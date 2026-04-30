#!/usr/bin/env python3
"""
Analyze which team members are in which country pages
"""
import re
from pathlib import Path

def get_team_members_in_file(html_file):
    """Extract team member names from HTML file"""
    with open(html_file, 'r', encoding='utf-8') as f:
        content = f.read()
    
    # Look for team member names in the HTML
    team_members = []
    
    # Search for specific team members
    members_to_check = {
        'Mosttafa Shazzad Hasan': 'Mosttafa Shazzad Hasan.jpg',
        'Manoneet Dalal': 'manoomet.png',
        'Nathaniel Owusu Ansah': 'Nathaniel Owusu Ansah.jpg',
        'George Mureithi': 'George Mureithi.jpg',
        'Gyan Prakash Srivastava': 'Gyan Prakash Srivastava new.jpg',
        'Mohammad Taher Shaikh': 'Mohammad Taher Shaikh new.jpg',
        'Saniya': 'SANIYA.jpg',
        'Priyanka': 'PRIYANKA new.jpg',
        'Udit Gupta': 'Udit Gupta.jpg',
        'Himanshu': 'himanshu1.png',
        'Nitin': 'nitin1.png',
        'Yishu': 'yishu1.png'
    }
    
    for member_name, image_file in members_to_check.items():
        # Check if the image file is referenced
        if image_file in content:
            team_members.append(member_name)
    
    return team_members

# Get all country HTML files (exclude aboutus.html, index.html, contact.html, solution.html, country.html)
country_pages = [
    'australia.html', 'bahrain.html', 'bangladesh.html', 'botswana.html',
    'canada.html', 'egypt.html', 'ghana.html', 'India.html', 'indonesia.html',
    'kenya.html', 'malaysia.html', 'oman.html', 'Qatar.html', 'Saudiarabia.html',
    'singapore.html', 'thailand.html', 'unitedarab.html', 'us.html', 'viethnam.html'
]

print("=" * 80)
print("TEAM MEMBER DISTRIBUTION ACROSS COUNTRY PAGES")
print("=" * 80)

# Target team members to add
target_members = ['Mosttafa Shazzad Hasan', 'Manoneet Dalal', 'Nathaniel Owusu Ansah', 'George Mureithi']

print(f"\n🎯 TARGET TEAM MEMBERS TO ADD:")
for member in target_members:
    print(f"   • {member}")

print("\n" + "=" * 80)
print("CURRENT DISTRIBUTION")
print("=" * 80)

pages_with_teams = {}
pages_missing_targets = {}

for page in country_pages:
    file_path = Path(page)
    if file_path.exists():
        members = get_team_members_in_file(file_path)
        if members:
            pages_with_teams[page] = members
            
            # Check which target members are missing
            missing = [m for m in target_members if m not in members]
            if missing:
                pages_missing_targets[page] = missing

print("\n📄 PAGES WITH TEAM SECTIONS:")
for page, members in sorted(pages_with_teams.items()):
    print(f"\n{page}:")
    for member in members:
        icon = "✅" if member in target_members else "  "
        print(f"  {icon} {member}")

print("\n\n" + "=" * 80)
print("PAGES MISSING TARGET TEAM MEMBERS")
print("=" * 80)

if pages_missing_targets:
    for page, missing in sorted(pages_missing_targets.items()):
        print(f"\n{page} - Missing {len(missing)} member(s):")
        for member in missing:
            print(f"  ❌ {member}")
else:
    print("\n✅ All pages have all target team members!")

# Summary
print("\n\n" + "=" * 80)
print("SUMMARY")
print("=" * 80)

print(f"\n📊 Total country pages: {len(country_pages)}")
print(f"📊 Pages with team sections: {len(pages_with_teams)}")
print(f"📊 Pages missing target members: {len(pages_missing_targets)}")

# Count how many pages each target member is in
print("\n📊 TARGET MEMBER COVERAGE:")
for member in target_members:
    count = sum(1 for members in pages_with_teams.values() if member in members)
    total = len(pages_with_teams)
    print(f"   • {member}: {count}/{total} pages ({count*100//total if total > 0 else 0}%)")

print("\n" + "=" * 80)
