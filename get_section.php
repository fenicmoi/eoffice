<?php
include('library/config.php');
include('library/database.php');
$sql = "SELECT * FROM section WHERE depart_id = ?";
$query = dbQuery($sql, "i", [(int)$_GET['depart_id']]);
$json = array();
while($result = dbFetchAssoc($query)) {    
array_push($json, $result);
}
echo json_encode($json);