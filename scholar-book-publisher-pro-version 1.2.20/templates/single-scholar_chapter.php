<?php
/**
 * Template for displaying single book chapter
 * 
 * Place this file in your theme directory as: single-scholar_chapter.php
 * 
 * @package Scholar_Book_Publisher
 * @version 1.2.13
 */

get_header(); ?>

<style>
    /* Scholar Chapter - Clean Reading Experience */
    :root {
        --chapter-primary: #1a1a1a;
        --chapter-secondary: #4a4a4a;
        --chapter-accent: #8b4513;
        --chapter-bg: #fafaf8;
        --chapter-paper: #ffffff;
        --chapter-border: #e5e5e0;
    }

    .scholar-chapter-container {
        max-width: 900px;
        margin: 0 auto;
        padding: clamp(1.5rem, 4vw, 3rem);
        background: var(--chapter-bg);
        font-family: 'Charter', 'Georgia', serif;
        color: var(--chapter-primary);
        line-height: 1.75;
    }

    /* Breadcrumb */
    .scholar-chapter-breadcrumb {
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid var(--chapter-border);
    }

    .scholar-breadcrumb-list {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        list-style: none;
        padding: 0;
        margin: 0;
        font-family: 'Libre Franklin', sans-serif;
        font-size: 0.875rem;
        color: var(--chapter-secondary);
    }

    .scholar-breadcrumb-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .scholar-breadcrumb-link {
        color: var(--chapter-accent);
        text-decoration: none;
        transition: color 0.2s;
    }

    .scholar-breadcrumb-link:hover {
        color: var(--chapter-primary);
    }

    .scholar-breadcrumb-separator {
        color: var(--chapter-border);
    }

    /* Parent Book Info */
    .scholar-parent-book {
        background: linear-gradient(135deg, #f9f9f7 0%, #f0f0ed 100%);
        border-left: 4px solid var(--chapter-accent);
        padding: 1.5rem 2rem;
        margin-bottom: 3rem;
        border-radius: 0 2px 2px 0;
    }

    .scholar-parent-label {
        font-family: 'Libre Franklin', sans-serif;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: var(--chapter-accent);
        margin-bottom: 0.5rem;
    }

    .scholar-parent-title {
        font-family: 'Libre Baskerville', 'Baskerville', serif;
        font-size: 1.25rem;
        font-weight: 600;
        margin: 0;
        line-height: 1.4;
    }

    .scholar-parent-title a {
        color: var(--chapter-primary);
        text-decoration: none;
        transition: color 0.3s;
    }

    .scholar-parent-title a:hover {
        color: var(--chapter-accent);
    }

    /* Chapter Header */
    .scholar-chapter-header {
        margin-bottom: 3rem;
        padding-bottom: 2rem;
        border-bottom: 3px solid var(--chapter-accent);
    }

    .scholar-chapter-number {
        font-family: 'Libre Franklin', sans-serif;
        font-size: 0.875rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: var(--chapter-accent);
        margin-bottom: 1rem;
    }

    .scholar-chapter-title {
        font-family: 'Libre Baskerville', 'Baskerville', serif;
        font-size: clamp(2rem, 5vw, 3rem);
        font-weight: 700;
        line-height: 1.2;
        margin: 0 0 1.5rem 0;
        color: var(--chapter-primary);
        letter-spacing: -0.02em;
    }

    .scholar-chapter-authors {
        font-family: 'Charter', 'Georgia', serif;
        font-size: 1.125rem;
        font-style: italic;
        color: var(--chapter-secondary);
        margin-bottom: 1rem;
    }

    .scholar-chapter-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        font-family: 'Libre Franklin', sans-serif;
        font-size: 0.875rem;
        color: var(--chapter-secondary);
    }

    .scholar-chapter-meta-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .scholar-chapter-meta-icon {
        color: var(--chapter-accent);
    }

    /* Chapter Content */
    .scholar-chapter-content {
        background: var(--chapter-paper);
        padding: 3rem;
        border: 1px solid var(--chapter-border);
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        margin-bottom: 3rem;
    }

    .scholar-chapter-content h2 {
        font-family: 'Libre Baskerville', 'Baskerville', serif;
        font-size: 1.75rem;
        font-weight: 700;
        margin: 2.5rem 0 1rem 0;
        color: var(--chapter-primary);
    }

    .scholar-chapter-content h3 {
        font-family: 'Libre Baskerville', 'Baskerville', serif;
        font-size: 1.375rem;
        font-weight: 600;
        margin: 2rem 0 0.75rem 0;
        color: var(--chapter-primary);
    }

    .scholar-chapter-content p {
        margin-bottom: 1.5em;
        text-align: justify;
        hyphens: auto;
    }

    .scholar-chapter-content p:first-of-type::first-letter {
        font-family: 'Libre Baskerville', 'Baskerville', serif;
        float: left;
        font-size: 4rem;
        line-height: 0.9;
        margin: 0.05em 0.15em 0 0;
        color: var(--chapter-accent);
        font-weight: 700;
    }

    /* Chapter Actions */
    .scholar-chapter-actions {
        display: flex;
        justify-content: space-between;
        gap: 1rem;
        margin-top: 3rem;
        padding-top: 2rem;
        border-top: 2px solid var(--chapter-border);
    }

    @media (max-width: 600px) {
        .scholar-chapter-actions {
            flex-direction: column;
        }
    }

    .scholar-chapter-btn {
        flex: 1;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 1rem 1.5rem;
        font-family: 'Libre Franklin', sans-serif;
        font-size: 0.95rem;
        font-weight: 600;
        text-decoration: none;
        border: 2px solid var(--chapter-accent);
        border-radius: 2px;
        transition: all 0.3s ease;
    }

    .scholar-chapter-btn-primary {
        background: var(--chapter-accent);
        color: white;
    }

    .scholar-chapter-btn-primary:hover {
        background: #a0522d;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(139, 69, 19, 0.3);
    }

    .scholar-chapter-btn-secondary {
        background: transparent;
        color: var(--chapter-accent);
    }

    .scholar-chapter-btn-secondary:hover {
        background: var(--chapter-accent);
        color: white;
    }

    /* Citation */
    .scholar-chapter-citation {
        background: #f9f9f7;
        border-left: 4px solid var(--chapter-accent);
        padding: 1.5rem 2rem;
        margin: 2rem 0;
        font-family: 'IBM Plex Mono', 'Courier New', monospace;
        font-size: 0.875rem;
        line-height: 1.6;
    }

    .scholar-chapter-citation h4 {
        font-family: 'Libre Franklin', sans-serif;
        font-size: 0.85rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        margin: 0 0 1rem 0;
        color: var(--chapter-accent);
    }

    /* Navigation */
    .scholar-chapter-navigation {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
        margin-top: 3rem;
    }

    @media (max-width: 600px) {
        .scholar-chapter-navigation {
            grid-template-columns: 1fr;
        }
    }

    .scholar-nav-item {
        background: var(--chapter-paper);
        border: 1px solid var(--chapter-border);
        padding: 1.5rem;
        text-decoration: none;
        transition: all 0.3s ease;
        border-radius: 2px;
    }

    .scholar-nav-item:hover {
        border-color: var(--chapter-accent);
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }

    .scholar-nav-label {
        font-family: 'Libre Franklin', sans-serif;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: var(--chapter-secondary);
        margin-bottom: 0.5rem;
    }

    .scholar-nav-title {
        font-family: 'Libre Baskerville', 'Baskerville', serif;
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--chapter-primary);
        line-height: 1.3;
    }

    .scholar-nav-item:hover .scholar-nav-title {
        color: var(--chapter-accent);
    }

    /* Animations */
    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .scholar-chapter-header {
        animation: slideInUp 0.6s ease-out;
    }

    .scholar-chapter-content {
        animation: slideInUp 0.6s ease-out 0.1s backwards;
    }
</style>

<?php while (have_posts()) : the_post(); 
    // Get chapter metadata
    $parent_book_id = get_post_meta(get_the_ID(), '_sbpp_parent_book', true);
    $first_page = get_post_meta(get_the_ID(), '_sbpp_chapter_first_page', true);
    $last_page = get_post_meta(get_the_ID(), '_sbpp_chapter_last_page', true);
    $chapter_authors = get_post_meta(get_the_ID(), '_sbpp_chapter_authors', true);
    $chapter_pdf = get_post_meta(get_the_ID(), '_sbpp_chapter_pdf_url', true);
    $chapter_doi = get_post_meta(get_the_ID(), '_sbpp_chapter_doi', true);
    
    // Get parent book data
    $book_title = '';
    $book_publisher = '';
    $book_year = '';
    if ($parent_book_id) {
        $book_title = get_the_title($parent_book_id);
        $book_publisher = get_post_meta($parent_book_id, '_sbpp_book_publisher', true);
        $book_pub_date = get_post_meta($parent_book_id, '_sbpp_publication_date', true);
        $book_year = $book_pub_date ? date('Y', strtotime($book_pub_date)) : '';
    }
    
    // Get chapter number (based on page order)
    $all_chapters = new WP_Query(array(
        'post_type' => 'scholar_chapter',
        'posts_per_page' => -1,
        'meta_query' => array(
            array(
                'key' => '_sbpp_parent_book',
                'value' => $parent_book_id
            )
        ),
        'orderby' => 'meta_value_num',
        'meta_key' => '_sbpp_chapter_first_page',
        'order' => 'ASC'
    ));
    
    $chapter_number = 0;
    $current_index = 0;
    if ($all_chapters->have_posts()) {
        $index = 1;
        while ($all_chapters->have_posts()) {
            $all_chapters->the_post();
            if (get_the_ID() === get_queried_object_id()) {
                $chapter_number = $index;
                $current_index = $index - 1;
            }
            $index++;
        }
        wp_reset_postdata();
    }
?>

<div class="scholar-chapter-container">
    
    <!-- Breadcrumb -->
    <nav class="scholar-chapter-breadcrumb" aria-label="Breadcrumb">
        <ol class="scholar-breadcrumb-list">
            <li class="scholar-breadcrumb-item">
                <a href="<?php echo get_post_type_archive_link('scholar_book'); ?>" class="scholar-breadcrumb-link">
                    Books
                </a>
            </li>
            <?php if ($parent_book_id): ?>
                <li class="scholar-breadcrumb-item">
                    <span class="scholar-breadcrumb-separator">›</span>
                    <a href="<?php echo get_permalink($parent_book_id); ?>" class="scholar-breadcrumb-link">
                        <?php echo esc_html($book_title); ?>
                    </a>
                </li>
            <?php endif; ?>
            <li class="scholar-breadcrumb-item">
                <span class="scholar-breadcrumb-separator">›</span>
                <span><?php the_title(); ?></span>
            </li>
        </ol>
    </nav>
    
    <!-- Parent Book Info -->
    <?php if ($parent_book_id): ?>
        <div class="scholar-parent-book">
            <div class="scholar-parent-label">Part of Book</div>
            <h2 class="scholar-parent-title">
                <a href="<?php echo get_permalink($parent_book_id); ?>">
                    <?php echo esc_html($book_title); ?>
                </a>
            </h2>
        </div>
    <?php endif; ?>
    
    <!-- Chapter Header -->
    <header class="scholar-chapter-header">
        <?php if ($chapter_number): ?>
            <div class="scholar-chapter-number">Chapter <?php echo $chapter_number; ?></div>
        <?php endif; ?>
        
        <h1 class="scholar-chapter-title"><?php the_title(); ?></h1>
        
        <?php if (!empty($chapter_authors) && is_array($chapter_authors)): ?>
            <div class="scholar-chapter-authors">
                <?php
                $author_names = array();
                foreach ($chapter_authors as $author) {
                    if (!empty($author['first_name']) && !empty($author['last_name'])) {
                        $author_names[] = $author['first_name'] . ' ' . $author['last_name'];
                    }
                }
                echo 'By ' . esc_html(implode(', ', $author_names));
                ?>
            </div>
        <?php endif; ?>
        
        <div class="scholar-chapter-meta">
            <?php if ($first_page && $last_page): ?>
                <div class="scholar-chapter-meta-item">
                    <span class="scholar-chapter-meta-icon">📄</span>
                    <span>Pages <?php echo esc_html($first_page . '–' . $last_page); ?></span>
                </div>
            <?php endif; ?>
            
            <?php if ($chapter_doi): ?>
                <div class="scholar-chapter-meta-item">
                    <span class="scholar-chapter-meta-icon">🔗</span>
                    <span>DOI: <?php echo esc_html($chapter_doi); ?></span>
                </div>
            <?php endif; ?>
        </div>
    </header>
    
    <!-- Chapter Content -->
    <article class="scholar-chapter-content">
        <?php the_content(); ?>
    </article>
    
    <!-- Citation -->
    <?php if (!empty($chapter_authors) && $book_publisher && $book_year): ?>
        <aside class="scholar-chapter-citation">
            <h4>Cite This Chapter</h4>
            <?php
            $author_string = '';
            $author_names = array();
            foreach ($chapter_authors as $author) {
                if (!empty($author['last_name']) && !empty($author['first_name'])) {
                    $author_names[] = $author['last_name'] . ', ' . $author['first_name'][0] . '.';
                }
            }
            $author_string = implode(', ', $author_names);
            ?>
            <p style="margin: 0; word-wrap: break-word;">
                <?php echo esc_html($author_string); ?> (<?php echo esc_html($book_year); ?>). 
                <?php the_title(); ?>. In <em><?php echo esc_html($book_title); ?></em> 
                (<?php if ($first_page && $last_page): ?>pp. <?php echo esc_html($first_page . '–' . $last_page); ?><?php endif; ?>). 
                <?php echo esc_html($book_publisher); ?>.
                <?php if ($chapter_doi): ?>
                    https://doi.org/<?php echo esc_html($chapter_doi); ?>
                <?php endif; ?>
            </p>
        </aside>
    <?php endif; ?>
    
    <!-- Actions -->
    <div class="scholar-chapter-actions">
        <?php if ($parent_book_id): ?>
            <a href="<?php echo get_permalink($parent_book_id); ?>" class="scholar-chapter-btn scholar-chapter-btn-secondary">
                <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M15 2a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2zM0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2zm4.5 5.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z"/>
                </svg>
                View Full Book
            </a>
        <?php endif; ?>
        
        <?php if ($chapter_pdf): ?>
            <a href="<?php echo esc_url($chapter_pdf); ?>" class="scholar-chapter-btn scholar-chapter-btn-primary" target="_blank">
                <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
                    <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/>
                </svg>
                Download Chapter PDF
            </a>
        <?php endif; ?>
    </div>
    
    <!-- Chapter Navigation -->
    <?php
    // Get previous and next chapters
    $prev_chapter = null;
    $next_chapter = null;
    
    if ($all_chapters->have_posts()) {
        $chapters_array = $all_chapters->posts;
        if (isset($chapters_array[$current_index - 1])) {
            $prev_chapter = $chapters_array[$current_index - 1];
        }
        if (isset($chapters_array[$current_index + 1])) {
            $next_chapter = $chapters_array[$current_index + 1];
        }
    }
    
    if ($prev_chapter || $next_chapter):
    ?>
        <nav class="scholar-chapter-navigation">
            <?php if ($prev_chapter): ?>
                <a href="<?php echo get_permalink($prev_chapter->ID); ?>" class="scholar-nav-item">
                    <div class="scholar-nav-label">← Previous Chapter</div>
                    <div class="scholar-nav-title"><?php echo esc_html(get_the_title($prev_chapter->ID)); ?></div>
                </a>
            <?php else: ?>
                <div></div>
            <?php endif; ?>
            
            <?php if ($next_chapter): ?>
                <a href="<?php echo get_permalink($next_chapter->ID); ?>" class="scholar-nav-item" style="text-align: right;">
                    <div class="scholar-nav-label">Next Chapter →</div>
                    <div class="scholar-nav-title"><?php echo esc_html(get_the_title($next_chapter->ID)); ?></div>
                </a>
            <?php endif; ?>
        </nav>
    <?php endif; ?>
    
</div>

<?php endwhile; ?>

<?php get_footer(); ?>
