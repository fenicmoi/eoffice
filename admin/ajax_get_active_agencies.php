<?php
// AJAX endpoint for getting detailed info about active agencies and users
ob_start();
header('Content-Type: application/json');
require_once '../chksession.php';
require_once '../library/database.php';

if (ob_get_length())
    ob_clean();

// Query for active agencies and user counts
$sql = "SELECT d.dep_name, t.type_name, COUNT(uo.session) as user_count 
        FROM user_online uo
        LEFT JOIN depart d ON uo.dep_id = d.dep_id
        LEFT JOIN office_type t ON d.type_id = t.type_id
        WHERE uo.dep_id IS NOT NULL AND uo.dep_id != 0
        GROUP BY uo.dep_id, d.dep_name, t.type_name
        ORDER BY user_count DESC, d.dep_name ASC";

$result = dbQuery($sql);
$agencies = [];
if ($result) {
    while ($row = dbFetchArray($result)) {
        $agencies[] = [
            'agency_name' => $row['dep_name'] ?? 'ไม่ระบุชื่อหน่วยงาน',
            'agency_type' => $row['type_name'] ?? 'ไม่ระบุ',
            'user_count' => (int) $row['user_count']
        ];
    }
}

// Also get total active users and agencies
$totalUsers = 0;
foreach ($agencies as $a) {
    $totalUsers += $a['user_count'];
}
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