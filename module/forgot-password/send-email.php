<?php
require '../../components/header.php';
?>

<body>
    <!-- Main container -->
    <div class="container d-flex justify-content-center align-items-center min-vh-100 border-5">
        <!-- login-container -->
        <div class="row border border rounded-5 p-3 bg-white" style="width: 930px; margin: auto">
            <!-- Alert Box - Hiển thị thông báo -->
            <?php if (!empty($alert_message)): ?>
                <div class="col-12 mb-3">
                    <div class="alert alert-<?php echo $alert_type; ?> alert-dismissible fade show" role="alert"
                        id="alertBox">
                        <i
                            class="bi bi-<?php echo $alert_type == 'success' ? 'check-circle' : ($alert_type == 'danger' ? 'exclamation-triangle' : 'info-circle'); ?>"></i>
                        <?php echo $alert_message; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            <?php endif; ?>

        </div>


        <div class="col-md-6">
            <!-- Form đăng nhập -->
            <form action="login.php" method="post">
                <!-- tạo 1 row ở cột phải -->
                <div class="row align-items-center">
                    <div>
                        <p class="text-dark mt-4 mb-4" id="login-text">Sign in</p>
                    </div>
                    <!-- input username, password -->
                    <div class="input-group mb-3">
                        <input type="text" id="username" name="username"
                            class="form-control form-control-lg bg-light fs-6" placeholder="Username"
                            value="<?php echo $cookie_id ?>" />
                    </div>

                    <div class="input-group mb-4">
                        <input type="password" id="password" name="password"
                            class="form-control form-control-lg bg-light fs-6" placeholder="Password"
                            value="<?php echo $password ?>" />
                    </div>
                    <!-- Button login -->
                    <div class="input-group mb-lg-3 mb-md-2 mb-sm-2">
                        <button type="submit" class="btn btn-dark btn-lg mt-4 rounded-5 w-100" id="login-btn">
                            Sign in
                        </button>
                    </div>
                </div>
        </div>
</body>

</html>