<?php
require_once(__DIR__ . '/../../db/connect.php');
if (session_status() === PHP_SESSION_NONE) session_start();

if (!isset($_SESSION['username'])) {
    http_response_code(401);
    echo "Not logged in";
    exit;
}

// Lấy user_id
$username = $_SESSION['username'];
$stmt = $conn->prepare("SELECT id FROM site_user WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    http_response_code(404);
    echo "User not found";
    exit;
}

$user_id = $user['id'];

// Đánh dấu tất cả là đã đọc
$stmt = $conn->prepare("UPDATE notifications SET is_read = 1 WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();

echo "success";
