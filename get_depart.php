<?php
include('library/config.php');
include('library/database.php');
$sql = "SELECT * FROM  depart  WHERE depart_id={$_GET['depart_id']}";
$query = dbQuery($sql);
$json = array();
while($result = dbFetchAssoc($query)) {    
array_push($json, $result);
}
echo json_encode($json);
?>