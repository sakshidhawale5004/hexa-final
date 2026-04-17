#!/usr/bin/env python3
"""
Script to replace external image URLs with local file paths
"""

import os
import re

# Mapping of external URLs to local files
IMAGE_MAPPINGS = {
    # Team member images
    'https://hexatp.com/wp-content/uploads/2022/04/3-2-1.png': 'gyan.jpg',
    'https://hexatp.com/wp-content/uploads/2022/04/Nitin-Gupta.png': 'nitin.png',
    'https://hexatp.com/wp-content/uploads/2022/05/2-1-1-1024x1024.png': 'nitin1.png',
    'https://hexatp.com/wp-content/uploads/2022/04/Yishu-Agarwal.png': 'yishu.png',
    'https://hexatp.com/wp-content/uploads/2022/05/4-1-1-1024x1024.png': 'yishu1.png',
    'https://hexatp.com/wp-content/uploads/2022/05/3-1-1-1024x1024.png': 'himanshu1.png',
    'https://hexatp.com/wp-content/uploads/2022/05/6-1-1-1024x1024.png': 'hitansu.png',
    'https://hexatp.com/wp-content/uploads/2022/05/5-1-1-1024x1024.png': 'priyanka.png',
    'https://hexatp.com/wp-content/uploads/2025/03/Manoneet-Hexatp.webp': 'manoomet.png',
    'https://hexatp.com/wp-content/uploads/2022/04/7-1.png': 'gyan.jpg',  # Fallback
    'https://hexatp.com/wp-content/uploads/2022/05/1-1-1-1024x1024.png': 'nitin.png',  # Fallback
    'https://hexatp.com/wp-content/uploads/2025/03/Saniya-Abbasi-Hexatp.webp': 'priyanka.png',  # Fallback
}

def fix_images_in_file(filepath):
    """Replace external image URLs with local paths in a file"""
    try:
        with open(filepath, 'r', encoding='utf-8') as f:
            content = f.read()
        
        original_content = content
        replacements_made = 0
        
        # Replace each external URL with local path
        for external_url, local_file in IMAGE_MAPPINGS.items():
            if external_url in content:
                content = content.replace(external_url, local_file)
                count = original_content.count(external_url)
                replacements_made += count
                print(f"  ✓ Replaced {count}x: {os.path.basename(external_url)} → {local_file}")
        
        # Write back if changes were made
        if content != original_content:
            with open(filepath, 'w', encoding='utf-8') as f:
                f.write(content)
            return replacements_made
        
        return 0
    
    except Exception as e:
        print(f"  ✗ Error processing {filepath}: {e}")
        return 0

def main():
    """Main function to process all HTML files"""
    print("\n" + "="*60)
    print("  IMAGE URL REPLACEMENT SCRIPT")
    print("="*60 + "\n")
    
    # Get all HTML files
    html_files = [f for f in os.listdir('.') if f.endswith('.html')]
    
    if not html_files:
        print("✗ No HTML files found in current directory")
        return
    
    print(f"Found {len(html_files)} HTML files\n")
    
    total_replacements = 0
    files_modified = 0
    
    # Process each HTML file
    for html_file in sorted(html_files):
        print(f"Processing: {html_file}")
        replacements = fix_images_in_file(html_file)
        
        if replacements > 0:
            files_modified += 1
            total_replacements += replacements
        else:
            print(f"  - No changes needed")
        print()
    
    # Summary
    print("="*60)
    print("  SUMMARY")
    print("="*60)
    print(f"Files processed:  {len(html_files)}")
    print(f"Files modified:   {files_modified}")
    print(f"Total replacements: {total_replacements}")
    print("\n✓ Image URL replacement complete!\n")
    
    if files_modified > 0:
        print("Next steps:")
        print("1. Test locally: Open HTML files in browser")
        print("2. Commit changes: git add . && git commit -m 'Fixed image paths'")
        print("3. Push to GitHub: git push origin main")
        print("4. Redeploy to Vercel")

if __name__ == '__main__':
    main()
