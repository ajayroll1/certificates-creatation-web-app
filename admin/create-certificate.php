<?php
require_once '../config/database.php';
require_once '../includes/functions.php';
require_once 'includes/header.php';

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'certificate_number' => sanitizeInput($_POST['certificate_number'] ?? ''),
        'employee_name' => sanitizeInput($_POST['employee_name'] ?? ''),
        'email' => sanitizeInput($_POST['email'] ?? ''),
        'phone' => sanitizeInput($_POST['phone'] ?? ''),
        'course_name' => sanitizeInput($_POST['course_name'] ?? ''),
        'duration' => sanitizeInput($_POST['duration'] ?? ''),
        'issue_date' => $_POST['issue_date'] ?? '',
        'status' => isset($_POST['status']) ? 1 : 0
    ];
    
    // Validation
    if (empty($data['certificate_number']) || empty($data['employee_name']) || 
        empty($data['email']) || empty($data['course_name']) || 
        empty($data['duration']) || empty($data['issue_date'])) {
        $error = 'Please fill all required fields';
    } else {
        // Check if certificate number already exists
        $existing = verifyCertificate($data['certificate_number']);
        if ($existing) {
            $error = 'Certificate number already exists. Please use a unique number.';
        } else {
            $result = createCertificate($data);
            if ($result) {
                $success = 'Certificate created successfully!';
                // Clear form data
                $_POST = [];
            } else {
                $error = 'Failed to create certificate. Please try again.';
            }
        }
    }
}
?>
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2><i class="fas fa-plus-circle me-2"></i>Create New Certificate</h2>
                    <a href="dashboard.php" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                    </a>
                </div>
                
                <?php if ($success): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i><?php echo htmlspecialchars($success); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
                
                <?php if ($error): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i><?php echo htmlspecialchars($error); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
                
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="certificate_number" class="form-label">
                                        Certificate Number <span class="text-danger">*</span>
                                    </label>
                                    <input 
                                        type="text" 
                                        class="form-control" 
                                        id="certificate_number" 
                                        name="certificate_number" 
                                        value="<?php echo isset($_POST['certificate_number']) ? htmlspecialchars($_POST['certificate_number']) : ''; ?>"
                                        placeholder="e.g., CERT-2025-00123"
                                        required
                                    >
                                    <small class="text-muted">Must be unique</small>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="employee_name" class="form-label">
                                        Employee Name <span class="text-danger">*</span>
                                    </label>
                                    <input 
                                        type="text" 
                                        class="form-control" 
                                        id="employee_name" 
                                        name="employee_name" 
                                        value="<?php echo isset($_POST['employee_name']) ? htmlspecialchars($_POST['employee_name']) : ''; ?>"
                                        required
                                    >
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">
                                        Email <span class="text-danger">*</span>
                                    </label>
                                    <input 
                                        type="email" 
                                        class="form-control" 
                                        id="email" 
                                        name="email" 
                                        value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
                                        required
                                    >
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input 
                                        type="text" 
                                        class="form-control" 
                                        id="phone" 
                                        name="phone" 
                                        value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?>"
                                        placeholder="+1234567890"
                                    >
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="course_name" class="form-label">
                                        Course Name <span class="text-danger">*</span>
                                    </label>
                                    <input 
                                        type="text" 
                                        class="form-control" 
                                        id="course_name" 
                                        name="course_name" 
                                        value="<?php echo isset($_POST['course_name']) ? htmlspecialchars($_POST['course_name']) : ''; ?>"
                                        required
                                    >
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="duration" class="form-label">
                                        Duration <span class="text-danger">*</span>
                                    </label>
                                    <input 
                                        type="text" 
                                        class="form-control" 
                                        id="duration" 
                                        name="duration" 
                                        value="<?php echo isset($_POST['duration']) ? htmlspecialchars($_POST['duration']) : ''; ?>"
                                        placeholder="e.g., 40 hours, 3 months"
                                        required
                                    >
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="issue_date" class="form-label">
                                        Issue Date <span class="text-danger">*</span>
                                    </label>
                                    <input 
                                        type="date" 
                                        class="form-control" 
                                        id="issue_date" 
                                        name="issue_date" 
                                        value="<?php echo isset($_POST['issue_date']) ? htmlspecialchars($_POST['issue_date']) : date('Y-m-d'); ?>"
                                        required
                                    >
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Status</label>
                                    <div class="form-check form-switch mt-2">
                                        <input 
                                            class="form-check-input" 
                                            type="checkbox" 
                                            id="status" 
                                            name="status" 
                                            checked
                                        >
                                        <label class="form-check-label" for="status">
                                            Active Certificate
                                        </label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-save me-2"></i>Create Certificate
                                </button>
                                <button type="reset" class="btn btn-outline-secondary btn-lg ms-2">
                                    <i class="fas fa-redo me-2"></i>Reset Form
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
<?php require_once 'includes/footer.php'; ?>

