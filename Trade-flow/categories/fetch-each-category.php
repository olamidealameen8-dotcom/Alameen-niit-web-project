<?php require_once __DIR__ . '/../config/connection.php'; ?>

<?php

$categoryId = trim($_POST['categoryId']);

if ($categoryId == '') {
    $response = [
        'success' => false,
        'message' => 'CATEGORY ID IS REQUIRED'
    ];
    goto end;
}

$checkCategoryQuery = mysqli_query($conn, "SELECT categories_tab.*, status_tab.status_name FROM categories_tab, status_tab WHERE categories_tab.status_id = status_tab.status_id AND categories_tab.categories_id = '$categoryId'") or die(mysqli_error($conn));

if (mysqli_num_rows($checkCategoryQuery) == 0) {
    $response = [
        'success' => false,
        'message' => 'CATEGORY NOT FOUND'
    ];
    goto end;
}

$categoryData = mysqli_fetch_assoc($checkCategoryQuery);

$response = [
    'success' => true,
    'message' => "CATEGORY FETCHED SUCCESSFULLY",
    'data' => $categoryData
];

end:
echo json_encode($response);
?>
