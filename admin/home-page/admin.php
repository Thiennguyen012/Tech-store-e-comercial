<?php
$current_page = 'dashboard';
require_once '../includes/admin-layout.php';
?>

<!-- Dashboard content -->
<div class="row mb-4">
    <div class="col-12">
        <h2>Admin Dashboard</h2>
        <p class="text-muted">Welcome to the administration panel</p>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Products</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?php
                            try {
                                $stmt = $conn->prepare("SELECT COUNT(*) as count FROM product");
                                $stmt->execute();
                                echo $stmt->fetch()['count'];
                            } catch (Exception $e) {
                                echo "0";
                            }
                            ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-box text-primary" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Orders</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?php
                            try {
                                $stmt = $conn->prepare("SELECT COUNT(*) as count FROM bill");
                                $stmt->execute();
                                echo $stmt->fetch()['count'];
                            } catch (Exception $e) {
                                echo "0";
                            }
                            ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-cart-check text-success" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Users</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?php
                            try {
                                $stmt = $conn->prepare("SELECT COUNT(*) as count FROM site_user");
                                $stmt->execute();
                                echo $stmt->fetch()['count'];
                            } catch (Exception $e) {
                                echo "0";
                            }
                            ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-people text-info" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total Revenue</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?php
                            try {
                                $stmt = $conn->prepare("SELECT SUM(order_total) as total FROM bill");
                                $stmt->execute();
                                $result = $stmt->fetch();
                                echo "$" . number_format($result['total'] ?? 0, 2);
                            } catch (Exception $e) {
                                echo "$0.00";
                            }
                            ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-currency-dollar text-warning" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Orders -->
<div class="row">
    <div class="col-lg-8 mb-4">
        <div class="card shadow">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Recent Orders</h6>
                <a href="../modules/orders.php" class="btn btn-primary btn-sm">View All</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Customer</th>
                                <th>Total</th>
                                <th>Date</th>
                                <th>Status</th>
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
                                    LIMIT 5
                                ");
                                $stmt->execute();
                                
                                while ($order = $stmt->fetch(PDO::FETCH_ASSOC)) {
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
                                    
                                    echo "<tr>";
                                    echo "<td>#{$order['id']}</td>";
                                    echo "<td>{$customer_name}</td>";
                                    echo "<td>$" . number_format($order['order_total'], 2) . "</td>";
                                    echo "<td>" . date('M d, Y', strtotime($order['order_date'])) . "</td>";
                                    echo "<td><span class='badge bg-{$status_color}'>{$status_text}</span></td>";
                                    echo "</tr>";
                                }
                            } catch (Exception $e) {
                                echo "<tr><td colspan='5' class='text-center text-danger'>Error loading orders</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 mb-4">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Quick Actions</h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="../modules/products.php?action=add" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Add New Product
                    </a>
                    <a href="../modules/categories.php?action=add" class="btn btn-success">
                        <i class="bi bi-plus-circle"></i> Add New Category
                    </a>
                    <a href="../modules/users.php" class="btn btn-info">
                        <i class="bi bi-eye"></i> View All Users
                    </a>
                    <a href="../modules/orders.php" class="btn btn-warning">
                        <i class="bi bi-cart-check"></i> Manage Orders
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once '../includes/admin-layout-footer.php'; ?>
