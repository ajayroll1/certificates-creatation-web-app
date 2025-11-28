<?php
require_once '../config/database.php';
require_once '../includes/functions.php';
require_once 'includes/header.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$certificate = getCertificateById($id);

if (!$certificate) {
    header("Location: manage-certificates.php");
    exit;
}

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
        // Check if certificate number already exists (excluding current record)
        $existing = verifyCertificate($data['certificate_number']);
        if ($existing && $existing['id'] != $id) {
            $error = 'Certificate number already exists. Please use a unique number.';
        } else {
            if (updateCertificate($id, $data)) {
                $success = 'Certificate updated successfully!';
                $certificate = getCertificateById($id); // Refresh data
            } else {
                $error = 'Failed to update certificate. Please try again.';
            }
        }
    }
}
?>
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2><i class="fas fa-edit me-2"></i>Edit Certificate</h2>
                    <a href="manage-certificates.php" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to List
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
                                        value="<?php echo htmlspecialchars($certificate['certificate_number']); ?>"
                                        required
                                    >
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
                                        value="<?php echo htmlspecialchars($certificate['employee_name']); ?>"
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
                                        value="<?php echo htmlspecialchars($certificate['email']); ?>"
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
                                        value="<?php echo htmlspecialchars($certificate['phone']); ?>"
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
                                        value="<?php echo htmlspecialchars($certificate['course_name']); ?>"
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
                                        value="<?php echo htmlspecialchars($certificate['duration']); ?>"
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
                                        value="<?php echo $certificate['issue_date']; ?>"
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
                                            <?php echo $certificate['status'] ? 'checked' : ''; ?>
                                        >
                                        <label class="form-check-label" for="status">
                                            Active Certificate
                                        </label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-save me-2"></i>Update Certificate
                                </button>
                                <a href="manage-certificates.php" class="btn btn-outline-secondary btn-lg ms-2">
                                    <i class="fas fa-times me-2"></i>Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
<?php require_once 'includes/footer.php'; ?>

