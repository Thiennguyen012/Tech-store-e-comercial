<?php

// Kết nối database
require_once __DIR__ . '/../../db/connect.php';

// ✅ SỬA: Debug để kiểm tra dữ liệu nhận được
error_log("POST Data: " . print_r($_POST, true));

// Lấy các giá trị lọc từ request POST (AJAX)
$selectedFilters = isset($_POST['filters']) ? $_POST['filters'] : [];
$minPrice = isset($_POST['minPrice']) ? intval($_POST['minPrice']) : 0;
$maxPrice = isset($_POST['maxPrice']) ? intval($_POST['maxPrice']) : 10000000;
$category = isset($_POST['category']) ? htmlspecialchars($_POST['category']) : 'laptop';
$sortBy = isset($_POST['sortBy']) ? $_POST['sortBy'] : '1';
$limit = isset($_POST['limit']) ? intval($_POST['limit']) : 8;
$offset = isset($_POST['offset']) ? intval($_POST['offset']) : 0;

// ✅ THÊM: Debug để xem structure của selectedFilters
error_log("Selected Filters: " . print_r($selectedFilters, true));

// Tạo câu truy vấn SQL cơ bản
$sql = "SELECT DISTINCT p.id, p.name, p.product_image, p.price, p.qty_in_stock 
        FROM product p 
        INNER JOIN product_category pc ON p.category_id = pc.id 
        LEFT JOIN variation_options vo ON p.id = vo.product_id 
        LEFT JOIN variation v ON vo.variation_id = v.id 
        WHERE pc.category_name = ? AND p.price BETWEEN ? AND ?";

// ✅ SỬA: Xử lý multiple selections và logic AND
$filterConditions = [];
$params = [$category, $minPrice, $maxPrice];
$types = "sii";

// ✅ SỬA: Xử lý selectedFilters an toàn
if (!empty($selectedFilters) && is_array($selectedFilters)) {
    foreach ($selectedFilters as $categoryName => $selectedValues) {
        // ✅ SỬA: Đảm bảo selectedValues là array
        if (!is_array($selectedValues)) {
            $selectedValues = [$selectedValues]; // Convert single value to array
        }
        
        if (!empty($selectedValues)) {
            // Tạo điều kiện OR cho cùng 1 category (ví dụ: Dell OR HP)
            $categoryConditions = [];
            foreach ($selectedValues as $value) {
                // ✅ SỬA: Flatten array nếu cần thiết
                if (is_array($value)) {
                    foreach ($value as $subValue) {
                        if (is_string($subValue) && !empty(trim($subValue))) {
                            $categoryConditions[] = "vo.value = ?";
                            $params[] = htmlspecialchars(trim($subValue), ENT_QUOTES, 'UTF-8');
                            $types .= "s";
                        }
                    }
                } elseif (is_string($value) && !empty(trim($value))) {
                    $categoryConditions[] = "vo.value = ?";
                    $params[] = htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
                    $types .= "s";
                }
            }
            
            if (!empty($categoryConditions)) {
                // Nhóm các điều kiện của cùng 1 category
                $filterConditions[] = "(" . implode(" OR ", $categoryConditions) . ")";
            }
        }
    }
}

// ✅ SỬA: Dùng AND để kết hợp các categories khác nhau
if (!empty($filterConditions)) {
    // AND logic: Sản phẩm phải thỏa mãn TẤT CẢ categories được chọn
    $sql .= " AND " . implode(" AND ", $filterConditions);
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

// ✅ THÊM: Debug SQL và params
error_log("Final SQL: " . $sql);
error_log("Params: " . print_r($params, true));
error_log("Types: " . $types);

// Chuẩn bị và thực thi truy vấn
$stmt = $conn->prepare($sql);
if (!$stmt) {
    error_log("SQL Prepare Error: " . $conn->error);
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

// ✅ SỬA: Count query với cùng logic
$countSql = "SELECT COUNT(DISTINCT p.id) as total 
             FROM product p 
             INNER JOIN product_category pc ON p.category_id = pc.id 
             LEFT JOIN variation_options vo ON p.id = vo.product_id 
             LEFT JOIN variation v ON vo.variation_id = v.id 
             WHERE pc.category_name = ? AND p.price BETWEEN ? AND ?";

$countParams = [$category, $minPrice, $maxPrice];
$countTypes = "sii";

// ✅ SỬA: Dùng logic AND giống main query và xử lý array đúng
if (!empty($filterConditions)) {
    $countSql .= " AND " . implode(" AND ", $filterConditions);
    
    // ✅ SỬA: Copy exact params từ main query (trừ limit và offset)
    $mainParams = array_slice($params, 3, -2); // Bỏ category, minPrice, maxPrice và limit, offset
    $countParams = array_merge($countParams, $mainParams);
    $countTypes .= substr($types, 3, -2); // Bỏ "sii" đầu và "ii" cuối
}

$countStmt = $conn->prepare($countSql);
if (!$countStmt) {
    error_log("Count SQL Error: " . $conn->error);
    $total = 0;
} else {
    $countStmt->bind_param($countTypes, ...$countParams);
    if ($countStmt->execute()) {
        $countResult = $countStmt->get_result();
        $total = $countResult->fetch_assoc()['total'];
    } else {
        error_log("Count Execute Error: " . $countStmt->error);
        $total = 0;
    }
}

// ✅ Header với product count
echo '<div class="d-flex justify-content-between align-items-center mb-3">';
echo '<h3 class="fw-bold mb-0">';
echo ucfirst($category);
echo '<span class="fs-6 fw-normal"> (' . $total . ' products)</span>';
echo '</h3>';
echo '</div>';

// ✅ Wrapper để match với product.php
echo '<div class="row row-cols-1 row-cols-sm-2 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-4" id="productGrid">';

if ($result && $result->num_rows > 0) {
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
        
        echo '    <div class="d-flex flex-wrap justify-content-center gap-2 mb-3">';
        echo '      <button onclick="loadPage(\'module/product/single_product.php?id=' . $row['id'] . '\', this, \'single-product\', \'' . $row['id'] . '\'); return false;" class="btn btn-dark btn-sm rounded-pill px-3">';
        echo '        More details';
        echo '      </button>';
        
        if ($row['qty_in_stock'] > 0) {
            echo '      <form id="addToCartForm" action="module/cart/cart.php" method="POST" class="m-0 p-0">';
            echo '        <input type="hidden" name="product-id" value="' . $row['id'] . '">';
            echo '        <input type="hidden" name="product-name" value="' . htmlspecialchars($row['name']) . '">';
            echo '        <input type="hidden" name="product-price" value="' . $row['price'] . '">';
            echo '        <input type="hidden" name="product-img" value="' . htmlspecialchars($row['product_image']) . '">';
            echo '        <button id="addcart-submit" type="submit" name="add-to-cart" class="btn btn-outline-dark btn-sm rounded-pill px-3">';
            echo '          <i class="bi bi-cart"></i>';
            echo '        </button>';
            echo '      </form>';
        } else {
            echo '      <button type="button" onclick="location.href=\'index.php?act=contact\'; return false;" class="btn btn-outline-secondary btn-sm rounded-pill px-3">';
            echo '        Contact';
            echo '      </button>';
        }
        
        echo '    </div>';
        echo '  </div>';
        echo '</div>';
    }
} else {
    echo '<div class="col"><div class="alert alert-warning w-100">No products match the current filter.</div></div>';
}

echo '</div>'; // Đóng productGrid

// Show More button (nếu còn products)
if ($offset + $limit < $total) {
    echo '<div class="text-center my-4">';
    echo '<button id="showMoreBtn" class="btn btn-outline-dark px-4 rounded-pill" data-offset="' . ($offset + $limit) . '">Show more</button>';
    echo '</div>';
}

// ✅ THÊM: Debug info để kiểm tra
echo '<!-- Debug: Total=' . $total . ', Offset=' . $offset . ', Limit=' . $limit . ' -->';
?>
