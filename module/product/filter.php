<?php
// Kết nối database
require_once __DIR__ . '/../../db/connect.php';

// Lấy các giá trị lọc từ request POST (AJAX)
$selectedFilters = isset($_POST['filters']) ? $_POST['filters'] : [];
$minPrice = isset($_POST['minPrice']) ? intval($_POST['minPrice']) : 0;
$maxPrice = isset($_POST['maxPrice']) ? intval($_POST['maxPrice']) : 10000000;
$category = isset($_POST['category']) ? htmlspecialchars($_POST['category']) : 'laptop'; // Lấy category từ request
$sortBy = isset($_POST['sortBy']) ? $_POST['sortBy'] : '1';
$limit = isset($_POST['limit']) ? intval($_POST['limit']) : 8;
$offset = isset($_POST['offset']) ? intval($_POST['offset']) : 0;

// Tạo câu truy vấn SQL cơ bản
$sql = "SELECT DISTINCT p.id, p.name, p.product_image, p.price, p.qty_in_stock 
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

// Thêm điều kiện giới hạn và offset cho phân trang
$sql .= " LIMIT ? OFFSET ?";
$params[] = $limit;
$params[] = $offset;
$types .= "ii";

// Chuẩn bị và thực thi truy vấn
$stmt = $conn->prepare($sql);
if (!$stmt) {
    error_log("SQL Error: " . $conn->error);
    echo '<div class="alert alert-danger">Database error occurred.</div>';
    exit;
}

$stmt->bind_param($types, ...$params);
if (!$stmt->execute()) {
    error_log("Execute Error: " . $stmt->error);
    echo '<div class="alert alert-danger">Query execution failed.</div>';
    exit;
}
$result = $stmt->get_result();

// Đếm tổng số sản phẩm phù hợp (không có LIMIT và OFFSET)
$countSql = "SELECT COUNT(DISTINCT p.id) as total 
             FROM product p 
             INNER JOIN product_category pc ON p.category_id = pc.id 
             LEFT JOIN variation_options vo ON p.id = vo.product_id 
             LEFT JOIN variation v ON vo.variation_id = v.id 
             WHERE pc.category_name = ? AND p.price BETWEEN ? AND ?";

// Thêm điều kiện filter (giống như query chính)
$countParams = [$category, $minPrice, $maxPrice];
$countTypes = "sii";

if (!empty($filterConditions)) {
    $countSql .= " AND (" . implode(" OR ", $filterConditions) . ")";
    foreach ($selectedFilters as $key => $value) {
        $countParams[] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
        $countTypes .= "s";
    }
}

$countStmt = $conn->prepare($countSql);
$countStmt->bind_param($countTypes, ...$countParams);
$countStmt->execute();
$countResult = $countStmt->get_result();
$total = $countResult->fetch_assoc()['total'];

// Xuất HTML danh sách sản phẩm (dạng grid Bootstrap)
if ($result && $result->num_rows > 0) {
    echo '<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">';
    while ($row = $result->fetch_assoc()) {
        echo '<div class="col">';
        echo '  <div class="card product-card border-0 h-100 shadow-sm">';
        echo '    <a href="#" onclick="loadPage(\'module/product/single_product.php?id=' . $row['id'] . '\', this, \'single-product\', \'' . $row['id'] . '\'); return false;" style="text-decoration:none; color:inherit;">';
        echo '      <img src="' . htmlspecialchars($row['product_image']) . '" class="card-img-top p-2" alt="' . htmlspecialchars($row['name']) . '" style="height:260px;object-fit:contain;">';
        echo '    </a>';
        echo '    <div class="card-body text-center">';
        echo '      <h6 class="card-title fw-bold text-uppercase mb-2" style="font-size: 0.95rem; min-height: 38px;">' . htmlspecialchars($row['name']) . '</h6>';
        echo '      <div class="fw-bold mb-2" style="font-size: 1.1rem; margin-top: 0.5rem;">' . number_format($row['price'], 0, ',', '.') . '$</div>';
        echo '    </div>';
        echo '    <div class="card-footer bg-white border-0">';
        echo '      <div class="d-flex flex-wrap justify-content-center gap-2">';
        echo '        <button';
        echo '        onclick="loadPage(\'module/product/single_product.php?id=' . $row['id'] . '\', this, \'single-product\', \'' . $row['id'] . '\'); return false;" class="btn btn-dark btn-sm rounded-pill px-3">';
        echo '          More details';
        echo '        </button>';
        if ($row['qty_in_stock'] > 0) {
            echo '        <form id="addToCartForm" action="module/cart/cart.php" method="POST" class="m-0 p-0">';
            echo '          <input type="hidden" name="product-id" value="' . $row['id'] . '">';
            echo '          <input type="hidden" name="product-name" value="' . htmlspecialchars($row['name']) . '">';
            echo '          <input type="hidden" name="product-price" value="' . $row['price'] . '">';
            echo '          <input type="hidden" name="product-img" value="' . htmlspecialchars($row['product_image']) . '">';
            echo '          <button id="addcart-submit" type="submit" name="add-to-cart" class="btn btn-outline-dark btn-sm rounded-pill px-3">';
            echo '            <i class="bi bi-cart"></i>';
            echo '          </button>';
            echo '        </form>';
        } else {
            echo '        <button type="button" onclick="location.href=\'index.php?act=contact\'; return false;" class="btn btn-outline-secondary btn-sm rounded-pill px-3">';
            echo '          Contact';
            echo '        </button>';
        }
        echo '      </div>';
        echo '    </div>';
        echo '  </div>';
        echo '</div>';
    }
    echo '</div>';
} else {
    // Không có sản phẩm phù hợp
    echo '<div class="col"><div class="alert alert-warning w-100">No products match the current filter.</div></div>';
}
if ($offset + $limit < $total) {
    echo '<div class="text-center my-4"><button id="showMoreBtn" class="btn btn-outline-dark px-4 rounded-pill" data-offset="' . ($offset + $limit) . '">Show more</button></div>';
}

// Debug info (có thể bỏ khi production)
if (isset($_POST['debug']) && $_POST['debug'] == '1') {
    echo '<div class="alert alert-info mt-3">';
    echo '<strong>Debug Info:</strong><br>';
    echo 'Total: ' . $total . '<br>';
    echo 'Limit: ' . $limit . '<br>';
    echo 'Offset: ' . $offset . '<br>';
    echo 'SQL: ' . htmlspecialchars($sql) . '<br>';
    echo 'Params: ' . json_encode($params);
    echo '</div>';
}
