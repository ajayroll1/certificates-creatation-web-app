-- Certificate Generation & Verification System Database Schema

CREATE DATABASE IF NOT EXISTS certificates;
USE certificates;

-- Admins Table
CREATE TABLE IF NOT EXISTS admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(50) DEFAULT 'admin',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Certificates Table
CREATE TABLE IF NOT EXISTS certificates (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert default admin (username: admin, password: admin123)
-- Password hash for 'admin123' using password_hash()
-- Run setup.php to generate a fresh hash, or use the SQL below after importing
-- INSERT INTO admins (username, password, role) VALUES 
-- ('admin', '$2y$10$YOUR_HASH_HERE', 'admin');
-- 
-- Or run: UPDATE admins SET password = '$2y$10$YOUR_HASH_HERE' WHERE username = 'admin';

-- Create index for faster searches
CREATE INDEX idx_certificate_number ON certificates(certificate_number);
CREATE INDEX idx_status ON certificates(status);
CREATE INDEX idx_issue_date ON certificates(issue_date);

