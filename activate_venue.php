<?php
require_once 'config.php';
session_start();

// Check if user is logged in and is an admin
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    header('Location: login.php');
    exit;
}

// Check if venue ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['error'] = "Venue ID is required.";
    header('Location: admin.php');
    exit;
}

$venue_id = $_GET['id'];

try {
    // Get venue details before activating
    $stmt = $pdo->prepare("SELECT * FROM venues WHERE id = ?");
    $stmt->execute([$venue_id]);
    $venue = $stmt->fetch();
    
    if ($venue) {
        // Check if the venues table has is_active column
        $stmt = $pdo->query("DESCRIBE venues");
        $columns = $stmt->fetchAll(PDO::FETCH_COLUMN);
        
        if (in_array('is_active', $columns)) {
            // If is_active column exists, set it to 1 (activate)
            $stmt = $pdo->prepare("UPDATE venues SET is_active = 1 WHERE id = ?");
            $stmt->execute([$venue_id]);
            $_SESSION['success'] = "Venue activated successfully!";
        } else {
            // If is_active column doesn't exist, add it first
            $pdo->exec("ALTER TABLE venues ADD COLUMN is_active BOOLEAN DEFAULT true");
            
            // Then set it to 1 for this venue
            $stmt = $pdo->prepare("UPDATE venues SET is_active = 1 WHERE id = ?");
            $stmt->execute([$venue_id]);
            $_SESSION['success'] = "Venue activated successfully!";
        }
    } else {
        $_SESSION['error'] = "Venue not found.";
    }
} catch (PDOException $e) {
    $_SESSION['error'] = "Database error: " . $e->getMessage();
}

// Redirect back to admin page
header('Location: admin.php');
exit;