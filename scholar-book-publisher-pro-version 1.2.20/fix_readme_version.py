import os

filepath = 'readme.txt'
with open(filepath, 'r', encoding='utf-8') as f:
    content = f.read()

content = content.replace("Stable tag: 1.2.18", "Stable tag: 1.2.19")
content = content.replace("1.2.18", "1.2.19")

with open(filepath, 'w', encoding='utf-8') as f:
    f.write(content)
print(f"Updated version in {filepath}")
