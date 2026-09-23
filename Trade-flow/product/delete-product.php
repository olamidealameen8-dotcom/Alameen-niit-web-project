<?php require_once __DIR__ . '/../config/connection.php'; ?>

<?php

$productId = trim($_POST['productId']);

if ($productId == '') {
    $response = [
        'success' => false,
        'message' => 'PRODUCT ID IS REQUIRED'
    ];
    goto end;
}

$checkProductQuery = mysqli_query($conn, "SELECT * FROM product_tab WHERE product_id = '$productId'") or die(mysqli_error($conn));
if (mysqli_num_rows($checkProductQuery) == 0) {
    $response = [
        'success' => false,
        'message' => 'PRODUCT NOT FOUND'
    ];
    goto end;
}

mysqli_query($conn, "DELETE FROM product_tab WHERE product_id = '$productId'") or die(mysqli_error($conn));

$response = [
    'success' => true,
    'message' => 'PRODUCT DELETED SUCCESSFULLY'
];

end:
echo json_encode($response);
?>
