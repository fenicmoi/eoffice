<?php
header('Content-Type: application/json');
include '../library/database.php';

$data = $_GET['data'] ?? '';
$val = $_GET['val'] ?? '';

if ($data == 'province') {
    // Return list of Province Types (office_type)
    $sql = "SELECT type_id as id, type_name as name FROM office_type ORDER BY type_id";
    $result = dbQuery($sql);
    $response = [];
    while ($row = dbFetchAssoc($result)) {
        $response[] = $row;
    }
    echo json_encode($response);

} else if ($data == 'amphur') {
    // Return list of Departments (Amphur) based on Type ID
    $sql = "SELECT dep_id as id, dep_name as name FROM depart WHERE type_id = ? ORDER BY dep_name";
    $result = dbQuery($sql, 'i', [(int) $val]);
    $response = [];
    while ($row = dbFetchAssoc($result)) {
        $response[] = $row;
    }
    echo json_encode($response);

} else if ($data == 'district') {
    // Return list of Sections (District) based on Department ID
    $sql = "SELECT sec_id as id, sec_name as name FROM section WHERE dep_id = ? ORDER BY sec_name";
    $result = dbQuery($sql, 'i', [(int) $val]);
    $response = [];
    while ($row = dbFetchAssoc($result)) {
        $response[] = $row;
    }
    echo json_encode($response);
}
?>