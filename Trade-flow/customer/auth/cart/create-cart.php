<?php require_once __DIR__ . '/../../../config/connection.php'; ?>

<?php
// DECLARATION OF VARIABLES
$productId = trim($_POST['productId']);
$customerId = trim($_POST['customerId']);
$sessionId = trim($_POST['sessionId']);
$quantity = trim($_POST['quantity']);
$price = trim($_POST['price']);
$statusId = trim($_POST['statusId']);

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

if ($statusId == '') {
    $statusId = 11; 
}

$checkProductQuery = mysqli_query($conn, "SELECT * FROM product_tab WHERE product_id = '$productId'") or die(mysqli_error($conn));
if (mysqli_num_rows($checkProductQuery) == 0) {
    $response = [
        'success' => false,
        'message' => "INVALID PRODUCT ID! Selected product ID does not exist in product_tab"
    ];
    goto end;
}
$productData = mysqli_fetch_assoc($checkProductQuery);

if ($price == '') {
    $price = $productData['price'] ?? 0;
}


if ($customerId != '') {
    $checkCustomerQuery = mysqli_query($conn, "SELECT * FROM customer_tab WHERE customer_id = '$customerId'") or die(mysqli_error($conn));
    if (mysqli_num_rows($checkCustomerQuery) == 0) {
        $response = [
            'success' => false,
            'message' => "INVALID CUSTOMER ID! Selected customer ID does not exist in customer_tab"
        ];
        goto end;
    }
}

$checkStatusQuery = mysqli_query($conn, "SELECT * FROM status_tab WHERE status_id = '$statusId'") or die(mysqli_error($conn));
if (mysqli_num_rows($checkStatusQuery) == 0) {
    $response = [
        'success' => false,
        'message' => "INVALID STATUS ID! Selected status ID does not exist in status_tab"
    ];
    goto end;
}


$checkExistingCart = mysqli_query($conn, "SELECT * FROM `cart_tab` WHERE `product_id` = '$productId' AND `session_id` = '$sessionId'") or die(mysqli_error($conn));
if ($customerId != '') {
    $checkExistingCart = mysqli_query($conn, "SELECT * FROM `cart_tab` WHERE `product_id` = '$productId' AND (`customer_id` = '$customerId' OR `session_id` = '$sessionId')") or die(mysqli_error($conn));
}

if (mysqli_num_rows($checkExistingCart) > 0) {
    $existingCartData = mysqli_fetch_assoc($checkExistingCart);
    $cartId = $existingCartData['cart_id'];

    $updateCustomerClause = "";
    if ($customerId != '') {
        $updateCustomerClause = ", `customer_id` = '$customerId'";
    }

    mysqli_query($conn, "UPDATE `cart_tab` SET `quantity` = `quantity` + $quantity, `status_id` = '$statusId' $updateCustomerClause WHERE `cart_id` = '$cartId'") or die(mysqli_error($conn));
    $message = "CART QUANTITY UPDATED SUCCESSFULLY";
}


if (mysqli_num_rows($checkExistingCart) == 0) {
    $cartId = 'CART' . date("YmdHis");

    mysqli_query($conn, "INSERT INTO `cart_tab` (`cart_id`, `product_id`, `customer_id`, `session_id`, `quantity`, `price`, `status_id`, `created_at`) VALUES ('$cartId', '$productId', '$customerId', '$sessionId', '$quantity', '$price', '$statusId', NOW())") or die(mysqli_error($conn));
    $message = "CART CREATED SUCCESSFULLY";
}


$fetchCartQuery = mysqli_query($conn, "SELECT cart_tab.*, product_tab.product_name, status_tab.status_name FROM cart_tab, product_tab, status_tab WHERE cart_tab.product_id = product_tab.product_id AND cart_tab.status_id = status_tab.status_id AND cart_tab.cart_id = '$cartId'") or die(mysqli_error($conn));
$cartData = mysqli_fetch_assoc($fetchCartQuery);

$response = [
    'success' => true,
    'message' => $message,
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