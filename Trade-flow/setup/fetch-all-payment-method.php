<?php require_once __DIR__ . '/../config/connection.php'; ?>

<?php

$fetchAllQuery = mysqli_query($conn, "SELECT * FROM payment_method_tab ORDER BY created_at DESC") or die(mysqli_error($conn));

if (mysqli_num_rows($fetchAllQuery) == 0) {
    $response = [
        'success' => false,
        'message' => 'NO PAYMENT METHODS FOUND'
    ];
    goto end;
}

$fetchData = mysqli_fetch_all($fetchAllQuery, MYSQLI_ASSOC);

$response = [
    'success' => true,
    'message' => "PAYMENT METHODS FETCHED SUCCESSFULLY",
    'data' => $fetchData
];

end:
echo json_encode($response);
?>
