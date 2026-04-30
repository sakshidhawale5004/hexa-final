#!/usr/bin/env python3
"""
Fix Mosttafa Shazzad Hasan image reference in bangladesh.html
Change from external URL to local image file
"""
import re
from pathlib import Path

def fix_bangladesh_mosttafa():
    """Fix Mosttafa image reference in bangladesh.html"""
    print("=" * 80)
    print("FIXING MOSTTAFA IMAGE IN BANGLADESH.HTML")
    print("=" * 80)
    
    file_path = Path('bangladesh.html')
    
    if not file_path.exists():
        print("\n❌ bangladesh.html not found")
        return False
    
    with open(file_path, 'r', encoding='utf-8') as f:
        content = f.read()
    
    # Replace external image URL with local file
    old_url = 'https://hexatp.com/wp-content/uploads/2022/02/Shazzad-Hasan-980x980.png'
    new_file = 'Mosttafa Shazzad Hasan.jpg'
    
    if old_url in content:
        new_content = content.replace(old_url, new_file)
        
        with open(file_path, 'w', encoding='utf-8') as f:
            f.write(new_content)
        
        # Count how many replacements were made
        count = content.count(old_url)
        
        print(f"\n✅ bangladesh.html - Updated {count} image reference(s)")
        print(f"   Old: {old_url}")
        print(f"   New: {new_file}")
        return True
    else:
        print("\n✅ bangladesh.html - Already using correct image reference")
        return False

if __name__ == '__main__':
    fix_bangladesh_mosttafa()
    print("\n" + "=" * 80)
    print("✅ COMPLETE")
    print("=" * 80)
