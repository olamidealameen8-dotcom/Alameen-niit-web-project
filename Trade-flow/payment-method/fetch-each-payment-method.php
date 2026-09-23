<?php require_once __DIR__ . '/../config/connection.php'; ?>

<?php

$paymentMethodId = trim($_POST['paymentMethodId']);

if ($paymentMethodId == '') {
    $response = [
        'success' => false,
        'message' => 'PAYMENT METHOD ID IS REQUIRED'
    ];
    goto end;
}

$checkQuery = mysqli_query($conn, "SELECT * FROM payment_method_tab WHERE payment_method_id = '$paymentMethodId'") or die(mysqli_error($conn));

if (mysqli_num_rows($checkQuery) == 0) {
    $response = [
        'success' => false,
        'message' => 'PAYMENT METHOD NOT FOUND'
    ];
    goto end;
}

$data = mysqli_fetch_assoc($checkQuery);

$response = [
    'success' => true,
    'message' => "PAYMENT METHOD FETCHED SUCCESSFULLY",
    'data' => $data
];

end:
echo json_encode($response);
?>
