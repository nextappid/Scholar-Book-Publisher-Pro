import os
import re

directory = '.'

for root, dirs, files in os.walk(directory):
    if '.git' in root:
        continue
        
    for filename in files:
        if 'class-sbp-' in filename:
            old_path = os.path.join(root, filename)
            new_filename = filename.replace('class-sbp-', 'class-sbpp-')
            new_path = os.path.join(root, new_filename)
            os.rename(old_path, new_path)
            print(f"Renamed {old_path} to {new_path}")
            
print("File renaming complete.")
