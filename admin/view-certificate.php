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
?>
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2><i class="fas fa-eye me-2"></i>View Certificate</h2>
                    <div>
                        <a href="edit-certificate.php?id=<?php echo $certificate['id']; ?>" class="btn btn-warning">
                            <i class="fas fa-edit me-2"></i>Edit
                        </a>
                        <a href="manage-certificates.php" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Back
                        </a>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <strong>Certificate Number:</strong>
                                <p class="text-muted"><?php echo htmlspecialchars($certificate['certificate_number']); ?></p>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <strong>Status:</strong>
                                <p>
                                    <?php if ($certificate['status']): ?>
                                        <span class="badge bg-success">Active</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Revoked</span>
                                    <?php endif; ?>
                                </p>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <strong>Employee Name:</strong>
                                <p class="text-muted"><?php echo htmlspecialchars($certificate['employee_name']); ?></p>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <strong>Email:</strong>
                                <p class="text-muted"><?php echo htmlspecialchars($certificate['email']); ?></p>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <strong>Phone:</strong>
                                <p class="text-muted"><?php echo htmlspecialchars($certificate['phone'] ?: 'N/A'); ?></p>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <strong>Course Name:</strong>
                                <p class="text-muted"><?php echo htmlspecialchars($certificate['course_name']); ?></p>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <strong>Duration:</strong>
                                <p class="text-muted"><?php echo htmlspecialchars($certificate['duration']); ?></p>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <strong>Issue Date:</strong>
                                <p class="text-muted"><?php echo date('F d, Y', strtotime($certificate['issue_date'])); ?></p>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <strong>Created At:</strong>
                                <p class="text-muted"><?php echo date('F d, Y h:i A', strtotime($certificate['created_at'])); ?></p>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <strong>Last Updated:</strong>
                                <p class="text-muted"><?php echo date('F d, Y h:i A', strtotime($certificate['updated_at'])); ?></p>
                            </div>
                        </div>
                        
                        <hr>
                        
                        <hr>
                        
                        <div class="mt-4">
                            <h5>Actions</h5>
                            <div class="d-flex gap-2 flex-wrap">
                                <a href="print-certificate.php?id=<?php echo $certificate['id']; ?>" 
                                   target="_blank" 
                                   class="btn btn-success">
                                    <i class="fas fa-print me-2"></i>Print Certificate
                                </a>
                                <a href="../verify.php?number=<?php echo urlencode($certificate['certificate_number']); ?>" 
                                   target="_blank" 
                                   class="btn btn-info">
                                    <i class="fas fa-external-link-alt me-2"></i>View Verification Page
                                </a>
                            </div>
                        </div>
                        
                        <div class="mt-4">
                            <h5>Verification Link</h5>
                            <div class="input-group mb-3">
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="verifyLink" 
                                    value="<?php echo (isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . dirname(dirname($_SERVER['PHP_SELF'])) . '/verify.php?number=' . urlencode($certificate['certificate_number']); ?>"
                                    readonly
                                >
                                <button class="btn btn-outline-secondary" type="button" onclick="copyToClipboard()">
                                    <i class="fas fa-copy me-2"></i>Copy Link
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <script>
                    function copyToClipboard() {
                        const link = document.getElementById('verifyLink');
                        link.select();
                        document.execCommand('copy');
                        alert('Link copied to clipboard!');
                    }
                </script>
<?php require_once 'includes/footer.php'; ?>

