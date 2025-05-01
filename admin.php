<?php
require_once 'config.php';
session_start();

// Check if user is logged in and is an admin
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    // Display login/signup page with buttons instead of redirecting
    include_once 'includes/header.php';
    ?>
    <div class="container" style="text-align: center; padding: 50px 20px;">
        <h2>Admin Access Required</h2>
        <p>You need to be logged in as an administrator to access this page.</p>
        <div class="auth-buttons" style="margin-top: 20px;">
            <a href="login.php" class="login-btn" style="background-color: #ff4d4d; color: white; padding: 10px 20px; border-radius: 4px; text-decoration: none; margin-right: 10px;">Login</a>
            <a href="signup.php" class="signin-btn" style="background-color: #333; color: white; padding: 10px 20px; border-radius: 4px; text-decoration: none;">Sign Up</a>
        </div>
    </div>
    <?php
    include_once 'includes/footer.php';
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
        header('Location: login.php');
        exit;
    }
    
    // Get all users
    $stmt = $pdo->query("SELECT * FROM users ORDER BY created_at DESC");
    $users = $stmt->fetchAll();
    
    // Get all messages/feedback
    $stmt = $pdo->query("SELECT * FROM messages ORDER BY created_at DESC");
    $messages = $stmt->fetchAll();
    
    // Get all bookings
    $stmt = $pdo->query("SELECT b.*, u.fullname FROM bookings b JOIN users u ON b.user_id = u.id ORDER BY b.created_at DESC");
    $bookings = $stmt->fetchAll();
    
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
    <title>Admin Panel - Classic Events</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/dropdown.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/profile-dropdown.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }
        
        .admin-container {
            max-width: 1200px;
            margin: 100px auto 30px; /* Increased top margin to fix overlap */
            padding: 20px;
            overflow-x: hidden;
        }
        
        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .admin-title h1 {
            color: #333;
            margin: 0;
        }
        
        .admin-title span {
            color: #8a2be2;
        }
        
        .admin-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            text-align: center;
            transition: transform 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
        }
        
        .stat-card i {
            font-size: 2.5rem;
            color: #8a2be2;
            margin-bottom: 10px;
        }
        
        .stat-card h2 {
            font-size: 2rem;
            margin: 10px 0;
            color: #333;
        }
        
        .stat-card p {
            color: #666;
            margin: 0;
        }
        
        .admin-tabs {
            display: flex;
            margin-bottom: 20px;
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .tab-btn {
            flex: 1;
            padding: 15px;
            text-align: center;
            background-color: #f9f9f9;
            border: none;
            cursor: pointer;
            font-size: 1rem;
            font-weight: bold;
            color: #666;
            transition: all 0.3s ease;
        }
        
        .tab-btn:hover {
            background-color: #f0f0f0;
        }
        
        .tab-btn.active {
            background-color: #8a2be2;
            color: white;
        }
        
        .tab-content {
            display: none;
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 30px;
            overflow-x: auto; /* Fix for table overflow */
        }
        
        .tab-content.active {
            display: block;
        }
        
        .data-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed; /* Fix for column width issues */
        }
        
        .data-table th, .data-table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            word-wrap: break-word; /* Prevents text from overflowing */
        }
        
        /* Status dropdown styling */
        .status-dropdown {
            position: relative;
            display: inline-block;
            width: 100%;
        }
        
        .change-status {
            margin-top: 5px;
            padding: 5px;
            border-radius: 4px;
            border: 1px solid #ddd;
            background-color: #f9f9f9;
            width: 100%;
            cursor: pointer;
        }
        
        .data-table th {
            background-color: #f9f9f9;
            color: #333;
            font-weight: bold;
        }
        
        .data-table tr:hover {
            background-color: #f5f5f5;
        }
        
        .status-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .status-pending {
            background-color: #ffeeba;
            color: #856404;
        }
        
        .status-confirmed {
            background-color: #d4edda;
            color: #155724;
        }
        
        .status-completed {
            background-color: #c3e6cb;
            color: #0f5132;
        }
        
        .status-cancelled {
            background-color: #f8d7da;
            color: #721c24;
        }
        
        .action-btn {
            padding: 6px 12px;
            border-radius: 4px;
            font-size: 0.8rem;
            cursor: pointer;
            border: none;
            transition: background-color 0.3s ease;
        }
        
        .view-btn {
            background-color: #8a2be2;
            color: white;
        }
        
        .view-btn:hover {
            background-color: #7823d8;
        }
        
        .message-card {
            background-color: #f9f9f9;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            border-left: 4px solid #8a2be2;
        }
        
        .message-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        
        .message-sender {
            font-weight: bold;
            color: #333;
        }
        
        .message-date {
            color: #888;
            font-size: 0.9rem;
        }
        
        .message-subject {
            color: #555;
            margin-bottom: 10px;
            font-weight: bold;
        }
        
        .message-body {
            color: #666;
        }
        
        .unread {
            background-color: #f0e6ff;
        }
        
        @media (max-width: 768px) {
            .admin-stats {
                grid-template-columns: 1fr;
            }
            
            .admin-tabs {
                flex-direction: column;
            }
            
            .data-table {
                display: block;
                overflow-x: auto;
            }
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <div class="logo"><img src="images/logo.png" alt="Logo"></div>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="about.php">About Us</a></li>
                <li><a href="#">Services</a>
                    <ul class="dropdown">
                        <li><a href="wedding.php">Wedding</a></li>
                        <li><a href="birthday.php">Birthday Party</a></li>
                        <li><a href="anniversary.php">Anniversary</a></li>
                        <li><a href="other-events.php">Other Events</a></li>
                    </ul>
                </li>
                <li><a href="gallery.php">Gallery</a></li>
                <li><a href="contact.php">Contact Us</a></li>
            </ul>
            <div class="user-profile">
                <?php echo substr($admin['fullname'], 0, 1); ?>
                <div class="profile-dropdown">
                    <a href="admin.php"><i class="fas fa-tachometer-alt"></i> Admin Dashboard</a>
                    <a href="profile.php"><i class="fas fa-user"></i> My Profile</a>
                    <a href="auth/logout.php" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</a>
                </div>
            </div>
        </nav>
    </header>

    <main>
        <div class="admin-container">
            <div class="admin-header">
                <div class="admin-title">
                    <h1>Admin <span>Panel</span></h1>
                </div>
                <div class="admin-welcome">
                    <p>Welcome, <?php echo $admin['fullname']; ?></p>
                </div>
            </div>
            
            <!-- Notification Messages -->
            <?php if(isset($_SESSION['success'])): ?>
            <div class="alert alert-success" style="background-color: #d4edda; color: #155724; padding: 15px; margin-bottom: 20px; border-radius: 4px; border-left: 4px solid #28a745;">
                <?php echo $_SESSION['success']; ?>
                <?php unset($_SESSION['success']); ?>
            </div>
            <?php endif; ?>
            
            <?php if(isset($_SESSION['error'])): ?>
            <div class="alert alert-danger" style="background-color: #f8d7da; color: #721c24; padding: 15px; margin-bottom: 20px; border-radius: 4px; border-left: 4px solid #dc3545;">
                <?php echo $_SESSION['error']; ?>
                <?php unset($_SESSION['error']); ?>
            </div>
            <?php endif; ?>
            
            <div class="admin-stats">
                <div class="stat-card">
                    <i class="fas fa-users"></i>
                    <h2><?php echo $user_count; ?></h2>
                    <p>Registered Users</p>
                </div>
                <div class="stat-card">
                    <i class="fas fa-calendar-check"></i>
                    <h2><?php echo $booking_count; ?></h2>
                    <p>Total Bookings</p>
                </div>
                <div class="stat-card">
                    <i class="fas fa-envelope"></i>
                    <h2><?php echo $message_count; ?></h2>
                    <p>Messages/Feedback</p>
                </div>
            </div>
            
            <div class="admin-tabs">
                <button class="tab-btn active" onclick="openTab('users')">Users</button>
                <button class="tab-btn" onclick="openTab('bookings')">Bookings</button>
                <button class="tab-btn" onclick="openTab('messages')">Messages/Feedback</button>
                <button class="tab-btn" onclick="openTab('venues')">Venues</button>
            </div>
            
            <!-- Users Tab -->
            <div id="users" class="tab-content active">
                <h2>Registered Users</h2>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>User Type</th>
                            <th>Registered On</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($users)): ?>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><?php echo $user['id']; ?></td>
                                    <td><?php echo $user['fullname']; ?></td>
                                    <td><?php echo $user['email']; ?></td>
                                    <td><?php echo ucfirst($user['user_type']); ?></td>
                                    <td><?php echo date('M d, Y', strtotime($user['created_at'])); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" style="text-align: center;">No users found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            
            <!-- Bookings Tab -->
            <div id="bookings" class="tab-content">
                <h2>Event Bookings</h2>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Customer</th>
                            <th>Event Type</th>
                            <th>Event Date</th>
                            <th>Venue</th>
                            <th>Guests</th>
                            <th>Status</th>
                            <th>Booked On</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($bookings)): ?>
                            <?php foreach ($bookings as $booking): ?>
                                <tr>
                                    <td><?php echo $booking['id']; ?></td>
                                    <td><?php echo $booking['fullname']; ?></td>
                                    <td><?php echo $booking['event_type']; ?></td>
                                    <td><?php echo date('M d, Y', strtotime($booking['event_date'])) . ' at ' . date('h:i A', strtotime($booking['event_time'])); ?></td>
                                    <td><?php echo $booking['venue']; ?></td>
                                    <td><?php echo $booking['guests']; ?></td>
                                    <td>
                                        <div class="status-dropdown">
                                            <span class="status-badge status-<?php echo strtolower($booking['status']); ?>">
                                                <?php echo $booking['status']; ?>
                                            </span>
                                            <select class="change-status" data-booking-id="<?php echo $booking['id']; ?>">
                                                <option value="pending" <?php echo ($booking['status'] == 'pending') ? 'selected' : ''; ?>>Pending</option>
                                                <option value="confirmed" <?php echo ($booking['status'] == 'confirmed') ? 'selected' : ''; ?>>Confirmed</option>
                                                <option value="completed" <?php echo ($booking['status'] == 'completed') ? 'selected' : ''; ?>>Completed</option>
                                                <option value="cancelled" <?php echo ($booking['status'] == 'cancelled') ? 'selected' : ''; ?>>Cancelled</option>
                                            </select>
                                        </div>
                                    </td>
                                    <td><?php echo date('M d, Y', strtotime($booking['created_at'])); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" style="text-align: center;">No bookings found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            
            <!-- Messages Tab -->
            <div id="messages" class="tab-content">
                <h2>Messages & Feedback</h2>
                <?php if (!empty($messages)): ?>
                    <?php foreach ($messages as $message): ?>
                        <div class="message-card <?php echo $message['is_read'] ? '' : 'unread'; ?>">
                            <div class="message-header">
                                <div class="message-sender"><?php echo $message['name']; ?> (<?php echo $message['email']; ?>)</div>
                                <div class="message-date"><?php echo date('M d, Y h:i A', strtotime($message['created_at'])); ?></div>
                            </div>
                            <div class="message-subject"><?php echo $message['subject']; ?></div>
                            <div class="message-body"><?php echo $message['message']; ?></div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p style="text-align: center;">No messages found</p>
                <?php endif; ?>
            </div>
            
            <!-- Venues Tab -->
            <div id="venues" class="tab-content">
                <h2>Manage Venues</h2>
                
                <!-- Add Venue Form -->
                <div class="venue-form-container" style="margin-bottom: 30px; padding: 20px; background-color: #f9f9f9; border-radius: 8px;">
                    <h3>Add New Venue</h3>
                    <form id="addVenueForm" action="venue_process.php" method="post" enctype="multipart/form-data">
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 15px;">
                            <div>
                                <label for="venue_name">Venue Name</label>
                                <input type="text" id="venue_name" name="venue_name" required style="width: 100%; padding: 8px; margin-bottom: 10px; border: 1px solid #ddd; border-radius: 4px;">
                            </div>
                            <div>
                                <label for="event_type">Event Type</label>
                                <select id="event_type" name="event_type" required style="width: 100%; padding: 8px; margin-bottom: 10px; border: 1px solid #ddd; border-radius: 4px;">
                                    <option value="">Select Event Type</option>
                                    <option value="wedding">Wedding</option>
                                    <option value="birthday">Birthday</option>
                                    <option value="anniversary">Anniversary</option>
                                    <option value="other">Other Events</option>
                                </select>
                            </div>
                            <div>
                                <label for="venue_price">Price</label>
                                <input type="text" id="venue_price" name="venue_price" required style="width: 100%; padding: 8px; margin-bottom: 10px; border: 1px solid #ddd; border-radius: 4px;">
                            </div>
                        </div>
                        <div>
                            <label for="venue_image">Venue Image</label>
                            <input type="file" id="venue_image" name="venue_image" required style="width: 100%; padding: 8px; margin-bottom: 10px; border: 1px solid #ddd; border-radius: 4px;">
                        </div>
                        <div>
                            <label for="venue_description">Description</label>
                            <textarea id="venue_description" name="venue_description" rows="4" required style="width: 100%; padding: 8px; margin-bottom: 10px; border: 1px solid #ddd; border-radius: 4px;"></textarea>
                        </div>
                        <button type="submit" style="background-color: #8a2be2; color: white; border: none; padding: 10px 20px; border-radius: 4px; cursor: pointer; font-weight: bold;">Add Venue</button>
                    </form>
                </div>
                
                <!-- Venues Table -->
                <h3>Existing Venues</h3>
                <?php
                // Get all venues
                try {
                    $stmt = $pdo->query("SELECT * FROM venues ORDER BY is_active DESC, event_type, created_at DESC");
                    $venues = $stmt->fetchAll();
                } catch (PDOException $e) {
                    echo "<p>Error loading venues: " . $e->getMessage() . "</p>";
                    $venues = [];
                }
                ?>
                
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Event Type</th>
                            <th>Price</th>
                            <th>Image</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($venues)): ?>
                            <?php foreach ($venues as $venue): ?>
                                <?php $isActive = isset($venue['is_active']) ? (bool)$venue['is_active'] : true; ?>
                                <tr <?php echo !$isActive ? 'style="opacity: 0.6;"' : ''; ?>>
                                    <td><?php echo $venue['id']; ?></td>
                                    <td><?php echo $venue['name']; ?></td>
                                    <td><?php echo ucfirst($venue['event_type']); ?></td>
                                    <td><?php echo $venue['price']; ?></td>
                                    <td><img src="<?php echo $venue['image']; ?>" alt="<?php echo $venue['name']; ?>" style="width: 100px; height: auto;"></td>
                                    <td><?php echo substr($venue['description'], 0, 100) . (strlen($venue['description']) > 100 ? '...' : ''); ?></td>
                                    <td>
                                        <span class="status-badge <?php echo $isActive ? 'status-confirmed' : 'status-cancelled'; ?>">
                                            <?php echo $isActive ? 'Active' : 'Inactive'; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="edit_venue.php?id=<?php echo $venue['id']; ?>" class="action-btn view-btn">Edit</a>
                                        <?php if ($isActive): ?>
                                            <a href="delete_venue.php?id=<?php echo $venue['id']; ?>" class="action-btn" style="background-color: #ff4d4d; color: white;" onclick="return confirm('Are you sure you want to deactivate this venue?')">Deactivate</a>
                                        <?php else: ?>
                                            <a href="activate_venue.php?id=<?php echo $venue['id']; ?>" class="action-btn" style="background-color: #28a745; color: white;">Activate</a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" style="text-align: center;">No venues found. <a href="create_venues_table.php">Create venues table</a></td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            
            <?php
                // Get venues count
                try {
                    $stmt = $pdo->query("SELECT COUNT(*) as total FROM venues");
                    $venue_count = $stmt->fetch()['total'];
                } catch (PDOException $e) {
                    $venue_count = 0;
                }
                
                // Get venue types count
                try {
                    $stmt = $pdo->query("SELECT event_type, COUNT(*) as count FROM venues GROUP BY event_type");
                    $venue_types = $stmt->fetchAll();
                } catch (PDOException $e) {
                    $venue_types = [];
                }
                ?>
                
                <div style="margin-top: 20px; display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;">
                    <div class="stat-card">
                        <i class="fas fa-building"></i>
                        <h2><?php echo $venue_count; ?></h2>
                        <p>Total Venues</p>
                    </div>
                    
                    <?php foreach ($venue_types as $type): ?>
                    <div class="stat-card">
                        <i class="fas fa-tag"></i>
                        <h2><?php echo $type['count']; ?></h2>
                        <p><?php echo ucfirst($type['event_type']); ?> Venues</p>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </main>

    <footer>
        <div class="footer-content">
            <div class="footer-section">
                <img src="images/logo.png" alt="Logo" class="footer-logo">
                <p class="footer-description">Occasio® Event Management is a certified event management company offering comprehensive services for all your event needs across India.</p>
                <div class="social-icons">
                    <a href="#"><i class="fab fa-facebook"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-linkedin"></i></a>
                </div>
            </div>
            
            <div class="footer-section">
                <h3 class="footer-title">Quick Links</h3>
                <ul class="footer-links">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="about.php">About Us</a></li>
                    <li><a href="gallery.php">Gallery</a></li>
                    <li><a href="contact.php">Contact Us</a></li>
                </ul>
            </div>

            <div class="footer-section">
                <h3 class="footer-title">Contact Info</h3>
                <div class="contact-info">
                    <div class="contact-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <p>123 Event Street, Mumbai, India</p>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-phone"></i>
                        <p>+91 123 456 7890</p>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-envelope"></i>
                        <p>info@occasio.com</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2024 Occasio. All rights reserved.</p>
        </div>
    </footer>

    <script>
        function openTab(tabName) {
            // Hide all tab content
            var tabContents = document.getElementsByClassName('tab-content');
            for (var i = 0; i < tabContents.length; i++) {
                tabContents[i].classList.remove('active');
            }
            
            // Remove active class from all tab buttons
            var tabButtons = document.getElementsByClassName('tab-btn');
            for (var i = 0; i < tabButtons.length; i++) {
                tabButtons[i].classList.remove('active');
            }
            
            // Show the selected tab content and mark the button as active
            document.getElementById(tabName).classList.add('active');
            event.currentTarget.classList.add('active');
            
            // Save the active tab to localStorage
            localStorage.setItem('activeAdminTab', tabName);
        }
        
        // Check if there's a saved tab in localStorage
        document.addEventListener('DOMContentLoaded', function() {
            const savedTab = localStorage.getItem('activeAdminTab');
            if (savedTab) {
                // Get the tab button and simulate a click
                const tabButtons = document.getElementsByClassName('tab-btn');
                for (var i = 0; i < tabButtons.length; i++) {
                    if (tabButtons[i].getAttribute('onclick').includes(savedTab)) {
                        openTab(savedTab);
                        tabButtons[i].classList.add('active');
                        break;
                    }
                }
            }
        });
        
        // Add event listeners for status change dropdowns when the DOM is loaded
        document.addEventListener('DOMContentLoaded', function() {
            // Get all status change dropdowns
            var statusDropdowns = document.querySelectorAll('.change-status');
            
            // Add change event listener to each dropdown
            statusDropdowns.forEach(function(dropdown) {
                dropdown.addEventListener('change', function() {
                    var bookingId = this.getAttribute('data-booking-id');
                    var newStatus = this.value;
                    updateBookingStatus(bookingId, newStatus, this);
                });
            });
        });
        
        // Function to update booking status via AJAX
        function updateBookingStatus(bookingId, newStatus, element) {
            // Create a new XMLHttpRequest object
            var xhr = new XMLHttpRequest();
            
            // Configure it to make a POST request to the update_status.php endpoint
            xhr.open('POST', 'update_status.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            
            // Set up the callback for when the request completes
            xhr.onload = function() {
                if (xhr.status === 200) {
                    try {
                        var response = JSON.parse(xhr.responseText);
                        
                        if (response.success) {
                            // Update the status badge
                            var statusBadge = element.previousElementSibling;
                            statusBadge.textContent = newStatus.charAt(0).toUpperCase() + newStatus.slice(1);
                            
                            // Remove all status classes
                            statusBadge.classList.remove('status-pending', 'status-confirmed', 'status-completed', 'status-cancelled');
                            
                            // Add the new status class
                            statusBadge.classList.add('status-' + newStatus);
                            
                            // Show success message
                            alert('Booking status updated successfully!');
                        } else {
                            // Show error message
                            alert('Error: ' + response.message);
                            
                            // Reset the dropdown to the previous value
                            element.value = statusBadge.textContent.toLowerCase();
                        }
                    } catch (e) {
                        alert('Error processing response: ' + e.message);
                    }
                } else {
                    alert('Error updating booking status. Please try again.');
                }
            };
            
            // Handle network errors
            xhr.onerror = function() {
                alert('Network error occurred. Please check your connection and try again.');
            };
            
            // Send the request with the booking ID and new status
            xhr.send('booking_id=' + encodeURIComponent(bookingId) + '&status=' + encodeURIComponent(newStatus));
        }
    </script>
</body>
</html>