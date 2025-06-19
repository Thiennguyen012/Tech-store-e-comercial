<?php
require_once 'vendor/autoload.php';
session_start();

$client = new Google_Client();
$client->setClientId('55616739892-ag6b1llvhtsc82pg91bpksmuvfbku8dv.apps.googleusercontent.com');
$client->setClientSecret('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');
$client->setRedirectUri('http://localhost/Webbanhang/callback.php'); // Thay your-project-folder bằng tên thư mục project của bạn
$client->addScope('email');
$client->addScope('profile');

// Tạo URL đăng nhập
$authUrl = $client->createAuthUrl();

// Chuyển hướng đến Google OAuth
header('Location: ' . $authUrl);
exit;
?>