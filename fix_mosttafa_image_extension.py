#!/usr/bin/env python3
"""
Fix Mosttafa Shazzad Hasan image extension from .jpg to .JPG
"""
import re
from pathlib import Path

def fix_mosttafa_image(html_file):
    """Fix Mosttafa image extension"""
    with open(html_file, 'r', encoding='utf-8') as f:
        content = f.read()
    
    original_content = content
    
    # Fix: Mosttafa Shazzad Hasan.jpg -> Mosttafa Shazzad Hasan.JPG
    content = content.replace('Mosttafa Shazzad Hasan.jpg', 'Mosttafa Shazzad Hasan.JPG')
    
    # Write the updated content
    if content != original_content:
        with open(html_file, 'w', encoding='utf-8') as f:
            f.write(content)
        return True
    return False

# Get all HTML files
html_files = list(Path('.').glob('*.html'))

print("=" * 80)
print("FIXING MOSTTAFA SHAZZAD HASAN IMAGE EXTENSION")
print("=" * 80)

print("\n🎯 CHANGE TO MAKE:")
print("   • Mosttafa Shazzad Hasan.jpg → Mosttafa Shazzad Hasan.JPG")
print("   • (lowercase .jpg → uppercase .JPG)")

print("\n" + "=" * 80)

updated_files = 0
for html_file in sorted(html_files):
    if fix_mosttafa_image(html_file):
        print(f"✅ {html_file.name}")
        updated_files += 1

if updated_files == 0:
    print("\n✅ No files needed updating - all already use .JPG extension!")
else:
    print(f"\n{'=' * 80}")
    print(f"✅ Updated {updated_files} file(s)")

print("\n" + "=" * 80)
print("VERIFICATION")
print("=" * 80)

# Verify the fix
files_with_lowercase = []
files_with_uppercase = []

for html_file in sorted(html_files):
    with open(html_file, 'r', encoding='utf-8') as f:
        content = f.read()
    
    if 'Mosttafa Shazzad Hasan.jpg' in content:
        files_with_lowercase.append(html_file.name)
    if 'Mosttafa Shazzad Hasan.JPG' in content:
        files_with_uppercase.append(html_file.name)

if files_with_lowercase:
    print("\n❌ Still found lowercase .jpg in:")
    for file in files_with_lowercase:
        print(f"   - {file}")
else:
    print("\n✅ No lowercase .jpg references found!")

if files_with_uppercase:
    print(f"\n✅ Found uppercase .JPG in {len(files_with_uppercase)} file(s)")
    print("\n📋 Files using Mosttafa Shazzad Hasan.JPG:")
    for file in files_with_uppercase:
        print(f"   ✅ {file}")
else:
    print("\n⚠️  No files reference Mosttafa Shazzad Hasan")

print("\n" + "=" * 80)
print("SUMMARY")
print("=" * 80)
print("\n✅ All files now use: Mosttafa Shazzad Hasan.JPG")
print("   (uppercase .JPG extension)")
print("\n" + "=" * 80)
