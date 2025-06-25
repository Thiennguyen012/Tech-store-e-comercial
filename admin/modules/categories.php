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
    // Handle add category
    try {
        $stmt = $conn->prepare("INSERT INTO product_category (category_name) VALUES (?)");
        $stmt->execute([$_POST['category_name']]);
        echo '<div class="alert alert-success">Category added successfully!</div>';
    } catch (Exception $e) {
        echo '<div class="alert alert-danger">Error: ' . $e->getMessage() . '</div>';
    }
}

if ($action == 'delete' && isset($_GET['id'])) {
    try {
        $stmt = $conn->prepare("DELETE FROM product_category WHERE id = ?");
        $stmt->execute([$_GET['id']]);
        echo '<div class="alert alert-success">Category deleted successfully!</div>';
    } catch (Exception $e) {
        echo '<div class="alert alert-danger">Error: ' . $e->getMessage() . '</div>';
    }
}
?>

<div class="row mb-4">
    <div class="col-12">
        <h2>Category Management</h2>
        <p class="text-muted">Manage product categories</p>
    </div>
</div>

<?php if ($action == 'add'): ?>
<!-- Add Category Form -->
<div class="row">
    <div class="col-lg-6">
        <div class="card shadow">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Add New Category</h6>
            </div>
            <div class="card-body">
                <form method="POST">
                    <div class="mb-3">
                        <label>Category Name</label>
                        <input type="text" class="form-control" name="category_name" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Category</button>
                    <button type="button" onclick="loadAdminPage('categories')" class="btn btn-secondary">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php else: ?>
<!-- Categories List -->
<div class="row">
    <div class="col-lg-8">
        <div class="card shadow">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">All Categories</h6>
                <button onclick="loadAdminPage('categories', 'add')" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-circle"></i> Add New Category
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Category Name</th>
                                <th>Product Count</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            try {
                                $stmt = $conn->prepare("
                                    SELECT pc.*, COUNT(p.id) as product_count
                                    FROM product_category pc 
                                    LEFT JOIN product p ON pc.id = p.category_id 
                                    GROUP BY pc.id 
                                    ORDER BY pc.id
                                ");
                                $stmt->execute();
                                
                                while ($category = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<tr>";
                                    echo "<td>{$category['id']}</td>";
                                    echo "<td>{$category['category_name']}</td>";
                                    echo "<td><span class='badge bg-info'>{$category['product_count']} products</span></td>";
                                    echo "<td>";
                                    echo "<button class='btn btn-sm btn-warning me-1'>Edit</button>";
                                    if ($category['product_count'] == 0) {
                                        echo "<button class='btn btn-sm btn-danger' onclick='deleteCategory({$category['id']})'>Delete</button>";
                                    } else {
                                        echo "<button class='btn btn-sm btn-danger' disabled title='Cannot delete category with products'>Delete</button>";
                                    }
                                    echo "</td>";
                                    echo "</tr>";
                                }
                            } catch (Exception $e) {
                                echo "<tr><td colspan='4' class='text-center text-danger'>Error loading categories: {$e->getMessage()}</td></tr>";
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
function deleteCategory(categoryId) {
    if (confirm('Are you sure you want to delete this category?')) {
        $.get('../modules/categories.php?action=delete&id=' + categoryId)
            .done(function() {
                loadAdminPage('categories');
            });
    }
}
</script>

<?php endif; ?>
