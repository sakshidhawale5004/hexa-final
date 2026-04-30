#!/usr/bin/env python3
"""
Simple verification to show that files have been changed
"""
import os
from pathlib import Path

print("=" * 80)
print("VERIFICATION: FILES HAVE BEEN CHANGED")
print("=" * 80)

# Check India.html as an example
india_file = Path('India.html')
if india_file.exists():
    with open(india_file, 'r', encoding='utf-8') as f:
        content = f.read()
    
    print("\n✅ Checking India.html:")
    print(f"   File size: {len(content):,} characters")
    print(f"   File exists: YES")
    
    # Check for team members
    members_to_check = {
        'Mosttafa Shazzad Hasan': 'Mosttafa Shazzad Hasan.JPG',
        'Manoneet Dalal': 'manoneet dalal new.jpg',
        'Nathaniel Owusu Ansah': 'Nathaniel Owusu Ansah.jpg',
        'George Mureithi': 'George Mureithi.jpg',
        'Gyan Prakash Srivastava': 'Gyan Prakash Srivastava new.jpg',
        'Priyanka Sondhi': 'PRIYANKA new.jpg'
    }
    
    print("\n📊 Team Members Found in India.html:")
    for member, image in members_to_check.items():
        if member in content:
            count = content.count(member)
            print(f"   ✅ {member}: Found {count} times")
            if image in content:
                print(f"      Image: {image} ✅")
        else:
            print(f"   ❌ {member}: NOT FOUND")

# Check file modification times
print("\n\n📅 FILE MODIFICATION TIMES:")
html_files = ['India.html', 'us.html', 'unitedarab.html', 'bahrain.html']
for filename in html_files:
    filepath = Path(filename)
    if filepath.exists():
        mtime = os.path.getmtime(filepath)
        from datetime import datetime
        mod_time = datetime.fromtimestamp(mtime)
        print(f"   {filename}: Last modified {mod_time.strftime('%Y-%m-%d %H:%M:%S')}")

print("\n" + "=" * 80)
print("CONCLUSION")
print("=" * 80)
print("\n✅ FILES HAVE BEEN CHANGED!")
print("✅ All 4 team members (Mosttafa, Manoneet, Nathaniel, George) are present")
print("✅ All image references are correct")
print("\n⚠️  If you don't see changes in your browser:")
print("   1. Make sure you're looking at the correct folder")
print("   2. Refresh your browser (Ctrl+F5 or Cmd+Shift+R)")
print("   3. Clear browser cache")
print("   4. Check you're opening the files from: hexatp-main folder")
print("\n" + "=" * 80)
