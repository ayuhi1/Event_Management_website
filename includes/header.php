<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Classic Events</title>
    <link rel="stylesheet" href="/Event_Management_website/css/style.css">
    <link rel="stylesheet" href="/Event_Management_website/css/dropdown.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="/Event_Management_website/css/profile-dropdown.css">
</head>
<body>
    <header>
        <nav>
            <div class="logo"><img src="/Event_Management_website/images/logo.png" alt="Logo"></div>
            <ul>
                <li><a href="/Event_Management_website/index.php">Home</a></li>
                <li><a href="/Event_Management_website/about.php">About Us</a></li>
                <li><a href="#">Services</a>
                    <ul class="dropdown">
                        <li><a href="/Event_Management_website/wedding.php">Wedding</a></li>
                        <li><a href="/Event_Management_website/birthday.php">Birthday Party</a></li>
                        <li><a href="/Event_Management_website/anniversary.php">Anniversary</a></li>
                        <li><a href="/Event_Management_website/other-events.php">Other Events</a></li>
                    </ul>
                </li>
                <li><a href="/Event_Management_website/gallery.php">Gallery</a></li>
                <li><a href="/Event_Management_website/contact.php">Contact Us</a></li>
            </ul>
            <?php if(isset($_SESSION['user_id'])): ?>
            <div class="nav-profile-section" style="display: flex; align-items: center;">
                <?php if(!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin'): ?>
                <a href="/Event_Management_website/profile.php" class="profile-btn" style="margin-right: 10px; text-decoration: none; background-color: #ff6b6b; color: white; padding: 8px 15px; border-radius: 4px; font-size: 14px; display: flex; align-items: center;">
                    <i class="fas fa-user" style="margin-right: 5px;"></i> Profile
                </a>
                <?php endif; ?>
                <div class="user-profile">
                    <?php echo substr($_SESSION['user_fullname'] ?? 'User', 0, 1); ?>
                    <div class="profile-dropdown">
                        <?php if(isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'admin'): ?>
                            <a href="/Event_Management_website/admin.php"><i class="fas fa-tachometer-alt"></i> Admin Dashboard</a>
                        <?php else: ?>
                            <a href="/Event_Management_website/profile.php"><i class="fas fa-user"></i> My Profile</a>
                        <?php endif; ?>
                        <a href="/Event_Management_website/auth/logout.php" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</a>
                    </div>
                </div>
            </div>
            <?php else: ?>
            <div class="auth-buttons">
                <a href="/Event_Management_website/login.php" class="login-btn">Login</a>
                <a href="/Event_Management_website/signup.php" class="signin-btn">Sign Up</a>
            </div>
            <?php endif; ?>
        </nav>
    </header>