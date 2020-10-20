<?
	session_start();
	error_reporting(E_ALL^E_NOTICE);
	include '../inc/connect_db.php';
	
	if(!$admin_id)
	{
		echo"<script language=\"javascript\">
	alert(\"กรุณา Login ก่อนใช้งานหน้านี้\");
	window.location='../index.php';
</script>";
	}else
	{
		if($day > 30)
		{
			echo"<script language=\"javascript\">
	alert(\"กำหนดวันจองล่วงหน้าสูงสุดได้แค่ 30 วันครับ\");
	window.location='config_day2.php';
</script>";
		}else
		$sql="update meeting_cancelday set day='$day' where day_id='$day_id'";
		$dbquery=mysql_db_query($dbname, $sql);

		echo"<script language=\"javascript\">
	alert(\"บันทึกวันเรียบร้อยครับ\");
	window.location='config_day2.php';
</script>";
	}


