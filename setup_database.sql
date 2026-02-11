-- ============================================
-- Food Ordering System Database Setup
-- ============================================
-- Database: food_ordering
-- 6 Tables: users, foods, orders, order_items, categories, logs
-- Normalized to 3NF with proper foreign keys
-- ============================================

-- Drop existing database if needed
DROP DATABASE IF EXISTS food_ordering;

-- Create Database
CREATE DATABASE food_ordering;
USE food_ordering;

-- ============================================
-- Categories Table (1st Normal Form - atomic values)
-- ============================================
CREATE TABLE categories (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_name (name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert sample categories
INSERT INTO categories (name, description) VALUES 
('Main Course', 'Delicious main dishes for your meal'),
('Appetizers', 'Start your meal with tasty starters'),
('Beverages', 'Refreshing drinks and juices'),
('Desserts', 'Sweet treats and cakes'),
('Fast Food', 'Quick and tasty fast food items');

-- ============================================
-- Users Table (with roles: admin/user)
-- ============================================
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    address TEXT,
    role ENUM('user', 'admin') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_username (username),
    INDEX idx_email (email),
    INDEX idx_role (role)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert default admin user (password: admin123)
-- Password is: admin123 (hashed)
INSERT INTO users (username, email, password, full_name, role) VALUES 
('admin', 'admin@foodorder.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'System Administrator', 'admin');

-- Insert sample users
INSERT INTO users (username, email, password, full_name, phone, address) VALUES 
('john_doe', 'john@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'John Doe', '0712345678', '123 Main Street, Dar es Salaam'),
('jane_smith', 'jane@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Jane Smith', '0712345679', '456 Ocean Road, Dar es Salaam');

-- ============================================
-- Foods Table
-- ============================================
CREATE TABLE foods (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    category_id INT,
    image VARCHAR(255),
    is_available BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL,
    INDEX idx_name (name),
    INDEX idx_category (category_id),
    INDEX idx_price (price),
    INDEX idx_available (is_available)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert sample foods
INSERT INTO foods (name, description, price, category_id, image) VALUES 
('Chicken Fried Rice', 'Delicious fried rice with tender chicken pieces', 8000, 1, 'food1.jpg'),
('Beef Burger', 'Juicy beef burger with fresh vegetables and cheese', 10000, 5, 'food2.jpg'),
('Fish and Chips', 'Crispy fried fish with golden french fries', 12000, 1, 'food3.jpg'),
('Caesar Salad', 'Fresh romaine lettuce with caesar dressing and croutons', 6000, 2, 'food4.jpg'),
('Grilled Chicken', 'Tasty grilled chicken breast with herbs', 15000, 1, 'food5.jpg'),
('Fruit Juice', 'Fresh mixed fruit juice (orange, mango, pineapple)', 3000, 3, 'food6.jpg'),
('Chocolate Cake', 'Rich and moist chocolate layer cake', 5000, 4, 'food7.jpg'),
('Pizza Margherita', 'Classic Italian pizza with tomato and mozzarella', 15000, 5, 'food8.jpg'),
('Spring Rolls', 'Crispy vegetable spring rolls with sweet chili sauce', 4000, 2, 'food9.jpg'),
('Coffee', 'Freshly brewed hot coffee', 2000, 3, 'food10.jpg'),
('Ice Cream', 'Creamy vanilla ice cream with chocolate topping', 3500, 4, 'food11.jpg'),
('Pasta Carbonara', 'Creamy pasta with bacon and parmesan cheese', 11000, 1, 'food12.jpg');

-- ============================================
-- Orders Table
-- ============================================
CREATE TABLE orders (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    total_amount DECIMAL(10,2) NOT NULL,
    status ENUM('pending', 'approved', 'rejected', 'completed', 'cancelled') DEFAULT 'pending',
    delivery_address TEXT,
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user (user_id),
    INDEX idx_status (status),
    INDEX idx_created (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Order Items Table
-- ============================================
CREATE TABLE order_items (
    id INT PRIMARY KEY AUTO_INCREMENT,
    order_id INT NOT NULL,
    food_id INT NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    price DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (food_id) REFERENCES foods(id) ON DELETE CASCADE,
    INDEX idx_order (order_id),
    INDEX idx_food (food_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Logs Table (for system activity tracking)
-- ============================================
CREATE TABLE logs (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    action VARCHAR(100) NOT NULL,
    details TEXT,
    ip_address VARCHAR(45),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_user (user_id),
    INDEX idx_action (action),
    INDEX idx_created (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert sample logs
INSERT INTO logs (user_id, action, details, ip_address) VALUES 
(1, 'system_init', 'Database initialized', '127.0.0.1'),
(1, 'user_created', 'Admin account created', '127.0.0.1'),
(2, 'user_registered', 'New user registered: john_doe', '127.0.0.1'),
(3, 'user_registered', 'New user registered: jane_smith', '127.0.0.1');
