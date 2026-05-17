import os
import re

directory = '.'

for root, dirs, files in os.walk(directory):
    if '.git' in root:
        continue
    for file in files:
        if file == 'scholar-book-publisher.php':
            continue
            
        filepath = os.path.join(root, file)
        
        # Only process text files (PHP)
        if not filepath.endswith('.php'):
            continue

        with open(filepath, 'r', encoding='utf-8') as f:
            content = f.read()
            
        new_content = content
        
        if filepath.endswith('class-sbp-admin-notices.php'):
            # Replace sbpDismissSitemapNotice()
            new_content = re.sub(r'sbpDismissSitemapNotice\(\)', 'sbppDismissSitemapNotice()', new_content)
            new_content = re.sub(r'function sbpDismissSitemapNotice\(\)', 'function sbppDismissSitemapNotice()', new_content)

        if content != new_content:
            with open(filepath, 'w', encoding='utf-8') as f:
                f.write(new_content)
            print(f"Updated {filepath}")

print("Update complete.")
