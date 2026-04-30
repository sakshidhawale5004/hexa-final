#!/usr/bin/env python3
"""
Add Manoneet Dalal modal popup to Gulf region pages
"""
import re
from pathlib import Path

# Manoneet Dalal modal HTML
MANONEET_MODAL = '''
<!-- Manoneet Dalal Modal -->
<div class="modal fade" id="modalManoneet" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="background: var(--bg-dark); border: 1px solid var(--accent); border-radius: 20px; overflow: hidden;">
            <div class="modal-header border-0 pb-0">
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div class="row g-0">
                    <div class="col-md-4 text-center p-4" style="background: rgba(245, 196, 0, 0.05); border-right: 1px solid var(--glass-border);">
                        <img src="manoneet dalal new.jpg" class="img-fluid rounded mb-3" style="border: 2px solid var(--accent); width: 180px;">
                        <h4 class="text-white fw-bold mb-1" style="font-size: 1.1rem;">Manoneet Dalal</h4>
                        <p style="color: var(--accent); font-size: 0.85rem;">Leader - Global TP</p>
                        <hr style="border-color: var(--glass-border);">
                        <a href="mailto:md@hexatp.com" class="btn-main w-100">Consult Specialist</a>
                    </div>
                    <div class="col-md-8 p-4 p-md-5">
                        <h5 class="text-white fw-bold mb-3"><i class="bi bi-person-lines-fill me-2 text-warning"></i>Global Expertise</h5>
                        <p style="color: var(--text-slate); font-size: 0.95rem; line-height: 1.8;">
                            Manoneet brings a wealth of knowledge in international tax law and global transfer pricing strategies. He oversees complex benchmarking and documentation for large MNEs operating globally.
                        </p>
                        <h6 class="text-white mt-4"><i class="bi bi-star-fill me-2 text-warning"></i>Key Specializations:</h6>
                        <ul class="row list-unstyled" style="color: var(--text-slate); font-size: 0.85rem;">
                            <li class="col-6 mb-2"><i class="bi bi-check2 text-warning me-2"></i>Global TP Strategy</li>
                            <li class="col-6 mb-2"><i class="bi bi-check2 text-warning me-2"></i>OECD BEPS</li>
                            <li class="col-6 mb-2"><i class="bi bi-check2 text-warning me-2"></i>Benchmarking</li>
                            <li class="col-6 mb-2"><i class="bi bi-check2 text-warning me-2"></i>Dispute Resolution</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
'''

GULF_PAGES = ['unitedarab.html', 'Saudiarabia.html', 'Qatar.html', 'oman.html', 'bahrain.html', 'egypt.html']

def add_manoneet_modal():
    """Add Manoneet modal to Gulf region pages"""
    print("=" * 80)
    print("ADDING MANONEET DALAL MODAL TO GULF REGION PAGES")
    print("=" * 80)
    
    added_count = 0
    
    for filename in GULF_PAGES:
        file_path = Path(filename)
        if not file_path.exists():
            print(f"\n⚠️  {filename} not found")
            continue
        
        with open(file_path, 'r', encoding='utf-8') as f:
            content = f.read()
        
        # Check if modal already exists
        if 'id="modalManoneet"' in content:
            print(f"\n✅ {filename} - Modal already exists")
            continue
        
        # Find the position before </body> tag to insert modal
        body_close_pattern = r'(</body>)'
        match = re.search(body_close_pattern, content)
        
        if match:
            # Insert modal before </body>
            insert_pos = match.start()
            new_content = content[:insert_pos] + MANONEET_MODAL + '\n' + content[insert_pos:]
            
            with open(file_path, 'w', encoding='utf-8') as f:
                f.write(new_content)
            print(f"\n✅ {filename} - Added Manoneet modal")
            added_count += 1
        else:
            print(f"\n⚠️  {filename} - Could not find </body> tag")
    
    print("\n" + "=" * 80)
    print(f"✅ Added modal to {added_count} file(s)")
    print("=" * 80)

if __name__ == '__main__':
    add_manoneet_modal()
