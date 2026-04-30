#!/usr/bin/env python3
"""
Script to check team member images in HTML files
"""
import re
import os
from pathlib import Path

def check_team_images(html_file):
    """Extract team member image references from HTML file"""
    with open(html_file, 'r', encoding='utf-8') as f:
        content = f.read()
    
    # Find all image src attributes
    img_pattern = r'<img[^>]+src=["\']([^"\']+)["\'][^>]*>'
    images = re.findall(img_pattern, content)
    
    # Filter for team member images (local jpg/png files)
    team_images = []
    for img in images:
        if not img.startswith('http') and (img.endswith('.jpg') or img.endswith('.png') or img.endswith('.jpeg')):
            team_images.append(img)
    
    return team_images

def list_available_images(directory):
    """List all image files in directory"""
    image_files = []
    for ext in ['*.jpg', '*.png', '*.jpeg', '*.JPG', '*.PNG', '*.JPEG']:
        image_files.extend(Path(directory).glob(ext))
    return [f.name for f in image_files]

# Check aboutus.html
print("=" * 60)
print("TEAM MEMBER IMAGES IN aboutus.html")
print("=" * 60)
team_imgs = check_team_images('aboutus.html')
print(f"\nFound {len(team_imgs)} team member images:")
for img in sorted(set(team_imgs)):
    print(f"  - {img}")

# List available image files
print("\n" + "=" * 60)
print("AVAILABLE IMAGE FILES IN hexatp-main/")
print("=" * 60)
available = list_available_images('.')
print(f"\nFound {len(available)} image files:")
for img in sorted(available):
    print(f"  - {img}")

# Check which images are referenced but don't exist
print("\n" + "=" * 60)
print("MISSING IMAGES (referenced but not found)")
print("=" * 60)
missing = []
for img in team_imgs:
    img_name = img.split('/')[-1]  # Get filename only
    if img_name not in available:
        missing.append(img_name)
        print(f"  ❌ {img_name}")

if not missing:
    print("  ✅ All referenced images exist!")

# Check which new images are not being used
print("\n" + "=" * 60)
print("UNUSED NEW IMAGES")
print("=" * 60)
new_images = [
    "Gyan Prakash Srivastava new.jpg",
    "PRIYANKA new.jpg",
    "Mohammad Taher Shaikh new.jpg",
    "SANIYA.jpg",
    "Mosttafa Shazzad Hasan.jpg",
    "Udit Gupta.jpg",
    "Nathaniel Owusu Ansah.jpg",
    "George Mureithi.jpg",
    "himanshu1.png",
    "nitin1.png",
    "yishu1.png"
]

unused = []
for img in new_images:
    if img not in [t.split('/')[-1] for t in team_imgs]:
        unused.append(img)
        print(f"  ⚠️  {img}")

if not unused:
    print("  ✅ All new images are being used!")

print("\n" + "=" * 60)
