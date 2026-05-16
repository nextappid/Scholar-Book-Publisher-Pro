# Scholar Book Publisher Pro - Installation & Usage Guide

## 📋 Table of Contents
1. [System Requirements](#system-requirements)
2. [Installation Methods](#installation-methods)
3. [Initial Configuration](#initial-configuration)
4. [Adding Your First Book](#adding-your-first-book)
5. [Google Drive Setup](#google-drive-setup)
6. [Google Scholar Optimization](#google-scholar-optimization)
7. [Troubleshooting](#troubleshooting)
8. [FAQ](#faq)

---

## 🖥️ System Requirements

### Minimum Requirements
- **WordPress Version:** 5.8 or higher
- **PHP Version:** 7.4 or higher (8.0+ recommended)
- **MySQL Version:** 5.6 or higher (or MariaDB 10.1+)
- **Memory Limit:** 128MB minimum (256MB recommended)
- **Upload File Size:** 5MB minimum for PDF uploads
- **HTTPS:** Required (SSL certificate installed)

### Recommended Hosting Specifications
- **Disk Space:** 
  - If using WordPress Upload: 50MB+ per book
  - If using Google Drive: Minimal (only metadata)
- **Bandwidth:** Sufficient for PDF downloads (if using WordPress upload)
- **Hosting Type:** Shared hosting acceptable, VPS/dedicated preferred

### Server Requirements
```
PHP Extensions Required:
- mysqli
- json
- xml
- mbstring
- zip (for imports)
- curl (for Google Drive validation)
- gd or imagick (for thumbnails)

Apache Modules (if applicable):
- mod_rewrite (for permalinks)
- mod_headers
```

### Check Your System
Navigate to: **WordPress Admin → Tools → Site Health** to verify compatibility.

---

## 📥 Installation Methods

### Method 1: Upload via WordPress Admin (Recommended for Beginners)

**Step 1:** Download the plugin
- Download `scholar-book-publisher-pro.zip` from the provider

**Step 2:** Upload to WordPress
1. Log in to your WordPress admin panel
2. Navigate to **Plugins → Add New**
3. Click **Upload Plugin** button at the top
4. Click **Choose File** and select `scholar-book-publisher-pro.zip`
5. Click **Install Now**

**Step 3:** Activate
1. After installation completes, click **Activate Plugin**
2. You'll see a success message: "Plugin activated successfully"

**Step 4:** Verify Installation
1. Check for new menu items: **Books** and **Chapters** in the admin sidebar
2. Navigate to **Settings → Permalinks** and click **Save Changes** (flush rewrite rules)

---

### Method 2: FTP/SFTP Upload (For Advanced Users)

**Step 1:** Extract the plugin
- Unzip `scholar-book-publisher-pro.zip` on your computer
- You should see a folder named `scholar-book-publisher`

**Step 2:** Upload via FTP
1. Connect to your server using FTP client (FileZilla, Cyberduck, etc.)
2. Navigate to `/wp-content/plugins/`
3. Upload the entire `scholar-book-publisher` folder
4. Verify all files are uploaded successfully

**Step 3:** Activate
1. Log in to WordPress admin
2. Navigate to **Plugins → Installed Plugins**
3. Find "Scholar Book Publisher Pro"
4. Click **Activate**

**Step 4:** Set Permissions (if needed)
```bash
# Connect via SSH and run:
cd /path/to/wordpress/wp-content/plugins/scholar-book-publisher
chmod 755 -R .
chown www-data:www-data -R .
```

---

### Method 3: WP-CLI Installation (For Developers)

```bash
# Navigate to WordPress root
cd /path/to/wordpress

# Install from zip
wp plugin install /path/to/scholar-book-publisher-pro.zip --activate

# Or install from directory
cp -r /path/to/scholar-book-publisher wp-content/plugins/
wp plugin activate scholar-book-publisher

# Flush rewrite rules
wp rewrite flush

# Verify installation
wp plugin list | grep scholar
```

---

## ⚙️ Initial Configuration

### Step 1: Verify Plugin Activation

After activation, you should see:

✅ **New Admin Menu Items:**
- Books (with book icon 📚)
- Chapters (with document icon 📄)

✅ **Automatic Setup Completed:**
- Custom post types registered
- Upload directories created (`/wp-content/uploads/scholar-books/` and `/scholar-chapters/`)
- Rewrite rules flushed
- Default settings created

### Step 2: Configure Permalinks

**CRITICAL STEP - DO NOT SKIP!**

1. Navigate to **Settings → Permalinks**
2. Ensure you're NOT using "Plain" permalinks
3. Recommended: **Post name** structure (`/%postname%/`)
4. Click **Save Changes**

Your book URLs will look like:
```
https://yoursite.com/books/book-title/
https://yoursite.com/chapters/chapter-title/
```

### Step 3: Verify Robots.txt

1. Visit: `https://yoursite.com/robots.txt`
2. Verify you see these lines:

```
# Google Scholar Crawler Access
User-agent: Googlebot-Scholar
Allow: /books/
Allow: /chapters/
Allow: /wp-content/uploads/
```

If not visible:
- Go to **Settings → Reading**
- Uncheck "Discourage search engines from indexing this site"
- Save changes

### Step 4: Check XML Sitemap

1. Visit: `https://yoursite.com/books-sitemap.xml`
2. You should see XML sitemap structure (even if empty initially)
3. This sitemap will auto-update when you add books

### Step 5: Verify Upload Directories

Check that these directories exist (via FTP or File Manager):
```
/wp-content/uploads/scholar-books/
/wp-content/uploads/scholar-chapters/
```

Each should contain an empty `index.php` file for security.

### Step 6: SSL Certificate Verification

**Google Scholar requires HTTPS!**

1. Visit: `https://yoursite.com` (note the "https")
2. Check for padlock icon in browser
3. If no SSL:
   - Contact your hosting provider
   - Or use free SSL from Let's Encrypt
   - Many hosts offer one-click SSL installation

---

## 📚 Adding Your First Book

### Complete Step-by-Step Tutorial

#### Step 1: Navigate to Books

1. In WordPress admin, click **Books → Add New**
2. You'll see the book editor screen

#### Step 2: Enter Basic Information

**Book Title** (Required)
```
Example: Machine Learning Fundamentals
```

**Subtitle** (Optional)
```
Example: A Practical Approach to Modern AI
```

**Book Content/Description**
- Use the main editor to add:
  - Book description
  - Abstract
  - Table of contents
  - Any introductory text

#### Step 3: Add Authors

1. Scroll to "Book Publication Details" meta box
2. Find the "Authors" section
3. Click **+ Add Author**
4. Enter:
   - **First Name:** `John`
   - **Last Name:** `Smith`
5. For multiple authors, click **+ Add Author** again
6. Authors will appear in citation as: `Smith, John`

**Important Formatting:**
- Last name first in citations: ✅ `Smith, John`
- Not: ❌ `John Smith`
- Consistent capitalization
- Full first names (not just initials)

#### Step 4: Add Editors (Optional)

For edited volumes or collections:
1. Click **+ Add Editor**
2. Same format as authors
3. Editors will appear in metadata as "Contributor"

#### Step 5: Publisher Information

**Publisher Name** (Required)
```
Example: Oxford University Press
```
- Use official publisher name
- Consistent across all books
- No abbreviations unless official

**Publisher City** (Required)
```
Example: New York
```
- City of publication
- Used in formal citations
- Format: `City Name` (not "City, State")

#### Step 6: Publication Details

**Publication Date** (Required)
1. Click the date picker
2. Select the official publication date
3. Format: `YYYY-MM-DD`
4. Note: Google Scholar will use year only

**ISBN** (Required)
```
Example: 978-0-19-123456-7
```
- 13-digit ISBN (with or without hyphens)
- Include hyphens for readability: `978-0-19-123456-7`
- Validate at: https://www.isbn-international.org/

**DOI** (Optional but Highly Recommended)
```
Example: 10.1234/example.book.2026
```
- Digital Object Identifier
- Greatly improves discoverability
- Format: Just the DOI, not full URL
- Correct: `10.1234/example`
- Wrong: `https://doi.org/10.1234/example`

#### Step 7: PDF Provision (Optional but Recommended)

**Option A: No PDF**
- Simply leave "This book has a PDF available" unchecked
- Warning: May not be indexed by Google Scholar
- Use only for: metadata-only entries, forthcoming books

**Option B: WordPress Upload** (See detailed steps below)

**Option C: Google Drive Link** (See [Google Drive Setup](#google-drive-setup))

#### Step 8: Set Featured Image (Optional)

1. In right sidebar, find "Featured Image"
2. Click **Set featured image**
3. Upload book cover (recommended size: 600x900px)
4. This will display in archive pages

#### Step 9: Categorize (Optional)

1. In right sidebar, add:
   - **Categories:** Science, Technology, etc.
   - **Tags:** machine learning, AI, algorithms
2. Helps with site organization and filtering

#### Step 10: Publish

1. Click **Publish** button (top right)
2. You'll see: "Book published successfully"
3. Click **View Book** to see the public page

---

### Adding PDF via WordPress Upload

#### Step 1: Prepare Your PDF

Before uploading, ensure:
- ✅ File size < 5MB (compress if needed)
- ✅ Searchable text (not scanned image)
- ✅ Proper filename: `book-title.pdf` (no spaces, use hyphens)
- ✅ Metadata embedded in PDF properties

**How to check if PDF is searchable:**
1. Open PDF in reader
2. Try to select and copy text
3. If you can copy text = searchable ✅
4. If you can't = scanned image ❌

**How to compress PDF:**
- Online: https://www.ilovepdf.com/compress_pdf
- Adobe Acrobat: File → Save As Other → Reduced Size PDF
- Mac Preview: Export → Reduce File Size

#### Step 2: Enable PDF in WordPress

1. Check ☑️ **"This book has a PDF available"**
2. Select ⚫ **"Schema 1: Upload to WordPress Media Library"**

#### Step 3: Upload PDF

1. Click **📤 Upload PDF File** button
2. WordPress Media Library will open
3. Options:
   - **Upload Files Tab:** Drag & drop or click "Select Files"
   - **Media Library Tab:** Select existing PDF

#### Step 4: Select PDF

1. Click on the PDF you uploaded
2. Verify the preview shows correctly
3. Click **Use this PDF** button

#### Step 5: Verify Upload

You'll see a success message:
```
✅ Selected PDF: machine-learning-fundamentals.pdf
File size: 2.3 MB
```

**If file > 5MB:**
```
⚠️ Warning: This file is larger than 5MB (7.8 MB). 
Google Scholar may not index files larger than 5MB.
```

Action: Compress the PDF or split into chapters.

#### Step 6: Save

Click **Update** or **Publish** to save changes.

---

## 🔗 Google Drive Setup

### Why Use Google Drive?

**Advantages:**
- ✅ Unlimited storage (15GB free, more with paid plans)
- ✅ No server storage used
- ✅ Easy to update files
- ✅ Can handle multiple large books
- ✅ Automatic backups

**Best for:**
- Large PDF files (> 5MB)
- Publishers with many books
- Limited server storage
- Books that may need updates

### Complete Google Drive Setup

#### Step 1: Upload PDF to Google Drive

1. Go to https://drive.google.com
2. Log in with your Google account
3. Click **+ New** → **File upload**
4. Select your PDF file
5. Wait for upload to complete

#### Step 2: Set Sharing Permissions

**CRITICAL - DO NOT SKIP!**

1. Right-click the uploaded PDF
2. Select **Share**
3. Click **Change to anyone with the link** (or "Get link")
4. Ensure it says: **"Anyone with the link"** + **"Viewer"**
5. Click **Copy link**

Your link will look like:
```
https://drive.google.com/file/d/1ABCdefGHIjklMNOpqrSTUVwxyz123456/view?usp=sharing
```

**Common Mistake:** Leaving it as "Restricted" - Google Scholar cannot access!

#### Step 3: Add Link to WordPress

1. In WordPress book editor, check ☑️ **"This book has a PDF available"**
2. Select ⚫ **"Schema 2: Link from Google Drive"**
3. Paste the Google Drive link in **"Google Drive Share Link"** field

#### Step 4: Validate and Extract ID

1. Click **🔍 Validate & Extract Google Drive ID** button
2. Plugin will automatically:
   - Extract the File ID from the link
   - Generate direct download link
   - Display success message

You'll see:
```
✅ Success! File ID extracted: 1ABCdefGHIjklMNOpqrSTUVwxyz123456

Direct Download Link:
https://drive.google.com/uc?export=download&id=1ABCdefGHIjklMNOpqrSTUVwxyz123456
```

#### Step 5: Test Download Link

1. Click **🧪 Test Download Link** button
2. Your browser should start downloading the PDF
3. If it doesn't download:
   - Check sharing permissions (Step 2)
   - Verify the file isn't corrupted
   - Try a different browser

#### Step 6: Enter File Size (Optional)

1. Find the PDF file size:
   - Right-click PDF in Google Drive → Details
   - Convert to MB (e.g., 2.5 MB)
2. Enter in **"PDF File Size (MB)"** field
3. Plugin will warn if > 5MB

#### Step 7: Save

Click **Update** or **Publish**.

### Troubleshooting Google Drive Links

**Problem: Link doesn't extract ID**
- Ensure you copied the full link
- Try removing tracking parameters: `?usp=sharing`
- Use this format: `https://drive.google.com/file/d/FILE_ID/view`

**Problem: Download doesn't work**
- Verify: Right-click file → Share → "Anyone with the link"
- Not "Restricted" or "People with access"
- Wait 5 minutes after changing permissions

**Problem: Google Scholar not crawling**
- Ensure file is set to "Anyone with the link"
- File must be in root or public folder (not restricted folder)
- Wait 6-9 months for initial indexing

---

## 🎯 Google Scholar Optimization

### Pre-Publication Checklist

Before publishing, verify:

#### ✅ Metadata Complete
- [ ] Book title is clear and descriptive
- [ ] All author names formatted correctly (Last, First)
- [ ] Publisher name is official and consistent
- [ ] Publisher city is correct
- [ ] Publication date is accurate
- [ ] ISBN is valid (13 digits)
- [ ] DOI added (if available)

#### ✅ PDF Requirements
- [ ] PDF is available (WordPress or Google Drive)
- [ ] File size < 5MB (recommended)
- [ ] PDF is searchable (text can be copied)
- [ ] PDF opens without errors
- [ ] Direct download link works

#### ✅ Content Quality
- [ ] Abstract/description is comprehensive (150+ words)
- [ ] Content is scholarly/academic in nature
- [ ] No spelling errors in metadata
- [ ] Categories and tags added

#### ✅ Technical Requirements
- [ ] Site has valid SSL certificate (HTTPS)
- [ ] Robots.txt allows Googlebot-Scholar
- [ ] XML sitemap includes the book
- [ ] Permalink structure is SEO-friendly
- [ ] Page loads in < 10 seconds

### Verify Meta Tags

**Critical Step:** Check that meta tags are properly generated.

1. Publish your book
2. Click **View Book** to see public page
3. Right-click page → **View Page Source** (or press `Ctrl+U`)
4. Press `Ctrl+F` and search for: `citation_`

You should see tags like:
```html
<!-- Google Scholar Metadata (Scholar Book Publisher Pro) -->
<meta name="citation_title" content="Machine Learning Fundamentals">
<meta name="citation_author" content="Smith, John">
<meta name="citation_author" content="Doe, Jane">
<meta name="citation_publication_date" content="2026">
<meta name="citation_publisher" content="Oxford University Press">
<meta name="citation_publisher_place" content="New York">
<meta name="citation_isbn" content="978-0-19-123456-7">
<meta name="citation_doi" content="10.1234/example">
<meta name="citation_pdf_url" content="https://yoursite.com/path/to/book.pdf">
<meta name="citation_abstract_html_url" content="https://yoursite.com/books/machine-learning/">
<!-- End Google Scholar Metadata -->
```

**If tags are missing:**
1. Ensure plugin is activated
2. Clear cache (if using caching plugin)
3. Check theme compatibility (might override wp_head)

### Submit to Google Scholar (Optional)

**Note:** Submission is NOT required - Google Scholar crawls automatically.

However, you can manually notify Google:

1. Wait until you have at least 5-10 books published
2. Visit: https://scholar.google.com/intl/en/scholar/inclusion.html
3. Review inclusion guidelines
4. Submit your sitemap: `https://yoursite.com/books-sitemap.xml`

**Timeline:**
- Initial crawl: 4-12 weeks
- First indexing: 2-6 months
- Full indexing: 6-9 months
- Updates: 2x per year (Google Scholar update cycle)

### Monitoring Indexing Status

**Method 1: Site-Specific Search**
```
site:yoursite.com "Book Title"
```
Search on Google Scholar. If indexed, your book will appear.

**Method 2: Author Search**
```
author:"John Smith" site:yoursite.com
```

**Method 3: ISBN Search**
```
isbn:978-0-19-123456-7
```

### Best Practices for Indexing

1. **Consistent Metadata**
   - Use same publisher name across all books
   - Consistent author name format
   - Same ISBN format (with or without hyphens)

2. **Regular Publishing**
   - Add books regularly (not all at once)
   - Google Scholar prefers active sites
   - Aim for 1-2 books per month minimum

3. **Quality Over Quantity**
   - Complete metadata better than partial
   - Proper PDFs better than scanned images
   - Academic content only

4. **Update Frequency**
   - Google Scholar updates index 2x/year
   - Don't expect immediate results
   - Changes take months to reflect

5. **Link Building**
   - Get citations from other indexed papers
   - Share on academic platforms (ResearchGate, Academia.edu)
   - Submit to DOAJ if open access

---

## 🔧 Troubleshooting

### Common Issues and Solutions

#### Issue 1: Plugin Doesn't Appear After Activation

**Symptoms:**
- No "Books" or "Chapters" menu items
- Settings don't show

**Solutions:**
1. **Check PHP version:**
   ```
   WordPress Admin → Site Health → Info → Server
   Ensure PHP 7.4+
   ```

2. **Check for conflicts:**
   - Deactivate all other plugins
   - Activate Scholar Book Publisher Pro
   - Test if it appears
   - Reactivate other plugins one by one

3. **Check error logs:**
   ```
   /wp-content/debug.log (if WP_DEBUG enabled)
   ```

4. **Reinstall:**
   - Deactivate plugin
   - Delete plugin files
   - Reinstall fresh copy

#### Issue 2: Books Not Showing on Frontend

**Symptoms:**
- Book published but shows 404 error
- Permalink doesn't work

**Solutions:**
1. **Flush rewrite rules:**
   ```
   Settings → Permalinks → Save Changes
   ```

2. **Check theme compatibility:**
   - Switch to default WordPress theme (Twenty Twenty-Four)
   - Test if book displays
   - If yes, contact theme developer

3. **Create custom templates (advanced):**
   - Copy `single.php` from theme
   - Rename to `single-scholar_book.php`
   - Customize as needed

#### Issue 3: PDF Upload Fails

**Symptoms:**
- "Upload failed" error
- File doesn't appear in media library

**Solutions:**
1. **Check file size limit:**
   ```
   WordPress Admin → Media → Add New
   Check "Maximum upload file size"
   ```

2. **Increase PHP limits (via hosting):**
   - Contact hosting provider
   - Ask to increase `upload_max_filesize` to 10MB
   - Also increase `post_max_size` to 10MB

3. **Edit php.ini (if you have access):**
   ```ini
   upload_max_filesize = 10M
   post_max_size = 10M
   max_execution_time = 300
   ```

4. **Use .htaccess (for Apache servers):**
   ```apache
   php_value upload_max_filesize 10M
   php_value post_max_size 10M
   ```

5. **Try smaller file:**
   - Compress PDF to < 5MB
   - Or use Google Drive method

#### Issue 4: Google Drive Link Doesn't Extract

**Symptoms:**
- "Could not extract File ID" error
- Validation fails

**Solutions:**
1. **Check link format:**
   - Correct: `https://drive.google.com/file/d/1ABC.../view?usp=sharing`
   - Wrong: `https://drive.google.com/open?id=1ABC...`

2. **Try manual extraction:**
   - Your link: `https://drive.google.com/file/d/1ABCdefGHI/view`
   - File ID is: `1ABCdefGHI` (between `/d/` and `/view`)
   - Paste File ID directly in "Extracted File ID" field

3. **Generate new share link:**
   - In Google Drive, click Share again
   - Generate new link
   - Try again

#### Issue 5: Meta Tags Not Appearing

**Symptoms:**
- View source shows no `citation_` tags
- Google Scholar not indexing

**Solutions:**
1. **Clear all caches:**
   - WordPress cache (if using W3 Total Cache, WP Super Cache)
   - CDN cache (Cloudflare, etc.)
   - Browser cache (Ctrl+Shift+R)

2. **Check theme compatibility:**
   ```php
   // Theme must call wp_head() in header.php
   // Look for this line:
   <?php wp_head(); ?>
   ```

3. **Disable caching for testing:**
   - Temporarily deactivate caching plugins
   - Test meta tags
   - Reactivate after verification

4. **Check for theme overrides:**
   - Some themes override wp_head
   - Contact theme developer
   - Or switch to default theme

#### Issue 6: Books Not in Sitemap

**Symptoms:**
- Visit `/books-sitemap.xml` shows empty
- Books don't appear in sitemap

**Solutions:**
1. **Flush rewrite rules:**
   ```
   Settings → Permalinks → Save Changes
   ```

2. **Check publication status:**
   - Only "Published" books appear in sitemap
   - "Draft" or "Pending" won't show

3. **Regenerate sitemap:**
   ```php
   // Add this code to functions.php temporarily:
   add_action('init', function() {
       flush_rewrite_rules();
   });
   
   // Visit any page, then remove the code
   ```

4. **Check .htaccess:**
   - Ensure .htaccess isn't blocking XML files
   - Look for rules blocking `.xml` extension

#### Issue 7: SSL/HTTPS Issues

**Symptoms:**
- "Not Secure" warning in browser
- Mixed content errors
- Google Scholar won't crawl

**Solutions:**
1. **Install SSL certificate:**
   - Contact hosting provider
   - Most offer free Let's Encrypt SSL
   - One-click installation usually available

2. **Update WordPress URLs:**
   ```
   Settings → General
   WordPress Address (URL): https://yoursite.com
   Site Address (URL): https://yoursite.com
   ```

3. **Force HTTPS via plugin:**
   - Install "Really Simple SSL" plugin
   - Activate and follow wizard

4. **Update .htaccess (manual):**
   ```apache
   # Force HTTPS
   RewriteEngine On
   RewriteCond %{HTTPS} off
   RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
   ```

---

## ❓ FAQ

### General Questions

**Q: Is this plugin free?**
A: Yes, Scholar Book Publisher Pro is completely free and open-source.

**Q: Does it work with any WordPress theme?**
A: Yes, but themes must properly implement `wp_head()`. Most modern themes do.

**Q: Can I use it for journals/articles?**
A: This plugin is optimized for books. For journals, consider OJS (Open Journal Systems).

**Q: Will it slow down my site?**
A: No significant impact. The plugin is lightweight and only loads on book pages.

**Q: Can I migrate from another system?**
A: Yes, you can manually add books or use CSV import (if implemented).

### PDF Questions

**Q: What if my PDF is larger than 5MB?**
A: Options:
1. Compress the PDF (recommended)
2. Split into chapters
3. Use Google Drive (but may not be indexed by Google Scholar)

**Q: Can I update the PDF after publishing?**
A: Yes, simply replace the file:
- WordPress: Upload new PDF, select it
- Google Drive: Replace file in Drive (keep same File ID)

**Q: Do I need PDF for every book?**
A: No, but highly recommended for Google Scholar indexing.

**Q: Can I use both WordPress and Google Drive for different books?**
A: Yes! Each book can use different methods.

**Q: What PDF format is best?**
A: Standard PDF/A or PDF 1.7, searchable text, not scanned images.

### Google Scholar Questions

**Q: How long until Google Scholar indexes my books?**
A: Typically 6-9 months for new sites, 2-4 months for established sites.

**Q: Do I need to submit to Google Scholar?**
A: No, Google Scholar crawls automatically. Submission is optional.

**Q: Why isn't my book appearing in Google Scholar?**
A: Common reasons:
- Too new (wait 6+ months)
- Incomplete metadata
- PDF not searchable or accessible
- Site not HTTPS
- Content not scholarly

**Q: Can I track how many times my books are cited?**
A: Google Scholar shows citations automatically. You can also use:
- Google Scholar Alerts
- Google Scholar Profile (create one)
- Third-party tools (Publish or Perish)

**Q: What's the difference between indexing and ranking?**
A: Indexing = appearing in search results
Ranking = position in search results
Both depend on quality and citations.

### Technical Questions

**Q: Is coding knowledge required?**
A: No, the plugin has a user-friendly interface. No coding needed.

**Q: Can I customize the book templates?**
A: Yes, create custom templates in your theme:
- `single-scholar_book.php` for book pages
- `archive-scholar_book.php` for book listings

**Q: Does it work with page builders?**
A: Yes, but you'll use the meta boxes for metadata, not the page builder.

**Q: Can I use custom fields?**
A: Yes, the plugin uses standard WordPress custom fields. You can add more.

**Q: Is it multisite compatible?**
A: Yes, activate per site or network-wide.

**Q: Can I export my books?**
A: Not built-in yet, but you can:
- Use WordPress export (Tools → Export)
- Access database directly
- Use third-party export plugins

### Google Drive Questions

**Q: Does Google Drive cost money?**
A: 15GB free, paid plans available for more storage.

**Q: What if I delete the file from Google Drive?**
A: The download link will break. Always keep files in Drive.

**Q: Can I organize files in folders in Google Drive?**
A: Yes, organize as you like. Just ensure "Anyone with the link" permission.

**Q: Will Google Drive links expire?**
A: No, as long as you maintain your Google account and file permissions.

**Q: Can multiple books share the same PDF?**
A: Yes, but each book should have its own PDF for proper indexing.

---

## 📞 Support & Resources

### Getting Help

**Plugin Documentation:**
- GitHub: [Link to repository]
- Documentation: [Link to docs]

**WordPress Support:**
- WordPress Forums: https://wordpress.org/support/
- Stack Exchange: https://wordpress.stackexchange.com/

**Google Scholar Help:**
- Inclusion Guidelines: https://scholar.google.com/intl/en/scholar/inclusion.html
- Help Center: https://scholar.google.com/intl/en/scholar/help.html

### Reporting Issues

If you encounter bugs:
1. Check this guide first
2. Search existing issues on GitHub
3. Create new issue with:
   - WordPress version
   - PHP version
   - Plugin version
   - Detailed description
   - Steps to reproduce
   - Screenshots (if applicable)

### Contributing

This is an open-source project. Contributions welcome:
- Code improvements
- Translation files
- Documentation
- Bug reports
- Feature requests

---

## 🎓 Best Practices Summary

### For Optimal Google Scholar Indexing:

1. **Complete Metadata**
   - Every field filled accurately
   - Consistent formatting across books
   - Valid ISBN and DOI

2. **Quality PDFs**
   - Searchable text (not scanned)
   - < 5MB file size
   - Properly formatted
   - Accessible without login

3. **Technical Setup**
   - HTTPS enabled
   - Proper permalinks
   - Fast loading times
   - Clean robots.txt

4. **Regular Updates**
   - Add books consistently
   - Update metadata when needed
   - Monitor indexing status

5. **Patience**
   - Wait 6-9 months for indexing
   - Don't expect immediate results
   - Build quality over quantity

---

## 📊 Quick Reference Checklist

### Before Publishing Each Book:

```
☐ Title and subtitle entered
☐ At least one author added (Last, First format)
☐ Publisher name and city filled
☐ Valid publication date selected
☐ 13-digit ISBN entered
☐ DOI added (if available)
☐ PDF uploaded or Google Drive linked
☐ PDF is < 5MB and searchable
☐ Book description/abstract written (150+ words)
☐ Featured image added (book cover)
☐ Categories/tags added
☐ Preview looks correct
☐ Meta tags verified in page source
☐ PDF download tested
☐ HTTPS working (padlock icon)
☐ No cache preventing updates
```

### After Publishing:

```
☐ Book appears on frontend
☐ PDF downloads correctly
☐ Meta tags in page source
☐ Added to sitemap XML
☐ Robots.txt allows crawling
☐ Shared on social media/academic platforms
☐ Added to Google Scholar profile (if you have one)
☐ Monitor for citations (after 6+ months)
```

---

**Version:** 1.0.0  
**Last Updated:** February 2026  
**Plugin:** Scholar Book Publisher Pro

For the latest version of this guide, visit: [Link to documentation site]

---

**Need more help?** Contact support or consult the FAQ section above.

**Ready to publish?** Start adding your first book now! 📚
