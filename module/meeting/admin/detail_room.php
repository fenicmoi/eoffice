<?
	session_start();
	error_reporting(E_ALL^E_NOTICE);
	include '../inc/connect_db.php';
	$room_id=$_GET['room_id'];
	if(!$_SESSION['admin_id'])
	{
		echo"<script language=\"javascript\">
	alert(\"��س� Login ��͹��ҹ˹�ҹ��\");
	window.parent.location='../index.php';
</script>";
	}else
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<title>��������´��ͧ��Ъ��</title>
<link href="../mystyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
body {
	margin-top: 10px;
}
-->
</style></head>

<body>
<table width="500" border="1" align="center" cellpadding="5" cellspacing="0" bordercolor="#000000" bordercolorlight="#666666" bordercolordark="#FFFFFF">
  
  <tr>
    <td width="474" class="topic">
	<?php
		$sql="select * from meeting_room where room_id='$room_id'";
		$dbquery=@mysql_db_query($dbname, $sql);
				
		$result=@mysql_fetch_array($dbquery);
		
			$room_id=$result[room_id];
			$roomname=$result[roomname];
			$roomplace=$result[roomplace];
			$roomcount=$result[roomcount];
			$roomimg=$result[roomimg];		
			$dept=$result[dept];
			$tel=$result[tel];
			$comment=$result[comment];
			
			echo $roomname;
	?>	</td>
  </tr>
  <tr>
    <td>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="3%" valign="top"><?
		if($roomimg =='')
		{
			$showimg="<img src='roomimg/noimg.jpg' border='1' width='200' height='150'>";	
		}else
		{
			$showimg="<img src='roomimg/$roomimg' border='1' width='200' height='150'>";
		}
		echo $showimg;
	?></td>
          <td width="97%" valign="top"><table width="100%" border="1" cellspacing="0" cellpadding="5">
            
            <tr>
              <td width="38%"><div align="right" class="title">ʶҹ����� : </div></td>
              <td width="62%"><strong><? echo $roomplace; ?></strong></td>
            </tr>
            <tr>
              <td><div align="right" class="title">�����ط���� : </div></td>
              <td><strong><? echo $roomcount; ?> �� </strong></td>
            </tr>
            <tr>
              <td class="title"><div align="right">˹��§ҹ���� : </div></td>
              <td><strong><? echo $dept; ?></strong></td>
            </tr>
            <tr>
              <td class="title"><div align="right">���Ѿ�� : </div></td>
              <td><strong><? echo $tel; ?></strong></td>
            </tr>
            <tr>
              <td valign="top" class="title"><div align="right">�����˵� : </div></td>
              <td><strong><? echo $comment; ?></strong></td>
            </tr>
          </table></td>
        </tr>
      </table>    </td>
  </tr>
</table>
<p align="center">
  <input type="submit" name="Submit" value="�Դ˹�ҵ�ҧ" onclick="window.close();" />
</p>
</body>
</html>
