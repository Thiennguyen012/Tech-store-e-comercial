<?php
session_start();
require_once '../../db/connect.php';

// Check if user is admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != 0) {
    http_response_code(403);
    echo json_encode(['error' => 'Access denied']);
    exit;
}

$service_id = $_GET['id'] ?? null;

if (!$service_id) {
    http_response_code(400);
    echo json_encode(['error' => 'Service ID is required']);
    exit;
}

try {
    $stmt = $conn->prepare("DELETE FROM services WHERE id = ?");
    $stmt->execute([$service_id]);
    
    echo json_encode(['success' => true, 'message' => 'Service deleted successfully']);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>
