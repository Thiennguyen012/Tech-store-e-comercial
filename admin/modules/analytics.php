<?php
$current_page = 'analytics';
require_once '../includes/admin-layout.php';

// Check if user is admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != 0) {
    echo '<div class="alert alert-danger">Access denied</div>';
    exit;
}
?>

<div class="row mb-4">
    <div class="col-12">
        <h2>Analytics & Reports</h2>
        <p class="text-muted">View sales analytics and business reports</p>
    </div>
</div>

<!-- Analytics Overview -->
<div class="row mb-4">
    <div class="col-lg-6">
        <div class="card shadow">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Sales by Category</h6>
            </div>
            <div class="card-body">
                <canvas id="salesByCategoryChart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card shadow">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Monthly Sales Trend</h6>
            </div>
            <div class="card-body">
                <canvas id="monthlySalesChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Top Products -->
<div class="row mb-4">
    <div class="col-lg-8">
        <div class="card shadow">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Top Selling Products</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Category</th>
                                <th>Times Sold</th>
                                <th>Total Revenue</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            try {
                                $stmt = $conn->prepare("
                                    SELECT p.name, COALESCE(pc.category_name, 'Uncategorized') as category_name, 
                                           COUNT(cc.id) as times_sold,
                                           SUM(cc.quantity * cc.price) as total_revenue
                                    FROM checkout_cart cc
                                    LEFT JOIN product p ON cc.product_name = p.name
                                    LEFT JOIN product_category pc ON p.category_id = pc.id
                                    WHERE p.name IS NOT NULL
                                    GROUP BY p.id, p.name
                                    ORDER BY times_sold DESC
                                    LIMIT 10
                                ");
                                $stmt->execute();
                                
                                while ($product = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<tr>";
                                    echo "<td>" . substr($product['name'], 0, 50) . (strlen($product['name']) > 50 ? '...' : '') . "</td>";
                                    echo "<td>{$product['category_name']}</td>";
                                    echo "<td><span class='badge bg-info'>{$product['times_sold']}</span></td>";
                                    echo "<td>$" . number_format($product['total_revenue'], 2) . "</td>";
                                    echo "</tr>";
                                }
                            } catch (Exception $e) {
                                echo "<tr><td colspan='4' class='text-center text-danger'>Error loading data: {$e->getMessage()}</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card shadow">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Quick Stats</h6>
            </div>
            <div class="card-body">
                <?php
                try {
                    // Average Order Value
                    $stmt = $conn->prepare("SELECT AVG(order_total) as avg_order FROM bill");
                    $stmt->execute();
                    $avg_order = $stmt->fetch()['avg_order'];
                    
                    // Most Popular Category
                    $stmt = $conn->prepare("
                        SELECT pc.category_name, COUNT(cc.id) as count
                        FROM checkout_cart cc
                        JOIN product p ON cc.product_name = p.name
                        JOIN product_category pc ON p.category_id = pc.id
                        GROUP BY pc.id
                        ORDER BY count DESC
                        LIMIT 1
                    ");
                    $stmt->execute();
                    $popular_category = $stmt->fetch();
                    
                    // Orders This Month
                    $stmt = $conn->prepare("
                        SELECT COUNT(*) as count 
                        FROM bill 
                        WHERE MONTH(order_date) = MONTH(CURDATE()) 
                        AND YEAR(order_date) = YEAR(CURDATE())
                    ");
                    $stmt->execute();
                    $monthly_orders = $stmt->fetch()['count'];
                    
                    echo "<div class='mb-3'>";
                    echo "<h5>$" . number_format($avg_order, 2) . "</h5>";
                    echo "<small class='text-muted'>Average Order Value</small>";
                    echo "</div>";
                    
                    echo "<div class='mb-3'>";
                    echo "<h5>" . ($popular_category['category_name'] ?? 'N/A') . "</h5>";
                    echo "<small class='text-muted'>Most Popular Category</small>";
                    echo "</div>";
                    
                    echo "<div class='mb-3'>";
                    echo "<h5>{$monthly_orders}</h5>";
                    echo "<small class='text-muted'>Orders This Month</small>";
                    echo "</div>";
                    
                } catch (Exception $e) {
                    echo "<div class='alert alert-danger'>Error loading stats</div>";
                }
                ?>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity -->
<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Recent Activity</h6>
            </div>
            <div class="card-body">
                <div class="timeline">
                    <?php
                    try {
                        $stmt = $conn->prepare("
                            SELECT 'order' as type, id, order_name as name, order_date as date, order_total as amount
                            FROM bill 
                            ORDER BY order_date DESC
                            LIMIT 10
                        ");
                        $stmt->execute();
                        
                        while ($activity = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            $time_ago = date('M d, H:i', strtotime($activity['date']));
                            echo "<div class='d-flex align-items-center mb-3'>";
                            echo "<div class='flex-shrink-0'>";
                            echo "<div class='bg-primary text-white rounded-circle p-2' style='width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;'>";
                            echo "<i class='bi bi-cart-check'></i>";
                            echo "</div>";
                            echo "</div>";
                            echo "<div class='flex-grow-1 ms-3'>";
                            echo "<h6 class='mb-0'>New Order #{$activity['id']}</h6>";
                            echo "<small class='text-muted'>Customer: {$activity['name']} - Amount: $" . number_format($activity['amount'], 2) . "</small>";
                            echo "<br><small class='text-muted'>{$time_ago}</small>";
                            echo "</div>";
                            echo "</div>";
                        }
                    } catch (Exception $e) {
                        echo "<div class='alert alert-danger'>Error loading recent activity</div>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Sales by Category Chart
$.get('../api/sales-by-category.php')
    .done(function(data) {
        const categories = JSON.parse(data);
        const ctx = document.getElementById('salesByCategoryChart').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: categories.map(c => c.category),
                datasets: [{
                    data: categories.map(c => c.total),
                    backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    });

// Monthly Sales Chart
$.get('../api/monthly-sales.php')
    .done(function(data) {
        const sales = JSON.parse(data);
        const ctx = document.getElementById('monthlySalesChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: sales.map(s => s.month),
                datasets: [{
                    label: 'Sales ($)',
                    data: sales.map(s => s.total),
                    borderColor: '#4e73df',
                    backgroundColor: 'rgba(78, 115, 223, 0.1)',
                    fill: true
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>

<?php require_once '../includes/admin-layout-footer.php'; ?>
