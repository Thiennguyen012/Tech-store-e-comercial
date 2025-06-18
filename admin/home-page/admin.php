<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../asset/admin-style.css">

</head>

<body>

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