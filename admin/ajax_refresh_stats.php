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

// Query for Circular Documents
$sqlCircular = "SELECT COUNT(*) as circular_docs FROM book_master WHERE type_id = 3";
$resultCircular = dbQuery($sqlCircular);
$rowCircular = dbFetchArray($resultCircular);
$circularDocs = $rowCircular['circular_docs'] ?? 0;

// Query for Provincial Commands
$sqlCommands = "SELECT COUNT(*) as commands FROM book_master WHERE type_id = 4";
$resultCommands = dbQuery($sqlCommands);
$rowCommands = dbFetchArray($resultCommands);
$commands = $rowCommands['commands'] ?? 0;

// Query for Pending Documents
$sqlPending = "SELECT COUNT(*) as pending_docs FROM book_detail WHERE status = ''";
$resultPending = dbQuery($sqlPending);
$rowPending = dbFetchArray($resultPending);
$pendingDocs = $rowPending['pending_docs'] ?? 0;

// Query for Completed Documents
$sqlCompleted = "SELECT COUNT(*) as completed_docs FROM book_detail WHERE status != ''";
$resultCompleted = dbQuery($sqlCompleted);
$rowCompleted = dbFetchArray($resultCompleted);
$completedDocs = $rowCompleted['completed_docs'] ?? 0;

// Return JSON response
echo json_encode([
    'success' => true,
    'data' => [
        'activeUsers' => $activeUsers,
        'todayDocs' => $todayDocs,
        'incomingTotal' => $incomingTotal,
        'outgoingNormal' => $outgoingNormal,
        'circularDocs' => $circularDocs,
        'commands' => $commands,
        'pendingDocs' => $pendingDocs,
        'completedDocs' => $completedDocs
    ],
    'timestamp' => date('d/m/Y H:i:s')
]);
?>