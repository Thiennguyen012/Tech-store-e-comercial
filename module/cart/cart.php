<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ✅ Xử lý xóa sản phẩm
if (isset($_GET['delid'])) {
    $id = $_GET['delid'];
    if (isset($_SESSION['cart'][$id])) {
        unset($_SESSION['cart'][$id]);
    }
}
// Nếu là POST -> xử lý thêm vào giỏ hàng
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product-id'])) {
    $id = $_POST['product-id'];
    $name = $_POST['product-name'];
    $price = $_POST['product-price'];
    $img = $_POST['product-img'];
    $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]['quantity'] += $quantity;
    } else {
        $_SESSION['cart'][$id] = [
            'id' => $id,
            'name' => $name,
            'price' => $price,
            'img' => $img,
            'quantity' => $quantity
        ];
    }

    // Tổng số lượng
    $total = 0;
    foreach ($_SESSION['cart'] as $item) {
        $total += $item['quantity'];
    }
    echo json_encode(['success' => true, 'total' => $total]);
    exit;
}

// ✅ Hàm hiển thị giỏ hàng
function showCart()
{
    if (isset($_SESSION['cart']) && is_array($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
        foreach ($_SESSION['cart'] as $id => $item) {
            $name = $item['name'];
            $price = (float)$item['price'];
            $img = $item['img'];
            $quantity = (int)$item['quantity'];
            $subtotal = $price * $quantity;

            echo '<tr class="cart-item">
                <td>
                    <div class="d-flex align-items-center">
                        <img src="' . htmlspecialchars($img) . '" alt="' . htmlspecialchars($name) . '" class="me-3" style="width: 80px;">
                        <div>
                            <div><strong>' . htmlspecialchars($name) . '</strong></div>
                            <div><strong>Price</strong>: $' . number_format($price, 2) . '</div>
                            <a href="?act=cart&delid=' . $id . '" class="remove-link text-danger fw-bold">Remove</a>
                        </div>
                    </div>
                </td>
                <td class="text-center">
                    <input type="number" class="form-control text-center mx-auto" value="' . $quantity . '" min="1" style="width: 60px;">
                </td>
                <td class="text-end">$' . number_format($subtotal, 2) . '</td>
            </tr>';
        }
    } else {
        echo '
        <tr><td colspan="3" class="text-center text-muted fs-5"><br></br>Your cart is empty.<br></br></td></tr>';
    }
}
?>

<!-- ✅ HTML GIỎ HÀNG -->
<div class="container py-5 bg-white p-4 rounded shadow my-4">
    <h2 class="mb-4 fw-semibold">Shopping Cart</h2>
    <table class="table align-middle">
        <thead>
            <tr>
                <th class="text-start">Product</th>
                <th class="text-center" style="width: 120px;">Quantity</th>
                <th class="text-end" style="width: 120px;">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php showCart(); ?>
        </tbody>
    </table>

    <!-- Có thể tính tổng ở đây nếu muốn -->
    <div class="row justify-content-end mb-3">
        <div class="col-md-4">
            <table class="table">
                <tr>
                    <td><strong>Subtotal</strong></td>
                    <td class="text-end">
                        <?php
                        $totalAmount = 0;
                        if (isset($_SESSION['cart'])) {
                            foreach ($_SESSION['cart'] as $item) {
                                $totalAmount += $item['price'] * $item['quantity'];
                            }
                        }
                        echo '$' . number_format($totalAmount, 2);
                        ?>
                    </td>
                </tr>
                <tr>
                    <td><strong>Tax</strong></td>
                    <td class="text-end">
                        <?php
                        $tax = $totalAmount * 0.1;
                        echo '$' . number_format($tax, 2);
                        ?>
                    </td>
                </tr>
                <tr>
                    <td><strong>Total</strong></td>
                    <td class="text-end"><strong><?php echo '$' . number_format($totalAmount + $tax, 2); ?></strong></td>
                </tr>

            </table>
            <button class="btn btn-dark w-100 rounded-4" onclick="checkCartBeforeCheckout()">Check Out</button>
        </div>
    </div>
</div>
<script>
    function checkCartBeforeCheckout() {
        const cartHasItem = <?= isset($_SESSION['cart']) && count($_SESSION['cart']) > 0 ? 'true' : 'false' ?>;

        if (!cartHasItem) {
            alert("Your cart is empty. Please add some products before checking out.");
        } else {
            window.location.href = '?act=checkout';
        }
    }
</script>