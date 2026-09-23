<?php require_once __DIR__ . '/../config/connection.php'; ?>

<?php

$fetchAllOrdersQuery = mysqli_query($conn, "SELECT order_tab.*, customer_tab.first_name, customer_tab.last_name, product_tab.product_name, status_tab.status_name FROM order_tab, customer_tab, product_tab, status_tab WHERE order_tab.customer_id = customer_tab.customer_id AND order_tab.product_id = product_tab.product_id AND order_tab.status_id = status_tab.status_id ORDER BY order_tab.created_at DESC") or die(mysqli_error($conn));

if (mysqli_num_rows($fetchAllOrdersQuery) == 0) {
    $response = [
        'success' => false,
        'message' => 'NO ORDERS FOUND'
    ];
    goto end;
}

$fetchData = mysqli_fetch_all($fetchAllOrdersQuery, MYSQLI_ASSOC);

$response = [
    'success' => true,
    'message' => "ORDERS FETCHED SUCCESSFULLY",
    'data' => $fetchData
];

end:
echo json_encode($response);
?>
