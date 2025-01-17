
<?php
date_default_timezone_set('Asia/Bangkok');
include 'function.php';
include '../library/database.php';

$pid=$_POST['pid'];
$puid=$_POST['puid'];
$sql="";

//print $sql;
$result=dbQuery($sql);
$row=dbFetchAssoc($result);
?>  

