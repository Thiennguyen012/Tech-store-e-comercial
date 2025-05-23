<?php
require 'components/header.php';
require 'db/connect.php'
?>
<!-- Navbar -->
<nav
  class="navbar navbar-expand-lg navbar-light bg-light sticky-top shadow"
  style="height: 65px">
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
      aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <!-- sidebar -->
    <div
      class="sidebar offcanvas offcanvas-end"
      tabindex="-1"
      id="offcanvasNavbar"
      aria-labelledby="offcanvasNavbarLabel">
      <!-- sidebar header -->
      <div class="offcanvas-header border-dark border-bottom">
        <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Menu</h5>
        <button
          type="button"
          class="btn-close btn-close-dark shadow-none border-0"
          data-bs-dismiss="offcanvas"
          aria-label="Close"></button>
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
              aria-expanded="false">
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
              aria-expanded="false">
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
              aria-expanded="false">
              <i class="fas fa-search"></i>
            </a>
            <ul class="dropmenu dropdown-menu mx-2">
              <li class="d-flex justify-content-center">
                <form action="search.php" method="post">
                  <input
                    type="text"
                    class="form-control search-form"
                    placeholder="Search..."
                    aria-label="Search" />
                </form>
              </li>
            </ul>
          </li>
        </ul>
        <!-- Login/register -->
        <div
          class="d-flex justify-content-center align-content-center gap-3">
          <a href="Login.php" class="btn btn-dark rounded-4">Sign in</a>
          <a href="Registration.php" class="btn btn-dark rounded-4">Sign up</a>
        </div>
      </div>
    </div>
  </div>
</nav>
<!-- End Navbar -->

<!-- loc san pham -->
<div class="container-fluid mt-5 mb-5 px-2">
  <div class="row">
    <!-- Sidebar on the left -->
    <div class="col-md-3">
      <div
        class="card shadow-sm position-sticky"
        style="top: 80px; z-index: 1020; background: #fff">
        <div class="card-body">
          <h6
            class="card-title text-uppercase fw-bold border-bottom pb-2 mb-3">
            Thương hiệu
          </h6>
          <div class="mb-4" style="max-height: 120px; overflow-y: auto">
            <ul class="list-group list-group-flush">
              <li class="list-group-item px-0">
                <div class="form-check">
                  <input
                    class="form-check-input"
                    type="checkbox"
                    id="asus" />
                  <label class="form-check-label fw-semibold" for="asus">Asus</label>
                </div>
              </li>
              <li class="list-group-item px-0">
                <div class="form-check">
                  <input
                    class="form-check-input"
                    type="checkbox"
                    id="alienware" />
                  <label class="form-check-label fw-semibold" for="alienware">Alienware</label>
                </div>
              </li>
              <li class="list-group-item px-0">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="dell" />
                  <label class="form-check-label fw-semibold" for="dell">Dell</label>
                </div>
              </li>
              <li class="list-group-item px-0">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="fpt" />
                  <label class="form-check-label fw-semibold" for="fpt">FPT</label>
                </div>
              </li>
              <li class="list-group-item px-0">
                <div class="form-check">
                  <input
                    class="form-check-input"
                    type="checkbox"
                    id="santacruz" />
                  <label class="form-check-label fw-semibold" for="santacruz">SANTA CRUZ</label>
                </div>
              </li>
            </ul>
          </div>
          <h6
            class="card-title text-uppercase fw-bold border-bottom pb-2 mb-3">
            Mức giá
          </h6>
          <form>
            <div class="d-flex align-items-center gap-2 mb-3">
              <input
                type="number"
                min="0"
                max="10000000"
                value="0"
                id="minPriceInput"
                class="form-control"
                style="width: 45%" />
              <span>-</span>
              <input
                type="number"
                min="0"
                max="10000000"
                value="10000000"
                id="maxPriceInput"
                class="form-control"
                style="width: 45%" />
            </div>
            <button
              type="submit"
              class="btn btn-dark w-100 rounded-pill fw-bold">
              Lọc giá
            </button>
          </form>
        </div>
      </div>
    </div>
    <!-- Main content on the right -->
    <div class="col-md-9">
      <!-- Your product grid/list goes here -->
    </div>
  </div>
</div>
<!-- End loc san pham -->
<?php
include 'components/footer.php'
?>