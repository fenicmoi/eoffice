<?php
$host="localhost";
$user="root";
$password="";
$database="office2017";

//create connection
 $conn=  mysqli_connect($host, $user, $password,$database);
$conn->query("set names utf8");

if(!$conn){
    die("ไม่สามารถเชื่อมต่อเครื่องแม่ข่ายได้".mysqli_error());
}
?>