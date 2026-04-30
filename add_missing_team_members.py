#!/usr/bin/env python3
"""
Add missing team members (Mosttafa, Manoneet, Nathaniel, George) to country pages
"""
import re
from pathlib import Path

# Team member HTML templates
TEAM_MEMBERS = {
    'Mosttafa Shazzad Hasan': {
        'card': '''            <div class="col-lg-3 col-md-6">
                <div class="team-card">
                    <div class="team-img-wrapper">
                        <img src="Mosttafa Shazzad Hasan.jpg" alt="Mosttafa Shazzad Hasan">
                    </div>
                    <h5>Mosttafa Shazzad Hasan [MBA, LL.B.]</h5>
                    <p class="role">TP Specialist – Asia Pacific</p>
                    <a href="javascript:void(0)" class="learn-more-btn" data-bs-toggle="modal" data-bs-target="#modalMosttafa">
                        Learn More <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>''',
        'modal': '''<div class="modal fade" id="modalMosttafa" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="background: var(--bg-dark); border: 1px solid var(--accent); border-radius: 20px; overflow: hidden;">
            <div class="modal-header border-0 pb-0">
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div class="row g-0">
                    <div class="col-md-4 text-center p-4" style="background: rgba(245, 196, 0, 0.05); border-right: 1px solid var(--glass-border);">
                        <img src="Mosttafa Shazzad Hasan.jpg" class="img-fluid rounded mb-3" style="border: 2px solid var(--accent); width: 180px;">
                        <h4 class="text-white fw-bold mb-1" style="font-size: 1.1rem;">Mosttafa Shazzad Hasan</h4>
                        <p style="color: var(--accent); font-size: 0.85rem;">TP Specialist – Asia Pacific</p>
                    </div>
                    <div class="col-md-8 p-4 p-md-5">
                        <h5 class="text-white fw-bold mb-3"><i class="bi bi-person-lines-fill me-2 text-warning"></i>Professional Bio</h5>
                        <p style="color: var(--text-slate); font-size: 0.95rem; line-height: 1.8;">
                            Mosttafa is a seasoned transfer pricing professional with extensive experience in the Asia Pacific region. He specializes in helping multinational enterprises navigate complex transfer pricing regulations and documentation requirements.
                        </p>
                        <h6 class="text-white mt-4"><i class="bi bi-star-fill me-2 text-warning"></i>Key Specializations:</h6>
                        <ul class="row list-unstyled" style="color: var(--text-slate); font-size: 0.85rem;">
                            <li class="col-6 mb-2"><i class="bi bi-check2 text-warning me-2"></i>Asia Pacific TP</li>
                            <li class="col-6 mb-2"><i class="bi bi-check2 text-warning me-2"></i>Documentation</li>
                            <li class="col-6 mb-2"><i class="bi bi-check2 text-warning me-2"></i>Benchmarking</li>
                            <li class="col-6 mb-2"><i class="bi bi-check2 text-warning me-2"></i>Compliance</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
'''
    },
    'Manoneet Dalal': {
        'card': '''            <div class="col-lg-3 col-md-6">
                <div class="team-card">
                    <div class="team-img-wrapper">
                        <img src="manoomet.png" alt="Manoneet Dalal">
                    </div>
                    <h5>Manoneet Dalal [LL.M.]</h5>
                    <p class="role">Leader - Global TP</p>
                    <a href="javascript:void(0)" class="learn-more-btn" data-bs-toggle="modal" data-bs-target="#modalManoneet">
                        Learn More <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>''',
        'modal': '''<div class="modal fade" id="modalManoneet" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="background: var(--bg-dark); border: 1px solid var(--accent); border-radius: 20px; overflow: hidden;">
            <div class="modal-header border-0 pb-0">
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div class="row g-0">
                    <div class="col-md-4 text-center p-4" style="background: rgba(245, 196, 0, 0.05); border-right: 1px solid var(--glass-border);">
                        <img src="manoomet.png" class="img-fluid rounded mb-3" style="border: 2px solid var(--accent); width: 180px;">
                        <h4 class="text-white fw-bold mb-1" style="font-size: 1.1rem;">Manoneet Dalal</h4>
                        <p style="color: var(--accent); font-size: 0.85rem;">Leader - Global TP</p>
                    </div>
                    <div class="col-md-8 p-4 p-md-5">
                        <h5 class="text-white fw-bold mb-3"><i class="bi bi-person-lines-fill me-2 text-warning"></i>Global Expertise</h5>
                        <p style="color: var(--text-slate); font-size: 0.95rem; line-height: 1.8;">
                            Manoneet brings a wealth of knowledge in international tax law and global transfer pricing strategies. He oversees complex benchmarking and documentation for large MNEs operating globally.
                        </p>
                        <h6 class="text-white mt-4"><i class="bi bi-star-fill me-2 text-warning"></i>Key Specializations:</h6>
                        <ul class="row list-unstyled" style="color: var(--text-slate); font-size: 0.85rem;">
                            <li class="col-6 mb-2"><i class="bi bi-check2 text-warning me-2"></i>Global TP Strategy</li>
                            <li class="col-6 mb-2"><i class="bi bi-check2 text-warning me-2"></i>International Tax Law</li>
                            <li class="col-6 mb-2"><i class="bi bi-check2 text-warning me-2"></i>MNE Advisory</li>
                            <li class="col-6 mb-2"><i class="bi bi-check2 text-warning me-2"></i>OECD Guidelines</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
'''
    },
    'Nathaniel Owusu Ansah': {
        'card': '''            <div class="col-lg-3 col-md-6">
                <div class="team-card">
                    <div class="team-img-wrapper">
                        <img src="Nathaniel Owusu Ansah.jpg" alt="Nathaniel Owusu Ansah">
                    </div>
                    <h5>Nathaniel Owusu Ansah [MBA, ACCA]</h5>
                    <p class="role">TP Specialist – Africa</p>
                    <a href="javascript:void(0)" class="learn-more-btn" data-bs-toggle="modal" data-bs-target="#modalNathaniel">
                        Learn More <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>''',
        'modal': '''<div class="modal fade" id="modalNathaniel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="background: var(--bg-dark); border: 1px solid var(--accent); border-radius: 20px; overflow: hidden;">
            <div class="modal-header border-0 pb-0">
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div class="row g-0">
                    <div class="col-md-4 text-center p-4" style="background: rgba(245, 196, 0, 0.05); border-right: 1px solid var(--glass-border);">
                        <img src="Nathaniel Owusu Ansah.jpg" class="img-fluid rounded mb-3" style="border: 2px solid var(--accent); width: 180px;">
                        <h4 class="text-white fw-bold mb-1" style="font-size: 1.1rem;">Nathaniel Owusu Ansah</h4>
                        <p style="color: var(--accent); font-size: 0.85rem;">TP Specialist – Africa</p>
                    </div>
                    <div class="col-md-8 p-4 p-md-5">
                        <h5 class="text-white fw-bold mb-3"><i class="bi bi-person-lines-fill me-2 text-warning"></i>Professional Bio</h5>
                        <p style="color: var(--text-slate); font-size: 0.95rem; line-height: 1.8;">
                            Nathaniel is a transfer pricing expert with deep knowledge of African markets and tax regulations. He helps companies navigate the unique challenges of transfer pricing compliance across the African continent.
                        </p>
                        <h6 class="text-white mt-4"><i class="bi bi-star-fill me-2 text-warning"></i>Key Specializations:</h6>
                        <ul class="row list-unstyled" style="color: var(--text-slate); font-size: 0.85rem;">
                            <li class="col-6 mb-2"><i class="bi bi-check2 text-warning me-2"></i>African TP</li>
                            <li class="col-6 mb-2"><i class="bi bi-check2 text-warning me-2"></i>Regional Compliance</li>
                            <li class="col-6 mb-2"><i class="bi bi-check2 text-warning me-2"></i>Documentation</li>
                            <li class="col-6 mb-2"><i class="bi bi-check2 text-warning me-2"></i>Advisory Services</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
'''
    },
    'George Mureithi': {
        'card': '''            <div class="col-lg-3 col-md-6">
                <div class="team-card">
                    <div class="team-img-wrapper">
                        <img src="George Mureithi.jpg" alt="George Mureithi">
                    </div>
                    <h5>George Mureithi [CPA]</h5>
                    <p class="role">TP Specialist – East Africa</p>
                    <a href="javascript:void(0)" class="learn-more-btn" data-bs-toggle="modal" data-bs-target="#modalGeorge">
                        Learn More <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>''',
        'modal': '''<div class="modal fade" id="modalGeorge" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="background: var(--bg-dark); border: 1px solid var(--accent); border-radius: 20px; overflow: hidden;">
            <div class="modal-header border-0 pb-0">
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div class="row g-0">
                    <div class="col-md-4 text-center p-4" style="background: rgba(245, 196, 0, 0.05); border-right: 1px solid var(--glass-border);">
                        <img src="George Mureithi.jpg" class="img-fluid rounded mb-3" style="border: 2px solid var(--accent); width: 180px;">
                        <h4 class="text-white fw-bold mb-1" style="font-size: 1.1rem;">George Mureithi</h4>
                        <p style="color: var(--accent); font-size: 0.85rem;">TP Specialist – East Africa</p>
                    </div>
                    <div class="col-md-8 p-4 p-md-5">
                        <h5 class="text-white fw-bold mb-3"><i class="bi bi-person-lines-fill me-2 text-warning"></i>Professional Bio</h5>
                        <p style="color: var(--text-slate); font-size: 0.95rem; line-height: 1.8;">
                            George is a Certified Public Accountant with extensive experience in East African transfer pricing. He provides strategic guidance on TP compliance and documentation for companies operating in the region.
                        </p>
                        <h6 class="text-white mt-4"><i class="bi bi-star-fill me-2 text-warning"></i>Key Specializations:</h6>
                        <ul class="row list-unstyled" style="color: var(--text-slate); font-size: 0.85rem;">
                            <li class="col-6 mb-2"><i class="bi bi-check2 text-warning me-2"></i>East Africa TP</li>
                            <li class="col-6 mb-2"><i class="bi bi-check2 text-warning me-2"></i>Tax Compliance</li>
                            <li class="col-6 mb-2"><i class="bi bi-check2 text-warning me-2"></i>Financial Analysis</li>
                            <li class="col-6 mb-2"><i class="bi bi-check2 text-warning me-2"></i>Strategic Advisory</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
'''
    }
}

def check_if_member_exists(content, member_name):
    """Check if team member already exists in the file"""
    if member_name == 'Mosttafa Shazzad Hasan':
        return 'Mosttafa Shazzad Hasan.jpg' in content
    elif member_name == 'Manoneet Dalal':
        return 'manoomet.png' in content
    elif member_name == 'Nathaniel Owusu Ansah':
        return 'Nathaniel Owusu Ansah.jpg' in content
    elif member_name == 'George Mureithi':
        return 'George Mureithi.jpg' in content
    return False

def add_team_members_to_file(html_file, members_to_add):
    """Add missing team members to a country page"""
    with open(html_file, 'r', encoding='utf-8') as f:
        content = f.read()
    
    original_content = content
    
    # Find the team section - look for the closing </div> of the last team card before </section>
    # Pattern: find the row with team cards, then add new cards before the closing </div></div></section>
    
    # Find the team section pattern
    team_section_pattern = r'(<div class="row g-4 justify-content-center">.*?)(</div>\s*</div>\s*</section>)'
    match = re.search(team_section_pattern, content, re.DOTALL)
    
    if not match:
        print(f"  ⚠️  Could not find team section pattern in {html_file.name}")
        return False
    
    # Add team member cards
    cards_html = ""
    for member in members_to_add:
        if member in TEAM_MEMBERS:
            cards_html += "\n" + TEAM_MEMBERS[member]['card']
    
    # Insert cards before the closing tags
    new_team_section = match.group(1) + cards_html + "\n        " + match.group(2)
    content = content[:match.start()] + new_team_section + content[match.end():]
    
    # Add modals before the closing </body> tag
    modals_html = ""
    for member in members_to_add:
        if member in TEAM_MEMBERS:
            modals_html += "\n" + TEAM_MEMBERS[member]['modal']
    
    # Find the last modal or the footer section to insert before
    body_close_pattern = r'(</body>)'
    content = re.sub(body_close_pattern, modals_html + r'\n\1', content)
    
    # Write the updated content
    if content != original_content:
        with open(html_file, 'w', encoding='utf-8') as f:
            f.write(content)
        return True
    return False

# Country pages to update
country_pages = [
    'australia.html', 'bahrain.html', 'canada.html', 'egypt.html',
    'India.html', 'indonesia.html', 'malaysia.html', 'oman.html',
    'Qatar.html', 'Saudiarabia.html', 'singapore.html', 'thailand.html',
    'unitedarab.html', 'us.html', 'viethnam.html'
]

print("=" * 80)
print("ADDING MISSING TEAM MEMBERS TO COUNTRY PAGES")
print("=" * 80)

target_members = ['Mosttafa Shazzad Hasan', 'Manoneet Dalal', 'Nathaniel Owusu Ansah', 'George Mureithi']

print(f"\n🎯 TEAM MEMBERS TO ADD:")
for member in target_members:
    print(f"   • {member}")

print("\n" + "=" * 80)

updated_files = 0
for page in country_pages:
    file_path = Path(page)
    if not file_path.exists():
        continue
    
    with open(file_path, 'r', encoding='utf-8') as f:
        content = f.read()
    
    # Check which members are missing
    missing_members = []
    for member in target_members:
        if not check_if_member_exists(content, member):
            missing_members.append(member)
    
    if missing_members:
        print(f"\n📄 {page}")
        print(f"   Adding {len(missing_members)} member(s):")
        for member in missing_members:
            print(f"      + {member}")
        
        if add_team_members_to_file(file_path, missing_members):
            print(f"   ✅ Updated successfully")
            updated_files += 1
        else:
            print(f"   ❌ Failed to update")
    else:
        print(f"\n✅ {page} - Already has all target members")

print("\n" + "=" * 80)
print(f"✅ Updated {updated_files} file(s)")
print("=" * 80)
