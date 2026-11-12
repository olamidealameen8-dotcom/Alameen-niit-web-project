<?php require_once __DIR__ . '/../../config/connection.php'; ?>
<?php require_once __DIR__ . '/../../config/upload-helper.php'; ?>

<?php
// DECLARATION OF VARIABLES
$customerId = trim($_POST['customerId']);
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

if ($customerId == '') {
    $response = [
        'success' => false,
        'message' => 'CUSTOMER ID IS REQUIRED'
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

$currentCustomer = mysqli_fetch_assoc($checkCustomerQuery);

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

// Preserve existing profile image if none was provided
if ($profileImage == '') {
    $profileImage = isset($currentCustomer['profile_image']) ? $currentCustomer['profile_image'] : '';
}

// Split full name if provided
if ($fullName != '' && $firstName == '' && $lastName == '') {
    $nameParts = explode(' ', $fullName, 2);
    $firstName = $nameParts[0];
    $lastName = isset($nameParts[1]) ? $nameParts[1] : '';
}

if ($firstName == '') {
    $firstName = $currentCustomer['first_name'];
}
if ($lastName == '') {
    $lastName = $currentCustomer['last_name'];
}
if ($titleId == '') {
    $titleId = $currentCustomer['title_id'];
}
if ($emailAddress == '') {
    $emailAddress = $currentCustomer['email_address'];
}
if ($phoneNumber == '') {
    $phoneNumber = $currentCustomer['phone_number'];
}
if ($address == '') {
    $address = $currentCustomer['address'];
}
if ($roleId == '') {
    $roleId = $currentCustomer['role_id'];
}
if ($statusId == '') {
    $statusId = $currentCustomer['status_id'];
}

if (!filter_var($emailAddress, FILTER_VALIDATE_EMAIL)) {
    $response = [
        'success' => false,
        'message' => "INVALID EMAIL ADDRESS! Enter a valid email address and try again"
    ];
    goto end;
}

$emailCheck = mysqli_query($conn, "SELECT * FROM customer_tab WHERE email_address = '$emailAddress' AND customer_id != '$customerId' LIMIT 1") or die(mysqli_error($conn));
if (mysqli_num_rows($emailCheck) > 0) {
    $response = [
        'success' => false,
        'message' => "EMAIL ALREADY EXIST! This email $emailAddress is already registered. Kindly use another email address to continue"
    ];
    goto end;
}

$escapedAddress = mysqli_real_escape_string($conn, $address);
$escapedProfileImage = mysqli_real_escape_string($conn, $profileImage);

mysqli_query($conn, "UPDATE customer_tab SET 
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
WHERE customer_id = '$customerId'") or die(mysqli_error($conn));

$fetchUpdatedCustomer = mysqli_query($conn, "SELECT customer_tab.*, title_tab.title_name, role_tab.role_name, status_tab.status_name FROM customer_tab 
    LEFT JOIN title_tab ON customer_tab.title_id = title_tab.title_id 
    LEFT JOIN role_tab ON customer_tab.role_id = role_tab.role_id 
    LEFT JOIN status_tab ON customer_tab.status_id = status_tab.status_id 
    WHERE customer_tab.customer_id = '$customerId'") or die(mysqli_error($conn));
$customerData = mysqli_fetch_assoc($fetchUpdatedCustomer);

$response = [
    'success' => true,
    'message' => 'CUSTOMER PROFILE UPDATED SUCCESSFULLY',
    'data' => [
        'customerId' => $customerData['customer_id'],
        'titleId' => $customerData['title_id'],
        'titleName' => $customerData['title_name'],
        'firstName' => $customerData['first_name'],
        'lastName' => $customerData['last_name'],
        'fullName' => trim($customerData['first_name'] . ' ' . $customerData['last_name']),
        'emailAddress' => $customerData['email_address'],
        'phoneNumber' => $customerData['phone_number'],
        'address' => $customerData['address'],
        'profileImage' => $customerData['profile_image'],
        'imageUrl' => $customerData['profile_image'],
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
