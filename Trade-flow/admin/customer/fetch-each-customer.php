<?php require_once __DIR__ . '/../../config/connection.php'; ?>

<?php

$customerId = trim($_POST['customerId']);

if ($customerId == '') {
    $response = [
        'success' => false,
        'message' => 'CUSTOMER ID IS REQUIRED'
    ];
    goto end;
}

$checkCustomerQuery = mysqli_query($conn, "SELECT customer_tab.sn, customer_tab.customer_id, customer_tab.title_id, customer_tab.first_name, customer_tab.last_name, customer_tab.email_address, customer_tab.phone_number, customer_tab.address, customer_tab.status_id, customer_tab.role_id, customer_tab.reset_otp, customer_tab.last_login_date, customer_tab.created_at, customer_tab.updated_at, title_tab.title_name, role_tab.role_name, status_tab.status_name FROM customer_tab, title_tab, role_tab, status_tab WHERE customer_tab.title_id = title_tab.title_id AND customer_tab.role_id = role_tab.role_id AND customer_tab.status_id = status_tab.status_id AND customer_tab.customer_id = '$customerId'") or die(mysqli_error($conn));

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
