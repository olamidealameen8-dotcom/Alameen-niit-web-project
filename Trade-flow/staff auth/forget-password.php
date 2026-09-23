<?php require_once __DIR__ . '/../config/connection.php'; ?>

<?php
// Decleration Of Variable
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

$resetotp = rand(100000, 999999); // Generate a random 6-digit reset otp

mysqli_query($conn, "UPDATE staff_tab SET reset_otp='$resetotp', updated_at=NOW() WHERE staff_id = '$staffId'") or die(mysqli_error($conn));

$response = [
    'success' => true,
    'message' => "RESET OTP GENERATED SUCCESSFULLY",
    'data' => [
        'staffId' => $staffId,
        'resetotp' => $resetotp,
        'emailAddress' => $emailAddress
    ]
];

end:
echo json_encode($response);
?>
