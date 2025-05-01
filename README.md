# Classic Events Management Website

## Overview
This is a PHP-based event management website that allows users to browse event services, contact the company, and book events. It includes user authentication (login/signup), an admin dashboard, and contact form functionality.

## Features
- User authentication (login/signup)
- Admin dashboard for managing bookings and messages
- Contact form with database storage
- Responsive design for all devices
- Event services showcase
- Image gallery

## Technical Implementation
- Frontend: HTML, CSS, JavaScript
- Backend: PHP
- Database: MySQL

## Setup Instructions

### Database Setup
1. Create a MySQL database named `occasio_db`
2. Import the `mysql.sql` file to set up the database schema and sample data
   ```
   mysql -u username -p occasio_db < mysql.sql
   ```
3. Update database credentials in `config.php` if needed

### PHP Configuration
1. Make sure you have PHP 7.0 or higher installed
2. Configure your web server (Apache/Nginx) to point to the project directory
3. Ensure the web server has write permissions for the project directory

### Default Admin Account
- Email: admin@classicevents.com
- Password: admin123

## File Structure
- `/auth/` - Authentication related PHP files
- `/admin/` - Admin dashboard files
- `/css/` - Stylesheet files
- `/js/` - JavaScript files
- `/images/` - Image assets
- `*.html` - Static HTML pages
- `*.php` - Dynamic PHP pages
- `mysql.sql` - Database schema and sample data
- `config.php` - Database connection configuration

## Usage
1. Navigate to the index page
2. Sign up for a new account or log in with existing credentials
3. Browse services and contact the company through the contact form
4. Admin users can access the dashboard at `/admin/dashboard.php`

## Security Notes
- Passwords are hashed using PHP's password_hash() function
- Input validation is implemented for all form submissions
- Session management is used for authentication