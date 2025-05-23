<?php
  require 'components/header.php';
  require 'db/connect.php'
?>
    <!-- Navbar -->
    <nav
      class="navbar navbar-expand-lg navbar-light bg-light sticky-top shadow"
      style="height: 65px"
    >
      <div class="container">
        <!-- Logo -->
        <a class="navbar-brand fs-4" href="#">Technologia</a>
        <!-- Toggle button -->
        <button
          class="navbar-toggler shaddow-none border-0"
          type="button"
          data-bs-toggle="offcanvas"
          data-bs-target="#offcanvasNavbar"
          aria-controls="offcanvasNavbar"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <!-- sidebar -->
        <div
          class="sidebar offcanvas offcanvas-end"
          tabindex="-1"
          id="offcanvasNavbar"
          aria-labelledby="offcanvasNavbarLabel"
        >
          <!-- sidebar header -->
          <div class="offcanvas-header border-dark border-bottom">
            <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Menu</h5>
            <button
              type="button"
              class="btn-close btn-close-dark shadow-none border-0"
              data-bs-dismiss="offcanvas"
              aria-label="Close"
            ></button>
          </div>
          <!-- sidebar body -->
          <div class="offcanvas-body flex-lg-row d-flex flex-column">
            <ul class="navbar-nav justify-content-center flex-grow-1 pe-3">
              <li class="nav-item mx-2">
                <a class="nav-link" aria-current="page" href="index.php">Home</a>
              </li>

              <li class="nav-item dropdown mx-2">
                <a
                  class="nav-link dropdown-toggle"
                  href="#"
                  role="button"
                  data-bs-toggle="dropdown"
                  aria-expanded="false"
                >
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
                <a
                  class="nav-link dropdown-toggle"
                  href="#"
                  role="button"
                  data-bs-toggle="dropdown"
                  aria-expanded="false"
                >
                  Services
                </a>
                <ul class="dropmenu dropdown-menu mx-2" ;>
                  <li><a class="dropdown-item" href="#">Laptop cleaning</a></li>
                  <li>
                    <a class="dropdown-item" href="#"
                      >Security Camera installation</a
                    >
                  </li>
                  <li><a class="dropdown-item" href="#">Repair</a></li>
                  <li>
                    <a class="dropdown-item" href="#">Warranty</a>
                  </li>
                </ul>
              </li>
              <li class="nav-item mx-2">
                <a class="nav-link" href="#About">About</a>
              </li>
              <li class="nav-item mx-2">
                <a class="nav-link" href="#Contact">Contact</a>
              </li>
              <li class="nav-item dropdown mx-2">
                <a
                  class="nav-link dropdown-toggle"
                  href="#"
                  role="button"
                  data-bs-toggle="dropdown"
                  aria-expanded="false"
                >
                  <i class="fas fa-search"></i>
                </a>
                <ul class="dropmenu dropdown-menu mx-2">
                  <li class="d-flex justify-content-center">
                    <form action="search.php" method="post">
                      <input
                        type="text"
                        class="form-control search-form"
                        placeholder="Search..."
                        aria-label="Search"
                      />
                    </form>
                  </li>
                </ul>
              </li>
            </ul>
            <!-- Login/register -->
            <div
              class="d-flex justify-content-center align-content-center gap-3"
            >
              <a href="Login.php" class="btn btn-dark rounded-4">Sign in</a>
              <a href="Registration.php" class="btn btn-dark rounded-4"
                >Sign up</a
              >
            </div>
          </div>
        </div>
      </div>
    </nav>
    <!-- End Navbar -->

    <!-- loc san pham -->
     <aside class="custom-sidebar">
  <div class="sidebar__header-title">Brands</div>
  <ul class="brand-list">
    <li><input type="checkbox" id="carver"> <label for="carver">Asus</label></li>
    <li><input type="checkbox" id="bdskateco"> <label for="bdskateco">Alienware</label></li>
    <li><input type="checkbox" id="axesea"> <label for="axesea">DEll</label></li>
    <li><input type="checkbox" id="darkroom"> <label for="darkroom">FPT</label></li>
    <li><input type="checkbox" id="santacruz"> <label for="santacruz">SANTA CRUZ</label></li>
  </ul>
  <div class="price-title">Price</div>
  <form>
    <div class="price-range">
      <input type="range" min="0" max="10000000" value="0" id="minPrice" style="width: 45%;">
      <input type="range" min="0" max="10000000" value="10000000" id="maxPrice" style="width: 45%;">
    </div>
    <div class="price-inputs">
      <input type="number" min="0" max="10000000" value="0" id="minPriceInput" class="form-control" style="width: 45%;">
      <span>-</span>
      <input type="number" min="0" max="10000000" value="10000000" id="maxPriceInput" class="form-control" style="width: 45%;">
    </div>
    <button type="submit" class="btn-filter">Filer</button>
  </form>
</aside>

<!-- style loc san pham -->
 
 <style>
  .custom-sidebar {
    margin-top: 20px; /* 8px lower than navbar */
    background: #fff;
    border-radius: 8px;
    padding: 24px 16px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    min-width: 240px;
    max-width: 300px;
  }
  .sidebar__header-title {
    font-size: 1.1rem;
    font-weight: bold;
    margin-bottom: 16px;
    border-bottom: 1px solid #eee;
    padding-bottom: 6px;
    text-transform: uppercase;
    letter-spacing: 1px;
  }
  .brand-list {
    max-height: 120px;
    overflow-y: auto;
    margin-bottom: 24px;
    padding-left: 0;
    list-style: none;
  }
  .brand-list li {
    margin-bottom: 8px;
    font-size: 1rem;
  }
  .price-title {
    font-size: 1.1rem;
    font-weight: bold;
    margin-bottom: 12px;
    border-bottom: 1px solid #eee;
    padding-bottom: 6px;
    text-transform: uppercase;
    letter-spacing: 1px;
  }
  .price-range {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 12px;
  }
  .price-inputs {
    display: flex;
    gap: 8px;
    margin-bottom: 12px;
  }
  .btn-filter {
    width: 100%;
    border-radius: 20px;
    background: #000;
    color: #fff;
    border: none;
    padding: 8px 0;
    font-weight: bold;
    transition: background 0.2s;
  }
  .btn-filter:hover {
    background: #222;
  }
</style>
<!-- End loc san pham -->
<?php
  include 'components/footer.php'
?>