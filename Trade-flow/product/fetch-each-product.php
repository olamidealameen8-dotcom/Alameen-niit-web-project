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

$checkProductQuery = mysqli_query($conn, "SELECT product_tab.*, categories_tab.categories_name, status_tab.status_name FROM product_tab, categories_tab, status_tab WHERE product_tab.categories_id = categories_tab.categories_id AND product_tab.status_id = status_tab.status_id AND product_tab.product_id = '$productId'") or die(mysqli_error($conn));

if (mysqli_num_rows($checkProductQuery) == 0) {
    $response = [
        'success' => false,
        'message' => 'PRODUCT NOT FOUND'
    ];
    goto end;
}

$productData = mysqli_fetch_assoc($checkProductQuery);

$response = [
    'success' => true,
    'message' => "PRODUCT FETCHED SUCCESSFULLY",
    'data' => $productData
];

end:
echo json_encode($response);
?>
