<?php require_once __DIR__ . '/../config/connection.php'; ?>

<?php
// Decleration Of Variable
$staffId = trim($_POST['staffId']);
$resetOtp = trim($_POST['resetOtp']);
$password = trim($_POST['password']);
$confirmPassword = trim($_POST['confirmPassword']);


if ($staffId == '') {
    $response = [
        'success' => false,
        'message' => "STAFF ID IS REQUIRED, Kindly fill in the staff ID to continue"
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

$staffCheck = mysqli_query($conn, "SELECT * FROM staff_tab WHERE staff_id = '$staffId' AND reset_otp = '$resetOtp' LIMIT 1") or die(mysqli_error($conn));
if (mysqli_num_rows($staffCheck) == 0) {
    $response = [
        'success' => false,
        'message' => "INVALID OTP! Check your OTP and try again"
    ];
    goto end;
}

$hashPassword = md5($password);

mysqli_query($conn, "UPDATE staff_tab SET password='$hashPassword', reset_otp=0, updated_at=NOW() WHERE staff_id = '$staffId'") or die(mysqli_error($conn));

$response = [
    'success' => true,
    'message' => "PASSWORD RESET SUCCESSFULLY"
];

end:
echo json_encode($response);
?>
