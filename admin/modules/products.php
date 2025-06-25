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
    // Handle add product
    try {
        $stmt = $conn->prepare("
            INSERT INTO product (name, description, category_id, qty_in_stock, product_image, price) 
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $_POST['name'],
            $_POST['description'],
            $_POST['category_id'],
            $_POST['qty_in_stock'],
            $_POST['product_image'],
            $_POST['price']
        ]);
        echo '<div class="alert alert-success">Product added successfully!</div>';
    } catch (Exception $e) {
        echo '<div class="alert alert-danger">Error: ' . $e->getMessage() . '</div>';
    }
}

if ($action == 'delete' && isset($_GET['id'])) {
    try {
        $stmt = $conn->prepare("DELETE FROM product WHERE id = ?");
        $stmt->execute([$_GET['id']]);
        echo '<div class="alert alert-success">Product deleted successfully!</div>';
    } catch (Exception $e) {
        echo '<div class="alert alert-danger">Error: ' . $e->getMessage() . '</div>';
    }
}
?>

<div class="row mb-4">
    <div class="col-12">
        <h2>Product Management</h2>
        <p class="text-muted">Manage store products</p>
    </div>
</div>

<?php if ($action == 'add'): ?>
<!-- Add Product Form -->
<div class="row">
    <div class="col-lg-10">
        <div class="card shadow">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Add New Product</h6>
            </div>
            <div class="card-body">
                <form method="POST">
                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label>Product Name</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Price ($)</label>
                            <input type="number" step="0.01" class="form-control" name="price" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Category</label>
                            <select class="form-control" name="category_id" required>
                                <option value="">Select Category</option>
                                <?php
                                try {
                                    $stmt = $conn->prepare("SELECT * FROM product_category ORDER BY category_name");
                                    $stmt->execute();
                                    while ($category = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        echo "<option value='{$category['id']}'>{$category['category_name']}</option>";
                                    }
                                } catch (Exception $e) {
                                    echo "<option value=''>Error loading categories</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Quantity in Stock</label>
                            <input type="number" class="form-control" name="qty_in_stock" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label>Product Image URL</label>
                        <input type="url" class="form-control" name="product_image" required>
                    </div>
                    <div class="mb-3">
                        <label>Description</label>
                        <textarea class="form-control" name="description" rows="5"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Product</button>
                    <button type="button" onclick="loadAdminPage('products')" class="btn btn-secondary">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php else: ?>
<!-- Products List -->
<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">All Products</h6>
                <button onclick="loadAdminPage('products', 'add')" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-circle"></i> Add New Product
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="productsTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            try {
                                $stmt = $conn->prepare("
                                    SELECT p.*, pc.category_name 
                                    FROM product p 
                                    LEFT JOIN product_category pc ON p.category_id = pc.id 
                                    ORDER BY p.id DESC
                                ");
                                $stmt->execute();
                                
                                while ($product = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    $stock_color = $product['qty_in_stock'] > 5 ? 'success' : ($product['qty_in_stock'] > 0 ? 'warning' : 'danger');
                                    
                                    echo "<tr>";
                                    echo "<td>{$product['id']}</td>";
                                    echo "<td><img src='{$product['product_image']}' alt='Product' style='width: 50px; height: 50px; object-fit: cover;'></td>";
                                    echo "<td>" . substr($product['name'], 0, 50) . (strlen($product['name']) > 50 ? '...' : '') . "</td>";
                                    echo "<td>{$product['category_name']}</td>";
                                    echo "<td>$" . number_format($product['price'], 2) . "</td>";
                                    echo "<td><span class='badge bg-{$stock_color}'>{$product['qty_in_stock']}</span></td>";
                                    echo "<td>";
                                    echo "<button class='btn btn-sm btn-warning me-1'>Edit</button>";
                                    echo "<button class='btn btn-sm btn-danger' onclick='deleteProduct({$product['id']})'>Delete</button>";
                                    echo "</td>";
                                    echo "</tr>";
                                }
                            } catch (Exception $e) {
                                echo "<tr><td colspan='7' class='text-center text-danger'>Error loading products: {$e->getMessage()}</td></tr>";
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
function deleteProduct(productId) {
    if (confirm('Are you sure you want to delete this product?')) {
        $.get('../modules/products.php?action=delete&id=' + productId)
            .done(function() {
                loadAdminPage('products');
            });
    }
}
</script>

<?php endif; ?>
