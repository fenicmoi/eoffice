<?
	session_start();
	session_destroy();
	error_reporting(E_ALL^E_NOTICE);
	include'inc/connect_db.php';
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>รายละเอียดห้องประชุม</title>
<link href="mystyle.css" rel="stylesheet" type="text/css" />
 <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<style type="text/css">
<!--
body {
	margin-top: 10px;
}
-->
</style></head>

<body>
<?
		$sql="select * from meeting_room order by room_id";
		$dbquery=@mysql_db_query($dbname, $sql);
		while($result=@mysql_fetch_array($dbquery))
		{
			$room_id=$result[room_id];
			$roomname=$result[roomname];
			$roomplace=$result[roomplace];
			$roomcount=$result[roomcount];
			$roomtools=$result[roomtools];
			$roomimg=$result[roomimg];
			
			if($roomimg =="")
			{
				$showimg="<img src='admin/roomimg/noimg.jpg' border='1' width='200' height='150'>";	
			}else
			{
				$showimg="<img src='admin/roomimg/$roomimg' border='1' width='200' height='150'>";
			}
			
			
	?>
<table class="table-bordered table-striped"  width="600" border="1" align="center" cellpadding="10" cellspacing="0" bordercolor="#000000" bordercolorlight="#666666" bordercolordark="#FFFFFF">
  <tr>
    <td width="280" valign="top"><div align="center"><? echo "$showimg"; ?></div></td>
    <td width="294" valign="top"><table width="100%" border="0" cellspacing="5" cellpadding="5">
      <tr>
        <td width="41%"><div align="right" class="title">ชื่อห้อง : </div></td>
        <td width="59%" valign="top"><strong><? echo $roomname; ?></strong></td>
      </tr>
      <tr>
        <td><div align="right" class="title">ที่ตั้ง : </div></td>
        <td valign="top"><strong><? echo $roomplace; ?></strong></td>
      </tr>
      <tr>
        <td><div align="right" class="title">ความจุที่นั่ง : </div></td>
        <td valign="top"><strong><? echo $roomcount; ?></strong></td>
      </tr>
      
      
    </table></td>
  </tr>
</table>
<?
	}
?>
<p align="center">
  <input type="submit" name="Submit" value="ปิดหน้าต่าง" onclick="window.close();" />
</p>
</body>
</html>
