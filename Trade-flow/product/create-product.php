<?php require_once __DIR__ . '/../config/connection.php'; ?>

<?php
// DECLARATION OF VARIABLES
$categoryId = trim($_POST['categoryId']);
$productName = trim($_POST['productName']);
$price = trim($_POST['price']);
$quantity = trim($_POST['quantity']);
$statusId = trim($_POST['statusId']);

if ($categoryId == '') {
    $response = [
        'success' => false,
        'message' => "CATEGORY ID IS REQUIRED, Kindly fill in category ID to continue"
    ];
    goto end;
}

if ($productName == '') {
    $response = [
        'success' => false,
        'message' => "PRODUCT NAME IS REQUIRED, Kindly fill in product name to continue"
    ];
    goto end;
}

if ($price == '') {
    $response = [
        'success' => false,
        'message' => "PRODUCT PRICE IS REQUIRED, Kindly fill in the price to continue"
    ];
    goto end;
}

if ($quantity == '') {
    $response = [
        'success' => false,
        'message' => "QUANTITY IS REQUIRED, Kindly fill in a quantity to continue"
    ];
    goto end;
}

if ($statusId == '') {
    $response = [
        'success' => false,
        'message' => "STATUS ID IS REQUIRED, Kindly fill in status ID to continue"
    ];
    goto end;
}

$checkCategory = mysqli_query($conn, "SELECT * FROM categories_tab WHERE categories_id = '$categoryId'") or die(mysqli_error($conn));
if (mysqli_num_rows($checkCategory) == 0) {
    $response = [
        'success' => false,
        'message' => "INVALID CATEGORY ID! Selected category does not exist"
    ];
    goto end;
}

$checkStatus = mysqli_query($conn, "SELECT * FROM status_tab WHERE status_id = '$statusId'") or die(mysqli_error($conn));
if (mysqli_num_rows($checkStatus) == 0) {
    $response = [
        'success' => false,
        'message' => "INVALID STATUS ID! Selected status ID does not exist in status_tab"
    ];
    goto end;
}

$productId = 'PROD' . date("YmdHis");

mysqli_query($conn, "INSERT INTO `product_tab` (`categories_id`, `product_id`, `product_name`, `product_price`, `quantity`, `status_id`, `created_at`, `updated_at`) VALUES ('$categoryId', '$productId', '$productName', '$price', '$quantity', '$statusId', NOW(), NOW())") or die(mysqli_error($conn));

$fetchProductQuery = mysqli_query($conn, "SELECT product_tab.*, categories_tab.categories_name, status_tab.status_name FROM product_tab, categories_tab, status_tab WHERE product_tab.categories_id = categories_tab.categories_id AND product_tab.status_id = status_tab.status_id AND product_tab.product_id = '$productId'") or die(mysqli_error($conn));
$productData = mysqli_fetch_assoc($fetchProductQuery);

$response = [
    'success' => true,
    'message' => "PRODUCT CREATED SUCCESSFULLY",
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
