<?php
require_once '../config/database.php';
require_once '../includes/functions.php';
require_once 'includes/auth.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$certificate = getCertificateById($id);

if (!$certificate) {
    header("Location: manage-certificates.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Certificate - <?php echo htmlspecialchars($certificate['certificate_number']); ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Georgia', 'Times New Roman', serif;
            background: #f5f5f5;
            padding: 20px;
        }
        
        .certificate-container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            padding: 60px;
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.1);
            position: relative;
        }
        
        /* Border Design */
        .certificate-container::before {
            content: '';
            position: absolute;
            top: 20px;
            left: 20px;
            right: 20px;
            bottom: 20px;
            border: 5px solid #667eea;
            border-radius: 10px;
        }
        
        .certificate-header {
            text-align: center;
            margin-bottom: 40px;
            position: relative;
            z-index: 1;
        }
        
        .certificate-title {
            font-size: 3rem;
            font-weight: bold;
            color: #667eea;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 3px;
        }
        
        .certificate-subtitle {
            font-size: 1.2rem;
            color: #666;
            margin-bottom: 20px;
        }
        
        .certificate-divider {
            width: 200px;
            height: 3px;
            background: linear-gradient(90deg, transparent, #667eea, transparent);
            margin: 20px auto;
        }
        
        .certificate-body {
            text-align: center;
            margin: 50px 0;
            position: relative;
            z-index: 1;
        }
        
        .certificate-text {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #333;
            margin-bottom: 30px;
        }
        
        .employee-name {
            font-size: 2.5rem;
            font-weight: bold;
            color: #667eea;
            margin: 30px 0;
            text-decoration: underline;
            text-decoration-color: #764ba2;
            text-underline-offset: 10px;
        }
        
        .course-details {
            margin: 40px 0;
            padding: 30px;
            background: #f9fafb;
            border-radius: 10px;
            border-left: 5px solid #667eea;
        }
        
        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #e5e7eb;
        }
        
        .detail-row:last-child {
            border-bottom: none;
        }
        
        .detail-label {
            font-weight: 600;
            color: #666;
        }
        
        .detail-value {
            color: #333;
        }
        
        .certificate-footer {
            margin-top: 60px;
            display: flex;
            justify-content: space-between;
            position: relative;
            z-index: 1;
        }
        
        .signature-block {
            text-align: center;
            width: 200px;
        }
        
        .signature-line {
            border-top: 2px solid #333;
            margin-top: 60px;
            margin-bottom: 10px;
        }
        
        .signature-name {
            font-weight: 600;
            color: #333;
        }
        
        .certificate-number {
            text-align: center;
            margin-top: 30px;
            padding: 15px;
            background: #f9fafb;
            border-radius: 5px;
            font-family: 'Courier New', monospace;
            font-size: 0.9rem;
            color: #666;
            position: relative;
            z-index: 1;
        }
        
        .print-actions {
            text-align: center;
            margin: 20px 0;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        .btn {
            padding: 12px 30px;
            margin: 5px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            text-decoration: none;
            display: inline-block;
        }
        
        .btn-primary {
            background: #667eea;
            color: white;
        }
        
        .btn-secondary {
            background: #6b7280;
            color: white;
        }
        
        @media print {
            body {
                background: white;
                padding: 0;
            }
            
            .print-actions {
                display: none;
            }
            
            .certificate-container {
                box-shadow: none;
                padding: 40px;
            }
        }
        
        /* Decorative Elements */
        .decorative-corner {
            position: absolute;
            width: 100px;
            height: 100px;
            border: 3px solid #667eea;
        }
        
        .corner-top-left {
            top: 30px;
            left: 30px;
            border-right: none;
            border-bottom: none;
        }
        
        .corner-top-right {
            top: 30px;
            right: 30px;
            border-left: none;
            border-bottom: none;
        }
        
        .corner-bottom-left {
            bottom: 30px;
            left: 30px;
            border-right: none;
            border-top: none;
        }
        
        .corner-bottom-right {
            bottom: 30px;
            right: 30px;
            border-left: none;
            border-top: none;
        }
    </style>
</head>
<body>
    <div class="print-actions">
        <button onclick="window.print()" class="btn btn-primary">🖨️ Print Certificate</button>
        <a href="view-certificate.php?id=<?php echo $certificate['id']; ?>" class="btn btn-secondary">← Back to View</a>
    </div>
    
    <div class="certificate-container">
        <div class="decorative-corner corner-top-left"></div>
        <div class="decorative-corner corner-top-right"></div>
        <div class="decorative-corner corner-bottom-left"></div>
        <div class="decorative-corner corner-bottom-right"></div>
        
        <div class="certificate-header">
            <div class="certificate-title">Certificate of Completion</div>
            <div class="certificate-subtitle">This is to certify that</div>
            <div class="certificate-divider"></div>
        </div>
        
        <div class="certificate-body">
            <div class="employee-name">
                <?php echo htmlspecialchars($certificate['employee_name']); ?>
            </div>
            
            <div class="certificate-text">
                has successfully completed the course
            </div>
            
            <div class="course-details">
                <div class="detail-row">
                    <span class="detail-label">Course Name:</span>
                    <span class="detail-value"><strong><?php echo htmlspecialchars($certificate['course_name']); ?></strong></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Duration:</span>
                    <span class="detail-value"><?php echo htmlspecialchars($certificate['duration']); ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Issue Date:</span>
                    <span class="detail-value"><?php echo date('F d, Y', strtotime($certificate['issue_date'])); ?></span>
                </div>
            </div>
        </div>
        
        <div class="certificate-footer">
            <div class="signature-block">
                <div class="signature-line"></div>
                <div class="signature-name">Authorized Signatory</div>
            </div>
            <div class="signature-block">
                <div class="signature-line"></div>
                <div class="signature-name">Date</div>
            </div>
        </div>
        
        <div class="certificate-number">
            Certificate Number: <strong><?php echo htmlspecialchars($certificate['certificate_number']); ?></strong>
        </div>
    </div>
    
    <script>
        // Auto-print on load if print parameter is set
        if (window.location.search.includes('autoprint=1')) {
            window.onload = function() {
                window.print();
            };
        }
    </script>
</body>
</html>

