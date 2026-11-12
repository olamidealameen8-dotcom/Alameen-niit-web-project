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

    // Set UTF-8 encoding so no strange symbols like â€“ appear
    $mail->CharSet = 'UTF-8';
    $mail->Encoding = 'base64';

    $mail->setFrom('olamidealameen8@gmail.com', 'TradeFlow');

    // Recipient — $emailAddress passed from forgot-password
    $mail->addAddress($emailAddress);

    $mail->isHTML(true);

    // Clean subject with standard hyphen to avoid â€“ glitch
    $mail->Subject = 'Your OTP Code - TradeFlow';

    // Get clean first name for friendly greeting (e.g., "Hi Layi,")
    $nameSource = !empty(trim($staffName)) ? trim($staffName) : 'User';
    $nameParts = explode(' ', $nameSource);
    $firstName = !empty($nameParts[0]) ? ucfirst($nameParts[0]) : 'User';

    // Format OTP with non-breaking spaces so mobile email clients CANNOT wrap it onto two lines
    $cleanOtp = trim($resetOtp);
    $formattedOtp = implode('&nbsp;&nbsp;', str_split($cleanOtp));

    // Attach TradeFlow logo: use embedded CID if local file exists, else fallback to public URL
    $logoFile = __DIR__ . '/tradeflow-logo.jpg';
    $logoSrc = 'https://tradeflow.niitwebdev.com.ng/tradeflow-api/uploads/general/tradeflow-logo.jpg';
    if (file_exists($logoFile)) {
        $mail->addEmbeddedImage($logoFile, 'tradeflow_logo', 'tradeflow-logo.jpg', 'base64', 'image/jpeg');
        $logoSrc = 'cid:tradeflow_logo';
    }

    $mail->Body = '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>OTP Verification</title>
    </head>
    <body style="margin: 0; padding: 30px 10px; background-color: #f3f4f6; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Helvetica, Arial, sans-serif;">
        <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0">
            <tr>
                <td align="center">
                    <table role="presentation" width="100%" style="max-width: 500px; background-color: #ffffff; border-radius: 18px; overflow: hidden; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06); border: 1px solid #e5e7eb;" cellspacing="0" cellpadding="0" border="0">
                        
                        <!-- Header Banner with Official TradeFlow Logo -->
                        <tr>
                            <td align="center" style="background-color: #ffffff; padding: 32px 24px 20px 24px; border-bottom: 2px solid #f0fdf4;">
                                <table role="presentation" cellspacing="0" cellpadding="0" border="0" style="margin: 0 auto;">
                                    <tr>
                                        <td align="center">
                                            <img src="' . $logoSrc . '" alt="TradeFlow" style="max-height: 48px; width: auto; max-width: 220px; display: block; margin: 0 auto; border: 0;" />
                                        </td>
                                    </tr>
                                </table>
                                <div style="margin-top: 12px; color: #15803d; font-size: 11px; font-weight: 700; letter-spacing: 2.5px; text-transform: uppercase;">
                                    SECURE VERIFICATION
                                </div>
                            </td>
                        </tr>

                        <!-- Body Content -->
                        <tr>
                            <td style="padding: 36px 32px 28px 32px;">
                                <h2 style="margin: 0 0 16px 0; color: #111827; font-size: 22px; font-weight: 700;">
                                    Hi ' . htmlspecialchars($firstName) . ',
                                </h2>
                                
                                <p style="margin: 0 0 26px 0; color: #4b5563; font-size: 15px; line-height: 1.55;">
                                    Use the 6-digit verification code below to reset your TradeFlow account password:
                                </p>

                                <!-- OTP Code Box (Single Straight Line Guarantee) -->
                                <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="margin-bottom: 26px;">
                                    <tr>
                                        <td align="center" style="background-color: #f0fdf4; border: 1.5px solid #bbf7d0; border-radius: 14px; padding: 22px 10px; text-align: center; white-space: nowrap !important;">
                                            <div style="font-size: 28px; font-weight: 800; color: #15803d; letter-spacing: 4px; font-family: \'SF Mono\', Consolas, \'Liberation Mono\', Menlo, Courier, monospace; margin-bottom: 8px; white-space: nowrap !important; word-break: keep-all !important; display: inline-block;">
                                                ' . $formattedOtp . '
                                            </div>
                                            <div style="color: #166534; font-size: 12px; font-weight: 600; white-space: nowrap;">
                                                Valid for 10 minutes &bull; Keep confidential
                                            </div>
                                        </td>
                                    </tr>
                                </table>

                                <!-- Security Notice -->
                                <p style="margin: 0; color: #94a3b8; font-size: 13px; line-height: 1.5;">
                                    If you did not request a password reset, someone may have entered your email by mistake. Please secure your account.
                                </p>
                            </td>
                        </tr>

                        <!-- Footer -->
                        <tr>
                            <td align="center" style="background-color: #fafafa; padding: 18px 24px; border-top: 1px solid #f1f5f9;">
                                <p style="margin: 0; color: #94a3b8; font-size: 12px;">
                                    &copy; 2026 TradeFlow. Safe Buyer &amp; Seller Protection.
                                </p>
                            </td>
                        </tr>

                    </table>
                </td>
            </tr>
        </table>
    </body>
    </html>
    ';

    $mail->AltBody = 'Hi ' . $firstName . ', your TradeFlow OTP code is: ' . $resetOtp . '. Valid for 10 minutes.';

    $mail->send();

} catch (Exception $e) {
    // Silently log the error — do NOT echo here, it would break the JSON response
    error_log('PHPMailer Error: ' . $mail->ErrorInfo);
}
