<?php
session_start();
require_once '../../db/connect.php';

if (isset($_POST['id'], $_SESSION['username'])) {
    $id = (int)$_POST['id'];

    $stmt = $conn->prepare("UPDATE notifications SET is_read = 1 WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}
