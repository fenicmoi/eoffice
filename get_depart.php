<?php
include('library/config.php');
include('library/database.php');
$type_id = $_GET['type_id'];
$sql = "SELECT * FROM  depart  WHERE type_id = $type_id";
//$sql = "SELECT * FROM  depart  WHERE type_id = 2";
//echo $sql;
$query = dbQuery($sql);
$json = array();
while($result = dbFetchAssoc($query)) {    
array_push($json, $result);
}
echo json_encode($json);
?>
