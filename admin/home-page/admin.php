<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../asset/admin-style.css">

</head>

<body>
    <?php
    session_start();

    if (!isset($_SESSION['role'])) {
        echo '
    <div class="main container mt-5 mb-5 py-5">
            <div class="row mb-3">
                <div class="col-12 col-sm-12 col-md-12 col-lg-3"></div>

                <div class="col-12 col-sm-12 col-md-12 col-lg-6">
                    <div class="main-img text-center">
                        <img src="../../img/access-denied.png" alt="Main" class="img-fluid pb-3" style="max-width: 300px;">

                        <h2>Access Denied</h2>
                        <p>You must <a href="../../login.php" class="alert-link">log in</a> to access this page.</p>
                    </div>
                </div>

                <div class="col-12 col-sm-12 col-md-12 col-lg-3"></div>
            </div>
        </div>';
        exit;
    }

    if ($_SESSION['role'] != 0) {
        echo '
    <div class="main container mt-5 mb-5 py-5">
            <div class="row mb-3">
                <div class="col-12 col-sm-12 col-md-12 col-lg-3"></div>

                <div class="col-12 col-sm-12 col-md-12 col-lg-6">
                    <div class="main-img text-center">
                        <img src="../../img/access-denied.png" alt="Main" class="img-fluid pb-3" style="max-width: 300px;">

                        <h2>Access Denied</h2>
                        <p class="main-description pt-2">You do not have permission to access this page.</p>
                        <button class="btn btn-dark rounded-5 w-25" onclick="location.href=\'../../index.php\'">Go Home</button>
                    </div>
                </div>

                <div class="col-12 col-sm-12 col-md-12 col-lg-3"></div>
            </div>
        </div>';
        exit;
    }
    ?>
    <div class="d-flex">
        <!-- Sidebar -->
        <!-- Sidebar -->
        <div id="sidebar" class="bg-dark text-white p-3 sidebar d-flex flex-column justify-content-between">
            <!-- Header -->
            <div>
                <div class="d-flex justify-content-between align-items-center mb-4 sidebar-header">
                    <h5 class="mb-0 title">Admin</h5>
                    <span id="toggleSidebar" class="sidebar-toggle text-white">&#9776;</span>
                </div>                <!-- Menu -->
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a href="../../index.php" class="nav-link text-white"><i class="bi bi-house-door"></i> <span>Go to Website</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="#" onclick="loadAdminPage('dashboard')" class="nav-link text-white active"><i class="bi bi-speedometer2"></i> <span>Dashboard</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="#" onclick="loadAdminPage('users')" class="nav-link text-white"><i class="bi bi-people"></i> <span>Users</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="#" onclick="loadAdminPage('products')" class="nav-link text-white"><i class="bi bi-box"></i> <span>Products</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="#" onclick="loadAdminPage('categories')" class="nav-link text-white"><i class="bi bi-tags"></i> <span>Categories</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="#" onclick="loadAdminPage('orders')" class="nav-link text-white"><i class="bi bi-cart-check"></i> <span>Orders</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="#" onclick="loadAdminPage('services')" class="nav-link text-white"><i class="bi bi-tools"></i> <span>Services</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="#" onclick="loadAdminPage('analytics')" class="nav-link text-white"><i class="bi bi-graph-up"></i> <span>Analytics</span></a>
                    </li>
                </ul>
            </div>

            <!-- Logout -->
            <div class="mt-auto">
                <a href="../../Logout.php" class="nav-link text-white"><i class="bi bi-box-arrow-right"></i> <span>Logout</span></a>
            </div>
        </div>        <!-- Main content -->
        <div class="content flex-fill p-4">
            <div id="admin-content">
                <!-- Dashboard content will be loaded here -->
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
                                        <div class="h5 mb-0 font-weight-bold text-gray-800" id="total-products">-</div>
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
                                        <div class="h5 mb-0 font-weight-bold text-gray-800" id="total-orders">-</div>
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
                                        <div class="h5 mb-0 font-weight-bold text-gray-800" id="total-users">-</div>
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
                                        <div class="h5 mb-0 font-weight-bold text-gray-800" id="total-revenue">-</div>
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
                                <a href="#" onclick="loadAdminPage('orders')" class="btn btn-primary btn-sm">View All</a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="recent-orders-table">
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
                                            <!-- Recent orders will be loaded here -->
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
                                    <button class="btn btn-primary" onclick="loadAdminPage('products', 'add')">
                                        <i class="bi bi-plus-circle"></i> Add New Product
                                    </button>
                                    <button class="btn btn-success" onclick="loadAdminPage('categories', 'add')">
                                        <i class="bi bi-plus-circle"></i> Add New Category
                                    </button>
                                    <button class="btn btn-info" onclick="loadAdminPage('users')">
                                        <i class="bi bi-eye"></i> View All Users
                                    </button>
                                    <button class="btn btn-warning" onclick="loadAdminPage('orders')">
                                        <i class="bi bi-cart-check"></i> Manage Orders
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>    <!-- Bootstrap + Icons + JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    
    <style>
        .border-left-primary { border-left: .25rem solid #4e73df !important; }
        .border-left-success { border-left: .25rem solid #1cc88a !important; }
        .border-left-info { border-left: .25rem solid #36b9cc !important; }
        .border-left-warning { border-left: .25rem solid #f6c23e !important; }
        .text-primary { color: #4e73df !important; }
        .text-success { color: #1cc88a !important; }
        .text-info { color: #36b9cc !important; }
        .text-warning { color: #f6c23e !important; }
        .nav-link.active { background-color: rgba(255, 255, 255, 0.1) !important; }
    </style>
    
    <script>
        const sidebar = document.getElementById('sidebar');
        const toggleBtn = document.getElementById('toggleSidebar');

        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
        });

        // Function to load different admin pages
        function loadAdminPage(page, action = '') {
            // Remove active class from all nav links
            document.querySelectorAll('.nav-link').forEach(link => {
                link.classList.remove('active');
            });
            
            // Add active class to clicked link
            event.target.closest('.nav-link').classList.add('active');
            
            const contentDiv = document.getElementById('admin-content');
            
            // Define the file paths for different pages
            let filePath = '';
            switch(page) {
                case 'dashboard':
                    loadDashboard();
                    return;
                case 'users':
                    filePath = '../modules/users.php';
                    break;
                case 'products':
                    filePath = '../modules/products.php';
                    if(action) filePath += '?action=' + action;
                    break;
                case 'categories':
                    filePath = '../modules/categories.php';
                    if(action) filePath += '?action=' + action;
                    break;
                case 'orders':
                    filePath = '../modules/orders.php';
                    break;
                case 'services':
                    filePath = '../modules/services.php';
                    break;
                case 'analytics':
                    filePath = '../modules/analytics.php';
                    break;
                default:
                    loadDashboard();
                    return;
            }
            
            // Load content with jQuery
            if(filePath) {
                $.get(filePath)
                    .done(function(data) {
                        contentDiv.innerHTML = data;
                    })
                    .fail(function() {
                        contentDiv.innerHTML = '<div class="alert alert-danger">Error loading page</div>';
                    });
            }
        }

        // Function to load dashboard statistics
        function loadDashboard() {
            // Reset to dashboard content
            const dashboardHTML = `
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
                                        <div class="h5 mb-0 font-weight-bold text-gray-800" id="total-products">Loading...</div>
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
                                        <div class="h5 mb-0 font-weight-bold text-gray-800" id="total-orders">Loading...</div>
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
                                        <div class="h5 mb-0 font-weight-bold text-gray-800" id="total-users">Loading...</div>
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
                                        <div class="h5 mb-0 font-weight-bold text-gray-800" id="total-revenue">Loading...</div>
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
                                <a href="#" onclick="loadAdminPage('orders')" class="btn btn-primary btn-sm">View All</a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="recent-orders-table">
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
                                            <tr><td colspan="5" class="text-center">Loading...</td></tr>
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
                                    <button class="btn btn-primary" onclick="loadAdminPage('products', 'add')">
                                        <i class="bi bi-plus-circle"></i> Add New Product
                                    </button>
                                    <button class="btn btn-success" onclick="loadAdminPage('categories', 'add')">
                                        <i class="bi bi-plus-circle"></i> Add New Category
                                    </button>
                                    <button class="btn btn-info" onclick="loadAdminPage('users')">
                                        <i class="bi bi-eye"></i> View All Users
                                    </button>
                                    <button class="btn btn-warning" onclick="loadAdminPage('orders')">
                                        <i class="bi bi-cart-check"></i> Manage Orders
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            document.getElementById('admin-content').innerHTML = dashboardHTML;
            
            // Load dashboard statistics
            loadDashboardStats();
        }

        // Function to load dashboard statistics
        function loadDashboardStats() {
            $.get('../api/dashboard-stats.php')
                .done(function(data) {
                    const stats = JSON.parse(data);
                    document.getElementById('total-products').textContent = stats.total_products || '0';
                    document.getElementById('total-orders').textContent = stats.total_orders || '0';
                    document.getElementById('total-users').textContent = stats.total_users || '0';
                    document.getElementById('total-revenue').textContent = '$' + (stats.total_revenue || '0.00');
                })
                .fail(function() {
                    document.getElementById('total-products').textContent = 'Error';
                    document.getElementById('total-orders').textContent = 'Error';
                    document.getElementById('total-users').textContent = 'Error';
                    document.getElementById('total-revenue').textContent = 'Error';
                });
            
            // Load recent orders
            $.get('../api/recent-orders.php')
                .done(function(data) {
                    const orders = JSON.parse(data);
                    let html = '';
                    if(orders.length > 0) {
                        orders.forEach(order => {
                            html += `
                                <tr>
                                    <td>#${order.id}</td>
                                    <td>${order.order_name}</td>
                                    <td>$${order.order_total}</td>
                                    <td>${order.order_date}</td>
                                    <td><span class="badge bg-${order.status_color}">${order.status_text}</span></td>
                                </tr>
                            `;
                        });
                    } else {
                        html = '<tr><td colspan="5" class="text-center">No recent orders</td></tr>';
                    }
                    document.querySelector('#recent-orders-table tbody').innerHTML = html;
                })
                .fail(function() {
                    document.querySelector('#recent-orders-table tbody').innerHTML = 
                        '<tr><td colspan="5" class="text-center text-danger">Error loading orders</td></tr>';
                });
        }

        // Load dashboard on page load
        document.addEventListener('DOMContentLoaded', function() {
            loadDashboard();
        });
    </script>

</body>

</html>