<?php
// Simple test without session
$servername = "localhost";
$username = "root"; 
$password = "";
$dbname = "banhang";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
    if (isset($_POST['order_id']) && isset($_POST['status'])) {
        $stmt = $conn->prepare("UPDATE bill SET order_status = ? WHERE id = ?");
        $result = $stmt->execute([$_POST['status'], $_POST['order_id']]);
        
        if ($result && $stmt->rowCount() > 0) {
            echo json_encode(['success' => true, 'message' => 'Order status updated successfully!', 'rowCount' => $stmt->rowCount()]);
        } else {
            echo json_encode(['success' => false, 'message' => 'No order found or no changes made', 'rowCount' => $stmt->rowCount()]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Missing parameters']);
    }
} catch(PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
?>
