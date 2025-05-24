<?php
session_start();
require 'components/header.php';
require 'db/connect.php';
?>

<!-- Lấy dữ liệu từ form đăng ký -->
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Lấy dữ liệu từ form
  $name = $_POST["name"];
  $email = $_POST["email"];
  $phone = $_POST["phone"];
  $username = $_POST["username"];
  $password = $_POST["password"];
  $rePassword = $_POST["rePassword"];
}
// Kiểm tra các trường trống 
if (empty($name) || empty($email) || empty($phone) || empty($username) || empty($password)) {
  echo "<script>alert('Vui lòng nhập đầy đủ thông tin');</script>";
} elseif ($password !== $rePassword) {
  echo "<script>alert('Mật khẩu xác nhận không khớp');</script>";
} else {
  // Kiểm tra username đã tồn tại chưa
  $check = "SELECT * FROM tbl_user WHERE username = '$username'";
  $result = mysqli_query($conn, $check);

  if (mysqli_num_rows($result) > 0) {
    echo "<script>alert('Username đã tồn tại');</script>";
  } else {
    $sql = "INSERT INTO tbl_user (name, email, phone, username, password, role)
              VALUES ('$name', '$email', '$phone', '$username', '$password', 1)";

    if (mysqli_query($conn, $sql)) {
      echo "<script>alert('Đăng ký thành công'); window.location.href='login.php';</script>";
    } else {
      echo "<script>alert('Có lỗi xảy ra khi đăng ký');</script>";
    }
  }
}
?>

<!-- Main container -->
<div class="container d-flex justify-content-center align-items-center min-vh-100 border-5">
  <!-- login-container -->
  <div class="row border border rounded-5 p-3 bg-white" style="width: 930px">
    <!-- left box -->
    <div class="col-md-6 rounded-4 justify-content-center align-content-center d-flex flex-column">
      <div>
        <img id="register-img" src="./img/register-side-img.jpg" class="img-fluid rounded-5" />
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
      <!-- Tạo form đăng ký -->
      <form method="POST" action="Registration.php">
        <!-- tạo 1 row ở cột phải -->
        <div class="row align-items-center">
          <div>
            <p class="text-dark mt-4 mb-4" id="login-text">Sign up</p>
          </div>
          <!-- input username, password -->
          <div class="input-group mb-3">
            <input type="text" name="name" class="form-control form-control-lg bg-light fs-6"
              placeholder="Enter your name" required />
          </div>
          <div class="input-group mb-3">
            <input type="email" name="email" class="form-control form-control-lg bg-light fs-6"
              placeholder="Enter your email" required />
          </div>
          <div class="input-group mb-3">
            <input type="text" name="phone" class="form-control form-control-lg bg-light fs-6" placeholder="Phone"
              required />
          </div>
          <div class="input-group mb-3">
            <input type="text" name="username" class="form-control form-control-lg bg-light fs-6"
              placeholder="Enter your username" required />
          </div>
          <div class="input-group mb-3">
            <input type="password" name="password" class="form-control form-control-lg bg-light fs-6"
              placeholder="Enter password" required />
          </div>
          <div class="input-group mb-3">
            <input type="password" name="rePassword" class="form-control form-control-lg bg-light fs-6"
              placeholder="Password confirmation" required />
          </div>
          <!-- show password -->
          <div class="input-group-lg">
            <input class="form-check-input" type="checkbox" id="showPasswordCheck"
              onclick="togglePasswordVisibility()" />
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
            <button type="submit" class="btn btn-dark btn-lg mt-3 rounded-5 w-100" id="regis-btn">
              Register now
            </button>
          </div>

          <!-- line -->
          <div>
            <hr style="border: 1px solid #9da1a6" />
          </div>
      </form>
      <!-- tạo need an account và sign up cùng trên 1 hàng, lại dùng d-flex justify-content -->
      <div class="justify-content d-flex mt-1 mb-3">
        <div>
          <small class="text" style="margin-right: 5px">Already have an account?</small>
        </div>

        <div>
          <small><a href="./Login.php" class="text-success">Sign in</a></small>
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