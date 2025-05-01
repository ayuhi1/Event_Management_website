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
    <title>Login - Your Website</title>
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
                <h2>Welcome Back</h2>
                <p>Please login to your account</p>
            </div>
            <form class="auth-form" id="loginForm">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
    <label for="password">Password</label>
    <input type="password" id="password" name="password" required>
    <div class="show-password">
        <input type="checkbox" id="showPassword">
        <label for="showPassword">Show Password</label>
    </div>
</div>
                <div class="form-group">
                    <label>User Type</label>
                    <div class="radio-group">
                        <label class="radio-label">
                            <input type="radio" name="userType" value="user" checked> User
                        </label>
                        <label class="radio-label">
                            <input type="radio" name="userType" value="admin"> Admin
                        </label>
                    </div>
                </div>
                <button type="submit" class="auth-btn">Login</button>
            </form>
            <div class="auth-links">
                <p>Don't have an account? <a href="signup.php">Sign up</a></p>
            </div>
        </div>
    </div>
    <script src="js/auth.js"></script>
    <script src="js/auth-display.js"></script>
    <script>
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const userType = document.querySelector('input[name="userType"]:checked').value;
            
            login(email, password, userType);
        });
    </script>
</body>
</html>