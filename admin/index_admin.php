<?php
session_start();
if(!isset($_SESSION['ses_u_id'])){
	header("location:../index.php");
	exit;
}

include 'header.php';
include 'deskboard.php';
include 'footer.php';
?>
