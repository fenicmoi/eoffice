<?php 
	session_start();
	error_reporting(E_ALL ^ E_NOTICE);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<title>ตรวจสอบการล็อกอิน</title>
<link href="mystyle.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?
include('inc/connect_db.php');
?>
<?php
	$username=$_POST['username'];
	$passwords=$_POST['passwords'];
	$sql="select * from  user where user='$username' and pass='$passwords' and level='2'" ;
	$dbname="phangnga_office";
	$dbquery = @mysql_db_query($dbname, $sql);
	$num_rows = @mysql_num_rows($dbquery);
	$i=0;
	while ($i < $num_rows)
	{
		$result = @mysql_fetch_array($dbquery);
		$name=$result[name];
		$admin_id=$result[uid];
		$i++;
	}
	if($i==0)
	{?>
	
	<script language="javascript">
	alert("ชื่อผู้ใช้ หรือ รหัสผ่าน ไม่ถูกต้อง กรุณาตรวจสอบ");
	window.location='admin.php';
	</script>
<?	 }else{
	 	$sql="select * from  user where user='$username' and pass='$passwords'";
	 	echo $sql;
		$dbname="phangnga_office";
		$dbquery = @mysql_db_query($dbname, $sql);
		$num_rows = @mysql_num_rows($dbquery);
		$i=0;
		while ($i < $num_rows)
		{
		$result = @mysql_fetch_array($dbquery);
		$name=$result[name];
		$admin_id=$result[uid];
		$i++;
}	 	
		$_SESSION['name']=$name;
		$_SESSION['admin_id']=$admin_id;
		//@session_register("name");
		//@session_register("admin_id");
		echo"<meta http-equiv='refresh' content='0;URL=admin/main.php'>";
	 	}?>
</body>
</html>
<?
	@mysql_close();
?>
