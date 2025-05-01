<?php
require_once 'config.php';
session_start();

echo "<h2>Venue Upload Fix</h2>";

try {
    // Check if venues table exists
    $stmt = $pdo->query("SHOW TABLES LIKE 'venues'");
    $tableExists = $stmt->rowCount() > 0;
    
    if (!$tableExists) {
        echo "<p style='color: red;'>Venues table does not exist. Creating it now...</p>";
        
        // Create the venues table with the correct structure
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
        echo "<p style='color: green;'>Venues table created successfully!</p>";
    } else {
        echo "<p style='color: green;'>Venues table exists.</p>";
        
        // Check table structure
        $stmt = $pdo->query("DESCRIBE venues");
        $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Check if there's a mismatch between column names
        $hasEventType = false;
        $hasType = false;
        
        foreach ($columns as $column) {
            if ($column['Field'] === 'event_type') {
                $hasEventType = true;
            }
            if ($column['Field'] === 'type') {
                $hasType = true;
            }
        }
        
        if ($hasType && !$hasEventType) {
            echo "<p style='color: red;'>ISSUE FOUND: Table has 'type' column but venue_process.php is trying to insert into 'event_type' column.</p>";
            echo "<p>Fixing the issue by renaming the column...</p>";
            
            // Rename the column
            $pdo->exec("ALTER TABLE venues CHANGE type event_type VARCHAR(50) NOT NULL");
            echo "<p style='color: green;'>Column renamed successfully!</p>";
        }
    }
    
    // Create and fix permissions for the venues directory
    $target_dir = "images/venues/";
    
    if (!file_exists($target_dir)) {
        echo "<p>Creating venues directory...</p>";
        if (mkdir($target_dir, 0777, true)) {
            echo "<p style='color: green;'>Created directory: $target_dir</p>";
        } else {
            echo "<p style='color: red;'>Failed to create directory: $target_dir. Please create it manually.</p>";
        }
    } else {
        echo "<p>Venues directory exists.</p>";
    }
    
    // Set proper permissions
    if (file_exists($target_dir)) {
        if (chmod($target_dir, 0777)) {
            echo "<p style='color: green;'>Set permissions for venues directory to 777.</p>";
        } else {
            echo "<p style='color: red;'>Failed to set permissions for venues directory. Please set it manually to 777.</p>";
        }
        
        echo "<p>Current directory permissions: " . substr(sprintf('%o', fileperms($target_dir)), -4) . "</p>";
    }
    
    echo "<p style='color: green;'>Fix completed. You should now be able to add venues in the admin panel.</p>";
    echo "<p><a href='admin.php'>Return to Admin Panel</a></p>";
    
} catch(PDOException $e) {
    echo "<p style='color: red;'>Database error: " . $e->getMessage() . "</p>";
}
?>