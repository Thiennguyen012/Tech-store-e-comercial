-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th6 21, 2025 lúc 05:42 AM
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
-- Cấu trúc bảng cho bảng `bill`
--

CREATE TABLE `bill` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `order_date` datetime DEFAULT current_timestamp(),
  `order_name` varchar(50) NOT NULL,
  `order_phone` varchar(50) NOT NULL,
  `order_address` varchar(255) DEFAULT NULL,
  `order_total` decimal(12,2) DEFAULT NULL,
  `order_paymethod` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0: thanh toán offline, 1: thanh toán online',
  `order_status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `bill`
--

INSERT INTO `bill` (`id`, `user_id`, `order_date`, `order_name`, `order_phone`, `order_address`, `order_total`, `order_paymethod`, `order_status`) VALUES
(1, NULL, '2025-06-18 00:12:32', '', '', '', 438.90, 0, NULL),
(2, NULL, '2025-06-18 00:30:02', '', '', '', 548.90, 0, NULL),
(3, NULL, '2025-06-18 00:35:08', '', '', '', 877.80, 0, NULL),
(4, NULL, '2025-06-18 00:40:17', '', '', '', 50.24, 0, NULL),
(5, NULL, '2025-06-18 01:10:16', 'Thien dep trai ne', '123', 'vn', 438.90, 0, NULL),
(6, NULL, '2025-06-18 01:10:53', 'hẹ ', 'hẹ ', 'hẹ', 2306.70, 0, NULL),
(7, NULL, '2025-06-18 01:15:10', 'kk', 'kk', '1', 746.78, 0, NULL),
(8, NULL, '2025-06-18 01:19:13', 'Thien dep trai ne', '123', 'vn', 438.90, 0, NULL),
(9, NULL, '2025-06-18 01:19:50', 'Thien dep trai ne', '123', 'vn', 50.24, 0, NULL),
(10, NULL, '2025-06-18 01:21:05', 'Thien dep trai ne', '123', 'vn', 438.90, 0, NULL),
(11, NULL, '2025-06-18 01:21:32', 'Thien dep trai ne', '123', 'vn', 548.90, 0, NULL),
(12, NULL, '2025-06-18 01:23:36', 'Thien dep trai ne', '123', 'vn', 197.88, 0, NULL),
(13, NULL, '2025-06-18 01:37:52', 'Thien dep trai ne', '123', 'vn', 197.88, 0, NULL),
(14, NULL, '2025-06-18 01:46:17', '', '', '', 548.90, 0, NULL),
(15, NULL, '2025-06-18 01:49:03', '36', '36', '36', 438.90, 0, NULL),
(16, NULL, '2025-06-18 01:49:48', '36', '36', '37', 32.99, 0, NULL),
(17, NULL, '2025-06-18 01:50:38', 'Thien dep trai ne', '123', 'vn', 197.88, 0, NULL),
(18, NULL, '2025-06-18 01:52:08', 'Thien dep trai ne', '123', 'vn', 1241.76, 0, NULL),
(19, NULL, '2025-06-18 01:53:01', '36', '36', '36', 54.99, 0, NULL),
(20, NULL, '2025-06-18 22:55:00', 'Bùi Thịnh', '0333675969', 'tao bắn phi phai', 219.99, 0, NULL),
(21, NULL, '2025-06-18 22:56:07', '36', '36', '36', 438.90, 0, NULL),
(22, NULL, '2025-06-18 22:57:28', 'Thien dep trai ne', '123', 'vn', 1097.25, 0, NULL),
(23, NULL, '2025-06-18 23:06:58', 'Bùi Thịnh', '0333675969', 'tao bắn phi phai', 714.97, 0, NULL),
(24, 2, '2025-06-18 23:44:14', '1', '1', '1', 438.90, 0, NULL),
(25, 2, '2025-06-18 23:54:40', 'Bùi Thịnh', '0333675969', 'tao bắn phi phai', 197.88, 0, NULL),
(26, 2, '2025-06-19 00:21:59', 'Bùi Thịnh', '0333675969', 'tao bắn phi phai', 438.90, 0, NULL),
(27, 2, '2025-06-19 00:52:02', 'Bùi Thịnh', '0333675969', 'tao bắn phi phai', 515.88, 0, NULL),
(28, 2, '2025-06-19 00:56:25', 'Bùi Thịnh', '0333675969', 'tao bắn phi phai', 438.90, 0, NULL),
(29, 2, '2025-06-19 01:00:05', 'Bùi Thịnh', '0333675969', 'tao bắn phi phai', 438.90, 0, NULL),
(30, 2, '2025-06-19 01:00:54', '2', '2', '2', 1013.19, 0, NULL),
(31, 2, '2025-06-19 01:21:10', 'Bùi Thịnh', '0333675969', 'tao bắn phi phai', 197.88, 0, NULL),
(32, 2, '2025-06-19 01:24:29', 'Bùi Thịnh', '0333675969', 'tao bắn phi phai', 438.90, 0, NULL),
(33, 2, '2025-06-19 01:27:21', 'Bùi Thịnh', '0333675969', 'tao bắn phi phai', 32.99, 0, NULL),
(34, 2, '2025-06-19 01:27:28', 'Bùi Thịnh', '0333675969', 'tao bắn phi phai', 197.88, 0, NULL),
(35, 2, '2025-06-19 01:27:49', 'Bùi Thịnh', '0333675969', 'tao bắn phi phai', 197.88, 0, NULL),
(36, 2, '2025-06-19 01:47:10', 'Bùi Thịnh', '0333675969', 'tao bắn phi phai', 197.88, 0, NULL),
(37, 2, '2025-06-19 01:49:16', 'Bùi Thịnh', '0333675969', 'tao bắn phi phai', 438.90, 0, NULL),
(38, 2, '2025-06-19 01:51:36', 'Bùi Thịnh', '0333675969', 'tao bắn phi phai', 438.90, 0, NULL),
(39, 2, '2025-06-19 01:55:01', 'Bùi Thịnh', '0333675969', 'tao bắn phi phai', 438.90, 0, NULL),
(40, 2, '2025-06-19 02:00:49', 'Bùi Thịnh', '0333675969', 'tao bắn phi phai', 658.90, 0, NULL),
(41, 2, '2025-06-19 02:04:43', 'Bùi Thịnh', '0333675969', 'tao bắn phi phai', 438.90, 0, NULL),
(42, 2, '2025-06-19 02:09:42', 'Bùi Thịnh', '0333675969', 'tao bắn phi phai', 438.90, 0, NULL),
(43, 2, '2025-06-19 02:17:44', 'Bùi Thịnh', '0333675969', 'tao bắn phi phai', 197.88, 0, NULL),
(44, 2, '2025-06-19 02:20:51', 'Bùi Thịnh', '0333675969', 'tao bắn phi phai', 438.90, 0, NULL),
(45, 2, '2025-06-19 02:21:51', 'Bùi Thịnh', '0333675969', 'tao bắn phi phai', 549.97, 0, NULL),
(46, 2, '2025-06-19 02:24:00', 'Bùi Thịnh', '0333675969', 'tao bắn phi phai', 1097.25, 0, NULL),
(47, 2, '2025-06-19 02:25:20', 'Bùi Thịnh', '0333675969', 'tao bắn phi phai', 438.90, 0, NULL),
(48, 8, '2025-06-19 02:47:16', '18', '36', '36', 1955.68, 0, NULL),
(49, 2, '2025-06-19 10:31:32', 'Bùi Thịnh', '0333675969', 'tao bắn phi phai', 438.90, 0, NULL),
(50, 9, '2025-06-19 10:57:27', '1', '1', '1', 197.88, 0, NULL),
(51, 2, '2025-06-19 11:01:26', 'Bùi Thịnh', '0333675969', 'tao bắn phi phai', 384.97, 0, NULL),
(52, 2, '2025-06-19 11:07:24', 'Bùi Thịnh', '0333675969', 'tao bắn phi phai', 768.90, 0, NULL),
(53, 2, '2025-06-19 11:20:46', 'Bùi Thịnh', '0333675969', 'tao bắn phi phai', 1538.90, 0, NULL),
(54, 2, '2025-06-19 11:26:26', 'Bùi Thịnh', '0333675969', 'tao bắn phi phai', 3298.90, 0, NULL),
(55, 2, '2025-06-19 11:47:20', 'Bùi Thịnh', '0333675969', 'tao bắn phi phai', 438.90, 0, NULL),
(56, 2, '2025-06-19 15:27:19', 'Bùi Thịnh', '0333675969', 'tao bắn phi phai', 438.90, 0, NULL),
(57, 2, '2025-06-19 15:28:31', 'Bùi Thịnh', '0333675969', 'tao bắn phi phai', 1013.19, 0, NULL),
(58, 2, '2025-06-19 16:03:58', 'Bùi Thịnh', '0333675969', 'tao bắn phi phai', 6155.60, 0, NULL),
(59, 2, '2025-06-21 00:35:49', 'Bùi Thịnh', '0333675969', 'tao bắn phi phai', 197.88, 0, NULL),
(60, 2, '2025-06-21 01:55:59', 'Bùi Thịnh', '0333675969', 'tao bắn phi phai', 438.90, 0, NULL),
(61, 8, '2025-06-21 02:53:06', '31313', '51415', 'fff', 603.90, 0, NULL),
(62, 8, '2025-06-21 02:56:27', '414', '51', '12', 252.98, 0, NULL),
(63, 2, '2025-06-21 10:19:45', 'Bùi Thịnh', '0333675969', 'tao bắn phi phai', 2715.15, 0, NULL),
(64, 2, '2025-06-21 10:23:36', 'Bùi Thịnh', '0333675969', 'tao bắn phi phai', 759.51, 0, NULL),
(65, 2, '2025-06-21 10:24:52', 'Bùi Thịnh', '0333675969', 'tao bắn phi phai', 3406.70, 0, NULL),
(66, 2, '2025-06-21 10:28:12', 'Bùi Thịnh', '0333675969', 'tao bắn phi phai', 438.90, 0, NULL),
(67, 2, '2025-06-21 10:30:31', 'Bùi Thịnh', '0333675969', 'tao bắn phi phai', 603.90, 0, NULL),
(68, 2, '2025-06-21 10:31:57', 'Bùi Thịnh', '0333675969', 'tao bắn phi phai', 768.90, 0, NULL),
(69, 2, '2025-06-21 10:36:07', 'Bùi Thịnh', '0333675969', 'tao bắn phi phai', 603.90, 0, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `checkout_cart`
--

CREATE TABLE `checkout_cart` (
  `id` int(11) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `product_image` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `bill_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `checkout_cart`
--

INSERT INTO `checkout_cart` (`id`, `product_name`, `product_image`, `price`, `quantity`, `total`, `bill_id`) VALUES
(1, 'Dell Latitude 7400 Intel Core i5 8th Gen 16GB 256GB 14 Inch Win 11 Pro', 'https://www.laptopsdirect.co.uk/Images/T15420i516GB256GBW10P_1_Supersize.jpg?v=3', 399.00, 1, 399.00, 1),
(2, 'Dell Latitude 5420 Core i5 11th Gen 16GB 256GB 14 Inch Windows 10 Pro', 'https://www.laptopsdirect.co.uk/Images/T17400i516GB256GBW11P_1_Supersize.jpg?v=3', 499.00, 1, 499.00, 2),
(3, 'Dell Latitude 7400 Intel Core i5 8th Gen 16GB 256GB 14 Inch Win 11 Pro', 'https://www.laptopsdirect.co.uk/Images/T15420i516GB256GBW10P_1_Supersize.jpg?v=3', 399.00, 2, 798.00, 3),
(4, 'TP-Link VIGI C240I 4mm 4MP Dome Camera', 'https://hanoicomputercdn.com/media/product/74709_camera_tp_link_vigi_c240l_4mm_1.jpg', 45.67, 1, 45.67, 4),
(5, 'Dell Latitude 7400 Intel Core i5 8th Gen 16GB 256GB 14 Inch Win 11 Pro', 'https://www.laptopsdirect.co.uk/Images/T15420i516GB256GBW10P_1_Supersize.jpg?v=3', 399.00, 1, 399.00, 5),
(6, 'Dell Latitude 7400 Intel Core i5 8th Gen 16GB 256GB 14 Inch Win 11 Pro', 'https://www.laptopsdirect.co.uk/Images/T15420i516GB256GBW10P_1_Supersize.jpg?v=3', 399.00, 1, 399.00, 6),
(7, 'Dell Latitude 5420 Core i5 11th Gen 16GB 256GB 14 Inch Windows 10 Pro', 'https://www.laptopsdirect.co.uk/Images/T17400i516GB256GBW11P_1_Supersize.jpg?v=3', 499.00, 1, 499.00, 6),
(8, 'ASUS TUF A15 Ryzen 7 7435HS 16GB RAM 512GB SSD RTX 4060 144Hz 15.6 Inch FHD', 'https://www.laptopsdirect.co.uk/Images/FA507NVR-LP012W_1_Supersize.jpg?v=3', 1199.00, 1, 1199.00, 6),
(9, 'Dell Latitude 5420 Core i5 11th Gen 16GB 256GB 14 Inch Windows 10 Pro', 'https://www.laptopsdirect.co.uk/Images/T17400i516GB256GBW11P_1_Supersize.jpg?v=3', 499.00, 1, 499.00, 7),
(10, 'Acer Aspire 3 Intel Celeron 4GB RAM 128GB SSD 15.6 Inch Windows 11 Laptop', 'https://www.laptopsdirect.co.uk/Images/NX.A6LEK.00P_1_Supersize.jpg?width=750&height=750&v=3', 179.89, 1, 179.89, 7),
(11, 'Dell Latitude 7400 Intel Core i5 8th Gen 16GB 256GB 14 Inch Win 11 Pro', 'https://www.laptopsdirect.co.uk/Images/T15420i516GB256GBW10P_1_Supersize.jpg?v=3', 399.00, 1, 399.00, 8),
(12, 'TP-Link VIGI C240I 4mm 4MP Dome Camera', 'https://hanoicomputercdn.com/media/product/74709_camera_tp_link_vigi_c240l_4mm_1.jpg', 45.67, 1, 45.67, 9),
(13, 'Dell Latitude 7400 Intel Core i5 8th Gen 16GB 256GB 14 Inch Win 11 Pro', 'https://www.laptopsdirect.co.uk/Images/T15420i516GB256GBW10P_1_Supersize.jpg?v=3', 399.00, 1, 399.00, 10),
(14, 'Dell Latitude 5420 Core i5 11th Gen 16GB 256GB 14 Inch Windows 10 Pro', 'https://www.laptopsdirect.co.uk/Images/T17400i516GB256GBW11P_1_Supersize.jpg?v=3', 499.00, 1, 499.00, 11),
(15, 'Acer Aspire 3 Intel Celeron 4GB RAM 128GB SSD 15.6 Inch Windows 11 Laptop', 'https://www.laptopsdirect.co.uk/Images/NX.A6LEK.00P_1_Supersize.jpg?width=750&height=750&v=3', 179.89, 1, 179.89, 12),
(16, 'Acer Aspire 3 Intel Celeron 4GB RAM 128GB SSD 15.6 Inch Windows 11 Laptop', 'https://www.laptopsdirect.co.uk/Images/NX.A6LEK.00P_1_Supersize.jpg?width=750&height=750&v=3', 179.89, 1, 179.89, 13),
(17, 'Dell Latitude 5420 Core i5 11th Gen 16GB 256GB 14 Inch Windows 10 Pro', 'https://www.laptopsdirect.co.uk/Images/T17400i516GB256GBW11P_1_Supersize.jpg?v=3', 499.00, 1, 499.00, 14),
(18, 'Dell Latitude 7400 Intel Core i5 8th Gen 16GB 256GB 14 Inch Win 11 Pro', 'https://www.laptopsdirect.co.uk/Images/T15420i516GB256GBW10P_1_Supersize.jpg?v=3', 399.00, 1, 399.00, 15),
(19, 'MSI Vigor GK20 UK USB Keyboard', 'https://www.laptopsdirect.co.uk/Images/S11-04UK231-CLA_1_Supersize.jpg?width=750&height=750&v=15', 29.99, 1, 29.99, 16),
(20, 'Acer Aspire 3 Intel Celeron 4GB RAM 128GB SSD 15.6 Inch Windows 11 Laptop', 'https://www.laptopsdirect.co.uk/Images/NX.A6LEK.00P_1_Supersize.jpg?width=750&height=750&v=3', 179.89, 1, 179.89, 17),
(21, 'Dell Latitude 5420 Core i5 11th Gen 16GB 256GB 14 Inch Windows 10 Pro', 'https://www.laptopsdirect.co.uk/Images/T17400i516GB256GBW11P_1_Supersize.jpg?v=3', 499.00, 1, 499.00, 18),
(22, 'Acer Aspire 3 Intel Celeron 4GB RAM 128GB SSD 15.6 Inch Windows 11 Laptop', 'https://www.laptopsdirect.co.uk/Images/NX.A6LEK.00P_1_Supersize.jpg?width=750&height=750&v=3', 179.89, 1, 179.89, 18),
(23, 'Razer BlackWidow V4 75 RGB Gaming Keyboard', 'https://www.laptopsdirect.co.uk/Images/RZ03-05000400-R3E1_1_Supersize.png?width=750&height=750&v=3', 199.99, 1, 199.99, 18),
(24, 'Corsair T3 Rush Fabric Gaming Chair Grey and Charcoal', 'https://www.laptopsdirect.co.uk/Images/CF-9010056-UK%20_1_Supersize.jpg?width=750&height=750&v=3', 249.99, 1, 249.99, 18),
(25, 'Razer Kraken X Wired Gaming Headset', 'https://www.laptopsdirect.co.uk/Images/RZ04-02950100-R381_1_Supersize.jpg?width=750&height=750&v=7', 49.99, 1, 49.99, 19),
(26, 'Razer BlackWidow V4 75 RGB Gaming Keyboard', 'https://www.laptopsdirect.co.uk/Images/RZ03-05000400-R3E1_1_Supersize.png?width=750&height=750&v=3', 199.99, 1, 199.99, 20),
(27, 'Dell Latitude 7400 Intel Core i5 8th Gen 16GB 256GB 14 Inch Win 11 Pro', 'https://www.laptopsdirect.co.uk/Images/T15420i516GB256GBW10P_1_Supersize.jpg?v=3', 399.00, 1, 399.00, 21),
(28, 'ASUS Zenbook UX3405MA-PP152W i5-12500H 16GB RAM 512GB SSD 14 Inch OLED Touch Win11', 'https://hanoicomputercdn.com/media/product/79246_laptop_asus_zenbook_ux3405ma_pp152w__6_.jpg', 997.50, 1, 997.50, 22),
(29, 'Corsair T3 Rush Fabric Gaming Chair Grey and Charcoal', 'https://www.laptopsdirect.co.uk/Images/CF-9010056-UK%20_1_Supersize.jpg?width=750&height=750&v=3', 249.99, 1, 249.99, 23),
(30, 'Razer DeathAdder V3 Pro Black Gaming Mouse', 'https://www.laptopsdirect.co.uk/Images/RZ01-04630100-R3G1_1_Supersize.png?width=750&height=750&v=7', 149.99, 1, 149.99, 23),
(31, 'Razer Huntsman V3 Pro USB RGB Mechanical Gaming Keyboard', 'https://www.laptopsdirect.co.uk/Images/RZ03-04970300-R3W1_1_Supersize.jpg?width=750&height=750&v=3', 249.99, 1, 249.99, 23),
(32, 'Dell Latitude 7400 Intel Core i5 8th Gen 16GB 256GB 14 Inch Win 11 Pro', 'https://www.laptopsdirect.co.uk/Images/T15420i516GB256GBW10P_1_Supersize.jpg?v=3', 399.00, 1, 399.00, 24),
(33, 'Acer Aspire 3 Intel Celeron 4GB RAM 128GB SSD 15.6 Inch Windows 11 Laptop', 'https://www.laptopsdirect.co.uk/Images/NX.A6LEK.00P_1_Supersize.jpg?width=750&height=750&v=3', 179.89, 1, 179.89, 25),
(34, 'Dell Latitude 7400 Intel Core i5 8th Gen 16GB 256GB 14 Inch Win 11 Pro', 'https://www.laptopsdirect.co.uk/Images/T15420i516GB256GBW10P_1_Supersize.jpg?v=3', 399.00, 1, 399.00, 26),
(35, 'Dell Latitude 7400 Intel Core i5 8th Gen 16GB 256GB 14 Inch Win 11 Pro', 'https://www.laptopsdirect.co.uk/Images/T15420i516GB256GBW10P_1_Supersize.jpg?v=3', 399.00, 1, 399.00, 27),
(36, 'MSI Vigor GK20 UK USB Keyboard', 'https://www.laptopsdirect.co.uk/Images/S11-04UK231-CLA_1_Supersize.jpg?width=750&height=750&v=15', 29.99, 1, 29.99, 27),
(37, 'MSI Forge GM300 Wired Gaming Mouse', 'https://www.laptopsdirect.co.uk/Images/BUNS12-0402300-HH996740_2_Supersize.png?width=750&height=750&', 39.99, 1, 39.99, 27),
(38, 'Dell Latitude 7400 Intel Core i5 8th Gen 16GB 256GB 14 Inch Win 11 Pro', 'https://www.laptopsdirect.co.uk/Images/T15420i516GB256GBW10P_1_Supersize.jpg?v=3', 399.00, 1, 399.00, 28),
(39, 'Dell Latitude 7400 Intel Core i5 8th Gen 16GB 256GB 14 Inch Win 11 Pro', 'https://www.laptopsdirect.co.uk/Images/T15420i516GB256GBW10P_1_Supersize.jpg?v=3', 399.00, 1, 399.00, 29),
(40, 'Acer Gaming Nitro Lite NL16-71G-71UJ i7-13620H 16GB RAM 512GB SSD RTX 4050 16 Inch WUXGA Win11 Black', 'https://hanoicomputercdn.com/media/product/90816_laptop_acer_gaming_nitro_lite_nl16_71g_71uj_nh_d59s', 921.08, 1, 921.08, 30),
(41, 'Acer Aspire 3 Intel Celeron 4GB RAM 128GB SSD 15.6 Inch Windows 11 Laptop', 'https://www.laptopsdirect.co.uk/Images/NX.A6LEK.00P_1_Supersize.jpg?width=750&height=750&v=3', 179.89, 1, 179.89, 31),
(42, 'Dell Latitude 7400 Intel Core i5 8th Gen 16GB 256GB 14 Inch Win 11 Pro', 'https://www.laptopsdirect.co.uk/Images/T15420i516GB256GBW10P_1_Supersize.jpg?v=3', 399.00, 1, 399.00, 32),
(43, 'MSI Vigor GK20 UK USB Keyboard', 'https://www.laptopsdirect.co.uk/Images/S11-04UK231-CLA_1_Supersize.jpg?width=750&height=750&v=15', 29.99, 1, 29.99, 33),
(44, 'Acer Aspire 3 Intel Celeron 4GB RAM 128GB SSD 15.6 Inch Windows 11 Laptop', 'https://www.laptopsdirect.co.uk/Images/NX.A6LEK.00P_1_Supersize.jpg?width=750&height=750&v=3', 179.89, 1, 179.89, 34),
(45, 'Acer Aspire 3 Intel Celeron 4GB RAM 128GB SSD 15.6 Inch Windows 11 Laptop', 'https://www.laptopsdirect.co.uk/Images/NX.A6LEK.00P_1_Supersize.jpg?width=750&height=750&v=3', 179.89, 1, 179.89, 35),
(46, 'Acer Aspire 3 Intel Celeron 4GB RAM 128GB SSD 15.6 Inch Windows 11 Laptop', 'https://www.laptopsdirect.co.uk/Images/NX.A6LEK.00P_1_Supersize.jpg?width=750&height=750&v=3', 179.89, 1, 179.89, 36),
(47, 'Dell Latitude 7400 Intel Core i5 8th Gen 16GB 256GB 14 Inch Win 11 Pro', 'https://www.laptopsdirect.co.uk/Images/T15420i516GB256GBW10P_1_Supersize.jpg?v=3', 399.00, 1, 399.00, 37),
(48, 'Dell Latitude 7400 Intel Core i5 8th Gen 16GB 256GB 14 Inch Win 11 Pro', 'https://www.laptopsdirect.co.uk/Images/T15420i516GB256GBW10P_1_Supersize.jpg?v=3', 399.00, 1, 399.00, 38),
(49, 'Dell Latitude 7400 Intel Core i5 8th Gen 16GB 256GB 14 Inch Win 11 Pro', 'https://www.laptopsdirect.co.uk/Images/T15420i516GB256GBW10P_1_Supersize.jpg?v=3', 399.00, 1, 399.00, 39),
(50, 'HP 250 G9 Intel Core i5 16GB RAM 256GB SSD 15.6 Inch Windows 11 Pro Laptop', 'https://www.laptopsdirect.co.uk/Images/A16Q947ES_1_Supersize.jpg?v=47', 599.00, 1, 599.00, 40),
(51, 'Dell Latitude 7400 Intel Core i5 8th Gen 16GB 256GB 14 Inch Win 11 Pro', 'https://www.laptopsdirect.co.uk/Images/T15420i516GB256GBW10P_1_Supersize.jpg?v=3', 399.00, 1, 399.00, 41),
(52, 'Dell Latitude 7400 Intel Core i5 8th Gen 16GB 256GB 14 Inch Win 11 Pro', 'https://www.laptopsdirect.co.uk/Images/T15420i516GB256GBW10P_1_Supersize.jpg?v=3', 399.00, 1, 399.00, 42),
(53, 'Acer Aspire 3 Intel Celeron 4GB RAM 128GB SSD 15.6 Inch Windows 11 Laptop', 'https://www.laptopsdirect.co.uk/Images/NX.A6LEK.00P_1_Supersize.jpg?width=750&height=750&v=3', 179.89, 1, 179.89, 43),
(54, 'Dell Latitude 7400 Intel Core i5 8th Gen 16GB 256GB 14 Inch Win 11 Pro', 'https://www.laptopsdirect.co.uk/Images/T15420i516GB256GBW10P_1_Supersize.jpg?v=3', 399.00, 1, 399.00, 44),
(55, 'Acer TravelMate P2 Intel Core i5 8GB RAM 256GB SSD 14 Inch Windows 11 Laptop', 'https://www.laptopsdirect.co.uk/Images/NX.VYAEK.00F_1_Supersize.jpg?v=3', 499.97, 1, 499.97, 45),
(56, 'ASUS Zenbook UX3405MA-PP152W i5-12500H 16GB RAM 512GB SSD 14 Inch OLED Touch Win11', 'https://hanoicomputercdn.com/media/product/79246_laptop_asus_zenbook_ux3405ma_pp152w__6_.jpg', 997.50, 1, 997.50, 46),
(57, 'Dell Latitude 7400 Intel Core i5 8th Gen 16GB 256GB 14 Inch Win 11 Pro', 'https://www.laptopsdirect.co.uk/Images/T15420i516GB256GBW10P_1_Supersize.jpg?v=3', 399.00, 1, 399.00, 47),
(58, 'Dell Latitude 7400 Intel Core i5 8th Gen 16GB 256GB 14 Inch Win 11 Pro', 'https://www.laptopsdirect.co.uk/Images/T15420i516GB256GBW10P_1_Supersize.jpg?v=3', 399.00, 1, 399.00, 48),
(59, 'Acer Aspire 3 Intel Celeron 4GB RAM 128GB SSD 15.6 Inch Windows 11 Laptop', 'https://www.laptopsdirect.co.uk/Images/NX.A6LEK.00P_1_Supersize.jpg?width=750&height=750&v=3', 179.89, 1, 179.89, 48),
(60, 'ASUS TUF A15 Ryzen 7 7435HS 16GB RAM 512GB SSD RTX 4060 144Hz 15.6 Inch FHD', 'https://www.laptopsdirect.co.uk/Images/FA507NVR-LP012W_1_Supersize.jpg?v=3', 1199.00, 1, 1199.00, 48),
(61, 'Dell Latitude 7400 Intel Core i5 8th Gen 16GB 256GB 14 Inch Win 11 Pro', 'https://www.laptopsdirect.co.uk/Images/T15420i516GB256GBW10P_1_Supersize.jpg?v=3', 399.00, 1, 399.00, 49),
(62, 'Acer Aspire 3 Intel Celeron 4GB RAM 128GB SSD 15.6 Inch Windows 11 Laptop', 'https://www.laptopsdirect.co.uk/Images/NX.A6LEK.00P_1_Supersize.jpg?width=750&height=750&v=3', 179.89, 1, 179.89, 50),
(63, 'Corsair T3 Rush Fabric Gaming Chair Grey and Charcoal', 'https://www.laptopsdirect.co.uk/Images/CF-9010056-UK%20_1_Supersize.jpg?width=750&height=750&v=3', 249.99, 1, 249.99, 51),
(64, 'Razer Kraken X Wired Gaming Headset', 'https://www.laptopsdirect.co.uk/Images/RZ04-02950100-R381_1_Supersize.jpg?width=750&height=750&v=7', 49.99, 2, 99.98, 51),
(65, 'HP 250 G9 Laptop Intel Core i7 1255U 16GB 512GB SSD 15.6 Inch FHD Windows 11', 'https://www.laptopsdirect.co.uk/Images/A16Q947ES_1_Supersize.jpg?v=47', 699.00, 1, 699.00, 52),
(66, 'Apple MacBook Air 13-inch M2 16GB RAM 512GB SSD Space Grey', 'https://www.laptopsdirect.co.uk/Images/Z15S2002148089_1_Supersize.png?v=3', 1399.00, 1, 1399.00, 53),
(67, 'ASUS ROG Strix G16 Intel Core Ultra 9 16GB RAM 2TB SSD GeForce RTX 5080 240Hz 16 Inch', 'https://www.laptopsdirect.co.uk/Images/G615LW-S5008W_1_Supersize.png?v=32', 2999.00, 1, 2999.00, 54),
(68, 'Dell Latitude 7400 Intel Core i5 8th Gen 16GB 256GB 14 Inch Win 11 Pro', 'https://www.laptopsdirect.co.uk/Images/T15420i516GB256GBW10P_1_Supersize.jpg?v=3', 399.00, 1, 399.00, 55),
(69, 'Dell Latitude 7400 Intel Core i5 8th Gen 16GB 256GB 14 Inch Win 11 Pro', 'https://www.laptopsdirect.co.uk/Images/T15420i516GB256GBW10P_1_Supersize.jpg?v=3', 399.00, 1, 399.00, 56),
(70, 'Acer Gaming Nitro Lite NL16-71G-71UJ i7-13620H 16GB RAM 512GB SSD RTX 4050 16 Inch WUXGA Win11 Black', 'https://hanoicomputercdn.com/media/product/90816_laptop_acer_gaming_nitro_lite_nl16_71g_71uj_nh_d59s', 921.08, 1, 921.08, 57),
(71, 'Apple MacBook Air 13-inch M2 16GB RAM 512GB SSD Space Grey', 'https://www.laptopsdirect.co.uk/Images/Z15S2002148089_1_Supersize.png?v=3', 1399.00, 4, 5596.00, 58),
(72, 'Acer Aspire 3 Intel Celeron 4GB RAM 128GB SSD 15.6 Inch Windows 11 Laptop', 'https://www.laptopsdirect.co.uk/Images/NX.A6LEK.00P_1_Supersize.jpg?width=750&height=750&v=3', 179.89, 1, 179.89, 59),
(73, 'Dell Latitude 7400 Intel Core i5 8th Gen 16GB 256GB 14 Inch Win 11 Pro', 'https://www.laptopsdirect.co.uk/Images/T15420i516GB256GBW10P_1_Supersize.jpg?v=3', 399.00, 1, 399.00, 60),
(74, 'Lenovo V15 G4 AMD Ryzen 5 16GB RAM 512GB SSD 15.6 Inch Windows 11 Pro Laptop', 'https://www.laptopsdirect.co.uk/Images/82YU00JYUK_1_15087916_Supersize.jpg?v=5', 549.00, 1, 549.00, 61),
(75, 'Razer BlackWidow V4 75 RGB Gaming Keyboard', 'https://www.laptopsdirect.co.uk/Images/RZ03-05000400-R3E1_1_Supersize.png?width=750&height=750&v=3', 199.99, 1, 199.99, 62),
(76, 'MSI Vigor GK20 UK USB Keyboard', 'https://www.laptopsdirect.co.uk/Images/S11-04UK231-CLA_1_Supersize.jpg?width=750&height=750&v=15', 29.99, 1, 29.99, 62),
(77, 'Dell Latitude 5420 Core i5 11th Gen 16GB 256GB 14 Inch Windows 10 Pro', 'https://www.laptopsdirect.co.uk/Images/T17400i516GB256GBW11P_1_Supersize.jpg?v=3', 499.00, 1, 499.00, 63),
(78, 'Acer Aspire 3 Intel Celeron 4GB RAM 128GB SSD 15.6 Inch Windows 11 Laptop', 'https://www.laptopsdirect.co.uk/Images/NX.A6LEK.00P_1_Supersize.jpg?width=750&height=750&v=3', 179.89, 1, 179.89, 63),
(79, 'Acer TravelMate P2 Intel Core i5 8GB RAM 256GB SSD 14 Inch Windows 11 Laptop', 'https://www.laptopsdirect.co.uk/Images/NX.VYAEK.00F_1_Supersize.jpg?v=3', 499.97, 1, 499.97, 63),
(80, 'Dell Inspiron 3530 i7-1355U 16GB 512GB SSD 15.6 Inch FHD 120Hz Win11H OfficeHS21 Silver', 'https://hanoicomputercdn.com/media/product/86105_file_pts_chu___n_l____0000_layer_1.jpg', 690.46, 1, 690.46, 63),
(81, 'HP 250 G9 Intel Core i5 16GB RAM 256GB SSD 15.6 Inch Windows 11 Pro Laptop', 'https://www.laptopsdirect.co.uk/Images/A16Q947ES_1_Supersize.jpg?v=47', 599.00, 1, 599.00, 63),
(82, 'Dell Inspiron 3530 i7-1355U 16GB 512GB SSD 15.6 Inch FHD 120Hz Win11H OfficeHS21 Silver', 'https://hanoicomputercdn.com/media/product/86105_file_pts_chu___n_l____0000_layer_1.jpg', 690.46, 1, 690.46, 64),
(83, 'ASUS TUF A15 Ryzen 7 7435HS 16GB RAM 512GB SSD RTX 4060 144Hz 15.6 Inch FHD', 'https://www.laptopsdirect.co.uk/Images/FA507NVR-LP012W_1_Supersize.jpg?v=3', 1199.00, 2, 2398.00, 65),
(84, 'HP 250 G9 Laptop Intel Core i7 1255U 16GB 512GB SSD 15.6 Inch FHD Windows 11', 'https://www.laptopsdirect.co.uk/Images/A16Q947ES_1_Supersize.jpg?v=47', 699.00, 1, 699.00, 65),
(85, 'Dell Latitude 7400 Intel Core i5 8th Gen 16GB 256GB 14 Inch Win 11 Pro', 'https://www.laptopsdirect.co.uk/Images/T15420i516GB256GBW10P_1_Supersize.jpg?v=3', 399.00, 1, 399.00, 66),
(86, 'Lenovo V15 G4 AMD Ryzen 5 16GB RAM 512GB SSD 15.6 Inch Windows 11 Pro Laptop', 'https://www.laptopsdirect.co.uk/Images/82YU00JYUK_1_15087916_Supersize.jpg?v=5', 549.00, 1, 549.00, 67),
(87, 'HP 250 G9 Laptop Intel Core i7 1255U 16GB 512GB SSD 15.6 Inch FHD Windows 11', 'https://www.laptopsdirect.co.uk/Images/A16Q947ES_1_Supersize.jpg?v=47', 699.00, 1, 699.00, 68),
(88, 'Lenovo V15 G4 AMD Ryzen 5 16GB RAM 512GB SSD 15.6 Inch Windows 11 Pro Laptop', 'https://www.laptopsdirect.co.uk/Images/82YU00JYUK_1_15087916_Supersize.jpg?v=5', 549.00, 1, 549.00, 69);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `type` tinyint(1) NOT NULL COMMENT '0: product, 1: service',
  `content` text DEFAULT NULL,
  `is_read` tinyint(4) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product`
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
-- Đang đổ dữ liệu cho bảng `product`
--

INSERT INTO `product` (`id`, `name`, `description`, `category_id`, `qty_in_stock`, `product_image`, `price`) VALUES
(1, 'Acer Aspire 3 Intel Celeron 4GB RAM 128GB SSD 15.6 Inch Windows 11 Laptop', 'Highlighting form and function, a stunningly slim body and impressive tactile finish accentuate real-world design features. Built to keep you active, engaged, and on the move, the Aspire 3 has the technology to suit your way of life. Fundamentally impressive technology.\r\nEfficient Performance with Intel Celeron N4500\r\nThe Acer Aspire 3 A315-35 is powered by the Intel Celeron N4500 processor, delivering reliable performance for everyday computing tasks. With speeds of up to 2.8 GHz, this dual-core processor ensures smooth web browsing, document editing, and media playback. Whether you\'re working on assignments, streaming content, or managing emails, the Aspire 3 provides a seamless user experience.Crisp 15.6-Inch HD Display for Everyday Use\r\nFeaturing a 15.6-inch HD (1366 x 768) TN display, the Aspire 3 offers clear visuals and vibrant colors for work and entertainment. The anti-glare screen reduces reflections, making it comfortable to use in various lighting conditions. Its widescreen format enhances productivity, allowing you to view multiple applications simultaneously without feeling cramped.Fast and Reliable Storage with 128GB NVMe SSD\r\nThe 128GB NVMe SSD provides quick boot times and fast data access, ensuring efficient performance for everyday computing. With 3D Triple-Level Cell (TLC) technology, the SSD offers durability and reliability, making file transfers and software loading times much faster compared to traditional hard drives. This storage capacity is ideal for essential applications, documents, and media files.Seamless Connectivity with Wi-Fi 6 and Gigabit Ethernet\r\nStay connected with the latest Wi-Fi 6 technology, providing faster and more stable wireless connections for browsing, streaming, and online meetings. The Aspire 3 also includes a Gigabit Ethernet port for a reliable wired connection when needed. Whether at home, in the office, or on the go, you can enjoy uninterrupted connectivity for all your online activities.Sleek Design with a Comfortable UK Keyboard\r\nFinished in an elegant pure silver design, the Acer Aspire 3 offers a stylish and lightweight build, making it easy to carry wherever you go. The UK keyboard layout ensures comfortable and accurate typing, ideal for students and professionals alike. With a full-sized keyboard and precision touchpad, navigating through tasks becomes effortless, enhancing your overall productivity.', 1, 7, 'https://www.laptopsdirect.co.uk/Images/NX.A6LEK.00P_1_Supersize.jpg?width=750&height=750&v=3', 179.89),
(2, 'Acer TravelMate P2 Intel Core i5 8GB RAM 256GB SSD 14 Inch Windows 11 Laptop', 'Acer TravelMate P2, Intel Core i5, 8GB RAM, 256GB SSD, 14\" Full HD, Windows 11, NX.VYAEK.003. Designed for business and productivity with robust security, long battery life, and a lightweight chassis.', 1, 9, 'https://www.laptopsdirect.co.uk/Images/NX.VYAEK.00F_1_Supersize.jpg?v=3', 499.97),
(3, 'Apple MacBook Air 13-inch M2 16GB RAM 512GB SSD Space Grey', 'Apple MacBook Air 13-inch (M2, 2022), 16GB RAM, 512GB SSD, Space Grey. Siêu mỏng nhẹ, hiệu năng mạnh mẽ với chip Apple M2, màn hình Liquid Retina, thời lượng pin lên tới 18 giờ, Touch ID, macOS.', 1, 0, 'https://www.laptopsdirect.co.uk/Images/Z15S2002148089_1_Supersize.png?v=3', 1399.00),
(4, 'Apple MacBook Pro 14-inch M4 16GB RAM 512GB SSD Space Black', 'Apple MacBook Pro 14-inch (2024), Apple M4 chip with 10-core CPU and 10-core GPU, 16GB RAM, 512GB SSD, Space Black. Màn hình Liquid Retina XDR, Touch ID, thời lượng pin lên tới 18 giờ, macOS.', 1, 5, 'https://www.laptopsdirect.co.uk/Images/MW2U3BA_1_Supersize.jpg?v=4', 1799.00),
(5, 'ASUS TUF A15 Ryzen 7 7435HS 16GB RAM 512GB SSD RTX 4060 144Hz 15.6 Inch FHD', 'ASUS TUF A15, AMD Ryzen 7 7435HS, 16GB RAM, 512GB SSD, NVIDIA GeForce RTX 4060, 144Hz 15.6\" FHD, FA507NVR-LP012W, Windows 11, thiết kế gaming bền bỉ, hiệu năng mạnh mẽ.', 1, 8, 'https://www.laptopsdirect.co.uk/Images/FA507NVR-LP012W_1_Supersize.jpg?v=3', 1199.00),
(6, 'ASUS ROG Strix G16 Intel Core Ultra 9 16GB RAM 2TB SSD GeForce RTX 5080 240Hz 16 Inch', 'ASUS ROG Strix G16, Intel Core Ultra 9, 16GB RAM, 2TB SSD, NVIDIA GeForce RTX 5080, 240Hz 16\" FHD, G615LW-S5008W, Windows 11, laptop gaming cao cấp với hiệu năng vượt trội.', 1, 9, 'https://www.laptopsdirect.co.uk/Images/G615LW-S5008W_1_Supersize.png?v=32', 2999.00),
(7, 'Dell Latitude 7400 Intel Core i5 8th Gen 16GB 256GB 14 Inch Win 11 Pro', 'Dell Latitude 7400 Refurbished, Intel Core i5 8th Gen, 16GB RAM, 256GB SSD, 14\" FHD, Windows 11 Pro. Laptop doanh nhân bền bỉ, hiệu năng ổn định, thiết kế mỏng nhẹ.', 1, 1, 'https://www.laptopsdirect.co.uk/Images/T15420i516GB256GBW10P_1_Supersize.jpg?v=3', 399.00),
(8, 'Dell Latitude 5420 Core i5 11th Gen 16GB 256GB 14 Inch Windows 10 Pro', 'Dell Latitude 5420 Refurbished, Intel Core i5 11th Gen, 16GB RAM, 256GB SSD, 14\" FHD, Windows 10 Pro. Laptop doanh nhân bền bỉ, hiệu năng ổn định, thiết kế mỏng nhẹ.', 1, 4, 'https://www.laptopsdirect.co.uk/Images/T17400i516GB256GBW11P_1_Supersize.jpg?v=3', 499.00),
(9, 'HP 250 G9 Laptop Intel Core i7 1255U 16GB 512GB SSD 15.6 Inch FHD Windows 11', 'HP 250 G9, Intel Core i7-1255U, 16GB RAM, 512GB SSD, 15.6\" FHD, Windows 11. Laptop văn phòng mạnh mẽ, thiết kế bền bỉ, phù hợp cho công việc và học tập.', 1, 7, 'https://www.laptopsdirect.co.uk/Images/A16Q947ES_1_Supersize.jpg?v=47', 699.00),
(10, 'HP 250 G9 Intel Core i5 16GB RAM 256GB SSD 15.6 Inch Windows 11 Pro Laptop', 'HP 250 G9, Intel Core i5, 16GB RAM, 256GB SSD, 15.6\" FHD, Windows 11 Pro. Laptop văn phòng bền bỉ, hiệu năng ổn định, phù hợp cho doanh nghiệp và cá nhân.', 1, 9, 'https://www.laptopsdirect.co.uk/Images/A16Q947ES_1_Supersize.jpg?v=47', 599.00),
(11, 'Lenovo V15 G4 AMD Ryzen 5 16GB RAM 512GB SSD 15.6 Inch Windows 11 Pro Laptop', 'Lenovo V15 G4, AMD Ryzen 5, 16GB RAM, 512GB SSD, 15.6\" FHD, Windows 11 Pro. Laptop văn phòng mạnh mẽ, thiết kế bền bỉ, phù hợp cho công việc và học tập.', 1, 7, 'https://www.laptopsdirect.co.uk/Images/82YU00JYUK_1_15087916_Supersize.jpg?v=5', 549.00),
(12, 'Lenovo Legion 5 Y500 Series 16 240Hz Intel Core i7-14650HX 16GB 1TB RTX 4060', 'Lenovo Legion 5 Y500 Series, 16\" 240Hz, Intel Core i7-14650HX, 16GB RAM, 1TB SSD, NVIDIA GeForce RTX 4060, Windows 11, laptop gaming cao cấp với hiệu năng mạnh mẽ và màn hình tần số quét cao.', 1, 10, 'https://www.laptopsdirect.co.uk/Images/83DG00DSUK_1_Supersize.jpg?v=8', 1599.00),
(13, 'Tapo C510W Outdoor Pan/Tilt Wi-Fi Camera', 'Tapo C510W Outdoor Pan/Tilt Wi-Fi Camera, 3MP, Color Night Vision, Motion Tracking, Two-Way Audio, IP65 Weatherproof, Smart AI Detection, Works with Alexa & Google Home.', 2, 20, 'https://hanoicomputercdn.com/media/product/91274_camera_tp_link_tapo_c510w_0003_layer_1.jpg', 59.99),
(14, 'Hikvision DS-2CD1343G2-LIU/SL 4MP Dome Camera', 'Camera IP Hikvision DS-2CD1343G2-LIU/SL, 4MP, Dome, ColorVu, tích hợp micro, cảnh báo đèn còi, chuẩn nén H.265+, chống ngược sáng WDR 120dB, chuẩn IP67, hỗ trợ thẻ nhớ microSD lên tới 256GB.', 2, 15, 'https://hanoicomputercdn.com/media/product/83147_camera_hikvision_ds_2cd1343g2_liuf_sl_2.jpg', 240.00),
(15, 'TP-Link VIGI C240I 4mm 4MP Dome Camera', 'TP-Link VIGI C240I 4mm IP Camera, 4MP, Dome, H.265+ Compression, AI-Powered, Motion Detection, WDR Backlight Compensation, IP67 Rating, Built-in Microphone.', 2, 20, 'https://hanoicomputercdn.com/media/product/74709_camera_tp_link_vigi_c240l_4mm_1.jpg', 45.67),
(16, 'Hikvision DS-2CE16D0T-EXLPF 2MP Bullet Camera', 'Hikvision DS-2CE16D0T-EXLPF, 2MP, Bullet, EXIR, 2.8mm lens, IR up to 30m, IP67 weatherproof, metal body, suitable for indoor and outdoor installation.', 2, 20, 'https://hanoicomputercdn.com/media/product/89646_camera_hikvision_ds_2ce16d0t_exlpf.jpg', 13.39),
(17, 'Acer Gaming Nitro V 16 ProPanel ANV16-41-R36Y R7-8845HS 16GB RAM 512GB SSD RTX 4050 16 Inch WUXGA Win11 Black', 'Acer Nitro V 16 ProPanel ANV16-41-R36Y, AMD Ryzen 7 8845HS, 16GB RAM, 512GB SSD, NVIDIA GeForce RTX 4050 6GB, 16\" WUXGA, Windows 11,Black color, high-performance gaming laptop, large display, efficient cooling system.', 1, 10, 'https://hanoicomputercdn.com/media/product/84662_laptop_acer_gaming_nitro_v_16_propanel_anv16_41_r6na_nh_qp0sv_001_r7_8845hs_16gb_ram_512gb_ssd_rtx4060_8gb_16_inch_0005_.jpg', 1120.66),
(18, 'Acer Gaming Nitro Lite NL16-71G-71UJ i7-13620H 16GB RAM 512GB SSD RTX 4050 16 Inch WUXGA Win11 Black', 'Acer Gaming Nitro Lite NL16-71G-71UJ, Intel Core i7-13620H, 16GB RAM, 512GB SSD, NVIDIA GeForce RTX 4050 6GB, 16\" WUXGA, Windows 11, black color. High-performance gaming laptop with large display, efficient cooling, and modern design.', 1, 9, 'https://hanoicomputercdn.com/media/product/90816_laptop_acer_gaming_nitro_lite_nl16_71g_71uj_nh_d59sv_002_0007_layer_2.jpg', 921.08),
(19, 'ASUS Zenbook UX3405MA-PP152W i5-12500H 16GB RAM 512GB SSD 14 Inch OLED Touch Win11', 'ASUS Zenbook UX3405MA-PP152W, Intel Core Ultra 5 125H, 16GB RAM, 512GB SSD, 14\" 3K OLED Touch Display, Intel Graphics, Windows 11, ultra-thin and lightweight design, long battery life, premium build quality.', 1, 10, 'https://hanoicomputercdn.com/media/product/79246_laptop_asus_zenbook_ux3405ma_pp152w__6_.jpg', 997.50),
(20, 'Dell Inspiron 3530 i7-1355U 16GB 512GB SSD 15.6 Inch FHD 120Hz Win11H OfficeHS21 Silver', 'Dell Inspiron 3530, Intel Core i7-1355U, 16GB RAM, 512GB SSD, 15.6\" FHD 120Hz, Windows 11 Home, Office Home & Student 2021, Silver. High-performance laptop for work and entertainment, featuring a fast display and modern design.', 1, 8, 'https://hanoicomputercdn.com/media/product/86105_file_pts_chu___n_l____0000_layer_1.jpg', 690.46),
(21, 'MSI Vigor GK20 UK USB Keyboard', 'MSI Vigor GK20 UK USB Keyboard, ergonomic design, RGB lighting, durable keys.', 3, 49, 'https://www.laptopsdirect.co.uk/Images/S11-04UK231-CLA_1_Supersize.jpg?width=750&height=750&v=15', 29.99),
(22, 'SteelSeries Apex 9 TKL Mechanical Gaming Keyboard', 'SteelSeries Apex 9 TKL, mechanical gaming keyboard, compact design, RGB lighting.', 3, 50, 'https://www.laptopsdirect.co.uk/Images/64848_1_Supersize.png?width=750&height=750&v=5', 129.99),
(23, 'Razer Huntsman V3 Pro USB RGB Mechanical Gaming Keyboard', 'Razer Huntsman V3 Pro, RGB mechanical gaming keyboard, analog optical switches.', 3, 50, 'https://www.laptopsdirect.co.uk/Images/RZ03-04970300-R3W1_1_Supersize.jpg?width=750&height=750&v=3', 249.99),
(24, 'Razer BlackWidow V4 75 RGB Gaming Keyboard', 'Razer BlackWidow V4 75, RGB gaming keyboard, customizable keys, durable design.', 3, 49, 'https://www.laptopsdirect.co.uk/Images/RZ03-05000400-R3E1_1_Supersize.png?width=750&height=750&v=3', 199.99),
(25, 'MSI Forge GM300 Wired Gaming Mouse', 'MSI Forge GM300, wired gaming mouse, ergonomic design, RGB lighting.', 3, 50, 'https://www.laptopsdirect.co.uk/Images/BUNS12-0402300-HH996740_2_Supersize.png?width=750&height=750&v=10', 39.99),
(26, 'Razer Kraken X Wired Gaming Headset', 'Razer Kraken X, wired gaming headset, lightweight design, immersive sound.', 3, 48, 'https://www.laptopsdirect.co.uk/Images/RZ04-02950100-R381_1_Supersize.jpg?width=750&height=750&v=7', 49.99),
(27, 'Razer DeathAdder V3 Pro Black Gaming Mouse', 'Razer DeathAdder V3 Pro, wireless gaming mouse, ergonomic design, high precision.', 3, 50, 'https://www.laptopsdirect.co.uk/Images/RZ01-04630100-R3G1_1_Supersize.png?width=750&height=750&v=7', 149.99),
(28, 'Cables Direct HDMI Cable with Ethernet 3m', 'Cables Direct HDMI Cable, 3m length, supports Ethernet, high-speed data transfer.', 3, 100, 'https://www.laptopsdirect.co.uk/Images/77HDMI-030_1_supersize.jpg?width=750&height=750&v=1', 9.99),
(29, '1m RJ-45 Cat6 Networking Cable Black', 'RJ-45 Cat6 Networking Cable, 1m length, black, high-speed data transfer.', 3, 100, 'https://www.laptopsdirect.co.uk/Images/31-0010BK_1_Supersize.jpg?width=750&height=750&v=3', 4.99),
(30, 'Corsair T3 Rush Fabric Gaming Chair Grey and Charcoal', 'Corsair T3 Rush Gaming Chair, fabric material, ergonomic design, grey and charcoal.', 3, 19, 'https://www.laptopsdirect.co.uk/Images/CF-9010056-UK%20_1_Supersize.jpg?width=750&height=750&v=3', 249.99),
(31, 'Google Nest Cam Outdoor/Indoor Battery', 'Google Nest Cam (battery) is a completely wire-free outdoor security camera that helps you keep watch over what matters most. It can run on battery power or be plugged in, and it works with the Google Home app for easy setup and control.\r\n\r\nKey Features:\r\n- Wire-free design with rechargeable battery\r\n- Works indoors and outdoors (IP54 weather resistance)\r\n- 1080p HDR video with night vision\r\n- 130° diagonal field of view\r\n- Two-way talk with noise cancellation\r\n- Activity zones and intelligent alerts\r\n- 3 hours of free event video history\r\n- Works with Google Assistant and Alexa\r\n- Easy magnetic mount included\r\n- Privacy features with physical privacy switch\r\n\r\nThe camera uses advanced machine learning to tell the difference between people, animals, and vehicles, sending you intelligent alerts about activity that matters to you. With the Nest Aware subscription (sold separately), you can get up to 60 days of video history and additional intelligent features.\r\n\r\nPerfect for monitoring your home, garden, or any area where running cables isn\'t practical. The weather-resistant design means it can handle rain, snow, and extreme temperatures.', 2, 25, 'https://haloshop.vn/wp-content/uploads/2025/02/google-nest-cam-outdoor-or-indoor-battery-00-700x700-1.jpg', 179.99);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_category`
--

CREATE TABLE `product_category` (
  `id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `product_category`
--

INSERT INTO `product_category` (`id`, `category_name`) VALUES
(1, 'laptop'),
(2, 'camera'),
(3, 'accessories');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` varchar(255) NOT NULL,
  `service_type` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `services`
--

INSERT INTO `services` (`id`, `user_id`, `name`, `phone`, `address`, `service_type`, `created_at`) VALUES
(1, 2, '1', '1', '', 'Laptop Cleaning', '2025-06-19 14:02:35'),
(2, 2, '1', '1', '1', 'Laptop Cleaning', '2025-06-19 14:05:32'),
(3, 6, '1', '2', '3', 'Repair', '2025-06-19 14:24:08'),
(4, 2, 'hẹ', 'hẹ ', 'hẹ', 'Camera Installation', '2025-06-19 15:29:05'),
(5, 2, 'im dead', '123', '123', 'Repair', '2025-06-20 22:53:58'),
(6, 2, 'kk', 'gg', '3', 'Camera Installation', '2025-06-20 23:05:59'),
(7, 2, '3', '3', '3', 'Warranty', '2025-06-20 23:06:22'),
(8, 2, '3', '3', '3', 'Warranty', '2025-06-20 23:06:37'),
(9, 2, '3', '3', '3', 'Warranty', '2025-06-20 23:06:39'),
(10, 2, '3', '3', '3', 'Warranty', '2025-06-20 23:08:58'),
(11, 2, '3', '3', '3', 'Warranty', '2025-06-20 23:09:14'),
(12, 2, '3', '3', '3', 'Warranty', '2025-06-20 23:09:14'),
(13, 2, '1', '1', '1', 'Camera Installation', '2025-06-20 23:09:27'),
(14, 2, '1', '1', '1', 'Camera Installation', '2025-06-20 23:13:48'),
(15, 2, '1', '1', '1', 'Camera Installation', '2025-06-20 23:13:49'),
(16, 2, '1', '1', '1', 'Camera Installation', '2025-06-20 23:13:49'),
(17, 2, '1', '2', '3', 'Laptop Cleaning', '2025-06-20 23:14:12'),
(18, 2, '3', '3', '3', 'Laptop Cleaning', '2025-06-20 23:14:42'),
(19, 2, '3', '3', '3', 'Laptop Cleaning', '2025-06-20 23:18:41'),
(20, 2, '3', '3', '3', 'Laptop Cleaning', '2025-06-20 23:18:42'),
(21, 2, '1', '1', '1', 'Laptop Cleaning', '2025-06-20 23:20:20'),
(22, 2, '1', '1', '1', 'Laptop Cleaning', '2025-06-20 23:20:35'),
(23, 2, '1', '1', '1', 'Laptop Cleaning', '2025-06-20 23:20:55'),
(24, 2, '1', '1', '1', 'Laptop Cleaning', '2025-06-20 23:20:56'),
(25, 2, '1', '2', '3', 'Repair', '2025-06-20 23:21:09'),
(26, 2, '1', '2', '3', 'Repair', '2025-06-20 23:22:00'),
(27, 2, '1', '2', '3', 'Repair', '2025-06-20 23:22:01'),
(28, 2, '1', '2', '3', 'Repair', '2025-06-20 23:22:02'),
(29, 2, '1', '2', '3', 'Repair', '2025-06-20 23:22:02'),
(30, 2, '1', '2', '3', 'Repair', '2025-06-20 23:22:03'),
(31, 2, '1', '2', '3', 'Repair', '2025-06-20 23:23:05'),
(32, 2, '1', '2', '3', 'Laptop Cleaning', '2025-06-20 23:23:11'),
(33, 2, '33', '44', '55', 'Camera Installation', '2025-06-20 23:23:33'),
(34, 2, '33', '44', '55', 'Camera Installation', '2025-06-20 23:23:38'),
(35, 2, '33', '44', '55', 'Camera Installation', '2025-06-20 23:27:28'),
(36, 2, '33', '44', '55', 'Camera Installation', '2025-06-20 23:27:52'),
(37, 2, '33', '44', '55', 'Camera Installation', '2025-06-20 23:33:07'),
(38, 2, 'kk', '66', '1', 'Laptop Cleaning', '2025-06-20 23:35:35'),
(39, 2, '1', '3', '4', 'Laptop Cleaning', '2025-06-20 23:37:28'),
(40, 2, '1', '3', '4', 'Camera Installation', '2025-06-20 23:38:47'),
(41, 2, '1', '3', '4', 'Camera Installation', '2025-06-20 23:38:58'),
(42, 2, '3', '4', '1', 'Camera Installation', '2025-06-20 23:42:39'),
(43, 2, '3', '4', '5', 'Camera Installation', '2025-06-20 23:46:15'),
(44, 2, 'lonma', 'kk', '69', 'Repair', '2025-06-20 23:59:52'),
(45, 2, '4', '3', '5', 'Laptop Cleaning', '2025-06-21 00:02:30'),
(46, 2, '1', '1', '1', 'Laptop Cleaning', '2025-06-21 00:03:21'),
(47, 2, 'h', '2', '3', 'Camera Installation', '2025-06-21 00:07:52'),
(48, 2, '3', '45', '1', 'Laptop Cleaning', '2025-06-21 00:09:35'),
(49, 2, '3', '2', '3', 'Camera Installation', '2025-06-21 00:10:56'),
(50, 2, '1', '1', '1', 'Laptop Cleaning', '2025-06-21 00:18:39'),
(51, 2, '4', '5', '6', 'Laptop Cleaning', '2025-06-21 00:19:42'),
(52, 2, '1', '2', '3', 'Laptop Cleaning', '2025-06-21 00:31:31'),
(53, 2, '1', '2', '3', 'Laptop Cleaning', '2025-06-21 00:31:48'),
(54, 2, '3', '4141', '213123', 'Repair', '2025-06-21 00:32:11'),
(55, 2, '1', '3', '4', 'Camera Installation', '2025-06-21 00:46:44'),
(56, 2, '1', '3', '4', 'Camera Installation', '2025-06-21 00:48:17'),
(57, 2, '1', '3', '4', 'Repair', '2025-06-21 00:49:35'),
(58, 2, '1', '3', '4', 'Repair', '2025-06-21 00:50:02'),
(59, 2, '1', '1', '1', 'Laptop Cleaning', '2025-06-21 00:50:10'),
(60, 2, '3', '4', '5', 'Laptop Cleaning', '2025-06-21 00:51:10'),
(61, 2, '3', '4', '5', 'Laptop Cleaning', '2025-06-21 00:51:39'),
(62, 2, '1', '3', '4', 'Laptop Cleaning', '2025-06-21 00:53:23'),
(63, 2, '1', '1', '1', 'Laptop Cleaning', '2025-06-21 00:54:33'),
(64, 8, '1', '3', '4', 'Repair', '2025-06-21 02:25:55'),
(65, 8, '44', '55', '11', 'Laptop Cleaning', '2025-06-21 02:27:44'),
(66, 8, '1', '1', '1', 'Laptop Cleaning', '2025-06-21 02:46:28'),
(67, 8, '1', '3', '4', 'Camera Installation', '2025-06-21 02:46:48'),
(68, 8, '55', '33', '11', 'Laptop Cleaning', '2025-06-21 02:49:04'),
(69, 8, '515', '115', '15151515', 'Warranty', '2025-06-21 02:56:54'),
(70, 2, 'hh', 'kk', 'jj', 'Warranty', '2025-06-21 10:16:28'),
(71, 2, '313', '414', '5151', 'Repair', '2025-06-21 10:18:02'),
(72, 2, '4141', '51515', '231', 'Repair', '2025-06-21 10:18:13'),
(73, 2, 'gg', 'ee', 'aa', 'Laptop Cleaning', '2025-06-21 10:19:21'),
(74, 2, '44', '555', '111', 'Camera Installation', '2025-06-21 10:22:27');

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
(2, 'Bùi Thịnh', 'tao bắn phi phai', 'thinhbui7779@gmail.com', '0333675969', 'thinh1', '123456', 1),
(3, 'Bùi Đức Thịnh', NULL, 'thinhbui7779@gmail.com', '0333675969', 'thinh2', '123456', 1),
(4, 'Bùi Đức Thịnh', NULL, 'thinhbui7779@gmail.com', '0333675969', 'thinh3', '123456', 1),
(5, 'Vũ Chu', NULL, 'chuminhvubu1@gmail.com', '0389040222', 'WhiteYin69', '1234', 1),
(6, 'Thien dep trai ne', 'vn', '123@gmail.com', '123', 'dit cu', '123', 1),
(7, 'Tao la Tung Tung ', 'tao ở mỹ', '123@gmail.com', '123', 'duma1', '321', 1),
(8, 'hẹ', NULL, 'kkk@gmail.com', '123', 'hehehe', '123123', 1),
(9, 'admin', NULL, '', NULL, 'admin1', '123', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `variation`
--

CREATE TABLE `variation` (
  `id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `variation`
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
(11, 1, 'Storage Capacity'),
(12, 2, 'CCTV brand'),
(13, 2, 'camera location'),
(14, 2, 'connection type'),
(15, 2, 'Camera Resolution'),
(16, 3, 'accessory_type'),
(17, 3, 'accessory_brand');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `variation_options`
--

CREATE TABLE `variation_options` (
  `product_id` int(11) NOT NULL,
  `variation_id` int(11) NOT NULL,
  `value` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `variation_options`
--

INSERT INTO `variation_options` (`product_id`, `variation_id`, `value`) VALUES
(1, 1, 'Everyday'),
(1, 2, 'Acer'),
(1, 3, 'Intel Celeron'),
(1, 4, '15.6'),
(1, 5, '4GB'),
(1, 10, 'Windows 11'),
(1, 11, '128GB SSD'),
(2, 1, 'Business'),
(2, 2, 'Acer'),
(2, 3, 'Intel Core i5'),
(2, 4, '14'),
(2, 5, '8GB'),
(2, 10, 'Windows 11'),
(2, 11, '256GB SSD'),
(3, 1, 'Everyday'),
(3, 2, 'Apple'),
(3, 3, 'Apple M2'),
(3, 4, '13.3'),
(3, 5, '16GB'),
(3, 10, 'macOS'),
(3, 11, '512GB SSD'),
(4, 1, 'Professional'),
(4, 2, 'Apple'),
(4, 3, 'Apple M4'),
(4, 4, '14'),
(4, 5, '16GB'),
(4, 9, 'Space Black'),
(4, 10, 'macOS'),
(4, 11, '512GB SSD'),
(5, 1, 'Gaming'),
(5, 2, 'ASUS'),
(5, 3, 'AMD Ryzen 7 7435HS'),
(5, 4, '15.6'),
(5, 5, '16GB'),
(5, 6, 'RTX 4060'),
(5, 7, '144Hz'),
(5, 10, 'Windows 11'),
(5, 11, '512GB SSD'),
(6, 1, 'Gaming'),
(6, 2, 'ASUS'),
(6, 3, 'Intel Core Ultra 9'),
(6, 4, '16'),
(6, 5, '16GB'),
(6, 6, 'RTX 5080'),
(6, 7, '240Hz'),
(6, 10, 'Windows 11'),
(6, 11, '2TB SSD'),
(7, 1, 'Business'),
(7, 2, 'Dell'),
(7, 3, 'Intel Core i5 8th Gen'),
(7, 4, '14'),
(7, 5, '16GB'),
(7, 10, 'Windows 11 Pro'),
(7, 11, '256GB SSD'),
(8, 1, 'Business'),
(8, 2, 'Dell'),
(8, 3, 'Intel Core i5 11th Gen'),
(8, 4, '14'),
(8, 5, '16GB'),
(8, 10, 'Windows 10 Pro'),
(8, 11, '256GB SSD'),
(9, 1, 'Business'),
(9, 2, 'HP'),
(9, 3, 'Intel Core i7-1255U'),
(9, 4, '15.6'),
(9, 5, '16GB'),
(9, 10, 'Windows 11'),
(9, 11, '512GB SSD'),
(10, 1, 'Business'),
(10, 2, 'HP'),
(10, 3, 'Intel Core i5'),
(10, 4, '15.6'),
(10, 5, '16GB'),
(10, 10, 'Windows 11 Pro'),
(10, 11, '256GB SSD'),
(11, 1, 'Business'),
(11, 2, 'Lenovo'),
(11, 3, 'AMD Ryzen 5'),
(11, 4, '15.6'),
(11, 5, '16GB'),
(11, 10, 'Windows 11 Pro'),
(11, 11, '512GB SSD'),
(12, 1, 'Gaming'),
(12, 2, 'Lenovo'),
(12, 3, 'Intel Core i7-14650HX'),
(12, 4, '16'),
(12, 5, '16GB'),
(12, 6, 'RTX 4060'),
(12, 7, '240Hz'),
(12, 10, 'Windows 11'),
(12, 11, '1TB SSD'),
(13, 11, 'No Storage Included'),
(13, 12, 'Tapo'),
(13, 13, 'Outdoor'),
(13, 14, 'Wireless'),
(13, 15, '2k'),
(14, 12, 'Hikvision'),
(14, 13, 'Indoor/Outdoor'),
(14, 14, 'Wired'),
(14, 15, '4MP'),
(15, 12, 'TP-Link'),
(15, 13, 'Indoor/Outdoor'),
(15, 14, 'Wired'),
(15, 15, '4MP'),
(16, 12, 'Hikvision'),
(16, 13, 'Indoor/Outdoor'),
(16, 14, 'Wired'),
(16, 15, '2MP'),
(17, 1, 'Gaming'),
(17, 2, 'Acer'),
(17, 3, 'AMD Ryzen 7 8845HS'),
(17, 4, '16'),
(17, 5, '16GB'),
(17, 6, 'RTX 4050'),
(17, 9, 'Black'),
(17, 10, 'Windows 11'),
(17, 11, '512GB SSD'),
(18, 1, 'Gaming'),
(18, 2, 'Acer'),
(18, 3, 'Intel Core i7-13620H'),
(18, 4, '16'),
(18, 5, '16GB'),
(18, 6, 'RTX 4050'),
(18, 9, 'Black'),
(18, 10, 'Windows 11'),
(18, 11, '512GB SSD'),
(19, 1, 'Business'),
(19, 2, 'ASUS'),
(19, 3, 'Intel Core Ultra 5 125H'),
(19, 4, '14'),
(19, 5, '16GB'),
(19, 6, 'Intel Graphics'),
(19, 8, 'Touch'),
(19, 10, 'Windows 11'),
(19, 11, '512GB SSD'),
(20, 1, 'Business'),
(20, 2, 'Dell'),
(20, 3, 'Intel Core i7-1355U'),
(20, 4, '15.6'),
(20, 5, '16GB'),
(20, 7, '120Hz'),
(20, 9, 'Silver'),
(20, 10, 'Windows 11 Home'),
(20, 11, '512GB SSD'),
(21, 16, 'Keyboard'),
(21, 17, 'MSI'),
(22, 16, 'Keyboard'),
(22, 17, 'SteelSeries'),
(23, 16, 'Keyboard'),
(23, 17, 'Razer'),
(24, 16, 'Keyboard'),
(24, 17, 'Razer'),
(25, 16, 'Mouse'),
(25, 17, 'MSI'),
(26, 16, 'Headset'),
(26, 17, 'Razer'),
(27, 16, 'Mouse'),
(27, 17, 'Razer'),
(28, 16, 'Cable'),
(28, 17, 'Generic'),
(29, 16, 'Cable'),
(29, 17, 'Generic'),
(30, 16, 'Gaming Chair'),
(30, 17, 'Corsair'),
(31, 12, 'Google'),
(31, 13, 'Indoor/Outdoor'),
(31, 14, 'Wireless'),
(31, 15, '1080p');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `bill`
--
ALTER TABLE `bill`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `order_status` (`order_status`);

--
-- Chỉ mục cho bảng `checkout_cart`
--
ALTER TABLE `checkout_cart`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_product_category` (`category_id`);

--
-- Chỉ mục cho bảng `product_category`
--
ALTER TABLE `product_category`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `services`
--
ALTER TABLE `services`
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
-- Chỉ mục cho bảng `site_user`
--
ALTER TABLE `site_user`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `variation`
--
ALTER TABLE `variation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Chỉ mục cho bảng `variation_options`
--
ALTER TABLE `variation_options`
  ADD PRIMARY KEY (`product_id`,`variation_id`),
  ADD KEY `variation_id` (`variation_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `bill`
--
ALTER TABLE `bill`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT cho bảng `checkout_cart`
--
ALTER TABLE `checkout_cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT cho bảng `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;

--
-- AUTO_INCREMENT cho bảng `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT cho bảng `product_category`
--
ALTER TABLE `product_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

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
-- AUTO_INCREMENT cho bảng `site_user`
--
ALTER TABLE `site_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `variation`
--
ALTER TABLE `variation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `bill`
--
ALTER TABLE `bill`
  ADD CONSTRAINT `bill_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `site_user` (`id`);

--
-- Các ràng buộc cho bảng `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `fk_product_category` FOREIGN KEY (`category_id`) REFERENCES `product_category` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_ibfk_category` FOREIGN KEY (`category_id`) REFERENCES `product_category` (`id`);

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
  ADD CONSTRAINT `shopping_cart_item_ibfk_2` FOREIGN KEY (`product_item_id`) REFERENCES `product` (`id`);

--
-- Các ràng buộc cho bảng `variation`
--
ALTER TABLE `variation`
  ADD CONSTRAINT `fk_variation_category` FOREIGN KEY (`category_id`) REFERENCES `product_category` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `variation_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `product_category` (`id`);

--
-- Các ràng buộc cho bảng `variation_options`
--
ALTER TABLE `variation_options`
  ADD CONSTRAINT `fk_productconfig_product` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_productconfig_variation` FOREIGN KEY (`variation_id`) REFERENCES `variation` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `variation_options_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  ADD CONSTRAINT `variation_options_ibfk_3` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
