# Scholar Book Publisher Pro — Changelog

## Version 1.2.1 (2024-02-18) — Stability & Integration Release

### Fixed
- ✅ Version consistency across all template files
- ✅ Verified all class loading and instantiation
- ✅ Confirmed hook priorities and integration points
- ✅ Validated security measures (nonce, escaping, sanitization)

### Verified
- ✅ URL structure: `/books/` working correctly
- ✅ Automatic 301 redirects: `/catalogs/` → `/books/`
- ✅ All 7 metadata standards outputting correctly
- ✅ Frontend features: search, filters, dark theme
- ✅ AJAX system: secure and functional
- ✅ Mobile responsiveness verified

### Documentation
- ✅ Comprehensive upgrade guide included
- ✅ System integration verified
- ✅ All features tested and confirmed

---

## Version 1.2.0 (2024-02-18) — Major Update

### Added — URL Structure
- ✅ New semantic URLs: `/books/` instead of `/catalogs/`
- ✅ Automatic 301 redirects for all legacy URLs
- ✅ SEO migration helper class
- ✅ Server rules generator (Apache & Nginx)
- ✅ Enhanced admin upgrade notice

### Added — Comprehensive Metadata
- ✅ Google Scholar (Highwire Press) - complete tags
- ✅ AI Crawler optimization (GPT, Claude, Perplexity)
- ✅ Open Graph Protocol (Facebook, LinkedIn, WhatsApp)
- ✅ Twitter Cards with rich preview
- ✅ Dublin Core metadata (universal compatibility)
- ✅ Schema.org JSON-LD (rich search results)
- ✅ Archive page as CollectionPage
- ✅ Chapter-to-book relationships

### Enhanced
- ✅ robots.txt crawler directives
- ✅ Canonical URLs for SEO
- ✅ Sitemap references updated
- ✅ Access mode declarations (Open Access support)
- ✅ View count integration in structured data

---

## Version 1.1.11 (2024-02-18)

### Changed
- ✅ Restored magnifying glass icon in search section title
- ✅ Kept clean input field (no icon inside)

---

## Version 1.1.10 (2024-02-18)

### Changed
- ✅ Removed magnifying glass icons from search input
- ✅ Cleaner, simpler search UI

---

## Version 1.1.9 (2024-02-18)

### Added
- ✅ Search functionality: title and author search
- ✅ Debounced search (500ms delay)
- ✅ Clear button for search input
- ✅ AJAX integration with existing filters

---

## Version 1.1.8 (2024-02-18)

### Fixed
- ✅ Dark theme white flash on archive page
- ✅ Dark theme as default on all pages
- ✅ Mobile toggle visibility (z-index fix)

### Changed
- ✅ Anti-flash script prevents white flash
- ✅ Default theme: dark mode

---

## Version 1.1.7 (2024-02-17)

### Added
- ✅ Dark/light theme toggle on single book page
- ✅ Shared theme preference across pages
- ✅ Mobile-optimized toggle positioning

---

## Version 1.1.6 (2024-02-17)

### Fixed
- ✅ Definitive pagination fix (50 books per page)
- ✅ Custom WP_Query implementation
- ✅ Enhanced pre_get_posts hook with 3 detection methods

---

## Version 1.1.5 (2024-02-16)

### Fixed
- ✅ Pagination hook placement
- ✅ AJAX filter system
- ✅ Theme toggle positioning

---

## Version 1.1.0-1.1.4

### Features
- ✅ Archive page redesign (Tosca theme)
- ✅ Single page 2-column layout
- ✅ Carousel navigation
- ✅ Dark/light theme toggle
- ✅ Responsive design (14+ breakpoints)
- ✅ AJAX filters (category, year, open access)
- ✅ Usage metrics (views, downloads)
- ✅ Compact card design
- ✅ Open Sans typography

---

## Version 1.0.0 — Initial Release

### Core Features
- ✅ Custom post types (Books, Chapters)
- ✅ Hierarchical chapter structure
- ✅ Author/editor management
- ✅ ISBN & DOI support
- ✅ PDF management (WordPress & Google Drive)
- ✅ Google Scholar metadata
- ✅ Taxonomies (categories, tags)
- ✅ Usage tracking
- ✅ Admin interface
- ✅ Template system

---

## Feature Summary (v1.2.1)

| Category | Features |
|----------|----------|
| **URLs** | Semantic `/books/` structure, 301 redirects |
| **SEO** | 7 metadata standards, rich results ready |
| **Crawlers** | Google Scholar, AI (GPT/Claude), social media |
| **Frontend** | Search, filters, dark theme, responsive |
| **Performance** | Custom queries, AJAX, optimized loading |
| **Security** | Nonce verification, sanitization, escaping |
| **UX** | Clean design, mobile-first, accessibility |

---

## Upgrade Path

- **From 1.0.x → 1.2.1:** Major update, requires permalink flush
- **From 1.1.x → 1.2.1:** URL structure change, automatic redirects active
- **Within 1.2.x:** Minor updates, no action required

---

## Support & Documentation

- Installation: See README.md
- Upgrade: See UPGRADE-1.2.0.md
- Technical: See code comments
- Issue: Check WordPress error logs

---

**Last Updated:** February 18, 2024
**Current Version:** 1.2.1
**Status:** Production Ready ✅
