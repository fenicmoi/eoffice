<?php
$hostname = "localhost"; 
$user = "root"; 
$password = "hellojava"; // รหัสผ่านฐานข้อมูล
$dbname = "phangnga_office"; 
$connection=@mysql_connect($hostname, $user, $password) or die("fail connection");
mysql_query("SET NAMES UTF-8",$connection);
mysql_query("SET character_set_results=utf8");
mysql_query("SET character_set_client=utf8");
mysql_query("SET character_set_connection=utf8");

$sql="select day from meeting_day";
$dbquery=@mysql_db_query($dbname, $sql);
$result=@mysql_fetch_array($dbquery);

$config_day=$result[0];
?>