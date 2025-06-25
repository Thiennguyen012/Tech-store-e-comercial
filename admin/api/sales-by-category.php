<?php
session_start();
require_once '../../db/connect.php';

// Check if user is admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != 0) {
    http_response_code(403);
    echo json_encode(['error' => 'Access denied']);
    exit;
}

try {
    $stmt = $conn->prepare("
        SELECT pc.category_name as category, SUM(cc.total) as total
        FROM checkout_cart cc
        JOIN product p ON cc.product_name = p.name
        JOIN product_category pc ON p.category_id = pc.id
        GROUP BY pc.id
        ORDER BY total DESC
    ");
    $stmt->execute();
    
    $categories = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $categories[] = [
            'category' => $row['category'],
            'total' => floatval($row['total'])
        ];
    }
    
    echo json_encode($categories);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>
