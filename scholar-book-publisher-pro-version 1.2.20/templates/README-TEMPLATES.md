# Frontend Templates Documentation
## Scholar Book Publisher Pro

---

## 📁 Template Files Overview

This plugin includes three main frontend templates with a refined scholarly aesthetic:

### 1. `single-scholar_book.php` - Individual Book Display
**Purpose:** Displays a single book with complete metadata and chapters

**Features:**
- ✅ Two-column layout (sidebar + main content)
- ✅ Book cover with hover animation
- ✅ Complete publication details
- ✅ Author and editor listings
- ✅ Download PDF button (if available)
- ✅ DOI link button
- ✅ Academic citation box (APA style)
- ✅ Table of contents (chapters list)
- ✅ Print-friendly styles
- ✅ Responsive design

**Design:** Refined scholarly minimalism with Baskerville typography and subtle animations

---

### 2. `archive-scholar_book.php` - Books Listing/Archive
**Purpose:** Displays collection of books in grid layout

**Features:**
- ✅ Responsive grid layout (3 columns → 2 → 1)
- ✅ Search box integration
- ✅ Sort options (newest, title, author, oldest)
- ✅ Book cards with covers
- ✅ PDF and DOI badges
- ✅ Hover animations and effects
- ✅ Pagination support
- ✅ Empty state handling
- ✅ Books count display

**Design:** Modern academic library aesthetic with card-based layout

---

### 3. `single-scholar_chapter.php` - Individual Chapter Display
**Purpose:** Displays a book chapter with parent book context

**Features:**
- ✅ Breadcrumb navigation
- ✅ Parent book information box
- ✅ Chapter number and title
- ✅ Chapter-specific authors
- ✅ Page range display
- ✅ Drop cap on first paragraph
- ✅ Academic citation (chapter format)
- ✅ Previous/Next chapter navigation
- ✅ Link back to full book
- ✅ Download chapter PDF (if available)

**Design:** Clean reading experience optimized for academic content

---

## 🎨 Design Philosophy

### Typography Hierarchy
```
Display Font:  Libre Baskerville (headings, titles)
Body Font:     Charter / Georgia (content)
UI Font:       Libre Franklin (buttons, labels)
Mono Font:     IBM Plex Mono (citations, code)
```

### Color Palette
```css
Primary:       #1a1a1a (text)
Secondary:     #4a4a4a (meta text)
Accent:        #8b4513 (brown - academic feel)
Accent Light:  #d2691e (hover states)
Background:    #fafaf8 (warm off-white)
Paper:         #ffffff (content boxes)
Border:        #e5e5e0 (subtle divisions)
```

### Design Principles
1. **Scholarly Refinement** - Professional, academic aesthetic
2. **Readability First** - Generous line-height (1.7-1.75) and spacing
3. **Subtle Motion** - Smooth transitions and animations
4. **Responsive** - Mobile-first approach
5. **Accessibility** - Semantic HTML, ARIA labels, keyboard navigation

---

## 📦 Installation Methods

### Method 1: Copy to Theme (Recommended)
```bash
# Copy templates to your active theme directory
cp templates/single-scholar_book.php /path/to/your-theme/
cp templates/archive-scholar_book.php /path/to/your-theme/
cp templates/single-scholar_chapter.php /path/to/your-theme/
```

**Advantages:**
- ✅ Full control over customization
- ✅ Survives plugin updates
- ✅ Easy to modify

### Method 2: Child Theme
```bash
# Create child theme directory
mkdir /wp-content/themes/your-theme-child/

# Copy templates to child theme
cp templates/*.php /wp-content/themes/your-theme-child/
```

**Advantages:**
- ✅ Preserves parent theme updates
- ✅ Clean separation of customizations

### Method 3: Plugin Default (No Action Needed)
If you don't copy templates to your theme, the plugin will use fallback templates automatically.

**Note:** Custom styling may conflict with theme styles.

---

## 🎨 Customization Guide

### Change Color Scheme

Edit CSS variables at the top of each template file:

```css
/* In single-scholar_book.php */
:root {
    --scholar-primary: #1a1a1a;      /* Change main text color */
    --scholar-accent: #8b4513;        /* Change accent color */
    --scholar-bg: #fafaf8;            /* Change background */
    /* ... other variables ... */
}
```

**Example: Dark Mode**
```css
:root {
    --scholar-primary: #e8e8e8;
    --scholar-secondary: #b0b0b0;
    --scholar-accent: #d2691e;
    --scholar-bg: #1a1a1a;
    --scholar-paper: #2a2a2a;
    --scholar-border: #404040;
}
```

### Change Typography

Replace font families in CSS:

```css
/* Current */
font-family: 'Libre Baskerville', 'Baskerville', serif;

/* Modern Alternative */
font-family: 'Inter', 'Helvetica Neue', sans-serif;

/* Classic Alternative */
font-family: 'Crimson Text', 'Garamond', serif;

/* Brutalist Alternative */
font-family: 'Space Grotesk', 'Arial', sans-serif;
```

**Important:** Update Google Fonts or system fonts accordingly.

### Modify Layout

**Change Grid Columns (Archive):**
```css
/* Current: 3 columns */
.scholar-books-grid {
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
}

/* Change to 4 columns */
.scholar-books-grid {
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
}

/* Change to 2 columns */
.scholar-books-grid {
    grid-template-columns: repeat(auto-fill, minmax(400px, 1fr));
}
```

**Change Sidebar Position (Single Book):**
```css
/* Current: Sidebar on left */
.scholar-book-grid {
    grid-template-columns: 300px 1fr;
}

/* Sidebar on right */
.scholar-book-grid {
    grid-template-columns: 1fr 300px;
}
```

### Add Custom Sections

**Example: Add "Related Books" Section**

In `single-scholar_book.php`, before `get_footer()`:

```php
<?php
// Get related books (same publisher)
$related_books = new WP_Query(array(
    'post_type' => 'scholar_book',
    'posts_per_page' => 3,
    'post__not_in' => array(get_the_ID()),
    'meta_query' => array(
        array(
            'key' => '_sbpp_book_publisher',
            'value' => $publisher,
            'compare' => '='
        )
    )
));

if ($related_books->have_posts()):
?>
    <div class="scholar-related-books">
        <h2>Related Books</h2>
        <div class="scholar-related-grid">
            <?php while ($related_books->have_posts()): $related_books->the_post(); ?>
                <div class="scholar-related-item">
                    <a href="<?php the_permalink(); ?>">
                        <?php the_post_thumbnail('thumbnail'); ?>
                        <h3><?php the_title(); ?></h3>
                    </a>
                </div>
            <?php endwhile; wp_reset_postdata(); ?>
        </div>
    </div>
<?php endif; ?>
```

---

## 🔧 Advanced Customization

### Remove Elements

**Hide PDF Download Button:**
```css
.scholar-btn-primary {
    display: none;
}
```

**Hide Citation Box:**
```css
.scholar-citation-box {
    display: none;
}
```

**Hide Chapter Navigation:**
```css
.scholar-chapter-navigation {
    display: none;
}
```

### Add Custom CSS

**Method 1: Via Theme's style.css**
```css
/* Add to your theme's stylesheet */
.scholar-book-title {
    color: #custom-color;
    font-size: 3.5rem;
}
```

**Method 2: Via Customizer**
1. Go to Appearance → Customize
2. Additional CSS
3. Add your custom CSS

**Method 3: Via Plugin (Recommended)**
Create `/wp-content/plugins/scholar-book-publisher/assets/css/custom.css`

Then enqueue it:
```php
// In plugin main file
function sbpp_enqueue_custom_styles() {
    if (is_singular('scholar_book') || is_post_type_archive('scholar_book')) {
        wp_enqueue_style(
            'sbp-custom',
            plugins_url('assets/css/custom.css', __FILE__)
        );
    }
}
add_action('wp_enqueue_scripts', 'sbpp_enqueue_custom_styles');
```

### JavaScript Interactions

**Add "Copy Citation" Button:**

Add to template before citation box closing tag:

```php
<button onclick="copyCitation(this)" class="scholar-copy-citation">
    Copy Citation
</button>

<script>
function copyCitation(button) {
    const citation = button.previousElementSibling.textContent;
    navigator.clipboard.writeText(citation).then(() => {
        button.textContent = 'Copied!';
        setTimeout(() => {
            button.textContent = 'Copy Citation';
        }, 2000);
    });
}
</script>
```

---

## 🎯 Common Use Cases

### 1. University Press Style
```css
:root {
    --scholar-accent: #003262; /* University blue */
    --scholar-accent-light: #3b7ea1;
}
.scholar-book-title {
    text-transform: uppercase;
    letter-spacing: 0.05em;
}
```

### 2. Minimalist Clean
```css
.scholar-book-card {
    border: none;
    box-shadow: none;
}
.scholar-book-card:hover {
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}
```

### 3. Magazine Editorial
```css
.scholar-book-content p:first-of-type::first-letter {
    font-size: 6rem;
    line-height: 0.8;
    color: var(--scholar-accent);
}
.scholar-chapter-title {
    font-style: italic;
}
```

---

## 📱 Responsive Breakpoints

Templates use these responsive breakpoints:

```css
/* Mobile First Approach */
/* Small phones: 0-600px (base styles) */

/* Tablets: 600px+ */
@media (max-width: 768px) {
    .scholar-book-grid {
        grid-template-columns: 1fr;
    }
}

/* Desktop: 900px+ */
@media (max-width: 900px) {
    .scholar-books-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

/* Large Desktop: 1200px+ */
@media (min-width: 1200px) {
    .scholar-books-grid {
        grid-template-columns: repeat(3, 1fr);
    }
}
```

### Mobile Optimization Tips

1. **Test on real devices** - Emulators don't show real performance
2. **Optimize images** - Use responsive images (`srcset`)
3. **Reduce animations** - Use `prefers-reduced-motion` media query
4. **Touch targets** - Minimum 44x44px for buttons

---

## ♿ Accessibility Features

All templates include:

### Semantic HTML
```html
<article> for book content
<nav> for navigation
<aside> for sidebar
<header> for page headers
```

### ARIA Labels
```html
<nav aria-label="Breadcrumb">
<nav aria-label="Books pagination">
```

### Keyboard Navigation
- All interactive elements are keyboard accessible
- Focus states clearly visible
- Logical tab order

### Screen Reader Support
- Alt text on images
- Descriptive link text
- Skip links (can be added)

### Testing Checklist
```
☐ Keyboard-only navigation works
☐ Screen reader announces content correctly
☐ Color contrast meets WCAG AA (4.5:1)
☐ Focus indicators visible
☐ No motion sickness triggers
☐ Text resizes properly (up to 200%)
```

---

## 🐛 Troubleshooting

### Templates Not Showing

**Problem:** Custom templates not being used

**Solutions:**
1. Verify file names are exact: `single-scholar_book.php`
2. Clear cache (if using caching plugin)
3. Flush permalinks: Settings → Permalinks → Save Changes
4. Check theme supports custom post type templates

### Styling Conflicts

**Problem:** Theme CSS overriding template styles

**Solutions:**
1. Increase specificity:
   ```css
   /* Instead of */
   .scholar-book-title { }
   
   /* Use */
   body.single-scholar_book .scholar-book-title { }
   ```

2. Use `!important` (last resort):
   ```css
   .scholar-book-title {
       color: #1a1a1a !important;
   }
   ```

3. Dequeue theme styles on book pages:
   ```php
   function sbpp_dequeue_theme_styles() {
       if (is_singular('scholar_book')) {
           wp_dequeue_style('theme-style-handle');
       }
   }
   add_action('wp_enqueue_scripts', 'sbpp_dequeue_theme_styles', 100);
   ```

### Images Not Displaying

**Problem:** Book covers not showing

**Solutions:**
1. Check featured image is set
2. Verify image size exists:
   ```php
   add_image_size('scholar-book-cover', 600, 900, true);
   ```
3. Regenerate thumbnails (Regenerate Thumbnails plugin)

### Mobile Layout Issues

**Problem:** Layout broken on mobile

**Solutions:**
1. Add viewport meta tag in header:
   ```html
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   ```
2. Test with browser dev tools
3. Check for fixed widths in CSS

---

## 📊 Performance Optimization

### Best Practices

1. **Lazy Load Images**
   ```php
   the_post_thumbnail('large', array(
       'loading' => 'lazy'
   ));
   ```

2. **Inline Critical CSS**
   - Keep template CSS inline (< 10KB)
   - Load additional CSS separately

3. **Minimize Queries**
   - Use `WP_Query` efficiently
   - Cache query results

4. **Optimize Fonts**
   ```html
   <!-- Preconnect to font source -->
   <link rel="preconnect" href="https://fonts.googleapis.com">
   
   <!-- Load only needed weights -->
   <link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:wght@400;700&display=swap">
   ```

---

## 🔄 Updates & Maintenance

### When Plugin Updates

If you've copied templates to your theme:

1. **Check changelog** for template changes
2. **Compare files** with new version
3. **Test thoroughly** after updates
4. **Backup first** before updating templates

### Version Control

Recommended file structure:
```
your-theme/
├── scholar-templates/
│   ├── v1.0.0/
│   │   └── single-scholar_book.php
│   └── v1.1.0/
│       └── single-scholar_book.php (updated)
└── single-scholar_book.php (active)
```

---

## 💡 Tips & Best Practices

### Do's ✅
- Keep templates simple and focused
- Use theme's design language when appropriate
- Test on multiple devices and browsers
- Follow WordPress coding standards
- Add comments for custom modifications
- Use child theme for customizations

### Don'ts ❌
- Don't hardcode URLs or paths
- Don't remove security functions (esc_html, etc.)
- Don't ignore responsive design
- Don't forget about accessibility
- Don't use deprecated WordPress functions
- Don't modify plugin files directly

---

## 📚 Resources

### WordPress Template Hierarchy
- https://developer.wordpress.org/themes/basics/template-hierarchy/

### Typography Resources
- Google Fonts: https://fonts.google.com
- Font Pair: https://fontpair.co

### Accessibility
- WCAG Guidelines: https://www.w3.org/WAI/WCAG21/quickref/
- WebAIM: https://webaim.org

### Performance
- Google PageSpeed: https://pagespeed.web.dev
- GTmetrix: https://gtmetrix.com

---

## 🤝 Contributing

Found a bug or have a template improvement?

1. **Report Issues:** GitHub Issues
2. **Submit Templates:** Pull requests welcome
3. **Share Customizations:** Community showcase

---

## 📄 License

Templates are licensed under GPL v2 or later, same as WordPress.

You are free to:
- Use commercially
- Modify freely
- Distribute
- Sublicense

---

**Version:** 1.0.0  
**Last Updated:** February 2026  
**Compatible With:** Scholar Book Publisher Pro 1.0.0+

For more help, see INSTALLATION-GUIDE.md or visit plugin documentation.
