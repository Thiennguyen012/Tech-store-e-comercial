<?php
session_start();
require_once __DIR__ . '/../../db/connect.php';

// Kiểm tra đăng nhập
if (!isset($_SESSION['username'])) {
    echo json_encode(['success' => false, 'message' => 'Please log in to cancel orders']);
    exit;
}

// Kiểm tra method và dữ liệu
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['order_id'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
    exit;
}

$order_id = (int)$_POST['order_id'];

try {
    // Lấy thông tin user
    $username = $_SESSION['username'];
    $sqlUser = "SELECT id FROM site_user WHERE username = ?";
    $stmtUser = $conn->prepare($sqlUser);
    $stmtUser->bind_param("s", $username);
    $stmtUser->execute();
    $resultUser = $stmtUser->get_result();
    $userData = $resultUser->fetch_assoc();
    
    if (!$userData) {
        echo json_encode(['success' => false, 'message' => 'User not found']);
        exit;
    }
    
    $userId = $userData['id'];
    
    // Kiểm tra đơn hàng có thuộc về user này và có trạng thái Pending không
    $sqlCheck = "SELECT id, order_status, order_paymethod FROM bill WHERE id = ? AND user_id = ?";
    $stmtCheck = $conn->prepare($sqlCheck);
    $stmtCheck->bind_param("ii", $order_id, $userId);
    $stmtCheck->execute();
    $resultCheck = $stmtCheck->get_result();
    $orderData = $resultCheck->fetch_assoc();
    
    if (!$orderData) {
        echo json_encode(['success' => false, 'message' => 'Order not found or access denied']);
        exit;
    }
    
    // Kiểm tra trạng thái đơn hàng
    $currentStatus = $orderData['order_status'];
    if ($currentStatus !== 'Pending' && $currentStatus !== null && $currentStatus !== '') {
        echo json_encode(['success' => false, 'message' => 'Only pending orders can be cancelled']);
        exit;
    }
    
    // Bắt đầu transaction
    $conn->autocommit(false);
    
    // Lấy danh sách sản phẩm trong đơn hàng
    $sqlItems = "SELECT product_name, quantity FROM checkout_cart WHERE bill_id = ?";
    $stmtItems = $conn->prepare($sqlItems);
    $stmtItems->bind_param("i", $order_id);
    $stmtItems->execute();
    $resultItems = $stmtItems->get_result();
    
    $items = [];
    while ($row = $resultItems->fetch_assoc()) {
        $items[] = $row;
    }
    
    if (empty($items)) {
        echo json_encode(['success' => false, 'message' => 'No items found in this order']);
        $conn->rollback();
        exit;
    }
    
    // Hoàn trả số lượng sản phẩm vào kho
    foreach ($items as $item) {
        $sqlRestore = "UPDATE product SET qty_in_stock = qty_in_stock + ? WHERE name = ?";
        $stmtRestore = $conn->prepare($sqlRestore);
        $stmtRestore->bind_param("is", $item['quantity'], $item['product_name']);
        
        if (!$stmtRestore->execute()) {
            echo json_encode(['success' => false, 'message' => 'Failed to restore product quantity']);
            $conn->rollback();
            exit;
        }
    }
    
    // Cập nhật trạng thái đơn hàng thành Cancelled
    $sqlUpdate = "UPDATE bill SET order_status = 'Cancelled' WHERE id = ?";
    $stmtUpdate = $conn->prepare($sqlUpdate);
    $stmtUpdate->bind_param("i", $order_id);
    
    if (!$stmtUpdate->execute()) {
        echo json_encode(['success' => false, 'message' => 'Failed to update order status']);
        $conn->rollback();
        exit;
    }
    
    // Commit transaction
    $conn->commit();
    $conn->autocommit(true);
    
    // Kiểm tra phương thức thanh toán để đưa ra thông báo phù hợp
    $paymentMethod = $orderData['order_paymethod'];
    $isOnlinePayment = ($paymentMethod == 1);
    
    echo json_encode([
        'success' => true, 
        'message' => 'Order cancelled successfully!',
        'is_online_payment' => $isOnlinePayment
    ]);
    
} catch (Exception $e) {
    // Rollback nếu có lỗi
    $conn->rollback();
    $conn->autocommit(true);
    
    error_log("Error cancelling order: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'An error occurred while cancelling the order']);
}
?>
