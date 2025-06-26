<?php
$current_page = 'orders';
require_once '../includes/admin-layout.php';

// Check if user is admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != 0) {
    echo '<div class="alert alert-danger">Access denied</div>';
    exit;
}
?>

<div class="row mb-4">
    <div class="col-12">
        <h2>Order Management</h2>
        <p class="text-muted">Manage customer orders</p>
    </div>
</div>

<!-- Order Statistics -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Pending Orders</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?php
                            try {
                                $stmt = $conn->prepare("SELECT COUNT(*) as count FROM bill WHERE order_status IS NULL OR order_status = 0");
                                $stmt->execute();
                                echo $stmt->fetch()['count'];
                            } catch (Exception $e) {
                                echo "Error";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Completed Orders</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?php
                            try {
                                $stmt = $conn->prepare("SELECT COUNT(*) as count FROM bill WHERE order_status = 1");
                                $stmt->execute();
                                echo $stmt->fetch()['count'];
                            } catch (Exception $e) {
                                echo "Error";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Cancelled Orders</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?php
                            try {
                                $stmt = $conn->prepare("SELECT COUNT(*) as count FROM bill WHERE order_status = 2");
                                $stmt->execute();
                                echo $stmt->fetch()['count'];
                            } catch (Exception $e) {
                                echo "Error";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Today's Orders</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?php
                            try {
                                $stmt = $conn->prepare("SELECT COUNT(*) as count FROM bill WHERE DATE(order_date) = CURDATE()");
                                $stmt->execute();
                                echo $stmt->fetch()['count'];
                            } catch (Exception $e) {
                                echo "Error";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Orders List -->
<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">All Orders</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="ordersTable">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Customer</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>Total</th>
                                <th>Date</th>
                                <th>Payment</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            try {
                                $stmt = $conn->prepare("
                                    SELECT b.*, u.name as user_name 
                                    FROM bill b 
                                    LEFT JOIN site_user u ON b.user_id = u.id 
                                    ORDER BY b.order_date DESC
                                ");
                                $stmt->execute();
                                
                                while ($order = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    $status_text = 'Pending';
                                    $status_color = 'warning';
                                    $status_value = $order['order_status'] ?? 0;
                                    
                                    if ($status_value == 1) {
                                        $status_text = 'Completed';
                                        $status_color = 'success';
                                    } elseif ($status_value == 2) {
                                        $status_text = 'Cancelled';
                                        $status_color = 'danger';
                                    }
                                    
                                    $customer_name = $order['user_name'] ?: $order['order_name'] ?: 'Guest';
                                    $payment_method = $order['order_paymethod'] == 1 ? 'Online' : 'Cash on Delivery';
                                    
                                    echo "<tr>";
                                    echo "<td>#{$order['id']}</td>";
                                    echo "<td>{$customer_name}</td>";
                                    echo "<td>{$order['order_phone']}</td>";
                                    echo "<td>" . substr($order['order_address'], 0, 30) . (strlen($order['order_address']) > 30 ? '...' : '') . "</td>";
                                    echo "<td>$" . number_format($order['order_total'], 2) . "</td>";
                                    echo "<td>" . date('M d, Y H:i', strtotime($order['order_date'])) . "</td>";
                                    echo "<td><span class='badge bg-info'>{$payment_method}</span></td>";
                                    echo "<td><span class='badge bg-{$status_color}'>{$status_text}</span></td>";
                                    echo "<td>";
                                    echo "<button class='btn btn-sm btn-primary me-1' onclick='viewOrderDetails({$order['id']})'>View</button>";
                                    echo "<select class='form-select form-select-sm d-inline w-auto' onchange='updateOrderStatus({$order['id']}, this.value)'>";
                                    echo "<option value='0'" . ($status_value == 0 ? ' selected' : '') . ">Pending</option>";
                                    echo "<option value='1'" . ($status_value == 1 ? ' selected' : '') . ">Completed</option>";
                                    echo "<option value='2'" . ($status_value == 2 ? ' selected' : '') . ">Cancelled</option>";
                                    echo "</select>";
                                    echo "</td>";
                                    echo "</tr>";
                                }
                            } catch (Exception $e) {
                                echo "<tr><td colspan='9' class='text-center text-danger'>Error loading orders: {$e->getMessage()}</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Order Details Modal -->
<div class="modal fade" id="orderDetailsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Order Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="orderDetailsContent">
                Loading...
            </div>
        </div>
    </div>
</div>

<script>
function updateOrderStatus(orderId, status) {
    console.log('Updating order status:', orderId, status);
    
    $.post('orders-ajax.php', {
        action: 'update_status',
        order_id: orderId,
        status: status
    })
    .done(function(response) {
        console.log('Server response:', response);
        try {
            const result = JSON.parse(response);
            if (result.success) {
                // Show success message
                const alertDiv = $('<div class="alert alert-success alert-dismissible fade show" role="alert">' +
                    result.message +
                    '<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>');
                $('#admin-content').prepend(alertDiv);
                
                // Auto dismiss after 3 seconds
                setTimeout(function() {
                    alertDiv.remove();
                }, 3000);
                
                // Reload the page to show updated status
                setTimeout(function() {
                    location.reload();
                }, 1000);
            } else {
                alert('Error: ' + result.message);
            }
        } catch (e) {
            console.error('Parse error:', e);
            console.error('Raw response:', response);
            alert('Error updating order status');
        }
    })
    .fail(function(xhr, status, error) {
        console.error('AJAX error:', status, error);
        alert('Error updating order status');
    });
}

function viewOrderDetails(orderId) {
    $('#orderDetailsContent').html('Loading...');
    $('#orderDetailsModal').modal('show');
    
    $.get('../api/order-details.php?id=' + orderId)
        .done(function(data) {
            $('#orderDetailsContent').html(data);
        })
        .fail(function() {
            $('#orderDetailsContent').html('<div class="alert alert-danger">Error loading order details</div>');
        });
}
</script>

<?php require_once '../includes/admin-layout-footer.php'; ?>
