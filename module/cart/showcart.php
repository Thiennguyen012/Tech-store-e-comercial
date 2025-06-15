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
