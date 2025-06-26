<?php
session_start();
require '../../vendor/autoload.php';

use PayOS\PayOS;

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

    $payment_method = $_POST['payment_method'] ?? 'cash';
    $payment_code = ($payment_method === 'vnpay') ? 1 : 0;
    $cart = $_SESSION['cart'] ?? [];

    if (empty($cart)) {
        echo "<div class='alert alert-warning text-center'>Your cart is empty. Cannot place order.</div>";
        exit;
    }
}
$cart = $_SESSION['cart'] ?? [];
$exchangeRate = 25000; // 1 USD = 25,000 VND

$subtotal = 0;
foreach ($cart as $item) {
    $subtotal += $item['price'] * $item['quantity'];
}

$tax = $subtotal * 0.1;
$total = $subtotal + $tax;

// Quy đổi sang VND
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
    'orderCode'  => intval(microtime(true) * 1000),
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
