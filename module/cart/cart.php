<!-- Cart item details -->
<div class="container bg-white p-4 rounded shadow my-4">
    <h2 class="mb-4">Shopping cart</h2>
    <table class="table align-middle">
        <thead>
            <tr>
                <th class=>Product</th>
                <th class="text-center">Quantity</th>
                <th class="text-end">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <!-- Item 1 -->
            <tr class="cart-item">
                <td>
                    <div class="d-flex align-items-center">
                        <img src="https://i.imgur.com/OYQeYem.png" alt="Red T-shirt" class="me-3">
                        <div>
                            <div><strong>Red Printed Tshirt</strong></div>
                            <div>Price: $50.00</div>
                            <a href="#" class="remove-link">Remove</a>
                        </div>
                    </div>
                </td>
                <td class="text-center">
                    <input type="number" class="form-control text-center" value="1" min="1" style="width: 60px;">
                </td>
                <td class="text-end">$50.00</td>
            </tr>

            <!-- Item 2 -->
            <tr class="cart-item">
                <td>
                    <div class="d-flex align-items-center">
                        <img src="https://i.imgur.com/XRj6sAV.png" alt="Shoes" class="me-3">
                        <div>
                            <div><strong>Red Printed Tshirt</strong></div>
                            <div>Price: $75.00</div>
                            <a href="#" class="remove-link">Remove</a>
                        </div>
                    </div>
                </td>
                <td class="text-center align-items-center">
                    <input type="number" class="form-control text-center" value="1" min="1" style="width: 60px;">
                </td>
                <td class="text-end">$75.00</td>
            </tr>

            <!-- Item 3 -->
            <tr class="cart-item">
                <td>
                    <div class="d-flex align-items-center">
                        <img src="https://i.imgur.com/qQfE2kd.png" alt="Pants" class="me-3">
                        <div>
                            <div><strong>Red Printed Tshirt</strong></div>
                            <div>Price: $75.00</div>
                            <a href="#" class="remove-link">Remove</a>
                        </div>
                    </div>
                </td>
                <td class="text-center">
                    <input type="number" class="form-control text-center" value="1" min="1" style="width: 60px;">
                </td>
                <td class="text-end">$75.00</td>
            </tr>
        </tbody>
    </table>

    <div class="row justify-content-end">
        <div class="col-md-4">
            <table class="table">
                <tr>
                    <td><strong>Subtotal</strong></td>
                    <td class="text-end">$200.00</td>
                </tr>
                <tr>
                    <td><strong>Tax</strong></td>
                    <td class="text-end">$35.00</td>
                </tr>
                <tr>
                    <td><strong>Total</strong></td>
                    <td class="text-end"><strong>$235.00</strong></td>
                </tr>
            </table>
        </div>
    </div>
</div>