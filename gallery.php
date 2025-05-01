<?php
session_start();
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery - Classic Events</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/dropdown.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/profile-dropdown.css">
    <link rel="stylesheet" href="css/gallery.css">
    <!-- Lightbox CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">
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
                <li><a href="gallery.php" class="active">Gallery</a></li>
                <li><a href="contact.php">Contact Us</a></li>
            </ul>
            <?php if(isset($_SESSION['user_id'])): ?>
                <div class="user-profile">
                    <?php echo substr($_SESSION['user_fullname'], 0, 1); ?>
                    <div class="profile-dropdown">
                        <?php if($_SESSION['user_type'] === 'admin'): ?>
                            <a href="admin.php"><i class="fas fa-tachometer-alt"></i> Admin Dashboard</a>
                        <?php endif; ?>
                        <a href="profile.php"><i class="fas fa-user"></i> My Profile</a>
                        <a href="auth/logout.php" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</a>
                    </div>
                </div>
            <?php else: ?>
                <div class="auth-buttons">
                    <a href="login.php" class="login-btn">Login</a>
                    <a href="signup.php" class="signin-btn">Sign Up</a>
                </div>
            <?php endif; ?>
        </nav>
    </header>

    <div class="gallery-hero">
        <div class="gallery-hero-content">
            <h1>Our Event Gallery</h1>
            <p>Browse through our collection of memorable events and celebrations we've had the privilege to organize and manage.</p>
        </div>
    </div>

    <section class="gallery-section">
        <div class="gallery-container">
            <div class="gallery-filters">
                <button class="filter-btn active" data-filter="all">All Events</button>
                <button class="filter-btn" data-filter="wedding">Weddings</button>
                <button class="filter-btn" data-filter="birthday">Birthdays</button>
                <button class="filter-btn" data-filter="corporate">Corporate</button>
                <button class="filter-btn" data-filter="anniversary">Anniversaries</button>
            </div>
            
            <div class="gallery-grid">
                <!-- Wedding Events -->
                <div class="gallery-item wedding">
                    <a href="images/wed_page1.jpeg" data-lightbox="gallery" data-title="Elegant Wedding Ceremony">
                        <img src="images/wed_page1.jpeg" alt="Wedding Event 1">
                        <div class="gallery-item-overlay">
                            <h3>Elegant Wedding Ceremony</h3>
                            <p>A beautiful wedding ceremony at a beachside resort</p>
                        </div>
                    </a>
                </div>
                <div class="gallery-item wedding">
                    <a href="images/wed_page_2.jpeg" data-lightbox="gallery" data-title="Luxury Wedding Reception">
                        <img src="images/wed_page_2.jpeg" alt="Wedding Event 2">
                        <div class="gallery-item-overlay">
                            <div class="gallery-info">
                                <h3>Luxury Wedding Reception</h3>
                                <p>An opulent wedding reception with exquisite decorations</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="gallery-item wedding">
                    <a href="images/wed_page3.png" data-lightbox="gallery" data-title="Traditional Wedding Celebration">
                        <img src="images/wed_page3.png" alt="Wedding Event 3">
                        <div class="gallery-item-overlay">
                            <h3>Traditional Wedding</h3>
                            <p>Traditional Wedding Ceremony</p>
                        </div>
                    </a>
                </div>
                
                <!-- Birthday Events -->
                <div class="gallery-item birthday">
                    <a href="images/party_page_!.jpeg" data-lightbox="gallery" data-title="Colorful Birthday Party">
                        <img src="images/party_page_!.jpeg" alt="Birthday Event 1">
                        <div class="gallery-item-overlay">
                            <div class="gallery-info">
                                <h3>Colorful Birthday Party</h3>
                                <p>A vibrant birthday celebration with fun activities</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="gallery-item birthday">
                    <a href="images/theme_services.jpg" data-lightbox="gallery" data-title="Themed Birthday Celebration">
                        <img src="images/theme_services.jpg" alt="Birthday Event 2">
                        <div class="gallery-item-overlay">
                            <div class="gallery-info">
                                <h3>Themed Birthday Celebration</h3>
                                <p>A creatively themed birthday party for all ages</p>
                            </div>
                        </div>
                    </a>
                </div>
                
                <!-- Corporate Events -->
                <div class="gallery-item corporate">
                    <a href="images/corporate_con.jpg" data-lightbox="gallery" data-title="Corporate Conference">
                        <img src="images/corporate_con.jpg" alt="Corporate Event 1">
                        <div class="gallery-item-overlay">
                            <div class="gallery-info">
                                <h3>Corporate Conference</h3>
                                <p>A professional business conference with modern amenities</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="gallery-item corporate">
                    <a href="images/social_gathring.jpg" data-lightbox="gallery" data-title="Team Building Event">
                        <img src="images/social_gathring.jpg" alt="Corporate Event 2">
                        <div class="gallery-item-overlay">
                            <div class="gallery-info">
                                <h3>Team Building Event</h3>
                                <p>An engaging team building activity for corporate clients</p>
                            </div>
                        </div>
                    </a>
                </div>
                
                <!-- Anniversary Events -->
                <div class="gallery-item anniversary">
                    <a href="images/anni_page_1.jpeg" data-lightbox="gallery" data-title="Silver Anniversary Celebration">
                        <img src="images/anni_page_1.jpeg" alt="Anniversary Event 1">
                        <div class="gallery-item-overlay">
                            <div class="gallery-info">
                                <h3>Silver Anniversary Celebration</h3>
                                <p>A beautiful 25th anniversary celebration</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="gallery-item anniversary">
                    <a href="images/anni_page_2.jpeg" data-lightbox="gallery" data-title="Golden Anniversary Party">
                        <img src="images/anni_page_2.jpeg" alt="Anniversary Event 2">
                        <div class="gallery-item-overlay">
                            <div class="gallery-info">
                                <h3>Golden Anniversary Party</h3>
                                <p>An elegant 50th anniversary celebration</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="gallery-item anniversary">
                    <a href="images/anni_page_3.jpeg" data-lightbox="gallery" data-title="Anniversary Dinner">
                        <img src="images/anni_page_3.jpeg" alt="Anniversary Event 3">
                        <div class="gallery-item-overlay">
                            <div class="gallery-info">
                                <h3>Anniversary Dinner</h3>
                                <p>An intimate anniversary dinner celebration</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="gallery-item wedding">
                    <a href="images/elegant_wedding1.jpeg" data-lightbox="gallery" data-title="Elegant Wedding Ceremony">
                        <img src="images/elegant_wedding1.jpeg" alt="Wedding Event 1">
                        <div class="gallery-item-overlay">
                            <h3>Elegant Wedding Ceremony</h3>
                            <p>A beautiful wedding ceremony at a beachside resort</p>
                        </div>
                    </a>
                </div>
                <div class="gallery-item wedding">
                    <a href="images/reception_1.jpeg" data-lightbox="gallery" data-title="Luxury Wedding Reception">
                        <img src="images/reception_1.jpeg" alt="Wedding Event 2">
                        <div class="gallery-item-overlay">
                            <div class="gallery-info">
                                <h3>Luxury Wedding Reception</h3>
                                <p>An opulent wedding reception with exquisite decorations</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="gallery-item wedding">
                    <a href="images/reception_2.png" data-lightbox="gallery" data-title="Traditional Wedding Celebration">
                        <img src="images/reception_2.png" alt="Wedding Event 3">
                        <div class="gallery-item-overlay">
                            <h3>Traditional Wedding</h3>
                            <p>Traditional Wedding Ceremony</p>
                        </div>
                    </a>
                </div>
                
                <!-- Birthday Events -->
                <div class="gallery-item birthday">
                    <a href="images/venue_birthday.jpg" data-lightbox="gallery" data-title="Colorful Birthday Party">
                        <img src="images/venue_birthday.jpg" alt="Birthday Event 1">
                        <div class="gallery-item-overlay">
                            <div class="gallery-info">
                                <h3>Colorful Birthday Party</h3>
                                <p>A vibrant birthday celebration with fun activities</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="gallery-item birthday">
                    <a href="images/party_page_2.jpg" data-lightbox="gallery" data-title="Themed Birthday Celebration">
                        <img src="images/party_page_2.jpg" alt="Birthday Event 2">
                        <div class="gallery-item-overlay">
                            <div class="gallery-info">
                                <h3>Themed Birthday Celebration</h3>
                                <p>A creatively themed birthday party for all ages</p>
                            </div>
                        </div>
                    </a>
                </div>
                
                <!-- Corporate Events -->
                <div class="gallery-item corporate">
                    <a href="images/corporate_events.jpg" data-lightbox="gallery" data-title="Corporate Conference">
                        <img src="images/corporate_events.jpg" alt="Corporate Event 1">
                        <div class="gallery-item-overlay">
                            <div class="gallery-info">
                                <h3>Corporate Conference</h3>
                                <p>A professional business conference with modern amenities</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="gallery-item corporate">
                    <a href="images/about_2.jpg" data-lightbox="gallery" data-title="Team Building Event">
                        <img src="images/about_2.jpg" alt="Corporate Event 2">
                        <div class="gallery-item-overlay">
                            <div class="gallery-info">
                                <h3>Team Building Event</h3>
                                <p>An engaging team building activity for corporate clients</p>
                            </div>
                        </div>
                    </a>
                </div>
                
                <!-- Anniversary Events -->
                <div class="gallery-item anniversary">
                    <a href="images/silver_25.jpeg" data-lightbox="gallery" data-title="Silver Anniversary Celebration">
                        <img src="images/silver_25.jpeg" alt="Anniversary Event 1">
                        <div class="gallery-item-overlay">
                            <div class="gallery-info">
                                <h3>Silver Anniversary Celebration</h3>
                                <p>A beautiful 25th anniversary celebration</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="gallery-item anniversary">
                    <a href="images/golden_2.jpeg" data-lightbox="gallery" data-title="Golden Anniversary Party">
                        <img src="images/golden_2.jpeg" alt="Anniversary Event 2">
                        <div class="gallery-item-overlay">
                            <div class="gallery-info">
                                <h3>Golden Anniversary Party</h3>
                                <p>An elegant 50th anniversary celebration</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="gallery-item anniversary">
                    <a href="images/about_3.jpg" data-lightbox="gallery" data-title="Anniversary Dinner">
                        <img src="images/about_3.jpg" alt="Anniversary Event 3">
                        <div class="gallery-item-overlay">
                            <div class="gallery-info">
                                <h3>Anniversary Dinner</h3>
                                <p>An intimate anniversary dinner celebration</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="cta-section">
        <div class="cta-container">
            <h2>Ready to Create Your Own Memorable Event?</h2>
            <p>Contact us today to start planning your special occasion with our expert team.</p>
            <a href="contact.php" class="cta-button">Get in Touch</a>
        </div>
    </section>

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

    <!-- Lightbox JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
    <script>
        // Initialize Lightbox
        lightbox.option({
            'resizeDuration': 200,
            'wrapAround': true,
            'albumLabel': 'Image %1 of %2'
        });
        
        // Gallery Filtering
        document.addEventListener('DOMContentLoaded', function() {
            const filterButtons = document.querySelectorAll('.filter-btn');
            const galleryItems = document.querySelectorAll('.gallery-item');
            
            filterButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Remove active class from all buttons
                    filterButtons.forEach(btn => btn.classList.remove('active'));
                    
                    // Add active class to clicked button
                    this.classList.add('active');
                    
                    // Get filter value
                    const filterValue = this.getAttribute('data-filter');
                    
                    // Filter gallery items
                    galleryItems.forEach(item => {
                        if (filterValue === 'all' || item.classList.contains(filterValue)) {
                            item.style.display = 'block';
                        } else {
                            item.style.display = 'none';
                        }
                    });
                });
            });
        });
    </script>
    <script src="js/script.js"></script>
    <script src="js/auth.js"></script>
</body>
</html>