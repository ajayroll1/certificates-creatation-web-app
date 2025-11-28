<?php
require_once '../config/database.php';
require_once '../includes/functions.php';
require_once 'includes/header.php';

$search = isset($_GET['search']) ? sanitizeInput($_GET['search']) : '';
$certificates = [];

if (!empty($search)) {
    $conn = getDBConnection();
    $searchTerm = "%$search%";
    $stmt = $conn->prepare("SELECT * FROM certificates WHERE certificate_number LIKE ? OR employee_name LIKE ? OR email LIKE ? OR course_name LIKE ? ORDER BY created_at DESC");
    $stmt->bind_param("ssss", $searchTerm, $searchTerm, $searchTerm, $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();
    
    while ($row = $result->fetch_assoc()) {
        $certificates[] = $row;
    }
} else {
    $certificates = getAllCertificates(100, 0);
}

$message = '';
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    if (deleteCertificate($_GET['delete'])) {
        $message = '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>Certificate deleted successfully!
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>';
        header("Location: manage-certificates.php?deleted=1");
        exit;
    }
}
?>
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2><i class="fas fa-list me-2"></i>Manage Certificates</h2>
                    <a href="create-certificate.php" class="btn btn-primary">
                        <i class="fas fa-plus-circle me-2"></i>Create New
                    </a>
                </div>
                
                <?php if (isset($_GET['deleted'])): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>Certificate deleted successfully!
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
                
                <!-- Search Bar -->
                <div class="card mb-4">
                    <div class="card-body">
                        <form method="GET" action="" class="row g-3">
                            <div class="col-md-10">
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    name="search" 
                                    placeholder="Search by certificate number, employee name, email, or course name..."
                                    value="<?php echo htmlspecialchars($search); ?>"
                                >
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-search me-2"></i>Search
                                </button>
                            </div>
                        </form>
                        <?php if (!empty($search)): ?>
                            <div class="mt-2">
                                <a href="manage-certificates.php" class="text-decoration-none">
                                    <i class="fas fa-times me-2"></i>Clear Search
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Certificates Table -->
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Certificate Number</th>
                                        <th>Employee Name</th>
                                        <th>Email</th>
                                        <th>Course</th>
                                        <th>Issue Date</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($certificates)): ?>
                                        <tr>
                                            <td colspan="8" class="text-center text-muted py-5">
                                                <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                                                No certificates found. <?php echo !empty($search) ? 'Try a different search term.' : 'Create your first certificate!'; ?>
                                            </td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($certificates as $cert): ?>
                                            <tr>
                                                <td><?php echo $cert['id']; ?></td>
                                                <td>
                                                    <strong><?php echo htmlspecialchars($cert['certificate_number']); ?></strong>
                                                </td>
                                                <td><?php echo htmlspecialchars($cert['employee_name']); ?></td>
                                                <td><?php echo htmlspecialchars($cert['email']); ?></td>
                                                <td><?php echo htmlspecialchars($cert['course_name']); ?></td>
                                                <td><?php echo date('M d, Y', strtotime($cert['issue_date'])); ?></td>
                                                <td>
                                                    <?php if ($cert['status']): ?>
                                                        <span class="badge bg-success">Active</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-danger">Revoked</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <a href="view-certificate.php?id=<?php echo $cert['id']; ?>" 
                                                           class="btn btn-sm btn-info" 
                                                           title="View">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a href="print-certificate.php?id=<?php echo $cert['id']; ?>" 
                                                           target="_blank"
                                                           class="btn btn-sm btn-success" 
                                                           title="Print">
                                                            <i class="fas fa-print"></i>
                                                        </a>
                                                        <a href="edit-certificate.php?id=<?php echo $cert['id']; ?>" 
                                                           class="btn btn-sm btn-warning" 
                                                           title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <a href="manage-certificates.php?delete=<?php echo $cert['id']; ?>" 
                                                           class="btn btn-sm btn-danger" 
                                                           title="Delete"
                                                           onclick="return confirm('Are you sure you want to delete this certificate?');">
                                                            <i class="fas fa-trash"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
<?php require_once 'includes/footer.php'; ?>

