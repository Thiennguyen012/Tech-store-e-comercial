<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!-- Link awesome font -->
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
    integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
    crossorigin="anonymous"
    referrerpolicy="no-referrer" />
  <!-- Link bootstrap icon -->
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" />
  <!-- Link google font -->
  <link
    href="https://fonts.googleapis.com/css?family=Roboto&display=swap"
    rel="stylesheet" />
  <!-- bootstrap css -->
  <link rel="stylesheet" href="asset/bootstrap/css/bootstrap.min.css" />

  <link rel="stylesheet" href="asset/style1.css" />
  <title>Technologia</title>
</head>

<body>
  <?php
  session_start();
  require 'db/connect.php';
  // navbar
  include 'components/navbar.php'
  ?>

  <!-- Content -->
  <div id="main-content">
    <?php
    $act = $_GET['act'] ?? '';
    switch ($act) {
      // mục products
      case 'products':
        include 'module/product/product.php';
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
      // 
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
      case 'warrantly':
        include 'module/services/warrantly/warrantly.php';
        break;
      // 
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
      // Default sẽ nhảy về main-content 
      default:
        include 'module/main-content/main-content.php';
    }
    ?>
  </div>
  <!-- back to top -->
  <a href="#" class="arrow" id="scrollToTop">
    <i><img src="img/up-arrow.png" alt="" width="50px"></i>
  </a>
  <!-- Footer -->
  <footer class="bg-dark text-white py-4">
    <div class="container px-4">
      <div class="row">
        <div class="col-6 col-lg-4">
          <h4 class="pt-2">About Us</h4>
          <ul class="list-unstyled">
            <li>
              <a href="#" class="text-decoration-none text-white">Our Team</a>
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
              <a href="#" class="text-decoration-none text-white">Laptop</a>
            </li>
            <li>
              <a href="#" class="text-decoration-none text-white">Security Camera</a>
            </li>
            <li>
              <a href="#" class="text-decoration-none text-white">Others</a>
            </li>
          </ul>
        </div>
        <div class="col">
          <h4 class="pt-2">More</h4>
          <ul class="list-unstyled">
            <li>
              <a href="#" class="text-decoration-none text-white">Tracking</a>
            </li>
            <li>
              <a href="#" class="text-decoration-none text-white">Contribute Us</a>
            </li>
          </ul>
        </div>
        <div class="col-6 col-lg-3">
          <h4 class="pt-2">Social Media</h4>
          <div>
            <a href="#"><i
                class="bi bi-google me-3 text-decoration-none text-white fs-5"></i></a>
            <a href="#"><i
                class="bi bi-facebook me-3 text-decoration-none text-white fs-5"></i></a>
            <a href="#"><i
                class="bi bi-instagram me-3 text-decoration-none text-white fs-5"></i></a>
            <a href="#"><i
                class="bi bi-twitter-x me-3 text-decoration-none text-white fs-5"></i></a>
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
  <script src="./asset/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- reload page -->
  <script src="./asset/main-script1.js"></script>

</body>

</html>