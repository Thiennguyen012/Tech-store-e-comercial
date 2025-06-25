<?php
session_start();
require_once '../../db/connect.php';

// Check if user is admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != 0) {
    http_response_code(403);
    echo json_encode(['error' => 'Access denied']);
    exit;
}

$order_id = $_GET['id'] ?? null;

if (!$order_id) {
    echo '<div class="alert alert-danger">Order ID is required</div>';
    exit;
}

try {
    // Get order details
    $stmt = $conn->prepare("
        SELECT b.*, u.name as user_name, u.email as user_email 
        FROM bill b 
        LEFT JOIN site_user u ON b.user_id = u.id 
        WHERE b.id = ?
    ");
    $stmt->execute([$order_id]);
    $order = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$order) {
        echo '<div class="alert alert-danger">Order not found</div>';
        exit;
    }
    
    // Get order items
    $stmt = $conn->prepare("SELECT * FROM checkout_cart WHERE bill_id = ?");
    $stmt->execute([$order_id]);
    $items = [];
    while ($item = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $items[] = $item;
    }
    
    $status_text = 'Pending';
    $status_color = 'warning';
    if ($order['order_status'] == 1) {
        $status_text = 'Completed';
        $status_color = 'success';
    } elseif ($order['order_status'] == 2) {
        $status_text = 'Cancelled';
        $status_color = 'danger';
    }
    
    $customer_name = $order['user_name'] ?: $order['order_name'] ?: 'Guest';
    $payment_method = $order['order_paymethod'] == 1 ? 'Online Payment' : 'Cash on Delivery';
    
    echo "<div class='row'>";
    echo "<div class='col-md-6'>";
    echo "<h5>Order Information</h5>";
    echo "<table class='table table-borderless'>";
    echo "<tr><td><strong>Order ID:</strong></td><td>#{$order['id']}</td></tr>";
    echo "<tr><td><strong>Customer:</strong></td><td>{$customer_name}</td></tr>";
    if ($order['user_email']) {
        echo "<tr><td><strong>Email:</strong></td><td>{$order['user_email']}</td></tr>";
    }
    echo "<tr><td><strong>Phone:</strong></td><td>{$order['order_phone']}</td></tr>";
    echo "<tr><td><strong>Address:</strong></td><td>{$order['order_address']}</td></tr>";
    echo "<tr><td><strong>Order Date:</strong></td><td>" . date('M d, Y H:i', strtotime($order['order_date'])) . "</td></tr>";
    echo "<tr><td><strong>Payment Method:</strong></td><td>{$payment_method}</td></tr>";
    echo "<tr><td><strong>Status:</strong></td><td><span class='badge bg-{$status_color}'>{$status_text}</span></td></tr>";
    echo "<tr><td><strong>Total:</strong></td><td><h5>$" . number_format($order['order_total'], 2) . "</h5></td></tr>";
    echo "</table>";
    echo "</div>";
    echo "</div>";
    
    echo "<hr>";
    echo "<h5>Order Items</h5>";
    echo "<div class='table-responsive'>";
    echo "<table class='table table-bordered'>";
    echo "<thead><tr><th>Product</th><th>Image</th><th>Price</th><th>Quantity</th><th>Total</th></tr></thead>";
    echo "<tbody>";
    
    foreach ($items as $item) {
        echo "<tr>";
        echo "<td>" . substr($item['product_name'], 0, 40) . (strlen($item['product_name']) > 40 ? '...' : '') . "</td>";
        echo "<td><img src='{$item['product_image']}' alt='Product' style='width: 50px; height: 50px; object-fit: cover;'></td>";
        echo "<td>$" . number_format($item['price'], 2) . "</td>";
        echo "<td>{$item['quantity']}</td>";
        echo "<td>$" . number_format($item['total'], 2) . "</td>";
        echo "</tr>";
    }
    
    echo "</tbody>";
    echo "</table>";
    echo "</div>";

} catch (Exception $e) {
    echo '<div class="alert alert-danger">Error loading order details: ' . $e->getMessage() . '</div>';
}
?>
