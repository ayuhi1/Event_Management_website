<?php
require_once 'config.php';
session_start();

echo "<h2>Fixing Venues Active Status</h2>";

try {
    echo "<h3>Checking Database Connection</h3>";
    if ($pdo) {
        echo "<p style='color: green;'>✓ Database connection successful</p>";
    } else {
        echo "<p style='color: red;'>✗ Database connection failed</p>";
        exit;
    }
    
    echo "<h3>Checking Venues Table Structure</h3>";
    // Check if venues table exists
    $stmt = $pdo->query("SHOW TABLES LIKE 'venues'");
    $tableExists = $stmt->rowCount() > 0;
    
    if (!$tableExists) {
        echo "<p style='color: red;'>✗ Venues table does not exist.</p>";
        exit;
    } else {
        echo "<p style='color: green;'>✓ Venues table exists</p>";
        
        // Check table structure
        $stmt = $pdo->query("DESCRIBE venues");
        $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo "<h4>Current Table Structure:</h4>";
        echo "<pre>";
        print_r($columns);
        echo "</pre>";
        
        // Check if is_active column exists
        $hasIsActive = false;
        
        foreach ($columns as $column) {
            if ($column['Field'] === 'is_active') {
                $hasIsActive = true;
                break;
            }
        }
        
        if (!$hasIsActive) {
            echo "<p style='color: red;'>✗ Table does not have 'is_active' column. Adding it now...</p>";
            
            // Add is_active column
            $pdo->exec("ALTER TABLE venues ADD COLUMN is_active BOOLEAN DEFAULT true");
            echo "<p style='color: green;'>✓ Added 'is_active' column successfully!</p>";
        } else {
            echo "<p style='color: green;'>✓ Table already has 'is_active' column</p>";
        }
        
        // Make sure all venues have is_active set properly
        $stmt = $pdo->query("UPDATE venues SET is_active = 1 WHERE is_active IS NULL");
        echo "<p style='color: green;'>✓ Updated any NULL is_active values to 1</p>";
    }
    
    echo "<h3>Checking Venues Data</h3>";
    // Get all venues
    $stmt = $pdo->query("SELECT * FROM venues ORDER BY is_active DESC, event_type, name");
    $venues = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (count($venues) > 0) {
        echo "<p style='color: green;'>✓ Found " . count($venues) . " venues in the database</p>";
        
        echo "<table border='1' cellpadding='5' style='border-collapse: collapse;'>";
        echo "<tr><th>ID</th><th>Name</th><th>Event Type</th><th>Price</th><th>Active</th></tr>";
        
        foreach ($venues as $venue) {
            $activeStatus = isset($venue['is_active']) && $venue['is_active'] ? 'Yes' : 'No';
            $activeColor = isset($venue['is_active']) && $venue['is_active'] ? 'green' : 'red';
            
            echo "<tr>";
            echo "<td>{$venue['id']}</td>";
            echo "<td>{$venue['name']}</td>";
            echo "<td>{$venue['event_type']}</td>";
            echo "<td>{$venue['price']}</td>";
            echo "<td style='color: {$activeColor};'>{$activeStatus}</td>";
            echo "</tr>";
        }
        
        echo "</table>";
    } else {
        echo "<p style='color: red;'>✗ No venues found in the database</p>";
    }
    
    echo "<h3>Summary</h3>";
    echo "<p style='color: green;'>✓ Fix completed. The venues table now has the is_active column properly set.</p>";
    echo "<p>The delete venue functionality should now work correctly, and only active venues will be displayed in the booking section.</p>";
    
    echo "<p><a href='admin.php' style='display: inline-block; background-color: #8a2be2; color: white; padding: 10px 20px; text-decoration: none; border-radius: 4px;'>Return to Admin Panel</a></p>";
    
} catch(PDOException $e) {
    echo "<p style='color: red;'>Database error: " . $e->getMessage() . "</p>";
}
?>