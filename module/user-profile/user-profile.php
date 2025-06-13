<?php
// Bắt đầu session nếu chưa có
if (session_status() === PHP_SESSION_NONE) session_start();

// Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
if (!isset($_SESSION['username'])) {
    echo '<div class="container mt-5"><div class="alert alert-warning">Please <a href="Login.php">login</a> to view your account information.</div></div>';
    return;
}

require_once __DIR__ . '/../../db/connect.php';

$username = $_SESSION['username'];
$success = $error = "";

// Xử lý cập nhật thông tin hồ sơ
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $dob = trim($_POST['dob'] ?? '');
    $gender = trim($_POST['gender'] ?? '');

    // Kiểm tra dữ liệu cơ bản
    if ($name === "" || $email === "" || $phone === "") {
        $error = "Please fill in all required fields.";
    } else {
        // Chuẩn bị câu lệnh SQL và tham số tùy theo cột có sẵn
        $sql = "UPDATE site_user SET name=?, email=?, phone=? WHERE username=?";
        $params = [$name, $email, $phone, $username];
        $types = "ssss";
        // Nếu có cột dob và gender thì cập nhật luôn
        if (isset($user['dob']) && isset($user['gender'])) {
            $sql = "UPDATE site_user SET name=?, email=?, phone=?, dob=?, gender=? WHERE username=?";
            $params = [$name, $email, $phone, $dob, $gender, $username];
            $types = "ssssss";
        }
        $stmt = $conn->prepare($sql);
        $stmt->bind_param($types, ...$params);
        if ($stmt->execute()) {
            $success = "Profile updated successfully!";
        } else {
            $error = "An error occurred, please try again.";
        }
    }
}

// Luôn lấy lại thông tin user mới nhất sau khi cập nhật
$sql = "SELECT * FROM site_user WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
?>

<div class="container py-4">
    <div class="row g-4">
        <!-- Sidebar với menu điều hướng -->
        <div class="col-lg-3">
            <?php include 'user-profile-sidebar.php'; ?>
        </div>
        <!-- Form thông tin tài khoản chính -->
        <div class="col-lg-6">
            <div class="pv-profile-main shadow-sm">
                <h4 class="mb-4 fw-bold">Account Information</h4>
                <?php if ($success): ?>
                    <div class="alert alert-success"><?php echo $success; ?></div>
                <?php elseif ($error): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                <form method="post" autocomplete="off">
                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="name" name="name"
                               value="<?php echo htmlspecialchars($user['name'] ?? ''); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email"
                               value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input type="text" class="form-control" id="phone" name="phone"
                               value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>" required>
                    </div>
                    <?php if (isset($user['dob'])): ?>
                    <div class="mb-3">
                        <label for="dob" class="form-label">Date of Birth</label>
                        <input type="date" class="form-control" id="dob" name="dob"
                               value="<?php echo htmlspecialchars($user['dob'] ?? ''); ?>">
                    </div>
                    <?php endif; ?>
                    <?php if (isset($user['gender'])): ?>
                    <div class="mb-3">
                        <label class="form-label">Gender</label><br>
                        <?php $gender = $user['gender'] ?? ''; ?>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gender" id="male" value="Nam" <?php if($gender=='Nam') echo 'checked'; ?>>
                            <label class="form-check-label" for="male">Male</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gender" id="female" value="Nữ" <?php if($gender=='Nữ') echo 'checked'; ?>>
                            <label class="form-check-label" for="female">Female</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gender" id="other" value="Khác" <?php if($gender=='Khác') echo 'checked'; ?>>
                            <label class="form-check-label" for="other">Other</label>
                        </div>
                    </div>
                    <?php endif; ?>
                    <button type="submit" class="btn btn-dark mt-2">Update</button>
                </form>
            </div>
        </div>
        <!-- Hộp địa chỉ mặc định -->
        <div class="col-lg-3">
            <div class="pv-profile-address shadow-sm">
                <h5 class="fw-bold mb-2">Default Address</h5>
                <div class="text-muted mb-2" style="font-size:15px;">
                    You don't have a default shipping address. Please select Add new address.
                </div>
                <!-- Liên kết đến trang sổ địa chỉ -->
                <a class="nav-link <?php echo is_active('addresses.php'); ?>" href="#" onclick="loadPage('module/user-profile/addresses.php',this,'addresses'); return false;">
                    <i class="bi bi-plus"></i> Add a new address
                </a>
            </div>
        </div>
    </div>
</div>