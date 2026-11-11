<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/PHPMailer/src/Exception.php';
require_once __DIR__ . '/PHPMailer/src/PHPMailer.php';
require_once __DIR__ . '/PHPMailer/src/SMTP.php';

$mail = new PHPMailer(true);

try {

    $mail->isSMTP();

    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;

    $mail->Username = 'olamidealameen8@gmail.com';

    $mail->Password = 'joux jomy olpo ppgq';

    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->setFrom('olamidealameen8@gmail.com', 'Trade Flow');

    // Recipient — $emailAddress is passed in from the calling script (forgot-password.php)
    $mail->addAddress($emailAddress);

    $mail->isHTML(true);

    $mail->Subject = 'Your OTP Code — Trade Flow';

    $mail->Body = '
        <h2>OTP Verification</h2>
        <p>Hello ' . $staffName . ',</p>
        <p>Your password reset OTP code is:</p>
        <h1 style="letter-spacing: 8px; color: #2d6a4f;">' . $resetOtp . '</h1>
        <p>This code will expire in 10 minutes. Do not share it with anyone.</p>
        <p>If you did not request this, please ignore this email.</p>
        <br>
        <p>— Trade Flow Team</p>
    ';

    $mail->AltBody = 'Your OTP code is: ' . $resetOtp . '. This code will expire in 10 minutes.';

    $mail->send();

} catch (Exception $e) {
    // Silently log the error — do NOT echo here, it would break the JSON response
    error_log('PHPMailer Error: ' . $mail->ErrorInfo);
}
