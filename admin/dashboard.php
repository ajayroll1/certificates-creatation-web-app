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

// Handle certificate creation
$success_message = "";
$error_message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'create_certificate') {
    $student_name = trim($_POST['student_name'] ?? '');
    $student_email = trim($_POST['student_email'] ?? '');
    $student_phone = trim($_POST['student_phone'] ?? '');
    $course_name = trim($_POST['course_name'] ?? '');
    $starting_date = $_POST['starting_date'] ?? date('Y-m-d');
    $completion_date = $_POST['completion_date'] ?? date('Y-m-d');
    $certificate_id = 'CERT-' . strtoupper(uniqid());
    $issue_date = date('Y-m-d');
    
    if (!empty($student_name) && !empty($course_name) && !empty($student_email) && !empty($student_phone)) {
        $stmt = $conn->prepare("INSERT INTO certificates (certificate_id, student_name, student_email, student_phone, course_name, starting_date, completion_date, issue_date, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'active')");
        $stmt->bind_param("ssssssss", $certificate_id, $student_name, $student_email, $student_phone, $course_name, $starting_date, $completion_date, $issue_date);
        
        if ($stmt->execute()) {
            // Store short professional success message in session
            $_SESSION['success_message'] = "Certificate issued successfully! ID: " . $certificate_id;
            
            // Redirect to prevent form resubmission
            header('Location: dashboard.php?success=1');
            exit;
        } else {
            $_SESSION['error_message'] = "❌ Error creating certificate: " . $conn->error;
            header('Location: dashboard.php?error=1');
            exit;
        }
        $stmt->close();
    } else {
        $_SESSION['error_message'] = "Please fill all required fields!";
        header('Location: dashboard.php?error=1');
        exit;
    }
}

// Get messages from session
$success_message = $_SESSION['success_message'] ?? '';
$error_message = $_SESSION['error_message'] ?? '';

// Clear messages after displaying
unset($_SESSION['success_message']);
unset($_SESSION['error_message']);

// Handle certificate deletion
if (isset($_GET['delete']) && !empty($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM certificates WHERE certificate_id = ?");
    $stmt->bind_param("s", $delete_id);
    
    if ($stmt->execute()) {
        $success_message = "Certificate deleted successfully!";
    }
    $stmt->close();
    header('Location: dashboard.php');
    exit;
}

// Get statistics
$stats_result = $conn->query("SELECT 
    COUNT(*) as total_certificates,
    SUM(CASE WHEN issue_date = CURDATE() THEN 1 ELSE 0 END) as today_certificates,
    COUNT(DISTINCT course_name) as unique_courses
    FROM certificates");
$stats = $stats_result->fetch_assoc();

$total_certificates = $stats['total_certificates'] ?? 0;
$today_certificates = $stats['today_certificates'] ?? 0;
$unique_courses = $stats['unique_courses'] ?? 0;

// Get all certificates
$certificates_result = $conn->query("SELECT * FROM certificates ORDER BY created_at DESC");
$certificates = [];
while ($row = $certificates_result->fetch_assoc()) {
    $certificates[] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - ICBWO</title>
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
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: #f7f9fa;
            color: #1c1d1f;
            overflow-x: hidden;
            width: 100%;
        }

        .dashboard-header {
            background: #fff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 1.5rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .dashboard-header h1 {
            color: #5624d0;
            font-size: 1.8rem;
        }

        .header-actions {
            display: flex;
            gap: 1rem;
            align-items: center;
            flex-wrap: wrap;
        }

        .btn {
            padding: 0.7rem 1.5rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s;
        }

        .btn-primary {
            background: #5624d0;
            color: #fff;
        }

        .btn-primary:hover {
            background: #4a1fb8;
        }

        .btn-danger {
            background: #dc3545;
            color: #fff;
        }

        .btn-danger:hover {
            background: #c82333;
        }

        .btn-secondary {
            background: #6c757d;
            color: #fff;
        }

        .btn-secondary:hover {
            background: #5a6268;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem;
            width: 100%;
            overflow-x: hidden;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: #fff;
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .stat-card h3 {
            color: #6a6f73;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
            text-transform: uppercase;
        }

        .stat-card .stat-value {
            font-size: 2.5rem;
            font-weight: bold;
            color: #5624d0;
        }

        .dashboard-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
        }

        .card {
            background: #fff;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .card h2 {
            color: #1c1d1f;
            margin-bottom: 1.5rem;
            font-size: 1.5rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: #1c1d1f;
            font-weight: 500;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 0.8rem;
            border: 1px solid #d1d7dc;
            border-radius: 4px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #5624d0;
        }

        .alert {
            padding: 1rem 1.5rem;
            border-radius: 6px;
            margin-bottom: 1.5rem;
            text-align: center;
            font-weight: 500;
            position: relative;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .alert-success::before {
            content: "✓";
            font-size: 1.2rem;
            font-weight: bold;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .alert-error::before {
            content: "✗";
            font-size: 1.2rem;
            font-weight: bold;
        }

        .certificates-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }

        .certificates-table th,
        .certificates-table td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #e9ecef;
        }

        .certificates-table th {
            background: #f7f9fa;
            font-weight: 600;
            color: #1c1d1f;
        }

        .certificates-table tr:hover {
            background: #f7f9fa;
        }

        .badge {
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .badge-success {
            background: #d4edda;
            color: #155724;
        }

        .action-buttons {
            display: flex;
            gap: 0.5rem;
        }

        .btn-sm {
            padding: 0.4rem 0.8rem;
            font-size: 0.85rem;
        }

        /* Certificate Cards - Hidden on desktop */
        .certificates-cards {
            display: none;
        }

        .mobile-view {
            display: none;
        }

        .desktop-view {
            display: block;
        }

        @media (max-width: 1200px) {
            .container {
                padding: 1.5rem;
            }
        }

        @media (max-width: 968px) {
            .dashboard-grid {
                grid-template-columns: 1fr;
            }
            
            .dashboard-header {
                padding: 1rem 1.5rem;
                flex-direction: column;
                align-items: flex-start;
            }
            
            .dashboard-header h1 {
                font-size: 1.5rem;
                margin-bottom: 0.75rem;
            }
            
            .header-actions {
                width: 100%;
                flex-direction: column;
                gap: 0.75rem;
            }
            
            .header-actions .btn {
                width: 100%;
                text-align: center;
            }
            
            .header-actions span {
                display: none;
            }
        }

        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }
            
            .dashboard-header {
                padding: 1rem;
                flex-direction: column;
                align-items: flex-start;
            }
            
            .dashboard-header h1 {
                font-size: 1.5rem;
                margin-bottom: 0.5rem;
            }
            
            .header-actions {
                width: 100%;
                flex-direction: column;
                gap: 0.75rem;
            }
            
            .header-actions .btn {
                width: 100%;
                text-align: center;
                padding: 0.875rem 1.25rem;
            }
            
            .header-actions span {
                display: none;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }
            
            .card {
                padding: 1.25rem;
            }
            
            .card h2 {
                font-size: 1.25rem;
            }
            
            .form-group {
                margin-bottom: 1.25rem;
            }
            
            .form-group input,
            .form-group select {
                padding: 0.875rem;
                font-size: 0.95rem;
            }
            
            .btn {
                width: 100%;
                padding: 0.875rem 1.25rem;
                text-align: center;
                margin-bottom: 0.5rem;
            }
            
            /* Hide table on mobile, show cards instead */
            .certificates-table {
                display: none;
            }
            
            .desktop-view {
                display: none !important;
            }
            
            .mobile-view {
                display: block !important;
            }
            
            .certificates-cards {
                display: block;
            }
            
            .certificate-card {
                background: #fff;
                border: 1px solid #e9ecef;
                border-radius: 12px;
                padding: 1.25rem;
                margin-bottom: 1rem;
                box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            }
            
            .certificate-card-header {
                display: flex;
                justify-content: space-between;
                align-items: flex-start;
                margin-bottom: 1rem;
                padding-bottom: 1rem;
                border-bottom: 2px solid #f1f3f5;
            }
            
            .certificate-card-id {
                font-size: 0.85rem;
                color: #6a6f73;
                font-weight: 600;
                letter-spacing: 0.5px;
            }
            
            .certificate-card-status {
                padding: 0.25rem 0.75rem;
                border-radius: 20px;
                font-size: 0.8rem;
                font-weight: 600;
            }
            
            .certificate-card-body {
                margin-bottom: 1rem;
            }
            
            .certificate-card-row {
                display: flex;
                justify-content: space-between;
                align-items: flex-start;
                padding: 0.75rem 0;
                border-bottom: 1px solid #f1f3f5;
            }
            
            .certificate-card-row:last-child {
                border-bottom: none;
            }
            
            .certificate-card-label {
                font-weight: 600;
                color: #6a6f73;
                font-size: 0.9rem;
                min-width: 120px;
            }
            
            .certificate-card-value {
                color: #1c1d1f;
                font-size: 0.95rem;
                text-align: right;
                flex: 1;
            }
            
            .certificate-card-value strong {
                display: block;
                color: #1c1d1f;
                margin-bottom: 0.25rem;
            }
            
            .certificate-card-value small {
                display: block;
                color: #6a6f73;
                font-size: 0.85rem;
            }
            
            .certificate-card-actions {
                display: flex;
                gap: 0.75rem;
                margin-top: 1rem;
                padding-top: 1rem;
                border-top: 1px solid #f1f3f5;
            }
            
            .certificate-card-actions .btn {
                flex: 1;
                margin-bottom: 0;
                padding: 0.75rem;
                font-size: 0.9rem;
            }
            
            .action-buttons {
                flex-direction: column;
                gap: 0.5rem;
            }
            
            .btn-sm {
                width: 100%;
                text-align: center;
                padding: 0.75rem;
            }
            
            .preview-actions {
                flex-direction: column;
                padding: 1rem;
            }
            
            .preview-actions .btn {
                width: 100%;
                margin-bottom: 0.5rem;
            }
            
            .preview-header {
                padding: 1rem;
                flex-direction: column;
                gap: 1rem;
            }
            
            .preview-header h2 {
                font-size: 1.25rem;
            }
            
            .close-preview {
                width: 100%;
            }
            
            .preview-certificate {
                padding: 1rem;
            }
            
            .certificate-preview {
                padding: 1rem;
                border-width: 5px;
            }
            
            .search-container {
                margin-bottom: 1rem;
            }
            
            .search-box input {
                padding: 0.75rem 0.875rem 0.75rem 2.5rem;
                font-size: 0.9rem;
            }
            
            .search-icon {
                left: 0.875rem;
                font-size: 1rem;
            }
            
            .pagination-container {
                flex-direction: column;
                gap: 0.75rem;
            }
            
            .pagination-info {
                text-align: center;
                width: 100%;
            }
            
            .pagination {
                justify-content: center;
                width: 100%;
            }
            
            .pagination button,
            .pagination a {
                padding: 0.5rem 0.75rem;
                font-size: 0.85rem;
                min-width: 36px;
            }
        }

        @media (max-width: 480px) {
            .container {
                padding: 0.75rem;
            }
            
            .dashboard-header h1 {
                font-size: 1.25rem;
            }
            
            .card {
                padding: 1rem;
            }
            
            .certificate-card {
                padding: 1rem;
            }
            
            .certificate-card-label {
                min-width: 100px;
                font-size: 0.85rem;
            }
            
            .certificate-card-value {
                font-size: 0.9rem;
            }
            
            .preview-actions {
                flex-direction: column;
                padding: 1rem;
            }
            
            .preview-actions .btn {
                width: 100%;
                margin-bottom: 0.5rem;
            }
            
            .preview-header {
                padding: 1rem;
                flex-direction: column;
                gap: 1rem;
            }
            
            .preview-header h2 {
                font-size: 1.25rem;
            }
            
            .close-preview {
                width: 100%;
            }
            
            .preview-certificate {
                padding: 1rem;
            }
            
            .certificate-preview {
                padding: 1rem;
                border-width: 5px;
            }
        }

        .empty-state {
            text-align: center;
            padding: 3rem;
            color: #6a6f73;
        }

        .empty-state p {
            margin-top: 1rem;
        }

        /* Preview Modal */
        .preview-modal {
            display: none;
            position: fixed;
            z-index: 2000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.7);
            overflow-y: auto;
            padding: 20px;
        }

        .preview-modal.active {
            display: block;
        }

        .preview-content {
            background: #fff;
            margin: 20px auto;
            max-width: 1000px;
            border-radius: 8px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.3);
            position: relative;
        }

        .preview-header {
            padding: 1.5rem;
            border-bottom: 1px solid #e9ecef;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .preview-header h2 {
            margin: 0;
            color: #1c1d1f;
        }

        .close-preview {
            background: #dc3545;
            color: #fff;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 600;
        }

        .close-preview:hover {
            background: #c82333;
        }

        .preview-certificate {
            padding: 3rem;
            background: #fff;
        }

        .certificate-preview {
            max-width: 900px;
            margin: 0 auto;
            background: #fff;
            padding: 3rem;
            border: 10px solid #5624d0;
            box-shadow: 0 0 30px rgba(0,0,0,0.1);
            font-family: 'Poppins', 'Montserrat', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }

        .cert-header-preview {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #5624d0;
        }

        .cert-logo-left {
            text-align: left;
        }

        .cert-logo-left h1 {
            font-family: 'Playfair Display', serif;
            font-size: 2.8rem;
            color: #5624d0;
            margin: 0;
            font-weight: 700;
            letter-spacing: 1px;
        }

        .cert-logo-left p {
            font-family: 'Montserrat', sans-serif;
            color: #666;
            margin-top: 0.5rem;
            font-size: 1rem;
            font-weight: 500;
        }

        .cert-logo-right {
            text-align: right;
        }

        .cert-logo-right h2 {
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem;
            color: #5624d0;
            margin: 0;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .cert-logo-right p {
            font-family: 'Montserrat', sans-serif;
            color: #666;
            margin-top: 0.5rem;
            font-size: 0.95rem;
            font-weight: 400;
        }

        .cert-date {
            font-family: 'Montserrat', sans-serif;
            text-align: left;
            color: #666;
            margin-bottom: 2rem;
            font-size: 1rem;
            font-weight: 500;
        }

        .cert-body-preview {
            text-align: center;
            padding: 2rem 0;
            margin: 2rem 0;
        }

        .cert-body-preview p {
            font-family: 'Poppins', sans-serif;
            font-size: 1.15rem;
            line-height: 2;
            margin: 1rem 0;
            color: #333;
            font-weight: 400;
            letter-spacing: 0.3px;
        }

        .student-name-preview {
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

        .student-info-preview {
            font-family: 'Montserrat', sans-serif;
            font-size: 1rem;
            color: #555;
            margin: 1rem 0;
            line-height: 1.8;
            text-align: left;
            background: #f7f9fa;
            padding: 1rem;
            border-radius: 4px;
            font-weight: 500;
        }

        .course-name-preview {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            color: #5624d0;
            font-weight: 600;
            margin: 1.5rem 0;
            letter-spacing: 0.5px;
        }

        .course-dates-preview {
            font-family: 'Poppins', sans-serif;
            font-size: 1rem;
            color: #666;
            margin: 1rem 0;
            font-style: italic;
            font-weight: 400;
        }

        .cert-id-preview {
            font-family: 'Montserrat', sans-serif;
            text-align: center;
            margin-top: 2rem;
            padding-top: 1rem;
            border-top: 1px solid #ddd;
            font-size: 0.95rem;
            color: #999;
            font-weight: 500;
            letter-spacing: 0.5px;
        }

        .cert-footer-preview {
            display: flex;
            justify-content: space-between;
            margin-top: 3rem;
            padding-top: 2rem;
            border-top: 1px solid #ddd;
        }

        .signature-preview {
            text-align: center;
            width: 200px;
        }

        .signature-line-preview {
            border-top: 2px solid #1c1d1f;
            margin-top: 60px;
            margin-bottom: 10px;
        }

        .signature-preview p {
            font-family: 'Montserrat', sans-serif;
            font-size: 0.95rem;
            color: #666;
            margin: 0;
            font-weight: 500;
        }

        .preview-actions {
            padding: 1.5rem;
            border-top: 1px solid #e9ecef;
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
            flex-wrap: wrap;
        }

        .btn-cancel {
            background: #6c757d;
            color: #fff;
        }

        .btn-cancel:hover {
            background: #5a6268;
        }

        .btn-confirm {
            background: #28a745;
            color: #fff;
        }

        .btn-confirm:hover {
            background: #218838;
        }

        /* Search Box */
        .search-container {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .search-box {
            position: relative;
            width: 100%;
        }

        .search-box input {
            width: 100%;
            padding: 0.875rem 1rem 0.875rem 2.75rem;
            border: 1px solid #d1d7dc;
            border-radius: 8px;
            font-size: 0.95rem;
            transition: all 0.3s;
        }

        .search-box input:focus {
            outline: none;
            border-color: #5624d0;
            box-shadow: 0 0 0 3px rgba(86, 36, 208, 0.1);
        }

        .search-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #6a6f73;
            font-size: 1.1rem;
            pointer-events: none;
        }

        /* Pagination */
        .pagination-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid #e9ecef;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .pagination-info {
            color: #6a6f73;
            font-size: 0.9rem;
        }

        .pagination {
            display: flex;
            gap: 0.5rem;
            align-items: center;
            flex-wrap: wrap;
        }

        .pagination button,
        .pagination a {
            padding: 0.5rem 0.875rem;
            border: 1px solid #d1d7dc;
            background: #fff;
            color: #1c1d1f;
            border-radius: 6px;
            text-decoration: none;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.3s;
            min-width: 40px;
            text-align: center;
        }

        .pagination button:hover:not(:disabled),
        .pagination a:hover:not(.disabled) {
            background: #5624d0;
            color: #fff;
            border-color: #5624d0;
        }

        .pagination button:disabled,
        .pagination a.disabled {
            opacity: 0.5;
            cursor: not-allowed;
            background: #f7f9fa;
        }

        .pagination .active {
            background: #5624d0;
            color: #fff;
            border-color: #5624d0;
            font-weight: 600;
        }

        .no-results {
            text-align: center;
            padding: 3rem;
            color: #6a6f73;
        }

        .no-results p {
            margin-top: 0.5rem;
            font-size: 0.95rem;
        }
    </style>
</head>
<body>
    <div class="dashboard-header">
        <h1>Admin Dashboard</h1>
        <div class="header-actions">
            <a href="view_database.php" class="btn btn-primary" style="margin-right: 1rem;">View Database</a>
            <a href="test_certificate.php" class="btn btn-primary" style="margin-right: 1rem;">Test Certificate</a>
            <span>Welcome, <?php echo htmlspecialchars($_SESSION['admin_name'] ?? $_SESSION['admin_email']); ?></span>
            <a href="logout.php" class="btn btn-secondary">Logout</a>
        </div>
    </div>

    <div class="container">
        <!-- Statistics -->
        <div class="stats-grid">
            <div class="stat-card">
                <h3>Total Certificates</h3>
                <div class="stat-value"><?php echo $total_certificates; ?></div>
            </div>
            <div class="stat-card">
                <h3>Issued Today</h3>
                <div class="stat-value"><?php echo $today_certificates; ?></div>
            </div>
            <div class="stat-card">
                <h3>Active Courses</h3>
                <div class="stat-value"><?php echo $unique_courses; ?></div>
            </div>
        </div>

        <div class="dashboard-grid">
            <!-- Create Certificate Form -->
            <div class="card">
                <h2>Issue New Certificate</h2>
                
                <?php if ($success_message): ?>
                    <div class="alert alert-success"><?php echo htmlspecialchars($success_message); ?></div>
                <?php endif; ?>
                
                <?php if ($error_message): ?>
                    <div class="alert alert-error"><?php echo htmlspecialchars($error_message); ?></div>
                <?php endif; ?>

                <form id="certificateForm" method="POST" action="">
                    <input type="hidden" name="action" value="create_certificate">
                    
                    <div class="form-group">
                        <label for="student_name">Student Name *</label>
                        <input type="text" id="student_name" name="student_name" required placeholder="Enter student full name">
                    </div>

                    <div class="form-group">
                        <label for="student_email">Student Email *</label>
                        <input type="email" id="student_email" name="student_email" required placeholder="Enter student email">
                    </div>

                    <div class="form-group">
                        <label for="student_phone">Student Phone *</label>
                        <input type="tel" id="student_phone" name="student_phone" required placeholder="Enter student phone number">
                    </div>

                    <div class="form-group">
                        <label for="course_name">Course Name *</label>
                        <input type="text" id="course_name" name="course_name" required placeholder="Enter course name">
                    </div>

                    <div class="form-group">
                        <label for="starting_date">Course Starting Date *</label>
                        <input type="date" id="starting_date" name="starting_date" value="<?php echo date('Y-m-d'); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="completion_date">Completion Date *</label>
                        <input type="date" id="completion_date" name="completion_date" value="<?php echo date('Y-m-d'); ?>" required>
                    </div>

                    <button type="button" onclick="showPreview()" class="btn btn-primary">Preview Certificate</button>
                    <a href="test_certificate.php" class="btn btn-secondary" style="margin-top: 1rem; display: inline-block;">Quick Test Certificate</a>
                </form>
            </div>

            <!-- Certificates List -->
            <div class="card">
                <h2>Recent Certificates</h2>
                
                <?php if (empty($certificates)): ?>
                    <div class="empty-state">
                        <p>No certificates issued yet.</p>
                        <p>Issue your first certificate using the form on the left.</p>
                    </div>
                <?php else: ?>
                    <!-- Search Box -->
                    <div class="search-container">
                        <div class="search-box">
                            <span class="search-icon">🔍</span>
                            <input type="text" id="searchRecent" placeholder="Search by ID, name, email, course..." onkeyup="filterAndPaginate('recent', this.value)">
                        </div>
                    </div>

                    <!-- Desktop Table View -->
                    <div style="max-height: 500px; overflow-y: auto;" class="desktop-view" id="recentTableContainer">
                        <table class="certificates-table" id="recentTable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Student</th>
                                    <th>Course</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="recentTableBody">
                                <?php 
                                $recent_certificates = array_slice($certificates, 0, 10);
                                foreach ($recent_certificates as $cert): 
                                ?>
                                    <tr data-search="<?php echo strtolower(htmlspecialchars($cert['certificate_id'] . ' ' . $cert['student_name'] . ' ' . ($cert['student_email'] ?? '') . ' ' . ($cert['student_phone'] ?? '') . ' ' . $cert['course_name'])); ?>">
                                        <td data-label="ID"><small><?php echo htmlspecialchars($cert['certificate_id']); ?></small></td>
                                        <td data-label="Student">
                                            <strong><?php echo htmlspecialchars($cert['student_name']); ?></strong><br>
                                            <small style="color: #6a6f73;"><?php echo htmlspecialchars($cert['student_email'] ?? 'N/A'); ?></small><br>
                                            <small style="color: #6a6f73;"><?php echo htmlspecialchars($cert['student_phone'] ?? 'N/A'); ?></small>
                                        </td>
                                        <td data-label="Course"><?php echo htmlspecialchars($cert['course_name']); ?></td>
                                        <td data-label="Date"><?php echo date('M d, Y', strtotime($cert['issue_date'])); ?></td>
                                        <td data-label="Actions">
                                            <div class="action-buttons">
                                                <a href="view_certificate.php?id=<?php echo $cert['certificate_id']; ?>" class="btn btn-primary btn-sm">View</a>
                                                <a href="?delete=<?php echo $cert['certificate_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this certificate?')">Delete</a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <div id="recentNoResults" class="no-results" style="display: none;">
                            <p>🔍</p>
                            <p>No certificates found matching your search.</p>
                        </div>
                    </div>
                    <div class="pagination-container desktop-view" id="recentPaginationDesktop"></div>
                    
                    <!-- Mobile Cards View -->
                    <div class="certificates-cards mobile-view" id="recentCardsContainer">
                        <?php 
                        $recent_certificates = array_slice($certificates, 0, 10);
                        foreach ($recent_certificates as $cert): 
                        ?>
                            <div class="certificate-card" data-search="<?php echo strtolower(htmlspecialchars($cert['certificate_id'] . ' ' . $cert['student_name'] . ' ' . ($cert['student_email'] ?? '') . ' ' . ($cert['student_phone'] ?? '') . ' ' . $cert['course_name'])); ?>">
                                <div class="certificate-card-header">
                                    <div class="certificate-card-id"><?php echo htmlspecialchars($cert['certificate_id']); ?></div>
                                    <span class="badge badge-success certificate-card-status"><?php echo ucfirst($cert['status']); ?></span>
                                </div>
                                <div class="certificate-card-body">
                                    <div class="certificate-card-row">
                                        <span class="certificate-card-label">Student</span>
                                        <div class="certificate-card-value">
                                            <strong><?php echo htmlspecialchars($cert['student_name']); ?></strong>
                                            <small><?php echo htmlspecialchars($cert['student_email'] ?? 'N/A'); ?></small>
                                            <small><?php echo htmlspecialchars($cert['student_phone'] ?? 'N/A'); ?></small>
                                        </div>
                                    </div>
                                    <div class="certificate-card-row">
                                        <span class="certificate-card-label">Course</span>
                                        <div class="certificate-card-value"><?php echo htmlspecialchars($cert['course_name']); ?></div>
                                    </div>
                                    <div class="certificate-card-row">
                                        <span class="certificate-card-label">Issue Date</span>
                                        <div class="certificate-card-value"><?php echo date('M d, Y', strtotime($cert['issue_date'])); ?></div>
                                    </div>
                                </div>
                                <div class="certificate-card-actions">
                                    <a href="view_certificate.php?id=<?php echo $cert['certificate_id']; ?>" class="btn btn-primary btn-sm">View</a>
                                    <a href="?delete=<?php echo $cert['certificate_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div id="recentNoResultsMobile" class="no-results mobile-view" style="display: none;">
                        <p>🔍</p>
                        <p>No certificates found matching your search.</p>
                    </div>
                    <div class="pagination-container mobile-view" id="recentPaginationMobile"></div>
                <?php endif; ?>
            </div>
        </div>

        <!-- All Certificates -->
        <div class="card" style="margin-top: 2rem;">
            <h2>All Certificates</h2>
            
            <?php if (empty($certificates)): ?>
                <div class="empty-state">
                    <p>No certificates found.</p>
                </div>
            <?php else: ?>
                <!-- Search Box -->
                <div class="search-container">
                    <div class="search-box">
                        <span class="search-icon">🔍</span>
                        <input type="text" id="searchAll" placeholder="Search by ID, name, email, course..." onkeyup="filterAndPaginate('all', this.value)">
                    </div>
                </div>

                <!-- Desktop Table View -->
                <div style="max-height: 600px; overflow-y: auto;" class="desktop-view" id="allTableContainer">
                    <table class="certificates-table" id="allTable">
                        <thead>
                            <tr>
                                <th>Certificate ID</th>
                                <th>Student Info</th>
                                <th>Course Name</th>
                                <th>Starting Date</th>
                                <th>Completion Date</th>
                                <th>Issue Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="allTableBody">
                            <?php foreach ($certificates as $cert): ?>
                                <tr data-search="<?php echo strtolower(htmlspecialchars($cert['certificate_id'] . ' ' . $cert['student_name'] . ' ' . ($cert['student_email'] ?? '') . ' ' . ($cert['student_phone'] ?? '') . ' ' . $cert['course_name'])); ?>">
                                    <td data-label="Certificate ID"><small><?php echo htmlspecialchars($cert['certificate_id']); ?></small></td>
                                    <td data-label="Student Info">
                                        <strong><?php echo htmlspecialchars($cert['student_name']); ?></strong><br>
                                        <small style="color: #6a6f73;"><?php echo htmlspecialchars($cert['student_email'] ?? 'N/A'); ?></small><br>
                                        <small style="color: #6a6f73;"><?php echo htmlspecialchars($cert['student_phone'] ?? 'N/A'); ?></small>
                                    </td>
                                    <td data-label="Course Name"><?php echo htmlspecialchars($cert['course_name']); ?></td>
                                    <td data-label="Starting Date"><?php echo isset($cert['starting_date']) ? date('M d, Y', strtotime($cert['starting_date'])) : 'N/A'; ?></td>
                                    <td data-label="Completion Date"><?php echo date('M d, Y', strtotime($cert['completion_date'])); ?></td>
                                    <td data-label="Issue Date"><?php echo date('M d, Y', strtotime($cert['issue_date'])); ?></td>
                                    <td data-label="Status"><span class="badge badge-success"><?php echo ucfirst($cert['status']); ?></span></td>
                                    <td data-label="Actions">
                                        <div class="action-buttons">
                                            <a href="view_certificate.php?id=<?php echo $cert['certificate_id']; ?>" class="btn btn-primary btn-sm">View</a>
                                            <a href="?delete=<?php echo $cert['certificate_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <div id="allNoResults" class="no-results" style="display: none;">
                        <p>🔍</p>
                        <p>No certificates found matching your search.</p>
                    </div>
                </div>
                <div class="pagination-container desktop-view" id="allPaginationDesktop"></div>
                
                <!-- Mobile Cards View -->
                <div class="certificates-cards mobile-view" id="allCardsContainer">
                    <?php foreach ($certificates as $cert): ?>
                        <div class="certificate-card" data-search="<?php echo strtolower(htmlspecialchars($cert['certificate_id'] . ' ' . $cert['student_name'] . ' ' . ($cert['student_email'] ?? '') . ' ' . ($cert['student_phone'] ?? '') . ' ' . $cert['course_name'])); ?>">
                            <div class="certificate-card-header">
                                <div class="certificate-card-id"><?php echo htmlspecialchars($cert['certificate_id']); ?></div>
                                <span class="badge badge-success certificate-card-status"><?php echo ucfirst($cert['status']); ?></span>
                            </div>
                            <div class="certificate-card-body">
                                <div class="certificate-card-row">
                                    <span class="certificate-card-label">Student</span>
                                    <div class="certificate-card-value">
                                        <strong><?php echo htmlspecialchars($cert['student_name']); ?></strong>
                                        <small><?php echo htmlspecialchars($cert['student_email'] ?? 'N/A'); ?></small>
                                        <small><?php echo htmlspecialchars($cert['student_phone'] ?? 'N/A'); ?></small>
                                    </div>
                                </div>
                                <div class="certificate-card-row">
                                    <span class="certificate-card-label">Course</span>
                                    <div class="certificate-card-value"><?php echo htmlspecialchars($cert['course_name']); ?></div>
                                </div>
                                <div class="certificate-card-row">
                                    <span class="certificate-card-label">Starting Date</span>
                                    <div class="certificate-card-value"><?php echo isset($cert['starting_date']) ? date('M d, Y', strtotime($cert['starting_date'])) : 'N/A'; ?></div>
                                </div>
                                <div class="certificate-card-row">
                                    <span class="certificate-card-label">Completion Date</span>
                                    <div class="certificate-card-value"><?php echo date('M d, Y', strtotime($cert['completion_date'])); ?></div>
                                </div>
                                <div class="certificate-card-row">
                                    <span class="certificate-card-label">Issue Date</span>
                                    <div class="certificate-card-value"><?php echo date('M d, Y', strtotime($cert['issue_date'])); ?></div>
                                </div>
                            </div>
                            <div class="certificate-card-actions">
                                <a href="view_certificate.php?id=<?php echo $cert['certificate_id']; ?>" class="btn btn-primary btn-sm">View</a>
                                <a href="?delete=<?php echo $cert['certificate_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div id="allNoResultsMobile" class="no-results mobile-view" style="display: none;">
                    <p>🔍</p>
                    <p>No certificates found matching your search.</p>
                </div>
                <div class="pagination-container mobile-view" id="allPaginationMobile"></div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Preview Modal -->
    <div id="previewModal" class="preview-modal">
        <div class="preview-content">
            <div class="preview-header">
                <h2>Certificate Preview</h2>
                <button class="close-preview" onclick="closePreview()">Close</button>
            </div>
            <div class="preview-certificate">
                <div class="certificate-preview" id="certificatePreview">
                    <div class="cert-header-preview">
                        <div class="cert-logo-left">
                            <h1>ICBWO</h1>
                            <p>International Certificate Board of World Organization</p>
                        </div>
                        <div class="cert-logo-right">
                            <h2>Certificate</h2>
                            <p>Certificate of Completion</p>
                        </div>
                    </div>
                    <div class="cert-date" id="previewDate"></div>
                    <div class="cert-body-preview">
                        <p>This certificate is awarded to</p>
                        <div class="student-name-preview" id="previewStudentName"></div>
                        <div class="student-info-preview" id="previewStudentInfo"></div>
                        <p>For completing the requirements of</p>
                        <div class="course-name-preview" id="previewCourseName"></div>
                        <div class="course-dates-preview" id="previewCourseDates"></div>
                        <div class="cert-id-preview" id="previewCertId"></div>
                    </div>
                    <div class="cert-footer-preview">
                        <div class="signature-preview">
                            <div class="signature-line-preview"></div>
                            <p>Authorized Signatory</p>
                        </div>
                        <div class="signature-preview">
                            <div class="signature-line-preview"></div>
                            <p id="previewIssueDate"></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="preview-actions">
                <button class="btn btn-cancel" onclick="closePreview()">Cancel</button>
                <button class="btn btn-confirm" onclick="confirmIssue()">Confirm & Issue Certificate</button>
            </div>
        </div>
    </div>
    
    <script>
        function showPreview() {
            // Get form values
            const studentName = document.getElementById('student_name').value.trim();
            const studentEmail = document.getElementById('student_email').value.trim();
            const studentPhone = document.getElementById('student_phone').value.trim();
            const courseName = document.getElementById('course_name').value.trim();
            const startingDate = document.getElementById('starting_date').value;
            const completionDate = document.getElementById('completion_date').value;

            // Validate form
            if (!studentName || !studentEmail || !studentPhone || !courseName || !startingDate || !completionDate) {
                alert('Please fill all required fields!');
                return;
            }

            // Generate certificate ID
            const certId = 'CERT-' + Math.random().toString(36).substr(2, 9).toUpperCase();
            
            // Format dates
            const startDateFormatted = new Date(startingDate).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
            const completionDateFormatted = new Date(completionDate).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
            const issueDateFormatted = new Date().toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
            const todayDate = new Date().toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });

            // Update preview
            document.getElementById('previewStudentName').textContent = studentName;
            document.getElementById('previewStudentInfo').innerHTML = 
                '<strong>Email:</strong> ' + studentEmail + '<br>' +
                '<strong>Phone:</strong> ' + studentPhone;
            document.getElementById('previewCourseName').textContent = courseName;
            document.getElementById('previewCourseDates').innerHTML = 
                '<strong>Course Duration:</strong> ' + startDateFormatted + ' to ' + completionDateFormatted;
            document.getElementById('previewCertId').innerHTML = 
                '<strong>Certificate Number:</strong> ' + certId;
            document.getElementById('previewDate').textContent = todayDate;
            document.getElementById('previewIssueDate').textContent = 'Date: ' + issueDateFormatted;

            // Show modal
            document.getElementById('previewModal').classList.add('active');
        }

        function closePreview() {
            document.getElementById('previewModal').classList.remove('active');
        }

        function confirmIssue() {
            // Close preview modal first
            closePreview();
            
            // Small delay to ensure modal closes
            setTimeout(function() {
                // Submit the form
                document.getElementById('certificateForm').submit();
            }, 100);
        }

        // Close modal on outside click
        window.onclick = function(event) {
            const modal = document.getElementById('previewModal');
            if (event.target == modal) {
                closePreview();
            }
        }

        // Pagination and Search functionality
        const itemsPerPage = 10;
        let currentPageRecent = 1;
        let currentPageAll = 1;
        let filteredDataRecent = [];
        let filteredDataAll = [];

        // Initialize pagination on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Store original data first
            const recentTableBody = document.getElementById('recentTableBody');
            const recentCardsContainer = document.getElementById('recentCardsContainer');
            const allTableBody = document.getElementById('allTableBody');
            const allCardsContainer = document.getElementById('allCardsContainer');

            // Store recent certificates
            if (recentTableBody) {
                filteredDataRecent = Array.from(recentTableBody.querySelectorAll('tr')).map(tr => {
                    const clone = tr.cloneNode(true);
                    return clone;
                });
            } else if (recentCardsContainer) {
                filteredDataRecent = Array.from(recentCardsContainer.querySelectorAll('.certificate-card')).map(card => {
                    const clone = card.cloneNode(true);
                    return clone;
                });
            }

            // Store all certificates
            if (allTableBody) {
                filteredDataAll = Array.from(allTableBody.querySelectorAll('tr')).map(tr => {
                    const clone = tr.cloneNode(true);
                    return clone;
                });
            } else if (allCardsContainer) {
                filteredDataAll = Array.from(allCardsContainer.querySelectorAll('.certificate-card')).map(card => {
                    const clone = card.cloneNode(true);
                    return clone;
                });
            }

            // Initialize pagination
            initializePagination('recent');
            initializePagination('all');
        });

        function initializePagination(type) {
            const isRecent = type === 'recent';
            const filtered = isRecent ? filteredDataRecent : filteredDataAll;
            
            if (!filtered || filtered.length === 0) return;

            // Show first page
            showPage(type, 1);
        }

        function filterAndPaginate(type, searchTerm) {
            const isRecent = type === 'recent';
            const noResults = document.getElementById(isRecent ? 'recentNoResults' : 'allNoResults');
            const noResultsMobile = document.getElementById(isRecent ? 'recentNoResultsMobile' : 'allNoResultsMobile');
            
            const searchLower = searchTerm.toLowerCase().trim();
            
            // Get original data from stored arrays
            let originalItems = [];
            if (isRecent) {
                // Re-initialize from DOM if needed
                const recentTableBody = document.getElementById('recentTableBody');
                const recentCardsContainer = document.getElementById('recentCardsContainer');
                if (recentTableBody && filteredDataRecent.length === 0) {
                    filteredDataRecent = Array.from(recentTableBody.querySelectorAll('tr')).map(tr => tr.cloneNode(true));
                } else if (recentCardsContainer && filteredDataRecent.length === 0) {
                    filteredDataRecent = Array.from(recentCardsContainer.querySelectorAll('.certificate-card')).map(card => card.cloneNode(true));
                }
                originalItems = filteredDataRecent;
            } else {
                const allTableBody = document.getElementById('allTableBody');
                const allCardsContainer = document.getElementById('allCardsContainer');
                if (allTableBody && filteredDataAll.length === 0) {
                    filteredDataAll = Array.from(allTableBody.querySelectorAll('tr')).map(tr => tr.cloneNode(true));
                } else if (allCardsContainer && filteredDataAll.length === 0) {
                    filteredDataAll = Array.from(allCardsContainer.querySelectorAll('.certificate-card')).map(card => card.cloneNode(true));
                }
                originalItems = filteredDataAll;
            }
            
            // If search is empty, show all items
            if (!searchLower) {
                if (isRecent) {
                    filteredDataRecent = originalItems.map(item => item.cloneNode(true));
                } else {
                    filteredDataAll = originalItems.map(item => item.cloneNode(true));
                }
            } else {
                // Filter items
                const filtered = originalItems.filter(item => {
                    const searchData = item.getAttribute('data-search') || '';
                    return searchData.includes(searchLower);
                }).map(item => item.cloneNode(true));

                // Update filtered data
                if (isRecent) {
                    filteredDataRecent = filtered;
                } else {
                    filteredDataAll = filtered;
                }
            }

            // Get current filtered data
            const filtered = isRecent ? filteredDataRecent : filteredDataAll;

            // Show/hide no results
            const hasResults = filtered.length > 0;
            if (noResults) noResults.style.display = hasResults ? 'none' : 'block';
            if (noResultsMobile) noResultsMobile.style.display = hasResults ? 'none' : 'block';

            // Reset to first page and show pagination
            if (isRecent) {
                currentPageRecent = 1;
            } else {
                currentPageAll = 1;
            }
            showPage(type, 1);
        }

        function showPage(type, page) {
            const isRecent = type === 'recent';
            const filtered = isRecent ? filteredDataRecent : filteredDataAll;
            
            if (!filtered || filtered.length === 0) return;
            
            if (isRecent) {
                currentPageRecent = page;
            } else {
                currentPageAll = page;
            }

            const startIndex = (page - 1) * itemsPerPage;
            const endIndex = startIndex + itemsPerPage;
            const pageItems = filtered.slice(startIndex, endIndex);

            // Update table
            const tableBody = document.getElementById(isRecent ? 'recentTableBody' : 'allTableBody');
            if (tableBody) {
                tableBody.innerHTML = '';
                pageItems.forEach(item => {
                    if (item.tagName === 'TR' || item.tagName === 'tr') {
                        tableBody.appendChild(item.cloneNode(true));
                    }
                });
            }

            // Update cards
            const cardsContainer = document.getElementById(isRecent ? 'recentCardsContainer' : 'allCardsContainer');
            if (cardsContainer) {
                cardsContainer.innerHTML = '';
                pageItems.forEach(item => {
                    if (item.classList && item.classList.contains('certificate-card')) {
                        cardsContainer.appendChild(item.cloneNode(true));
                    }
                });
            }

            // Update pagination
            renderPagination(type, filtered.length, page);
        }

        function renderPagination(type, totalItems, currentPage) {
            const isRecent = type === 'recent';
            const totalPages = Math.ceil(totalItems / itemsPerPage);
            const paginationDesktop = document.getElementById(isRecent ? 'recentPaginationDesktop' : 'allPaginationDesktop');
            const paginationMobile = document.getElementById(isRecent ? 'recentPaginationMobile' : 'allPaginationMobile');

            if (!paginationDesktop && !paginationMobile) return;

            const paginationHTML = `
                <div class="pagination-info">
                    Showing ${Math.min((currentPage - 1) * itemsPerPage + 1, totalItems)} - ${Math.min(currentPage * itemsPerPage, totalItems)} of ${totalItems}
                </div>
                <div class="pagination">
                    <button onclick="showPage('${type}', 1)" ${currentPage === 1 ? 'disabled' : ''}>«</button>
                    <button onclick="showPage('${type}', ${currentPage - 1})" ${currentPage === 1 ? 'disabled' : ''}>‹</button>
                    ${generatePageNumbers(type, totalPages, currentPage)}
                    <button onclick="showPage('${type}', ${currentPage + 1})" ${currentPage === totalPages ? 'disabled' : ''}>›</button>
                    <button onclick="showPage('${type}', ${totalPages})" ${currentPage === totalPages ? 'disabled' : ''}>»</button>
                </div>
            `;

            if (paginationDesktop) paginationDesktop.innerHTML = paginationHTML;
            if (paginationMobile) paginationMobile.innerHTML = paginationHTML;
        }

        function generatePageNumbers(type, totalPages, currentPage) {
            let pages = '';
            const maxVisible = 5;
            let start = Math.max(1, currentPage - Math.floor(maxVisible / 2));
            let end = Math.min(totalPages, start + maxVisible - 1);
            
            if (end - start < maxVisible - 1) {
                start = Math.max(1, end - maxVisible + 1);
            }

            if (start > 1) {
                pages += `<button onclick="showPage('${type}', 1)">1</button>`;
                if (start > 2) pages += `<span>...</span>`;
            }

            for (let i = start; i <= end; i++) {
                pages += `<button onclick="showPage('${type}', ${i})" class="${i === currentPage ? 'active' : ''}">${i}</button>`;
            }

            if (end < totalPages) {
                if (end < totalPages - 1) pages += `<span>...</span>`;
                pages += `<button onclick="showPage('${type}', ${totalPages})">${totalPages}</button>`;
            }

            return pages;
        }
    </script>
    
    <?php $conn->close(); ?>
</body>
</html>

