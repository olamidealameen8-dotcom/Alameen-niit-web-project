<?php require_once __DIR__ . '/../../config/connection.php'; ?>

<?php

$transactionsId = trim($_POST['transactionsId']);

if ($transactionsId == '') {
    $response = [
        'success' => false,
        'message' => 'TRANSACTION ID IS REQUIRED'
    ];
    goto end;
}

$checkTransactionQuery = mysqli_query($conn, "SELECT transaction_tab.*, customer_tab.first_name, customer_tab.last_name, payment_method_tab.payment_method_name, status_tab.status_name FROM transaction_tab, customer_tab, payment_method_tab, status_tab WHERE transaction_tab.customer_id = customer_tab.customer_id AND transaction_tab.payment_method_id = payment_method_tab.payment_method_id AND transaction_tab.status_id = status_tab.status_id AND transaction_tab.transactions_id = '$transactionsId'") or die(mysqli_error($conn));

if (mysqli_num_rows($checkTransactionQuery) == 0) {
    $response = [
        'success' => false,
        'message' => 'TRANSACTION NOT FOUND'
    ];
    goto end;
}

$transactionData = mysqli_fetch_assoc($checkTransactionQuery);

$response = [
    'success' => true,
    'message' => "TRANSACTION FETCHED SUCCESSFULLY",
    'data' => $transactionData
];

end:
echo json_encode($response);
?>
