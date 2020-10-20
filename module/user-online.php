<?php
$sid = session_id();
//print $sid;
$sql="DELETE FROM user_online WHERE expire < NOW()";
dbQuery($sql);

$sql="REPLACE INTO user_online VALUES 
      ('$sid',DATE_ADD(NOW(),INTERVAL 15 MINUTE))";
//print $sql;
dbQuery($sql);

$sql="SELECT COUNT(*) FROM user_online";
$result=dbQuery($sql);
$data=dbFetchArray($result);
$num_users=$data[0];
echo number_format($num_users);
?>