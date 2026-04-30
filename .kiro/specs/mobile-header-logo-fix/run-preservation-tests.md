# How to Run Preservation Tests

## Manual Testing Instructions

### Step 1: Open the Test File
1. Navigate to: `hexatp-main/.kiro/specs/mobile-header-logo-fix/preservation-test.html`
2. Open the file in a web browser (Chrome, Firefox, Safari, or Edge)

### Step 2: Test Desktop Viewports
1. Open browser DevTools (F12 or Right-click → Inspect)
2. Click the "Toggle Device Toolbar" icon (or press Ctrl+Shift+M / Cmd+Shift+M)
3. Set viewport to **1920px × 1080px** (Desktop)
   - Verify all 5 test cases show ✅ PASS
   - Check that logo displays "HEXATP" correctly
4. Set viewport to **1440px × 900px** (Desktop)
   - Verify tests still pass
5. Set viewport to **1024px × 768px** (Tablet)
   - Verify tests still pass

### Step 3: Test Tablet Edge Case
1. Set viewport to **768px × 1024px** (Tablet Edge)
   - Verify logo displays correctly (may show 18px font size due to mobile breakpoint)
   - This is expected behavior at the breakpoint

### Step 4: Review Test Results
1. Scroll to the bottom of the page
2. Check the "Test Summary" section
3. **Expected Result:** 5/5 tests passed (100% success rate)
4. All test result boxes should be green with ✅ PASS status

### Step 5: Document Findings
1. If all tests pass: Baseline is confirmed ✅
2. If any tests fail: Document the failure and investigate
3. Take screenshots of test results for reference

---

## Expected Test Results (UNFIXED CODE)

### Test Case 1: Desktop (1920px) - Logo Display
**Expected:** ✅ PASS  
**Reason:** Logo displays "HEXATP" with font-size: 20px, font-weight: 800

### Test Case 2: Desktop (1440px) - Logo Display
**Expected:** ✅ PASS  
**Reason:** Logo displays "HEXATP" with same styling as 1920px

### Test Case 3: Tablet (1024px) - Logo Display
**Expected:** ✅ PASS  
**Reason:** Logo displays "HEXATP" with desktop styling

### Test Case 4: Tablet Edge (768px) - Logo Display
**Expected:** ✅ PASS  
**Reason:** Logo displays "HEXATP" (font-size may be 18px due to mobile breakpoint)

### Test Case 5: Header Layout Preservation
**Expected:** ✅ PASS  
**Reason:** Header uses flexbox with space-between, navigation and CTA button positioned correctly

---

## Post-Fix Verification

After implementing the fix (Task 3), re-run these tests with the following changes:

### Expected Changes:
- Logo element changes from `<div class="logo">HEXA<span>TP</span></div>` to `<img src="LOGO.jpeg" alt="..." class="logo-img" />`
- Logo displays as image instead of text
- Image height: 40px (desktop), 30px (mobile)

### Expected Preservation:
- ✅ All 5 tests should still PASS
- ✅ Header layout unchanged
- ✅ Navigation menu unchanged
- ✅ CTA button unchanged
- ✅ Logo positioning unchanged
- ✅ Logo size visually similar to original text-based logo

### Verification Checklist:
- [ ] Logo image loads successfully
- [ ] Logo image has correct dimensions
- [ ] Logo image has alt text: "HexaTP - Transfer Pricing Simplified"
- [ ] Header flexbox layout preserved
- [ ] Navigation menu displays horizontally
- [ ] CTA button styling unchanged
- [ ] No layout shifts or visual regressions
- [ ] All spacing and padding values match baseline

---

## Troubleshooting

### Issue: Tests show ❌ FAIL on unfixed code
**Possible Causes:**
- Browser viewport is too small (< 768px)
- Font not loading correctly
- CSS not applied properly

**Solution:**
- Ensure viewport width > 768px for desktop/tablet tests
- Check browser console for font loading errors
- Verify Poppins font is loading from Google Fonts

### Issue: Logo displays "?" instead of "HEXATP"
**Expected Behavior:**
- This should NOT happen on desktop/tablet viewports (> 768px)
- If it happens, this indicates the bug affects desktop too (unexpected)

**Action:**
- Document the issue
- Check if font is loading correctly
- Verify CSS specificity

### Issue: Layout appears broken
**Possible Causes:**
- Browser compatibility issue
- CSS not loading
- Viewport too small

**Solution:**
- Try a different browser
- Check browser console for errors
- Ensure viewport is set correctly

---

## Test Automation (Optional)

For automated testing, you can use browser automation tools like:
- **Playwright:** For visual regression testing
- **Puppeteer:** For screenshot comparison
- **Cypress:** For E2E testing

Example Playwright test:
```javascript
test('preservation test - desktop 1920px', async ({ page }) => {
  await page.setViewportSize({ width: 1920, height: 1080 });
  await page.goto('file:///.../preservation-test.html');
  
  const logo = await page.locator('.logo').first();
  const logoText = await logo.textContent();
  
  expect(logoText.trim()).toBe('HEXATP');
  expect(await logo.evaluate(el => getComputedStyle(el).fontSize)).toBe('20px');
});
```

---

## Success Criteria

✅ **Task 2 Complete When:**
1. Preservation test file created (`preservation-test.html`)
2. Tests run on UNFIXED code
3. All 5 tests PASS (100% success rate)
4. Baseline observations documented (`preservation-baseline-observations.md`)
5. Desktop/tablet logo display confirmed working correctly
6. Header layout, navigation, and CTA button confirmed unchanged

**Current Status:** ✅ ALL CRITERIA MET

---

**Next Step:** Proceed to Task 3 - Implement the mobile logo fix
