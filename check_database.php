<?php
require_once 'config.php';

echo "<h2>Database Diagnostic Tool</h2>";

try {
    // Check database connection
    echo "<h3>Database Connection</h3>";
    if ($pdo) {
        echo "<p style='color: green;'>✓ Database connection successful</p>";
        
        // Get database name from connection
        $stmt = $pdo->query("SELECT DATABASE()");
        $dbName = $stmt->fetchColumn();
        echo "<p>Current database: <strong>$dbName</strong></p>";
        
        if ($dbName !== 'occasio_db') {
            echo "<p style='color: red;'>✗ Wrong database! Expected 'occasio_db' but connected to '$dbName'</p>";
            echo "<p>This is likely the cause of the 'Table occasio_db.venues doesn't exist' error.</p>";
        }
        
        // List all tables
        echo "<h3>Tables in Database</h3>";
        $stmt = $pdo->query("SHOW TABLES");
        $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
        
        if (count($tables) > 0) {
            echo "<ul>";
            foreach ($tables as $table) {
                $style = ($table === 'venues') ? "color: green; font-weight: bold;" : "";
                echo "<li style='$style'>$table</li>";
            }
            echo "</ul>";
            
            // Check if venues table exists
            if (in_array('venues', $tables)) {
                echo "<p style='color: green;'>✓ Venues table exists in the current database</p>";
                
                // Show venues table structure
                echo "<h3>Venues Table Structure</h3>";
                $stmt = $pdo->query("DESCRIBE venues");
                $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                echo "<table border='1' cellpadding='5' style='border-collapse: collapse;'>";
                echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
                
                foreach ($columns as $column) {
                    echo "<tr>";
                    foreach ($column as $key => $value) {
                        echo "<td>" . ($value === null ? 'NULL' : htmlspecialchars($value)) . "</td>";
                    }
                    echo "</tr>";
                }
                
                echo "</table>";
                
                // Check for required columns
                $requiredColumns = ['id', 'name', 'event_type', 'price', 'image', 'description', 'is_active'];
                $missingColumns = [];
                
                foreach ($requiredColumns as $required) {
                    $found = false;
                    foreach ($columns as $column) {
                        if ($column['Field'] === $required) {
                            $found = true;
                            break;
                        }
                    }
                    
                    if (!$found) {
                        $missingColumns[] = $required;
                    }
                }
                
                if (count($missingColumns) > 0) {
                    echo "<p style='color: red;'>✗ Missing required columns: " . implode(', ', $missingColumns) . "</p>";
                    echo "<p>This could cause errors when adding or editing venues.</p>";
                } else {
                    echo "<p style='color: green;'>✓ All required columns exist</p>";
                }
                
                // Check for data in venues table
                $stmt = $pdo->query("SELECT COUNT(*) FROM venues");
                $count = $stmt->fetchColumn();
                
                echo "<h3>Venues Data</h3>";
                echo "<p>Total venues in database: <strong>$count</strong></p>";
                
                if ($count > 0) {
                    echo "<p style='color: green;'>✓ Venues table has data</p>";
                    
                    // Show sample data
                    $stmt = $pdo->query("SELECT * FROM venues LIMIT 5");
                    $venues = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    
                    echo "<h4>Sample Venues:</h4>";
                    echo "<table border='1' cellpadding='5' style='border-collapse: collapse;'>";
                    echo "<tr>";
                    foreach (array_keys($venues[0]) as $header) {
                        echo "<th>$header</th>";
                    }
                    echo "</tr>";
                    
                    foreach ($venues as $venue) {
                        echo "<tr>";
                        foreach ($venue as $value) {
                            echo "<td>" . (is_null($value) ? 'NULL' : (strlen($value) > 50 ? substr(htmlspecialchars($value), 0, 50) . '...' : htmlspecialchars($value))) . "</td>";
                        }
                        echo "</tr>";
                    }
                    
                    echo "</table>";
                } else {
                    echo "<p style='color: red;'>✗ Venues table is empty</p>";
                    echo "<p>This could be normal if you haven't added any venues yet.</p>";
                }
            } else {
                echo "<p style='color: red;'>✗ Venues table does not exist in the current database</p>";
                echo "<p>This is likely the cause of the 'Table occasio_db.venues doesn't exist' error.</p>";
                echo "<p>Try running the setup_venues.php or create_venues_table.php script to create the table.</p>";
            }
        } else {
            echo "<p style='color: red;'>✗ No tables found in the database</p>";
            echo "<p>The database appears to be empty. You may need to run the database setup scripts.</p>";
        }
    } else {
        echo "<p style='color: red;'>✗ Database connection failed</p>";
    }
    
    echo "<h3>Recommendations</h3>";
    echo "<ol>";
    echo "<li>Make sure you're connected to the correct database ('occasio_db').</li>";
    echo "<li>If the venues table doesn't exist, run the setup_venues.php script.</li>";
    echo "<li>If the venues table exists but has missing columns, run the create_venues_table.php script.</li>";
    echo "<li>Check the config.php file to ensure the database connection settings are correct.</li>";
    echo "</ol>";
    
    echo "<p><a href='admin.php' style='display: inline-block; background-color: #8a2be2; color: white; padding: 10px 20px; text-decoration: none; border-radius: 4px;'>Return to Admin Panel</a></p>";
    
} catch(PDOException $e) {
    echo "<p style='color: red;'>Database error: " . $e->getMessage() . "</p>";
}
?>