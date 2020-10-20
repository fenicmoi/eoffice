
<?php

	session_start();
	error_reporting(E_ALL^E_NOTICE);
	include '../inc/connect_db.php';

	$del_room_id=$_GET['del_room_id'];
	$del_rooming=$_GET['del_roomimg'];
	$admin_id=$_SESSION['admin_id'];
	if(!$admin_id){
		echo"<script language=\"javascript\">
	         alert(\"กรุณาเข้าสู่ระบบ
	         window.parent.location=../index.php';
            </script>";  
	} 
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
<link href="../mystyle.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php
	$del_book_id=$_GET['del_book_id'];
	if($del_room_id)
	{
		//echo $del_room_id;
		$sql="delete from meeting_room where room_id='$del_room_id' ";
		//echo "sql=$sql<br";
		$dbquery=@mysql_db_query($dbname, $sql);
		unlink("roomimg/$del_room_id.jpg");
		echo"<script language=\"javascript\">
		alert(\"ดำเนินการลบห้องประชุมเรียบร้อยแล้ว\");
		window.location='meetingroom.php';
		</script>";
	}
	
	$del_tool_id=$_GET['del_tool_id'];
	if($del_tool_id)
	{
		$sql="delete from meeting_tools where tool_id='$del_tool_id' ";
		$dbquery=@mysql_db_query($dbname, $sql);
		echo"<script language=\"javascript\">
		alert(\"del success\");
		window.location='toolmeeting.php';
		</script>";
	}

     $conf_book_id=$_GET['conf_book_id'];
	if($conf_book_id)
	{
		$sql="update meeting_booking set conf_status='2' where book_id='$conf_book_id' ";
		$dbquery=@mysql_db_query($dbname, $sql);
		echo "<script language=\"javascript\">
		alert(\"ดำเนินการยกเลิกการอนุมัติเรียบร้อยแล้ว\");
		window.location='meeting-data-cancel.php';
	</script>";
	}
	
	if($del_user_id)
	{
		$sql="delete from meeting_user where user_id='$del_user_id' ";
		$dbquery=@mysql_db_query($dbname, $sql);
		echo "<script language=\"javascript\">
		alert(\"ดำเนินการลบข้อมูลการจองเรียบร้อยแล้ว\");
		window.location='add_user.php';
	</script>";
	}
	
	$del_dept_id=$_GET['del_dept_id'];
	if($del_dept_id)
	{
		$sql="delete from meeting_department where dept_id='$del_dept_id' ";
		$dbquery=@mysql_db_query($dbname, $sql);
		echo "<script language=\"javascript\">
		alert(\"deleate success\");
		window.location='add_dept.php';
	</script>";
	}
	
	$del_starttime_id=$_GET['del_starttime_id'];
	if($del_starttime_id)
	{
		$sql="delete from meeting_starttime where time_id='$del_starttime_id' ";
		$dbquery=@mysql_db_query($dbname, $sql);
		echo "<script language=\"javascript\">
		alert(\"ร…ยบร รร•รยบรรฉรรยครร‘ยบ\");
		window.location='savetime.php';
	</script>";
	}

	$del_endtime_id=$_GET['del_endtime_id'];
	if($del_endtime_id)
	{
		$sql="delete from meeting_endtime where time_id='$del_endtime_id' ";
		$dbquery=@mysql_db_query($dbname, $sql);
		echo "<script language=\"javascript\">
		alert(\"ร…ยบร รร•รยบรรฉรรยครร‘ยบ\");
		window.location='savetime.php';
	</script>";
	}
	
	if($room_id and $tool_id)
	{
		$sql="delete from meeting_roomtools where room_id='$room_id' AND tool_id='$tool_id' ";
		//echo $sql;
		$dbquery=@mysql_db_query($dbname, $sql);
		echo "<script language=\"javascript\">
		alert(\"ร…ยบร รร•รยบรรฉรรยครร‘ยบ\");
		window.location='viewtools.php?room_id=$room_id';
	</script>";
	}

	if($del_tools_id2 and $del_room_id2 and $edit_room_id)
	{
		$sql="delete from meeting_roomtools where room_id='$del_room_id2' AND tools_id='$del_tools_id2'";
		$dbquery=@mysql_db_query($dbname, $sql);
		echo "<script language=\"javascript\">
		alert(\"ลบข้อมูลเรียบร้อยแล้ว\");
		window.location='meetingroom.php?edit_room_id=$edit_room_id';
	</script>";
	}

	if($del_book_id)
	{
		$sql="delete from meeting_booking where book_id='$del_book_id' ";
		$dbquery=@mysql_db_query($dbname, $sql);
		echo "<script language=\"javascript\">
		alert(\"ลบข้อมูลเรียบร้อยแล้ว\");
		window.location='meeting-data-conf.php';
	</script>";
	}
?>
</body>
</html>
