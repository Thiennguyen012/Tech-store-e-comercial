<?php
// Kết nối database
require_once __DIR__ . '/../../db/connect.php';
require_once __DIR__ . '../../search/search-logic.php';

$query = isset($_GET['query']) ? trim($_GET['query']) : '';
$isSearchMode = !empty($query); // Kiểm tra có đang ở chế độ tìm kiếm không

// Lấy giá trị lọc giá từ request (nếu có), nếu không thì lấy mặc định
$minPrice = isset($_GET['minPrice']) && is_numeric($_GET['minPrice']) ? intval($_GET['minPrice']) : 0;
$maxPrice = isset($_GET['maxPrice']) && is_numeric($_GET['maxPrice']) ? intval($_GET['maxPrice']) : 10000000;

// Lấy category từ URL, nếu không có thì mặc định là 'laptop'
$category = isset($_GET['category']) ? htmlspecialchars($_GET['category']) : 'laptop';

// Lấy các bộ lọc đã chọn từ request
$selectedFilters = [];
if (isset($_GET['filters']) && is_array($_GET['filters'])) {
  foreach ($_GET['filters'] as $key => $value) {
    $selectedFilters[htmlspecialchars($key)] = htmlspecialchars($value);
  }
}

// Thêm điều kiện sắp xếp
$sortBy = isset($_GET['sortBy']) ? htmlspecialchars($_GET['sortBy']) : '1';

// Xử lý logic tùy theo chế độ
if ($isSearchMode) {
  // Chế độ tìm kiếm
  $result = searchProductsWithFilters($conn, $query, array_values($selectedFilters), $minPrice, $maxPrice, $sortBy);
  $filters = getSearchFilters($conn); // Lấy tất cả bộ lọc
  $pageTitle = 'Search Results for "' . htmlspecialchars($query) . '"';
  $breadcrumbTitle = 'Search Results';
} else {
  // Chế độ category thông thường
  $sql = "SELECT DISTINCT p.id, p.name, p.product_image, p.price 
            FROM product p 
            INNER JOIN product_category pc ON p.category_id = pc.id 
            LEFT JOIN variation_options vo ON p.id = vo.product_id 
            WHERE pc.category_name = ? AND p.price BETWEEN ? AND ?";

  // Lấy danh sách các bộ lọc (variation) cho category hiện tại
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

  // Lấy các giá trị bộ lọc (option) và số lượng sản phẩm cho từng bộ lọc
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

  // Thêm điều kiện sắp xếp
  switch ($sortBy) {
    case '1': // Giá tăng dần
      $sql .= " ORDER BY p.price ASC";
      break;
    case '2': // Giá giảm dần
      $sql .= " ORDER BY p.price DESC";
      break;
    case '3': // Theo tên
      $sql .= " ORDER BY p.name ASC";
      break;
    default:
      $sql .= " ORDER BY p.price ASC";
  }

  $limit = 8;
  $offset = 0;

  // Khởi tạo biến types và values đúng thứ tự
  $allTypes = "sii" . $filterTypes;
  $allValues = array_merge([$category, $minPrice, $maxPrice], $filterValues);

  // Thêm điều kiện phân trang
  $sql .= " LIMIT ? OFFSET ?";
  $allTypes .= "ii";
  $allValues[] = $limit;
  $allValues[] = $offset;

  // Bind tất cả tham số vào statement
  $stmt = $conn->prepare($sql);
  $stmt->bind_param($allTypes, ...$allValues);
  $stmt->execute();
  $result = $stmt->get_result();

  $pageTitle = ucfirst($category);
  $breadcrumbTitle = ucfirst($category);
}
?>

<!-- Breadcrumb -->
<div class="container mt-3">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="#"
          onclick="loadPage('module/main-content/main-content.php', this); return false;">Home</a></li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo $breadcrumbTitle; ?></li>
    </ol>
  </nav>
</div>

<!-- loc san pham -->
<div class="container-fluid mt-5 mb-5 px-2">
  <div class="row">
    <!-- Nút mở bộ lọc cho mobile/tablet (ẩn trên desktop) -->
    <div class="d-md-none mb-3">
      <button class="btn btn-dark w-100 fw-bold" type="button" data-bs-toggle="offcanvas"
        data-bs-target="#filterOffcanvas" aria-controls="filterOffcanvas">
        Filters
      </button>
    </div>
    <!-- Sidebar bộ lọc (chỉ hiện trên desktop/laptop) -->
    <div class="col-md-2 d-none d-md-block">
      <div class="shadow-sm position-sticky border rounded-3 p-3" style="top: 80px; background: #fff">
        <div class="card-body">
          <!-- Form bộ lọc desktop -->
          <form id="filterForm">
            <?php if ($isSearchMode): ?>
              <input type="hidden" name="query" value="<?php echo htmlspecialchars($query); ?>">
            <?php else: ?>
              <input type="hidden" name="category" value="<?php echo htmlspecialchars($category); ?>">
            <?php endif; ?>

            <?php foreach ($filters as $categoryName => $filterOptions): ?>
              <h6 class="card-title text-uppercase fw-bold border-bottom pb-2 mb-3">
                <span class="toggle-category" style="cursor: pointer;"
                  onclick="toggleCategory('<?php echo str_replace(' ', '-', $categoryName); ?>')">
                  <span id="toggle-icon-<?php echo str_replace(' ', '-', $categoryName); ?>">+</span>
                  <?php echo $categoryName; ?>
                </span>
              </h6>
              <div class="mb-4" id="category-<?php echo str_replace(' ', '-', $categoryName); ?>"
                style="max-height: 120px; overflow-y: auto; display: none;">
                <ul class="list-group list-group-flush">
                  <?php foreach ($filterOptions as $option): ?>
                    <li class="list-group-item px-0">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="filters[<?php echo $categoryName; ?>]"
                          value="<?php echo $option['value']; ?>" id="<?php echo $option['value']; ?>" />
                        <label class="form-check-label fw-semibold" for="<?php echo $option['value']; ?>">
                          <?php echo $option['value']; ?> (<?php echo $option['count']; ?>)
                        </label>
                      </div>
                    </li>
                  <?php endforeach; ?>
                </ul>
              </div>
            <?php endforeach; ?>
            <h6 class="card-title text-uppercase fw-bold border-bottom pb-2 mb-3">Price($)</h6>
            <div class="d-flex align-items-center gap-2 flex-wrap mb-3">
              <input type="number" name="minPrice" min="0" max="10000000" value="<?php echo $minPrice; ?>"
                class="form-control w-30" />
              <span>-</span>
              <input type="number" name="maxPrice" min="0" max="10000000" value="<?php echo $maxPrice; ?>"
                class="form-control w-50" />
            </div>
            <h6 class="card-title text-uppercase fw-bold border-bottom pb-2 mb-3">Sort by</h6>
            <div class="mb-4">
              <select name="sortBy" class="form-select">
                <option value="1" <?php if ($sortBy === '1')
                  echo 'selected'; ?>>Price (Low to High)</option>
                <option value="2" <?php if ($sortBy === '2')
                  echo 'selected'; ?>>Price (High to Low)</option>
                <option value="3" <?php if ($sortBy === '3')
                  echo 'selected'; ?>>Alphabetical</option>
              </select>
            </div>
            <div class="d-flex gap-2 flex-wrap">
              <button type="button" id="filterButton" class="btn btn-dark w-100 rounded-pill fw-bold">Sort</button>
              <button type="button" id="resetFilterButton" class="btn btn-outline-dark w-100 rounded-pill fw-bold">Reset
                filter</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- Offcanvas bộ lọc cho mobile/tablet -->
    <div class="offcanvas offcanvas-start d-md-none" tabindex="-1" id="filterOffcanvas"
      aria-labelledby="filterOffcanvasLabel">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="filterOffcanvasLabel">Filters</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body">
        <form id="filterFormMobile">
          <?php if ($isSearchMode): ?>
            <input type="hidden" name="query" value="<?php echo htmlspecialchars($query); ?>">
          <?php else: ?>
            <input type="hidden" name="category" value="<?php echo htmlspecialchars($category); ?>">
          <?php endif; ?>

          <!-- Form bộ lọc mobile (giống desktop nhưng id khác) -->
          <?php foreach ($filters as $categoryName => $filterOptions): ?>
            <h6 class="card-title text-uppercase fw-bold border-bottom pb-2 mb-3">
              <span class="toggle-category" style="cursor: pointer;"
                onclick="toggleCategory('<?php echo str_replace(' ', '-', $categoryName); ?>-mobile')">
                <span id="toggle-icon-<?php echo str_replace(' ', '-', $categoryName); ?>-mobile">+</span>
                <?php echo $categoryName; ?>
              </span>
            </h6>
            <div class="mb-4" id="category-<?php echo str_replace(' ', '-', $categoryName); ?>-mobile"
              style="max-height: 120px; overflow-y: auto; display: none;">
              <ul class="list-group list-group-flush">
                <?php foreach ($filterOptions as $option): ?>
                  <li class="list-group-item px-0">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="filters[<?php echo $categoryName; ?>]"
                        value="<?php echo $option['value']; ?>" id="<?php echo $option['value']; ?>-mobile" />
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
            <input type="number" name="minPrice" min="0" max="10000000" value="<?php echo $minPrice; ?>"
              class="form-control" style="width: 45%" />
            <span>-</span>
            <input type="number" name="maxPrice" min="0" max="10000000" value="<?php echo $maxPrice; ?>"
              class="form-control" style="width: 45%" />
          </div>
          <h6 class="card-title text-uppercase fw-bold border-bottom pb-2 mb-3">Sort by</h6>
          <div class="mb-4">
            <select name="sortBy" class="form-select">
              <option value="1" <?php if ($sortBy === '1')
                echo 'selected'; ?>>Price (Low to High)</option>
              <option value="2" <?php if ($sortBy === '2')
                echo 'selected'; ?>>Price (High to Low)</option>
              <option value="3" <?php if ($sortBy === '3')
                echo 'selected'; ?>>Alphabetical</option>
            </select>
          </div>
          <div class="d-flex gap-2 flex-wrap">
            <button type="button" id="filterButtonMobile" class="btn btn-dark w-100 rounded-pill fw-bold"
              data-bs-dismiss="offcanvas">Sort</button>
            <button type="button" id="resetFilterButtonMobile" class="btn btn-outline-dark w-100 rounded-pill fw-bold">Reset
              filter</button>
          </div>
        </form>
      </div>
    </div>
    <!-- Khu vực hiển thị sản phẩm -->
    <div class="col-md-9">
      <div id="productList">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h3 class="fw-bold mb-0">
            <?php echo $pageTitle; ?>
            <span class="fs-6 fw-normal">
              <?php if ($result): ?>
                (<?php echo $result->num_rows; ?> products<?php echo $isSearchMode ? ' found' : ''; ?>)
              <?php endif; ?>
            </span>
          </h3>
        </div>
        <!-- Grid sản phẩm, responsive theo từng loại màn hình -->
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xxl-4 g-4" id="productGrid">
          <?php
          $productCount = 0;
          if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              $productCount++;
              ?>
              <div class="col">
                <div class="card border-0 h-100 shadow-sm">
                  <a href="#"
                    onclick="loadPage('module/product/single_product.php?id=<?php echo $row['id']; ?>'); return false;"
                    style="text-decoration:none; color:inherit;">
                    <img src="<?php echo htmlspecialchars($row['product_image']); ?>" class="card-img-top p-2"
                      alt="<?php echo htmlspecialchars($row['name']); ?>" style="height:260px;object-fit:contain;">
                  </a>
                  <div class="card-body text-center">
                    <h6 class="card-title fw-bold text-uppercase mb-2" style="font-size: 0.95rem; min-height: 38px;">
                      <?php echo htmlspecialchars($row['name']); ?>
                    </h6>
                    <div class="fw-bold mb-2" style="font-size: 1.1rem; margin-top: 0.5rem;">
                      <?php echo number_format($row['price'], 0, ',', '.'); ?>$
                    </div>
                    <div class="d-flex justify-content-center gap-2">
                      <a href="#"
                        onclick="loadPage('module/product/single_product.php?id=<?php echo $row['id']; ?>'); return false;"
                        class="btn btn-dark btn-sm rounded-pill px-3">
                        More details
                      </a>
                      <!-- Tạo form để lấy thông tin của 1 sản phẩm khi click thêm vào giỏ hàng -->
                      <form id="addToCartForm" action="module/cart/cart.php" method="POST">
                        <input type="hidden" name="product-id" value="<?= $row['id'] ?>">
                        <input type="hidden" name="product-name" value="<?= $row['name'] ?>">
                        <input type="hidden" name="product-price" value="<?= $row['price'] ?>">
                        <input type="hidden" name="product-img" value="<?= $row['product_image'] ?>">
                        <button id="addcart-submit" type="submit" name="add-to-cart"
                          class="btn btn-outline-dark btn-sm rounded-pill px-3">
                          <i class="bi bi-cart"></i>
                        </button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
              <?php
            }
          }
          ?>
        </div>
        <?php if ($result && $result->num_rows == $limit): ?>
          <div class="text-center my-4">
            <button id="showMoreBtn" class="btn btn-outline-dark px-4 rounded-pill" data-offset="<?= $limit ?>">Show more</button>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<script>
  // Ẩn/hiện từng nhóm bộ lọc (desktop & mobile)
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

  // Gửi form lọc (desktop)
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

  // Gửi form lọc (mobile)
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

  // Reset filter desktop
  document.getElementById('resetFilterButton').addEventListener('click', function () {
    const form = document.getElementById('filterForm');
    form.reset();
    // Nếu có giá trị mặc định cho category, minPrice, maxPrice, sortBy thì set lại
    // Gửi lại filter để load toàn bộ sản phẩm
    document.getElementById('filterButton').click();
  });

  // Reset filter mobile
  document.getElementById('resetFilterButtonMobile').addEventListener('click', function () {
    const form = document.getElementById('filterFormMobile');
    form.reset();
    document.getElementById('filterButtonMobile').click();
  });

  
  // Show more sản phẩm
function handleShowMore(e) {
  if (e.target && e.target.id === 'showMoreBtn') {
    const btn = e.target;
    
    // Prevent multiple clicks while loading
    if (btn.disabled) return;
    
    btn.disabled = true;
    btn.textContent = 'Loading...';
    const offset = parseInt(btn.getAttribute('data-offset'), 10);
    const form = document.getElementById('filterForm') || document.getElementById('filterFormMobile');
    const formData = new FormData(form);
    formData.append('limit', 8);
    formData.append('offset', offset);
    formData.append('showMore', 1);

    fetch('module/product/filter.php', {
      method: 'POST',
      body: formData,
    })
      .then(res => res.text())
      .then(html => {
        // Tạo một div tạm để lấy các .col mới
        const tempDiv = document.createElement('div');
        tempDiv.innerHTML = html;

        // Lấy tất cả .col mới và append vào grid
        tempDiv.querySelectorAll('.col').forEach(col => {
          document.getElementById('productGrid').appendChild(col);
        });

        // Xử lý nút show more mới (nếu còn)
        const newShowMore = tempDiv.querySelector('#showMoreBtn');
        if (newShowMore) {
          btn.setAttribute('data-offset', newShowMore.getAttribute('data-offset'));
          btn.disabled = false;
          btn.textContent = 'Show more';
        } else {
          btn.remove();
        }
      })
      .catch(() => {
        btn.textContent = 'Show more';
        btn.disabled = false;
      });
  }
}

// Alternative approach: Check if listener already exists
if (!window.showMoreListenerAdded) {
  document.addEventListener('click', handleShowMore);
  window.showMoreListenerAdded = true;
}
<!-- Make sure Bootstrap JS is loaded for offcanvas to work -->

  // Xử lý thêm vào giỏ hàng bằng AJAX cho tất cả form trên trang
  document.querySelectorAll('form[id="addToCartForm"]').forEach(function (form) {
    form.addEventListener('submit', function (e) {
      e.preventDefault(); // Ngăn submit mặc định

      const formData = new FormData(form);

      fetch('module/cart/cart.php', {
        method: 'POST',
        body: formData
      })
        .then(res => res.json())
        .then(data => {
          if (data.success) {
            alert("Đã thêm sản phẩm vào giỏ hàng!");
            // Cập nhật số trên icon giỏ hàng nếu cần
            document.querySelector('.cart-icon .fw-bold').textContent = data.total;
          } else {
            alert("Thêm vào giỏ hàng thất bại!");
          }
        })
        .catch(err => console.error("Lỗi khi gửi form:", err));
    });
  });

</script>
