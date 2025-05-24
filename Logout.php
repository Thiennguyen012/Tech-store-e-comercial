<?php
session_start();             // Bắt đầu session
session_unset();             // Xóa tất cả các biến session
session_destroy();           // Hủy session hoàn toàn

// Điều hướng về trang chủ
header("Location: index.php");
exit();
?>