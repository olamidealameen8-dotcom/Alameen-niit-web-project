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

$statusData = mysqli_fetch_assoc($checkStatusQuery);

$response = [
    'success' => true,
    'message' => "STATUS FETCHED SUCCESSFULLY",
    'data' => $statusData
];

end:
echo json_encode($response);
?>
