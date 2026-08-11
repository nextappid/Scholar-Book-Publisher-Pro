<?php
/**
 * PDF Proxy Stream Handler
 * 
 * Creates a local virtual endpoint for pseudo-static PDFs to satisfy 
 * Google Scholar requirements for direct PDF links on the publisher's domain.
 * Supports streaming Open Access local PDFs directly and safely redirecting Close Access books.
 * 
 * @package Scholar_Book_Publisher
 * @since 1.2.35
 */

class SBPP_PDF_Proxy {

    public function __construct() {
        // Register custom rewrite rule
        add_action('init', array($this, 'add_rewrite_rules'));
        
        // Add query vars
        add_filter('query_vars', array($this, 'add_query_vars'));
        
        // Handle stream requests
        add_action('template_redirect', array($this, 'handle_proxy_stream'), 1);
    }

    /**
     * Add rewrite rules for virtual endpoint
     * Endpoint format: /sbpp-pdf/{post_slug}.pdf
     */
    public function add_rewrite_rules() {
        add_rewrite_rule(
            '^sbpp-pdf/([^/]*)\.pdf$',
            'index.php?sbpp_pdf=$matches[1]',
            'top'
        );
    }

    /**
     * Register query variables
     */
    public function add_query_vars($vars) {
        $vars[] = 'sbpp_pdf';
        return $vars;
    }

    /**
     * Handle the proxy streaming request
     */
    public function handle_proxy_stream() {
        $slug = sanitize_title(get_query_var('sbpp_pdf'));
        
        if (empty($slug)) {
            return;
        }
        
        // Find book by slug
        $args = array(
            'name'        => $slug,
            'post_type'   => 'scholar_book',
            'post_status' => 'publish',
            'numberposts' => 1
        );
        $books = get_posts($args);
        
        if (empty($books)) {
            wp_safe_redirect(home_url());
            exit;
        }
        
        $book = $books[0];

        // Check if book is Open Access
        $access = get_post_meta($book->ID, '_sbpp_access_category', true);
        if ($access === 'open') {
            // Ambil data PDF menggunakan Meta Key Asli
            $pdf_id = get_post_meta($book->ID, '_sbpp_pdf_wordpress_id', true);
            $direct_pdf_url = '';
            
            if ($pdf_id) {
                // Dapatkan Direct URL dari file PDF tersebut
                $direct_pdf_url = wp_get_attachment_url($pdf_id);
            }
            
            // LAKUKAN HTTP 301 REDIRECT
            if ( ! empty($direct_pdf_url) ) {
                wp_redirect( $direct_pdf_url, 301 );
                exit;
            }
        }
        
        // Jika buku Close Access atau file PDF tidak ditemukan, barulah wp_safe_redirect
        wp_safe_redirect( get_permalink($book->ID) );
        exit;
    }
}
