<?php
require_once "library/config.php";
require_once "library/database.php";
$res = dbQuery("SELECT postdate FROM paper ORDER BY pid DESC LIMIT 1");
$row = dbFetchAssoc($res);
var_dump($row);
?>
