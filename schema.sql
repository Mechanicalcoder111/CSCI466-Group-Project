-- =========================
-- Justin Carney z1960727  |
-- Aasim Ghani  z2051554   |
-- Tyler Rouw 21942888     |
-- Liam Belh z2047328      |
-- Trevor Jannsen z2036452 |
-- =========================

-- ==================================
-- Drop existing tables (if needed) |
-- ==================================

DROP TABLE IF EXISTS OrderDetail;
DROP TABLE IF EXISTS `Order`;
DROP TABLE IF EXISTS Product;
DROP TABLE IF EXISTS User;

-- ====================
-- Create User Table  |
-- ====================
CREATE TABLE User (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('customer', 'employee') DEFAULT 'customer'
);

-- ======================
-- Create Product Table |
-- ======================
CREATE TABLE Product (
    product_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    stock_quantity INT NOT NULL
);

-- ======================
-- | Create Order Table |
-- ======================
CREATE TABLE `Order` (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    order_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    total_amount DECIMAL(10,2) NOT NULL,
    status ENUM('Processing', 'Shipped') DEFAULT 'Processing',
    shipping_address TEXT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES User(user_id)
);

-- ==========================
-- Create OrderDetail Table |
-- ==========================
CREATE TABLE OrderDetail (
    order_id INT,
    product_id INT,
    quantity INT NOT NULL,
    price_at_purchase DECIMAL(10,2) NOT NULL,
    PRIMARY KEY (order_id, product_id),
    FOREIGN KEY (order_id) REFERENCES `Order`(order_id),
    FOREIGN KEY (product_id) REFERENCES Product(product_id)
);