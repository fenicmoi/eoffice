<?php
include "config/db.php";

$sql = "SELECT u_id, firstname, dep_id, sec_id FROM user WHERE level_id = 3 AND (sec_id = 0 OR sec_id IS NULL)";
$res = dbQuery($sql);
echo "Level 3 users with sec_id=0 or NULL:\n";
while($row = dbFetchAssoc($res)) {
    print_r($row);
}

$sql2 = "SELECT d.dep_id, d.dep_name FROM depart d LEFT JOIN user u ON d.dep_id = u.dep_id AND u.level_id = 3 WHERE u.u_id IS NULL";
$res2 = dbQuery($sql2);
echo "\nDepartments with NO level 3 user:\n";
while($row2 = dbFetchAssoc($res2)) {
    print_r($row2);
}
?>
