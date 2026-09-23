<?php require_once __DIR__ . '/../config/connection.php'; ?>

<?php

$customerId = trim($_POST['customerId']);

if ($customerId == '') {
    $response = [
        'success' => false,
        'message' => 'CUSTOMER ID IS REQUIRED'
    ];
    goto end;
}

$checkCustomerQuery = mysqli_query($conn, "SELECT customer_tab.*, role_tab.role_name, status_tab.status_name FROM customer_tab, role_tab, status_tab WHERE customer_tab.role_id = role_tab.role_id AND customer_tab.status_id = status_tab.status_id AND customer_tab.customer_id = '$customerId'") or die(mysqli_error($conn));

if (mysqli_num_rows($checkCustomerQuery) == 0) {
    $response = [
        'success' => false,
        'message' => 'CUSTOMER NOT FOUND'
    ];
    goto end;
}

$customerData = mysqli_fetch_assoc($checkCustomerQuery);

$response = [
    'success' => true,
    'message' => "CUSTOMER FETCHED SUCCESSFULLY",
    'data' => $customerData
];

end:
echo json_encode($response);
?>
