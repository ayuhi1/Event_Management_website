<?php
session_start();

// Include database connection
require_once 'config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Get user information
$user_id = $_SESSION['user_id'];
$user_fullname = $_SESSION['user_fullname'];
$user_email = $_SESSION['user_email'];

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['profile_message'] = "Error: Invalid request method.";
    header('Location: profile.php');
    exit;
}

// Validate required fields
$booking_id = filter_input(INPUT_POST, 'booking_id', FILTER_VALIDATE_INT);
$message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_SPECIAL_CHARS);

if (!$booking_id || empty($message)) {
    $_SESSION['profile_message'] = "Error: All fields are required.";
    header('Location: profile.php');
    exit;
}

try {
    // Verify that the booking belongs to the current user
    $stmt = $pdo->prepare("SELECT * FROM bookings WHERE id = ? AND user_id = ?");
    $stmt->execute([$booking_id, $user_id]);
    $booking = $stmt->fetch();
    
    if (!$booking) {
        $_SESSION['profile_message'] = "Error: You don't have permission to contact about this booking.";
        header('Location: profile.php');
        exit;
    }
    
    // Create a message in the messages table
    $subject = "Inquiry about " . $booking['event_type'] . " booking #" . $booking_id;
    
    $stmt = $pdo->prepare("INSERT INTO messages (name, email, subject, message, is_read, created_at) 
                          VALUES (?, ?, ?, ?, 0, NOW())");
    $stmt->execute([$user_fullname, $user_email, $subject, $message]);
    
    if ($stmt->rowCount() > 0) {
        $_SESSION['profile_message'] = "Your message has been sent to the event organizers. They will contact you soon.";
    } else {
        $_SESSION['profile_message'] = "Error: Failed to send message.";
    }
    
} catch (PDOException $e) {
    $_SESSION['profile_message'] = "Database error: " . $e->getMessage();
}

// Redirect back to profile page
header('Location: profile.php');
exit;