<?php require_once __DIR__ . '/../config/connection.php'; ?>

<?php
// DECLARATION OF VARIABLES
$customerId = trim($_POST['customerId']);
$price = trim($_POST['price']);
$paymentMethodId = trim($_POST['paymentMethodId']);
$statusId = trim($_POST['statusId']);

if ($customerId == '') {
    $response = [
        'success' => false,
        'message' => "CUSTOMER ID IS REQUIRED, Kindly fill in the customer ID to continue"
    ];
    goto end;
}

if ($price == '') {
    $response = [
        'success' => false,
        'message' => "PRICE IS REQUIRED, Kindly fill in the price to continue"
    ];
    goto end;
}

if ($paymentMethodId == '') {
    $response = [
        'success' => false,
        'message' => "PAYMENT METHOD ID IS REQUIRED, Kindly fill in the payment method ID to continue"
    ];
    goto end;
}

if ($statusId == '') {
    $response = [
        'success' => false,
        'message' => "STATUS ID IS REQUIRED, Kindly fill in the status ID to continue"
    ];
    goto end;
}

$checkCustomerQuery = mysqli_query($conn, "SELECT * FROM customer_tab WHERE customer_id = '$customerId'") or die(mysqli_error($conn));
if (mysqli_num_rows($checkCustomerQuery) == 0) {
    $response = [
        'success' => false,
        'message' => "INVALID CUSTOMER ID! Selected customer ID does not exist in customer_tab"
    ];
    goto end;
}

$checkPaymentMethodQuery = mysqli_query($conn, "SELECT * FROM payment_method_tab WHERE payment_method_id = '$paymentMethodId'") or die(mysqli_error($conn));
if (mysqli_num_rows($checkPaymentMethodQuery) == 0) {
    $response = [
        'success' => false,
        'message' => "INVALID PAYMENT METHOD ID! Selected payment method ID does not exist in payment_method_tab"
    ];
    goto end;
}

$checkStatusQuery = mysqli_query($conn, "SELECT * FROM status_tab WHERE status_id = '$statusId'") or die(mysqli_error($conn));
if (mysqli_num_rows($checkStatusQuery) == 0) {
    $response = [
        'success' => false,
        'message' => "INVALID STATUS ID! Selected status ID does not exist in status_tab"
    ];
    goto end;
}

$transactionsId = 'TXN' . date("YmdHis");

mysqli_query($conn, "INSERT INTO `transactions_tab` (`transactions_id`, `customer_id`, `price`, `payment_method_id`, `status_id`, `created_at`, `updated_at`) VALUES ('$transactionsId', '$customerId', '$price', '$paymentMethodId', '$statusId', NOW(), NOW())") or die(mysqli_error($conn));

$fetchTransactionQuery = mysqli_query($conn, "SELECT transactions_tab.*, customer_tab.first_name, customer_tab.last_name, payment_method_tab.payment_method_name, status_tab.status_name FROM transactions_tab, customer_tab, payment_method_tab, status_tab WHERE transactions_tab.customer_id = customer_tab.customer_id AND transactions_tab.payment_method_id = payment_method_tab.payment_method_id AND transactions_tab.status_id = status_tab.status_id AND transactions_tab.transactions_id = '$transactionsId'") or die(mysqli_error($conn));
$transactionData = mysqli_fetch_assoc($fetchTransactionQuery);

$response = [
    'success' => true,
    'message' => "TRANSACTION CREATED SUCCESSFULLY",
    'data' => [
        'transactionsId' => $transactionData['transactions_id'],
        'customerId' => $transactionData['customer_id'],
        'firstName' => $transactionData['first_name'],
        'lastName' => $transactionData['last_name'],
        'price' => $transactionData['price'],
        'paymentMethodId' => $transactionData['payment_method_id'],
        'paymentMethodName' => $transactionData['payment_method_name'],
        'statusId' => $transactionData['status_id'],
        'statusName' => $transactionData['status_name'],
        'createdAt' => $transactionData['created_at'],
        'updatedAt' => $transactionData['updated_at']
    ]
];

end:
echo json_encode($response);
?>
