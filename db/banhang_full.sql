-- Create database
CREATE DATABASE IF NOT EXISTS banhang CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE banhang;

-- Table: country
CREATE TABLE country (
    id INT AUTO_INCREMENT PRIMARY KEY,
    country_name VARCHAR(100) NOT NULL
);

-- Table: site_user
CREATE TABLE site_user (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email_address VARCHAR(255) NOT NULL UNIQUE,
    phone_number VARCHAR(50),
    password VARCHAR(255) NOT NULL
);

-- Table: address
CREATE TABLE address (
    id INT AUTO_INCREMENT PRIMARY KEY,
    unit_number VARCHAR(20),
    street_number VARCHAR(20),
    address_line1 VARCHAR(255),
    address_line2 VARCHAR(255),
    city VARCHAR(100),
    region VARCHAR(100),
    postal_code VARCHAR(20),
    country_id INT,
    FOREIGN KEY (country_id) REFERENCES country(id)
);

-- Table: user_address
CREATE TABLE user_address (
    user_id INT,
    address_id INT,
    is_default BOOLEAN DEFAULT FALSE,
    PRIMARY KEY (user_id, address_id),
    FOREIGN KEY (user_id) REFERENCES site_user(id),
    FOREIGN KEY (address_id) REFERENCES address(id)
);

-- Table: user_review
CREATE TABLE user_review (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    ordered_product_id INT,
    rating_value INT,
    comment TEXT,
    FOREIGN KEY (user_id) REFERENCES site_user(id)
    -- ordered_product_id FK will be added after order_line is created
);

-- Table: payment_type
CREATE TABLE payment_type (
    id INT AUTO_INCREMENT PRIMARY KEY,
    value VARCHAR(100) NOT NULL
);

-- Table: user_payment_method
CREATE TABLE user_payment_method (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    payment_type_id INT,
    provider VARCHAR(100),
    account_number VARCHAR(100),
    expiry_date DATE,
    is_default BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (user_id) REFERENCES site_user(id),
    FOREIGN KEY (payment_type_id) REFERENCES payment_type(id)
);

-- Table: shopping_cart
CREATE TABLE shopping_cart (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    FOREIGN KEY (user_id) REFERENCES site_user(id)
);

-- Table: product_category
CREATE TABLE product_category (
    id INT AUTO_INCREMENT PRIMARY KEY,
    parent_category_id INT,
    category_name VARCHAR(100) NOT NULL,
    FOREIGN KEY (parent_category_id) REFERENCES product_category(id)
);

-- Table: product
CREATE TABLE product (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    product_image VARCHAR(255),
    FOREIGN KEY (category_id) REFERENCES product_category(id)
);

-- Table: product_item
CREATE TABLE product_item (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT,
    SKU VARCHAR(100),
    qty_in_stock INT,
    product_image VARCHAR(255),
    price DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (product_id) REFERENCES product(id)
);

-- Table: variation
CREATE TABLE variation (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT,
    name VARCHAR(100) NOT NULL,
    FOREIGN KEY (category_id) REFERENCES product_category(id)
);

-- Table: variation_option
CREATE TABLE variation_option (
    id INT AUTO_INCREMENT PRIMARY KEY,
    variation_id INT,
    value VARCHAR(100) NOT NULL,
    FOREIGN KEY (variation_id) REFERENCES variation(id)
);

-- Table: product_configuration
CREATE TABLE product_configuration (
    product_item_id INT,
    variation_option_id INT,
    PRIMARY KEY (product_item_id, variation_option_id),
    FOREIGN KEY (product_item_id) REFERENCES product_item(id),
    FOREIGN KEY (variation_option_id) REFERENCES variation_option(id)
);

-- Table: promotion
CREATE TABLE promotion (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    discount_rate DECIMAL(5,2),
    start_date DATE,
    end_date DATE
);

-- Table: promotion_category
CREATE TABLE promotion_category (
    category_id INT,
    promotion_id INT,
    PRIMARY KEY (category_id, promotion_id),
    FOREIGN KEY (category_id) REFERENCES product(id),
    FOREIGN KEY (promotion_id) REFERENCES promotion(id)
);

-- Table: shopping_cart_item
CREATE TABLE shopping_cart_item (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cart_id INT,
    product_item_id INT,
    qty INT NOT NULL,
    FOREIGN KEY (cart_id) REFERENCES shopping_cart(id),
    FOREIGN KEY (product_item_id) REFERENCES product_item(id)
);

-- Table: shipping_method
CREATE TABLE shipping_method (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL
);

-- Table: order_status
CREATE TABLE order_status (
    id INT AUTO_INCREMENT PRIMARY KEY,
    status VARCHAR(50) NOT NULL
);

-- Table: shop_order
CREATE TABLE shop_order (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    order_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    payment_method_id INT,
    shipping_address INT,
    shipping_method INT,
    order_total DECIMAL(12,2),
    order_status INT,
    FOREIGN KEY (user_id) REFERENCES site_user(id),
    FOREIGN KEY (payment_method_id) REFERENCES user_payment_method(id),
    FOREIGN KEY (shipping_address) REFERENCES address(id),
    FOREIGN KEY (shipping_method) REFERENCES shipping_method(id),
    FOREIGN KEY (order_status) REFERENCES order_status(id)
);

-- Table: order_line
CREATE TABLE order_line (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_item_id INT,
    order_id INT,
    qty INT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (product_item_id) REFERENCES product_item(id),
    FOREIGN KEY (order_id) REFERENCES shop_order(id)
);

-- Add missing FK to user_review for ordered_product_id
ALTER TABLE user_review
    ADD CONSTRAINT fk_user_review_ordered_product
    FOREIGN KEY (ordered_product_id) REFERENCES order_line(id);
