<?php require_once __DIR__ . '/../config/connection.php'; ?>

<?php
// DECLARATION OF VARIABLE
$searchContent = trim($_POST['searchContent']);

if ($searchContent == '') {
    $response = [
        'success' => false,
        'message' => "SEARCH CONTENT IS REQUIRED, Kindly fill in the search content to continue"
    ];
    goto end;
}

$searchProductQuery = mysqli_query($conn, "SELECT product_tab.*, categories_tab.categories_name, status_tab.status_name FROM product_tab, categories_tab, status_tab WHERE product_tab.categories_id = categories_tab.categories_id AND product_tab.status_id = status_tab.status_id AND (product_tab.product_name LIKE '%$searchContent%' OR categories_tab.categories_name LIKE '%$searchContent%' OR product_tab.product_id LIKE '%$searchContent%' OR status_tab.status_name LIKE '%$searchContent%') ORDER BY product_tab.created_at DESC") or die(mysqli_error($conn));

if (mysqli_num_rows($searchProductQuery) == 0) {
    $response = [
        'success' => false,
        'message' => "NO PRODUCTS FOUND"
    ];
    goto end;
}

$fetchData = mysqli_fetch_all($searchProductQuery, MYSQLI_ASSOC);

$response = [
    'success' => true,
    'message' => "PRODUCTS SEARCHED SUCCESSFULLY",
    'data' => $fetchData
];

end:
echo json_encode($response);
?>
