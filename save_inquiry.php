<?php
/**
 * Save Consultation Inquiry
 * HexaTP Consultation System
 */

header('Content-Type: application/json');

// Include database configuration
require_once 'db_config.php';

// Validate request method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method'
    ]);
    exit;
}

// Sanitize and validate input
$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$subject = trim($_POST['subject'] ?? '');
$appointment_date = trim($_POST['appointment_date'] ?? '');
$appointment_time = trim($_POST['appointment_time'] ?? '');
$message = trim($_POST['message'] ?? '');

// Validation
$errors = [];

if (empty($name)) {
    $errors[] = 'Name is required';
}

if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Valid email is required';
}

if (empty($phone)) {
    $errors[] = 'Phone number is required';
}

if (empty($subject)) {
    $errors[] = 'Consultation type is required';
}

if (empty($appointment_date)) {
    $errors[] = 'Appointment date is required';
}

if (empty($appointment_time)) {
    $errors[] = 'Appointment time is required';
}

// Return validation errors
if (!empty($errors)) {
    echo json_encode([
        'success' => false,
        'message' => implode(', ', $errors)
    ]);
    exit;
}

// Prepare statement to prevent SQL injection
$stmt = $conn->prepare("INSERT INTO consultations (name, email, phone, consultation_type, appointment_date, appointment_time, message, status) VALUES (?, ?, ?, ?, ?, ?, ?, 'pending')");

if (!$stmt) {
    echo json_encode([
        'success' => false,
        'message' => 'Database error: ' . $conn->error
    ]);
    exit;
}

// Bind parameters
$stmt->bind_param("sssssss", $name, $email, $phone, $subject, $appointment_date, $appointment_time, $message);

// Execute statement
if ($stmt->execute()) {
    // Also save to inquiries table for backward compatibility
    $stmt2 = $conn->prepare("INSERT INTO inquiries (name, email, phone, message) VALUES (?, ?, ?, ?)");
    $stmt2->bind_param("ssss", $name, $email, $phone, $message);
    $stmt2->execute();
    $stmt2->close();

    // Send email notification to admin
    $to = 'md@hexatp.com';
    $email_subject = 'New Consultation Request - HexaTP';
    
    // Format the date nicely
    $formatted_date = date('F j, Y', strtotime($appointment_date));
    
    // Create email body
    $email_body = "New Consultation Request Received\n\n";
    $email_body .= "=================================\n\n";
    $email_body .= "Client Details:\n";
    $email_body .= "Name: $name\n";
    $email_body .= "Email: $email\n";
    $email_body .= "Phone: $phone\n\n";
    $email_body .= "Appointment Details:\n";
    $email_body .= "Date: $formatted_date\n";
    $email_body .= "Time: $appointment_time\n";
    $email_body .= "Consultation Type: $subject\n\n";
    $email_body .= "Message:\n";
    $email_body .= "$message\n\n";
    $email_body .= "=================================\n\n";
    $email_body .= "View all consultations: https://hexatp.com/admin_consultations.php\n";
    
    // Email headers
    $headers = "From: HexaTP Contact Form <noreply@hexatp.com>\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();
    
    // Send email
    mail($to, $email_subject, $email_body, $headers);

    echo json_encode([
        'success' => true,
        'message' => 'Consultation request submitted successfully! We will contact you soon.'
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Error submitting consultation: ' . $stmt->error
    ]);
}

$stmt->close();
$conn->close();
?>
