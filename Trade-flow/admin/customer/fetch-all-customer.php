<?php require_once __DIR__ . '/../../config/connection.php'; ?>

<?php

$fetchAllCustomerQuery = mysqli_query($conn, "SELECT sn, customer_id, title_id, first_name, last_name, email_address, phone_number, address, status_id, role_id, reset_otp, last_login_date, created_at, updated_at FROM customer_tab ORDER BY customer_tab.created_at DESC") or die(mysqli_error($conn));

if (mysqli_num_rows($fetchAllCustomerQuery) == 0) {
    $response = [
        'success' => false,
        'message' => 'NO CUSTOMERS FOUND'
    ];
    goto end;
}

$fetchData = mysqli_fetch_all($fetchAllCustomerQuery, MYSQLI_ASSOC);

$response = [
    'success' => true,
    'message' => "CUSTOMERS FETCHED SUCCESSFULLY",
    'data' => $fetchData
];

end:
echo json_encode($response);
?>
