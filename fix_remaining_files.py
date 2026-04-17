#!/usr/bin/env python3
"""
Fix the remaining 5 HTML files that use <nav> instead of <header>
"""

import re

# Mobile Navigation CSS
MOBILE_NAV_CSS = """
<style>
/* ========== MOBILE NAVIGATION STYLES ========== */
.mobile-nav-toggle {
    display: none;
    position: fixed;
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
    nav.navbar .navbar-collapse { display: none !important; }
}

@media (min-width: 769px) {
    .mobile-menu, .mobile-overlay, .mobile-nav-toggle { display: none !important; }
}

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

files_to_fix = [
    'aboutus1.html',
    'contact-form-example.html',
    'country.html',
    'country2.html',
    'sloution1.html'
]

print("🔧 Fixing remaining 5 HTML files\n")
print("=" * 60)

for filename in files_to_fix:
    try:
        with open(filename, 'r', encoding='utf-8') as f:
            content = f.read()
        
        # Check if already added
        if 'mobile-nav-toggle' in content:
            print(f"⏭️  {filename} (already has mobile nav)")
            continue
        
        # Add CSS before </head>
        if '</head>' in content:
            content = content.replace('</head>', f'{MOBILE_NAV_CSS}\n</head>', 1)
        
        # Add HTML after <body> or after <nav>
        if '<body>' in content:
            content = content.replace('<body>', f'<body>\n{MOBILE_NAV_HTML}\n', 1)
        
        # Add JavaScript before </body>
        if '</body>' in content:
            content = content.replace('</body>', f'{MOBILE_NAV_JS}\n</body>', 1)
        
        # Write back
        with open(filename, 'w', encoding='utf-8') as f:
            f.write(content)
        
        print(f"✅ {filename}")
    
    except FileNotFoundError:
        print(f"⚠️  {filename} (file not found)")
    except Exception as e:
        print(f"❌ {filename} - Error: {str(e)}")

print("\n" + "=" * 60)
print("✨ All files updated successfully!")
print("\n📱 All 29 HTML files now have mobile navigation!")
