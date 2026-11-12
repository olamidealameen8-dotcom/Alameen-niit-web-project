<?php require_once __DIR__ . '/../../config/connection.php'; ?>

<?php
// Declaration Of Variable
$emailAddress = trim($_POST['emailAddress']);

if ($emailAddress == '') {

    $response = [
        'success' => false,
        'message' => "EMAIL ADDRESS IS REQUIRED, Kindly fill in the email address to continue"
    ];
    goto end;
}

if (!filter_var($emailAddress, FILTER_VALIDATE_EMAIL)) {
    $response = [
        'response' => 102,
        'success' => false,
        'message' => "INVALID EMAIL ADDRESS! Enter a valid email address and try again",
    ];
    goto end;
}

$emailCheck = mysqli_query($conn, "SELECT * FROM staff_tab WHERE email_address = '$emailAddress' LIMIT 1") or die(mysqli_error($conn));
if (mysqli_num_rows($emailCheck) == 0) {
    $response = [
        'success' => false,
        'message' => "EMAIL NOT FOUND! No account is registered with this email address"
    ];
    goto end;
}

$staffData = mysqli_fetch_assoc($emailCheck);
$staffId = $staffData['staff_id'];
$emailAddress = $staffData['email_address'];
$staffName = $staffData['first_name'] . ' ' . $staffData['last_name'];

$resetOtp = rand(100000, 999999);

mysqli_query($conn, "UPDATE staff_tab SET reset_otp='$resetOtp', updated_at=NOW() WHERE staff_id = '$staffId'") or die(mysqli_error($conn));

$response = [
    'success' => true,
    'message' => "RESET OTP GENERATED SUCCESSFULLY",
    'data' => [
        'staffId' => $staffId,
        'resetotp' => $resetOtp,
        'emailAddress' => $emailAddress
    ]
];

// Safely load mail file — will not crash the endpoint if something goes wrong
$mailFile = __DIR__ . "/../../config/mail/sent-otp-to-mail.php";
if (file_exists($mailFile)) {
    try {
        require $mailFile;
    } catch (Exception $e) {
        error_log('Mail Error: ' . $e->getMessage());
    }
} else {
    error_log('Mail file not found: ' . $mailFile);
}

end:
echo json_encode($response);
?>
