<?php
/*
 * connection database
 */
include 'function.php';

$email = isset($_POST['email']) ? trim($_POST['email']) : "";
$Query = mysqli_query("SELECT * FROM user WHERE email='{$email}'");
$Rows = mysqli_num_rows($Query);
if($Rows == 1){
    echo "1";
}
?>