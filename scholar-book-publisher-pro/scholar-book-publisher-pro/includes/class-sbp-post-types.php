<?php
/**
 * Register Custom Post Types and Meta Boxes
 * Complete implementation with all metadata fields
 * 
 * @package Scholar_Book_Publisher
 * @since 1.0.0
 */

class SBP_Post_Types {
    
    public function __construct() {
        add_action('init', array($this, 'register_post_types'));
        add_action('init', array($this, 'register_taxonomies'));
        add_action('init', array($this, 'remove_default_editor'));
        add_action('add_meta_boxes', array($this, 'add_meta_boxes'));
        add_action('save_post', array($this, 'save_book_meta'), 10, 2);
        add_action('save_post', array($this, 'save_chapter_meta'), 10, 2);
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));
        add_filter('post_type_link', array($this, 'chapter_permalink'), 10, 2);
        
        // Force classic editor for our post types
        add_filter('use_block_editor_for_post_type', array($this, 'disable_gutenberg'), 10, 2);
    }
    
    /**
     * Disable Gutenberg editor for Books and Chapters
     * Force classic editor instead
     */
    public function disable_gutenberg($use_block_editor, $post_type) {
        if (in_array($post_type, array('scholar_book', 'scholar_chapter'))) {
            return false;
        }
        return $use_block_editor;
    }
    
    /**
     * Remove default WordPress editor for Books and Chapters
     * We use custom meta box editors instead
     */
    public function remove_default_editor() {
        remove_post_type_support('scholar_book', 'editor');
        remove_post_type_support('scholar_chapter', 'editor');
    }
    
    /**
     * Register Custom Post Types
     */
    public function register_post_types() {
        // Register Book CPT
        register_post_type('scholar_book', array(
            'labels' => array(
                'name' => __('Books', 'scholar-book-publisher'),
                'singular_name' => __('Book', 'scholar-book-publisher'),
                'add_new' => __('Add New Book', 'scholar-book-publisher'),
                'add_new_item' => __('Add New Book', 'scholar-book-publisher'),
                'edit_item' => __('Edit Book', 'scholar-book-publisher'),
                'view_item' => __('View Book', 'scholar-book-publisher'),
                'search_items' => __('Search Books', 'scholar-book-publisher'),
            ),
            'public' => true,
            'has_archive' => 'books',
            'rewrite' => array(
                'slug' => 'books',
                'with_front' => false,
                'hierarchical' => false
            ),
            'supports' => array('title', 'thumbnail'),
            'menu_icon' => 'dashicons-book',
            'show_in_rest' => false,
            'menu_position' => 5
        ));
        
        // Register Chapter CPT
        register_post_type('scholar_chapter', array(
            'labels' => array(
                'name' => __('Chapters', 'scholar-book-publisher'),
                'singular_name' => __('Chapter', 'scholar-book-publisher'),
                'add_new' => __('Add Book Chapter', 'scholar-book-publisher'),
                'add_new_item' => __('Add New Book Chapter', 'scholar-book-publisher'),
                'edit_item' => __('Edit Book Chapter', 'scholar-book-publisher'),
                'view_item' => __('View Chapter', 'scholar-book-publisher'),
                'search_items' => __('Search Chapters', 'scholar-book-publisher'),
            ),
            'public' => true,
            'has_archive' => false,
            'rewrite' => array(
                'slug' => 'books/%book%',
                'with_front' => false
            ),
            'supports' => array('title'),
            'menu_icon' => 'dashicons-media-text',
            'show_in_rest' => false,
            'menu_position' => 6
        ));
    }
    
    /**
     * Register Taxonomies
     */
    public function register_taxonomies() {
        // Book Category
        register_taxonomy('book_category', 'scholar_book', array(
            'hierarchical' => true,
            'labels' => array(
                'name' => __('Book Categories', 'scholar-book-publisher'),
                'singular_name' => __('Category', 'scholar-book-publisher'),
            ),
            'show_in_rest' => false,
            'rewrite' => array('slug' => 'book-category'),
        ));
        
        // Book Tags
        register_taxonomy('book_tag', 'scholar_book', array(
            'hierarchical' => false,
            'labels' => array(
                'name' => __('Book Tags', 'scholar-book-publisher'),
                'singular_name' => __('Tag', 'scholar-book-publisher'),
            ),
            'show_in_rest' => false,
            'rewrite' => array('slug' => 'book-tag'),
        ));
    }
    
    /**
     * Add Meta Boxes
     */
    public function add_meta_boxes() {
        // Book Meta Box
        add_meta_box(
            'sbp_book_details',
            __('Book Publication Details', 'scholar-book-publisher'),
            array($this, 'render_book_meta_box'),
            'scholar_book',
            'normal',
            'high'
        );
        
        // Usage Metrics Meta Box
        add_meta_box(
            'sbp_usage_metrics',
            __('Usage Metrics', 'scholar-book-publisher'),
            array($this, 'render_usage_metrics_box'),
            'scholar_book',
            'side',
            'default'
        );
        
        // Chapter Meta Box
        add_meta_box(
            'sbp_chapter_details',
            __('Chapter Details', 'scholar-book-publisher'),
            array($this, 'render_chapter_meta_box'),
            'scholar_chapter',
            'normal',
            'high'
        );
    }
    
    /**
     * Enqueue Admin Scripts
     */
    public function enqueue_admin_scripts($hook) {
        global $post_type;
        
        if (($hook === 'post.php' || $hook === 'post-new.php') && 
            ($post_type === 'scholar_book' || $post_type === 'scholar_chapter')) {
            
            // Enqueue WordPress Media Uploader
            wp_enqueue_media();
            
            // Inline styles for meta boxes
            wp_add_inline_style('wp-admin', '
                .sbp-field { margin-bottom: 20px; }
                .sbp-field label { display: block; font-weight: bold; margin-bottom: 5px; }
                .sbp-field input[type="text"],
                .sbp-field input[type="url"],
                .sbp-field input[type="date"],
                .sbp-field input[type="number"],
                .sbp-field select { width: 100%; max-width: 500px; padding: 6px 8px; }
                .sbp-field textarea { width: 100%; max-width: 500px; min-height: 100px; }
                .sbp-repeater-item { background: #f9f9f9; padding: 15px; margin-bottom: 10px; border-left: 3px solid #2271b1; position: relative; }
                .sbp-remove-btn { color: #dc3232; cursor: pointer; text-decoration: none; position: absolute; top: 10px; right: 10px; }
                .sbp-pdf-schema { border: 2px solid #2271b1; padding: 20px; background: #f0f8ff; margin: 20px 0; }
                .sbp-schema-option { display: none; padding: 15px; background: white; border: 1px solid #ddd; margin-top: 10px; }
                .sbp-schema-option.active { display: block; }
                .sbp-info-box { background: #fff3cd; border-left: 4px solid #ffc107; padding: 12px; margin: 10px 0; }
            ');
        }
    }
    
    /**
     * Render Book Meta Box
     */
    public function render_book_meta_box($post) {
        wp_nonce_field('sbp_book_meta', 'sbp_book_nonce');
        
        // Get existing values
        $cover_id = get_post_meta($post->ID, '_sbp_book_cover', true);
        $subtitle = get_post_meta($post->ID, '_sbp_book_subtitle', true);
        $description = get_post_meta($post->ID, '_sbp_book_description', true);
        $language = get_post_meta($post->ID, '_sbp_book_language', true);
        $publisher = get_post_meta($post->ID, '_sbp_book_publisher', true);
        $publisher_city = get_post_meta($post->ID, '_sbp_publisher_city', true);
        $pub_date = get_post_meta($post->ID, '_sbp_publication_date', true);
        $isbn = get_post_meta($post->ID, '_sbp_isbn', true);
        $doi = get_post_meta($post->ID, '_sbp_doi', true);
        $dimensions = get_post_meta($post->ID, '_sbp_dimensions', true);
        $price = get_post_meta($post->ID, '_sbp_price', true);
        $access_category = get_post_meta($post->ID, '_sbp_access_category', true) ?: 'open';
        
        $pdf_available = get_post_meta($post->ID, '_sbp_pdf_available', true);
        $pdf_source = get_post_meta($post->ID, '_sbp_pdf_source', true) ?: 'wordpress';
        $pdf_wordpress_id = get_post_meta($post->ID, '_sbp_pdf_wordpress_id', true);
        $pdf_gdrive_url = get_post_meta($post->ID, '_sbp_pdf_gdrive_url', true);
        $pdf_gdrive_id = get_post_meta($post->ID, '_sbp_pdf_gdrive_id', true);
        $pdf_file_size = get_post_meta($post->ID, '_sbp_pdf_file_size', true);
        
        $authors = get_post_meta($post->ID, '_sbp_authors', true) ?: array(array('first_name' => '', 'last_name' => ''));
        $editors = get_post_meta($post->ID, '_sbp_editors', true) ?: array();
        
        ?>
        
        <!-- Book Subtitle -->
        <div class="sbp-field">
            <label for="sbp_book_subtitle"><?php _e('Book Subtitle (Optional)', 'scholar-book-publisher'); ?></label>
            <input type="text" id="sbp_book_subtitle" name="sbp_book_subtitle" 
                   value="<?php echo esc_attr($subtitle); ?>" 
                   style="width: 100%; max-width: 100%;"
                   placeholder="e.g., A Comprehensive Guide">
            <p class="description"><?php _e('Optional subtitle that appears below the main title. Will be displayed on the book page and included in metadata.', 'scholar-book-publisher'); ?></p>
        </div>
        
        <!-- Book Cover -->
        <div class="sbp-field">
            <label for="sbp_book_cover"><strong><?php _e('Book Cover Image', 'scholar-book-publisher'); ?></strong></label>
            <input type="hidden" id="sbp_book_cover" name="sbp_book_cover" value="<?php echo esc_attr($cover_id); ?>">
            <div id="sbp_cover_preview" style="margin: 10px 0;">
                <?php if ($cover_id): 
                    $cover_url = wp_get_attachment_url($cover_id);
                ?>
                    <img src="<?php echo esc_url($cover_url); ?>" style="max-width: 200px; height: auto; display: block; margin-bottom: 10px; border: 1px solid #ddd; padding: 5px;">
                <?php endif; ?>
            </div>
            <button type="button" class="button" id="sbp_upload_cover_button">
                <?php echo $cover_id ? '📷 ' . __('Change Cover', 'scholar-book-publisher') : '📤 ' . __('Upload Cover', 'scholar-book-publisher'); ?>
            </button>
            <?php if ($cover_id): ?>
                <button type="button" class="button" id="sbp_remove_cover_button" style="margin-left: 10px;">
                    ❌ <?php _e('Remove Cover', 'scholar-book-publisher'); ?>
                </button>
            <?php endif; ?>
            <p class="description"><?php _e('Recommended size: 600x900px. Maximum file size: 1MB. Formats: JPG, PNG.', 'scholar-book-publisher'); ?></p>
        </div>
        
        <!-- Book Description -->
        <div class="sbp-field">
            <label for="sbp_book_description"><strong><?php _e('Book Description (Synopsis)', 'scholar-book-publisher'); ?></strong></label>
            <?php 
            wp_editor($description, 'sbp_book_description', array(
                'textarea_name' => 'sbp_book_description',
                'textarea_rows' => 8,
                'media_buttons' => false,
                'teeny' => false,
                'wpautop' => true,
                'tinymce' => array(
                    'toolbar1' => 'formatselect,bold,italic,underline,strikethrough,bullist,numlist,blockquote,alignleft,aligncenter,alignright,link,unlink,removeformat',
                    'toolbar2' => '',
                    'force_br_newlines' => false,
                    'force_p_newlines' => true,
                    'convert_newlines_to_brs' => false,
                    'remove_linebreaks' => false,
                ),
                'quicktags' => array(
                    'buttons' => 'strong,em,link,block,ul,ol,li,close'
                ),
                'editor_class' => 'sbp-description-editor',
            ));
            ?>
            <p class="description" style="margin-top: 10px;"><?php _e('Brief description or synopsis of the book. Will appear in "About This Book" section. You can use formatting for better presentation.', 'scholar-book-publisher'); ?></p>
        </div>
        
        <!-- Authors -->
        <div class="sbp-field">
            <label><strong><?php _e('Authors *', 'scholar-book-publisher'); ?></strong></label>
            <div id="sbp_authors_container">
                <?php foreach ($authors as $index => $author): ?>
                    <div class="sbp-repeater-item">
                        <a href="#" class="sbp-remove-btn" onclick="jQuery(this).closest('.sbp-repeater-item').remove(); return false;">✕ Remove</a>
                        <label><?php _e('First Name:', 'scholar-book-publisher'); ?></label>
                        <input type="text" name="sbp_authors[<?php echo $index; ?>][first_name]" 
                               value="<?php echo esc_attr($author['first_name'] ?? ''); ?>" 
                               style="width: 48%; margin-right: 2%;" required>
                        <label><?php _e('Last Name:', 'scholar-book-publisher'); ?></label>
                        <input type="text" name="sbp_authors[<?php echo $index; ?>][last_name]" 
                               value="<?php echo esc_attr($author['last_name'] ?? ''); ?>" 
                               style="width: 48%;" required>
                    </div>
                <?php endforeach; ?>
            </div>
            <button type="button" class="button" id="sbp_add_author">+ <?php _e('Add Author', 'scholar-book-publisher'); ?></button>
            <p class="description"><?php _e('Format: Last Name, First Name (e.g., Smith, John)', 'scholar-book-publisher'); ?></p>
        </div>
        
        <!-- Editors -->
        <div class="sbp-field">
            <label><strong><?php _e('Editors (Optional for edited volumes)', 'scholar-book-publisher'); ?></strong></label>
            <div id="sbp_editors_container">
                <?php if (!empty($editors)): foreach ($editors as $index => $editor): ?>
                    <div class="sbp-repeater-item">
                        <a href="#" class="sbp-remove-btn" onclick="jQuery(this).closest('.sbp-repeater-item').remove(); return false;">✕ Remove</a>
                        <label><?php _e('First Name:', 'scholar-book-publisher'); ?></label>
                        <input type="text" name="sbp_editors[<?php echo $index; ?>][first_name]" 
                               value="<?php echo esc_attr($editor['first_name'] ?? ''); ?>" 
                               style="width: 48%; margin-right: 2%;">
                        <label><?php _e('Last Name:', 'scholar-book-publisher'); ?></label>
                        <input type="text" name="sbp_editors[<?php echo $index; ?>][last_name]" 
                               value="<?php echo esc_attr($editor['last_name'] ?? ''); ?>" 
                               style="width: 48%;">
                    </div>
                <?php endforeach; endif; ?>
            </div>
            <button type="button" class="button" id="sbp_add_editor">+ <?php _e('Add Editor', 'scholar-book-publisher'); ?></button>
        </div>
        
        <!-- Publisher -->
        <div class="sbp-field">
            <label for="sbp_book_publisher"><?php _e('Publisher Name *', 'scholar-book-publisher'); ?></label>
            <input type="text" id="sbp_book_publisher" name="sbp_book_publisher" 
                   value="<?php echo esc_attr($publisher ? $publisher : 'Southeast Asian Publishing'); ?>" 
                   placeholder="Southeast Asian Publishing" required>
        </div>
        
        <!-- Publisher City -->
        <div class="sbp-field">
            <label for="sbp_publisher_city"><?php _e('Publisher City *', 'scholar-book-publisher'); ?></label>
            <input type="text" id="sbp_publisher_city" name="sbp_publisher_city" 
                   value="<?php echo esc_attr($publisher_city ? $publisher_city : 'Semarang'); ?>" 
                   placeholder="Semarang" required>
            <p class="description"><?php _e('City of publication (essential for academic citations)', 'scholar-book-publisher'); ?></p>
        </div>
        
        <!-- Publication Date -->
        <div class="sbp-field">
            <label for="sbp_publication_date"><?php _e('Publication Date *', 'scholar-book-publisher'); ?></label>
            <input type="date" id="sbp_publication_date" name="sbp_publication_date" 
                   value="<?php echo esc_attr($pub_date); ?>" required>
        </div>
        
        <!-- Language -->
        <div class="sbp-field">
            <label for="sbp_book_language"><?php _e('Language', 'scholar-book-publisher'); ?></label>
            <select id="sbp_book_language" name="sbp_book_language" style="max-width: 300px;">
                <option value=""><?php _e('Select language', 'scholar-book-publisher'); ?></option>
                <option value="English" <?php selected($language, 'English'); ?>>English</option>
                <option value="Indonesian" <?php selected($language, 'Indonesian'); ?>>Indonesian (Bahasa Indonesia)</option>
                <option value="Spanish" <?php selected($language, 'Spanish'); ?>>Spanish (Español)</option>
                <option value="French" <?php selected($language, 'French'); ?>>French (Français)</option>
                <option value="German" <?php selected($language, 'German'); ?>>German (Deutsch)</option>
                <option value="Chinese" <?php selected($language, 'Chinese'); ?>>Chinese (中文)</option>
                <option value="Arabic" <?php selected($language, 'Arabic'); ?>>Arabic (العربية)</option>
                <option value="Portuguese" <?php selected($language, 'Portuguese'); ?>>Portuguese (Português)</option>
                <option value="Russian" <?php selected($language, 'Russian'); ?>>Russian (Русский)</option>
                <option value="Japanese" <?php selected($language, 'Japanese'); ?>>Japanese (日本語)</option>
                <option value="Korean" <?php selected($language, 'Korean'); ?>>Korean (한국어)</option>
                <option value="Dutch" <?php selected($language, 'Dutch'); ?>>Dutch (Nederlands)</option>
                <option value="Italian" <?php selected($language, 'Italian'); ?>>Italian (Italiano)</option>
                <option value="Other" <?php selected($language, 'Other'); ?>>Other</option>
            </select>
            <p class="description"><?php _e('The language in which the book is written.', 'scholar-book-publisher'); ?></p>
        </div>
        
        <!-- ISBN -->
        <div class="sbp-field">
            <label for="sbp_isbn"><?php _e('ISBN *', 'scholar-book-publisher'); ?></label>
            <input type="text" id="sbp_isbn" name="sbp_isbn" 
                   value="<?php echo esc_attr($isbn); ?>" 
                   placeholder="978-1234567890" required>
            <p class="description"><?php _e('13-digit ISBN (with or without hyphens)', 'scholar-book-publisher'); ?></p>
        </div>
        
        <!-- DOI -->
        <div class="sbp-field">
            <label for="sbp_doi"><?php _e('DOI (Optional but recommended)', 'scholar-book-publisher'); ?></label>
            <input type="text" id="sbp_doi" name="sbp_doi" 
                   value="<?php echo esc_attr($doi); ?>" 
                   placeholder="10.1234/example">
            <p class="description"><?php _e('Digital Object Identifier - greatly improves discoverability', 'scholar-book-publisher'); ?></p>
        </div>
        
        <!-- Dimensions -->
        <div class="sbp-field">
            <label for="sbp_dimensions"><?php _e('Dimensions (Optional)', 'scholar-book-publisher'); ?></label>
            <input type="text" id="sbp_dimensions" name="sbp_dimensions" 
                   value="<?php echo esc_attr($dimensions); ?>" 
                   placeholder="e.g., 6 x 9 inches or 15 x 23 cm">
            <p class="description"><?php _e('Physical dimensions of the book (Width x Height)', 'scholar-book-publisher'); ?></p>
        </div>
        
        <!-- Price -->
        <div class="sbp-field">
            <label for="sbp_price"><?php _e('Price (Optional)', 'scholar-book-publisher'); ?></label>
            <input type="text" id="sbp_price" name="sbp_price" 
                   value="<?php echo esc_attr($price); ?>" 
                   placeholder="e.g., $29.99 or Rp 250.000">
            <p class="description"><?php _e('Book price - leave empty if not applicable. Will only display if filled.', 'scholar-book-publisher'); ?></p>
        </div>
        
        <!-- Access Category -->
        <div class="sbp-field">
            <label for="sbp_access_category"><strong><?php _e('Access Category *', 'scholar-book-publisher'); ?></strong></label>
            <select id="sbp_access_category" name="sbp_access_category" required style="max-width: 300px;">
                <option value="open" <?php selected($access_category, 'open'); ?>><?php _e('Open Access', 'scholar-book-publisher'); ?></option>
                <option value="closed" <?php selected($access_category, 'closed'); ?>><?php _e('Closed Access', 'scholar-book-publisher'); ?></option>
            </select>
            <p class="description"><?php _e('Open Access: PDF will be available. Closed Access: No PDF upload needed.', 'scholar-book-publisher'); ?></p>
        </div>
        
        <!-- PDF Section -->
        <div class="sbp-pdf-schema" id="sbp_pdf_section" style="<?php echo ($access_category === 'closed') ? 'display:none;' : ''; ?>">
            <h3 style="margin-top: 0;">📄 <?php _e('PDF Provision', 'scholar-book-publisher'); ?></h3>
            
            <div class="sbp-info-box">
                <strong>ℹ️ <?php _e('Open Access Book:', 'scholar-book-publisher'); ?></strong> 
                <?php _e('Please provide PDF for better Google Scholar indexing.', 'scholar-book-publisher'); ?>
            </div>
            
            <div class="sbp-field">
                <label>
                    <input type="checkbox" id="sbp_pdf_available" name="sbp_pdf_available" 
                           value="1" <?php checked($pdf_available, '1'); ?>>
                    <?php _e('This book has a PDF available', 'scholar-book-publisher'); ?>
                </label>
            </div>
            
            <div id="sbp_pdf_options" style="<?php echo $pdf_available ? '' : 'display:none;'; ?>">
                
                <div class="sbp-field">
                    <label><strong><?php _e('Choose PDF Source:', 'scholar-book-publisher'); ?></strong></label>
                    <div style="margin: 10px 0;">
                        <label style="display: block; margin-bottom: 10px;">
                            <input type="radio" name="sbp_pdf_source" value="wordpress" 
                                   <?php checked($pdf_source, 'wordpress'); ?>>
                            <strong><?php _e('Schema 1:', 'scholar-book-publisher'); ?></strong> <?php _e('Upload to WordPress Media Library', 'scholar-book-publisher'); ?>
                        </label>
                        <label style="display: block;">
                            <input type="radio" name="sbp_pdf_source" value="gdrive" 
                                   <?php checked($pdf_source, 'gdrive'); ?>>
                            <strong><?php _e('Schema 2:', 'scholar-book-publisher'); ?></strong> <?php _e('Link from Google Drive', 'scholar-book-publisher'); ?>
                        </label>
                    </div>
                </div>
                
                <!-- WordPress Upload -->
                <div id="sbp_schema_wordpress" class="sbp-schema-option <?php echo ($pdf_source === 'wordpress') ? 'active' : ''; ?>">
                    <h4>📤 <?php _e('Upload PDF to WordPress', 'scholar-book-publisher'); ?></h4>
                    <input type="hidden" id="sbp_pdf_wordpress_id" name="sbp_pdf_wordpress_id" 
                           value="<?php echo esc_attr($pdf_wordpress_id); ?>">
                    <button type="button" class="button" id="sbp_upload_pdf_button">
                        <?php echo $pdf_wordpress_id ? '📎 ' . __('Change PDF File', 'scholar-book-publisher') : '📤 ' . __('Upload PDF File', 'scholar-book-publisher'); ?>
                    </button>
                    <div id="sbp_pdf_preview" style="margin-top: 10px;">
                        <?php if ($pdf_wordpress_id): 
                            $pdf_url = wp_get_attachment_url($pdf_wordpress_id);
                            $pdf_filename = basename($pdf_url);
                        ?>
                            <div style="background: #d4edda; border-left: 4px solid #28a745; padding: 12px; margin-top: 10px;">
                                <strong>✅ <?php _e('Current PDF:', 'scholar-book-publisher'); ?></strong> 
                                <a href="<?php echo esc_url($pdf_url); ?>" target="_blank"><?php echo esc_html($pdf_filename); ?></a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Google Drive -->
                <div id="sbp_schema_gdrive" class="sbp-schema-option <?php echo ($pdf_source === 'gdrive') ? 'active' : ''; ?>">
                    <h4>🔗 <?php _e('Link PDF from Google Drive', 'scholar-book-publisher'); ?></h4>
                    <div class="sbp-field">
                        <label for="sbp_pdf_gdrive_url"><?php _e('Google Drive Share Link:', 'scholar-book-publisher'); ?></label>
                        <input type="url" id="sbp_pdf_gdrive_url" name="sbp_pdf_gdrive_url" 
                               value="<?php echo esc_attr($pdf_gdrive_url); ?>"
                               placeholder="https://drive.google.com/file/d/1ABC.../view">
                        <button type="button" class="button button-primary" id="sbp_validate_gdrive" style="margin-top: 10px;">
                            🔍 <?php _e('Validate & Extract ID', 'scholar-book-publisher'); ?>
                        </button>
                        <div id="sbp_gdrive_result" style="margin-top: 10px;"></div>
                    </div>
                    <input type="hidden" id="sbp_pdf_gdrive_id" name="sbp_pdf_gdrive_id" 
                           value="<?php echo esc_attr($pdf_gdrive_id); ?>">
                    
                    <?php if ($pdf_gdrive_id): ?>
                    <div style="background: #d4edda; border-left: 4px solid #28a745; padding: 12px; margin-top: 10px;">
                        <strong>✅ <?php _e('Direct Download Link:', 'scholar-book-publisher'); ?></strong><br>
                        <code style="background: #fff; padding: 5px; display: block; margin-top: 5px; word-break: break-all;">
                            https://drive.google.com/uc?export=download&id=<?php echo esc_attr($pdf_gdrive_id); ?>
                        </code>
                    </div>
                    <?php endif; ?>
                    
                    <div class="sbp-field" style="margin-top: 15px;">
                        <label for="sbp_pdf_file_size"><?php _e('PDF File Size (MB):', 'scholar-book-publisher'); ?></label>
                        <input type="number" id="sbp_pdf_file_size" name="sbp_pdf_file_size" 
                               value="<?php echo esc_attr($pdf_file_size); ?>" 
                               step="0.1" min="0" max="10" placeholder="e.g., 2.5">
                    </div>
                </div>
                
            </div>
        </div>
        
        <script>
        jQuery(document).ready(function($) {
            // Upload Book Cover
            var coverFrame;
            $('#sbp_upload_cover_button').click(function(e) {
                e.preventDefault();
                if (coverFrame) { coverFrame.open(); return; }
                coverFrame = wp.media({
                    title: '<?php _e('Select Book Cover', 'scholar-book-publisher'); ?>',
                    button: { text: '<?php _e('Use this image', 'scholar-book-publisher'); ?>' },
                    library: { type: 'image' },
                    multiple: false
                });
                coverFrame.on('select', function() {
                    var attachment = coverFrame.state().get('selection').first().toJSON();
                    // Check file size (max 1MB = 1048576 bytes)
                    if (attachment.filesizeInBytes > 1048576) {
                        alert('<?php _e('File size must be less than 1MB. Please choose a smaller image.', 'scholar-book-publisher'); ?>');
                        return;
                    }
                    $('#sbp_book_cover').val(attachment.id);
                    $('#sbp_cover_preview').html(
                        '<img src="' + attachment.url + '" style="max-width: 200px; height: auto; display: block; margin-bottom: 10px; border: 1px solid #ddd; padding: 5px;">'
                    );
                    $('#sbp_upload_cover_button').text('<?php _e('📷 Change Cover', 'scholar-book-publisher'); ?>');
                    if ($('#sbp_remove_cover_button').length === 0) {
                        $('#sbp_upload_cover_button').after('<button type="button" class="button" id="sbp_remove_cover_button" style="margin-left: 10px;">❌ <?php _e('Remove Cover', 'scholar-book-publisher'); ?></button>');
                    }
                });
                coverFrame.open();
            });
            
            // Remove Book Cover
            $(document).on('click', '#sbp_remove_cover_button', function(e) {
                e.preventDefault();
                $('#sbp_book_cover').val('');
                $('#sbp_cover_preview').html('');
                $('#sbp_upload_cover_button').text('<?php _e('📤 Upload Cover', 'scholar-book-publisher'); ?>');
                $(this).remove();
            });
            
            // Access Category toggle for PDF section
            $('#sbp_access_category').change(function() {
                if ($(this).val() === 'open') {
                    $('#sbp_pdf_section').slideDown();
                } else {
                    $('#sbp_pdf_section').slideUp();
                    $('#sbp_pdf_available').prop('checked', false).trigger('change');
                }
            });
            
            // PDF checkbox toggle
            $('#sbp_pdf_available').change(function() {
                $('#sbp_pdf_options').toggle(this.checked);
            });
            
            // PDF source radio toggle
            $('input[name="sbp_pdf_source"]').change(function() {
                $('.sbp-schema-option').removeClass('active');
                if ($(this).val() === 'wordpress') {
                    $('#sbp_schema_wordpress').addClass('active');
                } else {
                    $('#sbp_schema_gdrive').addClass('active');
                }
            });
            
            // Add author
            $('#sbp_add_author').click(function() {
                var index = $('#sbp_authors_container .sbp-repeater-item').length;
                var html = '<div class="sbp-repeater-item">' +
                    '<a href="#" class="sbp-remove-btn" onclick="jQuery(this).closest(\'.sbp-repeater-item\').remove(); return false;">✕ Remove</a>' +
                    '<label>First Name:</label>' +
                    '<input type="text" name="sbp_authors[' + index + '][first_name]" style="width: 48%; margin-right: 2%;" required>' +
                    '<label>Last Name:</label>' +
                    '<input type="text" name="sbp_authors[' + index + '][last_name]" style="width: 48%;" required>' +
                    '</div>';
                $('#sbp_authors_container').append(html);
            });
            
            // Add editor
            $('#sbp_add_editor').click(function() {
                var index = $('#sbp_editors_container .sbp-repeater-item').length;
                var html = '<div class="sbp-repeater-item">' +
                    '<a href="#" class="sbp-remove-btn" onclick="jQuery(this).closest(\'.sbp-repeater-item\').remove(); return false;">✕ Remove</a>' +
                    '<label>First Name:</label>' +
                    '<input type="text" name="sbp_editors[' + index + '][first_name]" style="width: 48%; margin-right: 2%;">' +
                    '<label>Last Name:</label>' +
                    '<input type="text" name="sbp_editors[' + index + '][last_name]" style="width: 48%;">' +
                    '</div>';
                $('#sbp_editors_container').append(html);
            });
            
            // WordPress Media Upload
            var fileFrame;
            $('#sbp_upload_pdf_button').click(function(e) {
                e.preventDefault();
                if (fileFrame) { fileFrame.open(); return; }
                fileFrame = wp.media({
                    title: '<?php _e('Select PDF', 'scholar-book-publisher'); ?>',
                    button: { text: '<?php _e('Use this PDF', 'scholar-book-publisher'); ?>' },
                    library: { type: 'application/pdf' },
                    multiple: false
                });
                fileFrame.on('select', function() {
                    var attachment = fileFrame.state().get('selection').first().toJSON();
                    $('#sbp_pdf_wordpress_id').val(attachment.id);
                    $('#sbp_pdf_preview').html(
                        '<div style="background: #d4edda; border-left: 4px solid #28a745; padding: 12px; margin-top: 10px;">' +
                        '<strong>✅ Selected PDF:</strong> <a href="' + attachment.url + '" target="_blank">' + attachment.filename + '</a>' +
                        '</div>'
                    );
                });
                fileFrame.open();
            });
            
            // Google Drive Validation
            $('#sbp_validate_gdrive').click(function() {
                var url = $('#sbp_pdf_gdrive_url').val();
                if (!url) {
                    $('#sbp_gdrive_result').html('<div style="background: #fff3cd; border-left: 4px solid #ffc107; padding: 12px;">Please enter a link first.</div>');
                    return;
                }
                var patterns = [/\/d\/([a-zA-Z0-9_-]+)/, /id=([a-zA-Z0-9_-]+)/, /\/file\/d\/([a-zA-Z0-9_-]+)/];
                var fileId = null;
                for (var i = 0; i < patterns.length; i++) {
                    var match = url.match(patterns[i]);
                    if (match && match[1]) { fileId = match[1]; break; }
                }
                if (fileId) {
                    $('#sbp_pdf_gdrive_id').val(fileId);
                    var directLink = 'https://drive.google.com/uc?export=download&id=' + fileId;
                    $('#sbp_gdrive_result').html(
                        '<div style="background: #d4edda; border-left: 4px solid #28a745; padding: 12px;">' +
                        '<strong>✅ Success!</strong> File ID: <code>' + fileId + '</code><br>' +
                        '<strong>Direct Link:</strong><br><code style="background: #fff; padding: 5px; display: block; margin-top: 5px; word-break: break-all;">' + directLink + '</code>' +
                        '</div>'
                    );
                } else {
                    $('#sbp_gdrive_result').html('<div style="background: #f8d7da; border-left: 4px solid #dc3545; padding: 12px;"><strong>❌ Error:</strong> Could not extract File ID.</div>');
                }
            });
        });
        </script>
        <?php
    }
    
    /**
     * Render Usage Metrics Meta Box
     */
    public function render_usage_metrics_box($post) {
        $metrics = SBP_Usage_Metrics::get_metrics($post->ID);
        ?>
        <div style="padding: 10px 0;">
            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: 600; margin-bottom: 5px; color: #2271b1;">
                    👁️ Views
                </label>
                <div style="font-size: 1.5rem; font-weight: 700;">
                    <?php echo number_format($metrics['views']); ?>
                </div>
                <small style="color: #666;">Auto-tracked page views</small>
            </div>
            
            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: 600; margin-bottom: 5px; color: #059669;">
                    📥 Downloads
                </label>
                <div style="font-size: 1.5rem; font-weight: 700;">
                    <?php echo number_format($metrics['downloads']); ?>
                </div>
                <small style="color: #666;">Auto-tracked PDF downloads</small>
            </div>
            
            <div style="background: #f0f8ff; padding: 10px; border-left: 3px solid #2271b1; font-size: 0.85rem;">
                <strong>ℹ️ Note:</strong> Views and downloads are tracked automatically. Check your book's performance metrics here.
            </div>
        </div>
        <?php
    }
    
    /**
     * Render Chapter Meta Box
     */
    public function render_chapter_meta_box($post) {
        wp_nonce_field('sbp_chapter_meta', 'sbp_chapter_nonce');
        
        $parent_book = get_post_meta($post->ID, '_sbp_parent_book', true);
        $first_page = get_post_meta($post->ID, '_sbp_chapter_first_page', true);
        $last_page = get_post_meta($post->ID, '_sbp_chapter_last_page', true);
        $chapter_authors = get_post_meta($post->ID, '_sbp_chapter_authors', true) ?: array(array('first_name' => '', 'last_name' => ''));
        $chapter_pdf = get_post_meta($post->ID, '_sbp_chapter_pdf_url', true);
        $chapter_doi = get_post_meta($post->ID, '_sbp_chapter_doi', true);
        
        // Get all books for dropdown
        $books = get_posts(array('post_type' => 'scholar_book', 'posts_per_page' => -1, 'orderby' => 'title', 'order' => 'ASC'));
        ?>
        
        <!-- Parent Book -->
        <div class="sbp-field">
            <label for="sbp_parent_book"><?php _e('Parent Book *', 'scholar-book-publisher'); ?></label>
            <select id="sbp_parent_book" name="sbp_parent_book" required>
                <option value=""><?php _e('Select a book', 'scholar-book-publisher'); ?></option>
                <?php foreach ($books as $book): ?>
                    <option value="<?php echo $book->ID; ?>" <?php selected($parent_book, $book->ID); ?>>
                        <?php echo esc_html($book->post_title); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <!-- Chapter Authors -->
        <div class="sbp-field">
            <label><strong><?php _e('Chapter Authors *', 'scholar-book-publisher'); ?></strong></label>
            <div id="sbp_chapter_authors_container">
                <?php foreach ($chapter_authors as $index => $author): ?>
                    <div class="sbp-repeater-item">
                        <a href="#" class="sbp-remove-btn" onclick="jQuery(this).closest('.sbp-repeater-item').remove(); return false;">✕ Remove</a>
                        <label><?php _e('First Name:', 'scholar-book-publisher'); ?></label>
                        <input type="text" name="sbp_chapter_authors[<?php echo $index; ?>][first_name]" 
                               value="<?php echo esc_attr($author['first_name'] ?? ''); ?>" 
                               style="width: 48%; margin-right: 2%;" required>
                        <label><?php _e('Last Name:', 'scholar-book-publisher'); ?></label>
                        <input type="text" name="sbp_chapter_authors[<?php echo $index; ?>][last_name]" 
                               value="<?php echo esc_attr($author['last_name'] ?? ''); ?>" 
                               style="width: 48%;" required>
                    </div>
                <?php endforeach; ?>
            </div>
            <button type="button" class="button" id="sbp_add_chapter_author">+ <?php _e('Add Author', 'scholar-book-publisher'); ?></button>
        </div>
        
        <!-- Page Range -->
        <div class="sbp-field">
            <label><?php _e('Page Range', 'scholar-book-publisher'); ?></label>
            <input type="number" name="sbp_chapter_first_page" value="<?php echo esc_attr($first_page); ?>" 
                   placeholder="<?php _e('First page', 'scholar-book-publisher'); ?>" style="width: 48%; margin-right: 2%;">
            <input type="number" name="sbp_chapter_last_page" value="<?php echo esc_attr($last_page); ?>" 
                   placeholder="<?php _e('Last page', 'scholar-book-publisher'); ?>" style="width: 48%;">
        </div>
        
        <!-- Chapter PDF URL -->
        <div class="sbp-field">
            <label for="sbp_chapter_pdf_url"><?php _e('Chapter PDF URL (Optional)', 'scholar-book-publisher'); ?></label>
            <input type="url" id="sbp_chapter_pdf_url" name="sbp_chapter_pdf_url" 
                   value="<?php echo esc_attr($chapter_pdf); ?>">
        </div>
        
        <!-- Chapter DOI -->
        <div class="sbp-field">
            <label for="sbp_chapter_doi"><?php _e('Chapter DOI (Optional)', 'scholar-book-publisher'); ?></label>
            <input type="text" id="sbp_chapter_doi" name="sbp_chapter_doi" 
                   value="<?php echo esc_attr($chapter_doi); ?>" 
                   placeholder="10.1234/example.chapter">
        </div>
        
        <script>
        jQuery(document).ready(function($) {
            $('#sbp_add_chapter_author').click(function() {
                var index = $('#sbp_chapter_authors_container .sbp-repeater-item').length;
                var html = '<div class="sbp-repeater-item">' +
                    '<a href="#" class="sbp-remove-btn" onclick="jQuery(this).closest(\'.sbp-repeater-item\').remove(); return false;">✕ Remove</a>' +
                    '<label>First Name:</label>' +
                    '<input type="text" name="sbp_chapter_authors[' + index + '][first_name]" style="width: 48%; margin-right: 2%;" required>' +
                    '<label>Last Name:</label>' +
                    '<input type="text" name="sbp_chapter_authors[' + index + '][last_name]" style="width: 48%;" required>' +
                    '</div>';
                $('#sbp_chapter_authors_container').append(html);
            });
        });
        </script>
        <?php
    }
    
    /**
     * Generate hierarchical permalink for chapters
     */
    public function chapter_permalink($post_link, $post) {
        if ($post->post_type === 'scholar_chapter' && strpos($post_link, '%book%') !== false) {
            $parent_book_id = get_post_meta($post->ID, '_sbp_parent_book', true);
            if ($parent_book_id) {
                $parent_book = get_post($parent_book_id);
                if ($parent_book) {
                    $post_link = str_replace('%book%', $parent_book->post_name, $post_link);
                }
            } else {
                // Fallback if no parent book
                $post_link = str_replace('%book%', 'uncategorized', $post_link);
            }
        }
        return $post_link;
    }
    
    /**
     * Save Book Meta
     */
    public function save_book_meta($post_id, $post) {
        if ($post->post_type !== 'scholar_book') return;
        if (!isset($_POST['sbp_book_nonce']) || !wp_verify_nonce($_POST['sbp_book_nonce'], 'sbp_book_meta')) return;
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
        if (!current_user_can('edit_post', $post_id)) return;
        
        // Save simple fields
        $fields = array('sbp_book_cover', 'sbp_book_language', 'sbp_book_publisher', 'sbp_publisher_city', 
                       'sbp_publication_date', 'sbp_isbn', 'sbp_doi', 'sbp_dimensions', 'sbp_price', 'sbp_access_category');
        foreach ($fields as $field) {
            if (isset($_POST[$field])) {
                update_post_meta($post_id, '_' . $field, sanitize_text_field($_POST[$field]));
            }
        }
        
        // Save book subtitle
        if (isset($_POST['sbp_book_subtitle'])) {
            update_post_meta($post_id, '_sbp_book_subtitle', sanitize_text_field($_POST['sbp_book_subtitle']));
        }
        
        // Save book description (allows HTML)
        if (isset($_POST['sbp_book_description'])) {
            update_post_meta($post_id, '_sbp_book_description', wp_kses_post($_POST['sbp_book_description']));
        }
        
        // Save citations count (no longer used but keep for backwards compatibility)
        if (isset($_POST['sbp_citations_count'])) {
            delete_post_meta($post_id, '_sbp_citations_count'); // Remove citations
        }
        
        // Save authors
        if (isset($_POST['sbp_authors'])) {
            update_post_meta($post_id, '_sbp_authors', $_POST['sbp_authors']);
        }
        
        // Save editors
        if (isset($_POST['sbp_editors'])) {
            update_post_meta($post_id, '_sbp_editors', $_POST['sbp_editors']);
        }
        
        // Save PDF fields
        $pdf_available = isset($_POST['sbp_pdf_available']) ? '1' : '0';
        update_post_meta($post_id, '_sbp_pdf_available', $pdf_available);
        
        if ($pdf_available === '1') {
            $pdf_source = isset($_POST['sbp_pdf_source']) ? sanitize_text_field($_POST['sbp_pdf_source']) : 'wordpress';
            update_post_meta($post_id, '_sbp_pdf_source', $pdf_source);
            
            if ($pdf_source === 'wordpress' && isset($_POST['sbp_pdf_wordpress_id'])) {
                update_post_meta($post_id, '_sbp_pdf_wordpress_id', intval($_POST['sbp_pdf_wordpress_id']));
            } elseif ($pdf_source === 'gdrive') {
                if (isset($_POST['sbp_pdf_gdrive_url'])) {
                    update_post_meta($post_id, '_sbp_pdf_gdrive_url', esc_url_raw($_POST['sbp_pdf_gdrive_url']));
                }
                if (isset($_POST['sbp_pdf_gdrive_id'])) {
                    update_post_meta($post_id, '_sbp_pdf_gdrive_id', sanitize_text_field($_POST['sbp_pdf_gdrive_id']));
                }
                if (isset($_POST['sbp_pdf_file_size'])) {
                    update_post_meta($post_id, '_sbp_pdf_file_size', floatval($_POST['sbp_pdf_file_size']));
                }
            }
        }
    }
    
    /**
     * Save Chapter Meta
     */
    public function save_chapter_meta($post_id, $post) {
        if ($post->post_type !== 'scholar_chapter') return;
        if (!isset($_POST['sbp_chapter_nonce']) || !wp_verify_nonce($_POST['sbp_chapter_nonce'], 'sbp_chapter_meta')) return;
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
        if (!current_user_can('edit_post', $post_id)) return;
        
        $fields = array('sbp_parent_book', 'sbp_chapter_first_page', 'sbp_chapter_last_page', 
                       'sbp_chapter_pdf_url', 'sbp_chapter_doi');
        foreach ($fields as $field) {
            if (isset($_POST[$field])) {
                $value = ($field === 'sbp_parent_book' || strpos($field, '_page') !== false) 
                    ? intval($_POST[$field]) 
                    : sanitize_text_field($_POST[$field]);
                update_post_meta($post_id, '_' . $field, $value);
            }
        }
        
        if (isset($_POST['sbp_chapter_authors'])) {
            update_post_meta($post_id, '_sbp_chapter_authors', $_POST['sbp_chapter_authors']);
        }
    }
}
