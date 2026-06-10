<?php
require_once "library/config.php";
require_once "library/database.php";
$res = dbQuery("SELECT COUNT(*) as c FROM paper WHERE title IS NULL");
echo "Null title count: " . dbFetchAssoc($res)['c'] . "\n";
$res2 = dbQuery("SELECT COUNT(*) as c FROM paper WHERE dep_name IS NULL"); // wait, dep_name is from d.dep_name
// let's just check title and postdate
?>
