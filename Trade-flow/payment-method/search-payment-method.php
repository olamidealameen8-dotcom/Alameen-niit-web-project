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

$searchQuery = mysqli_query($conn, "SELECT * FROM payment_method_tab WHERE (payment_method_name LIKE '%$searchContent%' OR payment_method_id LIKE '%$searchContent%') ORDER BY created_at DESC") or die(mysqli_error($conn));

if (mysqli_num_rows($searchQuery) == 0) {
    $response = [
        'success' => false,
        'message' => "NO PAYMENT METHODS FOUND"
    ];
    goto end;
}

$fetchData = mysqli_fetch_all($searchQuery, MYSQLI_ASSOC);

$response = [
    'success' => true,
    'message' => "PAYMENT METHODS SEARCHED SUCCESSFULLY",
    'data' => $fetchData
];

end:
echo json_encode($response);
?>
