<?php
require_once '../library/database.php';

function getCreate($table)
{
    global $dbConn;
    $res = mysqli_query($dbConn, "SHOW CREATE TABLE $table");
    $row = mysqli_fetch_assoc($res);
    echo "--- Table: $table ---" . PHP_EOL;
    echo $row['Create Table'] . ";" . PHP_EOL . PHP_EOL;
}

getCreate('flownormal');
getCreate('flowcircle');
