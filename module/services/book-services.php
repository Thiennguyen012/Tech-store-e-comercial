<?php
require_once(__DIR__ . '/../../db/connect.php');

if (!isset($_SESSION['username'])) {
    echo '<div class="container-fluid vh-50 d-flex align-items-center justify-content-center mt-5">
            <div class="text-center py-5">
                <div class="mb-4"><i class="fas fa-user fa-3x text-muted"></i></div>
                <h4 class="text-muted mb-3">You are not logged in</h4>
                <p class="text-muted mb-4">Please login to book your service now</p>
                <button class="btn btn-dark rounded-4" onclick="location.href=\'Login.php\'">Login Now</button>
            </div>
        </div>';
    return;
}

// Lấy user ID
$username = $_SESSION['username'];
$stmt = $conn->prepare("SELECT id FROM site_user WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$user_id = $user['id'] ?? 0;

// Xử lý form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $address = $_POST['address'] ?? '';
    $service_type = $_POST['service_type'] ?? '';

    // ✅ Lưu vào bảng services (đã có thêm cột address)
    $stmt = $conn->prepare("INSERT INTO services (user_id, name, phone, address, service_type) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issss", $user_id, $name, $phone, $address, $service_type);
    $stmt->execute();

    // ✅ Ghi thông báo
    $content = "You have successfully booked the service: $service_type";
    $stmt = $conn->prepare("INSERT INTO notifications (user_id, content) VALUES (?, ?)");
    $stmt->bind_param("is", $user_id, $content);
    $stmt->execute();

    echo '<div class="alert alert-success">Service booked successfully!</div>';
}
?>


<div class="container py-5 mt-5 mb-5 bg-light p-4 rounded shadow-sm">
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
        <button type="submit" class="btn btn-dark rounded-4 w-25">Book Now</button>
    </form>
    <div class="bg-white p-3 mt-4 rounded shadow-sm">
        <p>For <span class="fw-bold">Laptop Cleaning, Repair, and Warranty Services</span>, please come or send your device to our <span class="fw-bold">Official Store</span> at:</p>
        <p>141 Chien Thang, Tan Trieu, Thanh Tri, Ha Noi</p>
        <p>We will contact you shortly to confirm your booking.</p>
    </div>
</div>