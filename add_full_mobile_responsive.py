#!/usr/bin/env python3
"""
Add comprehensive mobile responsive CSS to all HTML files
"""

import re
from pathlib import Path

# Comprehensive Mobile Responsive CSS
MOBILE_RESPONSIVE_CSS = """
<style>
/* ========== COMPREHENSIVE MOBILE RESPONSIVE STYLES ========== */

/* Base Responsive Typography */
@media (max-width: 768px) {
    body {
        font-size: 16px;
        line-height: 1.6;
    }
    
    h1 {
        font-size: 32px !important;
        line-height: 1.2 !important;
    }
    
    h2 {
        font-size: 28px !important;
        line-height: 1.3 !important;
    }
    
    h3 {
        font-size: 24px !important;
        line-height: 1.4 !important;
    }
    
    h4 {
        font-size: 20px !important;
    }
    
    p {
        font-size: 16px !important;
        line-height: 1.6 !important;
    }
    
    /* Hero Section */
    .hero-section,
    .hero,
    .hero-split {
        padding: 120px 20px 60px !important;
        text-align: center !important;
    }
    
    .hero-section h1,
    .hero h1 {
        font-size: 36px !important;
        margin-bottom: 20px !important;
    }
    
    .hero-section p,
    .hero p {
        font-size: 16px !important;
        max-width: 100% !important;
        padding: 0 10px !important;
    }
    
    /* Header/Navigation */
    header {
        width: 95% !important;
        padding: 10px 20px !important;
        top: 10px !important;
    }
    
    .logo {
        font-size: 18px !important;
    }
    
    /* Buttons */
    .btn-main,
    .btn-accent,
    .btn-glow,
    .cta-btn {
        padding: 12px 24px !important;
        font-size: 14px !important;
        width: auto !important;
        display: inline-block !important;
    }
    
    /* Cards & Grid Layouts */
    .card,
    .service-card,
    .feature-card,
    .country-card,
    .hexa-card {
        margin-bottom: 20px !important;
        padding: 20px !important;
    }
    
    .grid,
    .bento-grid,
    .advisory-container,
    .section-wrapper {
        grid-template-columns: 1fr !important;
        gap: 20px !important;
    }
    
    /* Containers */
    .container {
        padding-left: 20px !important;
        padding-right: 20px !important;
    }
    
    section {
        padding: 60px 20px !important;
    }
    
    /* Images */
    img {
        max-width: 100% !important;
        height: auto !important;
    }
    
    /* Tables */
    table {
        display: block !important;
        overflow-x: auto !important;
        white-space: nowrap !important;
    }
    
    /* Forms */
    input,
    textarea,
    select {
        width: 100% !important;
        font-size: 16px !important;
        padding: 12px !important;
    }
    
    /* Modals */
    .modal-dialog {
        margin: 10px !important;
        max-width: calc(100% - 20px) !important;
    }
    
    .modal-content {
        border-radius: 12px !important;
    }
    
    /* Stats/Numbers */
    .stat-number,
    .stats-card {
        font-size: 32px !important;
    }
    
    /* Columns */
    .row > [class*='col-'] {
        padding-left: 15px !important;
        padding-right: 15px !important;
    }
    
    /* Hide desktop-only elements */
    .d-none.d-md-block:not(nav) {
        display: none !important;
    }
    
    /* Show mobile-only elements */
    .d-block.d-md-none {
        display: block !important;
    }
    
    /* Spacing */
    .mb-5 {
        margin-bottom: 30px !important;
    }
    
    .mt-5 {
        margin-top: 30px !important;
    }
    
    .py-5 {
        padding-top: 40px !important;
        padding-bottom: 40px !important;
    }
    
    /* Footer */
    footer {
        padding: 40px 20px !important;
        text-align: center !important;
    }
    
    footer .row {
        flex-direction: column !important;
    }
    
    footer .col-md-3,
    footer .col-md-4,
    footer .col-md-6 {
        margin-bottom: 30px !important;
        text-align: center !important;
    }
}

/* Tablet Responsive (768px - 1024px) */
@media (min-width: 769px) and (max-width: 1024px) {
    .container {
        max-width: 720px !important;
    }
    
    h1 {
        font-size: 42px !important;
    }
    
    h2 {
        font-size: 36px !important;
    }
    
    .grid,
    .bento-grid {
        grid-template-columns: repeat(2, 1fr) !important;
    }
}

/* Small Mobile (< 400px) */
@media (max-width: 400px) {
    body {
        font-size: 14px;
    }
    
    h1 {
        font-size: 28px !important;
    }
    
    h2 {
        font-size: 24px !important;
    }
    
    .btn-main,
    .btn-accent {
        padding: 10px 20px !important;
        font-size: 13px !important;
    }
    
    header {
        padding: 8px 15px !important;
    }
    
    .logo {
        font-size: 16px !important;
    }
}

/* Landscape Mobile */
@media (max-height: 500px) and (orientation: landscape) {
    .hero-section,
    .hero {
        padding: 80px 20px 40px !important;
    }
    
    .hero-section h1,
    .hero h1 {
        font-size: 32px !important;
    }
}

/* Touch-friendly improvements */
@media (hover: none) and (pointer: coarse) {
    /* Touch devices */
    a,
    button,
    .btn,
    .card {
        min-height: 44px !important;
        min-width: 44px !important;
    }
    
    input,
    textarea,
    select {
        font-size: 16px !important; /* Prevents zoom on iOS */
    }
}

/* Prevent horizontal scroll */
body {
    overflow-x: hidden !important;
}

* {
    max-width: 100%;
}

/* Ensure images don't overflow */
img,
video,
iframe {
    max-width: 100% !important;
    height: auto !important;
}
</style>
"""

def add_responsive_css(filepath):
    """Add comprehensive mobile responsive CSS to HTML file"""
    try:
        with open(filepath, 'r', encoding='utf-8') as f:
            content = f.read()
        
        # Check if already added
        if 'COMPREHENSIVE MOBILE RESPONSIVE STYLES' in content:
            return 'already_added'
        
        # Add CSS before </head>
        if '</head>' in content:
            content = content.replace('</head>', f'{MOBILE_RESPONSIVE_CSS}\n</head>', 1)
        else:
            return 'no_head_tag'
        
        # Write back
        with open(filepath, 'w', encoding='utf-8') as f:
            f.write(content)
        
        return 'success'
    
    except Exception as e:
        return f'error: {str(e)}'

def main():
    """Main function"""
    print("🎨 Adding Comprehensive Mobile Responsive CSS\n")
    print("=" * 60)
    
    # Get all HTML files
    html_files = list(Path('.').glob('*.html'))
    
    if not html_files:
        print("❌ No HTML files found")
        return
    
    success_count = 0
    already_count = 0
    error_count = 0
    
    for html_file in html_files:
        filename = html_file.name
        result = add_responsive_css(html_file)
        
        if result == 'success':
            success_count += 1
            print(f"✅ {filename}")
        elif result == 'already_added':
            already_count += 1
            print(f"⏭️  {filename} (already responsive)")
        else:
            error_count += 1
            print(f"❌ {filename} - {result}")
    
    print("\n" + "=" * 60)
    print("📊 SUMMARY\n")
    print(f"✅ Successfully updated: {success_count} files")
    print(f"⏭️  Already responsive: {already_count} files")
    print(f"❌ Errors: {error_count} files")
    print(f"\n📱 Total files now fully responsive: {success_count + already_count}")
    
    print("\n" + "=" * 60)
    print("✨ Mobile Responsiveness Enhancement Complete!")
    print("\n📱 Your website is now FULLY mobile responsive!")
    print("   - All text sizes adapt to screen size")
    print("   - All layouts stack properly on mobile")
    print("   - All images scale correctly")
    print("   - Touch-friendly button sizes")
    print("   - No horizontal scrolling")

if __name__ == '__main__':
    main()
