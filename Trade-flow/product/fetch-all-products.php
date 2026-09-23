<?php require_once __DIR__ . '/../config/connection.php'; ?>

<?php

$fetchAllProductsQuery = mysqli_query($conn, "SELECT product_tab.*, categories_tab.categories_name, status_tab.status_name FROM product_tab, categories_tab, status_tab WHERE product_tab.categories_id = categories_tab.categories_id AND product_tab.status_id = status_tab.status_id ORDER BY product_tab.created_at DESC") or die(mysqli_error($conn));

if (mysqli_num_rows($fetchAllProductsQuery) == 0) {
    $response = [
        'success' => false,
        'message' => 'NO PRODUCTS FOUND'
    ];
    goto end;
}

$fetchData = mysqli_fetch_all($fetchAllProductsQuery, MYSQLI_ASSOC);

$response = [
    'success' => true,
    'message' => "PRODUCTS FETCHED SUCCESSFULLY",
    'data' => $fetchData
];

end:
echo json_encode($response);
?>
