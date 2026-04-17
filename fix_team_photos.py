#!/usr/bin/env python3
"""
Fix Team Member Photo - Use Professional Framed Photo
Replace Mohammad Taher Shaikh's photo with the new professional framed version
"""

import os
import re

# Files to process (Gulf country pages + aboutus.html)
html_files = [
    'bahrain.html',
    'Qatar.html',
    'Saudiarabia.html',
    'oman.html',
    'egypt.html',
    'unitedarab.html',
    'aboutus.html'
]

def fix_mohammad_taher_photos(filepath):
    """Replace Mohammad Taher Shaikh's photo with professional framed version (mohammad.jpg)"""
    try:
        with open(filepath, 'r', encoding='utf-8') as f:
            content = f.read()
        
        original_content = content
        replacements_made = 0
        
        # Pattern 1: Team card with Mohammad Taher Shaikh - replace any image with mohammad.jpg
        # Find sections with Mohammad Taher Shaikh and replace the image source
        
        # Replace gyan.jpg or hitansu.png with mohammad.jpg for Mohammad Taher Shaikh
        pattern1 = r'src="(gyan\.jpg|hitansu\.png)" alt="Mohammad Taher Shaikh"'
        replacement1 = 'src="mohammad.jpg" alt="Mohammad Taher Shaikh"'
        
        count1 = len(re.findall(pattern1, content))
        if count1 > 0:
            content = re.sub(pattern1, replacement1, content)
            replacements_made += count1
            print(f"  ✓ Replaced {count1}x team card image")
        
        # Pattern 2: Modal image with Mohammad Taher Shaikh name nearby
        # Look for any image followed by Mohammad Taher Shaikh in h4 tag
        modal_pattern = r'src="(gyan\.jpg|hitansu\.png)" class="img-fluid rounded mb-3"([^>]*)>\s*<h4[^>]*>Mohammad Taher Shaikh</h4>'
        modal_replacement = r'src="mohammad.jpg" class="img-fluid rounded mb-3"\2>\n                        <h4 class="text-white fw-bold mb-1" style="font-size: 1.1rem;">Mohammad Taher Shaikh</h4>'
        
        count2 = len(re.findall(modal_pattern, content))
        if count2 > 0:
            content = re.sub(modal_pattern, modal_replacement, content)
            replacements_made += count2
            print(f"  ✓ Replaced {count2}x modal image")
        
        # Write back if changes were made
        if content != original_content:
            with open(filepath, 'w', encoding='utf-8') as f:
                f.write(content)
            print(f"✅ {filepath}: {replacements_made} replacements made\n")
            return replacements_made
        else:
            print(f"⚪ {filepath}: No changes needed\n")
            return 0
            
    except Exception as e:
        print(f"❌ Error processing {filepath}: {e}\n")
        return 0

def main():
    print("=" * 60)
    print("TEAM MEMBER PHOTO UPDATE")
    print("Using Professional Framed Photo: mohammad.jpg")
    print("=" * 60)
    print()
    
    total_replacements = 0
    
    for html_file in html_files:
        if os.path.exists(html_file):
            print(f"Processing: {html_file}")
            replacements = fix_mohammad_taher_photos(html_file)
            total_replacements += replacements
        else:
            print(f"⚠️  File not found: {html_file}\n")
    
    print("=" * 60)
    print(f"COMPLETE! Total replacements: {total_replacements}")
    print("=" * 60)
    print()
    print("✅ Mohammad Taher Shaikh now uses: mohammad.jpg (professional framed photo)")
    print("✅ All Gulf country pages updated")

if __name__ == "__main__":
    main()
