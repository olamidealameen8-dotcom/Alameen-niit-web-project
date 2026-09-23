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

$searchCustomerQuery = mysqli_query($conn, "SELECT customer_tab.*, role_tab.role_name, status_tab.status_name FROM customer_tab, role_tab, status_tab WHERE customer_tab.role_id = role_tab.role_id AND customer_tab.status_id = status_tab.status_id AND (customer_tab.customer_id LIKE '%$searchContent%' OR customer_tab.first_name LIKE '%$searchContent%' OR customer_tab.last_name LIKE '%$searchContent%' OR customer_tab.email_address LIKE '%$searchContent%' OR role_tab.role_name LIKE '%$searchContent%' OR status_tab.status_name LIKE '%$searchContent%') ORDER BY customer_tab.created_at DESC") or die(mysqli_error($conn));

if (mysqli_num_rows($searchCustomerQuery) == 0) {
    $response = [
        'success' => false,
        'message' => "NO CUSTOMERS FOUND"
    ];
    goto end;
}

$fetchData = mysqli_fetch_all($searchCustomerQuery, MYSQLI_ASSOC);

$response = [
    'success' => true,
    'message' => "CUSTOMERS SEARCHED SUCCESSFULLY",
    'data' => $fetchData
];

end:
echo json_encode($response);
?>
