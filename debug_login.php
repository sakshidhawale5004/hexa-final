<?php
/**
 * Debug Login Page
 * This will show us the actual PHP error
 * DELETE THIS FILE AFTER DEBUGGING!
 */

// Enable error display
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<h1>Debug Login Page</h1>";
echo "<hr>";

echo "<h2>Step 1: Load db_config.php</h2>";
try {
    require_once __DIR__ . '/db_config.php';
    echo "✅ db_config.php loaded<br>";
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
    die();
}

echo "<h2>Step 2: Load services/AuthService.php</h2>";
try {
    require_once __DIR__ . '/services/AuthService.php';
    echo "✅ AuthService.php loaded<br>";
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
    die();
}

echo "<h2>Step 3: Start session</h2>";
try {
    session_start();
    echo "✅ Session started<br>";
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
    die();
}

echo "<h2>Step 4: Create AuthService instance</h2>";
try {
    $authService = new AuthService($conn);
    echo "✅ AuthService created<br>";
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
    die();
}

echo "<h2>Step 5: Test login with fake credentials</h2>";
try {
    $result = $authService->login('test_user', 'test_password');
    echo "✅ Login method executed<br>";
    echo "Result: " . json_encode($result) . "<br>";
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
    echo "Stack trace: <pre>" . $e->getTraceAsString() . "</pre>";
}

echo "<hr>";
echo "<h2>✅ All steps completed!</h2>";
echo "<p>If you see this, the login page should work.</p>";
echo "<p><a href='admin/login.php'>Try login page</a></p>";
?>
