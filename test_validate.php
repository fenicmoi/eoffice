<?php
$json = file_get_contents('test_history.json');
if(json_decode($json) === null && json_last_error() !== JSON_ERROR_NONE) { 
    echo 'JSON Error: ' . json_last_error_msg(); 
} else { 
    echo 'Valid JSON'; 
}
?>
