<?php require_once __DIR__ . '/../config/connection.php'; ?>

<?php

$roleId = trim($_POST['roleId']);
$roleName = trim($_POST['roleName']);

if ($roleId == '') {
    $response = [
        'success' => false,
        'message' => 'ROLE ID IS REQUIRED'
    ];
    goto end;
}

if ($roleName == '') {
    $response = [
        'success' => false,
        'message' => 'ROLE NAME IS REQUIRED'
    ];
    goto end;
}

$checkRoleQuery = mysqli_query($conn, "SELECT * FROM role_tab WHERE role_id = '$roleId'") or die(mysqli_error($conn));
if (mysqli_num_rows($checkRoleQuery) == 0) {
    $response = [
        'success' => false,
        'message' => 'ROLE NOT FOUND'
    ];
    goto end;
}

$duplicateCheck = mysqli_query($conn, "SELECT * FROM role_tab WHERE role_name = '$roleName' AND role_id != '$roleId'") or die(mysqli_error($conn));
if (mysqli_num_rows($duplicateCheck) > 0) {
    $response = [
        'success' => false,
        'message' => 'ROLE NAME ALREADY EXISTS'
    ];
    goto end;
}

mysqli_query($conn, "UPDATE role_tab SET role_name = '$roleName' WHERE role_id = '$roleId'") or die(mysqli_error($conn));

$fetchUpdatedRole = mysqli_query($conn, "SELECT * FROM role_tab WHERE role_id = '$roleId'") or die(mysqli_error($conn));
$roleData = mysqli_fetch_assoc($fetchUpdatedRole);

$response = [
    'success' => true,
    'message' => 'ROLE UPDATED SUCCESSFULLY',
    'data' => $roleData
];

end:
echo json_encode($response);
?>
