<?php
// Include file lấy dữ liệu sản phẩm
include __DIR__ . '/get-top-products.php';
?>

<!-- Carousel -->
<div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active"
      aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
  </div>
  <div class="carousel-inner">
    <div class="carousel-item active c-items">
      <img id="slide-img1" src="./img/product-banner/zenbook14.jpg" class="d-block w-100 c-img" alt="..." />
      <div class="carousel-caption d-md-block">
        <button class="btn btn-transparent btn-outline-dark rounded-4 mx-3 my-1 my-lg-3 fw-bold"
          onclick="loadPage('module/product/product.php?category=laptop', this, 'products'); return false;">Learn more</button>
        <a class="text-dark ms-2 fw-bold" href="#"
          onclick="loadPage('module/product/product.php?category=laptop', this, 'products'); return false;">Buy now</a>
      </div>
    </div>
    <div class="carousel-item c-items">
      <img id="slide-img2" src="./img/product-banner/vivo s16.jpg" class="d-block w-100 c-img" alt="..." />
      <div class="carousel-caption d-md-block">
        <button class="btn btn-transparent btn-outline-light rounded-4 mx-3 my-1 my-lg-3 fw-bold"
          onclick="loadPage('module/product/product.php?category=camera', this, 'products'); return false;">Learn more</button>
        <a class="text-light ms-2 fw-bold" href="#"
          onclick="loadPage('module/product/product.php?category=camera', this, 'products'); return false;">Buy now</a>
      </div>
    </div>
    <div class="carousel-item c-items">
      <img id="slide-img3" src="./img/product-banner/zenbook a14.jpg" class="d-block w-100 c-img" alt="..." />
      <div class="carousel-caption d-md-block">
        <button class="btn btn-transparent btn-outline-light rounded-4 mx-3 my-1 my-lg-3 fw-bold"
          onclick="loadPage('module/product/product.php?category=accessories', this, 'products'); return false;">Learn more</button>
        <a class="text-light ms-2 fw-bold" href="#"
          onclick="loadPage('module/product/product.php?category=accessories', this, 'products'); return false;">Buy now</a>
      </div>
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>

<!-- Camera Featured Section -->
<div class="gcam-container container my-5">
  <div class="row align-items-center">
    <!-- Nội dung bên trái -->
    <div class="col-md-6 text-md-start text-center mb-4 mb-md-0">
      <h1 class="gcam-title fw-bold mb-3">
        <!-- hàm bên dưới để gọi tên sản phẩm top mới nếu cần 
         <?php echo $featuredCamera ? htmlspecialchars($featuredCamera['name']) : 'Make your home secured with Google Nest Cam'; ?> -->
        Make your home secured with Google Nest Cam
      </h1>
      <p class="gcam-content text-muted mb-4">
        Start or expand your security setup with professional security cameras
      </p>
      <p class="gcam-content mb-4 fs-2 fw-bold">
        <span style="font-size: 16px; vertical-align: top">$</span><?php echo $featuredCamera ? number_format($featuredCamera['price'], 0) : '69'; ?><span
          style="font-size: 14px; vertical-align: super">99</span>
      </p>
      <?php if ($featuredCamera): ?>
        <button class="btn btn-dark gcam-btn rounded-4 px-4 py-2"
          onclick="loadPage('module/product/single_product.php?id=<?php echo $featuredCamera['id']; ?>', this, 'single-product', '<?php echo $featuredCamera['id']; ?>'); return false;">
          Show more
        </button>
      <?php else: ?>
        <button class="btn btn-dark gcam-btn rounded-4 px-4 py-2"
          onclick="loadPage('module/product/product.php?category=camera', this, 'products'); return false;">
          Show more
        </button>
      <?php endif; ?>
    </div>

    <!-- Hình ảnh bên phải -->
    <div class="col-md-6 text-center">
      <div id="carouselExampleIndicators" class="carousel slide">
        <div class="carousel-indicators">
          <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"
            aria-current="true" aria-label="Slide 1"></button>
          <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
            aria-label="Slide 2"></button>
          <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
            aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img src="./img/product-banner/google-camera.png" class="d-block w-100" alt="camera" />
          </div>
          <div class="carousel-item">
            <img src="./img/product-banner/gcam-front.png" class="d-block w-100" alt="camera-front" />
          </div>
          <div class="carousel-item">
            <img src="./img/product-banner/gcam-side.png" class="d-block w-100" alt="camera-side" />
          </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
          data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
          data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
      </div>
    </div>
  </div>
</div>
<hr style="width: 85%; margin: auto" />

<!-- ROG Featured Section -->
<div class="laptop-container container my-5">
  <div class="row align-items-center">
    <!-- Hình ảnh bên phải -->
    <div class="col-md-6 text-center">
      <div id="carouselLaptopIndicators" class="carousel slide">
        <div class="carousel-indicators">
          <button type="button" data-bs-target="#carouselLaptopIndicators" data-bs-slide-to="0" class="active"
            aria-current="true" aria-label="Slide 1"></button>
          <button type="button" data-bs-target="#carouselLaptopIndicators" data-bs-slide-to="1"
            aria-label="Slide 2"></button>
          <button type="button" data-bs-target="#carouselLaptopIndicators" data-bs-slide-to="2"
            aria-label="Slide 3"></button>
          <button type="button" data-bs-target="#carouselLaptopIndicators" data-bs-slide-to="3"
            aria-label="Slide 4"></button>
          <button type="button" data-bs-target="#carouselLaptopIndicators" data-bs-slide-to="4"
            aria-label="Slide 5"></button>
        </div>
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img src="./img/product-banner/rog/89555_laptop_asus_gaming_rog_strix_Front.png" class="d-block w-100"
              alt="camera" />
          </div>
          <div class="carousel-item">
            <img src="./img/product-banner/rog/89555_laptop_asus_gaming_rog_strix__A.png" class="d-block w-100"
              alt="camera-front" />
          </div>
          <div class="carousel-item">
            <img src="./img/product-banner/rog/89555_laptop_asus_gaming_rog_strix__B.png" class="d-block w-100"
              alt="camera-side" />
          </div>
          <div class="carousel-item">
            <img src="./img/product-banner/rog/89555_laptop_asus_gaming_rog_strix__C.png" class="d-block w-100"
              alt="camera-side" />
          </div>
          <div class="carousel-item">
            <img src="./img/product-banner/rog/89555_laptop_asus_gaming_rog_strix__D.png" class="d-block w-100"
              alt="camera-side" />
          </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselLaptopIndicators"
          data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselLaptopIndicators"
          data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
      </div>
    </div>
    <!-- Nội dung bên trái -->
    <div class="col-md-6 text-md-start text-center mb-4 mb-md-0">
      <h1 class="laptop-title fw-bold mb-3">
        <!-- <?php echo $featuredLaptop ? htmlspecialchars($featuredLaptop['name']) : 'Extreme Gaming performance with ROG Strix G16'; ?> -->
        Extreme Gaming performance with ROG Strix G16
      </h1>
      <p class="laptop-content text-muted mb-4">
        Reach new heights of Windows 11 Pro gaming with high-performance laptops
      </p>
      <p class="laptop-content mb-4 fs-2 fw-bold">
        <span style="font-size: 16px; vertical-align: top">$</span><?php echo $featuredLaptop ? number_format($featuredLaptop['price'], 0) : '1,899'; ?><span
          style="font-size: 14px; vertical-align: super">99</span>
      </p>
      <?php if ($featuredLaptop): ?>
        <button class="btn btn-dark gcam-btn rounded-4 px-4 py-2"
          onclick="loadPage('module/product/single_product.php?id=<?php echo $featuredLaptop['id']; ?>', this, 'single-product', '<?php echo $featuredLaptop['id']; ?>'); return false;">
          Show more
        </button>
      <?php else: ?>
        <button class="btn btn-dark gcam-btn rounded-4 px-4 py-2"
          onclick="loadPage('module/product/product.php?category=laptop', this, 'products'); return false;">
          Show more
        </button>
      <?php endif; ?>
    </div>
  </div>
</div>

<!-- Categories -->
<div class="categories-part-container container mb-5">
  <h1 class="text-center fw-semibold">Categories</h1>
  <hr />
  <div class="row text-center my-lg-4">
    <div class="col-md-4 col-sm-6 my-2">
      <div class="card p-4 categories-card" style="cursor: pointer;"
        onclick="loadPage('module/product/product.php?category=laptop', this, 'products'); return false;">
        <img src="./img/categories-pic-laptop.png" class="mx-auto mb-3" style="height:120px" alt="icon">
        <h4 class="card-title fw-bold">Laptop</h4>
        <p class="card-text">Fast, reliable laptops for work, study, or gaming.</p>
      </div>
    </div>

    <div class="col-md-4 col-sm-6 my-2">
      <div class="card p-4 categories-card" style="cursor: pointer;"
        onclick="loadPage('module/product/product.php?category=camera', this, 'products'); return false;">
        <img src="./img/categories-pic-camera.png" class="mx-auto mb-3" style="height: 120px;" alt="icon">
        <h4 class="card-title fw-bold">Security Camera</h4>
        <p class="card-text">Easy-to-use cameras for smart home security.</p>
      </div>
    </div>

    <div class="col-md-4 col-sm-6 my-2">
      <div class="card p-4 categories-card" style="cursor: pointer;"
        onclick="loadPage('module/product/product.php?category=accessories', this, 'products'); return false;">
        <img src="./img/categories-pic-others.png" class="mx-auto mb-3" style="height: 120px;" alt="icon">
        <h4 class="card-title fw-bold">Computer Accessories</h4>
        <p class="card-text">Useful gadgets to improve your PC setup.</p>
      </div>
    </div>
  </div>
</div>

<!-- Top Product -->
<div class="top-product-container container">
  <h1 class="text-center fw-semibold">Top Products</h1>
  <hr />

  <!-- Laptop -->
  <div class="row align-content-center my-lg-4">
    <?php while ($laptop = $laptops->fetch_assoc()): ?>
      <div class="col col-sm-6 col-md-6 col-lg-4 col-xl-3 mb-4 d-flex justify-content-center">
        <div class="card" style="width: 18rem">
          <a href="#" onclick="loadPage('module/product/single_product.php?id=<?php echo $laptop['id']; ?>', this, 'single-product', '<?php echo $laptop['id']; ?>'); return false;" style="text-decoration: none; color: inherit;">
            <img src="<?php echo htmlspecialchars($laptop['product_image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($laptop['name']); ?>" />
          </a>
          <div class="card-body">
            <h5 class="card-title"><?php echo htmlspecialchars($laptop['name']); ?></h5>
            <p class="card-text">
              Price: $<?php echo number_format($laptop['price'], 2); ?>
            </p>
          </div>
          <div class="row justify-content-center text-center">
            <div class="col-auto">
              <a href="#" class="btn btn-dark rounded-4 mb-3"
                onclick="loadPage('module/product/single_product.php?id=<?php echo $laptop['id']; ?>', this, 'single-product', '<?php echo $laptop['id']; ?>'); return false;">More details</a>
            </div>
            <div class="col-auto">
              <?php if ($laptop['qty_in_stock'] > 0): ?>
                <form class="addToCartForm" action="module/cart/cart.php" method="POST" style="display: inline;">
                  <input type="hidden" name="product-id" value="<?php echo $laptop['id']; ?>">
                  <input type="hidden" name="product-name" value="<?php echo htmlspecialchars($laptop['name']); ?>">
                  <input type="hidden" name="product-price" value="<?php echo $laptop['price']; ?>">
                  <input type="hidden" name="product-img" value="<?php echo htmlspecialchars($laptop['product_image']); ?>">
                  <input type="hidden" name="quantity" value="1">
                  <button type="submit" name="add-to-cart" class="btn rounded-4 mb-3">
                    <i class="fa-solid fa-cart-plus fs-4"></i>
                  </button>
                </form>
              <?php else: ?>
                <button onclick="loadPage('module/contact/contact.php'); return false;" class="btn rounded-4 mb-3">
                  <i class="fa-solid fa-phone fs-4"></i>
                </button>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    <?php endwhile; ?>
  </div>

  <!-- Security Camera -->
  <div class="row align-content-center my-lg-4">
    <?php while ($camera = $cameras->fetch_assoc()): ?>
      <div class="col col-sm-6 col-md-6 col-lg-4 col-xl-3 mb-4 d-flex justify-content-center">
        <div class="card" style="width: 18rem">
          <a href="#" onclick="loadPage('module/product/single_product.php?id=<?php echo $camera['id']; ?>', this, 'single-product', '<?php echo $camera['id']; ?>'); return false;" style="text-decoration: none; color: inherit;">
            <img src="<?php echo htmlspecialchars($camera['product_image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($camera['name']); ?>" />
          </a>
          <div class="card-body">
            <h5 class="card-title"><?php echo htmlspecialchars($camera['name']); ?></h5>
            <p class="card-text">
              Price: $<?php echo number_format($camera['price'], 2); ?>
            </p>
          </div>
          <div class="row justify-content-center text-center">
            <div class="col-auto">
              <a href="#" class="btn btn-dark rounded-4 mb-3"
                onclick="loadPage('module/product/single_product.php?id=<?php echo $camera['id']; ?>', this, 'single-product', '<?php echo $camera['id']; ?>'); return false;">More details</a>
            </div>
            <div class="col-auto">
              <?php if ($camera['qty_in_stock'] > 0): ?>
                <form class="addToCartForm" action="module/cart/cart.php" method="POST" style="display: inline;">
                  <input type="hidden" name="product-id" value="<?php echo $camera['id']; ?>">
                  <input type="hidden" name="product-name" value="<?php echo htmlspecialchars($camera['name']); ?>">
                  <input type="hidden" name="product-price" value="<?php echo $camera['price']; ?>">
                  <input type="hidden" name="product-img" value="<?php echo htmlspecialchars($camera['product_image']); ?>">
                  <input type="hidden" name="quantity" value="1">
                  <button type="submit" name="add-to-cart" class="btn rounded-4 mb-3">
                    <i class="fa-solid fa-cart-plus fs-4"></i>
                  </button>
                </form>
              <?php else: ?>
                <button onclick="loadPage('module/contact/contact.php'); return false;" class="btn rounded-4 mb-3">
                  <i class="fa-solid fa-phone fs-4"></i>
                </button>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    <?php endwhile; ?>
  </div>

  <div class="row align-content-center my-lg-4">
    <div class="col-12 d-flex justify-content-center">
      <button class="btn btn-outline-dark rounded-4 mb-3 w-25"
        onclick="loadPage('module/product/product.php',this,'products');return false;">View more</button>
    </div>
  </div>
</div>

<!-- about us -->
<hr style="width: 85%; margin: auto" />
<div id="#About" class="about-us container container my-5">
  <div class="about-us-container border p-4 rounded-4">
    <div class="row">
      <div class="col col-6">
        <h1>About Us</h1>
        <p>Welcome to <span style="font-weight:bold ;">Technologia</span> – your trusted destination for the latest and most reliable tech products!</p>
        <p>We specialize in providing high-quality technology items such as laptops, cameras, electronic accessories, smart devices, and more. With our motto <span style="font-weight: bold;">"Quality – Trust – Dedicated Support," Technologia</span> is committed to delivering a safe, convenient, and professional shopping experience.</p>
        <button id="about-us-btn" class="btn btn-dark rounded-4"
          onclick="loadPage('module/about-us/about-us.php', this, 'about'); return false;">More about us</button>
      </div>
    </div>
  </div>
</div>

<style>
  #about-us-btn {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }

  #about-us-btn:hover {
    transform: scale(1.03);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0);
  }

  .categories-card:hover {
    transform: scale(1.02);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
  }
</style>

<script>
  function updateCarouselImages() {
    const aspectRatio = window.innerHeight / window.innerWidth;

    const slide1 = document.getElementById("slide-img1");
    const slide2 = document.getElementById("slide-img2");
    const slide3 = document.getElementById("slide-img3");

    if (slide1 && slide2 && slide3) {
      if (aspectRatio > 0.9) {
        slide1.src = "./img/product-banner/zenbook14-smalll.jpg";
        slide2.src = "./img/product-banner/vivo s16-small.jpg";
        slide3.src = "./img/product-banner/zenbook a14-small.jpg";
      } else {
        slide1.src = "./img/product-banner/zenbook14.jpg";
        slide2.src = "./img/product-banner/vivo s16.jpg";
        slide3.src = "./img/product-banner/zenbook a14.jpg";
      }
    }
  }

  // Hàm xử lý thêm vào giỏ hàng cho main content
  function attachMainContentCartEventListeners() {
    document.querySelectorAll('form.addToCartForm').forEach(function(form) {
      form.removeEventListener('submit', handleMainContentCartSubmit);
      form.addEventListener('submit', handleMainContentCartSubmit);
    });
  }

  function handleMainContentCartSubmit(e) {
    e.preventDefault();

    const formData = new FormData(e.target);

    fetch('module/cart/cart.php', {
        method: 'POST',
        body: formData
      })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          // Hiển thị modal thay vì alert
          const modalElement = document.getElementById('addToCartSuccessModal');
          const modal = new bootstrap.Modal(modalElement, {
            backdrop: true,
            keyboard: true
          });
          modal.show();

          // Thêm event listener để dispose modal khi đóng
          modalElement.addEventListener('hidden.bs.modal', function() {
            modal.dispose();
          }, {
            once: true
          });

          // Cập nhật số trên icon giỏ hàng nếu có
          const cartIcon = document.querySelector('.cart-icon .fw-bold');
          if (cartIcon) {
            cartIcon.textContent = data.total;
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
  }

  window.addEventListener("load", function() {
    updateCarouselImages();
    attachMainContentCartEventListeners();
  });

  window.addEventListener("resize", updateCarouselImages);

  // Gán sự kiện khi trang được load lại qua AJAX
  document.addEventListener('DOMContentLoaded', function() {
    attachMainContentCartEventListeners();
  });
</script>
<!-- các modal thông báo -->
<!-- Modal thông báo thêm vào giỏ hàng thành công -->
<div class="modal fade" id="addToCartSuccessModal" tabindex="-1" aria-labelledby="addToCartSuccessModalLabel"
  aria-hidden="true">
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
        <a href="login.php" class="btn btn-dark">Login Now</a>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>