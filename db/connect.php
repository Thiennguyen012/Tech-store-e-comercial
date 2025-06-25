<?php
//Database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "banhang";

try {
    // Tạo kết nối PDO
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    die("Kết nối thất bại: " . $e->getMessage());
}

// Giữ lại mysqli connection cho backward compatibility
$mysqli_conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối mysqli
if ($mysqli_conn->connect_error) {
    die("Kết nối mysqli thất bại: " . $mysqli_conn->connect_error);
}
?>