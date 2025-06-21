<?php
require_once(__DIR__ . '/../../db/connect.php');
session_start();

if (!isset($_SESSION['username']) || !isset($_GET['id'])) {
    echo json_encode(['type' => null]);
    exit;
}

$notiId = intval($_GET['id']);
$stmt = $conn->prepare("SELECT type FROM notifications WHERE id = ? LIMIT 1");
$stmt->bind_param("i", $notiId);
$stmt->execute();
$stmt->bind_result($type);
$stmt->fetch();
$stmt->close();

echo json_encode(['type' => $type]);
