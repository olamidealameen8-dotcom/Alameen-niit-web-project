<?php require_once __DIR__ . '/../config/connection.php'; ?>

<?php

$fetchAllTransactionsQuery = mysqli_query($conn, "SELECT transactions_tab.*, customer_tab.first_name, customer_tab.last_name, payment_method_tab.payment_method_name, status_tab.status_name FROM transactions_tab, customer_tab, payment_method_tab, status_tab WHERE transactions_tab.customer_id = customer_tab.customer_id AND transactions_tab.payment_method_id = payment_method_tab.payment_method_id AND transactions_tab.status_id = status_tab.status_id ORDER BY transactions_tab.created_at DESC") or die(mysqli_error($conn));

if (mysqli_num_rows($fetchAllTransactionsQuery) == 0) {
    $response = [
        'success' => false,
        'message' => 'NO TRANSACTIONS FOUND'
    ];
    goto end;
}

$fetchData = mysqli_fetch_all($fetchAllTransactionsQuery, MYSQLI_ASSOC);

$response = [
    'success' => true,
    'message' => "TRANSACTIONS FETCHED SUCCESSFULLY",
    'data' => $fetchData
];

end:
echo json_encode($response);
?>
