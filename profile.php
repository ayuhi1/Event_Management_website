<?php
session_start();

// Include database connection
require_once 'config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page with a return URL
    header('Location: login.php?redirect=profile.php');
    exit;
}

// Get user information
$user_id = $_SESSION['user_id'];
$user_fullname = $_SESSION['user_fullname'];
$user_email = $_SESSION['user_email'];

// Fetch user's bookings
$bookings = [];
try {
    $stmt = $pdo->prepare("SELECT b.*, v.name as venue_name, v.image as venue_image 
                          FROM bookings b 
                          LEFT JOIN venues v ON b.venue_id = v.id 
                          WHERE b.user_id = ? 
                          ORDER BY b.event_date DESC");
    $stmt->execute([$user_id]);
    $bookings = $stmt->fetchAll();
} catch (PDOException $e) {
    $error_message = "Error fetching bookings: " . $e->getMessage();
}

// Handle status messages
$status_message = '';
if (isset($_SESSION['profile_message'])) {
    $status_message = $_SESSION['profile_message'];
    unset($_SESSION['profile_message']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - Classic Events</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/dropdown.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/profile-dropdown.css">
    <style>
        body{
            background-color:rgb(156, 85, 221);
        }
        .profile-container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border-radius: 8px;
        }
        
        .profile-header {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #eee;
        }
        
        .profile-avatar {
            width: 100px;
            height: 100px;
            background-color: #ff6b6b;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            color: white;
            margin-right: 20px;
        }
        
        .profile-info h1 {
            margin: 0 0 10px 0;
            color: #333;
        }
        
        .profile-info p {
            margin: 0;
            color: #666;
        }
        
        .bookings-section h2 {
            margin-bottom: 20px;
            color: #333;
        }
        
        .bookings-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        
        .bookings-table th, .bookings-table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
        .bookings-table th {
            background-color: #f8f9fa;
            font-weight: 600;
        }
        
        .bookings-table tr:hover {
            background-color: #f5f5f5;
        }
        
        .status-badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
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
            color: #155724;
        }
        
        .status-cancelled {
            background-color: #f8d7da;
            color: #721c24;
        }
        
        .action-buttons {
            display: flex;
            gap: 10px;
        }
        
        .action-buttons a, .action-buttons button {
            padding: 6px 12px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 14px;
            cursor: pointer;
            border: none;
        }
        
        .contact-btn {
            background-color: #17a2b8;
            color: white;
        }
        
        .delete-btn {
            background-color: #dc3545;
            color: white;
        }
        
        .no-bookings {
            text-align: center;
            padding: 40px 0;
            color: #666;
        }
        
        .status-message {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
            background-color: #d4edda;
            color: #155724;
            display: none;
        }
        
        .status-message.show {
            display: block;
        }
        
        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.5);
        }
        
        .modal-content {
            background-color: #fefefe;
            margin: 10% auto;
            padding: 20px;
            border-radius: 8px;
            width: 50%;
            max-width: 500px;
        }
        
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }
        
        .close:hover {
            color: black;
        }
        
        .modal-form {
            margin-top: 20px;
        }
        
        .modal-form textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            resize: vertical;
            min-height: 100px;
        }
        
        .modal-form button {
            padding: 10px 15px;
            background-color: #ff6b6b;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        
        .venue-image {
            width: 80px;
            height: 60px;
            object-fit: cover;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div style="padding: 20px; background-color: #f8f9fa; box-shadow: 0 2px 5px rgba(0,0,0,0.1); position: relative; z-index: 100;">
        <div style="max-width: 1200px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center;">
            <a href="index.php" class="back-btn" style="display: inline-flex; align-items: center; text-decoration: none; color: #333; font-weight: 500; transition: color 0.3s;">
                <i class="fas fa-arrow-left" style="margin-right: 8px;"></i> Back to Home
            </a>
            <a href="#" id="logout-btn" class="logout-btn" style="display: inline-flex; align-items: center; text-decoration: none; color: #dc3545; font-weight: 500; transition: color 0.3s;">
                <i class="fas fa-sign-out-alt" style="margin-right: 8px;"></i> Logout
            </a>
        </div>
    </div>
    
    <div class="profile-container">
        <?php if (!empty($status_message)): ?>
        <div class="status-message show">
            <?php echo $status_message; ?>
        </div>
        <?php endif; ?>
        
        <div class="profile-header">
            <div class="profile-avatar">
                <?php echo substr($user_fullname, 0, 1); ?>
            </div>
            <div class="profile-info">
                <h1><?php echo htmlspecialchars($user_fullname); ?></h1>
                <p><?php echo htmlspecialchars($user_email); ?></p>
            </div>
        </div>
        
        <div class="bookings-section">
            <h2>My Bookings</h2>
            
            <?php if (empty($bookings)): ?>
                <div class="no-bookings">
                    <p>You don't have any bookings yet.</p>
                    <a href="booking.php" class="btn">Book an Event</a>
                </div>
            <?php else: ?>
                <table class="bookings-table">
                    <thead>
                        <tr>
                            <th>Event</th>
                            <th>Venue</th>
                            <th>Date & Time</th>
                            <th>Guests</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($bookings as $booking): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($booking['event_type']); ?></td>
                                <td>
                                    <?php if (!empty($booking['venue_image'])): ?>
                                        <img src="<?php echo htmlspecialchars($booking['venue_image']); ?>" alt="Venue" class="venue-image"><br>
                                    <?php endif; ?>
                                    <?php echo htmlspecialchars($booking['venue']); ?>
                                </td>
                                <td>
                                    <?php 
                                        $date = new DateTime($booking['event_date']);
                                        echo $date->format('M d, Y'); 
                                    ?><br>
                                    <?php 
                                        $time = new DateTime($booking['event_time']);
                                        echo $time->format('h:i A'); 
                                    ?>
                                </td>
                                <td><?php echo htmlspecialchars($booking['guests']); ?></td>
                                <td>
                                    <span class="status-badge status-<?php echo strtolower($booking['status']); ?>">
                                        <?php echo ucfirst($booking['status']); ?>
                                    </span>
                                </td>
                                <td class="action-buttons">
                                    <button class="contact-btn" onclick="openContactModal(<?php echo $booking['id']; ?>)">Contact</button>
                                    <?php if ($booking['status'] === 'pending'): ?>
                                        <a href="delete_booking.php?id=<?php echo $booking['id']; ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this booking?')">Delete</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Contact Modal -->
    <div id="contactModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Contact About Booking</h2>
            <form id="contactForm" class="modal-form" action="contact_organizer.php" method="post">
                <input type="hidden" id="booking_id" name="booking_id" value="">
                <textarea name="message" placeholder="Your message to the event organizer..." required></textarea>
                <button type="submit">Send Message</button>
            </form>
        </div>
    </div>
    
    <!-- Logout Confirmation Modal -->
    <div id="logoutModal" class="modal">
        <div class="modal-content">
            <span class="close logout-close">&times;</span>
            <h2>Confirm Logout</h2>
            <p>Are you sure you want to logout?</p>
            <div style="display: flex; justify-content: space-between; margin-top: 20px;">
                <button class="action-buttons cancel-btn" style="background-color: #6c757d; color: white;">Cancel</button>
                <a href="auth/logout_process.php" class="action-buttons delete-btn" style="text-decoration: none; text-align: center;">Logout</a>
            </div>
        </div>
    </div>
    
    <script>
        // Show status message and fade out after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const statusMessage = document.querySelector('.status-message');
            if (statusMessage && statusMessage.classList.contains('show')) {
                setTimeout(function() {
                    statusMessage.style.opacity = '0';
                    statusMessage.style.transition = 'opacity 1s';
                    setTimeout(function() {
                        statusMessage.style.display = 'none';
                    }, 1000);
                }, 5000);
            }
            
            // Contact Modal functionality
            const contactModal = document.getElementById('contactModal');
            const contactCloseBtn = document.querySelector('.close');
            
            contactCloseBtn.onclick = function() {
                contactModal.style.display = 'none';
            }
            
            // Logout Modal functionality
            const logoutModal = document.getElementById('logoutModal');
            const logoutBtn = document.getElementById('logout-btn');
            const logoutCloseBtn = document.querySelector('.logout-close');
            const cancelBtn = document.querySelector('.cancel-btn');
            
            logoutBtn.onclick = function(e) {
                e.preventDefault();
                logoutModal.style.display = 'block';
            }
            
            logoutCloseBtn.onclick = function() {
                logoutModal.style.display = 'none';
            }
            
            cancelBtn.onclick = function() {
                logoutModal.style.display = 'none';
            }
            
            // Close modals when clicking outside
            window.onclick = function(event) {
                if (event.target == contactModal) {
                    contactModal.style.display = 'none';
                }
                if (event.target == logoutModal) {
                    logoutModal.style.display = 'none';
                }
            }
        });
        
        function openContactModal(bookingId) {
            document.getElementById('booking_id').value = bookingId;
            contactModal.style.display = 'block';
        }
    </script>
    <script src="js/script.js"></script>
</body>
</html>