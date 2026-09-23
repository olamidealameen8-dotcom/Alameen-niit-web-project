<?php require_once __DIR__ . '/../config/connection.php'; ?>

<?php
// Declaration Of Variable
$customerId = trim($_POST['customerId']);
$resetOtp = trim($_POST['resetOtp']);
$password = trim($_POST['password']);
$confirmPassword = trim($_POST['confirmPassword']);

if ($customerId == '') {
    $response = [
        'success' => false,
        'message' => "CUSTOMER ID IS REQUIRED, Kindly fill in the customer ID to continue"
    ];
    goto end;
}

if ($resetOtp == '') {
    $response = [
        'success' => false,
        'message' => "RESET OTP IS REQUIRED, Kindly fill in the reset OTP to continue"
    ];
    goto end;
}

if ($password == '') {
    $response = [
        'success' => false,
        'message' => "PASSWORD IS REQUIRED, Kindly fill in the password to continue"
    ];
    goto end;
}

if ($confirmPassword == '') {
    $response = [
        'success' => false,
        'message' => "CONFIRM PASSWORD IS REQUIRED, Kindly fill in the confirm password to continue"
    ];
    goto end;
}

if ($password !== $confirmPassword) {
    $response = [
        'success' => false,
        'message' => "PASSWORDS DO NOT MATCH, Kindly fill in the passwords correctly"
    ];
    goto end;
}

$customerCheck = mysqli_query($conn, "SELECT * FROM customer_tab WHERE customer_id = '$customerId' AND reset_otp = '$resetOtp' LIMIT 1") or die(mysqli_error($conn));
if (mysqli_num_rows($customerCheck) == 0) {
    $response = [
        'success' => false,
        'message' => "INVALID OTP! Check your OTP and try again"
    ];
    goto end;
}

$hashPassword = md5($password);

mysqli_query($conn, "UPDATE customer_tab SET password='$hashPassword', reset_otp=0, updated_at=NOW() WHERE customer_id = '$customerId'") or die(mysqli_error($conn));

$response = [
    'success' => true,
    'message' => "PASSWORD RESET SUCCESSFULLY"
];

end:
echo json_encode($response);
?>
