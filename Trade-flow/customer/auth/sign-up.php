<?php require_once __DIR__ . '/../../config/connection.php'; ?>

<?php
// DECLARATION OF VARIABLES
$firstName = trim($_POST['firstName']);
$lastName = trim($_POST['lastName']);
$emailAddress = trim($_POST['emailAddress']);
$phoneNumber = trim($_POST['phoneNumber']);
$address = $_POST['address'];
$password = $_POST['password'];

if ($firstName == '') {
    $response = [
        'success' => false,
        'message' => "FIRST NAME IS REQUIRED, Kindly fill in your first name to continue"
    ];
    goto end;
}

if ($lastName == '') {
    $response = [
        'success' => false,
        'message' => "LAST NAME IS REQUIRED, Kindly fill in your last name to continue"
    ];
    goto end;
}

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

if ($phoneNumber == '') {
    $response = [
        'success' => false,
        'message' => "PHONE NUMBER IS REQUIRED, Kindly fill in your phone number to continue"
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

if ($address == '') {
    $response = [
        'success' => false,
        'message' => "ADDRESS IS REQUIRED, Kindly fill in your address to continue"
    ];
    goto end;
}

$emailCheck = mysqli_query($conn, "SELECT * FROM customer_tab WHERE email_address = '$emailAddress'") or die(mysqli_error($conn));
if (mysqli_num_rows($emailCheck) > 0) {
    $response = [
        'success' => false,
        'message' => "EMAIL ADDRESS ALREADY EXISTS! Kindly proceed to sign in or forget password"
    ];
    goto end;
}

$customerId = 'CUST' . date("YmdHis");
$hashPassword = md5($password);

mysqli_query($conn, "INSERT INTO `customer_tab` 
    (`customer_id`, `title_id`, `first_name`, `last_name`, `email_address`, `phone_number`, `address`, `password`, `status_id`, `role_id`, `created_at`, `updated_at`) VALUES 
    ('$customerId', 0, '$firstName', '$lastName', '$emailAddress', '$phoneNumber', '$address', '$hashPassword', 1, 19, NOW(), NOW())") or die(mysqli_error($conn));

$createCustomerQuery = mysqli_query($conn, "SELECT * FROM customer_tab WHERE email_address = '$emailAddress'") or die(mysqli_error($conn));
$customerData = mysqli_fetch_assoc($createCustomerQuery);

$response = [
    'success' => true,
    'message' => "CUSTOMER SIGN UP SUCCESSFUL",
    'data' => [
        'customerId' => $customerData['customer_id'],
        'firstName' => $customerData['first_name'],
        'lastName' => $customerData['last_name'],
        'emailAddress' => $customerData['email_address'],
        'phoneNumber' => $customerData['phone_number'],
        'address' => $customerData['address'],
        'lastLoginDate' => $customerData['last_login_date'],
        'createdAt' => $customerData['created_at'],
        'updatedAt' => $customerData['updated_at']
    ]
];

end:
echo json_encode($response);
?>
