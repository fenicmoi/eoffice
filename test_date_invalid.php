<?php
require_once "library/config.php";
require_once "library/database.php";
$res = dbQuery("SELECT pid, postdate FROM paper WHERE postdate IS NULL OR postdate = '' OR postdate NOT LIKE '%-%'");
echo "Invalid postdate count: " . dbNumRows($res) . "\n";
while($row = dbFetchAssoc($res)) {
    print_r($row);
}
?>
