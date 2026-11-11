<?php require_once __DIR__ . '/../../config/connection.php'; ?>

<?php
// DECLARATION OF VARIABLES
$productId = trim($_POST['productId']);
$customerId = trim($_POST['customerId']);
$sessionId = trim($_POST['sessionId']);
$quantity = trim($_POST['quantity']);

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

if ($quantity == '') {
    $response = [
        'success' => false,
        'message' => "QUANTITY IS REQUIRED, Kindly fill in the quantity to continue"
    ];
    goto end;
}

// Check product exists — fetch price and status automatically from product
$checkProductQuery = mysqli_query($conn, "SELECT * FROM product_tab WHERE product_id = '$productId'") or die(mysqli_error($conn));
if (mysqli_num_rows($checkProductQuery) == 0) {
    $response = [
        'success' => false,
        'message' => "INVALID PRODUCT ID! Selected product ID does not exist in product_tab"
    ];
    goto end;
}

// ✅ Price and status fetched directly from product — no need to send them in the request
$productData = mysqli_fetch_assoc($checkProductQuery);
$price = $productData['product_price'];
$statusId = $productData['status_id'];

$checkCustomerQuery = mysqli_query($conn, "SELECT * FROM customer_tab WHERE customer_id = '$customerId'") or die(mysqli_error($conn));
if (mysqli_num_rows($checkCustomerQuery) == 0) {
    $response = [
        'success' => false,
        'message' => "INVALID CUSTOMER ID! Selected customer ID does not exist in customer_tab"
    ];
    goto end;
}

$cartId = 'CART' . date("YmdHis");

mysqli_query($conn, "INSERT INTO `cart_tab` (`cart_id`, `product_id`, `customer_id`, `session_id`, `quantity`, `price`, `status_id`, `created_at`) VALUES ('$cartId', '$productId', '$customerId', '$sessionId', '$quantity', '$price', '$statusId', NOW())") or die(mysqli_error($conn));

$fetchCartQuery = mysqli_query($conn, "SELECT cart_tab.*, product_tab.product_name, product_tab.product_price, status_tab.status_name FROM cart_tab, product_tab, status_tab WHERE cart_tab.product_id = product_tab.product_id AND cart_tab.status_id = status_tab.status_id AND cart_tab.cart_id = '$cartId'") or die(mysqli_error($conn));
$cartData = mysqli_fetch_assoc($fetchCartQuery);

$response = [
    'success' => true,
    'message' => "CART CREATED SUCCESSFULLY",
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
