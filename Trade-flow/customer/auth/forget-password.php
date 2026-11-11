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
        'success' => false,
        'message' => "INVALID EMAIL ADDRESS! Enter a valid email address and try again"
    ];
    goto end;
}

$emailCheck = mysqli_query($conn, "SELECT * FROM customer_tab WHERE email_address = '$emailAddress' LIMIT 1") or die(mysqli_error($conn));
if (mysqli_num_rows($emailCheck) == 0) {
    $response = [
        'success' => false,
        'message' => "EMAIL NOT FOUND! No account is registered with this email address"
    ];
    goto end;
}

$customerData = mysqli_fetch_assoc($emailCheck);
$customerId = $customerData['customer_id'];
$emailAddress = $customerData['email_address'];
$staffName = $customerData['first_name'] . ' ' . $customerData['last_name'];
$resetOtp = rand(100000, 999999);

mysqli_query($conn, "UPDATE customer_tab SET reset_otp='$resetOtp', updated_at=NOW() WHERE customer_id = '$customerId'") or die(mysqli_error($conn));

$response = [
    'success' => true,
    'message' => "RESET OTP GENERATED SUCCESSFULLY",
    'data' => [
        'customerId' => $customerId,
        'resetotp' => $resetOtp,
        'emailAddress' => $emailAddress
    ]
];

end:
echo json_encode($response);
?>
