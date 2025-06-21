<?php
require_once __DIR__ . '/../../db/connect.php';
session_start();

if (!isset($_SESSION['username'])) exit;

$username = $_SESSION['username'];
$stmtUser = $conn->prepare("SELECT id FROM site_user WHERE username = ?");
$stmtUser->bind_param("s", $username);
$stmtUser->execute();
$user = $stmtUser->get_result()->fetch_assoc();
if (!$user) exit;

$userId = $user['id'];
$offset = isset($_GET['offset']) ? (int)$_GET['offset'] : 0;
$limit = 10;

$stmt = $conn->prepare("SELECT id, name, phone, address, service_type, created_at FROM services WHERE user_id = ? ORDER BY created_at DESC LIMIT ? OFFSET ?");
$stmt->bind_param("iii", $userId, $limit, $offset);
$stmt->execute();
$result = $stmt->get_result();

$counter = $offset + 1;
while ($row = $result->fetch_assoc()) {
    echo '<tr>
        <th scope="row">' . $counter++ . '</th>
        <td>' . htmlspecialchars($row['id']) . '</td>
        <td>' . htmlspecialchars($row['name']) . '</td>
        <td>' . htmlspecialchars($row['phone']) . '</td>
        <td>' . htmlspecialchars($row['address']) . '</td>
        <td>' . htmlspecialchars($row['service_type']) . '</td>
        <td>' . date('Y-m-d H:i:s', strtotime($row['created_at'])) . '</td>
    </tr>';
}