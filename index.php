<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!-- Link awesome font -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
    integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- Link bootstrap icon -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" />
  <!-- Link google font -->
  <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet" />
  <!-- bootstrap css -->
  <link rel="stylesheet" href="asset/bootstrap/css/bootstrap.min.css" />

  <link rel="stylesheet" href="asset/style1.css" />
  <link rel="icon" href="asset/web-favicon/favicon.ico" type="image/x-icon">
  <title>Technologia</title>
</head>

<body>
  <?php
  session_start();
  if (!isset($_SESSION['username'])) {
    // Lưu URL hiện tại vào session
    $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
  }
  require 'db/connect.php';
  // navbar
  include 'components/navbar.php'
  ?>

  <!-- Content -->
  <main id="main-content" class="flex-fill">
    <?php
    $act = $_GET['act'] ?? '';
    switch ($act) {
      // mục products
      case 'products':
        include 'module/product/product.php';
        break;
      // Thêm case cho single product
      case 'single-product':
        $productId = $_GET['id'] ?? '';
        if ($productId) {
          $_GET['id'] = $productId; // Đảm bảo id được truyền đúng
          include 'module/product/single_product.php';
        } else {
          include 'module/product/product.php';
        }
        break;
      // vũ ịt làm chỗ products thêm file php nào muốn load thì thêm 1 case mới vào đây
      case 'laptop':
        include 'module/product/product.php';
        break;
      case 'camera':
        include 'module/product/product.php';
        break;
      case 'accessories':
        include 'module/product/product.php';
        break;
      case 'about':
        include 'module/about-us/about-us.php';
        break;
      // Mục services
      case 'services':
        include 'module/services/services.php';
        break;
      case 'laptopcleaning':
        include 'module/services/laptop-cleaning/laptop-cleaning.php';
        break;
      case 'installcam':
        include 'module/services/install-cam/install-cam.php';
        break;
      case 'repair':
        include 'module/services/repair/repair.php';
        break;
      case 'warranty':
        include 'module/services/warranty/warranty.php';
        break;
      case 'book-services':
        include 'module/services/book-services.php';
        break;
      case 'book-result':
        include 'module/services/book-result.php';
        break;
      //Mục contact
      case 'contact':
        include 'module/contact/contact.php';
        break;
      // Mục cart
      case 'cart':
        include 'module/cart/cart.php';
        break;
      // Mục User profile
      case 'profile':
        include 'module/user-profile/user-profile.php';
        break;
      // Mục your Order
      case 'order':
        include 'module/user-order/user-order.php';
        break;
      case 'notification':
        include 'module/user-profile/notification.php';
        break;
      case 'addresses':
        include 'module/user-profile/addresses.php';
        break;
      case 'checkout':
        include 'module/checkout/checkout.php';
        break;
      case 'checkout-result':
        include 'module/checkout/checkout-result.php';
        break;
      case 'donate':
        include 'module/donate/donate.php';
        break;
      case 'home':
        include 'module/main-content/main-content.php';
        break;
      // Default sẽ nhảy về main-content 
      default:
        include 'module/main-content/main-content.php';
    }
    ?>
  </main>
  <!-- back to top -->
  <a href="#" class="arrow" id="scrollToTop"
    style="display: none; position: fixed; bottom: 20px; right: 20px; z-index: 999;">
    <img src="img/up-arrow.png" alt="" width="50px">
  </a>

  <!-- sticky cart/social contact -->
  <div class="cart-social-fixed">
    <!-- Cart -->
    <div class="cart-icon bg-warning text-white d-flex flex-column align-items-center justify-content-center rounded-3">
      <span id="cart-count" class="fw-bold">
        <?php
        $totalItems = 0;
        if (isset($_SESSION['cart'])) {
          foreach ($_SESSION['cart'] as $item) {
            $totalItems += $item['quantity'];
          }
        }
        echo $totalItems;
        ?>
      </span>

      <!-- check xem đã đăng nhập hay chưa -->
      <!-- chưa thì đăng nhập -->
      <?php if (isset($_SESSION['username'])): ?>
        <a href="#" style="text-decoration: none; color:white;"
          onclick="loadPage('module/cart/cart.php', this, 'cart'); return false;">
          <i class="bi bi-bag-fill fs-4"></i>
        </a>
        <!-- nếu đã login thì mở giỏ hàng của user -->
      <?php else: ?>
        <a href="Login.php" style="text-decoration: none; color:white;">
          <i class="bi bi-bag-fill fs-4"></i>
        </a>
      <?php endif; ?>
    </div>

    <!-- Socials -->
    <div class="social-icons bg-dark d-flex flex-column text-white p-2 gap-2 rounded-3">
      <a href="https://www.facebook.com/" target="_blank"><i
          class="bi bi-facebook text-decoration-none text-white fs-5"></i></a>
      <a href="https://www.instagram.com/" target="_blank"><i
          class="bi bi-instagram text-decoration-none text-white fs-5"></i></a>
      <a href="https://x.com/" target="_blank"><i class="bi bi-twitter-x text-decoration-none text-white fs-5"></i></a>
      <a href="https://www.youtube.com/" target="_blank"><i
          class="bi bi-youtube text-decoration-none text-white fs-4"></i></a>
    </div>
  </div>
  <!-- Footer -->
  <footer class="bg-dark text-white py-4">
    <div class="container px-4">
      <div class="row">
        <div class="col-6 col-lg-4">
          <h4 class="pt-2">About Us</h4>
          <ul class="list-unstyled">
            <li>
              <a href="#" class="text-decoration-none text-white"
                onclick="loadPage('module/about-us/about-us.php',this,'about'); return false;">Our Team</a>
            </li>
            <li>
              <p>Address: 141 Chien Thang, Tan Trieu, Thanh Tri, Ha Noi</p>
            </li>
            <li>
              <p>0945411232</p>
            </li>
          </ul>
        </div>
        <div class="col">
          <h4 class="pt-2">Categories</h4>
          <ul class="list-unstyled">
            <li>
              <a href="#" class="text-decoration-none text-white"
                onclick="loadPage('module/product/product.php?category=laptop', this, 'products'); return false;">Laptop</a>
            </li>
            <li>
              <a href="#" class="text-decoration-none text-white"
                onclick="loadPage('module/product/product.php?category=camera', this, 'products'); return false;">Security Camera</a>
            </li>
            <li>
              <a href="#" class="text-decoration-none text-white"
                onclick="loadPage('module/product/product.php?category=accessories', this, 'products'); return false;">Computer Accessories</a>
            </li>
          </ul>
        </div>
        <div class="col">
          <h4 class="pt-2">More</h4>
          <ul class="list-unstyled">
            <li>
              <a href="#" class="text-decoration-none text-white"
                onclick="location.href='index.php?act=order'; return false;">Tracking</a>
            </li>
            <li>
              <a href="#" class="text-decoration-none text-white"
                onclick="loadPage('module/contact/contact.php', this, 'contact'); return false;">Contribute Us</a>
            </li>
            <li>
              <a href="#" class="text-decoration-none text-white"
                onclick="loadPage('module/donate/donate.php', this, 'donate'); return false;">Donation</a>
            </li>
          </ul>
        </div>
        <div class="col-6 col-lg-3">
          <h4 class="pt-2">Social Media</h4>
          <div>
            <a href="https://www.facebook.com/" target="_blank"><i
                class="bi bi-facebook me-3 text-decoration-none text-white fs-5"></i></a>
            <a href="https://www.instagram.com/" target="_blank"><i
                class="bi bi-instagram me-3 text-decoration-none text-white fs-5"></i></a>
            <a href="https://x.com/" target="_blank"><i
                class="bi bi-twitter-x me-3 text-decoration-none text-white fs-5"></i></a>
            <a href="https://www.youtube.com/" target="_blank"><i
                class="bi bi-youtube me-3 text-decoration-none text-white fs-4"></i></a>
          </div>
        </div>
      </div>
      <hr />
      <div class="d-flex justify-content-between">
        <small>2025 © Technologia. All Rights Reserved.</small>
        <div>
          <a href="#" class="text-decoration-none text-white me-4"><small>Terms of Use</small></a>
          <a href="#" class="text-decoration-none text-white"><small>Privacy Policy</small></a>
        </div>
      </div>
    </div>
  </footer>
  <!-- Bootstrap JS -->
  <script src="asset/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- reload page -->
  <script src="asset/main-script1.js"></script>
</body>

</html>