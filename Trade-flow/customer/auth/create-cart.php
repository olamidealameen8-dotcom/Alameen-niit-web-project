<?php require_once __DIR__ . '/../../config/connection.php'; ?>

<?php
// DECLARATION OF VARIABLES
$productId = trim($_POST['productId']);
$customerId = trim($_POST['customerId']);
$sessionId = trim($_POST['sessionId']);
$price = trim($_POST['price']);
$statusId = trim($_POST['statusId']);

if ($productId == '') {
    $response = [
        'success' => false,
        'message' => "PRODUCT ID IS REQUIRED, Kindly fill in the product ID to continue"
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

if ($sessionId == '') {
    $response = [
        'success' => false,
        'message' => "SESSION ID IS REQUIRED, Kindly fill in the session ID to continue"
    ];
    goto end;
}

if ($price == '') {
    $response = [
        'success' => false,
        'message' => "PRICE IS REQUIRED, Kindly fill in the price to continue"
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

$cartId = 'CART' . date("Ymdhis");

mysqli_query($conn, "INSERT INTO `cart_tab` (`cart_id`, `product_id`, `customer_id`, `session_id`, `price`, `status_id`, `created_at`) VALUES ('$cartId', '$productId', '$customerId', '$sessionId', '$price', '$statusId', NOW())") or die(mysqli_error($conn));

$createCartQuery = mysqli_query($conn, "SELECT cart_tab.*, status_tab.status_name FROM cart_tab, status_tab WHERE cart_tab.status_id = status_tab.status_id AND cart_tab.cart_id = '$cartId'") or die(mysqli_error($conn));
if (mysqli_num_rows($createCartQuery) == 0) {
    $createCartQuery = mysqli_query($conn, "SELECT * FROM cart_tab WHERE cart_id = '$cartId'") or die(mysqli_error($conn));
}
$cartData = mysqli_fetch_assoc($createCartQuery);

$response = [
    'success' => true,
    'message' => "CART CREATED SUCCESSFUL",
    'data' => [
        'sn' => $cartData['sn'],
        'cartId' => $cartData['cart_id'],
        'productId' => $cartData['product_id'],
        'customerId' => $cartData['customer_id'],
        'sessionId' => $cartData['session_id'],
        'price' => $cartData['price'],
        'statusId' => $cartData['status_id'],
        'statusName' => $cartData['status_name'],
        'createdAt' => $cartData['created_at']
    ]
];

end:
echo json_encode($response);
?>
