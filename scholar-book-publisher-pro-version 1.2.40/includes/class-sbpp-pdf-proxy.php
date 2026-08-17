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
            // Ambil data PDF menggunakan Meta Key Asli
            $pdf_id = get_post_meta($post_id, '_sbpp_pdf_wordpress_id', true);
            $direct_pdf_url = '';
            
            if ($pdf_id) {
                // Dapatkan Direct URL dari file PDF tersebut
                $direct_pdf_url = wp_get_attachment_url($pdf_id);
            }
            
            // OPSI A (Teraman & Tercepat): HTTP 301 Redirect langsung ke URL file .pdf asli
            if ( ! empty($direct_pdf_url) ) {
                wp_redirect( $direct_pdf_url, 301 );
                exit;
            }
        }
        
        // Jika Close Access atau PDF Kosong:
        wp_safe_redirect( get_permalink( $post_id ) );
        exit;
    }
}
