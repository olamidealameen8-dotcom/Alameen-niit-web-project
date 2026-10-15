<?php require_once __DIR__ . '/../../config/connection.php'; ?>

<?php
// DECLARATION OF VARIABLES
$titleId = trim($_POST['titleId']);
$firstName = trim($_POST['firstName']);
$lastName = trim($_POST['lastName']);
$emailAddress = trim($_POST['emailAddress']);
$phoneNumber = trim($_POST['phoneNumber']);
$address = $_POST['address'];
$roleId = trim($_POST['roleId']);
$statusId = trim($_POST['statusId']);

if ($titleId == '') {
    $response = [
        'success' => false,
        'message' => "TITLE ID IS REQUIRED, Kindly fill in the title ID to continue"
    ];
    goto end;
}

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

if ($phoneNumber == '') {
    $response = [
        'success' => false,
        'message' => "PHONE NUMBER IS REQUIRED, Kindly fill in the phone number to continue"
    ];
    goto end;
}

if ($address == '') {
    $response = [
        'success' => false,
        'message' => "ADDRESS IS REQUIRED, Kindly fill in the address to continue"
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

if ($statusId == '') {
    $response = [
        'success' => false,
        'message' => "STATUS ID IS REQUIRED, Kindly fill in the status ID to continue"
    ];
    goto end;
}

$titleCheck = mysqli_query($conn, "SELECT * FROM title_tab WHERE title_id = '$titleId'") or die(mysqli_error($conn));
if (mysqli_num_rows($titleCheck) == 0) {
    $response = [
        'success' => false,
        'message' => "INVALID TITLE ID! Selected title ID does not exist in title_tab"
    ];
    goto end;
}

$emailCheck = mysqli_query($conn, "SELECT * FROM customer_tab WHERE email_address = '$emailAddress'") or die(mysqli_error($conn));
if (mysqli_num_rows($emailCheck) > 0) {
    $response = [
        'success' => false,
        'message' => "EMAIL ADDRESS ALREADY EXISTS! Kindly proceed to sign in or reset password"
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

$statusCheck = mysqli_query($conn, "SELECT * FROM status_tab WHERE status_id = '$statusId'") or die(mysqli_error($conn));
if (mysqli_num_rows($statusCheck) == 0) {
    $response = [
        'success' => false,
        'message' => "INVALID STATUS ID! Selected status does not exist"
    ];
    goto end;
}

$customerId = 'CUST' . date("YmdHis");


mysqli_query($conn, "INSERT INTO `customer_tab` 
    (`customer_id`, `title_id`, `first_name`, `last_name`, `email_address`, `phone_number`, `address`,  `status_id`, `role_id`, `created_at`, `updated_at`) VALUES 
    ('$customerId', '$titleId', '$firstName', '$lastName', '$emailAddress', '$phoneNumber', '$address',  '$statusId', '$roleId', NOW(), NOW())") or die(mysqli_error($conn));

$fetchCustomerQuery = mysqli_query($conn, "SELECT customer_tab.*, title_tab.title_name, role_tab.role_name, status_tab.status_name FROM customer_tab, title_tab, role_tab, status_tab WHERE customer_tab.title_id = title_tab.title_id AND customer_tab.role_id = role_tab.role_id AND customer_tab.status_id = status_tab.status_id AND customer_tab.customer_id = '$customerId'") or die(mysqli_error($conn));
$customerData = mysqli_fetch_assoc($fetchCustomerQuery);

$response = [
    'success' => true,
    'message' => "CUSTOMER CREATED SUCCESSFULLY",
    'data' => [
        'customerId' => $customerData['customer_id'],
        'titleId' => $customerData['title_id'],
        'titleName' => $customerData['title_name'],
        'firstName' => $customerData['first_name'],
        'lastName' => $customerData['last_name'],
        'emailAddress' => $customerData['email_address'],
        'phoneNumber' => $customerData['phone_number'],
        'address' => $customerData['address'],
        'statusId' => $customerData['status_id'],
        'statusName' => $customerData['status_name'],
        'roleId' => $customerData['role_id'],
        'roleName' => $customerData['role_name'],
        'createdAt' => $customerData['created_at'],
        'updatedAt' => $customerData['updated_at']
    ]
];

end:
echo json_encode($response);
?>
