<?php require_once __DIR__ . '/../config/connection.php'; ?>

<?php

$roleId = trim($_POST['roleId']);

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
        'message' => 'ROLE NOT FOUND'
    ];
    goto end;
}

$roleData = mysqli_fetch_assoc($checkRoleQuery);

$response = [
    'success' => true,
    'message' => "ROLE FETCHED SUCCESSFULLY",
    'data' => $roleData
];

end:
echo json_encode($response);
?>
