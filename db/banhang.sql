-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th5 24, 2025 lúc 06:23 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `banhang`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_line`
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
-- Cấu trúc bảng cho bảng `order_status`
--

CREATE TABLE `order_status` (
  `id` int(11) NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `payment_type`
--

CREATE TABLE `payment_type` (
  `id` int(11) NOT NULL,
  `value` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `product_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_category`
--

CREATE TABLE `product_category` (
  `id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_configuration`
--

CREATE TABLE `product_configuration` (
  `product_item_id` int(11) NOT NULL,
  `variation_option_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_item`
--

CREATE TABLE `product_item` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `SKU` varchar(100) DEFAULT NULL,
  `qty_in_stock` int(11) DEFAULT NULL,
  `product_image` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `promotion`
--

CREATE TABLE `promotion` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `discount_rate` decimal(5,2) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `promotion_category`
--

CREATE TABLE `promotion_category` (
  `category_id` int(11) NOT NULL,
  `promotion_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `shipping_method`
--

CREATE TABLE `shipping_method` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `shopping_cart`
--

CREATE TABLE `shopping_cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `shopping_cart_item`
--

CREATE TABLE `shopping_cart_item` (
  `id` int(11) NOT NULL,
  `cart_id` int(11) DEFAULT NULL,
  `product_item_id` int(11) DEFAULT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `shop_order`
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
-- Cấu trúc bảng cho bảng `site_user`
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
-- Đang đổ dữ liệu cho bảng `site_user`
--

INSERT INTO `site_user` (`id`, `name`, `address`, `email`, `phone`, `username`, `password`, `role`) VALUES
(1, 'Chu Minh Vũ', NULL, 'vungu@gmail.com', '0333123456', 'vungu1', '123456', 1),
(2, 'Bùi Thịnh', NULL, 'thinhbui7779@gmail.com', '0333675969', 'thinh1', '123456', 1),
(3, 'Bùi Đức Thịnh', NULL, 'thinhbui7779@gmail.com', '0333675969', 'thinh2', '123456', 1),
(4, 'Bùi Đức Thịnh', NULL, 'thinhbui7779@gmail.com', '0333675969', 'thinh3', '123456', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user_payment_method`
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
-- Cấu trúc bảng cho bảng `user_review`
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
-- Cấu trúc bảng cho bảng `variation`
--

CREATE TABLE `variation` (
  `id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `variation_option`
--

CREATE TABLE `variation_option` (
  `id` int(11) NOT NULL,
  `variation_id` int(11) DEFAULT NULL,
  `value` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `order_line`
--
ALTER TABLE `order_line`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_item_id` (`product_item_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Chỉ mục cho bảng `order_status`
--
ALTER TABLE `order_status`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `payment_type`
--
ALTER TABLE `payment_type`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Chỉ mục cho bảng `product_category`
--
ALTER TABLE `product_category`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `product_configuration`
--
ALTER TABLE `product_configuration`
  ADD PRIMARY KEY (`product_item_id`,`variation_option_id`),
  ADD KEY `variation_option_id` (`variation_option_id`);

--
-- Chỉ mục cho bảng `product_item`
--
ALTER TABLE `product_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `promotion`
--
ALTER TABLE `promotion`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `promotion_category`
--
ALTER TABLE `promotion_category`
  ADD PRIMARY KEY (`category_id`,`promotion_id`),
  ADD KEY `promotion_id` (`promotion_id`);

--
-- Chỉ mục cho bảng `shipping_method`
--
ALTER TABLE `shipping_method`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `shopping_cart`
--
ALTER TABLE `shopping_cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `shopping_cart_item`
--
ALTER TABLE `shopping_cart_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cart_id` (`cart_id`),
  ADD KEY `product_item_id` (`product_item_id`);

--
-- Chỉ mục cho bảng `shop_order`
--
ALTER TABLE `shop_order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `payment_method_id` (`payment_method_id`),
  ADD KEY `shipping_method` (`shipping_method`),
  ADD KEY `order_status` (`order_status`);

--
-- Chỉ mục cho bảng `site_user`
--
ALTER TABLE `site_user`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `user_payment_method`
--
ALTER TABLE `user_payment_method`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `payment_type_id` (`payment_type_id`);

--
-- Chỉ mục cho bảng `user_review`
--
ALTER TABLE `user_review`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `ordered_product_id` (`ordered_product_id`);

--
-- Chỉ mục cho bảng `variation`
--
ALTER TABLE `variation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Chỉ mục cho bảng `variation_option`
--
ALTER TABLE `variation_option`
  ADD PRIMARY KEY (`id`),
  ADD KEY `variation_id` (`variation_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `order_line`
--
ALTER TABLE `order_line`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `order_status`
--
ALTER TABLE `order_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `payment_type`
--
ALTER TABLE `payment_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `product_category`
--
ALTER TABLE `product_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `product_item`
--
ALTER TABLE `product_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `promotion`
--
ALTER TABLE `promotion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `shipping_method`
--
ALTER TABLE `shipping_method`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `shopping_cart`
--
ALTER TABLE `shopping_cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `shopping_cart_item`
--
ALTER TABLE `shopping_cart_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `shop_order`
--
ALTER TABLE `shop_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `site_user`
--
ALTER TABLE `site_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `user_payment_method`
--
ALTER TABLE `user_payment_method`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `user_review`
--
ALTER TABLE `user_review`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `variation`
--
ALTER TABLE `variation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `variation_option`
--
ALTER TABLE `variation_option`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `order_line`
--
ALTER TABLE `order_line`
  ADD CONSTRAINT `order_line_ibfk_1` FOREIGN KEY (`product_item_id`) REFERENCES `product_item` (`id`),
  ADD CONSTRAINT `order_line_ibfk_2` FOREIGN KEY (`order_id`) REFERENCES `shop_order` (`id`);

--
-- Các ràng buộc cho bảng `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `product_category` (`id`);

--
-- Các ràng buộc cho bảng `product_configuration`
--
ALTER TABLE `product_configuration`
  ADD CONSTRAINT `product_configuration_ibfk_1` FOREIGN KEY (`product_item_id`) REFERENCES `product_item` (`id`),
  ADD CONSTRAINT `product_configuration_ibfk_2` FOREIGN KEY (`variation_option_id`) REFERENCES `variation_option` (`id`);

--
-- Các ràng buộc cho bảng `product_item`
--
ALTER TABLE `product_item`
  ADD CONSTRAINT `product_item_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);

--
-- Các ràng buộc cho bảng `promotion_category`
--
ALTER TABLE `promotion_category`
  ADD CONSTRAINT `promotion_category_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `product_category` (`id`),
  ADD CONSTRAINT `promotion_category_ibfk_2` FOREIGN KEY (`promotion_id`) REFERENCES `promotion` (`id`);

--
-- Các ràng buộc cho bảng `shopping_cart`
--
ALTER TABLE `shopping_cart`
  ADD CONSTRAINT `shopping_cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `site_user` (`id`);

--
-- Các ràng buộc cho bảng `shopping_cart_item`
--
ALTER TABLE `shopping_cart_item`
  ADD CONSTRAINT `shopping_cart_item_ibfk_1` FOREIGN KEY (`cart_id`) REFERENCES `shopping_cart` (`id`),
  ADD CONSTRAINT `shopping_cart_item_ibfk_2` FOREIGN KEY (`product_item_id`) REFERENCES `product_item` (`id`);

--
-- Các ràng buộc cho bảng `shop_order`
--
ALTER TABLE `shop_order`
  ADD CONSTRAINT `shop_order_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `site_user` (`id`),
  ADD CONSTRAINT `shop_order_ibfk_2` FOREIGN KEY (`payment_method_id`) REFERENCES `user_payment_method` (`id`),
  ADD CONSTRAINT `shop_order_ibfk_3` FOREIGN KEY (`shipping_method`) REFERENCES `shipping_method` (`id`),
  ADD CONSTRAINT `shop_order_ibfk_4` FOREIGN KEY (`order_status`) REFERENCES `order_status` (`id`);

--
-- Các ràng buộc cho bảng `user_payment_method`
--
ALTER TABLE `user_payment_method`
  ADD CONSTRAINT `user_payment_method_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `site_user` (`id`),
  ADD CONSTRAINT `user_payment_method_ibfk_2` FOREIGN KEY (`payment_type_id`) REFERENCES `payment_type` (`id`);

--
-- Các ràng buộc cho bảng `user_review`
--
ALTER TABLE `user_review`
  ADD CONSTRAINT `user_review_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `site_user` (`id`),
  ADD CONSTRAINT `user_review_ibfk_2` FOREIGN KEY (`ordered_product_id`) REFERENCES `order_line` (`id`);

--
-- Các ràng buộc cho bảng `variation`
--
ALTER TABLE `variation`
  ADD CONSTRAINT `variation_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `product_category` (`id`);

--
-- Các ràng buộc cho bảng `variation_option`
--
ALTER TABLE `variation_option`
  ADD CONSTRAINT `variation_option_ibfk_1` FOREIGN KEY (`variation_id`) REFERENCES `variation` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
