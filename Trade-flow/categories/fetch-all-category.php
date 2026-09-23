<?php require_once __DIR__ . '/../config/connection.php'; ?>

<?php

$fetchAllCategoriesQuery = mysqli_query($conn, "SELECT categories_tab.*, status_tab.status_name FROM categories_tab, status_tab WHERE categories_tab.status_id = status_tab.status_id ORDER BY categories_tab.created_at DESC") or die(mysqli_error($conn));

if (mysqli_num_rows($fetchAllCategoriesQuery) == 0) {
    $response = [
        'success' => false,
        'message' => 'NO CATEGORIES FOUND'
    ];
    goto end;
}

$fetchData = mysqli_fetch_all($fetchAllCategoriesQuery, MYSQLI_ASSOC);

$response = [
    'success' => true,
    'message' => "CATEGORIES FETCHED SUCCESSFULLY",
    'data' => $fetchData
];

end:
echo json_encode($response);
?>
