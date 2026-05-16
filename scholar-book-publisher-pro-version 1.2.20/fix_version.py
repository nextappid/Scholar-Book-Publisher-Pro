import os

filepath = 'scholar-book-publisher.php'
with open(filepath, 'r', encoding='utf-8') as f:
    content = f.read()

content = content.replace("Version: 1.2.18", "Version: 1.2.19")
content = content.replace("define('SBPP_VERSION', '1.2.18');", "define('SBPP_VERSION', '1.2.19');")

with open(filepath, 'w', encoding='utf-8') as f:
    f.write(content)
print(f"Updated version in {filepath}")
