<?php require_once __DIR__ . '/../config/connection.php'; ?>

<?php
// DECLARATION OF VARIABLES
$roleName = trim($_POST['roleName']);

if ($roleName == '') {
    $response = [
        'success' => false,
        'message' => "ROLE NAME IS REQUIRED, Kindly fill in the role name to continue"
    ];
    goto end;
}

$checkRoleQuery = mysqli_query($conn, "SELECT * FROM role_tab WHERE role_name = '$roleName'") or die(mysqli_error($conn));
if (mysqli_num_rows($checkRoleQuery) > 0) {
    $response = [
        'success' => false,
        'message' => "ROLE ALREADY EXISTS! Kindly enter a different role name"
    ];
    goto end;
}

$roleId = 'ROLE' . date("YmdHis");

mysqli_query($conn, "INSERT INTO `role_tab` (`role_id`, `role_name`, `created_at`) VALUES ('$roleId', '$roleName', NOW())") or die(mysqli_error($conn));

$fetchRoleQuery = mysqli_query($conn, "SELECT * FROM role_tab WHERE role_id = '$roleId'") or die(mysqli_error($conn));
$roleData = mysqli_fetch_assoc($fetchRoleQuery);

$response = [
    'success' => true,
    'message' => "ROLE CREATED SUCCESSFULLY",
    'data' => [
        'roleId' => $roleData['role_id'],
        'roleName' => $roleData['role_name'],
        'createdAt' => $roleData['created_at']
    ]
];

end:
echo json_encode($response);
?>
