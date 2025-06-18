<?php
require_once 'vendor/autoload.php';

$client = new Google_Client();
$client->setClientId('55616739892-ag6b1llvhtsc82pg91bpksmuvfbku8dv.apps.googleusercontent.com');
$client->setClientSecret('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');
$client->setRedirectUri('http://localhost/Webbanhang/callback.php');
$client->addScope('email');
$client->addScope('profile');

$authUrl = $client->createAuthUrl();
header('Location: ' . filter_var($authUrl, FILTER_SANITIZE_URL));
exit;
?>