<?
	session_start();
	error_reporting(E_ALL^E_NOTICE);
	include '../inc/connect_db.php';
	if(!$_SESSION['admin_id'])
	{
		echo"<script language=\"javascript\">
	alert(\"กรุณา Login ก่อนใช้งานหน้านี้\");
	window.parent.location='../index.php';
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
	$add_room=$_POST['add_room'];
	$roomname=$_POST['roomname'];
	$roomplace=$_POST['roomplace'];
	$roomcount=$_POST['roomcount'];
	$dept=$_POST['dept'];
	$tel=$_POST['tel'];
	$comment=$_POST['comment'];
if($add_room)        
{
	$roomimg=$_FILES['roomimg'] ['tmp_name'];
	$roomimg_name=$_FILES['roomimg'] ['name'];
	$roomimg_size=$_FILES['roomimg'] ['size'];
	$roomimg_type=$_FILES['roomimg'] ['type'];


	
		$array_last=explode(".", $roomimg_name);
		$c=count($array_last)-1;
		$lastname=strtolower($array_last[$c]);
		
		if($lastname=="gif" or $lastname=="jpg" or $lastname=="jpeg")
		{
			$sql="insert into meeting_room(room_id, roomname, roomplace, roomcount, dept, tel, comment)
			values('', '$roomname', '$roomplace', '$roomcount', '$dept', '$tel', '$comment')";
			$dbquery=@mysql_db_query($dbname, $sql);
			
			$sql2="select max(room_id) from meeting_room";
			$dbquery2=@mysql_db_query($dbname, $sql2);
			$result=@mysql_fetch_array($dbquery2);
			
			$room_id=$result[0];
			
			$filename=$room_id .".".$lastname;
			
			copy($roomimg, "roomimg/" .$filename);
			
			$sql3="update meeting_room set roomimg='$filename' where room_id='$room_id' ";
			//echo $sql3;
			$dbquery3=@mysql_db_query($dbname, $sql3);
			unlink($roomimg);		
			
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
			echo "<script language='javascript'>
				alert('บันทึกข้อมูลเรียบร้อยครับ');
				window.location='meetingroom.php';
			</script>";
						
		}else if($lastname<>"gif" or $lastname<>"jpg" or $lastname<>"jpeg")
		{
			echo "<script language='javascript'>
				alert('ไม่สามารถ upload ภาพได้เนื่องจาก ชนิดไฟล์ไม่ถูกต้อง ต้องเป็นชนิด gif, jpg, jpeg เท่านั้น');
				window.location='meetingroom.php';
			</script>";
		}
}

$add_tools=$_POST['add_tools'];
$toolname=$_POST['toolname'];
if($add_tools)
{
	$sql="insert into meeting_tools(tool_id, toolname) values('', '$toolname')";
	//echo $sql;
	$dbquery=@mysql_db_query($dbname, $sql);
	echo "<script language='javascript'>
	alert('บันทึกข้อมูลเรียบร้อยครับ');
	window.location='toolmeeting.php';
	</script>";		
}
$starttime=$_POST['starttime'];
if($starttime)
{
	$sql="insert into meeting_starttime(time_id, time_name) values('', '$starttime')";
	$dbquery=@mysql_db_query($dbname, $sql);
	echo "<script language='javascript'>
	alert('บันทึกข้อมูลเรียบร้อยครับ');
	window.location='savetime.php';
	</script>";
}

$endtime=$_POST['endtime'];
if($endtime)
{
	$sql="insert into meeting_endtime(time_id, time_name) values('', '$endtime')";
	$dbquery=@mysql_db_query($dbname, $sql);
	echo "<script language='javascript'>
	alert('บันทึกข้อมูลเรียบร้อยครับ');
	window.location='savetime.php';
	</script>";
}

$account=$_POST['account'];
$pass=$_POST['pass'];
$fullname=$_POST['fullname'];
$dept=$_POST['dept_id'];
if($account)
{
	$sql2="select * from meeting_user where username='$account'";
	$dbquery2=@mysql_db_query($dbname, $sql2);
	$numrows=@mysql_num_rows($dbquery2);
	
	if($numrows <> 0)
	{
		echo "<script language='javascript'>
		alert('username error');
		window.location='add_user.php';
		</script>";
	}else if($numrows == 0)
	{
		$sql="insert into meeting_user(user_id, username, passwords, name, department) values('', '$account', '$pass', '$fullname', '$dept')";
		echo $sql;
		$dbquery=@mysql_db_query($dbname, $sql);
		echo "<script language='javascript'>
		alert('add user success');
		window.location='add_user.php';
		</script>";
	}
}

$dept_code=$_POST['dept_code'];
$dept_name=$_POST['dept_name'];
if($dept_name)
{
	$sql2="select * from meeting_department where dept_code='$dept_code'";
	$dbquery2=@mysql_db_query($dbname, $sql2);
	$numrows=@mysql_num_rows($dbquery2);
	
	if($numrows <> 0)
	{
		echo "<script language='javascript'>
		alert('depart code not work');
		window.location='add_dept.php';
		</script>";
	}else if($numrows == 0)
	{
	$sql="insert into meeting_department(dept_code, dept_name) values('$dept_code', '$dept_name')";
	$dbquery=@mysql_db_query($dbname, $sql);
	echo "<script language='javascript'>
	alert('บันทึกข้อมูลเรียบร้อยครับ');
	window.location='add_dept.php';
	</script>";
	}
}

if($checktool)
{				
	for ($i=0;$i<count($checktool);$i++) 
		{ 
			$tool_id= $checktool[$i];
					
			$sql4="insert into meeting_roomtools(room_id, tool_id) values('$room_id', '$tool_id') "; 
			//echo $sql4;
			$dbquery4=mysql_db_query($dbname,$sql4); 	
		}
		
		echo "<script language='javascript'>
		alert('บันทึกข้อมูลเรียบร้อยครับ');
		window.location='viewtools.php?room_id=$room_id';
		</script>";
}

mysql_close();
?>
</body>
</html>