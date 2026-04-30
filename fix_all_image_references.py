#!/usr/bin/env python3
"""
Fix all team member image references to match actual filenames
"""
import re
from pathlib import Path

# Image reference fixes needed
IMAGE_FIXES = [
    # Udit Gupta: udit.png -> Udit Gupta.jpg
    {
        'old': 'udit.png',
        'new': 'Udit Gupta.jpg',
        'files': ['canada.html', 'us.html', 'indonesia.html', 'viethnam.html']
    },
    # Mosttafa: Mosttafa Shazzad Hasan.JPG -> Mosttafa Shazzad Hasan.jpg
    {
        'old': 'Mosttafa Shazzad Hasan.JPG',
        'new': 'Mosttafa Shazzad Hasan.jpg',
        'files': ['bangladesh.html', 'aboutus.html']
    }
]

# Add Manoneet Dalal to Gulf region pages
MANONEET_CARD = '''            <div class="col-lg-3 col-md-6">
                <div class="team-card">
                    <div class="team-img-wrapper">
                        <img src="manoneet dalal new.jpg" alt="Manoneet Dalal">
                    </div>
                    <h5>Manoneet Dalal [LL.M.]</h5>
                    <p class="role">Leader - Global TP</p>
                    <a href="javascript:void(0)" class="learn-more-btn" data-bs-toggle="modal" data-bs-target="#modalManoneet">
                        Learn More <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>'''

GULF_PAGES = ['unitedarab.html', 'Saudiarabia.html', 'Qatar.html', 'oman.html', 'bahrain.html', 'egypt.html']

def fix_image_references():
    """Fix all image reference issues"""
    print("=" * 80)
    print("FIXING ALL IMAGE REFERENCES")
    print("=" * 80)
    
    fixed_count = 0
    
    # Fix image filename references
    for fix in IMAGE_FIXES:
        print(f"\n📝 Fixing: {fix['old']} -> {fix['new']}")
        for filename in fix['files']:
            file_path = Path(filename)
            if not file_path.exists():
                print(f"   ⚠️  {filename} not found")
                continue
            
            with open(file_path, 'r', encoding='utf-8') as f:
                content = f.read()
            
            if fix['old'] in content:
                new_content = content.replace(fix['old'], fix['new'])
                with open(file_path, 'w', encoding='utf-8') as f:
                    f.write(new_content)
                print(f"   ✅ {filename} - Updated")
                fixed_count += 1
            else:
                print(f"   ℹ️  {filename} - No change needed")
    
    # Add Manoneet Dalal to Gulf region pages
    print(f"\n📝 Adding Manoneet Dalal to Gulf region pages")
    for filename in GULF_PAGES:
        file_path = Path(filename)
        if not file_path.exists():
            print(f"   ⚠️  {filename} not found")
            continue
        
        with open(file_path, 'r', encoding='utf-8') as f:
            content = f.read()
        
        # Check if Manoneet is already present
        if 'manoneet dalal new.jpg' in content:
            print(f"   ℹ️  {filename} - Manoneet already present")
            continue
        
        # Find the position after Saniya Abbasi card to insert Manoneet
        # Pattern: Find Saniya's card closing </div></div> and insert Manoneet after it
        saniya_pattern = r'(<h5>Saniya Abbasi.*?</div>\s*</div>)'
        match = re.search(saniya_pattern, content, re.DOTALL)
        
        if match:
            # Insert Manoneet card after Saniya's card
            insert_pos = match.end()
            new_content = content[:insert_pos] + '\n' + MANONEET_CARD + content[insert_pos:]
            
            with open(file_path, 'w', encoding='utf-8') as f:
                f.write(new_content)
            print(f"   ✅ {filename} - Added Manoneet Dalal")
            fixed_count += 1
        else:
            print(f"   ⚠️  {filename} - Could not find insertion point")
    
    print("\n" + "=" * 80)
    print(f"✅ Fixed {fixed_count} file(s)")
    print("=" * 80)

if __name__ == '__main__':
    fix_image_references()
