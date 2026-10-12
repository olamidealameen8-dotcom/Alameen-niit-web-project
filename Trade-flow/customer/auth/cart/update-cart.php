<?php require_once __DIR__ . '/../../../config/connection.php'; ?>

<?php
// DECLARATION OF VARIABLES
$cartId = trim($_POST['cartId']);
$productId = trim($_POST['productId']);
$customerId = trim($_POST['customerId']);
$sessionId = trim($_POST['sessionId']);
$quantity = trim($_POST['quantity']);
$price = trim($_POST['price']);
$statusId = trim($_POST['statusId']);

if ($cartId == '') {
    $response = [
        'success' => false,
        'message' => "CART ID IS REQUIRED, Kindly fill in the cart ID to continue"
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

if ($sessionId == '') {
    $response = [
        'success' => false,
        'message' => "SESSION ID IS REQUIRED, Kindly fill in the session ID to continue"
    ];
    goto end;
}

if ($quantity == '' || $quantity <= 0) {
    $quantity = 1;
}

if ($price == '') {
    $response = [
        'success' => false,
        'message' => "PRICE IS REQUIRED, Kindly fill in the price to continue"
    ];
    goto end;
}

if ($statusId == '') {
    $statusId = 11; // 11 represents 'In Stock'
}

$checkCartQuery = mysqli_query($conn, "SELECT * FROM cart_tab WHERE cart_id = '$cartId'") or die(mysqli_error($conn));
if (mysqli_num_rows($checkCartQuery) == 0) {
    $response = [
        'success' => false,
        'message' => "CART NOT FOUND"
    ];
    goto end;
}

if ($customerId != '') {
    $checkCustomerQuery = mysqli_query($conn, "SELECT * FROM customer_tab WHERE customer_id = '$customerId'") or die(mysqli_error($conn));
    if (mysqli_num_rows($checkCustomerQuery) == 0) {
        $response = [
            'success' => false,
            'message' => "INVALID CUSTOMER ID! Selected customer ID ($customerId) does not exist in customer_tab"
        ];
        goto end;
    }
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

mysqli_query($conn, "UPDATE cart_tab SET product_id = '$productId', customer_id = '$customerId', session_id = '$sessionId', quantity = '$quantity', price = '$price', status_id = '$statusId' WHERE cart_id = '$cartId'") or die(mysqli_error($conn));

$fetchUpdatedCart = mysqli_query($conn, "SELECT cart_tab.*, product_tab.product_name, status_tab.status_name FROM cart_tab, product_tab, status_tab WHERE cart_tab.product_id = product_tab.product_id AND cart_tab.status_id = status_tab.status_id AND cart_tab.cart_id = '$cartId'") or die(mysqli_error($conn));
$cartData = mysqli_fetch_assoc($fetchUpdatedCart);

$response = [
    'success' => true,
    'message' => "CART UPDATED SUCCESSFULLY",
    'data' => [
        'cartId' => $cartData['cart_id'],
        'productId' => $cartData['product_id'],
        'productName' => $cartData['product_name'],
        'customerId' => $cartData['customer_id'],
        'sessionId' => $cartData['session_id'],
        'quantity' => $cartData['quantity'],
        'price' => $cartData['price'],
        'statusId' => $cartData['status_id'],
        'statusName' => $cartData['status_name'],
        'createdAt' => $cartData['created_at']
    ]
];

end:
echo json_encode($response);
?>
