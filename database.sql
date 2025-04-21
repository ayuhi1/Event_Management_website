-- Create the database
CREATE DATABASE IF NOT EXISTS occasio_db;
USE occasio_db;

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
('images/slide1.jpg', 'Welcome to Occasio', 'Discover amazing opportunities', 1),
('images/slide2.jpg', 'Our Services', 'Professional solutions for your needs', 2),
('images/slide3.jpg', 'Get Started', 'Join us today and explore more', 3);