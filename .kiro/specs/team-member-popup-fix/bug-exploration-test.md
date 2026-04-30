# Bug Condition Exploration Test

**Purpose**: Surface counterexamples that demonstrate the team member modal popup bug BEFORE implementing the fix.

**CRITICAL**: This test MUST FAIL on unfixed code - failure confirms the bug exists.

**Test Date**: 2026-04-28

---

## Test Methodology

This is a manual exploratory test to be performed in a web browser. Each test case verifies whether clicking a "Learn More" button displays the expected modal popup.

### Test Environment
- Browser: Chrome/Firefox/Safari/Edge
- Test Server: Local or production (https://hexatp.com)
- Developer Console: Open to observe JavaScript errors

---

## Test Cases

### Category 1: ID Mismatch Tests (6 pages)

#### Test 1.1: Thailand - Gyan Button
- **Page**: thailand.html
- **Action**: Click "Learn More" button on Gyan Prakash Srivastava's card
- **Button Target**: `data-bs-target="#modalGyan"` (line 1033)
- **Actual Modal ID**: `id="modalGyanTH"` (line 1053)
- **Bug Condition**: Button target `#modalGyan` does NOT match modal ID `modalGyanTH`
- **Expected Result (Unfixed)**: ❌ Modal does NOT appear
- **Expected Result (Fixed)**: ✅ Modal appears with Gyan's information
- **Actual Result (Unfixed)**: _[TO BE FILLED DURING TEST]_
- **Console Errors**: _[TO BE FILLED DURING TEST]_

#### Test 1.2: Thailand - Priyanka Button
- **Page**: thailand.html
- **Action**: Click "Learn More" button on Priyanka Sondhi's card
- **Button Target**: `data-bs-target="#modalPriyanka"` (line 1045)
- **Actual Modal ID**: `id="modalPriyankaTH"` (line 1085)
- **Bug Condition**: Button target `#modalPriyanka` does NOT match modal ID `modalPriyankaTH`
- **Expected Result (Unfixed)**: ❌ Modal does NOT appear
- **Expected Result (Fixed)**: ✅ Modal appears with Priyanka's information
- **Actual Result (Unfixed)**: _[TO BE FILLED DURING TEST]_
- **Console Errors**: _[TO BE FILLED DURING TEST]_

#### Test 1.3: US - Gyan Button
- **Page**: us.html
- **Action**: Click "Learn More" button on Gyan Prakash Srivastava's card
- **Button Target**: `data-bs-target="#modalGyan"`
- **Actual Modal ID**: `id="modalGyanUS"`
- **Bug Condition**: Button target `#modalGyan` does NOT match modal ID `modalGyanUS`
- **Expected Result (Unfixed)**: ❌ Modal does NOT appear
- **Expected Result (Fixed)**: ✅ Modal appears with Gyan's information
- **Actual Result (Unfixed)**: _[TO BE FILLED DURING TEST]_

#### Test 1.4: US - Udit Button
- **Page**: us.html
- **Action**: Click "Learn More" button on Udit Gupta's card
- **Button Target**: `data-bs-target="#modalUdit"`
- **Actual Modal ID**: `id="modalUditUS"`
- **Bug Condition**: Button target `#modalUdit` does NOT match modal ID `modalUditUS`
- **Expected Result (Unfixed)**: ❌ Modal does NOT appear
- **Expected Result (Fixed)**: ✅ Modal appears with Udit's information
- **Actual Result (Unfixed)**: _[TO BE FILLED DURING TEST]_

#### Test 1.5: Vietnam - All Buttons
- **Page**: viethnam.html
- **Action**: Click "Learn More" buttons on all team member cards
- **Bug Condition**: Button targets do NOT match country-specific modal IDs (VN suffix)
- **Expected Result (Unfixed)**: ❌ Modals do NOT appear
- **Expected Result (Fixed)**: ✅ Modals appear correctly
- **Actual Result (Unfixed)**: _[TO BE FILLED DURING TEST]_

#### Test 1.6: Indonesia - All Buttons
- **Page**: indonesia.html
- **Action**: Click "Learn More" buttons on all team member cards
- **Bug Condition**: Button targets do NOT match country-specific modal IDs (ID suffix)
- **Expected Result (Unfixed)**: ❌ Modals do NOT appear
- **Expected Result (Fixed)**: ✅ Modals appear correctly
- **Actual Result (Unfixed)**: _[TO BE FILLED DURING TEST]_

#### Test 1.7: Canada - All Buttons
- **Page**: canada.html
- **Action**: Click "Learn More" buttons on all team member cards
- **Bug Condition**: Button targets do NOT match country-specific modal IDs (CA suffix)
- **Expected Result (Unfixed)**: ❌ Modals do NOT appear
- **Expected Result (Fixed)**: ✅ Modals appear correctly
- **Actual Result (Unfixed)**: _[TO BE FILLED DURING TEST]_

#### Test 1.8: Australia - All Buttons
- **Page**: australia.html
- **Action**: Click "Learn More" buttons on all team member cards
- **Bug Condition**: Button targets do NOT match country-specific modal IDs (AU suffix)
- **Expected Result (Unfixed)**: ❌ Modals do NOT appear
- **Expected Result (Fixed)**: ✅ Modals appear correctly
- **Actual Result (Unfixed)**: _[TO BE FILLED DURING TEST]_

---

### Category 2: Missing Modal Tests (2 pages)

#### Test 2.1: Singapore - Gyan Button
- **Page**: singapore.html
- **Action**: Click "Learn More" button on Gyan Prakash Srivastava's card
- **Button Target**: `data-bs-target="#modalGyan"` (line 1036)
- **Modal Exists**: ❌ NO - No modal HTML definition found in file
- **Bug Condition**: Modal HTML definition is completely missing
- **Expected Result (Unfixed)**: ❌ Modal does NOT appear (nothing to display)
- **Expected Result (Fixed)**: ✅ Modal appears with Gyan's information
- **Actual Result (Unfixed)**: _[TO BE FILLED DURING TEST]_
- **Console Errors**: _[TO BE FILLED DURING TEST]_

#### Test 2.2: Malaysia - Gyan Button
- **Page**: malaysia.html
- **Action**: Click "Learn More" button on Gyan Prakash Srivastava's card
- **Button Target**: `data-bs-target="#modalGyan"`
- **Modal Exists**: ❌ NO - No modal HTML definition found in file
- **Bug Condition**: Modal HTML definition is completely missing
- **Expected Result (Unfixed)**: ❌ Modal does NOT appear (nothing to display)
- **Expected Result (Fixed)**: ✅ Modal appears with Gyan's information
- **Actual Result (Unfixed)**: _[TO BE FILLED DURING TEST]_
- **Console Errors**: _[TO BE FILLED DURING TEST]_

---

## Test Execution Instructions

1. **Open each affected page** in a web browser
2. **Open Developer Console** (F12) to observe errors
3. **Locate the team member cards** with "Learn More" buttons
4. **Click each "Learn More" button**
5. **Observe the result**:
   - Does a modal popup appear?
   - If yes, does it show the correct team member information?
   - If no, what happens? (nothing, error, wrong modal?)
6. **Check Developer Console** for JavaScript errors
7. **Document the results** in the "Actual Result (Unfixed)" fields above
8. **Document any console errors** in the "Console Errors" fields

---

## Expected Counterexamples (Bug Confirmation)

If the bug exists as described, we expect to find:

### ID Mismatch Counterexamples:
- **Thailand**: Clicking Gyan's button → No modal appears (Bootstrap cannot find `#modalGyan` because modal has `id="modalGyanTH"`)
- **Thailand**: Clicking Priyanka's button → No modal appears (Bootstrap cannot find `#modalPriyanka` because modal has `id="modalPriyankaTH"`)
- **US**: Clicking Gyan's button → No modal appears (Bootstrap cannot find `#modalGyan` because modal has `id="modalGyanUS"`)
- **US**: Clicking Udit's button → No modal appears (Bootstrap cannot find `#modalUdit` because modal has `id="modalUditUS"`)
- Similar failures on Vietnam, Indonesia, Canada, Australia pages

### Missing Modal Counterexamples:
- **Singapore**: Clicking Gyan's button → No modal appears (no modal HTML exists in the file)
- **Malaysia**: Clicking Gyan's button → No modal appears (no modal HTML exists in the file)

### Possible Console Errors:
- Bootstrap may log warnings about target not found
- No JavaScript errors (this is a configuration issue, not a code error)

---

## Root Cause Confirmation

Based on test results, confirm the root cause:

1. **ID Mismatch**: ✅ Confirmed if buttons reference generic IDs but modals have country-specific IDs
2. **Missing Modals**: ✅ Confirmed if buttons exist but no modal HTML definitions found
3. **Other Issues**: ❌ If different behavior observed, re-analyze root cause

---

## Test Completion Criteria

- [ ] All 10 test cases executed on UNFIXED code
- [ ] Results documented in "Actual Result (Unfixed)" fields
- [ ] Console errors documented (if any)
- [ ] Counterexamples confirm the bug exists
- [ ] Root cause confirmed (ID mismatch + missing modals)

**Test Status**: ⏳ PENDING EXECUTION

**Next Step**: Execute tests on unfixed code, document results, then proceed to Task 2 (Preservation Tests)
