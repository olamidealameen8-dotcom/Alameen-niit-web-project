<?php require_once __DIR__ . '/../../config/connection.php'; ?>

<?php
// DECLARATION OF VARIABLES
$customerId = trim($_POST['customerId']);
$titleId = trim($_POST['titleId']);
$firstName = trim($_POST['firstName']);
$lastName = trim($_POST['lastName']);
$emailAddress = trim($_POST['emailAddress']);
$phoneNumber = trim($_POST['phoneNumber']);
$address = $_POST['address'];
$roleId = trim($_POST['roleId']);
$statusId = trim($_POST['statusId']);

if ($customerId == '') {
    $response = [
        'success' => false,
        'message' => 'CUSTOMER ID IS REQUIRED'
    ];
    goto end;
}

if ($titleId == '') {
    $response = [
        'success' => false,
        'message' => 'TITLE ID IS REQUIRED'
    ];
    goto end;
}

if ($firstName == '') {
    $response = [
        'success' => false,
        'message' => 'FIRST NAME IS REQUIRED'
    ];
    goto end;
}

if ($lastName == '') {
    $response = [
        'success' => false,
        'message' => 'LAST NAME IS REQUIRED'
    ];
    goto end;
}

if ($emailAddress == '') {
    $response = [
        'success' => false,
        'message' => 'EMAIL ADDRESS IS REQUIRED'
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
        'message' => 'PHONE NUMBER IS REQUIRED'
    ];
    goto end;
}

if ($address == '') {
    $response = [
        'success' => false,
        'message' => 'ADDRESS IS REQUIRED'
    ];
    goto end;
}

if ($roleId == '') {
    $response = [
        'success' => false,
        'message' => 'ROLE ID IS REQUIRED'
    ];
    goto end;
}

if ($statusId == '') {
    $response = [
        'success' => false,
        'message' => 'STATUS ID IS REQUIRED'
    ];
    goto end;
}

$checkCustomerQuery = mysqli_query($conn, "SELECT * FROM customer_tab WHERE customer_id = '$customerId'") or die(mysqli_error($conn));
if (mysqli_num_rows($checkCustomerQuery) == 0) {
    $response = [
        'success' => false,
        'message' => 'CUSTOMER NOT FOUND'
    ];
    goto end;
}

$checkTitleQuery = mysqli_query($conn, "SELECT * FROM title_tab WHERE title_id = '$titleId'") or die(mysqli_error($conn));
if (mysqli_num_rows($checkTitleQuery) == 0) {
    $response = [
        'success' => false,
        'message' => "INVALID TITLE ID! Selected title ID ($titleId) does not exist in title_tab"
    ];
    goto end;
}

$emailCheck = mysqli_query($conn, "SELECT * FROM customer_tab WHERE email_address = '$emailAddress' AND customer_id != '$customerId' LIMIT 1") or die(mysqli_error($conn));
if (mysqli_num_rows($emailCheck) > 0) {
    $response = [
        'success' => false,
        'message' => "EMAIL ALREADY EXISTS! This email ($emailAddress) is already in use by another customer"
    ];
    goto end;
}

$checkRoleQuery = mysqli_query($conn, "SELECT * FROM role_tab WHERE role_id = '$roleId'") or die(mysqli_error($conn));
if (mysqli_num_rows($checkRoleQuery) == 0) {
    $response = [
        'success' => false,
        'message' => "INVALID ROLE ID! Selected role ID ($roleId) does not exist in role_tab"
    ];
    goto end;
}

$checkStatusQuery = mysqli_query($conn, "SELECT * FROM status_tab WHERE status_id = '$statusId'") or die(mysqli_error($conn));
if (mysqli_num_rows($checkStatusQuery) == 0) {
    $response = [
        'success' => false,
        'message' => "INVALID STATUS ID! Selected status ID ($statusId) does not exist in status_tab"
    ];
    goto end;
}

mysqli_query($conn, "UPDATE customer_tab SET title_id = '$titleId', first_name = '$firstName', last_name = '$lastName', email_address = '$emailAddress', phone_number = '$phoneNumber', address = '$address', role_id = '$roleId', status_id = '$statusId', updated_at = NOW() WHERE customer_id = '$customerId'") or die(mysqli_error($conn));

$fetchUpdatedCustomer = mysqli_query($conn, "SELECT customer_tab.*, title_tab.title_name, role_tab.role_name, status_tab.status_name FROM customer_tab, title_tab, role_tab, status_tab WHERE customer_tab.title_id = title_tab.title_id AND customer_tab.role_id = role_tab.role_id AND customer_tab.status_id = status_tab.status_id AND customer_tab.customer_id = '$customerId'") or die(mysqli_error($conn));
$customerData = mysqli_fetch_assoc($fetchUpdatedCustomer);

$response = [
    'success' => true,
    'message' => 'CUSTOMER UPDATED SUCCESSFULLY',
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
