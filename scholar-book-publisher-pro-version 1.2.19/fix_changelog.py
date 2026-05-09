import os
import datetime

filepath = 'CHANGELOG.md'
with open(filepath, 'r', encoding='utf-8') as f:
    content = f.read()

date_str = datetime.datetime.now().strftime("%Y-%m-%d")

new_changelog = f"""# Changelog

## [1.2.19] - {date_str}
### Fixed
- Fixed fatal error related to missing function exists checks for plugin activation/deactivation hooks.
- Fixed critical error in admin notices by wrapping hook callbacks in `current_user_can('manage_options')` checks.
- Migrated plugin prefix from `sbp_` to `sbpp_` across all functions, constants, and classes to prevent namespace collisions.
- Updated version numbers to 1.2.19 in main plugin file and readme.

"""

content = content.replace("# Changelog", new_changelog)

with open(filepath, 'w', encoding='utf-8') as f:
    f.write(content)
print(f"Updated {filepath}")
