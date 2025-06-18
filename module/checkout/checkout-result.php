<?php
include 'lib.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $phone = $address = '';

    // Nếu chọn dùng thông tin mới:
    if (isset($_POST['use_new_info']) && $_POST['use_new_info'] === '1') {
        $name = $_POST['form_name'] ?? '';
        $phone = $_POST['form_phone'] ?? '';
        $address = $_POST['form_address'] ?? '';
    } else {
        // Ngược lại dùng thông tin từ DB
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

    // Calculate total
    $subtotal = 0;
    foreach ($cart as $item) {
        $subtotal += $item['price'] * $item['quantity'];
    }
    $tax = $subtotal * 0.1;
    $total = $subtotal + $tax;

    // Insert order
    $order_id = newBillOrder($conn, $name, $phone, $address, $total, $payment_code);

    // Insert order items
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
    }

    // Clear cart
    unset($_SESSION['cart']);
} else {
    echo "<div class='alert alert-danger text-center'>Invalid access.</div>";
    exit;
}
?>
<div class="container bg-white shadow p-5 mt-5 rounded-4 mb-5">
    <div class="text-center mb-5">
        <h1 class="text-success fw-bold">🎉 Order Successfully Placed!</h1>
        <p class="text-muted">Thank you for shopping with us.</p>
        <h5 class="mt-3">Order ID: <span class="text-success">#<?= htmlspecialchars($order_id) ?></span></h5>
    </div>

    <!-- Shipping Info -->
    <div class="mb-4">
        <h4 class="mb-3">Shipping Information</h4>
        <ul class="list-group">
            <li class="list-group-item"><strong>Recipient:</strong> <?= htmlspecialchars($name) ?></li>
            <li class="list-group-item"><strong>Phone:</strong> <?= htmlspecialchars($phone) ?></li>
            <li class="list-group-item"><strong>Address:</strong> <?= htmlspecialchars($address) ?></li>
            <li class="list-group-item"><strong>Payment:</strong> <?= $payment_method === 'vnpay' ? 'VNPay' : 'Cash on Delivery' ?></li>
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
                <?php foreach ($cart as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['name']) ?></td>
                        <td class="text-center"><?= $item['quantity'] ?></td>
                        <td class="text-end">$<?= number_format($item['price'] * $item['quantity'], 2) ?></td>
                    </tr>
                <?php endforeach; ?>
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
        <a href="index.php" class="btn btn-outline-dark rounded-4 px-4">Continue Shopping</a>
    </div>
</div>