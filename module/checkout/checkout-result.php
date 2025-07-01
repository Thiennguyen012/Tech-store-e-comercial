<?php
include 'lib.php';

// Xác định user_id từ session
$username = $_SESSION['username'] ?? '';
$user_id = null;

if (!isset($_SESSION['username'])) {
    echo '<div class="text-center py-5 mt-5">
        <div class="mb-4"><i class="fas fa-user fa-3x text-muted"></i></div>
        <h4 class="text-muted mb-3">You are not Place order yet</h4>
        <p class="text-muted mb-4">Please add some products to do this action.</p>
        <button class="btn btn-dark rounded-4" onclick="location.href=\'index.php?act=products\'">Shop now</button>
    </div>';
    return;
}

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

$cart = $_SESSION['cart'] ?? [];

if (isset($_GET['code']) && $_GET['code'] === '00' && $_GET['status'] === 'PAID') {
    // ✅ Thanh toán online thành công từ PayOS

    $order_id = $_GET['orderCode'] ?? '';
    $payment_code = 1;
    $status = 'Paid';

    // Tính lại total
    $subtotal = 0;
    //subtotal được tính bằng số lượng * đơn giá của các sản phẩm có bill_id = order_id
    $stmt = $conn->prepare("SELECT price, quantity FROM checkout_cart WHERE bill_id = ?");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $subtotal = 0;
    while ($row = $result->fetch_assoc()) {
        $subtotal += $row['price'] * $row['quantity'];
    }


    $tax = $subtotal * 0.1;
    $total = $subtotal + $tax;

    // ✅ Lưu đơn hàng
    updatebillOrder($conn, $order_id, $status);

    // Thêm thông báo
    if ($user_id && $order_id) {
        $message = "You have successfully placed order #$order_id.";
        $type = 0;
        $stmtNotify = $conn->prepare("INSERT INTO notifications (user_id, content, type) VALUES (?, ?, ?)");
        $stmtNotify->bind_param("isi", $user_id, $message, $type);
        $stmtNotify->execute();
    }
    unset($_SESSION['cart']);
} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
    $payment_code = 0;
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
    // ✅ Tạo đơn hàng
    $order_id = newBillOrder($conn, $user_id, $name, $phone, $address, $total, $payment_code);
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

    // ✅ Thêm thông báo sau khi có $order_id
    if ($user_id && $order_id) {
        $message = "You have successfully placed order #$order_id.";
        $type = 0; // 0 = product (checkout)
        $stmtNotify = $conn->prepare("INSERT INTO notifications (user_id, content, type) VALUES (?, ?, ?)");
        $stmtNotify->bind_param("isi", $user_id, $message, $type);
        $stmtNotify->execute();
    }


    // Xóa giỏ hàng
    unset($_SESSION['cart']);
} else {
    echo '<div class="text-center py-5 mt-5">
        <div class="mb-4"><i class="fas fa-user fa-3x text-muted"></i></div>
        <h4 class="text-muted mb-3">You are not logged in</h4>
        <p class="text-muted mb-4">Please login to do this action.</p>
        <button class="btn btn-dark rounded-4" onclick="location.href=\'Login.php\'">Login Now</button>
    </div>';
    return;
}
?>
<div class="container bg-white shadow p-5 mt-5 rounded-4 mb-5">
    <div class="text-center mb-5">
        <h1 class="text-success fw-bold">Order Successfully Placed!</h1>
        <p class="text-muted">Thank you for shopping with us.</p>
        <h5 class="mt-3">Order ID: <span class="text-success">#<?= htmlspecialchars($order_id) ?></span></h5>
    </div>
    <?php
    if (!$order_id) {
        echo "<div class='alert alert-danger'>Order_id not Found!</div>";
        exit;
    }
    $stmt = $conn->prepare("SELECT order_name, order_phone, order_address, order_paymethod FROM bill WHERE id = ?");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $name = $row['order_name'];
        $phone = $row['order_phone'];
        $address = $row['order_address'];
        $payment_method = $row['order_paymethod'];
    }
    ?>
    <!-- Shipping Info -->
    <div class="mb-4">
        <h4 class="mb-3">Shipping Information</h4>
        <ul class="list-group">
            <li class="list-group-item"><strong>Recipient:</strong> <?= htmlspecialchars($name) ?></li>
            <li class="list-group-item"><strong>Phone:</strong> <?= htmlspecialchars($phone) ?></li>
            <li class="list-group-item"><strong>Address:</strong> <?= htmlspecialchars($address) ?></li>
            <li class="list-group-item"><strong>Payment:</strong> <?= $payment_method == 1 ? 'Online by PayOS' : 'Cash on Delivery' ?></li>
        </ul>
    </div>

    <!-- Products -->
    <div>
        <h4 class="mb-3">Ordered Products</h4>
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>Product Name</th>
                    <th class="text-center" style="width: 100px;">Quantity</th>
                    <th class="text-end" style="width: 150px;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <!-- Lấy thông tin sản phẩm từ bảng checkout-cart với bill_id = order_id -->
                <?php
                $stmt = $conn->prepare("SELECT product_name, quantity, price FROM checkout_cart WHERE bill_id = ?");
                $stmt->bind_param("i", $order_id);
                $stmt->execute();
                $result = $stmt->get_result();
                while ($row = $result->fetch_assoc()) {
                ?>
                    <tr>
                        <td><?= htmlspecialchars($row['product_name']) ?></td>
                        <td class="text-center"><?= $row['quantity'] ?></td>
                        <td class="text-end">$<?= number_format($row['price'] * $row['quantity'], 2) ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <!-- Totals -->
        <div class="text-end mt-4">
            <p><strong>Subtotal:</strong> $<?= number_format($subtotal, 2) ?></p>
            <p><strong>Tax (10%):</strong> $<?= number_format($tax, 2) ?></p>
            <h5><strong>Total:</strong> $<?= number_format($total, 2) ?></h5>
        </div>
    </div>

    <!-- Back button -->
    <div class="text-center mt-5">
        <div class="d-flex justify-content-center gap-3">
            <a onclick="location.href='?act=products'" class="btn btn-outline-dark rounded-4 px-4">Continue Shopping</a>
            <a onclick="location.href='?act=order'" class="btn btn-outline-dark rounded-4 px-4">View your Order</a>
        </div>
    </div>

</div>