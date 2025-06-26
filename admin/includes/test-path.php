<?php
echo "<h3>Path Test</h3>";
echo "__DIR__: " . __DIR__ . "<br>";
echo "dirname(__DIR__): " . dirname(__DIR__) . "<br>";
echo "Config path: " . dirname(__DIR__) . '/config/admin-connect.php' . "<br>";
echo "File exists: " . (file_exists(dirname(__DIR__) . '/config/admin-connect.php') ? 'YES' : 'NO') . "<br>";

if (file_exists(dirname(__DIR__) . '/config/admin-connect.php')) {
    require_once dirname(__DIR__) . '/config/admin-connect.php';
    echo "Database connection: " . (isset($conn) ? 'SUCCESS' : 'FAILED');
} else {
    echo "Config file not found!";
}
?>
