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
    // Get total products
    $stmt = $conn->prepare("SELECT COUNT(*) as total_products FROM product");
    $stmt->execute();
    $products = $stmt->fetch()['total_products'];

    // Get total orders
    $stmt = $conn->prepare("SELECT COUNT(*) as total_orders FROM bill");
    $stmt->execute();
    $orders = $stmt->fetch()['total_orders'];

    // Get total users (excluding admins)
    $stmt = $conn->prepare("SELECT COUNT(*) as total_users FROM site_user WHERE role = 1");
    $stmt->execute();
    $users = $stmt->fetch()['total_users'];

    // Get total revenue
    $stmt = $conn->prepare("SELECT SUM(order_total) as total_revenue FROM bill");
    $stmt->execute();
    $revenue = $stmt->fetch()['total_revenue'] ?? 0;

    $stats = [
        'total_products' => $products,
        'total_orders' => $orders,
        'total_users' => $users,
        'total_revenue' => number_format($revenue, 2)
    ];

    echo json_encode($stats);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>
