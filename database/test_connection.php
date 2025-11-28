<?php
/**
 * Database Connection Test Script
 * Use this to verify your database setup is working correctly
 * Delete this file after testing for security
 */

require_once '../config/database.php';

echo "<!DOCTYPE html>
<html>
<head>
    <title>Database Connection Test</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; background: #f5f5f5; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h1 { color: #333; border-bottom: 3px solid #667eea; padding-bottom: 10px; }
        .success { background: #d1fae5; color: #065f46; padding: 15px; border-radius: 5px; margin: 10px 0; }
        .error { background: #fee2e2; color: #991b1b; padding: 15px; border-radius: 5px; margin: 10px 0; }
        .info { background: #dbeafe; color: #1e40af; padding: 15px; border-radius: 5px; margin: 10px 0; }
        .warning { background: #fef3c7; color: #92400e; padding: 15px; border-radius: 5px; margin: 10px 0; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #667eea; color: white; }
        tr:hover { background: #f5f5f5; }
        .check { color: #10b981; font-weight: bold; }
        .cross { color: #ef4444; font-weight: bold; }
    </style>
</head>
<body>
<div class='container'>
    <h1>🔍 Database Connection Test</h1>";

try {
    // Test 1: Database Connection
    echo "<h2>Test 1: Database Connection</h2>";
    $conn = getDBConnection();
    echo "<div class='success'>✅ Database connection successful!</div>";
    echo "<div class='info'><strong>Database:</strong> " . DB_NAME . "<br><strong>Host:</strong> " . DB_HOST . "<br><strong>User:</strong> " . DB_USER . "</div>";
    
    // Test 2: Check if database exists
    echo "<h2>Test 2: Database Exists</h2>";
    $result = $conn->query("SELECT DATABASE() as db");
    $row = $result->fetch_assoc();
    if ($row['db'] === DB_NAME) {
        echo "<div class='success'>✅ Connected to database: <strong>" . $row['db'] . "</strong></div>";
    } else {
        echo "<div class='error'>❌ Not connected to expected database. Current: " . ($row['db'] ?? 'None') . "</div>";
    }
    
    // Test 3: Check Tables
    echo "<h2>Test 3: Tables Check</h2>";
    $tables = ['admins', 'certificates'];
    $allTablesExist = true;
    
    echo "<table>";
    echo "<tr><th>Table Name</th><th>Status</th><th>Row Count</th></tr>";
    
    foreach ($tables as $table) {
        $result = $conn->query("SHOW TABLES LIKE '$table'");
        if ($result->num_rows > 0) {
            $countResult = $conn->query("SELECT COUNT(*) as count FROM $table");
            $count = $countResult->fetch_assoc()['count'];
            echo "<tr><td><strong>$table</strong></td><td><span class='check'>✅ Exists</span></td><td>$count rows</td></tr>";
        } else {
            echo "<tr><td><strong>$table</strong></td><td><span class='cross'>❌ Missing</span></td><td>-</td></tr>";
            $allTablesExist = false;
        }
    }
    echo "</table>";
    
    if (!$allTablesExist) {
        echo "<div class='error'>❌ Some tables are missing! Please import database/install.sql or database/schema.sql</div>";
    }
    
    // Test 4: Test Data Fetching
    echo "<h2>Test 4: Data Fetching Test</h2>";
    if ($allTablesExist) {
        // Test certificates fetch
        $result = $conn->query("SELECT * FROM certificates LIMIT 5");
        $certCount = $result->num_rows;
        echo "<div class='success'>✅ Can fetch certificates data. Found $certCount certificate(s) in database.</div>";
        
        if ($certCount > 0) {
            echo "<table>";
            echo "<tr><th>ID</th><th>Certificate Number</th><th>Employee Name</th><th>Course</th><th>Status</th></tr>";
            while ($row = $result->fetch_assoc()) {
                $status = $row['status'] ? 'Active' : 'Revoked';
                echo "<tr><td>{$row['id']}</td><td>{$row['certificate_number']}</td><td>{$row['employee_name']}</td><td>{$row['course_name']}</td><td>$status</td></tr>";
            }
            echo "</table>";
        }
        
        // Test admins fetch
        $result = $conn->query("SELECT COUNT(*) as count FROM admins");
        $adminCount = $result->fetch_assoc()['count'];
        echo "<div class='info'>ℹ️ Found $adminCount admin account(s) in database.</div>";
    }
    
    // Test 5: Test Data Insert (Test Insert)
    echo "<h2>Test 5: Data Insert Test</h2>";
    if ($allTablesExist) {
        $testCertNumber = 'TEST-' . time();
        $stmt = $conn->prepare("INSERT INTO certificates (certificate_number, employee_name, email, phone, course_name, duration, issue_date, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $name = "Test Employee";
        $email = "test@example.com";
        $phone = "+1234567890";
        $course = "Test Course";
        $duration = "1 hour";
        $date = date('Y-m-d');
        $status = 1;
        
        $stmt->bind_param("sssssssi", $testCertNumber, $name, $email, $phone, $course, $duration, $date, $status);
        
        if ($stmt->execute()) {
            echo "<div class='success'>✅ Data insert test successful! Test certificate created: <strong>$testCertNumber</strong></div>";
            
            // Clean up test data
            $conn->query("DELETE FROM certificates WHERE certificate_number = '$testCertNumber'");
            echo "<div class='info'>ℹ️ Test certificate deleted (cleanup).</div>";
        } else {
            echo "<div class='error'>❌ Data insert test failed: " . $conn->error . "</div>";
        }
    }
    
    // Test 6: Functions Test
    echo "<h2>Test 6: PHP Functions Test</h2>";
    require_once '../includes/functions.php';
    
    $functions = [
        'sanitizeInput',
        'verifyCertificate',
        'getAllCertificates',
        'getCertificateById',
        'createCertificate',
        'updateCertificate',
        'deleteCertificate',
        'getDashboardStats',
        'checkAdminLogin'
    ];
    
    echo "<table>";
    echo "<tr><th>Function Name</th><th>Status</th></tr>";
    foreach ($functions as $func) {
        if (function_exists($func)) {
            echo "<tr><td><strong>$func()</strong></td><td><span class='check'>✅ Exists</span></td></tr>";
        } else {
            echo "<tr><td><strong>$func()</strong></td><td><span class='cross'>❌ Missing</span></td></tr>";
        }
    }
    echo "</table>";
    
    // Final Summary
    echo "<h2>📊 Summary</h2>";
    echo "<div class='success'>";
    echo "✅ Database connection: Working<br>";
    echo "✅ Database name: " . DB_NAME . "<br>";
    echo "✅ Tables: " . ($allTablesExist ? "All present" : "Some missing") . "<br>";
    echo "✅ Data operations: " . ($allTablesExist ? "Working" : "Cannot test") . "<br>";
    echo "</div>";
    
    echo "<div class='warning'>";
    echo "⚠️ <strong>Security Note:</strong> Delete this test file (database/test_connection.php) after testing!";
    echo "</div>";
    
} catch (Exception $e) {
    echo "<div class='error'>";
    echo "❌ <strong>Error:</strong> " . $e->getMessage() . "<br><br>";
    echo "<strong>Common Solutions:</strong><br>";
    echo "1. Check database credentials in config/database.php<br>";
    echo "2. Make sure MySQL service is running<br>";
    echo "3. Verify database 'certificates' exists<br>";
    echo "4. Import database/install.sql to create tables<br>";
    echo "</div>";
}

echo "</div></body></html>";
?>

