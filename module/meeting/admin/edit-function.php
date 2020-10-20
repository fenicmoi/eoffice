<?
	session_start();
	error_reporting(E_ALL^E_NOTICE);
	include '../inc/connect_db.php';

	$room_id=$_POST['edit_room_id'];
	

	if(!$_SESSION['admin_id'])
	{
		echo"<script language=\"javascript\">
	alert(\"please login\");
	window.parent.location='../index.php';
</script>";
	}
?>
<html>
<head>
<title>โปรแกรมจองห้องประชุมออนไลน์ จังหวัดพังงา</title>
<meta charset="utf-8">
<meta name="description" content="meeting room">
<link href="mystyle.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="css/bootstrap.min.css">
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<link href="../mystyle.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?php
$room_id=$_POST['room_id'];
if($room_id)
{
	$roomimg=$_FILES['roomimg'] ['tmp_name'];
	$roomimg_name=$_FILES['roomimg'] ['name'];
	$roomimg_size=$_FILES['roomimg'] ['size'];
	$roomimg_type=$_FILES['roomimg'] ['type'];
	if($chkdel=="1")
	{
		$sql="update meeting_room set roomimg=' ' where room_id='$room_id' ";
		$dbquery=@mysql_db_query($dbname, $sql);
		unlink("roomimg/$del_roomimg");
	}
		
	if($roomimg)
	{
		$array_last=explode(".",$roomimg_name);
		$c=count($array_last) -1;
		$lastname=strtolower($array_last[$c]);
		if($lastname=="gif" or $lastname=="jpg" or $lastname=="jpeg")
		{
			$photoname=$room_id.".".$lastname;
			copy($roomimg, "roomimg/" .$photoname);
			
			$sql3="update meeting_room set roomimg='$photoname' where room_id='$room_id' ";
			$dbquery3=@mysql_db_query($dbname, $sql3);
			unlink($roomimg);
		}
		else if($lastname<>"gif" or $lastname<>"jpg" or $lastname<>"jpeg")
		{
			echo "<script language=\"javascript\">
				alert(\"ระบบสามารถรองรับภาพชนิด gif, jpg, jpeg  เท่านั้น\");
				window.location='meetingroom.php?edit_room_id=$room_id';
			</script>";
		}
	}
	
	if($checktool)
	{
		for ($i=0;$i<count($checktool);$i++) 
		{ 
			$tool_id= $checktool[$i];
				
			$sql23="insert into meeting_roomtools(room_id, tools_id) values('$room_id', '$tool_id') "; 
			//echo $sql2;
			$dbquery23=@mysql_db_query($dbname,$sql23); 	
		}
	}
	$roomname=$_POST['roomname'];
	$roomplace=$_POST['roomplace'];
	$roomcount=$_POST['roomcount'];
	$dept=$_POST['dept'];
	$tel=$_POST['tel'];
	$comment=$_POST['comment'];

	$sql2="update meeting_room set roomname='$roomname', roomplace='$roomplace', roomcount='$roomcount', dept='$dept', tel='$tel', comment='$comment' where room_id='$room_id' ";
	echo $sql;
	$dbquery2=@mysql_db_query($dbname, $sql2);	
	echo "<script language=\"javascript\">
	alert(\"รกยกรฉรคยขร รร•รยบรรฉรรยครร‘ยบ\");
	window.location='meetingroom.php';
</script>";
}

$tool_id=$_POST['tool_id'];
$edit_toolname=$_POST['edit_toolname'];
if($edit_toolname)
{

	$sql="update meeting_tools set toolname='$edit_toolname' where tool_id='$tool_id' ";
	$dbquery=@mysql_db_query($dbname, $sql);
	echo "<script language=\"javascript\">
	alert(\"รกยกรฉรคยขร รร•รยบรรฉรรยครร‘ยบ edit toolname\");
	window.location='toolmeeting.php';
</script>";
}

$conf_book_id=$_GET['conf_book_id'];
if($conf_book_id)
{
	$sql2="select * from meeting_booking where startdate='$startdate' AND starttime='$starttime' AND endtime='$endtime' AND room_id='$sel_room_id' AND conf_status='1' ";
	$dbquery2=@mysql_db_query($dbname,$sql2);
	$numrows=@mysql_num_rows($dbquery2);
	if($numrows > 0)
	{
		echo "<script language=\"javascript\">
	alert(\"รรฉรยงยนร•รฉยครยณรคยดรฉรยนรรร‘ยตร”ยกร’รรฃยชรฉยงร’ยนรฃยนรร‘ยนรกร…รร รร…ร’ยทร•รจร ร…ร—รยกรกร…รฉรยครร‘ยบ\");
	window.location='meeting-data.php';
</script>";
	}else if($numrows == '0')
	{
	
	$sql="update meeting_booking set conf_status='1' where book_id='$conf_book_id' ";
	$dbquery=@mysql_db_query($dbname, $sql);
	echo "<script language=\"javascript\">
	alert(\"อนุมัติห้องประชุมเรียบร้อยแล้ว\");
	window.location='meeting-data-conf.php';
</script>";
	}
}
$old_pass=$_POST['old_pass'];
$new_pass1=$_POST['new_pass1'];
$new_pass2=$_POST['new_pass2'];
if($old_pass and $new_pass1 and $new_pass2)
{
	$sql="select * from meeting_admin";
	$dbquery=@mysql_db_query($dbname, $sql);
	$result=@mysql_fetch_array($dbquery);
	
	$passwords=$result[passwords];
	
	if($old_pass <> $passwords)
	{
			echo "<script language=\"javascript\">
	alert(\"รรร‘รร ยดร”รรครรจยถรยกยตรฉรยง\");
	window.location='changepass.php';
</script>";
	}else if($old_pass == $passwords)
	{
		if($new_pass1 == $new_pass2)
		{
			$sql2="update meeting_admin set passwords='$new_pass1' ";
			echo $sql2;
			$dbquery2=@mysql_db_query($dbname, $sql2);
		}else if($new_pass1 <> $new_pass2)
		{
						echo "<script language=\"javascript\">
	alert(\"รรร‘รยทร•รจยพร”รยพรฌรครรจยตรยงยกร‘ยน\");
	window.location='changepass.php';
</script>";
		}
	}
							echo "<script language=\"javascript\">
	alert(\"ร ยปร…ร•รจรยนรรร‘รยผรจร’ยนร รร•รยบรรฉรรยครร‘ยบ\");
	window.location='changepass.php';
</script>";
}

if($edit_fullname)
{
	$sql="update meeting_user set name='$edit_fullname', department='$edit_dept', username='$edit_account', passwords='$edit_pass', phone='$phone' where user_id=$edit_user_id ";
	//echo $sql;
	$dbquery=@mysql_db_query($dbname, $sql);
	echo "<script language=\"javascript\">
	alert(\"รกยกรฉรคยขร รร•รยบรรฉรรยครร‘ยบ\");
	window.location='add_user.php';
</script>";
}

$edit_dept_id=$_POST['edit_dept_id'];
$edit_dept_code=$_POST['edit_dept_code'];
$edit_dept_name=$_POST['edit_dept_name'];
if($edit_dept_id)
{
	$sql="update meeting_department set dept_name='$edit_dept_name', dept_code='$edit_dept_code' where dept_id='$edit_dept_id' ";
	//echo $sql;
	$dbquery=@mysql_db_query($dbname, $sql);
	echo "<script language=\"javascript\">
	alert(\"รกยกรฉรคยขร รร•รยบรรฉรรยครร‘ยบ\");
	window.location='add_dept.php';
</script>";
}


$edit_starttime_id=$_POST['edit_starttime_id'];
$starttime=$_POST['starttime'];
if($edit_starttime_id)
{
	$sql="update meeting_starttime set time_name='$starttime' where time_id='$edit_starttime_id' ";
	$dbquery=@mysql_db_query($dbname, $sql);
	echo "<script language=\"javascript\">
	alert(\"รกยกรฉรคยขร รร•รยบรรฉรรยครร‘ยบ\");
	window.location='savetime.php';
</script>";
}

$edit_endtime_id=$_POST['edit_endtime_id'];
$endtime=$_POST['endtime'];
if($edit_endtime_id)
{
	$sql="update meeting_endtime set time_name='$endtime' where time_id='$edit_endtime_id' ";
	$dbquery=@mysql_db_query($dbname, $sql);
	echo "<script language=\"javascript\">
	alert(\"รกยกรฉรคยขร รร•รยบรรฉรรยครร‘ยบ\");
	window.location='savetime.php';
</script>";
}

if($book_id)
{
	$sql="select * from meeting_booking where book_id='$book_id' ";
	$dbquery=@mysql_db_query($dbname, $sql);
	$result=@mysql_fetch_array($dbquery);

		$subject=$result[subject];
		$head=$result[head];
		$num=$result[numpeople];
		$room_id=$result[room_id];
		$startdate=$result[startdate];
		$starttime=$result[starttime];
		$endtime=$result[endtime];
		$bookname=$result[bookname];
		$bookingdate=$result[bookingdate];
		$user_id=$result[user_id];
		$conf_status=$result[conf_status];
		$comment=$result[comment];

		$today=date("Y-m-d");

		$sql2="insert into meeting_booking_ori(count_id, book_id, subject, head, numpeople, room_id, startdate, starttime, endtime, bookname, bookingdate, user_id, comment, conf_status, date_edit)
		values('', '$book_id', '$subject', '$head', '$num', '$room_id', '$startdate', '$starttime', '$endtime', '$bookname', '$bookingdate', '$user_id', '$comment', '$conf_status', '$today' )";
		//echo $sql2;
		$dbquery2=@mysql_db_query($dbname, $sql2);

		$sql33="update meeting_booking set update_status='0' where book_id='$book_id'";
		$dbquery33=@mysql_db_query($dbname, $sql33);
	echo "<script language=\"javascript\">
	alert(\"ดำเนินการอนุมัติเรียบร้อยแล้ว\");
	window.location='meeting-data-conf.php';
</script>";
}

mysql_close();
?>
</body>
</html>
