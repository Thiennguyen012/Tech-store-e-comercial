<?php
require_once(__DIR__ . '/../../db/connect.php');
session_start();

if (!isset($_SESSION['username'])) {
    echo 'not_logged_in';
    exit;
}

$username = $_SESSION['username'];
$stmt = $conn->prepare("SELECT id FROM site_user WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    echo 'user_not_found';
    exit;
}

$user_id = $user['id'];

$stmt = $conn->prepare("DELETE FROM notifications WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
if ($stmt->execute()) {
    echo 'success';
} else {
    echo 'error';
}
