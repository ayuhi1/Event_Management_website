<?php
session_start();

// Include database connection
require_once 'config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Get user ID
$user_id = $_SESSION['user_id'];

// Check if booking ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['profile_message'] = "Error: No booking specified.";
    header('Location: profile.php');
    exit;
}

$booking_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$booking_id) {
    $_SESSION['profile_message'] = "Error: Invalid booking ID.";
    header('Location: profile.php');
    exit;
}

try {
    // First, verify that the booking belongs to the current user and is in 'pending' status
    $stmt = $pdo->prepare("SELECT * FROM bookings WHERE id = ? AND user_id = ?");
    $stmt->execute([$booking_id, $user_id]);
    $booking = $stmt->fetch();
    
    if (!$booking) {
        $_SESSION['profile_message'] = "Error: You don't have permission to delete this booking.";
        header('Location: profile.php');
        exit;
    }
    
    if ($booking['status'] !== 'pending') {
        $_SESSION['profile_message'] = "Error: Only pending bookings can be deleted.";
        header('Location: profile.php');
        exit;
    }
    
    // Delete the booking
    $stmt = $pdo->prepare("DELETE FROM bookings WHERE id = ? AND user_id = ?");
    $stmt->execute([$booking_id, $user_id]);
    
    if ($stmt->rowCount() > 0) {
        $_SESSION['profile_message'] = "Booking successfully deleted.";
    } else {
        $_SESSION['profile_message'] = "Error: Failed to delete booking.";
    }
    
} catch (PDOException $e) {
    $_SESSION['profile_message'] = "Database error: " . $e->getMessage();
}

// Redirect back to profile page
header('Location: profile.php');
exit;