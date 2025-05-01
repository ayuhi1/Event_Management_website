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
if (empty($data['fullname']) || empty($data['email']) || empty($data['password']) || empty($data['userType'])) {
    echo json_encode(['success' => false, 'message' => 'All fields are required']);
    exit;
}

$fullname = trim($data['fullname']);
$email = trim($data['email']);
$password = $data['password'];
$userType = $data['userType'];

// Validate email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Invalid email format']);
    exit;
}

// Validate password strength (at least 8 characters)
if (strlen($password) < 8) {
    echo json_encode(['success' => false, 'message' => 'Password must be at least 8 characters long']);
    exit;
}

// Validate user type
if ($userType !== 'user' && $userType !== 'admin') {
    echo json_encode(['success' => false, 'message' => 'Invalid user type']);
    exit;
}

try {
    // Check if email already exists
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    
    if ($stmt->rowCount() > 0) {
        echo json_encode(['success' => false, 'message' => 'Email already registered']);
        exit;
    }
    
    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
    // Insert new user
    $stmt = $pdo->prepare("INSERT INTO users (fullname, email, password, user_type) VALUES (?, ?, ?, ?)");
    $stmt->execute([$fullname, $email, $hashedPassword, $userType]);
    
    $userId = $pdo->lastInsertId();
    
    // Create user session
    $_SESSION['user_id'] = $userId;
    $_SESSION['user_email'] = $email;
    $_SESSION['user_fullname'] = $fullname;
    $_SESSION['user_type'] = $userType;
    
    // Return success response
    echo json_encode([
        'success' => true, 
        'message' => 'Registration successful', 
        'user' => [
            'id' => $userId,
            'fullname' => $fullname,
            'email' => $email,
            'user_type' => $userType
        ],
        'redirect' => $userType === 'admin' ? 'admin.php' : 'index.php'
    ]);
    
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}