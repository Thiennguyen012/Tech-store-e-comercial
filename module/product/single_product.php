<?php
// Kết nối database
require_once __DIR__ . '/../../db/connect.php';

// Lấy id sản phẩm từ URL
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Lấy thông tin sản phẩm
$sql = "SELECT * FROM product WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result && $result->num_rows > 0 ? $result->fetch_assoc() : null;

// Lấy số sao trung bình và tổng số đánh giá
$avg_sql = "SELECT AVG(rating) as avg_rating, COUNT(*) as total_reviews FROM product_review WHERE product_id = ?";
$stmt = $conn->prepare($avg_sql);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$avg_result = $stmt->get_result()->fetch_assoc();
$avg_rating = round($avg_result['avg_rating'], 1);
$total_reviews = $avg_result['total_reviews'];

// Lấy danh sách đánh giá (mới nhất trước)
$reviews = [];
$review_sql = "SELECT pr.*, u.username FROM product_review pr LEFT JOIN site_user u ON pr.user_id = u.id WHERE pr.product_id = ? ORDER BY pr.created_at DESC";
$stmt = $conn->prepare($review_sql);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
  $reviews[] = $row;
}

// Lấy tên hãng (brand) phù hợp với từng category
$brand = '';
$brand_variation = '';
switch ($product['category_id']) {
  case 1: // laptop
    $brand_variation = 'Brand';
    break;
  case 2: // camera
    $brand_variation = 'CCTV brand';
    break;
  case 3: // accessories
    $brand_variation = 'accessory_brand';
    break;
}
if ($brand_variation) {
  // Lấy giá trị brand từ variation_options
  $brandSql = "SELECT vo.value FROM variation_options vo
        JOIN variation v ON vo.variation_id = v.id
        WHERE vo.product_id = ? AND v.name = ? LIMIT 1";
  $brandStmt = $conn->prepare($brandSql);
  $brandStmt->bind_param('is', $product_id, $brand_variation);
  $brandStmt->execute();
  $brandStmt->bind_result($brand);
  $brandStmt->fetch();
  $brandStmt->close();
}

// Lấy các thuộc tính cấu hình (nếu có)
$configs = [];
$config_sql = "SELECT v.name as variation, vo.value 
               FROM variation_options vo 
               JOIN variation v ON vo.variation_id = v.id 
               WHERE vo.product_id = ?";
$stmt = $conn->prepare($config_sql);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$config_result = $stmt->get_result();
while ($row = $config_result->fetch_assoc()) {
  $configs[] = $row;
}
?>
<?php if ($product): ?>
  <div class="container mt-5 mb-5">
    <div class="p-4 rounded shadow" style="background: #fff;">
      <!-- Breadcrumb -->
      <style>
        .breadcrumb a {
          color: rgb(126, 130, 134) !important;
          text-decoration: none !important;
          font-family: inherit !important;
          font-size: inherit !important;
        }

        .breadcrumb a:hover {
          text-decoration: underline !important;
        }
      </style>
      <nav style="--bs-breadcrumb-divider: '/';" aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="#" onclick="loadPage('module/main-content/main-content.php'); return false;">Home</a>
          </li>
          <li class="breadcrumb-item">
            <a href="#" onclick="loadPage('module/product/product.php', this, 'products'); return false;">Laptops</a>
          </li>
          <li class="breadcrumb-item">
            <!-- Breadcrumb hãng, tự động lấy theo category và brand -->
            <a href="#" onclick="loadPage('module/product/product.php?category=<?php
                                                                                // Lấy category
                                                                                $catSql = 'SELECT category_name FROM product_category WHERE id = ? LIMIT 1';
                                                                                $catStmt = $conn->prepare($catSql);
                                                                                $catStmt->bind_param('i', $product['category_id']);
                                                                                $catStmt->execute();
                                                                                $catStmt->bind_result($catName);
                                                                                $catStmt->fetch();
                                                                                $catStmt->close();
                                                                                echo urlencode($catName);
                                                                                ?>&filters[<?php echo urlencode($brand_variation); ?>]=<?php echo urlencode($brand); ?>', this, 'products'); return false;">
              <?php echo htmlspecialchars($brand); ?>
            </a>
          </li>
          <li class="breadcrumb-item active" aria-current="page"><?php echo htmlspecialchars($product['name']); ?></li>
        </ol>
      </nav>
      <!-- End Breadcrumb -->
      <div class="row">
        <div class="col-md-5 text-center">
          <!-- Ảnh sản phẩm -->
          <img src="<?php echo htmlspecialchars($product['product_image']); ?>" class="img-fluid" alt="<?php echo htmlspecialchars($product['name']); ?>">
        </div>
        <div class="col-md-7">
          <h2 class="fw-bold"><?php echo htmlspecialchars($product['name']); ?></h2>
          <div class="mb-2" style="font-size: 2rem;">
            <?php
            for ($i = 1; $i <= 5; $i++) {
              echo $i <= round($avg_rating) ? '<span style="color:#ffc107">&#9733;</span>' : '<span style="color:#ccc">&#9733;</span>';
            }
            ?>
            <span class="ms-2 text-dark" style="font-size: 1.2rem;"><?php echo $avg_rating; ?>/5</span>
            <span class="text-muted ms-2" style="font-size: 1rem;">(<?php echo $total_reviews; ?> reviews)</span>
          </div>
          <div class="mb-3 text-dark fw-bold" style="font-size: 1.5rem;">
            <?php echo number_format($product['price'], 0, ',', '.'); ?>$
          </div>
          <!-- Danh sách cấu hình sản phẩm -->
          <ul class="mb-3">
            <?php foreach ($configs as $c): ?>
              <li><b><?php echo htmlspecialchars($c['variation']); ?>:</b> <?php echo htmlspecialchars($c['value']); ?></li>
            <?php endforeach; ?>
          </ul>
          <div class="mb-3">
            <label for="quantity">Quantity:</label>
            <input type="number" id="quantity" value="1" min="1" class="form-control d-inline-block" style="width:100px;">
          </div>
          <?php if ($product['qty_in_stock'] > 0): ?>
            <!-- Form thêm vào giỏ hàng -->
            <form id="addToCartForm" action="module/cart/cart.php" method="POST" class="d-inline">
              <input type="hidden" name="product-id" value="<?php echo $product['id']; ?>">
              <input type="hidden" name="product-name" value="<?php echo htmlspecialchars($product['name']); ?>">
              <input type="hidden" name="product-price" value="<?php echo $product['price']; ?>">
              <input type="hidden" name="product-img" value="<?php echo htmlspecialchars($product['product_image']); ?>">
              <input type="hidden" name="quantity" id="hiddenQuantity" value="1">
              <button type="submit" name="add-to-cart" class="btn btn-dark btn-lg fw-bold">Add To Cart</button>
            </form>
          <?php else: ?>
            <button id="contactBtn" class="btn btn-outline-secondary btn-lg fw-bold">
              Contact us
            </button>
          <?php endif; ?>
        </div>
      </div>
      <div class="row mt-4">
        <div class="col-12">
          <h5 class="fw-bold border-bottom pb-2 mb-3">Description</h5>
          <div class="bg-light p-3 rounded">
            <?php echo nl2br(htmlspecialchars($product['description'])); ?>
          </div>
        </div>
      </div>
      <div class="row mt-4">
        <div class="col-12">
          <h5 class="fw-bold border-bottom pb-2 mb-3">Product Rating</h5>
          <form id="ratingForm" class="bg-light p-3 rounded mb-3">
            <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
            <div class="mb-2">
              <label class="form-label fw-semibold">Your rating:</label>
              <div id="starRating" class="mb-2" style="font-size: 2rem; color: #ffc107; cursor: pointer;">
                <span data-value="1" class="star">&#9734;</span>
                <span data-value="2" class="star">&#9734;</span>
                <span data-value="3" class="star">&#9734;</span>
                <span data-value="4" class="star">&#9734;</span>
                <span data-value="5" class="star">&#9734;</span>
              </div>
              <input type="hidden" name="rating" id="ratingValue" value="0">
            </div>
            <div class="mb-2">
              <label for="comment" class="form-label fw-semibold">Your comment:</label>
              <textarea class="form-control" id="comment" name="comment" rows="2" maxlength="255" required></textarea>
            </div>
            <button type="submit" class="btn btn-dark rounded-4 mt-2">Submit Rating</button>
          </form>
          <div id="ratingMessage"></div>
          <!-- Danh sách đánh giá -->
          <div id="ratingList" class="mt-3">
            <?php if (count($reviews) === 0): ?>
              <div class="text-muted fs-5">No reviews yet.</div>
            <?php else: ?>
              <?php foreach ($reviews as $review): ?>
                <div class="border rounded p-2 mb-2 bg-white mt-3">
                  <div>
                    <?php
                    for ($i = 1; $i <= 5; $i++) {
                      echo $i <= $review['rating'] ? '<span style="color:#ffc107">&#9733;</span>' : '<span style="color:#ccc">&#9733;</span>';
                    }
                    ?>
                    <span class="ms-2 small text-muted">
                      <?= htmlspecialchars($review['username'] ?? $review['reviewer_name'] ?? 'Guest') ?>,
                      <?= date('d/m/Y H:i', strtotime($review['created_at'])) ?>
                    </span>
                  </div>
                  <div class="small text-muted mt-1"><?= nl2br(htmlspecialchars($review['comment'])) ?></div>
                </div>
              <?php endforeach; ?>
            <?php endif; ?>
          </div>
        </div>
      </div>
      <div class="row mt-4">
        <!-- Related Products -->
        <div class="row mt-5">
          <div class="col-12">
            <h5 class="fw-bold border-bottom pb-2 mb-3">Related Products</h5>
            <div id="relatedProductsCarousel" class="carousel slide" data-bs-ride="carousel">
              <div class="carousel-inner">
                <?php
                // Lấy danh sách sản phẩm liên quan (cùng category_id, loại trừ chính nó)
                $related_sql = "SELECT id, name, price, product_image FROM product WHERE category_id = ? AND id != ? LIMIT 10";
                $stmt = $conn->prepare($related_sql);
                $stmt->bind_param("ii", $product['category_id'], $product_id);
                $stmt->execute();
                $related_result = $stmt->get_result();
                $products = [];
                while ($related = $related_result->fetch_assoc()) {
                  $products[] = $related;
                }

                // Chia sản phẩm thành các nhóm (mỗi nhóm 4 sản phẩm cho 1 slide)
                $chunks = array_chunk($products, 4);
                $isActive = true; // Slide đầu tiên là active

                foreach ($chunks as $chunk):
                ?>
                  <div class="carousel-item <?php echo $isActive ? 'active' : ''; ?>">
                    <div class="row">
                      <?php foreach ($chunk as $related): ?>
                        <div class="col-md-3 text-center">
                          <div class="card border-0 text-center" style="width: 100%;">
                            <a href="#" onclick="loadPage('module/product/single_product.php?id=<?php echo $related['id']; ?>', this, 'single-product', '<?php echo $related['id']; ?>'); return false;" class="text-decoration-none text-dark">
                              <img src="<?php echo htmlspecialchars($related['product_image']); ?>" class="card-img-top img-fluid" alt="<?php echo htmlspecialchars($related['name']); ?>">
                              <div class="card-body">
                                <h6 class="card-title fw-bold text-uppercase mb-2" style="font-size: 0.9rem;"><?php echo htmlspecialchars($related['name']); ?></h6>
                                <div class="text-uppercase fw-bold"><?php echo number_format($related['price'], 0, ',', '.'); ?>$</div>
                              </div>
                            </a>
                          </div>
                        </div>
                      <?php endforeach; ?>
                    </div>
                  </div>
                <?php
                  $isActive = false; // Sau slide đầu, các slide khác không active
                endforeach;
                ?>
              </div>
              <!-- Nút điều hướng carousel -->
              <button class="carousel-control-prev" type="button" data-bs-target="#relatedProductsCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
              </button>
              <button class="carousel-control-next" type="button" data-bs-target="#relatedProductsCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  <?php else: ?>
    <!-- Nếu không tìm thấy sản phẩm -->
    <div class="container mt-5">
      <div class="alert alert-danger">Product not found.</div>
    </div>
  <?php endif; ?>
  <script>
    // Đồng bộ quantity input với hidden field
    document.getElementById('quantity').addEventListener('change', function() {
      document.getElementById('hiddenQuantity').value = this.value;
    });

    // Xử lý thêm vào giỏ hàng bằng AJAX
    document.querySelector('form[id="addToCartForm"]')?.addEventListener('submit', function(e) {
      e.preventDefault(); // Ngăn submit mặc định

      const formData = new FormData(this);

      fetch('module/cart/cart.php', {
          method: 'POST',
          body: formData
        })
        .then(res => res.json())
        .then(data => {
          if (data.success) {
            // Hiển thị modal Bootstrap (copy từ product.php)
            const modal = new bootstrap.Modal(document.getElementById('addToCartSuccessModal'));
            modal.show();
            // Cập nhật số trên icon giỏ hàng nếu cần
            if (document.querySelector('.cart-icon .fw-bold')) {
              document.querySelector('.cart-icon .fw-bold').textContent = data.total;
            }
          } else {
            alert("Thêm vào giỏ hàng thất bại!");
          }
        })
        .catch(err => {
          console.error("Lỗi khi gửi form:", err);
          // alert("You are not logged, please login to add products to cart.");
          const notLoggedInModal = new bootstrap.Modal(document.getElementById('notLoggedInModal'));
          notLoggedInModal.show();
        });

    });

    // Xử lý button contact
    document.getElementById('contactBtn')?.addEventListener('click', function() {
      loadPage('module/contact/contact.php');
    });
    // Hiệu ứng chọn sao
    const stars = document.querySelectorAll('#starRating .star');
    const ratingValue = document.getElementById('ratingValue');
    stars.forEach(star => {
      star.addEventListener('mouseenter', function() {
        const val = parseInt(this.getAttribute('data-value'));
        stars.forEach((s, i) => {
          s.innerHTML = i < val ? '&#9733;' : '&#9734;';
        });
      });
      star.addEventListener('mouseleave', function() {
        const val = parseInt(ratingValue.value);
        stars.forEach((s, i) => {
          s.innerHTML = i < val ? '&#9733;' : '&#9734;';
        });
      });
      star.addEventListener('click', function() {
        const val = parseInt(this.getAttribute('data-value'));
        ratingValue.value = val;
        stars.forEach((s, i) => {
          s.innerHTML = i < val ? '&#9733;' : '&#9734;';
        });
      });
    });

    // gửi form đánh giá
    document.getElementById('ratingForm').addEventListener('submit', function(e) {
      e.preventDefault();
      const rating = ratingValue.value;
      const comment = document.getElementById('comment').value.trim();
      const product_id = <?php echo $product_id; ?>;
      if (rating == 0) {
        document.getElementById('ratingMessage').innerHTML = '<div class="alert alert-warning mt-2">Please select a star rating.</div>';
        return;
      }
      fetch('module/product/submit_review.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
          },
          body: `product_id=${product_id}&rating=${rating}&comment=${encodeURIComponent(comment)}`
        })
        .then(res => res.json())
        .then(data => {
          if (data.success) {
            const modal = new bootstrap.Modal(document.getElementById('reviewSuccessModal'));
            modal.show();
            // setTimeout(() => location.reload(), 1000); // Reload để cập nhật đánh giá mới
          } else {
            document.getElementById('ratingMessage').innerHTML = '<div class="alert alert-danger mt-2">Failed to submit rating.</div>';
          }
        });
    });
  </script>

  <!-- Modal thông báo thêm vào giỏ hàng thành công (copy từ product.php) -->
  <div class="modal fade" id="addToCartSuccessModal" tabindex="-1" aria-labelledby="addToCartSuccessModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addToCartSuccessModalLabel">Success</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Product has been added to your cart successfully!
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal thông báo chưa đăng nhập -->
  <div class="modal fade" id="notLoggedInModal" tabindex="-1" aria-labelledby="notLoggedInModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="notLoggedInModalLabel">Notification</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          You are not logged in. Please login to add products to cart.
        </div>
        <div class="modal-footer">
          <a href="login.php" class="btn btn-dark">Go to Login</a>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal thông báo đánh giá thành công -->
  <div class="modal fade" id="reviewSuccessModal" tabindex="-1" aria-labelledby="reviewSuccessModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="reviewSuccessModalLabel">Thank you!</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Your review has been submitted successfully!
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-dark" data-bs-dismiss="modal" onclick="location.reload()">OK</button>
        </div>
      </div>
    </div>
  </div>