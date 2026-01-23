<?php
// AJAX endpoint for refreshing dashboard statistics
header('Content-Type: application/json');
require_once '../chksession.php';
require_once '../library/database.php';

// Query for Active Users
$sqlActiveUsers = "SELECT COUNT(*) as active_users FROM user_online";
$resultActiveUsers = dbQuery($sqlActiveUsers);
$rowActiveUsers = dbFetchArray($resultActiveUsers);
$activeUsers = $rowActiveUsers['active_users'] ?? 0;

// Query for Active Agencies (distinct dep_id from user_online)
$sqlActiveAgencies = "SELECT COUNT(DISTINCT dep_id) as active_agencies FROM user_online WHERE dep_id != 0";
$resultActiveAgencies = dbQuery($sqlActiveAgencies);
$rowActiveAgencies = dbFetchArray($resultActiveAgencies);
$activeAgencies = $rowActiveAgencies['active_agencies'] ?? 0;

// Return JSON response
echo json_encode([
    'success' => true,
    'data' => [
        'activeUsers' => $activeUsers,
        'activeAgencies' => $activeAgencies
    ],
    'timestamp' => date('d/m/Y H:i:s')
]);
?>