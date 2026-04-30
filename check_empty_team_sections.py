#!/usr/bin/env python3
"""
Check all country pages for empty team sections
"""
import re
from pathlib import Path

# Country pages to check
country_pages = [
    'australia.html', 'bahrain.html', 'bangladesh.html', 'botswana.html',
    'canada.html', 'egypt.html', 'ghana.html', 'India.html', 'indonesia.html',
    'kenya.html', 'malaysia.html', 'oman.html', 'Qatar.html',
    'Saudiarabia.html', 'singapore.html', 'thailand.html',
    'unitedarab.html', 'us.html', 'viethnam.html'
]

def check_team_section(html_file):
    """Check if team section is empty"""
    with open(html_file, 'r', encoding='utf-8') as f:
        content = f.read()
    
    # Pattern: <div class="row g-4 justify-content-center"> followed by only whitespace and </div>
    empty_pattern = r'<div class="row g-4 justify-content-center">\s*</div>'
    
    # Pattern: <div class="row g-4 justify-content-center"> with actual content
    has_content_pattern = r'<div class="row g-4 justify-content-center">.*?<div class="col-'
    
    is_empty = bool(re.search(empty_pattern, content))
    has_content = bool(re.search(has_content_pattern, content, re.DOTALL))
    
    return is_empty, has_content

print("=" * 80)
print("CHECKING ALL COUNTRY PAGES FOR EMPTY TEAM SECTIONS")
print("=" * 80)

empty_pages = []
pages_with_content = []
missing_pages = []

for page in country_pages:
    file_path = Path(page)
    if not file_path.exists():
        missing_pages.append(page)
        continue
    
    is_empty, has_content = check_team_section(file_path)
    
    if is_empty:
        empty_pages.append(page)
        print(f"\n❌ {page} - EMPTY TEAM SECTION")
    elif has_content:
        pages_with_content.append(page)
        print(f"\n✅ {page} - Has team members")
    else:
        print(f"\n⚠️  {page} - Could not determine status")

print("\n" + "=" * 80)
print("SUMMARY")
print("=" * 80)

print(f"\n✅ Pages with team members: {len(pages_with_content)}")
for page in pages_with_content:
    print(f"   • {page}")

if empty_pages:
    print(f"\n❌ Pages with EMPTY team sections: {len(empty_pages)}")
    for page in empty_pages:
        print(f"   • {page}")
else:
    print(f"\n✅ No pages with empty team sections found!")

if missing_pages:
    print(f"\n⚠️  Missing pages: {len(missing_pages)}")
    for page in missing_pages:
        print(f"   • {page}")

print("\n" + "=" * 80)
