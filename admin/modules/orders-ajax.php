<?php
session_start();

// Kết nối cơ sở dữ liệu cho Admin Panel
$servername = "localhost";
$username = "root"; 
$password = "";
$dbname = "banhang";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Kiểm tra xem người dùng có phải admin không
if (!isset($_SESSION['role']) || $_SESSION['role'] != 0) {
    echo json_encode(['success' => false, 'message' => 'Access denied']);
    exit;
}

if (isset($_POST['action']) && $_POST['action'] == 'mark_orders_viewed') {
    try {
        $admin_id = $_SESSION['user_id'] ?? 0;
        
        // Kiểm tra xem bản ghi admin có tồn tại không
        $check_stmt = $conn->prepare("SELECT id FROM admin_order_views WHERE admin_user_id = ?");
        $check_stmt->execute([$admin_id]);
        
        if ($check_stmt->fetch()) {
            // Cập nhật bản ghi hiện có
            $update_stmt = $conn->prepare("UPDATE admin_order_views SET last_view_time = NOW() WHERE admin_user_id = ?");
            $update_stmt->execute([$admin_id]);
        } else {
            // Thêm bản ghi mới
            $insert_stmt = $conn->prepare("INSERT INTO admin_order_views (admin_user_id, last_view_time) VALUES (?, NOW())");
            $insert_stmt->execute([$admin_id]);
        }
        
        echo json_encode(['success' => true, 'message' => 'Orders marked as viewed']);
        exit;
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        exit;
    }
} elseif (isset($_POST['action']) && $_POST['action'] == 'update_status' && isset($_POST['order_id']) && isset($_POST['status'])) {
    // Debug log
    error_log("Order status update attempt: order_id=" . $_POST['order_id'] . ", status=" . $_POST['status']);
    
    try {
        // Đầu tiên kiểm tra xem đơn hàng có tồn tại không
        $check_stmt = $conn->prepare("SELECT id, order_status FROM bill WHERE id = ?");
        $check_stmt->execute([$_POST['order_id']]);
        $existing_order = $check_stmt->fetch();
        
        if (!$existing_order) {
            echo json_encode(['success' => false, 'message' => 'Order not found with ID: ' . $_POST['order_id']]);
            exit;
        }
        
        // Kiểm tra xem trạng thái đã giống như vậy chưa
        if ($existing_order['order_status'] == $_POST['status']) {
            echo json_encode(['success' => true, 'message' => 'Order status is already set to this value']);
            exit;
        }
        
        // Cập nhật trạng thái
        $stmt = $conn->prepare("UPDATE bill SET order_status = ? WHERE id = ?");
        $result = $stmt->execute([$_POST['status'], $_POST['order_id']]);
        
        if ($result && $stmt->rowCount() > 0) {
            echo json_encode(['success' => true, 'message' => 'Order status updated successfully!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Update failed. Rows affected: ' . $stmt->rowCount()]);
        }
        exit;
    } catch (Exception $e) {
        error_log("Order status update error: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        exit;
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
?>
