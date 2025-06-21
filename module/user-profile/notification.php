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
                    <div class="d-flex gap-3">
                        <a href="#" class="text-success" style="font-size:15px;" onclick="markAllAsRead(); return false;">Mark all as read</a>
                        <!-- Nút Delete All -->
                        <a href="#" class="btn btn-outline-dark btn-sm d-inline-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#confirmDeleteAllModal">
                            <i class="fa-solid fa-trash"></i>
                        </a>
                    </div>
                </div>

                <?php if ($notifications->num_rows === 0): ?>
                    <div class="text-center py-5">
                        <img src="https://cdn-icons-png.flaticon.com/512/4076/4076549.png" width="100" alt="empty">
                        <div class="text-muted mt-3">You don't have any notifications</div>
                    </div>
                <?php else: ?>
                    <div class="notification-container" style="max-height: 345px; overflow-y: auto;">
                        <ul class="list-group">
                            <?php while ($row = $notifications->fetch_assoc()): ?>
                                <li class="noti-item list-group-item d-flex justify-content-between align-items-start <?= $row['is_read'] ? 'text-muted' : '' ?>"
                                    data-id="<?= $row['id'] ?>">
                                    <div class="d-flex flex-column w-100">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="d-flex align-items-center gap-2">
                                                <div><?= htmlspecialchars($row['content']) ?></div>
                                                <?php if (!$row['is_read']): ?>
                                                    <span class="badge bg-success">New</span>
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
<!-- Modal xác nhận xóa tất cả -->
<div class="modal fade" id="confirmDeleteAllModal" tabindex="-1" aria-labelledby="confirmDeleteAllLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark" id="confirmDeleteAllLabel">Confirm Delete All</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete <strong>all</strong> notifications?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-dark" onclick="deleteAllNotifications()">Yes, Delete All</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal thông báo không có thông báo nào -->
<div class="modal fade" id="emptyNotiModal" tabindex="-1" aria-labelledby="emptyNotiLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="emptyNotiLabel">No Notifications</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                You don't have any notifications to delete.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Xử lý click vào notification để chuyển hướng theo type
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.noti-item').forEach(function(item) {
            item.addEventListener('click', function(e) {
                // Ngăn click vào nút xóa không bị trigger
                if (e.target.closest('a')) return;
                const notiId = this.getAttribute('data-id');

                // Gọi API đánh dấu đã đọc
                fetch("module/user-profile/mark-read.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded"
                    },
                    body: "id=" + notiId
                }).then(() => {
                    // Xóa badge trên navbar nếu có
                    const navbarBadge = document.querySelector("#noti-badge");
                    if (navbarBadge) navbarBadge.remove();

                    // Lấy type và chuyển hướng
                    fetch(`module/user-profile/get-notification-type.php?id=${notiId}`)
                        .then(res => res.json())
                        .then(data => {
                            if (data.type == 0) {
                                window.location.href = 'index.php?act=order';
                            } else if (data.type == 1) {
                                window.location.href = 'index.php?act=book-result';
                            }
                        });
                });
            });
        });
    });

    function markAllAsRead() {
        fetch("module/user-profile/mark-all-read.php", {
                method: "POST"
            }).then(res => res.text())
            .then(res => {
                if (res === "success") {
                    document.querySelectorAll(".noti-item").forEach(item => {
                        item.classList.add("text-muted");
                        item.querySelector(".badge")?.remove();
                    });
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
                    const notiItem = btnElement.closest(".noti-item");
                    notiItem.remove();
                    window.location.href = 'index.php?act=notification';
                    const navbarBadge = document.querySelector("#noti-badge");
                    if (navbarBadge) navbarBadge.remove();
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

    function deleteAllNotifications() {
        const notiCount = document.querySelectorAll('.noti-item').length;
        if (notiCount === 0) {
            const emptyModal = new bootstrap.Modal(document.getElementById('emptyNotiModal'));
            emptyModal.show();
            const confirmModal = bootstrap.Modal.getInstance(document.getElementById('confirmDeleteAllModal'));
            if (confirmModal) confirmModal.hide();
            return;
        }

        fetch("module/user-profile/delete-all-notifications.php", {
                method: "POST"
            }).then(res => res.text())
            .then(res => {
                if (res === "success") {
                    const modal = bootstrap.Modal.getInstance(document.getElementById('confirmDeleteAllModal'));
                    modal.hide();
                    document.querySelector('.notification-container').innerHTML = `
                <div class="text-center py-5">
                    <img src="https://cdn-icons-png.flaticon.com/512/4076/4076549.png" width="100" alt="empty">
                    <div class="text-muted mt-3">You don't have any new notifications</div>
                </div>
            `;
                    document.querySelectorAll(".noti-item").forEach(item => {
                        item.classList.add("text-muted");
                        item.querySelector(".badge")?.remove();
                    });
                    // Xóa badge trên navbar
                    const navbarBadge = document.querySelector("#noti-badge");
                    if (navbarBadge) navbarBadge.remove();
                    // Xóa badge ở sidebar (bổ sung dòng này)
                    const sidebarBadge = document.querySelector("#noti-badge-sidebar");
                    if (sidebarBadge) sidebarBadge.remove();
                }
            });
    }
</script>