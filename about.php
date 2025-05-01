<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Classic Events</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/dropdown.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/profile-dropdown.css">
    <link rel="stylesheet" href="css/about.css">
</head>
<body>
    <header>
        <nav>
            <div class="logo"><img src="images/logo.png" alt="Logo"></div>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="about.php" class="active">About Us</a></li>
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

    <div class="slider-container">
        <div class="slider">
            <div class="slide">
                <img src="images/about1.jpg" alt="Slide 1">
            </div>
            <div class="slide">
                <img src="images/slide2.jpeg" alt="Slide 2">
            </div>
            <div class="slide">
                <img src="images/slide3.jpeg" alt="Slide 3">
            </div>
        </div>
        <div class="slider-overlay">
            <h2 class="slider-heading">ABOUT US</h2>
            <h1 class="slider-title">Classic Events Management</h1>
            <p class="slider-subtitle">We're a team of dreamers, planners, and doers — passionate about turning your special moments into lifelong memories. Whether it’s a wedding, birthday, or business launch, we make it spectacular.<br>From concept to celebration, we’ve got you covered. Sit back, relax, and let the magic happen.
               </p>
        </div>
    </div>


    <section class="about_section">
        <div class="container">
            <div class="about-content">
                <div class="about-text">
                    <h2>Welcome to <span>Classic Events</span></h2>
                    <p>We are an ISO 9001:2015-certified event management company with over 15 years of experience in the event management industry. Classic Events specializes in wedding event management, as well as a wide range of corporate, personal, and private event management services.</p>
                    <p>Since our inception, we have successfully organized over 650 weddings, 70 corporate events, and countless private celebrations. Our commitment to excellence and attention to detail has made us the preferred choice for event management in the region.</p>
                    <div class="about-features">
                        <div class="feature">
                            <i class="fas fa-star"></i>
                            <h3>Quality Service</h3>
                            <p>ISO 9001:2015 certified for excellence</p>
                        </div>
                        <div class="feature">
                            <i class="fas fa-users"></i>
                            <h3>Expert Team</h3>
                            <p>Experienced professionals at your service</p>
                        </div>
                        <div class="feature">
                            <i class="fas fa-clock"></i>
                            <h3>Timely Delivery</h3>
                            <p>On-time execution guaranteed</p>
                        </div>
                    </div>
                </div>
                <div class="about-images">
                    <div class="image-grid">
                        <div class="grid-item"><img src="images/about_1.jpg" alt="Event Image 1"></div>
                        <div class="grid-item"><img src="images/about_2.jpg" alt="Event Image 2"></div>
                        <div class="grid-item"><img src="images/about_3.jpg" alt="Event Image 3"></div>
                        <div class="grid-item"><img src="images/about_4.jpg" alt="Event Image 4"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="services-section" style="background-image: url('images/services-bg.jpg'); background-size: cover; background-position: center; background-attachment: fixed; position: relative;">
        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.7); z-index: 1;"></div>
        <div class="container" style="position: relative; z-index: 2;">
            <div class="section-title">
                <h2 style="color: #ffffff;">Our <span style="color: var(--primary-color);">Services</span></h2>
            </div>
            <div class="services-grid">
                <div class="service-card" style="color: #ffffff;">
                    <i class="fas fa-ring" style="color: var(--primary-color);"></i>
                    <h3>Wedding Events</h3>
                    <p>Create your dream wedding with our expert planning and execution services.</p>
                </div>
                <div class="service-card" style="color: #ffffff;">
                    <i class="fas fa-building" style="color: var(--primary-color);"></i>
                    <h3>Corporate Events</h3>
                    <p>Professional corporate event management for conferences, seminars, and team building.</p>
                </div>
                <div class="service-card" style="color: #ffffff;">
                    <i class="fas fa-glass-cheers" style="color: var(--primary-color);"></i>
                    <h3>Private Celebrations</h3>
                    <p>Make your special occasions memorable with our personalized event services.</p>
                </div>
                <div class="service-card" style="color: #ffffff;">
                    <i class="fas fa-music" style="color: var(--primary-color);"></i>
                    <h3>Entertainment</h3>
                    <p>Top-tier entertainment solutions for all types of events.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="achievements-section">
        <div class="container">
            <h2 class="achievements-title">A Recall of <span style="color: var(--primary-color);">Achievements</span></h2>
            <div class="achievements-grid">
                <div class="achievement-card">
                    <h3>650+</h3>
                    <p>Weddings Organized</p>
                </div>
                <div class="achievement-card">
                    <h3>70+</h3>
                    <p>Corporate Events</p>
                </div>
                <div class="achievement-card">
                    <h3>15+</h3>
                    <p>Years Experience</p>
                </div>
            </div>
        </div>
    </section>

    <section class="testimonial-section">
        <div class="section-title" style="margin-bottom: 3rem;">
            <h2 style="color: var(--text-dark);">Client <span style="color: var(--primary-color);">Testimonials</span></h2>
        </div>
        <div class="testimonial-slider">
            <div class="testimonial-card">
                <q>I am satisfied with event organizer's work. Best work and as per our budget.</q>
                <div class="client-info">- <strong>Jammy Patel</strong></div>
            </div>
            <div class="testimonial-card">
                <q>Classic Events made our wedding day absolutely perfect! Their attention to detail was outstanding.</q>
                <div class="client-info">- <strong>Priya Sharma</strong></div>
            </div>
            <div class="testimonial-card">
                <q>The corporate event they organized for us was flawless. Highly professional team!</q>
                <div class="client-info">- <strong>Rajesh Kumar</strong></div>
            </div>
            <div class="testimonial-card">
                <q>They turned our vision into reality. The decoration and coordination were exceptional.</q>
                <div class="client-info">- <strong>Meera Singh</strong></div>
            </div>
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

    <script src="js/script.js"></script>
    <script src="js/auth.js"></script>
</body>
</html>