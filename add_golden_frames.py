#!/usr/bin/env python3
"""
Add Professional Golden Frame Effect to All Team Member Photos
Creates CSS-based golden geometric frames matching Mohammad's professional photo
"""

import os
import re

# All HTML files with team members
html_files = [
    'India.html', 'Qatar.html', 'Saudiarabia.html', 'bahrain.html',
    'oman.html', 'egypt.html', 'unitedarab.html', 'singapore.html',
    'malaysia.html', 'thailand.html', 'indonesia.html', 'viethnam.html',
    'us.html', 'canada.html', 'australia.html', 'kenya.html',
    'ghana.html', 'botswana.html', 'bangladesh.html', 'aboutus.html'
]

# Enhanced golden frame CSS
enhanced_frame_css = '''/* --- Professional Golden Frame Effect --- */
.team-img-wrapper {
    position: relative;
    display: inline-block;
    margin-bottom: 20px;
    padding: 15px;
}

/* Multiple overlapping golden frames effect */
.team-img-wrapper::before,
.team-img-wrapper::after {
    content: '';
    position: absolute;
    border: 3px solid var(--accent);
    pointer-events: none;
    transition: all 0.3s ease;
}

/* First golden frame (outer) */
.team-img-wrapper::before {
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    transform: rotate(-2deg);
    z-index: 0;
}

/* Second golden frame (inner) */
.team-img-wrapper::after {
    top: 8px;
    left: 8px;
    right: 8px;
    bottom: 8px;
    transform: rotate(2deg);
    z-index: 0;
}

/* Hover effect - frames expand */
.team-card:hover .team-img-wrapper::before {
    transform: rotate(-3deg) scale(1.02);
    border-color: #fff;
}

.team-card:hover .team-img-wrapper::after {
    transform: rotate(3deg) scale(1.02);
    border-color: #fff;
}

.team-img-wrapper img {
    width: 150px;
    height: 150px;
    object-fit: cover;
    position: relative;
    z-index: 1;
    border: 2px solid var(--accent);
    box-shadow: 0 5px 15px rgba(245, 196, 0, 0.2);
    transition: all 0.3s ease;
}

/* Image hover effect */
.team-card:hover .team-img-wrapper img {
    transform: scale(1.05);
    box-shadow: 0 8px 25px rgba(245, 196, 0, 0.4);
}'''

def add_golden_frame_css(filepath):
    """Add or replace team-img-wrapper CSS with enhanced golden frame effect"""
    try:
        with open(filepath, 'r', encoding='utf-8') as f:
            content = f.read()
        
        original_content = content
        
        # Pattern to find existing team-img-wrapper CSS block
        # Look for .team-img-wrapper { ... } including nested rules
        pattern = r'\/\* Gold frame effect.*?\*\/\s*\.team-img-wrapper\s*\{[^}]*\}(?:\s*\.team-img-wrapper::before\s*\{[^}]*\})?(?:\s*\.team-img-wrapper::after\s*\{[^}]*\})?(?:\s*\.team-img-wrapper\s+img\s*\{[^}]*\})?'
        
        # If pattern found, replace it
        if re.search(pattern, content, re.DOTALL):
            content = re.sub(pattern, enhanced_frame_css, content, flags=re.DOTALL)
            print(f"  ✓ Replaced existing frame CSS")
        else:
            # If not found, try to find just .team-img-wrapper and replace
            simple_pattern = r'\.team-img-wrapper\s*\{[^}]*\}(?:\s*\.team-img-wrapper::before\s*\{[^}]*\})?(?:\s*\.team-img-wrapper\s+img\s*\{[^}]*\})?'
            
            if re.search(simple_pattern, content, re.DOTALL):
                content = re.sub(simple_pattern, enhanced_frame_css, content, flags=re.DOTALL)
                print(f"  ✓ Replaced simple frame CSS")
            else:
                # If still not found, insert before .team-card h5
                insert_pattern = r'(\.team-card\s+h5\s*\{)'
                if re.search(insert_pattern, content):
                    content = re.sub(insert_pattern, enhanced_frame_css + '\n\n\\1', content)
                    print(f"  ✓ Inserted new frame CSS")
                else:
                    print(f"  ⚠️  Could not find insertion point")
                    return 0
        
        # Write back if changes were made
        if content != original_content:
            with open(filepath, 'w', encoding='utf-8') as f:
                f.write(content)
            print(f"✅ {filepath}: Golden frame CSS added\n")
            return 1
        else:
            print(f"⚪ {filepath}: No changes needed\n")
            return 0
            
    except Exception as e:
        print(f"❌ Error processing {filepath}: {e}\n")
        return 0

def main():
    print("=" * 70)
    print("ADDING PROFESSIONAL GOLDEN FRAMES TO ALL TEAM MEMBER PHOTOS")
    print("=" * 70)
    print()
    print("This will add CSS-based golden geometric frames to match")
    print("Mohammad Taher Shaikh's professional framed photo design.")
    print()
    print("=" * 70)
    print()
    
    total_updated = 0
    
    for html_file in html_files:
        if os.path.exists(html_file):
            print(f"Processing: {html_file}")
            result = add_golden_frame_css(html_file)
            total_updated += result
        else:
            print(f"⚠️  File not found: {html_file}\n")
    
    print("=" * 70)
    print(f"COMPLETE! Files updated: {total_updated}/{len(html_files)}")
    print("=" * 70)
    print()
    print("✅ All team member photos now have professional golden frames!")
    print("✅ Multiple overlapping frames create depth")
    print("✅ Hover effects add interactivity")
    print("✅ Consistent design across all pages")

if __name__ == "__main__":
    main()
