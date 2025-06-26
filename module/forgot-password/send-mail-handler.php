<!-- feae uzam xwvt zgdf -->
<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../../vendor/autoload.php';

require '../../db/connect.php'; // Cấu hình database và email

// Cấu hình email SMTP
$smtp_host = 'smtp.gmail.com';
$smtp_port = 587;
$smtp_username = 'thinhbui7779@gmail.com';
$smtp_password = 'feae uzam xwvt zgdf';
$from_email = 'thinhbui7779@gmail.com';
$from_name = 'Technologia';

// Xử lý form khi được submit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'send_code') {
    $email = trim($_POST['email']);

    // Validate email
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Vui lòng nhập email hợp lệ!";
    } else {
        try {
            // Kết nối database với mysqli
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Kiểm tra kết nối
            if ($conn->connect_error) {
                throw new Exception("Connection failed: " . $conn->connect_error);
            }

            // Set charset
            $conn->set_charset("utf8");

            // Kiểm tra email có tồn tại trong database không
            $stmt = $conn->prepare("SELECT id, name FROM site_user WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();

            if (!$user) {
                $error_message = "Email không tồn tại trong hệ thống!";
            } else {
                // Tạo token ngẫu nhiên
                $token = bin2hex(random_bytes(32));

                // Cập nhật token vào database
                $stmt = $conn->prepare("UPDATE site_user SET reset_token = ? WHERE email = ?");
                $stmt->bind_param("ss", $token, $email);
                $stmt->execute();

                // Tạo link reset password
                $reset_link = "http://localhost/Webbanhang/module/forgot-password/reset-password.php?token=" . $token;

                // Gửi email
                $mail = new PHPMailer(true);

                try {
                    // Cấu hình SMTP
                    $mail->isSMTP();
                    $mail->Host = $smtp_host;
                    $mail->SMTPAuth = true;
                    $mail->Username = $smtp_username;
                    $mail->Password = $smtp_password;
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port = $smtp_port;
                    $mail->CharSet = 'UTF-8';

                    // Người gửi
                    $mail->setFrom($from_email, $from_name);

                    // Người nhận
                    $mail->addAddress($email, $user['name']);

                    // Nội dung email
                    $mail->isHTML(true);
                    $mail->Subject = 'Đặt lại mật khẩu - Technologia';
                    $mail->Body = generateEmailTemplate($user['name'], $reset_link);
                    $mail->AltBody = "Xin chào {$user['name']},\n\nBạn đã yêu cầu đặt lại mật khẩu. Vui lòng click vào link sau để đặt lại mật khẩu:\n\n$reset_link\n\nTrân trọng,\nTeam Technologia";

                    // Gửi email
                    $mail->send();
                    $success_message = "Email đặt lại mật khẩu đã được gửi! Vui lòng kiểm tra hộp thư của bạn.";

                } catch (Exception $e) {
                    $error_message = "Không thể gửi email. Lỗi: {$mail->ErrorInfo}";
                }

                // Đóng statement
                $stmt->close();
            }

            // Đóng kết nối
            $conn->close();

        } catch (Exception $e) {
            $error_message = "Lỗi database: " . $e->getMessage();
        }
    }
}
// Function tạo template email HTML
function generateEmailTemplate($userName, $resetLink)
{
    return "
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Đặt lại mật khẩu</title>
        <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>
    </head>
    <body>
        <div class='container py-4'>
            <div class='text-center mb-4'>
                <h2 class='fw-bold'>Technologia</h2>
                <h4>Đặt lại mật khẩu</h4>
            </div>
            <div class='mb-4'>
                <p>Xin chào <strong>$userName</strong>,</p>
                <p>Chúng tôi nhận được yêu cầu đặt lại mật khẩu cho tài khoản của bạn. Nếu bạn đã yêu cầu điều này, hãy nhấn nút dưới đây:</p>
                <div class='text-center my-3'>
                    <a href='$resetLink' class='btn-dark'>Đặt lại mật khẩu</a>
                </div>
                <div class='alert alert-warning' role='alert'>
                    <strong>Lưu ý:</strong>
                    <ul class='mb-0'>
                        <li>Nếu bạn không yêu cầu, hãy bỏ qua email này.</li>
                        <li>Không chia sẻ liên kết với người khác.</li>
                    </ul>
                </div>
                <p>Nếu nút không hoạt động, hãy dán liên kết sau vào trình duyệt:</p>
                <div class='link-box'>$resetLink</div>
                <p class='mt-4'>Trân trọng,<br><strong>Team Technologia</strong></p>
            </div>
            <div class='footer'>
                <p>Email được gửi tự động. Vui lòng không trả lời.</p>
                <p>&copy; 2024 Technologia. All rights reserved.</p>
            </div>
        </div>
    </body>
    </html>
    ";
}


// Hiển thị thông báo nếu có
if (isset($success_message)) {
    echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            alert('$success_message');
        });
    </script>";
}

if (isset($error_message)) {
    echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            alert('$error_message');
        });
    </script>";
}
?>