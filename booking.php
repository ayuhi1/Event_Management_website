<?php
session_start();

// Include database connection
require_once 'config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page with a return URL
    header('Location: login.php?redirect=booking.php');
    exit;
}

// Get user information
$user_id = $_SESSION['user_id'];
$user_fullname = $_SESSION['user_fullname'];

// Initialize venues array
$venues = [
    'Wedding' => [],
    'Birthday' => [],
    'Anniversary' => [],
    'Corporate' => [],
    'Other' => []
];

// Fetch venues from database
try {
    $stmt = $pdo->query("SELECT * FROM venues WHERE is_active = 1 ORDER BY event_type, name");
    $db_venues = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Organize venues by event type
    foreach ($db_venues as $venue) {
        $type = ucfirst($venue['event_type']);
        // Map database event types to our categories
        switch ($type) {
            case 'Wedding':
            case 'Birthday':
            case 'Anniversary':
                // These match directly
                break;
            case 'Corporate':
                $type = 'Corporate';
                break;
            default:
                $type = 'Other';
        }
        
        // Add venue to appropriate category
        if (!isset($venues[$type])) {
            $venues[$type] = [];
        }
        
        $venues[$type][] = [
            'id' => $venue['id'],
            'name' => $venue['name'],
            'price' => '₹' . number_format($venue['price'], 2),
            'raw_price' => $venue['price'],
            'image' => $venue['image'],
            'description' => $venue['description']
        ];
    }
} catch (PDOException $e) {
    // If there's an error, we'll use empty arrays
    error_log("Error fetching venues: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book an Event - Classic Events</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/dropdown.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/profile-dropdown.css">
    <link rel="stylesheet" href="css/venues.css">
    <style>
        /* Booking Page Specific Styles */
        .booking-hero {
            position: relative;
            height: 40vh;
            background: url('images/wedding1.jpeg') center/cover no-repeat;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
        }

        .booking-hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            z-index: 1;
        }

        .booking-hero-content {
            position: relative;
            z-index: 2;
            max-width: 800px;
            padding: 0 2rem;
        }

        .booking-hero h1 {
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        .booking-hero p {
            font-size: 1.2rem;
            margin-bottom: 0;
        }

        .booking-section {
            padding: 4rem 2rem;
            background-color: #f9f9f9;
        }

        .booking-container {
            max-width: 800px;
            margin: 0 auto;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            padding: 2.5rem;
        }

        .booking-title {
            text-align: center;
            margin-bottom: 2rem;
            color: #333;
        }

        .booking-title span {
            color: #8a2be2;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: #666;
            font-size: 0.9rem;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 0.8rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            border-color: #8a2be2;
            outline: none;
        }

        .form-group textarea {
            min-height: 120px;
            resize: vertical;
        }

        .form-row {
            display: flex;
            gap: 20px;
        }

        .form-row .form-group {
            flex: 1;
        }

        .submit-btn {
            background-color: #8a2be2;
            color: white;
            padding: 1rem 2rem;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
            width: 100%;
        }

        .submit-btn:hover {
            background-color: #9f3eff;
        }

        /* Alert styles */
        
        /* Venue selection and booking form visibility */
        .hidden {
            display: none;
        }
        
        .active {
            display: block;
        }
        
        /* Initially hide the booking form */
        #bookingFormContainer {
            display: none;
        }
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        @media (max-width: 768px) {
            .form-row {
                flex-direction: column;
                gap: 0;
            }

            .booking-hero h1 {
                font-size: 2.5rem;
            }

            .booking-hero p {
                font-size: 1rem;
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
                <?php echo substr($user_fullname, 0, 1); ?>
                <div class="profile-dropdown">
                    <?php if(isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'admin'): ?>
                        <a href="admin.php"><i class="fas fa-tachometer-alt"></i> Admin Dashboard</a>
                    <?php endif; ?>
                    <a href="profile.php"><i class="fas fa-user"></i> My Profile</a>
                    <a href="auth/logout.php" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</a>
                </div>
            </div>
        </nav>
    </header>

    <main>
        <section class="booking-hero">
            <div class="booking-hero-content">
                <h1>Book Your Event</h1>
                <p>Let us help you create an unforgettable experience</p>
            </div>
        </section>

        <section class="booking-section">
            <!-- Display success or error messages if they exist -->
            <?php if(isset($_SESSION['booking_success'])): ?>
            <div class="alert alert-success">
                <?php echo $_SESSION['booking_success']; ?>
                <?php unset($_SESSION['booking_success']); ?>
            </div>
            <?php endif; ?>
            <?php if(isset($_SESSION['booking_error'])): ?>
            <div class="alert alert-error">
                <?php echo $_SESSION['booking_error']; ?>
                <?php unset($_SESSION['booking_error']); ?>
            </div>
            <?php endif; ?>
            
            <!-- Venue Selection Section -->
            <div class="venues-section" id="venuesSection">
                <div class="venues-container">
                    <h2 class="venues-title">Select a <span>Venue</span></h2>
                    <p style="text-align: center; margin-bottom: 2rem;">Please select an event type to view available venues</p>
                    
                    <div class="form-group" style="max-width: 400px; margin: 0 auto 3rem;">
                        <label for="venue_event_type">Event Type</label>
                        <select id="venue_event_type" name="venue_event_type" required>
                            <option value="">Select Event Type</option>
                            <option value="Wedding">Wedding</option>
                            <option value="Birthday">Birthday Party</option>
                            <option value="Anniversary">Anniversary</option>
                            <option value="Corporate">Corporate Event</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    
                    <div class="venues-grid" id="venuesGrid">
                        <!-- Venues will be loaded here dynamically -->
                    </div>
                </div>
            </div>
            
            <!-- Booking Form Section -->
            <div class="booking-form-container" id="bookingFormContainer">
                <div class="booking-container">
                    <h2 class="booking-title">Event <span>Booking Form</span></h2>
                    
                    <?php
                    if(isset($_SESSION['booking_success'])) {
                        echo '<div class="alert alert-success">' . $_SESSION['booking_success'] . '</div>';
                        unset($_SESSION['booking_success']);
                    }
                    if(isset($_SESSION['booking_error'])) {
                        echo '<div class="alert alert-error">' . $_SESSION['booking_error'] . '</div>';
                        unset($_SESSION['booking_error']);
                    }
                    ?>
                    
                    <form action="booking_process.php" method="post" id="bookingForm">
                    <div class="form-group">
                        <label for="event_type">Event Type</label>
                        <select id="event_type" name="event_type" required>
                            <option value="">Select Event Type</option>
                            <option value="Wedding">Wedding</option>
                            <option value="Birthday">Birthday Party</option>
                            <option value="Anniversary">Anniversary</option>
                            <option value="Corporate">Corporate Event</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="event_date">Event Date</label>
                            <input type="date" id="event_date" name="event_date" required min="<?php echo date('Y-m-d', strtotime('+3 days')); ?>">
                        </div>
                        
                        <div class="form-group">
                            <label for="event_time">Event Time</label>
                            <input type="time" id="event_time" name="event_time" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="venue">Venue/Location</label>
                        <input type="text" id="venue" name="venue" placeholder="Enter venue or location" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="guests">Number of Guests</label>
                        <input type="number" id="guests" name="guests" min="1" placeholder="Enter number of guests" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="additional_info">Additional Information</label>
                        <textarea id="additional_info" name="additional_info" placeholder="Please provide any additional details or special requirements"></textarea>
                    </div>
                    
                    <button type="submit" class="submit-btn">Submit Booking</button>
                </form>
            </div>
        </section>
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

    <script src="js/script.js"></script>
    <script src="js/auth.js"></script>
    <script>
        // Venue selection functionality
        document.addEventListener('DOMContentLoaded', function() {
            const venueEventTypeSelect = document.getElementById('venue_event_type');
            const venuesGrid = document.getElementById('venuesGrid');
            const venuesSection = document.getElementById('venuesSection');
            const bookingFormContainer = document.getElementById('bookingFormContainer');
            const eventTypeSelect = document.getElementById('event_type');
            const venueInput = document.getElementById('venue');
            
            // Add hidden fields for venue information
            const form = document.getElementById('bookingForm');
            const hiddenVenueNameField = document.createElement('input');
            hiddenVenueNameField.type = 'hidden';
            hiddenVenueNameField.name = 'venue_name';
            hiddenVenueNameField.id = 'venue_name';
            form.appendChild(hiddenVenueNameField);
            
            const hiddenVenuePriceField = document.createElement('input');
            hiddenVenuePriceField.type = 'hidden';
            hiddenVenuePriceField.name = 'venue_price';
            hiddenVenuePriceField.id = 'venue_price';
            form.appendChild(hiddenVenuePriceField);
            
            // Venue data from PHP
            const venuesData = <?php echo json_encode($venues); ?>;
            
            venueEventTypeSelect.addEventListener('change', function() {
                const selectedEventType = this.value;
                venuesGrid.innerHTML = '';
                
                if (selectedEventType && venuesData[selectedEventType]) {
                    const venues = venuesData[selectedEventType];
                    
                    if (venues.length === 0) {
                        // No venues available for this event type
                        const noVenuesMessage = document.createElement('div');
                        noVenuesMessage.className = 'no-venues-message';
                        noVenuesMessage.innerHTML = `<p>No venues available for ${selectedEventType} events. Please select another event type or contact us for custom arrangements.</p>`;
                        noVenuesMessage.style.textAlign = 'center';
                        noVenuesMessage.style.padding = '20px';
                        noVenuesMessage.style.color = '#666';
                        venuesGrid.appendChild(noVenuesMessage);
                    } else {
                        venues.forEach(venue => {
                            const venueCard = document.createElement('div');
                            venueCard.className = 'venue-card';
                            
                            // Use a default image if the venue image doesn't exist
                            const imageUrl = venue.image || 'images/default_venue.jpg';
                            
                            venueCard.innerHTML = `
                                <div class="venue-image">
                                    <img src="${imageUrl}" alt="${venue.name}" onerror="this.src='images/default_venue.jpg'">
                                </div>
                                <div class="venue-details">
                                    <h3 class="venue-name">${venue.name}</h3>
                                    <p class="venue-price">${venue.price}</p>
                                    <p class="venue-description">${venue.description || 'No description available'}</p>
                                    <button type="button" class="select-venue-btn">Select Venue</button>
                                </div>
                            `;
                            
                            venuesGrid.appendChild(venueCard);
                            
                            // Add event listener to the select button
                            const selectButton = venueCard.querySelector('.select-venue-btn');
                            selectButton.addEventListener('click', function() {
                                // Set the event type in the booking form
                                eventTypeSelect.value = selectedEventType;
                                
                                // Set the venue name in the booking form
                                venueInput.value = venue.name;
                                
                                // Set hidden fields
                                hiddenVenueNameField.value = venue.name;
                                hiddenVenuePriceField.value = venue.raw_price || venue.price;
                                
                                // Add venue ID field if it exists
                                if (venue.id) {
                                    // Check if venue ID field already exists
                                    let hiddenVenueIdField = document.getElementById('venue_id');
                                    if (!hiddenVenueIdField) {
                                        hiddenVenueIdField = document.createElement('input');
                                        hiddenVenueIdField.type = 'hidden';
                                        hiddenVenueIdField.name = 'venue_id';
                                        hiddenVenueIdField.id = 'venue_id';
                                        form.appendChild(hiddenVenueIdField);
                                    }
                                    hiddenVenueIdField.value = venue.id;
                                }
                                
                                // Hide venues section and show booking form
                                venuesSection.classList.add('hidden');
                                bookingFormContainer.style.display = 'block'; // Directly set display style instead of using class
                                
                                // Scroll to booking form
                                bookingFormContainer.scrollIntoView({ behavior: 'smooth' });
                            });
                        });
                    }
                }
            });
            
            // Add back button to booking form
            const backButton = document.createElement('button');
            backButton.type = 'button';
            backButton.className = 'back-btn';
            backButton.textContent = 'Back to Venues';
            backButton.style.cssText = 'background-color: #666; color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 4px; margin-bottom: 1.5rem; cursor: pointer;';
            
            const bookingTitle = bookingFormContainer.querySelector('.booking-title');
            bookingFormContainer.insertBefore(backButton, bookingTitle.nextSibling);
            
            backButton.addEventListener('click', function() {
                bookingFormContainer.style.display = 'none'; // Directly set display style
                venuesSection.classList.remove('hidden');
                venuesSection.scrollIntoView({ behavior: 'smooth' });
            });
        });
    </script>
</body>
</html>