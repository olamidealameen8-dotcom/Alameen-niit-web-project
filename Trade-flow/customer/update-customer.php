<?php require_once __DIR__ . '/../config/connection.php'; ?>

<?php
// DECLARATION OF VARIABLES
$customerId = trim($_POST['customerId']);
$firstName = trim($_POST['firstName']);
$lastName = trim($_POST['lastName']);
$emailAddress = trim($_POST['emailAddress']);
$roleId = trim($_POST['roleId']);
$statusId = trim($_POST['statusId']);

if ($customerId == '') {
    $response = [
        'success' => false,
        'message' => 'CUSTOMER ID IS REQUIRED'
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

mysqli_query($conn, "UPDATE customer_tab SET first_name = '$firstName', last_name = '$lastName', email_address = '$emailAddress', role_id = '$roleId', status_id = '$statusId', updated_at = NOW() WHERE customer_id = '$customerId'") or die(mysqli_error($conn));

$fetchUpdatedCustomer = mysqli_query($conn, "SELECT customer_tab.*, role_tab.role_name, status_tab.status_name FROM customer_tab, role_tab, status_tab WHERE customer_tab.role_id = role_tab.role_id AND customer_tab.status_id = status_tab.status_id AND customer_tab.customer_id = '$customerId'") or die(mysqli_error($conn));
$customerData = mysqli_fetch_assoc($fetchUpdatedCustomer);

$response = [
    'success' => true,
    'message' => 'CUSTOMER UPDATED SUCCESSFULLY',
    'data' => [
        'customerId' => $customerData['customer_id'],
        'firstName' => $customerData['first_name'],
        'lastName' => $customerData['last_name'],
        'emailAddress' => $customerData['email_address'],
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
