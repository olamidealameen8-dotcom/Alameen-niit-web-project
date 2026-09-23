<?php require_once __DIR__ . '/../config/connection.php'; ?>

<?php

$fetchAllStatusQuery = mysqli_query($conn, "SELECT * FROM status_tab ORDER BY created_at DESC") or die(mysqli_error($conn));

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
