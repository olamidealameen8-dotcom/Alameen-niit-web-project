<?php require_once __DIR__ . '/../../config/connection.php'; ?>

<?php
// DECLARATION OF VARIABLES
$cartId = trim($_POST['cartId']);

if ($cartId == '') {
    $response = [
        'success' => false,
        'message' => "CART ID IS REQUIRED, Kindly fill in the cart ID to continue"
    ];
    goto end;
}

$fetchEachQuery = mysqli_query($conn, "SELECT cart_tab.*, status_tab.status_name FROM cart_tab, status_tab WHERE cart_tab.status_id = status_tab.status_id AND cart_tab.cart_id = '$cartId'") or die(mysqli_error($conn));
if (mysqli_num_rows($fetchEachQuery) == 0) {
    $fetchEachQuery = mysqli_query($conn, "SELECT * FROM cart_tab WHERE cart_id = '$cartId'") or die(mysqli_error($conn));
}

if (mysqli_num_rows($fetchEachQuery) == 0) {
    $response = [
        'success' => false,
        'message' => "INVALID CART ID! Selected cart item does not exist"
    ];
    goto end;
}

$cartData = mysqli_fetch_assoc($fetchEachQuery);

$response = [
    'success' => true,
    'message' => "CART RECORD FETCHED SUCCESSFUL",
    'data' => [
        'sn' => $cartData['sn'],
        'cartId' => $cartData['cart_id'],
        'productId' => $cartData['product_id'],
        'customerId' => $cartData['customer_id'],
        'sessionId' => $cartData['session_id'],
        'price' => $cartData['price'],
        'statusId' => $cartData['status_id'],
        'statusName' => $cartData['status_name'] ?? '',
        'createdAt' => $cartData['created_at']
    ]
];

end:
echo json_encode($response);
?>
