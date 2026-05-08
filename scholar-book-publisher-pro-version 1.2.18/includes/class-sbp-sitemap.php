<?php
/**
 * Sitemap Generator for Books
 * Helps Google Scholar discover all scholarly books
 * 
 * @package Scholar_Book_Publisher
 * @since 1.2.5
 */

class SBP_Sitemap_Generator {
    
    public function __construct() {
        add_action('init', array($this, 'add_sitemap_rewrite'), 10);
        add_action('template_redirect', array($this, 'serve_sitemap'), 1);
        add_filter('query_vars', array($this, 'add_query_vars'));
    }
    
    /**
     * Add query vars
     */
    public function add_query_vars($vars) {
        $vars[] = 'sbp_sitemap';
        return $vars;
    }
    
    /**
     * Add rewrite rule for books-sitemap.xml
     */
    public function add_sitemap_rewrite() {
        add_rewrite_rule(
            '^books-sitemap\.xml$',
            'index.php?sbp_sitemap=books',
            'top'
        );
        add_rewrite_tag('%sbp_sitemap%', '([^&]+)');
    }
    
    /**
     * Serve the sitemap XML
     */
    public function serve_sitemap() {
        // Method 1: Check query var (rewrite rule)
        $sitemap_type = get_query_var('sbp_sitemap');
        
        if ($sitemap_type === 'books') {
            $this->output_sitemap();
        }
        
        // Method 2: Direct URI check (fallback if rewrite not working)
        $request_uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
        if (preg_match('/books-sitemap\.xml$/i', $request_uri)) {
            $this->output_sitemap();
        }
    }
    
    /**
     * Output sitemap with complete isolation from WordPress
     */
    private function output_sitemap() {
        // Remove ALL actions and filters that might interfere
        remove_all_actions('wp_head');
        remove_all_actions('wp_footer');
        remove_all_actions('wp_print_scripts');
        remove_all_actions('wp_print_styles');
        remove_all_filters('the_content');
        remove_all_filters('the_excerpt');
        
        // Disable theme and plugin interference
        define('DONOTCACHEPAGE', true);
        
        // Clean all output buffers
        while (ob_get_level() > 0) {
            ob_end_clean();
        }
        
        // Start fresh output buffer
        ob_start();
        
        // Generate sitemap content
        $this->generate_books_sitemap();
        
        // Get the content
        $sitemap_content = ob_get_clean();
        
        // Set headers
        status_header(200);
        header('Content-Type: application/xml; charset=utf-8', true);
        header('X-Robots-Tag: noindex, follow', true);
        header('Content-Length: ' . strlen($sitemap_content), true);
        
        // Output and exit immediately
        echo $sitemap_content;
        exit;
    }
    
    /**
     * Generate XML sitemap for all published books
     */
    private function generate_books_sitemap() {
        // Query all published books
        $books = get_posts(array(
            'post_type'      => 'scholar_book',
            'post_status'    => 'publish',
            'posts_per_page' => -1,
            'orderby'        => 'modified',
            'order'          => 'DESC',
            'no_found_rows'  => true,
            'update_post_meta_cache' => false,
            'update_post_term_cache' => false,
        ));
        
        // Start XML output
        echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
        
        // Add archive page
        $archive_url = get_post_type_archive_link('scholar_book');
        if ($archive_url) {
            echo '  <url>' . "\n";
            echo '    <loc>' . esc_url($archive_url) . '</loc>' . "\n";
            echo '    <changefreq>daily</changefreq>' . "\n";
            echo '    <priority>1.0</priority>' . "\n";
            echo '  </url>' . "\n";
        }
        
        // Add each book
        if (!empty($books) && is_array($books)) {
            foreach ($books as $book) {
                // Skip if not valid post
                if (!is_object($book) || !isset($book->ID)) {
                    continue;
                }
                
                // Get permalink
                $permalink = get_permalink($book->ID);
                if (!$permalink || is_wp_error($permalink)) {
                    continue;
                }
                
                // Get modified time - use GMT to avoid timezone issues
                $modified = get_post_modified_time('Y-m-d\TH:i:s+00:00', true, $book->ID);
                if (!$modified || $modified === false) {
                    $modified = get_post_time('Y-m-d\TH:i:s+00:00', true, $book->ID);
                }
                if (!$modified || $modified === false) {
                    $modified = gmdate('Y-m-d\TH:i:s+00:00');
                }
                
                echo '  <url>' . "\n";
                echo '    <loc>' . esc_url($permalink) . '</loc>' . "\n";
                echo '    <lastmod>' . esc_html($modified) . '</lastmod>' . "\n";
                echo '    <changefreq>weekly</changefreq>' . "\n";
                echo '    <priority>0.8</priority>' . "\n";
                echo '  </url>' . "\n";
                
                // Also add chapters for this book
                $chapters = get_posts(array(
                    'post_type'      => 'scholar_chapter',
                    'post_status'    => 'publish',
                    'posts_per_page' => -1,
                    'meta_query'     => array(
                        array(
                            'key'     => '_sbp_parent_book',
                            'value'   => $book->ID,
                            'compare' => '=',
                        ),
                    ),
                    'no_found_rows'  => true,
                    'update_post_meta_cache' => false,
                    'update_post_term_cache' => false,
                ));
                
                if (!empty($chapters) && is_array($chapters)) {
                    foreach ($chapters as $chapter) {
                        // Skip if not valid post
                        if (!is_object($chapter) || !isset($chapter->ID)) {
                            continue;
                        }
                        
                        // Get permalink
                        $chapter_permalink = get_permalink($chapter->ID);
                        if (!$chapter_permalink || is_wp_error($chapter_permalink)) {
                            continue;
                        }
                        
                        // Get modified time - use GMT
                        $chapter_modified = get_post_modified_time('Y-m-d\TH:i:s+00:00', true, $chapter->ID);
                        if (!$chapter_modified || $chapter_modified === false) {
                            $chapter_modified = get_post_time('Y-m-d\TH:i:s+00:00', true, $chapter->ID);
                        }
                        if (!$chapter_modified || $chapter_modified === false) {
                            $chapter_modified = gmdate('Y-m-d\TH:i:s+00:00');
                        }
                        
                        echo '  <url>' . "\n";
                        echo '    <loc>' . esc_url($chapter_permalink) . '</loc>' . "\n";
                        echo '    <lastmod>' . esc_html($chapter_modified) . '</lastmod>' . "\n";
                        echo '    <changefreq>monthly</changefreq>' . "\n";
                        echo '    <priority>0.6</priority>' . "\n";
                        echo '  </url>' . "\n";
                    }
                }
            }
        }
        
        echo '</urlset>';
    }
}
