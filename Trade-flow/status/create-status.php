<?php require_once __DIR__ . '/../config/connection.php'; ?>

<?php
// DECLARATION OF VARIABLES
$statusId = trim($_POST['statusId']);
$statusName = trim($_POST['statusName']);

if ($statusId == '') {
    $response = [
        'success' => false,
        'message' => "STATUS ID IS REQUIRED (e.g. A, I, P)"
    ];
    goto end;
}

if ($statusName == '') {
    $response = [
        'success' => false,
        'message' => "STATUS NAME IS REQUIRED"
    ];
    goto end;
}

$checkStatusQuery = mysqli_query($conn, "SELECT * FROM status_tab WHERE status_id = '$statusId'") or die(mysqli_error($conn));
if (mysqli_num_rows($checkStatusQuery) > 0) {
    $response = [
        'success' => false,
        'message' => "STATUS ID ALREADY EXISTS!"
    ];
    goto end;
}

mysqli_query($conn, "INSERT INTO `status_tab` (`status_id`, `status_name`, `created_at`) VALUES ('$statusId', '$statusName', NOW())") or die(mysqli_error($conn));

$fetchStatusQuery = mysqli_query($conn, "SELECT * FROM status_tab WHERE status_id = '$statusId'") or die(mysqli_error($conn));
$statusData = mysqli_fetch_assoc($fetchStatusQuery);

$response = [
    'success' => true,
    'message' => "STATUS CREATED SUCCESSFULLY",
    'data' => [
        'statusId' => $statusData['status_id'],
        'statusName' => $statusData['status_name'],
        'createdAt' => $statusData['created_at']
    ]
];

end:
echo json_encode($response);
?>
