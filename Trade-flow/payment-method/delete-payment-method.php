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

$checkPaymentMethodQuery = mysqli_query($conn, "SELECT * FROM payment_method_tab WHERE payment_method_id = '$paymentMethodId'") or die(mysqli_error($conn));
if (mysqli_num_rows($checkPaymentMethodQuery) == 0) {
    $response = [
        'success' => false,
        'message' => 'PAYMENT METHOD NOT FOUND'
    ];
    goto end;
}

mysqli_query($conn, "DELETE FROM payment_method_tab WHERE payment_method_id = '$paymentMethodId'") or die(mysqli_error($conn));

$response = [
    'success' => true,
    'message' => 'PAYMENT METHOD DELETED SUCCESSFULLY'
];

end:
echo json_encode($response);
?>
