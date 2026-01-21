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

// Query for Today's Documents
$sqlTodayDocs = "SELECT COUNT(*) as today_docs FROM book_detail WHERE date_in = CURDATE()";
$resultTodayDocs = dbQuery($sqlTodayDocs);
$rowTodayDocs = dbFetchArray($resultTodayDocs);
$todayDocs = $rowTodayDocs['today_docs'] ?? 0;

// Query for Incoming Documents (Total)
$sqlIncomingTotal = "SELECT COUNT(*) as incoming_total FROM book_master WHERE type_id = 1";
$resultIncomingTotal = dbQuery($sqlIncomingTotal);
$rowIncomingTotal = dbFetchArray($resultIncomingTotal);
$incomingTotal = $rowIncomingTotal['incoming_total'] ?? 0;

// Query for Outgoing Documents (Normal)
$sqlOutgoingNormal = "SELECT COUNT(*) as outgoing_normal FROM book_master WHERE type_id = 2";
$resultOutgoingNormal = dbQuery($sqlOutgoingNormal);
$rowOutgoingNormal = dbFetchArray($resultOutgoingNormal);
$outgoingNormal = $rowOutgoingNormal['outgoing_normal'] ?? 0;

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
        'todayDocs' => $todayDocs,
        'incomingTotal' => $incomingTotal,
        'outgoingNormal' => $outgoingNormal,
        'activeAgencies' => $activeAgencies
    ],
    'timestamp' => date('d/m/Y H:i:s')
]);
?>