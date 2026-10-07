<?php require_once __DIR__ . '/../../config/connection.php'; ?>

<?php
// DECLARATION OF VARIABLES
$customerId = trim($_POST['customerId']);

if ($customerId == '') {
    $response = [
        'success' => false,
        'message' => "CUSTOMER ID IS REQUIRED, Kindly fill in the customer ID to continue"
    ];
    goto end;
}

$fetchAllQuery = mysqli_query($conn, "SELECT cart_tab.*, status_tab.status_name FROM cart_tab, status_tab WHERE cart_tab.status_id = status_tab.status_id AND cart_tab.customer_id = '$customerId'") or die(mysqli_error($conn));
if (mysqli_num_rows($fetchAllQuery) == 0) {
    $fetchAllQuery = mysqli_query($conn, "SELECT * FROM cart_tab WHERE customer_id = '$customerId'") or die(mysqli_error($conn));
}

if (mysqli_num_rows($fetchAllQuery) == 0) {
    $response = [
        'success' => false,
        'message' => "NO CART RECORD FOUND! No cart items found for this customer"
    ];
    goto end;
}

$cartList = [];
while ($cartData = mysqli_fetch_assoc($fetchAllQuery)) {
    $cartList[] = [
        'sn' => $cartData['sn'],
        'cartId' => $cartData['cart_id'],
        'productId' => $cartData['product_id'],
        'customerId' => $cartData['customer_id'],
        'sessionId' => $cartData['session_id'],
        'price' => $cartData['price'],
        'statusId' => $cartData['status_id'],
        'statusName' => $cartData['status_name'] ?? '',
        'createdAt' => $cartData['created_at']
    ];
}

$response = [
    'success' => true,
    'message' => "CART RECORD FETCHED SUCCESSFUL",
    'data' => $cartList
];

end:
echo json_encode($response);
?>
