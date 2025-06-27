<?php
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
<tr>
    <td colspan="3" class="text-center text-muted fs-5"><br></br>Your cart is empty.<br></br></td>
</tr>';
    }
}

function calculateTotal()
{
    $total = 0;
    if (isset($_SESSION['cart']) && is_array($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
        foreach ($_SESSION['cart'] as $id => $item) {
            $name = $item['name'];
            $price = (float)$item['price'];
            $img = $item['img'];
            $quantity = (int)$item['quantity'];
            $subtotal = $price * $quantity;

            $total += $subtotal;
        }
    }
    return $total;
}

function newBillOrder($conn, $userId, $name, $phone, $address, $total, $paymentMethod)
{
    // Chuẩn bị câu lệnh SQL an toàn
    $stmt = $conn->prepare("INSERT INTO bill (user_id, order_name, order_phone, order_address, order_total, order_paymethod) 
                            VALUES (?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    // Gắn giá trị vào câu lệnh
    $stmt->bind_param("isssdi", $userId, $name, $phone, $address, $total, $paymentMethod);

    // Thực thi
    if ($stmt->execute()) {
        // Trả về ID đơn hàng vừa tạo
        return $stmt->insert_id;
    } else {
        return false;
    }
}

function newCheckoutCart($conn, $product_name, $product_image, $price, $quantity, $total, $bill_id)
{
    // Chuẩn bị câu SQL an toàn
    $stmt = $conn->prepare("INSERT INTO checkout_cart (product_name, product_image, price, quantity, total, bill_id)
                            VALUES (?, ?, ?, ?, ?, ?)");

    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    // Gắn dữ liệu vào câu lệnh
    $stmt->bind_param("ssdddi", $product_name, $product_image, $price, $quantity, $total, $bill_id);

    // Thực thi câu lệnh
    if (!$stmt->execute()) {
        echo "Failed to insert cart item: " . $stmt->error;
    }

    // Đóng statement (không đóng connection ở đây, để gọi nhiều lần nếu cần)
    $stmt->close();
}

function updatebillOrder($conn, $bill_id, $status)
{
    $stmt = $conn->prepare("UPDATE bill SET order_status = ? WHERE id = ?");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("si", $status, $bill_id);

    if (!$stmt->execute()) {
        echo "Failed to update order status: " . $stmt->error;
    }

    $stmt->close();
}
