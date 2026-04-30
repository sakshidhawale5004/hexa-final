# Implementation Plan

## Overview

This task list implements the fix for the "Failed to save country" error in the admin panel using the bug condition methodology. The workflow follows:
1. **Explore** - Write tests BEFORE fix to understand the bug (Bug Condition)
2. **Preserve** - Write tests for non-buggy behavior (Preservation Requirements)
3. **Implement** - Apply the fix with understanding (Expected Behavior)
4. **Validate** - Verify fix works and doesn't break anything

## Tasks

- [x] 1. Write bug condition exploration test
  - **Property 1: Bug Condition** - Country Save Error Scenarios
  - **CRITICAL**: This test MUST FAIL on unfixed code - failure confirms the bug exists
  - **DO NOT attempt to fix the test or the code when it fails**
  - **NOTE**: This test encodes the expected behavior - it will validate the fix when it passes after implementation
  - **GOAL**: Surface counterexamples that demonstrate the bug exists
  - **Scoped PBT Approach**: Test country ID 78 (Saudi Arabia) with various failure scenarios
  - Test implementation details from Bug Condition in design:
    - Session timeout scenario: Load edit page, expire session (wait 31 minutes or manually expire), attempt save
    - CSRF token mismatch scenario: Load edit page, modify CSRF token, attempt save
    - Validation error scenario: Load edit page, enter hero_title with 150 characters (exceeds 100 limit), attempt save
    - Database error scenario: Simulate database connection failure or constraint violation, attempt save
  - The test assertions should match the Expected Behavior Properties from design:
    - Session timeout should return 401 with "Authentication required" message
    - CSRF mismatch should return 403 with "Invalid CSRF token" message
    - Validation error should return 400 with specific field error messages (field name, current length, max length)
    - Database error should return 400 with descriptive error message
  - Run test on UNFIXED code
  - **EXPECTED OUTCOME**: Test FAILS (this is correct - it proves the bug exists)
  - Document counterexamples found to understand root cause:
    - Which scenarios return generic "Failed to save country" error instead of specific error messages?
    - Are error responses properly propagated from backend to frontend?
    - Does JavaScript handle different HTTP status codes correctly?
  - Mark task complete when test is written, run, and failure is documented
  - _Requirements: 1.1, 1.2, 1.3, 1.4_

- [x] 2. Write preservation property tests (BEFORE implementing fix)
  - **Property 2: Preservation** - Non-Country-78 Save Operations
  - **IMPORTANT**: Follow observation-first methodology
  - Observe behavior on UNFIXED code for non-buggy inputs:
    - Save other countries (IDs 1-77, 79+) with valid data
    - Create new countries with valid data
    - Verify field validation enforces same limits for all countries
    - Verify revision tracking creates records for changed fields
    - Verify transaction rollback on errors
  - Write property-based tests capturing observed behavior patterns from Preservation Requirements:
    - For all country IDs != 78 with valid session, CSRF, and data: save succeeds with 200 response
    - For all create operations with valid data: country is created with 201 response
    - For all countries with field values exceeding limits: validation errors are returned
    - For all successful saves: revision records are created for changed fields
  - Property-based testing generates many test cases for stronger guarantees
  - Run tests on UNFIXED code
  - **EXPECTED OUTCOME**: Tests PASS (this confirms baseline behavior to preserve)
  - Mark task complete when tests are written, run, and passing on unfixed code
  - _Requirements: 3.1, 3.2, 3.3, 3.4, 3.5, 3.6_

- [x] 3. Fix for "Failed to save country" error

  - [x] 3.1 Enhance error response handling in API endpoint
    - File: `hexatp-main/api/country.php`
    - Function: `handleUpdateCountry`
    - Ensure all error conditions return specific error messages in consistent JSON format
    - Session validation: When `checkSession()` returns false, return 401 with "Authentication required"
    - CSRF validation: When `verifyCsrfToken()` returns false, return 403 with "Invalid CSRF token" and log for security monitoring
    - Validation errors: Ensure errors from `Country::validate()` are included in 400 response with field-specific messages
    - Database errors: Catch exceptions, log for debugging, return 400 with descriptive error messages
    - _Bug_Condition: isBugCondition(input) where input.country_id == 78 AND (sessionExpired OR csrfTokenInvalid OR fieldValidationFails OR databaseErrorOccurs)_
    - _Expected_Behavior: specificErrorReturned(result) AND errorMessageMatchesFailureReason(result, input) from design_
    - _Preservation: Non-country-78 save operations continue to work as before_
    - _Requirements: 2.1, 2.2, 2.3, 2.4, 2.5_

  - [x] 3.2 Improve JavaScript error handling in admin panel
    - File: `hexatp-main/admin/country_edit.php`
    - Function: Form submission handler (JavaScript)
    - Update fetch error handling to properly handle different HTTP status codes:
      - 401: Display "Session expired. Please log in again." and redirect to login
      - 403: Display "Invalid security token. Please refresh the page and try again."
      - 400: Parse `errors` object and display field-specific validation errors
      - 500: Display "Server error. Please try again later."
    - Add field-specific error display next to form fields
    - Add session timeout warning at 25 minutes with option to refresh session
    - _Bug_Condition: JavaScript not handling different HTTP status codes properly_
    - _Expected_Behavior: User sees specific error messages for each failure scenario_
    - _Preservation: Successful save operations continue to work as before_
    - _Requirements: 2.1, 2.2, 2.3, 2.4_

  - [x] 3.3 Enhance error context in ContentService
    - File: `hexatp-main/services/ContentService.php`
    - Function: `updateCountry`
    - Ensure validation errors include field name, current length, and maximum allowed length
    - Improve exception handling to distinguish between different database error types
    - Add logging for transaction rollback events
    - _Bug_Condition: Validation errors not providing sufficient context_
    - _Expected_Behavior: Validation errors include field name, current value length, and max length_
    - _Preservation: Validation logic and transaction handling remain unchanged_
    - _Requirements: 2.2, 2.5_

  - [x] 3.4 Add session timeout reason in AuthService
    - File: `hexatp-main/services/AuthService.php`
    - Function: `checkSession`
    - Modify to return more detailed information about session invalidity (timeout vs not logged in)
    - Add logging for CSRF token validation failures
    - _Bug_Condition: Session validation not providing reason for failure_
    - _Expected_Behavior: Session validation returns specific reason (timeout, not logged in, etc.)_
    - _Preservation: Session validation logic remains unchanged_
    - _Requirements: 2.4, 2.3_

  - [x] 3.5 Verify bug condition exploration test now passes
    - **Property 1: Expected Behavior** - Country Save Error Scenarios
    - **IMPORTANT**: Re-run the SAME test from task 1 - do NOT write a new test
    - The test from task 1 encodes the expected behavior
    - When this test passes, it confirms the expected behavior is satisfied
    - Run bug condition exploration test from step 1
    - **EXPECTED OUTCOME**: Test PASSES (confirms bug is fixed)
    - Verify all failure scenarios now return specific error messages:
      - Session timeout returns 401 with "Authentication required"
      - CSRF mismatch returns 403 with "Invalid CSRF token"
      - Validation error returns 400 with field-specific messages
      - Database error returns 400 with descriptive message
    - _Requirements: 2.1, 2.2, 2.3, 2.4, 2.5_

  - [x] 3.6 Verify preservation tests still pass
    - **Property 2: Preservation** - Non-Country-78 Save Operations
    - **IMPORTANT**: Re-run the SAME tests from task 2 - do NOT write new tests
    - Run preservation property tests from step 2
    - **EXPECTED OUTCOME**: Tests PASS (confirms no regressions)
    - Confirm all tests still pass after fix:
      - Other countries save successfully with valid data
      - Create operations work correctly
      - Field validation enforces same limits
      - Revision tracking creates records for changed fields
      - Transaction rollback works on errors
    - _Requirements: 3.1, 3.2, 3.3, 3.4, 3.5, 3.6_

- [x] 4. Checkpoint - Ensure all tests pass
  - Run all bug condition exploration tests - should PASS
  - Run all preservation property tests - should PASS
  - Manually test country ID 78 save operation with valid data - should succeed
  - Manually test session timeout scenario - should return 401 with specific message
  - Manually test CSRF mismatch scenario - should return 403 with specific message
  - Manually test validation error scenario - should return 400 with field-specific messages
  - Ensure all tests pass, ask the user if questions arise

## Notes

- **Bug Condition Methodology**: This workflow uses C(X) to identify buggy inputs (country ID 78 with various failure scenarios), P(result) to define expected behavior (specific error messages), and ¬C(X) to preserve non-buggy behavior (other countries and create operations).

- **Property-Based Testing**: Tasks 1 and 2 use property-based testing to generate many test cases automatically, providing stronger guarantees than manual unit tests.

- **Observation-First**: Task 2 follows observation-first methodology - observe behavior on unfixed code first, then write tests capturing that behavior.

- **Test Ordering**: Exploration test (Task 1) and preservation tests (Task 2) MUST be written and run BEFORE implementing the fix (Task 3). This ensures we understand the bug and baseline behavior before making changes.
