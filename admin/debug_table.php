<?php
include 'header.php';
$result = dbQuery("SELECT * FROM paper_file LIMIT 1");
if ($row = dbFetchAssoc($result)) {
    print_r(array_keys($row));
} else {
    echo "No data in paper_file. Trying SHOW COLUMNS.";
    $result = dbQuery("SHOW COLUMNS FROM paper_file");
    while ($row = dbFetchArray($result)) {
        echo $row[0] . "\n";
    }
}
?>