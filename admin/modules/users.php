<?php
session_start();
require_once '../../db/connect.php';

// Check if user is admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != 0) {
    echo '<div class="alert alert-danger">Access denied</div>';
    exit;
}

$action = $_GET['action'] ?? 'list';

if ($action == 'add' && $_POST) {
    // Handle add user
    try {
        $stmt = $conn->prepare("
            INSERT INTO site_user (name, email, phone, username, password, role, address) 
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $_POST['name'],
            $_POST['email'],
            $_POST['phone'],
            $_POST['username'],
            $_POST['password'], // In production, this should be hashed
            $_POST['role'],
            $_POST['address']
        ]);
        echo '<div class="alert alert-success">User added successfully!</div>';
    } catch (Exception $e) {
        echo '<div class="alert alert-danger">Error: ' . $e->getMessage() . '</div>';
    }
}

if ($action == 'delete' && isset($_GET['id'])) {
    try {
        $stmt = $conn->prepare("DELETE FROM site_user WHERE id = ?");
        $stmt->execute([$_GET['id']]);
        echo '<div class="alert alert-success">User deleted successfully!</div>';
    } catch (Exception $e) {
        echo '<div class="alert alert-danger">Error: ' . $e->getMessage() . '</div>';
    }
}
?>

<div class="row mb-4">
    <div class="col-12">
        <h2>User Management</h2>
        <p class="text-muted">Manage website users</p>
    </div>
</div>

<?php if ($action == 'add'): ?>
<!-- Add User Form -->
<div class="row">
    <div class="col-lg-8">
        <div class="card shadow">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Add New User</h6>
            </div>
            <div class="card-body">
                <form method="POST">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Full Name</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Email</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Phone</label>
                            <input type="text" class="form-control" name="phone">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Username</label>
                            <input type="text" class="form-control" name="username" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Password</label>
                            <input type="password" class="form-control" name="password" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Role</label>
                            <select class="form-control" name="role">
                                <option value="1">User</option>
                                <option value="0">Admin</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label>Address</label>
                        <textarea class="form-control" name="address" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Add User</button>
                    <a href="?action=list" onclick="loadAdminPage('users')" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>

<?php else: ?>
<!-- Users List -->
<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">All Users</h6>
                <button onclick="loadAdminPage('users', 'add')" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-circle"></i> Add New User
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="usersTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Username</th>
                                <th>Phone</th>
                                <th>Role</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            try {
                                $stmt = $conn->prepare("SELECT * FROM site_user ORDER BY id DESC");
                                $stmt->execute();
                                
                                while ($user = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    $role_text = $user['role'] == 0 ? 'Admin' : 'User';
                                    $role_badge = $user['role'] == 0 ? 'danger' : 'primary';
                                    
                                    echo "<tr>";
                                    echo "<td>{$user['id']}</td>";
                                    echo "<td>{$user['name']}</td>";
                                    echo "<td>{$user['email']}</td>";
                                    echo "<td>{$user['username']}</td>";
                                    echo "<td>{$user['phone']}</td>";
                                    echo "<td><span class='badge bg-{$role_badge}'>{$role_text}</span></td>";
                                    echo "<td>";                                    echo "<button class='btn btn-sm btn-warning me-1'>Edit</button>";
                                    // Check if current session has user_id and prevent self-deletion
                                    $current_user_id = $_SESSION['user_id'] ?? null;
                                    if (!$current_user_id || $user['id'] != $current_user_id) {
                                        echo "<button class='btn btn-sm btn-danger' onclick='deleteUser({$user['id']})'>Delete</button>";
                                    }
                                    echo "</td>";
                                    echo "</tr>";
                                }
                            } catch (Exception $e) {
                                echo "<tr><td colspan='7' class='text-center text-danger'>Error loading users: {$e->getMessage()}</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function deleteUser(userId) {
    if (confirm('Are you sure you want to delete this user?')) {
        $.get('../modules/users.php?action=delete&id=' + userId)
            .done(function() {
                loadAdminPage('users');
            });
    }
}
</script>

<?php endif; ?>
