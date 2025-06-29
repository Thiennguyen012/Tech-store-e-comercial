<?php
session_start();
require_once '../config/admin-connect.php';

// Check if user is admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != 0) {
    die('Access denied');
}

try {
    echo "<h2>Order Status Migration</h2>";
    echo "<p>Migrating numeric order statuses to string values...</p>";

    // Count existing records with numeric status
    $stmt = $conn->prepare("SELECT 
        COUNT(CASE WHEN order_status = 0 OR order_status IS NULL THEN 1 END) as pending_count,
        COUNT(CASE WHEN order_status = 1 THEN 1 END) as completed_count,
        COUNT(CASE WHEN order_status = 2 THEN 1 END) as cancelled_count,
        COUNT(CASE WHEN order_status NOT IN (0, 1, 2) AND order_status IS NOT NULL THEN 1 END) as already_migrated
        FROM bill");
    $stmt->execute();
    $counts = $stmt->fetch();

    echo "<div style='background: #f8f9fa; padding: 15px; margin: 10px 0; border-radius: 5px;'>";
    echo "<h4>Current Status Distribution:</h4>";
    echo "<ul>";
    echo "<li>Pending (0 or NULL): " . $counts['pending_count'] . " orders</li>";
    echo "<li>Completed (1): " . $counts['completed_count'] . " orders</li>";
    echo "<li>Cancelled (2): " . $counts['cancelled_count'] . " orders</li>";
    echo "<li>Already migrated (string values): " . $counts['already_migrated'] . " orders</li>";
    echo "</ul>";
    echo "</div>";

    if (isset($_POST['migrate'])) {
        $conn->beginTransaction();

        // Update status 0 and NULL to 'pending'
        $stmt = $conn->prepare("UPDATE bill SET order_status = 'pending' WHERE order_status = 0 OR order_status IS NULL");
        $stmt->execute();
        $pending_updated = $stmt->rowCount();

        // Update status 1 to 'paid'
        $stmt = $conn->prepare("UPDATE bill SET order_status = 'paid' WHERE order_status = 1");
        $stmt->execute();
        $paid_updated = $stmt->rowCount();

        // Update status 2 to 'cancelled'
        $stmt = $conn->prepare("UPDATE bill SET order_status = 'cancelled' WHERE order_status = 2");
        $stmt->execute();
        $cancelled_updated = $stmt->rowCount();

        $conn->commit();

        echo "<div style='background: #d4edda; border: 1px solid #c3e6cb; color: #155724; padding: 15px; margin: 10px 0; border-radius: 5px;'>";
        echo "<h4>✅ Migration Completed Successfully!</h4>";
        echo "<ul>";
        echo "<li>Updated $pending_updated orders to 'pending'</li>";
        echo "<li>Updated $paid_updated orders to 'paid'</li>";
        echo "<li>Updated $cancelled_updated orders to 'cancelled'</li>";
        echo "</ul>";
        echo "<p><strong>Total updated:</strong> " . ($pending_updated + $paid_updated + $cancelled_updated) . " orders</p>";
        echo "</div>";

        echo "<p><a href='../modules/orders.php' class='btn btn-primary'>Go to Order Management</a></p>";

    } else {
        // Show migration form
        if ($counts['pending_count'] > 0 || $counts['completed_count'] > 0 || $counts['cancelled_count'] > 0) {
            echo "<form method='POST'>";
            echo "<div style='background: #fff3cd; border: 1px solid #ffeaa7; color: #856404; padding: 15px; margin: 10px 0; border-radius: 5px;'>";
            echo "<h4>⚠️ Migration Required</h4>";
            echo "<p>This will update your database to use string status values ('pending', 'paid', 'cancelled') instead of numeric values (0, 1, 2).</p>";
            echo "<p><strong>What will happen:</strong></p>";
            echo "<ul>";
            echo "<li>Status 0 and NULL → 'pending'</li>";
            echo "<li>Status 1 → 'paid'</li>";
            echo "<li>Status 2 → 'cancelled'</li>";
            echo "</ul>";
            echo "<p><strong>This action cannot be undone. Please backup your database before proceeding.</strong></p>";
            echo "</div>";
            
            echo "<button type='submit' name='migrate' class='btn btn-warning' onclick='return confirm(\"Are you sure you want to migrate the order statuses? This cannot be undone!\")'>🔄 Migrate Order Status Values</button>";
            echo "</form>";
        } else {
            echo "<div style='background: #d4edda; border: 1px solid #c3e6cb; color: #155724; padding: 15px; margin: 10px 0; border-radius: 5px;'>";
            echo "<h4>✅ No Migration Needed</h4>";
            echo "<p>All orders already use string status values or there are no orders to migrate.</p>";
            echo "</div>";
        }
    }

} catch (Exception $e) {
    if (isset($conn) && $conn->inTransaction()) {
        $conn->rollback();
    }
    echo "<div style='background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; padding: 15px; margin: 10px 0; border-radius: 5px;'>";
    echo "<h4>❌ Migration Failed</h4>";
    echo "<p>Error: " . $e->getMessage() . "</p>";
    echo "</div>";
}
?>

<style>
body { 
    font-family: Arial, sans-serif; 
    margin: 20px; 
    background: #f5f5f5; 
}
.btn {
    display: inline-block;
    padding: 10px 20px;
    margin: 5px;
    text-decoration: none;
    border-radius: 5px;
    border: none;
    cursor: pointer;
    font-size: 14px;
}
.btn-primary { 
    background: #007bff; 
    color: white; 
}
.btn-warning { 
    background: #ffc107; 
    color: #212529; 
}
.btn:hover { 
    opacity: 0.8; 
}
</style>
