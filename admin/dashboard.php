<?php
require_once '../config/database.php';
require_once '../includes/functions.php';
require_once 'includes/header.php';

$stats = getDashboardStats();
?>
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2><i class="fas fa-tachometer-alt me-2"></i>Dashboard</h2>
                    <span class="text-muted">Welcome, <?php echo htmlspecialchars($_SESSION['admin_username']); ?>!</span>
                </div>
                
                <!-- Statistics Cards -->
                <div class="row">
                    <div class="col-md-3">
                        <div class="stat-card">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="stat-number"><?php echo $stats['total_certificates']; ?></div>
                                    <div>Total Certificates</div>
                                </div>
                                <div class="stat-icon">
                                    <i class="fas fa-certificate"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="stat-card success">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="stat-number"><?php echo $stats['active_certificates']; ?></div>
                                    <div>Active Certificates</div>
                                </div>
                                <div class="stat-icon">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="stat-card warning">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="stat-number"><?php echo $stats['revoked_certificates']; ?></div>
                                    <div>Revoked Certificates</div>
                                </div>
                                <div class="stat-icon">
                                    <i class="fas fa-ban"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="stat-card info">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="stat-number"><?php echo $stats['courses_count']; ?></div>
                                    <div>Total Courses</div>
                                </div>
                                <div class="stat-icon">
                                    <i class="fas fa-book"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Quick Actions -->
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-4"><i class="fas fa-bolt me-2"></i>Quick Actions</h5>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <a href="create-certificate.php" class="btn btn-primary w-100">
                                    <i class="fas fa-plus-circle me-2"></i>Create New Certificate
                                </a>
                            </div>
                            <div class="col-md-4 mb-3">
                                <a href="manage-certificates.php" class="btn btn-outline-primary w-100">
                                    <i class="fas fa-list me-2"></i>Manage Certificates
                                </a>
                            </div>
                            <div class="col-md-4 mb-3">
                                <a href="../index.php" target="_blank" class="btn btn-outline-success w-100">
                                    <i class="fas fa-external-link-alt me-2"></i>View Verification Page
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Recent Certificates -->
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-4"><i class="fas fa-clock me-2"></i>Recent Certificates</h5>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Certificate Number</th>
                                        <th>Employee Name</th>
                                        <th>Course</th>
                                        <th>Issue Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $recentCertificates = getAllCertificates(5, 0);
                                    if (empty($recentCertificates)):
                                    ?>
                                        <tr>
                                            <td colspan="5" class="text-center text-muted">No certificates found. Create your first certificate!</td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($recentCertificates as $cert): ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($cert['certificate_number']); ?></td>
                                                <td><?php echo htmlspecialchars($cert['employee_name']); ?></td>
                                                <td><?php echo htmlspecialchars($cert['course_name']); ?></td>
                                                <td><?php echo date('M d, Y', strtotime($cert['issue_date'])); ?></td>
                                                <td>
                                                    <?php if ($cert['status']): ?>
                                                        <span class="badge bg-success">Active</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-danger">Revoked</span>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="text-center mt-3">
                            <a href="manage-certificates.php" class="btn btn-outline-primary">View All Certificates</a>
                        </div>
                    </div>
                </div>
<?php require_once 'includes/footer.php'; ?>

