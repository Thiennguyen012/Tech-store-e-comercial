<?php
// filepath: d:\xampp\htdocs\code web\module\product\single_product.php
require_once __DIR__ . '/../../db/connect.php';

// Lấy id sản phẩm từ URL
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Lấy thông tin sản phẩm
$sql = "SELECT * FROM product WHERE id = $product_id";
$result = $conn->query($sql);
$product = $result->fetch_assoc();

// Lấy các thuộc tính cấu hình (nếu có)
$configs = [];
$config_sql = "SELECT v.name as variation, vo.value 
               FROM variation_options vo 
               JOIN variation v ON vo.variation_id = v.id 
               WHERE vo.product_id = $product_id";
$config_result = $conn->query($config_sql);
while($row = $config_result->fetch_assoc()) {
    $configs[] = $row;
}
?>
<?php if ($product): ?>
<div class="container mt-5 mb-5">
  <div class="p-4 rounded shadow" style="background: #fff;">
    <!-- Breadcrumb -->
    <style>
      .breadcrumb a {
        color:rgb(126, 130, 134) !important;      /* Bootstrap default link color */
        text-decoration: none !important;
        font-family: inherit !important;
        font-size: inherit !important;
      }
      .breadcrumb a:hover {
        text-decoration: underline !important;
      }
    </style>
    <nav style="--bs-breadcrumb-divider: '»';" aria-label="breadcrumb" class="mb-3">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="#" onclick="loadPage('module/main-content/main-content.php'); return false;">Home</a>
        </li>
        <li class="breadcrumb-item">
          <a href="#" onclick="loadPage('module/product/product.php'); return false;">Laptops</a>
        </li>
        <li class="breadcrumb-item">
          <a href="#" onclick="loadPage('module/product/product.php'); return false;">
            <?php
              $brand = '';
              foreach($configs as $c) {
                if (strtolower($c['variation']) == 'brand' || strtolower($c['variation']) == 'thương hiệu') {
                  $brand = $c['value'];
                  break;
                }
              }
              echo htmlspecialchars($brand);
            ?>
          </a>
        </li>
        <li class="breadcrumb-item active" aria-current="page"><?php echo htmlspecialchars($product['name']); ?></li>
      </ol>
    </nav>
    <!-- End Breadcrumb -->
    <div class="row">
      <div class="col-md-5 text-center">
        <img src="<?php echo htmlspecialchars($product['product_image']); ?>" class="img-fluid" alt="<?php echo htmlspecialchars($product['name']); ?>">
      </div>
      <div class="col-md-7">
        <h2 class="fw-bold"><?php echo htmlspecialchars($product['name']); ?></h2>
        <div class="mb-3 text-dark fw-bold" style="font-size: 1.5rem;">
          <?php echo number_format($product['price'], 0, ',', '.'); ?>$
        </div>
        <ul class="mb-3">
          <?php foreach($configs as $c): ?>
            <li><b><?php echo htmlspecialchars($c['variation']); ?>:</b> <?php echo htmlspecialchars($c['value']); ?></li>
          <?php endforeach; ?>
        </ul>
        <div class="mb-3">
          <label for="quantity">Quantity:</label>
          <input type="number" id="quantity" value="1" min="1" class="form-control d-inline-block" style="width:100px;">
        </div>
        <button class="btn btn-dark btn-lg fw-bold">Add To Cart</button>
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
    <!-- Related Products -->
    <div class="row mt-5">
      <div class="col-12">
        <h5 class="fw-bold border-bottom pb-2 mb-3">Sản phẩm liên quan</h5>
        <div id="relatedProductsCarousel" class="carousel slide" data-bs-ride="carousel">
          <div class="carousel-inner">
            <?php
            // Lấy danh sách sản phẩm liên quan (cùng category_id)
            $related_sql = "SELECT id, name, price, product_image FROM product WHERE category_id = " . intval($product['category_id']) . " AND id != $product_id LIMIT 10";
            $related_result = $conn->query($related_sql);
            $products = [];
            while ($related = $related_result->fetch_assoc()) {
              $products[] = $related;
            }

            // Chia sản phẩm thành các nhóm (mỗi nhóm 4 sản phẩm)
            $chunks = array_chunk($products, 4);
            $isActive = true; // Đặt nhóm đầu tiên là active

            foreach ($chunks as $chunk):
            ?>
            <div class="carousel-item <?php echo $isActive ? 'active' : ''; ?>">
              <div class="row">
                <?php foreach ($chunk as $related): ?>
                <div class="col-md-3 text-center">
                  <div class="card border-0 text-center" style="width: 100%;">
                    <a href="#" onclick="loadPage('module/product/single_product.php?id=<?php echo $related['id']; ?>'); return false;" class="text-decoration-none text-dark">
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
            $isActive = false; // Sau nhóm đầu tiên, các nhóm khác không active
            endforeach;
            ?>
          </div>
          <!-- Nút điều hướng trái phải -->
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
<div class="container mt-5"><div class="alert alert-danger">Product not found.</div></div>
<?php endif; ?>