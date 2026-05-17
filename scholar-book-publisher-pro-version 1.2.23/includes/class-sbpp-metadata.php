<?php
/**
 * Comprehensive Metadata Generator
 * Optimized for: Google Scholar, AI Crawlers (GPT, Claude, Perplexity), Social Media
 * 
 * @package Scholar_Book_Publisher
 * @since 1.2.0
 */

class SBPP_Metadata_Generator {
    
    public function __construct() {
        // Priority 1 - inject before other plugins
        add_action('wp_head', array($this, 'inject_scholar_meta_tags'), 1);
        
        // Add structured data for archive page
        add_action('wp_head', array($this, 'inject_archive_metadata'), 2);
        
        // OpenGraph optimization
        add_filter('language_attributes', array($this, 'add_opengraph_namespace'));
    }
    
    /**
     * Add OpenGraph namespace to HTML tag
     */
    public function add_opengraph_namespace($output) {
        if (is_singular('scholar_book') || is_singular('scholar_chapter')) {
            return $output . ' prefix="og: https://ogp.me/ns# book: https://ogp.me/ns/book#"';
        }
        return $output;
    }
    
    /**
     * Main metadata injection router
     */
    public function inject_scholar_meta_tags() {
        if (is_singular('scholar_book')) {
            $this->generate_book_metadata();
        } elseif (is_singular('scholar_chapter')) {
            $this->generate_chapter_metadata();
        }
    }
    
    /**
     * Archive page metadata for catalog discoverability
     */
    public function inject_archive_metadata() {
        if (is_post_type_archive('scholar_book')) {
            echo "\n<!-- Book Archive Metadata -->\n";
            echo '<meta name="description" content="Browse our complete catalog of scholarly books and academic publications">' . "\n";
            echo '<meta property="og:type" content="website">' . "\n";
            echo '<meta property="og:title" content="Book Catalog">' . "\n";
            echo '<meta property="og:url" content="' . esc_url(get_post_type_archive_link('scholar_book')) . '">' . "\n";
            
            // Schema.org CollectionPage
            $schema = array(
                '@context' => 'https://schema.org',
                '@type' => 'CollectionPage',
                'name' => 'Scholarly Books Catalog',
                'description' => 'Complete catalog of scholarly publications',
                'url' => get_post_type_archive_link('scholar_book')
            );
            echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_SLASHES) . '</script>' . "\n";
        }
    }
    
    /**
     * Comprehensive book metadata generation
     * Optimized for: Google Scholar, AI crawlers, Social Media
     */
    private function generate_book_metadata() {
        global $post;
        
        // Get all metadata
        $subtitle = get_post_meta($post->ID, '_sbpp_book_subtitle', true);
        $description = get_post_meta($post->ID, '_sbpp_book_description', true);
        $authors = get_post_meta($post->ID, '_sbpp_authors', true);
        $editors = get_post_meta($post->ID, '_sbpp_editors', true);
        $publisher = get_post_meta($post->ID, '_sbpp_book_publisher', true);
        $publisher_city = get_post_meta($post->ID, '_sbpp_publisher_city', true);
        $pub_date = get_post_meta($post->ID, '_sbpp_publication_date', true);
        $isbn = get_post_meta($post->ID, '_sbpp_isbn', true);
        $doi = get_post_meta($post->ID, '_sbpp_doi', true);
        $language = get_post_meta($post->ID, '_sbpp_book_language', true);
        $pages = get_post_meta($post->ID, '_sbpp_page_count', true);
        $access_category = get_post_meta($post->ID, '_sbpp_access_category', true);
        
        // Cover image
        $cover_id = get_post_meta($post->ID, '_sbpp_book_cover', true);
        $cover_url = $cover_id ? wp_get_attachment_url($cover_id) : '';
        if (!$cover_url && has_post_thumbnail()) {
            $cover_url = get_the_post_thumbnail_url($post->ID, 'large');
        }
        
        // PDF URL (only for open access)
        $pdf_url = '';
        $pdf_available = get_post_meta($post->ID, '_sbpp_pdf_available', true);
        if ($pdf_available && $access_category === 'open') {
            $pdf_source = get_post_meta($post->ID, '_sbpp_pdf_source', true);
            if ($pdf_source === 'wordpress') {
                $pdf_id = get_post_meta($post->ID, '_sbpp_pdf_wordpress_id', true);
                if ($pdf_id) $pdf_url = wp_get_attachment_url($pdf_id);
            } elseif ($pdf_source === 'gdrive') {
                $pdf_gdrive_id = get_post_meta($post->ID, '_sbpp_pdf_gdrive_id', true);
                if ($pdf_gdrive_id) $pdf_url = home_url('/scholar-pdf/' . $post->ID . '/' . $post->post_name . '.pdf');
            }
        }
        
        $year = $pub_date ? date('Y', strtotime($pub_date)) : '';
        $full_title = get_the_title();
        if ($subtitle) $full_title .= ': ' . $subtitle;
        
        // Use description or excerpt
        $abstract = $description ? $description : get_the_excerpt();
        
        echo "\n<!-- ===================================== -->\n";
        echo "<!-- Comprehensive Metadata v1.2.0         -->\n";
        echo "<!-- Google Scholar, AI Crawlers, Social   -->\n";
        echo "<!-- ===================================== -->\n\n";
        
        // ============================================
        // 1. GOOGLE SCHOLAR META TAGS (Highwire Press)
        // ============================================
        echo "<!-- Google Scholar Citation Tags -->\n";
        echo '<meta name="citation_title" content="' . esc_attr($full_title) . '">' . "\n";
        
        // For books, also add citation_book_title (REQUIRED by Google Scholar for book indexing)
        echo '<meta name="citation_book_title" content="' . esc_attr(get_the_title()) . '">' . "\n";
        
        if ($subtitle) echo '<meta name="citation_subtitle" content="' . esc_attr($subtitle) . '">' . "\n";
        
        // Authors (required by Google Scholar)
        if (!empty($authors) && is_array($authors)) {
            foreach ($authors as $author) {
                if (!empty($author['last_name']) && !empty($author['first_name'])) {
                    echo '<meta name="citation_author" content="' . esc_attr($author['last_name'] . ', ' . $author['first_name']) . '">' . "\n";
                    // Institution helps with author disambiguation
                    if ($publisher) {
                        echo '<meta name="citation_author_institution" content="' . esc_attr($publisher) . '">' . "\n";
                    }
                }
            }
        }
        
        // Editors (if book is edited)
        if (!empty($editors) && is_array($editors)) {
            foreach ($editors as $editor) {
                if (!empty($editor['first_name']) && !empty($editor['last_name'])) {
                    echo '<meta name="citation_editor" content="' . esc_attr($editor['last_name'] . ', ' . $editor['first_name']) . '">' . "\n";
                }
            }
        }
        
        // Publication details
        if ($pub_date) {
            echo '<meta name="citation_publication_date" content="' . esc_attr($pub_date) . '">' . "\n";
            // Online date (when it became available online) - important for Google Scholar
            echo '<meta name="citation_online_date" content="' . esc_attr($pub_date) . '">' . "\n";
        }
        if ($year) echo '<meta name="citation_year" content="' . esc_attr($year) . '">' . "\n";
        if ($publisher) echo '<meta name="citation_publisher" content="' . esc_attr($publisher) . '">' . "\n";
        if ($isbn) echo '<meta name="citation_isbn" content="' . esc_attr($isbn) . '">' . "\n";
        if ($doi) echo '<meta name="citation_doi" content="' . esc_attr($doi) . '">' . "\n";
        if ($language) echo '<meta name="citation_language" content="' . esc_attr($language) . '">' . "\n";
        if ($pages) echo '<meta name="citation_pages" content="' . esc_attr($pages) . '">' . "\n";
        
        // URLs (critical for indexing)
        echo '<meta name="citation_abstract_html_url" content="' . esc_url(get_permalink()) . '">' . "\n";
        echo '<meta name="citation_fulltext_html_url" content="' . esc_url(get_permalink()) . '">' . "\n";
        if ($pdf_url) {
            echo '<meta name="citation_pdf_url" content="' . esc_url($pdf_url) . '">' . "\n";
        }
        
        // ============================================
        // 2. DUBLIN CORE (Broad compatibility)
        // ============================================
        echo "\n<!-- Dublin Core Metadata -->\n";
        echo '<meta name="DC.title" content="' . esc_attr($full_title) . '">' . "\n";
        if (!empty($authors) && is_array($authors)) {
            foreach ($authors as $author) {
                if (!empty($author['first_name']) && !empty($author['last_name'])) {
                    echo '<meta name="DC.creator" content="' . esc_attr($author['first_name'] . ' ' . $author['last_name']) . '">' . "\n";
                }
            }
        }
        if ($publisher) echo '<meta name="DC.publisher" content="' . esc_attr($publisher) . '">' . "\n";
        if ($pub_date) echo '<meta name="DC.date" content="' . esc_attr($pub_date) . '">' . "\n";
        if ($isbn) echo '<meta name="DC.identifier" content="ISBN:' . esc_attr($isbn) . '">' . "\n";
        if ($doi) echo '<meta name="DC.identifier" content="DOI:' . esc_attr($doi) . '">' . "\n";
        echo '<meta name="DC.type" content="Book">' . "\n";
        echo '<meta name="DC.format" content="text/html">' . "\n";
        if ($language) echo '<meta name="DC.language" content="' . esc_attr($language) . '">' . "\n";
        if ($abstract) echo '<meta name="DC.description" content="' . esc_attr(wp_strip_all_tags($abstract)) . '">' . "\n";
        echo '<meta name="DC.rights" content="' . ($access_category === 'open' ? 'Open Access' : 'All rights reserved') . '">' . "\n";
        
        // ============================================
        // 3. OPEN GRAPH (Facebook, LinkedIn, WhatsApp)
        // ============================================
        echo "\n<!-- Open Graph Protocol -->\n";
        echo '<meta property="og:type" content="book">' . "\n";
        echo '<meta property="og:title" content="' . esc_attr(get_the_title()) . '">' . "\n";
        if ($subtitle) echo '<meta property="og:subtitle" content="' . esc_attr($subtitle) . '">' . "\n";
        echo '<meta property="og:url" content="' . esc_url(get_permalink()) . '">' . "\n";
        echo '<meta property="og:site_name" content="' . esc_attr(get_bloginfo('name')) . '">' . "\n";
        if ($abstract) echo '<meta property="og:description" content="' . esc_attr(wp_strip_all_tags(wp_trim_words($abstract, 30))) . '">' . "\n";
        if ($cover_url) echo '<meta property="og:image" content="' . esc_url($cover_url) . '">' . "\n";
        if ($cover_url) echo '<meta property="og:image:secure_url" content="' . esc_url($cover_url) . '">' . "\n";
        echo '<meta property="og:image:type" content="image/jpeg">' . "\n";
        
        // Book-specific OG tags
        if ($isbn) echo '<meta property="book:isbn" content="' . esc_attr($isbn) . '">' . "\n";
        if ($pub_date) echo '<meta property="book:release_date" content="' . esc_attr($pub_date) . '">' . "\n";
        if (!empty($authors) && is_array($authors)) {
            foreach ($authors as $author) {
                if (!empty($author['first_name']) && !empty($author['last_name'])) {
                    echo '<meta property="book:author" content="' . esc_attr($author['first_name'] . ' ' . $author['last_name']) . '">' . "\n";
                }
            }
        }
        
        // ============================================
        // 4. TWITTER CARD (Twitter/X)
        // ============================================
        echo "\n<!-- Twitter Card -->\n";
        echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
        echo '<meta name="twitter:title" content="' . esc_attr(get_the_title()) . '">' . "\n";
        if ($abstract) echo '<meta name="twitter:description" content="' . esc_attr(wp_strip_all_tags(wp_trim_words($abstract, 30))) . '">' . "\n";
        if ($cover_url) echo '<meta name="twitter:image" content="' . esc_url($cover_url) . '">' . "\n";
        echo '<meta name="twitter:label1" content="Written by">' . "\n";
        if (!empty($authors) && is_array($authors)) {
            $author_names = array();
            foreach ($authors as $author) {
                if (!empty($author['first_name']) && !empty($author['last_name'])) {
                    $author_names[] = $author['first_name'] . ' ' . $author['last_name'];
                }
            }
            if (!empty($author_names)) {
                echo '<meta name="twitter:data1" content="' . esc_attr(implode(', ', $author_names)) . '">' . "\n";
            }
        }
        if ($publisher) {
            echo '<meta name="twitter:label2" content="Published by">' . "\n";
            echo '<meta name="twitter:data2" content="' . esc_attr($publisher) . '">' . "\n";
        }
        
        // ============================================
        // 5. AI CRAWLER OPTIMIZATION
        // ============================================
        echo "\n<!-- AI Crawler Optimization -->\n";
        // Robots meta
        echo '<meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">' . "\n";
        echo '<meta name="googlebot" content="index, follow">' . "\n";
        echo '<meta name="bingbot" content="index, follow">' . "\n";
        
        // AI-specific hints
        echo '<meta name="article:published_time" content="' . esc_attr($pub_date) . '">' . "\n";
        echo '<meta name="article:author" content="' . esc_attr(!empty($authors) && is_array($authors) ? $authors[0]['first_name'] . ' ' . $authors[0]['last_name'] : '') . '">' . "\n";
        
        // General description for AI understanding
        $meta_description = $abstract ? wp_strip_all_tags(wp_trim_words($abstract, 40)) : 
                           'Scholarly book: ' . $full_title . ' by ' . (!empty($authors) ? $authors[0]['first_name'] . ' ' . $authors[0]['last_name'] : 'various authors');
        echo '<meta name="description" content="' . esc_attr($meta_description) . '">' . "\n";
        
        // Keywords (helpful for AI)
        $categories = wp_get_post_terms($post->ID, 'book_category', array('fields' => 'names'));
        if (!empty($categories) && !is_wp_error($categories)) {
            echo '<meta name="keywords" content="' . esc_attr(implode(', ', $categories) . ', ' . $full_title) . '">' . "\n";
        }
        
        // ============================================
        // 6. SCHEMA.ORG JSON-LD (Google, AI, Rich Results)
        // ============================================
        echo "\n<!-- Schema.org Structured Data -->\n";
        $schema = array(
            '@context' => 'https://schema.org',
            '@type' => 'Book',
            '@id' => get_permalink() . '#book',
            'url' => get_permalink(),
            'name' => get_the_title(),
            'headline' => $full_title,
            'alternativeHeadline' => $subtitle,
            'inLanguage' => $language ? $language : get_locale(),
            'bookFormat' => 'https://schema.org/Hardcover',
        );
        
        // Abstract/Description
        if ($abstract) {
            $schema['abstract'] = wp_strip_all_tags($abstract);
            $schema['description'] = wp_strip_all_tags(wp_trim_words($abstract, 50));
        }
        
        // Authors
        if (!empty($authors) && is_array($authors)) {
            $schema['author'] = array();
            foreach ($authors as $author) {
                if (!empty($author['first_name']) && !empty($author['last_name'])) {
                    $schema['author'][] = array(
                        '@type' => 'Person',
                        'name' => $author['first_name'] . ' ' . $author['last_name'],
                        'givenName' => $author['first_name'],
                        'familyName' => $author['last_name']
                    );
                }
            }
        }
        
        // Editors
        if (!empty($editors) && is_array($editors)) {
            $schema['editor'] = array();
            foreach ($editors as $editor) {
                if (!empty($editor['first_name']) && !empty($editor['last_name'])) {
                    $schema['editor'][] = array(
                        '@type' => 'Person',
                        'name' => $editor['first_name'] . ' ' . $editor['last_name']
                    );
                }
            }
        }
        
        // Publisher
        if ($publisher) {
            $pub_schema = array(
                '@type' => 'Organization',
                'name' => $publisher
            );
            if ($publisher_city) {
                $pub_schema['address'] = array(
                    '@type' => 'PostalAddress',
                    'addressLocality' => $publisher_city
                );
            }
            $schema['publisher'] = $pub_schema;
        }
        
        // Publication date
        if ($pub_date) {
            $schema['datePublished'] = $pub_date;
            $schema['copyrightYear'] = $year;
        }
        
        // Identifiers
        if ($isbn) $schema['isbn'] = $isbn;
        if ($doi) $schema['identifier'] = array(
            '@type' => 'PropertyValue',
            'propertyID' => 'DOI',
            'value' => $doi
        );
        
        // Image/Cover
        if ($cover_url) {
            $schema['image'] = array(
                '@type' => 'ImageObject',
                'url' => $cover_url,
                'representativeOfPage' => true
            );
        }
        
        // Number of pages
        if ($pages) $schema['numberOfPages'] = intval($pages);
        
        // PDF availability
        if ($pdf_url) {
            $schema['workExample'] = array(
                '@type' => 'Book',
                'bookFormat' => 'https://schema.org/EBook',
                'url' => $pdf_url,
                'fileFormat' => 'application/pdf'
            );
        }
        
        // Access mode
        $schema['isAccessibleForFree'] = ($access_category === 'open');
        if ($access_category === 'open') {
            $schema['conditionsOfAccess'] = 'Open Access';
        }
        
        // Categories/subjects
        $categories = wp_get_post_terms($post->ID, 'book_category', array('fields' => 'names'));
        if (!empty($categories) && !is_wp_error($categories)) {
            $schema['about'] = array();
            foreach ($categories as $cat) {
                $schema['about'][] = array(
                    '@type' => 'Thing',
                    'name' => $cat
                );
            }
        }
        
        // Aggregate rating (if available)
        $views = get_post_meta($post->ID, '_sbpp_views_count', true);
        if ($views && $views > 0) {
            $schema['interactionStatistic'] = array(
                '@type' => 'InteractionCounter',
                'interactionType' => 'https://schema.org/ReadAction',
                'userInteractionCount' => intval($views)
            );
        }
        
        echo '<script type="application/ld+json">' . "\n";
        echo wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        echo "\n</script>\n";
        
        // ============================================
        // 7. ADDITIONAL CRAWLER HINTS
        // ============================================
        echo "\n<!-- Additional Crawler Optimization -->\n";
        // NOTE: <link rel="canonical"> is intentionally omitted here.
        // SBPP_SEO_Migration::add_canonical_meta() outputs the canonical at wp_head
        // priority 1 for all book/chapter/archive pages. Outputting it twice would
        // send conflicting signals to Googlebot and other crawlers.
        if ($pdf_url) {
            echo '<link rel="alternate" type="application/pdf" href="' . esc_url($pdf_url) . '">' . "\n";
        }
        
        echo "\n<!-- End Comprehensive Metadata -->\n\n";
    }
    
    /**
     * Chapter metadata (inherits book context)
     */
    private function generate_chapter_metadata() {
        global $post;
        
        $parent_book_id = get_post_meta($post->ID, '_sbpp_parent_book', true);
        if (!$parent_book_id) return;
        
        $book = get_post($parent_book_id);
        if (!$book) return;
        
        // Get chapter-specific data
        $chapter_number = get_post_meta($post->ID, '_sbpp_chapter_number', true);
        $authors = get_post_meta($post->ID, '_sbpp_chapter_authors', true);
        $start_page = get_post_meta($post->ID, '_sbpp_chapter_start_page', true);
        $end_page = get_post_meta($post->ID, '_sbpp_chapter_end_page', true);
        
        // Get book data
        $book_authors = get_post_meta($parent_book_id, '_sbpp_authors', true);
        $publisher = get_post_meta($parent_book_id, '_sbpp_book_publisher', true);
        $pub_date = get_post_meta($parent_book_id, '_sbpp_publication_date', true);
        $isbn = get_post_meta($parent_book_id, '_sbpp_isbn', true);
        
        echo "\n<!-- Chapter Metadata (Part of Book) -->\n";
        
        // Google Scholar chapter tags
        echo '<meta name="citation_title" content="' . esc_attr(get_the_title()) . '">' . "\n";
        echo '<meta name="citation_book_title" content="' . esc_attr($book->post_title) . '">' . "\n";
        if ($chapter_number) echo '<meta name="citation_chapter_number" content="' . esc_attr($chapter_number) . '">' . "\n";
        
        // Chapter authors (or fall back to book authors)
        if (!empty($authors) && is_array($authors)) {
            foreach ($authors as $author) {
                if (!empty($author['last_name']) && !empty($author['first_name'])) {
                    echo '<meta name="citation_author" content="' . esc_attr($author['last_name'] . ', ' . $author['first_name']) . '">' . "\n";
                }
            }
        } elseif (!empty($book_authors) && is_array($book_authors)) {
            foreach ($book_authors as $author) {
                if (!empty($author['last_name']) && !empty($author['first_name'])) {
                    echo '<meta name="citation_author" content="' . esc_attr($author['last_name'] . ', ' . $author['first_name']) . '">' . "\n";
                }
            }
        }
        
        if ($start_page && $end_page) {
            echo '<meta name="citation_firstpage" content="' . esc_attr($start_page) . '">' . "\n";
            echo '<meta name="citation_lastpage" content="' . esc_attr($end_page) . '">' . "\n";
        }
        if ($publisher) echo '<meta name="citation_publisher" content="' . esc_attr($publisher) . '">' . "\n";
        if ($pub_date) echo '<meta name="citation_publication_date" content="' . esc_attr($pub_date) . '">' . "\n";
        if ($isbn) echo '<meta name="citation_isbn" content="' . esc_attr($isbn) . '">' . "\n";
        echo '<meta name="citation_fulltext_html_url" content="' . esc_url(get_permalink()) . '">' . "\n";
        
        // Schema.org for chapter
        $schema = array(
            '@context' => 'https://schema.org',
            '@type' => 'Chapter',
            'name' => get_the_title(),
            'url' => get_permalink(),
            'position' => $chapter_number,
            'isPartOf' => array(
                '@type' => 'Book',
                '@id' => get_permalink($parent_book_id) . '#book',
                'name' => $book->post_title,
                'url' => get_permalink($parent_book_id)
            )
        );
        
        if ($start_page) $schema['pageStart'] = intval($start_page);
        if ($end_page) $schema['pageEnd'] = intval($end_page);
        
        echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_SLASHES) . '</script>' . "\n";
        echo "<!-- End Chapter Metadata -->\n\n";
    }
}

// NOTE: Instantiated by Scholar_Book_Publisher::init() — do NOT instantiate here.
