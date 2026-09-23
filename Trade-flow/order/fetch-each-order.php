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

$checkOrderQuery = mysqli_query($conn, "SELECT order_tab.*, customer_tab.first_name, customer_tab.last_name, product_tab.product_name, status_tab.status_name FROM order_tab, customer_tab, product_tab, status_tab WHERE order_tab.customer_id = customer_tab.customer_id AND order_tab.product_id = product_tab.product_id AND order_tab.status_id = status_tab.status_id AND order_tab.order_id = '$orderId'") or die(mysqli_error($conn));

if (mysqli_num_rows($checkOrderQuery) == 0) {
    $response = [
        'success' => false,
        'message' => 'ORDER NOT FOUND'
    ];
    goto end;
}

$orderData = mysqli_fetch_assoc($checkOrderQuery);

$response = [
    'success' => true,
    'message' => "ORDER FETCHED SUCCESSFULLY",
    'data' => $orderData
];

end:
echo json_encode($response);
?>
