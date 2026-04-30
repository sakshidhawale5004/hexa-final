ugfix Requirements Document

## Introduction

The admin login page at hexatp.com/admin/login.php is experiencing an infinite redirect loop (ERR_TOO_MANY_REDIRECTS) that prevents administrators from accessing the CMS. The issue occurs when visiting the login page, which should allow users to authenticate and access the dashboard. Instead, the page enters a redirect loop between login.php and dashboard.php, making the admin panel completely inaccessible.

**Impact**: Critical - The entire admin panel is inaccessible, preventing content management operations.

**Root Cause**: Multiple `session_start()` calls and session state management issues between login.php, dashboard.php, and AuthService.php create a redirect loop where:
1. login.php checks session and redirects to dashboard if logged in
2. dashboard.php checks authentication and redirects to login if not authenticated
3. Session state inconsistencies cause the authentication check to fail even when session data exists
4. The redirect loop continues indefinitely

## Bug Analysis

### Current Behavior (Defect)

1.1 WHEN a user visits /admin/login.php THEN the system enters an infinite redirect loop between login.php and dashboard.php, displaying ERR_TOO_MANY_REDIRECTS

1.2 WHEN login.php calls session_start() and then AuthService methods are invoked THEN session_start() is called multiple times, potentially causing session state corruption

1.3 WHEN dashboard.php calls AuthService->checkSession() after login.php has already started a session THEN session_start() is called again within checkSession(), leading to potential session conflicts

1.4 WHEN the redirect loop occurs THEN the admin panel becomes completely inaccessible, preventing any content management operations

### Expected Behavior (Correct)

2.1 WHEN a user visits /admin/login.php THEN the system SHALL display the login form without any redirect loops

2.2 WHEN login.php needs to check authentication status THEN the system SHALL call session_start() only once and use AuthService methods that do not redundantly call session_start()

2.3 WHEN dashboard.php checks authentication THEN the system SHALL properly validate the session state and only redirect to login.php when the user is genuinely not authenticated

2.4 WHEN a user successfully logs in THEN the system SHALL redirect to dashboard.php exactly once and maintain the authenticated session state

2.5 WHEN session management methods are called THEN the system SHALL check if a session is already active before calling session_start() to prevent multiple session initialization

### Unchanged Behavior (Regression Prevention)

3.1 WHEN a user submits valid credentials on the login form THEN the system SHALL CONTINUE TO authenticate the user and create a session with user_id, username, role, and other session data

3.2 WHEN an unauthenticated user tries to access dashboard.php directly THEN the system SHALL CONTINUE TO redirect them to login.php

3.3 WHEN an authenticated user accesses dashboard.php THEN the system SHALL CONTINUE TO display the dashboard with statistics, quick actions, and navigation menu

3.4 WHEN a user logs out THEN the system SHALL CONTINUE TO destroy the session and redirect to login.php

3.5 WHEN AuthService validates credentials THEN the system SHALL CONTINUE TO verify passwords, check rate limiting, update last login timestamps, and record failed attempts

3.6 WHEN session timeout occurs (30 minutes of inactivity) THEN the system SHALL CONTINUE TO invalidate the session and require re-authentication

3.7 WHEN CSRF tokens are generated or verified THEN the system SHALL CONTINUE TO use the existing CSRF protection mechanisms

## Bug Condition and Property

### Bug Condition Function

```pascal
FUNCTION isBugCondition(X)
  INPUT: X of type SessionState
  OUTPUT: boolean
  
  // Returns true when the bug condition is met
  // Bug occurs when session_start() is called multiple times
  // OR when session state is inconsistent between login.php and dashboard.php
  RETURN (X.session_start_count > 1) OR 
         (X.login_has_session_data AND NOT X.dashboard_validates_session)
END FUNCTION
```

### Property Specification - Fix Checking

```pascal
// Property: Fix Checking - No Redirect Loop
FOR ALL X WHERE isBugCondition(X) DO
  result ← handleLoginFlow'(X)
  ASSERT no_redirect_loop(result) AND 
         (result.redirects <= 1) AND
         (result.session_start_count = 1)
END FOR
```

**Key Definitions:**
- **F**: The original (unfixed) code - login.php and dashboard.php with multiple session_start() calls
- **F'**: The fixed code - login.php and dashboard.php with proper session management

### Property Specification - Preservation Checking

```pascal
// Property: Preservation Checking
FOR ALL X WHERE NOT isBugCondition(X) DO
  ASSERT F(X) = F'(X)
END FOR
```

This ensures that for all non-buggy scenarios (valid login, logout, session timeout, CSRF protection), the fixed code behaves identically to the original.

## Counterexample

**Concrete example demonstrating the bug:**

1. User navigates to `hexatp.com/admin/login.php`
2. login.php executes `session_start()` at line 10
3. login.php checks `isset($_SESSION['user_id'])`
4. If session data exists (from previous login attempt), redirects to dashboard.php
5. dashboard.php calls `AuthService->checkSession()`
6. checkSession() calls `session_start()` again (line 127 in AuthService.php)
7. checkSession() returns false due to session state issues
8. dashboard.php redirects back to login.php
9. Loop repeats indefinitely → ERR_TOO_MANY_REDIRECTS
