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
    echo '<div class="alert alert-danger">Service ID is required</div>';
    exit;
}

try {
    // Get service details
    $stmt = $conn->prepare("
        SELECT s.*, u.name as user_name, u.email as user_email 
        FROM services s 
        LEFT JOIN site_user u ON s.user_id = u.id 
        WHERE s.id = ?
    ");
    $stmt->execute([$service_id]);
    $service = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$service) {
        echo '<div class="alert alert-danger">Service request not found</div>';
        exit;
    }
      $customer_name = $service['user_name'] ?: $service['name'] ?: 'Guest';
    
    echo "<div class='row'>";
    echo "<div class='col-12'>";
    echo "<h5>Service Request Information</h5>";
    echo "<table class='table table-borderless'>";
    echo "<tr><td><strong>Request ID:</strong></td><td>#{$service['id']}</td></tr>";
    echo "<tr><td><strong>Customer:</strong></td><td>{$customer_name}</td></tr>";
    if ($service['user_email']) {
        echo "<tr><td><strong>Email:</strong></td><td>{$service['user_email']}</td></tr>";
    }
    echo "<tr><td><strong>Phone:</strong></td><td>{$service['phone']}</td></tr>";
    echo "<tr><td><strong>Address:</strong></td><td>{$service['address']}</td></tr>";
    echo "<tr><td><strong>Service Type:</strong></td><td><span class='badge bg-info'>{$service['service_type']}</span></td></tr>";
    echo "<tr><td><strong>Request Date:</strong></td><td>" . date('M d, Y H:i', strtotime($service['created_at'])) . "</td></tr>";
    echo "</table>";
    echo "</div>";
    echo "</div>";

} catch (Exception $e) {
    echo '<div class="alert alert-danger">Error loading service details: ' . $e->getMessage() . '</div>';
}
?>
