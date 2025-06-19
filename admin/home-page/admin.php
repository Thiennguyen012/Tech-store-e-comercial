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
                </div>
                <!-- Menu -->
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a href="../../index.php" class="nav-link text-white"><i class="bi bi-house-door"></i> <span>Go to Website</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link text-white"><i class="bi bi-people"></i> <span>Users</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link text-white"><i class="bi bi-box"></i> <span>Products</span></a>
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
            <h2>Welcome to Admin Dashboard</h2>
            <p>Chọn chức năng từ menu bên trái để quản lý.</p>
        </div>
    </div>

    <!-- Bootstrap + Icons + JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <script>
        const sidebar = document.getElementById('sidebar');
        const toggleBtn = document.getElementById('toggleSidebar');

        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
        });
    </script>

</body>

</html>