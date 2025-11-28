-- Sample Data for Testing
-- Run this after importing schema.sql

USE certificates;

-- Sample Certificates
INSERT INTO certificates (certificate_number, employee_name, email, phone, course_name, duration, issue_date, status) VALUES
('CERT-2025-00123', 'John Doe', 'john.doe@example.com', '+1234567890', 'Web Development Fundamentals', '40 hours', '2025-01-15', 1),
('CERT-2025-00124', 'Jane Smith', 'jane.smith@example.com', '+1234567891', 'Python Programming', '60 hours', '2025-01-20', 1),
('CERT-2025-00125', 'Mike Johnson', 'mike.johnson@example.com', '+1234567892', 'Data Science Basics', '80 hours', '2025-02-01', 1),
('CERT-2025-00126', 'Sarah Williams', 'sarah.williams@example.com', '+1234567893', 'Digital Marketing', '30 hours', '2025-02-10', 1),
('CERT-2025-00127', 'David Brown', 'david.brown@example.com', '+1234567894', 'Cloud Computing', '50 hours', '2025-02-15', 0);

-- Note: Admin account should be created using setup.php or manually

