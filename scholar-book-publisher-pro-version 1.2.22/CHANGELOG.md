# Changelog

## [1.2.20] - 2026-05-17
### Fixed
- Fixed critical error caused by incorrect taxonomy name `scholar_category` in `wp_get_post_terms` causing fatal crashes on single book pages and related book queries.
- Added `is_wp_error()` validation checks across template loops to ensure safe processing when fetching categories and metadata.

## [1.2.19] - 2026-05-09
### Fixed
- Fixed fatal error related to missing function exists checks for plugin activation/deactivation hooks.
- Fixed critical error in admin notices by wrapping hook callbacks in `current_user_can('manage_options')` checks.
- Migrated plugin prefix from `sbp_` to `sbpp_` across all functions, constants, and classes to prevent namespace collisions.
- Updated version numbers to 1.2.19 in main plugin file and readme.

 - Scholar Book Publisher Pro

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Planned Features
- [ ] CSV import for bulk book addition
- [ ] BibTeX export functionality
- [ ] CrossRef API integration for automatic metadata retrieval
- [ ] Citation counter (integration with Google Scholar API if available)
- [ ] Advanced search and filtering in admin
- [ ] Book series support
- [ ] Multi-volume book support
- [ ] Translation/edition tracking
- [ ] Author profile pages
- [ ] Publisher profile pages
- [ ] Analytics dashboard (views, downloads, citations)

### Future Enhancements
- [ ] Gutenberg block for book listings
- [ ] Elementor widget support
- [ ] REST API endpoints for external integrations
- [ ] Webhooks for book publication events
- [ ] Email notifications for new citations
- [ ] Batch PDF upload
- [ ] PDF metadata extraction
- [ ] OCR support for scanned PDFs
- [ ] ORCID integration
- [ ] DOAB (Directory of Open Access Books) submission
- [ ] OAPEN integration

---

## [1.0.0] - 2026-02-10

### Added - Final Release

#### Core Features
- **Custom Post Types:**
  - `scholar_book` - For book entries with complete metadata
  - `scholar_chapter` - For individual book chapters with parent book relationship
  - Hierarchical URL structure for chapters

- **Metadata Management:**
  - Book title field (simplified - no subtitle)
  - Multiple authors with proper citation format (Last, First)
  - Multiple editors for edited volumes
  - Publisher name field
  - **Publisher city field** (essential for academic citations)
  - Publication date picker
  - ISBN (13-digit) with validation
  - DOI field with format validation
  - **Price field** (optional, displays only on single page if filled)
  - **Access Category** (Open Access / Closed Access)
  - Abstract/description rich text editor
  - Featured image support (book cover)

- **Access Category System (NEW!):**
  - **Open Access option** - PDF section visible and available
  - **Closed Access option** - PDF section automatically hidden
  - Smart workflow integration with PDF management
  - Suitable for paid, restricted, or forthcoming books
  
- **Dual PDF Schema:**
  - **Schema 1:** WordPress Media Upload (conditional on Open Access)
    - Direct upload to WordPress media library
    - Automatic file size validation
    - Warning for files > 5MB
    - Integration with WordPress media picker
  
  - **Schema 2:** Google Drive External Link (conditional on Open Access)
    - Paste Google Drive share link
    - Automatic File ID extraction
    - Direct download link generation
    - Test download functionality
    - File size input (optional)
    - Storage-saving solution

- **Usage Metrics System (NEW!):**
  - **Automatic view tracking** - Excludes bots and admin
  - **Automatic download tracking** - Tracks PDF downloads via special URL
  - **Manual citations tracking** - Admin input from Google Scholar
  - Display on single book page (metrics box in sidebar)
  - Display on archive cards (compact view)
  - Admin meta box for metrics management
  - Daily tracking for analytics
  
- **Comprehensive Metadata Generation:**
  - **Google Scholar meta tags** (complete set):
    - `citation_title`, `citation_author` (multiple)
    - `citation_publication_date`, `citation_year`
    - `citation_publisher`, `citation_publisher_place`
    - `citation_isbn`, `citation_doi`
    - `citation_pdf_url` (if available)
    - `citation_abstract_html_url`, `citation_fulltext_html_url`
  
  - **Dublin Core metadata** (for citation managers):
    - `DC.title`, `DC.creator` (multiple)
    - `DC.publisher`, `DC.date`
    - `DC.identifier` (ISBN & DOI)
    - `DC.type`, `DC.format`, `DC.language`, `DC.coverage`
  
  - **Open Graph tags** (for social media & crawlers):
    - `og:type` (book), `og:title`, `og:url`, `og:image`
    - `book:publisher`, `book:isbn`, `book:author` (multiple)
  
  - **Twitter Card tags**:
    - `twitter:card`, `twitter:title`, `twitter:image`
  
  - **Highwire Press tags** (alternative format):
    - `HW.identifier`, `HW.ad-path`
  
  - **Schema.org JSON-LD** (for AI crawlers & rich results):
    - Complete Book structured data
    - Author objects with given/family names
    - Publisher with address (including city)
    - ISBN and DOI identifiers
    - Access mode (OpenAccess/ClosedAccess)
    - Work example for PDF
    - Image and description

- **URL Structure (Simplified & Hierarchical):**
  - Archive: `yoursite.com/catalogs/`
  - Single Book: `yoursite.com/catalogs/book-title/`
  - Chapter: `yoursite.com/catalogs/book-title/chapter-title/` (hierarchical!)
  - Category: `yoursite.com/catalogs/book-category/category-name/`
  - Tag: `yoursite.com/catalogs/book-tag/tag-name/`
  
- **Enhanced Crawler Optimization:**
  - Optimized robots.txt with explicit allow rules
  - Crawl-delay set to 1 (prevents server overload)
  - Sitemap reference in robots.txt
  - Separate rules for Google Scholar and general crawlers
  - All paths explicitly allowed for maximum crawlability

- **Citation Manager Compatibility:**
  - ✅ Mendeley Web Importer (one-click import)
  - ✅ Zotero Connector (auto-detect)
  - ✅ EndNote Web (capture references)
  - ✅ RefWorks (import citations)
  - ✅ Papers (add to library)
  - ✅ Any tool supporting Dublin Core
  
- **Admin Interface:**
  - User-friendly meta boxes
  - Repeater fields for authors and editors
  - Real-time validation (JavaScript)
  - File size checking and warnings
  - Google Drive link validation
  - Visual feedback for all actions
  - Help text and descriptions
  - **Usage Metrics sidebar box**
  - **Access Category dropdown with smart PDF toggle**
  - Admin notices for issues

- **Frontend Features:**
  - Custom permalink structure (simplified to `/catalogs/`)
  - **Hierarchical chapter URLs** (under parent book)
  - Template override support
  - Archive page support
  - Taxonomy support (categories, tags)
  - **Usage metrics display** on single page and archive
  - Responsive design ready
  - SEO-friendly URLs
  - **Price display** (conditional, single page only)

- **Security & Performance:**
  - Nonce verification for all forms
  - Capability checks
  - Sanitization of all inputs
  - Escape output for security
  - Optimized database queries
  - Minimal performance impact
  - Bot detection for metrics tracking
  - Tracked download URLs for accurate counting

- **Documentation:**
  - Comprehensive installation guide (English)
  - Quick start guide (Indonesian)
  - README.txt for WordPress.org
  - **Final installation guide** with all features
  - Inline code documentation
  - Hook and filter reference
  - Troubleshooting section
  - **Usage metrics guide**
  - **Access category workflow guide**

#### Technical Implementation

**File Structure:**
```
scholar-book-publisher/
├── scholar-book-publisher.php (Main plugin file)
├── includes/
│   ├── class-sbp-activator.php (Activation handler)
│   ├── class-sbp-post-types.php (Custom post types & meta boxes)
│   ├── class-sbp-metadata.php (Meta tags generation)
│   ├── class-sbp-crawler-optimizer.php (Robots.txt & sitemap)
│   └── class-sbp-admin-notices.php (Admin warnings & notices)
├── templates/ (Frontend templates - to be developed)
├── assets/ (CSS & JS - to be developed)
├── languages/ (Translation files)
├── INSTALLATION-GUIDE.md
├── PANDUAN-CEPAT-ID.md
├── README.txt
└── CHANGELOG.md (this file)
```

**Custom Fields Created:**
- `_sbpp_book_subtitle` - Book subtitle
- `_sbpp_authors` - Array of authors
- `_sbpp_editors` - Array of editors
- `_sbpp_book_publisher` - Publisher name
- `_sbpp_publisher_city` - **Publisher city (NEW)**
- `_sbpp_publication_date` - Publication date
- `_sbpp_isbn` - ISBN number
- `_sbpp_doi` - DOI identifier
- `_sbpp_pdf_available` - Boolean (PDF available or not)
- `_sbpp_pdf_source` - PDF source type (wordpress/gdrive)
- `_sbpp_pdf_wordpress_id` - WordPress media ID
- `_sbpp_pdf_gdrive_url` - Google Drive share URL
- `_sbpp_pdf_gdrive_id` - Extracted Google Drive File ID
- `_sbpp_pdf_file_size` - PDF file size in MB
- `_sbpp_pdf_size_warning` - Warning message for oversized files

**Database Tables:**
No custom tables created. Uses WordPress standard tables:
- `wp_posts` - For books and chapters
- `wp_postmeta` - For all metadata
- `wp_terms` & `wp_term_relationships` - For taxonomies

**WordPress Hooks Used:**
- `init` - Register post types and taxonomies
- `add_meta_boxes` - Add meta boxes to edit screens
- `save_post` - Save custom field data
- `wp_head` - Inject meta tags and Schema.org
- `robots_txt` - Optimize robots.txt
- `publish_scholar_book` - Trigger on book publication
- `admin_notices` - Display admin warnings

**External Dependencies:**
- WordPress Media Library (for PDF upload)
- Google Drive API (public links only, no auth required)
- WordPress Rewrite API (for permalinks)
- WordPress REST API (for sitemap)

### Changed
- N/A (Initial release)

### Deprecated
- N/A (Initial release)

### Removed
- N/A (Initial release)

### Fixed
- N/A (Initial release)

### Security
- All user inputs sanitized with appropriate WordPress functions
- Nonce verification on all form submissions
- Capability checks before saving data
- Escaped output to prevent XSS
- No SQL injection vulnerabilities (using WordPress APIs)
- File upload type restrictions (PDF only)
- File size validation

---

## Version History Summary

| Version | Release Date | Major Features |
|---------|-------------|----------------|
| 1.0.0   | 2026-02-04  | Initial release with dual PDF schema, publisher city field, Google Scholar optimization |

---

## Migration Guide

### From Manual Book Management
1. Install plugin
2. Manually create book entries
3. Copy metadata from old system
4. Upload or link PDFs
5. Verify meta tags generated correctly

### From Other Plugins
No automatic migration available yet. Manual entry required.

Future versions may include:
- Import from CSV
- Import from BibTeX
- Migration from custom solutions

---

## Known Issues

### Current Limitations
1. **No bulk import** - Books must be added one by one (CSV import planned for v1.1.0)
2. **No BibTeX export** - Only manual copying available (export planned for v1.1.0)
3. **No citation counter** - Manual checking in Google Scholar required
4. **No author profiles** - Authors are just metadata, not WordPress users
5. **Google Drive dependency** - Schema 2 requires Google Drive account
6. **No PDF preview** - Only download link, no in-browser preview

### Browser Compatibility
- Tested on: Chrome 120+, Firefox 120+, Safari 17+, Edge 120+
- JavaScript required for optimal experience
- Internet connection required for Google Drive validation

### WordPress Compatibility
- Tested on WordPress 5.8 - 6.4
- Multisite compatible
- Classic Editor: ✅ Fully supported
- Gutenberg Editor: ✅ Supported (meta boxes work)
- Page Builders: ⚠️ Meta boxes only, not page builder compatible

### Theme Compatibility
- Works with any theme that properly implements `wp_head()`
- Custom templates may be needed for styling
- Some themes may override default layouts

### Server Requirements Issues
- Upload file size limited by server `php.ini` settings
- SSL certificate required (HTTPS mandatory for Google Scholar)
- Minimum PHP 7.4 required

---

## Development Roadmap

### Version 1.1.0 (Q2 2026) - Planned
- CSV import functionality
- BibTeX export
- Batch PDF upload
- Enhanced admin interface
- Book series support

### Version 1.2.0 (Q3 2026) - Planned
- CrossRef API integration
- ORCID author identification
- Citation tracking
- Analytics dashboard

### Version 2.0.0 (Q4 2026) - Planned
- Complete redesign with React admin interface
- Real-time collaboration features
- Advanced search and filtering
- Multi-language content management
- API endpoints for third-party integrations

---

## Credits & Acknowledgments

### Inspired By
- **Open Journal Systems (OJS)** - Academic publishing standards
- **Google Scholar** - Indexing requirements and best practices
- **WordPress** - Plugin development patterns

### Technologies Used
- WordPress Core (6.4)
- PHP 8.0+
- JavaScript (ES6+)
- MySQL/MariaDB
- Google Drive API (public links)

### Contributors
- Initial development: [Your Name]
- Documentation: [Your Name]
- Testing: Community

### Special Thanks
- Public Knowledge Project for OJS documentation
- Google Scholar team for inclusion guidelines
- WordPress community for support and feedback

---

## Support & Contact

**Documentation:**
- INSTALLATION-GUIDE.md (comprehensive English guide)
- PANDUAN-CEPAT-ID.md (Indonesian quick start)
- README.txt (WordPress plugin repository format)

**Bug Reports:**
- GitHub Issues: [Repository URL]
- WordPress Support Forum: [Forum URL]

**Feature Requests:**
- GitHub Discussions: [Discussions URL]
- Community voting: [Voting platform]

**Commercial Support:**
- Available upon request
- Custom development services
- Migration assistance
- Training and consulting

---

## License

**GPL v2 or later**

Copyright (C) 2026 [Your Name/Organization]

This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; either version 2 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

---

**Last Updated:** 2026-02-04  
**Maintained By:** [Your Name/Organization]  
**Repository:** [GitHub URL]
