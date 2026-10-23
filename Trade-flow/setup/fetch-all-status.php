<?php require_once __DIR__ . '/../config/connection.php'; ?>

<?php

$statusIds =  $_POST['statusIds'] ?? '';

if ($statusIds === '') {
    $query = "SELECT * FROM status_tab";
}else {
    $query = "SELECT * FROM status_tab WHERE status_id IN ($statusIds)";
}
$fetchAllStatusQuery = mysqli_query($conn, $query) or die(mysqli_error($conn));

if (mysqli_num_rows($fetchAllStatusQuery) == 0) {
    $response = [
        'success' => false,
        'message' => 'NO STATUSES FOUND'
    ];
    goto end;
}

$fetchData = mysqli_fetch_all($fetchAllStatusQuery, MYSQLI_ASSOC);

$response = [
    'success' => true,
    'message' => "STATUSES FETCHED SUCCESSFULLY",
    'data' => $fetchData
];

end:
echo json_encode($response);
?>
