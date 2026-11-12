<?php

function uploadImageFile($file, $folder = 'categories') {
    // Max size: 5MB
    $maxSize = 5 * 1024 * 1024;
    if ($file['size'] > $maxSize) {
        return [
            'success' => false,
            'message' => 'FILE TOO LARGE. Maximum allowed file size is 5MB.'
        ];
    }

    // Allowed MIME types
    $allowedMimes = [
        'image/jpeg' => 'jpg',
        'image/jpg'  => 'jpg',
        'image/png'  => 'png',
        'image/webp' => 'webp'
    ];

    $mimeType = '';
    if (function_exists('finfo_open')) {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);
    } elseif (function_exists('mime_content_type')) {
        $mimeType = mime_content_type($file['tmp_name']);
    } else {
        $mimeType = $file['type'];
    }

    if (!array_key_exists($mimeType, $allowedMimes)) {
        return [
            'success' => false,
            'message' => 'INVALID FILE FORMAT. Only JPG, PNG, and WEBP images are supported.'
        ];
    }

    $folder = preg_replace('/[^a-zA-Z0-9_-]/', '', $folder);
    if (empty($folder)) {
        $folder = 'categories';
    }

    $uploadDir = __DIR__ . "/../uploads/{$folder}/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $extension = $allowedMimes[$mimeType];
    $fileName = uniqid($folder . "_" . date("Ymd_")) . "." . $extension;
    $destination = $uploadDir . $fileName;

    if (move_uploaded_file($file['tmp_name'], $destination)) {
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443)) ? "https://" : "http://";
        $host = $_SERVER['HTTP_HOST'];

        $scriptDir = dirname(dirname($_SERVER['SCRIPT_NAME']));
        // If called from admin/upload/ or admin/categories/, get root web path
        $parts = explode('/', trim(str_replace('\\', '/', $_SERVER['SCRIPT_NAME']), '/'));
        // Find index of 'admin' or determine root
        $adminIndex = array_search('admin', $parts);
        if ($adminIndex !== false) {
            $baseParts = array_slice($parts, 0, $adminIndex);
            $basePath = !empty($baseParts) ? '/' . implode('/', $baseParts) : '';
        } else {
            $basePath = rtrim(str_replace('\\', '/', dirname(dirname(dirname($_SERVER['SCRIPT_NAME'])))), '/');
        }

        $publicUrl = $protocol . $host . $basePath . "/uploads/{$folder}/" . $fileName;

        return [
            'success' => true,
            'message' => 'IMAGE UPLOADED SUCCESSFULLY',
            'data' => [
                'imageUrl' => $publicUrl,
                'fileName' => $fileName,
                'fileSize' => $file['size']
            ]
        ];
    }

    return [
        'success' => false,
        'message' => 'FAILED TO SAVE FILE on server disk. Please verify directory write permissions.'
    ];
}
?>
