-- ============================================
-- Alnoor Store – Database Export
-- Week 3: Database Connection Practice
-- BIT3208: Advanced Web Design and Development
-- Student: Ali Bishar | BBIT/2024/60394
-- ============================================

CREATE DATABASE IF NOT EXISTS `alnoor-store`;
USE `alnoor-store`;

-- ── Users table (prepared for Week 4 auth) ──
CREATE TABLE IF NOT EXISTS `users` (
    `id`         INT PRIMARY KEY AUTO_INCREMENT,
    `full_name`  VARCHAR(100) NOT NULL,
    `email`      VARCHAR(150) NOT NULL UNIQUE,
    `phone`      VARCHAR(20),
    `password`   VARCHAR(255) NOT NULL,
    `role`       ENUM('admin', 'customer') DEFAULT 'customer',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ── Products table (prepared for Week 5 CRUD) ──
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

-- ── Sample admin user ──
INSERT INTO `users` (`full_name`, `email`, `phone`, `password`, `role`)
VALUES ('Ali Bishar', 'ali@alnoorstore.com', '0700000000', 'admin1234', 'admin');

-- ── Sample products ──
INSERT INTO `products` (`name`, `description`, `price`, `category`, `stock`)
VALUES
    ('Wireless Headphones', 'High quality over-ear headphones', 3500.00, 'Electronics', 20),
    ('Men\'s Polo Shirt',   'Premium cotton polo shirt',        1200.00, 'Fashion',     50),
    ('Rice Cooker 1.8L',    'Automatic electric rice cooker',   2800.00, 'Home & Living', 15),
    ('Basmati Rice 5kg',    'Premium long grain basmati rice',   950.00, 'Groceries',   100);