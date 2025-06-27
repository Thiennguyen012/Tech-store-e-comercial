<?php
session_start();
require_once '../config/admin-connect.php';

// Check if user is admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != 0) {
    echo '<div class="alert alert-danger">Access denied</div>';
    exit;
}

$order_id = $_GET['id'] ?? 0;

try {
    // Get order information
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
    $stmt = $conn->prepare("
        SELECT cc.*, p.name as product_name, p.product_image 
        FROM checkout_cart cc 
        LEFT JOIN product p ON cc.product_name = p.name 
        WHERE cc.bill_id = ?
    ");
    $stmt->execute([$order_id]);
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $status_text = 'Pending';
    $status_color = 'warning';
    $status_value = $order['order_status'];
    
    // Handle both string and numeric status values
    if ($status_value === 'paid' || $status_value == 1) {
        $status_text = 'Paid';
        $status_color = 'success';
    } elseif ($status_value === 'cancelled' || $status_value == 2) {
        $status_text = 'Cancelled';
        $status_color = 'danger';
    }
    
    $customer_name = $order['user_name'] ?: $order['order_name'] ?: 'Guest';
    $payment_method = $order['order_paymethod'] == 1 ? 'Online Payment' : 'Cash on Delivery';
    
    ?>
    
    <div class="row">
        <div class="col-md-6">
            <h6>Order Information</h6>
            <table class="table table-sm">
                <tr><td><strong>Order ID:</strong></td><td>#<?php echo $order['id']; ?></td></tr>
                <tr><td><strong>Date:</strong></td><td><?php echo date('M d, Y H:i', strtotime($order['order_date'])); ?></td></tr>
                <tr><td><strong>Status:</strong></td><td><span class="badge bg-<?php echo $status_color; ?>"><?php echo $status_text; ?></span></td></tr>
                <tr><td><strong>Payment:</strong></td><td><?php echo $payment_method; ?></td></tr>
                <tr><td><strong>Total:</strong></td><td><strong>$<?php echo number_format($order['order_total'], 2); ?></strong></td></tr>
            </table>
        </div>
        <div class="col-md-6">
            <h6>Customer Information</h6>
            <table class="table table-sm">
                <tr><td><strong>Name:</strong></td><td><?php echo htmlspecialchars($customer_name); ?></td></tr>
                <?php if ($order['user_email']): ?>
                <tr><td><strong>Email:</strong></td><td><?php echo htmlspecialchars($order['user_email']); ?></td></tr>
                <?php endif; ?>
                <tr><td><strong>Phone:</strong></td><td><?php echo htmlspecialchars($order['order_phone']); ?></td></tr>
                <tr><td><strong>Address:</strong></td><td><?php echo htmlspecialchars($order['order_address']); ?></td></tr>
            </table>
        </div>
    </div>
    
    <hr>
    
    <h6>Order Items</h6>
    <div class="table-responsive">
        <table class="table table-sm">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $subtotal = 0;
                foreach ($items as $item): 
                    $item_total = $item['quantity'] * $item['price'];
                    $subtotal += $item_total;
                ?>
                <tr>
                    <td>
                        <?php if ($item['product_image']): ?>
                        <img src="<?php echo $item['product_image']; ?>" alt="Product" style="width: 40px; height: 40px; object-fit: cover;" class="me-2">
                        <?php endif; ?>
                        <?php echo htmlspecialchars($item['product_name'] ?: $item['product_name']); ?>
                    </td>
                    <td><?php echo $item['quantity']; ?></td>
                    <td>$<?php echo number_format($item['price'], 2); ?></td>
                    <td>$<?php echo number_format($item_total, 2); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3">Total:</th>
                    <th>$<?php echo number_format($order['order_total'], 2); ?></th>
                </tr>
            </tfoot>
        </table>
    </div>
    
    <?php
} catch (Exception $e) {
    echo '<div class="alert alert-danger">Error loading order details: ' . $e->getMessage() . '</div>';
}
?>
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
