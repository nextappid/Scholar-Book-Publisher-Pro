/**
 * Scholar Book Publisher Pro - Frontend JavaScript
 * 
 * @package Scholar_Book_Publisher
 * @version 1.0.0
 */

(function($) {
    'use strict';
    
    $(document).ready(function() {
        
        // Initialize any frontend interactions here
        
        // Example: Copy citation to clipboard
        $('.scholar-copy-citation').on('click', function(e) {
            e.preventDefault();
            var citationText = $(this).siblings('.scholar-citation-box').text().trim();
            
            if (navigator.clipboard) {
                navigator.clipboard.writeText(citationText).then(function() {
                    alert('Citation copied to clipboard!');
                }).catch(function(err) {
                    console.error('Failed to copy citation:', err);
                });
            }
        });
        
    });
    
})(jQuery);
