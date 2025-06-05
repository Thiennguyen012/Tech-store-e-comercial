-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 05, 2025 at 03:54 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Table structure for table `order_line`
--

CREATE TABLE `order_line` (
  `id` int(11) NOT NULL,
  `product_item_id` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `qty` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_status`
--

CREATE TABLE `order_status` (
  `id` int(11) NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_type`
--

CREATE TABLE `payment_type` (
  `id` int(11) NOT NULL,
  `value` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `qty_in_stock` int(11) DEFAULT NULL,
  `product_image` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `name`, `description`, `category_id`, `qty_in_stock`, `product_image`, `price`) VALUES
(1, 'Acer Aspire 3 Intel Celeron 4GB RAM 128GB SSD 15.6 Inch Windows 11 Laptop', 'Highlighting form and function, a stunningly slim body and impressive tactile finish accentuate real-world design features. Built to keep you active, engaged, and on the move, the Aspire 3 has the technology to suit your way of life. Fundamentally impressive technology.\r\nEfficient Performance with Intel Celeron N4500\r\nThe Acer Aspire 3 A315-35 is powered by the Intel Celeron N4500 processor, delivering reliable performance for everyday computing tasks. With speeds of up to 2.8 GHz, this dual-core processor ensures smooth web browsing, document editing, and media playback. Whether you\'re working on assignments, streaming content, or managing emails, the Aspire 3 provides a seamless user experience.Crisp 15.6-Inch HD Display for Everyday Use\r\nFeaturing a 15.6-inch HD (1366 x 768) TN display, the Aspire 3 offers clear visuals and vibrant colors for work and entertainment. The anti-glare screen reduces reflections, making it comfortable to use in various lighting conditions. Its widescreen format enhances productivity, allowing you to view multiple applications simultaneously without feeling cramped.Fast and Reliable Storage with 128GB NVMe SSD\r\nThe 128GB NVMe SSD provides quick boot times and fast data access, ensuring efficient performance for everyday computing. With 3D Triple-Level Cell (TLC) technology, the SSD offers durability and reliability, making file transfers and software loading times much faster compared to traditional hard drives. This storage capacity is ideal for essential applications, documents, and media files.Seamless Connectivity with Wi-Fi 6 and Gigabit Ethernet\r\nStay connected with the latest Wi-Fi 6 technology, providing faster and more stable wireless connections for browsing, streaming, and online meetings. The Aspire 3 also includes a Gigabit Ethernet port for a reliable wired connection when needed. Whether at home, in the office, or on the go, you can enjoy uninterrupted connectivity for all your online activities.Sleek Design with a Comfortable UK Keyboard\r\nFinished in an elegant pure silver design, the Acer Aspire 3 offers a stylish and lightweight build, making it easy to carry wherever you go. The UK keyboard layout ensures comfortable and accurate typing, ideal for students and professionals alike. With a full-sized keyboard and precision touchpad, navigating through tasks becomes effortless, enhancing your overall productivity.', 1, 10, 'https://www.laptopsdirect.co.uk/Images/NX.A6LEK.00P_3_Supersize.jpg?width=750&height=750&v=3', 179.89);

-- --------------------------------------------------------

--
-- Table structure for table `product_category`
--

CREATE TABLE `product_category` (
  `id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_category`
--

INSERT INTO `product_category` (`id`, `category_name`) VALUES
(1, 'laptop'),
(2, 'camera');

-- --------------------------------------------------------

--
-- Table structure for table `product_configuration`
--

CREATE TABLE `product_configuration` (
  `product_id` int(11) NOT NULL,
  `variation_id` int(11) NOT NULL,
  `value` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_configuration`
--

INSERT INTO `product_configuration` (`product_id`, `variation_id`, `value`) VALUES
(1, 1, 'Everyday'),
(1, 4, '15.6\"'),
(1, 2, 'Acer'),
(1, 3, 'Intel Celeron'),
(1, 5, '4GB'),
(1, 10, 'Windows 11'),
(1, 11, '128GB SSD');

-- --------------------------------------------------------

--
-- Table structure for table `shipping_method`
--

CREATE TABLE `shipping_method` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shopping_cart`
--

CREATE TABLE `shopping_cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shopping_cart_item`
--

CREATE TABLE `shopping_cart_item` (
  `id` int(11) NOT NULL,
  `cart_id` int(11) DEFAULT NULL,
  `product_item_id` int(11) DEFAULT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shop_order`
--

CREATE TABLE `shop_order` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `order_date` datetime DEFAULT current_timestamp(),
  `payment_method_id` int(11) DEFAULT NULL,
  `shipping_address_line` varchar(255) DEFAULT NULL,
  `shipping_method` int(11) DEFAULT NULL,
  `order_total` decimal(12,2) DEFAULT NULL,
  `order_status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `site_user`
--

CREATE TABLE `site_user` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `site_user`
--

INSERT INTO `site_user` (`id`, `name`, `address`, `email`, `phone`, `username`, `password`, `role`) VALUES
(1, 'Chu Minh Vũ', NULL, 'vungu@gmail.com', '0333123456', 'vungu1', '123456', 1),
(2, 'Bùi Thịnh', NULL, 'thinhbui7779@gmail.com', '0333675969', 'thinh1', '123456', 1),
(3, 'Bùi Đức Thịnh', NULL, 'thinhbui7779@gmail.com', '0333675969', 'thinh2', '123456', 1),
(4, 'Bùi Đức Thịnh', NULL, 'thinhbui7779@gmail.com', '0333675969', 'thinh3', '123456', 1),
(5, 'Vũ Chu', NULL, 'chuminhvubu1@gmail.com', '0389040222', 'WhiteYin69', '1234', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_payment_method`
--

CREATE TABLE `user_payment_method` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `payment_type_id` int(11) DEFAULT NULL,
  `account_number` varchar(100) DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `is_default` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_review`
--

CREATE TABLE `user_review` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `ordered_product_id` int(11) DEFAULT NULL,
  `rating_value` int(11) DEFAULT NULL,
  `comment` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `variation`
--

CREATE TABLE `variation` (
  `id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `variation`
--

INSERT INTO `variation` (`id`, `category_id`, `name`) VALUES
(1, 1, 'Use'),
(2, 1, 'Brand'),
(3, 1, 'CPU'),
(4, 1, 'Screen Size'),
(5, 1, 'RAM'),
(6, 1, 'GPU'),
(7, 1, 'Refresh Rate'),
(8, 1, 'Touch Screen'),
(9, 1, 'Color'),
(10, 1, 'Operating system'),
(11, 1, 'Storage Capacity');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `order_line`
--
ALTER TABLE `order_line`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_item_id` (`product_item_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `order_status`
--
ALTER TABLE `order_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_type`
--
ALTER TABLE `payment_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_product_category` (`category_id`);

--
-- Indexes for table `product_category`
--
ALTER TABLE `product_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_configuration`
--
ALTER TABLE `product_configuration`
  ADD PRIMARY KEY (`product_id`,`variation_id`),
  ADD KEY `variation_id` (`variation_id`);

--
-- Indexes for table `shipping_method`
--
ALTER TABLE `shipping_method`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shopping_cart`
--
ALTER TABLE `shopping_cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `shopping_cart_item`
--
ALTER TABLE `shopping_cart_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cart_id` (`cart_id`),
  ADD KEY `product_item_id` (`product_item_id`);

--
-- Indexes for table `shop_order`
--
ALTER TABLE `shop_order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `payment_method_id` (`payment_method_id`),
  ADD KEY `shipping_method` (`shipping_method`),
  ADD KEY `order_status` (`order_status`);

--
-- Indexes for table `site_user`
--
ALTER TABLE `site_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_payment_method`
--
ALTER TABLE `user_payment_method`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `payment_type_id` (`payment_type_id`);

--
-- Indexes for table `user_review`
--
ALTER TABLE `user_review`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `ordered_product_id` (`ordered_product_id`);

--
-- Indexes for table `variation`
--
ALTER TABLE `variation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `order_line`
--
ALTER TABLE `order_line`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_status`
--
ALTER TABLE `order_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment_type`
--
ALTER TABLE `payment_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `product_category`
--
ALTER TABLE `product_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `shipping_method`
--
ALTER TABLE `shipping_method`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shopping_cart`
--
ALTER TABLE `shopping_cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shopping_cart_item`
--
ALTER TABLE `shopping_cart_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shop_order`
--
ALTER TABLE `shop_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `site_user`
--
ALTER TABLE `site_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user_payment_method`
--
ALTER TABLE `user_payment_method`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_review`
--
ALTER TABLE `user_review`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `variation`
--
ALTER TABLE `variation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order_line`
--
ALTER TABLE `order_line`
  ADD CONSTRAINT `order_line_ibfk_1` FOREIGN KEY (`product_item_id`) REFERENCES `product` (`id`),
  ADD CONSTRAINT `order_line_ibfk_2` FOREIGN KEY (`order_id`) REFERENCES `shop_order` (`id`);

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `fk_product_category` FOREIGN KEY (`category_id`) REFERENCES `product_category` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_ibfk_category` FOREIGN KEY (`category_id`) REFERENCES `product_category` (`id`);

--
-- Constraints for table `product_configuration`
--
ALTER TABLE `product_configuration`
  ADD CONSTRAINT `fk_productconfig_product` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_productconfig_variation` FOREIGN KEY (`variation_id`) REFERENCES `variation` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_configuration_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  ADD CONSTRAINT `product_configuration_ibfk_3` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `shopping_cart`
--
ALTER TABLE `shopping_cart`
  ADD CONSTRAINT `shopping_cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `site_user` (`id`);

--
-- Constraints for table `shopping_cart_item`
--
ALTER TABLE `shopping_cart_item`
  ADD CONSTRAINT `shopping_cart_item_ibfk_1` FOREIGN KEY (`cart_id`) REFERENCES `shopping_cart` (`id`),
  ADD CONSTRAINT `shopping_cart_item_ibfk_2` FOREIGN KEY (`product_item_id`) REFERENCES `product` (`id`);

--
-- Constraints for table `shop_order`
--
ALTER TABLE `shop_order`
  ADD CONSTRAINT `shop_order_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `site_user` (`id`),
  ADD CONSTRAINT `shop_order_ibfk_2` FOREIGN KEY (`payment_method_id`) REFERENCES `user_payment_method` (`id`),
  ADD CONSTRAINT `shop_order_ibfk_3` FOREIGN KEY (`shipping_method`) REFERENCES `shipping_method` (`id`),
  ADD CONSTRAINT `shop_order_ibfk_4` FOREIGN KEY (`order_status`) REFERENCES `order_status` (`id`);

--
-- Constraints for table `user_payment_method`
--
ALTER TABLE `user_payment_method`
  ADD CONSTRAINT `user_payment_method_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `site_user` (`id`),
  ADD CONSTRAINT `user_payment_method_ibfk_2` FOREIGN KEY (`payment_type_id`) REFERENCES `payment_type` (`id`);

--
-- Constraints for table `user_review`
--
ALTER TABLE `user_review`
  ADD CONSTRAINT `user_review_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `site_user` (`id`),
  ADD CONSTRAINT `user_review_ibfk_2` FOREIGN KEY (`ordered_product_id`) REFERENCES `order_line` (`id`);

--
-- Constraints for table `variation`
--
ALTER TABLE `variation`
  ADD CONSTRAINT `fk_variation_category` FOREIGN KEY (`category_id`) REFERENCES `product_category` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `variation_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `product_category` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
