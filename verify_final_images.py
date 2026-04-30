#!/usr/bin/env python3
"""
Final verification script to show which team images are used in each HTML file
"""
import re
from pathlib import Path
from collections import defaultdict

def extract_team_images(html_file):
    """Extract team member image references from HTML file"""
    with open(html_file, 'r', encoding='utf-8') as f:
        content = f.read()
    
    # Find all local image src attributes (not URLs)
    img_pattern = r'<img[^>]+src=["\']([^"\']+\.(?:jpg|png|jpeg))["\'][^>]*>'
    images = re.findall(img_pattern, content, re.IGNORECASE)
    
    # Filter for team member images (exclude URLs and common non-team images)
    team_images = []
    exclude_patterns = ['http', 'unsplash', 'placeholder', 'logo', 'banner']
    
    for img in images:
        img_lower = img.lower()
        if not any(pattern in img_lower for pattern in exclude_patterns):
            # Get just the filename
            filename = img.split('/')[-1]
            if filename not in team_images:
                team_images.append(filename)
    
    return sorted(team_images)

# Get all HTML files
html_files = list(Path('.').glob('*.html'))

print("=" * 80)
print("FINAL VERIFICATION - TEAM MEMBER IMAGES IN EACH HTML FILE")
print("=" * 80)

# Track which images are used in which files
image_usage = defaultdict(list)
files_with_teams = {}

for html_file in sorted(html_files):
    team_imgs = extract_team_images(html_file)
    if team_imgs:
        files_with_teams[html_file.name] = team_imgs
        for img in team_imgs:
            image_usage[img].append(html_file.name)

# Show images per file
print("\n📄 TEAM IMAGES BY FILE:")
print("-" * 80)
for filename, images in sorted(files_with_teams.items()):
    print(f"\n{filename}:")
    for img in images:
        print(f"  ✅ {img}")

# Show which files use each image
print("\n\n" + "=" * 80)
print("📊 IMAGE USAGE SUMMARY")
print("=" * 80)

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
    "yishu1.png",
    "manoomet.png"
]

print("\n✅ NEW IMAGES (should be used):")
for img in new_images:
    if img in image_usage:
        count = len(image_usage[img])
        print(f"  ✅ {img} - Used in {count} file(s)")
    else:
        print(f"  ⚠️  {img} - NOT USED")

old_images = [
    "gyan.jpg",
    "priyanka.png",
    "hitansu.png",
    "yishu.png",
    "nitin.png"
]

print("\n🗑️  OLD IMAGES (should NOT be used):")
found_old = False
for img in old_images:
    if img in image_usage:
        count = len(image_usage[img])
        print(f"  ❌ {img} - Still used in {count} file(s): {', '.join(image_usage[img])}")
        found_old = True

if not found_old:
    print("  ✅ No old images found - all have been replaced!")

print("\n" + "=" * 80)
print("FINAL STATUS")
print("=" * 80)

# Check if all new images are used and no old images remain
all_new_used = all(img in image_usage for img in new_images)
no_old_used = not any(img in image_usage for img in old_images)

if all_new_used and no_old_used:
    print("\n✅ ✅ ✅ PERFECT! ✅ ✅ ✅")
    print("\n✅ All new team member images are being used")
    print("✅ No old images are being referenced")
    print("✅ Website is ready for deployment!")
else:
    if not all_new_used:
        print("\n⚠️  Some new images are not being used")
    if not no_old_used:
        print("\n❌ Some old images are still being referenced")

print("\n" + "=" * 80)
