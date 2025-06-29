<?php
session_start();

// Determine the base path for navigation
$current_dir = basename(dirname($_SERVER['PHP_SELF']));
$base_path = '';
$dashboard_path = '';
if ($current_dir == 'home-page') {
    $base_path = '../modules/';
    $dashboard_path = 'admin.php';
} elseif ($current_dir == 'modules') {
    $base_path = '';
    $dashboard_path = '../home-page/admin.php';
}

// Database connection for Admin Panel
$servername = "localhost";
$username = "root"; 
$password = "";
$dbname = "banhang";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Check if user is admin
if (!isset($_SESSION['role'])) {
    header('Location: ../../Login.php');
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

$current_page = $current_page ?? 'dashboard';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - <?php echo ucfirst($current_page); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../../asset/admin-style.css">
</head>

<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div id="sidebar" class="bg-dark text-white p-3 sidebar d-flex flex-column justify-content-between">
            <!-- Header -->
            <div>
                <div class="d-flex justify-content-between align-items-center mb-4 sidebar-header">
                    <h5 class="mb-0 title">Admin</h5>
                    <span id="toggleSidebar" class="sidebar-toggle text-white">&#9776;</span>
                </div>
                
                <!-- Menu -->
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a href="../../index.php" class="nav-link text-white"><i class="bi bi-house-door"></i> <span>Go to Website</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo $dashboard_path; ?>" class="nav-link text-white <?php echo $current_page == 'dashboard' ? 'active' : ''; ?>"><i class="bi bi-speedometer2"></i> <span>Dashboard</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo $base_path; ?>users.php" class="nav-link text-white <?php echo $current_page == 'users' ? 'active' : ''; ?>"><i class="bi bi-people"></i> <span>Users</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo $base_path; ?>products.php" class="nav-link text-white <?php echo $current_page == 'products' ? 'active' : ''; ?>"><i class="bi bi-box"></i> <span>Products</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo $base_path; ?>categories.php" class="nav-link text-white <?php echo $current_page == 'categories' ? 'active' : ''; ?>"><i class="bi bi-tags"></i> <span>Categories</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo $base_path; ?>orders.php" class="nav-link text-white <?php echo $current_page == 'orders' ? 'active' : ''; ?>"><i class="bi bi-cart-check"></i> <span>Orders</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo $base_path; ?>services.php" class="nav-link text-white <?php echo $current_page == 'services' ? 'active' : ''; ?>"><i class="bi bi-tools"></i> <span>Services</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo $base_path; ?>analytics.php" class="nav-link text-white <?php echo $current_page == 'analytics' ? 'active' : ''; ?>"><i class="bi bi-graph-up"></i> <span>Analytics</span></a>
                    </li>
                </ul>
            </div>

            <!-- Logout -->
            <div class="mt-auto">
                <a href="../../Logout.php" class="nav-link text-white"><i class="bi bi-box-arrow-right"></i> <span>Logout</span></a>
            </div>
        </div>
        
        <!-- Main content -->
        <div class="content flex-fill p-4">
            <div id="admin-content">
                <!-- Page content will be loaded here -->
