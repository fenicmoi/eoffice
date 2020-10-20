<?
	session_start();
	error_reporting(E_ALL^E_NOTICE);
	include '../inc/connect_db.php';
	
	if(!$admin_id)
	{
		echo"<script language=\"javascript\">
	alert(\"กรุณา Login ก่อนใช้งานหน้านี้\");
	window.parent.location='../index.php';
</script>";
	}else
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<title>ViewTools</title>
<link href="../mystyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
body {
	margin-top: 20px;
}
-->
</style>
</head>

<body>
<table width="433" border="1" align="center" cellpadding="5" cellspacing="0" bordercolor="#000000" bordercolorlight="#666666" bordercolordark="#FFFFFF">
  <tr>
    <td width="474" class="subtopic"><div align="center">อุปกรณ์ที่มีในห้อง	
        <?
		$sql="select roomname from meeting_room where room_id='$room_id'";
		$dbquery=mysql_db_query($dbname, $sql);
		$result=mysql_fetch_array($dbquery);
		
		$roomname=$result[0];
		echo $roomname;
	?>	
    </div></td>
  </tr>
  <tr>
    <td><br />
      <table width="300" height="25" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" bordercolorlight="#999999" bordercolordark="#FFFFFF">
      <tr class="title_table">
        <td width="87%">ชื่ออุปกรณ์</td>
        </tr>
      <?	
		  	$sql="select mr.tool_id, mt.toolname from meeting_tools as mt, meeting_roomtools as mr
			where mt.tool_id=mr.tool_id and mr.room_id=$room_id";
			//echo $sql;
			$dbquery=mysql_db_query($dbname, $sql);
			while($result=mysql_fetch_array($dbquery))
			{
				$tool_id=$result[0];
				$toolname=$result[1];
				
				echo"<tr class='text'>
						<td>&nbsp;$toolname</td>
					</tr>";
			}
		  ?>
    </table>
    <br /></td>
  </tr>
</table>
<p align="center">
  <input type="submit" name="Submit" value="ปิดหน้าต่าง" onclick="window.close();" />
</p>
</body>
</html>
