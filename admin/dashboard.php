<?php
require_once '../config.php';
session_start();

// Check if user is logged in and is an admin
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    // Display login/signup page with buttons instead of redirecting
    include_once '../includes/header.php';
    ?>
    <div class="container" style="text-align: center; padding: 50px 20px;">
        <h2>Admin Access Required</h2>
        <p>You need to be logged in as an administrator to access this page.</p>
        <div class="auth-buttons" style="margin-top: 20px;">
            <a href="../login.php" class="login-btn" style="background-color: #ff4d4d; color: white; padding: 10px 20px; border-radius: 4px; text-decoration: none; margin-right: 10px;">Login</a>
            <a href="../signup.php" class="signin-btn" style="background-color: #333; color: white; padding: 10px 20px; border-radius: 4px; text-decoration: none;">Sign Up</a>
        </div>
    </div>
    <?php
    include_once '../includes/footer.php';
    exit;
}

// Get admin information
$admin_id = $_SESSION['user_id'];

try {
    // Get admin details
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ? AND user_type = 'admin'");
    $stmt->execute([$admin_id]);
    $admin = $stmt->fetch();
    
    if (!$admin) {
        // If admin not found, log out and redirect
        session_destroy();
        header('Location: ../login.php');
        exit;
    }
    
    // Get recent messages
    $stmt = $pdo->query("SELECT * FROM messages ORDER BY created_at DESC LIMIT 5");
    $recent_messages = $stmt->fetchAll();
    
    // Get recent bookings
    $stmt = $pdo->query("SELECT b.*, u.fullname FROM bookings b JOIN users u ON b.user_id = u.id ORDER BY b.created_at DESC LIMIT 5");
    $recent_bookings = $stmt->fetchAll();
    
    // Count total users
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM users WHERE user_type = 'user'");
    $user_count = $stmt->fetch()['total'];
    
    // Count total bookings
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM bookings");
    $booking_count = $stmt->fetch()['total'];
    
    // Count total messages
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM messages");
    $message_count = $stmt->fetch()['total'];
    
} catch (PDOException $e) {
    $error = 'Database error: ' . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Classic Events</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }
        
        .admin-container {
            display: flex;
            min-height: 100vh;
        }
        
        .sidebar {
            width: 250px;
            background-color: #333;
            color: white;
            padding-top: 20px;
        }
        
        .sidebar-header {
            padding: 0 20px 20px;
            border-bottom: 1px solid #444;
            text-align: center;
        }
        
        .sidebar-header img {
            max-width: 150px;
            margin-bottom: 10px;
        }
        
        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 20px 0;
        }
        
        .sidebar-menu li {
            padding: 10px 20px;
            border-left: 3px solid transparent;
            transition: all 0.3s;
        }
        
        .sidebar-menu li:hover, .sidebar-menu li.active {
            background-color: #444;
            border-left-color: #ff4d4d;
        }
        
        .sidebar-menu a {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
        }
        
        .sidebar-menu i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }
        
        .main-content {
            flex: 1;
            padding: 20px;
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            background-color: white;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        
        .header h1 {
            margin: 0;
            color: #333;
        }
        
        .user-info {
            display: flex;
            align-items: center;
        }
        
        .user-info span {
            margin-right: 10px;
        }
        
        .logout-btn {
            background-color: #ff4d4d;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
        }
        
        .dashboard-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 20px;
            text-align: center;
        }
        
        .stat-card i {
            font-size: 40px;
            margin-bottom: 10px;
            color: #ff4d4d;
        }
        
        .stat-card h3 {
            font-size: 24px;
            margin: 10px 0;
            color: #333;
        }
        
        .stat-card p {
            color: #666;
            margin: 0;
        }
        
        .recent-section {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 20px;
            margin-bottom: 30px;
        }
        
        .recent-section h2 {
            margin-top: 0;
            color: #333;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }
        
        .recent-item {
            padding: 15px 0;
            border-bottom: 1px solid #eee;
        }
        
        .recent-item:last-child {
            border-bottom: none;
        }
        
        .recent-item h4 {
            margin: 0 0 5px;
            color: #333;
        }
        
        .recent-item p {
            margin: 0;
            color: #666;
            font-size: 14px;
        }
        
        .recent-item .date {
            color: #999;
            font-size: 12px;
        }
        
        .view-all {
            display: block;
            text-align: center;
            margin-top: 15px;
            color: #ff4d4d;
            text-decoration: none;
        }
        
        .view-all:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <div class="sidebar">
            <div class="sidebar-header">
                <img src="../images/logo.png" alt="Logo">
                <h3>Admin Panel</h3>
            </div>
            <ul class="sidebar-menu">
                <li class="active"><a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li><a href="#"><i class="fas fa-users"></i> Users</a></li>
                <li><a href="#"><i class="fas fa-calendar-check"></i> Bookings</a></li>
                <li><a href="#"><i class="fas fa-envelope"></i> Messages</a></li>
                <li><a href="#"><i class="fas fa-images"></i> Gallery</a></li>
                <li><a href="#"><i class="fas fa-cog"></i> Settings</a></li>
            </ul>
        </div>
        
        <div class="main-content">
            <div class="header">
                <h1>Dashboard</h1>
                <div class="user-info">
                    <span>Welcome, <?php echo htmlspecialchars($admin['fullname']); ?></span>
                    <a href="../auth/logout.php" class="logout-btn">Logout</a>
                </div>
            </div>
            
            <div class="dashboard-stats">
                <div class="stat-card">
                    <i class="fas fa-users"></i>
                    <h3><?php echo $user_count; ?></h3>
                    <p>Total Users</p>
                </div>
                <div class="stat-card">
                    <i class="fas fa-calendar-check"></i>
                    <h3><?php echo $booking_count; ?></h3>
                    <p>Total Bookings</p>
                </div>
                <div class="stat-card">
                    <i class="fas fa-envelope"></i>
                    <h3><?php echo $message_count; ?></h3>
                    <p>Total Messages</p>
                </div>
            </div>
            
            <div class="recent-section">
                <h2>Recent Bookings</h2>
                <?php if (!empty($recent_bookings)): ?>
                    <?php foreach ($recent_bookings as $booking): ?>
                        <div class="recent-item">
                            <h4><?php echo htmlspecialchars($booking['event_type']); ?> Event</h4>
                            <p>By <?php echo htmlspecialchars($booking['fullname']); ?></p>
                            <p>Date: <?php echo htmlspecialchars($booking['event_date']); ?> at <?php echo htmlspecialchars($booking['event_time']); ?></p>
                            <p>Status: <span class="status-<?php echo $booking['status']; ?>"><?php echo ucfirst($booking['status']); ?></span></p>
                            <p class="date">Booked on: <?php echo date('M d, Y', strtotime($booking['created_at'])); ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No bookings yet.</p>
                <?php endif; ?>
                <a href="#" class="view-all">View All Bookings</a>
            </div>
            
            <div class="recent-section">
                <h2>Recent Messages</h2>
                <?php if (!empty($recent_messages)): ?>
                    <?php foreach ($recent_messages as $message): ?>
                        <div class="recent-item">
                            <h4><?php echo htmlspecialchars($message['subject']); ?></h4>
                            <p>From: <?php echo htmlspecialchars($message['name']); ?> (<?php echo htmlspecialchars($message['email']); ?>)</p>
                            <p><?php echo substr(htmlspecialchars($message['message']), 0, 100); ?>...</p>
                            <p class="date">Received: <?php echo date('M d, Y', strtotime($message['created_at'])); ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No messages yet.</p>
                <?php endif; ?>
                <a href="#" class="view-all">View All Messages</a>
            </div>
        </div>
    </div>
</body>
</html>