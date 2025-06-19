<?php
require_once(__DIR__ . '/../../db/connect.php');
if (session_status() === PHP_SESSION_NONE) session_start();

if (!isset($_SESSION['username'])) {
    echo '<div class="container mt-5"><div class="alert alert-warning">Please <a href="Login.php">login</a> to view your notifications.</div></div>';
    return;
}

// Lấy ID người dùng
$username = $_SESSION['username'];
$sql = "SELECT id FROM site_user WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    echo '<div class="container mt-5"><div class="alert alert-danger">User not found.</div></div>';
    return;
}

$user_id = $user['id'];

// Lấy danh sách thông báo
$sql = "SELECT * FROM notifications WHERE user_id = ? ORDER BY created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$notifications = $stmt->get_result();
?>

<div class="container py-4">
    <div class="row g-4">
        <!-- Sidebar với menu điều hướng -->
        <div class="col-lg-3">
            <?php include 'user-profile-sidebar.php'; ?>
        </div>
        <div class="col-lg-9">
            <div class="pv-profile-main shadow-sm mt-5 mb-5" style="height: 446px">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="fw-bold mb-0">Your Notifications</h4>
                    <a href="#" class="text-primary" style="font-size:15px;" onclick="markAllAsRead(); return false;">Mark all as read</a>

                </div>

                <?php if ($notifications->num_rows === 0): ?>
                    <div class="text-center py-5">
                        <img src="https://cdn-icons-png.flaticon.com/512/4076/4076549.png" width="100" alt="empty">
                        <div class="text-muted mt-3">You don't have any new notifications</div>
                    </div>
                <?php else: ?>
                    <div class="notification-container" style="max-height: 345px; overflow-y: auto;">
                        <ul class="list-group">
                            <?php while ($row = $notifications->fetch_assoc()): ?>
                                <li class="noti-item list-group-item d-flex justify-content-between align-items-start <?= $row['is_read'] ? 'text-muted' : '' ?>">
                                    <div class="d-flex flex-column w-100" onclick="markAsRead(<?= $row['id'] ?>, this); return false;">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="d-flex align-items-center gap-2">
                                                <div><?= htmlspecialchars($row['content']) ?></div>
                                                <?php if (!$row['is_read']): ?>
                                                    <span class="badge bg-primary">New</span>
                                                <?php endif; ?>
                                            </div>
                                            <a href="#" onclick="deleteNotification(<?= $row['id'] ?>, this); return false;" class="text-dark text-decoration-none fs-5 fw-bold"><i class="fa-solid fa-xmark"></i></a>
                                        </div>
                                        <small class="text-muted mt-1"><?= date('Y-m-d H:i', strtotime($row['created_at'])) ?></small>
                                    </div>
                                </li>
                            <?php endwhile; ?>
                        </ul>

                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
    function markAsRead(notiId, element) {
        fetch("module/user-profile/mark-read.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: "id=" + notiId
        }).then(() => {
            element.classList.remove("text-muted");
            element.querySelector(".badge")?.remove();
            window.location.href = '?act=order';
        });
    }

    function markAllAsRead() {
        fetch("module/user-profile/mark-all-read.php", {
                method: "POST"
            }).then(res => res.text())
            .then(res => {
                if (res === "success") {
                    // Xóa các badge NEW và làm mờ tất cả
                    document.querySelectorAll(".noti-item").forEach(item => {
                        item.classList.add("text-muted");
                        item.querySelector(".badge")?.remove();
                    });

                    // Xóa badge ở navbar nếu có
                    window.location.href = '?act=notification';
                    const navbarBadge = document.querySelector("#noti-badge");
                    if (navbarBadge) navbarBadge.remove();
                }
            });
    }

    function deleteNotification(notiId, btnElement) {
        if (!confirm("Are you sure you want to delete this notification?")) return;

        fetch("module/user-profile/delete-notification.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: "id=" + notiId
            }).then(res => res.text())
            .then(res => {
                if (res === "success") {
                    // Xóa li khỏi giao diện
                    const notiItem = btnElement.closest(".noti-item");
                    notiItem.remove();
                    window.location.href = '?act=notification';
                    // Nếu có badge thì xóa luôn
                    const navbarBadge = document.querySelector("#noti-badge");
                    if (navbarBadge) navbarBadge.remove();
                    // Nếu không còn thông báo nào thì hiện giao diện rỗng
                    if (document.querySelectorAll('.noti-item').length === 0) {
                        document.querySelector('.notification-container').innerHTML = `
                    <div class="text-center py-5">
                        <img src="https://cdn-icons-png.flaticon.com/512/4076/4076549.png" width="100" alt="empty">
                        <div class="text-muted mt-3">You don't have any new notifications</div>
                    </div>
                `;
                    }
                }
            });
    }
</script>