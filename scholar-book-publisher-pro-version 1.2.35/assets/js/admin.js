/**
 * Scholar Book Publisher Pro - Admin JavaScript
 * 
 * WYSIWYG Editor Fix - Safe, non-blocking approach
 * 
 * @package Scholar_Book_Publisher
 * @version 1.2.14
 */

(function($) {
    'use strict';
    
    var editorId = 'sbpp_book_description';
    var focusAttempts = 0;
    var maxFocusAttempts = 3;
    
    /**
     * Auto-focus title field on new book page
     */
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
    
    /**
     * Safely focus the TinyMCE editor WITHOUT blocking
     */
    function safelyFocusEditor() {
        // Prevent too many attempts
        if (focusAttempts >= maxFocusAttempts) {
            console.log('[SBP] Max focus attempts reached, stopping');
            return;
        }
        
        focusAttempts++;
        
        var editor = tinymce.get(editorId);
        if (!editor) {
            console.log('[SBP] Editor not found');
            return;
        }
        
        try {
            // Simple, safe focus
            editor.focus();
            console.log('[SBP] Editor focused (attempt ' + focusAttempts + ')');
        } catch(e) {
            console.error('[SBP] Error focusing editor:', e);
        }
    }
    
    /**
     * Initialize editor on page load ONCE
     */
    function initializeEditorOnce() {
        // Check if we're on a book edit page
        if (!$('#' + editorId).length) {
            return;
        }
        
        console.log('[SBP] Book edit page detected');
        
        // Wait for TinyMCE to be ready
        var checkTinyMCE = setInterval(function() {
            if (typeof tinymce !== 'undefined' && tinymce.get(editorId)) {
                clearInterval(checkTinyMCE);
                console.log('[SBP] TinyMCE ready');
                
                // Focus ONCE after a delay
                setTimeout(function() {
                    safelyFocusEditor();
                }, 300);
            }
        }, 100);
        
        // Stop checking after 5 seconds
        setTimeout(function() {
            clearInterval(checkTinyMCE);
        }, 5000);
    }
    
    /**
     * Handle ONLY Visual tab click (not blocking)
     */
    function handleVisualTabClick() {
        $(document).on('click.sbpEditor', '#' + editorId + '-tmce', function(e) {
            console.log('[SBP] Visual tab clicked');
            
            // Reset counter for new tab switch
            focusAttempts = 0;
            
            // Focus after tab switches
            setTimeout(function() {
                safelyFocusEditor();
            }, 100);
        });
    }
    
    /**
     * Handle ONLY Text tab click (not blocking)
     */
    function handleTextTabClick() {
        $(document).on('click.sbpEditor', '#' + editorId + '-html', function(e) {
            console.log('[SBP] Text tab clicked');
            
            // Focus textarea
            setTimeout(function() {
                $('#' + editorId).focus();
            }, 50);
        });
    }
    
    /**
     * Initialize everything
     */
    $(document).ready(function() {
        console.log('[SBP] Admin scripts loaded');
        
        // Focus title field on new book pages
        focusTitleField();
        
        // Only initialize editor if on book page
        if ($('#' + editorId).length) {
            initializeEditorOnce();
            handleVisualTabClick();
            handleTextTabClick();
        }
    });
    
})(jQuery);
