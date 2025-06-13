<?php
// Kết nối CSDL
require_once __DIR__ . '/../../db/connect.php';

// Kiểm tra kết nối
if (!$conn) {
    die("Database connection failed: " . $conn->connect_error);
}

// Lấy từ khóa tìm kiếm
$query = isset($_GET['query']) ? trim($_GET['query']) : '';
$category = isset($_GET['category']) ? htmlspecialchars($_GET['category'], ENT_QUOTES, 'UTF-8') : 'laptop';
$minPrice = isset($_GET['minPrice']) && is_numeric($_GET['minPrice']) ? intval($_GET['minPrice']) : 0;
$maxPrice = isset($_GET['maxPrice']) && is_numeric($_GET['maxPrice']) ? intval($_GET['maxPrice']) : 10000000;

// Khởi tạo SQL cơ bản
$sql = "SELECT DISTINCT p.id, p.name, p.product_image, p.price
        FROM product p
        INNER JOIN product_category pc ON p.category_id = pc.id
        WHERE pc.category_name = ? AND p.price BETWEEN ? AND ?";

$params = [$category, $minPrice, $maxPrice];
$types = "sii";

// Thêm điều kiện tìm kiếm theo tên nếu có từ khóa
if (!empty($query)) {
    $sql .= " AND p.name LIKE ?";
    $params[] = '%' . $query . '%';
    $types .= "s";
}

// Chuẩn bị và thực thi truy vấn
$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();

// Trả kết quả
$products = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}

// Đóng tài nguyên
$stmt->close();
$conn->close();

// Return products array
return $products;
?>