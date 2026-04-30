# Bug Condition Exploration Test

## Purpose

This test explores the bug condition BEFORE implementing the fix. The test is expected to FAIL on unfixed code, which confirms the bug exists. After the fix is implemented, this same test should PASS, confirming the bug is resolved.

## Bug Condition

The bug manifests when an administrator attempts to save country ID 78 (Saudi Arabia) and encounters various failure scenarios (session timeout, CSRF mismatch, validation errors, database errors). Instead of receiving specific error messages, the user receives a generic "Failed to save country" error.

## Test Scenarios

### Scenario 1: Session Timeout

**Setup:**
1. User logs into admin panel at https://hexatp.com/admin/login.php
2. User navigates to edit page for country ID 78: https://hexatp.com/admin/country_edit.php?id=78
3. User makes edits to the country data
4. User waits 31 minutes (session timeout is 30 minutes)
5. User clicks "Save & Publish" button

**Expected Behavior (After Fix):**
- HTTP Status: 401 Unauthorized
- Response JSON: `{"success": false, "error": "Authentication required"}`
- Frontend displays: "Session expired. Please log in again."
- User is redirected to login page

**Actual Behavior (Before Fix):**
- HTTP Status: Unknown (likely 400 or 500)
- Response JSON: `{"success": false, "error": "Failed to save country"}` OR `{"success": false, "errors": {...}}`
- Frontend displays: "Error: Failed to save country"
- User is NOT redirected to login page

**Test Result:** ❌ FAIL (Expected - confirms bug exists)

---

### Scenario 2: CSRF Token Mismatch

**Setup:**
1. User logs into admin panel
2. User navigates to edit page for country ID 78
3. User opens browser developer tools
4. User modifies the CSRF token in the hidden form field to an invalid value
5. User makes edits to the country data
6. User clicks "Save & Publish" button

**Expected Behavior (After Fix):**
- HTTP Status: 403 Forbidden
- Response JSON: `{"success": false, "error": "Invalid CSRF token"}`
- Frontend displays: "Invalid security token. Please refresh the page and try again."

**Actual Behavior (Before Fix):**
- HTTP Status: Unknown (likely 400 or 500)
- Response JSON: `{"success": false, "error": "Failed to save country"}` OR `{"success": false, "errors": {...}}`
- Frontend displays: "Error: Failed to save country"

**Test Result:** ❌ FAIL (Expected - confirms bug exists)

---

### Scenario 3: Validation Error - Hero Title Exceeds Limit

**Setup:**
1. User logs into admin panel
2. User navigates to edit page for country ID 78
3. User enters a hero_title with 150 characters (exceeds 100 character limit)
4. User clicks "Save & Publish" button

**Expected Behavior (After Fix):**
- HTTP Status: 400 Bad Request
- Response JSON: `{"success": false, "errors": {"hero_title": "Title must not exceed 100 characters (current: 150)"}}`
- Frontend displays field-specific error: "Title must not exceed 100 characters (current: 150)" next to the hero_title field

**Actual Behavior (Before Fix):**
- HTTP Status: 400 Bad Request
- Response JSON: `{"success": false, "errors": {"hero_title": "Title must not exceed 100 characters (current: 150)"}}` (validation might work)
- Frontend displays: "Error: Failed to save country" OR validation error might be shown correctly

**Test Result:** ⚠️ UNKNOWN (Need to test - validation might already work correctly)

---

### Scenario 4: Validation Error - Hero Description Exceeds Limit

**Setup:**
1. User logs into admin panel
2. User navigates to edit page for country ID 78
3. User enters a hero_description with 600 characters (exceeds 500 character limit)
4. User clicks "Save & Publish" button

**Expected Behavior (After Fix):**
- HTTP Status: 400 Bad Request
- Response JSON: `{"success": false, "errors": {"hero_description": "Description must not exceed 500 characters (current: 600)"}}`
- Frontend displays field-specific error: "Description must not exceed 500 characters (current: 600)" next to the hero_description field

**Actual Behavior (Before Fix):**
- HTTP Status: 400 Bad Request
- Response JSON: `{"success": false, "errors": {"hero_description": "Description must not exceed 500 characters (current: 600)"}}` (validation might work)
- Frontend displays: "Error: Failed to save country" OR validation error might be shown correctly

**Test Result:** ⚠️ UNKNOWN (Need to test - validation might already work correctly)

---

### Scenario 5: Database Error - Duplicate Country Name

**Setup:**
1. User logs into admin panel
2. User navigates to edit page for country ID 78
3. User changes the country_name to "Australia" (which already exists as another country)
4. User clicks "Save & Publish" button

**Expected Behavior (After Fix):**
- HTTP Status: 400 Bad Request
- Response JSON: `{"success": false, "errors": {"country_name": "A country with this name already exists"}}`
- Frontend displays field-specific error: "A country with this name already exists" next to the country_name field

**Actual Behavior (Before Fix):**
- HTTP Status: 400 Bad Request
- Response JSON: `{"success": false, "errors": {"country_name": "A country with this name already exists"}}` (might work)
- Frontend displays: "Error: Failed to save country" OR validation error might be shown correctly

**Test Result:** ⚠️ UNKNOWN (Need to test - duplicate check might already work correctly)

---

## Manual Testing Instructions

Since this is a PHP application without automated test infrastructure, we'll perform manual testing:

### Prerequisites
1. Access to https://hexatp.com/admin/
2. Login credentials: username `nayeshai_nayesha_healthcare`, password `nayesha1234`
3. Browser with developer tools (Chrome, Firefox, etc.)

### Test Execution Steps

#### Test 1: Session Timeout
1. Log into admin panel
2. Navigate to https://hexatp.com/admin/country_edit.php?id=78
3. Open browser developer tools → Network tab
4. Make a small edit (e.g., add a space to hero_title)
5. Wait 31 minutes OR manually delete session cookie to simulate timeout
6. Click "Save & Publish"
7. Observe Network tab for API request to `/api/country.php?id=78`
8. Record HTTP status code and response JSON
9. Observe frontend error message displayed to user

**Expected Result (Unfixed):** Generic "Failed to save country" error
**Expected Result (Fixed):** 401 error with "Authentication required" and redirect to login

---

#### Test 2: CSRF Token Mismatch
1. Log into admin panel
2. Navigate to https://hexatp.com/admin/country_edit.php?id=78
3. Open browser developer tools → Elements/Inspector tab
4. Find the hidden input field: `<input type="hidden" name="csrf_token" value="...">`
5. Change the value to something invalid (e.g., "invalid_token_12345")
6. Open Network tab
7. Make a small edit (e.g., add a space to hero_title)
8. Click "Save & Publish"
9. Observe Network tab for API request to `/api/country.php?id=78`
10. Record HTTP status code and response JSON
11. Observe frontend error message displayed to user

**Expected Result (Unfixed):** Generic "Failed to save country" error
**Expected Result (Fixed):** 403 error with "Invalid CSRF token"

---

#### Test 3: Validation Error - Hero Title Exceeds Limit
1. Log into admin panel
2. Navigate to https://hexatp.com/admin/country_edit.php?id=78
3. Open browser developer tools → Network tab
4. In the "Hero Title" field, enter exactly 150 characters:
   ```
   This is a very long hero title that exceeds the maximum allowed length of 100 characters and should trigger a validation error when saving
   ```
5. Click "Save & Publish"
6. Observe Network tab for API request to `/api/country.php?id=78`
7. Record HTTP status code and response JSON
8. Observe frontend error message displayed to user

**Expected Result (Unfixed):** Might show validation error OR generic "Failed to save country" error
**Expected Result (Fixed):** 400 error with specific field error message displayed next to hero_title field

---

#### Test 4: Validation Error - Hero Description Exceeds Limit
1. Log into admin panel
2. Navigate to https://hexatp.com/admin/country_edit.php?id=78
3. Open browser developer tools → Network tab
4. In the "Hero Description" field, enter exactly 600 characters (copy-paste a long paragraph)
5. Click "Save & Publish"
6. Observe Network tab for API request to `/api/country.php?id=78`
7. Record HTTP status code and response JSON
8. Observe frontend error message displayed to user

**Expected Result (Unfixed):** Might show validation error OR generic "Failed to save country" error
**Expected Result (Fixed):** 400 error with specific field error message displayed next to hero_description field

---

## Test Results Documentation

### Test Run: [Date/Time]

| Scenario | HTTP Status | Response JSON | Frontend Message | Result |
|----------|-------------|---------------|------------------|--------|
| Session Timeout | | | | |
| CSRF Mismatch | | | | |
| Hero Title > 100 chars | | | | |
| Hero Description > 500 chars | | | | |
| Duplicate Country Name | | | | |

### Counterexamples Found

Document any counterexamples that demonstrate the bug:

1. **Session Timeout:**
   - Observed behavior: 
   - Root cause analysis:

2. **CSRF Token Mismatch:**
   - Observed behavior:
   - Root cause analysis:

3. **Validation Errors:**
   - Observed behavior:
   - Root cause analysis:

### Root Cause Confirmation

Based on the test results, confirm or refute the hypothesized root causes from the design document:

- [ ] Session timeout between page load and save
- [ ] CSRF token validation failure
- [ ] Field validation errors not surfaced properly
- [ ] Database errors not reported clearly
- [ ] JavaScript error handling issues

### Next Steps

After documenting the test results:
1. If tests confirm the bug exists (generic error messages), proceed to Task 2 (Preservation Tests)
2. If tests show unexpected behavior, update the root cause analysis in the design document
3. Use the counterexamples to guide the fix implementation in Task 3
