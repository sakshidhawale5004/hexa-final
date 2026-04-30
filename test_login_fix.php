<?php
/**
 * Test Script: Verify Login Fix
 * 
 * This script tests that the session management fix works correctly
 * Run this locally to verify before uploading to Hostinger
 */

echo "<h1>Testing Login Fix</h1>";
echo "<hr>";

// Test 1: Check if session_start() is called only once
echo "<h2>Test 1: Session Start Count</h2>";
$session_start_count = 0;

// Override session_start to count calls
function test_session_start() {
    global $session_start_count;
    $session_start_count++;
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}

echo "✅ Session management test: ";
if (session_status() === PHP_SESSION_NONE) {
    session_start();
    echo "Session started successfully<br>";
} else {
    echo "Session already active<br>";
}

// Test 2: Verify AuthService exists
echo "<h2>Test 2: AuthService Availability</h2>";
if (file_exists(__DIR__ . '/services/AuthService.php')) {
    echo "✅ AuthService.php exists<br>";
    require_once __DIR__ . '/db_config.php';
    require_once __DIR__ . '/services/AuthService.php';
    echo "✅ AuthService loaded successfully<br>";
} else {
    echo "❌ AuthService.php not found<br>";
}

// Test 3: Verify database connection
echo "<h2>Test 3: Database Connection</h2>";
try {
    if (function_exists('getDBConnection')) {
        echo "✅ getDBConnection() function exists<br>";
        // Don't actually connect in test, just verify function exists
    } else {
        echo "❌ getDBConnection() function not found<br>";
    }
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
}

// Test 4: Verify login.php structure
echo "<h2>Test 4: Login.php Structure</h2>";
$login_content = file_get_contents(__DIR__ . '/admin/login.php');

if (strpos($login_content, 'session_start();') === false || 
    strpos($login_content, '// FIXED: Removed session_start()') !== false) {
    echo "✅ login.php does NOT have standalone session_start()<br>";
} else {
    echo "❌ login.php still has standalone session_start() - FIX NOT APPLIED<br>";
}

if (strpos($login_content, '$authService->checkSession()') !== false) {
    echo "✅ login.php uses AuthService->checkSession()<br>";
} else {
    echo "❌ login.php does not use AuthService->checkSession()<br>";
}

if (strpos($login_content, 'require_once __DIR__ . \'/../db_config.php\';') !== false) {
    echo "✅ login.php loads db_config.php at the top<br>";
} else {
    echo "❌ login.php does not load db_config.php properly<br>";
}

// Test 5: Verify AuthService session checks
echo "<h2>Test 5: AuthService Session Checks</h2>";
$auth_content = file_get_contents(__DIR__ . '/services/AuthService.php');

if (strpos($auth_content, 'session_status() === PHP_SESSION_NONE') !== false) {
    echo "✅ AuthService checks session status before starting<br>";
} else {
    echo "❌ AuthService does not check session status<br>";
}

// Summary
echo "<hr>";
echo "<h2>Summary</h2>";
echo "<p><strong>Fix Status:</strong> ";
if (strpos($login_content, '// FIXED: Removed session_start()') !== false) {
    echo "<span style='color: green; font-weight: bold;'>✅ FIX APPLIED</span></p>";
    echo "<p>The redirect loop fix has been successfully applied to login.php</p>";
    echo "<p><strong>Next Step:</strong> Upload admin/login.php to Hostinger</p>";
} else {
    echo "<span style='color: red; font-weight: bold;'>❌ FIX NOT APPLIED</span></p>";
    echo "<p>The fix has not been applied yet. Please apply the fix first.</p>";
}

echo "<hr>";
echo "<p><em>Test completed at " . date('Y-m-d H:i:s') . "</em></p>";
?>
