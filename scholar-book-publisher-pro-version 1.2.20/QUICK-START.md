# 🚀 Scholar Book Publisher Pro - Quick Start Guide

## ⚡ Installation in 3 Minutes

### Step 1: Download & Extract
1. Download `scholar-book-publisher-pro.zip`
2. Extract the ZIP file on your computer

### Step 2: Install Plugin

**Option A: Via WordPress Admin (Easiest)**
```
1. Login to WordPress Admin
2. Go to Plugins → Add New
3. Click "Upload Plugin"
4. Choose the ZIP file
5. Click "Install Now"
6. Click "Activate Plugin"
```

**Option B: Via FTP**
```
1. Upload the extracted folder to /wp-content/plugins/
2. Go to WordPress Admin → Plugins
3. Find "Scholar Book Publisher Pro"
4. Click "Activate"
```

### Step 3: Configure (30 seconds)
```
1. Go to Settings → Permalinks
2. Click "Save Changes" (flush rewrite rules)
3. Verify HTTPS is enabled (required for Google Scholar)
```

**Done! ✅ Plugin is ready to use.**

---

## 📚 Add Your First Book (2 minutes)

### Quick Method:
```
1. Click "Books" → "Add New"
2. Fill required fields:
   - Title: "Your Book Title"
   - Authors: First Name + Last Name
   - Publisher: "Publisher Name"
   - Publisher City: "City Name"
   - Publication Date: Select date
   - ISBN: 978-xxx-xxxx (13 digits)
3. Choose PDF method:
   ☐ Upload to WordPress (< 5MB)
   ☐ Link from Google Drive (recommended for larger files)
4. Click "Publish"
```

### Verify Installation:
```
✓ Check: yoursite.com/robots.txt (should allow Googlebot-Scholar)
✓ Check: yoursite.com/books-sitemap.xml (should show XML)
✓ Check: yoursite.com/books/ (should show books archive)
✓ Right-click on book page → View Source → Search "citation_" (should see meta tags)
```

---

## 🔗 Google Drive Setup (Optional, 2 minutes)

For books with PDF > 5MB or to save server storage:

```
1. Upload PDF to Google Drive
2. Right-click file → Share
3. Change to "Anyone with the link"
4. Copy the share link
5. In WordPress book editor:
   - Check "This book has a PDF available"
   - Select "Schema 2: Link from Google Drive"
   - Paste the link
   - Click "Validate & Extract ID"
6. Save book
```

---

## ✅ Post-Installation Checklist

```
☐ Plugin activated successfully
☐ Permalinks flushed (Settings → Permalinks → Save)
☐ HTTPS enabled (padlock icon in browser)
☐ robots.txt accessible and correct
☐ Sitemap XML accessible
☐ First book added with complete metadata
☐ PDF available (WordPress or Google Drive)
☐ Meta tags visible in page source
☐ Book displays correctly on frontend
```

---

## 🎨 Optional: Customize Templates

Copy templates to your theme for customization:

```bash
# From plugin directory to theme:
cp /wp-content/plugins/scholar-book-publisher-pro/templates/single-scholar_book.php 
   /wp-content/themes/your-theme/

cp /wp-content/plugins/scholar-book-publisher-pro/templates/archive-scholar_book.php 
   /wp-content/themes/your-theme/

cp /wp-content/plugins/scholar-book-publisher-pro/templates/single-scholar_chapter.php 
   /wp-content/themes/your-theme/
```

Or use the custom CSS file:
```bash
cp templates/scholar-custom.css 
   /wp-content/themes/your-theme/scholar-custom.css
```

Then enqueue in your theme's functions.php:
```php
wp_enqueue_style('scholar-custom', 
    get_template_directory_uri() . '/scholar-custom.css'
);
```

---

## 📊 Google Scholar Indexing Timeline

```
Week 1-4:    Plugin setup, add books, verify metadata
Week 4-12:   Google Scholar initial crawl
Month 2-6:   First books start appearing in Google Scholar
Month 6-9:   Full indexing complete
Ongoing:     Google Scholar updates index 2x per year
```

**Note:** Indexing is automatic. No submission required!

---

## 🐛 Common Issues & Quick Fixes

### Issue: Books not showing on frontend
```
Fix: Settings → Permalinks → Save Changes
```

### Issue: PDF upload fails
```
Fix: Check file size < upload limit
Alternative: Use Google Drive method
```

### Issue: Meta tags not appearing
```
Fix: Clear all caches (plugin cache, browser cache)
Check: View Page Source → Search "citation_"
```

### Issue: Templates not working
```
Fix: Copy templates to your theme directory
Clear theme cache
```

### Issue: Google Drive link doesn't work
```
Fix: Verify sharing is "Anyone with the link"
      Not "Restricted"
```

---

## 📖 Full Documentation

For detailed guides:

- **English (Complete):** INSTALLATION-GUIDE.md
- **Indonesian (Quick Start):** PANDUAN-CEPAT-ID.md
- **Templates Guide:** templates/README-TEMPLATES.md
- **Changelog:** CHANGELOG.md
- **WordPress.org Format:** readme.txt

---

## 🔧 System Requirements

```
✓ WordPress 5.8+
✓ PHP 7.4+ (8.0+ recommended)
✓ MySQL 5.6+ or MariaDB 10.1+
✓ HTTPS (SSL certificate required)
✓ Memory: 128MB minimum (256MB recommended)
✓ Upload limit: 5MB+ for PDF uploads
```

---

## 💡 Pro Tips

1. **Start Small:** Add 5-10 books first, verify everything works
2. **Complete Metadata:** Fill all fields for best Google Scholar results
3. **Use DOI:** Greatly improves discoverability
4. **Google Drive:** Best for multiple books or limited server storage
5. **Be Patient:** Google Scholar indexing takes 6-9 months
6. **Regular Publishing:** Add books consistently (1-2 per month)
7. **Quality PDFs:** Searchable text, < 5MB, proper formatting

---

## 🆘 Need Help?

1. Check documentation files (detailed guides included)
2. View troubleshooting sections in INSTALLATION-GUIDE.md
3. GitHub Issues: [Create new issue]
4. WordPress Forum: [Plugin support forum]

---

## 📝 Quick Reference

**File Locations:**
```
Plugin:     /wp-content/plugins/scholar-book-publisher-pro/
Templates:  /wp-content/plugins/scholar-book-publisher-pro/templates/
Uploads:    /wp-content/uploads/scholar-books/
Settings:   WordPress Admin → Books → Settings (future feature)
```

**Important URLs:**
```
Books Archive:  yoursite.com/books/
Single Book:    yoursite.com/books/book-title/
XML Sitemap:    yoursite.com/books-sitemap.xml
Robots.txt:     yoursite.com/robots.txt
```

**Meta Tags to Verify:**
```
citation_title
citation_author
citation_publication_date
citation_publisher
citation_publisher_place (publisher city - unique to this plugin!)
citation_isbn
citation_doi
citation_pdf_url
```

---

## ✨ What Makes This Plugin Special?

1. ✅ **Publisher City Field** - Essential for academic citations, rarely found in other plugins
2. ✅ **Dual PDF Schema** - WordPress upload OR Google Drive link (saves storage!)
3. ✅ **Google Scholar Optimized** - Built-in crawler optimization, no configuration needed
4. ✅ **Automatic Meta Tags** - All required tags generated automatically
5. ✅ **Beautiful Templates** - Refined scholarly design included
6. ✅ **Zero Configuration** - Works out of the box for Google Scholar
7. ✅ **Free & Open Source** - GPL licensed, no premium version

---

## 🎯 Next Steps After Installation

1. ✅ Add your first 5-10 books
2. ✅ Verify meta tags are present (View Source)
3. ✅ Check robots.txt and sitemap
4. ✅ Customize templates (optional)
5. ✅ Share books on academic platforms
6. ✅ Wait 6-9 months for Google Scholar indexing
7. ✅ Monitor citations and visibility

---

**Ready to publish your academic books? Let's go! 🚀📚**

---

**Plugin Version:** 1.0.0  
**Last Updated:** February 2026  
**License:** GPL v2 or later

For detailed documentation, see INSTALLATION-GUIDE.md
