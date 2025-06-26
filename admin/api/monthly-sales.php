<?php
session_start();
require_once '../config/admin-connect.php';

// Check if user is admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != 0) {
    http_response_code(403);
    echo json_encode(['error' => 'Access denied']);
    exit;
}

try {
    $stmt = $conn->prepare("
        SELECT 
            DATE_FORMAT(order_date, '%b %Y') as month,
            SUM(order_total) as total
        FROM bill 
        WHERE order_date >= DATE_SUB(CURDATE(), INTERVAL 12 MONTH)
        GROUP BY YEAR(order_date), MONTH(order_date)
        ORDER BY order_date
    ");
    $stmt->execute();
    
    $sales = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $sales[] = [
            'month' => $row['month'],
            'total' => floatval($row['total'])
        ];
    }
    
    echo json_encode($sales);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>
