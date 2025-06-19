<?php
require_once 'vendor/autoload.php';
require 'db/connect.php'; // Kết nối CSDL MySQLi
session_start();
use Google\Client;

$client = new Google_Client();
$client->setClientId('55616739892-ag6b1llvhtsc82pg91bpksmuvfbku8dv.apps.googleusercontent.com');
$client->setClientSecret('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');
$client->setRedirectUri('http://localhost/Webbanhang/callback.php'); // Thay your-project-folder bằng tên thư mục project của bạn
$client->addScope('email');
$client->addScope('profile');

if (isset($_GET['code'])) {
    try {
        // Lấy access token
        $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);

        // Kiểm tra nếu có lỗi
        if (isset($token['error'])) {
            throw new Exception('Error fetching token: ' . $token['error_description']);
        }

        $client->setAccessToken($token);

        // Lấy thông tin người dùng từ Google
        $oauth2 = new \Google\Service\Oauth2($client);
        $userinfo = $oauth2->userinfo->get();

        $email = $userinfo->email;
        $name = $userinfo->name;
        $username = $email; // Sử dụng email làm username

        // Kiểm tra email trong DB
        $stmt = $conn->prepare("SELECT * FROM site_user WHERE email = ? OR username = ?");
        $stmt->bind_param("ss", $email, $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 0) {
            // Nếu chưa có thì thêm user mới
            $stmt = $conn->prepare("INSERT INTO site_user (username, name, email, role) VALUES (?, ?, ?, ?)");
            $role = 1; // Role mặc định là user
            $stmt->bind_param("sssi", $username, $name, $email, $role);
            $stmt->execute();
        } else {
            // Lấy thông tin user đã có
            $user = $result->fetch_assoc();
            $role = $user['role'];
        }

        // Lưu session (sử dụng cùng tên biến như trong index.php)
        $_SESSION['username'] = $username;
        $_SESSION['email'] = $email;
        $_SESSION['name'] = $name;
        $_SESSION['role'] = $role;

        // Chuyển về trang chủ hoặc trang đã lưu
        $redirect_url = $_SESSION['redirect_url'] ?? 'index.php';
        unset($_SESSION['redirect_url']); // Xóa URL đã lưu

        header("Location: " . $redirect_url);
        exit;

    } catch (Exception $e) {
        // Ghi log lỗi
        error_log("Google OAuth Error: " . $e->getMessage());

        // Chuyển về trang login với thông báo lỗi
        $_SESSION['login_error'] = 'Đăng nhập Google thất bại. Vui lòng thử lại.';
        header("Location: Login.php");
        exit;
    }
} else {
    // Không có code từ Google
    $_SESSION['login_error'] = 'Không nhận được mã xác thực từ Google.';
    header("Location: Login.php");
    exit;
}
?>