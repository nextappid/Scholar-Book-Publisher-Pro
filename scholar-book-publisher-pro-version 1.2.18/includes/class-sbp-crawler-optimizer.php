<?php
/**
 * Crawler Optimization for Google Scholar
 * Simplified version
 * 
 * @package Scholar_Book_Publisher
 * @since 1.0.0
 */

class SBP_Crawler_Optimizer {
    
    public function __construct() {
        add_filter('robots_txt', array($this, 'optimize_robots_txt'), 10, 2);
    }
    
    public function optimize_robots_txt($output, $public) {
        if ($public) {
            $output .= "\n# Google Scholar Crawler Access\n";
            $output .= "User-agent: Googlebot-Scholar\n";
            $output .= "Allow: /books/\n";
            $output .= "Allow: /wp-content/uploads/\n";
            $output .= "Crawl-delay: 1\n\n";
            $output .= "# General Crawlers\n";
            $output .= "User-agent: *\n";
            $output .= "Allow: /books/\n";
            $output .= "Sitemap: " . home_url('/books-sitemap.xml') . "\n\n";
        }
        return $output;
    }
}
