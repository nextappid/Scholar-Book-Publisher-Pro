import os
import re

directory = '.'

# Files to exclude from content renaming if necessary
exclude_files = ['rename_prefixes.py']

for root, dirs, files in os.walk(directory):
    if '.git' in root:
        continue
    for file in files:
        if file in exclude_files:
            continue
            
        filepath = os.path.join(root, file)
        
        # Only process text files (PHP, JS, CSS, MD)
        if not filepath.endswith(('.php', '.js', '.css', '.md', '.txt')):
            continue

        with open(filepath, 'r', encoding='utf-8') as f:
            content = f.read()

        # Replace SBP_ with SBPP_
        new_content = re.sub(r'SBP_', 'SBPP_', content)
        # Replace sbp_ with sbpp_
        new_content = re.sub(r'sbp_', 'sbpp_', new_content)

        if content != new_content:
            with open(filepath, 'w', encoding='utf-8') as f:
                f.write(new_content)
            print(f"Updated {filepath}")

print("Prefixing complete.")
