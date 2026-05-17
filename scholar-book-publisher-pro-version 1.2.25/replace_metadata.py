import re

with open("includes/class-sbpp-metadata.php", "r") as f:
    content = f.read()

# 1. Update inject_scholar_meta_tags
old_inject = """    public function inject_scholar_meta_tags() {
        if (is_singular('scholar_book')) {
            $this->generate_book_metadata();
        } elseif (is_singular('scholar_chapter')) {
            $this->generate_chapter_metadata();
        }
    }"""
new_inject = """    public function inject_scholar_meta_tags() {
        // Strict Single Page Loading
        if (!is_singular('scholar_book') && !is_singular('scholar_chapter')) {
            return;
        }

        if (is_singular('scholar_book')) {
            $this->generate_book_metadata();
        } elseif (is_singular('scholar_chapter')) {
            $this->generate_chapter_metadata();
        }
    }"""
content = content.replace(old_inject, new_inject)

# 2. Update Publisher default in generate_book_metadata
content = content.replace(
    "$publisher = get_post_meta($post->ID, '_sbpp_book_publisher', true);",
    "$publisher_meta = get_post_meta($post->ID ?? 0, '_sbpp_book_publisher', true);\n        $publisher = !empty($publisher_meta) ? $publisher_meta : 'Southeast Asian Publishing';"
)
content = content.replace(
    "$pub_date = get_post_meta($post->ID, '_sbpp_publication_date', true);",
    "$pub_date = get_post_meta($post->ID ?? 0, '_sbpp_publication_date', true);"
)

# Replace other $post->ID occurrences in get_post_meta in generate_book_metadata with null checks
for meta_key in ['_sbpp_book_subtitle', '_sbpp_book_description', '_sbpp_authors', '_sbpp_editors', '_sbpp_publisher_city', '_sbpp_isbn', '_sbpp_doi', '_sbpp_book_language', '_sbpp_page_count', '_sbpp_access_category', '_sbpp_book_cover', '_sbpp_pdf_available', '_sbpp_pdf_source', '_sbpp_pdf_wordpress_id', '_sbpp_pdf_gdrive_id']:
    content = content.replace(
        f"$post->ID, '{meta_key}'",
        f"$post->ID ?? 0, '{meta_key}'"
    )

# 3. Update abstract and year logic in generate_book_metadata
old_abstract_logic = """        $year = $pub_date ? date('Y', strtotime($pub_date)) : '';
        $full_title = get_the_title();
        if ($subtitle) $full_title .= ': ' . $subtitle;
        
        // Use description or excerpt
        $abstract = $description ? $description : get_the_excerpt();"""
new_abstract_logic = """        $year = !empty($pub_date) ? date('Y', strtotime($pub_date)) : '';
        $full_title = get_the_title($post->ID ?? 0);
        if (!empty($subtitle)) $full_title .= ': ' . $subtitle;
        
        // Strict Abstract Cleaning
        $raw_abstract = !empty($description) ? $description : get_the_excerpt($post->ID ?? 0);
        $abstract = !empty($raw_abstract) ? wp_strip_all_tags(trim((string)$raw_abstract), true) : '';"""
content = content.replace(old_abstract_logic, new_abstract_logic)

# 4. Update publication details section
old_pub_details = """        // Publication details
        if ($pub_date) {
            echo '<meta name="citation_publication_date" content="' . esc_attr($pub_date) . '">' . "\\n";
            // Online date (when it became available online) - important for Google Scholar
            echo '<meta name="citation_online_date" content="' . esc_attr($pub_date) . '">' . "\\n";
        }
        if ($year) echo '<meta name="citation_year" content="' . esc_attr($year) . '">' . "\\n";
        if ($publisher) echo '<meta name="citation_publisher" content="' . esc_attr($publisher) . '">' . "\\n";
        if ($isbn) echo '<meta name="citation_isbn" content="' . esc_attr($isbn) . '">' . "\\n";
        if ($doi) echo '<meta name="citation_doi" content="' . esc_attr($doi) . '">' . "\\n";
        if ($language) echo '<meta name="citation_language" content="' . esc_attr($language) . '">' . "\\n";
        if ($pages) echo '<meta name="citation_pages" content="' . esc_attr($pages) . '">' . "\\n";
        if ($abstract) echo '<meta name="citation_abstract" content="' . esc_attr(wp_strip_all_tags($abstract)) . '">' . "\\n";"""
new_pub_details = """        // Publication details
        if (!empty($year)) {
            echo '<meta name="citation_publication_date" content="' . esc_attr($year) . '">' . "\\n";
            echo '<meta name="citation_online_date" content="' . esc_attr($year) . '">' . "\\n";
            echo '<meta name="citation_year" content="' . esc_attr($year) . '">' . "\\n";
        }
        if (!empty($publisher)) {
            echo '<meta name="citation_publisher" content="' . esc_attr($publisher) . '">' . "\\n";
        }
        if (!empty($isbn)) echo '<meta name="citation_isbn" content="' . esc_attr($isbn) . '">' . "\\n";
        if (!empty($doi)) echo '<meta name="citation_doi" content="' . esc_attr($doi) . '">' . "\\n";
        if (!empty($language)) echo '<meta name="citation_language" content="' . esc_attr($language) . '">' . "\\n";
        if (!empty($pages)) echo '<meta name="citation_pages" content="' . esc_attr($pages) . '">' . "\\n";
        if (!empty($abstract)) echo '<meta name="citation_abstract" content="' . esc_attr($abstract) . '">' . "\\n";"""
content = content.replace(old_pub_details, new_pub_details)

# Let's also fix citation_abstract occurrences in Dublin Core, Open Graph, etc.
# Actually, since $abstract is already cleaned, we can just use $abstract
content = content.replace("wp_strip_all_tags($abstract)", "$abstract")

# Now update generate_chapter_metadata
# Publisher default
content = content.replace(
    "$publisher = get_post_meta($parent_book_id, '_sbpp_book_publisher', true);",
    "$publisher_meta = get_post_meta($parent_book_id, '_sbpp_book_publisher', true);\n        $publisher = !empty($publisher_meta) ? $publisher_meta : 'Southeast Asian Publishing';"
)

# Update publication details in chapter
old_chapter_pub = """        if ($start_page && $end_page) {
            echo '<meta name="citation_firstpage" content="' . esc_attr($start_page) . '">' . "\\n";
            echo '<meta name="citation_lastpage" content="' . esc_attr($end_page) . '">' . "\\n";
        }
        if ($publisher) echo '<meta name="citation_publisher" content="' . esc_attr($publisher) . '">' . "\\n";
        if ($pub_date) echo '<meta name="citation_publication_date" content="' . esc_attr($pub_date) . '">' . "\\n";
        if ($isbn) echo '<meta name="citation_isbn" content="' . esc_attr($isbn) . '">' . "\\n";"""

new_chapter_pub = """        if (!empty($start_page) && !empty($end_page)) {
            echo '<meta name="citation_firstpage" content="' . esc_attr($start_page) . '">' . "\\n";
            echo '<meta name="citation_lastpage" content="' . esc_attr($end_page) . '">' . "\\n";
        }
        if (!empty($publisher)) echo '<meta name="citation_publisher" content="' . esc_attr($publisher) . '">' . "\\n";
        $year_only = !empty($pub_date) ? date('Y', strtotime($pub_date)) : '';
        if (!empty($year_only)) {
            echo '<meta name="citation_publication_date" content="' . esc_attr($year_only) . '">' . "\\n";
            echo '<meta name="citation_year" content="' . esc_attr($year_only) . '">' . "\\n";
        }
        if (!empty($isbn)) echo '<meta name="citation_isbn" content="' . esc_attr($isbn) . '">' . "\\n";"""
content = content.replace(old_chapter_pub, new_chapter_pub)

# Prepend a null check on $post globally for these two functions
content = content.replace(
    "private function generate_book_metadata() {\n        global $post;",
    "private function generate_book_metadata() {\n        global $post;\n        if ( empty( $post ) || empty( $post->ID ) ) return;"
)
content = content.replace(
    "private function generate_chapter_metadata() {\n        global $post;",
    "private function generate_chapter_metadata() {\n        global $post;\n        if ( empty( $post ) || empty( $post->ID ) ) return;"
)

with open("includes/class-sbpp-metadata.php", "w") as f:
    f.write(content)

