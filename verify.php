<?php
require_once 'config/database.php';
require_once 'includes/functions.php';

$certificateNumber = isset($_GET['number']) ? sanitizeInput($_GET['number']) : '';
$certificate = null;

if (!empty($certificateNumber)) {
    $certificate = verifyCertificate($certificateNumber);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verification Result - Certificate System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --success-color: #10b981;
            --danger-color: #ef4444;
            --text-dark: #1f2937;
            --text-light: #6b7280;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            min-height: 100vh;
            padding: 20px;
        }
        
        .result-container {
            max-width: 800px;
            margin: 50px auto;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 30px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            padding: 50px;
            animation: slideUp 0.8s ease-out;
        }
        
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .result-header {
            text-align: center;
            margin-bottom: 40px;
        }
        
        .result-icon {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            font-size: 50px;
            color: white;
        }
        
        .result-icon.success {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            box-shadow: 0 10px 30px rgba(16, 185, 129, 0.4);
        }
        
        .result-icon.error {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            box-shadow: 0 10px 30px rgba(239, 68, 68, 0.4);
        }
        
        .result-title {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 10px;
        }
        
        .result-title.success {
            color: var(--success-color);
        }
        
        .result-title.error {
            color: var(--danger-color);
        }
        
        .certificate-details {
            background: #f9fafb;
            border-radius: 20px;
            padding: 30px;
            margin-top: 30px;
        }
        
        .detail-item {
            display: flex;
            justify-content: space-between;
            padding: 15px 0;
            border-bottom: 1px solid #e5e7eb;
        }
        
        .detail-item:last-child {
            border-bottom: none;
        }
        
        .detail-label {
            font-weight: 600;
            color: var(--text-dark);
        }
        
        .detail-value {
            color: var(--text-light);
            text-align: right;
        }
        
        .status-badge {
            display: inline-block;
            padding: 8px 20px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.9rem;
        }
        
        .status-badge.valid {
            background: #d1fae5;
            color: #065f46;
        }
        
        .btn-back {
            background: var(--primary-gradient);
            border: none;
            border-radius: 15px;
            padding: 12px 30px;
            color: white;
            font-weight: 600;
            margin-top: 30px;
            transition: all 0.3s;
        }
        
        .btn-back:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
            color: white;
        }
        
        .error-message {
            text-align: center;
            padding: 30px;
            color: var(--text-light);
        }
        
        @media (max-width: 768px) {
            .result-container {
                padding: 30px 20px;
            }
            
            .detail-item {
                flex-direction: column;
            }
            
            .detail-value {
                text-align: left;
                margin-top: 5px;
            }
        }
    </style>
</head>
<body>
    <div class="result-container">
        <?php if ($certificate): ?>
            <!-- Valid Certificate -->
            <div class="result-header">
                <div class="result-icon success">
                    <i class="fas fa-check"></i>
                </div>
                <h2 class="result-title success">Certificate Verified!</h2>
                <p style="color: var(--text-light);">This certificate is valid and authentic</p>
            </div>
            
            <div class="certificate-details">
                <div class="detail-item">
                    <span class="detail-label"><i class="fas fa-user me-2"></i>Employee Name</span>
                    <span class="detail-value"><?php echo htmlspecialchars($certificate['employee_name']); ?></span>
                </div>
                <div class="detail-item">
                    <span class="detail-label"><i class="fas fa-book me-2"></i>Course Name</span>
                    <span class="detail-value"><?php echo htmlspecialchars($certificate['course_name']); ?></span>
                </div>
                <div class="detail-item">
                    <span class="detail-label"><i class="fas fa-clock me-2"></i>Duration</span>
                    <span class="detail-value"><?php echo htmlspecialchars($certificate['duration']); ?></span>
                </div>
                <div class="detail-item">
                    <span class="detail-label"><i class="fas fa-calendar me-2"></i>Issue Date</span>
                    <span class="detail-value"><?php echo date('F d, Y', strtotime($certificate['issue_date'])); ?></span>
                </div>
                <div class="detail-item">
                    <span class="detail-label"><i class="fas fa-hashtag me-2"></i>Certificate Number</span>
                    <span class="detail-value"><?php echo htmlspecialchars($certificate['certificate_number']); ?></span>
                </div>
                <div class="detail-item">
                    <span class="detail-label"><i class="fas fa-envelope me-2"></i>Email</span>
                    <span class="detail-value"><?php echo htmlspecialchars($certificate['email']); ?></span>
                </div>
                <div class="detail-item">
                    <span class="detail-label"><i class="fas fa-info-circle me-2"></i>Status</span>
                    <span class="detail-value">
                        <span class="status-badge valid">✅ Valid</span>
                    </span>
                </div>
            </div>
            
            <div class="text-center">
                <a href="index.php" class="btn btn-back">
                    <i class="fas fa-arrow-left me-2"></i>Verify Another Certificate
                </a>
            </div>
            
        <?php else: ?>
            <!-- Invalid Certificate -->
            <div class="result-header">
                <div class="result-icon error">
                    <i class="fas fa-times"></i>
                </div>
                <h2 class="result-title error">Certificate Not Found</h2>
            </div>
            
            <div class="error-message">
                <p style="font-size: 1.1rem; margin-bottom: 20px;">
                    ❌ The certificate number you entered could not be found in our system.
                </p>
                <p style="color: var(--text-light);">
                    Please check the certificate number and try again. If you believe this is an error, please contact support.
                </p>
            </div>
            
            <div class="text-center">
                <a href="index.php" class="btn btn-back">
                    <i class="fas fa-arrow-left me-2"></i>Try Again
                </a>
            </div>
        <?php endif; ?>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

