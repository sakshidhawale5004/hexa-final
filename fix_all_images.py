#!/usr/bin/env python3
"""
Complete Image URL Fixer - Replaces ALL external image URLs with local files
"""

import os
import re

# Mapping of external URLs to local files
url_mappings = {
    # Team member images
    'https://hexatp.com/wp-content/uploads/2022/05/5-1-1.png': 'priyanka.png',
    'https://hexatp.com/wp-content/uploads/2022/05/5-1-1-1024x1024.png': 'priyanka.png',
    'https://hexatp.com/wp-content/uploads/2022/02/Shazzad-Hasan-980x980.png': 'yishu.png',
    'https://hexatp.com/wp-content/uploads/2022/05/Picture1.png': 'gyan.jpg',
    'https://hexatp.com/wp-content/uploads/2022/05/6-1-1024x1024.png': 'manoomet.png',
    
    # Other images
    'https://hexatp.com/wp-content/uploads/2021/09/Desktop-234-1.png': 'nitin.png',
    'https://hexatp.com/wp-content/uploads/2022/05/Tech-Face-1024x1024.png': 'himanshu1.png',
    'https://hexatp.com/wp-content/uploads/2025/10/vertical-cityscape-with-tall-skyscrapers-new-york-usa-1024x1024.webp': 'nitin.png',
    
    # Solution page country flags - using placeholder
    'https://hexatp.com/wp-content/uploads/2022/05/bahrain_flag-png-wave-xl.jpg': 'gyan.jpg',
    'https://hexatp.com/wp-content/uploads/2022/05/5.jpg': 'gyan.jpg',
    'https://hexatp.com/wp-content/uploads/2022/05/18.jpg': 'gyan.jpg',
    'https://hexatp.com/wp-content/uploads/2022/05/3-1.jpg': 'gyan.jpg',
    'https://hexatp.com/wp-content/uploads/2022/05/6.jpg': 'gyan.jpg',
    'https://hexatp.com/wp-content/uploads/2022/05/11.jpg': 'gyan.jpg',
    'https://hexatp.com/wp-content/uploads/2022/05/13.jpg': 'gyan.jpg',
    'https://hexatp.com/wp-content/uploads/2022/05/12.jpg': 'gyan.jpg',
    'https://hexatp.com/wp-content/uploads/2022/05/9.jpg': 'gyan.jpg',
    'https://hexatp.com/wp-content/uploads/2022/05/17.jpg': 'gyan.jpg',
    'https://hexatp.com/wp-content/uploads/2022/05/21.jpg': 'gyan.jpg',
    'https://hexatp.com/wp-content/uploads/2022/05/10.jpg': 'gyan.jpg',
    'https://hexatp.com/wp-content/uploads/2022/05/16.jpg': 'gyan.jpg',
    'https://hexatp.com/wp-content/uploads/2022/05/19.jpg': 'gyan.jpg',
    'https://hexatp.com/wp-content/uploads/2022/05/7-1.jpg': 'gyan.jpg',
    'https://hexatp.com/wp-content/uploads/2022/05/4.jpg': 'gyan.jpg',
    'https://hexatp.com/wp-content/uploads/2022/05/2-1.jpg': 'gyan.jpg',
    'https://hexatp.com/wp-content/uploads/2022/05/8-1.jpg': 'gyan.jpg',
    'https://hexatp.com/wp-content/uploads/2022/05/14.jpg': 'gyan.jpg',
    'https://hexatp.com/wp-content/uploads/2022/05/1.jpg': 'gyan.jpg',
    'https://hexatp.com/wp-content/uploads/2024/11/a5771af7-42aa-4461-9c1b-b445a78bd6db.webp': 'nitin.png',
}

# Files to process
html_files = [
    'index.html',
    'aboutus.html',
    'solution.html',
    'India.html',
    'kenya.html',
    'ghana.html',
    'bangladesh.html',
]

def fix_images_in_file(filepath):
    """Replace external image URLs with local files"""
    try:
        with open(filepath, 'r', encoding='utf-8') as f:
            content = f.read()
        
        original_content = content
        replacements_made = 0
        
        # Replace each URL
        for external_url, local_file in url_mappings.items():
            if external_url in content:
                count = content.count(external_url)
                content = content.replace(external_url, local_file)
                replacements_made += count
                print(f"  ✓ Replaced {count}x: {os.path.basename(external_url)} → {local_file}")
        
        # Write back if changes were made
        if content != original_content:
            with open(filepath, 'w', encoding='utf-8') as f:
                f.write(content)
            print(f"✅ {filepath}: {replacements_made} replacements made\n")
            return replacements_made
        else:
            print(f"⚪ {filepath}: No external URLs found\n")
            return 0
            
    except Exception as e:
        print(f"❌ Error processing {filepath}: {e}\n")
        return 0

def main():
    print("=" * 60)
    print("COMPLETE IMAGE URL FIXER")
    print("=" * 60)
    print()
    
    total_replacements = 0
    
    for html_file in html_files:
        if os.path.exists(html_file):
            print(f"Processing: {html_file}")
            replacements = fix_images_in_file(html_file)
            total_replacements += replacements
        else:
            print(f"⚠️  File not found: {html_file}\n")
    
    print("=" * 60)
    print(f"COMPLETE! Total replacements: {total_replacements}")
    print("=" * 60)

if __name__ == "__main__":
    main()
