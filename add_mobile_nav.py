#!/usr/bin/env python3
"""
Automatically add mobile navigation to all HTML files
"""

import os
import re
from pathlib import Path

# Mobile Navigation CSS
MOBILE_NAV_CSS = """
<style>
/* ========== MOBILE NAVIGATION STYLES ========== */
.mobile-nav-toggle {
    display: none;
    position: absolute;
    right: 5%;
    top: 20px;
    background: none;
    border: none;
    color: #f5c400;
    font-size: 28px;
    cursor: pointer;
    z-index: 1001;
    padding: 10px;
    line-height: 1;
}

.mobile-menu {
    position: fixed;
    top: 0;
    right: -100%;
    width: 280px;
    height: 100vh;
    background: rgba(5, 10, 20, 0.98);
    backdrop-filter: blur(20px);
    border-left: 1px solid rgba(255, 255, 255, 0.1);
    padding: 80px 20px 20px;
    transition: right 0.3s ease;
    z-index: 1000;
    overflow-y: auto;
    box-shadow: -5px 0 20px rgba(0, 0, 0, 0.5);
}

.mobile-menu.active { right: 0; }

.mobile-menu ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.mobile-menu ul li { margin-bottom: 15px; }

.mobile-menu ul li a {
    color: #fff;
    text-decoration: none;
    font-size: 18px;
    display: block;
    padding: 12px 15px;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.mobile-menu ul li a:hover {
    background: rgba(245, 196, 0, 0.1);
    color: #f5c400;
    transform: translateX(5px);
}

.mobile-submenu {
    padding-left: 20px;
    margin-top: 10px;
    display: none;
    border-left: 2px solid rgba(245, 196, 0, 0.3);
}

.mobile-submenu.active {
    display: block;
    animation: slideDown 0.3s ease;
}

@keyframes slideDown {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

.mobile-submenu li a {
    font-size: 16px;
    padding: 10px 15px;
}

.mobile-dropdown-toggle {
    color: #fff;
    font-size: 18px;
    padding: 12px 15px;
    cursor: pointer;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-radius: 8px;
    transition: all 0.3s ease;
    user-select: none;
}

.mobile-dropdown-toggle:hover {
    background: rgba(245, 196, 0, 0.1);
    color: #f5c400;
}

.mobile-dropdown-toggle::after {
    content: '▼';
    font-size: 12px;
    transition: transform 0.3s ease;
}

.mobile-dropdown-toggle.active { color: #f5c400; }
.mobile-dropdown-toggle.active::after { transform: rotate(180deg); }

.mobile-overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.7);
    z-index: 999;
    backdrop-filter: blur(2px);
}

.mobile-overlay.active {
    display: block;
    animation: fadeIn 0.3s ease;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

.close-menu {
    position: absolute;
    top: 20px;
    right: 20px;
    background: none;
    border: none;
    color: #f5c400;
    font-size: 32px;
    cursor: pointer;
    padding: 5px;
    line-height: 1;
    transition: transform 0.3s ease;
}

.close-menu:hover { transform: rotate(90deg); }

@media (max-width: 768px) {
    .mobile-nav-toggle { display: block; }
    header nav.d-none.d-md-block { display: none !important; }
}

@media (min-width: 769px) {
    .mobile-menu, .mobile-overlay, .mobile-nav-toggle { display: none !important; }
}

header { position: relative; }

.mobile-menu::-webkit-scrollbar { width: 6px; }
.mobile-menu::-webkit-scrollbar-track { background: rgba(255, 255, 255, 0.05); }
.mobile-menu::-webkit-scrollbar-thumb { background: rgba(245, 196, 0, 0.3); border-radius: 3px; }
.mobile-menu::-webkit-scrollbar-thumb:hover { background: rgba(245, 196, 0, 0.5); }
</style>
"""

# Mobile Navigation HTML
MOBILE_NAV_HTML = """
<!-- Mobile Navigation -->
<button class="mobile-nav-toggle" onclick="openMobileMenu()" aria-label="Open menu">☰</button>
<div class="mobile-overlay" id="mobileOverlay" onclick="closeMobileMenu()"></div>
<div class="mobile-menu" id="mobileMenu">
    <button class="close-menu" onclick="closeMobileMenu()" aria-label="Close menu">×</button>
    <ul>
        <li><a href="index.html">🏠 Home</a></li>
        <li><a href="aboutus.html">ℹ️ About</a></li>
        <li><a href="solution.html">💡 Solutions</a></li>
        <li>
            <div class="mobile-dropdown-toggle" onclick="toggleSubmenu('countriesMenu', this)">
                <span>🌍 Countries</span>
            </div>
            <ul class="mobile-submenu" id="countriesMenu">
                <li>
                    <div class="mobile-dropdown-toggle" onclick="toggleSubmenu('gulfMenu', this)">
                        <span>🏜️ Gulf Region</span>
                    </div>
                    <ul class="mobile-submenu" id="gulfMenu">
                        <li><a href="unitedarab.html">🇦🇪 UAE</a></li>
                        <li><a href="Saudiarabia.html">🇸🇦 Saudi Arabia</a></li>
                        <li><a href="Qatar.html">🇶🇦 Qatar</a></li>
                        <li><a href="oman.html">🇴🇲 Oman</a></li>
                        <li><a href="bahrain.html">🇧🇭 Bahrain</a></li>
                        <li><a href="egypt.html">🇪🇬 Egypt</a></li>
                    </ul>
                </li>
                <li>
                    <div class="mobile-dropdown-toggle" onclick="toggleSubmenu('asiaMenu', this)">
                        <span>🌏 Asia</span>
                    </div>
                    <ul class="mobile-submenu" id="asiaMenu">
                        <li><a href="India.html">🇮🇳 India</a></li>
                        <li><a href="singapore.html">🇸🇬 Singapore</a></li>
                        <li><a href="malaysia.html">🇲🇾 Malaysia</a></li>
                        <li><a href="thailand.html">🇹🇭 Thailand</a></li>
                        <li><a href="indonesia.html">🇮🇩 Indonesia</a></li>
                        <li><a href="viethnam.html">🇻🇳 Vietnam</a></li>
                        <li><a href="bangladesh.html">🇧🇩 Bangladesh</a></li>
                    </ul>
                </li>
                <li>
                    <div class="mobile-dropdown-toggle" onclick="toggleSubmenu('africaMenu', this)">
                        <span>🌍 Africa</span>
                    </div>
                    <ul class="mobile-submenu" id="africaMenu">
                        <li><a href="kenya.html">🇰🇪 Kenya</a></li>
                        <li><a href="ghana.html">🇬🇭 Ghana</a></li>
                        <li><a href="botswana.html">🇧🇼 Botswana</a></li>
                    </ul>
                </li>
                <li>
                    <div class="mobile-dropdown-toggle" onclick="toggleSubmenu('americasMenu', this)">
                        <span>🌎 Americas & Oceania</span>
                    </div>
                    <ul class="mobile-submenu" id="americasMenu">
                        <li><a href="us.html">🇺🇸 United States</a></li>
                        <li><a href="canada.html">🇨🇦 Canada</a></li>
                        <li><a href="australia.html">🇦🇺 Australia</a></li>
                    </ul>
                </li>
            </ul>
        </li>
        <li><a href="contact.html">📞 Contact</a></li>
    </ul>
</div>
"""

# Mobile Navigation JavaScript
MOBILE_NAV_JS = """
<script>
function openMobileMenu() {
    const menu = document.getElementById('mobileMenu');
    const overlay = document.getElementById('mobileOverlay');
    menu.classList.add('active');
    overlay.classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeMobileMenu() {
    const menu = document.getElementById('mobileMenu');
    const overlay = document.getElementById('mobileOverlay');
    menu.classList.remove('active');
    overlay.classList.remove('active');
    document.body.style.overflow = '';
}

function toggleSubmenu(submenuId, toggleElement) {
    const submenu = document.getElementById(submenuId);
    if (submenu) {
        submenu.classList.toggle('active');
        toggleElement.classList.toggle('active');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuLinks = document.querySelectorAll('.mobile-menu a');
    mobileMenuLinks.forEach(link => {
        link.addEventListener('click', function() {
            closeMobileMenu();
        });
    });
});

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeMobileMenu();
    }
});
</script>
"""

def add_mobile_nav_to_file(filepath):
    """Add mobile navigation to a single HTML file"""
    try:
        with open(filepath, 'r', encoding='utf-8') as f:
            content = f.read()
        
        # Check if already added
        if 'mobile-nav-toggle' in content or 'MOBILE NAVIGATION STYLES' in content:
            return 'already_added'
        
        # Add CSS before </head>
        if '</head>' in content:
            content = content.replace('</head>', f'{MOBILE_NAV_CSS}\n</head>', 1)
        else:
            return 'no_head_tag'
        
        # Add HTML after <header>
        header_pattern = r'(<header[^>]*>)'
        if re.search(header_pattern, content):
            content = re.sub(header_pattern, f'\\1\n{MOBILE_NAV_HTML}\n', content, count=1)
        else:
            return 'no_header_tag'
        
        # Add JavaScript before </body>
        if '</body>' in content:
            content = content.replace('</body>', f'{MOBILE_NAV_JS}\n</body>', 1)
        else:
            return 'no_body_tag'
        
        # Write back
        with open(filepath, 'w', encoding='utf-8') as f:
            f.write(content)
        
        return 'success'
    
    except Exception as e:
        return f'error: {str(e)}'

def main():
    """Main function to process all HTML files"""
    print("🚀 Adding Mobile Navigation to All HTML Files\n")
    print("=" * 60)
    
    # Get all HTML files
    html_files = list(Path('.').glob('*.html'))
    
    if not html_files:
        print("❌ No HTML files found in current directory")
        return
    
    results = {
        'success': [],
        'already_added': [],
        'no_header_tag': [],
        'no_head_tag': [],
        'no_body_tag': [],
        'error': []
    }
    
    for html_file in html_files:
        filename = html_file.name
        result = add_mobile_nav_to_file(html_file)
        
        if result == 'success':
            results['success'].append(filename)
            print(f"✅ {filename}")
        elif result == 'already_added':
            results['already_added'].append(filename)
            print(f"⏭️  {filename} (already has mobile nav)")
        elif result.startswith('error'):
            results['error'].append(filename)
            print(f"❌ {filename} - {result}")
        else:
            results[result].append(filename)
            print(f"⚠️  {filename} - {result}")
    
    # Summary
    print("\n" + "=" * 60)
    print("📊 SUMMARY\n")
    print(f"✅ Successfully updated: {len(results['success'])} files")
    print(f"⏭️  Already had mobile nav: {len(results['already_added'])} files")
    print(f"⚠️  Missing header tag: {len(results['no_header_tag'])} files")
    print(f"⚠️  Missing head tag: {len(results['no_head_tag'])} files")
    print(f"⚠️  Missing body tag: {len(results['no_body_tag'])} files")
    print(f"❌ Errors: {len(results['error'])} files")
    
    print("\n" + "=" * 60)
    print("✨ Mobile Navigation Update Complete!")
    print("\n📱 Test your pages:")
    print("   1. Open any HTML file in browser")
    print("   2. Resize to mobile width (< 768px)")
    print("   3. Click hamburger menu (☰)")
    print("   4. Test navigation links")

if __name__ == '__main__':
    main()
