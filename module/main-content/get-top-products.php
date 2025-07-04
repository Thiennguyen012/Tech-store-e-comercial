<?php
require_once __DIR__ . '/../../db/connect.php';

// Lấy top products từ mỗi category
function getTopProductsByCategory($conn, $categoryName, $limit = 4) {
    $sql = "SELECT p.id, p.name, p.product_image, p.price, p.qty_in_stock 
            FROM product p 
            INNER JOIN product_category pc ON p.category_id = pc.id 
            WHERE pc.category_name = ? 
            ORDER BY p.id ASC 
            LIMIT ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $categoryName, $limit);
    $stmt->execute();
    return $stmt->get_result();
}

// Lấy sản phẩm cụ thể theo ID
function getProductById($conn, $productId) {
    $sql = "SELECT p.id, p.name, p.product_image, p.price, p.qty_in_stock 
            FROM product p 
            WHERE p.id = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

// Lấy nhiều sản phẩm theo danh sách ID
function getProductsByIds($conn, $productIds) {
    if (empty($productIds)) {
        return [];
    }
    
    // Tạo placeholders cho IN clause
    $placeholders = str_repeat('?,', count($productIds) - 1) . '?';
    $sql = "SELECT p.id, p.name, p.product_image, p.price, p.qty_in_stock 
            FROM product p 
            WHERE p.id IN ($placeholders)
            ORDER BY FIELD(p.id, $placeholders)"; // Giữ thứ tự theo danh sách ID
    
    $stmt = $conn->prepare($sql);
    // Bind parameters - cần bind 2 lần vì có 2 placeholders
    $types = str_repeat('i', count($productIds) * 2);
    $params = array_merge($productIds, $productIds);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    return $stmt->get_result();
}

// ========== CẤU HÌNH TOP PRODUCTS ==========
// Load configuration from database

// Function to get config from database (using MySQLi)
function getTopProductsConfig($conn, $key, $default = '') {
    try {
        $stmt = $conn->prepare("SELECT config_value FROM top_products_config WHERE config_key = ?");
        $stmt->bind_param("s", $key);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row ? $row['config_value'] : $default;
    } catch (Exception $e) {
        return $default;
    }
}

// Load configuration and get products
$topLaptopIds = array_filter(array_map('intval', explode(',', getTopProductsConfig($conn, 'top_laptop_ids', '1,2,3,4'))));
$topCameraIds = array_filter(array_map('intval', explode(',', getTopProductsConfig($conn, 'top_camera_ids', '13,14,15,16'))));

// Get products by configured IDs or fallback to category method
$laptops = getProductsByIds($conn, $topLaptopIds);
if (!is_object($laptops) || $laptops->num_rows < 4) {
    $laptops = getTopProductsByCategory($conn, 'laptop', 4);
}

$cameras = getProductsByIds($conn, $topCameraIds);
if (!is_object($cameras) || $cameras->num_rows < 4) {
    $cameras = getTopProductsByCategory($conn, 'camera', 4);
}

// ========== HƯỚNG DẪN SỬ DỤNG ==========/
/*
CÁCH THAY ĐỔI TOP PRODUCTS:

Để thay đổi Top Products, vào Admin Panel:
1. Truy cập: /admin/modules/top-products-config.php
2. Chọn sản phẩm muốn hiển thị trong từng section
3. Nhấn "Save Configuration"

Cấu hình sẽ được lưu trong database và áp dụng ngay lập tức.
*/
?>