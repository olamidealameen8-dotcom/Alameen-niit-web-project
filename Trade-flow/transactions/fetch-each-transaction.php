<?php require_once __DIR__ . '/../config/connection.php'; ?>

<?php

$transactionsId = trim($_POST['transactionsId'] ?? $_POST['transactionId'] ?? '');

if ($transactionsId == '') {
    $response = [
        'success' => false,
        'message' => 'TRANSACTION ID IS REQUIRED'
    ];
    goto end;
}

$checkTransactionQuery = mysqli_query($conn, "SELECT transactions_tab.*, customer_tab.first_name, customer_tab.last_name, payment_method_tab.payment_method_name, status_tab.status_name FROM transactions_tab, customer_tab, payment_method_tab, status_tab WHERE transactions_tab.customer_id = customer_tab.customer_id AND transactions_tab.payment_method_id = payment_method_tab.payment_method_id AND transactions_tab.status_id = status_tab.status_id AND transactions_tab.transactions_id = '$transactionsId'") or die(mysqli_error($conn));

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
