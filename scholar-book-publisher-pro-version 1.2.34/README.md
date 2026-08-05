# Scholar Book Publisher Pro

> 📚 **Complete WordPress plugin for academic book publishing with Google Scholar optimization**

A comprehensive, free, and open-source WordPress plugin designed specifically for academic book publishers who want their content properly indexed by Google Scholar and other scholarly search engines.

[![WordPress](https://img.shields.io/badge/WordPress-5.8%2B-blue)](https://wordpress.org)
[![PHP](https://img.shields.io/badge/PHP-7.4%2B-purple)](https://php.net)
[![License](https://img.shields.io/badge/License-GPL%20v2-green)](LICENSE.txt)
[![Version](https://img.shields.io/badge/Version-1.0.0-orange)](CHANGELOG.md)

---

## ✨ Key Features

### 🎯 Google Scholar Optimized
- **Automatic meta tags generation** - All required `citation_*` tags generated automatically (30+ tags total)
- **Built-in crawler optimization** - robots.txt and XML sitemap configured out-of-the-box
- **Publisher city field** - Essential for academic citations, rarely found in other plugins
- **Comprehensive metadata** - Dublin Core, Open Graph, Schema.org JSON-LD
- **Citation manager ready** - Mendeley, Zotero, EndNote, RefWorks compatible
- **Zero configuration** - Works immediately after activation

### 🔐 Access Category System (NEW!)
- **Open Access** - PDF section visible and available for upload/linking
- **Closed Access** - PDF section automatically hidden, suitable for paid/restricted content
- **Smart workflow** - Prevents confusion about PDF requirements
- **Professional distinction** - Clear categorization of book access types

### 📄 Dual PDF Schema
- **WordPress Upload** - Direct upload to media library (< 5MB recommended)
- **Google Drive Link** - External PDF hosting to save server storage
- **Automatic validation** - File size checks and link verification
- **Storage savings** - Perfect for publishers with many books
- **Tracked downloads** - Automatic download counting for metrics

### 📊 Usage Metrics System (NEW!)
- **Automatic view tracking** - Tracks page views (excludes bots & admin)
- **Automatic download tracking** - Counts PDF downloads via tracked URLs
- **Manual citations tracking** - Admin updates from Google Scholar
- **Display on frontend** - Metrics visible on single page and archive cards
- **Admin dashboard** - Sidebar meta box for easy management

### 📚 Complete Metadata Management
- Title (no subtitle - simplified)
- Multiple authors and editors (proper citation format)
- Publisher name and **city** (unique feature!)
- Publication date
- ISBN (13-digit)
- DOI support
- **Price** (optional, displays only on single page if filled)
- **Access category** (Open/Closed)
- Abstract/description
- Book categories and tags

### 🎨 Beautiful Frontend Templates
- **Refined scholarly aesthetic** - Professional academic design
- **Fully responsive** - Mobile, tablet, and desktop optimized
- **Three templates included**:
  - Single book page (with usage metrics)
  - Books archive/listing (with metrics on cards)
  - Chapter display (hierarchical URLs)
- **Easy customization** - CSS variables and theme overrides

### 🔗 Enhanced URL Structure
- **Simplified & hierarchical** - Clean, SEO-friendly URLs
- Archive: `yoursite.com/catalogs/`
- Book: `yoursite.com/catalogs/book-title/`
- Chapter: `yoursite.com/catalogs/book-title/chapter-title/` (hierarchical!)
- Better for crawlers and user navigation

### 🔧 Developer Friendly
- Clean, documented code
- WordPress coding standards
- Custom post types and taxonomies
- Template override support
- Action and filter hooks
- REST API compatible
- **Usage metrics API** for custom integrations

---

## 🚀 Quick Start

### Installation

**Via WordPress Admin:**
```
1. Download the plugin ZIP file
2. Go to Plugins → Add New → Upload Plugin
3. Choose the ZIP file and click "Install Now"
4. Click "Activate Plugin"
5. Go to Settings → Permalinks → Save Changes
```

**Via FTP:**
```bash
1. Upload folder to /wp-content/plugins/
2. Activate via WordPress Admin → Plugins
3. Flush permalinks (Settings → Permalinks → Save)
```

### Your First Book

```
1. Click "Books" → "Add New"
2. Fill in metadata (title, authors, publisher, city, date, ISBN)
3. Choose PDF option (WordPress upload or Google Drive link)
4. Click "Publish"
```

**That's it!** Your book is now ready to be crawled by Google Scholar.

---

## 📖 Documentation

- **[Quick Start Guide](QUICK-START.md)** - Get started in 3 minutes
- **[Installation Guide](INSTALLATION-GUIDE.md)** - Complete installation and usage (English)
- **[Panduan Cepat](PANDUAN-CEPAT-ID.md)** - Quick start guide (Indonesian)
- **[Templates Guide](templates/README-TEMPLATES.md)** - Customize frontend templates
- **[Changelog](CHANGELOG.md)** - Version history and updates

---

## 🎯 What Makes This Plugin Special?

| Feature | Scholar Book Publisher Pro | Generic Plugins |
|---------|---------------------------|-----------------|
| Publisher City Field | ✅ Built-in | ❌ Missing |
| Dual PDF Schema | ✅ WordPress + Google Drive | ⚠️ Upload only |
| Google Scholar Meta Tags | ✅ Automatic, complete | ⚠️ Manual or incomplete |
| Crawler Optimization | ✅ Built-in, no config | ❌ Manual setup |
| Academic Citation Format | ✅ APA style ready | ❌ Not available |
| Chapter Support | ✅ Full support | ⚠️ Limited |
| Custom Templates | ✅ 3 included, customizable | ⚠️ Generic |
| Documentation | ✅ Comprehensive (EN + ID) | ⚠️ Basic |

---

## 💡 Use Cases

Perfect for:
- 📚 University presses
- 🎓 Academic publishers
- 🔬 Research institutions
- 📖 Scholarly book platforms
- 🌐 Open access publishers
- 👨‍🎓 Independent academic authors
- 🏛️ Digital libraries

---

## 🔧 System Requirements

```
✓ WordPress 5.8 or higher
✓ PHP 7.4 or higher (8.0+ recommended)
✓ MySQL 5.6+ or MariaDB 10.1+
✓ HTTPS (SSL certificate - required for Google Scholar)
✓ Memory: 128MB minimum, 256MB recommended
✓ Upload limit: 5MB+ (for PDF uploads)
```

---

## 📸 Screenshots

### Single Book Page
Beautiful, readable book display with all metadata, citation box, and table of contents.

### Books Archive
Grid layout with search, sorting, and filtering capabilities.

### Chapter Display
Clean reading experience with breadcrumb navigation and chapter-to-chapter links.

### Admin Interface
Intuitive meta boxes for entering book metadata with real-time validation.

---

## 🗺️ Roadmap

### Version 1.1.0 (Planned Q2 2026)
- [ ] CSV import for bulk book addition
- [ ] BibTeX export functionality
- [ ] Enhanced admin interface with settings page
- [ ] Book series support

### Version 1.2.0 (Planned Q3 2026)
- [ ] CrossRef API integration
- [ ] ORCID author identification
- [ ] Citation tracking
- [ ] Analytics dashboard

### Version 2.0.0 (Planned Q4 2026)
- [ ] React-based admin interface
- [ ] REST API endpoints
- [ ] Multi-language content management
- [ ] Advanced search and filtering

See [CHANGELOG.md](CHANGELOG.md) for full roadmap.

---

## 🤝 Contributing

Contributions are welcome! Here's how you can help:

### Ways to Contribute
- 🐛 Report bugs via GitHub Issues
- 💡 Suggest new features
- 📝 Improve documentation
- 🌐 Translate to other languages
- 💻 Submit pull requests
- ⭐ Star this repository

### Development Setup
```bash
git clone https://github.com/yourusername/scholar-book-publisher-pro.git
cd scholar-book-publisher-pro
# Make your changes
# Test thoroughly
# Submit pull request
```

---

## 📞 Support

### Getting Help
1. Check the [documentation files](QUICK-START.md)
2. Search [existing issues](https://github.com/yourusername/scholar-book-publisher-pro/issues)
3. Create a [new issue](https://github.com/yourusername/scholar-book-publisher-pro/issues/new)
4. Visit [WordPress support forum](#)

### Frequently Asked Questions

**Q: How long until Google Scholar indexes my books?**  
A: Typically 6-9 months for new sites, 2-4 months for established academic sites.

**Q: Do I need to submit to Google Scholar?**  
A: No, Google Scholar crawls automatically. Submission is optional.

**Q: Can I use both WordPress upload and Google Drive?**  
A: Yes! Each book can use different methods.

**Q: Is this plugin really free?**  
A: Yes, completely free and open-source under GPL v2.

See [INSTALLATION-GUIDE.md](INSTALLATION-GUIDE.md) for more FAQs.

---

## 📄 License

This plugin is licensed under the [GNU General Public License v2.0](LICENSE.txt).

You are free to:
- ✅ Use commercially
- ✅ Modify freely
- ✅ Distribute
- ✅ Create derivative works

---

## 🙏 Acknowledgments

- **Open Journal Systems (OJS)** - Inspiration for academic publishing standards
- **Google Scholar** - Indexing guidelines and best practices
- **WordPress Community** - Framework and support
- **Contributors** - Everyone who helps improve this plugin

---

## 📊 Stats

- **Version:** 1.2.34
- **Last Updated:** February 2026
- **Downloads:** [Count from WordPress.org]
- **Active Installs:** [Count from WordPress.org]
- **Rating:** ⭐⭐⭐⭐⭐ (Pending reviews)

---

## 🔗 Links

- [Plugin Homepage](#)
- [Documentation](QUICK-START.md)
- [WordPress.org Page](#)
- [GitHub Repository](#)
- [Issue Tracker](https://github.com/yourusername/scholar-book-publisher-pro/issues)
- [Changelog](CHANGELOG.md)

---

## ⚡ Quick Links

| Resource | Link |
|----------|------|
| 📥 Download | [Latest Release](#) |
| 📖 Documentation | [Read Docs](INSTALLATION-GUIDE.md) |
| 🐛 Report Bug | [Create Issue](#) |
| 💡 Feature Request | [Suggest Feature](#) |
| 💬 Support | [Get Help](#) |
| ⭐ Star | [Star on GitHub](#) |

---

<p align="center">
  <strong>Made with ❤️ for the academic community</strong>
  <br>
  <sub>Helping scholars share their knowledge with the world</sub>
</p>

<p align="center">
  <a href="#scholar-book-publisher-pro">Back to Top ↑</a>
</p>

---

**Scholar Book Publisher Pro** | Version 1.2.34 | GPL v2 License | February 2026
