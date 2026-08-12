/**
 * Scholar Book Publisher Pro - Frontend JavaScript
 * 
 * @package Scholar_Book_Publisher
 * @version 1.0.0
 */

(function($) {
    'use strict';
    
    $(document).ready(function() {
        
        // Initialize any frontend interactions here
        
        // Example: Copy citation to clipboard
        $('.scholar-copy-citation').on('click', function(e) {
            e.preventDefault();
            var citationText = $(this).siblings('.scholar-citation-box').text().trim();
            
            if (navigator.clipboard) {
                navigator.clipboard.writeText(citationText).then(function() {
                    alert('Citation copied to clipboard!');
                }).catch(function(err) {
                    console.error('Failed to copy citation:', err);
                });
            }
        });
        
    });
    
})(jQuery);
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
        data.append('action',     (typeof sbpp_ajax !== 'undefined' && sbpp_ajax.action) ? sbpp_ajax.action : 'sbpp_filter_books');
        data.append('security',   (typeof sbpp_ajax !== 'undefined' && sbpp_ajax.nonce) ? sbpp_ajax.nonce : '');
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
