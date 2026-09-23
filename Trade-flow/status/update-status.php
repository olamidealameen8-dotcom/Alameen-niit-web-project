<?php require_once __DIR__ . '/../config/connection.php'; ?>

<?php

$statusId = trim($_POST['statusId']);
$statusName = trim($_POST['statusName']);

if ($statusId == '') {
    $response = [
        'success' => false,
        'message' => 'STATUS ID IS REQUIRED'
    ];
    goto end;
}

if ($statusName == '') {
    $response = [
        'success' => false,
        'message' => 'STATUS NAME IS REQUIRED'
    ];
    goto end;
}

$checkStatusQuery = mysqli_query($conn, "SELECT * FROM status_tab WHERE status_id = '$statusId'") or die(mysqli_error($conn));
if (mysqli_num_rows($checkStatusQuery) == 0) {
    $response = [
        'success' => false,
        'message' => 'STATUS NOT FOUND'
    ];
    goto end;
}

mysqli_query($conn, "UPDATE status_tab SET status_name = '$statusName', created_at = IFNULL(created_at, NOW()) WHERE status_id = '$statusId'") or die(mysqli_error($conn));

$fetchUpdatedStatus = mysqli_query($conn, "SELECT * FROM status_tab WHERE status_id = '$statusId'") or die(mysqli_error($conn));
$statusData = mysqli_fetch_assoc($fetchUpdatedStatus);

$response = [
    'success' => true,
    'message' => 'STATUS UPDATED SUCCESSFULLY',
    'data' => $statusData
];

end:
echo json_encode($response);
?>
