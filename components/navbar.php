<?php

// Lấy user hiện tại
$username = $_SESSION['username'] ?? '';
$unread_count = 0;

if ($username) {
  $stmt = $conn->prepare("SELECT COUNT(*) FROM notifications n
                            JOIN site_user u ON n.user_id = u.id
                            WHERE u.username = ? AND n.is_read = 0");
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $stmt->bind_result($unread_count);
  $stmt->fetch();
  $stmt->close();
}
?>
<!-- Navbar -->
<nav class="navbar navbar-expand-xl navbar-light bg-light sticky-top shadow" style="height: 65px">
  <div class="container">
    <!-- Logo -->
    <a class="navbar-brand fs-4" href="#"
      onclick="loadPage('module/main-content/main-content.php',this,'home'); return false;">Technologia™</a>
    <!-- Toggle button -->
    <button class="navbar-toggler shaddow-none border-0" type="button" data-bs-toggle="offcanvas"
      data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <!-- sidebar -->
    <div class="sidebar offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar"
      aria-labelledby="offcanvasNavbarLabel">
      <!-- sidebar header -->
      <div class="offcanvas-header border-dark border-bottom">
        <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Menu</h5>
        <button type="button" class="btn-close btn-close-dark shadow-none border-0" data-bs-dismiss="offcanvas"
          aria-label="Close"></button>
      </div>
      <!-- sidebar body -->
      <div class="offcanvas-body flex-lg-row d-flex flex-column">
        <ul class="navbar-nav justify-content-center flex-grow-1 pe-3">
          <li class="nav-item mx-2">
            <a class="nav-link" href="#"
              onclick="loadPage('module/main-content/main-content.php',this,'home'); return false;">Home</a>

          </li>

          <li class="nav-item dropdown mx-2">
            <!-- onclick="location.href='?act=products'" -->
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"
              onclick="loadPage('module/product/product.php',this,'products'); return false;">
              Products
            </a>
            <ul class="dropmenu dropdown-menu mx-2" ;>
              <li><a class="dropdown-item" href="#"
                  onclick="loadPage('module/product/product.php?category=laptop', this, 'laptop'); return false;">Laptop</a>
              </li>
              <li><a class="dropdown-item" href="#"
                  onclick="loadPage('module/product/product.php?category=camera', this, 'camera'); return false;">Camera</a>
              </li>
              <li><a class="dropdown-item" href="#"
                  onclick="loadPage('module/product/product.php?category=accessories', this, 'accessories'); return false;">Accessories</a>
              </li>
            </ul>
          </li>
          <li class="nav-item dropdown mx-2">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"
              onclick="loadPage('module/services/services.php', this, 'services')">
              Services
            </a>
            <ul class="dropmenu dropdown-menu mx-2" ;>
              <li><a class="dropdown-item" href="#"
                  onclick="loadPage('module/services/laptop-cleaning/laptop-cleaning.php',this, 'laptopcleaning'); return false;">Laptop
                  cleaning</a></li>
              <li>
                <a class="dropdown-item" href="#"
                  onclick="loadPage('module/services/install-cam/install-cam.php',this, 'installcam'); return false;">Security
                  Camera installation</a>
              </li>
              <li><a class="dropdown-item" href="#"
                  onclick="loadPage('module/services/repair/repair.php',this, 'repair'); return false;">Repair</a></li>
              <li>
                <a class="dropdown-item" href="#"
                  onclick="loadPage('module/services/warranty/warranty.php',this, 'warranty'); return false;">Warranty</a>
              </li>
            </ul>
          </li>
          <li class="nav-item mx-2">
            <a class="nav-link" href="#"
              onclick="loadPage('module/about-us/about-us.php', this, 'about'); return false;">About</a>
          </li>
          <li class="nav-item mx-2">
            <a class="nav-link" href="#Contact"
              onclick="loadPage('module/contact/contact.php',this, 'contact'); return false;">Contact</a>
          </li>
          <!-- search -->
          <li class="nav-item dropdown mx-2">
            <a class="nav-link px-2 search-container">
              <i class="fas fa-search rounded-3" onclick="toggleSearch(); return false;">
              </i>
            </a>
          </li>

        </ul>
        <!-- Check đã đăng nhập hay chưa -->
        <div class="d-flex justify-content-center align-content-center gap-3">
          <?php if (!isset($_SESSION['username'])): ?>
            <!-- Chưa đăng nhập -->
            <button type="button" class="btn border-0 position-relative mt-1" onclick="location.href='login.php'">
              <i class="fa-solid fa-cart-shopping fs-5"></i>
            </button>
            <a href="./Login.php" class="btn btn-dark rounded-5">Sign in</a>
            <a href="./Registration.php" class="btn btn-dark rounded-5">Sign up</a>
          <?php else: ?>
            <!-- Đã đăng nhập -->
            <div class="d-flex justify-content-center align-content-center gap-5">
              <!-- Shopping cart  -->
              <button type="button" class="btn border-0 position-relative nav-link"
                onclick="loadPage('module/cart/cart.php', this, 'cart')">
                <i class="fa-solid fa-cart-shopping fs-5"></i>
              </button>
              <!-- Tính năng khác  -->
              <div class="dropdown">
                <button class="btn border-0 position-relative dropdown-toggle" type="button" data-bs-toggle="dropdown"
                  aria-expanded="false">
                  <i class="fa-solid fa-user fs-5"></i>
                </button>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="#"
                      onclick="loadPage('module/user-profile/user-profile.php', this, 'profile'); return false;">Profile</a>
                  </li>
                  <li><a class="dropdown-item" href="#" onclick="location.href='index.php?act=order'; return false;">Your
                      Order</a>
                  </li>
                  <li>
                    <a class="dropdown-item d-flex justify-content-between align-items-center" href="#"
                      onclick="location.href='index.php?act=notification'; return false;">
                      Notification
                      <?php if ($unread_count > 0): ?>
                        <span class="badge bg-danger ms-2" id="noti-badge"><?= $unread_count ?></span>
                      <?php endif; ?>
                    </a>
                  </li>


                  <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                </ul>
              </div>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
</nav>
<!-- search flyout -->
<div class="search-flyout bg-light py-4" id="searchFlyout" style="z-index: 1;">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-sm-10 col-md-8 col-lg-6">
        <div class="position-relative">
          <input type="text" class="form-control shadow-sm pe-5 rounded-5" placeholder="Search on Technologia..."
            id="searchInput">
          <button onclick="toggleSearch()" type="button"
            class="btn-close position-absolute top-50 end-0 translate-middle-y me-2" aria-label="Close">
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- search script -->
<script>
  // Biến trạng thái search flyout
  let isSearchOpen = false;

  // Hàm bật/tắt search flyout
  function toggleSearch() {
    const flyout = document.getElementById('searchFlyout');
    const searchInput = document.getElementById('searchInput');

    if (isSearchOpen) {
      // Đóng search flyout
      flyout.classList.remove('show');
      flyout.setAttribute('aria-hidden', 'true');
      isSearchOpen = false;
    } else {
      // Mở search flyout và focus vào input
      flyout.classList.add('show');
      flyout.setAttribute('aria-hidden', 'false');
      isSearchOpen = true;
      setTimeout(() => searchInput.focus(), 300);
    }
  }

  // Xử lý phím Enter để tìm kiếm
  function handleSearch(event) {
    if (event.key === 'Enter') {
      event.preventDefault();
      const query = document.getElementById('searchInput').value.trim();

      if (query) {
        performSearch(query);
        toggleSearch(); // Đóng search flyout sau khi tìm kiếm
      }
    }
  }
  document.getElementById('searchInput').addEventListener('keydown', handleSearch);

  // Handle escape key
  document.addEventListener('keydown', function (event) {
    if (event.key === 'Escape' && isSearchOpen) {
      document.getElementById('searchFlyout').classList.remove('show');
      isSearchOpen = false;
    }
  });

  // Perform search
  function performSearch(keyword) {
    // Xóa nội dung ô tìm kiếm
    document.getElementById('searchInput').value = '';

    // Cập nhật URL trình duyệt
    const newUrl = `index.php?act=products&query=${encodeURIComponent(keyword)}`;
    history.pushState({ query: keyword }, '', newUrl);

    // Tải trang sản phẩm với từ khóa tìm kiếm
    loadPage(`module/product/product.php?query=${encodeURIComponent(keyword)}`);
  }

  // Handle browser back/forward buttons
  window.addEventListener('popstate', function (event) {
    // Get current URL parameters
    const urlParams = new URLSearchParams(window.location.search);
    const query = urlParams.get('query');
    const act = urlParams.get('act');

    if (act === 'products') {
      if (query) {
        // Tải trang sản phẩm với tìm kiếm
        loadPage(`module/product/product.php?query=${encodeURIComponent(query)}`);
      } else {
        // Tải trang sản phẩm không có tìm kiếm
        loadPage('module/product/product.php');
      }
    } else {
      // Tái tải trang cho các trường hợp khác
      location.reload();
    }
  });

  // Improved popstate handler
  window.addEventListener('popstate', function (event) {
    handleUrlChange();
  });

  // Call handleUrlChange on page load to handle direct URL access
  document.addEventListener('DOMContentLoaded', function () {
    handleUrlChange();
  });
</script>

<script>
  function markAsRead(notiId, element) {
    fetch('module/user-profile/mark-read.php?id=' + notiId)
      .then(res => res.text())
      .then(() => {
        // 1. Cập nhật UI item vừa click
        element.classList.add('text-muted');
        const badge = element.querySelector('.badge');
        if (badge) badge.remove();

        // 2. Kiểm tra còn badge trên navbar không
        const navbarBadge = document.querySelector('#noti-badge');
        if (navbarBadge) {
          let count = parseInt(navbarBadge.innerText);
          count = Math.max(0, count - 1);

          if (count > 0) {
            navbarBadge.innerText = count;
          } else {
            navbarBadge.remove(); // Xóa badge nếu hết thông báo
          }
        }
      });
  }

  document.addEventListener('DOMContentLoaded', function () {
    // Lấy offcanvas element
    var offcanvasEl = document.getElementById('offcanvasNavbar');
    if (!offcanvasEl) return;

    // Lấy instance Bootstrap Offcanvas
    var bsOffcanvas = bootstrap.Offcanvas.getOrCreateInstance(offcanvasEl);

    // Đóng offcanvas khi click vào bất kỳ link trong offcanvas
    offcanvasEl.querySelectorAll('.nav-link, .dropdown-item').forEach(function (link) {
      link.addEventListener('click', function () {
        bsOffcanvas.hide();
      });
    });
  });
</script>