<?php require_once __DIR__ . '/../config/connection.php'; ?>

<?php

$paymentMethodIds =  $_POST['paymentMethodIds'] ?? '';

if ($paymentMethodIds === '') {
    $query = "SELECT * FROM payment_method_tab";
}else {
    $query = "SELECT * FROM payment_method_tab WHERE payment_method_id IN ($paymentMethodIds)";
}
$fetchAllStatusQuery = mysqli_query($conn, $query) or die(mysqli_error($conn));

if (mysqli_num_rows($fetchAllStatusQuery) == 0) {
    $response = [
        'success' => false,
        'message' => 'NO PAYMENT METHODS FOUND'
    ];
    goto end;
}

$fetchData = mysqli_fetch_all($fetchAllStatusQuery, MYSQLI_ASSOC);

$response = [
    'success' => true,
    'message' => "PAYMENT METHODS FETCHED SUCCESSFULLY",
    'data' => $fetchData
];

end:
echo json_encode($response);
?>
