<?php
require_once 'config.php';
session_start();

// Check if user is logged in and is an admin
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    header('Location: login.php');
    exit;
}

// Process form submission for adding a new venue
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $venue_name = trim($_POST['venue_name']);
    $event_type = trim($_POST['event_type']);
    $venue_price = trim($_POST['venue_price']);
    $venue_description = trim($_POST['venue_description']);
    
    // Handle file upload
    $target_dir = "images/venues/";
    
    // Create directory if it doesn't exist
    if (!file_exists($target_dir)) {
        if (!mkdir($target_dir, 0777, true)) {
            $_SESSION['error'] = "Failed to create upload directory. Please contact administrator.";
            header('Location: admin.php');
            exit;
        }
    }
    
    // Ensure directory has proper permissions
    chmod($target_dir, 0777);
    
    $file_extension = strtolower(pathinfo($_FILES["venue_image"]["name"], PATHINFO_EXTENSION));
    $new_filename = uniqid() . '.' . $file_extension;
    $target_file = $target_dir . $new_filename;
    
    // Check if image file is a actual image
    $check = getimagesize($_FILES["venue_image"]["tmp_name"]);
    if($check === false) {
        $_SESSION['error'] = "File is not an image.";
        header('Location: admin.php');
        exit;
    }
    
    // Check file size (limit to 5MB)
    if ($_FILES["venue_image"]["size"] > 5000000) {
        $_SESSION['error'] = "Sorry, your file is too large.";
        header('Location: admin.php');
        exit;
    }
    
    // Allow certain file formats
    if($file_extension != "jpg" && $file_extension != "png" && $file_extension != "jpeg" && $file_extension != "gif" ) {
        $_SESSION['error'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        header('Location: admin.php');
        exit;
    }
    
    // Try to upload file
    if (move_uploaded_file($_FILES["venue_image"]["tmp_name"], $target_file)) {
        // File uploaded successfully, now insert venue into database
        try {
            $stmt = $pdo->prepare("INSERT INTO venues (name, event_type, price, image, description) VALUES (?, ?, ?, ?, ?)");
            $result = $stmt->execute([$venue_name, $event_type, $venue_price, $target_file, $venue_description]);
            
            if ($result) {
                $_SESSION['success'] = "Venue added successfully!";
            } else {
                $_SESSION['error'] = "Failed to add venue. Database error occurred.";
                // Delete uploaded file if database insertion fails
                if (file_exists($target_file)) {
                    unlink($target_file);
                }
            }
            header('Location: admin.php');
            exit;
        } catch (PDOException $e) {
            $_SESSION['error'] = "Database error: " . $e->getMessage();
            // Delete uploaded file if database insertion fails
            if (file_exists($target_file)) {
                unlink($target_file);
            }
            header('Location: admin.php');
            exit;
        }
    } else {
        $_SESSION['error'] = "Sorry, there was an error uploading your file.";
        header('Location: admin.php');
        exit;
    }
}

// Process venue deletion
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $venue_id = $_GET['id'];
    
    try {
        // Get venue image path before deleting
        $stmt = $pdo->prepare("SELECT image FROM venues WHERE id = ?");
        $stmt->execute([$venue_id]);
        $venue = $stmt->fetch();
        
        if ($venue) {
            // Delete venue from database
            $stmt = $pdo->prepare("DELETE FROM venues WHERE id = ?");
            $stmt->execute([$venue_id]);
            
            // Delete venue image file
            if (file_exists($venue['image'])) {
                unlink($venue['image']);
            }
            
            $_SESSION['success'] = "Venue deleted successfully!";
        } else {
            $_SESSION['error'] = "Venue not found.";
        }
    } catch (PDOException $e) {
        $_SESSION['error'] = "Database error: " . $e->getMessage();
    }
    
    header('Location: admin.php');
    exit;
}

// Redirect back to admin page if accessed directly
header('Location: admin.php');
exit;