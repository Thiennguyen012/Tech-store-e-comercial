<?php
// Bắt đầu session nếu chưa có
if (session_status() === PHP_SESSION_NONE) session_start();

// Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
if (!isset($_SESSION['username'])) {
    echo '<div class="container mt-5"><div class="alert alert-warning">Please <a href="Login.php">login</a> to view your account information.</div></div>';
    return;
}
require_once __DIR__ . '/../../db/connect.php';


$user_id = $_SESSION['user_id'];
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current = $_POST['current_password'] ?? '';
    $new = $_POST['new_password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';

    // Lấy mật khẩu hiện tại từ DB
    $stmt = $conn->prepare("SELECT password FROM site_user WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($db_password);
    $stmt->fetch();
    $stmt->close();

    // Nếu bạn dùng password_hash:
    // $valid = password_verify($current, $db_password);
    // Nếu bạn lưu plain text:
    $valid = ($current === $db_password);

    if (!$valid) {
        $message = '<div class="alert alert-danger">Current password is incorrect.</div>';
    } elseif ($new !== $confirm) {
        $message = '<div class="alert alert-warning">Password confirmation does not match.</div>';
    } else {
        // Nếu bạn dùng password_hash:
        // $hashed = password_hash($new, PASSWORD_DEFAULT);
        // Nếu bạn lưu plain text:
        $hashed = $new;
        $stmt = $conn->prepare("UPDATE site_user SET password = ? WHERE id = ?");
        $stmt->bind_param("si", $hashed, $user_id);
        $stmt->execute();
        $stmt->close();
        $message = '<div class="alert alert-success">Password changed successfully!</div>';
    }
}
?>

<div class="container py-4">
    <div class="row g-4">
        <!-- Sidebar bên trái -->
        <div class="col-lg-3">
            <?php include 'user-profile-sidebar.php'; ?>
        </div>
        <!-- Form đổi mật khẩu bên phải -->
        <div class="col-lg-6">
            <div class="pv-profile-main shadow-sm mb-5 mt-5" style="height: 520px;">
                <h4 class="mb-4 fw-bold"> Change Password</h4>
                <?php if (!empty($message)) echo $message; ?>
                <form method="post" autocomplete="off">
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Current Password</label>
                        <input type="password" class="form-control" id="current_password" name="current_password" required autocomplete="current-password">
                    </div>
                    <div class="mb-3">
                        <label for="new_password" class="form-label">New Password</label>
                        <input type="password" class="form-control" id="new_password" name="new_password" required autocomplete="new-password">
                    </div>
                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Confirm New Password</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required autocomplete="new-password">
                    </div>
                    <button type="submit" class="btn btn-dark mt-2">Change Password</button>
                </form>
            </div>
        </div>
    </div>
</div>