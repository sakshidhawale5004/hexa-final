# Task 3.4: Preservation Test Instructions (FIXED CODE)

## Overview

This document provides instructions for running the preservation tests on the FIXED code to verify that desktop/tablet logo display remains unchanged after implementing the mobile logo fix.

## Test File

**File:** `preservation-test-fixed.html`  
**Location:** `hexatp-main/.kiro/specs/mobile-header-logo-fix/preservation-test-fixed.html`

## Test Objective

Verify that the image-based logo implementation preserves desktop/tablet behavior:
- Logo displays correctly on desktop viewports (1920px, 1440px, 1024px)
- Logo displays correctly on tablet edge case (768px)
- Header layout remains unchanged
- Navigation menu remains unchanged
- CTA button remains unchanged

## How to Run the Tests

### Step 1: Open the Test File
1. Navigate to: `hexatp-main/.kiro/specs/mobile-header-logo-fix/preservation-test-fixed.html`
2. Open the file in a web browser (Chrome, Firefox, Safari, or Edge)

### Step 2: Test Desktop Viewports
1. Open browser DevTools (F12 or Right-click → Inspect)
2. Click the "Toggle Device Toolbar" icon (or press Ctrl+Shift+M / Cmd+Shift+M)
3. Set viewport to **1920px × 1080px** (Desktop)
   - Verify all 5 test cases show ✅ PASS
   - Check that logo image displays correctly
4. Set viewport to **1440px × 900px** (Desktop)
   - Verify tests still pass
5. Set viewport to **1024px × 768px** (Tablet)
   - Verify tests still pass

### Step 3: Test Tablet Edge Case
1. Set viewport to **768px × 1024px** (Tablet Edge)
   - Verify logo image displays correctly (may show 30px height due to mobile breakpoint)
   - This is expected behavior at the breakpoint

### Step 4: Review Test Results
1. Scroll to the bottom of the page
2. Check the "Test Summary" section
3. **Expected Result:** 5/5 tests passed (100% success rate)
4. All test result boxes should be green with ✅ PASS status

### Step 5: Compare with Baseline
Compare the FIXED code results with the baseline observations from Task 2:

**Baseline (UNFIXED CODE):**
- Logo: Text-based "HEXATP" with font-size 20px (desktop), 18px (mobile)
- Header layout: Flexbox with space-between
- Navigation: Horizontal flex layout
- CTA button: Yellow background, 10px 25px padding

**Fixed Code (EXPECTED):**
- Logo: Image-based LOGO.jpeg with height 40px (desktop), 30px (mobile)
- Header layout: Flexbox with space-between (UNCHANGED)
- Navigation: Horizontal flex layout (UNCHANGED)
- CTA button: Yellow background, 10px 25px padding (UNCHANGED)

## Expected Test Results

### Test Case 1: Desktop (1920px) - Logo Display
**Expected:** ✅ PASS  
**Reason:** Logo image displays with height 40px, correct alt text, and proper source

### Test Case 2: Desktop (1440px) - Logo Display
**Expected:** ✅ PASS  
**Reason:** Logo image displays with same styling as 1920px

### Test Case 3: Tablet (1024px) - Logo Display
**Expected:** ✅ PASS  
**Reason:** Logo image displays with desktop styling (40px height)

### Test Case 4: Tablet Edge (768px) - Logo Display
**Expected:** ✅ PASS  
**Reason:** Logo image displays (height may be 30px due to mobile breakpoint)

### Test Case 5: Header Layout Preservation
**Expected:** ✅ PASS  
**Reason:** Header uses flexbox with space-between, navigation and CTA button positioned correctly

## Verification Checklist

After running the tests, verify the following:

- [ ] Logo image loads successfully (LOGO.jpeg)
- [ ] Logo image has correct dimensions (40px height on desktop, 30px on mobile)
- [ ] Logo image has correct alt text: "HexaTP - Transfer Pricing Simplified"
- [ ] Logo image has correct source path
- [ ] Header layout remains unchanged (flexbox properties preserved)
- [ ] Navigation menu continues to display horizontally on desktop/tablet
- [ ] CTA button position and styling remain unchanged
- [ ] All spacing, padding, and alignment values match baseline measurements
- [ ] No visual regressions detected across 1920px, 1440px, 1024px, 768px viewports

## Success Criteria

✅ **Task 3.4 Complete When:**
1. Preservation test file for fixed code created (`preservation-test-fixed.html`)
2. Tests run on FIXED code
3. All 5 tests PASS (100% success rate)
4. Desktop/tablet logo display confirmed working correctly with image-based logo
5. Header layout, navigation, and CTA button confirmed unchanged
6. No regressions detected

## Troubleshooting

### Issue: Logo image not loading
**Possible Causes:**
- Image path is incorrect
- LOGO.jpeg file not found

**Solution:**
- Verify LOGO.jpeg exists in hexatp-main/ directory
- Check image path in test file: `../../../LOGO.jpeg`

### Issue: Logo image too large or too small
**Possible Causes:**
- CSS not applied correctly
- Viewport size incorrect

**Solution:**
- Verify `.logo-img` CSS is present
- Check viewport width in DevTools
- Ensure media query applies at 768px breakpoint

### Issue: Header layout appears broken
**Possible Causes:**
- Flexbox properties not applied
- CSS conflict

**Solution:**
- Check browser console for CSS errors
- Verify header has `display: flex` and `justify-content: space-between`

## Next Steps

After completing Task 3.4:
1. Document test results
2. Proceed to Task 4: Checkpoint - Ensure all tests pass
3. Verify all 24 HTML pages display logo correctly on mobile and desktop
