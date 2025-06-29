<?php
// Clean output buffer and turn off error reporting for production
ob_start();
error_reporting(0);
ini_set('display_errors', 0);

session_start();
require_once '../config/admin-connect.php';

// Check if user is admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != 0) {
    echo '<div class="alert alert-danger">Access denied</div>';
    exit;
}

// Validate order ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo '<div class="alert alert-danger">Invalid order ID</div>';
    exit;
}

$order_id = (int)$_GET['id'];

try {
    // Verify database connection
    if (!$conn) {
        throw new Exception('Database connection not available');
    }
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
        echo '<div class="alert alert-warning">Order #' . $order_id . ' not found in the database.</div>';
        exit;
    }
    
    // Debug: Log successful order fetch
    error_log("Order details loaded successfully for ID: " . $order_id);
    
    // Get order items from checkout_cart table
    $stmt = $conn->prepare("
        SELECT cc.*, p.name as product_name, p.product_image 
        FROM checkout_cart cc 
        LEFT JOIN product p ON cc.product_name = p.name 
        WHERE cc.bill_id = ?
    ");
    $stmt->execute([$order_id]);
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Debug: Log items count
    error_log("Found " . count($items) . " items for order ID: " . $order_id);
    
    // Handle status display
    $status_text = 'Pending';
    $status_color = 'secondary';
    $status_value = $order['order_status'];
    
    if ($status_value === 'paid' || $status_value == 1) {
        $status_text = 'Paid';
        $status_color = 'success';
    } elseif ($status_value === 'cancelled' || $status_value == 2) {
        $status_text = 'Cancelled';
        $status_color = 'danger';
    }
    
    $customer_name = $order['user_name'] ?: ($order['order_name'] ?: 'Guest');
    $customer_email = $order['user_email'] ?: ($order['order_email'] ?: 'N/A');
    $payment_method = ($order['order_paymethod'] == 1) ? 'Online Payment' : 'Cash on Delivery';
    
    // Ensure order_total is not null
    $order_total = isset($order['order_total']) ? (float)$order['order_total'] : 0;
    
    ?>
    
    <div class="row">
        <div class="col-md-6 mb-3">
            <h6 class="mb-3">Order Information</h6>
            <div class="table-responsive">
                <table class="table table-sm table-borderless">
                    <tr>
                        <td class="fw-bold" style="width: 40%;">Order ID:</td>
                        <td>#<?php echo $order['id']; ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Order Date:</td>
                        <td><?php echo date('M d, Y H:i', strtotime($order['order_date'])); ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Status:</td>
                        <td><span class="badge bg-<?php echo $status_color; ?>"><?php echo $status_text; ?></span></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Payment Method:</td>
                        <td><?php echo $payment_method; ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Total Amount:</td>
                        <td class="fw-bold text-dark">$<?php echo number_format($order_total, 2); ?></td>
                    </tr>
                </table>
            </div>
        </div>
        
        <div class="col-md-6 mb-3">
            <h6 class="mb-3">Customer Information</h6>
            <div class="table-responsive">
                <table class="table table-sm table-borderless">
                    <tr>
                        <td class="fw-bold" style="width: 40%;">Customer:</td>
                        <td><?php echo htmlspecialchars($customer_name); ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Email:</td>
                        <td><?php echo htmlspecialchars($customer_email); ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Phone:</td>
                        <td><?php echo htmlspecialchars($order['order_phone'] ?? 'N/A'); ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Address:</td>
                        <td><?php echo htmlspecialchars($order['order_address'] ?? 'N/A'); ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    
    <hr class="my-3">
    
    <div class="row">
        <div class="col-12">
            <h6 class="mb-3">Order Items</h6>
            <?php if (!empty($items)): ?>
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead class="table-light">
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $calculated_total = 0;
                            foreach ($items as $item): 
                                $item_total = $item['quantity'] * $item['price'];
                                $calculated_total += $item_total;
                                $product_name = $item['product_name'] ?: 'Product';
                            ?>
                            <tr>
                                <td>
                                    <div class="fw-bold"><?php echo htmlspecialchars($product_name); ?></div>
                                    <small class="text-muted d-md-none">Qty: <?php echo $item['quantity']; ?> × $<?php echo number_format($item['price'], 2); ?></small>
                                </td>
                                <td class="d-none d-md-table-cell">$<?php echo number_format($item['price'], 2); ?></td>
                                <td class="d-none d-md-table-cell"><?php echo $item['quantity']; ?></td>
                                <td class="fw-bold">$<?php echo number_format($item_total, 2); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <th colspan="3" class="text-end">Total:</th>
                                <th class="fw-bold">$<?php echo number_format($order_total, 2); ?></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            <?php else: ?>
                <div class="alert alert-info">
                    <i class="bi bi-info-circle me-2"></i>
                    No items found for this order. This might be due to data migration or the order being placed through a different system.
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <?php
} catch (Exception $e) {
    // Log error for debugging but show user-friendly message
    error_log('Order Details Error: ' . $e->getMessage());
    echo '<div class="alert alert-danger">';
    echo '<i class="bi bi-exclamation-triangle me-2"></i>';
    echo 'Unable to load order details. Please try again later.';
    echo '</div>';
} catch (PDOException $e) {
    // Database specific errors
    error_log('Database Error in Order Details: ' . $e->getMessage());
    echo '<div class="alert alert-danger">';
    echo '<i class="bi bi-exclamation-triangle me-2"></i>';
    echo 'Database error occurred. Please try again later.';
    echo '</div>';
}

// Clean up output buffer
ob_end_flush();
?>
