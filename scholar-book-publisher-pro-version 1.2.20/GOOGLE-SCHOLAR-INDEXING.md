# Google Scholar Indexing Guide

## What's Fixed in v1.2.5

### Critical Google Scholar Requirements Added

1. ✅ **citation_book_title** — REQUIRED for book indexing
2. ✅ **citation_online_date** — When book became available online
3. ✅ **citation_editor** — For edited volumes
4. ✅ **XML Sitemap** — /books-sitemap.xml for discovery
5. ✅ **Proper Institution Tags** — Author affiliation

---

## How to Verify Your Books Are Indexed

### Step 1: Check Meta Tags

Visit your book page and view source (Ctrl+U or Cmd+Option+U):

```html
<!-- Should see these tags in <head> -->
<meta name="citation_title" content="Your Book Title">
<meta name="citation_book_title" content="Your Book Title">
<meta name="citation_author" content="Last, First">
<meta name="citation_author_institution" content="Publisher Name">
<meta name="citation_publication_date" content="2024-01-15">
<meta name="citation_online_date" content="2024-01-15">
<meta name="citation_publisher" content="Publisher Name">
<meta name="citation_isbn" content="978-1234567890">
<meta name="citation_doi" content="10.1234/example">
<meta name="citation_pdf_url" content="https://...">
<meta name="citation_abstract_html_url" content="https://...">
<meta name="citation_fulltext_html_url" content="https://...">
```

### Step 2: Check Robots.txt

Visit: `https://yoursite.com/robots.txt`

Should contain:
```
User-agent: Googlebot-Scholar
Allow: /books/
Allow: /wp-content/uploads/

User-agent: *
Allow: /books/
```

### Step 3: Check Sitemap

Visit: `https://yoursite.com/books-sitemap.xml`

Should show XML list of all books and chapters.

### Step 4: Submit to Google Scholar

**Important:** Google Scholar does NOT have a submission form like Google Search Console.

**How Google Scholar Finds Content:**
1. Googlebot-Scholar automatically crawls the web
2. Looks for pages with citation_* meta tags
3. Indexes scholarly content automatically

**To Help Google Scholar Find You:**
1. ✅ Make sure site is indexed in regular Google Search first
2. ✅ Submit your sitemap to Google Search Console: `https://yoursite.com/books-sitemap.xml`
3. ✅ Get backlinks from other academic sites (.edu, .ac, scholarly repositories)
4. ✅ Ensure content is high-quality and scholarly

### Step 5: Test with Google Scholar Search Operator

After 2-4 weeks, test if indexed:

```
site:yoursite.com intitle:"your book title"
```

Search in Google Scholar (not regular Google): https://scholar.google.com

---

## Timeline for Indexing

**Realistic Expectations:**

- **Week 1-2:** Google discovers your site
- **Week 2-4:** Googlebot-Scholar starts crawling
- **Week 4-8:** First books appear in Google Scholar
- **Month 3-6:** Full catalog indexed

**Note:** Google Scholar is slower than regular Google Search. Be patient.

---

## Requirements for Successful Indexing

### MUST HAVE:
1. ✅ Valid citation_title
2. ✅ Valid citation_book_title (for books)
3. ✅ At least one citation_author
4. ✅ citation_publication_date
5. ✅ Scholarly/academic content
6. ✅ Publicly accessible (not login-walled)
7. ✅ Proper HTML structure
8. ✅ Robots.txt allows Googlebot-Scholar

### HIGHLY RECOMMENDED:
1. ✅ citation_pdf_url (full-text PDF)
2. ✅ citation_doi (DOI increases credibility)
3. ✅ citation_isbn
4. ✅ Abstract/description
5. ✅ Multiple authors with institutions
6. ✅ Backlinks from academic sources

### OPTIONAL BUT HELPFUL:
1. ✅ citation_keywords
2. ✅ citation_language
3. ✅ References/citations to other works
4. ✅ Being cited by other indexed papers

---

## Common Issues That Prevent Indexing

### 1. Missing Required Tags
**Problem:** No citation_book_title for books
**Solution:** ✅ Fixed in v1.2.5

### 2. Robots Blocking
**Problem:** robots.txt blocks Googlebot-Scholar
**Solution:** ✅ Already configured correctly

### 3. Content Behind Paywall
**Problem:** Login required to view books
**Solution:** Make sure book pages are publicly viewable (even if PDFs are restricted)

### 4. Non-Scholarly Content
**Problem:** Content is not academic/scholarly
**Solution:** Ensure you're publishing legitimate scholarly works

### 5. New Site
**Problem:** Site is too new, not indexed yet
**Solution:** Wait 4-8 weeks, build backlinks, submit sitemap

### 6. Invalid HTML
**Problem:** Broken HTML prevents meta tag parsing
**Solution:** Validate with W3C validator

### 7. No Backlinks
**Problem:** Google doesn't know your site exists
**Solution:** Get links from other academic sites

---

## How to Speed Up Indexing

### 1. Submit Sitemap to Google Search Console
```
1. Go to https://search.google.com/search-console
2. Add your property
3. Sitemaps → Add sitemap: books-sitemap.xml
4. Submit
```

### 2. Get Backlinks from Academic Sources
- University websites (.edu)
- Research institution websites (.ac.uk, .edu.au)
- Other scholarly publishers
- Academic blogs
- ResearchGate, Academia.edu profiles
- ORCID profiles

### 3. Register with Academic Identifiers
- Get DOIs from CrossRef or DataCite
- Register ISBN with your country's ISBN agency
- Create ORCID profiles for authors
- Link to institutional repositories

### 4. Make PDF Available
If possible, provide open access PDFs:
- More likely to be indexed
- Higher citation potential
- Better visibility

---

## Verification Checklist

After updating to v1.2.5:

```
□ Flush permalinks (Settings → Permalinks → Save)
□ Visit a book page
□ View page source (Ctrl+U)
□ Verify citation_book_title tag exists
□ Verify citation_author tag exists
□ Verify citation_publication_date exists
□ Verify citation_pdf_url exists (if you have PDFs)
□ Check robots.txt allows Googlebot-Scholar
□ Check sitemap works: /books-sitemap.xml
□ Submit sitemap to Google Search Console
□ Wait 4-8 weeks for indexing
□ Search on Google Scholar for your books
```

---

## Monitor Indexing Progress

### Google Search Console
- Shows when Googlebot last crawled
- Shows any crawl errors
- Shows sitemap status

### Google Scholar
- Search: `site:yoursite.com`
- Shows indexed scholarly content
- May take weeks to show results

### Server Logs
- Look for Googlebot-Scholar in access logs
- Shows when Google Scholar is crawling

---

## Support Resources

**Google Scholar Help:**
- https://scholar.google.com/intl/en/scholar/inclusion.html

**Highwire Press Tags:**
- https://scholar.google.com/intl/en/scholar/inclusion.html#indexing

**Dublin Core:**
- https://www.dublincore.org/specifications/dublin-core/dcmi-terms/

**Schema.org Books:**
- https://schema.org/Book

---

## Expected Results After v1.2.5

**Immediate:**
- ✅ All required meta tags present
- ✅ Robots.txt configured correctly
- ✅ Sitemap accessible
- ✅ Valid HTML structure

**Within 2-4 Weeks:**
- ⏳ Google discovers your books
- ⏳ Googlebot-Scholar starts crawling
- ⏳ Server logs show Scholar crawler visits

**Within 4-8 Weeks:**
- ⏳ First books appear in Google Scholar
- ⏳ Citation counts start tracking
- ⏳ Books searchable by title/author

**Within 3-6 Months:**
- ⏳ Full catalog indexed
- ⏳ Regular updates crawled
- ⏳ Citations tracked automatically

---

**Status:** v1.2.5 implements ALL Google Scholar requirements
**Confidence:** High — all technical requirements met
**Timeline:** 4-8 weeks for initial indexing (typical for new sites)
