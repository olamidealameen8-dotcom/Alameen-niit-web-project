<?php require_once __DIR__ . '/../config/connection.php'; ?>

<?php

$roleIds =  $_POST['roleIds'] ?? '';

if ($roleIds === '') {
    $query = "SELECT * FROM role_tab";
}else {
    $query = "SELECT * FROM role_tab WHERE role_id IN ($roleIds)";
}
$fetchAllRoleQuery = mysqli_query($conn, $query) or die(mysqli_error($conn));

if (mysqli_num_rows($fetchAllRoleQuery) == 0) {
    $response = [
        'success' => false,
        'message' => 'NO ROLES FOUND'
    ];
    goto end;
}

$fetchData = mysqli_fetch_all($fetchAllRoleQuery, MYSQLI_ASSOC);

$response = [
    'success' => true,
    'message' => "ROLES FETCHED SUCCESSFULLY",
    'data' => $fetchData
];

end:
echo json_encode($response);
?>
