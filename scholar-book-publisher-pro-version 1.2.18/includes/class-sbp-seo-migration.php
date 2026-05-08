<?php
/**
 * SEO Migration Helper for URL Structure Change
 * Handles migration from /catalogs/ to /books/ with SEO preservation
 * 
 * @package Scholar_Book_Publisher
 * @since 1.2.0
 */

class SBP_SEO_Migration {
    
    /**
     * Constructor
     */
    public function __construct() {
        // Add canonical URLs to preserve SEO
        add_action('wp_head', array($this, 'add_canonical_meta'), 1);
        
        // Update sitemap if Yoast SEO is active
        add_filter('wpseo_sitemap_entry', array($this, 'update_sitemap_urls'), 10, 3);
    }
    
    /**
     * Add canonical meta tags to ensure search engines know the correct URL
     *
     * @since 1.2.0
     */
    public function add_canonical_meta() {
        if (is_singular('scholar_book') || is_singular('scholar_chapter') || is_post_type_archive('scholar_book')) {
            // WordPress will automatically use the current URL as canonical
            // This ensures /books/ URLs are indexed, not /catalogs/
            
            // Add hreflang if multilingual
            $current_url = get_permalink();
            if ($current_url) {
                echo '<!-- Scholar Book Publisher: Canonical URL -->' . "\n";
                echo '<link rel="canonical" href="' . esc_url($current_url) . '" />' . "\n";
            }
        }
    }
    
    /**
     * Update sitemap URLs if using Yoast SEO
     *
     * @param array  $url     Array of URL parts
     * @param string $type    URL type
     * @param object $object  Data object for the URL
     * @return array
     */
    public function update_sitemap_urls($url, $type, $object) {
        if (isset($url['loc'])) {
            // Replace any remaining /catalogs/ with /books/ in sitemap
            $url['loc'] = str_replace('/catalogs/', '/books/', $url['loc']);
        }
        return $url;
    }
    
    /**
     * Generate .htaccess rules for Apache servers
     * Can be manually added by users who want server-level redirects
     *
     * @return string
     */
    public static function get_htaccess_rules() {
        return <<<HTACCESS
# Scholar Book Publisher v1.2.0 - Legacy URL Redirects
# Redirect old /catalogs/ URLs to new /books/ URLs with 301 (permanent)

<IfModule mod_rewrite.c>
RewriteEngine On
RewriteBase /

# Redirect catalog archive to books archive
RewriteRule ^catalogs/?$ books/ [R=301,L]

# Redirect catalog pagination
RewriteRule ^catalogs/page/([0-9]+)/?$ books/page/$1/ [R=301,L]

# Redirect single book pages
RewriteRule ^catalogs/([^/]+)/?$ books/$1/ [R=301,L]

# Redirect book chapters (hierarchical)
RewriteRule ^catalogs/([^/]+)/([^/]+)/?$ books/$1/$2/ [R=301,L]

# Redirect category archives
RewriteRule ^catalogs/book-category/([^/]+)/?$ books/book-category/$1/ [R=301,L]

# Redirect tag archives
RewriteRule ^catalogs/book-tag/([^/]+)/?$ books/book-tag/$1/ [R=301,L]
</IfModule>

HTACCESS;
    }
    
    /**
     * Generate nginx rules for nginx servers
     *
     * @return string
     */
    public static function get_nginx_rules() {
        return <<<NGINX
# Scholar Book Publisher v1.2.0 - Legacy URL Redirects for nginx

# Redirect catalog archive to books archive
rewrite ^/catalogs/?$ /books/ permanent;

# Redirect catalog pagination
rewrite ^/catalogs/page/([0-9]+)/?$ /books/page/\$1/ permanent;

# Redirect single book pages
rewrite ^/catalogs/([^/]+)/?$ /books/\$1/ permanent;

# Redirect book chapters (hierarchical)
rewrite ^/catalogs/([^/]+)/([^/]+)/?$ /books/\$1/\$2/ permanent;

# Redirect category archives
rewrite ^/catalogs/book-category/([^/]+)/?$ /books/book-category/\$1/ permanent;

# Redirect tag archives
rewrite ^/catalogs/book-tag/([^/]+)/?$ /books/book-tag/\$1/ permanent;

NGINX;
    }
}

// Initialize SEO migration
new SBP_SEO_Migration();
