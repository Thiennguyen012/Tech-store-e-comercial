<?php
// search-logic.php
// File này sẽ được include trong product.php để xử lý tìm kiếm

// Không cần require connect.php ở đây vì product.php đã có

// Hàm tìm kiếm sản phẩm
function searchProducts($conn, $query, $minPrice = 0, $maxPrice = 10000000, $sortBy = '1')
{
    if (empty(trim($query))) {
        return false; // Không có từ khóa tìm kiếm
    }

    // Tạo câu truy vấn SQL tìm kiếm
    $sql = "SELECT DISTINCT p.id, p.name, p.product_image, p.price, p.qty_in_stock 
            FROM product p 
            INNER JOIN product_category pc ON p.category_id = pc.id 
            WHERE p.name LIKE ? AND p.price BETWEEN ? AND ?";

    $searchTerm = '%' . trim($query) . '%';
    $params = [$searchTerm, $minPrice, $maxPrice];
    $types = "sii";

    // Thêm điều kiện sắp xếp
    switch ($sortBy) {
        case '1': // Giá tăng dần
            $sql .= " ORDER BY p.price ASC";
            break;
        case '2': // Giá giảm dần
            $sql .= " ORDER BY p.price DESC";
            break;
        case '3': // Theo tên
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

    return $result;
}

// Hàm lấy các bộ lọc cho tìm kiếm (tất cả categories)
// Removed as per new search logic

// Hàm tìm kiếm với bộ lọc
function searchProductsWithFilters($conn, $query, $selectedFilters = [], $minPrice = 0, $maxPrice = 10000000, $sortBy = '1')
{
    if (empty(trim($query))) {
        return false;
    }

    $sql = "SELECT DISTINCT p.id, p.name, p.product_image, p.price, p.qty_in_stock 
            FROM product p 
            INNER JOIN product_category pc ON p.category_id = pc.id 
            WHERE p.name LIKE ? AND p.price BETWEEN ? AND ?";

    $searchTerm = '%' . trim($query) . '%';
    $params = [$searchTerm, $minPrice, $maxPrice];
    $types = "sii";

    // Thêm điều kiện bộ lọc
    if (!empty($selectedFilters)) {
        foreach ($selectedFilters as $value) {
            $sql .= " AND EXISTS (
                SELECT 1 FROM variation_options vo2 
                WHERE vo2.product_id = p.id 
                AND vo2.value = ?
            )";
            $params[] = $value;
            $types .= "s";
        }
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

    $stmt = $conn->prepare($sql);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result;
}
?>