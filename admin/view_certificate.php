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
$certificate_id = $_GET['id'] ?? '';

$stmt = $conn->prepare("SELECT * FROM certificates WHERE certificate_id = ?");
$stmt->bind_param("s", $certificate_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $conn->close();
    header('Location: dashboard.php');
    exit;
}

$certificate = $result->fetch_assoc();
$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Certificate - <?php echo htmlspecialchars($certificate['id']); ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Poppins:wght@300;400;500;600;700&family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', 'Montserrat', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: #f5f5f5;
            padding: 2rem;
        }

        .certificate-container {
            max-width: 900px;
            margin: 0 auto;
            background: #fff;
            padding: 3rem;
            box-shadow: 0 0 30px rgba(0,0,0,0.1);
            border: 10px solid #5624d0;
            position: relative;
        }

        .certificate-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .certificate-header h1 {
            font-family: 'Playfair Display', serif;
            font-size: 3.2rem;
            color: #5624d0;
            margin-bottom: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-weight: 700;
        }

        .certificate-header p {
            font-family: 'Montserrat', sans-serif;
            font-size: 1.25rem;
            color: #666;
            font-style: italic;
            font-weight: 500;
        }

        .certificate-body {
            text-align: center;
            padding: 2rem 0;
            border-top: 2px solid #5624d0;
            border-bottom: 2px solid #5624d0;
            margin: 2rem 0;
        }

        .certificate-body p {
            font-family: 'Poppins', sans-serif;
            font-size: 1.15rem;
            line-height: 2;
            margin: 1rem 0;
            color: #333;
            font-weight: 400;
            letter-spacing: 0.3px;
        }

        .student-name {
            font-family: 'Playfair Display', serif;
            font-size: 2.8rem;
            font-weight: 700;
            color: #1c1d1f;
            margin: 1.5rem 0;
            text-decoration: underline;
            text-decoration-color: #5624d0;
            text-decoration-thickness: 2px;
            letter-spacing: 1px;
        }

        .student-info {
            font-family: 'Montserrat', sans-serif;
            font-size: 1rem;
            color: #555;
            margin: 1rem 0;
            line-height: 1.8;
            text-align: left;
            font-weight: 500;
        }

        .course-name {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            color: #5624d0;
            font-weight: 600;
            margin: 1rem 0;
            letter-spacing: 0.5px;
        }

        .course-dates {
            font-family: 'Poppins', sans-serif;
            font-size: 1rem;
            color: #666;
            margin: 1rem 0;
            font-style: italic;
            font-weight: 400;
        }

        .certificate-footer {
            display: flex;
            justify-content: space-between;
            margin-top: 3rem;
            padding-top: 2rem;
            border-top: 1px solid #ddd;
        }

        .signature {
            text-align: center;
            width: 200px;
        }

        .signature-line {
            border-top: 2px solid #1c1d1f;
            margin-top: 60px;
            margin-bottom: 10px;
        }

        .signature p {
            font-family: 'Montserrat', sans-serif;
            font-size: 0.95rem;
            color: #666;
            font-weight: 500;
        }

        .certificate-id {
            font-family: 'Montserrat', sans-serif;
            position: absolute;
            bottom: 20px;
            right: 30px;
            font-size: 0.9rem;
            color: #999;
            font-weight: 500;
            letter-spacing: 0.5px;
        }

        .back-button {
            text-align: center;
            margin-top: 2rem;
        }

        .btn {
            padding: 0.7rem 1.5rem;
            background: #5624d0;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            display: inline-block;
            transition: background 0.3s;
        }

        .btn:hover {
            background: #4a1fb8;
        }

        .print-button {
            text-align: center;
            margin-bottom: 1rem;
        }

        @media print {
            body {
                padding: 0;
                background: #fff;
            }
            .print-button, .back-button {
                display: none;
            }
            .certificate-container {
                box-shadow: none;
                border: 10px solid #5624d0;
            }
        }
    </style>
</head>
<body>
    <div class="print-button">
        <button onclick="window.print()" class="btn">Print Certificate</button>
    </div>

    <div class="certificate-container">
        <div class="certificate-header">
            <h1>Certificate of Completion</h1>
            <p>This is to certify that</p>
        </div>

        <div class="certificate-body">
            <div class="student-name"><?php echo htmlspecialchars($certificate['student_name']); ?></div>
            
            <div class="student-info">
                <p><strong>Email:</strong> <?php echo htmlspecialchars($certificate['student_email'] ?? 'N/A'); ?></p>
                <p><strong>Phone:</strong> <?php echo htmlspecialchars($certificate['student_phone'] ?? 'N/A'); ?></p>
            </div>
            
            <p>has successfully completed the course</p>
            <div class="course-name"><?php echo htmlspecialchars($certificate['course_name']); ?></div>
            
            <div class="course-dates">
                <p><strong>Course Duration:</strong> 
                    <?php 
                    if (isset($certificate['starting_date']) && !empty($certificate['starting_date'])) {
                        echo date('F d, Y', strtotime($certificate['starting_date'])); 
                    } else {
                        echo 'N/A';
                    }
                    ?>
                    to <?php echo date('F d, Y', strtotime($certificate['completion_date'])); ?>
                </p>
            </div>
            
            <p style="margin-top: 1.5rem;"><strong>Certificate Number:</strong> <?php echo htmlspecialchars($certificate['certificate_id']); ?></p>
        </div>

        <div class="certificate-footer">
            <div class="signature">
                <div class="signature-line"></div>
                <p>Authorized Signatory</p>
            </div>
            <div class="signature">
                <div class="signature-line"></div>
                <p>Date: <?php echo date('F d, Y', strtotime($certificate['issue_date'])); ?></p>
            </div>
        </div>

        <div class="certificate-id">
            Certificate ID: <?php echo htmlspecialchars($certificate['certificate_id']); ?>
        </div>
    </div>

    <div class="back-button">
        <a href="dashboard.php" class="btn">Back to Dashboard</a>
    </div>
</body>
</html>

