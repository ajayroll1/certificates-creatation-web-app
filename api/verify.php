<?php
header('Content-Type: application/json');
require_once '../config/database.php';
require_once '../includes/functions.php';

$certificateNumber = isset($_GET['number']) ? sanitizeInput($_GET['number']) : '';

if (empty($certificateNumber)) {
    echo json_encode([
        'success' => false,
        'message' => 'Certificate number is required'
    ]);
    exit;
}

$certificate = verifyCertificate($certificateNumber);

if ($certificate) {
    echo json_encode([
        'success' => true,
        'data' => $certificate
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Certificate not found or invalid'
    ]);
}
?>

