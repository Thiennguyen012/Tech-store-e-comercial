<?php
require_once(__DIR__ . '/../../db/connect.php');

// Lấy user hiện tại
$username = $_SESSION['username'] ?? '';
$unread_count = 0;

if ($username) {
    $stmt = $conn->prepare("SELECT COUNT(*) FROM notifications n
                            JOIN site_user u ON n.user_id = u.id
                            WHERE u.username = ? AND n.is_read = 0");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($unread_count);
    $stmt->fetch();
    $stmt->close();
}
// Xác định mục nào trên sidebar đang active
$active = basename($_SERVER['PHP_SELF']);
function is_active($file)
{
    global $active;
    return $active === $file ? 'active' : '';
}
?>
<div class="pv-profile-sidebar text-center shadow-sm mb-5 mt-5" style="height: 446px;">
    <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($_SESSION['username']); ?>&background=4f5250&color=fff&size=128" class="avatar mb-2" alt="Avatar">
    <div class="username mb-2">Account of<br><span><?php echo htmlspecialchars($_SESSION['username']); ?></span></div>
    <nav class="nav flex-column align-items-start mt-4">
        <!-- Mỗi liên kết sẽ load một trang con của profile bằng AJAX -->
        <a class="nav-link text-dark<?php echo is_active('user-profile.php'); ?>" href="#" onclick="loadPage('module/user-profile/user-profile.php',this,'profile'); return false;">
            <i class="bi bi-person"></i> Account Information
        </a>
        <a class="nav-link text-dark<?php echo is_active('user-order.php'); ?>" href="#" onclick="loadPage('module/user-order/user-order.php',this,'order'); return false;">
            <i class="bi bi-bag"></i> Order Management
        </a>
        <a class="nav-link text-dark<?php echo is_active('addresses.php'); ?>" href="#" onclick="loadPage('module/user-profile/addresses.php',this,'addresses'); return false;">
            <i class="bi bi-geo-alt"></i> Address Book
        </a>
        <a class="nav-link d-flex justify-content-between align-items-center text-dark<?php echo is_active('notification.php'); ?>" href="#" onclick="loadPage('module/user-profile/notification.php',this,'notification'); return false;">
            <span><i class="bi bi-bell"></i> Notifications</span>
            <?php if ($unread_count > 0): ?>
                <span class="badge bg-danger"><?php echo $unread_count; ?></span>
            <?php endif; ?>
        </a>
        <!-- Mục dành cho admin -->
        <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 0): ?>
            <a class="nav-link d-flex justify-content-between align-items-center text-dark" href="admin/home-page/admin.php">
                <i class="bi bi-speedometer2"></i> Admin Dashboard
            </a>
        <?php endif; ?>
    </nav>
</div>