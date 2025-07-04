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

<!-- Modal xác nhận hủy đơn hàng -->
<div class="modal fade" id="confirmCancelModal" tabindex="-1" aria-labelledby="confirmCancelModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header confirm-modal-header d-flex justify-content-between">
                <h5 class="modal-title confirm-modal-title" id="confirmCancelModalLabel">Confirm Cancellation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <h4 class="mb-3">Cancel Order <span id="orderIdDisplay" class="text-success"></span>?</h4>
                <p class="text-muted mb-4">Are you sure you want to cancel this order? This action cannot be undone and the product quantities will be restored to inventory.</p>
                <div class="alert alert-success">
                    <strong>Note:</strong> If you have already made a payment, you will need to contact our support team for refund processing.
                </div>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-arrow-left me-1"></i> Keep Order
                </button>
                <button type="button" class="btn btn-dark" id="confirmCancelBtn">
                    <i class="fas fa-times me-1"></i> Yes, Cancel Order
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal thông báo hủy đơn hàng -->
<div class="modal fade" id="cancelOrderModal" tabindex="-1" aria-labelledby="cancelOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cancelOrderModalLabel">
                    <i class="fas fa-check-circle text-success me-2"></i>Order Cancelled
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="cancelSuccessMessage">
                    <div class="text-center mb-3">
                        <i class="fas fa-check-circle text-success" style="font-size: 3rem;"></i>
                    </div>
                    <p class="text-center mb-3">Your order has been cancelled successfully and product quantities have been restored to inventory.</p>
                </div>
                <div id="onlinePaymentWarning" class="alert alert-warning" style="display: none;">
                    <h6><i class="fas fa-exclamation-triangle me-2"></i>Important Notice</h6>
                    <p class="mb-2">Since you have already made an online payment for this order, please contact our support team for refund processing.</p>
                    <div class="mt-3">
                        <button type="button" class="btn btn-success btn-sm" onclick="goToContact()">
                            <i class="fas fa-envelope me-1"></i> Contact Support
                        </button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
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

                // Đếm số đơn hàng trả về trong lần này
                const orderCount = (data.match(/class="border rounded-4/g) || []).length;

                // Ẩn nút nếu không còn dữ liệu, có thông báo trống, hoặc số đơn hàng trả về < limit
                if (!data.trim() || data.includes('data-empty="true"') || orderCount < limit) {
                    document.getElementById("loadMoreBtn").style.display = "none";
                }
            });
    }

    function cancelOrder(orderId) {
        // Lưu orderId để sử dụng sau khi confirm
        window.currentOrderToCancel = orderId;
        
        // Cập nhật order ID trong modal
        document.getElementById('orderIdDisplay').textContent = '#' + orderId;
        
        // Hiển thị modal confirm
        const confirmModal = new bootstrap.Modal(document.getElementById('confirmCancelModal'));
        confirmModal.show();
    }

    function executeCancelOrder(orderId) {
        // Thêm loading state cho nút
        const confirmBtn = document.getElementById('confirmCancelBtn');
        const originalText = confirmBtn.innerHTML;
        confirmBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Cancelling...';
        confirmBtn.disabled = true;

        const formData = new FormData();
        formData.append('order_id', orderId);

        fetch('module/user-order/cancel-order.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            // Reset nút về trạng thái ban đầu
            confirmBtn.innerHTML = originalText;
            confirmBtn.disabled = false;

            if (data.success) {
                // Hiển thị modal thông báo thành công
                showCancelSuccessModal(data.is_online_payment);
                
                // Reload lại danh sách đơn hàng
                document.getElementById("order-list").innerHTML = '';
                offset = 0;
                document.getElementById("loadMoreBtn").style.display = "block";
                loadMoreOrders();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            // Reset nút về trạng thái ban đầu
            confirmBtn.innerHTML = originalText;
            confirmBtn.disabled = false;
            
            console.error('Error:', error);
            alert('An error occurred while cancelling the order');
        });
    }

    function showCancelSuccessModal(isOnlinePayment) {
        const modal = document.getElementById('cancelOrderModal');
        const onlinePaymentWarning = document.getElementById('onlinePaymentWarning');
        
        if (isOnlinePayment) {
            onlinePaymentWarning.style.display = 'block';
        } else {
            onlinePaymentWarning.style.display = 'none';
        }
        
        // Hiển thị modal (sử dụng Bootstrap modal)
        const bsModal = new bootstrap.Modal(modal);
        bsModal.show();
    }

    function goToContact() {
        // Đóng modal trước
        const modal = bootstrap.Modal.getInstance(document.getElementById('cancelOrderModal'));
        if (modal) {
            modal.hide();
        }
        
        // Thử sử dụng loadPage function nếu tồn tại
        if (typeof loadPage === 'function') {
            loadPage('module/contact/contact.php', null, 'contact');
        } else {
            // Fallback: reload trang với hash
            window.location.href = 'index.php#contact';
            window.location.reload();
        }
    }

    document.getElementById("loadMoreBtn").addEventListener("click", loadMoreOrders);
    document.addEventListener("DOMContentLoaded", loadMoreOrders);

    // Event listener cho nút confirm cancel trong modal
    document.getElementById("confirmCancelBtn").addEventListener("click", function() {
        // Đóng modal confirm
        const confirmModal = bootstrap.Modal.getInstance(document.getElementById('confirmCancelModal'));
        if (confirmModal) {
            confirmModal.hide();
        }
        
        // Thực hiện hủy đơn hàng
        if (window.currentOrderToCancel) {
            executeCancelOrder(window.currentOrderToCancel);
            window.currentOrderToCancel = null;
        }
    });
</script>