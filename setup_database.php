<?php
/**
 * Database Setup Script for HexaTP Consultation System
 * Run this file once to create the database and tables
 */

$servername = "localhost";
$username = "root";
$password = "";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database
$sql = "CREATE DATABASE IF NOT EXISTS hexatp_db";
if ($conn->query($sql) === TRUE) {
    echo "✓ Database 'hexatp_db' created successfully or already exists.<br>";
} else {
    echo "✗ Error creating database: " . $conn->error . "<br>";
}

// Select the database
$conn->select_db("hexatp_db");

// Create consultations table
$sql = "CREATE TABLE IF NOT EXISTS consultations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    consultation_type VARCHAR(100) NOT NULL,
    appointment_date DATE NOT NULL,
    appointment_time VARCHAR(20) NOT NULL,
    message LONGTEXT,
    status ENUM('pending', 'confirmed', 'completed', 'cancelled') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_email (email),
    INDEX idx_date (appointment_date),
    INDEX idx_status (status)
)";

if ($conn->query($sql) === TRUE) {
    echo "✓ Table 'consultations' created successfully or already exists.<br>";
} else {
    echo "✗ Error creating table: " . $conn->error . "<br>";
}

// Create inquiries table (for backward compatibility)
$sql = "CREATE TABLE IF NOT EXISTS inquiries (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    message LONGTEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_email (email)
)";

if ($conn->query($sql) === TRUE) {
    echo "✓ Table 'inquiries' created successfully or already exists.<br>";
} else {
    echo "✗ Error creating table: " . $conn->error . "<br>";
}

$conn->close();
echo "<br><strong>✓ Database setup completed successfully!</strong>";
?>
