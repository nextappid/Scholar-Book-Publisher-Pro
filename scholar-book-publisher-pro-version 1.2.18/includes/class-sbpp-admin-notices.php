<?php
/**
 * Admin Notices
 * 
 * @package Scholar_Book_Publisher
 * @since 1.0.0
 */

class SBPP_Admin_Notices {
    
    public function __construct() {
        add_action('admin_notices', array($this, 'display_notices'));
    }
    
    public function display_notices() {
        if (!current_user_can('manage_options')) {
            return;
        }
        
        // Check if we need to show sitemap setup notice (v1.2.5+)
        $sitemap_notice_dismissed = get_option('sbpp_sitemap_notice_dismissed', false);
        $current_version = get_option('sbpp_version', '1.0.0');
        
        if (!$sitemap_notice_dismissed && version_compare($current_version, '1.2.5', '>=')) {
            ?>
            <div class="notice notice-info is-dismissible" id="sbp-sitemap-notice">
                <h3>📍 Scholar Book Publisher — Sitemap Available</h3>
                <p><strong>New in v1.2.5:</strong> XML Sitemap for Google Scholar indexing is now available!</p>
                
                <h4>✅ Action Required: Flush Permalinks</h4>
                <p>To activate the sitemap at <code>/books-sitemap.xml</code>:</p>
                <ol style="margin-left: 20px;">
                    <li>Go to <a href="<?php echo admin_url('options-permalink.php'); ?>" class="button button-primary">Settings → Permalinks</a></li>
                    <li>Click <strong>Save Changes</strong> (no need to change anything)</li>
                    <li>Visit <a href="<?php echo home_url('/books-sitemap.xml'); ?>" target="_blank"><?php echo home_url('/books-sitemap.xml'); ?></a> to verify</li>
                </ol>
                
                <p><strong>Then submit to Google Search Console:</strong></p>
                <ol style="margin-left: 20px;">
                    <li>Go to <a href="https://search.google.com/search-console" target="_blank">Google Search Console</a></li>
                    <li>Sitemaps → Add sitemap: <code>books-sitemap.xml</code></li>
                    <li>Submit</li>
                </ol>
                
                <button type="button" class="button" onclick="sbppDismissSitemapNotice()">Dismiss this notice</button>
            </div>
            
            <script>
            function sbppDismissSitemapNotice() {
                document.getElementById('sbp-sitemap-notice').style.display = 'none';
                fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    body: 'action=sbpp_dismiss_sitemap_notice&nonce=<?php echo wp_create_nonce('sbpp_dismiss_sitemap'); ?>'
                });
            }
            </script>
            <?php
        }
        
        // Check if we need to show URL structure update notice
        $dismissed = get_option('sbpp_url_structure_notice_dismissed', false);
        
        // Show notice if upgrading from version < 1.2.0
        if (!$dismissed && version_compare($current_version, '1.2.0', '<')) {
            ?>
            <div class="notice notice-warning is-dismissible" id="sbp-url-notice">
                <h3>🔄 Scholar Book Publisher — URL Structure Updated</h3>
                <p><strong>Important:</strong> The URL structure has changed in version 1.2.0:</p>
                <ul style="list-style: disc; margin-left: 20px;">
                    <li>Archive: <code>/catalogs/</code> → <code>/books/</code></li>
                    <li>Book: <code>/catalogs/book-title/</code> → <code>/books/book-title/</code></li>
                    <li>Chapter: <code>/catalogs/book-title/chapter/</code> → <code>/books/book-title/chapter/</code></li>
                </ul>
                
                <h4>✅ Step 1: Flush Permalinks (REQUIRED)</h4>
                <p>Go to <a href="<?php echo admin_url('options-permalink.php'); ?>" class="button button-primary">Settings → Permalinks</a> and click <strong>Save Changes</strong>.</p>
                
                <h4>✅ Step 2: Automatic Redirects (ACTIVE)</h4>
                <p style="background: #d4edda; padding: 10px; border-left: 4px solid #28a745;">
                    <strong>Good news!</strong> Automatic 301 redirects are now active. All old <code>/catalogs/</code> URLs will automatically redirect to <code>/books/</code>.<br>
                    <em>No manual configuration needed — this preserves your SEO and prevents broken links!</em>
                </p>
                
                <details style="margin-top: 15px;">
                    <summary style="cursor: pointer; font-weight: 600;">📋 Optional: Server-Level Redirects (for better performance)</summary>
                    <div style="margin-top: 10px; padding: 15px; background: #f8f9fa; border: 1px solid #dee2e6;">
                        <p>For maximum performance, you can add server-level redirects (optional):</p>
                        <button type="button" class="button" onclick="document.getElementById('sbp-htaccess-rules').style.display='block'">Show Apache/.htaccess Rules</button>
                        <button type="button" class="button" onclick="document.getElementById('sbp-nginx-rules').style.display='block'">Show Nginx Rules</button>
                        
                        <div id="sbp-htaccess-rules" style="display:none; margin-top: 10px;">
                            <h4>Apache / .htaccess Rules:</h4>
                            <textarea readonly style="width: 100%; height: 200px; font-family: monospace; font-size: 12px;"><?php echo esc_textarea(SBPP_SEO_Migration::get_htaccess_rules()); ?></textarea>
                            <button type="button" class="button" onclick="navigator.clipboard.writeText(document.querySelector('#sbp-htaccess-rules textarea').value); alert('Copied to clipboard!')">Copy to Clipboard</button>
                        </div>
                        
                        <div id="sbp-nginx-rules" style="display:none; margin-top: 10px;">
                            <h4>Nginx Rules:</h4>
                            <textarea readonly style="width: 100%; height: 200px; font-family: monospace; font-size: 12px;"><?php echo esc_textarea(SBPP_SEO_Migration::get_nginx_rules()); ?></textarea>
                            <button type="button" class="button" onclick="navigator.clipboard.writeText(document.querySelector('#sbp-nginx-rules textarea').value); alert('Copied to clipboard!')">Copy to Clipboard</button>
                        </div>
                        
                        <p style="margin-top: 10px;"><em>Note: Server-level redirects are faster but require server access. The automatic PHP redirects work fine for most sites.</em></p>
                    </div>
                </details>
            </div>
            <script>
            jQuery(document).ready(function($) {
                $('#sbp-url-notice').on('click', '.notice-dismiss', function() {
                    $.post(ajaxurl, {
                        action: 'sbpp_dismiss_url_notice',
                        nonce: '<?php echo wp_create_nonce('sbpp_dismiss_notice'); ?>'
                    });
                });
            });
            </script>
            <?php
        }
        
        // Update version option
        if ($current_version !== SBPP_VERSION) {
            update_option('sbpp_version', SBPP_VERSION);
        }
    }
}
