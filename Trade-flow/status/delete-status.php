<?php require_once __DIR__ . '/../config/connection.php'; ?>

<?php

$statusId = trim($_POST['statusId']);

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
        'message' => 'STATUS NOT FOUND'
    ];
    goto end;
}

mysqli_query($conn, "DELETE FROM status_tab WHERE status_id = '$statusId'") or die(mysqli_error($conn));

$response = [
    'success' => true,
    'message' => 'STATUS DELETED SUCCESSFULLY'
];

end:
echo json_encode($response);
?>
