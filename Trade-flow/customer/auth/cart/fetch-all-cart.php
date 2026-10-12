<?php require_once __DIR__ . '/../../../config/connection.php'; ?>

<?php
// DECLARATION OF VARIABLES
$customerId = trim($_POST['customerId']);
$sessionId = trim($_POST['sessionId']);

if ($customerId == '' && $sessionId == '') {
    $response = [
        'success' => false,
        'message' => "CUSTOMER ID OR SESSION ID IS REQUIRED, Kindly provide an ID to continue"
    ];
    goto end;
}

$whereFilter = "cart_tab.session_id = '$sessionId'";

if ($customerId != '') {
    $checkCustomerQuery = mysqli_query($conn, "SELECT * FROM customer_tab WHERE customer_id = '$customerId'") or die(mysqli_error($conn));
    if (mysqli_num_rows($checkCustomerQuery) == 0) {
        $response = [
            'success' => false,
            'message' => "INVALID CUSTOMER ID! Selected customer ID does not exist in customer_tab"
        ];
        goto end;
    }
    $whereFilter = "cart_tab.customer_id = '$customerId'";
}

$fetchAllCartQuery = mysqli_query($conn, "SELECT cart_tab.*, product_tab.product_name, status_tab.status_name FROM cart_tab, product_tab, status_tab WHERE cart_tab.product_id = product_tab.product_id AND cart_tab.status_id = status_tab.status_id AND $whereFilter ORDER BY cart_tab.created_at DESC") or die(mysqli_error($conn));

if (mysqli_num_rows($fetchAllCartQuery) == 0) {
    $response = [
        'success' => false,
        'message' => "NO CART ITEMS FOUND"
    ];
    goto end;
}

$fetchData = mysqli_fetch_all($fetchAllCartQuery, MYSQLI_ASSOC);

$response = [
    'success' => true,
    'message' => "CART ITEMS FETCHED SUCCESSFULLY",
    'data' => $fetchData
];

end:
echo json_encode($response);
?>
