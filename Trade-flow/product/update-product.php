<?php require_once __DIR__ . '/../config/connection.php'; ?>

<?php
// DECLARATION OF VARIABLES
$productId = trim($_POST['productId']);
$categoryId = trim($_POST['categoryId']);
$productName = trim($_POST['productName']);
$price = trim($_POST['price']);
$quantity = trim($_POST['quantity']);
$statusId = trim($_POST['statusId']);

if ($productId == '') {
    $response = [
        'success' => false,
        'message' => 'PRODUCT ID IS REQUIRED'
    ];
    goto end;
}

if ($categoryId == '') {
    $response = [
        'success' => false,
        'message' => 'CATEGORY ID IS REQUIRED'
    ];
    goto end;
}

if ($productName == '') {
    $response = [
        'success' => false,
        'message' => 'PRODUCT NAME IS REQUIRED'
    ];
    goto end;
}

if ($price == '') {
    $response = [
        'success' => false,
        'message' => 'PRODUCT PRICE IS REQUIRED'
    ];
    goto end;
}

if ($quantity == '') {
    $response = [
        'success' => false,
        'message' => 'QUANTITY IS REQUIRED'
    ];
    goto end;
}

if ($statusId == '') {
    $response = [
        'success' => false,
        'message' => 'STATUS ID IS REQUIRED'
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

$checkCategoryQuery = mysqli_query($conn, "SELECT * FROM categories_tab WHERE categories_id = '$categoryId'") or die(mysqli_error($conn));
if (mysqli_num_rows($checkCategoryQuery) == 0) {
    $response = [
        'success' => false,
        'message' => "INVALID CATEGORY ID! Selected category ID ($categoryId) does not exist in categories_tab"
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

mysqli_query($conn, "UPDATE product_tab SET categories_id = '$categoryId', product_name = '$productName', product_price = '$price', quantity = '$quantity', status_id = '$statusId', updated_at = NOW() WHERE product_id = '$productId'") or die(mysqli_error($conn));

$fetchUpdatedProduct = mysqli_query($conn, "SELECT product_tab.*, categories_tab.categories_name, status_tab.status_name FROM product_tab, categories_tab, status_tab WHERE product_tab.categories_id = categories_tab.categories_id AND product_tab.status_id = status_tab.status_id AND product_tab.product_id = '$productId'") or die(mysqli_error($conn));
$productData = mysqli_fetch_assoc($fetchUpdatedProduct);

$response = [
    'success' => true,
    'message' => 'PRODUCT UPDATED SUCCESSFULLY',
    'data' => [
        'productId' => $productData['product_id'],
        'categoryId' => $productData['categories_id'],
        'categoryName' => $productData['categories_name'],
        'productName' => $productData['product_name'],
        'productPrice' => $productData['product_price'],
        'quantity' => $productData['quantity'],
        'statusId' => $productData['status_id'],
        'statusName' => $productData['status_name'],
        'createdAt' => $productData['created_at'],
        'updatedAt' => $productData['updated_at']
    ]
];

end:
echo json_encode($response);
?>
