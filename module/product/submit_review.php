<?php
require_once __DIR__ . '/../../db/connect.php';
session_start();

$product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
$rating = isset($_POST['rating']) ? intval($_POST['rating']) : 0;
$comment = trim($_POST['comment'] ?? '');
$user_id = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : null;
$reviewer_name = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';

if ($product_id && $rating >= 1 && $rating <= 5 && $comment !== '') {
    if ($user_id) {
        $stmt = $conn->prepare("INSERT INTO product_review (product_id, user_id, reviewer_name, rating, comment, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
        $stmt->bind_param("iisis", $product_id, $user_id, $reviewer_name, $rating, $comment);
    } else {
        $stmt = $conn->prepare("INSERT INTO product_review (product_id, reviewer_name, rating, comment, created_at) VALUES (?, ?, ?, ?, NOW())");
        $stmt->bind_param("isis", $product_id, $reviewer_name, $rating, $comment);
    }
    $success = $stmt->execute();
    echo json_encode(['success' => $success]);
} else {
    echo json_encode(['success' => false]);
}
