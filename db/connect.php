<?php
//Database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "banhang";

// Tạo kết nối MySQLi (connection gốc)
$conn = new mysqli($servername, $username, $password, $dbname);
$mysqli_conn = $conn; // Alias for backward compatibility

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
?>