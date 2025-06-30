<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

require_once 'contact-config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

// Lấy dữ liệu từ form
$input = json_decode(file_get_contents('php://input'), true);

// Nếu không có JSON data, lấy từ POST data
if (!$input) {
    $input = $_POST;
}

// Làm sạch dữ liệu
$cleanData = [
    'firstName' => trim(strip_tags($input['firstName'])),
    'lastName' => trim(strip_tags($input['lastName'])),
    'email' => trim(strtolower($input['email'])),
    'phone' => isset($input['phone']) ? trim(strip_tags($input['phone'])) : '',
    'subject' => trim(strip_tags($input['subject'])),
    'message' => trim(strip_tags($input['message']))
];

$result = sendContactEmail($cleanData);

if ($result['success']) {
    // Log successful submission (optional)
    error_log("Contact form submitted successfully by: " . $cleanData['email']);

    echo json_encode([
        'success' => true,
        'message' => 'Thank you for contacting us! We will respond as soon as possible.'
    ]);
} else {
    // Log error
    error_log("Contact form error: " . $result['message']);

    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Sorry, there was an error sending your message. Please try again later.'
    ]);
}
?>