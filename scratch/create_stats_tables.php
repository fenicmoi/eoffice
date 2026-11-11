<?php
$dbHost = 'localhost';
$dbUser = 'root';
$dbPass = '';
$dbName = 'phatthalun_eoffice';

$dbConn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);
if ($dbConn->connect_error) {
    die("Connection failed: " . $dbConn->connect_error);
}

// 1. visitor_logs
$sqlVisitor = "
CREATE TABLE IF NOT EXISTS visitor_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ip_address VARCHAR(45) NOT NULL,
    visit_date DATE NOT NULL,
    visit_time TIME NOT NULL,
    user_agent TEXT,
    UNIQUE KEY unique_visit_per_day (ip_address, visit_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
";

if ($dbConn->query($sqlVisitor) === TRUE) {
    echo "Table visitor_logs created successfully.\n";
} else {
    echo "Error creating visitor_logs: " . $dbConn->error . "\n";
}

// 2. online_users
$sqlOnline = "
CREATE TABLE IF NOT EXISTS online_users (
    session_id VARCHAR(128) PRIMARY KEY,
    ip_address VARCHAR(45) NOT NULL,
    last_activity DATETIME NOT NULL,
    user_id INT DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
";

if ($dbConn->query($sqlOnline) === TRUE) {
    echo "Table online_users created successfully.\n";
} else {
    echo "Error creating online_users: " . $dbConn->error . "\n";
}

$dbConn->close();
echo "Done.\n";
?>
