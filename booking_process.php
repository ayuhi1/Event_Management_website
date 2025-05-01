<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page with a return URL
    header('Location: login.php?redirect=booking.php');
    exit;
}

// Include database connection
require_once 'config.php';

// Get user information
$user_id = $_SESSION['user_id'];

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate input data
    $event_type = filter_input(INPUT_POST, 'event_type', FILTER_SANITIZE_SPECIAL_CHARS);
    $event_date = filter_input(INPUT_POST, 'event_date', FILTER_SANITIZE_SPECIAL_CHARS);
    $event_time = filter_input(INPUT_POST, 'event_time', FILTER_SANITIZE_SPECIAL_CHARS);
    $venue = filter_input(INPUT_POST, 'venue', FILTER_SANITIZE_SPECIAL_CHARS);
    $venue_id = filter_input(INPUT_POST, 'venue_id', FILTER_VALIDATE_INT);
    $venue_price = filter_input(INPUT_POST, 'venue_price', FILTER_SANITIZE_SPECIAL_CHARS);
    $guests = filter_input(INPUT_POST, 'guests', FILTER_VALIDATE_INT);
    $additional_info = filter_input(INPUT_POST, 'additional_info', FILTER_SANITIZE_SPECIAL_CHARS);
    
    // Validate required fields
    if (empty($event_type) || empty($event_date) || empty($event_time) || empty($venue) || empty($guests)) {
        $_SESSION['booking_error'] = "All required fields must be filled out.";
        header('Location: booking.php');
        exit;
    }
    
    // Validate event date (must be in the future, at least 3 days from now)
    $min_date = date('Y-m-d', strtotime('+3 days'));
    if ($event_date < $min_date) {
        $_SESSION['booking_error'] = "Event date must be at least 3 days from today.";
        header('Location: booking.php');
        exit;
    }
    
    // Validate number of guests
    if ($guests < 1) {
        $_SESSION['booking_error'] = "Number of guests must be at least 1.";
        header('Location: booking.php');
        exit;
    }
    
    try {
        // Check if bookings table has venue_id column
        $hasVenueIdColumn = false;
        try {
            $stmt = $pdo->query("DESCRIBE bookings");
            $columns = $stmt->fetchAll(PDO::FETCH_COLUMN);
            $hasVenueIdColumn = in_array('venue_id', $columns);
        } catch (PDOException $e) {
            // If there's an error, assume column doesn't exist
            $hasVenueIdColumn = false;
        }
        
        // Add venue_id column if it doesn't exist
        if (!$hasVenueIdColumn && $venue_id) {
            try {
                $pdo->exec("ALTER TABLE bookings ADD COLUMN venue_id INT");
                $hasVenueIdColumn = true;
            } catch (PDOException $e) {
                // If there's an error adding the column, continue without it
                error_log("Error adding venue_id column: " . $e->getMessage());
            }
        }
        
        // Prepare SQL statement to insert booking data
        if ($hasVenueIdColumn && $venue_id) {
            $stmt = $pdo->prepare("INSERT INTO bookings (user_id, event_type, event_date, event_time, venue, venue_id, guests, additional_info, status, created_at) 
                                  VALUES (:user_id, :event_type, :event_date, :event_time, :venue, :venue_id, :guests, :additional_info, 'pending', NOW())");
            
            // Bind parameters including venue_id
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindParam(':event_type', $event_type, PDO::PARAM_STR);
            $stmt->bindParam(':event_date', $event_date, PDO::PARAM_STR);
            $stmt->bindParam(':event_time', $event_time, PDO::PARAM_STR);
            $stmt->bindParam(':venue', $venue, PDO::PARAM_STR);
            $stmt->bindParam(':venue_id', $venue_id, PDO::PARAM_INT);
            $stmt->bindParam(':guests', $guests, PDO::PARAM_INT);
            $stmt->bindParam(':additional_info', $additional_info, PDO::PARAM_STR);
        } else {
            // Original query without venue_id
            $stmt = $pdo->prepare("INSERT INTO bookings (user_id, event_type, event_date, event_time, venue, guests, additional_info, status, created_at) 
                                  VALUES (:user_id, :event_type, :event_date, :event_time, :venue, :guests, :additional_info, 'pending', NOW())");
            
            // Bind parameters
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindParam(':event_type', $event_type, PDO::PARAM_STR);
            $stmt->bindParam(':event_date', $event_date, PDO::PARAM_STR);
            $stmt->bindParam(':event_time', $event_time, PDO::PARAM_STR);
            $stmt->bindParam(':venue', $venue, PDO::PARAM_STR);
            $stmt->bindParam(':guests', $guests, PDO::PARAM_INT);
            $stmt->bindParam(':additional_info', $additional_info, PDO::PARAM_STR);
        }
        
        // Execute the statement
        $stmt->execute();
        
        // Set success message
        $_SESSION['booking_success'] = "Your booking request has been submitted successfully! Our team will contact you shortly.";
        
        // Redirect back to booking page
        header('Location: booking.php');
        exit;
        
    } catch (PDOException $e) {
        // Log the error (in a production environment)
        error_log("Booking Error: " . $e->getMessage());
        
        // Set error message
        $_SESSION['booking_error'] = "An error occurred while processing your booking. Please try again later.";
        
        // Redirect back to booking page
        header('Location: booking.php');
        exit;
    }
} else {
    // If not a POST request, redirect to booking form
    header('Location: booking.php');
    exit;
}