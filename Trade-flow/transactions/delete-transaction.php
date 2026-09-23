<?php require_once __DIR__ . '/../config/connection.php'; ?>

<?php

$transactionsId = trim($_POST['transactionsId']);

if ($transactionsId == '') {
    $response = [
        'success' => false,
        'message' => 'TRANSACTION ID IS REQUIRED'
    ];
    goto end;
}

$checkTransactionQuery = mysqli_query($conn, "SELECT * FROM transactions_tab WHERE transactions_id = '$transactionsId'") or die(mysqli_error($conn));
if (mysqli_num_rows($checkTransactionQuery) == 0) {
    $response = [
        'success' => false,
        'message' => 'TRANSACTION NOT FOUND'
    ];
    goto end;
}

mysqli_query($conn, "DELETE FROM transactions_tab WHERE transactions_id = '$transactionsId'") or die(mysqli_error($conn));

$response = [
    'success' => true,
    'message' => 'TRANSACTION DELETED SUCCESSFULLY'
];

end:
echo json_encode($response);
?>
