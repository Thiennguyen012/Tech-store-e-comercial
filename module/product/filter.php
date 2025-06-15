<?php
// Kết nối database
require_once __DIR__ . '/../../db/connect.php';

// Lấy các giá trị lọc từ request POST (AJAX)
$selectedFilters = isset($_POST['filters']) ? $_POST['filters'] : [];
$minPrice = isset($_POST['minPrice']) ? intval($_POST['minPrice']) : 0;
$maxPrice = isset($_POST['maxPrice']) ? intval($_POST['maxPrice']) : 10000000;
$category = isset($_POST['category']) ? htmlspecialchars($_POST['category']) : 'laptop'; // Lấy category từ request
$sortBy = isset($_POST['sortBy']) ? $_POST['sortBy'] : '1';

// Tạo câu truy vấn SQL cơ bản
$sql = "SELECT DISTINCT p.id, p.name, p.product_image, p.price 
        FROM product p 
        INNER JOIN product_category pc ON p.category_id = pc.id 
        LEFT JOIN variation_options vo ON p.id = vo.product_id 
        LEFT JOIN variation v ON vo.variation_id = v.id 
        WHERE pc.category_name = ? AND p.price BETWEEN ? AND ?";

// Chuẩn bị mảng điều kiện lọc và tham số truyền vào
$filterConditions = [];
$params = [$category, $minPrice, $maxPrice];
$types = "sii"; // s: string, i: integer

// Nếu có lọc theo thuộc tính (variation), thêm điều kiện vào SQL
foreach ($selectedFilters as $key => $value) {
    $filterConditions[] = "vo.value = ?";
    $params[] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8'); // Xử lý giá trị đặc biệt
    $types .= "s";
}

// Nếu có điều kiện lọc, nối vào SQL (dùng OR để lọc theo nhiều giá trị)
if (!empty($filterConditions)) {
    $sql .= " AND (" . implode(" OR ", $filterConditions) . ")";
}

// Thêm điều kiện sắp xếp
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
    default:
        $sql .= " ORDER BY p.price ASC";
}

// Chuẩn bị và thực thi truy vấn
$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();

// Xuất HTML danh sách sản phẩm (dạng grid Bootstrap)
if ($result && $result->num_rows > 0) {
    echo '<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">';
    while ($row = $result->fetch_assoc()) {
        echo '<div class="col">';
        echo '<div class="card border-0 h-100 shadow-sm">';
        echo '<a href="#" onclick="loadPage(\'module/product/single_product.php?id=' . $row['id'] . '\'); return false;" style="text-decoration:none; color:inherit;">';
        echo '<img src="' . htmlspecialchars($row['product_image']) . '" class="card-img-top p-2" alt="' . htmlspecialchars($row['name']) . '" style="height:260px;object-fit:contain;">';
        echo '</a>';
        echo '<div class="card-body text-center">';
        echo '<h6 class="card-title fw-bold text-uppercase mb-2" style="font-size: 0.95rem; min-height: 38px;">' . htmlspecialchars($row['name']) . '</h6>';
        echo '<div class="fw-bold mb-2" style="font-size: 1.1rem; margin-top: 0.5rem;">' . number_format($row['price'], 0, ',', '.') . '$</div>';
        echo '<div class="d-flex justify-content-center gap-2">';
        echo '<a href="#" onclick="loadPage(\'module/product/single_product.php?id=' . $row['id'] . '\'); return false;" class="btn btn-dark btn-sm rounded-pill px-3">';
        echo 'More details';
        echo '</a>';
        echo '<form id="addToCartForm" action="module/cart/cart.php" method="POST">';
        echo '<input type="hidden" name="product-id" value="' . $row['id'] . '">';
        echo '<input type="hidden" name="product-name" value="' . $row['name'] . '">';
        echo '<input type="hidden" name="product-price" value="' . $row['price'] . '">';
        echo '<input type="hidden" name="product-img" value="' . $row['product_image'] . '">';
        echo '<button id="addcart-submit" type="submit" name="add-to-cart" class="btn btn-outline-dark btn-sm rounded-pill px-3">';
        echo '<i class="bi bi-cart"></i>';
        echo '</button>';
        echo '</form>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
    echo '</div>';
} else {
    // Không có sản phẩm phù hợp
    echo '<div class="col"><div class="alert alert-warning w-100">No products match the current filter.</div></div>';
}
?>