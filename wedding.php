<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wedding Services - Classic Events</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/dropdown.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/about.css">
    <link rel="stylesheet" href="css/profile-dropdown.css">
    <link rel="stylesheet" href="css/testimonials.css">
    <style>
        /* Wedding Page Specific Styles */
        .service-hero {
            position: relative;
            height: 60vh;
            background: url('images/wedding1.jpeg') center/cover no-repeat;
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

        .service-section {
            padding: 5rem 2rem;
            background-color: white;
        }

        .service-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .service-intro {
            text-align: center;
            margin-bottom: 4rem;
        }

        .service-intro h2 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            color: #333;
        }

        .service-intro p {
            max-width: 800px;
            margin: 0 auto;
            color: #666;
            line-height: 1.6;
        }

        .service-gallery {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
            margin-bottom: 4rem;
        }

        .gallery-item img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            border-radius: 8px;
            transition: transform 0.3s ease;
        }

        .gallery-item img:hover {
            transform: scale(1.05);
        }

        .service-features {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 3rem;
            margin-bottom: 4rem;
        }

        .feature-item {
            display: flex;
            align-items: flex-start;
        }

        .feature-icon {
            font-size: 2rem;
            color: #8a2be2;
            margin-right: 1.5rem;
        }

        .feature-content h3 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
            color: #333;
        }

        .feature-content p {
            color: #666;
            line-height: 1.6;
        }

        .cta-section {
            text-align: center;
            background-color: #f9f9f9;
            padding: 4rem 2rem;
            border-radius: 8px;
        }

        .cta-section h2 {
            font-size: 2.5rem;
            margin-bottom: 1.5rem;
            color: #333;
        }

        .cta-section p {
            max-width: 700px;
            margin: 0 auto 2rem;
            color: #666;
            line-height: 1.6;
        }

        .cta-button {
            display: inline-block;
            padding: 1rem 2.5rem;
            background-color: #8a2be2;
            color: white;
            text-decoration: none;
            border-radius: 50px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .cta-button:hover {
            background-color: #7823c9;
        }

        .testimonial-section {
            padding: 5rem 2rem;
            background-color: white;
        }

        .testimonial-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .testimonial-heading {
            text-align: center;
            margin-bottom: 3rem;
        }

        .testimonial-heading h2 {
            font-size: 2.5rem;
            color: #333;
        }

        .testimonial-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
        }

        .testimonial-card {
            background-color: #f9f9f9;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .testimonial-text {
            font-style: italic;
            color: #666;
            margin-bottom: 1.5rem;
            line-height: 1.6;
        }

        .testimonial-author {
            display: flex;
            align-items: center;
        }

        .author-image {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            overflow: hidden;
            margin-right: 1rem;
        }

        .author-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .author-info h4 {
            margin: 0;
            color: #333;
        }

        .author-info p {
            margin: 0;
            color: #8a2be2;
            font-size: 0.9rem;
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
            padding: 2rem;
            flex-grow: 1;
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
                <li><a href="#" class="active">Services</a>
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
                <?php echo substr($_SESSION['user_fullname'] ?? 'User', 0, 1); ?>
                <div class="profile-dropdown">
                    <?php if(isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'admin'): ?>
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

    <div class="service-hero">
        <div class="service-hero-content">
            <h1>Wedding Services</h1>
            <p>Marriages are planned in heavens, but celebrated on earth.</p>
        </div>
    </div>

    <section class="service-section">
        <div class="service-container">
            <div class="service-intro">
                <h2>Your Dream Wedding</h2>
                <p>Classic Events offers comprehensive wedding planning solutions right from booking the venue, decorations & entertainment arrangements. Our endeavour will always be to create something completely new to showcase visual designs to leave your guests in awe.</p>
                <p>Wedding is an important event in our social life. Managing and organizing it is always full of excitement for families. We can help you with our professional team to make your wedding stand out. We have experienced team of floral decorators, sound & light management team. You should be free from the tension of managing the event and enjoy the most with your family & dear. For we shall take the entire responsibility of managing your wedding event from start to finish by our experience and professional ability.</p>
            </div>

            <div class="service-gallery">
                <div class="gallery-item">
                    <img src="images/wed_page1.jpeg" alt="Wedding Venue">
                </div>
                <div class="gallery-item">
                    <img src="images/wed_page_2.jpeg" alt="Wedding Decoration">
                </div>
                <div class="gallery-item">
                    <img src="images/wed_page3.png" alt="Wedding Ceremony">
                </div>
            </div>

            <div class="service-features">
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div class="feature-content">
                        <h3>Destination Wedding</h3>
                        <p>Classic Events chooses beautiful locations for your wedding function and can make it a memorable one. It is very important to finalize the venue with the consent of the all concerned with the event. We help you with suggestions for you to make a perfect choice from many options we have to make your event memorable.</p>
                    </div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fas fa-paint-brush"></i>
                    </div>
                    <div class="feature-content">
                        <h3>Theme Wedding</h3>
                        <p>Our wedding themes come with numerous varieties. They could be simply floral, a beach, a palace and with dozens of traditional arts like Kathakali, Theyyam, etc. that designed and creatively decorated Mandap provides a dream traditional atmosphere on the auspicious occasion. We make sure that fire and flowers is easily accessible.</p>
                    </div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fas fa-utensils"></i>
                    </div>
                    <div class="feature-content">
                        <h3>Catering Service</h3>
                        <p>Food is very vital at any marriage function to make it memorable. It is something you share with your loved for your guests and for the families. We shall help you to make perfect buffet of your choice. We arrange various cuisines, Punjabi, Rajasthani, South Indian, Chinese, Continental etc. We create value that fits best choice or demand of your event.</p>
                    </div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fas fa-lightbulb"></i>
                    </div>
                    <div class="feature-content">
                        <h3>Lighting</h3>
                        <p>Sound, picture and light are part of modern celebrations. We do it in such a traditional way that it will help to enhance the effect created by the decorations of the venue. It will be a memorable experience of illumination for all who would be present at the occasion.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <section class="service-packages">
    <div class="packages-container">
        <div class="packages-heading">
            <h2>Our Wedding <span style="color: #8a2be2;">Packages</span></h2>
            <p>Choose from our beautifully curated wedding packages or let us design a custom experience for your big day</p>
        </div>
        <div class="packages-grid">
            <div class="package-card">
                <div class="package-header">
                    <h3 class="package-name">Essential Wedding</h3>
                    <div class="package-price">₹75,000</div>
                    <div class="package-duration">For up to 100 guests</div>
                </div>
                <div class="package-features">
                    <ul>
                        <li>Venue assistance</li>
                        <li>Basic floral & stage decor</li>
                        <li>Catering coordination</li>
                        <li>Wedding cake arrangement</li>
                        <li>Basic sound setup</li>
                    </ul>
                    <a href="booking.php?service=wedding&package=essential" class="package-button">Book Now</a>
                </div>
            </div>
            <div class="package-card">
                <div class="package-popular">Most Popular</div>
                <div class="package-header">
                    <h3 class="package-name">Signature Wedding</h3>
                    <div class="package-price">₹150,000</div>
                    <div class="package-duration">For up to 200 guests</div>
                </div>
                <div class="package-features">
                    <ul>
                        <li>Premium venue options</li>
                        <li>Themed floral decor</li>
                        <li>Custom catering menu</li>
                        <li>Designer wedding cake</li>
                        <li>Live music or DJ</li>
                        <li>Photography & video coverage</li>
                        <li>Wedding favors for guests</li>
                    </ul>
                    <a href="booking.php?service=wedding&package=signature" class="package-button">Book Now</a>
                </div>
            </div>
            <div class="package-card">
                <div class="package-header">
                    <h3 class="package-name">Royal Wedding</h3>
                    <div class="package-price">₹300,000+</div>
                    <div class="package-duration">For up to 500 guests</div>
                </div>
                <div class="package-features">
                    <ul>
                        <li>Exclusive luxury venue</li>
                        <li>Lavish decor & lighting</li>
                        <li>Gourmet catering & bar</li>
                        <li>Custom designer cake</li>
                        <li>Celebrity performance</li>
                        <li>Full cinematic coverage</li>
                        <li>Designer invitations</li>
                        <li>Luxury transportation</li>
                        <li>Dedicated wedding planner</li>
                    </ul>
                    <a href="booking.php?service=wedding&package=royal" class="package-button">Book Now</a>
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
                    <p class="testimonial-text">"Classic Events made our wedding day absolutely perfect. From the venue selection to the smallest details, everything was handled with such care and professionalism. We couldn't have asked for a better team to help us create our dream wedding."</p>
                    <div class="testimonial-author">
                        <div class="author-info">
                            <h4>Priya & Rahul</h4>
                            <p>Wedding in Kochi</p>
                        </div>
                    </div>
                </div>
                <div class="testimonial-card">
                    <p class="testimonial-text">"We had a destination wedding in Munnar, and Classic Events managed everything flawlessly. Our guests are still talking about how beautiful and well-organized everything was. Thank you for making our special day truly magical!"</p>
                    <div class="testimonial-author">
                        <div class="author-info">
                            <h4>Meera & Arjun</h4>
                            <p>Destination Wedding</p>
                        </div>
                    </div>
                </div>
                <div class="testimonial-card">
                    <p class="testimonial-text">"The theme wedding concept that Classic Events created for us was beyond our expectations. The attention to detail and the way they brought our vision to life was incredible. It was truly the wedding of our dreams!"</p>
                    <div class="testimonial-author">
                        <div class="author-info">
                            <h4>Anjali & Vikram</h4>
                            <p>Theme Wedding</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <div class="footer-content">
            <div class="footer-section">
                <img src="images/logo.png" alt="Logo" class="footer-logo">
                <p>Classic Events is a premier event management company specializing in creating unforgettable experiences for all types of celebrations and corporate gatherings.</p>
                <div class="social-links">
                    <a href="#"><i class="fab fa-facebook"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-linkedin"></i></a>
                </div>
            </div>
            <div class="footer-section">
                <h3 class="footer-title">Quick Links</h3>
                <ul class="footer-links">
                    <li><a href="#">Home</a></li>
                    <li><a href="about.php">About Us</a></li>
                    <li><a href="gallery.php">Gallery</a></li>
                    <li><a href="contact.php">Contact Us</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Contact Us</h3>
                <p><i class="fas fa-map-marker-alt"></i> 123 Event Street, Mumbai, India</p>
                <p><i class="fas fa-phone"></i> +91 98765 43210</p>
                <p><i class="fas fa-envelope"></i> info@occasio.com</p>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2024 Occasio. All rights reserved.</p>
        </div>
    </footer>

    <script src="js/script.js"></script>
    <script src="js/auth.js"></script>
    <script src="js/testimonials.js"></script>
</body>
</html>