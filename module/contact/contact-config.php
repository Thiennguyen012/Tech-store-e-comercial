<?php
require_once './vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Cấu hình email
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_PORT', 587);
define('SMTP_USERNAME', 'thinhbui7779@gmail.com'); // Email công ty
define('SMTP_PASSWORD', 'feae uzam xwvt zgdf'); // App password hoặc mật khẩu email
define('COMPANY_EMAIL', 'thinhbui7779@gmail.com'); // Email nhận tin nhắn
define('COMPANY_NAME', 'Technologia');

function sendContactEmail($data)
{
    $mail = new PHPMailer(true);

    try {
        // Cấu hình server
        $mail->isSMTP();
        $mail->Host = SMTP_HOST;
        $mail->SMTPAuth = true;
        $mail->Username = SMTP_USERNAME;
        $mail->Password = SMTP_PASSWORD;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = SMTP_PORT;
        $mail->CharSet = 'UTF-8';

        // Người gửi và người nhận
        $mail->setFrom(SMTP_USERNAME, COMPANY_NAME);
        $mail->addAddress(COMPANY_EMAIL, COMPANY_NAME);
        $mail->addReplyTo($data['email'], $data['firstName'] . ' ' . $data['lastName']);

        // Nội dung email
        $mail->isHTML(true);
        $mail->Subject = 'New Contact Form Submission: ' . $data['subject'];

        // Template HTML cho email
        $mail->Body = generateEmailTemplate($data);

        // Gửi email
        $mail->send();
        return ['success' => true, 'message' => 'Email sent successfully'];

    } catch (Exception $e) {
        return ['success' => false, 'message' => 'Email could not be sent. Error: ' . $mail->ErrorInfo];
    }
}

function generateEmailTemplate($data)
{
    $subjectTypes = [
        'general' => 'General Question',
        'service' => 'Service',
        'support' => 'Technical Support',
        'partnership' => 'Partnership',
        'other' => 'Other'
    ];

    $subjectText = isset($subjectTypes[$data['subject']]) ? $subjectTypes[$data['subject']] : 'Other';

    $html = '
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
            .container { max-width: 600px; margin: 0 auto; padding: 20px; }
            .header { background: #f8f9fa; padding: 20px; border-radius: 5px; margin-bottom: 20px; }
            .content { background: #ffffff; padding: 20px; border: 1px solid #dee2e6; border-radius: 5px; }
            .info-row { margin-bottom: 15px; }
            .label { font-weight: bold; color: #495057; }
            .value { margin-left: 10px; }
            .message-box { background: #f8f9fa; padding: 15px; border-radius: 5px; margin-top: 15px; }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="header">
                <h2>New Contact Form Submission</h2>
                <p>You have received a new message from your website contact form.</p>
            </div>
            
            <div class="content">
                <div class="info-row">
                    <span class="label">Name:</span>
                    <span class="value">' . htmlspecialchars($data['firstName']) . ' ' . htmlspecialchars($data['lastName']) . '</span>
                </div>
                
                <div class="info-row">
                    <span class="label">Email:</span>
                    <span class="value">' . htmlspecialchars($data['email']) . '</span>
                </div>
                
                <div class="info-row">
                    <span class="label">Phone:</span>
                    <span class="value">' . (empty($data['phone']) ? 'Not provided' : htmlspecialchars($data['phone'])) . '</span>
                </div>
                
                <div class="info-row">
                    <span class="label">Subject:</span>
                    <span class="value">' . htmlspecialchars($subjectText) . '</span>
                </div>
                
                <div class="info-row">
                    <span class="label">Date:</span>
                    <span class="value">' . date('Y-m-d H:i:s') . '</span>
                </div>
                
                <div class="message-box">
                    <div class="label">Message:</div>
                    <div style="margin-top: 10px; white-space: pre-wrap;">' . htmlspecialchars($data['message']) . '</div>
                </div>
            </div>
        </div>
    </body>
    </html>';

    return $html;
}

?>