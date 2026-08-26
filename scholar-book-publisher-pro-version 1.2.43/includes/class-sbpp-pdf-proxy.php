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
            // 2. Ambil data G-Drive (Dual-Prefix Scan)
            $pdf_wp_id = get_post_meta($post_id, '_sbpp_pdf_wordpress_id', true) ?: get_post_meta($post_id, 'sbpp_pdf_wordpress_id', true);
            $gdrive_id = get_post_meta($post_id, 'sbpp_pdf_gdrive_id', true) ?: get_post_meta($post_id, '_sbpp_pdf_gdrive_id', true);
            $gdrive_url = get_post_meta($post_id, 'sbpp_pdf_gdrive_url', true) ?: get_post_meta($post_id, '_sbpp_pdf_gdrive_url', true);
            
            $pdf_url = '';

            if ( ! empty($pdf_wp_id) && is_numeric($pdf_wp_id) ) {
                $pdf_url = wp_get_attachment_url(intval($pdf_wp_id));
            } elseif ( ! empty($gdrive_id) ) {
                $pdf_url = 'https://drive.google.com/uc?export=download&id=' . trim($gdrive_id);
            } elseif ( ! empty($gdrive_url) ) {
                $pdf_url = esc_url_raw(trim($gdrive_url));
            }

            // EKSEKUSI MUTLAK: HTTP 302 Redirect (Standar Antigravity)
            if ( ! empty($pdf_url) ) {
                while (ob_get_level() > 0) { @ob_end_clean(); }
                
                header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
                header("Cache-Control: post-check=0, pre-check=0", false);
                header("Pragma: no-cache");
                
                wp_redirect( esc_url_raw($pdf_url), 302 );
                exit;
            } else {
                // SILENT REPORTER: Gagal karena Data PDF Kosong
                wp_safe_redirect( get_permalink( $post_id ) . '?sbpp_error=pdf_data_empty' );
                exit;
            }
        }
        
        // SILENT REPORTER: Gagal karena Status Akses Bukan Open (Menampilkan nilai akses yang terbaca)
        wp_safe_redirect( get_permalink( $post_id ) . '?sbpp_error=access_denied&val=' . urlencode($access) );
        exit;
    }
}
