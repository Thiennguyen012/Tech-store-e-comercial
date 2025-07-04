<?php
$current_page = 'top-products-config';
require_once '../includes/admin-layout.php';


// Handle form submission
if ($_POST) {
    try {
        $configs = [
            'top_laptop_ids' => implode(',', $_POST['top_laptop_ids'] ?? []),
            'top_camera_ids' => implode(',', $_POST['top_camera_ids'] ?? [])
        ];
        
        foreach ($configs as $key => $value) {
            $stmt = $conn->prepare("
                INSERT INTO top_products_config (config_key, config_value) 
                VALUES (?, ?) 
                ON DUPLICATE KEY UPDATE config_value = ?
            ");
            $stmt->execute([$key, $value, $value]);
        }
        
        echo '<script>
            alert("Configuration saved successfully!");
            location.href = "top-products-config.php";
        </script>';
    } catch (Exception $e) {
        echo '<div class="alert alert-danger">Error saving configuration: ' . $e->getMessage() . '</div>';
    }
}

// Load current configuration
function getConfig($conn, $key, $default = '') {
    try {
        $stmt = $conn->prepare("SELECT config_value FROM top_products_config WHERE config_key = ?");
        $stmt->execute([$key]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['config_value'] : $default;
    } catch (Exception $e) {
        return $default;
    }
}

$currentTopLaptopIds = array_filter(explode(',', getConfig($conn, 'top_laptop_ids', '1,2,3,4')));
$currentTopCameraIds = array_filter(explode(',', getConfig($conn, 'top_camera_ids', '13,14,15,16')));
?>

<div class="row mb-4">
    <div class="col-12">
        <h2>Top Products Configuration</h2>
        <p class="text-muted">Configure which products appear in the Top Products sections</p>
    </div>
</div>

<form method="POST">
    <div class="row">
        <!-- Top Laptops Section -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Top Laptops (Select 4)</h6>
                </div>
                <div class="card-body">
                    <div style="max-height: 300px; overflow-y: auto;">
                        <?php
                        try {
                            $stmt = $conn->prepare("
                                SELECT p.id, p.name, p.price, p.product_image 
                                FROM product p 
                                INNER JOIN product_category pc ON p.category_id = pc.id 
                                WHERE pc.category_name = 'laptop' 
                                ORDER BY p.name
                            ");
                            $stmt->execute();
                            
                            while ($laptop = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                $checked = in_array($laptop['id'], $currentTopLaptopIds) ? 'checked' : '';
                                echo '<div class="form-check mb-2 p-2 border rounded">';
                                echo '<div class="row align-items-center">';
                                echo '<div class="col-2">';
                                echo '<img src="' . htmlspecialchars($laptop['product_image']) . '" class="img-fluid rounded" style="max-height: 40px;">';
                                echo '</div>';
                                echo '<div class="col-10">';
                                echo '<input class="form-check-input top-laptop-checkbox" type="checkbox" name="top_laptop_ids[]" value="' . $laptop['id'] . '" id="laptop_' . $laptop['id'] . '" ' . $checked . '>';
                                echo '<label class="form-check-label ms-2" for="laptop_' . $laptop['id'] . '">';
                                echo '<strong>' . htmlspecialchars(substr($laptop['name'], 0, 30)) . '</strong><br>';
                                echo '<small class="text-muted">ID: ' . $laptop['id'] . ' | $' . number_format($laptop['price'], 2) . '</small>';
                                echo '</label>';
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                            }
                        } catch (Exception $e) {
                            echo '<div class="alert alert-danger">Error loading laptops</div>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Cameras Section -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Top Cameras (Select 4)</h6>
                </div>
                <div class="card-body">
                    <div style="max-height: 300px; overflow-y: auto;">
                        <?php
                        try {
                            $stmt = $conn->prepare("
                                SELECT p.id, p.name, p.price, p.product_image 
                                FROM product p 
                                INNER JOIN product_category pc ON p.category_id = pc.id 
                                WHERE pc.category_name = 'camera' 
                                ORDER BY p.name
                            ");
                            $stmt->execute();
                            
                            while ($camera = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                $checked = in_array($camera['id'], $currentTopCameraIds) ? 'checked' : '';
                                echo '<div class="form-check mb-2 p-2 border rounded">';
                                echo '<div class="row align-items-center">';
                                echo '<div class="col-2">';
                                echo '<img src="' . htmlspecialchars($camera['product_image']) . '" class="img-fluid rounded" style="max-height: 40px;">';
                                echo '</div>';
                                echo '<div class="col-10">';
                                echo '<input class="form-check-input top-camera-checkbox" type="checkbox" name="top_camera_ids[]" value="' . $camera['id'] . '" id="camera_' . $camera['id'] . '" ' . $checked . '>';
                                echo '<label class="form-check-label ms-2" for="camera_' . $camera['id'] . '">';
                                echo '<strong>' . htmlspecialchars(substr($camera['name'], 0, 30)) . '</strong><br>';
                                echo '<small class="text-muted">ID: ' . $camera['id'] . ' | $' . number_format($camera['price'], 2) . '</small>';
                                echo '</label>';
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                            }
                        } catch (Exception $e) {
                            echo '<div class="alert alert-danger">Error loading cameras</div>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-body text-center">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="bi bi-check-circle"></i> Save Configuration
                    </button>
                    <a href="products.php" class="btn btn-secondary btn-lg ms-2">
                        <i class="bi bi-arrow-left"></i> Back to Products
                    </a>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
// Limit selection to 4 items for top products
function limitCheckboxes(className, maxSelections) {
    const checkboxes = document.querySelectorAll('.' + className);
    
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const checkedBoxes = document.querySelectorAll('.' + className + ':checked');
            
            if (checkedBoxes.length > maxSelections) {
                this.checked = false;
                alert(`You can only select up to ${maxSelections} items.`);
            }
        });
    });
}

// Initialize checkbox limits
limitCheckboxes('top-laptop-checkbox', 4);
limitCheckboxes('top-camera-checkbox', 4);

// Add visual feedback for selections
document.addEventListener('DOMContentLoaded', function() {
    const allCheckboxes = document.querySelectorAll('input[type="checkbox"]');
    
    allCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const parentDiv = this.closest('.form-check');
            if (this.checked) {
                parentDiv.style.backgroundColor = '#e3f2fd';
                parentDiv.style.borderColor = '#2196f3';
            } else {
                parentDiv.style.backgroundColor = '';
                parentDiv.style.borderColor = '';
            }
        });
        
        // Set initial state
        if (checkbox.checked) {
            const parentDiv = checkbox.closest('.form-check');
            parentDiv.style.backgroundColor = '#e3f2fd';
            parentDiv.style.borderColor = '#2196f3';
        }
    });
});
</script>

<style>
.form-check {
    transition: all 0.2s;
}

.form-check:hover {
    background-color: #f8f9fa !important;
}

.card-body {
    max-height: 400px;
}

.form-select option {
    padding: 8px;
}
</style>

<?php require_once '../includes/admin-layout-footer.php'; ?>
                    </button>
                    <a href="products.php" class="btn btn-secondary btn-lg ms-2">
                        <i class="bi bi-arrow-left"></i> Back to Products
                    </a>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
// Limit selection to 4 items for top products
function limitCheckboxes(className, maxSelections) {
    const checkboxes = document.querySelectorAll('.' + className);
    
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const checkedBoxes = document.querySelectorAll('.' + className + ':checked');
            
            if (checkedBoxes.length > maxSelections) {
                this.checked = false;
                alert(`You can only select up to ${maxSelections} items.`);
            }
        });
    });
}

// Initialize checkbox limits
limitCheckboxes('top-laptop-checkbox', 4);
limitCheckboxes('top-camera-checkbox', 4);

// Add visual feedback for selections
document.addEventListener('DOMContentLoaded', function() {
    const allCheckboxes = document.querySelectorAll('input[type="checkbox"]');
    
    allCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const parentDiv = this.closest('.form-check');
            if (this.checked) {
                parentDiv.style.backgroundColor = '#e3f2fd';
                parentDiv.style.borderColor = '#2196f3';
            } else {
                parentDiv.style.backgroundColor = '';
                parentDiv.style.borderColor = '';
            }
        });
        
        // Set initial state
        if (checkbox.checked) {
            const parentDiv = checkbox.closest('.form-check');
            parentDiv.style.backgroundColor = '#e3f2fd';
            parentDiv.style.borderColor = '#2196f3';
        }
    });
});
</script>

<style>
.form-check {
    transition: all 0.2s;
}

.form-check:hover {
    background-color: #f8f9fa !important;
}

.card-body {
    max-height: 400px;
}

.form-select option {
    padding: 8px;
}
</style>

<?php require_once '../includes/admin-layout-footer.php'; ?>
