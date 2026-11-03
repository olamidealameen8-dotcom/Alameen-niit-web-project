<?php require_once __DIR__ . '/../config/connection.php'; ?>

<?php

$titleIds =  $_POST['titleIds'] ?? '';

if ($titleIds === '') {
    $query = "SELECT * FROM title_tab";
}else {
    $query = "SELECT * FROM title_tab WHERE title_id IN ($titleIds)";
}
$fetchAllTitleQuery = mysqli_query($conn, $query) or die(mysqli_error($conn));

if (mysqli_num_rows($fetchAllTitleQuery) == 0) {
    $response = [
        'success' => false,
        'message' => 'NO TITLES FOUND'
    ];
    goto end;
}

$fetchData = mysqli_fetch_all($fetchAllTitleQuery, MYSQLI_ASSOC);

$response = [
    'success' => true,
    'message' => "TITLES FETCHED SUCCESSFULLY",
    'data' => $fetchData
];

end:
echo json_encode($response);
?>
