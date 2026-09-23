<?php require_once __DIR__ . '/../config/connection.php'; ?>

<?php

$customerId = trim($_POST['customerId']);

if ($customerId == '') {
    $response = [
        'success' => false,
        'message' => 'CUSTOMER ID IS REQUIRED'
    ];
    goto end;
}

$checkCustomerQuery = mysqli_query($conn, "SELECT * FROM customer_tab WHERE customer_id = '$customerId'") or die(mysqli_error($conn));
if (mysqli_num_rows($checkCustomerQuery) == 0) {
    $response = [
        'success' => false,
        'message' => 'CUSTOMER NOT FOUND'
    ];
    goto end;
}

mysqli_query($conn, "DELETE FROM customer_tab WHERE customer_id = '$customerId'") or die(mysqli_error($conn));

$response = [
    'success' => true,
    'message' => 'CUSTOMER DELETED SUCCESSFULLY'
];

end:
echo json_encode($response);
?>
