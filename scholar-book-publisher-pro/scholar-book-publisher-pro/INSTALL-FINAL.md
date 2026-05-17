# 🎉 Scholar Book Publisher Pro - FINAL VERSION
## Installation Guide & Quick Start

**Version:** 1.0.0 (Final)  
**Author:** Nextmedia  
**Release Date:** February 2026  
**Status:** ✅ Production Ready

---

## 📦 WHAT'S INCLUDED

This ZIP file contains the complete, production-ready plugin with all features:

### ✨ Core Features:
- ✅ Complete metadata management for academic books
- ✅ **Access Category system** (Open/Closed Access)
- ✅ Dual PDF schema (WordPress upload OR Google Drive link)
- ✅ **Usage Metrics tracking** (Views, Downloads, Citations)
- ✅ Comprehensive metadata for citation importers
- ✅ Google Scholar optimization (30+ meta tags)
- ✅ Beautiful frontend templates
- ✅ Hierarchical URL structure
- ✅ Chapter support with parent book relationship

### 🎯 Unique Features:
- ✅ **Publisher City field** (rare in other plugins!)
- ✅ **Access Category** with smart PDF workflow
- ✅ **Auto-tracking** views and downloads
- ✅ **Citation importer ready** (Mendeley, Zotero, EndNote)
- ✅ **AI crawler optimized** (GPT, Claude, etc.)
- ✅ **Hierarchical chapters** (catalogs/book/chapter/)

---

## 🚀 QUICK INSTALLATION (3 Minutes)

### Step 1: Upload Plugin (1 minute)
```
1. Login to WordPress Admin
2. Navigate to: Plugins → Add New
3. Click: "Upload Plugin"
4. Choose: scholar-book-publisher-pro.zip
5. Click: "Install Now"
6. Click: "Activate Plugin"
```

### Step 2: Flush Permalinks (30 seconds)
```
CRITICAL STEP - DO NOT SKIP!

1. Go to: Settings → Permalinks
2. Click: "Save Changes" (don't change anything)
3. This enables the new URL structure
```

### Step 3: Verify Installation (30 seconds)
```
✓ Check menu: "Books" appears in admin sidebar
✓ Check menu: "Chapters" appears in admin sidebar
✓ Visit: yoursite.com/catalogs/ (should work)
✓ Check: yoursite.com/robots.txt (should allow /catalogs/)
```

**✅ Installation Complete! Ready to add books.**

---

## 📚 ADD YOUR FIRST BOOK (5 Minutes)

### Go to: Books → Add New

### 1. Basic Information
```
Title: "Introduction to Machine Learning"
(No subtitle field - simplified!)
```

### 2. Authors (Required)
```
Click: "+ Add Author"
First Name: John
Last Name: Smith

(Add more authors if needed)
```

### 3. Publisher Information
```
Publisher Name: MIT Press
Publisher City: Cambridge  ← IMPORTANT!
Publication Date: 2026-01-15
```

### 4. Identifiers
```
ISBN: 978-0-262-12345-6 (required)
DOI: 10.1234/example (optional but recommended)
```

### 5. **Access Category** (NEW!)
```
Select: ⚪ Open Access (PDF available)
   OR:  ⚪ Closed Access (No PDF needed)

If Open Access:
  → PDF section will show below
  → Upload PDF or link from Google Drive
  
If Closed Access:
  → PDF section hidden automatically
  → Suitable for paid/restricted books
```

### 6. Price (Optional)
```
Enter price if applicable: "$29.99" or "Rp 250.000"
Leave empty if free or not applicable

Note: Price ONLY shows on single book page
      (not on archive listing)
```

### 7. PDF Upload (If Open Access)
```
Method A: WordPress Upload
  → Best for files < 5MB
  → Click "Upload PDF File"
  → Select from Media Library
  
Method B: Google Drive Link
  → Best for large files
  → Upload to Google Drive
  → Right-click → Share → "Anyone with the link"
  → Paste link in WordPress
  → Click "Validate & Extract ID"
```

### 8. Publish
```
Click: "Publish" button

Your book is now live at:
yoursite.com/catalogs/introduction-to-machine-learning/
```

---

## 🎯 NEW URL STRUCTURE

After installation:

```
Archive (All Books):
  yoursite.com/catalogs/

Single Book:
  yoursite.com/catalogs/book-title/

Chapter (Hierarchical):
  yoursite.com/catalogs/book-title/chapter-title/

Category:
  yoursite.com/catalogs/book-category/science/

Tag:
  yoursite.com/catalogs/book-tag/ai/
```

**Benefits:**
- ✅ Clean and intuitive
- ✅ SEO-friendly
- ✅ Hierarchical organization
- ✅ Easy to crawl by Google Scholar & AI

---

## 📊 USAGE METRICS SYSTEM

### Automatic Tracking:

**Views:**
- Tracked automatically on every page load
- Excludes bots and admin users
- Real-time counter

**Downloads:**
- Tracked when "Download PDF" clicked
- Works for both WordPress & Google Drive
- Accurate counting

**Citations:**
- Manual input by admin
- Update from Google Scholar periodically
- Located in sidebar meta box

### Where to See Metrics:

**Admin Dashboard:**
```
Books → Edit Book → Sidebar
┌─── Usage Metrics ─────┐
│ 👁️ Views: 1,234      │
│ 📥 Downloads: 156    │
│ 📖 Citations: [42]   │
└───────────────────────┘
```

**Single Book Page (Frontend):**
```
Sidebar shows metrics box with:
- Views count
- Downloads count  
- Citations count
```

**Archive Page (Book Cards):**
```
Each book card shows:
Publisher • 2026 • 👁️ 1,234  📥 156  📖 42
```

---

## 🔍 METADATA & CITATION IMPORTERS

This plugin generates **30+ meta tags** for maximum compatibility:

### Supported Tools:
- ✅ **Google Scholar** (full indexing)
- ✅ **Mendeley Web Importer** (one-click import)
- ✅ **Zotero Connector** (auto-detect metadata)
- ✅ **EndNote Web** (capture references)
- ✅ **RefWorks** (import citations)
- ✅ **Papers** (add to library)
- ✅ **AI Crawlers** (GPT, Claude, Perplexity)
- ✅ **Social Media** (Facebook, Twitter cards)

### Meta Tags Generated:
```
Citation Tags (Google Scholar):
  - citation_title
  - citation_author (multiple)
  - citation_publication_date
  - citation_publisher
  - citation_publisher_place ← Unique!
  - citation_isbn
  - citation_doi
  - citation_pdf_url
  + 4 more...

Dublin Core (Citation Managers):
  - DC.title
  - DC.creator (multiple)
  - DC.publisher
  - DC.date
  - DC.identifier (ISBN, DOI)
  - DC.type
  + 4 more...

Schema.org JSON-LD (AI & Rich Results):
  - Full structured data
  - Book type
  - Author objects
  - Publisher with address
  - Access mode (Open/Closed)
  + Complete semantic markup

Open Graph (Social):
  - og:type (book)
  - og:title
  - book:author
  - book:isbn
  + 5 more...
```

### Test Citation Import:
```
1. Open book page in browser
2. Click Mendeley/Zotero extension
3. Should detect all metadata automatically
4. Click to import → Complete!
```

---

## ⚙️ ACCESS CATEGORY SYSTEM

### Open Access Workflow:
```
1. Select "Open Access" in Access Category
2. PDF section appears automatically
3. Upload PDF or link from Google Drive
4. PDF becomes available for download
5. Better Google Scholar indexing
6. Usage metrics track downloads
```

### Closed Access Workflow:
```
1. Select "Closed Access" in Access Category
2. PDF section hidden automatically
3. No PDF upload needed
4. Suitable for:
   - Paid books
   - Restricted content
   - Forthcoming publications
   - Metadata-only entries
```

### Benefits:
- ✅ Clear workflow for different access types
- ✅ Prevents confusion about PDF requirements
- ✅ Saves time (no PDF needed for Closed Access)
- ✅ Professional distinction
- ✅ Google Scholar understands access mode

---

## 🎨 FRONTEND TEMPLATES

### Single Book Page Features:
- Clean, academic design
- Sidebar with all metadata
- **Usage metrics box** (NEW!)
- Download PDF button (tracked)
- Citation box (copy-ready)
- Table of contents (if chapters exist)
- Responsive design

### Archive Page Features:
- Grid layout (responsive)
- Book cards with covers
- **Usage metrics on cards** (NEW!)
- Search functionality
- Sort options
- Pagination
- Category/tag filtering

### Chapter Page Features:
- Breadcrumb navigation
- Parent book context
- Previous/Next navigation
- Chapter metadata
- Download chapter PDF

---

## 📋 ADMIN INTERFACE

### Book Editor Sections:

**1. Title & Content**
- Book title (required)
- Main content editor (description/abstract)
- Featured image (book cover)

**2. Book Publication Details Meta Box**
- Authors (multiple, repeater)
- Editors (optional, multiple)
- Publisher name & city
- Publication date
- ISBN & DOI
- **Access Category** (Open/Closed)
- Price (optional)
- PDF section (conditional on Access Category)

**3. Usage Metrics Meta Box (Sidebar)**
- Views count (auto)
- Downloads count (auto)
- Citations input (manual)
- Information notes

**4. Categories & Tags**
- Book categories (hierarchical)
- Book tags (flat)

---

## 🔐 SYSTEM REQUIREMENTS

### Minimum:
```
✓ WordPress 5.8+
✓ PHP 7.4+
✓ MySQL 5.6+ or MariaDB 10.1+
✓ HTTPS (SSL certificate - required!)
✓ Memory: 128MB
✓ Upload limit: 5MB+ (for PDF uploads)
```

### Recommended:
```
✓ WordPress 6.4+
✓ PHP 8.0+
✓ MySQL 8.0+ or MariaDB 10.6+
✓ HTTPS with valid certificate
✓ Memory: 256MB
✓ Upload limit: 10MB+
```

---

## ✅ POST-INSTALLATION CHECKLIST

After installing the plugin:

```
☐ Plugin activated successfully
☐ Permalinks flushed (Settings → Permalinks → Save)
☐ HTTPS enabled (check padlock icon)
☐ Visit: yoursite.com/catalogs/ (works)
☐ Visit: yoursite.com/robots.txt (allows /catalogs/)
☐ Books menu appears in admin
☐ Chapters menu appears in admin
☐ Add test book with complete metadata
☐ Select Open Access → PDF section visible
☐ Select Closed Access → PDF section hidden
☐ View book page → Check meta tags (View Source)
☐ Test Mendeley/Zotero import → Works correctly
☐ Check Usage Metrics → Views increment
☐ Test PDF download → Downloads increment
```

---

## 🧪 TESTING SCENARIOS

### Scenario 1: Open Access Book
```
1. Create new book
2. Select "Open Access"
3. Upload PDF (< 5MB recommended)
4. Publish book
5. Visit book page
6. Click "Download PDF"
7. Check Usage Metrics → Downloads +1
8. Refresh page → Views +1
```

### Scenario 2: Closed Access Book
```
1. Create new book
2. Select "Closed Access"
3. Note: PDF section hidden
4. Fill other metadata
5. Publish book
6. Visit book page
7. Note: No PDF download button
8. Page still indexed by Google Scholar
```

### Scenario 3: Chapter Hierarchy
```
1. Create a book first
2. Create a chapter
3. Select parent book
4. Publish chapter
5. Check URL: /catalogs/book-title/chapter-title/
6. Check breadcrumb navigation
7. Check previous/next links
```

### Scenario 4: Citation Import
```
1. Open book page
2. View page source
3. Search for "citation_" → Should see many tags
4. Use Mendeley Web Importer
5. Click to import → All fields populated
6. Success!
```

---

## 🎯 GOOGLE SCHOLAR INDEXING

### Timeline:
```
Week 1-4:   Setup, add books, verify metadata
Week 4-12:  Google Scholar initial crawl
Month 2-6:  First books appear in search
Month 6-9:  Full indexing complete
Ongoing:    Scholar updates 2x per year
```

### Requirements Met:
- ✅ All citation_* meta tags
- ✅ Publisher city (unique feature!)
- ✅ PDF URL (if Open Access)
- ✅ Clean URLs
- ✅ Robots.txt optimized
- ✅ HTTPS enabled
- ✅ Structured data (Schema.org)
- ✅ No authentication barriers
- ✅ Crawl-delay set appropriately

### Verify Metadata:
```
1. Visit book page
2. Right-click → View Page Source
3. Press Ctrl+F (or Cmd+F)
4. Search: "citation_"
5. Should see 10+ meta tags
6. Search: "schema.org"
7. Should see JSON-LD structured data
8. All present? ✅ Ready for indexing!
```

---

## 🐛 TROUBLESHOOTING

### Issue: URLs not working (404 error)
**Solution:**
```
Settings → Permalinks → Save Changes
(This flushes rewrite rules)
```

### Issue: PDF section not hiding when Closed Access selected
**Solution:**
```
1. Check browser console for JavaScript errors
2. Clear browser cache (Ctrl+Shift+R)
3. Try different browser
4. Ensure jQuery is loaded
```

### Issue: Usage Metrics not incrementing
**Solution:**
```
1. Check if you're logged in as admin (admin views may not count)
2. Try incognito/private browsing window
3. Check post meta in database: _sbp_views_count
4. Bot detection may be filtering your requests
```

### Issue: Mendeley/Zotero not detecting metadata
**Solution:**
```
1. View page source
2. Verify citation_* tags present
3. Clear browser extension cache
4. Try on different book page
5. Check HTTPS is enabled
```

### Issue: Chapter URLs not hierarchical
**Solution:**
```
1. Ensure parent book is selected
2. Save/publish chapter
3. Flush permalinks
4. Check chapter URL format
5. Should be: /catalogs/book-title/chapter-title/
```

---

## 💡 BEST PRACTICES

### Content Quality:
```
✓ Complete all required fields
✓ Add book description (150+ words)
✓ Use valid ISBN (13-digit)
✓ Include DOI if available
✓ Use searchable PDFs (not scanned images)
✓ Keep PDF files < 5MB when possible
✓ Add book cover image (600x900px recommended)
```

### Metadata:
```
✓ Consistent publisher name across all books
✓ Proper author name format (First Last)
✓ Accurate publication dates
✓ Complete publisher city information
✓ All authors listed (not "et al.")
```

### Access Category:
```
✓ Open Access: For free, publicly available books
✓ Closed Access: For paid, restricted, or forthcoming
✓ Be consistent with access policies
✓ Update to Open Access when book becomes free
```

### Usage Metrics:
```
✓ Monitor regularly
✓ Update citations from Google Scholar monthly
✓ Use metrics to identify popular content
✓ Share metrics with stakeholders
```

---

## 🎉 YOU'RE ALL SET!

Plugin is now ready for production use!

### Next Steps:
1. ✅ Add your book catalog
2. ✅ Configure categories/tags
3. ✅ Customize templates (optional)
4. ✅ Monitor usage metrics
5. ✅ Wait for Google Scholar indexing (6-9 months)
6. ✅ Update citations regularly

### Need Help?
- 📖 Check INSTALLATION-GUIDE.md (comprehensive guide)
- 📖 Check PANDUAN-CEPAT-ID.md (Indonesian guide)
- 📖 Check templates/README-TEMPLATES.md (customization)
- 🐛 Report issues on GitHub
- 💬 Ask in WordPress forums

---

## 📊 PLUGIN SPECIFICATIONS

```
Plugin Name:       Scholar Book Publisher Pro
Version:           1.0.0 (Final)
Author:            Nextmedia
Author URI:        https://nextmedia.id
File Size:         ~75KB (ZIP)
WordPress:         5.8+
PHP:               7.4+
License:           GPL v2 or later

Features:
  - Custom post types: Books, Chapters
  - Metadata fields: 15+ per book
  - Meta tags generated: 30+
  - Frontend templates: 3
  - Usage tracking: Automatic
  - Citation importers: 7+ supported
  - Google Scholar: Fully optimized
```

---

## 🏆 WHAT MAKES THIS SPECIAL

```
✨ Access Category System
   → Smart workflow for Open/Closed access
   
✨ Usage Metrics Tracking
   → Automatic views & downloads tracking
   
✨ Publisher City Field
   → Rare feature, essential for citations
   
✨ Comprehensive Metadata
   → 30+ meta tags for all tools
   
✨ Hierarchical URLs
   → Clean, SEO-friendly structure
   
✨ Citation Importer Ready
   → One-click import in Mendeley/Zotero
   
✨ AI Crawler Optimized
   → Schema.org for GPT, Claude, etc.
   
✨ Zero Configuration
   → Works immediately after activation
```

---

<p align="center">
  <strong>🎊 Congratulations! 🎊</strong>
  <br><br>
  <em>Your academic book publishing platform is ready!</em>
  <br><br>
  <strong>📚 Happy Publishing! 📚</strong>
</p>

---

**Scholar Book Publisher Pro** | v1.0.0 Final | By Nextmedia | GPL v2  
**Status:** ✅ Production Ready | **Updated:** February 2026
