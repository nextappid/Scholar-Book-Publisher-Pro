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

        // 1. Cek apakah buku berstatus Open Access.
        $access = get_post_meta($post_id, '_sbpp_access_category', true) ?: get_post_meta($post_id, 'sbpp_access_category', true);
        
        if ($access === 'open') {
            // 2. Ambil data dengan teknik "Dual-Prefix Scan"
            $pdf_wp_id = get_post_meta($post_id, '_sbpp_pdf_wordpress_id', true) ?: get_post_meta($post_id, 'sbpp_pdf_wordpress_id', true);
            $gdrive_id = get_post_meta($post_id, 'sbpp_pdf_gdrive_id', true) ?: get_post_meta($post_id, '_sbpp_pdf_gdrive_id', true);
            $gdrive_url = get_post_meta($post_id, 'sbpp_pdf_gdrive_url', true) ?: get_post_meta($post_id, '_sbpp_pdf_gdrive_url', true);
            
            $pdf_url = '';

            // TAHAP EVALUASI BERTINGKAT (Bukan Else-If, menghindari false-positive Media Library)
            
            // Evaluasi 1: Media Library Internal
            if ( ! empty($pdf_wp_id) && is_numeric($pdf_wp_id) ) {
                $wp_url = wp_get_attachment_url(intval($pdf_wp_id));
                if ( $wp_url ) {
                    $pdf_url = $wp_url;
                }
            }
            
            // Evaluasi 2: Google Drive Direct Download (Hanya jika Evaluasi 1 gagal/kosong)
            if ( empty($pdf_url) && ! empty($gdrive_id) ) {
                $pdf_url = 'https://drive.google.com/uc?export=download&id=' . urlencode(trim($gdrive_id));
            } 
            
            // Evaluasi 3: URL Mentah GDrive (Hanya jika Evaluasi 2 gagal)
            if ( empty($pdf_url) && ! empty($gdrive_url) ) {
                $pdf_url = esc_url_raw(trim($gdrive_url));
            }

            // EKSEKUSI MUTLAK LINTAS-SERVER (Bulletproof)
            if ( ! empty($pdf_url) ) {
                $safe_redirect_url = esc_url_raw($pdf_url);
                
                // Mencegah Infinite Loop dari System-level Buffer yang tidak bisa dihapus
                while (ob_get_level() > 0) { 
                    if ( ! @ob_end_clean() ) {
                        break; 
                    }
                }
                
                // Proteksi terhadap "Headers already sent" (Kerapuhan plugin eksternal)
                if ( ! headers_sent() ) {
                    // Gunakan 302 (Found) bukan 301, karena menggunakan no-cache headers.
                    // Google Scholar lebih suka 302 untuk URL proxy yang datanya (WP/GDrive) bisa diubah penerbit.
                    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
                    header("Cache-Control: post-check=0, pre-check=0", false);
                    header("Pragma: no-cache");
                    wp_redirect( $safe_redirect_url, 302 );
                    exit;
                } else {
                    // Fallback Javascript jika server sudah terlanjur mengirim output (Crash prevention)
                    echo '<script type="text/javascript">window.location.replace("' . esc_js($safe_redirect_url) . '");</script>';
                    echo '<noscript><meta http-equiv="refresh" content="0;url=' . esc_attr($safe_redirect_url) . '"></noscript>';
                    exit;
                }
            }
        }
        
        // Safety Net: Jika Close Access ATAU Semua Ekstraksi Data Gagal
        if ( ! headers_sent() ) {
            wp_safe_redirect( get_permalink( $post_id ), 302 );
        } else {
            echo '<script type="text/javascript">window.location.replace("' . esc_js(get_permalink( $post_id )) . '");</script>';
        }
        exit;
    }
}
