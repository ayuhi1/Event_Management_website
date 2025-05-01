<footer>
        <div class="footer-content">
            <div class="footer-section about">
                <h2>About Us</h2>
                <p>Classic Events is a premier event management company specializing in creating memorable experiences for all types of celebrations.</p>
                <div class="contact">
                    <span><i class="fas fa-phone"></i> &nbsp; 123-456-7890</span>
                    <span><i class="fas fa-envelope"></i> &nbsp; info@classicevents.com</span>
                </div>
                <div class="socials">
                    <a href="#"><i class="fab fa-facebook"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
            <div class="footer-section links">
                <h2>Quick Links</h2>
                <ul>
                    <li><a href="/Event_Management_website/index.php">Home</a></li>
                    <li><a href="/Event_Management_website/about.php">About</a></li>
                    <li><a href="/Event_Management_website/wedding.php">Wedding</a></li>
                    <li><a href="/Event_Management_website/birthday.php">Birthday</a></li>
                    <li><a href="/Event_Management_website/anniversary.php">Anniversary</a></li>
                    <li><a href="/Event_Management_website/contact.php">Contact</a></li>
                </ul>
            </div>
            <div class="footer-section contact-form">
                <h2>Contact Us</h2>
                <form action="/Event_Management_website/contact.php" method="post">
                    <input type="email" name="email" class="text-input contact-input" placeholder="Your email address...">
                    <textarea name="message" class="text-input contact-input" placeholder="Your message..."></textarea>
                    <button type="submit" class="btn btn-big contact-btn">
                        <i class="fas fa-envelope"></i>
                        Send
                    </button>
                </form>
            </div>
        </div>
        <div class="footer-bottom">
            &copy; <?php echo date('Y'); ?> Classic Events | All rights reserved
        </div>
    </footer>
</body>
</html>