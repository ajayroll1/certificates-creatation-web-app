-- Complete Database Setup for Certificate Generation & Verification System
-- Database Name: certificates
-- Run this file in phpMyAdmin or MySQL command line to set up the complete database

-- Create Database
CREATE DATABASE IF NOT EXISTS certificates CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE certificates;

-- Drop existing tables if they exist (for fresh install)
DROP TABLE IF EXISTS certificates;
DROP TABLE IF EXISTS admins;

-- Admins Table
CREATE TABLE admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(50) DEFAULT 'admin',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Certificates Table
CREATE TABLE certificates (
    id INT AUTO_INCREMENT PRIMARY KEY,
    certificate_number VARCHAR(100) UNIQUE NOT NULL,
    employee_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    course_name VARCHAR(255) NOT NULL,
    duration VARCHAR(100) NOT NULL,
    issue_date DATE NOT NULL,
    status BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create Indexes for faster searches
CREATE INDEX idx_certificate_number ON certificates(certificate_number);
CREATE INDEX idx_status ON certificates(status);
CREATE INDEX idx_issue_date ON certificates(issue_date);
CREATE INDEX idx_email ON certificates(email);
CREATE INDEX idx_employee_name ON certificates(employee_name);

-- Insert Default Admin Account
-- Username: admin
-- Password: admin123
-- Note: Password hash is generated using PHP password_hash() function
-- You should run setup.php to create/update admin password properly
INSERT INTO admins (username, password, role) VALUES 
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');

-- Sample Certificates Data (Optional - for testing)
INSERT INTO certificates (certificate_number, employee_name, email, phone, course_name, duration, issue_date, status) VALUES
('CERT-2025-00123', 'John Doe', 'john.doe@example.com', '+1234567890', 'Web Development Fundamentals', '40 hours', '2025-01-15', 1),
('CERT-2025-00124', 'Jane Smith', 'jane.smith@example.com', '+1234567891', 'Python Programming', '60 hours', '2025-01-20', 1),
('CERT-2025-00125', 'Mike Johnson', 'mike.johnson@example.com', '+1234567892', 'Data Science Basics', '80 hours', '2025-02-01', 1),
('CERT-2025-00126', 'Sarah Williams', 'sarah.williams@example.com', '+1234567893', 'Digital Marketing', '30 hours', '2025-02-10', 1),
('CERT-2025-00127', 'David Brown', 'david.brown@example.com', '+1234567894', 'Cloud Computing', '50 hours', '2025-02-15', 0);

-- Success message
SELECT 'Database setup completed successfully!' AS message;
SELECT 'Database: certificates' AS info;
SELECT 'Tables created: admins, certificates' AS info;
SELECT 'Default admin username: admin' AS info;
SELECT 'IMPORTANT: Run setup.php to set admin password properly!' AS warning;

