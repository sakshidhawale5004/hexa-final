# Header Fix Instructions for contact_new.html

## Problem:
The header in contact_new.html is simplified and doesn't match the other pages.

## Solution:
Replace the header section in contact_new.html with the complete header from index.html.

## What to Replace:

### Current Header in contact_new.html (REMOVE THIS):
```html
<header>
    <div class="logo">HEXA<span>TP</span></div>
    <nav class="d-none d-md-block">
        <ul>
            <li><a href="index.html">Home</a></li>
            <li><a href="aboutus.html">About</a></li>
            <li><a href="contact.html">Contact</a></li>
        </ul>
    </nav>
    <a href="mailto:md@hexatp.com" class="btn-main">Get Started</a>
</header>
```

### Replace With (COPY FROM index.html):
```html
<header>
    <!-- Mobile Navigation -->
    <button class="mobile-nav-toggle" onclick="openMobileMenu()" aria-label="Open menu">☰</button>
    <div class="mobile-overlay" id="mobileOverlay" onclick="closeMobileMenu()"></div>
    <div class="mobile-menu" id="mobileMenu">
        <button class="close-menu" onclick="closeMobileMenu()" aria-label="Close menu">×</button>
        <ul>
            <li><a href="index.html">Home</a></li>
            <li><a href="aboutus.html">About</a></li>
            <li><a href="solution.html">Solutions</a></li>
            <li>
                <div class="mobile-dropdown-toggle" onclick="toggleSubmenu('countriesMenu', this)">
                    <span>Countries</span>
                </div>
                <ul class="mobile-submenu" id="countriesMenu">
                    <li>
                        <div class="mobile-dropdown-toggle" onclick="toggleSubmenu('gulfMenu', this)">
                            <span>🏜️ Gulf Region</span>
                        </div>
                        <ul class="mobile-submenu" id="gulfMenu">
                            <li><a href="unitedarab.html">UAE</a></li>
                            <li><a href="Saudiarabia.html">Saudi Arabia</a></li>
                            <li><a href="Qatar.html">Qatar</a></li>
                            <li><a href="oman.html">Oman</a></li>
                            <li><a href="bahrain.html">Bahrain</a></li>
                            <li><a href="egypt.html">Egypt</a></li>
                        </ul>
                    </li>
                    <li>
                        <div class="mobile-dropdown-toggle" onclick="toggleSubmenu('asiaMenu', this)">
                            <span>Asia</span>
                        </div>
                        <ul class="mobile-submenu" id="asiaMenu">
                            <li><a href="India.html">India</a></li>
                            <li><a href="singapore.html">Singapore</a></li>
                            <li><a href="malaysia.html">Malaysia</a></li>
                            <li><a href="thailand.html">Thailand</a></li>
                            <li><a href="indonesia.html">Indonesia</a></li>
                            <li><a href="viethnam.html">Vietnam</a></li>
                            <li><a href="bangladesh.html">Bangladesh</a></li>
                        </ul>
                    </li>
                    <li>
                        <div class="mobile-dropdown-toggle" onclick="toggleSubmenu('africaMenu', this)">
                            <span>Africa</span>
                        </div>
                        <ul class="mobile-submenu" id="africaMenu">
                            <li><a href="kenya.html">Kenya</a></li>
                            <li><a href="ghana.html">Ghana</a></li>
                            <li><a href="botswana.html">🇧🇼 Botswana</a></li>
                        </ul>
                    </li>
                    <li>
                        <div class="mobile-dropdown-toggle" onclick="toggleSubmenu('americasMenu', this)">
                            <span>Americas & Oceania</span>
                        </div>
                        <ul class="mobile-submenu" id="americasMenu">
                            <li><a href="us.html">United States</a></li>
                            <li><a href="canada.html">Canada</a></li>
                            <li><a href="australia.html">Australia</a></li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li><a href="contact.html">Contact</a></li>
        </ul>
    </div>

    <div class="logo">HEXA<span>TP</span></div>
    
    <nav class="d-none d-md-block">
        <ul>
            <li><a href="index.html">Home</a></li>
            <li><a href="aboutus.html">About</a></li>
            <li><a href="solution.html">Solutions</a></li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                    Countries
                </a>
                <ul class="dropdown-menu">
                    <!-- Gulf Region -->
                    <li class="dropdown-submenu position-relative">
                        <a class="dropdown-item dropdown-toggle" href="#">Gulf Region</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="unitedarab.html">UAE</a></li>
                            <li><a class="dropdown-item" href="Saudiarabia.html">Saudi Arabia</a></li>
                            <li><a class="dropdown-item" href="Qatar.html">Qatar</a></li>
                            <li><a class="dropdown-item" href="oman.html">Oman</a></li>
                            <li><a class="dropdown-item" href="bahrain.html">Bahrain</a></li>
                            <li><a class="dropdown-item" href="egypt.html">Egypt</a></li>
                        </ul>
                    </li>
                    <!-- Asia -->
                    <li class="dropdown-submenu">
                        <a class="dropdown-item dropdown-toggle" href="#">Asia</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="India.html">India</a></li>
                            <li><a class="dropdown-item" href="bangladesh.html">Bangladesh</a></li>
                        </ul>
                    </li>
                    <!-- South East Asia -->
                    <li class="dropdown-submenu">
                        <a class="dropdown-item dropdown-toggle" href="#">South East Asia</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="singapore.html">Singapore</a></li>
                            <li><a class="dropdown-item" href="thailand.html">Thailand</a></li>
                            <li><a class="dropdown-item" href="malaysia.html">Malaysia</a></li>
                            <li><a class="dropdown-item" href="australia.html">Australia</a></li>
                            <li><a class="dropdown-item" href="indonesia.html">Indonesia</a></li>
                            <li><a class="dropdown-item" href="viethnam.html">Vietnam</a></li>
                        </ul>
                    </li>
                    <!-- Africa -->
                    <li class="dropdown-submenu">
                        <a class="dropdown-item dropdown-toggle" href="#">Africa</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="botswana.html">Botswana</a></li>
                            <li><a class="dropdown-item" href="ghana.html">Ghana</a></li>
                            <li><a class="dropdown-item" href="kenya.html">Kenya</a></li>
                        </ul>
                    </li>
                    <!-- America -->
                    <li class="dropdown-submenu">
                        <a class="dropdown-item dropdown-toggle" href="#">America</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="canada.html">Canada</a></li>
                            <li><a class="dropdown-item" href="us.html">United States</a></li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li><a href="contact.html">Contact</a></li>
        </ul>
    </nav>
    
    <a href="mailto:md@hexatp.com" class="btn-main py-2 px-4 fs-6">Get Started</a>
</header>
```

## Also Add Mobile Navigation Styles:

Add this CSS in the `<style>` section (after the existing styles):

```css
/* Mobile Navigation Styles */
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
}

.mobile-menu.active {
    right: 0;
}

.mobile-menu ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

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
}

.mobile-submenu {
    padding-left: 20px;
    margin-top: 10px;
    display: none;
}

.mobile-submenu.active {
    display: block;
}

.mobile-dropdown-toggle {
    color: #fff;
    font-size: 18px;
    padding: 12px 15px;
    cursor: pointer;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.mobile-dropdown-toggle::after {
    content: '▼';
    font-size: 12px;
}

.mobile-overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.7);
    z-index: 999;
}

.mobile-overlay.active {
    display: block;
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
}

@media (max-width: 768px) {
    .mobile-nav-toggle {
        display: block;
    }
}

/* Dropdown Styles */
.dropdown-submenu {
    position: relative;
}

.dropdown-submenu .dropdown-menu {
    position: absolute;
    top: 0;
    left: 100%;
    display: none;
    background: var(--accent);
}

.dropdown-submenu:hover > .dropdown-menu {
    display: block;
}

.dropdown-item:hover {
    background-color: #000;
    color: #fff;
}
```

## Add JavaScript Functions:

Add this before the closing `</body>` tag:

```javascript
<script>
function openMobileMenu() {
    document.getElementById('mobileMenu').classList.add('active');
    document.getElementById('mobileOverlay').classList.add('active');
}

function closeMobileMenu() {
    document.getElementById('mobileMenu').classList.remove('active');
    document.getElementById('mobileOverlay').classList.remove('active');
}

function toggleSubmenu(menuId, element) {
    const submenu = document.getElementById(menuId);
    submenu.classList.toggle('active');
    element.classList.toggle('active');
}
</script>
```

## Quick Fix:
The easiest way is to:
1. Open index.html
2. Copy the entire `<header>` section
3. Paste it into contact_new.html to replace the simple header
4. Make sure the mobile navigation CSS and JavaScript are also included

This will make the header identical across all pages!
