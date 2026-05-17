<?php
/**
 * PDF Proxy Stream Handler
 * 
 * Creates a local virtual endpoint for Google Drive PDFs to satisfy 
 * Google Scholar requirements for direct PDF links on the publisher's domain.
 * 
 * @package Scholar_Book_Publisher
 * @since 1.2.23
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
     * Endpoint format: /scholar-pdf/{book_id}/{filename}.pdf
     */
    public function add_rewrite_rules() {
        add_rewrite_rule(
            '^scholar-pdf/([0-9]+)/(.+)\.pdf/?$',
            'index.php?sbpp_pdf_id=$matches[1]&sbpp_pdf_filename=$matches[2]',
            'top'
        );
    }

    /**
     * Register query variables
     */
    public function add_query_vars($vars) {
        $vars[] = 'sbpp_pdf_id';
        $vars[] = 'sbpp_pdf_filename';
        return $vars;
    }

    /**
     * Handle the proxy streaming request
     */
    public function handle_proxy_stream() {
        $pdf_id = get_query_var('sbpp_pdf_id');
        
        if (empty($pdf_id)) {
            return;
        }
        
        // Verify book exists
        $book = get_post($pdf_id);
        if (!$book || $book->post_type !== 'scholar_book') {
            global $wp_query;
            $wp_query->set_404();
            status_header(404);
            return;
        }

        // Check if book is Open Access
        $access = get_post_meta($pdf_id, '_sbpp_access_category', true);
        if ($access !== 'open') {
            wp_die('This PDF is not available for Open Access.', 'Access Denied', array('response' => 403));
        }

        // Get Google Drive ID
        $gdrive_id = get_post_meta($pdf_id, '_sbpp_pdf_gdrive_id', true);
        if (empty($gdrive_id)) {
            global $wp_query;
            $wp_query->set_404();
            status_header(404);
            return;
        }

        // Create direct download URL
        $download_url = 'https://drive.google.com/uc?export=download&id=' . urlencode($gdrive_id);
        
        // Determine filename
        $filename_param = get_query_var('sbpp_pdf_filename');
        $filename = $filename_param ? sanitize_file_name($filename_param . '.pdf') : sanitize_file_name($book->post_name . '.pdf');

        // Close sessions to prevent locking
        if (session_id()) {
            session_write_close();
        }

        // Clear output buffers to prevent corruption
        while (ob_get_level()) {
            ob_end_clean();
        }

        // We use wp_remote_get with stream=true to save it to a temp file, 
        // avoiding RAM exhaustion for large PDFs.
        $temp_file = wp_tempnam($filename);
        $args = array(
            'timeout'     => 120,
            'redirection' => 5,
            'httpversion' => '1.1',
            'blocking'    => true,
            'stream'      => true,
            'filename'    => $temp_file
        );

        $response = wp_remote_get($download_url, $args);

        if (is_wp_error($response)) {
            @unlink($temp_file);
            wp_die('Error fetching PDF from Google Drive: ' . $response->get_error_message(), 'Error', array('response' => 500));
        }

        $response_code = wp_remote_retrieve_response_code($response);
        
        // Handle Google Drive warning page for large files
        if ($response_code === 200) {
            $content_type = wp_remote_retrieve_header($response, 'content-type');
            if (strpos($content_type, 'text/html') !== false) {
                // This means Google Drive showed a "File is too large to scan for viruses" warning instead of the file
                // We must use a workaround: parse the HTML to get the confirm token, or stream using curl directly.
                // For simplicity, we just fallback to cURL with proper streaming.
                @unlink($temp_file);
                $this->stream_with_curl($download_url, $filename);
                exit;
            }
        } elseif ($response_code !== 200) {
            @unlink($temp_file);
            wp_die('Google Drive returned an error. HTTP Status: ' . $response_code, 'Error', array('response' => 500));
        }

        // Stream output
        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="' . $filename . '"');
        header('Cache-Control: public, max-age=86400');
        
        $filesize = filesize($temp_file);
        if ($filesize) {
            header('Content-Length: ' . $filesize);
        }

        readfile($temp_file);
        @unlink($temp_file);
        exit;
    }
    
    /**
     * Fallback stream method using pure cURL to handle Google Drive's redirect
     * and confirmation pages for large files without saving to disk first,
     * or at least passing through without filling RAM.
     */
    private function stream_with_curl($url, $filename) {
        if (!function_exists('curl_init')) {
            wp_die('cURL is not installed on this server.', 'Error', array('response' => 500));
        }
        
        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="' . $filename . '"');
        header('Cache-Control: public, max-age=86400');
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, false); // Stream directly to output buffer
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 120);
        // By not setting CURLOPT_RETURNTRANSFER to true, curl_exec will output directly
        // to stdout (the browser), making it memory efficient.
        curl_exec($ch);
        curl_close($ch);
    }
}
