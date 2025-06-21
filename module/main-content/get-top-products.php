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

// Lấy top laptops
$laptops = getTopProductsByCategory($conn, 'laptop', 4);

// Lấy top cameras
$cameras = getTopProductsByCategory($conn, 'camera', 4);

// ========== CHỌN FEATURED PRODUCTS ==========
// Ta có thể thay đổi ID này để chọn sản phẩm featured khác

// Featured Laptop - thay đổi ID này để chọn laptop featured
$featuredLaptopId = 6; // ASUS ROG Strix G16 (ID = 6)
$featuredLaptop = getProductById($conn, $featuredLaptopId);

// Featured Camera - thay đổi ID này để chọn camera featured  
$featuredCameraId = 31; // Google Nest Cam (ID = 31, sản phẩm vừa thêm)
$featuredCamera = getProductById($conn, $featuredCameraId);

// Nếu không tìm thấy sản phẩm với ID đã chọn, fallback về sản phẩm đầu tiên
if (!$featuredLaptop) {
    $laptopFallback = getTopProductsByCategory($conn, 'laptop', 1);
    $featuredLaptop = $laptopFallback->fetch_assoc();
}

if (!$featuredCamera) {
    $cameraFallback = getTopProductsByCategory($conn, 'camera', 1);
    $featuredCamera = $cameraFallback->fetch_assoc();
}
?>