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

$emailCheck = mysqli_query($conn, "SELECT * FROM user_tab WHERE email = '$emailAddress' LIMIT 1") or die(mysqli_error($conn));
if (mysqli_num_rows($emailCheck) == 0) {
    $response = [
        'success' => false,
        'message' => "EMAIL NOT FOUND! No account is registered with this email address"
    ];
    goto end;
}

$userData = mysqli_fetch_assoc($emailCheck);
$userId = $userData['user_id'];
$emailAddress = $userData['email'];

$resetotp = rand(100000, 999999); // Generate a random 6-digit reset otp

mysqli_query($conn, "UPDATE user_tab SET reset_otp='$resetotp', updated_at=NOW() WHERE user_id = '$userId'") or die(mysqli_error($conn));

$response = [
    'success' => true,
    'message' => "RESET OTP GENERATED SUCCESSFULLY",
    'data' => [
        'userId' => $userId,
        'resetotp' => $resetotp,
        'emailAddress' => $emailAddress
    ]
];

end:
echo json_encode($response);
?>;