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

$searchCategoryQuery = mysqli_query($conn, "SELECT categories_tab.*, status_tab.status_name FROM categories_tab, status_tab WHERE categories_tab.status_id = status_tab.status_id AND (categories_tab.categories_name LIKE '%$searchContent%' OR categories_tab.categories_id LIKE '%$searchContent%' OR status_tab.status_name LIKE '%$searchContent%') ORDER BY categories_tab.created_at DESC") or die(mysqli_error($conn));

if (mysqli_num_rows($searchCategoryQuery) == 0) {
    $response = [
        'success' => false,
        'message' => "NO CATEGORIES FOUND"
    ];
    goto end;
}

$fetchData = mysqli_fetch_all($searchCategoryQuery, MYSQLI_ASSOC);

$response = [
    'success' => true,
    'message' => "CATEGORIES SEARCHED SUCCESSFULLY",
    'data' => $fetchData
];

end:
echo json_encode($response);
?>
