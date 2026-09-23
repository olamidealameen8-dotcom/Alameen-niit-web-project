<?php require_once __DIR__ . '/../config/connection.php'; ?>

<?php
// DECLARATION OF VARIABLES
$paymentMethodId = trim($_POST['paymentMethodId']);
$paymentMethodName = trim($_POST['paymentMethodName']);

if ($paymentMethodId == '') {
    $response = [
        'success' => false,
        'message' => 'PAYMENT METHOD ID IS REQUIRED'
    ];
    goto end;
}

if ($paymentMethodName == '') {
    $response = [
        'success' => false,
        'message' => 'PAYMENT METHOD NAME IS REQUIRED'
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

$duplicateCheck = mysqli_query($conn, "SELECT * FROM payment_method_tab WHERE payment_method_name = '$paymentMethodName' AND payment_method_id != '$paymentMethodId'") or die(mysqli_error($conn));
if (mysqli_num_rows($duplicateCheck) > 0) {
    $response = [
        'success' => false,
        'message' => 'PAYMENT METHOD NAME ALREADY EXISTS! Kindly use a different name'
    ];
    goto end;
}

mysqli_query($conn, "UPDATE payment_method_tab SET payment_method_name = '$paymentMethodName', created_at = IFNULL(created_at, NOW()), updated_at = NOW() WHERE payment_method_id = '$paymentMethodId'") or die(mysqli_error($conn));

$fetchUpdated = mysqli_query($conn, "SELECT * FROM payment_method_tab WHERE payment_method_id = '$paymentMethodId'") or die(mysqli_error($conn));
$data = mysqli_fetch_assoc($fetchUpdated);

$response = [
    'success' => true,
    'message' => 'PAYMENT METHOD UPDATED SUCCESSFULLY',
    'data' => [
        'paymentMethodId' => $data['payment_method_id'],
        'paymentMethodName' => $data['payment_method_name'],
        'createdAt' => $data['created_at'],
        'updatedAt' => $data['updated_at']
    ]
];

end:
echo json_encode($response);
?>
