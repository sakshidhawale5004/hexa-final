#!/usr/bin/env python3
"""
Script to fix team member image references in all HTML files
"""
import os
import re
from pathlib import Path

def fix_image_references(html_file):
    """Fix incorrect image references in HTML file"""
    with open(html_file, 'r', encoding='utf-8') as f:
        content = f.read()
    
    original_content = content
    
    # Fix: manoneet dalal new.jpg -> manoomet.png
    content = re.sub(
        r'manoneet dalal new\.jpg',
        'manoomet.png',
        content,
        flags=re.IGNORECASE
    )
    
    # Check if any changes were made
    if content != original_content:
        with open(html_file, 'w', encoding='utf-8') as f:
            f.write(content)
        return True
    return False

# Get all HTML files
html_files = list(Path('.').glob('*.html'))

print("=" * 60)
print("FIXING TEAM MEMBER IMAGE REFERENCES")
print("=" * 60)

fixed_count = 0
for html_file in sorted(html_files):
    if fix_image_references(html_file):
        print(f"✅ Fixed: {html_file.name}")
        fixed_count += 1

if fixed_count == 0:
    print("✅ No files needed fixing - all images are correct!")
else:
    print(f"\n✅ Fixed {fixed_count} file(s)")

print("\n" + "=" * 60)
print("VERIFICATION")
print("=" * 60)

# Verify the fix
errors = []
for html_file in sorted(html_files):
    with open(html_file, 'r', encoding='utf-8') as f:
        content = f.read()
    
    # Check for the incorrect reference
    if re.search(r'manoneet dalal new\.jpg', content, re.IGNORECASE):
        errors.append(html_file.name)

if errors:
    print("❌ Still found incorrect references in:")
    for err in errors:
        print(f"   - {err}")
else:
    print("✅ All team member images are now correctly referenced!")

print("=" * 60)
