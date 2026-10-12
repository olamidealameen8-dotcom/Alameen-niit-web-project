<?php require_once __DIR__ . '/../../../config/connection.php'; ?>

<?php

$cartId = trim($_POST['cartId']);

if ($cartId == '') {
    $response = [
        'success' => false,
        'message' => 'CART ID IS REQUIRED'
    ];
    goto end;
}

$checkCartQuery = mysqli_query($conn, "SELECT * FROM cart_tab WHERE cart_id = '$cartId'") or die(mysqli_error($conn));
if (mysqli_num_rows($checkCartQuery) == 0) {
    $response = [
        'success' => false,
        'message' => 'CART NOT FOUND'
    ];
    goto end;
}

mysqli_query($conn, "DELETE FROM cart_tab WHERE cart_id = '$cartId'") or die(mysqli_error($conn));

$response = [
    'success' => true,
    'message' => 'CART DELETED SUCCESSFULLY'
];

end:
echo json_encode($response);
?>
