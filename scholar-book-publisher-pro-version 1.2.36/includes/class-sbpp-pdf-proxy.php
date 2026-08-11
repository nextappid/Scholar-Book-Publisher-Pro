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
        if ($access !== 'open') {
            // Safe redirect to the Single Book page for Close Access to avoid 403 errors on Google Scholar
            wp_safe_redirect(get_permalink($book->ID));
            exit;
        }

        // Get Local WordPress PDF ID
        $pdf_id = get_post_meta($book->ID, '_sbpp_pdf_wordpress_id', true);
        if (empty($pdf_id)) {
            wp_safe_redirect(get_permalink($book->ID));
            exit;
        }

        // a. Dapatkan Jalur Fisik
        $absolute_path = get_attached_file($pdf_id);
        
        // b. Cek Keamanan
        if ( ! $absolute_path || ! file_exists($absolute_path) ) {
            wp_safe_redirect(get_permalink($book->ID));
            exit;
        }

        // c. Streaming Sempurna
        @ini_set('zlib.output_compression', '0');
        status_header(200);
        while (ob_get_level()) { ob_end_clean(); }
        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="' . basename($absolute_path) . '"');
        header('Content-Length: ' . filesize($absolute_path));
        header('Accept-Ranges: bytes');
        header('Cache-Control: public, max-age=86400');
        
        if ( isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'HEAD' ) { exit; }
        readfile($absolute_path); exit;
    }
}
