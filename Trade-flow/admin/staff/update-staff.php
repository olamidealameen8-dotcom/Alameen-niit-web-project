<?php require_once __DIR__ . '/../../config/connection.php'; ?>
<?php require_once __DIR__ . '/../../config/upload-helper.php'; ?>

<?php
// DECLARATION OF VARIABLES
$staffId = trim($_POST['staffId']);
$titleId = isset($_POST['titleId']) ? trim($_POST['titleId']) : '';
$firstName = isset($_POST['firstName']) ? trim($_POST['firstName']) : '';
$lastName = isset($_POST['lastName']) ? trim($_POST['lastName']) : '';
$fullName = isset($_POST['fullName']) ? trim($_POST['fullName']) : '';
$emailAddress = isset($_POST['emailAddress']) ? trim($_POST['emailAddress']) : '';
$phoneNumber = isset($_POST['phoneNumber']) ? trim($_POST['phoneNumber']) : '';
$address = isset($_POST['address']) ? trim($_POST['address']) : '';
$roleId = isset($_POST['roleId']) ? trim($_POST['roleId']) : '';
$statusId = isset($_POST['statusId']) ? trim($_POST['statusId']) : '';
$profileImage = isset($_POST['profileImage']) ? trim($_POST['profileImage']) : (isset($_POST['imageUrl']) ? trim($_POST['imageUrl']) : '');

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

$currentStaff = mysqli_fetch_assoc($checkStaffQuery);

// Handle direct file upload for profile image
if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $uploadResult = uploadImageFile($_FILES['image'], 'profiles');
    if (!$uploadResult['success']) {
        $response = $uploadResult;
        goto end;
    }
    $profileImage = $uploadResult['data']['imageUrl'];
} elseif (isset($_FILES['profileImage']) && $_FILES['profileImage']['error'] === UPLOAD_ERR_OK) {
    $uploadResult = uploadImageFile($_FILES['profileImage'], 'profiles');
    if (!$uploadResult['success']) {
        $response = $uploadResult;
        goto end;
    }
    $profileImage = $uploadResult['data']['imageUrl'];
}

// If no new image was uploaded or provided, preserve current image
if ($profileImage == '') {
    $profileImage = isset($currentStaff['profile_image']) ? $currentStaff['profile_image'] : '';
}

// Split full name if provided instead of first/last name
if ($fullName != '' && $firstName == '' && $lastName == '') {
    $nameParts = explode(' ', $fullName, 2);
    $firstName = $nameParts[0];
    $lastName = isset($nameParts[1]) ? $nameParts[1] : '';
}

// If first/last name still empty, retain existing
if ($firstName == '') {
    $firstName = $currentStaff['first_name'];
}
if ($lastName == '') {
    $lastName = $currentStaff['last_name'];
}

// Retain existing fields if not supplied in profile edit form
if ($titleId == '') {
    $titleId = $currentStaff['title_id'];
}
if ($emailAddress == '') {
    $emailAddress = $currentStaff['email_address'];
}
if ($phoneNumber == '') {
    $phoneNumber = $currentStaff['phone_number'];
}
if ($address == '') {
    $address = $currentStaff['address'];
}
if ($roleId == '') {
    $roleId = $currentStaff['role_id'];
}
if ($statusId == '') {
    $statusId = $currentStaff['status_id'];
}

// VALIDATIONS
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

$escapedAddress = mysqli_real_escape_string($conn, $address);
$escapedProfileImage = mysqli_real_escape_string($conn, $profileImage);

mysqli_query($conn, "UPDATE staff_tab SET 
    title_id = '$titleId', 
    first_name = '$firstName', 
    last_name = '$lastName', 
    email_address = '$emailAddress', 
    phone_number = '$phoneNumber', 
    address = '$escapedAddress', 
    profile_image = '$escapedProfileImage', 
    role_id = '$roleId', 
    status_id = '$statusId', 
    updated_at = NOW() 
WHERE staff_id = '$staffId'") or die(mysqli_error($conn));

$fetchUpdatedStaff = mysqli_query($conn, "SELECT staff_tab.*, title_tab.title_name, role_tab.role_name, status_tab.status_name FROM staff_tab 
    LEFT JOIN title_tab ON staff_tab.title_id = title_tab.title_id 
    LEFT JOIN role_tab ON staff_tab.role_id = role_tab.role_id 
    LEFT JOIN status_tab ON staff_tab.status_id = status_tab.status_id 
    WHERE staff_tab.staff_id = '$staffId'") or die(mysqli_error($conn));
$staffData = mysqli_fetch_assoc($fetchUpdatedStaff);

$response = [
    'success' => true,
    'message' => 'PROFILE UPDATED SUCCESSFULLY',
    'data' => [
        'staffId' => $staffData['staff_id'],
        'titleId' => $staffData['title_id'],
        'titleName' => $staffData['title_name'],
        'firstName' => $staffData['first_name'],
        'lastName' => $staffData['last_name'],
        'fullName' => trim($staffData['first_name'] . ' ' . $staffData['last_name']),
        'emailAddress' => $staffData['email_address'],
        'phoneNumber' => $staffData['phone_number'],
        'address' => $staffData['address'],
        'profileImage' => $staffData['profile_image'],
        'imageUrl' => $staffData['profile_image'],
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
