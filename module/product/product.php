<?php
// filepath: d:\xampp\htdocs\code web\module\product\product.php
require_once __DIR__ . '/../../db/connect.php';

// Lấy dữ liệu lọc từ request
$minPrice = isset($_GET['minPrice']) && is_numeric($_GET['minPrice']) ? intval($_GET['minPrice']) : 0;
$maxPrice = isset($_GET['maxPrice']) && is_numeric($_GET['maxPrice']) ? intval($_GET['maxPrice']) : 10000000;
$category = isset($_GET['category']) ? htmlspecialchars($_GET['category']) : 'laptop'; // Lấy category từ URL

$selectedFilters = [];
if (isset($_GET['filters']) && is_array($_GET['filters'])) {
    foreach ($_GET['filters'] as $key => $value) {
        $selectedFilters[htmlspecialchars($key)] = htmlspecialchars($value);
    }
}

// Xây dựng câu lệnh SQL với điều kiện lọc
$sql = "SELECT DISTINCT p.id, p.name, p.product_image, p.price 
        FROM product p 
        INNER JOIN product_category pc ON p.category_id = pc.id 
        LEFT JOIN variation_options vo ON p.id = vo.product_id 
        WHERE pc.category_name = ? AND p.price BETWEEN ? AND ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sii", $category, $minPrice, $maxPrice);
$stmt->execute();
$result = $stmt->get_result();

// Lấy danh sách các bộ lọc và số lượng sản phẩm tương ứng
$filterCategories = [];
$variationSql = "SELECT id, name FROM variation WHERE category_id = (SELECT id FROM product_category WHERE category_name = ?)";
$stmt = $conn->prepare($variationSql);
$stmt->bind_param("s", $category);
$stmt->execute();
$variationResult = $stmt->get_result();

if ($variationResult && $variationResult->num_rows > 0) {
    while ($row = $variationResult->fetch_assoc()) {
        $filterCategories[$row['name']] = $row['id'];
    }
}

$filters = [];
foreach ($filterCategories as $categoryName => $variationId) {
    $filterSql = "
        SELECT vo.value, COUNT(DISTINCT p.id) as count 
        FROM variation_options vo 
        LEFT JOIN product p ON vo.product_id = p.id 
        LEFT JOIN product_category pc ON p.category_id = pc.id 
        WHERE vo.variation_id = ? AND pc.category_name = ? 
        GROUP BY vo.value
    ";

    $stmt = $conn->prepare($filterSql);
    $stmt->bind_param("is", $variationId, $category);
    $stmt->execute();
    $filterResult = $stmt->get_result();

    if ($filterResult && $filterResult->num_rows > 0) {
        $filters[$categoryName] = [];
        while ($row = $filterResult->fetch_assoc()) {
            $filters[$categoryName][] = [
                'value' => htmlspecialchars($row['value']),
                'count' => $row['count'],
            ];
        }
    }
}

// Nếu có bộ lọc được chọn, thêm điều kiện vào câu truy vấn chính
$filterValues = [];
$filterTypes = "";
if (!empty($selectedFilters)) {
    foreach ($selectedFilters as $value) {
        $sql .= " AND EXISTS (
            SELECT 1 FROM variation_options vo2 
            WHERE vo2.product_id = p.id 
            AND vo2.value = ?
        )";
        $filterValues[] = $value;
        $filterTypes .= "s";
    }
}

// Thêm phần sắp xếp
$sortBy = isset($_GET['sortBy']) ? htmlspecialchars($_GET['sortBy']) : '1'; // Giá trị mặc định là '1'
switch ($sortBy) {
    case '1': // Price Low to High
        $sql .= " ORDER BY p.price ASC";
        break;
    case '2': // Price High to Low
        $sql .= " ORDER BY p.price DESC";
        break;
    case '3': // Alphabetical
        $sql .= " ORDER BY p.name ASC";
        break;
    case '4': // Popularity
        $sql .= " ORDER BY p.popularity DESC";
        break;
    default:
        $sql .= " ORDER BY p.price ASC"; // Giá trị mặc định
}

// Chuẩn bị bind tất cả tham số
$allTypes = "sii" . $filterTypes;
$allValues = array_merge([$category, $minPrice, $maxPrice], $filterValues);

$stmt = $conn->prepare($sql);
$stmt->bind_param($allTypes, ...$allValues);
$stmt->execute();
$result = $stmt->get_result();
?>

<!-- filepath: d:\xampp\htdocs\code web\module\product\product.php -->
<div class="container mt-3">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="#" onclick="loadPage('module/main-content/main-content.php', this); return false;">Home</a></li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo ucfirst($category); ?></li>
    </ol>
  </nav>
</div>

<!-- loc san pham -->
<div class="container-fluid mt-5 mb-5 px-2">
  <div class="row">
    <!-- Filter Button for mobile -->
    <div class="d-md-none mb-3">
      <button class="btn btn-dark w-100 fw-bold" type="button" data-bs-toggle="offcanvas" data-bs-target="#filterOffcanvas" aria-controls="filterOffcanvas">
        Filters
      </button>
    </div>
    <!-- Sidebar on the left (desktop) -->
    <div class="col-md-2 d-none d-md-block"> <!-- Đổi col-md-3 thành col-md-2 để giảm chiều rộng -->
      <div class="shadow-sm position-sticky border rounded-3 p-3" style="top: 80px; z-index: 1020; background: #fff">
        <div class="card-body">
          <!-- Filter Form -->
          <form id="filterForm">
            <input type="hidden" name="category" value="<?php echo htmlspecialchars($category); ?>">
            <?php foreach ($filters as $categoryName => $filterOptions): ?>
              <h6 class="card-title text-uppercase fw-bold border-bottom pb-2 mb-3">
                <span class="toggle-category" style="cursor: pointer;" onclick="toggleCategory('<?php echo str_replace(' ', '-', $categoryName); ?>')">
                  <span id="toggle-icon-<?php echo str_replace(' ', '-', $categoryName); ?>">+</span> <?php echo $categoryName; ?>
                </span>
              </h6>
              <div class="mb-4" id="category-<?php echo str_replace(' ', '-', $categoryName); ?>" style="max-height: 120px; overflow-y: auto; display: none;">
                <ul class="list-group list-group-flush">
                  <?php foreach ($filterOptions as $option): ?>
                    <li class="list-group-item px-0">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="filters[<?php echo $categoryName; ?>]" value="<?php echo $option['value']; ?>" id="<?php echo $option['value']; ?>" />
                        <label class="form-check-label fw-semibold" for="<?php echo $option['value']; ?>">
                          <?php echo $option['value']; ?> (<?php echo $option['count']; ?>)
                        </label>
                      </div>
                    </li>
                  <?php endforeach; ?>
                </ul>
              </div>
            <?php endforeach; ?>
            <h6 class="card-title text-uppercase fw-bold border-bottom pb-2 mb-3">Price</h6>
            <div class="d-flex align-items-center gap-2 mb-3">
              <input type="number" name="minPrice" min="0" max="10000000" value="<?php echo $minPrice; ?>" class="form-control" style="width: 45%" />
              <span>-</span>
              <input type="number" name="maxPrice" min="0" max="10000000" value="<?php echo $maxPrice; ?>" class="form-control" style="width: 45%" />
            </div>
            <h6 class="card-title text-uppercase fw-bold border-bottom pb-2 mb-3">Sort by</h6>
            <div class="mb-4">
              <select name="sortBy" class="form-select">
                <option value="1" <?php if ($sortBy === '1') echo 'selected'; ?>>Price (Low to High)</option>
                <option value="2" <?php if ($sortBy === '2') echo 'selected'; ?>>Price (High to Low)</option>
                <option value="3" <?php if ($sortBy === '3') echo 'selected'; ?>>Alphabetical</option>
              </select>
            </div>
            <button type="button" id="filterButton" class="btn btn-dark w-100 rounded-pill fw-bold">Sort</button>
          </form>
        </div>
      </div>
    </div>
    <!-- Offcanvas Filter for mobile -->
    <div class="offcanvas offcanvas-start d-md-none" tabindex="-1" id="filterOffcanvas" aria-labelledby="filterOffcanvasLabel">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="filterOffcanvasLabel">Filters</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body">
        <form id="filterFormMobile">
          <!-- Copy the filter form HTML here, but change id to filterFormMobile -->
          <?php foreach ($filters as $categoryName => $filterOptions): ?>
            <h6 class="card-title text-uppercase fw-bold border-bottom pb-2 mb-3">
              <span class="toggle-category" style="cursor: pointer;" onclick="toggleCategory('<?php echo str_replace(' ', '-', $categoryName); ?>-mobile')">
                <span id="toggle-icon-<?php echo str_replace(' ', '-', $categoryName); ?>-mobile">+</span> <?php echo $categoryName; ?>
              </span>
            </h6>
            <div class="mb-4" id="category-<?php echo str_replace(' ', '-', $categoryName); ?>-mobile" style="max-height: 120px; overflow-y: auto; display: none;">
              <ul class="list-group list-group-flush">
                <?php foreach ($filterOptions as $option): ?>
                  <li class="list-group-item px-0">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="filters[<?php echo $categoryName; ?>]" value="<?php echo $option['value']; ?>" id="<?php echo $option['value']; ?>-mobile" />
                      <label class="form-check-label fw-semibold" for="<?php echo $option['value']; ?>-mobile">
                        <?php echo $option['value']; ?> (<?php echo $option['count']; ?>)
                      </label>
                    </div>
                  </li>
                <?php endforeach; ?>
              </ul>
            </div>
          <?php endforeach; ?>
          <h6 class="card-title text-uppercase fw-bold border-bottom pb-2 mb-3">Price</h6>
          <div class="d-flex align-items-center gap-2 mb-3">
            <input type="number" name="minPrice" min="0" max="10000000" value="<?php echo $minPrice; ?>" class="form-control" style="width: 45%" />
            <span>-</span>
            <input type="number" name="maxPrice" min="0" max="10000000" value="<?php echo $maxPrice; ?>" class="form-control" style="width: 45%" />
          </div>
          <h6 class="card-title text-uppercase fw-bold border-bottom pb-2 mb-3">Sort by</h6>
          <div class="mb-4">
            <select name="sortBy" class="form-select">
              <option value="1" <?php if ($sortBy === '1') echo 'selected'; ?>>Price (Low to High)</option>
              <option value="2" <?php if ($sortBy === '2') echo 'selected'; ?>>Price (High to Low)</option>
              <option value="3" <?php if ($sortBy === '3') echo 'selected'; ?>>Alphabetical</option>
            </select>
          </div>
          <button type="button" id="filterButtonMobile" class="btn btn-dark w-100 rounded-pill fw-bold" data-bs-dismiss="offcanvas">Sort</button>
        </form>
      </div>
    </div>
    <!-- Main content on the right -->
    <div class="col-md-9">
      <div id="productList">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h3 class="fw-bold mb-0"><?php echo ucfirst($category); ?><span class="fs-6 fw-normal"></span></h3>
        </div>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
          <?php
          if ($result && $result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
          ?>
    <div class="col">
      <div class="card border-0 h-100 shadow-sm">
        <a href="#" onclick="loadPage('module/product/single_product.php?id=<?php echo $row['id']; ?>'); return false;" style="text-decoration:none; color:inherit;">
          <img src="<?php echo htmlspecialchars($row['product_image']); ?>" class="card-img-top p-2" alt="<?php echo htmlspecialchars($row['name']); ?>" style="height:260px;object-fit:contain;"> <!-- tăng chiều cao ảnh -->
        </a>
        <div class="card-body text-center">
          <h6 class="card-title fw-bold text-uppercase mb-2" style="font-size: 0.95rem; min-height: 38px;">
            <?php echo htmlspecialchars($row['name']); ?>
          </h6>
          <!-- Xóa dòng mô tả ngắn nếu không cần -->
          <div class="fw-bold mb-2" style="font-size: 1.1rem; margin-top: 0.5rem;"><?php echo number_format($row['price'], 0, ',', '.'); ?>$</div>
          <div class="d-flex justify-content-center gap-2">
            <a href="#" onclick="loadPage('module/product/single_product.php?id=<?php echo $row['id']; ?>'); return false;" class="btn btn-dark btn-sm rounded-pill px-3">
              More details
            </a>
            <button class="btn btn-outline-dark btn-sm rounded-pill px-3" onclick="addToCart(<?php echo $row['id']; ?>)">
              <i class="bi bi-cart"></i>
            </button>
          </div>
        </div>
      </div>
    </div>
          <?php
              }
          } else {
              echo '<div class="col"><div class="alert alert-warning w-100">No products match the current filter. Please try other options.</div></div>';
          }
          ?>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  // Toggle category for both desktop and mobile
  function toggleCategory(categoryId) {
    const categoryElement = document.getElementById(`category-${categoryId}`);
    const toggleIcon = document.getElementById(`toggle-icon-${categoryId}`);
    if (categoryElement.style.display === 'none') {
      categoryElement.style.display = 'block';
      toggleIcon.textContent = '-';
    } else {
      categoryElement.style.display = 'none';
      toggleIcon.textContent = '+';
    }
  }

  // Desktop filter
  document.getElementById('filterButton').addEventListener('click', function () {
    const formData = new FormData(document.getElementById('filterForm'));
    fetch('module/product/filter.php', {
        method: 'POST',
        body: formData,
    })
        .then((response) => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.text();
        })
        .then((data) => {
            document.getElementById('productList').innerHTML = data;
        })
        .catch((error) => {
            console.error('Error:', error);
            document.getElementById('productList').innerHTML = '<div class="alert alert-danger">An error occurred while loading products. Please try again later.</div>';
        });
  });

  // Mobile filter
  document.getElementById('filterButtonMobile').addEventListener('click', function () {
    const formData = new FormData(document.getElementById('filterFormMobile'));
    fetch('module/product/filter.php', {
        method: 'POST',
        body: formData,
    })
        .then((response) => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.text();
        })
        .then((data) => {
            document.getElementById('productList').innerHTML = data;
        })
        .catch((error) => {
            console.error('Error:', error);
            document.getElementById('productList').innerHTML = '<div class="alert alert-danger">An error occurred while loading products. Please try again later.</div>';
        });
  });
</script>
<!-- Make sure Bootstrap JS is loaded for offcanvas to work -->
