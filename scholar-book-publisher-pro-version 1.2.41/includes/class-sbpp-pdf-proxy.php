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
        $access = get_post_meta($post_id, '_sbpp_access_category', true);
        if ($access === 'open') {
            // Cek Upload Internal WordPress
            $pdf_wp_id = get_post_meta($post_id, '_sbpp_pdf_wordpress_id', true);
            
            // TUGAS AI: Ganti 'META_KEY_EXTERNAL_TEMUAN_ANDA' dengan meta key eksternal/Google Drive dari Langkah 1
            $pdf_external = get_post_meta($post_id, '_sbpp_pdf_gdrive_url', true);
            
            $pdf_url = '';

            // Prioritas 1: Ambil URL dari Media Library jika ID ada
            if ( ! empty($pdf_wp_id) && is_numeric($pdf_wp_id) ) {
                $pdf_url = wp_get_attachment_url(intval($pdf_wp_id));
            } 
            // Prioritas 2: Jika internal kosong, ambil dari External/Google Drive dengan validasi cerdas
            elseif ( ! empty($pdf_external) ) {
                if ( filter_var( $pdf_external, FILTER_VALIDATE_URL ) ) {
                    $pdf_url = $pdf_external;
                } elseif ( strpos( $pdf_external, '/wp-content/' ) === 0 ) {
                    // Fallback jika admin salah ketik menggunakan relative path
                    $pdf_url = site_url( $pdf_external );
                } else {
                    $pdf_url = $pdf_external;
                }
            }

            // OPSI A: HTTP 301 Redirect Aman (Anti-Ghost File & Anti-Headers Already Sent)
            if ( ! empty($pdf_url) ) {
                // Bersihkan memori dari spasi/karakter sampah plugin lain agar redirect tidak fatal error
                while (ob_get_level() > 0) { ob_end_clean(); }
                
                // Mencegah browser caching agar update PDF di masa depan langsung terbaca
                header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
                header("Cache-Control: post-check=0, pre-check=0", false);
                header("Pragma: no-cache");
                
                wp_redirect( esc_url_raw($pdf_url), 301 );
                exit;
            }
        }
        
        // Jika Close Access ATAU Semua sumber data (Internal & Eksternal) kosong:
        wp_safe_redirect( get_permalink( $post_id ) );
        exit;
    }
}
