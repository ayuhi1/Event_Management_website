<?php
session_start();
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Birthday Party Services - Classic Events</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/dropdown.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/profile-dropdown.css">
    <link rel="stylesheet" href="css/about.css">
    <link rel="stylesheet" href="css/testimonials.css">
    <style>
        /* Birthday Page Specific Styles */
        .service-hero {
            position: relative;
            height: 60vh;
            background: url('images/birthday1.jpg') center/cover no-repeat;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
        }

        .service-hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1;
        }

        .service-hero-content {
            position: relative;
            z-index: 2;
            max-width: 800px;
            padding: 0 2rem;
        }

        .service-hero h1 {
            font-size: 3.5rem;
            margin-bottom: 1rem;
        }

        .service-hero p {
            font-size: 1.2rem;
            margin-bottom: 0;
        }

        .service-features {
            padding: 5rem 2rem;
            background-color: #f9f9f9;
        }

        .features-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .features-heading {
            text-align: center;
            margin-bottom: 3rem;
        }

        .features-heading h2 {
            font-size: 2.5rem;
            color: #333;
            margin-bottom: 1rem;
        }

        .features-heading p {
            font-size: 1.1rem;
            color: #666;
            max-width: 700px;
            margin: 0 auto;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
        }

        .feature-card {
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-10px);
        }

        .feature-image {
            height: 200px;
            overflow: hidden;
        }

        .feature-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .feature-card:hover .feature-image img {
            transform: scale(1.1);
        }

        .feature-content {
            padding: 1.5rem;
        }

        .feature-content h3 {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
            color: #333;
        }

        .feature-content p {
            color: #666;
            margin-bottom: 1rem;
        }

        .service-packages {
            padding: 5rem 2rem;
        }

        .packages-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .packages-heading {
            text-align: center;
            margin-bottom: 3rem;
        }

        .packages-heading h2 {
            font-size: 2.5rem;
            color: #333;
            margin-bottom: 1rem;
        }

        .packages-heading p {
            font-size: 1.1rem;
            color: #666;
            max-width: 700px;
            margin: 0 auto;
        }

        .packages-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
        }

        .package-card {
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
            text-align: center;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .package-card:hover {
            transform: translateY(-10px);
        }

        .package-popular {
            position: absolute;
            top: 0;
            right: 0;
            background-color: #8a2be2;
            color: white;
            padding: 0.5rem 1rem;
            font-size: 0.8rem;
            font-weight: bold;
        }

        .package-header {
            background-color: #f5f5f5;
            padding: 2rem;
            border-bottom: 1px solid #eee;
        }

        .package-name {
            font-size: 1.8rem;
            margin-bottom: 0.5rem;
            color: #333;
        }

        .package-price {
            font-size: 2.5rem;
            font-weight: bold;
            color: #8a2be2;
            margin-bottom: 0.5rem;
        }

        .package-duration {
            color: #666;
            font-size: 0.9rem;
        }

        .package-features {
            flex-grow: 1;
            padding: 2rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .package-features ul {
            list-style: none;
            padding: 0;
            margin: 0 0 1rem 0;
        }

        .package-features li {
            padding: 0.5rem 0;
            border-bottom: 1px solid #eee;
            color: #666;
        }

        .package-features li:last-child {
            border-bottom: none;
        }

        .package-button {
            display: inline-block;
            background-color: #8a2be2;
            color: white;
            padding: 0.8rem 2rem;
            border-radius: 4px;
            text-decoration: none;
            margin-top: 1rem;
            transition: background-color 0.3s ease;
        }

        .package-button:hover {
            background-color: #7823c7;
        }

        @media (max-width: 992px) {
            .features-grid, .packages-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .service-hero h1 {
                font-size: 2.5rem;
            }

            .features-grid, .packages-grid {
                grid-template-columns: 1fr;
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
                        <li><a href="birthday.php" class="active">Birthday Party</a></li>
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

    <section class="service-hero">
        <div class="service-hero-content">
            <h1>Birthday Party Services</h1>
            <p>Make your special day unforgettable with our premium birthday party planning services</p>
        </div>
    </section>

    <section class="service-features">
        <div class="features-container">
            <div class="features-heading">
                <h2>Our Birthday Party <span style="color: #8a2be2;">Services</span></h2>
                <p>We offer comprehensive birthday party planning services to make your celebration truly special</p>
            </div>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-image">
                        <img src="images/venue_birthday.jpg" alt="Venue Selection">
                    </div>
                    <div class="feature-content">
                        <h3>Venue Selection</h3>
                        <p>We help you find the perfect venue for your birthday celebration, whether it's an intimate gathering or a grand party.</p>
                    </div>
                </div>
                <div class="feature-card">
                    <div class="feature-image">
                        <img src="images/theme_services.jpg" alt="Theme Design">
                    </div>
                    <div class="feature-content">
                        <h3>Theme Design</h3>
                        <p>From classic to contemporary, we create custom themes that reflect your personality and preferences.</p>
                    </div>
                </div>
                <div class="feature-card">
                    <div class="feature-image">
                        <img src="images/cater_birthday.jpg" alt="Catering Services">
                    </div>
                    <div class="feature-content">
                        <h3>Catering Services</h3>
                        <p>Delicious food and beverages tailored to your taste, dietary requirements, and party theme.</p>
                    </div>
                </div>
                <div class="feature-card">
                    <div class="feature-image">
                        <img src="images/party_page_!.jpeg" alt="Entertainment">
                    </div>
                    <div class="feature-content">
                        <h3>Entertainment</h3>
                        <p>From DJs and live bands to magicians and photo booths, we arrange entertainment that keeps your guests engaged.</p>
                    </div>
                </div>
                <div class="feature-card">
                    <div class="feature-image">
                        <img src="images/party_page_2.jpg" alt="Decoration">
                    </div>
                    <div class="feature-content">
                        <h3>Decoration</h3>
                        <p>Beautiful decorations that transform your venue into a festive space perfect for celebration.</p>
                    </div>
                </div>
                <div class="feature-card">
                    <div class="feature-image">
                        <img src="images/party_page_2.jpg" alt="Photography">
                    </div>
                    <div class="feature-content">
                        <h3>Photography</h3>
                        <p>Professional photographers to capture every special moment of your birthday celebration.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="service-packages">
        <div class="packages-container">
            <div class="packages-heading">
                <h2>Our Birthday Party <span style="color: #8a2be2;">Packages</span></h2>
                <p>Choose from our carefully crafted packages or let us create a custom solution for your special day</p>
            </div>
            <div class="packages-grid">
                <div class="package-card">
                    <div class="package-header">
                        <h3 class="package-name">Basic Celebration</h3>
                        <div class="package-price">₹25,000</div>
                        <div class="package-duration">For up to 50 guests</div>
                    </div>
                    <div class="package-features">
                        <ul>
                            <li>Venue arrangement assistance</li>
                            <li>Basic decorations</li>
                            <li>Catering coordination</li>
                            <li>Birthday cake arrangement</li>
                            <li>Basic sound system</li>
                        </ul>
                        <a href="booking.php?service=birthday&package=basic" class="package-button">Book Now</a>
                    </div>
                </div>
                <div class="package-card">
                    <div class="package-popular">Most Popular</div>
                    <div class="package-header">
                        <h3 class="package-name">Premium Party</h3>
                        <div class="package-price">₹50,000</div>
                        <div class="package-duration">For up to 100 guests</div>
                    </div>
                    <div class="package-features">
                        <ul>
                            <li>Premium venue selection</li>
                            <li>Themed decorations</li>
                            <li>Customized catering menu</li>
                            <li>Custom birthday cake</li>
                            <li>DJ or live music</li>
                            <li>Photography service</li>
                            <li>Party favors for guests</li>
                        </ul>
                        <a href="booking.php?service=birthday&package=premium" class="package-button">Book Now</a>
                    </div>
                </div>
                <div class="package-card">
                    <div class="package-header">
                        <h3 class="package-name">Luxury Celebration</h3>
                        <div class="package-price">₹100,000+</div>
                        <div class="package-duration">For up to 200 guests</div>
                    </div>
                    <div class="package-features">
                        <ul>
                            <li>Exclusive venue booking</li>
                            <li>Luxury themed decorations</li>
                            <li>Premium catering with bar service</li>
                            <li>Designer birthday cake</li>
                            <li>Celebrity performer or band</li>
                            <li>Professional photography & videography</li>
                            <li>Custom invitations</li>
                            <li>VIP transportation</li>
                            <li>Personal event coordinator</li>
                        </ul>
                        <a href="booking.php?service=birthday&package=luxury" class="package-button">Book Now</a>
                    </div>
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
                <q>Classic Events made my daughter's sweet 16 absolutely perfect! Their attention to detail was outstanding.</q>
                <div class="client-info">- <strong>Priya Sharma</strong></div>
            </div>
            <div class="testimonial-card">
                <q>The birthday party they organized for my son was flawless. All the kids had a blast!</q>
                <div class="client-info">- <strong>Rajesh Kumar</strong></div>
            </div>
            <div class="testimonial-card">
                <q>They turned our vision into reality. The decoration and coordination were exceptional.</q>
                <div class="client-info">- <strong>Meera Singh</strong></div>
            </div>
            <div class="testimonial-card">
                <q>I am satisfied with event organizer's work. Best work and as per our budget.</q>
                <div class="client-info">- <strong>Jammy Patel</strong></div>
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
    <script src="js/testimonials.js"></script>
    <script src="js/auth.js"></script>
</body>
</html>