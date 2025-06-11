<?php
require_once __DIR__ . '/../product/product.php';
require_once __DIR__ . '/../db/connect.php';
?>

<?php
// Lấy từ khóa tìm kiếm
$searchKeyword = isset($_POST['search']) ? trim($_POST['search']) : '';
$searchKeyword = htmlspecialchars($searchKeyword);

// Xây dựng câu lệnh SQL với điều kiện tìm kiếm
if (!empty($searchKeyword)) {
    $sql = "SELECT DISTINCT p.id, p.name, p.product_image, p.price 
            FROM product p 
            INNER JOIN product_category pc ON p.category_id = pc.id 
            LEFT JOIN variation_options vo ON p.id = vo.product_id 
            WHERE p.name LIKE ? AND pc.category_name = ? AND p.price BETWEEN ? AND ?";

    $searchParam = '%' . $searchKeyword . '%';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssii", $searchParam, $category, $minPrice, $maxPrice);
}

?>