# Scholar Book Publisher Pro v1.2.3 — Language Filter

## Version 1.2.3 (2024-02-18) — Language Filter Added

### Added
- ✅ **Language filter** on archive page (after Year filter)
- ✅ Dynamic language dropdown (populated from database)
- ✅ Language icon in filter header
- ✅ Full AJAX integration

### Frontend Features
- ✅ Language select dropdown
- ✅ "All Languages" default option
- ✅ Real-time filtering
- ✅ Works with other filters (category, year, OA, search)
- ✅ Included in Clear Filters button
- ✅ Debug logging in console

### Backend Features
- ✅ Language filter in AJAX handler
- ✅ Meta query on `_sbp_book_language` field
- ✅ Sanitization and validation
- ✅ Exact match comparison

---

## Implementation Details

### Frontend (Archive Template)

**HTML Filter:**
```html
<div class="scholar-filter-section">
    <h3 class="scholar-filter-title">
        <svg><!-- language icon --></svg>
        Language
    </h3>
    <select id="language-filter">
        <option value="">All Languages</option>
        <?php foreach ($languages as $language): ?>
            <option value="<?php echo esc_attr($language); ?>">
                <?php echo esc_html($language); ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>
```

**JavaScript:**
```javascript
const languageSelect = document.getElementById('language-filter');
let activeLanguage = '';

languageSelect.addEventListener('change', function() {
    activeLanguage = this.value;
    runAjaxFilter(1);
});

// In FormData
if (activeLanguage) data.append('language', activeLanguage);

// In hasFilter check
const hasFilter = activeCategories.length > 0 || activeYear || 
                  activeLanguage || oaOnly || searchTerm;
```

### Backend (AJAX Handler)

**PHP Processing:**
```php
$language = isset($_POST['language']) ? sanitize_text_field($_POST['language']) : '';

if (!empty($language)) {
    $args['meta_query'][] = array(
        'key'     => '_sbp_book_language',
        'value'   => $language,
        'compare' => '=',
    );
}
```

---

## Supported Languages

The filter displays all languages currently in use in your database:

- English
- Indonesian (Bahasa Indonesia)
- Spanish (Español)
- French (Français)
- German (Deutsch)
- Chinese (中文)
- Arabic (العربية)
- Portuguese (Português)
- Russian (Русский)
- Japanese (日本語)
- Korean (한국어)
- Dutch (Nederlands)
- Italian (Italiano)
- Other

**Note:** Only languages that have at least one published book will appear in the dropdown.

---

## Filter Position

```
Sidebar Filters:
├── Search (title/author)
├── Categories (checkboxes)
├── Year (dropdown)
├── Language (dropdown) ← NEW
├── Access Type (toggle)
└── Clear Filters (button)
```

---

## Usage Examples

### Example 1: Filter by Language
```
1. Visit /books/
2. Select "Indonesian" from Language dropdown
3. Only Indonesian books appear instantly
```

### Example 2: Combined Filters
```
1. Check "Fiction" category
2. Select "2024" year
3. Select "English" language
4. Toggle "Open Access"
→ Shows: English fiction books from 2024 that are open access
```

### Example 3: Language + Search
```
1. Select "Spanish" language
2. Type "quantum" in search
→ Shows: Spanish books with "quantum" in title/author
```

---

## Console Output

When language filter is used:

```javascript
Filter triggered with: {
  categories: [],
  year: "",
  language: "English",  // ← Language parameter
  oaOnly: false,
  search: "",
  page: 1
}

Sending AJAX to: /wp-admin/admin-ajax.php
AJAX Response status: 200
AJAX Response: {
  success: true,
  data: {
    html: "...",
    found_posts: 42,
    max_pages: 1,
    paged: 1
  }
}
```

---

## Database Query

The language filter uses WordPress meta_query:

```php
'meta_query' => array(
    'relation' => 'AND',
    array(
        'key'     => '_sbp_book_language',
        'value'   => 'English',
        'compare' => '='
    )
)
```

---

## Testing Checklist

### Frontend
```
□ Language dropdown appears after Year filter
□ Shows "All Languages" by default
□ Clicking language filters instantly
□ Works with category filter
□ Works with year filter
□ Works with open access filter
□ Works with search
□ All filters can be combined
□ Clear Filters resets language
□ Console shows language in logs
□ No JavaScript errors
```

### Admin
```
□ Language filter works when logged in
□ Same behavior as frontend
```

---

## Files Modified

| File | Changes |
|------|---------|
| `templates/archive-scholar_book.php` | • Added language filter HTML<br>• Added language SQL query<br>• Added language JS variable<br>• Added event listener<br>• Added to AJAX data<br>• Added to hasFilter check<br>• Added to clearFilters()<br>• Added to console logs |
| `scholar-book-publisher.php` | • Added language parameter<br>• Added language meta_query<br>• Version bump to 1.2.3 |
| All files | Version consistency |

---

## Performance

- **SQL Query:** Fast - uses indexed meta_key
- **Filter Speed:** Instant (same as other filters)
- **No Impact:** Existing filters unaffected

---

## Upgrade Notes

**From v1.2.0, v1.2.1, or v1.2.2:**
- Just update plugin
- Language filter appears automatically
- No configuration needed

**From v1.1.x:**
- Follow v1.2.0 upgrade guide first
- Then update to v1.2.3

---

## Complete Filter Matrix

| Filter | Type | Values | Status |
|--------|------|--------|--------|
| Search | Input | Title/Author | ✅ |
| Category | Checkboxes | Dynamic | ✅ |
| Year | Dropdown | Dynamic | ✅ |
| Language | Dropdown | Dynamic | ✅ NEW |
| Access Type | Toggle | Open/All | ✅ |

All filters work together and can be combined in any way!

---

**Status:** ✅ READY
**Feature:** Language Filter
**Impact:** Enhanced filtering capabilities
