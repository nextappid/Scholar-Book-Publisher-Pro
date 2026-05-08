<?php
/**
 * Usage Metrics Tracker
 * Tracks views, downloads, and citations
 * 
 * @package Scholar_Book_Publisher
 * @since 1.0.0
 */

class SBP_Usage_Metrics {
    
    public function __construct() {
        add_action('wp', array($this, 'track_page_view'));
        add_action('init', array($this, 'track_pdf_download'));
    }
    
    /**
     * Track page views
     */
    public function track_page_view() {
        if (is_singular('scholar_book') || is_singular('scholar_chapter')) {
            global $post;
            
            // Only count unique views (not bots, not admin)
            if (!is_admin() && !$this->is_bot()) {
                $views = (int) get_post_meta($post->ID, '_sbp_views_count', true);
                update_post_meta($post->ID, '_sbp_views_count', $views + 1);
                
                // Track daily views for analytics
                $today = date('Y-m-d');
                $daily_key = '_sbp_views_' . $today;
                $daily_views = (int) get_post_meta($post->ID, $daily_key, true);
                update_post_meta($post->ID, $daily_key, $daily_views + 1);
            }
        }
    }
    
    /**
     * Track PDF downloads
     */
    public function track_pdf_download() {
        // Check if this is a download request
        if (isset($_GET['sbp_download']) && isset($_GET['book_id'])) {
            $book_id = intval($_GET['book_id']);
            
            if ($book_id && get_post_type($book_id) === 'scholar_book') {
                // Increment download counter
                $downloads = (int) get_post_meta($book_id, '_sbp_downloads_count', true);
                update_post_meta($book_id, '_sbp_downloads_count', $downloads + 1);
                
                // Get PDF URL and redirect
                $pdf_source = get_post_meta($book_id, '_sbp_pdf_source', true);
                $pdf_url = '';
                
                if ($pdf_source === 'wordpress') {
                    $pdf_id = get_post_meta($book_id, '_sbp_pdf_wordpress_id', true);
                    if ($pdf_id) $pdf_url = wp_get_attachment_url($pdf_id);
                } elseif ($pdf_source === 'gdrive') {
                    $pdf_gdrive_id = get_post_meta($book_id, '_sbp_pdf_gdrive_id', true);
                    if ($pdf_gdrive_id) $pdf_url = 'https://drive.google.com/uc?export=download&id=' . $pdf_gdrive_id;
                }
                
                if ($pdf_url) {
                    wp_redirect($pdf_url);
                    exit;
                }
            }
        }
    }
    
    /**
     * Get usage metrics for a book
     */
    public static function get_metrics($post_id) {
        return array(
            'views' => (int) get_post_meta($post_id, '_sbp_views_count', true),
            'downloads' => (int) get_post_meta($post_id, '_sbp_downloads_count', true)
        );
    }
    
    /**
     * Manually update citations count (deprecated - no longer used)
     */
    public static function update_citations($post_id, $count) {
        // Deprecated - citations removed from v1.1
        delete_post_meta($post_id, '_sbp_citations_count');
    }
    
    /**
     * Check if visitor is a bot
     */
    private function is_bot() {
        $user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
        $bots = array('bot', 'crawl', 'spider', 'slurp', 'mediapartners');
        
        foreach ($bots as $bot) {
            if (stripos($user_agent, $bot) !== false) {
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * Get download URL with tracking
     */
    public static function get_tracked_download_url($post_id) {
        return add_query_arg(array(
            'sbp_download' => '1',
            'book_id' => $post_id
        ), home_url('/'));
    }
}
