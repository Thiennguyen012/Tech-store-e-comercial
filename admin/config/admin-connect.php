<?php
//Database configuration for Admin Panel
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "banhang";

try {
    // Tạo kết nối PDO cho admin panel
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    die("Kết nối admin thất bại: " . $e->getMessage());
}
?>
