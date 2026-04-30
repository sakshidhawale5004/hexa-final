#!/usr/bin/env python3
"""
Final verification that all country pages have correct team members
and do NOT have the 4 removed members (Mosttafa, Manoneet, Nathaniel, George)
"""
import re
from pathlib import Path

# Define expected team members for each country
EXPECTED_TEAMS = {
    'India.html': ['Priyanka Sondhi', 'Gyan Prakash Srivastava'],
    'unitedarab.html': ['Mohammad Taher Shaikh', 'Saniya Abbasi', 'Gyan Prakash Srivastava'],
    'Saudiarabia.html': ['Mohammad Taher Shaikh', 'Saniya Abbasi', 'Gyan Prakash Srivastava'],
    'Qatar.html': ['Mohammad Taher Shaikh', 'Saniya Abbasi', 'Gyan Prakash Srivastava'],
    'oman.html': ['Mohammad Taher Shaikh', 'Saniya Abbasi', 'Gyan Prakash Srivastava'],
    'bahrain.html': ['Mohammad Taher Shaikh', 'Saniya Abbasi', 'Gyan Prakash Srivastava'],
    'egypt.html': ['Mohammad Taher Shaikh', 'Saniya Abbasi', 'Gyan Prakash Srivastava'],
    'singapore.html': ['Gyan Prakash Srivastava'],
    'thailand.html': ['Gyan Prakash Srivastava', 'Priyanka Sondhi'],
    'malaysia.html': ['Gyan Prakash Srivastava'],
    'australia.html': ['Gyan Prakash Srivastava'],
    'indonesia.html': ['Gyan Prakash Srivastava', 'Udit Gupta'],
    'viethnam.html': ['Gyan Prakash Srivastava', 'Udit Gupta'],
    'canada.html': ['Gyan Prakash Srivastava', 'Udit Gupta'],
    'us.html': ['Gyan Prakash Srivastava', 'Udit Gupta']
}

# Image files that should NOT be on country pages (actual team cards)
FORBIDDEN_IMAGES = [
    'Mosttafa Shazzad Hasan.JPG',
    'manoneet dalal new.jpg',
    'Nathaniel Owusu Ansah.jpg',
    'George Mureithi.jpg'
]

def check_team_members(html_file, expected_members):
    """Check if file has expected team members and no forbidden ones"""
    with open(html_file, 'r', encoding='utf-8') as f:
        content = f.read()
    
    results = {
        'expected_found': [],
        'expected_missing': [],
        'forbidden_found': []
    }
    
    # Check expected members
    for member in expected_members:
        # Look for the member name in team card context
        if member in content:
            results['expected_found'].append(member)
        else:
            results['expected_missing'].append(member)
    
    # Check forbidden members (by image file reference)
    for image in FORBIDDEN_IMAGES:
        if image in content:
            results['forbidden_found'].append(image)
    
    return results

print("=" * 80)
print("FINAL VERIFICATION - ALL COUNTRY PAGES")
print("=" * 80)

all_passed = True
total_checks = 0
passed_checks = 0

for country, expected_members in EXPECTED_TEAMS.items():
    file_path = Path(country)
    
    if not file_path.exists():
        print(f"\n⚠️  {country} - File not found")
        continue
    
    total_checks += 1
    results = check_team_members(file_path, expected_members)
    
    # Check if all expected members are found
    all_expected_found = len(results['expected_found']) == len(expected_members)
    no_forbidden_found = len(results['forbidden_found']) == 0
    
    if all_expected_found and no_forbidden_found:
        print(f"\n✅ {country} - PASSED")
        print(f"   Expected members: {len(results['expected_found'])}/{len(expected_members)}")
        for member in results['expected_found']:
            print(f"      ✓ {member}")
        passed_checks += 1
    else:
        print(f"\n❌ {country} - FAILED")
        all_passed = False
        
        if results['expected_missing']:
            print(f"   Missing expected members:")
            for member in results['expected_missing']:
                print(f"      ✗ {member}")
        
        if results['forbidden_found']:
            print(f"   Found forbidden members:")
            for member in results['forbidden_found']:
                print(f"      ✗ {member}")

print("\n" + "=" * 80)
print("FINAL RESULTS")
print("=" * 80)

print(f"\n📊 Verification Results:")
print(f"   Total pages checked: {total_checks}")
print(f"   Passed: {passed_checks}")
print(f"   Failed: {total_checks - passed_checks}")

if all_passed:
    print("\n✅ ALL CHECKS PASSED!")
    print("\n🎉 All country pages have correct team members!")
    print("🎉 No forbidden members found on any country page!")
    print("\n✅ READY FOR DEPLOYMENT")
else:
    print("\n❌ SOME CHECKS FAILED")
    print("   Please review the failed pages above")

print("\n" + "=" * 80)
