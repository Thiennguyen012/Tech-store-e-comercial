<?php include 'module/cart/showcart.php';
$username = $_SESSION['username'] ?? '';

$user = null;
if ($username) {
    $sql = "SELECT name, phone, address FROM site_user WHERE username = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);
}
?>
<div class="container py-5 bg-white p-4 rounded shadow my-4">
    <h2 class="mb-4 fw-semibold">Checkout</h2>
    <div class="row">
        <!-- LEFT: Cart items -->
        <div class="col-md-7">
            <h4 class="mb-3">List Products in your Cart</h4>
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

            <!-- Order Summary -->
            <div class="mt-4">
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
            </div>
        </div>

        <!-- RIGHT: Shipping info -->
        <div class="col-md-5 p-4 rounded-3" style="background-color: #f8f9fa">
            <h4 class="mb-3">Shipping Information</h4>

            <!-- Địa chỉ từ database -->
            <div class="mb-4 p-3 border rounded bg-white shadow-sm">
                <h6>Default Information</h6>
                <div id="default-info-content">
                    <!-- Sẽ được chèn từ JS -->
                </div>
            </div>

            <!-- Form nhập địa chỉ mới -->
            <div class="p-3 border rounded bg-white shadow-sm">
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" id="use-new-info">
                    <label class="form-check-label" for="use-new-info">
                        Use a different shipping infomation
                    </label>
                </div>

                <div id="new-info-fields" class="d-none">
                    <form id="new-info-form">
                        <div class="mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" class="form-control" name="hoten">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone</label>
                            <input type="tel" class="form-control" name="sdt">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Address Details</label>
                            <input type="text" class="form-control" name="diachi">
                        </div>
                    </form>
                </div>
            </div>
            <!-- pt thanh toán -->
            <div class="p-3 border rounded bg-white shadow-sm mt-4">
                <h6 class="mb-3">Payment Method</h6>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="payment_method" id="payment_cash" value="cash" checked>
                    <label class="form-check-label" for="payment_cash">
                        Cash on Delivery
                    </label>
                </div>
                <div class="form-check mt-2">
                    <input class="form-check-input" type="radio" name="payment_method" id="payment_vnpay" value="vnpay">
                    <label class="form-check-label" for="payment_vnpay">
                        VNPay
                    </label>
                </div>
            </div>

            <!-- Nút đặt hàng -->
            <div class="mt-4">
                <button class="btn btn-dark w-100 rounded-4" onclick="handlePlaceOrder()">Place Order</button>
            </div>
        </div>
    </div>
</div>
</div>
<script>
    const userInfo = <?= json_encode($user) ?>;

    const addressContent = document.getElementById('default-info-content');
    const checkbox = document.getElementById('use-new-info');
    const newAddressFields = document.getElementById('new-info-fields');

    if (userInfo && userInfo.address) {
        addressContent.innerHTML = `
      <p><strong>${userInfo.name}</strong></p>
      <p>Phone: ${userInfo.phone}</p>
      <p>Address: ${userInfo.address}</p>
    `;
    } else {
        addressContent.innerHTML = `<p class="text-muted">No default address available.</p>`;
    }

    checkbox.addEventListener('change', function() {
        if (this.checked) {
            newAddressFields.classList.remove('d-none');
        } else {
            newAddressFields.classList.add('d-none');
        }
    });

    // Xử lý khi đặt hàng
    function handlePlaceOrder() {
        const checkbox = document.getElementById('use-new-info');
        const useNew = checkbox.checked;

        let shippingInfo = {};

        if (useNew) {
            // Lấy thông tin từ form nhập mới
            const form = document.getElementById('new-info-form');
            const hoten = form.hoten.value.trim();
            const sdt = form.sdt.value.trim();
            const diachi = form.diachi.value.trim();

            if (!hoten || !sdt || !diachi) {
                alert("Please fill in all new address fields.");
                return;
            }

            shippingInfo = {
                name: hoten,
                phone: sdt,
                address: diachi
            };
        } else {
            // Lấy từ dữ liệu user đã load từ PHP
            if (!userInfo || !userInfo.address) {
                alert("No default address available. Please enter a new address.");
                return;
            }

            shippingInfo = {
                name: userInfo.name,
                phone: userInfo.phone,
                address: userInfo.address
            };
        }

        // ✅ Kiểm tra phương thức thanh toán
        const selectedMethod = document.querySelector('input[name="payment_method"]:checked');
        if (!selectedMethod) {
            alert("Please select a payment method.");
            return;
        }

        const paymentMethod = selectedMethod.value;

        // ✅ Kiểm tra giỏ hàng không rỗng (từ PHP chuyển sang JS)
        const cartHasItem = <?= isset($_SESSION['cart']) && count($_SESSION['cart']) > 0 ? 'true' : 'false' ?>;
        if (!cartHasItem) {
            alert("Your cart is empty. Please add products before placing the order.");
            return;
        }

        // ✅ Gửi đơn hàng hoặc hiển thị (demo)
        console.log("Placing order with info:");
        console.log("Shipping Info:", shippingInfo);
        console.log("Payment Method:", paymentMethod);

        alert("Order placed successfully with " + paymentMethod.toUpperCase());

        // TODO: You can send the order via fetch() here
        // Example:
        /*
        fetch('process_order.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ shippingInfo, paymentMethod })
        })
        .then(res => res.json())
        .then(data => {
          alert(data.message || "Order placed!");
        })
        .catch(err => {
          console.error("Error:", err);
          alert("Failed to place order.");
        });
        */
    }
</script>