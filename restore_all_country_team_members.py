#!/usr/bin/env python3
"""
Restore correct team members to all country pages based on original assignments
"""
import re
from pathlib import Path

# Define team member cards
TEAM_CARDS = {
    'Priyanka Sondhi': '''            <div class="col-lg-3 col-md-6">
                <div class="team-card">
                    <div class="team-img-wrapper">
                        <img src="PRIYANKA new.jpg" alt="Priyanka Sondhi">
                    </div>
                    <h5>Priyanka Sondhi [ACA]</h5>
                    <p class="role">Principal</p>
                    <a href="javascript:void(0)" class="learn-more-btn" data-bs-toggle="modal" data-bs-target="#modalPriyanka">
                        Learn More <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>''',
    
    'Gyan Prakash Srivastava': '''            <div class="col-lg-3 col-md-6">
                <div class="team-card">
                    <div class="team-img-wrapper">
                        <img src="Gyan Prakash Srivastava new.jpg" alt="Gyan Prakash Srivastava">
                    </div>
                    <h5>Gyan Prakash Srivastava [MBA, LL.B.]</h5>
                    <p class="role">Leader - South Asia Practice</p>
                    <a href="javascript:void(0)" class="learn-more-btn" data-bs-toggle="modal" data-bs-target="#modalGyan">
                        Learn More <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>''',
    
    'Mohammad Taher Shaikh': '''            <div class="col-lg-3 col-md-6">
                <div class="team-card">
                    <div class="team-img-wrapper">
                        <img src="Mohammad Taher Shaikh new.jpg" alt="Mohammad Taher Shaikh">
                    </div>
                    <h5>Mohammad Taher Shaikh [FCA, LL.B.]</h5>
                    <p class="role">Leader - Gulf Practice</p>
                    <a href="javascript:void(0)" class="learn-more-btn" data-bs-toggle="modal" data-bs-target="#modalTaher">
                        Learn More <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>''',
    
    'Saniya Abbasi': '''            <div class="col-lg-3 col-md-6">
                <div class="team-card">
                    <div class="team-img-wrapper">
                        <img src="SANIYA.jpg" alt="Saniya Abbasi">
                    </div>
                    <h5>Saniya Abbasi [MBA]</h5>
                    <p class="role">TP Specialist – Gulf Region</p>
                    <a href="javascript:void(0)" class="learn-more-btn" data-bs-toggle="modal" data-bs-target="#modalSaniya">
                        Learn More <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>''',
    
    'Udit Gupta': '''            <div class="col-lg-3 col-md-6">
                <div class="team-card">
                    <div class="team-img-wrapper">
                        <img src="udit.png" alt="Udit Gupta">
                    </div>
                    <h5>Udit Gupta [MIA, CA]</h5>
                    <p class="role">Principal - North America Practice</p>
                    <a href="javascript:void(0)" class="learn-more-btn" data-bs-toggle="modal" data-bs-target="#modalUdit">
                        Learn More <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>'''
}

# Define which team members belong to each country
COUNTRY_TEAMS = {
    'India.html': ['Priyanka Sondhi', 'Gyan Prakash Srivastava'],
    'unitedarab.html': ['Mohammad Taher Shaikh', 'Saniya Abbasi', 'Gyan Prakash Srivastava'],
    'Saudiarabia.html': ['Mohammad Taher Shaikh', 'Saniya Abbasi', 'Gyan Prakash Srivastava'],
    'Qatar.html': ['Mohammad Taher Shaikh', 'Saniya Abbasi', 'Gyan Prakash Srivastava'],
    'oman.html': ['Mohammad Taher Shaikh', 'Saniya Abbasi', 'Gyan Prakash Srivastava'],
    'bahrain.html': ['Mohammad Taher Shaikh', 'Saniya Abbasi', 'Gyan Prakash Srivastava'],
    'egypt.html': ['Mohammad Taher Shaikh', 'Saniya Abbasi', 'Gyan Prakash Srivastava'],
    'singapore.html': ['Gyan Prakash Srivastava'],
    'thailand.html': ['Gyan Prakash Srivastava', 'Priyanka Sondhi'],
    'malaysia.html': ['Gyan Prakash Srivastava'],
    'australia.html': ['Gyan Prakash Srivastava'],
    'indonesia.html': ['Gyan Prakash Srivastava', 'Udit Gupta'],
    'viethnam.html': ['Gyan Prakash Srivastava', 'Udit Gupta'],
    'canada.html': ['Gyan Prakash Srivastava', 'Udit Gupta'],
    'us.html': ['Gyan Prakash Srivastava', 'Udit Gupta']
}

def restore_team_members(html_file, team_members):
    """Restore team members to a country page"""
    with open(html_file, 'r', encoding='utf-8') as f:
        content = f.read()
    
    # Find the empty team section
    team_section_pattern = r'(<div class="row g-4 justify-content-center">\s*)(</div>)'
    
    match = re.search(team_section_pattern, content)
    
    if not match:
        return False, "Could not find empty team section"
    
    # Build the cards HTML
    cards_html = "\n"
    for member in team_members:
        if member in TEAM_CARDS:
            cards_html += TEAM_CARDS[member] + "\n"
    cards_html += "        "
    
    # Insert the cards
    new_content = content[:match.start()] + match.group(1) + cards_html + match.group(2) + content[match.end():]
    
    # Write the updated content
    with open(html_file, 'w', encoding='utf-8') as f:
        f.write(new_content)
    
    return True, f"Added {len(team_members)} team member(s)"

print("=" * 80)
print("RESTORING TEAM MEMBERS TO ALL COUNTRY PAGES")
print("=" * 80)

updated_count = 0
failed_count = 0

for country, team_members in COUNTRY_TEAMS.items():
    file_path = Path(country)
    
    if not file_path.exists():
        print(f"\n⚠️  {country} - File not found")
        continue
    
    print(f"\n📄 {country}")
    print(f"   Team members to add: {len(team_members)}")
    for member in team_members:
        print(f"      • {member}")
    
    success, message = restore_team_members(file_path, team_members)
    
    if success:
        print(f"   ✅ {message}")
        updated_count += 1
    else:
        print(f"   ❌ {message}")
        failed_count += 1

print("\n" + "=" * 80)
print("SUMMARY")
print("=" * 80)
print(f"\n✅ Successfully updated: {updated_count} file(s)")
print(f"❌ Failed: {failed_count} file(s)")
print("\n" + "=" * 80)
print("✅ COMPLETE")
print("=" * 80)
