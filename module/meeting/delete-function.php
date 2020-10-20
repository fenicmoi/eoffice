<?
	session_start();
	error_reporting(E_ALL^E_NOTICE);
	include 'inc/connect_db.php';
	
	if(!$_SESSION['userid'])
	{
		echo"<script language=\"javascript\">
	alert(\"กรุณา Login ก่อนใช้งานหน้านี้\");
	window.parent.location='index.php';
</script>";
	}
?>
<!DOCTYPE html>
<html">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="mystyle.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?
	$del_book_id=$_GET['del_book_id'];
	if($del_book_id)
	{
		$sql="delete from meeting_booking where book_id='$del_book_id' ";
		$dbquery=@mysql_db_query($dbname, $sql);
		
		$sql2="delete from meeting_usetool where book_id='$del_book_id' ";
		$dbquery2=@mysql_db_query($dbname, $sql2);
		
		$sql3="delete from meeting_usefood where book_id='$del_book_id' ";
		$dbquery3=@mysql_db_query($dbname, $sql3);
		
		echo"<script language=\"javascript\">
		alert(\"ลบเรียบร้อยครับ\");
		window.location='cancelform.php';
		</script>";
	}
	
	if($del_tool_id)
	{
		$sql="delete from meeting_tools where tool_id='$del_tool_id' ";
		$dbquery=mysql_db_query($dbname, $sql);
		echo"<script language=\"javascript\">
		alert(\"ลบเรียบร้อยครับ\");
		window.location='toolmeeting.php';
		</script>";
	}
?>
</body>
</html>
