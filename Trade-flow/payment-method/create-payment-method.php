<?php require_once __DIR__ . '/../config/connection.php'; ?>

<?php
// DECLARATION OF VARIABLES
$paymentMethodName = trim($_POST['paymentMethodName']);

if ($paymentMethodName == '') {
    $response = [
        'success' => false,
        'message' => "PAYMENT METHOD NAME IS REQUIRED, Kindly fill in the payment method name to continue"
    ];
    goto end;
}

$checkPaymentMethod = mysqli_query($conn, "SELECT * FROM payment_method_tab WHERE payment_method_name = '$paymentMethodName'") or die(mysqli_error($conn));
if (mysqli_num_rows($checkPaymentMethod) > 0) {
    $response = [
        'success' => false,
        'message' => "PAYMENT METHOD NAME ALREADY EXISTS! Kindly use a different name"
    ];
    goto end;
}

// Generate payment_method_id or get next numeric id
$maxIdQuery = mysqli_query($conn, "SELECT MAX(payment_method_id) AS max_id FROM payment_method_tab") or die(mysqli_error($conn));
$maxIdRow = mysqli_fetch_assoc($maxIdQuery);
$paymentMethodId = ($maxIdRow['max_id'] !== null) ? $maxIdRow['max_id'] + 1 : 1;

mysqli_query($conn, "INSERT INTO `payment_method_tab` (`payment_method_id`, `payment_method_name`, `created_at`, `updated_at`) VALUES ('$paymentMethodId', '$paymentMethodName', NOW(), NOW())") or die(mysqli_error($conn));

$fetchQuery = mysqli_query($conn, "SELECT * FROM payment_method_tab WHERE payment_method_id = '$paymentMethodId'") or die(mysqli_error($conn));
$data = mysqli_fetch_assoc($fetchQuery);

$response = [
    'success' => true,
    'message' => "PAYMENT METHOD CREATED SUCCESSFULLY",
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
