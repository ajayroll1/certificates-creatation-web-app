<?php
header('Content-Type: application/json');
require_once '../config/database.php';

$certificate_id = trim($_GET['certificate_id'] ?? '');

if (empty($certificate_id)) {
    echo json_encode([
        'success' => false,
        'message' => 'Certificate number is required'
    ]);
    exit;
}

$conn = getDBConnection();

$stmt = $conn->prepare("SELECT * FROM certificates WHERE certificate_id = ? AND status = 'active'");
$stmt->bind_param("s", $certificate_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $certificate = $result->fetch_assoc();
    
    echo json_encode([
        'success' => true,
        'verified' => true,
        'message' => 'Certificate Verified',
        'data' => [
            'certificate_id' => $certificate['certificate_id'],
            'student_name' => $certificate['student_name'],
            'course_name' => $certificate['course_name'],
            'starting_date' => $certificate['starting_date'],
            'completion_date' => $certificate['completion_date'],
            'issue_date' => $certificate['issue_date']
        ]
    ]);
} else {
    echo json_encode([
        'success' => false,
        'verified' => false,
        'message' => 'Certificate Not Found'
    ]);
}

$stmt->close();
$conn->close();
?>

