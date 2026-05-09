<?php
/**
 * Template for displaying single book
 * 
 * Place this file in your theme directory as: single-scholar_book.php
 * Or the plugin will use a default fallback
 * 
 * @package Scholar_Book_Publisher
 * @version 1.2.13
 */

get_header(); ?>

<script>
/* Anti-flash: Terapkan dark theme SEBELUM CSS render (default: dark) */
(function(){
    var theme = localStorage.getItem('scholarTheme') || 'dark';
    if (theme === 'dark') {
        document.documentElement.style.backgroundColor = '#111827';
        document.body.style.backgroundColor = '#111827';
    }
})();
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
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800&family=Source+Sans+Pro:wght@300;400;600;700&display=swap');

    /* =====================================================
       TOSCA THEME — LIGHT & DARK MODE (Single Page)
       Selaras dengan Archive Page
       ===================================================== */
    :root {
        /* Light Mode */
        --scholar-primary:       #1F2937;
        --scholar-secondary:     #6B7280;
        --scholar-accent:        #037590;
        --scholar-accent-light:  #02b2bf;
        --scholar-bg:            #F9FAFB;
        --scholar-paper:         #ffffff;
        --scholar-border:        #E5E7EB;
        --scholar-border-light:  #F3F4F6;
        --scholar-muted:         #9CA3AF;
        --scholar-shadow:        0 2px 8px rgba(0,0,0,0.06);
        --scholar-shadow-hover:  0 8px 20px rgba(3,117,144,0.12);
        --scholar-spacing:       clamp(1rem, 3vw, 2rem);
        --scholar-transition:    all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        --scholar-citation-bg:   #f9f9f7;
    }

    /* Dark Mode — diaktifkan via data-theme="dark" di container */
    [data-theme="dark"] {
        --scholar-primary:       #F9FAFB;
        --scholar-secondary:     #D1D5DB;
        --scholar-accent:        #02b2bf;
        --scholar-accent-light:  #5DD9E5;
        --scholar-bg:            #111827;
        --scholar-paper:         #1F2937;
        --scholar-border:        #374151;
        --scholar-border-light:  #4B5563;
        --scholar-muted:         #9CA3AF;
        --scholar-shadow:        0 2px 8px rgba(0,0,0,0.3);
        --scholar-shadow-hover:  0 8px 20px rgba(2,178,191,0.2);
        --scholar-citation-bg:   #1a2435;
    }

    /* === THEME TOGGLE — Mobile-safe positioning === */
    .sbp-theme-toggle-wrap {
        position: relative;
        height: 0;
    }

    .sbp-theme-toggle {
        position: absolute;
        top: -2.25rem;
        right: 0;
        z-index: 999999;            /* Sangat tinggi - pasti tidak tertutup */
        display: flex;
        align-items: center;
        gap: 0.45rem;
        background: var(--scholar-accent);
        color: white;
        padding: 0.4rem 0.875rem;
        border-radius: 2rem;
        border: none;
        cursor: pointer;
        font-size: 0.8rem;
        font-weight: 600;
        font-family: 'Source Sans Pro', sans-serif;
        letter-spacing: 0.02em;
        user-select: none;
        transition: var(--scholar-transition);
        box-shadow: 0 2px 8px rgba(3,117,144,0.3);
        white-space: nowrap;
    }

    .sbp-theme-toggle:hover {
        background: var(--scholar-accent-light);
        box-shadow: 0 4px 12px rgba(3,117,144,0.4);
        transform: translateY(-1px);
    }

    .sbp-theme-toggle svg {
        width: 15px;
        height: 15px;
        flex-shrink: 0;
    }

    .sbp-toggle-switch {
        position: relative;
        width: 36px;
        height: 18px;
        background: rgba(255,255,255,0.3);
        border-radius: 9px;
        flex-shrink: 0;
        transition: var(--scholar-transition);
    }

    .sbp-toggle-slider {
        position: absolute;
        top: 2px;
        left: 2px;
        width: 14px;
        height: 14px;
        background: white;
        border-radius: 50%;
        transition: var(--scholar-transition);
        box-shadow: 0 1px 3px rgba(0,0,0,0.2);
    }

    [data-theme="dark"] .sbp-toggle-slider {
        transform: translateX(18px);
    }

    [data-theme="dark"] .sbp-toggle-switch {
        background: rgba(255,255,255,0.2);
    }

    [data-theme="dark"] .sbp-theme-toggle {
        background: #025E73;
    }

    .sbp-toggle-label {
        display: inline;
    }

    /* Responsive: adjust positioning based on container padding */
    @media (max-width: 900px) {
        .sbp-theme-toggle {
            top: -1.75rem;    /* Closer when padding reduces */
        }
    }

    @media (max-width: 600px) {
        .sbp-theme-toggle {
            top: -1.5rem;
            padding: 0.35rem 0.7rem;
            font-size: 0.75rem;
        }
    }

    @media (max-width: 480px) {
        .sbp-toggle-label { 
            display: none; 
        }
        .sbp-theme-toggle { 
            top: -1.25rem;       /* Even closer on very small screens */
            padding: 0.35rem 0.6rem;
            gap: 0.35rem;
        }
        .sbp-theme-toggle svg {
            width: 13px;
            height: 13px;
        }
        .sbp-toggle-switch {
            width: 32px;
            height: 16px;
        }
        .sbp-toggle-slider {
            width: 12px;
            height: 12px;
        }
        [data-theme="dark"] .sbp-toggle-slider {
            transform: translateX(16px);
        }
    }

    /* Main Container */
    .scholar-book-container {
        max-width: 1400px;
        width: 100%;
        margin: 0 auto;
        padding: 2.5rem;
        background: var(--scholar-bg);
        overflow-x: hidden;
        font-family: 'Source Sans Pro', -apple-system, BlinkMacSystemFont, sans-serif;
        color: var(--scholar-primary);
        line-height: 1.7;
        min-height: 100vh;
        transition: background 0.3s ease, color 0.3s ease;
    }

    @media (max-width: 1200px) {
        .scholar-book-container {
            padding: 2rem 1.75rem;
        }
    }

    @media (max-width: 900px) {
        .scholar-book-container {
            padding: 1.75rem 1.5rem;
        }
    }

    @media (max-width: 600px) {
        .scholar-book-container {
            padding: 1.5rem 1rem;
        }
    }

    @media (max-width: 400px) {
        .scholar-book-container {
            padding: 1rem 0.75rem;
        }
    }

    /* Header Section - Now in Right Column */
    .scholar-book-header {
        margin-bottom: 2rem;
    }

    .scholar-book-title {
        font-family: 'Playfair Display', serif;
        font-size: 28px;
        font-weight: 700;
        line-height: 1.3;
        margin: 0 0 0.75rem 0;
        color: var(--scholar-primary);
        letter-spacing: -0.02em;
    }

    @media (max-width: 768px) {
        .scholar-book-title {
            font-size: 24px;
        }
    }

    @media (max-width: 480px) {
        .scholar-book-title {
            font-size: 20px;
        }
    }

    .scholar-book-subtitle {
        font-family: 'Open Sans', sans-serif;
        font-size: 18px;
        font-weight: 400;
        font-style: normal;
        color: var(--scholar-secondary);
        margin: 0 0 1.5rem 0;
        letter-spacing: normal;
    }

    @media (max-width: 768px) {
        .scholar-book-subtitle {
            font-size: 16px;
        }
    }

    @media (max-width: 480px) {
        .scholar-book-subtitle {
            font-size: 15px;
        }
    }

    /* Grid Layout - More Spacious */
    .scholar-book-grid {
        display: grid;
        grid-template-columns: minmax(0, 320px) minmax(0, 1fr);
        gap: 3rem;
        margin-top: 2.5rem;
        width: 100%;
    }

    @media (max-width: 1200px) {
        .scholar-book-grid {
            grid-template-columns: minmax(0, 280px) minmax(0, 1fr);
            gap: 2.5rem;
        }
    }

    @media (max-width: 900px) {
        .scholar-book-grid {
            grid-template-columns: minmax(0, 1fr);
            gap: 2rem;
            margin-top: 2rem;
        }
    }

    /* Sidebar */
    .scholar-book-sidebar {
        position: sticky;
        top: 2rem;
        align-self: start;
    }

    @media (max-width: 1200px) {
        .scholar-book-sidebar {
            top: 1.5rem;
        }
    }

    .scholar-book-main-column {
        display: flex;
        flex-direction: column;
        gap: 0;
        padding-right: 2rem;
        border-right: 1px solid var(--scholar-border);
    }

    @media (max-width: 1200px) {
        .scholar-book-main-column {
            padding-right: 1.5rem;
        }
    }

    @media (max-width: 900px) {
        .scholar-book-sidebar {
            position: static;
        }
        
        .scholar-book-main-column {
            padding-right: 0;
            border-right: none;
        }
    }

    .scholar-book-cover {
        width: 100%;
        height: auto;
        aspect-ratio: 2 / 3;
        object-fit: cover;
        box-shadow: 0 4px 12px rgba(0,0,0,0.12), 0 2px 6px rgba(0,0,0,0.08);
        border-radius: 8px;
        border: 1px solid var(--scholar-border);
        margin-bottom: 2rem;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .scholar-book-cover:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 24px rgba(3,117,144,0.15), 0 6px 12px rgba(0,0,0,0.1);
    }

    /* Metadata Sections - Match Archive Card Style */
    .scholar-metadata-section {
        background: var(--scholar-paper);
        border: 1px solid var(--scholar-border);
        padding: 1.75rem 1.5rem;
        margin-bottom: 1.75rem;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        transition: all 0.3s ease;
    }

    .scholar-metadata-section:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }

    .scholar-metadata-section h3 {
        font-family: 'Playfair Display', serif;
        font-size: 0.9rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: var(--scholar-accent);
        margin: 0 0 1.25rem 0;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid var(--scholar-border);
    }

    .scholar-meta-item {
        margin-bottom: 0.75rem;
        font-size: 0.95rem;
    }

    .scholar-meta-label {
        font-weight: 600;
        color: var(--scholar-secondary);
        display: inline-block;
        min-width: 90px;
    }

    .scholar-meta-value {
        color: var(--scholar-primary);
    }

    /* Authors List */
    .scholar-authors-list {
        list-style: none;
        padding: 0;
        margin: 0.5rem 0 0 0;
    }

    .scholar-author-item {
        padding: 0.5rem 0;
        border-bottom: 1px solid rgba(0,0,0,0.05);
        font-size: 1rem;
    }

    .scholar-author-item:last-child {
        border-bottom: none;
    }

    /* Action Buttons */
    .scholar-actions {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
        margin-top: 1.5rem;
    }

    .scholar-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.875rem 1.5rem;
        font-family: 'Libre Franklin', 'Franklin Gothic', sans-serif;
        font-size: 0.95rem;
        font-weight: 600;
        text-decoration: none;
        border-radius: 2px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 2px solid;
        cursor: pointer;
        letter-spacing: 0.02em;
    }

    .scholar-btn-primary {
        background: var(--scholar-accent);
        color: white;
        border-color: var(--scholar-accent);
    }

    .scholar-btn-primary:hover {
        background: var(--scholar-accent-light);
        border-color: var(--scholar-accent-light);
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(3,117,144,0.25);
    }

    .scholar-btn-secondary {
        background: transparent;
        color: var(--scholar-accent);
        border-color: var(--scholar-accent);
    }

    .scholar-btn-secondary:hover {
        background: var(--scholar-accent);
        color: white;
        transform: translateY(-2px);
    }

    /* Main Content - Match Archive Cards */
    .scholar-book-content {
        background: var(--scholar-paper);
        padding: 1.75rem 1.5rem;
        border: 1px solid var(--scholar-border);
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        margin-bottom: 1.75rem;
    }

    .scholar-book-content h2,
    .scholar-book-content h3 {
        font-family: 'Playfair Display', serif;
        font-size: 0.9rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: var(--scholar-accent);
        margin: 0 0 1.25rem 0;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid var(--scholar-border);
    }

    .scholar-book-content p {
        margin-bottom: 1em;
        text-align: justify;
        hyphens: auto;
        line-height: 1.7;
        font-size: 16px;
    }

    /* Remove first-letter styling for cleaner look */
    .scholar-book-content p:first-of-type::first-letter {
        font-family: inherit;
        float: none;
        font-size: inherit;
        line-height: inherit;
        margin: 0;
        color: inherit;
        font-weight: inherit;
    }

    /* Chapters Section */
    .scholar-chapters {
        margin-top: calc(var(--scholar-spacing) * 2);
        padding-top: calc(var(--scholar-spacing) * 2);
        border-top: 2px solid var(--scholar-border);
    }

    .scholar-chapters-title {
        font-family: 'Playfair Display', serif;
        font-size: 1.75rem;
        font-weight: 700;
        margin: 0 0 1.5rem 0;
        color: var(--scholar-primary);
    }

    .scholar-chapters-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .scholar-chapter-item {
        background: var(--scholar-paper);
        border: 1px solid var(--scholar-border);
        padding: 1.5rem;
        margin-bottom: 1rem;
        border-radius: 2px;
        transition: all 0.3s ease;
        position: relative;
        padding-left: 4rem;
    }

    .scholar-chapter-item:hover {
        border-color: var(--scholar-accent);
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        transform: translateX(4px);
    }

    .scholar-chapter-number {
        position: absolute;
        left: 1.5rem;
        top: 50%;
        transform: translateY(-50%);
        font-family: 'Playfair Display', serif;
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--scholar-accent);
        opacity: 0.3;
    }

    .scholar-chapter-title {
        font-family: 'Playfair Display', serif;
        font-size: 1.1rem;
        font-weight: 600;
        margin: 0 0 0.5rem 0;
        color: var(--scholar-primary);
    }

    .scholar-chapter-link {
        color: inherit;
        text-decoration: none;
        transition: color 0.2s;
    }

    .scholar-chapter-link:hover {
        color: var(--scholar-accent);
    }

    .scholar-chapter-meta {
        font-size: 0.9rem;
        color: var(--scholar-secondary);
    }

    /* Info Badges - Updated */
    .scholar-badge {
        display: inline-block;
        padding: 0.35rem 0.85rem;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        border-radius: 6px;
        margin-right: 0.625rem;
        margin-bottom: 0.625rem;
        transition: all 0.3s ease;
    }

    .scholar-badge-doi {
        background: rgba(3, 117, 144, 0.1);
        color: #037590;
        border: 1px solid rgba(3, 117, 144, 0.3);
    }

    .scholar-badge-isbn {
        background: var(--scholar-bg);
        color: var(--scholar-secondary);
        border: 1px solid var(--scholar-border);
    }

    .scholar-badge-pdf {
        background: rgba(3, 117, 144, 0.1);
        color: #037590;
        font-weight: 700;
        border: 1px solid #037590;
    }

    .scholar-badge:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    
    .scholar-badge-pdf img {
        vertical-align: middle;
        margin-right: 4px;
    }

    /* Citation Box */
    .scholar-citation-box {
        background: #f9f9f7;
        border-left: 4px solid var(--scholar-accent);
        padding: 1.5rem;
        margin: 2rem 0;
        font-family: 'IBM Plex Mono', 'Courier New', monospace;
        font-size: 0.9rem;
        line-height: 1.6;
    }

    .scholar-citation-box h4 {
        font-family: 'Libre Franklin', 'Franklin Gothic', sans-serif;
        font-size: 0.85rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        margin: 0 0 1rem 0;
        color: var(--scholar-accent);
    }

    /* Animations */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .scholar-book-header {
        animation: fadeInUp 0.6s ease-out;
    }

    .scholar-book-sidebar {
        animation: fadeInUp 0.6s ease-out 0.1s backwards;
    }

    .scholar-book-content {
        animation: fadeInUp 0.6s ease-out 0.2s backwards;
    }

    /* Print Styles */
    @media print {
        .scholar-book-sidebar,
        .scholar-actions,
        .scholar-chapters,
        .scholar-related-carousel {
            display: none;
        }
        
        .scholar-book-content {
            box-shadow: none;
            border: none;
        }
    }

    /* === RELATED BOOKS CAROUSEL === */
    .scholar-related-carousel {
        margin-top: 3rem;
        padding-top: 2.5rem;
        border-top: 2px solid var(--scholar-border);
        width: 100%;
        overflow: hidden;
    }

    .scholar-carousel-title {
        font-family: 'Playfair Display', serif;
        font-size: 1.75rem;
        font-weight: 700;
        margin: 0 0 1.5rem 0;
        color: var(--scholar-primary);
    }

    @media (max-width: 768px) {
        .scholar-carousel-title {
            font-size: 1.5rem;
        }
    }

    .scholar-carousel-container {
        position: relative;
        overflow: hidden;
        padding: 0.5rem 0;
        width: 100%;
    }

    /* Carousel Navigation Arrows */
    .scholar-carousel-nav {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 40px;
        height: 40px;
        background: var(--scholar-paper);
        border: 2px solid var(--scholar-accent);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        z-index: 10;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .scholar-carousel-nav:hover {
        background: var(--scholar-accent);
        transform: translateY(-50%) scale(1.1);
        box-shadow: 0 4px 12px rgba(3,117,144,0.3);
    }

    .scholar-carousel-nav:hover svg {
        stroke: white;
    }

    .scholar-carousel-nav svg {
        width: 20px;
        height: 20px;
        stroke: var(--scholar-accent);
        transition: stroke 0.3s ease;
    }

    .scholar-carousel-nav.prev {
        left: -15px;
    }

    .scholar-carousel-nav.next {
        right: -15px;
    }

    @media (max-width: 768px) {
        .scholar-carousel-nav {
            width: 35px;
            height: 35px;
        }
        
        .scholar-carousel-nav.prev {
            left: 0;
        }
        
        .scholar-carousel-nav.next {
            right: 0;
        }
    }

    .scholar-carousel-track {
        display: flex;
        gap: 1.5rem;
        overflow-x: auto;
        scroll-behavior: smooth;
        scrollbar-width: thin;
        scrollbar-color: var(--scholar-accent) var(--scholar-bg);
        padding-bottom: 1rem;
    }

    .scholar-carousel-track::-webkit-scrollbar {
        height: 8px;
    }

    .scholar-carousel-track::-webkit-scrollbar-track {
        background: var(--scholar-bg);
        border-radius: 4px;
    }

    .scholar-carousel-track::-webkit-scrollbar-thumb {
        background: var(--scholar-accent);
        border-radius: 4px;
    }

    .scholar-carousel-track::-webkit-scrollbar-thumb:hover {
        background: var(--scholar-accent-light);
    }

    .scholar-carousel-card {
        flex: 0 0 152px;
        background: var(--scholar-paper);
        border: 1px solid var(--scholar-border);
        border-radius: 8px;
        overflow: hidden;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    }

    .scholar-carousel-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 16px rgba(3,117,144,0.12);
        border-color: var(--scholar-accent);
    }

    .scholar-carousel-cover {
        position: relative;
        width: 152px;
        height: auto;
        aspect-ratio: 2/3;
        overflow: hidden;
        background: linear-gradient(135deg, #f7f7f7, #e9ecef);
    }

    .scholar-carousel-cover img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .scholar-carousel-card:hover .scholar-carousel-cover img {
        transform: scale(1.05);
    }

    .scholar-carousel-content {
        padding: 0.75rem;
    }

    .scholar-carousel-title-text {
        font-family: 'Open Sans', sans-serif;
        font-size: 14px;
        font-weight: 700;
        line-height: 1.3;
        margin: 0 0 0.375rem 0;
        color: var(--scholar-primary);
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .scholar-carousel-title-text a {
        color: inherit;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .scholar-carousel-title-text a:hover {
        color: var(--scholar-accent);
    }

    .scholar-carousel-authors {
        font-size: 0.75rem;
        color: var(--scholar-secondary);
        line-height: 1.3;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* Responsive Carousel */
    @media (max-width: 768px) {
        .scholar-carousel-card {
            flex: 0 0 140px;
        }
        
        .scholar-carousel-cover {
            width: 140px;
        }
        
        .scholar-carousel-title-text {
            font-size: 13px;
        }
        
        .scholar-carousel-authors {
            font-size: 0.7rem;
        }
    }

    @media (max-width: 480px) {
        .scholar-carousel-card {
            flex: 0 0 120px;
        }
        
        .scholar-carousel-cover {
            width: 120px;
        }
        
        .scholar-carousel-content {
            padding: 0.5rem;
        }
        
        .scholar-carousel-title-text {
            font-size: 12px;
        }
        
        .scholar-carousel-authors {
            font-size: 0.65rem;
        }
    }

    /* =====================================================
       DARK MODE OVERRIDES — Single Page
       Semua elemen dengan warna hardcoded diganti ke vars
       ===================================================== */

    /* Container transisi warna */
    .scholar-book-container,
    .scholar-book-container * {
        transition: background-color 0.3s ease, border-color 0.3s ease, color 0.3s ease, box-shadow 0.3s ease;
    }

    /* Metadata sections */
    [data-theme="dark"] .scholar-metadata-section {
        background: var(--scholar-paper);
        border-color: var(--scholar-border);
        box-shadow: 0 2px 8px rgba(0,0,0,0.2);
    }

    [data-theme="dark"] .scholar-metadata-section h3 {
        border-bottom-color: var(--scholar-border);
    }

    /* Author items */
    [data-theme="dark"] .scholar-author-item {
        border-bottom-color: rgba(255,255,255,0.07);
    }

    /* Main content area */
    [data-theme="dark"] .scholar-book-content {
        background: var(--scholar-paper);
        border-color: var(--scholar-border);
        box-shadow: 0 2px 8px rgba(0,0,0,0.2);
    }

    [data-theme="dark"] .scholar-book-content h2,
    [data-theme="dark"] .scholar-book-content h3 {
        border-bottom-color: var(--scholar-border);
    }

    [data-theme="dark"] .scholar-book-content p {
        color: var(--scholar-primary);
    }

    /* Chapter items */
    [data-theme="dark"] .scholar-chapter-item {
        background: var(--scholar-paper);
        border-color: var(--scholar-border);
    }

    [data-theme="dark"] .scholar-chapter-item:hover {
        border-color: var(--scholar-accent);
        box-shadow: 0 4px 12px rgba(0,0,0,0.25);
    }

    /* Citation box */
    [data-theme="dark"] .scholar-citation-box {
        background: var(--scholar-citation-bg);
        color: var(--scholar-secondary);
    }

    /* Badges */
    [data-theme="dark"] .scholar-badge-isbn {
        background: var(--scholar-paper);
        border-color: var(--scholar-border);
        color: var(--scholar-secondary);
    }

    [data-theme="dark"] .scholar-badge-doi,
    [data-theme="dark"] .scholar-badge-pdf {
        background: rgba(2,178,191,0.1);
        color: var(--scholar-accent);
        border-color: rgba(2,178,191,0.3);
    }

    /* Book cover */
    [data-theme="dark"] .scholar-book-cover {
        border-color: var(--scholar-border);
        box-shadow: 0 4px 12px rgba(0,0,0,0.4), 0 2px 6px rgba(0,0,0,0.3);
    }

    /* Carousel */
    [data-theme="dark"] .scholar-related-carousel {
        border-top-color: var(--scholar-border);
    }

    [data-theme="dark"] .scholar-carousel-card {
        background: var(--scholar-paper);
        border-color: var(--scholar-border);
        box-shadow: 0 2px 8px rgba(0,0,0,0.2);
    }

    [data-theme="dark"] .scholar-carousel-card:hover {
        box-shadow: 0 8px 16px rgba(2,178,191,0.15);
        border-color: var(--scholar-accent);
    }

    [data-theme="dark"] .scholar-carousel-cover {
        background: linear-gradient(135deg, #1e2a3a, #263245);
    }

    [data-theme="dark"] .scholar-carousel-nav {
        background: var(--scholar-paper);
        border-color: var(--scholar-accent);
        box-shadow: 0 2px 8px rgba(0,0,0,0.3);
    }

    [data-theme="dark"] .scholar-carousel-nav:hover {
        background: var(--scholar-accent);
    }

    [data-theme="dark"] .scholar-carousel-track {
        scrollbar-color: var(--scholar-accent) var(--scholar-paper);
    }

    [data-theme="dark"] .scholar-carousel-track::-webkit-scrollbar-track {
        background: var(--scholar-paper);
    }

    /* Usage metrics boxes */
    [data-theme="dark"] .scholar-metric-item {
        background: rgba(2,178,191,0.08) !important;
    }

    [data-theme="dark"] .scholar-metric-item div:first-child {
        color: var(--scholar-accent) !important;
    }

    [data-theme="dark"] .scholar-metric-item div:last-child {
        color: var(--scholar-secondary) !important;
    }

    /* Action buttons */
    [data-theme="dark"] .scholar-btn-secondary {
        color: var(--scholar-accent);
        border-color: var(--scholar-accent);
    }

    [data-theme="dark"] .scholar-btn-secondary:hover {
        background: var(--scholar-accent);
        color: white;
    }

    /* Chapters section */
    [data-theme="dark"] .scholar-chapters {
        border-top-color: var(--scholar-border);
    }

    /* Print stays light */
    @media print {
        [data-theme="dark"] .scholar-book-container {
            background: #fff !important;
            color: #000 !important;
        }
    }
</style>

<?php while (have_posts()) : the_post(); 
    // Get all metadata
    $cover_id = get_post_meta(get_the_ID(), '_sbpp_book_cover', true);
    $subtitle = get_post_meta(get_the_ID(), '_sbpp_book_subtitle', true);
    $description = get_post_meta(get_the_ID(), '_sbpp_book_description', true);
    $language = get_post_meta(get_the_ID(), '_sbpp_book_language', true);
    $authors = get_post_meta(get_the_ID(), '_sbpp_authors', true);
    $editors = get_post_meta(get_the_ID(), '_sbpp_editors', true);
    $publisher = get_post_meta(get_the_ID(), '_sbpp_book_publisher', true);
    $publisher_city = get_post_meta(get_the_ID(), '_sbpp_publisher_city', true);
    $pub_date = get_post_meta(get_the_ID(), '_sbpp_publication_date', true);
    $isbn = get_post_meta(get_the_ID(), '_sbpp_isbn', true);
    $doi = get_post_meta(get_the_ID(), '_sbpp_doi', true);
    $dimensions = get_post_meta(get_the_ID(), '_sbpp_dimensions', true);
    $price = get_post_meta(get_the_ID(), '_sbpp_price', true);
    $access_category = get_post_meta(get_the_ID(), '_sbpp_access_category', true);
    
    // PDF data
    $pdf_available = get_post_meta(get_the_ID(), '_sbpp_pdf_available', true);
    $pdf_source = get_post_meta(get_the_ID(), '_sbpp_pdf_source', true);
    $pdf_url = '';
    
    if ($pdf_available) {
        if ($pdf_source === 'wordpress') {
            $pdf_wordpress_id = get_post_meta(get_the_ID(), '_sbpp_pdf_wordpress_id', true);
            if ($pdf_wordpress_id) {
                $pdf_url = wp_get_attachment_url($pdf_wordpress_id);
            }
        } elseif ($pdf_source === 'gdrive') {
            $pdf_gdrive_id = get_post_meta(get_the_ID(), '_sbpp_pdf_gdrive_id', true);
            if ($pdf_gdrive_id) {
                $pdf_url = 'https://drive.google.com/uc?export=download&id=' . $pdf_gdrive_id;
            }
        }
    }
    
    $year = $pub_date ? date('Y', strtotime($pub_date)) : '';
?>

<div class="scholar-book-container" data-theme="dark">

    <!-- Theme Toggle — anchored di dalam container, tidak tertutup WP header -->
    <div class="sbp-theme-toggle-wrap">
        <button class="sbp-theme-toggle" onclick="sbpToggleTheme()" aria-label="Toggle dark/light mode">
            <!-- Sun icon -->
            <svg class="sbp-icon-sun" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
            <div class="sbp-toggle-switch" aria-hidden="true">
                <div class="sbp-toggle-slider"></div>
            </div>
            <!-- Moon icon -->
            <svg class="sbp-icon-moon" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
            </svg>
            <span class="sbp-toggle-label">Theme</span>
        </button>
    </div>

    <!-- Main Grid -->
    <div class="scholar-book-grid">
        
        <!-- Left Column: Cover + Sidebar -->
        <aside class="scholar-book-sidebar">
            
            <?php if ($cover_id): 
                $cover_url = wp_get_attachment_url($cover_id);
            ?>
                <div class="scholar-book-cover-container">
                    <img src="<?php echo esc_url($cover_url); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" class="scholar-book-cover">
                </div>
            <?php elseif (has_post_thumbnail()): ?>
                <div class="scholar-book-cover-container">
                    <?php the_post_thumbnail('large', array('class' => 'scholar-book-cover')); ?>
                </div>
            <?php endif; ?>
            
            <!-- Usage Metrics -->
            <?php
            $metrics = SBPP_Usage_Metrics::get_metrics(get_the_ID());
            if ($metrics['views'] > 0 || $metrics['downloads'] > 0):
            ?>
            <div class="scholar-metadata-section">
                <h3>Usage Metrics</h3>
                
                <div class="scholar-metrics-grid" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px; text-align: center;">
                    <div class="scholar-metric-item" style="padding: 15px; background: #f0f8ff; border-radius: 4px;">
                        <div style="font-size: 2rem; font-weight: 700; color: #2271b1;">
                            <?php echo number_format($metrics['views']); ?>
                        </div>
                        <div style="font-size: 0.75rem; color: #666; text-transform: uppercase; letter-spacing: 0.05em; margin-top: 5px;">
                            Views
                        </div>
                    </div>
                    
                    <div class="scholar-metric-item" style="padding: 15px; background: #f0fff4; border-radius: 4px;">
                        <div style="font-size: 2rem; font-weight: 700; color: #059669;">
                            <?php echo number_format($metrics['downloads']); ?>
                        </div>
                        <div style="font-size: 0.75rem; color: #666; text-transform: uppercase; letter-spacing: 0.05em; margin-top: 5px;">
                            Downloads
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            
            <!-- Actions -->
            <div class="scholar-actions">
                <?php if ($pdf_url): ?>
                    <a href="<?php echo esc_url(SBPP_Usage_Metrics::get_tracked_download_url(get_the_ID())); ?>" 
                       class="scholar-btn scholar-btn-primary" 
                       target="_blank" 
                       rel="noopener">
                        <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
                            <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/>
                        </svg>
                        Download PDF
                    </a>
                <?php endif; ?>
                
                <?php if ($doi): ?>
                    <a href="https://doi.org/<?php echo esc_attr($doi); ?>" 
                       class="scholar-btn scholar-btn-secondary" 
                       target="_blank" 
                       rel="noopener">
                        <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M4.715 6.542 3.343 7.914a3 3 0 1 0 4.243 4.243l1.828-1.829A3 3 0 0 0 8.586 5.5L8 6.086a1.002 1.002 0 0 0-.154.199 2 2 0 0 1 .861 3.337L6.88 11.45a2 2 0 1 1-2.83-2.83l.793-.792a4.018 4.018 0 0 1-.128-1.287z"/>
                            <path d="M6.586 4.672A3 3 0 0 0 7.414 9.5l.775-.776a2 2 0 0 1-.896-3.346L9.12 3.55a2 2 0 1 1 2.83 2.83l-.793.792c.112.42.155.855.128 1.287l1.372-1.372a3 3 0 1 0-4.243-4.243L6.586 4.672z"/>
                        </svg>
                        View on DOI
                    </a>
                <?php endif; ?>
                
                <button onclick="window.print()" class="scholar-btn scholar-btn-secondary">
                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/>
                        <path d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2H5zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4V3zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2H5zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1z"/>
                    </svg>
                    Print Page
                </button>
            </div>
            
            <!-- Citation Box -->
            <?php if ($authors && $publisher && $year): ?>
                <div class="scholar-citation-box">
                    <h4>Cite This Book</h4>
                    <?php
                    $author_string = '';
                    if (is_array($authors) && !empty($authors)) {
                        $author_names = array();
                        foreach ($authors as $author) {
                            if (!empty($author['last_name']) && !empty($author['first_name'])) {
                                $author_names[] = $author['last_name'] . ', ' . $author['first_name'][0] . '.';
                            }
                        }
                        $author_string = implode(', ', $author_names);
                    }
                    
                    $full_title = get_the_title();
                    ?>
                    <p style="margin: 0; word-wrap: break-word;">
                        <?php echo esc_html($author_string); ?> (<?php echo esc_html($year); ?>). 
                        <em><?php echo esc_html($full_title); ?></em>. 
                        <?php echo esc_html($publisher_city); ?>: <?php echo esc_html($publisher); ?>.
                        <?php if ($doi): ?>
                            https://doi.org/<?php echo esc_html($doi); ?>
                        <?php endif; ?>
                    </p>
                </div>
            <?php endif; ?>
            
        </aside>
        
        <!-- Right Column: Header + Publication Details + Content -->
        <main class="scholar-book-main-column">
            
            <!-- Header (moved here) -->
            <header class="scholar-book-header">
                <h1 class="scholar-book-title"><?php the_title(); ?></h1>
                <?php if ($subtitle): ?>
                    <h2 class="scholar-book-subtitle"><?php echo esc_html($subtitle); ?></h2>
                <?php endif; ?>
                
                <div class="scholar-header-badges">
                    <?php if ($isbn): ?>
                        <span class="scholar-badge scholar-badge-isbn">ISBN: <?php echo esc_html($isbn); ?></span>
                    <?php endif; ?>
                    <?php if ($doi): ?>
                        <span class="scholar-badge scholar-badge-doi">DOI: <?php echo esc_html($doi); ?></span>
                    <?php endif; ?>
                    <?php if ($pdf_url && $access_category === 'open'): ?>
                        <span class="scholar-badge scholar-badge-pdf">
                            <img src="<?php echo plugins_url('assets/images/open-access-logo.svg', dirname(__FILE__)); ?>" alt="Open Access" width="16" height="16" style="vertical-align: middle; margin-right: 4px;">
                            Open Access
                        </span>
                    <?php endif; ?>
                </div>
            </header>
            
            <!-- Publication Details (moved here) -->
            <div class="scholar-metadata-section">
                <h3>Publication Details</h3>
                
                <?php if (!empty($authors) && is_array($authors)): ?>
                    <div class="scholar-meta-item">
                        <div class="scholar-meta-label">Author<?php echo count($authors) > 1 ? 's' : ''; ?>:</div>
                        <ul class="scholar-authors-list">
                            <?php foreach ($authors as $author): ?>
                                <?php if (!empty($author['first_name']) && !empty($author['last_name'])): ?>
                                    <li class="scholar-author-item">
                                        <?php echo esc_html($author['first_name'] . ' ' . $author['last_name']); ?>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
                
                <?php if (!empty($editors) && is_array($editors)): ?>
                    <div class="scholar-meta-item">
                        <div class="scholar-meta-label">Editor<?php echo count($editors) > 1 ? 's' : ''; ?>:</div>
                        <ul class="scholar-authors-list">
                            <?php foreach ($editors as $editor): ?>
                                <?php if (!empty($editor['first_name']) && !empty($editor['last_name'])): ?>
                                    <li class="scholar-author-item">
                                        <?php echo esc_html($editor['first_name'] . ' ' . $editor['last_name']); ?>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
                
                <?php if ($publisher): ?>
                    <div class="scholar-meta-item">
                        <span class="scholar-meta-label">Publisher:</span>
                        <span class="scholar-meta-value"><?php echo esc_html($publisher); ?></span>
                    </div>
                <?php endif; ?>
                
                <?php if ($publisher_city): ?>
                    <div class="scholar-meta-item">
                        <span class="scholar-meta-label">City:</span>
                        <span class="scholar-meta-value"><?php echo esc_html($publisher_city); ?></span>
                    </div>
                <?php endif; ?>
                
                <?php if ($year): ?>
                    <div class="scholar-meta-item">
                        <span class="scholar-meta-label">Year:</span>
                        <span class="scholar-meta-value"><?php echo esc_html($year); ?></span>
                    </div>
                <?php endif; ?>
                
                <?php if ($language): ?>
                    <div class="scholar-meta-item">
                        <span class="scholar-meta-label">Language:</span>
                        <span class="scholar-meta-value"><?php echo esc_html($language); ?></span>
                    </div>
                <?php endif; ?>
                
                <?php if ($dimensions): ?>
                    <div class="scholar-meta-item">
                        <span class="scholar-meta-label">Dimensions:</span>
                        <span class="scholar-meta-value"><?php echo esc_html($dimensions); ?></span>
                    </div>
                <?php endif; ?>
                
                <?php if ($price): ?>
                    <div class="scholar-meta-item">
                        <span class="scholar-meta-label">Price:</span>
                        <span class="scholar-meta-value"><?php echo esc_html($price); ?></span>
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- About This Book -->
            <div class="scholar-book-content">
                <h3>About This Book</h3>
            
            <?php if ($description): ?>
                <div class="scholar-book-description">
                    <?php echo wpautop($description); ?>
                </div>
            <?php endif; ?>
            
            <?php if (get_the_content()): ?>
                <div class="scholar-book-full-content">
                    <?php the_content(); ?>
                </div>
            <?php endif; ?>
            </div>
            <!-- End About This Book -->
            
            <?php
            // Get chapters if any
            $chapters = new WP_Query(array(
                'post_type' => 'scholar_chapter',
                'posts_per_page' => -1,
                'meta_query' => array(
                    array(
                        'key' => '_sbpp_parent_book',
                        'value' => get_the_ID()
                    )
                ),
                'orderby' => 'meta_value_num',
                'meta_key' => '_sbpp_chapter_first_page',
                'order' => 'ASC'
            ));
            
            if ($chapters->have_posts()): ?>
                <div class="scholar-chapters">
                    <h2 class="scholar-chapters-title">Table of Contents</h2>
                    <ol class="scholar-chapters-list">
                        <?php 
                        $chapter_num = 1;
                        while ($chapters->have_posts()): $chapters->the_post(); 
                            $first_page = get_post_meta(get_the_ID(), '_sbpp_chapter_first_page', true);
                            $last_page = get_post_meta(get_the_ID(), '_sbpp_chapter_last_page', true);
                            $chapter_authors = get_post_meta(get_the_ID(), '_sbpp_chapter_authors', true);
                        ?>
                            <li class="scholar-chapter-item">
                                <span class="scholar-chapter-number"><?php echo $chapter_num; ?></span>
                                <h3 class="scholar-chapter-title">
                                    <a href="<?php the_permalink(); ?>" class="scholar-chapter-link">
                                        <?php the_title(); ?>
                                    </a>
                                </h3>
                                <div class="scholar-chapter-meta">
                                    <?php if (!empty($chapter_authors) && is_array($chapter_authors)): ?>
                                        <?php
                                        $chapter_author_names = array();
                                        foreach ($chapter_authors as $author) {
                                            if (!empty($author['first_name']) && !empty($author['last_name'])) {
                                                $chapter_author_names[] = $author['first_name'] . ' ' . $author['last_name'];
                                            }
                                        }
                                        ?>
                                        <span>By <?php echo esc_html(implode(', ', $chapter_author_names)); ?></span>
                                    <?php endif; ?>
                                    <?php if ($first_page && $last_page): ?>
                                        <span> • Pages <?php echo esc_html($first_page . '-' . $last_page); ?></span>
                                    <?php endif; ?>
                                </div>
                            </li>
                        <?php 
                        $chapter_num++;
                        endwhile; 
                        wp_reset_postdata();
                        ?>
                    </ol>
                </div>
            <?php endif; ?>
            
            <!-- Related Books Carousel -->
            <?php
            // Get current book's categories
            $current_cats = wp_get_post_terms(get_the_ID(), 'scholar_category', array('fields' => 'ids'));
            
            // Build query args - prioritize same category
            $related_args = array(
                'post_type' => 'scholar_book',
                'posts_per_page' => 10,
                'post__not_in' => array(get_the_ID()),
                'orderby' => 'rand'
            );
            
            if (!empty($current_cats)) {
                $related_args['tax_query'] = array(
                    array(
                        'taxonomy' => 'scholar_category',
                        'field' => 'term_id',
                        'terms' => $current_cats
                    )
                );
            }
            
            $related_books = new WP_Query($related_args);
            
            // If not enough from same category, get more random books
            if ($related_books->post_count < 6) {
                wp_reset_postdata();
                $related_args = array(
                    'post_type' => 'scholar_book',
                    'posts_per_page' => 10,
                    'post__not_in' => array(get_the_ID()),
                    'orderby' => 'rand'
                );
                $related_books = new WP_Query($related_args);
            }
            
            if ($related_books->have_posts()):
            ?>
            <div class="scholar-related-carousel">
                <h2 class="scholar-carousel-title">Related Books</h2>
                <div class="scholar-carousel-container">
                    <!-- Previous Arrow -->
                    <button class="scholar-carousel-nav prev" onclick="scrollCarousel('prev')" aria-label="Previous">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </button>
                    
                    <!-- Next Arrow -->
                    <button class="scholar-carousel-nav next" onclick="scrollCarousel('next')" aria-label="Next">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>
                    
                    <div class="scholar-carousel-track" id="scholarCarouselTrack">
                        <?php while ($related_books->have_posts()): $related_books->the_post(); 
                            $cover_id = get_post_meta(get_the_ID(), '_sbpp_book_cover', true);
                            $authors = get_post_meta(get_the_ID(), '_sbpp_authors', true);
                            $author_names = array();
                            if (!empty($authors) && is_array($authors)) {
                                foreach ($authors as $author) {
                                    if (!empty($author['first_name']) && !empty($author['last_name'])) {
                                        $author_names[] = $author['first_name'] . ' ' . $author['last_name'];
                                    }
                                }
                            }
                        ?>
                            <article class="scholar-carousel-card">
                                <div class="scholar-carousel-cover">
                                    <?php if ($cover_id): ?>
                                        <img src="<?php echo esc_url(wp_get_attachment_url($cover_id)); ?>" 
                                             alt="<?php echo esc_attr(get_the_title()); ?>"
                                             loading="lazy">
                                    <?php elseif (has_post_thumbnail()): ?>
                                        <?php the_post_thumbnail('medium', array('loading' => 'lazy')); ?>
                                    <?php else: ?>
                                        <svg class="scholar-cover-fallback" width="40" height="40" fill="currentColor" viewBox="0 0 16 16">
                                            <path d="M1 2.828c.885-.37 2.154-.769 3.388-.893 1.33-.134 2.458.063 3.112.752v9.746c-.935-.53-2.12-.603-3.213-.493-1.18.12-2.37.461-3.287.811V2.828zm7.5-.141c.654-.689 1.782-.886 3.112-.752 1.234.124 2.503.523 3.388.893v9.923c-.918-.35-2.107-.692-3.287-.81-1.094-.111-2.278-.039-3.213.492V2.687zM8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783z"/>
                                        </svg>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="scholar-carousel-content">
                                    <h3 class="scholar-carousel-title-text">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h3>
                                    <?php if (!empty($author_names)): ?>
                                        <div class="scholar-carousel-authors">
                                            <?php echo esc_html(implode(', ', $author_names)); ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </article>
                        <?php endwhile; wp_reset_postdata(); ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            
        </main>
        
    </div>
    
</div>

<?php endwhile; ?>

<script>
// =====================================================
// DARK / LIGHT THEME — Single Book Page
// Default: DARK mode
// Shared localStorage key 'scholarTheme' dengan archive
// =====================================================
(function() {
    // Terapkan tema tersimpan SEBELUM render (default: dark)
    var saved = localStorage.getItem('scholarTheme') || 'dark';
    var container = document.querySelector('.scholar-book-container');
    if (container) container.setAttribute('data-theme', saved);
})();

function sbpToggleTheme() {
    var container = document.querySelector('.scholar-book-container');
    if (!container) return;
    var current = container.getAttribute('data-theme') || 'dark';
    var next    = current === 'light' ? 'dark' : 'light';
    container.setAttribute('data-theme', next);
    localStorage.setItem('scholarTheme', next);
}

// Terapkan lagi setelah DOM ready (fallback)
document.addEventListener('DOMContentLoaded', function() {
    var saved = localStorage.getItem('scholarTheme') || 'dark';
    var container = document.querySelector('.scholar-book-container');
    if (container) container.setAttribute('data-theme', saved);
});

// Carousel Navigation
function scrollCarousel(direction) {
    const track = document.getElementById('scholarCarouselTrack');
    if (!track) return;
    const scrollAmount = 320;
    if (direction === 'next') {
        track.scrollBy({ left: scrollAmount, behavior: 'smooth' });
    } else {
        track.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
    }
}

// Carousel arrows fade at start/end
document.addEventListener('DOMContentLoaded', function() {
    const track   = document.getElementById('scholarCarouselTrack');
    const prevBtn = document.querySelector('.scholar-carousel-nav.prev');
    const nextBtn = document.querySelector('.scholar-carousel-nav.next');
    if (!track || !prevBtn || !nextBtn) return;

    function updateArrows() {
        const atStart = track.scrollLeft <= 0;
        const atEnd   = track.scrollLeft >= (track.scrollWidth - track.clientWidth - 10);
        prevBtn.style.opacity = atStart ? '0.3' : '1';
        prevBtn.style.cursor  = atStart ? 'default' : 'pointer';
        nextBtn.style.opacity = atEnd   ? '0.3' : '1';
        nextBtn.style.cursor  = atEnd   ? 'default' : 'pointer';
    }

    track.addEventListener('scroll', updateArrows);
    updateArrows();
});
</script>

<?php get_footer(); ?>
