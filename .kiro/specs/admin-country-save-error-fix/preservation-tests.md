# Preservation Property Tests

## Purpose

These tests verify that the fix for country ID 78 does NOT break existing functionality for other countries and create operations. These tests should PASS on both unfixed and fixed code, confirming that we preserve existing behavior.

## Preservation Requirements

From the design document, we must preserve:
1. Saving other countries (not ID 78) with valid data continues to work
2. Creating new countries with valid data continues to work
3. Field validation for all countries continues to enforce the same length limits
4. Revision tracking for changed fields continues to work
5. Transaction rollback on errors continues to work

## Property-Based Test Approach

Property-based testing generates many test cases automatically to provide stronger guarantees than manual unit tests. For each property, we define:
- **Input domain**: The range of valid inputs to test
- **Property**: The invariant that must hold for all inputs
- **Expected outcome**: Tests should PASS on unfixed code (baseline behavior)

---

## Property 1: Non-Country-78 Save Operations Succeed

**Property Statement:**
For all country IDs != 78, with valid session, valid CSRF token, and valid country data, the save operation succeeds with HTTP 200 response and success message.

**Input Domain:**
- Country IDs: 1-77, 79-200 (excluding 78)
- Valid session: User logged in, session not expired
- Valid CSRF token: Token matches session token
- Valid country data: All required fields present, all fields within length limits

**Test Cases (Sample):**

### Test Case 1: Save Country ID 1 (Australia)
1. Log into admin panel
2. Navigate to https://hexatp.com/admin/country_edit.php?id=1
3. Make a small edit (e.g., add a space to hero_title)
4. Click "Save & Publish"
5. Verify HTTP 200 response
6. Verify response JSON: `{"success": true, "message": "Country updated successfully"}`
7. Verify frontend displays success message
8. Verify country data is updated in database

**Expected Result:** ✅ PASS (on both unfixed and fixed code)

---

### Test Case 2: Save Country ID 50 (Random Country)
1. Log into admin panel
2. Navigate to https://hexatp.com/admin/country_edit.php?id=50
3. Make a small edit
4. Click "Save & Publish"
5. Verify HTTP 200 response
6. Verify success message

**Expected Result:** ✅ PASS (on both unfixed and fixed code)

---

### Test Case 3: Save Country ID 100 (Random Country)
1. Log into admin panel
2. Navigate to https://hexatp.com/admin/country_edit.php?id=100
3. Make a small edit
4. Click "Save & Publish"
5. Verify HTTP 200 response
6. Verify success message

**Expected Result:** ✅ PASS (on both unfixed and fixed code)

---

## Property 2: Create Country Operations Succeed

**Property Statement:**
For all new country data with valid session, valid CSRF token, and valid fields, the create operation succeeds with HTTP 201 response and returns the new country ID.

**Input Domain:**
- Valid session: User logged in, session not expired
- Valid CSRF token: Token matches session token
- Valid country data: Unique country_name, unique country_code, all fields within length limits

**Test Cases (Sample):**

### Test Case 1: Create New Country "Test Country 1"
1. Log into admin panel
2. Navigate to https://hexatp.com/admin/country_edit.php?action=create
3. Enter country_name: "Test Country 1"
4. Enter country_code: "TC1"
5. Enter hero_title: "Test Hero Title"
6. Enter hero_description: "Test hero description"
7. Click "Save & Publish"
8. Verify HTTP 201 response
9. Verify response JSON: `{"success": true, "message": "Country created successfully", "data": {"id": <new_id>}}`
10. Verify frontend displays success message
11. Verify new country appears in countries list

**Expected Result:** ✅ PASS (on both unfixed and fixed code)

---

## Property 3: Field Validation Enforces Length Limits

**Property Statement:**
For all countries (including ID 78), when field values exceed length limits, validation errors are returned with specific field names and error messages.

**Input Domain:**
- Country IDs: 1-200 (including 78)
- Invalid field values: hero_title > 100 chars, hero_description > 500 chars, meta_title > 255 chars, meta_description > 500 chars

**Test Cases (Sample):**

### Test Case 1: Hero Title Exceeds Limit (Country ID 1)
1. Log into admin panel
2. Navigate to https://hexatp.com/admin/country_edit.php?id=1
3. Enter hero_title with 150 characters
4. Click "Save & Publish"
5. Verify HTTP 400 response
6. Verify response JSON contains: `{"success": false, "errors": {"hero_title": "Title must not exceed 100 characters (current: 150)"}}`
7. Verify frontend displays field-specific error

**Expected Result:** ✅ PASS (on both unfixed and fixed code)

---

### Test Case 2: Hero Description Exceeds Limit (Country ID 50)
1. Log into admin panel
2. Navigate to https://hexatp.com/admin/country_edit.php?id=50
3. Enter hero_description with 600 characters
4. Click "Save & Publish"
5. Verify HTTP 400 response
6. Verify response JSON contains validation error for hero_description
7. Verify frontend displays field-specific error

**Expected Result:** ✅ PASS (on both unfixed and fixed code)

---

## Property 4: Revision Tracking Creates Records

**Property Statement:**
For all successful save operations, revision records are created for changed fields with old value, new value, and user ID.

**Input Domain:**
- Country IDs: 1-200 (excluding 78 for now)
- Valid session: User logged in
- Changed fields: Any field that differs from current value

**Test Cases (Sample):**

### Test Case 1: Update Hero Title Creates Revision
1. Log into admin panel
2. Navigate to https://hexatp.com/admin/country_edit.php?id=1
3. Note current hero_title value
4. Change hero_title to a new value
5. Click "Save & Publish"
6. Verify HTTP 200 response
7. Query database for revision records:
   ```sql
   SELECT * FROM revisions 
   WHERE entity_type = 'country' 
   AND entity_id = 1 
   AND field_name = 'hero_title'
   ORDER BY created_at DESC 
   LIMIT 1
   ```
8. Verify revision record exists with:
   - old_value = previous hero_title
   - new_value = new hero_title
   - user_id = current user ID

**Expected Result:** ✅ PASS (on both unfixed and fixed code)

---

## Property 5: Transaction Rollback on Errors

**Property Statement:**
For all save operations that encounter database errors, the transaction is rolled back and no partial data is saved.

**Input Domain:**
- Country IDs: 1-200 (excluding 78 for now)
- Error conditions: Duplicate country_name, database connection failure, constraint violations

**Test Cases (Sample):**

### Test Case 1: Duplicate Country Name Rolls Back
1. Log into admin panel
2. Navigate to https://hexatp.com/admin/country_edit.php?id=1
3. Change country_name to "Canada" (which already exists as another country)
4. Click "Save & Publish"
5. Verify HTTP 400 response
6. Verify response JSON: `{"success": false, "errors": {"country_name": "A country with this name already exists"}}`
7. Query database to verify country ID 1 still has original country_name (not "Canada")
8. Verify no revision records were created for this failed save

**Expected Result:** ✅ PASS (on both unfixed and fixed code)

---

## Manual Testing Instructions

Since this is a PHP application without automated test infrastructure, we'll perform manual testing to observe baseline behavior on unfixed code.

### Prerequisites
1. Access to https://hexatp.com/admin/
2. Login credentials: username `nayeshai_nayesha_healthcare`, password `nayesha1234`
3. Browser with developer tools
4. Database access to verify revision records (optional)

### Test Execution Steps

#### Property 1: Non-Country-78 Save Operations

**Test 1.1: Save Country ID 1**
1. Log into admin panel
2. Navigate to https://hexatp.com/admin/country_edit.php?id=1
3. Open browser developer tools → Network tab
4. Make a small edit (e.g., add a space to hero_title)
5. Click "Save & Publish"
6. Observe Network tab for API request to `/api/country.php?id=1`
7. Record HTTP status code and response JSON
8. Verify success message displayed

**Expected:** HTTP 200, success response, data saved

---

**Test 1.2: Save Country ID 77**
1. Log into admin panel
2. Navigate to https://hexatp.com/admin/country_edit.php?id=77
3. Make a small edit
4. Click "Save & Publish"
5. Verify HTTP 200 response

**Expected:** HTTP 200, success response, data saved

---

**Test 1.3: Save Country ID 79**
1. Log into admin panel
2. Navigate to https://hexatp.com/admin/country_edit.php?id=79
3. Make a small edit
4. Click "Save & Publish"
5. Verify HTTP 200 response

**Expected:** HTTP 200, success response, data saved

---

#### Property 2: Create Country Operations

**Test 2.1: Create New Country**
1. Log into admin panel
2. Navigate to https://hexatp.com/admin/country_edit.php?action=create
3. Enter country_name: "Test Country Preservation"
4. Enter country_code: "TCP"
5. Enter hero_title: "Test Hero"
6. Enter hero_description: "Test description"
7. Click "Save & Publish"
8. Verify HTTP 201 response
9. Verify new country appears in list

**Expected:** HTTP 201, success response, country created

---

#### Property 3: Field Validation

**Test 3.1: Hero Title Exceeds Limit (Country ID 1)**
1. Log into admin panel
2. Navigate to https://hexatp.com/admin/country_edit.php?id=1
3. Enter hero_title with 150 characters
4. Click "Save & Publish"
5. Verify HTTP 400 response
6. Verify validation error message

**Expected:** HTTP 400, validation error for hero_title

---

**Test 3.2: Hero Description Exceeds Limit (Country ID 1)**
1. Log into admin panel
2. Navigate to https://hexatp.com/admin/country_edit.php?id=1
3. Enter hero_description with 600 characters
4. Click "Save & Publish"
5. Verify HTTP 400 response
6. Verify validation error message

**Expected:** HTTP 400, validation error for hero_description

---

#### Property 4: Revision Tracking

**Test 4.1: Update Creates Revision**
1. Log into admin panel
2. Navigate to https://hexatp.com/admin/country_edit.php?id=1
3. Note current hero_title value
4. Change hero_title to a new value
5. Click "Save & Publish"
6. Verify HTTP 200 response
7. (Optional) Query database for revision record

**Expected:** HTTP 200, revision record created

---

#### Property 5: Transaction Rollback

**Test 5.1: Duplicate Country Name**
1. Log into admin panel
2. Navigate to https://hexatp.com/admin/country_edit.php?id=1
3. Change country_name to "Canada" (existing country)
4. Click "Save & Publish"
5. Verify HTTP 400 response
6. Verify error message about duplicate name
7. Verify country ID 1 still has original name

**Expected:** HTTP 400, duplicate error, no data changed

---

## Test Results Documentation

### Test Run: [Date/Time] - UNFIXED CODE

| Property | Test Case | HTTP Status | Response | Result |
|----------|-----------|-------------|----------|--------|
| P1: Non-78 Save | Country ID 1 | | | |
| P1: Non-78 Save | Country ID 77 | | | |
| P1: Non-78 Save | Country ID 79 | | | |
| P2: Create | New Country | | | |
| P3: Validation | Hero Title > 100 | | | |
| P3: Validation | Hero Desc > 500 | | | |
| P4: Revisions | Update Hero Title | | | |
| P5: Rollback | Duplicate Name | | | |

### Baseline Behavior Observations

Document the observed behavior on unfixed code:

1. **Non-Country-78 Save Operations:**
   - Observed behavior:
   - Expected to preserve: This exact behavior after fix

2. **Create Country Operations:**
   - Observed behavior:
   - Expected to preserve: This exact behavior after fix

3. **Field Validation:**
   - Observed behavior:
   - Expected to preserve: This exact behavior after fix

4. **Revision Tracking:**
   - Observed behavior:
   - Expected to preserve: This exact behavior after fix

5. **Transaction Rollback:**
   - Observed behavior:
   - Expected to preserve: This exact behavior after fix

### Next Steps

After documenting baseline behavior:
1. Proceed to Task 3 (Implement Fix)
2. After fix is implemented, re-run these same tests
3. Verify all tests still PASS (confirms preservation)
4. If any test FAILS after fix, investigate regression
