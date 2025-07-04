<?php
session_start();
require_once '../config/admin-connect.php';

// Kiểm tra xem người dùng có phải admin không
if (!isset($_SESSION['role']) || $_SESSION['role'] != 0) {
    http_response_code(403);
    echo json_encode(['error' => 'Access denied']);
    exit;
}

try {
    // Lấy đơn hàng gần đây (10 đơn cuối)
    $stmt = $conn->prepare("
        SELECT id, order_name, order_total, order_date, order_status 
        FROM bill 
        ORDER BY order_date DESC 
        LIMIT 10
    ");    $stmt->execute();
    $orders = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $orders[] = $row;
    }

    // Định dạng đơn hàng để hiển thị
    $formatted_orders = [];
    foreach ($orders as $order) {
        $status_text = 'Pending';
        $status_color = 'warning';
        $status_value = $order['order_status'];
        
        // Xử lý cả giá trị trạng thái string và numeric
        if ($status_value === 'completed' || $status_value == 1) {
            $status_text = 'Completed';
            $status_color = 'success';
        } elseif ($status_value === 'shipping') {
            $status_text = 'Shipping';
            $status_color = 'info';
        } elseif ($status_value === 'cancelled' || $status_value == 2) {
            $status_text = 'Cancelled';
            $status_color = 'danger';
        }

        $formatted_orders[] = [
            'id' => $order['id'],
            'order_name' => $order['order_name'] ?: 'Guest',
            'order_total' => number_format($order['order_total'], 2),
            'order_date' => date('M d, Y', strtotime($order['order_date'])),
            'status_text' => $status_text,
            'status_color' => $status_color
        ];
    }

    echo json_encode($formatted_orders);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>
