<?php
/**
 * Database Configuration File
 * HexaTP Consultation System
 */

// Database credentials
// IMPORTANT: Replace these with your actual Hostinger database credentials
define('DB_HOST', 'localhost');  // Usually 'localhost' on Hostinger
define('DB_USER', 'YOUR_DATABASE_USERNAME');  // Replace with your Hostinger DB username
define('DB_PASS', 'YOUR_DATABASE_PASSWORD');  // Replace with your Hostinger DB password
define('DB_NAME', 'YOUR_DATABASE_NAME');      // Replace with your Hostinger DB name

// Create connection
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if ($conn->connect_error) {
    die(json_encode([
        'success' => false,
        'message' => 'Database connection failed: ' . $conn->connect_error
    ]));
}

// Set charset to utf8
$conn->set_charset("utf8");

?>
