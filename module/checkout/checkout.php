<?php include 'module/cart/showcart.php';
$username = $_SESSION['username'] ?? '';

if (!isset($_SESSION['username'])) {
    echo '<div class="text-center py-5 mt-5">
        <div class="mb-4"><i class="fas fa-user fa-3x text-muted"></i></div>
        <h4 class="text-muted mb-3">You are not logged in</h4>
        <p class="text-muted mb-4">Please login to do this action.</p>
        <button class="btn btn-dark rounded-4" onclick="location.href=\'Login.php\'">Login Now</button>
    </div>';
    return;
}
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
            <input type="hidden" name="db_name" value="<?= htmlspecialchars($user['name']) ?>">
            <input type="hidden" name="db_phone" value="<?= htmlspecialchars($user['phone']) ?>">
            <input type="hidden" name="db_address" value="<?= htmlspecialchars($user['address']) ?>">
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
                    <input type="hidden" name="use_new_info" id="use_new_info_hidden" value="0">
                    <label class="form-check-label" for="use-new-info">
                        Use a different shipping infomation
                    </label>
                </div>
                <!-- Thông tin người dùng nhập mới -->
                <div id="new-info-fields" class="d-none">

                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" class="form-control" name="form_name" id="form_name">
                    </div>
                    <div class=" mb-3">
                        <label class="form-label">Phone</label>
                        <input type="text" class="form-control" name="form_phone" id="form_phone">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Address Details</label>
                        <input type="text" class="form-control" name="form_address" id="form_address">
                    </div>

                </div>
            </div>
            <!-- Nút đặt hàng -->
            <div class="mt-4">
                <button value="Place Order" class="btn btn-dark w-100 rounded-4" onclick="handlePlaceOrder()">Place Order with Cash</button>
            </div>
            <div class="mt-4">
                <button value="Place Order" class="btn btn-dark w-100 rounded-4" onclick="handlePlaceOrderPayos()">Place Order with PayOS</button>
            </div>
            <!-- </form> -->
        </div>
    </div>
</div>
</div>
<script>
    // Kiểm tra xem người dùng có chọn sử dụng thông tin mới không
    document.getElementById('use-new-info').addEventListener('change', function() {
        document.getElementById('use_new_info_hidden').value = this.checked ? '1' : '0';
    });

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
        addressContent.innerHTML = `<p class="text-muted">No default address available.</p>
        <a class="text-success" href="#" onclick="location.href='index.php?act=profile';return false;">Update now!</a> `;
    }

    checkbox.addEventListener('change', function() {
        if (this.checked) {
            newAddressFields.classList.remove('d-none');
        } else {
            newAddressFields.classList.add('d-none');
        }
    });

    function handlePlaceOrder() {
        const checkbox = document.getElementById('use-new-info');
        const useNew = checkbox.checked;

        let name = '',
            phone = '',
            address = '';

        if (useNew) {
            const nameInput = document.getElementById('form_name');
            const phoneInput = document.getElementById('form_phone');
            const addressInput = document.getElementById('form_address');

            if (!nameInput || !phoneInput || !addressInput) {
                alert("Input fields not found in the DOM.");
                return;
            }

            name = nameInput.value.trim();
            phone = phoneInput.value.trim();
            address = addressInput.value.trim();

            if (!name || !phone || !address) {
                alert("Please fill in all new address fields.");
                return;
            }
        } else {
            if (!userInfo || !userInfo.address) {
                alert("No default address available. Please enter a new address.");
                return;
            }

            name = userInfo.name;
            phone = userInfo.phone;
            address = userInfo.address;
        }

        // ✅ Kiểm tra giỏ hàng
        const cartHasItem = <?= isset($_SESSION['cart']) && count($_SESSION['cart']) > 0 ? 'true' : 'false' ?>;
        if (!cartHasItem) {
            alert("Your cart is empty. Please add products before placing the order.");
            return;
        }

        // ✅ Tạo form ẩn để POST dữ liệu sang checkout-result.php
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = 'index.php?act=checkout-result';
        form.style.display = 'none';
        form.appendChild(createInput('use_new_info', useNew ? '1' : '0'));

        form.appendChild(createInput('db_name', userInfo.name));
        form.appendChild(createInput('db_phone', userInfo.phone));
        form.appendChild(createInput('db_address', userInfo.address));
        form.appendChild(createInput('form_name', name));
        form.appendChild(createInput('form_phone', phone));
        form.appendChild(createInput('form_address', address));

        document.body.appendChild(form);
        form.submit();

        function createInput(name, value) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = name;
            input.value = value;
            return input;
        }
    }

    function handlePlaceOrderPayos() {
        const checkbox = document.getElementById('use-new-info');
        const useNew = checkbox.checked;

        let name = '',
            phone = '',
            address = '';

        if (useNew) {
            const nameInput = document.getElementById('form_name');
            const phoneInput = document.getElementById('form_phone');
            const addressInput = document.getElementById('form_address');

            if (!nameInput || !phoneInput || !addressInput) {
                alert("Input fields not found in the DOM.");
                return;
            }

            name = nameInput.value.trim();
            phone = phoneInput.value.trim();
            address = addressInput.value.trim();

            if (!name || !phone || !address) {
                alert("Please fill in all new address fields.");
                return;
            }
        } else {
            if (!userInfo || !userInfo.address) {
                alert("No default address available. Please enter a new address.");
                return;
            }

            name = userInfo.name;
            phone = userInfo.phone;
            address = userInfo.address;
        }
        // ✅ Kiểm tra giỏ hàng
        const cartHasItem = <?= isset($_SESSION['cart']) && count($_SESSION['cart']) > 0 ? 'true' : 'false' ?>;
        if (!cartHasItem) {
            alert("Your cart is empty. Please add products before placing the order.");
            return;
        }

        // ✅ Tạo form ẩn để POST dữ liệu sang checkout-result.php
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = 'module/checkout/payos_payment.php';
        form.style.display = 'none';
        form.appendChild(createInput('use_new_info', useNew ? '1' : '0'));

        form.appendChild(createInput('db_name', userInfo.name));
        form.appendChild(createInput('db_phone', userInfo.phone));
        form.appendChild(createInput('db_address', userInfo.address));

        form.appendChild(createInput('form_name', name));
        form.appendChild(createInput('form_phone', phone));
        form.appendChild(createInput('form_address', address));

        document.body.appendChild(form);
        form.submit();

        function createInput(name, value) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = name;
            input.value = value;
            return input;
        }
    }
</script>