<?php
require 'components/header.php'
?>
    <!-- Main container -->
    <div
      class="container d-flex justify-content-center align-items-center min-vh-100 border-5"
    >
      <!-- login-container -->
      <div
        class="row border border rounded-5 p-3 bg-white"
        style="width: 930px"
      >
        <!-- left box -->
        <div
          class="col-md-6 rounded-4 justify-content-center align-content-center d-flex flex-column"
        >
          <div>
            <img
              id="register-img"
              src="./img/register-side-img.jpg"
              class="img-fluid rounded-5"
            />
          </div>
          <script>
            function updateLoginImage() {
              const img = document.getElementById("register-img");
              const aspectRatio = window.innerHeight / window.innerWidth;

              if (aspectRatio > 1.05) {
                img.src = "./img/register-side-img-cropped.jpg";
              } else {
                img.src = "./img/register-side-img.jpg"
              }
            }

            // Gọi ngay khi load
            window.addEventListener("load", updateLoginImage);
            // Gọi lại khi thay đổi kích thước cửa sổ
            window.addEventListener("resize", updateLoginImage);
          </script>
        </div>
        <!-- right box -->
        <!-- tạo cột phải -->
        <div class="col-md-6">
          <!-- tạo 1 row ở cột phải -->
          <div class="row align-items-center">
            <div>
              <p class="text-dark mt-4 mb-4" id="login-text">Sign up</p>
            </div>
            <!-- input username, password -->
            <div class="input-group mb-3">
              <input
                type="text"
                class="form-control form-control-lg bg-light fs-6"
                placeholder="Enter your name"
              />
            </div>
            <div class="input-group mb-3">
              <input
                type="text"
                class="form-control form-control-lg bg-light fs-6"
                placeholder="Enter your email"
              />
            </div>
            <div class="input-group mb-3">
              <input
                type="text"
                class="form-control form-control-lg bg-light fs-6"
                placeholder="Phone"
              />
            </div>
            <div class="input-group mb-3">
              <input
                type="text"
                class="form-control form-control-lg bg-light fs-6"
                placeholder="Enter your username"
              />
            </div>
            <div class="input-group mb-3">
              <input
                type="password"
                class="form-control form-control-lg bg-light fs-6"
                placeholder="Enter password"
              />
            </div>
            <div class="input-group mb-3">
              <input
                type="password"
                class="form-control form-control-lg bg-light fs-6"
                placeholder="Password confirmation"
              />
            </div>
            <!-- show password -->
            <div class="input-group-lg">
              <input
                class="form-check-input"
                type="checkbox"
                id="showPasswordCheck"
                onclick="togglePasswordVisibility()"
              />
              <label class="form-check-label" for="showPasswordCheck">
                <small>Show password</small>
              </label>
            </div>
            <script>
              function togglePasswordVisibility() {
                const passwordInputs = document.querySelectorAll(
                  'input[placeholder="Enter password"], input[placeholder="Password confirmation"]'
                );
                const isChecked =
                  document.getElementById("showPasswordCheck").checked;
                passwordInputs.forEach((input) => {
                  input.type = isChecked ? "text" : "password";
                });
              }
            </script>
            <!-- Button login -->
            <div class="input-group mb-lg-2 mb-md-2 mb-sm-2">
              <button
                type="button"
                class="btn btn-dark btn-lg mt-3 rounded-5 w-100"
                id="login-btn"
              >
                Register now
              </button>
            </div>
            <!-- line -->
            <div><hr style="border: 1px solid #9da1a6" /></div>

            <!-- tạo need an account và sign up cùng trên 1 hàng, lại dùng d-flex justify-content -->
            <div class="justify-content d-flex mt-1 mb-3">
              <div>
                <small class="text" style="margin-right: 5px"
                  >Already have an account?</small
                >
              </div>

              <div>
                <small
                  ><a href="./Login.php" class="text-success"
                    >Sign in</a
                  ></small
                >
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- bootstrap js -->
    <script src="./asset/bootstrap/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
