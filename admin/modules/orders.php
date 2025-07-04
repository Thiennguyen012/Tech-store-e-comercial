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
                                $stmt = $conn->prepare("SELECT COUNT(*) as count FROM bill WHERE order_status IS NULL OR order_status = 'Pending'");
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
                                $stmt = $conn->prepare("SELECT COUNT(*) as count FROM bill WHERE order_status = 'Paid'");
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
                                $stmt = $conn->prepare("SELECT COUNT(*) as count FROM bill WHERE order_status = 'Cancelled'");
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

<!-- Orders Filter -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-dark">Filter Orders</h6>
            </div>
            <div class="card-body">
                <form method="GET" action="" id="filterForm">
                    <!-- First Row: Customer Name & Order Status -->
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="customer_filter" class="form-label">Customer Name</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person-search"></i></span>
                                <input type="text" 
                                       class="form-control" 
                                       id="customer_filter" 
                                       name="customer_filter" 
                                       placeholder="Search by customer name or order name..." 
                                       value="<?php echo isset($_GET['customer_filter']) ? htmlspecialchars($_GET['customer_filter']) : ''; ?>">
                                <?php if (!empty($_GET['customer_filter'])): ?>
                                    <button type="button" class="btn btn-outline-secondary" onclick="clearCustomerFilter()" title="Clear search">
                                        <i class="bi bi-x"></i>
                                    </button>
                                <?php endif; ?>
                            </div>
                            <div class="form-text">Search by registered user name or guest order name</div>
                        </div>
                        <div class="col-md-6">
                            <label for="status_filter" class="form-label">Order Status</label>
                            <select class="form-select" id="status_filter" name="status_filter">
                                <option value="">All Status</option>
                                <option value="Pending" <?php echo (isset($_GET['status_filter']) && $_GET['status_filter'] === 'Pending') ? 'selected' : ''; ?>>Pending</option>
                                <option value="Paid" <?php echo (isset($_GET['status_filter']) && $_GET['status_filter'] === 'Paid') ? 'selected' : ''; ?>>Paid</option>
                                <option value="Cancelled" <?php echo (isset($_GET['status_filter']) && $_GET['status_filter'] === 'Cancelled') ? 'selected' : ''; ?>>Cancelled</option>
                            </select>
                        </div>
                    </div>
                    
                    <!-- Second Row: Payment Method & Date Filter -->
                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label for="payment_filter" class="form-label">Payment Method</label>
                            <select class="form-select" id="payment_filter" name="payment_filter">
                                <option value="">All Payment Methods</option>
                                <option value="0" <?php echo (isset($_GET['payment_filter']) && $_GET['payment_filter'] === '0') ? 'selected' : ''; ?>>Cash on Delivery</option>
                                <option value="1" <?php echo (isset($_GET['payment_filter']) && $_GET['payment_filter'] === '1') ? 'selected' : ''; ?>>Online Payment</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="date_filter" class="form-label">Date Filter</label>
                            <select class="form-select" id="date_filter" name="date_filter">
                                <option value="">All Time</option>
                                <option value="today" <?php echo (isset($_GET['date_filter']) && $_GET['date_filter'] === 'today') ? 'selected' : ''; ?>>Today</option>
                                <option value="yesterday" <?php echo (isset($_GET['date_filter']) && $_GET['date_filter'] === 'yesterday') ? 'selected' : ''; ?>>Yesterday</option>
                                <option value="week" <?php echo (isset($_GET['date_filter']) && $_GET['date_filter'] === 'week') ? 'selected' : ''; ?>>This Week</option>
                                <option value="month" <?php echo (isset($_GET['date_filter']) && $_GET['date_filter'] === 'month') ? 'selected' : ''; ?>>This Month</option>
                            </select>
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <div class="btn-group w-100" role="group">
                                <button type="submit" class="btn btn-dark">
                                    <i class="bi bi-funnel"></i> Filter
                                </button>
                                <a href="orders.php" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-clockwise"></i> Reset
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Orders List -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-dark">
                    All Orders
                    <?php
                    // Hiển thị thông tin filter đang áp dụng
                    $active_filters = [];
                    if (!empty($_GET['customer_filter'])) {
                        $active_filters[] = "Customer: \"" . htmlspecialchars($_GET['customer_filter']) . "\"";
                    }
                    if (!empty($_GET['status_filter'])) {
                        $active_filters[] = "Status: " . $_GET['status_filter'];
                    }
                    if (isset($_GET['payment_filter']) && $_GET['payment_filter'] !== '') {
                        $payment_text = $_GET['payment_filter'] == '1' ? 'Online Payment' : 'Cash on Delivery';
                        $active_filters[] = "Payment: " . $payment_text;
                    }
                    if (!empty($_GET['date_filter'])) {
                        $active_filters[] = "Date: " . ucfirst($_GET['date_filter']);
                    }
                    if (!empty($active_filters)) {
                        echo '<small class="text-muted">(' . implode(', ', $active_filters) . ')</small>';
                    }
                    ?>
                </h6>
                <div>
                    <?php
                    // Đếm tổng số orders sau khi filter
                    $count_sql = "SELECT COUNT(*) as total FROM bill b LEFT JOIN site_user u ON b.user_id = u.id WHERE 1=1";
                    $count_params = [];

                    // Áp dụng cùng filter logic như query chính
                    // Customer name filter
                    if (!empty($_GET['customer_filter'])) {
                        $count_sql .= " AND (u.name LIKE ? OR b.order_name LIKE ?)";
                        $search_term = '%' . $_GET['customer_filter'] . '%';
                        $count_params[] = $search_term;
                        $count_params[] = $search_term;
                    }

                    if (!empty($_GET['status_filter'])) {
                        if ($_GET['status_filter'] === 'Pending') {
                            $count_sql .= " AND (b.order_status IS NULL OR b.order_status = 'Pending')";
                        } else {
                            $count_sql .= " AND b.order_status = ?";
                            $count_params[] = $_GET['status_filter'];
                        }
                    }

                    if (isset($_GET['payment_filter']) && $_GET['payment_filter'] !== '') {
                        $count_sql .= " AND b.order_paymethod = ?";
                        $count_params[] = $_GET['payment_filter'];
                    }

                    if (!empty($_GET['date_filter'])) {
                        switch ($_GET['date_filter']) {
                            case 'today':
                                $count_sql .= " AND DATE(b.order_date) = CURDATE()";
                                break;
                            case 'yesterday':
                                $count_sql .= " AND DATE(b.order_date) = DATE_SUB(CURDATE(), INTERVAL 1 DAY)";
                                break;
                            case 'week':
                                $count_sql .= " AND WEEK(b.order_date) = WEEK(CURDATE()) AND YEAR(b.order_date) = YEAR(CURDATE())";
                                break;
                            case 'month':
                                $count_sql .= " AND MONTH(b.order_date) = MONTH(CURDATE()) AND YEAR(b.order_date) = YEAR(CURDATE())";
                                break;
                        }
                    }

                    try {
                        $count_stmt = $conn->prepare($count_sql);
                        if (!empty($count_params)) {
                            $count_stmt->execute($count_params);
                        } else {
                            $count_stmt->execute();
                        }
                        $total_orders = $count_stmt->fetchColumn();
                        echo "<span class='badge bg-dark'>{$total_orders} orders</span>";
                    } catch (Exception $e) {
                        echo "<span class='badge bg-danger'>Error</span>";
                    }
                    ?>
                </div>
            </div>
            <div class="card-body">
                <!-- Mobile-friendly order cards (visible only on small screens) -->
                <div class="d-block d-md-none">
                    <?php
                    // Build filter query
                    $sql = "SELECT b.*, u.name as user_name 
                            FROM bill b 
                            LEFT JOIN site_user u ON b.user_id = u.id 
                            WHERE 1=1";
                    $params = [];

                    // Customer name filter
                    if (!empty($_GET['customer_filter'])) {
                        $sql .= " AND (u.name LIKE ? OR b.order_name LIKE ?)";
                        $search_term = '%' . $_GET['customer_filter'] . '%';
                        $params[] = $search_term;
                        $params[] = $search_term;
                    }

                    // Status filter
                    if (!empty($_GET['status_filter'])) {
                        if ($_GET['status_filter'] === 'Pending') {
                            $sql .= " AND (b.order_status IS NULL OR b.order_status = 'Pending')";
                        } else {
                            $sql .= " AND b.order_status = ?";
                            $params[] = $_GET['status_filter'];
                        }
                    }

                    // Payment method filter
                    if (isset($_GET['payment_filter']) && $_GET['payment_filter'] !== '') {
                        $sql .= " AND b.order_paymethod = ?";
                        $params[] = $_GET['payment_filter'];
                    }

                    // Date filter
                    if (!empty($_GET['date_filter'])) {
                        switch ($_GET['date_filter']) {
                            case 'today':
                                $sql .= " AND DATE(b.order_date) = CURDATE()";
                                break;
                            case 'yesterday':
                                $sql .= " AND DATE(b.order_date) = DATE_SUB(CURDATE(), INTERVAL 1 DAY)";
                                break;
                            case 'week':
                                $sql .= " AND WEEK(b.order_date) = WEEK(CURDATE()) AND YEAR(b.order_date) = YEAR(CURDATE())";
                                break;
                            case 'month':
                                $sql .= " AND MONTH(b.order_date) = MONTH(CURDATE()) AND YEAR(b.order_date) = YEAR(CURDATE())";
                                break;
                        }
                    }

                    $sql .= " ORDER BY b.order_date DESC";

                    try {
                        $stmt = $conn->prepare($sql);
                        $stmt->execute($params);

                        while ($order = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            $status_text = 'Pending';
                            $status_color = 'warning';
                            $status_value = $order['order_status'];

                            if ($status_value === 'Paid') {
                                $status_text = 'Paid';
                                $status_color = 'success';
                                $status_value = 'Paid';
                            } elseif ($status_value === 'Cancelled') {
                                $status_text = 'Cancelled';
                                $status_color = 'danger';
                                $status_value = 'Cancelled';
                            } else {
                                $status_value = 'Pending';
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
                                            <option value="Pending" <?php echo $status_value == 'Pending' ? ' selected' : ''; ?>>Pending</option>
                                            <option value="Paid" <?php echo $status_value == 'Paid' ? ' selected' : ''; ?>>Paid</option>
                                            <option value="Cancelled" <?php echo $status_value == 'Cancelled' ? ' selected' : ''; ?>>Cancelled</option>
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
                                // Build same filter query for desktop table
                                $sql = "SELECT b.*, u.name as user_name 
                                        FROM bill b 
                                        LEFT JOIN site_user u ON b.user_id = u.id 
                                        WHERE 1=1";
                                $params = [];

                                // Customer name filter
                                if (!empty($_GET['customer_filter'])) {
                                    $sql .= " AND (u.name LIKE ? OR b.order_name LIKE ?)";
                                    $search_term = '%' . $_GET['customer_filter'] . '%';
                                    $params[] = $search_term;
                                    $params[] = $search_term;
                                }

                                // Status filter
                                if (!empty($_GET['status_filter'])) {
                                    if ($_GET['status_filter'] === 'Pending') {
                                        $sql .= " AND (b.order_status IS NULL OR b.order_status = 'Pending')";
                                    } else {
                                        $sql .= " AND b.order_status = ?";
                                        $params[] = $_GET['status_filter'];
                                    }
                                }

                                // Payment method filter
                                if (isset($_GET['payment_filter']) && $_GET['payment_filter'] !== '') {
                                    $sql .= " AND b.order_paymethod = ?";
                                    $params[] = $_GET['payment_filter'];
                                }

                                // Date filter
                                if (!empty($_GET['date_filter'])) {
                                    switch ($_GET['date_filter']) {
                                        case 'today':
                                            $sql .= " AND DATE(b.order_date) = CURDATE()";
                                            break;
                                        case 'yesterday':
                                            $sql .= " AND DATE(b.order_date) = DATE_SUB(CURDATE(), INTERVAL 1 DAY)";
                                            break;
                                        case 'week':
                                            $sql .= " AND WEEK(b.order_date) = WEEK(CURDATE()) AND YEAR(b.order_date) = YEAR(CURDATE())";
                                            break;
                                        case 'month':
                                            $sql .= " AND MONTH(b.order_date) = MONTH(CURDATE()) AND YEAR(b.order_date) = YEAR(CURDATE())";
                                            break;
                                    }
                                }

                                $sql .= " ORDER BY b.order_date DESC";

                                try {
                                    $stmt = $conn->prepare($sql);
                                    $stmt->execute($params);

                                    while ($order = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        $status_text = 'Pending';
                                        $status_color = 'warning';
                                        $status_value = $order['order_status'];

                                        if ($status_value === 'Paid') {
                                            $status_text = 'Paid';
                                            $status_color = 'success';
                                            $status_value = 'Paid';
                                        } elseif ($status_value === 'Cancelled') {
                                            $status_text = 'Cancelled';
                                            $status_color = 'danger';
                                            $status_value = 'Cancelled';
                                        } else {
                                            $status_value = 'Pending';
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
                                        echo "<option value='Pending'" . ($status_value == 'Pending' ? ' selected' : '') . ">Pending</option>";
                                        echo "<option value='Paid'" . ($status_value == 'Paid' ? ' selected' : '') . ">Paid</option>";
                                        echo "<option value='Cancelled'" . ($status_value == 'Cancelled' ? ' selected' : '') . ">Cancelled</option>";
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
    // Auto-submit form when filter changes
    document.addEventListener('DOMContentLoaded', function() {
        // Mark orders as viewed when page loads
        markOrdersAsViewed();
        
        const filterSelects = document.querySelectorAll('#status_filter, #payment_filter, #date_filter');
        const customerInput = document.getElementById('customer_filter');
        
        // Auto-submit for select fields
        filterSelects.forEach(function(select) {
            select.addEventListener('change', function() {
                submitFilterForm();
            });
        });
        
        // Debounced search for customer input
        let customerSearchTimeout;
        if (customerInput) {
            customerInput.addEventListener('input', function() {
                clearTimeout(customerSearchTimeout);
                customerSearchTimeout = setTimeout(function() {
                    if (customerInput.value.length >= 2 || customerInput.value.length === 0) {
                        submitFilterForm();
                    }
                }, 500); // Wait 500ms after user stops typing
            });
            
            // Submit on Enter key
            customerInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    clearTimeout(customerSearchTimeout);
                    submitFilterForm();
                }
            });
        }
        
        function submitFilterForm() {
            const submitBtn = document.querySelector('#filterForm button[type="submit"]');
            if (submitBtn) {
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="bi bi-hourglass-split"></i> Filtering...';
                submitBtn.disabled = true;
            }
            document.getElementById('filterForm').submit();
        }
        
        // Add tooltips to filter options
        const tooltips = {
            'customer_filter': 'Search by customer name or order name (min 2 characters)',
            'status_filter': 'Filter orders by their current status',
            'payment_filter': 'Filter by payment method used',
            'date_filter': 'Filter orders by date range'
        };
        
        Object.keys(tooltips).forEach(function(id) {
            const element = document.getElementById(id);
            if (element) {
                element.setAttribute('title', tooltips[id]);
            }
        });
    });

    // Mark orders as viewed and remove badge
    function markOrdersAsViewed() {
        $.post('orders-ajax.php', {
            action: 'mark_orders_viewed'
        })
        .done(function(response) {
            try {
                const result = JSON.parse(response);
                if (result.success) {
                    // Remove the badge from sidebar
                    const badge = document.getElementById('new-orders-badge');
                    if (badge) {
                        badge.style.transition = 'all 0.3s ease';
                        badge.style.opacity = '0';
                        badge.style.transform = 'scale(0)';
                        setTimeout(function() {
                            badge.remove();
                        }, 300);
                    }
                }
            } catch (e) {
                console.log('Non-critical error updating view status');
            }
        })
        .fail(function() {
            console.log('Non-critical error updating view status');
        });
    }

    // Clear customer filter function
    function clearCustomerFilter() {
        const customerInput = document.getElementById('customer_filter');
        if (customerInput) {
            customerInput.value = '';
            // Trigger form submission to apply the change
            document.getElementById('filterForm').submit();
        }
    }

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
            <div class="spinner-border spinner-border-sm text-dark" role="status">
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
            data: {
                id: orderId
            },
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