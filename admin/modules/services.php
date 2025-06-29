<?php
$current_page = 'services';
require_once '../includes/admin-layout.php';

// Check if user is admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != 0) {
    echo '<div class="alert alert-danger">Access denied</div>';
    exit;
}

$action = $_POST['action'] ?? $_GET['action'] ?? 'list';

if ($action == 'delete' && isset($_GET['id'])) {
    try {
        $stmt = $conn->prepare("DELETE FROM services WHERE id = ?");
        $stmt->execute([$_GET['id']]);
        echo '<script>
            alert("Service request deleted successfully!");
            location.href = "services.php";
        </script>';
    } catch (Exception $e) {
        echo '<div class="alert alert-danger">Error: ' . $e->getMessage() . '</div>';
    }
}

if ($action == 'update_status' && isset($_POST['service_id']) && isset($_POST['status'])) {
    try {
        $stmt = $conn->prepare("UPDATE services SET status = ? WHERE id = ?");
        $stmt->execute([$_POST['status'], $_POST['service_id']]);
        echo json_encode(['success' => true, 'message' => 'Service status updated successfully!']);
        exit;
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        exit;
    }
}
?>

<div class="row mb-4">
    <div class="col-12">
        <h2>Services Management</h2>
        <p class="text-muted">Manage customer service requests</p>
    </div>
</div>

<!-- Service Statistics -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 col-sm-6 mb-3">
        <div class="card h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">Total Requests</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?php
                            try {
                                $stmt = $conn->prepare("SELECT COUNT(*) as count FROM services");
                                $stmt->execute();
                                echo $stmt->fetch()['count'];
                            } catch (Exception $e) {
                                echo "Error";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 col-sm-6 mb-3">
        <div class="card h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">Laptop Cleaning</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?php
                            try {
                                $stmt = $conn->prepare("SELECT COUNT(*) as count FROM services WHERE service_type = 'Laptop Cleaning'");
                                $stmt->execute();
                                echo $stmt->fetch()['count'];
                            } catch (Exception $e) {
                                echo "Error";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 col-sm-6 mb-3">
        <div class="card h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">Camera Install</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?php
                            try {
                                $stmt = $conn->prepare("SELECT COUNT(*) as count FROM services WHERE service_type = 'Camera Installation'");
                                $stmt->execute();
                                echo $stmt->fetch()['count'];
                            } catch (Exception $e) {
                                echo "Error";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 col-sm-6 mb-3">
        <div class="card h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">Repairs</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?php
                            try {
                                $stmt = $conn->prepare("SELECT COUNT(*) as count FROM services WHERE service_type = 'Repair'");
                                $stmt->execute();
                                echo $stmt->fetch()['count'];
                            } catch (Exception $e) {
                                echo "Error";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Services List -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header py-3 mobile-stack">
                <h6 class="m-0 font-weight-bold text-dark">All Service Requests</h6>
            </div>
            <div class="card-body">
                <!-- Mobile-friendly service cards (visible only on small screens) -->
                <div class="d-block d-md-none">
                    <?php
                    try {
                        $stmt = $conn->prepare("
                            SELECT s.*, u.name as user_name 
                            FROM services s 
                            LEFT JOIN site_user u ON s.user_id = u.id 
                            ORDER BY s.created_at DESC
                        ");
                        $stmt->execute();
                        
                        while ($service = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            $customer_name = $service['user_name'] ?: $service['name'] ?: 'Guest';
                            ?>
                            <div class="card mb-3 border">
                                <div class="card-body p-3">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h6 class="card-title mb-0 text-dark">Service #<?php echo $service['id']; ?></h6>
                                        <span class="badge bg-secondary"><?php echo htmlspecialchars($service['service_type']); ?></span>
                                    </div>
                                    <div class="text-muted small mb-3">
                                        <div class="mb-1"><strong>Customer:</strong> <?php echo htmlspecialchars($customer_name); ?></div>
                                        <div class="mb-1"><strong>Phone:</strong> <?php echo htmlspecialchars($service['phone']); ?></div>
                                        <div class="mb-1"><strong>Address:</strong> <?php echo htmlspecialchars(substr($service['address'], 0, 50)) . (strlen($service['address']) > 50 ? '...' : ''); ?></div>
                                        <div><strong>Date:</strong> <?php echo date('M d, Y H:i', strtotime($service['created_at'])); ?></div>
                                    </div>
                                    <div class="d-grid gap-2">
                                        <div class="btn-group w-100" role="group">
                                            <button class="btn btn-outline-dark btn-sm" onclick="viewServiceDetails(<?php echo $service['id']; ?>)">
                                                <i class="bi bi-eye"></i> View Details
                                            </button>
                                            <button class="btn btn-dark btn-sm" onclick="deleteService(<?php echo $service['id']; ?>)">
                                                <i class="bi bi-trash"></i> Delete
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    } catch (Exception $e) {
                        echo '<div class="alert alert-danger">Error loading services: ' . $e->getMessage() . '</div>';
                    }
                    ?>
                </div>

                <!-- Desktop table (hidden on small screens) -->
                <div class="d-none d-md-block">
                    <div class="table-responsive">
                        <table class="table table-hover" id="servicesTable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Customer</th>
                                    <th class="d-none d-lg-table-cell">Phone</th>
                                    <th class="d-none d-lg-table-cell">Address</th>
                                    <th>Service Type</th>
                                    <th class="d-none d-lg-table-cell">Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                try {
                                    $stmt = $conn->prepare("
                                        SELECT s.*, u.name as user_name 
                                        FROM services s 
                                        LEFT JOIN site_user u ON s.user_id = u.id 
                                        ORDER BY s.created_at DESC
                                    ");
                                    $stmt->execute();
                                    
                                    while ($service = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        $customer_name = $service['user_name'] ?: $service['name'] ?: 'Guest';
                                        
                                        echo "<tr>";
                                        echo "<td>#{$service['id']}</td>";
                                        echo "<td class='text-truncate' style='max-width: 150px;'>" . htmlspecialchars($customer_name) . "</td>";
                                        echo "<td class='d-none d-lg-table-cell'>" . htmlspecialchars($service['phone']) . "</td>";
                                        echo "<td class='d-none d-lg-table-cell text-truncate' style='max-width: 150px;'>" . htmlspecialchars(substr($service['address'], 0, 30)) . (strlen($service['address']) > 30 ? '...' : '') . "</td>";
                                        echo "<td><span class='badge bg-secondary'>" . htmlspecialchars($service['service_type']) . "</span></td>";
                                        echo "<td class='d-none d-lg-table-cell'>" . date('M d, Y', strtotime($service['created_at'])) . "<br><small class='text-muted'>" . date('H:i', strtotime($service['created_at'])) . "</small></td>";
                                        echo "<td>";
                                        echo "<div class='btn-group btn-group-sm' role='group'>";
                                        echo "<button class='btn btn-outline-dark' onclick='viewServiceDetails({$service['id']})' title='View Details'><i class='bi bi-eye'></i></button>";
                                        echo "<button class='btn btn-dark' onclick='deleteService({$service['id']})' title='Delete Service'><i class='bi bi-trash'></i></button>";
                                        echo "</div>";
                                        echo "</td>";
                                        echo "</tr>";
                                    }
                                } catch (Exception $e) {
                                    echo "<tr><td colspan='7' class='text-center text-danger'>Error loading services: {$e->getMessage()}</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Service Details Modal -->
<div class="modal fade" id="serviceDetailsModal" tabindex="-1" aria-labelledby="serviceDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="serviceDetailsModalLabel">Service Request Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="serviceDetailsContent">
                <div class="text-center">
                    <div class="spinner-border spinner-border-sm" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    Loading...
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
function viewServiceDetails(serviceId) {
    console.log('Loading service details for ID:', serviceId);
    
    // Validate service ID
    if (!serviceId || isNaN(serviceId)) {
        alert('Invalid service ID');
        return;
    }
    
    $('#serviceDetailsContent').html(`
        <div class="text-center py-3">
            <div class="spinner-border spinner-border-sm text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <div class="mt-2">Loading service details...</div>
        </div>
    `);
    $('#serviceDetailsModal').modal('show');
    
    // Make AJAX request with better error handling
    $.ajax({
        url: '../api/service-details.php',
        type: 'GET',
        data: { id: serviceId },
        timeout: 10000, // 10 second timeout
        success: function(data) {
            console.log('Service details loaded successfully');
            $('#serviceDetailsContent').html(data);
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error:', {
                status: status,
                error: error,
                responseText: xhr.responseText
            });
            
            let errorMessage = 'Error loading service details.';
            if (status === 'timeout') {
                errorMessage = 'Request timed out. Please try again.';
            } else if (xhr.status === 404) {
                errorMessage = 'Service details not found.';
            } else if (xhr.status === 403) {
                errorMessage = 'Access denied.';
            }
            
            $('#serviceDetailsContent').html(`
                <div class="alert alert-danger">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    ${errorMessage}
                    <button type="button" class="btn btn-sm btn-outline-danger ms-2" onclick="viewServiceDetails(${serviceId})">
                        Try Again
                    </button>
                </div>
            `);
        }
    });
}

function deleteService(serviceId) {
    if (confirm('Are you sure you want to delete this service request?')) {
        // Show loading state
        const button = event.target.closest('button');
        const originalText = button.innerHTML;
        button.innerHTML = '<div class="spinner-border spinner-border-sm" role="status"></div>';
        button.disabled = true;
        
        $.ajax({
            url: 'services.php',
            type: 'GET',
            data: { action: 'delete', id: serviceId },
            success: function(response) {
                // Check if response contains success indicator
                if (response.includes('alert("Service request deleted successfully!")')) {
                    // Show success message
                    const alertDiv = $('<div class="alert alert-success alert-dismissible fade show" role="alert">' +
                        'Service request deleted successfully!' +
                        '<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>');
                    $('#admin-content').prepend(alertDiv);
                    
                    // Auto dismiss after 3 seconds
                    setTimeout(function() {
                        alertDiv.remove();
                    }, 3000);
                    
                    // Reload the page to show updated list
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                } else {
                    // Reset button state
                    button.innerHTML = originalText;
                    button.disabled = false;
                    alert('Error deleting service request');
                }
            },
            error: function() {
                // Reset button state
                button.innerHTML = originalText;
                button.disabled = false;
                alert('Error deleting service request');
            }
        });
    }
}
</script>

<?php require_once '../includes/admin-layout-footer.php'; ?>
