<?php
require '../../db/connect.php'; // Cấu hình database

$error_message = "";
$success_message = "";
$valid_token = false;
$user_email = "";

// Kiểm tra token từ URL
if (isset($_GET['token']) && !empty($_GET['token'])) {
    $token = trim($_GET['token']); // Thêm trim để loại bỏ khoảng trắng

    try {
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Kiểm tra kết nối
        if ($conn->connect_error) {
            throw new Exception("Connection failed: " . $conn->connect_error);
        }

        // Set charset
        $conn->set_charset("utf8");

        // Debug: In ra token để kiểm tra
        error_log("Token from URL: " . $token);

        // Kiểm tra token có hợp lệ không - thêm điều kiện IS NOT NULL
        $stmt = $conn->prepare("SELECT email, name FROM site_user WHERE reset_token = ? AND reset_token IS NOT NULL AND reset_token != ''");
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user) {
            $valid_token = true;
            $user_email = $user['email'];
            error_log("Valid token found for email: " . $user_email);
        } else {
            error_log("No user found with token: " . $token);
            // Debug: Kiểm tra tất cả tokens trong database
            $debug_stmt = $conn->prepare("SELECT email, reset_token FROM site_user WHERE reset_token IS NOT NULL LIMIT 5");
            $debug_stmt->execute();
            $debug_result = $debug_stmt->get_result();
            while ($debug_row = $debug_result->fetch_assoc()) {
                error_log("DB Token: " . $debug_row['reset_token'] . " for email: " . $debug_row['email']);
            }
            $debug_stmt->close();
        }

        $stmt->close();
        $conn->close();

    } catch (Exception $e) {
        $error_message = "Lỗi database: " . $e->getMessage();
        error_log("Database error: " . $e->getMessage());
    }
} else {
    $error_message = "Invalid token!";
}

// Xử lý form đặt lại mật khẩu
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'reset_password') {
    $token = trim($_POST['token']); // Thêm trim
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate
    if (empty($new_password) || empty($confirm_password)) {
        $error_message = "Please fulfill the form!";
    } elseif (strlen($new_password) < 6) {
        $error_message = "Password must be at least 6 characters long!";
    } elseif ($new_password !== $confirm_password) {
        $error_message = "Confirm password does not match!";
    } else {
        try {
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Kiểm tra kết nối
            if ($conn->connect_error) {
                throw new Exception("Connection failed: " . $conn->connect_error);
            }

            // Set charset
            $conn->set_charset("utf8");

            $stmt = $conn->prepare("SELECT email FROM site_user WHERE reset_token = ? AND reset_token IS NOT NULL AND reset_token != ''");
            $stmt->bind_param("s", $token);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();
            if ($user) {
                $plain_password = $new_password;

                // Cập nhật mật khẩu và xóa token
                $update_stmt = $conn->prepare("UPDATE site_user SET password = ?, reset_token = NULL WHERE reset_token = ?");
                $update_stmt->bind_param("ss", $plain_password, $token);

                if ($update_stmt->execute()) {
                    if ($update_stmt->affected_rows > 0) {
                        $success_message = "Successfully reset your password! You can now log in with your new password.";
                        $valid_token = false; // Ẩn form sau khi thành công
                        error_log("Password reset successful for token: " . $token);
                    } else {
                        $error_message = "Failed to update password. Please try again.";
                        error_log("No rows affected when updating password for token: " . $token);
                    }
                } else {
                    $error_message = "Database error occurred. Please try again.";
                    error_log("Update query failed: " . $update_stmt->error);
                }

                $update_stmt->close();
            } else {
                $error_message = "Invalid or expired token. Please request a new password reset.";
                error_log("Token validation failed during password reset: " . $token);
            }

            $stmt->close();
            $conn->close();

        } catch (Exception $e) {
            $error_message = "Lỗi database: " . $e->getMessage();
            error_log("Database error during password reset: " . $e->getMessage());
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../../asset/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../../asset/style1.css" />
    <title>Reset Password - Technologia</title>

    <style>
        .password-strength {
            height: 5px;
            border-radius: 3px;
            margin-top: 5px;
        }

        .strength-weak {
            background-color: #dc3545;
        }

        .strength-medium {
            background-color: #ffc107;
        }

        .strength-strong {
            background-color: #28a745;
        }

        .password-toggle {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #6c757d;
        }

        .position-relative {
            position: relative;
        }

        .debug-info {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            font-family: monospace;
            font-size: 12px;
        }
    </style>
</head>

<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="form-control bg-white shadow-sm">
                    <div class="text-center mb-4">
                        <h3 class="fw-bold">
                            Reset your Password
                        </h3>
                        <form method="POST" id="resetForm">
                            <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token']); ?>">
                            <input type="hidden" name="action" value="reset_password">

                            <div class="mb-3">
                                <label for="new_password" class="form-label fw-semibold">
                                    New password
                                </label>
                                <div class="position-relative">
                                    <input type="password" class="form-control" id="new_password" name="new_password"
                                        placeholder="Enter new password" required minlength="6">
                                    <i class="fas fa-eye password-toggle" onclick="togglePassword('new_password')"></i>
                                </div>
                                <div class="password-strength" id="strength-bar"></div>
                                <small class="text-muted">New password must have more than 6 characters</small>
                            </div>

                            <div class="mb-3">
                                <label for="confirm_password" class="form-label fw-semibold">
                                    Confirm new password
                                </label>
                                <div class="position-relative">
                                    <input type="password" class="form-control" id="confirm_password"
                                        name="confirm_password" placeholder="Confirm new password" required>
                                    <i class="fas fa-eye password-toggle"
                                        onclick="togglePassword('confirm_password')"></i>
                                </div>
                                <div id="password-match" class="mt-2"></div>
                            </div>

                            <button type="submit" class="btn btn-dark w-100" id="submitBtn">
                                <i class="fas fa-save me-2"></i>Reset Password
                            </button>
                        </form>
                    </div>

                    <!-- Divider -->
                    <hr style="border: 1px solid #9da1a6" />

                    <div class="d-flex justify-content-between mt-4">
                        <div>
                            <small><a href="../../Login.php" class="text-success">
                                    <i class="fas fa-arrow-left me-1"></i>Login to your account
                                </a></small>
                        </div>

                        <div>
                            <small><a href="../../Registration.php" class="text-success">
                                    <i class="fas fa-user-plus me-1"></i>Sign up
                                </a></small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    <script>
        // Toggle password visibility
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const icon = field.nextElementSibling;

            if (field.type === 'password') {
                field.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                field.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        // Check password strength
        document.getElementById('new_password').addEventListener('input', function () {
            const password = this.value;
            const strengthBar = document.getElementById('strength-bar');

            let strength = 0;
            if (password.length >= 6) strength++;
            if (password.match(/[a-z]/)) strength++;
            if (password.match(/[A-Z]/)) strength++;
            if (password.match(/[0-9]/)) strength++;
            if (password.match(/[^a-zA-Z0-9]/)) strength++;

            strengthBar.className = 'password-strength';
            if (strength < 2) {
                strengthBar.classList.add('strength-weak');
            } else if (strength < 4) {
                strengthBar.classList.add('strength-medium');
            } else {
                strengthBar.classList.add('strength-strong');
            }
        });

        // Check password match
        function checkPasswordMatch() {
            const password = document.getElementById('new_password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            const matchDiv = document.getElementById('password-match');
            const submitBtn = document.getElementById('submitBtn');

            if (confirmPassword.length > 0) {
                if (password === confirmPassword) {
                    matchDiv.innerHTML = '<small class="text-success"><i class="fas fa-check me-1"></i>Password match</small>';
                    submitBtn.disabled = false;
                } else {
                    matchDiv.innerHTML = '<small class="text-danger"><i class="fas fa-times me-1"></i>Password does not match</small>';
                    submitBtn.disabled = true;
                }
            } else {
                matchDiv.innerHTML = '';
                submitBtn.disabled = false;
            }
        }

        document.getElementById('new_password').addEventListener('input', checkPasswordMatch);
        document.getElementById('confirm_password').addEventListener('input', checkPasswordMatch);

        // Form validation
        document.getElementById('resetForm')?.addEventListener('submit', function (e) {
            const password = document.getElementById('new_password').value;
            const confirmPassword = document.getElementById('confirm_password').value;

            if (password.length < 6) {
                e.preventDefault();
                alert('Password must be at least 6 characters!');
                return;
            }

            if (password !== confirmPassword) {
                e.preventDefault();
                alert('Confirm password does not match!');
                return;
            }
        });
    </script>
</body>

</html>