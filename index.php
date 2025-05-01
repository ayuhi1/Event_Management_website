<?php
session_start();

// Check if session exists but localStorage might be cleared 
$session_user_data = null;
if(isset($_SESSION['user_id'])) {
    $session_user_data = json_encode([
        'id' => $_SESSION['user_id'],
        'email' => $_SESSION['user_email'],
        'fullname' => $_SESSION['user_fullname'],
        'user_type' => $_SESSION['user_type']
    ]);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Occasion</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/dropdown.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/profile-dropdown.css">
</head>

<body>
    <header>
        <nav>
            <div class="logo"><img src="images/logo.png" alt="Logo"></div>
            <ul>
                <li><a href="index.php" class="active">Home</a></li>
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
            <?php if(isset($_SESSION['user_id'])): ?>
    <div class="nav-profile-section" style="display: flex; align-items: center;">
        <div class="user-profile">
            <?php echo substr($_SESSION['user_fullname'], 0, 1); ?>
            <div class="profile-dropdown">
                <?php if(isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'admin'): ?>
                    <a href="admin.php"><i class="fas fa-tachometer-alt"></i> Admin Dashboard</a>
                <?php else: ?>
                    <a href="profile.php"><i class="fas fa-user"></i> My Profile</a>
                <?php endif; ?>
                <a href="auth/logout.php" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
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

    <main>
        <div class="slider-container">
            <div class="slider">
                <div class="slide">
                    <img src="images/slide3.jpeg" alt="Slide 1">
                </div>
                <div class="slide">
                    <img src="images/slide2.jpeg" alt="Slide 2">
                </div>
                <div class="slide">
                    <img src="images/slide1.jpeg" alt="Slide 3">
                </div>
            </div>
            <div class="slider-overlay">
                <h2 class="slider-heading">TAKE A TRIP INTO PARADISE</h2>
                <h1 class="slider-title">Partner with Occasio Event Management <Br> in India</h1>
                <p class="slider-subtitle">INDIA'S #1 EXCLUSIVE EVENT COMPANY</p>
                <div class="slider-social">
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                    <a href="#"><i class="fab fa-facebook"></i></a>
                    <a href="#"><i class="fab fa-linkedin"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                </div>
                <a href="contact.php" class="contact-btn">Contact Us</a>
            </div>
        </div>

        <section class="about-section">
            <div class="what-we-are">
                <h2>WHAT <span>WE ARE</span></h2>
                <p>Classic Events is young and dynamic event management company, which positions itself as "One-Stop Solutions" for all event needs. At Classic Events,we strive to be the most reliable and creative provider of a wide range of services to the clients.</p>
                <p>Classic Events is one of the leading corporate event management companies in India.</p>
                <a href="about.php" class="read-more-btn">Read More</a>
            </div>
            <div class="featured-image">
                <img src="images/home_event.jpg" alt="Featured Event">
            </div>
            <div class="specifications">
                <h2>OUR SPECIFICATIONS</h2>
                <div class="spec-item">
                    <div class="spec-number">01</div>
                    <div class="spec-content">
                        <h3>Designer Wedding</h3>
                        <p>Classic Events offers comprehensive wedding planning solutions.</p>
                    </div>
                </div>
                <div class="spec-item">
                    <div class="spec-number">02</div>
                    <div class="spec-content">
                        <h3>Destination Wedding</h3>
                        <p>Choose a beautiful location for your wedding function.</p>
                    </div>
                </div>
                <div class="spec-item">
                    <div class="spec-number">03</div>
                    <div class="spec-content">
                        <h3>Theme Wedding</h3>
                        <p>Our wedding themes come with numerous varieties.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="gallery-showcase">
            <div class="gallery-grid">
                <div class="gallery-item">
                    <img src="images/home_slider1.jpeg" alt="Event Design 1">
                </div>
                <div class="gallery-item">
                    <img src="images/home_slider2.jpeg" alt="Event Design 2">
                </div>
                <div class="gallery-item">
                    <img src="images/home_slider3.jpeg" alt="Event Design 3">
                </div>
                <div class="gallery-item">
                    <img src="images/home_slider4.jpeg" alt="Event Design 4">
                </div>
                <div class="gallery-item">
                    <img src="images/home_slider5.jpeg" alt="Event Design 5">
                </div>
            </div>
        </section>

        <section class="services-section">
            <h2 class="section-title">OUR SERVICES</h2> 
            <h3 class="services-heading">Services by Occasion Event Management</h3>
            <p class="services-description">Occasion Event Management is a certified event management company based in India. We offer excellent, comprehensive event management services, including personal event planning, corporate events and conferences, private parties, trade exhibitions, virtual event management services, and entertaining stage shows all over India.</p>
            
            <div class="services-grid">
                <div class="service-card">
                    <img src="images/wedding1.jpeg" alt="Corporate Event Management">
                    <h4>Promise Wedding Lounge</h4>
                    <p>If you want to make a statement at your wedding event, partner with Occasio Event Management Company.</p>
                    <a href="wedding.php" class="learn-more">Book Now »</a>
                </div>

                <div class="service-card">
                    <img src="images/anni1.webp" alt="Wedding Planners">
                    <h4>Golden Years Celebration</h4>
                    <p>Have you ever dreamed of planning the perfect anniversary event to be remembered forever?</p>
                    <a href="anniversary.php" class="learn-more">Book Now »</a>
                </div>

                <div class="service-card">
                    <img src="images/birthday1.jpg" alt="Destination Wedding In India">
                    <h4>The Big Day Bash</h4>
                    <p>Celebrate your special day in paradise with us. Make your birthdays unforgettable and joyful.</p>
                    <a href="birthday.php" class="learn-more">Book Now »</a>
                </div>

                <div class="service-card">
                    <img src="images/Party1.jpeg" alt="Virtual Event Management">
                    <h4>Eventure Collective</h4>
                    <p>Experience seamless virtual events with our cutting-edge technology and expert management services!</p>
                    <a href="other-events.php" class="learn-more">Book Now »</a>
                </div>
            </div>
        </section>
    </main>

    <footer>
        <div class="footer-content">
            <div class="footer-section">
                <img src="images/logo.png" alt="Logo" class="footer-logo">
                <p class="footer-description">Occasio®️ Event Management is a certified event management company offering comprehensive services for all your event needs across India.</p>
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
    // Synchronize PHP session with localStorage
    document.addEventListener('DOMContentLoaded', function() {
        const sessionUserData = <?php echo isset($session_user_data) ? $session_user_data : 'null'; ?>;
        const localStorageUser = JSON.parse(localStorage.getItem('currentUser'));
        
        // If we have session data but no localStorage data, update localStorage
        if (sessionUserData && !localStorageUser) {
            localStorage.setItem('currentUser', JSON.stringify(sessionUserData));
            // Force UI update
            checkUserLoggedIn();
        }
        // If we have no session data but localStorage data exists, clear localStorage
        else if (!sessionUserData && localStorageUser) {
            localStorage.removeItem('currentUser');
            // Force UI update
            showAuthButtons();
        }
    });
    </script>
</body>
</html>