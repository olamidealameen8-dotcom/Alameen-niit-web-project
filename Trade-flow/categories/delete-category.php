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

$checkCategoryQuery = mysqli_query($conn, "SELECT * FROM categories_tab WHERE categories_id = '$categoryId'") or die(mysqli_error($conn));
if (mysqli_num_rows($checkCategoryQuery) == 0) {
    $response = [
        'success' => false,
        'message' => 'CATEGORY NOT FOUND'
    ];
    goto end;
}

mysqli_query($conn, "DELETE FROM categories_tab WHERE categories_id = '$categoryId'") or die(mysqli_error($conn));

$response = [
    'success' => true,
    'message' => 'CATEGORY DELETED SUCCESSFULLY'
];

end:
echo json_encode($response);
?>
