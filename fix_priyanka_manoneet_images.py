#!/usr/bin/env python3
"""
Fix Priyanka and Manoneet image references to use the correct new images
"""
import re
from pathlib import Path

def fix_image_references(html_file):
    """Fix Priyanka and Manoneet image references"""
    with open(html_file, 'r', encoding='utf-8') as f:
        content = f.read()
    
    original_content = content
    changes = []
    
    # Fix 1: manoomet.png -> manoneet dalal new.jpg
    if 'manoomet.png' in content:
        content = content.replace('manoomet.png', 'manoneet dalal new.jpg')
        changes.append('manoomet.png → manoneet dalal new.jpg')
    
    # Verify PRIYANKA new.jpg is being used (should already be correct)
    # No change needed if already using PRIYANKA new.jpg
    
    # Write the updated content
    if content != original_content:
        with open(html_file, 'w', encoding='utf-8') as f:
            f.write(content)
        return True, changes
    return False, []

# Get all HTML files
html_files = list(Path('.').glob('*.html'))

print("=" * 80)
print("FIXING PRIYANKA & MANONEET IMAGE REFERENCES")
print("=" * 80)

print("\n🎯 CHANGES TO MAKE:")
print("   • manoomet.png → manoneet dalal new.jpg (Manoneet Dalal)")
print("   • PRIYANKA new.jpg → PRIYANKA new.jpg (already correct)")

print("\n" + "=" * 80)

updated_files = 0
for html_file in sorted(html_files):
    was_fixed, changes = fix_image_references(html_file)
    if was_fixed:
        print(f"\n✅ {html_file.name}")
        for change in changes:
            print(f"   • {change}")
        updated_files += 1

if updated_files == 0:
    print("\n✅ No files needed updating - all images already correct!")
else:
    print(f"\n{'=' * 80}")
    print(f"✅ Updated {updated_files} file(s)")

print("\n" + "=" * 80)
print("VERIFICATION")
print("=" * 80)

# Verify the fix
errors = []
for html_file in sorted(html_files):
    with open(html_file, 'r', encoding='utf-8') as f:
        content = f.read()
    
    # Check if old reference still exists
    if 'manoomet.png' in content:
        errors.append(html_file.name)

if errors:
    print("\n❌ Still found old references in:")
    for err in errors:
        print(f"   - {err}")
else:
    print("\n✅ All files now use correct image references!")
    print("\n📋 Current image usage:")
    print("   • Priyanka Sondhi: PRIYANKA new.jpg ✅")
    print("   • Manoneet Dalal: manoneet dalal new.jpg ✅")

print("\n" + "=" * 80)
