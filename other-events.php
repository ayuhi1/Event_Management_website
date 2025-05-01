<?php
session_start();
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Other Events - Classic Events</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/dropdown.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/profile-dropdown.css">
    <link rel="stylesheet" href="css/about.css">
    <link rel="stylesheet" href="css/testimonials.css">
    <style>
        /* Other Events Page Specific Styles */
        .service-hero {
            position: relative;
            height: 60vh;
            background: url('images/Party1.jpeg') center/cover no-repeat;
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

        .events-section {
            padding: 5rem 2rem;
            background-color: #f9f9f9;
        }

        .events-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .section-title {
            text-align: center;
            margin-bottom: 3rem;
        }

        .section-title h2 {
            font-size: 2.5rem;
            color: #333;
            margin-bottom: 1rem;
        }

        .section-title p {
            font-size: 1.1rem;
            color: #666;
            max-width: 700px;
            margin: 0 auto;
        }

        .events-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
        }

        .event-card {
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }

        .event-card:hover {
            transform: translateY(-10px);
        }

        .event-image {
            height: 200px;
            overflow: hidden;
        }

        .event-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .event-card:hover .event-image img {
            transform: scale(1.1);
        }

        .event-content {
            padding: 1.5rem;
        }

        .event-content h3 {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
            color: #333;
        }

        .event-content p {
            color: #666;
            margin-bottom: 1rem;
        }

        .event-link {
            display: inline-block;
            color: #8a2be2;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s ease;
        }

        .event-link:hover {
            color: #7823c7;
        }

        .process-section {
            padding: 5rem 2rem;
        }

        .process-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .process-steps {
            display: flex;
            justify-content: space-between;
            margin-top: 3rem;
            position: relative;
        }

        .process-steps::before {
            content: '';
            position: absolute;
            top: 50px;
            left: 0;
            width: 100%;
            height: 2px;
            background-color: #e0e0e0;
            z-index: 1;
        }

        .process-step {
            text-align: center;
            position: relative;
            z-index: 2;
            width: 20%;
        }

        .step-number {
            width: 100px;
            height: 100px;
            background-color: #8a2be2;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            font-weight: bold;
            margin: 0 auto 1.5rem;
        }

        .step-title {
            font-size: 1.2rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
            color: #333;
        }

        .step-description {
            font-size: 0.9rem;
            color: #666;
        }

        .cta-section {
            padding: 5rem 2rem;
            background-color: #f5f0ff;
            text-align: center;
        }

        .cta-container {
            max-width: 800px;
            margin: 0 auto;
        }

        .cta-title {
            font-size: 2.5rem;
            color: #333;
            margin-bottom: 1rem;
        }

        .cta-description {
            font-size: 1.1rem;
            color: #666;
            margin-bottom: 2rem;
        }

        .cta-button {
            display: inline-block;
            background-color: #8a2be2;
            color: white;
            padding: 1rem 2rem;
            border-radius: 4px;
            text-decoration: none;
            font-size: 1.1rem;
            transition: background-color 0.3s ease;
        }

        .cta-button:hover {
            background-color: #7823c7;
        }

        @media (max-width: 992px) {
            .events-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .process-steps {
                flex-direction: column;
                align-items: center;
            }

            .process-steps::before {
                display: none;
            }

            .process-step {
                width: 100%;
                max-width: 300px;
                margin-bottom: 2rem;
            }
        }

        @media (max-width: 768px) {
            .service-hero h1 {
                font-size: 2.5rem;
            }

            .events-grid {
                grid-template-columns: 1fr;
            }
            
            .testimonial-grid {
                grid-template-columns: 1fr;
            }
        }
        
        /* Testimonial Section Styles */
        .testimonial-section {
            padding: 5rem 2rem;
            background-color: #f9f9f9;
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
            background-color: white;
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
                        <li><a href="other-events.php" class="active">Other Events</a></li>
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
            <h1>Specialized Event Services</h1>
            <p>Beyond weddings and birthdays, we excel at creating memorable experiences for all types of events</p>
        </div>
    </section>

    <section class="events-section">
        <div class="events-container">
            <div class="section-title">
                <h2>Our <span style="color: #8a2be2;">Event Services</span></h2>
                <p>We offer comprehensive planning and management services for a wide range of events</p>
            </div>
            <div class="events-grid">
                <div class="event-card">
                    <div class="event-image">
                        <img src="images/corporate_events.jpg" alt="Corporate Events">
                    </div>
                    <div class="event-content">
                        <h3>Corporate Events</h3>
                        <p>From conferences and seminars to team building activities and product launches, we create professional corporate events that align with your business objectives.</p>
                        <a href="booking.php?service=corporate" class="event-link">Learn More <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
                <div class="event-card">
                    <div class="event-image">
                        <img src="images/social_gathring.jpg" alt="Social Gatherings">
                    </div>
                    <div class="event-content">
                        <h3>Social Gatherings</h3>
                        <p>Whether it's a family reunion, graduation party, or holiday celebration, we help you create memorable social gatherings that bring people together.</p>
                        <a href="booking.php?service=social" class="event-link">Learn More <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
                <div class="event-card">
                    <div class="event-image">
                        <img src="images/culture.jpeg" alt="Cultural Events">
                    </div>
                    <div class="event-content">
                        <h3>Cultural Events</h3>
                        <p>We specialize in organizing cultural events that celebrate traditions, heritage, and community values with authenticity and respect.</p>
                        <a href="booking.php?service=cultural" class="event-link">Learn More <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
                <div class="event-card">
                    <div class="event-image">
                        <img src="images/fundraser.jpg" alt="Fundraisers">
                    </div>
                    <div class="event-content">
                        <h3>Fundraisers</h3>
                        <p>Our team helps you organize impactful fundraising events that maximize donations while providing an engaging experience for attendees.</p>
                        <a href="booking.php?service=fundraiser" class="event-link">Learn More <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
                <div class="event-card">
                    <div class="event-image">
                        <img src="images/school_event.jpg" alt="Educational Events">
                    </div>
                    <div class="event-content">
                        <h3>Educational Events</h3>
                        <p>From workshops and training sessions to academic conferences, we create conducive environments for learning and knowledge sharing.</p>
                        <a href="booking.php?service=educational" class="event-link">Learn More <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
                <div class="event-card">
                    <div class="event-image">
                        <img src="images/virtual_event.jpg" alt="Virtual Events">
                    </div>
                    <div class="event-content">
                        <h3>Virtual Events</h3>
                        <p>We leverage cutting-edge technology to create engaging virtual events that connect people regardless of geographical boundaries.</p>
                        <a href="booking.php?service=virtual" class="event-link">Learn More <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="process-section">
        <div class="process-container">
            <div class="section-title">
                <h2>Our Event Planning <span style="color: #8a2be2;">Process</span></h2>
                <p>We follow a structured approach to ensure your event is planned and executed flawlessly</p>
            </div>
            <div class="process-steps">
                <div class="process-step">
                    <div class="step-number">1</div>
                    <div class="step-title">Consultation</div>
                    <div class="step-description">We begin with a detailed consultation to understand your vision, requirements, and budget.</div>
                </div>
                <div class="process-step">
                    <div class="step-number">2</div>
                    <div class="step-title">Planning</div>
                    <div class="step-description">Our team develops a comprehensive event plan including venue, vendors, timeline, and budget.</div>
                </div>
                <div class="process-step">
                    <div class="step-number">3</div>
                    <div class="step-title">Coordination</div>
                    <div class="step-description">We coordinate with all vendors and service providers to ensure everything is in place.</div>
                </div>
                <div class="process-step">
                    <div class="step-number">4</div>
                    <div class="step-title">Execution</div>
                    <div class="step-description">On the day of the event, our team manages all aspects to ensure a smooth experience.</div>
                </div>
                <div class="process-step">
                    <div class="step-number">5</div>
                    <div class="step-title">Follow-up</div>
                    <div class="step-description">After the event, we gather feedback and ensure all post-event tasks are completed.</div>
                </div>
            </div>
        </div>
    </section>

    <section class="cta-section">
        <div class="cta-container">
            <h2 class="cta-title">Ready to Plan Your Event?</h2>
            <p class="cta-description">Contact us today to discuss your event requirements and let us create a memorable experience for you and your guests.</p>
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

    <script src="js/script.js"></script>
    <script src="js/auth.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Testimonial slider functionality
            const testimonialCards = document.querySelectorAll('.testimonial-card');
            const prevBtn = document.querySelector('.testimonial-nav .prev-btn');
            const nextBtn = document.querySelector('.testimonial-nav .next-btn');
            let currentTestimonial = 0;
            
            // Function to show a specific testimonial
            function showTestimonial(index) {
                // Hide all testimonials
                testimonialCards.forEach(card => {
                    card.classList.remove('active');
                });
                
                // Show the selected testimonial
                testimonialCards[index].classList.add('active');
            }
            
            // Next testimonial function
            function nextTestimonial() {
                currentTestimonial = (currentTestimonial + 1) % testimonialCards.length;
                showTestimonial(currentTestimonial);
            }
            
            // Previous testimonial function
            function prevTestimonial() {
                currentTestimonial = (currentTestimonial - 1 + testimonialCards.length) % testimonialCards.length;
                showTestimonial(currentTestimonial);
            }
            
            // Add event listeners to buttons
            if (prevBtn) {
                prevBtn.addEventListener('click', prevTestimonial);
            }
            
            if (nextBtn) {
                nextBtn.addEventListener('click', nextTestimonial);
            }
        });
    </script>
</body>
</html>