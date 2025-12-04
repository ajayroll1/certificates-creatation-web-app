<?php
session_start();
require_once '../config/database.php';
require_once '../config/init_database.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

$conn = getDBConnection();

// Test certificate data
$test_data = [
    'certificate_id' => 'CERT-TEST-' . strtoupper(uniqid()),
    'student_name' => 'Test Student',
    'student_email' => 'test@example.com',
    'student_phone' => '+91 9876543210',
    'course_name' => 'Complete Web Development Bootcamp',
    'starting_date' => date('Y-m-d', strtotime('-30 days')),
    'completion_date' => date('Y-m-d'),
    'issue_date' => date('Y-m-d'),
    'status' => 'active'
];

$message = "";
$error = "";

// Insert test certificate
$stmt = $conn->prepare("INSERT INTO certificates (certificate_id, student_name, student_email, student_phone, course_name, starting_date, completion_date, issue_date, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssssss", 
    $test_data['certificate_id'],
    $test_data['student_name'],
    $test_data['student_email'],
    $test_data['student_phone'],
    $test_data['course_name'],
    $test_data['starting_date'],
    $test_data['completion_date'],
    $test_data['issue_date'],
    $test_data['status']
);

if ($stmt->execute()) {
    $message = "✅ Test certificate created successfully!";
    $message .= "<br><strong>Certificate ID:</strong> " . $test_data['certificate_id'];
} else {
    $error = "❌ Error: " . $conn->error;
}

$stmt->close();

// Verify by fetching the certificate
$verify_stmt = $conn->prepare("SELECT * FROM certificates WHERE certificate_id = ?");
$verify_stmt->bind_param("s", $test_data['certificate_id']);
$verify_stmt->execute();
$result = $verify_stmt->get_result();
$certificate = $result->fetch_assoc();
$verify_stmt->close();

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Certificate - ICBWO</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f7f9fa;
            padding: 2rem;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background: #fff;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        h1 {
            color: #5624d0;
            margin-bottom: 2rem;
        }

        .message {
            padding: 1rem;
            border-radius: 4px;
            margin-bottom: 1.5rem;
        }

        .success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .certificate-data {
            background: #f7f9fa;
            padding: 1.5rem;
            border-radius: 4px;
            margin-top: 1.5rem;
        }

        .certificate-data h2 {
            color: #1c1d1f;
            margin-bottom: 1rem;
            font-size: 1.3rem;
        }

        .data-row {
            display: flex;
            padding: 0.8rem 0;
            border-bottom: 1px solid #e9ecef;
        }

        .data-row:last-child {
            border-bottom: none;
        }

        .data-label {
            font-weight: 600;
            color: #5624d0;
            width: 200px;
        }

        .data-value {
            color: #1c1d1f;
            flex: 1;
        }

        .btn {
            display: inline-block;
            padding: 0.7rem 1.5rem;
            background: #5624d0;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 1.5rem;
            font-weight: 600;
            transition: background 0.3s;
        }

        .btn:hover {
            background: #4a1fb8;
        }

        .btn-secondary {
            background: #6c757d;
        }

        .btn-secondary:hover {
            background: #5a6268;
        }

        .actions {
            display: flex;
            gap: 1rem;
            margin-top: 1.5rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Test Certificate Creation</h1>

        <?php if ($message): ?>
            <div class="message success">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="message error">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <?php if ($certificate): ?>
            <div class="certificate-data">
                <h2>✅ Certificate Data Retrieved from Database:</h2>
                <div class="data-row">
                    <div class="data-label">Certificate ID:</div>
                    <div class="data-value"><?php echo htmlspecialchars($certificate['certificate_id']); ?></div>
                </div>
                <div class="data-row">
                    <div class="data-label">Student Name:</div>
                    <div class="data-value"><?php echo htmlspecialchars($certificate['student_name']); ?></div>
                </div>
                <div class="data-row">
                    <div class="data-label">Student Email:</div>
                    <div class="data-value"><?php echo htmlspecialchars($certificate['student_email']); ?></div>
                </div>
                <div class="data-row">
                    <div class="data-label">Student Phone:</div>
                    <div class="data-value"><?php echo htmlspecialchars($certificate['student_phone']); ?></div>
                </div>
                <div class="data-row">
                    <div class="data-label">Course Name:</div>
                    <div class="data-value"><?php echo htmlspecialchars($certificate['course_name']); ?></div>
                </div>
                <div class="data-row">
                    <div class="data-label">Starting Date:</div>
                    <div class="data-value"><?php echo date('F d, Y', strtotime($certificate['starting_date'])); ?></div>
                </div>
                <div class="data-row">
                    <div class="data-label">Completion Date:</div>
                    <div class="data-value"><?php echo date('F d, Y', strtotime($certificate['completion_date'])); ?></div>
                </div>
                <div class="data-row">
                    <div class="data-label">Issue Date:</div>
                    <div class="data-value"><?php echo date('F d, Y', strtotime($certificate['issue_date'])); ?></div>
                </div>
                <div class="data-row">
                    <div class="data-label">Status:</div>
                    <div class="data-value"><?php echo ucfirst($certificate['status']); ?></div>
                </div>
            </div>

            <div class="actions">
                <a href="view_certificate.php?id=<?php echo $certificate['certificate_id']; ?>" class="btn">View Certificate</a>
                <a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
            </div>
        <?php else: ?>
            <div class="message error">
                Certificate was not found in database. There might be an issue with the database connection or table structure.
            </div>
            <a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
        <?php endif; ?>
    </div>
</body>
</html>

