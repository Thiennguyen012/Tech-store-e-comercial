<?php
session_start();
require '../../vendor/autoload.php';
include 'lib.php';
include '../../db/connect.php';

use PayOS\PayOS;

// Xác định user_id từ session
$username = $_SESSION['username'] ?? '';
$user_id = null;

if ($username) {
    $sql = "SELECT id FROM site_user WHERE username = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($row = mysqli_fetch_assoc($result)) {
        $user_id = $row['id'];
    }
}
// Lấy giỏ hàng từ session
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $phone = $address = '';

    if (isset($_POST['use_new_info']) && $_POST['use_new_info'] === '1') {
        $name = $_POST['form_name'] ?? '';
        $phone = $_POST['form_phone'] ?? '';
        $address = $_POST['form_address'] ?? '';
    } else {
        $name = $_POST['db_name'] ?? '';
        $phone = $_POST['db_phone'] ?? '';
        $address = $_POST['db_address'] ?? '';
    }
    echo "$name, $phone, $address";
    $payment_method = $_POST['payment_method'] ?? 'cash';
    $payment_code = ($payment_method === 'vnpay') ? 1 : 0;
    $cart = $_SESSION['cart'] ?? [];

    if (empty($cart)) {
        echo "<div class='alert alert-warning text-center'>Your cart is empty. Cannot place order.</div>";
        exit;
    }

    $subtotal = 0;
    foreach ($cart as $item) {
        $subtotal += $item['price'] * $item['quantity'];
    }
    $tax = $subtotal * 0.1;
    $total = $subtotal + $tax;
    echo "debug3:$name, $phone, $address, $payment_method, $payment_code, $subtotal, $tax, $total";
    // ✅ Tạo đơn hàng
    $order_id = newBillOrder($conn, $user_id, $name, $phone, $address, $total, $payment_code);
    echo "debug4:$name, $phone, $address, $payment_method, $payment_code, $subtotal, $tax, $total";
    if (!$order_id) {
        echo "<div class='alert alert-danger text-center'>Failed to create order. Please try again later.</div>";
        exit;
    }

    // ✅ Thêm sản phẩm vào checkout_cart
    foreach ($cart as $item) {
        newCheckoutCart(
            $conn,
            $item['name'],
            $item['img'],
            $item['price'],
            $item['quantity'],
            $item['price'] * $item['quantity'],
            $order_id
        );
        $product_id = $item['id'];
        $qty_bought = $item['quantity'];

        $stmt = $conn->prepare("UPDATE product SET qty_in_stock = qty_in_stock - ? WHERE id = ?");
        $stmt->bind_param("ii", $qty_bought, $product_id);
        $stmt->execute();
    }

    // Xóa giỏ hàng
    unset($_SESSION['cart']);
}
// Quy đổi sang VND
$exchangeRate = 25000; // 1 USD = 25,000 VND
$subtotal_vnd = $subtotal * $exchangeRate;
$tax_vnd = $tax * $exchangeRate;
$total_vnd = $total * $exchangeRate;


// Nếu có thuế/phí ship, cộng thêm ở đây
// $tax = $total * 0.1; // ví dụ thuế 10%
// $total += $tax;

$clientId = '7e8f65c1-ca17-402d-a2b4-5c82fcff8885';
$apiKey = 'c3c0d1e3-3ec6-4d4a-b28c-1bf2aef496f7';
$checksumKey = '09da5ca20fab4848f33f37f8cfcf67396ebdb5bb9eed1accabe21a0340b9776a';

$payos = new PayOS($clientId, $apiKey, $checksumKey);

$data = [
    'name' => $name,
    'phone' => $phone,
    'address' => $address,
    'orderCode'  => $order_id,
    'amount'     => intval($total_vnd), // <-- Tổng tiền thực tế
    'description' => 'Checkout for Technologia',
    'returnUrl'  => 'http://localhost/Webbanhang/index.php?act=checkout-result',
    'cancelUrl'  => 'http://localhost/PAYOS_DEMO_PHP/cancel.php',
];
try {
    $response = $payos->createPaymentLink($data);
    header('Location: ' . $response['checkoutUrl']);
    exit;
} catch (\Throwable $e) {
    echo 'Lỗi tạo link: ' . $e->getMessage();
}

// ...sau khi lấy $name, $phone, $address...

// Lưu thông tin nhận hàng vào session (có thể dùng cho thanh toán offline)
$_SESSION['checkout_info'] = [
    'name' => $name,
    'phone' => $phone,
    'address' => $address
];

// Lưu dữ liệu tạm để webhook xử lý (vì webhook không có session)
$orderCode = $data['orderCode']; // Lấy từ mảng $data gửi lên cho PayOS

$tempData = [
    'checkout_info' => $_SESSION['checkout_info'],
    'cart' => $_SESSION['cart'],
    'user' => $_SESSION['user'] ?? null
];

// Tạo thư mục lưu file nếu chưa có
if (!is_dir('orders_temp')) {
    mkdir('orders_temp', 0777, true);
}

// Lưu file theo tên orderCode
file_put_contents("orders_temp/{$orderCode}.json", json_encode($tempData));

// $_SESSION['cart'] phải có sẵn từ trước khi đến checkout
