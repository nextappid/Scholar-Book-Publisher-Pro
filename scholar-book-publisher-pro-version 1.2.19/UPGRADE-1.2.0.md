# Scholar Book Publisher Pro v1.2.0 — Upgrade Guide

## 🔄 URL Structure Changed

Version 1.2.0 introduces a **cleaner, more semantic URL structure** for your book catalog.

### Old Structure (v1.1.x):
```
Archive:  yoursite.com/catalogs/
Book:     yoursite.com/catalogs/book-title/
Chapter:  yoursite.com/catalogs/book-title/chapter-title/
```

### New Structure (v1.2.0):
```
Archive:  yoursite.com/books/
Book:     yoursite.com/books/book-title/
Chapter:  yoursite.com/books/book-title/chapter-title/
```

---

## ⚠️ CRITICAL: Flush Permalinks Required

After upgrading to v1.2.0, **you MUST flush permalinks** or all book URLs will return 404 errors.

### How to Flush Permalinks:

1. Go to **WordPress Admin Dashboard**
2. Navigate to **Settings → Permalinks**
3. **Click "Save Changes"** (don't change anything, just click save)
4. Done! New URLs are now active.

---

## ✅ Automatic 301 Redirects — ACTIVE

**Good news!** Starting v1.2.0, **automatic 301 redirects are built-in**. 

All old `/catalogs/` URLs automatically redirect to `/books/` with proper 301 (permanent) status code.

### What This Means:
- ✅ **No broken links** — old URLs still work
- ✅ **SEO preserved** — search engines transfer ranking to new URLs
- ✅ **Zero configuration** — works automatically after permalink flush
- ✅ **External links safe** — bookmarks and shared links continue working

### Covered Redirects:
```
/catalogs/                      → /books/
/catalogs/book-title/           → /books/book-title/
/catalogs/book/chapter/         → /books/book/chapter/
/catalogs/page/2/               → /books/page/2/
/catalogs/book-category/fiction/ → /books/book-category/fiction/
```

---

## 🔍 What Gets Updated

### Automatically Updated:
- ✅ Archive page slug: `/catalogs/` → `/books/`
- ✅ Book post type slug: `catalogs` → `books`
- ✅ Chapter permalink structure
- ✅ `robots.txt` rules
- ✅ Sitemap references
- ✅ **Automatic 301 redirects for all old URLs**

### Requires Manual Action:
- ⚠️ **Flush permalinks** (Settings → Permalinks → Save)
- ⚠️ Update any **hardcoded links** in custom theme code (optional)
- ⚠️ Update **Google Search Console** sitemaps (if needed)

---

## 🚀 Optional: Server-Level Redirects (Advanced)

The **automatic PHP redirects work perfectly** for 99% of sites. However, if you want **maximum performance**, you can add server-level redirects.

### Benefits of Server-Level Redirects:
- ⚡ Slightly faster (redirect happens before PHP loads)
- 📊 Reduces server load on high-traffic sites

### When NOT Needed:
- ❌ Small to medium sites (< 10,000 visits/day)
- ❌ If you don't have server file access
- ❌ Shared hosting without custom .htaccess

### Apache / .htaccess Rules:

**Location:** Add to your `.htaccess` file in WordPress root

```apache
# Scholar Book Publisher v1.2.0 - Legacy URL Redirects
<IfModule mod_rewrite.c>
RewriteEngine On
RewriteBase /

# Archive
RewriteRule ^catalogs/?$ books/ [R=301,L]

# Pagination
RewriteRule ^catalogs/page/([0-9]+)/?$ books/page/$1/ [R=301,L]

# Books
RewriteRule ^catalogs/([^/]+)/?$ books/$1/ [R=301,L]

# Chapters
RewriteRule ^catalogs/([^/]+)/([^/]+)/?$ books/$1/$2/ [R=301,L]

# Categories
RewriteRule ^catalogs/book-category/([^/]+)/?$ books/book-category/$1/ [R=301,L]

# Tags
RewriteRule ^catalogs/book-tag/([^/]+)/?$ books/book-tag/$1/ [R=301,L]
</IfModule>
```

### Nginx Rules:

**Location:** Add to your nginx server block configuration

```nginx
# Scholar Book Publisher v1.2.0 - Legacy URL Redirects

# Archive
rewrite ^/catalogs/?$ /books/ permanent;

# Pagination
rewrite ^/catalogs/page/([0-9]+)/?$ /books/page/$1/ permanent;

# Books
rewrite ^/catalogs/([^/]+)/?$ /books/$1/ permanent;

# Chapters
rewrite ^/catalogs/([^/]+)/([^/]+)/?$ /books/$1/$2/ permanent;

# Categories
rewrite ^/catalogs/book-category/([^/]+)/?$ /books/book-category/$1/ permanent;

# Tags
rewrite ^/catalogs/book-tag/([^/]+)/?$ /books/book-tag/$1/ permanent;
```

**Important:** Server-level redirects are **completely optional**. The automatic PHP redirects handle everything.

---

## ✅ Verification Checklist

After upgrading, verify:

- [ ] Flushed permalinks (Settings → Permalinks → Save)
- [ ] Archive page loads: `yoursite.com/books/`
- [ ] Book pages load: `yoursite.com/books/sample-book/`
- [ ] Chapter pages load: `yoursite.com/books/sample-book/chapter-1/`
- [ ] **Test old URL**: Visit `yoursite.com/catalogs/` — should redirect to `/books/`
- [ ] **Test old book URL**: Should redirect to new `/books/` structure
- [ ] Search functionality works on archive page
- [ ] Filters (category, year, OA) work correctly
- [ ] Dark/light theme toggle works
- [ ] No 404 errors on any book/chapter pages

---

## 🐛 Troubleshooting

### All book pages show 404:
→ **You forgot to flush permalinks!** Go to Settings → Permalinks → Save Changes.

### Old /catalogs/ URLs show 404 instead of redirecting:
→ Flush permalinks again. The redirect function only works after permalink flush.

### Archive page works but book pages don't:
→ Check if your theme has conflicting rewrite rules. Deactivate theme temporarily to test.

### Redirects work but are slow:
→ Consider adding server-level redirects (see optional section above).

---

## 📊 SEO Impact & Google Search Console

### Automatic Handling:
- ✅ **301 redirects preserve PageRank** — Google transfers link value
- ✅ **Canonical URLs** automatically updated
- ✅ **Sitemaps** reference new URLs only

### Google Search Console (Optional):
1. Old sitemap: `yoursite.com/catalogs-sitemap.xml` → remove (if exists)
2. New sitemap: `yoursite.com/books-sitemap.xml` → submit
3. Monitor coverage report for 301 redirects

**Note:** Google will automatically discover and process the 301 redirects. No urgent action needed.

---

## 📝 Changelog v1.2.0

### Added:
- ✅ Automatic 301 redirects for legacy `/catalogs/` URLs
- ✅ SEO migration helper with canonical URLs
- ✅ Server redirect rules generator (optional)
- ✅ Enhanced admin notice with redirect status

### Changed:
- Archive URL: `/catalogs/` → `/books/`
- Book permalink: `catalogs/book` → `books/book`
- Chapter permalink: `catalogs/book/chapter` → `books/book/chapter`
- robots.txt rules
- Sitemap references

### Technical:
- Added `SBPP_SEO_Migration` class
- Added `handle_legacy_url_redirects()` function
- Enhanced permalink flush instructions
- Improved upgrade UX

---

## 🎉 Migration Complete!

Once you've flushed permalinks and verified the checklist above, your migration is complete!

**All old URLs will continue working** thanks to automatic redirects, while search engines gradually migrate to the new structure.

You can safely dismiss the admin notice once verification is complete.

---

## 🆘 Need Help?

If you encounter issues:

1. **Flush permalinks twice** (it really helps!)
2. **Clear all caches** (WordPress, CDN, browser)
3. **Deactivate conflicting plugins** temporarily
4. **Test with default theme** to rule out theme conflicts
5. **Check .htaccess permissions** (should be writable)

The plugin includes comprehensive automatic redirects — if something isn't working, it's usually a permalink flush or cache issue.
