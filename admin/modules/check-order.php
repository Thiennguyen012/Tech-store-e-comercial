<?php
$servername = "localhost";
$username = "root"; 
$password = "";
$dbname = "banhang";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
    // Check if order exists
    $stmt = $conn->prepare("SELECT id, order_status FROM bill WHERE id = ?");
    $stmt->execute([69]);
    $order = $stmt->fetch();
    
    if ($order) {
        echo "Order 69 exists. Current status: " . ($order['order_status'] ?? 'NULL') . "<br>";
        
        // Try updating
        $stmt = $conn->prepare("UPDATE bill SET order_status = ? WHERE id = ?");
        $result = $stmt->execute([1, 69]);
        echo "Update result: " . ($result ? 'true' : 'false') . "<br>";
        echo "Rows affected: " . $stmt->rowCount() . "<br>";
        
        // Check again
        $stmt = $conn->prepare("SELECT id, order_status FROM bill WHERE id = ?");
        $stmt->execute([69]);
        $order = $stmt->fetch();
        echo "New status: " . ($order['order_status'] ?? 'NULL');
    } else {
        echo "Order 69 does not exist.<br>";
        
        // Show last few orders
        $stmt = $conn->query("SELECT id, order_status FROM bill ORDER BY id DESC LIMIT 10");
        echo "Recent orders:<br>";
        while ($row = $stmt->fetch()) {
            echo "ID: {$row['id']}, Status: " . ($row['order_status'] ?? 'NULL') . "<br>";
        }
    }
} catch(PDOException $e) {
    echo "Database error: " . $e->getMessage();
}
?>
