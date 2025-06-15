<?php
// Xác định mục nào trên sidebar đang active
$active = basename($_SERVER['PHP_SELF']);
function is_active($file) {
    global $active;
    return $active === $file ? 'active' : '';
}
?>
<div class="pv-profile-sidebar text-center shadow-sm">
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
        <a class="nav-link text-dark<?php echo is_active('notification.php'); ?>" href="#" onclick="loadPage('module/user-profile/notification.php',this,'notification'); return false;">
            <i class="bi bi-bell"></i> Notifications
        </a>
    </nav>
</div>