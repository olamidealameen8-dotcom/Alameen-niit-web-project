<?php require_once __DIR__ . '/../config/connection.php'; ?>

<?php
// DECLARATION OF VARIABLES
$orderId = trim($_POST['orderId']);
$customerId = trim($_POST['customerId']);
$productId = trim($_POST['productId']);
$statusId = trim($_POST['statusId']);

if ($orderId == '') {
    $response = [
        'success' => false,
        'message' => "ORDER ID IS REQUIRED, Kindly fill in the order ID to continue"
    ];
    goto end;
}

if ($customerId == '') {
    $response = [
        'success' => false,
        'message' => "CUSTOMER ID IS REQUIRED, Kindly fill in the customer ID to continue"
    ];
    goto end;
}

if ($productId == '') {
    $response = [
        'success' => false,
        'message' => "PRODUCT ID IS REQUIRED, Kindly fill in the product ID to continue"
    ];
    goto end;
}

if ($statusId == '') {
    $response = [
        'success' => false,
        'message' => "STATUS ID IS REQUIRED, Kindly fill in the status ID to continue"
    ];
    goto end;
}

$checkOrderQuery = mysqli_query($conn, "SELECT * FROM order_tab WHERE order_id = '$orderId'") or die(mysqli_error($conn));
if (mysqli_num_rows($checkOrderQuery) == 0) {
    $response = [
        'success' => false,
        'message' => "ORDER NOT FOUND"
    ];
    goto end;
}

$checkCustomerQuery = mysqli_query($conn, "SELECT * FROM customer_tab WHERE customer_id = '$customerId'") or die(mysqli_error($conn));
if (mysqli_num_rows($checkCustomerQuery) == 0) {
    $response = [
        'success' => false,
        'message' => "INVALID CUSTOMER ID! Selected customer ID ($customerId) does not exist in customer_tab"
    ];
    goto end;
}

$checkProductQuery = mysqli_query($conn, "SELECT * FROM product_tab WHERE product_id = '$productId'") or die(mysqli_error($conn));
if (mysqli_num_rows($checkProductQuery) == 0) {
    $response = [
        'success' => false,
        'message' => "INVALID PRODUCT ID! Selected product ID ($productId) does not exist in product_tab"
    ];
    goto end;
}

$checkStatusQuery = mysqli_query($conn, "SELECT * FROM status_tab WHERE status_id = '$statusId'") or die(mysqli_error($conn));
if (mysqli_num_rows($checkStatusQuery) == 0) {
    $response = [
        'success' => false,
        'message' => "INVALID STATUS ID! Selected status ID ($statusId) does not exist in status_tab"
    ];
    goto end;
}

mysqli_query($conn, "UPDATE order_tab SET customer_id = '$customerId', product_id = '$productId', status_id = '$statusId', updated_at = NOW() WHERE order_id = '$orderId'") or die(mysqli_error($conn));

$fetchUpdatedOrder = mysqli_query($conn, "SELECT order_tab.*, customer_tab.first_name, customer_tab.last_name, product_tab.product_name, status_tab.status_name FROM order_tab, customer_tab, product_tab, status_tab WHERE order_tab.customer_id = customer_tab.customer_id AND order_tab.product_id = product_tab.product_id AND order_tab.status_id = status_tab.status_id AND order_tab.order_id = '$orderId'") or die(mysqli_error($conn));
$orderData = mysqli_fetch_assoc($fetchUpdatedOrder);

$response = [
    'success' => true,
    'message' => "ORDER UPDATED SUCCESSFULLY",
    'data' => [
        'orderId' => $orderData['order_id'],
        'customerId' => $orderData['customer_id'],
        'firstName' => $orderData['first_name'],
        'lastName' => $orderData['last_name'],
        'productId' => $orderData['product_id'],
        'productName' => $orderData['product_name'],
        'statusId' => $orderData['status_id'],
        'statusName' => $orderData['status_name'],
        'createdAt' => $orderData['created_at'],
        'updatedAt' => $orderData['updated_at']
    ]
];

end:
echo json_encode($response);
?>
