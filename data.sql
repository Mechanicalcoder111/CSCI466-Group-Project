-- =========================
-- Justin Carney z1960727  |
-- Aasim Ghani  z2051554   |
-- Tyler Rouw 21942888     |
-- Liam Belh z2047328      |
-- Trevor Jannsen z2036452 |
-- =========================

-- ====================
-- Insert 20 Products |
-- ====================
INSERT INTO Product (name, description, price, stock_quantity) VALUES
('Laptop', '16GB RAM, 512GB SSD', 999.99, 50),
('Smartphone', '6.5" OLED, 128GB', 699.99, 100),
('Headphones', 'Noise-Canceling Wireless', 199.99, 75),
('Keyboard', 'Mechanical RGB', 149.99, 30),
('Mouse', 'Wireless Ergonomic', 49.99, 200),
('Monitor', '27" 4K IPS', 299.99, 40),
('Tablet', '10.5" 256GB', 499.99, 60),
('Smartwatch', 'Fitness Tracker', 129.99, 90),
('Printer', 'Wireless All-in-One', 199.99, 25),
('Speaker', 'Bluetooth Portable', 79.99, 150),
('Camera', 'Mirrorless 24MP', 899.99, 20),
('Router', 'Wi-Fi 6 Dual-Band', 129.99, 80),
('External SSD', '1TB USB-C', 149.99, 100),
('Gaming Chair', 'Ergonomic Design', 249.99, 15),
('Webcam', '1080p HD', 59.99, 120),
('Microphone', 'Studio Quality', 89.99, 50),
('Desk Lamp', 'LED Adjustable', 39.99, 200),
('Backpack', 'Waterproof Laptop', 69.99, 80),
('USB Hub', '4-Port USB 3.0', 29.99, 150),
('Mousepad', 'XXL Gaming', 19.99, 300);

-- ====================
-- Insert 5 Customers |
-- ====================
INSERT INTO User (username, email, password_hash, role) VALUES
('alice', 'alice@example.com', '$2y$10$hashed123', 'customer'),
('bob', 'bob@example.com', '$2y$10$hashed456', 'customer'),
('charlie', 'charlie@example.com', '$2y$10$hashed789', 'customer'),
('dave', 'dave@example.com', '$2y$10$hashed012', 'customer'),
('eve', 'eve@example.com', '$2y$10$hashed345', 'customer');

-- ================================
-- Insert Orders (1 per customer) |
-- ================================
INSERT INTO `Order` (user_id, total_amount, shipping_address) VALUES
(1, 1699.98, '123 Main St, City'),
(2, 899.99, '456 Oak St, Town'),
(3, 249.99, '789 Pine St, Village'),
(4, 149.99, '321 Maple St, Hamlet'),
(5, 199.99, '654 Elm St, County');

-- ======================
-- Insert OrderDetails  |
-- ======================
INSERT INTO OrderDetail (order_id, product_id, quantity, price_at_purchase) VALUES
(1, 1, 1, 999.99),
(1, 3, 2, 199.99),
(2, 2, 1, 699.99),
(3, 5, 3, 49.99),
(4, 10, 1, 79.99),
(5, 15, 2, 59.99);