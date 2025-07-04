<?php
session_start();

// Database connection for Admin Panel
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

// Check if user is admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != 0) {
    echo json_encode(['success' => false, 'message' => 'Access denied']);
    exit;
}

if (isset($_POST['action']) && $_POST['action'] == 'mark_orders_viewed') {
    try {
        $admin_id = $_SESSION['user_id'] ?? 0;
        
        // Check if admin record exists
        $check_stmt = $conn->prepare("SELECT id FROM admin_order_views WHERE admin_user_id = ?");
        $check_stmt->execute([$admin_id]);
        
        if ($check_stmt->fetch()) {
            // Update existing record
            $update_stmt = $conn->prepare("UPDATE admin_order_views SET last_view_time = NOW() WHERE admin_user_id = ?");
            $update_stmt->execute([$admin_id]);
        } else {
            // Insert new record
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
        // First check if order exists
        $check_stmt = $conn->prepare("SELECT id, order_status FROM bill WHERE id = ?");
        $check_stmt->execute([$_POST['order_id']]);
        $existing_order = $check_stmt->fetch();
        
        if (!$existing_order) {
            echo json_encode(['success' => false, 'message' => 'Order not found with ID: ' . $_POST['order_id']]);
            exit;
        }
        
        // Check if status is already the same
        if ($existing_order['order_status'] == $_POST['status']) {
            echo json_encode(['success' => true, 'message' => 'Order status is already set to this value']);
            exit;
        }
        
        // Update the status
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
