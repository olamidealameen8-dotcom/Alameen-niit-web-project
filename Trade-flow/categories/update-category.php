<?php require_once __DIR__ . '/../config/connection.php'; ?>

<?php
// DECLARATION OF VARIABLES
$categoryId = trim($_POST['categoryId']);
$categoryName = trim($_POST['categoryName']);
$statusId = trim($_POST['statusId']);

if ($categoryId == '') {
    $response = [
        'success' => false,
        'message' => "CATEGORY ID IS REQUIRED, Kindly fill in the category ID to continue"
    ];
    goto end;
}

if ($categoryName == '') {
    $response = [
        'success' => false,
        'message' => "CATEGORY NAME IS REQUIRED, Kindly fill in the category name to continue"
    ];
    goto end;
}

if ($statusId == '') {
    $response = [
        'success' => false,
        'message' => "STATUS ID IS REQUIRED, Kindly fill in the status ID to continue"
    ];
    goto end;
}

$checkCategoryQuery = mysqli_query($conn, "SELECT * FROM categories_tab WHERE categories_id = '$categoryId'") or die(mysqli_error($conn));
if (mysqli_num_rows($checkCategoryQuery) == 0) {
    $response = [
        'success' => false,
        'message' => "CATEGORY NOT FOUND"
    ];
    goto end;
}

$checkStatusQuery = mysqli_query($conn, "SELECT * FROM status_tab WHERE status_id = '$statusId'") or die(mysqli_error($conn));
if (mysqli_num_rows($checkStatusQuery) == 0) {
    $response = [
        'success' => false,
        'message' => "INVALID STATUS ID! Selected status ID ($statusId) does not exist in status_tab"
    ];
    goto end;
}

$duplicateCheck = mysqli_query($conn, "SELECT * FROM categories_tab WHERE categories_name = '$categoryName' AND categories_id != '$categoryId'") or die(mysqli_error($conn));
if (mysqli_num_rows($duplicateCheck) > 0) {
    $response = [
        'success' => false,
        'message' => "CATEGORY NAME ALREADY EXISTS! Kindly use a different category name"
    ];
    goto end;
}

mysqli_query($conn, "UPDATE categories_tab SET categories_name = '$categoryName', status_id = '$statusId', updated_at = NOW() WHERE categories_id = '$categoryId'") or die(mysqli_error($conn));

$fetchUpdatedCategory = mysqli_query($conn, "SELECT categories_tab.*, status_tab.status_name FROM categories_tab, status_tab WHERE categories_tab.status_id = status_tab.status_id AND categories_tab.categories_id = '$categoryId'") or die(mysqli_error($conn));
$categoryData = mysqli_fetch_assoc($fetchUpdatedCategory);

$response = [
    'success' => true,
    'message' => "CATEGORY UPDATED SUCCESSFULLY",
    'data' => [
        'categoryId' => $categoryData['categories_id'],
        'categoryName' => $categoryData['categories_name'],
        'statusId' => $categoryData['status_id'],
        'statusName' => $categoryData['status_name'],
        'createdAt' => $categoryData['created_at'],
        'updatedAt' => $categoryData['updated_at']
    ]
];

end:
echo json_encode($response);
?>
