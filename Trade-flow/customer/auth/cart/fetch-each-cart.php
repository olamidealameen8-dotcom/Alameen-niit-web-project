<?php require_once __DIR__ . '/../../../config/connection.php'; ?>

<?php

$cartId = trim($_POST['cartId']);

if ($cartId == '') {
    $response = [
        'success' => false,
        'message' => 'CART ID IS REQUIRED, Kindly fill in the cart ID to continue'
    ];
    goto end;
}

$checkCartQuery = mysqli_query($conn, "SELECT cart_tab.*, product_tab.product_name, status_tab.status_name FROM cart_tab, product_tab, status_tab WHERE cart_tab.product_id = product_tab.product_id AND cart_tab.status_id = status_tab.status_id AND cart_tab.cart_id = '$cartId'") or die(mysqli_error($conn));

if (mysqli_num_rows($checkCartQuery) == 0) {
    $response = [
        'success' => false,
        'message' => 'CART NOT FOUND'
    ];
    goto end;
}

$cartData = mysqli_fetch_assoc($checkCartQuery);

$response = [
    'success' => true,
    'message' => "CART FETCHED SUCCESSFULLY",
    'data' => $cartData
];

end:
echo json_encode($response);
?>
