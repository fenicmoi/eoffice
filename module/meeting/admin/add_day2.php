<?
	session_start();
	error_reporting(E_ALL^E_NOTICE);
	include '../inc/connect_db.php';
	
	if(!$admin_id)
	{
		echo"<script language=\"javascript\">
	alert(\"��س� Login ��͹��ҹ˹�ҹ��\");
	window.location='../index.php';
</script>";
	}else
	{
		if($day > 30)
		{
			echo"<script language=\"javascript\">
	alert(\"��˹��ѹ�ͧ��ǧ˹���٧�ش���� 30 �ѹ��Ѻ\");
	window.location='config_day.php';
</script>";
		}else if($day == 0)
		{
			echo"<script language=\"javascript\">
	alert(\"��˹��ѹ�ͧ��ǧ˹���� 0 ������Ѻ\");
	window.location='config_day.php';
</script>";
		}else
		$sql="update meeting_day set day='$day' where day_id='$day_id'";
		$dbquery=mysql_db_query($dbname, $sql);

		echo"<script language=\"javascript\">
	alert(\"�ѹ�֡�ѹ���º���¤�Ѻ\");
	window.location='config_day.php';
</script>";
	}


