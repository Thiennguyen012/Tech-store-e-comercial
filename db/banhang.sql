-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 07, 2025 at 06:50 PM
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
-- Database: `banhang`
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
(1, 'Acer Aspire 3 Intel Celeron 4GB RAM 128GB SSD 15.6 Inch Windows 11 Laptop', 'Highlighting form and function, a stunningly slim body and impressive tactile finish accentuate real-world design features. Built to keep you active, engaged, and on the move, the Aspire 3 has the technology to suit your way of life. Fundamentally impressive technology.\r\nEfficient Performance with Intel Celeron N4500\r\nThe Acer Aspire 3 A315-35 is powered by the Intel Celeron N4500 processor, delivering reliable performance for everyday computing tasks. With speeds of up to 2.8 GHz, this dual-core processor ensures smooth web browsing, document editing, and media playback. Whether you\'re working on assignments, streaming content, or managing emails, the Aspire 3 provides a seamless user experience.Crisp 15.6-Inch HD Display for Everyday Use\r\nFeaturing a 15.6-inch HD (1366 x 768) TN display, the Aspire 3 offers clear visuals and vibrant colors for work and entertainment. The anti-glare screen reduces reflections, making it comfortable to use in various lighting conditions. Its widescreen format enhances productivity, allowing you to view multiple applications simultaneously without feeling cramped.Fast and Reliable Storage with 128GB NVMe SSD\r\nThe 128GB NVMe SSD provides quick boot times and fast data access, ensuring efficient performance for everyday computing. With 3D Triple-Level Cell (TLC) technology, the SSD offers durability and reliability, making file transfers and software loading times much faster compared to traditional hard drives. This storage capacity is ideal for essential applications, documents, and media files.Seamless Connectivity with Wi-Fi 6 and Gigabit Ethernet\r\nStay connected with the latest Wi-Fi 6 technology, providing faster and more stable wireless connections for browsing, streaming, and online meetings. The Aspire 3 also includes a Gigabit Ethernet port for a reliable wired connection when needed. Whether at home, in the office, or on the go, you can enjoy uninterrupted connectivity for all your online activities.Sleek Design with a Comfortable UK Keyboard\r\nFinished in an elegant pure silver design, the Acer Aspire 3 offers a stylish and lightweight build, making it easy to carry wherever you go. The UK keyboard layout ensures comfortable and accurate typing, ideal for students and professionals alike. With a full-sized keyboard and precision touchpad, navigating through tasks becomes effortless, enhancing your overall productivity.', 1, 10, 'https://www.laptopsdirect.co.uk/Images/NX.A6LEK.00P_1_Supersize.jpg?width=750&height=750&v=3', 179.89),
(2, 'Acer TravelMate P2 Intel Core i5 8GB RAM 256GB SSD 14 Inch Windows 11 Laptop', 'Acer TravelMate P2, Intel Core i5, 8GB RAM, 256GB SSD, 14\" Full HD, Windows 11, NX.VYAEK.003. Designed for business and productivity with robust security, long battery life, and a lightweight chassis.', 1, 10, 'https://www.laptopsdirect.co.uk/Images/NX.VYAEK.00F_1_Supersize.jpg?v=3', 499.97),
(3, 'Apple MacBook Air 13-inch M2 16GB RAM 512GB SSD Space Grey', 'Apple MacBook Air 13-inch (M2, 2022), 16GB RAM, 512GB SSD, Space Grey. Siêu mỏng nhẹ, hiệu năng mạnh mẽ với chip Apple M2, màn hình Liquid Retina, thời lượng pin lên tới 18 giờ, Touch ID, macOS.', 1, 5, 'https://www.laptopsdirect.co.uk/Images/Z15S2002148089_1_Supersize.png?v=3', 1399.00),
(4, 'Apple MacBook Pro 14-inch M4 16GB RAM 512GB SSD Space Black', 'Apple MacBook Pro 14-inch (2024), Apple M4 chip with 10-core CPU and 10-core GPU, 16GB RAM, 512GB SSD, Space Black. Màn hình Liquid Retina XDR, Touch ID, thời lượng pin lên tới 18 giờ, macOS.', 1, 5, 'https://www.laptopsdirect.co.uk/Images/MW2U3BA_1_Supersize.jpg?v=4', 1799.00),
(5, 'ASUS TUF A15 Ryzen 7 7435HS 16GB RAM 512GB SSD RTX 4060 144Hz 15.6 Inch FHD', 'ASUS TUF A15, AMD Ryzen 7 7435HS, 16GB RAM, 512GB SSD, NVIDIA GeForce RTX 4060, 144Hz 15.6\" FHD, FA507NVR-LP012W, Windows 11, thiết kế gaming bền bỉ, hiệu năng mạnh mẽ.', 1, 10, 'https://www.laptopsdirect.co.uk/Images/FA507NVR-LP012W_1_Supersize.jpg?v=3', 1199.00),
(6, 'ASUS ROG Strix G16 Intel Core Ultra 9 16GB RAM 2TB SSD GeForce RTX 5080 240Hz 16 Inch', 'ASUS ROG Strix G16, Intel Core Ultra 9, 16GB RAM, 2TB SSD, NVIDIA GeForce RTX 5080, 240Hz 16\" FHD, G615LW-S5008W, Windows 11, laptop gaming cao cấp với hiệu năng vượt trội.', 1, 10, 'https://www.laptopsdirect.co.uk/Images/G615LW-S5008W_1_Supersize.png?v=32', 2999.00),
(7, 'Dell Latitude 7400 Intel Core i5 8th Gen 16GB 256GB 14 Inch Win 11 Pro', 'Dell Latitude 7400 Refurbished, Intel Core i5 8th Gen, 16GB RAM, 256GB SSD, 14\" FHD, Windows 11 Pro. Laptop doanh nhân bền bỉ, hiệu năng ổn định, thiết kế mỏng nhẹ.', 1, 5, 'https://www.laptopsdirect.co.uk/Images/T15420i516GB256GBW10P_1_Supersize.jpg?v=3', 399.00),
(8, 'Dell Latitude 5420 Core i5 11th Gen 16GB 256GB 14 Inch Windows 10 Pro', 'Dell Latitude 5420 Refurbished, Intel Core i5 11th Gen, 16GB RAM, 256GB SSD, 14\" FHD, Windows 10 Pro. Laptop doanh nhân bền bỉ, hiệu năng ổn định, thiết kế mỏng nhẹ.', 1, 5, 'https://www.laptopsdirect.co.uk/Images/T17400i516GB256GBW11P_1_Supersize.jpg?v=3', 499.00),
(9, 'HP 250 G9 Laptop Intel Core i7 1255U 16GB 512GB SSD 15.6 Inch FHD Windows 11', 'HP 250 G9, Intel Core i7-1255U, 16GB RAM, 512GB SSD, 15.6\" FHD, Windows 11. Laptop văn phòng mạnh mẽ, thiết kế bền bỉ, phù hợp cho công việc và học tập.', 1, 10, 'https://www.laptopsdirect.co.uk/Images/A16Q947ES_1_Supersize.jpg?v=47', 699.00),
(10, 'HP 250 G9 Intel Core i5 16GB RAM 256GB SSD 15.6 Inch Windows 11 Pro Laptop', 'HP 250 G9, Intel Core i5, 16GB RAM, 256GB SSD, 15.6\" FHD, Windows 11 Pro. Laptop văn phòng bền bỉ, hiệu năng ổn định, phù hợp cho doanh nghiệp và cá nhân.', 1, 10, 'https://www.laptopsdirect.co.uk/Images/A16Q947ES_1_Supersize.jpg?v=47', 599.00),
(11, 'Lenovo V15 G4 AMD Ryzen 5 16GB RAM 512GB SSD 15.6 Inch Windows 11 Pro Laptop', 'Lenovo V15 G4, AMD Ryzen 5, 16GB RAM, 512GB SSD, 15.6\" FHD, Windows 11 Pro. Laptop văn phòng mạnh mẽ, thiết kế bền bỉ, phù hợp cho công việc và học tập.', 1, 10, 'https://www.laptopsdirect.co.uk/Images/82YU00JYUK_1_15087916_Supersize.jpg?v=5', 549.00),
(12, 'Lenovo Legion 5 Y500 Series 16 240Hz Intel Core i7-14650HX 16GB 1TB RTX 4060', 'Lenovo Legion 5 Y500 Series, 16\" 240Hz, Intel Core i7-14650HX, 16GB RAM, 1TB SSD, NVIDIA GeForce RTX 4060, Windows 11, laptop gaming cao cấp với hiệu năng mạnh mẽ và màn hình tần số quét cao.', 1, 10, 'https://www.laptopsdirect.co.uk/Images/83DG00DSUK_1_Supersize.jpg?v=8', 1599.00),
(13, 'Tapo C510W Outdoor Pan/Tilt Wi-Fi Camera', 'Tapo C510W Outdoor Pan/Tilt Wi-Fi Camera, 3MP, Color Night Vision, Motion Tracking, Two-Way Audio, IP65 Weatherproof, Smart AI Detection, Works with Alexa & Google Home.', 2, 20, 'https://hanoicomputercdn.com/media/product/91274_camera_tp_link_tapo_c510w_0003_layer_1.jpg', 59.99),
(14, 'Hikvision DS-2CD1343G2-LIU/SL 4MP Dome Camera', 'Camera IP Hikvision DS-2CD1343G2-LIU/SL, 4MP, Dome, ColorVu, tích hợp micro, cảnh báo đèn còi, chuẩn nén H.265+, chống ngược sáng WDR 120dB, chuẩn IP67, hỗ trợ thẻ nhớ microSD lên tới 256GB.', 2, 15, 'https://hanoicomputercdn.com/media/product/83147_camera_hikvision_ds_2cd1343g2_liuf_sl_2.jpg', 240.00),
(15, 'TP-Link VIGI C240I 4mm 4MP Dome Camera', 'TP-Link VIGI C240I 4mm IP Camera, 4MP, Dome, H.265+ Compression, AI-Powered, Motion Detection, WDR Backlight Compensation, IP67 Rating, Built-in Microphone.', 2, 20, 'https://hanoicomputercdn.com/media/product/74709_camera_tp_link_vigi_c240l_4mm_1.jpg', 45.67),
(16, 'Hikvision DS-2CE16D0T-EXLPF 2MP Bullet Camera', 'Hikvision DS-2CE16D0T-EXLPF, 2MP, Bullet, EXIR, 2.8mm lens, IR up to 30m, IP67 weatherproof, metal body, suitable for indoor and outdoor installation.', 2, 20, 'https://hanoicomputercdn.com/media/product/89646_camera_hikvision_ds_2ce16d0t_exlpf.jpg', 13.39),
(17, 'Acer Gaming Nitro V 16 ProPanel ANV16-41-R36Y R7-8845HS 16GB RAM 512GB SSD RTX 4050 16 Inch WUXGA Win11 Black', 'Acer Nitro V 16 ProPanel ANV16-41-R36Y, AMD Ryzen 7 8845HS, 16GB RAM, 512GB SSD, NVIDIA GeForce RTX 4050 6GB, 16\" WUXGA, Windows 11,Black color, high-performance gaming laptop, large display, efficient cooling system.', 1, 10, 'https://hanoicomputercdn.com/media/product/84662_laptop_acer_gaming_nitro_v_16_propanel_anv16_41_r6na_nh_qp0sv_001_r7_8845hs_16gb_ram_512gb_ssd_rtx4060_8gb_16_inch_0005_.jpg', 1120.66),
(18, 'Acer Gaming Nitro Lite NL16-71G-71UJ i7-13620H 16GB RAM 512GB SSD RTX 4050 16 Inch WUXGA Win11 Black', 'Acer Gaming Nitro Lite NL16-71G-71UJ, Intel Core i7-13620H, 16GB RAM, 512GB SSD, NVIDIA GeForce RTX 4050 6GB, 16\" WUXGA, Windows 11, black color. High-performance gaming laptop with large display, efficient cooling, and modern design.', 1, 10, 'https://hanoicomputercdn.com/media/product/90816_laptop_acer_gaming_nitro_lite_nl16_71g_71uj_nh_d59sv_002_0007_layer_2.jpg', 921.08),
(19, 'ASUS Zenbook UX3405MA-PP152W i5-12500H 16GB RAM 512GB SSD 14 Inch OLED Touch Win11', 'ASUS Zenbook UX3405MA-PP152W, Intel Core Ultra 5 125H, 16GB RAM, 512GB SSD, 14\" 3K OLED Touch Display, Intel Graphics, Windows 11, ultra-thin and lightweight design, long battery life, premium build quality.', 1, 10, 'https://hanoicomputercdn.com/media/product/79246_laptop_asus_zenbook_ux3405ma_pp152w__6_.jpg', 997.50),
(20, 'Dell Inspiron 3530 i7-1355U 16GB 512GB SSD 15.6 Inch FHD 120Hz Win11H OfficeHS21 Silver', 'Dell Inspiron 3530, Intel Core i7-1355U, 16GB RAM, 512GB SSD, 15.6\" FHD 120Hz, Windows 11 Home, Office Home & Student 2021, Silver. High-performance laptop for work and entertainment, featuring a fast display and modern design.', 1, 10, 'https://hanoicomputercdn.com/media/product/86105_file_pts_chu___n_l____0000_layer_1.jpg', 690.46),
(21, 'MSI Vigor GK20 UK USB Keyboard', 'MSI Vigor GK20 UK USB Keyboard, ergonomic design, RGB lighting, durable keys.', 3, 50, 'https://www.laptopsdirect.co.uk/Images/S11-04UK231-CLA_1_Supersize.jpg?width=750&height=750&v=15', 29.99),
(22, 'SteelSeries Apex 9 TKL Mechanical Gaming Keyboard', 'SteelSeries Apex 9 TKL, mechanical gaming keyboard, compact design, RGB lighting.', 3, 50, 'https://www.laptopsdirect.co.uk/Images/64848_1_Supersize.png?width=750&height=750&v=5', 129.99),
(23, 'Razer Huntsman V3 Pro USB RGB Mechanical Gaming Keyboard', 'Razer Huntsman V3 Pro, RGB mechanical gaming keyboard, analog optical switches.', 3, 50, 'https://www.laptopsdirect.co.uk/Images/RZ03-04970300-R3W1_1_Supersize.jpg?width=750&height=750&v=3', 249.99),
(24, 'Razer BlackWidow V4 75 RGB Gaming Keyboard', 'Razer BlackWidow V4 75, RGB gaming keyboard, customizable keys, durable design.', 3, 50, 'https://www.laptopsdirect.co.uk/Images/RZ03-05000400-R3E1_1_Supersize.png?width=750&height=750&v=3', 199.99),
(25, 'MSI Forge GM300 Wired Gaming Mouse', 'MSI Forge GM300, wired gaming mouse, ergonomic design, RGB lighting.', 3, 50, 'https://www.laptopsdirect.co.uk/Images/BUNS12-0402300-HH996740_2_Supersize.png?width=750&height=750&v=10', 39.99),
(26, 'Razer Kraken X Wired Gaming Headset', 'Razer Kraken X, wired gaming headset, lightweight design, immersive sound.', 3, 50, 'https://www.laptopsdirect.co.uk/Images/RZ04-02950100-R381_1_Supersize.jpg?width=750&height=750&v=7', 49.99),
(27, 'Razer DeathAdder V3 Pro Black Gaming Mouse', 'Razer DeathAdder V3 Pro, wireless gaming mouse, ergonomic design, high precision.', 3, 50, 'https://www.laptopsdirect.co.uk/Images/RZ01-04630100-R3G1_1_Supersize.png?width=750&height=750&v=7', 149.99),
(28, 'Cables Direct HDMI Cable with Ethernet 3m', 'Cables Direct HDMI Cable, 3m length, supports Ethernet, high-speed data transfer.', 3, 100, 'https://www.laptopsdirect.co.uk/Images/77HDMI-030_1_supersize.jpg?width=750&height=750&v=1', 9.99),
(29, '1m RJ-45 Cat6 Networking Cable Black', 'RJ-45 Cat6 Networking Cable, 1m length, black, high-speed data transfer.', 3, 100, 'https://www.laptopsdirect.co.uk/Images/31-0010BK_1_Supersize.jpg?width=750&height=750&v=3', 4.99),
(30, 'Corsair T3 Rush Fabric Gaming Chair Grey and Charcoal', 'Corsair T3 Rush Gaming Chair, fabric material, ergonomic design, grey and charcoal.', 3, 20, 'https://www.laptopsdirect.co.uk/Images/CF-9010056-UK%20_1_Supersize.jpg?width=750&height=750&v=3', 249.99);

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
(2, 'camera'),
(3, 'accessories');

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
(11, 1, 'Storage Capacity'),
(12, 2, 'CCTV brand'),
(13, 2, 'camera location'),
(14, 2, 'connection type'),
(15, 2, 'Camera Resolution'),
(16, 3, 'Mouse'),
(17, 3, 'Cables'),
(18, 3, 'Keyboard'),
(19, 3, 'Headsets'),
(20, 3, 'USB'),
(21, 3, 'SD Cards'),
(22, 3, 'Laptop Docking Stations'),
(23, 3, 'Gaming Chairs');

-- --------------------------------------------------------

--
-- Table structure for table `variation_options`
--

CREATE TABLE `variation_options` (
  `product_id` int(11) NOT NULL,
  `variation_id` int(11) NOT NULL,
  `value` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `variation_options`
--

INSERT INTO `variation_options` (`product_id`, `variation_id`, `value`) VALUES
(1, 1, 'Everyday'),
(1, 2, 'Acer'),
(1, 3, 'Intel Celeron'),
(1, 4, '15.6\"'),
(1, 5, '4GB'),
(1, 10, 'Windows 11'),
(1, 11, '128GB SSD'),
(2, 1, 'Business'),
(2, 2, 'Acer'),
(2, 3, 'Intel Core i5'),
(2, 4, '14\"'),
(2, 5, '8GB'),
(2, 10, 'Windows 11'),
(2, 11, '256GB SSD'),
(3, 1, 'Everyday'),
(3, 2, 'Apple'),
(3, 3, 'Apple M2'),
(3, 4, '13.3\"'),
(3, 5, '16GB'),
(3, 10, 'macOS'),
(3, 11, '512GB SSD'),
(4, 1, 'Professional'),
(4, 2, 'Apple'),
(4, 3, 'Apple M4'),
(4, 4, '14\"'),
(4, 5, '16GB'),
(4, 9, 'Space Black'),
(4, 10, 'macOS'),
(4, 11, '512GB SSD'),
(5, 1, 'Gaming'),
(5, 2, 'ASUS'),
(5, 3, 'AMD Ryzen 7 7435HS'),
(5, 4, '15.6\"'),
(5, 5, '16GB'),
(5, 6, 'RTX 4060'),
(5, 7, '144Hz'),
(5, 10, 'Windows 11'),
(5, 11, '512GB SSD'),
(6, 1, 'Gaming'),
(6, 2, 'ASUS'),
(6, 3, 'Intel Core Ultra 9'),
(6, 4, '16\"'),
(6, 5, '16GB'),
(6, 6, 'RTX 5080'),
(6, 7, '240Hz'),
(6, 10, 'Windows 11'),
(6, 11, '2TB SSD'),
(7, 1, 'Business'),
(7, 2, 'Dell'),
(7, 3, 'Intel Core i5 8th Gen'),
(7, 4, '14\"'),
(7, 5, '16GB'),
(7, 10, 'Windows 11 Pro'),
(7, 11, '256GB SSD'),
(8, 1, 'Business'),
(8, 2, 'Dell'),
(8, 3, 'Intel Core i5 11th Gen'),
(8, 4, '14\"'),
(8, 5, '16GB'),
(8, 10, 'Windows 10 Pro'),
(8, 11, '256GB SSD'),
(9, 1, 'Business'),
(9, 2, 'HP'),
(9, 3, 'Intel Core i7-1255U'),
(9, 4, '15.6\"'),
(9, 5, '16GB'),
(9, 10, 'Windows 11'),
(9, 11, '512GB SSD'),
(10, 1, 'Business'),
(10, 2, 'HP'),
(10, 3, 'Intel Core i5'),
(10, 4, '15.6\"'),
(10, 5, '16GB'),
(10, 10, 'Windows 11 Pro'),
(10, 11, '256GB SSD'),
(11, 1, 'Business'),
(11, 2, 'Lenovo'),
(11, 3, 'AMD Ryzen 5'),
(11, 4, '15.6\"'),
(11, 5, '16GB'),
(11, 10, 'Windows 11 Pro'),
(11, 11, '512GB SSD'),
(12, 1, 'Gaming'),
(12, 2, 'Lenovo'),
(12, 3, 'Intel Core i7-14650HX'),
(12, 4, '16\"'),
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
(17, 4, '16\"'),
(17, 5, '16GB'),
(17, 6, 'RTX 4050'),
(17, 9, 'Black'),
(17, 10, 'Windows 11'),
(17, 11, '512GB SSD'),
(18, 1, 'Gaming'),
(18, 2, 'Acer'),
(18, 3, 'Intel Core i7-13620H'),
(18, 4, '16\"'),
(18, 5, '16GB'),
(18, 6, 'RTX 4050'),
(18, 9, 'Black'),
(18, 10, 'Windows 11'),
(18, 11, '512GB SSD'),
(19, 1, 'Business'),
(19, 2, 'ASUS'),
(19, 3, 'Intel Core Ultra 5 125H'),
(19, 4, '14\"'),
(19, 5, '16GB'),
(19, 6, 'Intel Graphics'),
(19, 8, 'Touch'),
(19, 10, 'Windows 11'),
(19, 11, '512GB SSD'),
(20, 1, 'Business'),
(20, 2, 'Dell'),
(20, 3, 'Intel Core i7-1355U'),
(20, 4, '15.6\"'),
(20, 5, '16GB'),
(20, 7, '120Hz'),
(20, 9, 'Silver'),
(20, 10, 'Windows 11 Home'),
(20, 11, '512GB SSD'),
(21, 2, 'MSI'),
(22, 2, 'SteelSeries'),
(23, 2, 'Razer'),
(24, 2, 'Razer'),
(25, 2, 'MSI'),
(26, 2, 'Razer'),
(27, 2, 'Razer'),
(28, 2, 'Cables Direct'),
(29, 2, 'Generic'),
(30, 2, 'Corsair');

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
-- Indexes for table `variation_options`
--
ALTER TABLE `variation_options`
  ADD PRIMARY KEY (`product_id`,`variation_id`),
  ADD KEY `variation_id` (`variation_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `product_category`
--
ALTER TABLE `product_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

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

--
-- Constraints for table `variation_options`
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
