
-- Tạo database
CREATE DATABASE IF NOT EXISTS banhang CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE banhang;

-- Bảng người dùng
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user') DEFAULT 'user',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Bảng danh mục sản phẩm
CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL
);

-- Bảng sản phẩm
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    category_id INT,
    image VARCHAR(255),
    description TEXT,
    FOREIGN KEY (category_id) REFERENCES categories(id)
);

-- Bảng đơn hàng
CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    status ENUM('pending','paid','shipped','cancelled') DEFAULT 'pending',
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Bảng chi tiết đơn hàng
CREATE TABLE IF NOT EXISTS order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT,
    product_id INT,
    quantity INT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);

-- Dữ liệu mẫu cho categories
INSERT INTO categories (name) VALUES ('Laptop'), ('Camera');

-- Dữ liệu mẫu cho products
INSERT INTO products (name, price, category_id, image, description) VALUES
('Laptop Dell Inspiron', 15000000, 1, 'laptop_dell.jpg', 'Laptop Dell cấu hình mạnh'),
('Laptop HP Pavilion', 18000000, 1, 'laptop_hp.jpg', 'HP Pavilion 15-inch'),
('Camera Canon EOS', 12000000, 2, 'camera_canon.jpg', 'Máy ảnh Canon chuyên nghiệp'),
('Camera Sony Alpha', 15500000, 2, 'camera_sony.jpg', 'Sony Alpha mirrorless');

-- Dữ liệu mẫu cho users
INSERT INTO users (username, password, email, role) VALUES
('admin', '123456', 'admin@example.com', 'admin'),
('user1', '123456', 'user1@example.com', 'user');
