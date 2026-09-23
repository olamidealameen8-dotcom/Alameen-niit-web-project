<?php require_once __DIR__ . '/../../config/connection.php'; ?>

<?php

$userId = trim($_POST['userId']);

if ($userId == '') {
    $response = [
        'success' => false,
        'message' => 'USER ID REQUIRED'
    ];
    goto end;
}

$checkUserQuery = mysqli_query($conn, "SELECT * FROM user_tab WHERE user_id = '$userId'") or die(mysqli_error($conn));
if (mysqli_num_rows($checkUserQuery) == 0) {
    $response = [ 
        'success' => false,
        'message' => 'USER ID NOT FOUND'
    ];
    goto end;
}

$checkUserQuery = mysqli_query($conn, "SELECT user_tab.*, status_tab.status_name FROM user_tab, status_tab WHERE user_tab.status_id = status_tab.status_id AND user_tab.user_id = '$userId'") or die(mysqli_error($conn));
while ($fetchData = mysqli_fetch_assoc($checkUserQuery)) {
 $fetchData['reset_otp'] = $fetchData['reset_otp'];   
    $response = [
        'success' => true,
        'message' => "USER FETCH SUCCESFULLY",
        'data' => $fetchData
    ];
}

end:
echo json_encode($response);

?>