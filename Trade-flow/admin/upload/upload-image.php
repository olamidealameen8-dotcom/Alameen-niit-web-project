<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With, Origin, Accept");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once __DIR__ . '/../../config/upload-helper.php';

// Check if file was provided
if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
    echo json_encode([
        "success" => false,
        "message" => "NO FILE UPLOADED. Please select an image file to continue."
    ]);
    exit;
}

$folder = isset($_POST['folder']) ? $_POST['folder'] : 'categories';
$result = uploadImageFile($_FILES['image'], $folder);
echo json_encode($result);
?>
