<?php require_once __DIR__ . '/../config/connection.php'; ?>

<?php
// Update payment_method_tab
mysqli_query($conn, "UPDATE payment_method_tab SET created_at = NOW() WHERE created_at IS NULL OR created_at = '0000-00-00 00:00:00'");
mysqli_query($conn, "ALTER TABLE payment_method_tab MODIFY created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP");

// Update status_tab
mysqli_query($conn, "UPDATE status_tab SET created_at = NOW() WHERE created_at IS NULL OR created_at = '0000-00-00 00:00:00'");
mysqli_query($conn, "ALTER TABLE status_tab MODIFY created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP");

echo json_encode([
    'success' => true,
    'message' => 'payment_method_tab and status_tab fixed successfully! created_at is no longer NULL.'
]);
?>
