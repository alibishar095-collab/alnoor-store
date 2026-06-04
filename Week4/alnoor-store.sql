-- ============================================
-- Alnoor Store – Database Export
-- Week 4: Backend Development & Authentication
-- BIT3208: Advanced Web Design and Development
-- Student: Ali Bishar | BBIT/2024/60394
-- ============================================

CREATE DATABASE IF NOT EXISTS `alnoor-store`;
USE `alnoor-store`;

-- ── Users table ──
CREATE TABLE IF NOT EXISTS `users` (
    `id`         INT PRIMARY KEY AUTO_INCREMENT,
    `full_name`  VARCHAR(100) NOT NULL,
    `email`      VARCHAR(150) NOT NULL UNIQUE,
    `phone`      VARCHAR(20),
    `password`   VARCHAR(255) NOT NULL,
    `role`       ENUM('admin', 'customer') DEFAULT 'customer',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ── Products table ──
CREATE TABLE IF NOT EXISTS `products` (
    `id`          INT PRIMARY KEY AUTO_INCREMENT,
    `name`        VARCHAR(150) NOT NULL,
    `description` TEXT,
    `price`       DECIMAL(10,2) NOT NULL,
    `category`    VARCHAR(100),
    `image`       VARCHAR(255),
    `stock`       INT DEFAULT 0,
    `created_at`  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ── Sessions table (for tracking) ──
CREATE TABLE IF NOT EXISTS `user_sessions` (
    `id`         INT PRIMARY KEY AUTO_INCREMENT,
    `user_id`    INT NOT NULL,
    `login_time` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
);

-- ── Sample admin user ──
INSERT IGNORE INTO `users` (`full_name`, `email`, `phone`, `password`, `role`)
VALUES (
    'Ali Bishar',
    'ali@alnoorstore.com',
    '0700000000',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
    'admin'
);

-- ── Sample products ──
INSERT IGNORE INTO `products` (`name`, `description`, `price`, `category`, `stock`)
VALUES
    ('Wireless Headphones', 'High quality over-ear headphones', 3500.00, 'Electronics',   20),
    ('Men\'s Polo Shirt',   'Premium cotton polo shirt',        1200.00, 'Fashion',        50),
    ('Rice Cooker 1.8L',    'Automatic electric rice cooker',   2800.00, 'Home & Living',  15),
    ('Basmati Rice 5kg',    'Premium long grain basmati rice',   950.00, 'Groceries',     100),
    ('Smart Watch',         'Fitness tracking smart watch',     4500.00, 'Electronics',    30),
    ('Ladies Handbag',      'Genuine leather handbag',          2200.00, 'Fashion',        25),
    ('Wall Clock',          'Modern minimalist wall clock',      850.00, 'Home & Living',  40),
    ('Cooking Oil 5L',      'Pure sunflower cooking oil',        780.00, 'Groceries',      60);