<?php
/**
 * Plugin Name: Scholar Book Publisher Pro
 * Plugin URI: https://github.com/nextappid/Scholar-Book-Publisher-Pro
 * Description: Complete academic book publishing system optimized for Google Scholar indexing. Features subtitle support, teal theme, dark/light mode, WYSIWYG editor, advanced filters, and custom SVG branding. Supports dual PDF schema (WordPress upload or Google Drive link), complete metadata management, and automatic crawler optimization.
 * Version: 1.2.34
 * Author: Nextmedia
 * Author URI: https://nextmedia.id
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: scholar-book-publisher
 * Domain Path: /languages
 * Requires at least: 5.8
 * Requires PHP: 7.4
 *
 * @package Scholar_Book_Publisher
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Safety check: Prevent loading if already loaded
if (defined('SBPP_VERSION')) {
    return;
}

// Safety check: Minimum PHP version
if (version_compare(PHP_VERSION, '7.4', '<')) {
    add_action('admin_notices', function() {
        if (!current_user_can('activate_plugins')) return;
        echo '<div class="notice notice-error"><p>';
        echo '<strong>Scholar Book Publisher Pro:</strong> Requires PHP 7.4 or higher. ';
        echo 'Current version: ' . PHP_VERSION;
        echo '</p></div>';
    });
    return;
}

// Safety check: Minimum WordPress version
global $wp_version;
if (version_compare($wp_version, '5.8', '<')) {
    add_action('admin_notices', function() {
        if (!current_user_can('activate_plugins')) return;
        global $wp_version;
        echo '<div class="notice notice-error"><p>';
        echo '<strong>Scholar Book Publisher Pro:</strong> Requires WordPress 5.8 or higher. ';
        echo 'Current version: ' . $wp_version;
        echo '</p></div>';
    });
    return;
}

// Define plugin constants
define('SBPP_VERSION', '1.2.34');
define('SBPP_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('SBPP_PLUGIN_URL', plugin_dir_url(__FILE__));
define('SBPP_PLUGIN_BASENAME', plugin_basename(__FILE__));

// AJAX Constants
define('SBPP_AJAX_FILTER_ACTION', 'sbpp_filter_books');
define('SBPP_AJAX_FILTER_NONCE', 'sbpp_filter_nonce_action');

/**
 * Main Scholar Book Publisher Class
 *
 * @since 1.0.0
 */
final class Scholar_Book_Publisher {
    
    /**
     * The single instance of the class
     *
     * @var Scholar_Book_Publisher
     * @since 1.0.0
     */
    protected static $_instance = null;
    
    /**
     * Main Scholar_Book_Publisher Instance
     *
     * Ensures only one instance of Scholar_Book_Publisher is loaded or can be loaded.
     *
     * @since 1.0.0
     * @static
     * @return Scholar_Book_Publisher - Main instance
     */
    public static function instance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    
    /**
     * Scholar_Book_Publisher Constructor
     */
    public function __construct() {
        $this->includes();
        $this->init_hooks();
    }
    
    /**
     * Include required core files
     */
    public function includes() {
        // Core classes
        require_once SBPP_PLUGIN_DIR . 'includes/class-sbpp-post-types.php';
        require_once SBPP_PLUGIN_DIR . 'includes/class-sbpp-metadata.php';
        require_once SBPP_PLUGIN_DIR . 'includes/class-sbpp-crawler-optimizer.php';
        require_once SBPP_PLUGIN_DIR . 'includes/class-sbpp-admin-notices.php';
        require_once SBPP_PLUGIN_DIR . 'includes/class-sbpp-usage-metrics.php';
        require_once SBPP_PLUGIN_DIR . 'includes/class-sbpp-seo-migration.php';
        require_once SBPP_PLUGIN_DIR . 'includes/class-sbpp-sitemap.php';
        require_once SBPP_PLUGIN_DIR . 'includes/class-sbpp-pdf-proxy.php';
        require_once SBPP_PLUGIN_DIR . 'includes/class-sbpp-citation.php';
    }
    
    /**
     * Hook into actions and filters
     *
     * @since 1.0.0
     */
    private function init_hooks() {
        // Plugin loaded
        add_action('init', array($this, 'init'), 0);
        add_action('plugins_loaded', array($this, 'load_plugin_textdomain'));
        
        // Enqueue scripts and styles
        add_action('wp_enqueue_scripts', array($this, 'enqueue_frontend_assets'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_assets'));
        
        // Template loading
        add_filter('template_include', array($this, 'template_loader'));
        
        // FIX: Set 50 posts per page for book archive - must be here, NOT in template
        add_action('pre_get_posts', array($this, 'set_archive_posts_per_page'));
        
        // AJAX filter handler (logged in + non-logged in)
        add_action('wp_ajax_' . SBPP_AJAX_FILTER_ACTION, array($this, 'ajax_filter_books'));
        add_action('wp_ajax_nopriv_' . SBPP_AJAX_FILTER_ACTION, array($this, 'ajax_filter_books'));
        
        // AJAX handler for dismissing admin notice
        add_action('wp_ajax_sbpp_dismiss_url_notice', array($this, 'dismiss_url_notice'));
        add_action('wp_ajax_sbpp_dismiss_sitemap_notice', array($this, 'dismiss_sitemap_notice'));
        
        // Automatic 301 redirects for old /catalogs/ URLs (SEO migration)
        add_action('template_redirect', array($this, 'handle_legacy_url_redirects'), 1);
    }
    
    /**
     * Set 50 posts per page on book archive.
     * Uses multiple detection methods for reliability across all WP versions.
     * NOTE: archive template also uses its own WP_Query(50) as definitive fallback.
     */
    public function set_archive_posts_per_page($query) {
        if (is_admin() || !$query->is_main_query()) {
            return;
        }

        // Method 1: standard conditional
        if ($query->is_post_type_archive('scholar_book')) {
            $query->set('posts_per_page', 50);
            return;
        }

        // Method 2: query_vars array (more reliable in some WP setups)
        $qv_type = isset($query->query_vars['post_type']) ? $query->query_vars['post_type'] : '';
        if ($qv_type === 'scholar_book') {
            $query->set('posts_per_page', 50);
            return;
        }

        // Method 3: raw query array
        $q_type = isset($query->query['post_type']) ? $query->query['post_type'] : '';
        if ($q_type === 'scholar_book') {
            $query->set('posts_per_page', 50);
            return;
        }
    }
    
    /**
     * AJAX handler for book filter - searches ALL entries, not just current page
     * Supports: categories, year, open access, and search (title/author)
     */
    public function ajax_filter_books() {
        // Bypass nonce for logged out users due to Page Caching (LiteSpeed) issues
        if ( is_user_logged_in() ) {
            check_ajax_referer(SBPP_AJAX_FILTER_NONCE, 'security');
        }
        
        $categories  = isset($_POST['categories']) ? array_map('sanitize_text_field', (array)$_POST['categories']) : array();
        $year        = isset($_POST['year'])       ? sanitize_text_field($_POST['year'])       : '';
        $language    = isset($_POST['language'])   ? sanitize_text_field($_POST['language'])   : '';
        $oa_only     = isset($_POST['oa_only'])    ? (bool)$_POST['oa_only']                  : false;
        $search      = isset($_POST['search'])     ? sanitize_text_field($_POST['search'])     : '';
        $paged       = isset($_POST['paged'])      ? absint($_POST['paged'])                   : 1;
        
        $args = array(
            'post_type'      => 'scholar_book',
            'post_status'    => 'publish',
            'posts_per_page' => 50,
            'paged'          => $paged,
        );
        
        // Track our own posts_where filter so we can remove ONLY ours after the query.
        // Using remove_all_filters() would nuke every other plugin's WHERE filter.
        $sbpp_author_search_filter = null;

        // Search filter - title or author (custom implementation via meta_query)
        if (!empty($search)) {
            // WordPress 's' only searches title/content, not custom meta.
            // We use title search + a targeted posts_where addition for authors.
            $args['s'] = $search;  // This searches title
            
            // Named closure stored in a variable so we can remove ONLY this filter later.
            $sbpp_author_search_filter = function( $where ) use ( $search ) {
                global $wpdb;
                // Add OR condition to search in authors meta
                $search_safe = $wpdb->esc_like( $search );
                $where .= " OR (
                    {$wpdb->posts}.ID IN (
                        SELECT post_id FROM {$wpdb->postmeta}
                        WHERE meta_key = '_sbpp_authors'
                        AND meta_value LIKE '%{$search_safe}%'
                    )
                )";
                return $where;
            };
            add_filter( 'posts_where', $sbpp_author_search_filter, 10, 1 );
        }
        
        // Category filter
        if (!empty($categories)) {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'book_category',
                    'field'    => 'slug',
                    'terms'    => $categories,
                    'operator' => 'IN',
                ),
            );
        }
        
        // Year filter via meta — use LIKE on _sbpp_publication_date (format: YYYY-MM-DD or YYYY)
        if (!empty($year)) {
            $args['meta_query'][] = array(
                'key'     => '_sbpp_publication_date',
                'value'   => $year,
                'compare' => 'LIKE',
            );
        }
        
        // Language filter
        if (!empty($language)) {
            $args['meta_query'][] = array(
                'key'     => '_sbpp_book_language',
                'value'   => $language,
                'compare' => '=',
            );
        }
        
        // Open Access filter
        if ($oa_only) {
            $args['meta_query'][] = array(
                'key'     => '_sbpp_access_category',
                'value'   => 'open',
                'compare' => '=',
            );
        }
        
        if (!empty($args['meta_query']) && count($args['meta_query']) > 1) {
            $args['meta_query']['relation'] = 'AND';
        }
        
        $query = new WP_Query( $args );

        // Remove ONLY our own posts_where filter — never use remove_all_filters() here
        // because it would destroy WHERE filters added by other plugins (e.g. WPML, WooCommerce).
        if ( $sbpp_author_search_filter !== null ) {
            remove_filter( 'posts_where', $sbpp_author_search_filter, 10 );
        }
        
        ob_start();
        
        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $book_id       = get_the_ID();
                $cover_id      = get_post_meta($book_id, '_sbpp_book_cover', true);
                $authors_raw   = get_post_meta($book_id, '_sbpp_authors', true);
                $pub_date      = get_post_meta($book_id, '_sbpp_publication_date', true);
                $year_val      = $pub_date ? date('Y', strtotime($pub_date)) : '';
                $access        = get_post_meta($book_id, '_sbpp_access_category', true);
                
                // Build author string
                $authors_string = '';
                if (!empty($authors_raw) && is_array($authors_raw)) {
                    $names = array();
                    foreach ($authors_raw as $a) {
                        if (!empty($a['first_name']) && !empty($a['last_name'])) {
                            $names[] = $a['first_name'] . ' ' . $a['last_name'];
                        }
                    }
                    $authors_string = implode(', ', $names);
                }
                
                // Category slugs
                $cat_terms  = wp_get_post_terms($book_id, 'book_category', array('fields' => 'slugs'));
                $cat_string = implode(',', is_array($cat_terms) ? $cat_terms : array());
                
                // Metrics
                $metrics  = class_exists('SBPP_Usage_Metrics') ? SBPP_Usage_Metrics::get_metrics($book_id) : array('views' => 0, 'downloads' => 0);
                $svg_path = plugins_url('assets/images/open-access-logo.svg', __FILE__);
                $cover_url = $cover_id ? wp_get_attachment_url($cover_id) : '';
                ?>
                <article class="scholar-book-card"
                         data-categories="<?php echo esc_attr($cat_string); ?>"
                         data-year="<?php echo esc_attr($year_val); ?>"
                         data-access="<?php echo esc_attr($access); ?>">

                    <!-- Cover — identical structure to archive template card -->
                    <div class="scholar-card-cover">
                        <?php if ($cover_url): ?>
                            <img src="<?php echo esc_url($cover_url); ?>"
                                 alt="<?php echo esc_attr(get_the_title()); ?>"
                                 loading="lazy">
                        <?php elseif (has_post_thumbnail()): ?>
                            <?php the_post_thumbnail('medium', array('loading' => 'lazy')); ?>
                        <?php else: ?>
                            <svg class="scholar-cover-fallback" width="70" height="70" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M1 2.828c.885-.37 2.154-.769 3.388-.893 1.33-.134 2.458.063 3.112.752v9.746c-.935-.53-2.12-.603-3.213-.493-1.18.12-2.37.461-3.287.811V2.828zm7.5-.141c.654-.689 1.782-.886 3.112-.752 1.234.124 2.503.523 3.388.893v9.923c-.918-.35-2.107-.692-3.287-.81-1.094-.111-2.278-.039-3.213.492V2.687zM8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783z"/>
                            </svg>
                        <?php endif; ?>

                        <?php if ($access === 'open'): ?>
                            <div class="scholar-oa-badge">
                                <img src="<?php echo esc_url($svg_path); ?>" alt="Open Access">
                                OA
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Content -->
                    <div class="scholar-card-content">
                        <h2 class="scholar-card-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h2>
                        <?php if ($authors_string): ?>
                            <div class="scholar-card-authors"><?php echo esc_html($authors_string); ?></div>
                        <?php endif; ?>
                        <div class="scholar-card-meta">
                            <?php if ($year_val): ?>
                                <span class="scholar-card-year"><?php echo esc_html($year_val); ?></span>
                            <?php endif; ?>
                            <?php if ($metrics['views'] > 0 || $metrics['downloads'] > 0): ?>
                                <div class="scholar-card-metrics">
                                    <?php if ($metrics['views'] > 0): ?>
                                        <span title="Views">
                                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            <?php echo number_format($metrics['views']); ?>
                                        </span>
                                    <?php endif; ?>
                                    <?php if ($metrics['downloads'] > 0): ?>
                                        <span title="Downloads">
                                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                            </svg>
                                            <?php echo number_format($metrics['downloads']); ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </article>
                <?php
            }
        } else {
            echo '<p class="sbp-no-results">No books found matching your criteria.</p>';
        }
        
        $html = ob_get_clean();
        wp_reset_postdata();
        
        wp_send_json_success(array(
            'html'        => $html,
            'found_posts' => $query->found_posts,
            'max_pages'   => $query->max_num_pages,
            'paged'       => $paged,
        ));
    }
    
    /**
     * Init Scholar Book Publisher when WordPress Initialises
     */
    public function init() {
        // Guard each class before instantiating — a missing/corrupt include
        // would otherwise cause a Fatal Error on every page load.
        if ( class_exists( 'SBPP_Post_Types' ) )          { new SBPP_Post_Types(); }
        if ( class_exists( 'SBPP_Metadata_Generator' ) )  { new SBPP_Metadata_Generator(); }
        if ( class_exists( 'SBPP_Crawler_Optimizer' ) )   { new SBPP_Crawler_Optimizer(); }
        if ( class_exists( 'SBPP_Admin_Notices' ) )        { new SBPP_Admin_Notices(); }
        if ( class_exists( 'SBPP_Usage_Metrics' ) )        { new SBPP_Usage_Metrics(); }
        if ( class_exists( 'SBPP_Sitemap_Generator' ) )    { new SBPP_Sitemap_Generator(); }
        if ( class_exists( 'SBPP_PDF_Proxy' ) )            { new SBPP_PDF_Proxy(); }
        // SBPP_SEO_Migration: was previously auto-instantiated via a bare file-level call
        // that has been removed. Instantiate it here so it runs in the correct WP lifecycle.
        if ( class_exists( 'SBPP_SEO_Migration' ) )        { new SBPP_SEO_Migration(); }

        // Fire action
        do_action( 'scholar_book_publisher_init' );
    }
    
    /**
     * Load Localisation files
     *
     * @since 1.0.0
     */
    public function load_plugin_textdomain() {
        load_plugin_textdomain(
            'scholar-book-publisher',
            false,
            dirname(SBPP_PLUGIN_BASENAME) . '/languages/'
        );
    }
    
    /**
     * Enqueue frontend assets
     *
     * @since 1.0.0
     */
    public function enqueue_frontend_assets() {
        // Only load on book/chapter pages
        if (is_singular('scholar_book') || is_post_type_archive('scholar_book') || 
            is_singular('scholar_chapter') || is_tax(array('book_category', 'book_tag'))) {
            
            wp_enqueue_style(
                'sbp-frontend',
                SBPP_PLUGIN_URL . 'assets/css/frontend.css',
                array(),
                SBPP_VERSION
            );
            
            wp_enqueue_script(
                'sbp-frontend',
                SBPP_PLUGIN_URL . 'assets/js/frontend.js',
                array('jquery'),
                SBPP_VERSION,
                true
            );
            
            // Pass AJAX URL and nonce to JS
            wp_localize_script('sbp-frontend', 'sbpp_ajax', array(
                'ajax_url' => admin_url('admin-ajax.php'),
                'nonce'    => wp_create_nonce(SBPP_AJAX_FILTER_NONCE),
                'action'   => SBPP_AJAX_FILTER_ACTION
            ));
        }
    }
    
    /**
     * Enqueue admin assets
     *
     * @since 1.0.0
     */
    public function enqueue_admin_assets($hook) {
        global $post_type;
        
        // Only load on book/chapter edit screens
        if (($hook === 'post.php' || $hook === 'post-new.php') && 
            ($post_type === 'scholar_book' || $post_type === 'scholar_chapter')) {
            
            // Admin styles
            wp_enqueue_style(
                'sbp-admin',
                SBPP_PLUGIN_URL . 'assets/css/admin.css',
                array(),
                SBPP_VERSION
            );
            
            // Admin JavaScript
            wp_enqueue_script(
                'sbp-admin',
                SBPP_PLUGIN_URL . 'assets/js/admin.js',
                array('jquery'),
                SBPP_VERSION,
                true
            );
            
            // WordPress Media Uploader
            wp_enqueue_media();
        }
    }
    
    /**
     * Load template files
     *
     * @param string $template Template path
     * @return string Modified template path
     */
    public function template_loader($template) {
        // Check if it's a book or chapter
        if (is_singular('scholar_book')) {
            $template = $this->locate_template('single-scholar_book.php', $template);
        } elseif (is_post_type_archive('scholar_book')) {
            $template = $this->locate_template('archive-scholar_book.php', $template);
        } elseif (is_singular('scholar_chapter')) {
            $template = $this->locate_template('single-scholar_chapter.php', $template);
        }
        
        return $template;
    }
    
    /**
     * Locate template file
     *
     * @param string $template_name Template filename
     * @param string $default Default template path
     * @return string Template path
     */
    private function locate_template($template_name, $default) {
        // Check theme directory first
        $theme_template = locate_template(array($template_name));
        
        if ($theme_template) {
            return $theme_template;
        }
        
        // Check plugin template directory
        $plugin_template = SBPP_PLUGIN_DIR . 'templates/' . $template_name;
        
        if (file_exists($plugin_template)) {
            return $plugin_template;
        }
        
        // Return default
        return $default;
    }
    
    /**
     * Get the plugin url
     *
     * @return string
     */
    public function plugin_url() {
        return untrailingslashit(plugins_url('/', __FILE__));
    }
    
    /**
     * Get the plugin path
     *
     * @return string
     */
    public function plugin_path() {
        return untrailingslashit(plugin_dir_path(__FILE__));
    }
    
    /**
     * Dismiss URL structure update notice
     *
     * @since 1.2.0
     */
    public function dismiss_url_notice() {
        check_ajax_referer('sbpp_dismiss_notice', 'nonce');
        update_option('sbpp_url_structure_notice_dismissed', true);
        wp_send_json_success();
    }
    
    /**
     * AJAX handler for dismissing sitemap notice
     *
     * @since 1.2.6
     */
    public function dismiss_sitemap_notice() {
        check_ajax_referer('sbpp_dismiss_sitemap', 'nonce');
        update_option('sbpp_sitemap_notice_dismissed', true);
        wp_send_json_success();
    }
    
    /**
     * Handle automatic 301 redirects for legacy /catalogs/ URLs
     * Preserves SEO value when migrating from v1.1.x to v1.2.0
     *
     * @since 1.2.0
     */
    public function handle_legacy_url_redirects() {
        // Only run on frontend
        if (is_admin()) {
            return;
        }
        
        $request_uri = $_SERVER['REQUEST_URI'];
        $parsed_url = parse_url($request_uri);
        $path = isset($parsed_url['path']) ? $parsed_url['path'] : '';
        $query = isset($parsed_url['query']) ? '?' . $parsed_url['query'] : '';
        
        // Check if this is a /catalogs/ URL
        if (strpos($path, '/catalogs/') === false && strpos($path, '/catalogs') === false) {
            return;
        }
        
        // Build new URL by replacing /catalogs/ with /books/
        $new_path = str_replace('/catalogs/', '/books/', $path);
        $new_path = str_replace('/catalogs', '/books', $new_path);
        
        // Only redirect if path actually changed
        if ($new_path !== $path) {
            $new_url = home_url($new_path . $query);
            
            // Perform 301 permanent redirect
            wp_redirect($new_url, 301);
            exit;
        }
    }
}

/**
 * Main instance of Scholar_Book_Publisher.
 * Wrapped in function_exists() to prevent Fatal Error on edge-case double-load
 * (e.g. mu-plugins loading the file twice or a broken cache flushing it).
 *
 * @since 1.0.0
 * @return Scholar_Book_Publisher
 */
if ( ! function_exists( 'sbpp_instance' ) ) {
    function sbpp_instance() {
        return Scholar_Book_Publisher::instance();
    }
}

// Keep the short alias for any templates that may already call SBP().
if ( ! function_exists( 'SBP' ) ) {
    function SBP() {
        return sbpp_instance();
    }
}

// Initialize the plugin
sbpp_instance();

/**
 * Activation Hook
 */
register_activation_hook(__FILE__, 'sbpp_activate_plugin');

if (!function_exists('sbpp_activate_plugin')) {
    function sbpp_activate_plugin() {
        // Include activator class
        require_once SBPP_PLUGIN_DIR . 'includes/class-sbpp-activator.php';
        SBPP_Activator::activate();
    }
}

/**
 * Deactivation Hook
 */
register_deactivation_hook(__FILE__, 'sbpp_deactivate_plugin');

if (!function_exists('sbpp_deactivate_plugin')) {
    function sbpp_deactivate_plugin() {
        // Flush rewrite rules
        flush_rewrite_rules();
    }
}
