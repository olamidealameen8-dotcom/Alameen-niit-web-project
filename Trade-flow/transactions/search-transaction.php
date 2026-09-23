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

$searchTransactionQuery = mysqli_query($conn, "SELECT transactions_tab.*, customer_tab.first_name, customer_tab.last_name, payment_method_tab.payment_method_name, status_tab.status_name FROM transactions_tab, customer_tab, payment_method_tab, status_tab WHERE transactions_tab.customer_id = customer_tab.customer_id AND transactions_tab.payment_method_id = payment_method_tab.payment_method_id AND transactions_tab.status_id = status_tab.status_id AND (transactions_tab.transactions_id LIKE '%$searchContent%' OR customer_tab.first_name LIKE '%$searchContent%' OR customer_tab.last_name LIKE '%$searchContent%' OR payment_method_tab.payment_method_name LIKE '%$searchContent%' OR status_tab.status_name LIKE '%$searchContent%' OR transactions_tab.price LIKE '%$searchContent%') ORDER BY transactions_tab.created_at DESC") or die(mysqli_error($conn));

if (mysqli_num_rows($searchTransactionQuery) == 0) {
    $response = [
        'success' => false,
        'message' => "NO TRANSACTIONS FOUND"
    ];
    goto end;
}

$fetchData = mysqli_fetch_all($searchTransactionQuery, MYSQLI_ASSOC);

$response = [
    'success' => true,
    'message' => "TRANSACTIONS SEARCHED SUCCESSFULLY",
    'data' => $fetchData
];

end:
echo json_encode($response);
?>
