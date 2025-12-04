<?php
// Database Initialization - Run this once to setup database and tables
require_once 'database.php';

// Initialize database tables
function initDatabase() {
    // Try to connect without database first
    @$conn = new mysqli(DB_HOST, DB_USER, DB_PASS);
    
    if ($conn->connect_error) {
        // If connection fails, try with empty password
        $conn = new mysqli(DB_HOST, DB_USER, '');
        if ($conn->connect_error) {
            // Connection failed, return false
            return false;
        }
    }
    
    // Create database if it doesn't exist
    $sql = "CREATE DATABASE IF NOT EXISTS " . DB_NAME;
    $conn->query($sql);
    
    $conn->close();
    
    // Now connect to the database
    $conn = getDBConnection();
    
    // Create admin table
    $sql = "CREATE TABLE IF NOT EXISTS admins (
        id INT AUTO_INCREMENT PRIMARY KEY,
        email VARCHAR(255) UNIQUE NOT NULL,
        password VARCHAR(255) NOT NULL,
        name VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    $conn->query($sql);
    
    // Create certificates table
    $sql = "CREATE TABLE IF NOT EXISTS certificates (
        id INT AUTO_INCREMENT PRIMARY KEY,
        certificate_id VARCHAR(50) UNIQUE NOT NULL,
        student_name VARCHAR(255) NOT NULL,
        student_email VARCHAR(255) NOT NULL,
        student_phone VARCHAR(20) NOT NULL,
        course_name VARCHAR(255) NOT NULL,
        starting_date DATE NOT NULL,
        completion_date DATE NOT NULL,
        issue_date DATE NOT NULL,
        status VARCHAR(20) DEFAULT 'active',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    $conn->query($sql);
    
    // Add new columns if table already exists (for migration from old version)
    // Check and add student_email column
    $result = $conn->query("SHOW COLUMNS FROM certificates LIKE 'student_email'");
    if ($result->num_rows == 0) {
        $conn->query("ALTER TABLE certificates ADD COLUMN student_email VARCHAR(255) DEFAULT '' AFTER student_name");
    }
    
    // Check and add student_phone column
    $result = $conn->query("SHOW COLUMNS FROM certificates LIKE 'student_phone'");
    if ($result->num_rows == 0) {
        $conn->query("ALTER TABLE certificates ADD COLUMN student_phone VARCHAR(20) DEFAULT '' AFTER student_email");
    }
    
    // Check and add starting_date column
    $result = $conn->query("SHOW COLUMNS FROM certificates LIKE 'starting_date'");
    if ($result->num_rows == 0) {
        $conn->query("ALTER TABLE certificates ADD COLUMN starting_date DATE DEFAULT (CURDATE()) AFTER course_name");
    }
    
    // Insert default admin if not exists
    $checkAdmin = "SELECT COUNT(*) as count FROM admins WHERE email = 'admin@learnhub.com'";
    $result = $conn->query($checkAdmin);
    $row = $result->fetch_assoc();
    
    if ($row['count'] == 0) {
        $defaultPassword = password_hash('Admin@123', PASSWORD_DEFAULT);
        $insertAdmin = "INSERT INTO admins (email, password, name) VALUES ('admin@learnhub.com', '$defaultPassword', 'Admin User')";
        $conn->query($insertAdmin);
    }
    
    $conn->close();
    return true;
}

// Auto-initialize on first load (only if session is started)
if (session_status() === PHP_SESSION_ACTIVE && !isset($_SESSION['db_initialized'])) {
    try {
        initDatabase();
        $_SESSION['db_initialized'] = true;
    } catch (Exception $e) {
        // Silently fail if database initialization fails
        // User can manually create database if needed
    }
}
?>

