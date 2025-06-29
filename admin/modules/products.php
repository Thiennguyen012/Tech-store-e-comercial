<?php
$current_page = 'products';
require_once '../includes/admin-layout.php';

$action = $_POST['action'] ?? $_GET['action'] ?? 'list';

// Sorting parameters
$sort_by = $_GET['sort'] ?? 'id';
$sort_order = $_GET['order'] ?? 'DESC';

// Filtering parameters
$filter_category = $_GET['category'] ?? '';

// Validate sort parameters
$allowed_sorts = ['id', 'name', 'category_name', 'price', 'qty_in_stock'];
$allowed_orders = ['ASC', 'DESC'];

if (!in_array($sort_by, $allowed_sorts)) {
    $sort_by = 'id';
}
if (!in_array($sort_order, $allowed_orders)) {
    $sort_order = 'DESC';
}

// Function to generate sort URL with current filters
function getSortUrl($column, $current_sort, $current_order, $current_category = '') {
    $new_order = ($current_sort == $column && $current_order == 'ASC') ? 'DESC' : 'ASC';
    $url = "products.php?sort=" . $column . "&order=" . $new_order;
    if (!empty($current_category)) {
        $url .= "&category=" . urlencode($current_category);
    }
    return $url;
}

// Function to generate filter URL with current sorting
function getFilterUrl($category_id, $current_sort, $current_order) {
    $url = "products.php";
    $params = [];
    
    if (!empty($category_id)) {
        $params[] = "category=" . urlencode($category_id);
    }
    if ($current_sort != 'id' || $current_order != 'DESC') {
        $params[] = "sort=" . $current_sort;
        $params[] = "order=" . $current_order;
    }
    
    if (!empty($params)) {
        $url .= "?" . implode("&", $params);
    }
    
    return $url;
}

// Function to generate sort icon
function getSortIcon($column, $current_sort, $current_order) {
    if ($current_sort == $column) {
        return $current_order == 'ASC' ? '<i class="bi bi-arrow-up"></i>' : '<i class="bi bi-arrow-down"></i>';
    }
    return '<i class="bi bi-arrow-up-down text-muted"></i>';
}

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
        echo '<script>
            alert("Product added successfully!");
            location.href = "products.php";
        </script>';
    } catch (Exception $e) {
        echo '<div class="alert alert-danger">Error: ' . $e->getMessage() . '</div>';
    }
}

if ($action == 'edit' && $_POST) {
    // Handle edit product
    try {
        $stmt = $conn->prepare("
            UPDATE product 
            SET name = ?, description = ?, category_id = ?, qty_in_stock = ?, product_image = ?, price = ? 
            WHERE id = ?
        ");
        $stmt->execute([
            $_POST['name'],
            $_POST['description'],
            $_POST['category_id'],
            $_POST['qty_in_stock'],
            $_POST['product_image'],
            $_POST['price'],
            $_POST['id']
        ]);
        echo '<script>
            alert("Product updated successfully!");
            location.href = "products.php";
        </script>';
    } catch (Exception $e) {
        echo '<div class="alert alert-danger">Error: ' . $e->getMessage() . '</div>';
    }
}

if ($action == 'delete' && isset($_GET['id'])) {
    try {
        $stmt = $conn->prepare("DELETE FROM product WHERE id = ?");
        $stmt->execute([$_GET['id']]);
        echo '<script>
            alert("Product deleted successfully!");
            location.href = "products.php";
        </script>';
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
                <form method="POST" action="products.php?action=add">
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
                                        $category_display = ucfirst(htmlspecialchars($category['category_name']));
                                        echo "<option value='{$category['id']}'>{$category_display}</option>";
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
                    <button type="button" onclick="location.href='products.php'" class="btn btn-secondary">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php elseif ($action == 'edit'): ?>
<!-- Edit Product Form -->
<?php
$product_id = $_GET['id'] ?? 0;
try {
    $stmt = $conn->prepare("SELECT * FROM product WHERE id = ?");
    $stmt->execute([$product_id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$product) {
        echo '<div class="alert alert-danger">Product not found!</div>';
        exit;
    }
} catch (Exception $e) {
    echo '<div class="alert alert-danger">Error: ' . $e->getMessage() . '</div>';
    exit;
}
?>
<div class="row">
    <div class="col-lg-10">
        <div class="card shadow">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Edit Product</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="products.php?action=edit&id=<?php echo $product['id']; ?>">
                    <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label>Product Name</label>
                            <input type="text" class="form-control" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Price ($)</label>
                            <input type="number" step="0.01" class="form-control" name="price" value="<?php echo $product['price']; ?>" required>
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
                                        $selected = ($category['id'] == $product['category_id']) ? 'selected' : '';
                                        $category_display = ucfirst(htmlspecialchars($category['category_name']));
                                        echo "<option value='{$category['id']}' {$selected}>{$category_display}</option>";
                                    }
                                } catch (Exception $e) {
                                    echo "<option value=''>Error loading categories</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Quantity in Stock</label>
                            <input type="number" class="form-control" name="qty_in_stock" value="<?php echo $product['qty_in_stock']; ?>" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label>Product Image URL</label>
                        <input type="url" class="form-control" name="product_image" value="<?php echo htmlspecialchars($product['product_image']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label>Description</label>
                        <textarea class="form-control" name="description" rows="5"><?php echo htmlspecialchars($product['description']); ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Product</button>
                    <button type="button" onclick="location.href='products.php'" class="btn btn-secondary">Cancel</button>
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
            <div class="card-header py-3">
                <div class="d-flex flex-row align-items-center justify-content-between">
                    <div>
                        <h6 class="m-0 font-weight-bold text-dark">All Products</h6>
                        <?php if ($sort_by != 'id' || $sort_order != 'DESC' || !empty($filter_category)): ?>
                            <small class="text-muted">
                                <?php if ($sort_by != 'id' || $sort_order != 'DESC'): ?>
                                    Sorted by: <strong><?php 
                                        $sort_names = [
                                            'id' => 'ID',
                                            'name' => 'Name', 
                                            'category_name' => 'Category',
                                            'price' => 'Price',
                                            'qty_in_stock' => 'Stock'
                                        ];
                                        echo $sort_names[$sort_by] . ' (' . ($sort_order == 'ASC' ? 'A-Z' : 'Z-A') . ')';
                                    ?></strong>
                                <?php endif; ?>
                                <?php if (!empty($filter_category)): ?>
                                    <?php if ($sort_by != 'id' || $sort_order != 'DESC'): echo ' | '; endif; ?>
                                    Filtered by: <strong><?php 
                                        try {
                                            $stmt = $conn->prepare("SELECT category_name FROM product_category WHERE id = ?");
                                            $stmt->execute([$filter_category]);
                                            $cat = $stmt->fetch();
                                            echo $cat ? ucfirst(htmlspecialchars($cat['category_name'])) : 'Unknown Category';
                                        } catch (Exception $e) {
                                            echo 'Category';
                                        }
                                    ?></strong>
                                <?php endif; ?>
                            </small>
                        <?php endif; ?>
                    </div>
                    <div class="d-flex gap-2">
                        <?php if ($sort_by != 'id' || $sort_order != 'DESC' || !empty($filter_category)): ?>
                            <a href="products.php" class="btn btn-outline-secondary btn-sm" title="Reset sorting and filters">
                                <i class="bi bi-arrow-clockwise"></i> Reset All
                            </a>
                        <?php endif; ?>
                        <a href="products.php?action=add" class="btn btn-dark btn-sm">
                            <i class="bi bi-plus-circle"></i> Add New Product
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <!-- Category Filter -->
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="categoryFilter" class="form-label small text-muted">Filter by Category:</label>
                        <select id="categoryFilter" class="form-select form-select-md" onchange="filterByCategory(this.value)">
                            <option value="">All Categories</option>
                            <?php
                            try {
                                $stmt = $conn->prepare("SELECT id, category_name FROM product_category ORDER BY category_name");
                                $stmt->execute();
                                while ($category = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    $selected = ($filter_category == $category['id']) ? 'selected' : '';
                                    $category_display = ucfirst(htmlspecialchars($category['category_name']));
                                    echo "<option value='{$category['id']}' {$selected}>{$category_display}</option>";
                                }
                            } catch (Exception $e) {
                                echo "<option value=''>Error loading categories</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-8 d-flex align-items-end justify-content-between">
                        <small class="text-muted">
                            <?php
                            try {
                                // Build WHERE clause for filtering
                                $where_clause = "";
                                $params = [];
                                if (!empty($filter_category)) {
                                    $where_clause = "WHERE p.category_id = ?";
                                    $params[] = $filter_category;
                                }
                                
                                $count_stmt = $conn->prepare("
                                    SELECT COUNT(*) as total 
                                    FROM product p 
                                    LEFT JOIN product_category pc ON p.category_id = pc.id 
                                    {$where_clause}
                                ");
                                $count_stmt->execute($params);
                                $filtered_products = $count_stmt->fetch()['total'];
                                
                                // Total products count
                                $total_stmt = $conn->prepare("SELECT COUNT(*) as total FROM product");
                                $total_stmt->execute();
                                $total_products = $total_stmt->fetch()['total'];
                                
                                if (!empty($filter_category)) {
                                    echo "Showing {$filtered_products} of {$total_products} products";
                                } else {
                                    echo "Showing {$total_products} product" . ($total_products != 1 ? 's' : '');
                                }
                            } catch (Exception $e) {
                                echo "Products list";
                            }
                            ?>
                        </small>
                        
                        <!-- Quick sort buttons -->
                        <div class="btn-group btn-group-sm d-none d-md-block" role="group">
                            <button type="button" class="btn <?php echo ($sort_by == 'name') ? 'btn-dark' : 'btn-outline-secondary'; ?>" 
                                    onclick="location.href='<?php echo getSortUrl('name', $sort_by, $sort_order, $filter_category); ?>'" title="Sort by Name">
                                <i class="bi bi-sort-alpha-down"></i>
                            </button>
                            <button type="button" class="btn <?php echo ($sort_by == 'price') ? 'btn-dark' : 'btn-outline-secondary'; ?>" 
                                    onclick="location.href='<?php echo getSortUrl('price', $sort_by, $sort_order, $filter_category); ?>'" title="Sort by Price">
                                <i class="bi bi-currency-dollar"></i>
                            </button>
                            <button type="button" class="btn <?php echo ($sort_by == 'qty_in_stock') ? 'btn-dark' : 'btn-outline-secondary'; ?>" 
                                    onclick="location.href='<?php echo getSortUrl('qty_in_stock', $sort_by, $sort_order, $filter_category); ?>'" title="Sort by Stock">
                                <i class="bi bi-boxes"></i>
                            </button>
                        </div>
                    </div>
                </div>
                
                <div class="table-responsive">
                    <!-- Mobile Cards (visible only on small screens) -->
                    <div class="d-block d-md-none">
                        <?php
                        try {
                            // Build WHERE clause for filtering
                            $where_clause = "";
                            $params = [];
                            if (!empty($filter_category)) {
                                $where_clause = "WHERE p.category_id = ?";
                                $params[] = $filter_category;
                            }
                            
                            // Build the ORDER BY clause for mobile
                            $order_clause = "ORDER BY ";
                            if ($sort_by == 'category_name') {
                                $order_clause .= "pc.category_name " . $sort_order . ", p.id DESC";
                            } else {
                                $order_clause .= "p." . $sort_by . " " . $sort_order;
                                if ($sort_by != 'id') {
                                    $order_clause .= ", p.id DESC";
                                }
                            }
                            
                            $stmt = $conn->prepare("
                                SELECT p.*, pc.category_name 
                                FROM product p 
                                LEFT JOIN product_category pc ON p.category_id = pc.id 
                                {$where_clause}
                                {$order_clause}
                            ");
                            $stmt->execute($params);
                            
                            while ($product = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                $stock_color = $product['qty_in_stock'] > 5 ? 'success' : ($product['qty_in_stock'] > 0 ? 'warning' : 'danger');
                                ?>
                                <div class="card mb-3 border mobile-product-card">
                                    <div class="card-body p-3">
                                        <div class="row align-items-center">
                                            <div class="col-3">
                                                <img src="<?php echo htmlspecialchars($product['product_image']); ?>" 
                                                     alt="Product" 
                                                     class="img-fluid rounded" 
                                                     style="max-height: 80px; object-fit: cover;">
                                            </div>
                                            <div class="col-9">
                                                <h6 class="card-title mb-1 text-dark">
                                                    <?php echo htmlspecialchars(substr($product['name'], 0, 30) . (strlen($product['name']) > 30 ? '...' : '')); ?>
                                                </h6>
                                                <div class="small text-muted mb-2">
                                                    <div><strong>ID:</strong> #<?php echo $product['id']; ?></div>
                                                    <div><strong>Category:</strong> <?php echo htmlspecialchars(ucfirst($product['category_name'] ?? 'N/A')); ?></div>
                                                    <div><strong>Price:</strong> $<?php echo number_format($product['price'], 2); ?></div>
                                                    <div><strong>Stock:</strong> <span class="badge bg-<?php echo $stock_color; ?>"><?php echo $product['qty_in_stock']; ?></span></div>
                                                </div>
                                                <div class="d-grid gap-2 d-md-block">
                                                    <a href="products.php?action=edit&id=<?php echo $product['id']; ?>" class="btn btn-outline-dark btn-sm">
                                                        <i class="bi bi-pencil"></i> Edit
                                                    </a>
                                                    <a href="products.php?action=delete&id=<?php echo $product['id']; ?>" 
                                                       class="btn btn-dark btn-sm" 
                                                       onclick="return confirm('Are you sure you want to delete this product?')">
                                                        <i class="bi bi-trash"></i> Delete
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        } catch (Exception $e) {
                            echo '<div class="alert alert-danger">Error loading products: ' . htmlspecialchars($e->getMessage()) . '</div>';
                        }
                        ?>
                    </div>
                    
                    <!-- Desktop Table (hidden on small screens) -->
                    <div class="d-none d-md-block">
                    <table class="table table-bordered table-hover" id="productsTable">
                        <thead>
                            <tr>
                                <th style="width: 60px;">ID</th>
                                <th style="width: 80px;">Image</th>
                                <th>
                                    <a href="<?php echo getSortUrl('name', $sort_by, $sort_order, $filter_category); ?>" class="text-decoration-none text-dark d-flex align-items-center">
                                        Name <?php echo getSortIcon('name', $sort_by, $sort_order); ?>
                                    </a>
                                </th>
                                <th>
                                    <a href="<?php echo getSortUrl('category_name', $sort_by, $sort_order, $filter_category); ?>" class="text-decoration-none text-dark d-flex align-items-center">
                                        Category <?php echo getSortIcon('category_name', $sort_by, $sort_order); ?>
                                    </a>
                                </th>
                                <th>
                                    <a href="<?php echo getSortUrl('price', $sort_by, $sort_order, $filter_category); ?>" class="text-decoration-none text-dark d-flex align-items-center">
                                        Price <?php echo getSortIcon('price', $sort_by, $sort_order); ?>
                                    </a>
                                </th>
                                <th>
                                    <a href="<?php echo getSortUrl('qty_in_stock', $sort_by, $sort_order, $filter_category); ?>" class="text-decoration-none text-dark d-flex align-items-center">
                                        Stock <?php echo getSortIcon('qty_in_stock', $sort_by, $sort_order); ?>
                                    </a>
                                </th>
                                <th style="width: 150px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            try {
                                // Build WHERE clause for filtering  
                                $where_clause = "";
                                $params = [];
                                if (!empty($filter_category)) {
                                    $where_clause = "WHERE p.category_id = ?";
                                    $params[] = $filter_category;
                                }
                                
                                // Build the ORDER BY clause
                                $order_clause = "ORDER BY ";
                                if ($sort_by == 'category_name') {
                                    $order_clause .= "pc.category_name " . $sort_order . ", p.id DESC";
                                } else {
                                    $order_clause .= "p." . $sort_by . " " . $sort_order;
                                    if ($sort_by != 'id') {
                                        $order_clause .= ", p.id DESC";
                                    }
                                }
                                
                                $stmt = $conn->prepare("
                                    SELECT p.*, pc.category_name 
                                    FROM product p 
                                    LEFT JOIN product_category pc ON p.category_id = pc.id 
                                    {$where_clause}
                                    {$order_clause}
                                ");
                                $stmt->execute($params);
                                
                                while ($product = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    $stock_color = $product['qty_in_stock'] > 5 ? 'success' : ($product['qty_in_stock'] > 0 ? 'warning' : 'danger');
                                    
                                    echo "<tr>";
                                    echo "<td>{$product['id']}</td>";
                                    echo "<td><img src='{$product['product_image']}' alt='Product' style='width: 50px; height: 50px; object-fit: cover;'></td>";
                                    echo "<td>" . substr($product['name'], 0, 50) . (strlen($product['name']) > 50 ? '...' : '') . "</td>";
                                    echo "<td>" . ucfirst($product['category_name']) . "</td>";
                                    echo "<td>$" . number_format($product['price'], 2) . "</td>";
                                    echo "<td><span class='badge bg-{$stock_color}'>{$product['qty_in_stock']}</span></td>";
                                    echo "<td>";
                                    echo "<a href='products.php?action=edit&id={$product['id']}' class='btn btn-sm btn-outline-dark me-1'>Edit</a>";
                                    echo "<a href='products.php?action=delete&id={$product['id']}' class='btn btn-sm btn-dark' onclick='return confirm(\"Are you sure you want to delete this product?\")'>Delete</a>";
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
</div>

<?php endif; ?>

<style>
/* Sortable table headers */
.table thead th a {
    display: flex !important;
    align-items: center;
    justify-content: space-between;
    color: #495057 !important;
    text-decoration: none !important;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.75rem;
    letter-spacing: 0.05em;
}

.table thead th a:hover {
    color: #212529 !important;
    background-color: rgba(0, 0, 0, 0.05);
    border-radius: 0.25rem;
    padding: 0.25rem 0.5rem;
    margin: -0.25rem -0.5rem;
}

.table thead th a i {
    margin-left: 0.5rem;
    font-size: 0.875rem;
}

.table thead th a i.text-muted {
    opacity: 0.5;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .table thead th a {
        font-size: 0.7rem;
        flex-direction: column;
        gap: 0.25rem;
    }
    
    .table thead th a i {
        margin-left: 0;
    }
    
    .d-flex.gap-2 {
        flex-direction: column;
        gap: 0.5rem !important;
    }
}

/* Product image styling */
.table tbody td img {
    border-radius: 0.375rem;
    border: 1px solid #e9ecef;
}

/* Badge styling */
.badge.bg-success {
    background-color: #198754 !important;
}
.badge.bg-warning {
    background-color: #ffc107 !important;
    color: #000 !important;
}
.badge.bg-danger {
    background-color: #dc3545 !important;
}

/* Mobile card improvements */
@media (max-width: 767.98px) {
    .mobile-product-card {
        transition: transform 0.2s;
    }
    
    .mobile-product-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15) !important;
    }
}

/* Quick sort buttons */
.btn-group .btn {
    transition: all 0.2s;
}

.btn-group .btn:hover {
    transform: translateY(-1px);
}

/* Category dropdown styling */
#categoryFilter option {
    text-transform: capitalize;
}

.form-select option {
    text-transform: capitalize;
}
</style>

<script>
// Category filter function
function filterByCategory(categoryId) {
    var url = 'products.php';
    var params = [];
    
    // Add category filter if selected
    if (categoryId) {
        params.push('category=' + encodeURIComponent(categoryId));
    }
    
    // Preserve current sorting
    <?php if ($sort_by != 'id' || $sort_order != 'DESC'): ?>
        params.push('sort=<?php echo $sort_by; ?>');
        params.push('order=<?php echo $sort_order; ?>');
    <?php endif; ?>
    
    if (params.length > 0) {
        url += '?' + params.join('&');
    }
    
    location.href = url;
}

// Add keyboard shortcuts for sorting and filtering
document.addEventListener('keydown', function(e) {
    // Alt + N = Sort by Name
    if (e.altKey && e.key === 'n') {
        e.preventDefault();
        location.href = '<?php echo getSortUrl('name', $sort_by, $sort_order, $filter_category); ?>';
    }
    // Alt + P = Sort by Price  
    if (e.altKey && e.key === 'p') {
        e.preventDefault();
        location.href = '<?php echo getSortUrl('price', $sort_by, $sort_order, $filter_category); ?>';
    }
    // Alt + S = Sort by Stock
    if (e.altKey && e.key === 's') {
        e.preventDefault();
        location.href = '<?php echo getSortUrl('qty_in_stock', $sort_by, $sort_order, $filter_category); ?>';
    }
    // Alt + C = Focus on category filter
    if (e.altKey && e.key === 'c') {
        e.preventDefault();
        document.getElementById('categoryFilter').focus();
    }
    // Alt + R = Reset sorting and filters
    if (e.altKey && e.key === 'r') {
        e.preventDefault();
        location.href = 'products.php';
    }
});

// Confirm delete with better UX
function confirmDelete(productName, productId) {
    if (confirm(`Are you sure you want to delete "${productName}"?\n\nThis action cannot be undone.`)) {
        location.href = `products.php?action=delete&id=${productId}`;
    }
}

// Auto-refresh stock status colors
function updateStockColors() {
    document.querySelectorAll('.badge').forEach(badge => {
        const stock = parseInt(badge.textContent);
        badge.className = 'badge ';
        if (stock > 5) {
            badge.className += 'bg-success';
        } else if (stock > 0) {
            badge.className += 'bg-warning';
        } else {
            badge.className += 'bg-danger';
        }
    });
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    updateStockColors();
    
    // Add tooltips for keyboard shortcuts
    const tooltips = [
        { selector: 'a[href*="sort=name"]', text: 'Sort by Name (Alt+N)' },
        { selector: 'a[href*="sort=price"]', text: 'Sort by Price (Alt+P)' },
        { selector: 'a[href*="sort=qty_in_stock"]', text: 'Sort by Stock (Alt+S)' },
        { selector: 'a[href="products.php"]', text: 'Reset Sort (Alt+R)' }
    ];
    
    tooltips.forEach(tip => {
        const element = document.querySelector(tip.selector);
        if (element) {
            element.title = tip.text;
        }
    });
});
</script>

<?php require_once '../includes/admin-layout-footer.php'; ?>
