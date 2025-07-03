<?php
$current_page = 'users';
require_once '../includes/admin-layout.php';

$action = $_POST['action'] ?? $_GET['action'] ?? 'list';

if ($action == 'add' && $_POST) {
    // Handle add user
    try {
        $stmt = $conn->prepare("
            INSERT INTO site_user (name, email, phone, username, password, role, address) 
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        $password = $_POST['password'];
        $stmt->execute([
            $_POST['name'],
            $_POST['email'],
            $_POST['phone'],
            $_POST['username'],
            $password,
            $_POST['role'],
            $_POST['address']
        ]);
        echo '<script>
            alert("User added successfully!");
            location.href = "users.php";
        </script>';
    } catch (Exception $e) {
        echo '<div class="alert alert-danger">Error: ' . $e->getMessage() . '</div>';
    }
}

if ($action == 'edit' && $_POST) {
    // Handle edit user
    try {
        if (!empty($_POST['password'])) {
            $stmt = $conn->prepare("
                UPDATE site_user 
                SET name = ?, email = ?, phone = ?, username = ?, password = ?, role = ?, address = ?
                WHERE id = ?
            ");
            $password = $_POST['password'];
            $stmt->execute([
                $_POST['name'],
                $_POST['email'],
                $_POST['phone'],
                $_POST['username'],
                $password,
                $_POST['role'],
                $_POST['address'],
                $_POST['id']
            ]);
        } else {
            $stmt = $conn->prepare("
                UPDATE site_user 
                SET name = ?, email = ?, phone = ?, username = ?, role = ?, address = ?
                WHERE id = ?
            ");
            $stmt->execute([
                $_POST['name'],
                $_POST['email'],
                $_POST['phone'],
                $_POST['username'],
                $_POST['role'],
                $_POST['address'],
                $_POST['id']
            ]);
        }
        echo '<script>
            alert("User updated successfully!");
            location.href = "users.php";
        </script>';
    } catch (Exception $e) {
        echo '<div class="alert alert-dark">Error: ' . $e->getMessage() . '</div>';
    }
}

if ($action == 'delete' && isset($_GET['id'])) {
    try {
        $stmt = $conn->prepare("DELETE FROM site_user WHERE id = ?");
        $stmt->execute([$_GET['id']]);
        echo '<script>
            alert("User deleted successfully!");
            location.href = "users.php";
        </script>';
    } catch (Exception $e) {
        echo '<div class="alert alert-dark">Error: ' . $e->getMessage() . '</div>';
    }
}
?>

<div class="row mb-4">
    <div class="col-12">
        <h2>User Management</h2>
        <p class="text-muted">Manage site users</p>
    </div>
</div>

<?php if ($action == 'add'): ?>
    <!-- Add User Form -->
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10 col-xl-8">
            <div class="card">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-dark">Add New User</h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="users.php?action=add">
                        <div class="row">
                            <div class="col-12 col-md-6 mb-3">
                                <label class="form-label">Full Name</label>
                                <input type="text" class="form-control" name="name" required>
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6 mb-3">
                                <label class="form-label">Phone</label>
                                <input type="text" class="form-control" name="phone">
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <label class="form-label">Username</label>
                                <input type="text" class="form-control" name="username" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6 mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" class="form-control" name="password" required>
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <label class="form-label">Role</label>
                                <select class="form-control" name="role">
                                    <option value="1">User</option>
                                    <option value="0">Admin</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Address</label>
                            <textarea class="form-control" name="address" rows="3"></textarea>
                        </div>
                        <div class="d-flex flex-column flex-md-row gap-2">
                            <button type="submit" class="btn btn-dark">Add User</button>
                            <button type="button" onclick="location.href='users.php'" class="btn btn-outline-dark">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php elseif ($action == 'edit'): ?>
    <!-- Edit User Form -->
    <?php
    $user_id = $_GET['id'] ?? 0;
    try {
        $stmt = $conn->prepare("SELECT * FROM site_user WHERE id = ?");
        $stmt->execute([$user_id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            echo '<div class="alert alert-danger">User not found!</div>';
            exit;
        }
    } catch (Exception $e) {
        echo '<div class="alert alert-danger">Error: ' . $e->getMessage() . '</div>';
        exit;
    }
    ?>
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10 col-xl-8">
            <div class="card">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-dark">Edit User</h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="users.php?action=edit&id=<?php echo $user['id']; ?>">
                        <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                        <div class="row">
                            <div class="col-12 col-md-6 mb-3">
                                <label class="form-label">Full Name</label>
                                <input type="text" class="form-control" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6 mb-3">
                                <label class="form-label">Phone</label>
                                <input type="text" class="form-control" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>">
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <label class="form-label">Username</label>
                                <input type="text" class="form-control" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6 mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" class="form-control" name="password" placeholder="Leave blank to keep current password">
                                <small class="text-muted">Leave blank to keep current password</small>
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <label class="form-label">Role</label>
                                <select class="form-control" name="role">
                                    <option value="1" <?php echo $user['role'] == 1 ? 'selected' : ''; ?>>User</option>
                                    <option value="0" <?php echo $user['role'] == 0 ? 'selected' : ''; ?>>Admin</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Address</label>
                            <textarea class="form-control" name="address" rows="3"><?php echo htmlspecialchars($user['address']); ?></textarea>
                        </div>
                        <div class="d-flex flex-column flex-md-row gap-2">
                            <button type="submit" class="btn btn-dark">Update User</button>
                            <button type="button" onclick="location.href='users.php'" class="btn btn-outline-dark">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php else: ?>
    <!-- Users List -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header py-3 d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2">
                    <h6 class="m-0 font-weight-bold text-dark">All Users</h6>
                    <a href="users.php?action=add" class="btn btn-dark btn-sm">
                        <i class="bi bi-plus-circle"></i> Add New User
                    </a>
                </div>
                <div class="card-body">
                    <!-- Mobile-friendly user cards (visible only on small screens) -->
                    <div class="d-block d-md-none">
                        <?php
                        try {
                            $stmt = $conn->prepare("SELECT * FROM site_user ORDER BY id DESC");
                            $stmt->execute();

                            while ($user = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                $role_text = $user['role'] == 0 ? 'Admin' : 'User';
                                $role_color = $user['role'] == 0 ? 'danger' : 'success';
                        ?>
                                <div class="card mb-3 border">
                                    <div class="card-body p-3">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <h6 class="card-title mb-0 text-dark"><?php echo htmlspecialchars($user['name']); ?></h6>
                                            <span class="badge bg-<?php echo $role_color; ?>"><?php echo $role_text; ?></span>
                                        </div>
                                        <div class="text-muted small mb-3">
                                            <div class="mb-1"><i class="bi bi-envelope me-1"></i> <?php echo htmlspecialchars($user['email']); ?></div>
                                            <?php if ($user['phone']): ?>
                                                <div class="mb-1"><i class="bi bi-phone me-1"></i> <?php echo htmlspecialchars($user['phone']); ?></div>
                                            <?php endif; ?>
                                            <div><i class="bi bi-person me-1"></i> <?php echo htmlspecialchars($user['username']); ?></div>
                                        </div>
                                        <div class="d-grid gap-2">
                                            <div class="btn-group w-100" role="group">
                                                <a href="users.php?action=edit&id=<?php echo $user['id']; ?>" class="btn btn-outline-dark btn-sm">
                                                    <i class="bi bi-pencil"></i> Edit
                                                </a>
                                                <a href="users.php?action=delete&id=<?php echo $user['id']; ?>"
                                                    class="btn btn-dark btn-sm"
                                                    onclick="return confirm('Are you sure you want to delete this user?')">
                                                    <i class="bi bi-trash"></i> Delete
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        <?php
                            }
                        } catch (Exception $e) {
                            echo '<div class="alert alert-danger">Error loading users: ' . $e->getMessage() . '</div>';
                        }
                        ?>
                    </div>

                    <!-- Desktop table (hidden on small screens) -->
                    <div class="d-none d-md-block">
                        <div class="table-responsive">
                            <table class="table table-hover" id="usersTable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th class="d-none d-lg-table-cell">Username</th>
                                        <th class="d-none d-lg-table-cell">Phone</th>
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
                                            $role_color = $user['role'] == 0 ? 'danger' : 'success';

                                            echo "<tr>";
                                            echo "<td>{$user['id']}</td>";
                                            echo "<td class='text-truncate' style='max-width: 150px;'>" . htmlspecialchars($user['name']) . "</td>";
                                            echo "<td class='text-truncate' style='max-width: 200px;'>" . htmlspecialchars($user['email']) . "</td>";
                                            echo "<td class='d-none d-lg-table-cell text-truncate' style='max-width: 120px;'>" . htmlspecialchars($user['username']) . "</td>";
                                            echo "<td class='d-none d-lg-table-cell'>" . htmlspecialchars($user['phone']) . "</td>";
                                            echo "<td><span class='badge bg-{$role_color}'>{$role_text}</span></td>";
                                            echo "<td>";
                                            echo "<div class='btn-group btn-group-sm' role='group'>";
                                            echo "<a href='users.php?action=edit&id={$user['id']}' class='btn btn-outline-dark' title='Edit User'><i class='bi bi-pencil'></i></a>";
                                            echo "<a href='users.php?action=delete&id={$user['id']}' class='btn btn-dark' onclick='return confirm(\"Are you sure you want to delete this user?\")' title='Delete User'><i class='bi bi-trash'></i></a>";
                                            echo "</div>";
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
    </div>

<?php endif; ?>

<?php require_once '../includes/admin-layout-footer.php'; ?>