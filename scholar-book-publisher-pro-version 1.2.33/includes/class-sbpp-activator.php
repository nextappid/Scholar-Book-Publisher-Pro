<?php
/**
 * Fired during plugin activation
 *
 * @package Scholar_Book_Publisher
 * @since 1.0.0
 */

class SBPP_Activator {
    
    /**
     * Activate the plugin
     *
     * @since 1.0.0
     */
    public static function activate() {
        // Register post types (needed before flushing rewrite rules)
        $post_types = new SBPP_Post_Types();
        $post_types->register_post_types();
        
        // Add sitemap rewrite rules
        add_rewrite_rule(
            '^books-sitemap\.xml$',
            'index.php?sbpp_sitemap=books',
            'top'
        );
        add_rewrite_tag('%sbpp_sitemap%', '([^&]+)');
        
        // Create default settings
        self::create_default_settings();
        
        // Flush rewrite rules
        flush_rewrite_rules();
        
        // Create upload directories
        self::create_upload_directories();
        
        // Add .htaccess rules for PDF access
        self::add_htaccess_rules();
        
        // Trigger action for other components
        do_action('sbpp_plugin_activated');
    }
    
    /**
     * Create default plugin settings
     *
     * @since 1.0.0
     */
    private static function create_default_settings() {
        $default_settings = array(
            'auto_ping_google' => true,
            'generate_sitemap' => true,
            'optimize_robots' => true,
            'enable_schema_org' => true,
            'pdf_max_size' => 5, // MB
            'require_doi' => false,
            'version' => SBPP_VERSION
        );
        
        if (!get_option('sbpp_settings')) {
            add_option('sbpp_settings', $default_settings);
        }
    }
    
    /**
     * Create upload directories for PDFs
     *
     * @since 1.0.0
     */
    private static function create_upload_directories() {
        $upload_dir = wp_upload_dir();
        $books_dir = $upload_dir['basedir'] . '/scholar-books';
        $chapters_dir = $upload_dir['basedir'] . '/scholar-chapters';
        
        if (!file_exists($books_dir)) {
            wp_mkdir_p($books_dir);
        }
        
        if (!file_exists($chapters_dir)) {
            wp_mkdir_p($chapters_dir);
        }
        
        // Create index.php in each directory for security
        $index_content = '<?php // Silence is golden';
        
        if (!file_exists($books_dir . '/index.php')) {
            file_put_contents($books_dir . '/index.php', $index_content);
        }
        
        if (!file_exists($chapters_dir . '/index.php')) {
            file_put_contents($chapters_dir . '/index.php', $index_content);
        }
    }
    
    /**
     * Add .htaccess rules for PDF access
     *
     * @since 1.0.0
     */
    private static function add_htaccess_rules() {
        $upload_dir = wp_upload_dir();
        $htaccess_file = $upload_dir['basedir'] . '/.htaccess';
        
        $rules = "\n# Scholar Book Publisher - Allow PDF access\n";
        $rules .= "<FilesMatch '\.(pdf)$'>\n";
        $rules .= "    Order Allow,Deny\n";
        $rules .= "    Allow from all\n";
        $rules .= "</FilesMatch>\n";
        $rules .= "# End Scholar Book Publisher rules\n\n";
        
        // Append rules if file exists, create if not
        if (file_exists($htaccess_file)) {
            $current_content = file_get_contents($htaccess_file);
            if (strpos($current_content, '# Scholar Book Publisher') === false) {
                file_put_contents($htaccess_file, $current_content . $rules);
            }
        } else {
            file_put_contents($htaccess_file, $rules);
        }
    }
}
