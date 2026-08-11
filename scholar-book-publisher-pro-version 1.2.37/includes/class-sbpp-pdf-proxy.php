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

        // Ambil nilai mentah meta PDF
        $pdf_meta = get_post_meta($book->ID, '_sbpp_pdf_wordpress_id', true);
        $absolute_path = '';

        if ( ! empty( $pdf_meta ) ) {
            if ( is_numeric( $pdf_meta ) ) {
                // Jika data murni Attachment ID
                $absolute_path = get_attached_file( $pdf_meta );
            } elseif ( filter_var( $pdf_meta, FILTER_VALIDATE_URL ) ) {
                // Jika data adalah URL, gunakan fungsi core WP
                $attachment_id = attachment_url_to_postid( $pdf_meta );
                
                if ( $attachment_id ) {
                    $absolute_path = get_attached_file( $attachment_id );
                } else {
                    // Fallback terakhir jika bypass media library
                    $upload_dir = wp_get_upload_dir();
                    if ( strpos( $pdf_meta, $upload_dir['baseurl'] ) === 0 ) {
                        $absolute_path = str_replace( $upload_dir['baseurl'], $upload_dir['basedir'], $pdf_meta );
                    }
                }
            }
        }

        // Safety Net: Jika file fisik tidak ada, selamatkan ke single page
        if ( empty( $absolute_path ) || ! file_exists( $absolute_path ) ) {
            wp_safe_redirect( get_permalink( $book->ID ) );
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
