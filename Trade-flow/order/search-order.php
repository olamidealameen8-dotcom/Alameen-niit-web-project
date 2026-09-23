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

$searchOrderQuery = mysqli_query($conn, "SELECT order_tab.*, customer_tab.first_name, customer_tab.last_name, product_tab.product_name, status_tab.status_name FROM order_tab, customer_tab, product_tab, status_tab WHERE order_tab.customer_id = customer_tab.customer_id AND order_tab.product_id = product_tab.product_id AND order_tab.status_id = status_tab.status_id AND (order_tab.order_id LIKE '%$searchContent%' OR customer_tab.first_name LIKE '%$searchContent%' OR customer_tab.last_name LIKE '%$searchContent%' OR product_tab.product_name LIKE '%$searchContent%' OR status_tab.status_name LIKE '%$searchContent%') ORDER BY order_tab.created_at DESC") or die(mysqli_error($conn));

if (mysqli_num_rows($searchOrderQuery) == 0) {
    $response = [
        'success' => false,
        'message' => "NO ORDERS FOUND"
    ];
    goto end;
}

$fetchData = mysqli_fetch_all($searchOrderQuery, MYSQLI_ASSOC);

$response = [
    'success' => true,
    'message' => "ORDERS SEARCHED SUCCESSFULLY",
    'data' => $fetchData
];

end:
echo json_encode($response);
?>
