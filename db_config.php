<?php
/**
 * Database Configuration File
 * HexaTP Consultation System
 */

// Database credentials for Hostinger
// IMPORTANT: Replace the password with your actual password
define('DB_HOST', 'localhost');
define('DB_USER', 'u852823366_hexatp_user');
define('DB_PASS', 'Hexatp_2026');
define('DB_NAME', 'u852823366_hexatp_db');

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
