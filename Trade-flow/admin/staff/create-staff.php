<?php require_once __DIR__ . '/../../config/connection.php'; ?>

<?php
// DECLARATION OF VARIABLES
$titleId = trim($_POST['titleId']);
$firstName = trim($_POST['firstName']);
$lastName = trim($_POST['lastName']);
$emailAddress = trim($_POST['emailAddress']);
$phoneNumber = trim($_POST['phoneNumber']);
$address = trim($_POST['address']);
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



$emailCheck = mysqli_query($conn, "SELECT * FROM staff_tab WHERE email_address = '$emailAddress' LIMIT 1") or die(mysqli_error($conn));
if (mysqli_num_rows($emailCheck) > 0) {
    $response = [
        "success" => false,
        "message" => "EMAIL ADDRESS ALREADY EXIST kindly proceed to sign in or forget password"
    ];
    goto end;
}


$staffId = 'STAFF' . date("Ymdhis");

mysqli_query($conn, "INSERT INTO `staff_tab`
    (`staff_id`, `title_id`, `first_name`, `last_name`, `email_address`, `phone_number`, `address`, `status_id`, `role_id`, `created_at`, `updated_at`) VALUES
    ('$staffId', '$titleId', '$firstName', '$lastName', '$emailAddress', '$phoneNumber', '$address', '$statusId', '$roleId', NOW(), NOW())") or die(mysqli_error($conn));

$fetchStaffQuery = mysqli_query($conn, "SELECT staff_tab.*, title_tab.title_name, role_tab.role_name, status_tab.status_name FROM staff_tab, title_tab, role_tab, status_tab 
WHERE staff_tab.title_id = title_tab.title_id AND staff_tab.role_id = role_tab.role_id AND staff_tab.status_id = status_tab.status_id 
AND staff_tab.email_address = '$emailAddress'") or die(mysqli_error($conn));


$staffData = mysqli_fetch_assoc($fetchStaffQuery);

if (!$staffData) {
    $response = [
        'success' => false,
        'message' => "STAFF CREATED BUT UNABLE TO RETRIEVE DETAILS"
    ];
    goto end;
}

$response = [
    'success' => true,
    'message' => "STAFF CREATED SUCCESSFUL",
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