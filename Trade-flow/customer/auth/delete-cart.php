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

$cartCheck = mysqli_query($conn, "SELECT * FROM cart_tab WHERE cart_id = '$cartId'") or die(mysqli_error($conn));
if (mysqli_num_rows($cartCheck) == 0) {
    $response = [
        'success' => false,
        'message' => "INVALID CART ID! Selected cart item does not exist"
    ];
    goto end;
}

mysqli_query($conn, "DELETE FROM cart_tab WHERE cart_id = '$cartId'") or die(mysqli_error($conn));

$response = [
    'success' => true,
    'message' => "CART DELETED SUCCESSFUL"
];

end:
echo json_encode($response);
?>
