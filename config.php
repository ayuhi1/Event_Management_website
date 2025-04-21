<?php
$host = 'localhost';
$dbname = 'occasio_db';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    die();
}

// Function to get slider images from database
function getSliderImages($pdo) {
    try {
        $stmt = $pdo->query("SELECT * FROM slider_images ORDER BY position ASC LIMIT 3");
        return $stmt->fetchAll();
    } catch(PDOException $e) {
        return [];
    }
}
?>