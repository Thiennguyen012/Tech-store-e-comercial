<?php

$booked_services = [];
$status_message = ''; // Dùng để hiển thị thông báo thành công/lỗi/chưa có dịch vụ
$no_service_message = ''; // Thông báo chưa đặt dịch vụ

if (!isset($_SESSION['username'])) {
    $no_service_message = '<div class="text-center py-5">
        <div class="mb-4"><i class="fas fa-user fa-3x text-muted"></i></div>
        <h4 class="text-muted mb-3">You are not logged in</h4>
        <p class="text-muted mb-4">Please login to view your booked services.</p>
        <button class="btn btn-dark rounded-4" onclick="location.href=\'Login.php\'">Login Now</button>
    </div>';
} else {
    $username = $_SESSION['username'];
    $user_id = 0;

    $stmt_user = $conn->prepare("SELECT id FROM site_user WHERE username = ?");
    if ($stmt_user) {
        $stmt_user->bind_param("s", $username);
        $stmt_user->execute();
        $result_user = $stmt_user->get_result();
        if ($result_user->num_rows > 0) {
            $user_data = $result_user->fetch_assoc();
            $user_id = $user_data['id'];
        } else {
            $status_message = "Error: User data not found. Please log in again.";
        }
        $stmt_user->close();
    } else {
        $status_message = "Database query error (user data): " . $conn->error;
    }

    $limit = 10;
    $offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;

    if ($user_id > 0) {
        $stmt_services = $conn->prepare("SELECT id, name, phone, address, service_type, created_at FROM services WHERE user_id = ? ORDER BY created_at DESC LIMIT ? OFFSET ?");
        if ($stmt_services) {
            $stmt_services->bind_param("iii", $user_id, $limit, $offset);
            $stmt_services->execute();
            $result_services = $stmt_services->get_result();

            if ($result_services->num_rows > 0) {
                while ($row = $result_services->fetch_assoc()) {
                    $booked_services[] = $row;
                }
            } else {
                // Thông báo đẹp khi chưa đặt dịch vụ nào
                $no_service_message = '<div class="text-center py-5" data-empty="true">
                    <div class="mb-4"><i class="fas fa-search fa-3x text-muted"></i></div>
                    <h4 class="text-muted mb-3">No booked services yet!</h4>
                    <p class="text-muted mb-4">Please book a service to see it here.</p>
                    <a href="#" onclick="location.href=\'index.php?act=book-services\'; return false;" class="btn btn-dark rounded-pill px-4">Book now</a>
                </div>';
            }
            $stmt_services->close();
        } else {
            $status_message = "Database query error (services): " . $conn->error;
        }
    } else if (empty($status_message)) {
        $status_message = "Could not retrieve your user ID. Please try logging in again.";
    }
}

$conn->close();
?>
<div class="container bg-white px-5 py-5 mt-5 mb-5 rounded-4 shadow">
    <h2 class="mb-4 fw-bold text-start">Your Booked Service History</h2>
    <?php if (!empty($status_message)): ?>
        <div class="alert alert-info text-center" role="alert">
            <?= $status_message ?>
        </div>
    <?php endif; ?>
    <?php if (!empty($no_service_message)): ?>
        <?= $no_service_message ?>
    <?php endif; ?>
    <?php if (!empty($booked_services)): ?>
        <div class="table-responsive">
            <table class="table table-hover table-striped align-middle">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Order ID</th>
                        <th scope="col">Customer Name</th>
                        <th scope="col">Phone</th>
                        <th scope="col">Address</th>
                        <th scope="col">Service Type</th>
                        <th scope="col">Booked At</th>
                    </tr>
                </thead>
                <tbody id="service-list">
                    <?php $counter = $offset + 1; ?>
                    <?php foreach ($booked_services as $service): ?>
                        <tr>
                            <th scope="row"><?= $counter++ ?></th>
                            <td><?= htmlspecialchars($service['id']) ?></td>
                            <td><?= htmlspecialchars($service['name']) ?></td>
                            <td><?= htmlspecialchars($service['phone']) ?></td>
                            <td><?= htmlspecialchars($service['address']) ?></td>
                            <td><?= htmlspecialchars($service['service_type']) ?></td>
                            <td><?= date('Y-m-d H:i:s', strtotime($service['created_at'])) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php if (count($booked_services) === $limit): ?>
            <div class="text-center mt-3">
                <button id="loadMoreBtn" class="btn btn-outline-dark rounded-pill px-4">Show more</button>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>
<script>
let offset = <?= $offset + count($booked_services) ?>;
const limit = <?= $limit ?>;
document.addEventListener('DOMContentLoaded', function() {
    const loadMoreBtn = document.getElementById('loadMoreBtn');
    if (loadMoreBtn) {
        loadMoreBtn.addEventListener('click', function() {
            fetch(`module/services/load-more-services.php?offset=${offset}`)
                .then(res => res.text())
                .then(data => {
                    if (data.trim()) {
                        document.getElementById('service-list').insertAdjacentHTML('beforeend', data);
                        offset += limit;
                        if ((data.match(/<tr/g) || []).length < limit) {
                            loadMoreBtn.style.display = 'none';
                        }
                    } else {
                        loadMoreBtn.style.display = 'none';
                    }
                });
        });
    }
});
</script>