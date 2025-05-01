<?php
require_once 'config.php';

// Check if admin user exists
$stmt = $pdo->prepare("SELECT * FROM users WHERE user_type = 'admin'");
$stmt->execute();
$admin = $stmt->fetch();

echo "<h2>Admin User Information</h2>";
if ($admin) {
    echo "<p>Admin found with ID: {$admin['id']} and email: {$admin['email']}</p>";
    
    // Update admin password to 'admin123'
    $hashedPassword = password_hash('admin123', PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE user_type = 'admin'");
    $stmt->execute([$hashedPassword]);
    
    echo "<p>Password updated successfully. Affected rows: " . $stmt->rowCount() . "</p>";
    echo "<p>New admin password is: admin123</p>";
} else {
    echo "<p>No admin user found. Creating one...</p>";
    
    // Create admin user if none exists
    $hashedPassword = password_hash('admin123', PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO users (fullname, email, password, user_type, created_at) VALUES (?, ?, ?, ?, NOW())");
    $stmt->execute(['Administrator', 'admin@classicevents.com', $hashedPassword, 'admin']);
    
    echo "<p>Admin user created successfully with ID: " . $pdo->lastInsertId() . "</p>";
    echo "<p>Admin credentials: admin@classicevents.com / admin123</p>";
}

echo "<p><a href='login.php'>Go to Login Page</a></p>";
?>