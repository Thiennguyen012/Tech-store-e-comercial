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
    <div class="col-md-3">
        <div class="card shadow h-100 py-2">
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
    <div class="col-md-3">
        <div class="card shadow h-100 py-2">
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
    <div class="col-md-3">
        <div class="card shadow h-100 py-2">
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
    <div class="col-md-3">
        <div class="card shadow h-100 py-2">
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
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-dark">All Service Requests</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="servicesTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Customer</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>Service Type</th>
                                <th>Date Requested</th>
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
                                    echo "<td>{$customer_name}</td>";
                                    echo "<td>{$service['phone']}</td>";
                                    echo "<td>" . substr($service['address'], 0, 30) . (strlen($service['address']) > 30 ? '...' : '') . "</td>";
                                    echo "<td><span class='badge bg-info'>{$service['service_type']}</span></td>";
                                    echo "<td>" . date('M d, Y H:i', strtotime($service['created_at'])) . "</td>";
                                    echo "<td>";
                                    echo "<button class='btn btn-sm btn-outline-dark me-1' onclick='viewServiceDetails({$service['id']})'>View</button>";
                                    echo "<button class='btn btn-sm btn-dark' onclick='deleteService({$service['id']})'>Delete</button>";
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

<!-- Service Details Modal -->
<div class="modal fade" id="serviceDetailsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Service Request Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="serviceDetailsContent">
                Loading...
            </div>
        </div>
    </div>
</div>

<script>
function viewServiceDetails(serviceId) {
    $('#serviceDetailsContent').html('Loading...');
    $('#serviceDetailsModal').modal('show');
    
    $.get('../api/service-details.php?id=' + serviceId)
        .done(function(data) {
            $('#serviceDetailsContent').html(data);
        })
        .fail(function() {
            $('#serviceDetailsContent').html('<div class="alert alert-danger">Error loading service details</div>');
        });
}

function deleteService(serviceId) {
    if (confirm('Are you sure you want to delete this service request?')) {
        $.get('../modules/services.php?action=delete&id=' + serviceId)
            .done(function(response) {
                // Execute the script returned from server
                $('body').append(response);
            })
            .fail(function() {
                alert('Error deleting service request');
            });
    }
}
</script>

<?php require_once '../includes/admin-layout-footer.php'; ?>
