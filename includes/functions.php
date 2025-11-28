<?php
// Helper Functions

function sanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function verifyCertificate($certificateNumber) {
    $conn = getDBConnection();
    $certNumber = sanitizeInput($certificateNumber);
    
    $stmt = $conn->prepare("SELECT * FROM certificates WHERE certificate_number = ? AND status = 1");
    $stmt->bind_param("s", $certNumber);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    }
    
    return null;
}

function getAllCertificates($limit = 100, $offset = 0) {
    $conn = getDBConnection();
    $stmt = $conn->prepare("SELECT * FROM certificates ORDER BY created_at DESC LIMIT ? OFFSET ?");
    $stmt->bind_param("ii", $limit, $offset);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $certificates = [];
    while ($row = $result->fetch_assoc()) {
        $certificates[] = $row;
    }
    
    return $certificates;
}

function getCertificateById($id) {
    $conn = getDBConnection();
    $stmt = $conn->prepare("SELECT * FROM certificates WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    }
    
    return null;
}

function createCertificate($data) {
    $conn = getDBConnection();
    
    $stmt = $conn->prepare("INSERT INTO certificates (certificate_number, employee_name, email, phone, course_name, duration, issue_date, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    
    $status = isset($data['status']) && $data['status'] ? 1 : 1;
    $stmt->bind_param("sssssssi", 
        $data['certificate_number'],
        $data['employee_name'],
        $data['email'],
        $data['phone'],
        $data['course_name'],
        $data['duration'],
        $data['issue_date'],
        $status
    );
    
    if ($stmt->execute()) {
        return $conn->insert_id;
    }
    
    return false;
}

function updateCertificate($id, $data) {
    $conn = getDBConnection();
    
    $stmt = $conn->prepare("UPDATE certificates SET employee_name = ?, email = ?, phone = ?, course_name = ?, duration = ?, issue_date = ?, status = ? WHERE id = ?");
    
    $status = isset($data['status']) ? 1 : 0;
    $stmt->bind_param("ssssssii",
        $data['employee_name'],
        $data['email'],
        $data['phone'],
        $data['course_name'],
        $data['duration'],
        $data['issue_date'],
        $status,
        $id
    );
    
    return $stmt->execute();
}

function deleteCertificate($id) {
    $conn = getDBConnection();
    $stmt = $conn->prepare("UPDATE certificates SET status = 0 WHERE id = ?");
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}

function getDashboardStats() {
    $conn = getDBConnection();
    
    $stats = [];
    
    // Total Certificates
    $result = $conn->query("SELECT COUNT(*) as total FROM certificates");
    $stats['total_certificates'] = $result->fetch_assoc()['total'];
    
    // Active Certificates
    $result = $conn->query("SELECT COUNT(*) as total FROM certificates WHERE status = 1");
    $stats['active_certificates'] = $result->fetch_assoc()['total'];
    
    // Revoked Certificates
    $result = $conn->query("SELECT COUNT(*) as total FROM certificates WHERE status = 0");
    $stats['revoked_certificates'] = $result->fetch_assoc()['total'];
    
    // Unique Courses
    $result = $conn->query("SELECT COUNT(DISTINCT course_name) as total FROM certificates");
    $stats['courses_count'] = $result->fetch_assoc()['total'];
    
    // Unique Employees
    $result = $conn->query("SELECT COUNT(DISTINCT email) as total FROM certificates");
    $stats['employees_count'] = $result->fetch_assoc()['total'];
    
    return $stats;
}

function checkAdminLogin($username, $password) {
    $conn = getDBConnection();
    $stmt = $conn->prepare("SELECT * FROM admins WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $admin = $result->fetch_assoc();
        if (password_verify($password, $admin['password'])) {
            return $admin;
        }
    }
    
    return false;
}
?>

