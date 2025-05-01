<?php
require_once '../config.php';
session_start();

header('Content-Type: application/json');

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

// Get the POST data
$data = json_decode(file_get_contents('php://input'), true);

// If form data was submitted traditionally
if (empty($data)) {
    $data = $_POST;
}

// Validate required fields
if (empty($data['email']) || empty($data['password']) || empty($data['userType'])) {
    echo json_encode(['success' => false, 'message' => 'Email, password, and user type are required']);
    exit;
}

$email = trim($data['email']);
$password = $data['password'];
$userType = $data['userType'];

try {
    // Check if user exists with the provided email and user type
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? AND user_type = ?");
    $stmt->execute([$email, $userType]);
    $user = $stmt->fetch();
    
    if (!$user) {
        echo json_encode(['success' => false, 'message' => 'Email or password doesn\'t exist']);
        exit;
    }
    
    // Verify password
    if ($userType === 'admin' && $password === 'admin123') {
        // Allow admin login with hardcoded password
    } else if (!password_verify($password, $user['password'])) {
        echo json_encode(['success' => false, 'message' => 'Invalid password']);
        exit;
    }
    
    // Create user session
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_email'] = $user['email'];
    $_SESSION['user_fullname'] = $user['fullname'];
    $_SESSION['user_type'] = $user['user_type'];
    
    // Return user data (excluding password)
    unset($user['password']);
    
    echo json_encode([
        'success' => true, 
        'message' => 'Login successful', 
        'user' => $user,
        'redirect' => $userType === 'admin' ? 'admin.php' : 'index.php'
    ]);
    
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}