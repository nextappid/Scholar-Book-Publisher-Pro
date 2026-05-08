# Scholar Book Publisher Pro v1.2.14 — Editor Tab Fix & Title Autofocus

## Version 1.2.14 (2024-03-11) — Visual/Text Mode Display Fix

### Fixed — CRITICAL LAYOUT BUG
- ✅ **Both Visual and Text modes showing simultaneously** — CSS hide fix
- ✅ **Duplicate editor areas visible** — Tab switching CSS added
- ✅ **Title field autofocus** — Cursor starts in "Add title" on new books

---

## The Problem (From Screenshot)

**User Screenshot Shows:**
```
┌─────────────────────────────────┐
│ Book Description (Synopsis)     │
│                                 │
│ [Visual] [Code] ← Tabs          │
│ ┌─────────────────────────────┐ │
│ │ Paragraph [toolbar]         │ │ ← Visual mode area
│ │                             │ │
│ │                             │ │
│ └─────────────────────────────┘ │
│                                 │
│ ┌─────────────────────────────┐ │
│ │ P                           │ │ ← Text mode area
│ │                             │ │   (showing at same time!)
│ │                             │ │
│ └─────────────────────────────┘ │
└─────────────────────────────────┘
```

**Problem:** BOTH Visual and Text editor areas showing at the same time!

---

## Root Cause

### WordPress wp_editor Structure

```html
<div id="wp-sbp_book_description-wrap" class="tmce-active">
  <!-- Tabs -->
  <button id="sbp_book_description-tmce">Visual</button>
  <button id="sbp_book_description-html">Text</button>
  
  <!-- Visual Mode (TinyMCE) -->
  <div class="wp-editor-container">
    <iframe id="sbp_book_description_ifr">...</iframe>
  </div>
  
  <!-- Text Mode (Textarea) -->
  <textarea id="sbp_book_description" class="wp-editor-area"></textarea>
</div>
```

**Default WordPress Behavior:**
- When `.tmce-active` → Visual mode shown, Text mode hidden
- When `.html-active` → Text mode shown, Visual mode hidden

**Our Problem:**
- CSS rules not hiding inactive mode
- Both modes visible simultaneously
- Looks like 2 editors!

---

## The Solution

### 1. Added Tab Switching CSS

**Hide Text Mode When Visual Active:**
```css
#wp-sbp_book_description-wrap.tmce-active .wp-editor-area {
    display: block !important;
}

#wp-sbp_book_description-wrap.tmce-active textarea.wp-editor-area {
    display: none !important;  /* ← Hide textarea */
}
```

**Hide Visual Mode When Text Active:**
```css
#wp-sbp_book_description-wrap.html-active .wp-editor-container {
    display: none !important;  /* ← Hide TinyMCE */
}

#wp-sbp_book_description-wrap.html-active textarea.wp-editor-area {
    display: block !important;  /* ← Show textarea */
}
```

### 2. Title Field Autofocus

**New JavaScript Function:**
```javascript
function focusTitleField() {
    // Check if this is Add New page (no post ID in URL)
    var urlParams = new URLSearchParams(window.location.search);
    var postId = urlParams.get('post');
    
    // Only on new book pages
    if (!postId && $('#title').length) {
        setTimeout(function() {
            $('#title').focus();
            console.log('[SBP] Title field focused');
        }, 100);
    }
}
```

**Called on Page Load:**
```javascript
$(document).ready(function() {
    focusTitleField();  // ← Auto-focus title
    // ... rest of initialization
});
```

---

## How It Works Now

### Visual Tab Active

```
Click "Visual" tab
  ↓
WordPress adds class: .tmce-active
  ↓
CSS hides: textarea.wp-editor-area
  ↓
CSS shows: .wp-editor-container (TinyMCE)
  ↓
Result: ONLY Visual editor visible ✅
```

### Text Tab Active

```
Click "Text" tab  
  ↓
WordPress adds class: .html-active
  ↓
CSS hides: .wp-editor-container
  ↓
CSS shows: textarea.wp-editor-area
  ↓
Result: ONLY Text editor visible ✅
```

### New Book Page

```
Page loads
  ↓
JavaScript checks: No post ID?
  ↓
focusTitleField() runs
  ↓
$('#title').focus()
  ↓
Result: Cursor in "Add title" field ✅
```

---

## Files Modified

| File | Changes | Impact |
|------|---------|--------|
| `assets/css/admin.css` | • Added .tmce-active textarea hide rule<br>• Added .html-active container hide rule<br>• Updated version to 1.2.14 | **CSS FIX** |
| `assets/js/admin.js` | • Added focusTitleField() function<br>• Added URL parameter check<br>• Auto-focus title on new books<br>• Updated version to 1.2.14 | **UX IMPROVEMENT** |

---

## Before vs After

### Before v1.2.14:

```
Add New Book:

Book Description
┌───────────────────────────┐
│ [Visual] [Text]           │
├───────────────────────────┤
│ TinyMCE Visual Editor     │ ← Visible
│ [Toolbar] [Content area]  │
├───────────────────────────┤
│ Textarea Text Editor      │ ← ALSO Visible!
│ <p>HTML code here</p>     │   (WRONG!)
└───────────────────────────┘

❌ Both editors showing = Confusion!
```

### After v1.2.14:

```
Add New Book:

Title: [________]_ ← Cursor here automatically!

Book Description  
┌───────────────────────────┐
│ [Visual] [Text]           │
├───────────────────────────┤
│ TinyMCE Visual Editor     │ ← Visible
│ [Toolbar] [Content area]  │
└───────────────────────────┘

Click [Text] tab:
┌───────────────────────────┐
│ [Visual] [Text]           │
├───────────────────────────┤
│ Textarea Text Editor      │ ← Visible
│ <p>HTML code here</p>     │
└───────────────────────────┘

✅ Only ONE editor showing at a time!
✅ Cursor auto-starts in Title field!
```

---

## Technical Explanation

### WordPress wp_editor CSS Classes

**Class States:**

| State | Class on Wrapper | What Shows |
|-------|------------------|------------|
| Visual Mode | `.tmce-active` | TinyMCE iframe |
| Text Mode | `.html-active` | Textarea |

**Our CSS Rules:**

```css
/* When .tmce-active (Visual mode) */
.tmce-active .wp-editor-container { display: block; }
.tmce-active textarea { display: none; }

/* When .html-active (Text mode) */
.html-active .wp-editor-container { display: none; }
.html-active textarea { display: block; }
```

**Why !important:**
- Override other plugin styles
- Ensure our rules take precedence
- Guarantee correct display

---

## Testing Steps

### Test 1: Visual Mode

```
1. Go to Books → Add New
2. ✅ Cursor should be in "Add title" field
3. Scroll to Book Description
4. Click "Visual" tab (if not already active)
5. ✅ Should see ONLY TinyMCE editor
6. ✅ Should NOT see textarea below
7. ✅ Count editors: ONLY 1
```

### Test 2: Text Mode

```
1. In Book Description
2. Click "Text" tab
3. ✅ TinyMCE should disappear
4. ✅ Textarea should appear
5. ✅ Count editors: ONLY 1
6. Type some HTML: <p>Test</p>
7. ✅ Should show in textarea
```

### Test 3: Tab Switching

```
1. Start in Visual mode
2. Type: "Hello World"
3. Click "Text" tab
4. ✅ Should see: <p>Hello World</p>
5. Click "Visual" tab
6. ✅ Should see: Hello World (formatted)
7. ✅ Only one editor visible at a time
```

### Test 4: Title Autofocus

```
1. Go to Books → Add New
2. Wait for page to load
3. ✅ Cursor should be blinking in Title field
4. ✅ Can start typing immediately
5. Open DevTools Console
6. ✅ Should see: [SBP] Title field focused
```

### Test 5: Edit Existing Book

```
1. Edit an existing book
2. ✅ Title should NOT auto-focus (correct)
3. ✅ Only one editor showing
4. ✅ Description loads correctly
```

---

## Why Previous Versions Failed

### v1.2.13 and Earlier

**Problem:** No CSS rules to hide inactive editor mode

**Result:**
- Visual mode container: `display: block`
- Text mode textarea: `display: block`
- BOTH visible simultaneously

**Why:** WordPress doesn't hide inactive modes by default in meta boxes

---

## Console Output

**On Add New Book:**
```
[SBP] Admin scripts loaded
[SBP] Title field focused
[SBP] Book edit page detected
[SBP] TinyMCE ready
[SBP] Editor focused (attempt 1)
```

**On Visual Tab Click:**
```
[SBP] Visual tab clicked
[SBP] Editor focused (attempt 1)
```

**On Text Tab Click:**
```
[SBP] Text tab clicked
```

---

## Benefits

### 1. Clean Interface
```
Before: Confusing, two editors visible
After: Clean, one editor at a time
```

### 2. Better UX
```
Before: User confused which area to use
After: Clear, only active mode shown
```

### 3. Title Autofocus
```
Before: User clicks title field manually
After: Cursor ready, start typing immediately
```

### 4. Professional Appearance
```
Before: Looks broken/buggy
After: Professional, polished
```

---

## Edge Cases Handled

### 1. Slow Page Load

```javascript
setTimeout(function() {
    $('#title').focus();
}, 100);  // ← Waits for elements to render
```

### 2. Edit vs New Page

```javascript
var postId = urlParams.get('post');
if (!postId) {
    // Only focus on new pages
    focusTitleField();
}
```

### 3. Tab Switching

```css
/* Both directions handled */
.tmce-active { ... }
.html-active { ... }
```

---

## Verification Checklist

```
□ Updated to v1.2.14
□ Cleared browser cache
□ Went to Books → Add New
□ Cursor in Title field? ✅
□ Scrolled to Book Description
□ Visual tab active by default? ✅
□ Only ONE editor area visible? ✅
□ Clicked "Text" tab
□ TinyMCE disappeared? ✅
□ Textarea appeared? ✅
□ Only ONE editor area visible? ✅
□ Clicked "Visual" tab
□ Textarea disappeared? ✅
□ TinyMCE appeared? ✅
□ Only ONE editor area visible? ✅
□ Tested editing existing book
□ Title NOT auto-focused? ✅ (correct)
□ Editor works normally? ✅
```

---

## Status

**Duplicate Editor Areas:** ✅ FIXED (CSS hide rules)
**Tab Switching:** ✅ WORKING (only one visible)
**Title Autofocus:** ✅ IMPLEMENTED (new books only)
**Visual Mode:** ✅ CLEAN
**Text Mode:** ✅ CLEAN
**UX:** ✅ PROFESSIONAL

**Required Action:** Update to v1.2.14
**Breaking Changes:** None
**Expected Result:** ONE editor at a time + Title autofocus

---

**Root Cause:** No CSS to hide inactive editor mode  
**Solution:** Added .tmce-active and .html-active CSS rules  
**Bonus:** Title field autofocus on new books  
**Result:** Clean interface, single editor, better UX ✅
