<?php
require_once 'config.php';
session_start();

// Check if user is logged in and is an admin
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    header('Location: login.php');
    exit;
}

try {
    // Create venues table if it doesn't exist
    $sql = "CREATE TABLE IF NOT EXISTS venues (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        event_type VARCHAR(50) NOT NULL,
        price DECIMAL(10,2) NOT NULL,
        image VARCHAR(255) NOT NULL,
        description TEXT,
        is_active BOOLEAN DEFAULT true,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    
    $pdo->exec($sql);
    $_SESSION['success'] = "Venues table created successfully!";
    
    // Check if there are already venues in the table
    $stmt = $pdo->query("SELECT COUNT(*) FROM venues");
    $count = $stmt->fetchColumn();
    
    // If no venues exist, add some default ones
    if ($count == 0) {
        // Create venues directory if it doesn't exist
        $target_dir = "images/venues/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        
        // Sample venues data
        $venues = [
            // Wedding venues
            ['Grand Ballroom', 'wedding', 5000.00, 'images/venues/grand_ballroom.jpg', 'A luxurious ballroom perfect for grand weddings with high ceilings and elegant decor.'],
            ['Garden Pavilion', 'wedding', 3500.00, 'images/venues/garden_pavilion.jpg', 'Beautiful outdoor venue surrounded by lush gardens and water features.'],
            ['Beachfront Resort', 'wedding', 4500.00, 'images/venues/beachfront_resort.jpg', 'Romantic beachfront venue with panoramic ocean views.'],
            
            // Birthday venues
            ['Party Hall', 'birthday', 1500.00, 'images/venues/party_hall.jpg', 'Colorful and vibrant space ideal for birthday celebrations of all ages.'],
            ['Rooftop Lounge', 'birthday', 2000.00, 'images/venues/rooftop_lounge.jpg', 'Stylish rooftop venue with city views, ideal for adult birthday parties.'],
            
            // Corporate venues
            ['Conference Center', 'corporate', 2000.00, 'images/venues/conference_center.jpg', 'Professional setting with state-of-the-art technology for corporate events.'],
            
            // Anniversary venues
            ['Luxury Hotel', 'anniversary', 3000.00, 'images/venues/luxury_hotel.jpg', 'Sophisticated venue with premium amenities for anniversary celebrations.'],
            
            // Other event venues
            ['Multipurpose Hall', 'other', 1800.00, 'images/venues/multipurpose_hall.jpg', 'Versatile venue that can be customized for various types of events.']
        ];
        
        // Insert sample venues
        $stmt = $pdo->prepare("INSERT INTO venues (name, event_type, price, image, description, is_active) VALUES (?, ?, ?, ?, ?, 1)");
        
        foreach ($venues as $venue) {
            $stmt->execute($venue);
        }
        
        $_SESSION['success'] .= " Sample venues added successfully!";
    }
    
} catch(PDOException $e) {
    $_SESSION['error'] = "Error creating venues table: " . $e->getMessage();
}

// Redirect back to admin page
header('Location: admin.php');
exit;
?>