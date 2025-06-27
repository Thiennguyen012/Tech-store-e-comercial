<?php
session_start();
require_once '../../connect.php';

// Ghi log để kiểm tra webhook có hoạt động không (chỉ dùng để debug)
file_put_contents("payos_webhook_log.txt", date("Y-m-d H:i:s") . "\n" . print_r($_POST, true) . print_r($_SESSION, true), FILE_APPEND);

// Nhận dữ liệu JSON từ PayOS
$data = json_decode(file_get_contents("php://input"), true);

// Kiểm tra dữ liệu cần thiết
if (!isset($data['orderCode']) || $data['status'] !== 'PAID') {
    http_response_code(400);
    echo json_encode(['message' => 'Thiếu dữ liệu hoặc chưa thanh toán']);
    exit;
}

// Lấy thông tin người đặt từ SESSION
if (!isset($_SESSION['checkout_info']) || !isset($_SESSION['cart'])) {
    http_response_code(400);
    echo json_encode(['message' => 'Không có thông tin phiên']);
    exit;
}

$info = $_SESSION['checkout_info'];
$cart = $_SESSION['cart'];

// Lấy user ID nếu đã đăng nhập
$user_id = isset($_SESSION['user']['id']) ? $_SESSION['user']['id'] : null;

// Tính tổng tiền
$order_total = 0;
foreach ($cart as $item) {
    $order_total += $item['price'] * $item['quantity'];
}

// Thêm vào bảng `bill`
$stmt = $conn->prepare("INSERT INTO bill (user_id, order_name, order_phone, order_address, order_total, order_paymethod, order_status) VALUES (?, ?, ?, ?, ?, 1, 'Success')");
$stmt->bind_param("isssd", $user_id, $info['name'], $info['phone'], $info['address'], $order_total);
$stmt->execute();

$bill_id = $stmt->insert_id;

// Lưu từng sản phẩm vào bảng `bill_detail`
$stmtDetail = $conn->prepare("INSERT INTO checkout_cart (bill_id, product_id, price, quantity) VALUES (?, ?, ?, ?)");

foreach ($cart as $product_id => $item) {
    $stmtDetail->bind_param("iidi", $bill_id, $product_id, $item['price'], $item['quantity']);
    $stmtDetail->execute();
}

// Xóa session sau khi xử lý xong
unset($_SESSION['checkout_info']);
unset($_SESSION['cart']);

// Trả phản hồi thành công
http_response_code(200);
echo json_encode(['message' => 'Đã lưu đơn hàng thành công']);
