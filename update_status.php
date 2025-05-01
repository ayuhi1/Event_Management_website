<?php
require_once 'config.php';
session_start();

// Check if user is logged in and is an admin
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    // Return error response
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
    exit;
}

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

// Check if required parameters are provided
if (!isset($_POST['booking_id']) || !isset($_POST['status'])) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Missing required parameters']);
    exit;
}

// Get and sanitize input
$booking_id = filter_input(INPUT_POST, 'booking_id', FILTER_SANITIZE_NUMBER_INT);
$status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_STRING);

// Validate status value
$valid_statuses = ['pending', 'confirmed', 'completed', 'cancelled'];
if (!in_array($status, $valid_statuses)) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Invalid status value']);
    exit;
}

try {
    // Update the booking status in the database
    $stmt = $pdo->prepare("UPDATE bookings SET status = ? WHERE id = ?");
    $result = $stmt->execute([$status, $booking_id]);
    
    if ($result && $stmt->rowCount() > 0) {
        // Return success response
        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'message' => 'Booking status updated successfully']);
    } else {
        // Return error response if no rows were affected
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Booking not found or status already set to ' . $status]);
    }
} catch (PDOException $e) {
    // Return error response
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}