#!/usr/bin/env python3
"""
Script to update ALL team member images across ALL HTML files to use the new images
"""
import os
import re
from pathlib import Path

def update_team_images(html_file):
    """Update team member image references to use new images"""
    with open(html_file, 'r', encoding='utf-8') as f:
        content = f.read()
    
    original_content = content
    changes = []
    
    # Mapping of old images to new images
    image_mappings = {
        # Gyan Prakash Srivastava
        r'gyan\.jpg': 'Gyan Prakash Srivastava new.jpg',
        
        # Priyanka Sondhi
        r'priyanka\.png': 'PRIYANKA new.jpg',
        
        # Mohammad Taher Shaikh
        r'hitansu\.png': 'Mohammad Taher Shaikh new.jpg',
        
        # Saniya Abbasi
        r'yishu\.png': 'SANIYA.jpg',
        
        # Himanshu
        r'(?<!nitin1\.)himanshu\.png': 'himanshu1.png',  # Don't match if already himanshu1
        
        # Nitin
        r'(?<!1\.)nitin\.png': 'nitin1.png',  # Don't match if already nitin1
        
        # Yishu (if there's a separate yishu that's not Saniya)
        # Note: Based on context, yishu.png seems to be used for Saniya, so we map it to SANIYA.jpg
        
        # Manoneet Dalal
        r'manoneet dalal new\.jpg': 'manoomet.png',
    }
    
    # Apply all mappings
    for old_pattern, new_image in image_mappings.items():
        if re.search(old_pattern, content, re.IGNORECASE):
            content = re.sub(old_pattern, new_image, content, flags=re.IGNORECASE)
            changes.append(f"{old_pattern} → {new_image}")
    
    # Check if any changes were made
    if content != original_content:
        with open(html_file, 'w', encoding='utf-8') as f:
            f.write(content)
        return True, changes
    return False, []

# Get all HTML files
html_files = list(Path('.').glob('*.html'))

print("=" * 70)
print("UPDATING ALL TEAM MEMBER IMAGES TO NEW VERSIONS")
print("=" * 70)

total_fixed = 0
for html_file in sorted(html_files):
    was_fixed, changes = update_team_images(html_file)
    if was_fixed:
        print(f"\n✅ Updated: {html_file.name}")
        for change in changes:
            print(f"   • {change}")
        total_fixed += 1

if total_fixed == 0:
    print("\n✅ No files needed updating - all images are already using new versions!")
else:
    print(f"\n{'=' * 70}")
    print(f"✅ Updated {total_fixed} file(s) with new team member images")

print("\n" + "=" * 70)
print("VERIFICATION - Checking for old image references")
print("=" * 70)

# Verify the fix - check for old images
old_images = [
    r'gyan\.jpg',
    r'priyanka\.png',
    r'hitansu\.png',
    r'(?<!1\.)yishu\.png',  # yishu.png but not yishu1.png
    r'(?<!1\.)nitin\.png',  # nitin.png but not nitin1.png
    r'manoneet dalal new\.jpg'
]

files_with_old_images = {}
for html_file in sorted(html_files):
    with open(html_file, 'r', encoding='utf-8') as f:
        content = f.read()
    
    found_old = []
    for old_pattern in old_images:
        if re.search(old_pattern, content, re.IGNORECASE):
            found_old.append(old_pattern)
    
    if found_old:
        files_with_old_images[html_file.name] = found_old

if files_with_old_images:
    print("\n⚠️  Still found old image references in:")
    for filename, patterns in files_with_old_images.items():
        print(f"\n   {filename}:")
        for pattern in patterns:
            print(f"      - {pattern}")
else:
    print("\n✅ All team member images are now using the NEW versions!")
    print("\n📋 New images being used:")
    print("   • Gyan Prakash Srivastava new.jpg")
    print("   • PRIYANKA new.jpg")
    print("   • Mohammad Taher Shaikh new.jpg")
    print("   • SANIYA.jpg")
    print("   • Mosttafa Shazzad Hasan.jpg")
    print("   • Udit Gupta.jpg")
    print("   • Nathaniel Owusu Ansah.jpg")
    print("   • George Mureithi.jpg")
    print("   • himanshu1.png")
    print("   • nitin1.png")
    print("   • yishu1.png")
    print("   • manoomet.png")

print("\n" + "=" * 70)
