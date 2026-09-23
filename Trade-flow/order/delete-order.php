<?php require_once __DIR__ . '/../config/connection.php'; ?>

<?php

$orderId = trim($_POST['orderId']);

if ($orderId == '') {
    $response = [
        'success' => false,
        'message' => 'ORDER ID IS REQUIRED'
    ];
    goto end;
}

$checkOrderQuery = mysqli_query($conn, "SELECT * FROM order_tab WHERE order_id = '$orderId'") or die(mysqli_error($conn));
if (mysqli_num_rows($checkOrderQuery) == 0) {
    $response = [
        'success' => false,
        'message' => 'ORDER NOT FOUND'
    ];
    goto end;
}

mysqli_query($conn, "DELETE FROM order_tab WHERE order_id = '$orderId'") or die(mysqli_error($conn));

$response = [
    'success' => true,
    'message' => 'ORDER DELETED SUCCESSFULLY'
];

end:
echo json_encode($response);
?>
