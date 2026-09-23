<?php require_once __DIR__ . '/../config/connection.php'; ?>

<?php

$fetchAllCustomerQuery = mysqli_query($conn, "SELECT customer_tab.*, role_tab.role_name, status_tab.status_name FROM customer_tab, role_tab, status_tab WHERE customer_tab.role_id = role_tab.role_id AND customer_tab.status_id = status_tab.status_id ORDER BY customer_tab.created_at DESC") or die(mysqli_error($conn));

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
