<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Link awesome font -->
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer" />
    <!-- Link bootstrap icon -->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" />
    <!-- Link google font -->
    <link
        href="https://fonts.googleapis.com/css?family=Roboto&display=swap"
        rel="stylesheet" />
    <!-- bootstrap css -->
    <link rel="stylesheet" href="../../asset/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" href="cart-style.css">
    <link rel="stylesheet" href="../../asset/style.css" />
    <title>Your Cart</title>
</head>

<body>
    <!-- Cart item details -->
    <div class="small-container">
        <table>
            <tr>
                <th>Products</th>
                <th>Quantity</th>
                <th>Subtotal</th>
            </tr>
        </table>
    </div>
    <?php
    include '../../components//navbar.php'
    ?>

    <?php
    include '../../components/footer.php'
    ?>