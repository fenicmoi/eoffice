<?php
    session_start();
	session_destroy();	
        include 'function.php';
	header('Location:index_admin.php');
        mysqli_close($conn);
	//exit;
?>