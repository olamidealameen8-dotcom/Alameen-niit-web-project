<?php require_once __DIR__ . '/../config/connection.php'; ?>

<?php
// DECLARATION OF VARIABLES
$firstName = trim($_POST['firstName']);
$lastName = trim($_POST['lastName']);
$emailAddress = trim($_POST['emailAddress']);
$password = trim($_POST['password']);
$roleId = trim($_POST['roleId']);
$statusId = '1';

if ($firstName == '') {
    $response = [
        'success' => false,
        'message' => "FIRST NAME IS REQUIRED, Kindly fill in the first name to continue"
    ];
    goto end;
}

if ($lastName == '') {
    $response = [
        'success' => false,
        'message' => "LAST NAME IS REQUIRED, Kindly fill in the last name to continue"
    ];
    goto end;
}

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

if ($password == '') {
    $response = [
        'success' => false,
        'message' => "PASSWORD IS REQUIRED, Kindly fill in the password to continue"
    ];
    goto end;
}

if ($roleId == '') {
    $response = [
        'success' => false,
        'message' => "ROLE ID IS REQUIRED, Kindly fill in the role ID to continue"
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

$roleCheck = mysqli_query($conn, "SELECT * FROM role_tab WHERE role_id = '$roleId'") or die(mysqli_error($conn));
if (mysqli_num_rows($roleCheck) == 0) {
    $response = [
        'success' => false,
        'message' => "INVALID ROLE ID! Selected role does not exist"
    ];
    goto end;
}

$customerId = 'CUST' . date("YmdHis");
$hashPassword = md5($password);

mysqli_query($conn, "INSERT INTO `customer_tab` (`customer_id`, `first_name`, `last_name`, `email_address`, `password`, `status_id`, `role_id`, `created_at`, `updated_at`) VALUES ('$customerId', '$firstName', '$lastName', '$emailAddress', '$hashPassword', '$statusId', '$roleId', NOW(), NOW())") or die(mysqli_error($conn));

$createCustomerQuery = mysqli_query($conn, "SELECT customer_tab.*, role_tab.role_name, status_tab.status_name FROM customer_tab, role_tab, status_tab WHERE customer_tab.role_id = role_tab.role_id AND customer_tab.status_id = status_tab.status_id AND customer_tab.email_address = '$emailAddress'") or die(mysqli_error($conn));
$customerData = mysqli_fetch_assoc($createCustomerQuery);

$response = [
    'success' => true,
    'message' => "CUSTOMER SIGN UP SUCCESSFUL",
    'data' => [
        'customerId' => $customerData['customer_id'],
        'firstName' => $customerData['first_name'],
        'lastName' => $customerData['last_name'],
        'emailAddress' => $customerData['email_address'],
        'statusId' => $customerData['status_id'],
        'statusName' => $customerData['status_name'],
        'roleId' => $customerData['role_id'],
        'roleName' => $customerData['role_name'],
        'lastLoginDate' => $customerData['last_login_date'] ?? null,
        'createdAt' => $customerData['created_at'],
        'updatedAt' => $customerData['updated_at']
    ]
];

end:
echo json_encode($response);
?>
