<?php
// Include database configuration
require_once 'config.php';

// Function to check if string contains connection error messages
function isConnectionError($errorMsg) {
    $connectionErrors = [
        'Connection failed',
        'No connection',
        'refused',
        'Could not find driver',
        'Access denied',
        'Unknown host'
    ];
    
    foreach ($connectionErrors as $error) {
        if (strpos($errorMsg, $error) !== false) {
            return true;
        }
    }
    return false;
}

// HTML header for better styling
echo "<!DOCTYPE html>\n<html>\n<head>\n";
echo "<title>Setup Venues Table</title>\n";
echo "<style>\n";
echo "body { font-family: Arial, sans-serif; margin: 20px; }\n";
echo ".success { background-color: #dff0d8; border-left: 6px solid #4CAF50; padding: 10px; margin: 10px 0; }\n";
echo ".error { background-color: #ffdddd; border-left: 6px solid #f44336; padding: 10px; margin: 10px 0; }\n";
echo ".info { background-color: #e7f3fe; border-left: 6px solid #2196F3; padding: 10px; margin: 10px 0; }\n";
echo "ol { margin-left: 20px; }\n";
echo "a.button { display: inline-block; background-color: #8a2be2; color: white; padding: 10px 20px; text-decoration: none; border-radius: 4px; margin-top: 15px; }\n";
echo "</style>\n";
echo "</head>\n<body>\n";
echo "<h2>Setup Venues Table</h2>\n";

try {
    // Test database connection
    if ($pdo) {
        echo "<div class='success'><p>✓ Database connection successful</p></div>";
        
        try {
            // Create venues table if it doesn't exist
            $sql = "CREATE TABLE IF NOT EXISTS venues (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                event_type VARCHAR(50) NOT NULL,
                price DECIMAL(10,2) NOT NULL,
                image VARCHAR(255),
                description TEXT,
                is_active BOOLEAN DEFAULT true,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )";
            
            $pdo->exec($sql);
            
            echo "<div class='success'>";
            echo "<p>✓ Venues table created successfully!</p>";
            echo "</div>";
            
            // Check if the table was actually created
            $stmt = $pdo->query("SHOW TABLES LIKE 'venues'");
            if ($stmt->rowCount() > 0) {
                echo "<div class='info'>";
                echo "<p>The venues table is now ready to use.</p>";
                echo "<p>You can now add venues through the admin panel.</p>";
                echo "</div>";
            }
            
        } catch(PDOException $e) {
            echo "<div class='error'>";
            echo "<p>Error creating venues table: " . $e->getMessage() . "</p>";
            
            // Check if it's a table already exists error
            if (strpos($e->getMessage(), 'already exists') !== false) {
                echo "<p>The venues table already exists in the database.</p>";
            } else {
                echo "<p>There was a problem creating the venues table. Please check your database permissions.</p>";
            }
            echo "</div>";
        }
    }
} catch(PDOException $e) {
    echo "<div class='error'>";
    echo "<h3>Database Connection Error</h3>";
    echo "<p>" . $e->getMessage() . "</p>";
    
    // Provide helpful guidance for connection errors
    if (isConnectionError($e->getMessage())) {
        echo "<h4>MySQL Server Not Running</h4>";
        echo "<p>It appears that MySQL is not running or cannot be accessed. Please follow these steps:</p>";
        echo "<ol>";
        echo "<li>Open XAMPP Control Panel</li>";
        echo "<li>Click 'Start' next to MySQL</li>";
        echo "<li>Wait for MySQL to start (status should turn green)</li>";
        echo "<li>Refresh this page to try again</li>";
        echo "</ol>";
    } else if (strpos($e->getMessage(), 'Unknown database') !== false) {
        echo "<h4>Database 'occasio_db' Not Found</h4>";
        echo "<p>The database 'occasio_db' does not exist. Please create it first:</p>";
        echo "<ol>";
        echo "<li>Open phpMyAdmin (http://localhost/phpmyadmin/)</li>";
        echo "<li>Click 'New' in the left sidebar</li>";
        echo "<li>Enter 'occasio_db' as the database name</li>";
        echo "<li>Click 'Create'</li>";
        echo "<li>Refresh this page to try again</li>";
        echo "</ol>";
    }
    echo "</div>";
}

// Navigation button
echo "<a href='admin.php' class='button'>Return to Admin Panel</a>";

// HTML footer
echo "\n</body>\n</html>";
?>