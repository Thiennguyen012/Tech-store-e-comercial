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
        // Kiểm tra xem đơn hàng có tồn tại không
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
        
        // Kiểm tra nếu đơn hàng đã bị hủy thì không cho phép thay đổi trạng thái
        if ($existing_order['order_status'] === 'Cancelled') {
            echo json_encode(['success' => false, 'message' => 'Cannot change status of a cancelled order']);
            exit;
        }
        
        // Xử lý hoàn trả sản phẩm khi chuyển sang trạng thái Cancelled
        if ($_POST['status'] === 'Cancelled' && $existing_order['order_status'] !== 'Cancelled') {
            try {
                // Lấy danh sách sản phẩm trong đơn hàng từ checkout_cart
                $items_stmt = $conn->prepare("
                    SELECT product_name, quantity 
                    FROM checkout_cart 
                    WHERE bill_id = ?
                ");
                $items_stmt->execute([$_POST['order_id']]);
                $order_items = $items_stmt->fetchAll();
                
                // Hoàn trả số lượng sản phẩm vào kho
                foreach ($order_items as $item) {
                    $update_stock_stmt = $conn->prepare("
                        UPDATE product 
                        SET qty_in_stock = qty_in_stock + ? 
                        WHERE name = ?
                    ");
                    $update_stock_stmt->execute([$item['quantity'], $item['product_name']]);
                    
                    // Log việc hoàn trả để debug
                    error_log("Restored {$item['quantity']} units of product '{$item['product_name']}' for cancelled order #{$_POST['order_id']}");
                }
                
                // Cập nhật trạng thái đơn hàng
                $stmt = $conn->prepare("UPDATE bill SET order_status = ? WHERE id = ?");
                $result = $stmt->execute([$_POST['status'], $_POST['order_id']]);
                
                if ($result && $stmt->rowCount() > 0) {
                    echo json_encode([
                        'success' => true, 
                        'message' => 'Order cancelled successfully and product quantities restored to inventory!'
                    ]);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Failed to update order status']);
                }
                
            } catch (Exception $e) {
                error_log("Error restoring inventory for cancelled order: " . $e->getMessage());
                echo json_encode(['success' => false, 'message' => 'Error cancelling order: ' . $e->getMessage()]);
            }
        } else {
            // Cập nhật trạng thái bình thường cho các trường hợp khác
            $stmt = $conn->prepare("UPDATE bill SET order_status = ? WHERE id = ?");
            $result = $stmt->execute([$_POST['status'], $_POST['order_id']]);
            
            if ($result && $stmt->rowCount() > 0) {
                echo json_encode(['success' => true, 'message' => 'Order status updated successfully!']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Update failed. Rows affected: ' . $stmt->rowCount()]);
            }
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
