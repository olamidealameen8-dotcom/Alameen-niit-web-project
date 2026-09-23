<?php require_once __DIR__ . '/../../config/connection.php'; ?>

<?php

$fetchAllUserQuery = mysqli_query($conn, "SELECT user_tab.*, status_tab.status_name FROM user_tab, status_tab WHERE user_tab.status_id = status_tab.status_id") or die(mysqli_error($conn));

if (mysqli_num_rows($fetchAllUserQuery) == 0) {
    $response = [
        'success' => false,
        'message' => 'NO USER FOUND'
    ];
    goto end;
}

$fetchData = mysqli_fetch_all($fetchAllUserQuery, MYSQLI_ASSOC);

foreach ($fetchData as &$user) {
    $user['reset_otp'] = (int)$user['reset_otp'];
}
unset($user);

$response = [
    'success' => true,
    'message' => "USER FETCH SUCCESFULLY",
    'data' => $fetchData
];

end:
echo json_encode($response);
?>