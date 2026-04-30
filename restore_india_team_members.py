#!/usr/bin/env python3
"""
Restore correct team members to India.html page
India should have: Priyanka Sondhi and Gyan Prakash Srivastava
"""
import re
from pathlib import Path

# Team member HTML for India
PRIYANKA_CARD = '''            <div class="col-lg-3 col-md-6">
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
            </div>'''

GYAN_CARD = '''            <div class="col-lg-3 col-md-6">
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
            </div>'''

def restore_india_team_members():
    """Restore Priyanka and Gyan to India.html"""
    html_file = Path('India.html')
    
    if not html_file.exists():
        print(f"❌ {html_file} not found")
        return False
    
    with open(html_file, 'r', encoding='utf-8') as f:
        content = f.read()
    
    # Find the empty team section
    # Pattern: <div class="row g-4 justify-content-center"> followed by whitespace and </div>
    team_section_pattern = r'(<div class="row g-4 justify-content-center">\s*)(</div>)'
    
    match = re.search(team_section_pattern, content)
    
    if not match:
        print(f"❌ Could not find empty team section in {html_file}")
        return False
    
    # Insert both team member cards
    cards_html = "\n" + PRIYANKA_CARD + "\n" + GYAN_CARD + "\n        "
    new_content = content[:match.start()] + match.group(1) + cards_html + match.group(2) + content[match.end():]
    
    # Write the updated content
    with open(html_file, 'w', encoding='utf-8') as f:
        f.write(new_content)
    
    return True

print("=" * 80)
print("RESTORING INDIA TEAM MEMBERS")
print("=" * 80)

print("\n🎯 TEAM MEMBERS TO ADD TO INDIA.HTML:")
print("   1. Priyanka Sondhi [ACA] - Principal")
print("   2. Gyan Prakash Srivastava [MBA, LL.B.] - Leader - South Asia Practice")

print("\n" + "=" * 80)

if restore_india_team_members():
    print("\n✅ Successfully restored team members to India.html")
    print("\n📋 VERIFICATION:")
    print("   ✅ Priyanka Sondhi [ACA] - Principal")
    print("   ✅ Gyan Prakash Srivastava [MBA, LL.B.] - Leader - South Asia Practice")
else:
    print("\n❌ Failed to restore team members")

print("\n" + "=" * 80)
print("✅ COMPLETE")
print("=" * 80)
