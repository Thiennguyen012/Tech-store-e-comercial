<?php
// Dọn buffer đầu ra và tắt báo cáo lỗi cho production
ob_start();
error_reporting(0);
ini_set('display_errors', 0);

session_start();
require_once '../config/admin-connect.php';

// Kiểm tra xem người dùng có phải admin không
if (!isset($_SESSION['role']) || $_SESSION['role'] != 0) {
    echo '<div class="alert alert-danger">Access denied</div>';
    exit;
}

// Xác thực ID dịch vụ
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo '<div class="alert alert-danger">Invalid service ID</div>';
    exit;
}

$service_id = (int)$_GET['id'];

try {
    // Xác minh kết nối cơ sở dữ liệu
    if (!$conn) {
        throw new Exception('Database connection not available');
    }
    // Lấy chi tiết dịch vụ
    $stmt = $conn->prepare("
        SELECT s.*, u.name as user_name, u.email as user_email 
        FROM services s 
        LEFT JOIN site_user u ON s.user_id = u.id 
        WHERE s.id = ?
    ");
    $stmt->execute([$service_id]);
    $service = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$service) {
        echo '<div class="alert alert-warning">Service request #' . $service_id . ' not found in the database.</div>';
        exit;
    }
    
    // Debug: Ghi log việc lấy dịch vụ thành công
    error_log("Service details loaded successfully for ID: " . $service_id);
    
    $customer_name = $service['user_name'] ?: ($service['name'] ?: 'Guest');
    $customer_email = $service['user_email'] ?: ($service['email'] ?: 'N/A');
    
    ?>
    
    <div class="row">
        <div class="col-12">
            <h6 class="mb-3">Service Request Information</h6>
            <div class="table-responsive">
                <table class="table table-sm table-borderless">
                    <tr>
                        <td class="fw-bold" style="width: 30%;">Request ID:</td>
                        <td>#<?php echo $service['id']; ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Customer:</td>
                        <td><?php echo htmlspecialchars($customer_name); ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Email:</td>
                        <td><?php echo htmlspecialchars($customer_email); ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Phone:</td>
                        <td><?php echo htmlspecialchars($service['phone'] ?? 'N/A'); ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Address:</td>
                        <td><?php echo htmlspecialchars($service['address'] ?? 'N/A'); ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Service Type:</td>
                        <td><span class="badge bg-secondary"><?php echo htmlspecialchars($service['service_type'] ?? 'N/A'); ?></span></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Request Date:</td>
                        <td><?php echo date('M d, Y H:i', strtotime($service['created_at'])); ?></td>
                    </tr>
                    <?php if (!empty($service['description'])): ?>
                    <tr>
                        <td class="fw-bold">Description:</td>
                        <td><?php echo nl2br(htmlspecialchars($service['description'])); ?></td>
                    </tr>
                    <?php endif; ?>
                    <?php if (!empty($service['status'])): ?>
                    <tr>
                        <td class="fw-bold">Status:</td>
                        <td>
                            <?php 
                            $status_color = '';
                            switch(strtolower($service['status'])) {
                                case 'completed':
                                    $status_color = 'success';
                                    break;
                                case 'in_progress':
                                    $status_color = 'warning';
                                    break;
                                case 'cancelled':
                                    $status_color = 'danger';
                                    break;
                                default:
                                    $status_color = 'secondary';
                            }
                            ?>
                            <span class="badge bg-<?php echo $status_color; ?>"><?php echo ucfirst(str_replace('_', ' ', $service['status'])); ?></span>
                        </td>
                    </tr>
                    <?php endif; ?>
                </table>
            </div>
        </div>
    </div>
    
    <?php
} catch (Exception $e) {
    // Ghi log lỗi để debug nhưng hiển thị thông báo thân thiện với người dùng
    error_log('Service Details Error: ' . $e->getMessage());
    echo '<div class="alert alert-danger">';
    echo '<i class="bi bi-exclamation-triangle me-2"></i>';
    echo 'Unable to load service details. Please try again later.';
    echo '</div>';
} catch (PDOException $e) {
    // Lỗi cụ thể từ cơ sở dữ liệu
    error_log('Database Error in Service Details: ' . $e->getMessage());
    echo '<div class="alert alert-danger">';
    echo '<i class="bi bi-exclamation-triangle me-2"></i>';
    echo 'Database error occurred. Please try again later.';
    echo '</div>';
}

// Dọn dẹp buffer đầu ra
ob_end_flush();
?>