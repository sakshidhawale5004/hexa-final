#!/usr/bin/env python3
"""
Remove the 4 team members (Mosttafa, Manoneet, Nathaniel, George) that were added unnecessarily
Keep only the original team members on each page
"""
import re
from pathlib import Path

def remove_team_member_card_and_modal(content, member_name, modal_id):
    """Remove both the team card and modal for a specific member"""
    
    # Remove the team card
    # Pattern: <div class="col-lg-3 col-md-6">...<img src="...">...member_name...</div>
    card_pattern = rf'<div class="col-lg-3 col-md-6">\s*<div class="team-card">.*?{re.escape(member_name)}.*?</div>\s*</div>\s*</div>'
    content = re.sub(card_pattern, '', content, flags=re.DOTALL)
    
    # Remove the modal
    modal_pattern = rf'<div class="modal fade" id="{modal_id}".*?</div>\s*</div>\s*</div>\s*</div>'
    content = re.sub(modal_pattern, '', content, flags=re.DOTALL)
    
    return content

def clean_country_page(html_file):
    """Remove the 4 unnecessary team members from country pages"""
    with open(html_file, 'r', encoding='utf-8') as f:
        content = f.read()
    
    original_content = content
    
    # Remove these 4 team members
    members_to_remove = [
        ('Mosttafa Shazzad Hasan', 'modalMosttafa'),
        ('Manoneet Dalal', 'modalManoneet'),
        ('Nathaniel Owusu Ansah', 'modalNathaniel'),
        ('George Mureithi', 'modalGeorge')
    ]
    
    removed = []
    for member_name, modal_id in members_to_remove:
        if member_name in content:
            content = remove_team_member_card_and_modal(content, member_name, modal_id)
            removed.append(member_name)
    
    # Write back if changes were made
    if content != original_content:
        with open(html_file, 'w', encoding='utf-8') as f:
            f.write(content)
        return True, removed
    return False, []

# List of country pages to clean
country_pages = [
    'India.html',
    'australia.html',
    'bahrain.html',
    'canada.html',
    'egypt.html',
    'indonesia.html',
    'malaysia.html',
    'oman.html',
    'Qatar.html',
    'Saudiarabia.html',
    'singapore.html',
    'thailand.html',
    'unitedarab.html',
    'us.html',
    'viethnam.html'
]

print("=" * 80)
print("REMOVING UNNECESSARY TEAM MEMBERS")
print("=" * 80)

print("\n🎯 REMOVING THESE 4 MEMBERS:")
print("   • Mosttafa Shazzad Hasan")
print("   • Manoneet Dalal")
print("   • Nathaniel Owusu Ansah")
print("   • George Mureithi")

print("\n" + "=" * 80)

cleaned_files = 0
for page in country_pages:
    file_path = Path(page)
    if file_path.exists():
        was_cleaned, removed = clean_country_page(file_path)
        if was_cleaned:
            print(f"\n✅ {page}")
            print(f"   Removed {len(removed)} member(s):")
            for member in removed:
                print(f"      - {member}")
            cleaned_files += 1

if cleaned_files == 0:
    print("\n✅ No files needed cleaning")
else:
    print(f"\n{'=' * 80}")
    print(f"✅ Cleaned {cleaned_files} file(s)")

print("\n" + "=" * 80)
print("VERIFICATION")
print("=" * 80)

# Verify removal
print("\n📊 Checking India.html:")
india_file = Path('India.html')
if india_file.exists():
    with open(india_file, 'r', encoding='utf-8') as f:
        content = f.read()
    
    members_check = {
        'Priyanka Sondhi': '✅ Should be present',
        'Gyan Prakash Srivastava': '✅ Should be present',
        'Mosttafa Shazzad Hasan': '❌ Should be removed',
        'Manoneet Dalal': '❌ Should be removed',
        'Nathaniel Owusu Ansah': '❌ Should be removed',
        'George Mureithi': '❌ Should be removed'
    }
    
    for member, status in members_check.items():
        if member in content:
            if '✅' in status:
                print(f"   ✅ {member}: Present (correct)")
            else:
                print(f"   ❌ {member}: Still present (ERROR)")
        else:
            if '❌' in status:
                print(f"   ✅ {member}: Removed (correct)")
            else:
                print(f"   ❌ {member}: Missing (ERROR)")

print("\n" + "=" * 80)
