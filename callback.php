<?php
require 'db/connect.php';
session_start();

// Thông tin Google OAuth
$client_id = '55616739892-ag6b1llvhtsc82pg91bpksmuvfbku8dv.apps.googleusercontent.com';
$client_secret = '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';
$redirect_uri = 'http://localhost/Webbanhang/callback.php';

if (isset($_GET['code'])) {
    try {
        $code = $_GET['code'];

        // Bước 1: Trao đổi authorization code lấy access token
        $token_url = 'https://oauth2.googleapis.com/token';
        $token_data = array(
            'code' => $code,
            'client_id' => $client_id,
            'client_secret' => $client_secret,
            'redirect_uri' => $redirect_uri,
            'grant_type' => 'authorization_code'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $token_url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($token_data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/x-www-form-urlencoded'
        ));

        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curl_error = curl_error($ch);
        curl_close($ch);

        if ($curl_error) {
            throw new Exception('cURL Error: ' . $curl_error);
        }

        if ($http_code !== 200) {
            throw new Exception('Failed to get access token. HTTP Code: ' . $http_code . ' Response: ' . $response);
        }

        $token_data = json_decode($response, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception('Invalid JSON response: ' . json_last_error_msg());
        }

        if (isset($token_data['error'])) {
            throw new Exception('Token error: ' . ($token_data['error_description'] ?? $token_data['error']));
        }

        if (!isset($token_data['access_token'])) {
            throw new Exception('No access token received');
        }

        $access_token = $token_data['access_token'];

        // Bước 2: Lấy thông tin user từ Google API
        $userinfo_url = 'https://www.googleapis.com/oauth2/v2/userinfo';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $userinfo_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: Bearer ' . $access_token,
            'Accept: application/json'
        ));

        $userinfo_response = curl_exec($ch);
        $userinfo_http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $userinfo_curl_error = curl_error($ch);
        curl_close($ch);

        if ($userinfo_curl_error) {
            throw new Exception('cURL Error getting user info: ' . $userinfo_curl_error);
        }

        if ($userinfo_http_code !== 200) {
            throw new Exception('Failed to get user info. HTTP Code: ' . $userinfo_http_code . ' Response: ' . $userinfo_response);
        }

        $userinfo = json_decode($userinfo_response, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception('Invalid JSON response from userinfo: ' . json_last_error_msg());
        }

        if (!isset($userinfo['email'])) {
            throw new Exception('No email found in user info');
        }

        // Bước 3: Xử lý thông tin user
        $email = $userinfo['email'];
        $name = $userinfo['name'] ?? $email;
        $username = $email; // Sử dụng email làm username

        // Kiểm tra xem user đã tồn tại chưa
        $stmt = $conn->prepare("SELECT * FROM site_user WHERE email = ? OR username = ?");
        if (!$stmt) {
            throw new Exception('Database prepare failed: ' . $conn->error);
        }

        $stmt->bind_param("ss", $email, $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 0) {
            // User chưa tồn tại, tạo mới
            $username = $email;
            $insertStmt = $conn->prepare("INSERT INTO site_user (username, name, email, role) VALUES (?, ?, ?, ?)");
            if (!$insertStmt) {
                throw new Exception('Database prepare failed: ' . $conn->error);
            }

            $role = 1; // Role mặc định là user
            $insertStmt->bind_param("sssi", $username, $name, $email, $role);

            if (!$insertStmt->execute()) {
                throw new Exception('Failed to insert user: ' . $insertStmt->error);
            }
            $insertStmt->close();
        } else {
            // User đã tồn tại, lấy thông tin
            $user = $result->fetch_assoc();
            $role = $user['role'];
            $id = $user['id'];
            $username = $user['username'];
            $name = $user['name'];
        }

        $stmt->close();

        // Bước 4: Tạo session
        $_SESSION['username'] = $username;
        $_SESSION['user_id'] = $id;
        $_SESSION['email'] = $email;
        $_SESSION['name'] = $name;
        $_SESSION['role'] = $role;

        // Bước 5: Chuyển hướng về trang ban đầu
        $redirect_url = $_SESSION['redirect_url'] ?? 'index.php';
        unset($_SESSION['redirect_url']);

        header("Location: " . $redirect_url);
        exit;
    } catch (Exception $e) {
        // Log lỗi chi tiết
        error_log("Google OAuth Error: " . $e->getMessage());
        error_log("Request URI: " . $_SERVER['REQUEST_URI']);

        // Hiển thị thông báo lỗi cho user
        $_SESSION['login_error'] = 'Đăng nhập Google thất bại. Vui lòng thử lại.';
        header("Location: Login.php");
        exit;
    }
} else {
    // Không có authorization code
    $_SESSION['login_error'] = 'Không nhận được mã xác thực từ Google.';
    header("Location: Login.php");
    exit;
}
