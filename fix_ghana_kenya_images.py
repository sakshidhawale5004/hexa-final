#!/usr/bin/env python3
"""
Fix Nathaniel and George image references in ghana.html and kenya.html
Change from external URLs to local image files
"""
import re
from pathlib import Path

def fix_ghana_kenya_images():
    """Fix image references in ghana.html and kenya.html"""
    print("=" * 80)
    print("FIXING GHANA & KENYA IMAGE REFERENCES")
    print("=" * 80)
    
    fixes = [
        {
            'file': 'ghana.html',
            'old_url': 'https://hexatp.com/wp-content/uploads/2022/05/Picture1.png',
            'new_file': 'Nathaniel Owusu Ansah.jpg',
            'member': 'Nathaniel Owusu Ansah'
        },
        {
            'file': 'kenya.html',
            'old_url': 'https://hexatp.com/wp-content/uploads/2022/05/6-1-1024x1024.png',
            'new_file': 'George Mureithi.jpg',
            'member': 'George Mureithi'
        }
    ]
    
    fixed_count = 0
    
    for fix in fixes:
        file_path = Path(fix['file'])
        
        if not file_path.exists():
            print(f"\n❌ {fix['file']} not found")
            continue
        
        with open(file_path, 'r', encoding='utf-8') as f:
            content = f.read()
        
        if fix['old_url'] in content:
            new_content = content.replace(fix['old_url'], fix['new_file'])
            
            with open(file_path, 'w', encoding='utf-8') as f:
                f.write(new_content)
            
            count = content.count(fix['old_url'])
            
            print(f"\n✅ {fix['file']} - {fix['member']}")
            print(f"   Updated {count} image reference(s)")
            print(f"   Old: {fix['old_url']}")
            print(f"   New: {fix['new_file']}")
            fixed_count += 1
        else:
            print(f"\n✅ {fix['file']} - Already using correct image")
    
    print("\n" + "=" * 80)
    print(f"✅ Fixed {fixed_count} file(s)")
    print("=" * 80)

if __name__ == '__main__':
    fix_ghana_kenya_images()
