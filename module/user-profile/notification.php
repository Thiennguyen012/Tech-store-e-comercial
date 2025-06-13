<?php
// Bắt đầu session nếu chưa có
if (session_status() === PHP_SESSION_NONE) session_start();

// Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
if (!isset($_SESSION['username'])) {
    echo '<div class="container mt-5"><div class="alert alert-warning">Please <a href="Login.php">login</a> to view your notifications.</div></div>';
    return;
}
?>
<div class="container py-4">
    <div class="row g-4">
        <!-- Sidebar với menu điều hướng -->
        <div class="col-lg-3">
            <?php include 'user-profile-sidebar.php'; ?>
        </div>
        <div class="col-lg-9">
            <div class="pv-profile-main shadow-sm">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="fw-bold mb-0">Your Notifications</h4>
                    <a href="#" class="text-primary" style="font-size:15px;">Mark all as read</a>
                </div>
                <div class="text-center py-5">
                    <img src="https://cdn-icons-png.flaticon.com/512/4076/4076549.png" width="100" alt="empty">
                    <div class="text-muted mt-3">You don't have any new notifications</div>
                </div>
            </div>
        </div>
    </div>
</div>