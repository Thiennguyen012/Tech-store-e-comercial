<?php
include '../../db/connect.php';
include '../../module/checkout/lib.php';

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

if (isset($_GET['orderCode']) && isset($_GET['status']) && strtoupper($_GET['status']) === 'CANCELLED') {
    // ✅ Thanh toán online thành công từ PayOS

    $order_id = $_GET['orderCode'] ?? '';
    $payment_code = 1;
    $status = 'Cancelled';

    //cập nhật trạng thái đơn hàng
    updatebillOrder($conn, $order_id, $status);

    // Lấy lại các sản phẩm trong đơn hàng này
    $sql = "SELECT product_name, quantity FROM checkout_cart WHERE bill_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $product_name = $row['product_name'];
        $qty = $row['quantity'];

        // Cộng lại số lượng vào bảng product
        $update = $conn->prepare("UPDATE product SET qty_in_stock = qty_in_stock + ? WHERE name = ?");
        $update->bind_param("is", $qty, $product_name);
        $update->execute();
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Font Awesome -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
        integrity="sha512-Mz0f84lh4F+GoN2BQZ8/9kMwM0uJ3OPybOIoJleYz7/0bng++7Qf1IGuHD0MBuX+vH3YJjs7+bX0l1B1VItpXw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
    <title>Payment Cancelled</title>
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Roboto', sans-serif;
        }

        .cancel-container {
            max-width: 600px;
            margin: 100px auto;
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .cancel-icon {
            font-size: 80px;
            color: #dc3545;
        }

        .btn-home {
            border-radius: 30px;
            padding: 10px 30px;
        }
    </style>
</head>

<body>
    <div class="cancel-container text-center">
        <div class="mb-4">
            <i class="fas fa-times-circle cancel-icon"></i>
        </div>
        <h2 class="text-dark fw-bold">Payment Cancelled</h2>
        <br>
        <p class="text-muted">You have cancelled the payment process. No charges were made.</p>
        <a href="../../index.php" class="btn btn-outline-dark btn-home mt-3">
            <i class="fas fa-arrow-left me-2"></i> Return to HomePage
        </a>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>