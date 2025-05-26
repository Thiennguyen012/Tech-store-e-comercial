<div id="carouselExampleCaptions" class="carousel slide">
    <div class="carousel-indicators">
      <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active btn btn-primary"
        aria-current="true" aria-label="Slide 1"></button>
      <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
      <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>
    <div class="carousel-inner">
      <div class="carousel-item active c-items">
        <img id="slide-img1" src="./img/product-banner/zenbook14.jpg" class="d-block w-100 c-img" alt="..." />
        <script>
          function updateLoginImage() {
            const img = document.getElementById("slide-img1");
            const aspectRatio = window.innerHeight / window.innerWidth;

            if (aspectRatio > 0.9) {
              img.src = "./img/product-banner/zenbook14-smalll.jpg";
            } else {
              img.src = "./img/product-banner/zenbook14.jpg";
            }
          }

          // Gọi ngay khi load
          window.addEventListener("load", updateLoginImage);
          // Gọi lại khi thay đổi kích thước cửa sổ
          window.addEventListener("resize", updateLoginImage);
        </script>
        <div class="carousel-caption d-md-block">
          <!-- <h1 class="mt-5 fw-bold">First slide label</h1>
            <p class="my-3">
              Some representative placeholder content for the first slide.
            </p> -->
          <div>
            <button class="btn btn-transparent btn-outline-dark rounded-4 mx-3 my-1 my-lg-3 fw-bold">
              Learn more
            </button>
            <a class="text-dark ms-2 fw-bold" href="#">Buy now</a>
          </div>
        </div>
      </div>
      <div class="carousel-item c-items">
        <img id="slide-img2" src="./img/product-banner/vivo s16.jpg" class="d-block w-100 c-img" alt="..." />
        <script>
          function updateLoginImage() {
            const img = document.getElementById("slide-img2");
            const aspectRatio = window.innerHeight / window.innerWidth;

            if (aspectRatio > 0.9) {
              img.src = "./img/product-banner/vivo s16-small.jpg";
            } else {
              img.src = "./img/product-banner/vivo s16.jpg";
            }
          }

          // Gọi ngay khi load
          window.addEventListener("load", updateLoginImage);
          // Gọi lại khi thay đổi kích thước cửa sổ
          window.addEventListener("resize", updateLoginImage);
        </script>
        <div class="carousel-caption d-md-block">
          <!-- <h1 class="mt-5 fw-bold">Second slide label</h1>
            <p class="my-3">
              Some representative placeholder content for the second slide.
            </p> -->
          <div>
            <button class="btn btn-transparent btn-outline-light rounded-4 mx-3 my-1 my-lg-3 fw-bold">
              Learn more
            </button>
            <a class="text-light ms-2 fw-bold" href="#">Buy now</a>
          </div>
        </div>
      </div>
      <div class="carousel-item c-items">
        <img id="slide-img3" src="./img/product-banner/zenbook a14.jpg" class="d-block w-100 c-img" alt="..." />
        <script>
          function updateLoginImage() {
            const img = document.getElementById("slide-img3");
            const aspectRatio = window.innerHeight / window.innerWidth;

            if (aspectRatio > 0.9) {
              img.src = "./img/product-banner/zenbook a14-small.jpg";
            } else {
              img.src = "./img/product-banner/zenbook a14.jpg";
            }
          }

          // Gọi ngay khi load
          window.addEventListener("load", updateLoginImage);
          // Gọi lại khi thay đổi kích thước cửa sổ
          window.addEventListener("resize", updateLoginImage);
        </script>
        <div class="carousel-caption d-md-block align-content-center">
          <!-- <h1 class="mt-5 fw-bold">Third slide label</h1>
            <p class="my-3">
              Some representative placeholder content for the third slide.
            </p> -->
          <div>
            <button class="btn btn-transparent btn-outline-light rounded-4 mx-3 my-1 my-lg-3 fw-bold">
              Learn more
            </button>
            <a class="text-light ms-2 fw-bold" href="#">Buy now</a>
          </div>
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
  <!-- Camera -->
  <div class="gcam-container container my-5">
    <div class="row align-items-center">
      <!-- Nội dung bên trái -->
      <div class="col-md-6 text-md-start text-center mb-4 mb-md-0">
        <h1 class="gcam-title fw-bold mb-3">
          Make your home secured with Google Nest Cam
        </h1>
        <p class="gcam-content text-muted mb-4">
          Start or expand your security setup with Nest Cam (battery) and the
          Nest Cam Weatherproof Cable (10m)
        </p>
        <p class="gcam-content mb-4 fs-2 fw-bold">
          <span style="font-size: 16px; vertical-align: top">$</span>69<span
            style="font-size: 14px; vertical-align: super">99</span>
        </p>
        <button class="btn btn-dark gcam-btn rounded-4 px-4 py-2">
          Show more
        </button>
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
  <!-- ROG -->
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
          Extreme Gaming performance with ROG Strix G16
        </h1>
        <p class="laptop-content text-muted mb-4">
          Reach new heights of Windows 11 Pro gaming with the 2025 ROG Strix
          G16, boasting up to an AMD Ryzen™ 9 9955HX3D processor and up to an
          NVIDIA® GeForce RTX™ 5070 Ti Laptop GPU with a max TDP of 140W.
        </p>
        <p class="laptop-content mb-4 fs-2 fw-bold">
          <span style="font-size: 16px; vertical-align: top">$</span>1,899<span
            style="font-size: 14px; vertical-align: super">99</span>
        </p>
        <button class="btn btn-dark gcam-btn rounded-4 px-4 py-2">
          Show more
        </button>
      </div>
    </div>
  </div>
  <!-- Top Product -->
  <div class="top-product-container container">
    <h1 class="text-center fw-semibold">Top products</h1>
    <hr />
    <!-- Laptop -->
    <div class="row align-content-center my-lg-4">
      <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 mb-4 d-flex justify-content-center">
        <div class="card" style="width: 18rem">
          <img src="./img/products/laptop/84663_laptop_acer_gaming_nitro_v_16_propanel_anv16_41.jpg" class="card-img-top"
            alt="..." />
          <div class="card-body">
            <h5 class="card-title">Laptop Acer Gaming Nitro V 16 ProPanel</h5>
            <p class="card-text">
              RTX3050 6GB/R7-8845HS/16GB RAM/512GB SSD/Win11/Black
            </p>
          </div>
          <div class="row justify-content-center text-center">
            <div class="col-auto"><a href="#" class="btn btn-dark rounded-4 mb-3">More details</a></div>
            <div class="col-auto"><a href="#" class="btn rounded-4 mb-3"><i class="fa-solid fa-cart-plus fs-4"></i></a>
            </div>
          </div>
        </div>
      </div>
      <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 mb-4 d-flex justify-content-center">
        <div class="card" style="width: 18rem">
          <img src="./img/products/laptop/90816_laptop_acer_gaming_nitro_lite_nl16_71g_71uj_nh_d59sv_002_0007_layer_2.jpg"
            class="card-img-top" alt="..." />
          <div class="card-body">
            <h5 class="card-title">Laptop Acer Gaming Nitro Lite</h5>
            <p class="card-text">
              i7 13620H/16GB/512GB SSD/RTX3050 6G/Win11/White
            </p>
          </div>
          <div class="row justify-content-center text-center">
            <div class="col-auto"><a href="#" class="btn btn-dark rounded-4 mb-3">More details</a></div>
            <div class="col-auto"><a href="#" class="btn rounded-4 mb-3"><i class="fa-solid fa-cart-plus fs-4"></i></a>
            </div>
          </div>
        </div>
      </div>
      <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 mb-4 d-flex justify-content-center">
        <div class="card" style="width: 18rem">
          <img src="./img/products/laptop/79246_laptop_asus_zenbook_ux3405ma_pp152w__6_.jpg" class="card-img-top"
            alt="..." />
          <div class="card-body">
            <h5 class="card-title">Laptop Asus ZenBook UX3405MA-PP152W</h5>
            <p class="card-text">
              Core Ultra 7 155H/32GB RAM/1TB SSD/14 3K/Win11
            </p>
          </div>
          <div class="row justify-content-center text-center">
            <div class="col-auto"><a href="#" class="btn btn-dark rounded-4 mb-3">More details</a></div>
            <div class="col-auto"><a href="#" class="btn rounded-4 mb-3"><i class="fa-solid fa-cart-plus fs-4"></i></a>
            </div>
          </div>
        </div>
      </div>
      <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 mb-4 d-flex justify-content-center">
        <div class="card" style="width: 18rem">
          <img src="./img/products/laptop/dell inspiron 3530 i7.jpg" class="card-img-top" alt="..." />
          <div class="card-body">
            <h5 class="card-title">Laptop Dell Inspiron 3530 i7</h5>
            <p class="card-text">
              i7 1355U 16GB/512GB SSD/15.6 inch FHD
              120Hz/Win11H/OfficeHS21/Silver
            </p>
          </div>
          <div class="row justify-content-center text-center">
            <div class="col-auto"><a href="#" class="btn btn-dark rounded-4 mb-3">More details</a></div>
            <div class="col-auto"><a href="#" class="btn rounded-4 mb-3"><i class="fa-solid fa-cart-plus fs-4"></i></a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Security Camera -->
    <div class="row align-content-center my-lg-4">
      <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 mb-4 d-flex justify-content-center">
        <div class="card" style="width: 18rem">
          <img src="./img/products/cams/91274_camera_tp_link_tapo_c510w_0003_layer_1.jpg" class="card-img-top"
            alt="..." />
          <div class="card-body">
            <h5 class="card-title">Camera TP-Link Tapo C510W</h5>
            <p class="card-text">
              2K Resolution, Full Color Night Vision 360°, Visual Range Smart,
              Motion Tracking
            </p>
          </div>
          <div class="row justify-content-center text-center">
            <div class="col-auto"><a href="#" class="btn btn-dark rounded-4 mb-3">More details</a></div>
            <div class="col-auto"><a href="#" class="btn rounded-4 mb-3"><i class="fa-solid fa-cart-plus fs-4"></i></a>
            </div>
          </div>
        </div>
      </div>
      <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 mb-4 d-flex justify-content-center">
        <div class="card" style="width: 18rem">
          <img src="./img/products/cams/83142_camera_hikvision_ds_2cd1343g2_liuf_sl_2.jpg" class="card-img-top"
            alt="..." />
          <div class="card-body">
            <h5 class="card-title">
              Camera Hikvision DS-2CD1343G2-LIUF(SL)-2
            </h5>
            <p class="card-text">
              83 / 5.000 1/2.9″ progressive scan CMOS sensor Maximum
              resolution (1920 × 1080)/25fps 2MP
            </p>
          </div>
          <div class="row justify-content-center text-center">
            <div class="col-auto"><a href="#" class="btn btn-dark rounded-4 mb-3">More details</a></div>
            <div class="col-auto"><a href="#" class="btn rounded-4 mb-3"><i class="fa-solid fa-cart-plus fs-4"></i></a>
            </div>
          </div>
        </div>
      </div>
      <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 mb-4 d-flex justify-content-center">
        <div class="card" style="width: 18rem">
          <img src="./img/products/cams/74708_camera_tp_link_vigi_c240l_2_8mm_1.jpg" class="card-img-top" alt="..." />
          <div class="card-body">
            <h5 class="card-title">Camera TP-Link VIGI C240I</h5>
            <p class="card-text">
              Resolution 4 Megapixel H.265+/H.265/H.264+/H.264
              Fixed lens 2.8 mm
            </p>
          </div>
          <div class="row justify-content-center text-center">
            <div class="col-auto"><a href="#" class="btn btn-dark rounded-4 mb-3">More details</a></div>
            <div class="col-auto"><a href="#" class="btn rounded-4 mb-3"><i class="fa-solid fa-cart-plus fs-4"></i></a>
            </div>
          </div>
        </div>
      </div>
      <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 mb-4 d-flex justify-content-center">
        <div class="card" style="width: 18rem">
          <br />
          <br />
          <img src="./img/products/cams/56519_hikvision-hp-2cd1t23g0e-gpro-h265.jpg" class="card-img-top" alt="..." />
          <br />
          <br />
          <div class="card-body">
            <h5 class="card-title">CAMERA HIKVISION DS-2CE16D0T-EXLPF</h5>
            <p class="card-text">
              HD-TVI Bullet Camera, 2MP CMOS Sensor, 1920×1080 Resolution,
              0.02 Lux Light Sensitivity
            </p>
          </div>
          <div class="row justify-content-center text-center">
            <div class="col-auto"><a href="#" class="btn btn-dark rounded-4 mb-3">More details</a></div>
            <div class="col-auto"><a href="#" class="btn rounded-4 mb-3"><i class="fa-solid fa-cart-plus fs-4"></i></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>