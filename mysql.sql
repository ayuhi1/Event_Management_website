-- Create the database
CREATE DATABASE IF NOT EXISTS occasio_db;
USE occasio_db;

-- Create users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fullname VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    user_type ENUM('user', 'admin') NOT NULL DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert default admin user
INSERT INTO users (fullname, email, password, user_type) VALUES
('Admin User', 'admin@classicevents.com', 'admin123', 'admin');
-- Note: The password is 'admin123' in plain text

-- Create table for event bookings
CREATE TABLE IF NOT EXISTS bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    event_type VARCHAR(50) NOT NULL,
    event_date DATE NOT NULL,
    event_time TIME NOT NULL,
    venue VARCHAR(255),
    guests INT,
    additional_info TEXT,
    status ENUM('pending', 'confirmed', 'completed', 'cancelled') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Create table for contact messages
CREATE TABLE IF NOT EXISTS messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    subject VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    is_read BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create table for slider images
CREATE TABLE IF NOT EXISTS slider_images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    image_path VARCHAR(255) NOT NULL,
    title VARCHAR(100),
    description TEXT,
    position INT NOT NULL DEFAULT 0,
    active BOOLEAN DEFAULT true,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert sample data for slider images
INSERT INTO slider_images (image_path, title, description, position) VALUES
('images/slide1.jpeg', 'Welcome to Classic Events', 'Discover amazing opportunities', 1),
('images/slide2.jpeg', 'Our Services', 'Professional solutions for your needs', 2),
('images/slide3.jpeg', 'Get Started', 'Join us today and explore more', 3);

-- Create table for services
CREATE TABLE IF NOT EXISTS services (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    icon VARCHAR(50),
    image_path VARCHAR(255),
    is_active BOOLEAN DEFAULT true,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert sample services
INSERT INTO services (name, description, icon) VALUES
('Wedding Events', 'Create your dream wedding with our expert planning and execution services.', 'fa-ring'),
('Corporate Events', 'Professional corporate event management for conferences, seminars, and team building.', 'fa-building'),
('Private Celebrations', 'Make your special occasions memorable with our personalized event services.', 'fa-glass-cheers'),
('Entertainment', 'Top-tier entertainment solutions for all types of events.', 'fa-music');

-- Create table for testimonials
CREATE TABLE IF NOT EXISTS testimonials (
    id INT AUTO_INCREMENT PRIMARY KEY,
    client_name VARCHAR(100) NOT NULL,
    client_position VARCHAR(100),
    testimonial TEXT NOT NULL,
    rating INT DEFAULT 5,
    is_active BOOLEAN DEFAULT true,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert sample testimonials
INSERT INTO testimonials (client_name, testimonial) VALUES
('Jammy Patel', 'I am satisfied with event organizers work. Best work and as per our budget.'),
('Priya Sharma', 'Classic Events made our wedding day absolutely perfect! Their attention to detail was outstanding.'),
('Rajesh Kumar', 'The corporate event they organized for us was flawless. Highly professional team!'),
('Meera Singh', 'They turned our vision into reality. The decoration and coordination were exceptional.');

-- Create table for venues
CREATE TABLE IF NOT EXISTS venues (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    event_type VARCHAR(50) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    image VARCHAR(255) NOT NULL,
    description TEXT,
    is_active BOOLEAN DEFAULT true,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert sample venues
INSERT INTO venues (name, event_type, price, image, description) VALUES
('Grand Ballroom', 'wedding', 5000.00, 'images/venues/grand_ballroom.jpg', 'A luxurious ballroom perfect for grand weddings with high ceilings and elegant decor.'),
('Garden Pavilion', 'wedding', 3500.00, 'images/venues/garden_pavilion.jpg', 'Beautiful outdoor venue surrounded by lush gardens and water features.'),
('Conference Center', 'corporate', 2000.00, 'images/venues/conference_center.jpg', 'Professional setting with state-of-the-art technology for corporate events.'),
('Party Hall', 'birthday', 1500.00, 'images/venues/party_hall.jpg', 'Colorful and vibrant space ideal for birthday celebrations of all ages.');}]}}}