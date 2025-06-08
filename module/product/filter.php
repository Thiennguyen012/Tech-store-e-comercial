<?php
// filepath: d:\xampp\htdocs\code web\module\product\filter.php
require_once __DIR__ . '/../../db/connect.php';

$selectedFilters = isset($_POST['filters']) ? $_POST['filters'] : [];
$minPrice = isset($_POST['minPrice']) ? intval($_POST['minPrice']) : 0;
$maxPrice = isset($_POST['maxPrice']) ? intval($_POST['maxPrice']) : 10000000;
$category = isset($_POST['category']) ? htmlspecialchars($_POST['category']) : 'laptop'; // Lấy category từ request
$sortBy = isset($_POST['sortBy']) ? $_POST['sortBy'] : '1';

$sql = "SELECT DISTINCT p.id, p.name, p.product_image, p.price 
        FROM product p 
        INNER JOIN product_category pc ON p.category_id = pc.id 
        LEFT JOIN variation_options vo ON p.id = vo.product_id 
        LEFT JOIN variation v ON vo.variation_id = v.id 
        WHERE pc.category_name = ? AND p.price BETWEEN ? AND ?";

$filterConditions = [];
$params = [$category, $minPrice, $maxPrice];
$types = "sii";

foreach ($selectedFilters as $key => $value) {
    $filterConditions[] = "vo.value = ?";
    $params[] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8'); // Xử lý giá trị đặc biệt
    $types .= "s";
}

if (!empty($filterConditions)) {
    $sql .= " AND (" . implode(" OR ", $filterConditions) . ")";
}

// Thêm phần sắp xếp
switch ($sortBy) {
    case '1':
        $sql .= " ORDER BY p.price ASC";
        break;
    case '2':
        $sql .= " ORDER BY p.price DESC";
        break;
    case '3':
        $sql .= " ORDER BY p.name ASC";
        break;
    case '4':
        $sql .= " ORDER BY p.popularity DESC";
        break;
    default:
        $sql .= " ORDER BY p.price ASC";
}

$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    echo '<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">'; // Thêm lớp row và chia cột
    while ($row = $result->fetch_assoc()) {
        echo '<div class="col">';
        echo '<div class="card border-0 h-100">';
        echo '<a href="#" onclick="loadPage(\'module/product/single_product.php?id=' . $row['id'] . '\'); return false;" style="text-decoration:none; color:inherit;">';
        echo '<img src="' . htmlspecialchars($row['product_image']) . '" class="card-img-top" alt="' . htmlspecialchars($row['name']) . '">';
        echo '<div class="card-body text-center">';
        echo '<h6 class="card-title fw-bold text-uppercase mb-2" style="font-size: 1rem;">' . htmlspecialchars($row['name']) . '</h6>';
        echo '<div class="fw-bold" style="font-size: 1.1rem;">' . number_format($row['price'], 0, ',', '.') . '$</div>';
        echo '</div>';
        echo '</a>';
        echo '</div>';
        echo '</div>';
    }
    echo '</div>'; // Đóng lớp row
} else {
    echo '<div class="col"><div class="alert alert-warning w-100">No products match the current filter.</div></div>';
}
?>