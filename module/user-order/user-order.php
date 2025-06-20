<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../../db/connect.php';

if (!isset($_SESSION['username'])) {
    echo '<div class="alert alert-warning text-center mt-4">Please log in to view your orders.</div>';
    exit;
}

// Lấy ID của user hiện tại
$username = $_SESSION['username'];
$sqlUser = "SELECT id FROM site_user WHERE username = ?";
$stmtUser = $conn->prepare($sqlUser);
$stmtUser->bind_param("s", $username);
$stmtUser->execute();
$resultUser = $stmtUser->get_result();
$userData = $resultUser->fetch_assoc();

if (!$userData) {
    echo '<div class="alert alert-danger text-center mt-4">User not found.</div>';
    exit;
}

$userId = $userData['id'];
?>

<div class="container mt-5 bg-white shadow rounded p-5 mb-5 mt-5">
    <h2 class="mb-4 fw-bold">Your Orders</h2>

    <div id="order-list"></div>
    <div class="text-center">
        <button id="loadMoreBtn" class="btn btn-outline-dark px-4 rounded-pill mt-4">Show more</button>
    </div>
</div>

<script>
    let offset = 0;
    const limit = 3;

    function loadMoreOrders() {
        fetch(`module/user-order/load-more-orders.php?offset=${offset}`)
            .then(response => response.text())
            .then(data => {
                document.getElementById("order-list").insertAdjacentHTML("beforeend", data);
                offset += limit;

                if (!data.trim()) {
                    document.getElementById("loadMoreBtn").style.display = "none";
                }
            });
    }

    document.getElementById("loadMoreBtn").addEventListener("click", loadMoreOrders);
    document.addEventListener("DOMContentLoaded", loadMoreOrders);
</script>