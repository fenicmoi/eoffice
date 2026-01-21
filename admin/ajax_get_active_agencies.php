<?php
// AJAX endpoint for getting detailed info about active agencies and users
header('Content-Type: application/json');
require_once '../chksession.php';
require_once '../library/database.php';

// Query for active agencies and user counts
$sql = "SELECT d.dep_name, t.type_name, COUNT(uo.session) as user_count 
        FROM user_online uo
        INNER JOIN depart d ON uo.dep_id = d.dep_id
        LEFT JOIN office_type t ON d.type_id = t.type_id
        WHERE uo.dep_id != 0
        GROUP BY uo.dep_id
        ORDER BY user_count DESC, d.dep_name ASC";

$result = dbQuery($sql);
$agencies = [];
while ($row = dbFetchArray($result)) {
    $agencies[] = [
        'agency_name' => $row['dep_name'],
        'agency_type' => $row['type_name'] ?? 'ไม่ระบุ',
        'user_count' => $row['user_count']
    ];
}

// Also get total active users and agencies
$totalUsers = array_sum(array_column($agencies, 'user_count'));
$totalAgencies = count($agencies);

echo json_encode([
    'success' => true,
    'data' => [
        'agencies' => $agencies,
        'totalAgencies' => $totalAgencies,
        'totalUsers' => $totalUsers
    ],
    'timestamp' => date('d/m/Y H:i:s')
]);
?>