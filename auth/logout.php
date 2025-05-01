<?php
// This file now serves as a confirmation page before actual logout
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout Confirmation - Classic Events</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .logout-container {
            max-width: 500px;
            margin: 100px auto;
            padding: 30px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            text-align: center;
        }
        .logout-container h2 {
            margin-bottom: 20px;
            color: #333;
        }
        .logout-container p {
            margin-bottom: 30px;
            color: #666;
        }
        .btn-container {
            display: flex;
            justify-content: center;
            gap: 20px;
        }
        .btn {
            padding: 10px 20px;
            border-radius: 4px;
            text-decoration: none;
            font-weight: 500;
            cursor: pointer;
        }
        .btn-cancel {
            background-color: #6c757d;
            color: white;
            border: none;
        }
        .btn-logout {
            background-color: #dc3545;
            color: white;
            border: none;
        }
    </style>
</head>
<body>
    <div class="logout-container">
        <h2>Confirm Logout</h2>
        <p>Are you sure you want to logout from your account?</p>
        <div class="btn-container">
            <a href="../index.php" class="btn btn-cancel">Cancel</a>
            <a href="logout_process.php" class="btn btn-logout">Yes, Logout</a>
        </div>
    </div>
</body>
</html>
?>