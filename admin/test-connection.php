<?php
// Test script to check database connection and admin functionality
session_start();
require_once '../db/connect.php';

echo "<h2>Database Connection Test</h2>";

try {
    // Test PDO connection
    $stmt = $conn->prepare("SELECT COUNT(*) as total FROM site_user");
    $stmt->execute();
    $result = $stmt->fetch();
    echo "<p>✅ PDO Connection OK - Total users: " . $result['total'] . "</p>";
    
    // Test admin user
    $stmt = $conn->prepare("SELECT * FROM site_user WHERE role = 0");
    $stmt->execute();
    $admin = $stmt->fetch();
    if ($admin) {
        echo "<p>✅ Admin user found: " . $admin['username'] . " (ID: " . $admin['id'] . ")</p>";
    } else {
        echo "<p>❌ No admin user found</p>";
    }
    
    // Test services table structure
    $stmt = $conn->prepare("DESCRIBE services");
    $stmt->execute();
    echo "<h3>Services Table Structure:</h3><ul>";
    while ($column = $stmt->fetch()) {
        echo "<li>" . $column['Field'] . " (" . $column['Type'] . ")</li>";
    }
    echo "</ul>";
    
} catch (Exception $e) {
    echo "<p>❌ Error: " . $e->getMessage() . "</p>";
}

echo "<h3>Session Info:</h3>";
echo "<pre>";
print_r($_SESSION);
echo "</pre>";
?>

<a href="../admin/home-page/admin.php">Go to Admin Panel</a><br>
<a href="../Login.php">Go to Login</a>
