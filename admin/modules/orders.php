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
    <div class="col-xl-3 col-md-6 col-sm-6 mb-3">
        <div class="card h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">Pending Orders</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?php
                            try {
                                $stmt = $conn->prepare("SELECT COUNT(*) as count FROM bill WHERE order_status IS NULL OR order_status = 'pending' OR order_status = 0");
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
    <div class="col-xl-3 col-md-6 col-sm-6 mb-3">
        <div class="card h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">Paid Orders</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?php
                            try {
                                $stmt = $conn->prepare("SELECT COUNT(*) as count FROM bill WHERE order_status = 'paid' OR order_status = 1");
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
    <div class="col-xl-3 col-md-6 col-sm-6 mb-3">
        <div class="card h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">Cancelled Orders</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?php
                            try {
                                $stmt = $conn->prepare("SELECT COUNT(*) as count FROM bill WHERE order_status = 'cancelled' OR order_status = 2");
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
    <div class="col-xl-3 col-md-6 col-sm-6 mb-3">
        <div class="card h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">Today's Orders</div>
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
        <div class="card">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-dark">All Orders</h6>
            </div>
            <div class="card-body">
                <!-- Mobile-friendly order cards (visible only on small screens) -->
                <div class="d-block d-md-none">
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
                            $status_value = $order['order_status'];
                            
                            if ($status_value === 'paid' || $status_value == 1) {
                                $status_text = 'Paid';
                                $status_color = 'success';
                                $status_value = 'paid';
                            } elseif ($status_value === 'cancelled' || $status_value == 2) {
                                $status_text = 'Cancelled';
                                $status_color = 'danger';
                                $status_value = 'cancelled';
                            } else {
                                $status_value = 'pending';
                                $status_color = 'secondary';
                            }
                            
                            $customer_name = $order['user_name'] ?: $order['order_name'] ?: 'Guest';
                            $payment_method = $order['order_paymethod'] == 1 ? 'Online Payment' : 'Cash on Delivery';
                            ?>
                            <div class="card mb-3 border">
                                <div class="card-body p-3">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h6 class="card-title mb-0 text-dark">Order #<?php echo $order['id']; ?></h6>
                                        <span class="badge bg-<?php echo $status_color; ?>"><?php echo $status_text; ?></span>
                                    </div>
                                    <div class="text-muted small mb-2">
                                        <div class="mb-1"><strong>Customer:</strong> <?php echo htmlspecialchars($customer_name); ?></div>
                                        <div class="mb-1"><strong>Phone:</strong> <?php echo htmlspecialchars($order['order_phone']); ?></div>
                                        <div class="mb-1"><strong>Total:</strong> <span class="fw-bold text-dark">$<?php echo number_format($order['order_total'], 2); ?></span></div>
                                        <div class="mb-1"><strong>Date:</strong> <?php echo date('M d, Y H:i', strtotime($order['order_date'])); ?></div>
                                        <div class="mb-1"><strong>Payment:</strong> <?php echo $payment_method; ?></div>
                                    </div>
                                    <div class="d-grid gap-2">
                                        <button class="btn btn-outline-dark btn-sm" onclick="viewOrderDetails(<?php echo $order['id']; ?>)">
                                            <i class="bi bi-eye"></i> View Details
                                        </button>
                                        <select class="form-select form-select-sm" onchange="updateOrderStatus(<?php echo $order['id']; ?>, this.value)">
                                            <option value="pending"<?php echo $status_value == 'pending' ? ' selected' : ''; ?>>Pending</option>
                                            <option value="paid"<?php echo $status_value == 'paid' ? ' selected' : ''; ?>>Paid</option>
                                            <option value="cancelled"<?php echo $status_value == 'cancelled' ? ' selected' : ''; ?>>Cancelled</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    } catch (Exception $e) {
                        echo '<div class="alert alert-danger">Error loading orders: ' . $e->getMessage() . '</div>';
                    }
                    ?>
                </div>

                <!-- Desktop table (hidden on small screens) -->
                <div class="d-none d-md-block">
                    <div class="table-responsive">
                        <table class="table table-hover" id="ordersTable">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Customer</th>
                                    <th class="d-none d-lg-table-cell">Phone</th>
                                    <th class="d-none d-lg-table-cell">Address</th>
                                    <th>Total</th>
                                    <th class="d-none d-lg-table-cell">Date</th>
                                    <th class="d-none d-lg-table-cell">Payment</th>
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
                                        $status_value = $order['order_status'];
                                        
                                        if ($status_value === 'paid' || $status_value == 1) {
                                            $status_text = 'Paid';
                                            $status_color = 'success';
                                            $status_value = 'paid';
                                        } elseif ($status_value === 'cancelled' || $status_value == 2) {
                                            $status_text = 'Cancelled';
                                            $status_color = 'danger';
                                            $status_value = 'cancelled';
                                        } else {
                                            $status_value = 'pending';
                                            $status_color = 'secondary';
                                        }
                                        
                                        $customer_name = $order['user_name'] ?: $order['order_name'] ?: 'Guest';
                                        $payment_method = $order['order_paymethod'] == 1 ? 'Online' : 'COD';
                                        
                                        echo "<tr>";
                                        echo "<td>#{$order['id']}</td>";
                                        echo "<td class='text-truncate' style='max-width: 120px;'>" . htmlspecialchars($customer_name) . "</td>";
                                        echo "<td class='d-none d-lg-table-cell'>" . htmlspecialchars($order['order_phone']) . "</td>";
                                        echo "<td class='d-none d-lg-table-cell text-truncate' style='max-width: 150px;'>" . htmlspecialchars(substr($order['order_address'], 0, 30)) . (strlen($order['order_address']) > 30 ? '...' : '') . "</td>";
                                        echo "<td class='fw-bold'>$" . number_format($order['order_total'], 2) . "</td>";
                                        echo "<td class='d-none d-lg-table-cell'>" . date('M d, Y', strtotime($order['order_date'])) . "<br><small class='text-muted'>" . date('H:i', strtotime($order['order_date'])) . "</small></td>";
                                        echo "<td class='d-none d-lg-table-cell'><span class='badge bg-secondary'>{$payment_method}</span></td>";
                                        echo "<td><span class='badge bg-{$status_color}'>{$status_text}</span></td>";
                                        echo "<td>";
                                        echo "<div class='btn-group btn-group-sm' role='group'>";
                                        echo "<button class='btn btn-outline-dark' onclick='viewOrderDetails({$order['id']})' title='View Details'><i class='bi bi-eye'></i></button>";
                                        echo "<select class='form-select form-select-sm' onchange='updateOrderStatus({$order['id']}, this.value)' style='width: auto; min-width: 100px;'>";
                                        echo "<option value='pending'" . ($status_value == 'pending' ? ' selected' : '') . ">Pending</option>";
                                        echo "<option value='paid'" . ($status_value == 'paid' ? ' selected' : '') . ">Paid</option>";
                                        echo "<option value='cancelled'" . ($status_value == 'cancelled' ? ' selected' : '') . ">Cancelled</option>";
                                        echo "</select>";
                                        echo "</div>";
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
    console.log('Loading order details for ID:', orderId);
    
    // Validate order ID
    if (!orderId || isNaN(orderId)) {
        alert('Invalid order ID');
        return;
    }
    
    $('#orderDetailsContent').html(`
        <div class="text-center py-3">
            <div class="spinner-border spinner-border-sm text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <div class="mt-2">Loading order details...</div>
        </div>
    `);
    $('#orderDetailsModal').modal('show');
    
    // Make AJAX request with better error handling
    $.ajax({
        url: '../api/order-details.php',
        type: 'GET',
        data: { id: orderId },
        timeout: 10000, // 10 second timeout
        success: function(data) {
            console.log('Order details loaded successfully');
            $('#orderDetailsContent').html(data);
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error:', {
                status: status,
                error: error,
                responseText: xhr.responseText
            });
            
            let errorMessage = 'Error loading order details.';
            if (status === 'timeout') {
                errorMessage = 'Request timed out. Please try again.';
            } else if (xhr.status === 404) {
                errorMessage = 'Order details not found.';
            } else if (xhr.status === 403) {
                errorMessage = 'Access denied.';
            }
            
            $('#orderDetailsContent').html(`
                <div class="alert alert-danger">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    ${errorMessage}
                    <button type="button" class="btn btn-sm btn-outline-danger ms-2" onclick="viewOrderDetails(${orderId})">
                        Try Again
                    </button>
                </div>
            `);
        }
    });
}
</script>

<?php require_once '../includes/admin-layout-footer.php'; ?>
