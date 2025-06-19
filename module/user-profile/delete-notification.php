<?php
require_once(__DIR__ . '/../../db/connect.php');
if (session_status() === PHP_SESSION_NONE) session_start();

if (!isset($_SESSION['username'])) {
    http_response_code(401);
    echo "Not logged in";
    exit;
}

$username = $_SESSION['username'];
$notiId = $_POST['id'] ?? 0;

// Kiểm tra người dùng có quyền xóa thông báo này
$sql = "DELETE n FROM notifications n 
        JOIN site_user u ON n.user_id = u.id 
        WHERE n.id = ? AND u.username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $notiId, $username);
$stmt->execute();

echo "success";
