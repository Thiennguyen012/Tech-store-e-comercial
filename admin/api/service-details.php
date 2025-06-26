<?php
session_start();
require_once '../config/admin-connect.php';

// Check if user is admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != 0) {
    echo '<div class="alert alert-danger">Access denied</div>';
    exit;
}

$service_id = $_GET['id'] ?? 0;

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
    
    ?>
    
    <div class="row">
        <div class="col-12">
            <h6>Service Request Information</h6>
            <table class="table table-sm">
                <tr><td><strong>Request ID:</strong></td><td>#<?php echo $service['id']; ?></td></tr>
                <tr><td><strong>Customer:</strong></td><td><?php echo htmlspecialchars($customer_name); ?></td></tr>
                <?php if ($service['user_email']): ?>
                <tr><td><strong>Email:</strong></td><td><?php echo htmlspecialchars($service['user_email']); ?></td></tr>
                <?php endif; ?>
                <tr><td><strong>Phone:</strong></td><td><?php echo htmlspecialchars($service['phone']); ?></td></tr>
                <tr><td><strong>Address:</strong></td><td><?php echo htmlspecialchars($service['address']); ?></td></tr>
                <tr><td><strong>Service Type:</strong></td><td><span class="badge bg-info"><?php echo $service['service_type']; ?></span></td></tr>
                <tr><td><strong>Request Date:</strong></td><td><?php echo date('M d, Y H:i', strtotime($service['created_at'])); ?></td></tr>
                <?php if (!empty($service['description'])): ?>
                <tr><td><strong>Description:</strong></td><td><?php echo htmlspecialchars($service['description']); ?></td></tr>
                <?php endif; ?>
            </table>
        </div>
    </div>
    
    <?php
} catch (Exception $e) {
    echo '<div class="alert alert-danger">Error loading service details: ' . $e->getMessage() . '</div>';
}
?>
    echo "</div>";

} catch (Exception $e) {
    echo '<div class="alert alert-danger">Error loading service details: ' . $e->getMessage() . '</div>';
}
?>
