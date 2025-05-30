<?php
session_start();

// If user is already logged in, redirect to home page
if(isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Your Website</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/dropdown.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/profile-dropdown.css">
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/popup.css">
    
</head>
<body>
    <div class="auth-container">
        <a href="index.php" class="back-btn"><i class="fas fa-arrow-left"></i> Back to Home</a>
        <div class="auth-box">
            <div class="auth-header">
                <img src="images/logo.png" alt="Logo">
                <h2>Create Account</h2>
                <p>Join our community today</p>
            </div>
            <form class="auth-form" id="signupForm">
                <div class="form-group">
                    <label for="fullname">Full Name</label>
                    <input type="text" id="fullname" name="fullname" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                    <p class="password-requirements">Password must be at least 8 characters long and include numbers and special characters</p>
                    <div class="show-password">
                        <input type="checkbox" id="showPassword">
                        <label for="showPassword">Show Password</label>
                    </div>
                </div>
                <!-- </div> -->
                <div class="form-group">
                    <label for="confirmPassword">Confirm Password</label>
                    <input type="password" id="confirmPassword" name="confirmPassword" required>
                </div>
                
                <button type="submit" class="auth-btn">Sign Up</button>
            </form>
            <div class="auth-links">
                <p>Already have an account? <a href="login.php">Login</a></p>
            </div>
        </div>
    </div>
    <script src="js/auth.js"></script>
    <script src="js/auth-display.js"></script>
    <script>
        document.getElementById('signupForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const fullname = document.getElementById('fullname').value;
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirmPassword').value;
            const userTypeElement = document.querySelector('input[name="userType"]:checked');
            const userType = userTypeElement ? userTypeElement.value : 'user';
            
            // Validate password
            if (password.length < 8) {
                alert('Password must be at least 8 characters long');
                return;
            }
            
            if (password !== confirmPassword) {
                alert('Passwords do not match');
                return;
            }
            
            signup(fullname, email, password, userType);
        });
    </script>
</body>
</html>