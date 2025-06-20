<?php
require_once(__DIR__ . '/../../db/connect.php');

// Bắt đầu phiên nếu chưa bắt đầu (quan trọng cho các thông báo phiên)
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['username'])) {
    echo '<div class="container-fluid vh-50 d-flex align-items-center justify-content-center mt-5">
                <div class="text-center py-5">
                    <div class="mb-4"><i class="fas fa-user fa-3x text-muted"></i></div>
                    <h4 class="text-muted mb-3">You are not Login</h4>
                    <p class="text-muted mb-4">Please Login to book a Service now</p>
                    <button class="btn btn-dark rounded-4" onclick="location.href=\'Login.php\'">Login now</button>
                </div>
            </div>';
    return; // Dừng script nếu chưa đăng nhập
}

// Lấy user ID
$username = $_SESSION['username'];
$stmt = $conn->prepare("SELECT id FROM site_user WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$user_id = $user['id'] ?? 0;

// Khởi tạo biến để truyền trạng thái vào JavaScript
$showModal = false;
$modalStatus = '';
$modalMessage = '';

// Xử lý form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $address = $_POST['address'] ?? '';
    $service_type = $_POST['service_type'] ?? '';

    try {
        // ✅ Lưu vào bảng services (đã có thêm cột address)
        $stmt = $conn->prepare("INSERT INTO services (user_id, name, phone, address, service_type) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("issss", $user_id, $name, $phone, $address, $service_type);
        $stmt->execute();

        // ✅ Ghi thông báo (loại: service = 1)
        $content = "You have successfully booked the service: $service_type";
        $type = 1; // 1 = service
        $stmt = $conn->prepare("INSERT INTO notifications (user_id, content, type) VALUES (?, ?, ?)");
        $stmt->bind_param("isi", $user_id, $content, $type);
        $stmt->execute();


        $showModal = true;
        $modalStatus = 'success';
        $modalMessage = 'Service have been booked successfuly!';
    } catch (Exception $e) {
        $showModal = true;
        $modalStatus = 'error';
        $modalMessage = 'An error occur: ' . $e->getMessage();
    }
    // Không còn lệnh header('Location: ...') ở đây nữa
}

// KHÔNG CẦN THẺ <html>, <head>, <body> Ở ĐÂY NẾU FILE NÀY ĐƯỢC INCLUDE VÀO MỘT TRANG CHÍNH.
// Nếu file này là một trang độc lập, thì bạn cần giữ lại các thẻ đó.
// Giả định rằng file này được include vào index.php sau khi HTML đã bắt đầu.
?>

<div class="container py-5 mt-5 mb-5 bg-white p-4 rounded shadow-sm">
    <h2 class="mb-4 fw-bold">Book a Service</h2>
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Your Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Phone Number</label>
            <input type="text" name="phone" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Address</label>
            <input type="text" name="address" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Service Type</label>
            <select name="service_type" class="form-select" required>
                <option value="">-- Choose a Service --</option>
                <option value="Laptop Cleaning">Laptop Cleaning</option>
                <option value="Camera Installation">Camera Installation</option>
                <option value="Repair">Repair</option>
                <option value="Warranty">Warranty</option>
            </select>
        </div>
        <button type="submit" class="btn btn-dark rounded-4 w-25">Book now</button>
    </form>
    <div class="bg-white p-3 mt-4 rounded shadow-sm">
        <p>For <span class="fw-bold">Laptop Cleaning, Repair, and Warranty Services</span>, please come or send your device to our <span class="fw-bold">Official Store</span> at:</p>
        <p>141 Chien Thang, Tan Trieu, Thanh Tri, Ha Noi</p>
        <p>We will contact you shortly to confirm your booking.</p>
    </div>
</div>

<div class="modal fade" id="bookingStatusModal" tabindex="-1" aria-labelledby="bookingStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark" id="bookingStatusModalLabel">Booking Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="bookingModalBody">
            </div>
            <div>
                <p class="text-center">Please do not <strong>reload page</strong> or click on <strong>back button</strong></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="location.href='index.php?act=book-result';return false;">Đóng</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Chỉ hiển thị modal nếu có dữ liệu xử lý form từ PHP
        <?php if ($showModal): ?>
            var bookingStatus = '<?php echo $modalStatus; ?>';
            var bookingMessage = '<?php echo $modalMessage; ?>';
            var modalBody = document.getElementById('bookingModalBody');

            if (bookingStatus === 'success') {
                modalBody.innerHTML = '<div class="alert alert-success" role="alert"><i class="fas fa-check-circle me-2"></i>' + bookingMessage + '</div>';
            } else if (bookingStatus === 'error') {
                modalBody.innerHTML = '<div class="alert alert-danger" role="alert"><i class="fas fa-times-circle me-2"></i>' + bookingMessage + '</div>';
            }

            var myModal = new bootstrap.Modal(document.getElementById('bookingStatusModal'));
            myModal.show();
        <?php endif; ?>
    });
</script>