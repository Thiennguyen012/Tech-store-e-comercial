<?php
$current_page = 'categories';
require_once '../includes/admin-layout.php';

$action = $_POST['action'] ?? $_GET['action'] ?? 'list';

if ($action == 'add' && $_POST) {
    // Xử lý thêm danh mục
    try {
        $stmt = $conn->prepare("INSERT INTO product_category (category_name) VALUES (?)");
        $stmt->execute([$_POST['category_name']]);
        echo '<script>
            alert("Category added successfully!");
            location.href = "categories.php";
        </script>';
    } catch (Exception $e) {
        echo '<div class="alert alert-danger">Error: ' . $e->getMessage() . '</div>';
    }
}

if ($action == 'edit' && $_POST) {
    // Xử lý chỉnh sửa danh mục
    try {
        $stmt = $conn->prepare("UPDATE product_category SET category_name = ? WHERE id = ?");
        $stmt->execute([$_POST['category_name'], $_POST['id']]);
        echo '<script>
            alert("Category updated successfully!");
            location.href = "categories.php";
        </script>';
    } catch (Exception $e) {
        echo '<div class="alert alert-danger">Error: ' . $e->getMessage() . '</div>';
    }
}

if ($action == 'delete' && isset($_GET['id'])) {
    try {
        $stmt = $conn->prepare("DELETE FROM product_category WHERE id = ?");
        $stmt->execute([$_GET['id']]);
        echo '<script>
            alert("Category deleted successfully!");
            location.href = "categories.php";
        </script>';
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
<!-- Form thêm danh mục -->
<div class="row">
    <div class="col-lg-6">
        <div class="card shadow">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-dark">Add New Category</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="categories.php?action=add">
                    <div class="mb-3">
                        <label>Category Name</label>
                        <input type="text" class="form-control" name="category_name" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Category</button>
                    <button type="button" onclick="location.href='categories.php'" class="btn btn-secondary">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php elseif ($action == 'edit'): ?>
<!-- Form chỉnh sửa danh mục -->
<?php
$category_id = $_GET['id'] ?? 0;
try {
    $stmt = $conn->prepare("SELECT * FROM product_category WHERE id = ?");
    $stmt->execute([$category_id]);
    $category = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$category) {
        echo '<div class="alert alert-danger">Category not found!</div>';
        exit;
    }
} catch (Exception $e) {
    echo '<div class="alert alert-danger">Error: ' . $e->getMessage() . '</div>';
    exit;
}
?>
<div class="row">
    <div class="col-lg-6">
        <div class="card shadow">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Edit Category</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="categories.php?action=edit&id=<?php echo $category['id']; ?>">
                    <input type="hidden" name="id" value="<?php echo $category['id']; ?>">
                    <div class="mb-3">
                        <label>Category Name</label>
                        <input type="text" class="form-control" name="category_name" value="<?php echo htmlspecialchars($category['category_name']); ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Category</button>
                    <button type="button" onclick="location.href='categories.php'" class="btn btn-secondary">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php else: ?>
<!-- Danh sách danh mục -->
<div class="row">
    <div class="col-lg-8">
        <div class="card shadow">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-dark">All Categories</h6>
                <a href="categories.php?action=add" class="btn btn-dark btn-sm">
                    <i class="bi bi-plus-circle"></i> Add New Category
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="categoriesTable">
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
                                    ORDER BY pc.id DESC
                                ");
                                $stmt->execute();
                                
                                while ($category = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<tr>";
                                    echo "<td>{$category['id']}</td>";
                                    echo "<td>{$category['category_name']}</td>";
                                    echo "<td><span class='badge bg-success'>{$category['product_count']} products</span></td>";
                                    echo "<td>";
                                    echo "<a href='categories.php?action=edit&id={$category['id']}' class='btn btn-sm btn-outline-dark me-1'>Edit</a>";
                                    echo "<a href='categories.php?action=delete&id={$category['id']}' class='btn btn-sm btn-dark' onclick='return confirm(\"Are you sure you want to delete this category?\")'>Delete</a>";
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

<?php endif; ?>

<?php require_once '../includes/admin-layout-footer.php'; ?>
