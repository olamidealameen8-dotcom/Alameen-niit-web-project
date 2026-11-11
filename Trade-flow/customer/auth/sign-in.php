<?php require_once __DIR__ . '/../../config/connection.php'; ?>

<?php
// DECLARATION OF VARIABLES
$emailAddress = trim($_POST['emailAddress']);
$password = $_POST['password'];

if ($emailAddress == '') {
    $response = [
        'success' => false,
        'message' => "EMAIL ADDRESS IS REQUIRED, Kindly fill in your email address to continue"
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

if ($password == '') {
    $response = [
        'success' => false,
        'message' => "PASSWORD IS REQUIRED, Kindly fill in your password to continue"
    ];
    goto end;
}

$hashPassword = md5($password);

$loginQuery = mysqli_query($conn, "SELECT * FROM customer_tab WHERE email_address = '$emailAddress' AND password = '$hashPassword' LIMIT 1") or die(mysqli_error($conn));

if (mysqli_num_rows($loginQuery) == 0) {
    $response = [
        'success' => false,
        'message' => "INVALID LOGIN DETAILS! Check your email and password and try again"
    ];
    goto end;
}

$customerData = mysqli_fetch_assoc($loginQuery);

$customerId = $customerData['customer_id'];

$lastLoginDate = date("Y-m-d H:i:s");
mysqli_query($conn, "UPDATE customer_tab SET last_login_date = '$lastLoginDate' WHERE customer_id = '$customerId'") or die(mysqli_error($conn));

$response = [
    'success' => true,
    'message' => "LOGIN SUCCESSFUL",
    'data' => [
        'customerId' => $customerData['customer_id'],
        'firstName' => $customerData['first_name'],
        'lastName' => $customerData['last_name'],
        'emailAddress' => $customerData['email_address'],
        'phoneNumber' => $customerData['phone_number'],
        'address' => $customerData['address'],
        'lastLoginDate' => $lastLoginDate,
        'createdAt' => $customerData['created_at'],
        'updatedAt' => $customerData['updated_at']
    ]
];

end:
echo json_encode($response);
?>
