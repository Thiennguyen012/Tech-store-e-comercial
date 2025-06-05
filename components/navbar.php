<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top shadow" style="height: 65px">
  <div class="container">
    <!-- Logo -->
    <a class="navbar-brand fs-4" href="#" onclick="loadPage('module/main-content/main-content.php',this); return false;">Technologia</a>
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
            <a class="nav-link" href="#" onclick="loadPage('module/main-content/main-content.php',this); return false;">Home</a>

          </li>

          <li class="nav-item dropdown mx-2">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Products
            </a>
            <ul class="dropmenu dropdown-menu mx-2" ;>
              <li><a class="dropdown-item" href="#">Laptop</a></li>
              <li><a class="dropdown-item" href="#">Security Camera</a></li>
              <li>
                <a class="dropdown-item" href="#">Others</a>
              </li>
            </ul>
          </li>
          <li class="nav-item dropdown mx-2">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Services
            </a>
            <ul class="dropmenu dropdown-menu mx-2" ;>
              <li><a class="dropdown-item" href="#">Laptop cleaning</a></li>
              <li>
                <a class="dropdown-item" href="#">Security Camera installation</a>
              </li>
              <li><a class="dropdown-item" href="#">Repair</a></li>
              <li>
                <a class="dropdown-item" href="#">Warranty</a>
              </li>
            </ul>
          </li>
          <li class="nav-item mx-2">
            <a class="nav-link" href="#About" onclick="loadPage('module/about-us/about-us.php',this); return false;">About</a>
          </li>
          <li class="nav-item mx-2">
            <a class="nav-link" href="#Contact">Contact</a>
          </li>
          <li class="nav-item dropdown mx-2">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="fas fa-search"></i>
            </a>
            <ul class="dropmenu dropdown-menu mx-2">
              <li class="d-flex justify-content-center">
                <form action="search.php" method="post">
                  <input type="text" class="form-control search-form" placeholder="Search..." aria-label="Search" />
                </form>
              </li>
            </ul>
          </li>
        </ul>
        <!-- Login/register -->
        <div class="d-flex justify-content-center align-content-center gap-3">
          <?php if (!isset($_SESSION['username'])): ?>
            <!-- Chưa đăng nhập -->
            <button type="button" class="btn border-0 position-relative mt-1" onclick="location.href='login.php'">
              <i class="fa-solid fa-cart-shopping fs-5"></i>
            </button>
            <a href="./Login.php" class="btn btn-dark rounded-4">Sign in</a>
            <a href="./Registration.php" class="btn btn-dark rounded-4">Sign up</a>
          <?php else: ?>
            <!-- Đã đăng nhập -->
            <div class="d-flex justify-content-center align-content-center gap-5">
              <!-- Shopping cart  -->
              <button type="button" class="btn border-0 position-relative" onclick="loadPage('module/cart/cart.php')">
                <i class="fa-solid fa-cart-shopping fs-5"></i>
              </button>
              <!-- Tính năng khác  -->
              <div class="dropdown">
                <button class="btn border-0 position-relative dropdown-toggle" type="button" data-bs-toggle="dropdown"
                  aria-expanded="false">
                  <i class="fa-solid fa-user fs-5"></i>
                </button>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="#">Profile</a></li>
                  <li><a class="dropdown-item" href="#">Your Order</a></li>
                  <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                </ul>
              </div>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</nav>