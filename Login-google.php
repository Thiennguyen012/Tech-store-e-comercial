<?php
session_start();

// Thông tin Google OAuth
$client_id = '55616739892-ag6b1llvhtsc82pg91bpksmuvfbku8dv.apps.googleusercontent.com';
$redirect_uri = 'http://localhost/Webbanhang/callback.php';

$scope = 'email profile';
$response_type = 'code';
$state = bin2hex(random_bytes(16)); // Tạo state để bảo mật

// Lưu state vào session để verify sau
$_SESSION['oauth_state'] = $state;

$auth_url = 'https://accounts.google.com/o/oauth2/v2/auth?' . http_build_query([
    'client_id' => $client_id,
    'redirect_uri' => $redirect_uri,
    'scope' => $scope,
    'response_type' => $response_type,
    'state' => $state,
    'access_type' => 'offline',
    'prompt' => 'consent'
]);

// Chuyển hướng đến Google OAuth
header('Location: ' . $auth_url);
exit;
?>