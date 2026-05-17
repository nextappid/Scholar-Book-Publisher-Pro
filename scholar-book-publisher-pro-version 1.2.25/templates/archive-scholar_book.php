<?php
/**
 * Template for displaying books archive
 * Contemporary Tosca theme with dark/light mode
 * 
 * @package Scholar_Book_Publisher
 * @version 1.2.13
 */

get_header(); ?>

<script>
/* Anti-flash: Terapkan dark theme SEBELUM CSS render (mencegah white flash) */
(function(){
    var theme = localStorage.getItem('scholarTheme') || 'dark';
    if (theme === 'dark') {
        document.documentElement.style.backgroundColor = '#111827';
        document.body.style.backgroundColor = '#111827';
    }
})();

/* AJAX Variables - Make available globally for inline scripts */
var sbpp_ajax = {
    ajax_url: '<?php echo esc_url(admin_url('admin-ajax.php')); ?>',
    nonce: '<?php echo wp_create_nonce('sbpp_filter_nonce'); ?>'
};
</script>

<style>
    /* === RESET & BOX SIZING === */
    * {
        box-sizing: border-box;
    }
    
    html {
        overflow-x: hidden;
    }
    
    body {
        overflow-x: hidden;
        margin: 0;
        padding: 0;
    }
    
    img {
        max-width: 100%;
        height: auto;
    }

    /* === GOOGLE FONTS === */
    @import url('https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700;800&family=Playfair+Display:wght@400;500;600;700;800&family=Source+Sans+Pro:wght@300;400;600;700&display=swap');

    /* === TOSCA THEME - COLOR VARIABLES === */
    :root {
        /* Light Mode - New Color Scheme */
        --primary-teal: #037590;
        --primary-teal-light: #02b2bf;
        --primary-teal-lighter: #5DD9E5;
        --primary-teal-dark: #025E73;
        
        --accent-coral: #FF6B6B;
        --accent-amber: #F59E0B;
        --accent-purple: #8B5CF6;
        
        --text-primary: #1F2937;
        --text-secondary: #6B7280;
        --text-muted: #9CA3AF;
        
        --bg-primary: #FFFFFF;
        --bg-secondary: #F9FAFB;
        --bg-tertiary: #F3F4F6;
        
        --border-color: #E5E7EB;
        --border-light: #F3F4F6;
        
        --card-shadow: 0 1px 3px rgba(0,0,0,0.1), 0 1px 2px rgba(0,0,0,0.06);
        --card-shadow-hover: 0 10px 20px rgba(3,117,144,0.15), 0 6px 6px rgba(3,117,144,0.1);
        
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Dark Mode Colors */
    [data-theme="dark"] {
        --primary-teal: #02b2bf;
        --primary-teal-light: #5DD9E5;
        --primary-teal-lighter: #8FE5ED;
        --primary-teal-dark: #037590;
        
        --accent-coral: #FF8787;
        --accent-amber: #FBBF24;
        --accent-purple: #A78BFA;
        
        --text-primary: #F9FAFB;
        --text-secondary: #D1D5DB;
        --text-muted: #9CA3AF;
        
        --bg-primary: #111827;
        --bg-secondary: #1F2937;
        --bg-tertiary: #374151;
        
        --border-color: #374151;
        --border-light: #4B5563;
        
        --card-shadow: 0 4px 6px rgba(0,0,0,0.3);
        --card-shadow-hover: 0 10px 20px rgba(2,178,191,0.3), 0 6px 6px rgba(2,178,191,0.2);
    }

    /* === MAIN CONTAINER === */
    .scholar-archive-container {
        max-width: 100%;
        width: 100%;
        margin: 0;
        padding: 0;
        background: var(--bg-primary);
        color: var(--text-primary);
        font-family: 'Source Sans Pro', -apple-system, BlinkMacSystemFont, sans-serif;
        transition: background-color 0.3s ease, color 0.3s ease;
        min-height: 100vh;
        overflow-x: hidden;
        position: relative;
    }

    /* === HEADER SECTION === */
    .scholar-archive-header {
        background: linear-gradient(135deg, #025E73 0%, #037590 50%, #02b2bf 100%);
        color: white;
        padding: 3.5rem 2rem 3rem;
        position: relative;
        overflow: hidden;
    }

    @media (max-width: 768px) {
        .scholar-archive-header {
            padding: 2.5rem 1.5rem 2rem;
        }
    }

    @media (max-width: 480px) {
        .scholar-archive-header {
            padding: 2rem 1rem 1.5rem;
        }
    }

    .scholar-archive-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: 
            linear-gradient(45deg, rgba(3, 117, 144, 0.3) 0%, transparent 50%),
            url('data:image/svg+xml,<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg"><defs><pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse"><path d="M 40 0 L 0 0 0 40" fill="none" stroke="rgba(255,255,255,0.08)" stroke-width="1"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)"/></svg>');
        opacity: 0.5;
    }

    .scholar-header-content {
        max-width: 1400px;
        margin: 0 auto;
        position: relative;
        z-index: 1;
    }

    .scholar-archive-title {
        font-family: 'Playfair Display', serif;
        font-size: clamp(1.75rem, 4vw, 2.75rem);
        font-weight: 700;
        margin: 0 0 0.75rem 0;
        letter-spacing: -0.02em;
        line-height: 1.2;
        color: white;
    }

    .scholar-archive-subtitle {
        font-family: 'Source Sans Pro', sans-serif;
        font-size: clamp(0.95rem, 1.5vw, 1.125rem);
        font-weight: 300;
        margin: 0;
        opacity: 0.95;
        line-height: 1.6;
        max-width: 900px;
    }


    /* === THEME TOGGLE - Inside page header, not floating === */
    .theme-toggle-container {
        position: absolute;
        top: 1.5rem;
        right: 1.5rem;
        z-index: 10;
    }

    .theme-toggle {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        background: rgba(255, 255, 255, 0.18);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        padding: 0.45rem 1rem;
        border-radius: 2rem;
        border: 1px solid rgba(255, 255, 255, 0.3);
        transition: var(--transition);
        cursor: pointer;
        color: white;
        font-size: 0.85rem;
        font-weight: 600;
        letter-spacing: 0.02em;
        text-decoration: none;
        user-select: none;
    }

    .theme-toggle:hover {
        background: rgba(255, 255, 255, 0.28);
        border-color: rgba(255, 255, 255, 0.5);
    }

    .theme-icon {
        width: 18px;
        height: 18px;
        flex-shrink: 0;
    }

    .theme-switch {
        position: relative;
        width: 40px;
        height: 20px;
        background: rgba(255, 255, 255, 0.3);
        border-radius: 10px;
        cursor: pointer;
        transition: var(--transition);
        flex-shrink: 0;
    }

    .theme-switch-slider {
        position: absolute;
        top: 2px;
        left: 2px;
        width: 16px;
        height: 16px;
        background: white;
        border-radius: 50%;
        transition: var(--transition);
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }

    [data-theme="dark"] .theme-switch-slider {
        transform: translateX(20px);
    }

    [data-theme="dark"] .theme-switch {
        background: rgba(2, 178, 191, 0.5);
    }

    @media (max-width: 600px) {
        .theme-toggle-container {
            top: 1rem;
            right: 1rem;
        }
        .theme-toggle .theme-label {
            display: none;
        }
        .theme-toggle {
            padding: 0.4rem 0.75rem;
        }
    }

    /* === MAIN LAYOUT === */
    .scholar-main-layout {
        display: grid;
        grid-template-columns: 280px 1fr;
        gap: 2rem;
        padding: 2rem;
        max-width: 1400px;
        margin: 0 auto;
    }

    @media (max-width: 1200px) {
        .scholar-main-layout {
            padding: 1.75rem 1.5rem;
        }
    }

    @media (max-width: 1024px) {
        .scholar-main-layout {
            grid-template-columns: 1fr;
            padding: 1.5rem;
        }
    }

    @media (max-width: 768px) {
        .scholar-main-layout {
            padding: 1.25rem 1rem;
        }
    }

    @media (max-width: 480px) {
        .scholar-main-layout {
            padding: 1rem 0.75rem;
        }
    }

    /* === SIDEBAR FILTERS === */
    .scholar-sidebar {
        position: sticky;
        top: 2rem;
        height: fit-content;
    }

    .scholar-filter-section {
        background: var(--bg-secondary);
        border: 1px solid var(--border-color);
        border-radius: 10px;
        padding: 1.25rem;
        margin-bottom: 1.25rem;
        transition: var(--transition);
    }

    .scholar-filter-section:hover {
        border-color: var(--primary-teal-light);
        box-shadow: 0 4px 12px rgba(13, 148, 136, 0.08);
    }

    .scholar-filter-title {
        font-family: 'Playfair Display', serif;
        font-size: 1rem;
        font-weight: 600;
        margin: 0 0 1rem 0;
        color: var(--text-primary);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .scholar-filter-title svg {
        width: 16px;
        height: 16px;
        color: var(--primary-teal);
    }

    /* Category Filter */
    .scholar-category-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .scholar-category-item {
        margin-bottom: 0.625rem;
    }

    .scholar-category-item label {
        display: flex;
        align-items: center;
        gap: 0.625rem;
        cursor: pointer;
        font-size: 0.9rem;
        color: var(--text-secondary);
        transition: var(--transition);
        padding: 0.375rem;
        border-radius: 5px;
    }

    .scholar-category-item label:hover {
        color: var(--primary-teal);
        background: var(--bg-tertiary);
    }

    .scholar-category-item input[type="checkbox"] {
        width: 16px;
        height: 16px;
        cursor: pointer;
        accent-color: var(--primary-teal);
    }

    /* === SEARCH INPUT === */
    .scholar-search-input {
        width: 100%;
        padding: 0.75rem 2.5rem 0.75rem 1rem;  /* Extra right padding for clear button */
        font-size: 0.9rem;
        font-family: 'Source Sans Pro', sans-serif;
        border: 2px solid var(--border-color);
        border-radius: 8px;
        background: var(--bg-primary);
        color: var(--text-primary);
        transition: var(--transition);
        outline: none;
    }

    .scholar-search-input::placeholder {
        color: var(--text-muted);
    }

    .scholar-search-input:focus {
        border-color: var(--primary-teal);
        box-shadow: 0 0 0 3px rgba(3,117,144,0.1);
    }

    .scholar-search-wrapper {
        position: relative;
    }

    .scholar-search-clear {
        position: absolute;
        right: 0.75rem;
        top: 50%;
        transform: translateY(-50%);
        background: transparent;
        border: none;
        color: var(--text-muted);
        cursor: pointer;
        padding: 0.25rem;
        border-radius: 4px;
        transition: var(--transition);
        display: none;
    }

    .scholar-search-clear:hover {
        color: var(--primary-teal);
        background: var(--bg-tertiary);
    }

    .scholar-search-clear.active {
        display: block;
    }

    .scholar-search-clear svg {
        width: 16px;
        height: 16px;
    }

    /* Year Filter */
    .scholar-year-select {
        width: 100%;
        padding: 0.625rem;
        border: 1px solid var(--border-color);
        border-radius: 6px;
        background: var(--bg-primary);
        color: var(--text-primary);
        font-size: 0.9rem;
        cursor: pointer;
        transition: var(--transition);
        font-family: 'Source Sans Pro', sans-serif;
    }

    .scholar-year-select:hover,
    .scholar-year-select:focus {
        border-color: var(--primary-teal);
        outline: none;
        box-shadow: 0 0 0 3px rgba(13, 148, 136, 0.1);
    }

    /* Open Access Toggle */
    .scholar-oa-toggle {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0.875rem;
        background: linear-gradient(135deg, rgba(13, 148, 136, 0.1), rgba(20, 184, 166, 0.1));
        border-radius: 8px;
        cursor: pointer;
        transition: var(--transition);
    }

    .scholar-oa-toggle:hover {
        background: linear-gradient(135deg, rgba(13, 148, 136, 0.15), rgba(20, 184, 166, 0.15));
    }

    .scholar-oa-label {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: 600;
        font-size: 0.9rem;
        color: var(--primary-teal);
    }

    .scholar-oa-label svg {
        width: 18px;
        height: 18px;
    }

    /* Filter Toggle Switch */
    .filter-switch {
        position: relative;
        width: 44px;
        height: 22px;
        background: var(--border-color);
        border-radius: 11px;
        cursor: pointer;
        transition: var(--transition);
    }

    .filter-switch-slider {
        position: absolute;
        top: 2px;
        left: 2px;
        width: 18px;
        height: 18px;
        background: white;
        border-radius: 50%;
        transition: var(--transition);
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }

    .filter-switch.active {
        background: var(--primary-teal);
    }

    .filter-switch.active .filter-switch-slider {
        transform: translateX(22px);
    }

    /* Clear Filters Button */
    .scholar-clear-filters {
        width: 100%;
        padding: 0.625rem;
        background: transparent;
        border: 1px solid var(--border-color);
        border-radius: 6px;
        color: var(--text-secondary);
        font-size: 0.85rem;
        cursor: pointer;
        transition: var(--transition);
        font-family: 'Source Sans Pro', sans-serif;
        font-weight: 500;
    }

    .scholar-clear-filters:hover {
        background: var(--bg-tertiary);
        color: var(--primary-teal);
        border-color: var(--primary-teal);
    }

    /* === BOOKS GRID === */
    .scholar-books-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(min(170px, 100%), 1fr));
        gap: 2rem 1.5rem;
        padding-bottom: 2rem;
        width: 100%;
    }

    @media (max-width: 1200px) {
        .scholar-books-grid {
            grid-template-columns: repeat(auto-fill, minmax(min(160px, 100%), 1fr));
            gap: 1.75rem 1.25rem;
        }
    }

    @media (max-width: 768px) {
        .scholar-books-grid {
            grid-template-columns: repeat(auto-fill, minmax(min(140px, 45%), 1fr));
            gap: 1.5rem 1rem;
        }
    }

    @media (max-width: 600px) {
        .scholar-books-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 1.25rem 0.875rem;
        }
    }

    @media (max-width: 400px) {
        .scholar-books-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 1rem 0.75rem;
        }
    }

    /* === BOOK CARD === */
    .scholar-book-card {
        background: var(--bg-primary);
        border: 1px solid var(--border-color);
        border-radius: 8px;
        overflow: hidden;
        transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        position: relative;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .scholar-book-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 24px rgba(3,117,144,0.12), 0 8px 16px rgba(0,0,0,0.08);
        border-color: var(--primary-teal-light);
    }

    /* Book Cover Container - Flexible with aspect ratio */
    .scholar-card-cover {
        position: relative;
        width: 100%;
        aspect-ratio: 2 / 3;
        overflow: hidden;
        background: linear-gradient(135deg, #f7f7f7, #e9ecef);
    }

    [data-theme="dark"] .scholar-card-cover {
        background: linear-gradient(135deg, #2a2a2a, #1a1a1a);
    }

    .scholar-card-cover img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .scholar-book-card:hover .scholar-card-cover img {
        transform: scale(1.08);
    }

    /* Cover Fallback Icon */
    .scholar-cover-fallback {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: var(--text-muted);
        opacity: 0.15;
        font-size: 3rem;
    }

    /* Open Access Badge on Card */
    .scholar-oa-badge {
        position: absolute;
        top: 0.75rem;
        right: 0.75rem;
        background: rgba(3, 117, 144, 0.96);
        backdrop-filter: blur(10px);
        color: white;
        padding: 0.375rem 0.75rem;
        border-radius: 6px;
        font-size: 0.7rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 0.375rem;
        box-shadow: 0 3px 10px rgba(0,0,0,0.25);
        z-index: 2;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        transition: all 0.3s ease;
    }

    .scholar-book-card:hover .scholar-oa-badge {
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(0,0,0,0.3);
    }

    .scholar-oa-badge img {
        width: 16px;
        height: 16px;
        object-fit: contain;
    }

    /* Card Content - Very Tight Spacing */
    .scholar-card-content {
        padding: 1rem 0.875rem 0.875rem;
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 0;
    }

    @media (max-width: 600px) {
        .scholar-card-content {
            padding: 0.75rem 0.625rem 0.625rem;
        }
    }

    .scholar-card-title {
        font-family: 'Open Sans', sans-serif;
        font-size: 17px;
        font-weight: 400;
        line-height: 1.3;
        margin: 0;
        color: var(--text-primary);
        overflow-wrap: break-word;
        word-wrap: break-word;
        hyphens: auto;
    }

    @media (max-width: 768px) {
        .scholar-card-title {
            font-size: 15px;
        }
    }

    @media (max-width: 480px) {
        .scholar-card-title {
            font-size: 14px;
            line-height: 1.25;
        }
    }

    .scholar-card-title a {
        color: inherit;
        text-decoration: none;
        transition: color 0.3s ease;
        position: relative;
    }

    .scholar-card-title a:hover {
        color: var(--primary-teal);
    }

    .scholar-card-authors {
        font-size: 0.875rem;
        color: var(--text-secondary);
        font-weight: 400;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        line-height: 1.4;
        margin: 0;
    }

    .scholar-card-meta {
        font-size: 0.75rem;
        color: var(--text-muted);
        margin-top: auto;
        padding-top: 0.5rem;
        border-top: 1px solid var(--border-light);
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .scholar-card-year {
        font-weight: 700;
        color: var(--primary-teal);
        font-size: 0.8rem;
    }

    /* Usage Metrics on Card - Same Line with Year */
    .scholar-card-metrics {
        display: flex;
        gap: 0.75rem;
        font-size: 0.7rem;
        color: var(--text-muted);
    }

    .scholar-card-metrics span {
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    .scholar-card-metrics svg {
        width: 13px;
        height: 13px;
        color: var(--primary-teal);
    }

    /* === PAGINATION === */
    .scholar-pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 0.5rem;
        padding: 2rem 0;
        flex-wrap: wrap;
    }

    .scholar-page-link {
        padding: 0.5rem 0.875rem;
        background: var(--bg-secondary);
        border: 1px solid var(--border-color);
        border-radius: 6px;
        color: var(--text-primary);
        text-decoration: none;
        transition: var(--transition);
        font-weight: 500;
        font-size: 0.9rem;
        min-width: 38px;
        text-align: center;
    }

    .scholar-page-link:hover {
        background: var(--primary-teal);
        color: white;
        border-color: var(--primary-teal);
    }

    .scholar-page-link.current {
        background: var(--primary-teal);
        color: white;
        border-color: var(--primary-teal);
    }

    /* === MOBILE SIDEBAR === */
    @media (max-width: 1024px) {
        .scholar-sidebar {
            position: relative;
            top: 0;
        }
    }

    /* === AJAX LOADING & RESULT STATES === */
    .sbp-loading {
        text-align: center;
        padding: 2rem;
        color: var(--text-secondary);
        font-size: 0.95rem;
    }

    @keyframes sbp-spin {
        to { transform: rotate(360deg); }
    }

    .sbp-spinner {
        width: 36px;
        height: 36px;
        border: 3px solid var(--border-color);
        border-top-color: var(--primary-teal);
        border-radius: 50%;
        animation: sbp-spin 0.7s linear infinite;
        margin: 0 auto 0.75rem;
    }

    .sbp-result-count {
        font-size: 0.875rem;
        color: var(--text-secondary);
        margin: 0 0 1rem 0;
        padding: 0.5rem 0.75rem;
        background: var(--bg-tertiary);
        border-radius: 6px;
        border-left: 3px solid var(--primary-teal);
    }

    .sbp-filter-pagination {
        margin-top: 2rem;
        display: flex;
        flex-wrap: wrap;
        gap: 0.375rem;
        justify-content: center;
    }

    .sbp-no-results {
        text-align: center;
        padding: 3rem 2rem;
        color: var(--text-secondary);
        font-size: 1rem;
        grid-column: 1 / -1;
    }

    /* === NO RESULTS === */
    .scholar-no-results {
        text-align: center;
        padding: 3rem 2rem;
        color: var(--text-secondary);
        grid-column: 1 / -1;
    }

    .scholar-no-results svg {
        width: 56px;
        height: 56px;
        color: var(--text-muted);
        margin-bottom: 1rem;
    }

    .scholar-no-results h3 {
        font-family: 'Playfair Display', serif;
        font-size: 1.35rem;
        margin: 0 0 0.5rem 0;
        color: var(--text-primary);
    }

    .scholar-no-results p {
        font-size: 0.95rem;
        margin: 0;
    }

    /* === ANIMATIONS === */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(15px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .scholar-book-card {
        animation: fadeInUp 0.4s ease-out backwards;
    }

    .scholar-book-card:nth-child(1) { animation-delay: 0.03s; }
    .scholar-book-card:nth-child(2) { animation-delay: 0.06s; }
    .scholar-book-card:nth-child(3) { animation-delay: 0.09s; }
    .scholar-book-card:nth-child(4) { animation-delay: 0.12s; }
    .scholar-book-card:nth-child(5) { animation-delay: 0.15s; }
    .scholar-book-card:nth-child(6) { animation-delay: 0.18s; }

    /* === RESPONSIVE ADJUSTMENTS === */
    @media (max-width: 768px) {
        .scholar-archive-header {
            padding: 2.5rem 1.5rem 2rem;
        }
        
        .scholar-main-layout {
            padding: 1.5rem;
        }
        
        .scholar-filter-section {
            padding: 1rem;
        }
    }

    @media (max-width: 480px) {
        .scholar-archive-header {
            padding: 2rem 1rem 1.5rem;
        }
        
        .scholar-main-layout {
            padding: 1rem;
            gap: 1.5rem;
        }
        
        .scholar-card-content {
            padding: 0.75rem;
        }
        
        .scholar-related-section {
            padding: 2.5rem 1rem;
        }
    }
</style>

<div class="scholar-archive-container" data-theme="dark">

    <!-- Header (theme toggle lives INSIDE here, anchored absolutely) -->
    <header class="scholar-archive-header">
        <!-- Theme Toggle - inside header, always visible above WP header -->
        <div class="theme-toggle-container">
            <div class="theme-toggle" onclick="toggleTheme()">
                <svg class="theme-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
                <div class="theme-switch">
                    <div class="theme-switch-slider"></div>
                </div>
                <svg class="theme-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                </svg>
                <span class="theme-label">Theme</span>
            </div>
        </div>

        <div class="scholar-header-content">
            <h1 class="scholar-archive-title">Read to Discover. Write to Inspire.</h1>
            <p class="scholar-archive-subtitle">
                Explore our curated collection of scholarly publications, academic and research monographs, 
                alongside a premier selection of insightful general interest titles.
            </p>
        </div>
    </header>

    <!-- Main Layout -->
    <div class="scholar-main-layout">
        
        <!-- Sidebar Filters -->
        <aside class="scholar-sidebar">
            
            <!-- Search Filter -->
            <div class="scholar-filter-section">
                <h3 class="scholar-filter-title">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    Search
                </h3>
                <div class="scholar-search-wrapper">
                    <input 
                        type="text" 
                        id="search-input" 
                        class="scholar-search-input" 
                        placeholder="Search by title or author..."
                        autocomplete="off"
                    >
                    <button class="scholar-search-clear" id="search-clear" title="Clear search">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
            
            <!-- Category Filter -->
            <?php
            $categories = get_terms(array(
                'taxonomy' => 'book_category',
                'hide_empty' => true
            ));
            
            if (!empty($categories) && !is_wp_error($categories)):
            ?>
            <div class="scholar-filter-section">
                <h3 class="scholar-filter-title">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                    Category
                </h3>
                <ul class="scholar-category-list">
                    <?php foreach ($categories as $category): ?>
                        <li class="scholar-category-item">
                            <label>
                                <input type="checkbox" 
                                       class="category-filter" 
                                       value="<?php echo esc_attr($category->slug); ?>"
                                       data-count="<?php echo $category->count; ?>">
                                <span><?php echo esc_html($category->name); ?> (<?php echo $category->count; ?>)</span>
                            </label>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endif; ?>
            
            <!-- Year Filter -->
            <?php
            global $wpdb;
            $years = $wpdb->get_col("
                SELECT DISTINCT YEAR(STR_TO_DATE(meta_value, '%Y-%m-%d')) as year 
                FROM {$wpdb->postmeta} 
                WHERE meta_key = '_sbpp_publication_date' 
                AND meta_value != '' 
                ORDER BY year DESC
            ");
            
            if (!empty($years)):
            ?>
            <div class="scholar-filter-section">
                <h3 class="scholar-filter-title">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    Year
                </h3>
                <select class="scholar-year-select" id="year-filter">
                    <option value="">All Years</option>
                    <?php foreach ($years as $year): ?>
                        <?php if ($year): ?>
                            <option value="<?php echo esc_attr($year); ?>"><?php echo esc_html($year); ?></option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
            </div>
            <?php endif; ?>
            
            <!-- Language Filter -->
            <?php
            global $wpdb;
            $languages = $wpdb->get_col("
                SELECT DISTINCT meta_value 
                FROM {$wpdb->postmeta} 
                WHERE meta_key = '_sbpp_book_language' 
                AND meta_value != '' 
                ORDER BY meta_value ASC
            ");
            ?>
            <div class="scholar-filter-section">
                <h3 class="scholar-filter-title">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path>
                    </svg>
                    Language
                </h3>
                <select class="scholar-year-select" id="language-filter">
                    <option value="">All Languages</option>
                    <?php if (!empty($languages)): ?>
                        <?php foreach ($languages as $language): ?>
                            <?php if ($language): ?>
                                <option value="<?php echo esc_attr($language); ?>"><?php echo esc_html($language); ?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
                <?php if (empty($languages)): ?>
                    <p class="description" style="font-size: 0.85em; color: var(--text-muted); margin-top: 0.5rem;">
                        No languages set yet. Add language info to books to enable filtering.
                    </p>
                <?php endif; ?>
            </div>
            
            <!-- Open Access Filter -->
            <div class="scholar-filter-section">
                <h3 class="scholar-filter-title">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"></path>
                    </svg>
                    Access Type
                </h3>
                <div class="scholar-oa-toggle" id="oa-toggle">
                    <div class="scholar-oa-label">
                        <img src="<?php echo plugins_url('assets/images/open-access-logo.svg', dirname(__FILE__)); ?>" 
                             alt="Open Access" 
                             style="width: 20px; height: 20px;">
                        Open Access
                    </div>
                    <div class="filter-switch" id="oa-switch">
                        <div class="filter-switch-slider"></div>
                    </div>
                </div>
            </div>
            
            <!-- Clear Filters -->
            <button class="scholar-clear-filters" onclick="clearFilters()">
                Clear All Filters
            </button>
            
        </aside>

        <!-- Books Grid -->
        <main class="scholar-books-main">
            
            <?php
            // =====================================================
            // CUSTOM WP_QUERY — SOLUSI DEFINITIF UNTUK PAGINATION
            // Tidak bergantung pada main query / pre_get_posts
            // Langsung query 50 buku dari database
            // =====================================================
            $paged = get_query_var('paged') ? absint(get_query_var('paged')) : 1;
            if ($paged < 1) $paged = 1;

            $books_query = new WP_Query(array(
                'post_type'      => 'scholar_book',
                'post_status'    => 'publish',
                'posts_per_page' => 50,
                'paged'          => $paged,
                'orderby'        => 'date',
                'order'          => 'DESC',
            ));
            ?>
            
            <?php if ($books_query->have_posts()): ?>
                
                <div class="scholar-books-grid">
                    
                    <?php while ($books_query->have_posts()): $books_query->the_post(); 
                        // Get metadata
                        $cover_id = get_post_meta(get_the_ID(), '_sbpp_book_cover', true);
                        $authors = get_post_meta(get_the_ID(), '_sbpp_authors', true);
                        $publisher = get_post_meta(get_the_ID(), '_sbpp_book_publisher', true);
                        $pub_date = get_post_meta(get_the_ID(), '_sbpp_publication_date', true);
                        $access_category = get_post_meta(get_the_ID(), '_sbpp_access_category', true);
                        
                        $year = $pub_date ? date('Y', strtotime($pub_date)) : '';
                        
                        // Authors string
                        $authors_string = '';
                        if (!empty($authors) && is_array($authors)) {
                            $author_names = array();
                            foreach ($authors as $index => $author) {
                                if (!empty($author['first_name']) && !empty($author['last_name'])) {
                                    $author_names[] = $author['first_name'] . ' ' . $author['last_name'];
                                }
                                if ($index >= 1) break; // Max 2 authors
                            }
                            $authors_string = implode(', ', $author_names);
                            if (count($authors) > 2) {
                                $authors_string .= ' et al.';
                            }
                        }
                        
                        // Categories for filtering
                        $categories = wp_get_post_terms(get_the_ID(), 'book_category', array('fields' => 'slugs'));
                        if (is_wp_error($categories) || !is_array($categories)) {
                            $categories = array();
                        }
                    ?>
                    
                    <article class="scholar-book-card" 
                             data-categories="<?php echo esc_attr(implode(',', $categories)); ?>"
                             data-year="<?php echo esc_attr($year); ?>"
                             data-access="<?php echo esc_attr($access_category); ?>">
                        
                        <!-- Cover -->
                        <div class="scholar-card-cover">
                            <?php if ($cover_id): 
                                $cover_url = wp_get_attachment_url($cover_id);
                            ?>
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
                            
                            <!-- Open Access Badge -->
                            <?php if ($access_category === 'open'): ?>
                                <div class="scholar-oa-badge">
                                    <img src="<?php echo plugins_url('assets/images/open-access-logo.svg', dirname(__FILE__)); ?>" alt="Open Access">
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
                                <div class="scholar-card-authors">
                                    <?php echo esc_html($authors_string); ?>
                                </div>
                            <?php endif; ?>
                            
                            <div class="scholar-card-meta">
                                <?php if ($year): ?>
                                    <span class="scholar-card-year"><?php echo esc_html($year); ?></span>
                                <?php endif; ?>
                                
                                <?php
                                // Get usage metrics
                                $metrics = class_exists('SBPP_Usage_Metrics') ? SBPP_Usage_Metrics::get_metrics(get_the_ID()) : array('views' => 0, 'downloads' => 0);
                                if ($metrics['views'] > 0 || $metrics['downloads'] > 0):
                                ?>
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
                    
                    <?php endwhile; wp_reset_postdata(); ?>
                    
                </div>
                
                <!-- Pagination — menggunakan custom query $books_query -->
                <?php
                $pagination = paginate_links(array(
                    'base'      => get_pagenum_link(1) . '%_%',
                    'format'    => 'page/%#%/',
                    'current'   => $paged,
                    'total'     => $books_query->max_num_pages,
                    'type'      => 'array',
                    'prev_text' => '← Previous',
                    'next_text' => 'Next →',
                ));
                
                if ($pagination):
                ?>
                <nav class="scholar-pagination">
                    <?php foreach ($pagination as $page_link): ?>
                        <?php echo str_replace('page-numbers', 'scholar-page-link', $page_link); ?>
                    <?php endforeach; ?>
                </nav>
                <?php endif; ?>
                
            <?php else: ?>
                
                <div class="scholar-no-results">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h3>No Books Found</h3>
                    <p>No books have been published yet.</p>
                </div>
                
            <?php endif; ?>
            
        </main>
        
    </div>

</div>

<script>
// Theme Toggle
function toggleTheme() {
    const container = document.querySelector('.scholar-archive-container');
    const currentTheme = container.getAttribute('data-theme');
    const newTheme = currentTheme === 'light' ? 'dark' : 'light';
    
    container.setAttribute('data-theme', newTheme);
    localStorage.setItem('scholarTheme', newTheme);
}

// Load saved theme (default: dark)
document.addEventListener('DOMContentLoaded', function() {
    const savedTheme = localStorage.getItem('scholarTheme') || 'dark';
    document.querySelector('.scholar-archive-container').setAttribute('data-theme', savedTheme);
    
    // Debug: Check if AJAX variables are available
    if (typeof sbpp_ajax === 'undefined') {
        console.error('Scholar Book Publisher: AJAX variables not loaded!');
    } else {
        console.log('Scholar Book Publisher: AJAX ready', sbpp_ajax);
    }
    
    // Initialize AJAX filters
    initializeFilters();
});

// ==========================================
// AJAX-BASED FILTER SYSTEM
// Searches ALL database entries, not just current page
// Supports: Categories, Year, Open Access, Search (Title/Author)
// ==========================================
function initializeFilters() {
    const categoryCheckboxes = document.querySelectorAll('.category-filter');
    const yearSelect         = document.getElementById('year-filter');
    const languageSelect     = document.getElementById('language-filter');
    const oaToggle           = document.getElementById('oa-toggle');
    const oaSwitch           = document.getElementById('oa-switch');
    const searchInput        = document.getElementById('search-input');
    const searchClear        = document.getElementById('search-clear');
    
    // Debug: Log which elements are found
    console.log('SBP Filter Elements:', {
        categoryCheckboxes: categoryCheckboxes.length,
        yearSelect: !!yearSelect,
        languageSelect: !!languageSelect,
        oaToggle: !!oaToggle,
        searchInput: !!searchInput
    });
    
    let activeCategories = [];
    let activeYear       = '';
    let activeLanguage   = '';
    let oaOnly           = false;
    let searchTerm       = '';
    let isFiltering      = false;   // true while AJAX active
    let searchTimeout    = null;    // debounce timer

    // Search input with debounce
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTerm = this.value.trim();
            
            // Show/hide clear button
            if (searchClear) {
                if (searchTerm) {
                    searchClear.classList.add('active');
                } else {
                    searchClear.classList.remove('active');
                }
            }
            
            // Debounce: wait 500ms after user stops typing
            searchTimeout = setTimeout(function() {
                runAjaxFilter(1);
            }, 500);
        });
        
        // Clear button
        if (searchClear) {
            searchClear.addEventListener('click', function() {
                searchInput.value = '';
                searchTerm = '';
                this.classList.remove('active');
                runAjaxFilter(1);
            });
        }
    }

    // Category checkboxes
    categoryCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            if (this.checked) {
                activeCategories.push(this.value);
            } else {
                activeCategories = activeCategories.filter(c => c !== this.value);
            }
            runAjaxFilter(1);
        });
    });

    // Year select
    if (yearSelect) {
        yearSelect.addEventListener('change', function() {
            activeYear = this.value;
            runAjaxFilter(1);
        });
    }

    // Language select
    if (languageSelect) {
        languageSelect.addEventListener('change', function() {
            activeLanguage = this.value;
            console.log('Language changed to:', activeLanguage);
            runAjaxFilter(1);
        });
    } else {
        console.warn('Language filter element not found');
    }

    // OA toggle
    if (oaToggle) {
        oaToggle.addEventListener('click', function() {
            oaOnly = !oaOnly;
            oaSwitch.classList.toggle('active');
            runAjaxFilter(1);
        });
    }

    // Run AJAX filter
    window.runAjaxFilter = function(page) {
        if (isFiltering) return;

        console.log('Filter triggered with:', {
            categories: activeCategories,
            year: activeYear,
            language: activeLanguage,
            oaOnly: oaOnly,
            search: searchTerm,
            page: page
        });

        const grid     = document.querySelector('.scholar-books-grid');
        const main     = document.querySelector('.scholar-books-main');

        // If no filters active, reload default page (no AJAX needed for unfiltered state)
        const hasFilter = activeCategories.length > 0 || activeYear || activeLanguage || oaOnly || searchTerm;
        
        if (!hasFilter) {
            console.log('No filters active, reloading page');
            // Reload to show fresh WP pagination
            window.location.href = window.location.pathname;
            return;
        }

        isFiltering = true;

        // Show loading spinner
        if (grid) grid.style.opacity = '0.4';
        showLoadingSpinner(main);

        // Build request
        const data = new FormData();
        data.append('action',     'sbpp_filter_books');
        data.append('nonce',      (typeof sbpp_ajax !== 'undefined') ? sbpp_ajax.nonce : '');
        data.append('paged',      page || 1);
        data.append('oa_only',    oaOnly ? '1' : '0');
        data.append('search',     searchTerm);
        activeCategories.forEach(c => data.append('categories[]', c));
        if (activeYear) data.append('year', activeYear);
        if (activeLanguage) data.append('language', activeLanguage);

        const ajaxUrl = (typeof sbpp_ajax !== 'undefined') ? sbpp_ajax.ajax_url : '/wp-admin/admin-ajax.php';
        
        console.log('Sending AJAX to:', ajaxUrl);
        console.log('With nonce:', sbpp_ajax ? sbpp_ajax.nonce : 'undefined');

        fetch(ajaxUrl, { method: 'POST', body: data })
            .then(r => {
                console.log('AJAX Response status:', r.status);
                if (!r.ok) {
                    throw new Error(`HTTP error! status: ${r.status}`);
                }
                return r.json();
            })
            .then(response => {
                console.log('AJAX Response:', response);
                isFiltering = false;
                if (grid) grid.style.opacity = '';
                removeLoadingSpinner(main);

                if (response.success) {
                    // Replace cards
                    if (grid) grid.innerHTML = response.data.html;

                    // Update result count
                    updateResultCount(response.data.found_posts);

                    // Render pagination for filtered results
                    renderFilterPagination(response.data.max_pages, response.data.paged, main);
                } else {
                    console.error('AJAX returned error:', response);
                    if (grid) grid.innerHTML = '<p class="sbp-no-results">No books found matching your criteria.</p>';
                }
            })
            .catch(err => {
                isFiltering = false;
                if (grid) { grid.style.opacity = ''; grid.innerHTML = '<p class="sbp-no-results">Filter error. Please refresh and try again.</p>'; }
                removeLoadingSpinner(main);
                console.error('SBP Filter Error:', err);
            });
    };
}

function showLoadingSpinner(parent) {
    if (!parent || parent.querySelector('.sbp-loading')) return;
    const div = document.createElement('div');
    div.className = 'sbp-loading';
    div.innerHTML = `<div class="sbp-spinner"></div><p>Searching all books…</p>`;
    parent.prepend(div);
}

function removeLoadingSpinner(parent) {
    if (!parent) return;
    const el = parent.querySelector('.sbp-loading');
    if (el) el.remove();
}

function updateResultCount(total) {
    let counter = document.querySelector('.sbp-result-count');
    if (!counter) {
        counter = document.createElement('p');
        counter.className = 'sbp-result-count';
        const grid = document.querySelector('.scholar-books-grid');
        if (grid) grid.parentNode.insertBefore(counter, grid);
    }
    counter.textContent = total + ' book' + (total !== 1 ? 's' : '') + ' found';
}

function renderFilterPagination(maxPages, currentPage, container) {
    // Remove old filter pagination
    const old = container.querySelector('.sbp-filter-pagination');
    if (old) old.remove();
    if (maxPages <= 1) return;

    const nav = document.createElement('div');
    nav.className = 'sbp-filter-pagination scholar-pagination';
    let html = '';
    for (let p = 1; p <= maxPages; p++) {
        if (p === currentPage) {
            html += `<span class="page-numbers current">${p}</span>`;
        } else {
            html += `<a class="page-numbers" href="#" onclick="runAjaxFilter(${p}); return false;">${p}</a>`;
        }
    }
    nav.innerHTML = html;
    container.appendChild(nav);
}

// Clear all filters
function clearFilters() {
    // Clear search
    const searchInput = document.getElementById('search-input');
    const searchClear = document.getElementById('search-clear');
    if (searchInput) searchInput.value = '';
    if (searchClear) searchClear.classList.remove('active');
    
    // Clear category checkboxes
    document.querySelectorAll('.category-filter').forEach(c => { c.checked = false; });
    
    // Clear year select
    const yearSelect = document.getElementById('year-filter');
    if (yearSelect) yearSelect.value = '';
    
    // Clear language select
    const languageSelect = document.getElementById('language-filter');
    if (languageSelect) languageSelect.value = '';
    
    // Clear OA toggle
    const oaSwitch = document.getElementById('oa-switch');
    if (oaSwitch) oaSwitch.classList.remove('active');

    // Remove result count and filter pagination
    const rc = document.querySelector('.sbp-result-count');
    if (rc) rc.remove();
    const fp = document.querySelector('.sbp-filter-pagination');
    if (fp) fp.remove();

    // Reload to restore WP pagination
    window.location.href = window.location.pathname;
}
</script>

<?php get_footer(); ?>
