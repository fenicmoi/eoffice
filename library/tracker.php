<?php
// Script to track visitors and online users
// Assumes $dbConn is available from library/database.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

date_default_timezone_set('Asia/Bangkok');

// --- 1. Track Daily Visitors ---
$ip_address = $_SERVER['REMOTE_ADDR'] ?? 'UNKNOWN';
$visit_date = date('Y-m-d');
$visit_time = date('H:i:s');
$user_agent = $_SERVER['HTTP_USER_AGENT'] ?? '';

if (isset($dbConn) && $dbConn instanceof mysqli) {
    $stmtVisitor = $dbConn->prepare("INSERT IGNORE INTO visitor_logs (ip_address, visit_date, visit_time, user_agent) VALUES (?, ?, ?, ?)");
    if ($stmtVisitor) {
        $stmtVisitor->bind_param("ssss", $ip_address, $visit_date, $visit_time, $user_agent);
        $stmtVisitor->execute();
        $stmtVisitor->close();
    }
}

// --- 2. Track Online Users ---
$session_id = session_id();
$current_time = date('Y-m-d H:i:s');
$user_id = $_SESSION['ses_u_id'] ?? null;

if (isset($dbConn) && $dbConn instanceof mysqli && !empty($session_id)) {
    // Insert or update current online session
    $stmtOnline = $dbConn->prepare("
        INSERT INTO online_users (session_id, ip_address, last_activity, user_id) 
        VALUES (?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE last_activity = ?, user_id = ?
    ");
    if ($stmtOnline) {
        $stmtOnline->bind_param("sssisi", $session_id, $ip_address, $current_time, $user_id, $current_time, $user_id);
        $stmtOnline->execute();
        $stmtOnline->close();
    }

    // Clean up inactive sessions (older than 15 minutes)
    $timeout_minutes = 15;
    $timeout_time = date('Y-m-d H:i:s', strtotime("-$timeout_minutes minutes"));
    $stmtClean = $dbConn->prepare("DELETE FROM online_users WHERE last_activity < ?");
    if ($stmtClean) {
        $stmtClean->bind_param("s", $timeout_time);
        $stmtClean->execute();
        $stmtClean->close();
    }
}
?>
