<?php require_once __DIR__ . '/../config/connection.php'; ?>

<?php
// DECLARATION OF VARIABLES
$categoryName = trim($_POST['categoryName']);
$statusId = trim($_POST['statusId']);

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
        'message' => "STATUS ID IS REQUIRED, Kindly fill in the status ID (e.g. 1 for Active, 2 for Inactive)"
    ];
    goto end;
}

$checkStatusQuery = mysqli_query($conn, "SELECT * FROM status_tab WHERE status_id = '$statusId'") or die(mysqli_error($conn));
if (mysqli_num_rows($checkStatusQuery) == 0) {
    $response = [
        'success' => false,
        'message' => "INVALID STATUS ID! Selected status ID does not exist in status_tab"
    ];
    goto end;
}

$checkCategoryQuery = mysqli_query($conn, "SELECT * FROM categories_tab WHERE categories_name = '$categoryName'") or die(mysqli_error($conn));
if (mysqli_num_rows($checkCategoryQuery) > 0) {
    $response = [
        'success' => false,
        'message' => "CATEGORY NAME ALREADY EXISTS! Kindly use a different category name"
    ];
    goto end;
}

$categoryId = 'CAT' . date("YmdHis");

mysqli_query($conn, "INSERT INTO `categories_tab` (`categories_id`, `categories_name`, `status_id`, `created_at`, `updated_at`) VALUES ('$categoryId', '$categoryName', '$statusId', NOW(), NOW())") or die(mysqli_error($conn));

$fetchCategoryQuery = mysqli_query($conn, "SELECT categories_tab.*, status_tab.status_name FROM categories_tab, status_tab WHERE categories_tab.status_id = status_tab.status_id AND categories_tab.categories_id = '$categoryId'") or die(mysqli_error($conn));
$categoryData = mysqli_fetch_assoc($fetchCategoryQuery);

$response = [
    'success' => true,
    'message' => "CATEGORY CREATED SUCCESSFULLY",
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
