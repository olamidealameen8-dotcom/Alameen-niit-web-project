<?php require_once __DIR__ . '/../../config/connection.php'; ?>

<?php
// DECLARATION OF VARIABLES
$staffId = trim($_POST['staffId']);
$titleId = trim($_POST['titleId']);
$firstName = trim($_POST['firstName']);
$lastName = trim($_POST['lastName']);
$emailAddress = trim($_POST['emailAddress']);
$phoneNumber = trim($_POST['phoneNumber']);
$address = trim($_POST['address']);
$roleId = trim($_POST['roleId']);
$statusId = trim($_POST['statusId']);

// STAFF ID VALIDATION
if ($staffId == '') {
    $response = [
        'success' => false,
        'message' => 'STAFF ID IS REQUIRED'
    ];
    goto end;
}

$checkStaffQuery = mysqli_query($conn, "SELECT * FROM staff_tab WHERE staff_id = '$staffId'") or die(mysqli_error($conn));
if (mysqli_num_rows($checkStaffQuery) == 0) {
    $response = [
        'success' => false,
        'message' => 'STAFF NOT FOUND'
    ];
    goto end;
}

// TITLE VALIDATION
if ($titleId == '') {
    $response = [
        'success' => false,
        'message' => 'TITLE ID IS REQUIRED'
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

// FIRST NAME VALIDATION
if ($firstName == '') {
    $response = [
        'success' => false,
        'message' => 'FIRST NAME IS REQUIRED'
    ];
    goto end;
}

// LAST NAME VALIDATION
if ($lastName == '') {
    $response = [
        'success' => false,
        'message' => 'LAST NAME IS REQUIRED'
    ];
    goto end;
}

// EMAIL VALIDATION
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

$emailCheck = mysqli_query($conn, "SELECT * FROM staff_tab WHERE email_address = '$emailAddress' AND staff_id != '$staffId' LIMIT 1") or die(mysqli_error($conn));
if (mysqli_num_rows($emailCheck) > 0) {
    $response = [
        'success' => false,
        'message' => "EMAIL ALREADY EXIST!! This email $emailAddress is already used by someone. Kindly use another email address to continue"
    ];
    goto end;
}

// PHONE NUMBER VALIDATION
if ($phoneNumber == '') {
    $response = [
        'success' => false,
        'message' => 'PHONE NUMBER IS REQUIRED'
    ];
    goto end;
}

// ADDRESS VALIDATION
if ($address == '') {
    $response = [
        'success' => false,
        'message' => 'ADDRESS IS REQUIRED'
    ];
    goto end;
}

// ROLE VALIDATION
if ($roleId == '') {
    $response = [
        'success' => false,
        'message' => 'ROLE ID IS REQUIRED'
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

// STATUS VALIDATION
if ($statusId == '') {
    $response = [
        'success' => false,
        'message' => 'STATUS ID IS REQUIRED'
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

mysqli_query($conn, "UPDATE staff_tab SET title_id = '$titleId', first_name = '$firstName', last_name = '$lastName', email_address = '$emailAddress', phone_number = '$phoneNumber', address = '$address', role_id = '$roleId', status_id = '$statusId', updated_at = NOW() WHERE staff_id = '$staffId'") or die(mysqli_error($conn));

$fetchUpdatedStaff = mysqli_query($conn, "SELECT staff_tab.*, title_tab.title_name, role_tab.role_name, status_tab.status_name FROM staff_tab, title_tab, role_tab, status_tab WHERE staff_tab.title_id = title_tab.title_id AND staff_tab.role_id = role_tab.role_id AND staff_tab.status_id = status_tab.status_id AND staff_tab.staff_id = '$staffId'") or die(mysqli_error($conn));
$staffData = mysqli_fetch_assoc($fetchUpdatedStaff);

$response = [
    'success' => true,
    'message' => 'STAFF UPDATED SUCCESSFULLY',
    'data' => [
        'staffId' => $staffData['staff_id'],
        'titleId' => $staffData['title_id'],
        'titleName' => $staffData['title_name'],
        'firstName' => $staffData['first_name'],
        'lastName' => $staffData['last_name'],
        'emailAddress' => $staffData['email_address'],
        'phoneNumber' => $staffData['phone_number'],
        'address' => $staffData['address'],
        'statusId' => $staffData['status_id'],
        'statusName' => $staffData['status_name'],
        'roleId' => $staffData['role_id'],
        'roleName' => $staffData['role_name'],
        'createdAt' => $staffData['created_at'],
        'updatedAt' => $staffData['updated_at']
    ]
];

end:
echo json_encode($response);
?>
