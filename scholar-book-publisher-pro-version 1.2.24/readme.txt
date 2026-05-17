=== Scholar Book Publisher Pro ===
Contributors: yourname
Tags: google scholar, academic publishing, books, metadata, isbn, doi, pdf
Requires at least: 5.8
Tested up to: 6.4
Requires PHP: 7.4
Stable tag: 1.2.24
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Publish academic books with complete metadata optimized for Google Scholar indexing. Supports dual PDF schema (WordPress upload or Google Drive link).

== Description ==

**Scholar Book Publisher Pro** is a comprehensive WordPress plugin designed specifically for academic book publishers who want their content indexed by Google Scholar and other academic search engines.

= Key Features =

* **Complete Metadata Management** - All required fields for Google Scholar indexing
* **Dual PDF Schema** - Choose between WordPress media upload or Google Drive external link
* **Automatic Meta Tags Generation** - Citation tags generated automatically
* **Google Scholar Optimized** - Built-in crawler optimization with robots.txt and sitemap
* **Publisher City Field** - Essential for formal academic citations
* **DOI Support** - Integrated DOI field for better discoverability
* **Schema.org Markup** - Automatic JSON-LD structured data
* **No Coding Required** - User-friendly interface for non-technical users
* **Multilingual Ready** - Compatible with WPML and Polylang

= Perfect For =

* Academic book publishers
* University presses
* Research institutions
* Independent scholarly publishers
* Open access book platforms

= How It Works =

1. Install and activate the plugin
2. Add your books with complete metadata (title, authors, publisher, ISBN, etc.)
3. Optionally upload PDF or link from Google Drive
4. Plugin automatically generates Google Scholar-compatible meta tags
5. Google Scholar crawls and indexes your books (6-9 months timeline)

= Metadata Fields =

* Book Title & Subtitle
* Multiple Authors (proper citation format)
* Editors (for edited volumes)
* Publisher Name
* **Publisher City** (new feature!)
* Publication Date
* ISBN (13-digit)
* DOI (optional but recommended)
* Abstract/Description
* PDF provision (optional, dual schema)

= PDF Management =

**Schema 1: WordPress Media Upload**
* Direct upload to your WordPress media library
* Best for files < 5MB
* Complete control over files
* Automatic file size validation

**Schema 2: Google Drive External Link**
* Link PDF from Google Drive
* Saves server storage
* Unlimited capacity
* Automatic direct download link generation
* Perfect for large files or multiple books

= Google Scholar Optimization =

* Automatic `citation_*` meta tags
* Dublin Core metadata
* Schema.org Book markup
* XML sitemap for books
* Robots.txt optimization
* HTTPS compatibility check
* No authentication barriers

= Developer Friendly =

* Custom post types: `scholar_book` and `scholar_chapter`
* Template override support
* Action and filter hooks
* Clean, documented code
* REST API compatible

== Installation ==

= Automatic Installation =

1. Log in to your WordPress admin panel
2. Navigate to Plugins → Add New
3. Search for "Scholar Book Publisher Pro"
4. Click "Install Now" and then "Activate"
5. Go to Settings → Permalinks and click "Save Changes"

= Manual Installation =

1. Download the plugin zip file
2. Extract to `/wp-content/plugins/scholar-book-publisher/`
3. Activate through the 'Plugins' menu in WordPress
4. Go to Settings → Permalinks and click "Save Changes"

= After Installation =

1. Verify new menu items: "Books" and "Chapters"
2. Check robots.txt: `yoursite.com/robots.txt`
3. Check sitemap: `yoursite.com/books-sitemap.xml`
4. Ensure HTTPS is enabled on your site

For detailed installation guide, see INSTALLATION-GUIDE.md

== Frequently Asked Questions ==

= Is this plugin free? =

Yes, Scholar Book Publisher Pro is completely free and open-source.

= Does it work with any WordPress theme? =

Yes, as long as the theme properly implements `wp_head()` hook. Most modern themes do.

= How long until Google Scholar indexes my books? =

Typically 6-9 months for new sites, 2-4 months for established academic sites. Google Scholar updates its index twice per year.

= Do I need PDF for every book? =

No, PDF is optional but highly recommended for Google Scholar indexing. Books without PDFs are less likely to be indexed.

= Can I use Google Drive for PDFs? =

Yes! The plugin supports dual PDF schema. You can either upload to WordPress or link from Google Drive. Google Drive saves server storage and is perfect for multiple books.

= What if my PDF is larger than 5MB? =

You can still upload it, but Google Scholar recommends files < 5MB for optimal indexing. Consider:
* Compressing the PDF
* Splitting into chapters
* Using Google Drive (though large files may not be indexed)

= How do I set up Google Drive links? =

1. Upload PDF to Google Drive
2. Right-click → Share → "Anyone with the link"
3. Copy the share link
4. Paste in WordPress book editor
5. Plugin automatically extracts File ID and creates direct download link

See PANDUAN-CEPAT-ID.md for detailed steps (Indonesian) or INSTALLATION-GUIDE.md (English).

= Can I customize the book page templates? =

Yes, create these files in your theme:
* `single-scholar_book.php` - for individual book pages
* `archive-scholar_book.php` - for book listings
* `taxonomy-book_category.php` - for category archives

= Is it compatible with page builders? =

Yes, but metadata should be entered in the plugin's meta boxes, not the page builder.

= Does it support multiple languages? =

Yes, the plugin is translation-ready and compatible with WPML and Polylang.

= Can I export my book data? =

Currently, you can use WordPress's built-in export (Tools → Export) or access the database directly. CSV export may be added in future versions.

= What about privacy/GDPR? =

The plugin doesn't collect any personal data. All book metadata is public by design (required for Google Scholar indexing).

== Screenshots ==

1. Book editor with complete metadata fields
2. Dual PDF schema options (WordPress upload vs Google Drive)
3. Google Drive link validation
4. Author management interface
5. Generated meta tags in page source
6. XML sitemap for books
7. Frontend book display
8. Admin notices for PDF warnings

== Changelog ==

= 1.0.0 - 2026-02-04 =
* Initial release
* Complete metadata management system
* Dual PDF schema (WordPress upload + Google Drive link)
* Publisher city field for academic citations
* Automatic Google Scholar meta tags generation
* Built-in crawler optimization
* Schema.org markup support
* XML sitemap for books
* Admin validation and warnings
* Comprehensive documentation

== Upgrade Notice ==

= 1.0.0 =
Initial release. Install and start publishing your academic books!

== Technical Details ==

= Meta Tags Generated =

The plugin automatically generates these meta tags:

* `citation_title`
* `citation_author` (multiple)
* `citation_publication_date`
* `citation_publisher`
* `citation_publisher_place` (publisher city)
* `citation_isbn`
* `citation_doi`
* `citation_pdf_url` (if PDF available)
* `citation_abstract_html_url`
* Dublin Core tags
* Schema.org JSON-LD

= Custom Post Types =

* `scholar_book` - Main book entries
* `scholar_chapter` - Book chapters (linked to parent book)

= Taxonomies =

* `book_category` - Book categories
* `book_tag` - Book tags
* `book_discipline` - Academic disciplines

= Hooks for Developers =

**Actions:**
* `sbpp_before_book_meta_box`
* `sbpp_after_book_meta_box`
* `sbpp_book_published`
* `sbpp_chapter_published`

**Filters:**
* `sbpp_book_meta_fields`
* `sbpp_pdf_max_size`
* `sbpp_google_drive_url_pattern`
* `sbpp_metadata_output`

= File Structure =

```
scholar-book-publisher/
├── scholar-book-publisher.php (main file)
├── includes/
│   ├── class-sbp-activator.php
│   ├── class-sbp-post-types.php
│   ├── class-sbp-metadata.php
│   ├── class-sbp-crawler-optimizer.php
│   └── class-sbp-admin-notices.php
├── templates/
│   ├── single-book.php
│   ├── archive-books.php
│   └── chapter-list.php
├── assets/
│   ├── css/
│   └── js/
├── languages/
├── INSTALLATION-GUIDE.md
├── PANDUAN-CEPAT-ID.md
└── README.txt (this file)
```

== Support ==

For support, please:

1. Check the comprehensive guides:
   * INSTALLATION-GUIDE.md (English, detailed)
   * PANDUAN-CEPAT-ID.md (Indonesian, quick start)

2. Visit the plugin documentation page

3. Submit issues on GitHub repository

4. Contact via WordPress support forums

== Contributing ==

This is an open-source project. Contributions are welcome:

* Code improvements
* Bug reports
* Feature requests
* Translations
* Documentation

Visit our GitHub repository to contribute.

== Credits ==

Developed specifically for academic publishers who want their books indexed by Google Scholar and other academic search engines.

Special thanks to:
* Public Knowledge Project (OJS) for inspiration
* Google Scholar team for indexing guidelines
* WordPress community

== License ==

This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; either version 2 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
