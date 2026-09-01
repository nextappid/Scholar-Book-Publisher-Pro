<?php
/**
 * Bulletproof URI Interceptor for PDF
 * 
 * Creates an absolute URI interceptor that runs at init level,
 * ignoring query strings and utilizing the Book ID directly.
 * 
 * @package Scholar_Book_Publisher
 * @since 1.2.39
 */

add_action( 'init', 'sbpp_direct_uri_pdf_interceptor', 1 );
function sbpp_direct_uri_pdf_interceptor() {
    // Ambil URL Path saja (Abaikan parameter ?utm_source=... dsb)
    $parsed_url = parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH );
    
    // Regex menangkap ID dan Slug, aman untuk instalasi Subdirectory
    if ( preg_match( '#/sbpp-pdf/(\d+)/([^/]+)\.pdf$#i', $parsed_url, $matches ) ) {
        $post_id = intval( $matches[1] );
        $post = get_post( $post_id );
        
        // Validasi keberadaan buku dan pastikan post_type-nya benar
        if ( ! $post || $post->post_type !== 'scholar_book' ) {
            wp_safe_redirect( home_url() );
            exit;
        }

        // 1. Cek akses dan buat lebih toleran (case-insensitive & mencari kata 'open')
        $access = get_post_meta($post_id, '_sbpp_access_category', true) ?: get_post_meta($post_id, 'sbpp_access_category', true);
        $access_clean = strtolower(trim($access));
        
        if (strpos($access_clean, 'open') !== false) {
            // 2. Ambil Meta Data
            $pdf_wp_id = get_post_meta($post_id, '_sbpp_pdf_wordpress_id', true) ?: get_post_meta($post_id, 'sbpp_pdf_wordpress_id', true);
            $gdrive_id = get_post_meta($post_id, 'sbpp_pdf_gdrive_id', true) ?: get_post_meta($post_id, '_sbpp_pdf_gdrive_id', true);
            
            if ( ! empty($pdf_wp_id) && is_numeric($pdf_wp_id) ) {
                // A. Eksekusi URL Lokal WordPress
                $pdf_url = wp_get_attachment_url(intval($pdf_wp_id));
                if ($pdf_url) {
                    while (ob_get_level() > 0) { @ob_end_clean(); }
                    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
                    wp_redirect( esc_url_raw($pdf_url), 302 );
                    exit;
                }
            } elseif ( ! empty($gdrive_id) ) {
                // B. Eksekusi Enterprise cURL Chunked Streaming (Google Drive API)
                $api_key = 'AIzaSyCPundTEac2WDVMSyRj66j4OE5NoVR3XbM';
                $api_url = "https://www.googleapis.com/drive/v3/files/" . trim($gdrive_id) . "?alt=media&key=" . $api_key;
                
                // Bersihkan buffer WordPress agar tidak memicu memory limit
                while (ob_get_level() > 0) { @ob_end_clean(); }
                
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $api_url);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
                
                $is_error = false;
                $headers_sent = false;
                
                // Callback untuk inspeksi aliran data secara dinamis
                curl_setopt($ch, CURLOPT_WRITEFUNCTION, function($ch, $chunk) use (&$is_error, &$headers_sent, $post_id) {
                    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                    
                    // Cegah output jika API gagal/limitasi
                    if ($http_code !== 200) {
                        $is_error = true;
                        return strlen($chunk); 
                    }
                    
                    // Jika sukses, kirim header PDF hanya satu kali
                    if (!$headers_sent) {
                        header("Content-Type: application/pdf");
                        header("Content-Disposition: inline; filename=\"article-{$post_id}.pdf\"");
                        header("Cache-Control: public, max-age=86400");
                        $headers_sent = true;
                    }
                    
                    // Alirkan data ke browser dan langsung hapus dari memori server
                    echo $chunk;
                    flush();
                    return strlen($chunk);
                });
                
                curl_exec($ch);
                $final_http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                curl_close($ch);
                
                // Jika Google API gagal, lakukan fallback redirect dengan aman
                if ($is_error || $final_http_code !== 200) {
                    wp_safe_redirect( get_permalink( $post_id ) . '?sbpp_error=api_stream_failed' );
                    exit;
                }
                exit; // Berhenti dengan sukses (File berhasil diunduh)
            }

            // SILENT REPORTER: Gagal karena Data PDF Kosong
            wp_safe_redirect( get_permalink( $post_id ) . '?sbpp_error=pdf_data_empty' );
            exit;
        }
        
        // SILENT REPORTER: Gagal karena Status Akses Bukan Open (Menampilkan nilai akses yang terbaca)
        wp_safe_redirect( get_permalink( $post_id ) . '?sbpp_error=access_denied&val=' . urlencode($access) );
        exit;
    }
}
