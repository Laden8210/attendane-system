<?php
require_once 'repository/config.php';
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

header('Content-Type: application/json');


$input = json_decode(file_get_contents('php://input'), true);


$email = filter_var($input['email'], FILTER_VALIDATE_EMAIL);

if (!$email) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid email address.']);
    exit;
}


$stmt = $conn->prepare("SELECT user_id FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(['status' => 'error', 'message' => 'Email not found.']);
    exit;
}

$user = $result->fetch_assoc();
$userId = $user['user_id'];


$token = bin2hex(random_bytes(32));
$expiresAt = date('Y-m-d H:i:s', strtotime('+1 hour'));

$stmt = $conn->prepare("INSERT INTO password_reset_tokens  (user_id, token, expires_at) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE token = VALUES(token), expires_at = VALUES(expires_at)");
$stmt->bind_param("iss", $userId, $token, $expiresAt);
$stmt->execute();



$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";


$host = $_SERVER['HTTP_HOST'];

$resetUrl = $protocol . $host . '/school-attendance' . "/change_password.php?token=$token";






try {
    $mail = new PHPMailer(true);
    $mail->IsSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'sarmientojohncarlo97@gmail.com';
    $mail->Password   = 'ibol qtzv bhcd bjzs';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port       = 465;

    $mail->setFrom('sarmientojohncarlo97@gmail.com', 'Web-based School Event Attendance Monitoring System');
    $mail->addAddress($email, $email);

    $mail->isHTML(true);
    $mail->Subject = 'Reset Your Password';
    $mail->Body = "
<div style='font-family: Arial, sans-serif; line-height: 1.6; color: #333; padding: 20px; background-color: #f9f9f9;'>
    <div style='max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 4px rgba(0,0,0,0.1);'>
        <!-- Header Section -->
        <div style='background-color: #003C68; padding: 20px; text-align: center;'>
            <h1 style='color: #ffffff; font-size: 24px; margin: 0;'>Web-based School Event Attendance Monitoring System</h1>
        </div>
        
        <!-- Body Section -->
        <div style='padding: 20px;'>
            <p style='font-size: 16px; margin-bottom: 20px;'>Hello,</p>
            <p style='font-size: 16px; margin-bottom: 20px;'>We received a request to reset your password. Click the link below to reset it:</p>
            
            <div style='text-align: center; margin: 20px 0;'>
                <a href='$resetUrl' style='display: inline-block; padding: 10px 20px; color: #ffffff; background-color: #4CB4FF; text-decoration: none; border-radius: 5px; font-size: 16px;'>Reset Your Password</a>
            </div>
            
            <p style='font-size: 16px; margin-bottom: 20px;'>If the button above does not work, copy and paste the link below into your browser:</p>
            <p style='font-size: 14px; color: #555; word-wrap: break-word;'>$resetUrl</p>
            
            <p style='font-size: 16px; margin-top: 20px;'>If you did not request this, please ignore this email.</p>
        </div>
        

    </div>
</div>

";


    $mail->send();
    echo json_encode(['status' => 'success', 'message' => 'Reset password email sent.']);
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => 'Failed to send email.', 'error' => $e->getMessage()]);
}
