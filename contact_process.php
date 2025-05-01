<?php
require_once 'config.php';
session_start();

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: contact.php');
    exit;
}

// Get form data
$name = trim($_POST['name']);
$phone = trim($_POST['phone']);
$email = trim($_POST['email']);
$message = trim($_POST['message']);
$subject = isset($_POST['subject']) ? trim($_POST['subject']) : 'Contact Form Submission';

// Validate data
if (empty($name) || empty($email) || empty($message)) {
    $_SESSION['contact_error'] = 'Please fill all required fields';
    header('Location: contact.php');
    exit;
}

// Validate email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['contact_error'] = 'Please enter a valid email address';
    header('Location: contact.php');
    exit;
}

try {
    // Insert message into database
    $stmt = $pdo->prepare("INSERT INTO messages (name, email, subject, message) VALUES (?, ?, ?, ?)");
    $stmt->execute([$name, $email, $subject, $message]);
    
    // Set success message
    $_SESSION['contact_success'] = 'Your message has been sent successfully. We will contact you soon!';
    
    // Redirect back to contact page
    header('Location: contact.php');
    exit;
    
} catch (PDOException $e) {
    // Log error
    error_log('Contact form error: ' . $e->getMessage());
    
    // Set error message
    $_SESSION['contact_error'] = 'An error occurred while sending your message. Please try again later.';
    
    // Redirect back to contact page
    header('Location: contact.php');
    exit;
}