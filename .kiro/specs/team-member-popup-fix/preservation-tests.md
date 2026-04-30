# Preservation Property Tests

**Purpose**: Capture baseline behavior on working country pages BEFORE implementing the fix to ensure no regressions occur.

**IMPORTANT**: Follow observation-first methodology - observe behavior on UNFIXED code, then write tests to preserve that behavior.

**Test Date**: 2026-04-28

---

## Test Methodology

This test suite verifies that existing modal functionality on working country pages remains unchanged after the fix is applied. Tests should PASS on both unfixed and fixed code.

### Test Environment
- Browser: Chrome/Firefox/Safari/Edge
- Test Server: Local or production (https://hexatp.com)
- Developer Console: Open to observe any unexpected errors

---

## Working Country Pages (Baseline)

These pages currently have functioning team member modals:
1. UAE (unitedarab.html)
2. Saudi Arabia (Saudiarabia.html)
3. Qatar (Qatar.html)
4. Oman (oman.html)
5. Bahrain (bahrain.html)
6. Egypt (egypt.html)
7. India (India.html)
8. Bangladesh (bangladesh.html)
9. Kenya (kenya.html)
10. Ghana (ghana.html)
11. Botswana (botswana.html)

---

## Test Cases

### Category 1: Modal Display Preservation

#### Test P1.1: UAE - All Team Member Modals
- **Page**: unitedarab.html
- **Team Members**: Mohammad Taher Shaikh, Saniya Abbasi, Manoneet Dalal, Gyan Prakash Srivastava
- **Action**: Click "Learn More" button on each team member card
- **Expected Behavior (Unfixed)**: ✅ Modal appears for each team member
- **Expected Behavior (Fixed)**: ✅ Modal appears for each team member (SAME)
- **Verification**:
  - Modal displays within 300ms of button click
  - Modal contains team member name, role, photo, description
  - Modal styling matches page design (dark background, accent borders)
- **Actual Result (Unfixed)**: _[TO BE FILLED DURING TEST]_
- **Actual Result (Fixed)**: _[TO BE FILLED AFTER FIX]_

#### Test P1.2: Saudi Arabia - All Team Member Modals
- **Page**: Saudiarabia.html
- **Team Members**: Mohammad Taher Shaikh, Saniya Abbasi, Manoneet Dalal, Gyan Prakash Srivastava
- **Action**: Click "Learn More" button on each team member card
- **Expected Behavior**: ✅ Modals appear correctly (unchanged)
- **Actual Result (Unfixed)**: _[TO BE FILLED DURING TEST]_
- **Actual Result (Fixed)**: _[TO BE FILLED AFTER FIX]_

#### Test P1.3: Qatar - All Team Member Modals
- **Page**: Qatar.html
- **Action**: Click "Learn More" buttons on all team member cards
- **Expected Behavior**: ✅ Modals appear correctly (unchanged)
- **Actual Result (Unfixed)**: _[TO BE FILLED DURING TEST]_

#### Test P1.4: Oman - All Team Member Modals
- **Page**: oman.html
- **Action**: Click "Learn More" buttons on all team member cards
- **Expected Behavior**: ✅ Modals appear correctly (unchanged)
- **Actual Result (Unfixed)**: _[TO BE FILLED DURING TEST]_

#### Test P1.5: Bahrain - All Team Member Modals
- **Page**: bahrain.html
- **Action**: Click "Learn More" buttons on all team member cards
- **Expected Behavior**: ✅ Modals appear correctly (unchanged)
- **Actual Result (Unfixed)**: _[TO BE FILLED DURING TEST]_

#### Test P1.6: Egypt - All Team Member Modals
- **Page**: egypt.html
- **Action**: Click "Learn More" buttons on all team member cards
- **Expected Behavior**: ✅ Modals appear correctly (unchanged)
- **Actual Result (Unfixed)**: _[TO BE FILLED DURING TEST]_

#### Test P1.7: India - All Team Member Modals
- **Page**: India.html
- **Action**: Click "Learn More" buttons on all team member cards
- **Expected Behavior**: ✅ Modals appear correctly (unchanged)
- **Actual Result (Unfixed)**: _[TO BE FILLED DURING TEST]_

#### Test P1.8: Bangladesh - All Team Member Modals
- **Page**: bangladesh.html
- **Action**: Click "Learn More" buttons on all team member cards
- **Expected Behavior**: ✅ Modals appear correctly (unchanged)
- **Actual Result (Unfixed)**: _[TO BE FILLED DURING TEST]_

#### Test P1.9: Kenya - All Team Member Modals
- **Page**: kenya.html
- **Action**: Click "Learn More" buttons on all team member cards
- **Expected Behavior**: ✅ Modals appear correctly (unchanged)
- **Actual Result (Unfixed)**: _[TO BE FILLED DURING TEST]_

#### Test P1.10: Ghana - All Team Member Modals
- **Page**: ghana.html
- **Action**: Click "Learn More" buttons on all team member cards
- **Expected Behavior**: ✅ Modals appear correctly (unchanged)
- **Actual Result (Unfixed)**: _[TO BE FILLED DURING TEST]_

#### Test P1.11: Botswana - All Team Member Modals
- **Page**: botswana.html
- **Action**: Click "Learn More" buttons on all team member cards
- **Expected Behavior**: ✅ Modals appear correctly (unchanged)
- **Actual Result (Unfixed)**: _[TO BE FILLED DURING TEST]_

---

### Category 2: Modal Close Behavior Preservation

#### Test P2.1: Close Button Functionality
- **Pages**: All working country pages
- **Action**: 
  1. Click "Learn More" to open modal
  2. Click the close button (X) in modal header
- **Expected Behavior**: ✅ Modal closes smoothly with fade-out animation
- **Actual Result (Unfixed)**: _[TO BE FILLED DURING TEST]_
- **Actual Result (Fixed)**: _[TO BE FILLED AFTER FIX]_

#### Test P2.2: Backdrop Click Functionality
- **Pages**: All working country pages
- **Action**: 
  1. Click "Learn More" to open modal
  2. Click outside the modal (on the dark backdrop)
- **Expected Behavior**: ✅ Modal closes smoothly with fade-out animation
- **Actual Result (Unfixed)**: _[TO BE FILLED DURING TEST]_
- **Actual Result (Fixed)**: _[TO BE FILLED AFTER FIX]_

#### Test P2.3: ESC Key Functionality
- **Pages**: All working country pages
- **Action**: 
  1. Click "Learn More" to open modal
  2. Press ESC key on keyboard
- **Expected Behavior**: ✅ Modal closes smoothly with fade-out animation
- **Actual Result (Unfixed)**: _[TO BE FILLED DURING TEST]_
- **Actual Result (Fixed)**: _[TO BE FILLED AFTER FIX]_

---

### Category 3: Modal Animation Preservation

#### Test P3.1: Fade-In Animation
- **Pages**: All working country pages
- **Action**: Click "Learn More" button
- **Expected Behavior**: 
  - ✅ Modal fades in smoothly (opacity 0 → 1)
  - ✅ Animation duration ~150-300ms
  - ✅ Backdrop fades in simultaneously
- **Actual Result (Unfixed)**: _[TO BE FILLED DURING TEST]_
- **Actual Result (Fixed)**: _[TO BE FILLED AFTER FIX]_

#### Test P3.2: Fade-Out Animation
- **Pages**: All working country pages
- **Action**: Close modal (any method)
- **Expected Behavior**: 
  - ✅ Modal fades out smoothly (opacity 1 → 0)
  - ✅ Animation duration ~150-300ms
  - ✅ Backdrop fades out simultaneously
- **Actual Result (Unfixed)**: _[TO BE FILLED DURING TEST]_
- **Actual Result (Fixed)**: _[TO BE FILLED AFTER FIX]_

---

### Category 4: Modal Styling Preservation

#### Test P4.1: Visual Consistency
- **Pages**: All working country pages
- **Action**: Open any team member modal
- **Expected Behavior**: 
  - ✅ Dark background (var(--bg-dark))
  - ✅ Accent border (1px solid var(--accent))
  - ✅ Rounded corners (border-radius: 20px)
  - ✅ Team member photo displayed correctly
  - ✅ Text colors match design (white for headings, slate for body)
  - ✅ Accent color (gold/yellow) used for highlights
- **Actual Result (Unfixed)**: _[TO BE FILLED DURING TEST]_
- **Actual Result (Fixed)**: _[TO BE FILLED AFTER FIX]_

---

### Category 5: Other Page Elements Preservation

#### Test P5.1: Navigation Menu
- **Pages**: All working country pages
- **Action**: 
  1. Click navigation menu items
  2. Test dropdown menus
  3. Test mobile navigation (if applicable)
- **Expected Behavior**: ✅ Navigation works correctly (unchanged)
- **Actual Result (Unfixed)**: _[TO BE FILLED DURING TEST]_
- **Actual Result (Fixed)**: _[TO BE FILLED AFTER FIX]_

#### Test P5.2: Contact Forms
- **Pages**: All working country pages
- **Action**: 
  1. Click "Book Free Consultation" button
  2. Fill out contact form
  3. Submit form
- **Expected Behavior**: ✅ Forms work correctly (unchanged)
- **Actual Result (Unfixed)**: _[TO BE FILLED DURING TEST]_
- **Actual Result (Fixed)**: _[TO BE FILLED AFTER FIX]_

#### Test P5.3: Other Buttons and Links
- **Pages**: All working country pages
- **Action**: Click various buttons and links on the page
- **Expected Behavior**: ✅ All buttons and links work correctly (unchanged)
- **Actual Result (Unfixed)**: _[TO BE FILLED DURING TEST]_
- **Actual Result (Fixed)**: _[TO BE FILLED AFTER FIX]_

---

### Category 6: Responsive Behavior Preservation

#### Test P6.1: Desktop View (1920x1080)
- **Pages**: Sample of working country pages (UAE, Saudi Arabia, India)
- **Action**: Open modals at desktop resolution
- **Expected Behavior**: ✅ Modals display correctly at desktop size
- **Actual Result (Unfixed)**: _[TO BE FILLED DURING TEST]_
- **Actual Result (Fixed)**: _[TO BE FILLED AFTER FIX]_

#### Test P6.2: Tablet View (768x1024)
- **Pages**: Sample of working country pages
- **Action**: Open modals at tablet resolution
- **Expected Behavior**: ✅ Modals display correctly at tablet size
- **Actual Result (Unfixed)**: _[TO BE FILLED DURING TEST]_
- **Actual Result (Fixed)**: _[TO BE FILLED AFTER FIX]_

#### Test P6.3: Mobile View (375x667)
- **Pages**: Sample of working country pages
- **Action**: Open modals at mobile resolution
- **Expected Behavior**: ✅ Modals display correctly at mobile size
- **Actual Result (Unfixed)**: _[TO BE FILLED DURING TEST]_
- **Actual Result (Fixed)**: _[TO BE FILLED AFTER FIX]_

---

## Property-Based Test Scenarios

### Scenario PBT1: Random Button Click Sequences
- **Test**: Generate random sequences of "Learn More" button clicks across working pages
- **Property**: For each click, the correct modal should appear
- **Example Sequence**: 
  1. UAE → Taher modal → Close
  2. Saudi Arabia → Gyan modal → Close
  3. UAE → Saniya modal → Close
  4. India → [Team member] modal → Close
- **Expected**: All modals appear correctly in sequence
- **Actual Result (Unfixed)**: _[TO BE FILLED DURING TEST]_
- **Actual Result (Fixed)**: _[TO BE FILLED AFTER FIX]_

### Scenario PBT2: Random Modal Close Actions
- **Test**: Generate random modal close actions (close button, backdrop, ESC)
- **Property**: Modal should close correctly regardless of close method
- **Example Sequence**:
  1. Open modal → Close with button
  2. Open modal → Close with backdrop
  3. Open modal → Close with ESC
  4. Open modal → Close with button
- **Expected**: All close methods work correctly
- **Actual Result (Unfixed)**: _[TO BE FILLED DURING TEST]_
- **Actual Result (Fixed)**: _[TO BE FILLED AFTER FIX]_

### Scenario PBT3: Rapid Button Clicks
- **Test**: Click "Learn More" button multiple times rapidly
- **Property**: Only one modal should open, no duplicate modals or errors
- **Expected**: Modal opens once, subsequent clicks ignored while modal is open
- **Actual Result (Unfixed)**: _[TO BE FILLED DURING TEST]_
- **Actual Result (Fixed)**: _[TO BE FILLED AFTER FIX]_

---

## Test Execution Instructions

### Phase 1: Baseline Observation (UNFIXED Code)
1. **Execute all test cases on UNFIXED code**
2. **Document observed behavior** in "Actual Result (Unfixed)" fields
3. **Confirm all tests PASS** (working pages should work correctly)
4. **Document any unexpected behavior** or edge cases discovered

### Phase 2: Post-Fix Verification (FIXED Code)
1. **Execute all test cases on FIXED code** (after implementing Tasks 3.1-3.8)
2. **Document observed behavior** in "Actual Result (Fixed)" fields
3. **Compare results**: Unfixed vs Fixed should be IDENTICAL for working pages
4. **Confirm all tests still PASS** (no regressions introduced)

---

## Test Completion Criteria

### Phase 1 (Unfixed Code):
- [ ] All test cases executed on UNFIXED code
- [ ] Results documented in "Actual Result (Unfixed)" fields
- [ ] All tests PASS (baseline behavior confirmed)
- [ ] No unexpected errors or issues found

### Phase 2 (Fixed Code):
- [ ] All test cases executed on FIXED code
- [ ] Results documented in "Actual Result (Fixed)" fields
- [ ] All tests still PASS (preservation confirmed)
- [ ] Unfixed and Fixed results are IDENTICAL

**Test Status**: ⏳ PENDING EXECUTION (Phase 1)

**Next Step**: Execute Phase 1 tests on unfixed code to establish baseline, then proceed to Task 3 (Implementation)
