<?
	session_start();
	error_reporting(E_ALL^E_NOTICE);
	include '../inc/connect_db.php';
	
	if(!$_SESSION['admin_id'])
	{
		echo"<script language=\"javascript\">
	alert(\"please login\");
	window.parent.location=../index.php\';
</script>";
	}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
<link href="../mystyle.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
body {
	margin-top: 20px;
	background-color: #E5E5E5;
}
-->
</style></head>

<body>
<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td class="title_bg_text_no_center_blue"><img src="../images/application_add.gif" alt="title" width="16" height="16" align="absmiddle"> บันทึกเวลาที่ใช้ในการประชุม</td>
  </tr>
</table>
<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0" class="borderall_green">
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td width="45%" valign="top">
	<?
		$edit_starttime_id=$_GET['edit_starttime_id'];

		if(!$edit_starttime_id)
		{
	?>
	<form action="add-function.php" method="post" name="form1">
	<table width="425" border="0" cellspacing="3" cellpadding="2">
      <tr>
        <td colspan="2" class="bg_colorCopy"><img src="../images/add.gif" width="16" height="16" align="absmiddle"> เพิ่มเวลาเริ่ม</td>
        </tr>
      
      <tr>
        <td width="149" class="bg_color"><div align="right">เวลา : </div></td>
        <td width="259" class="yellow_bg_color"><input name="starttime" type="text" id="starttime" size="10"> 
          ex.08:00:00</td>
      </tr>
      <tr>
        <td class="bg_color">&nbsp;</td>
        <td class="yellow_bg_color"><input type="button" name="Button" value="บันทึก"  onclick="chkform();"> <input type="reset" name="Reset" value="ยกเลิก"></td>
      </tr>
    </table>
	</form>
	
	<?
		}else if($edit_starttime_id)
		{
			$sql="select * from meeting_starttime where time_id='$edit_starttime_id' ";
			$dbquery=@mysql_db_query($dbname, $sql);
			$result=@mysql_fetch_array($dbquery);
			
			$starttime=$result[time_name];
	?>
	<form action="edit-function.php" method="post" name="form2">
	<table width="425" border="0" cellspacing="3" cellpadding="2">
      <tr class="bg_colorCopy">
        <td colspan="2"><img src="../images/drive_edit.gif" width="16" height="16" align="absmiddle"> แก้ไขเวลา</td>
        </tr>
      
      <tr>
        <td width="149" class="bg_color"><div align="right">เวลา : </div></td>
        <td width="259" class="yellow_bg_color"><input name="starttime" type="text" id="starttime" value="<? echo $starttime; ?>" size="10">
          <input name="edit_starttime_id" type="hidden" id="edit_starttime_id" value="<? echo $edit_starttime_id; ?>"></td>
      </tr>
      <tr>
        <td class="bg_color">&nbsp;</td>
        <td class="yellow_bg_color"><input type="button" name="Button" value="แก้ไข"  onclick="chkform2();"> 
        <input type="reset" name="Reset" value="ยกเลิก"></td>
      </tr>
    </table>
	</form>
	<? } ?></td>
    <td width="55%" valign="top">
	 <?
	 	$edit_endtime_id=$_GET['edit_endtime_id'];
		if(!$edit_endtime_id)
		{
	?>
	  <form name="form3" method="post" action="add-function.php">
	  <table width="425" border="0" cellspacing="3" cellpadding="2">
      <tr>
        <td colspan="2" class="bg_colorCopy"><img src="../images/add.gif" width="16" height="16" align="absmiddle"> เพิ่มเวลาสิ้นสุด</td>
      </tr>
      
      <tr>
        <td width="149" class="bg_color"><div align="right">เวลา : </div></td>
        <td width="259" class="yellow_bg_color"><input name="endtime" type="text" id="endtime" size="10">
          ex.08:00:00</td>
      </tr>
      <tr>
        <td class="bg_color">&nbsp;</td>
        <td class="yellow_bg_color"><input type="button" name="Button2" value="บันทึก"  onclick="chkform3();">
            <input type="reset" name="Reset2" value="ยกเลิก"></td>
      </tr>
    </table>
	</form>
      <?

		}else if($edit_endtime_id)
		{
			$sql="select * from meeting_endtime where time_id='$edit_endtime_id' ";
			$dbquery=@mysql_db_query($dbname, $sql);
			$result=@mysql_fetch_array($dbquery);
			
			$endtime=$result[time_name];
	?>
	<form name="form4" action="edit-function.php" method="post">
      <table width="425" border="0" cellspacing="3" cellpadding="2">
        <tr class="bg_colorCopy">
          <td colspan="2"><img src="../images/drive_edit.gif" width="16" height="16" align="absmiddle"> แก้ไขเวลา</td>
        </tr>
        
        <tr>
          <td width="149" class="bg_color"><div align="right">เวลา : </div></td>
          <td width="259" class="yellow_bg_color"><input name="endtime" type="text" id="endtime" value="<? echo $endtime; ?>" size="10">
              <input name="edit_endtime_id" type="hidden" id="edit_endtime_id" value="<? echo $edit_endtime_id; ?>"></td>
        </tr>
        <tr>
          <td class="bg_color">&nbsp;</td>
          <td class="yellow_bg_color"><input type="button" name="Button3" value="แก้ไข"  onclick="chkform4();">
              <input type="reset" name="Reset3" value="ยกเลิก"></td>
        </tr>
      </table>
	  </form>	
	  <? } ?></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top"><table width="425" border="0" cellspacing="3" cellpadding="2">
      <tr class="bg_colorCopy">
        <td><img src="../images/report.gif" width="16" height="16" align="absmiddle"> รายละเอียดเวลาเริ่ม</td>
      </tr>
      
      <tr>
        <td><table width="100%" height="25" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" bordercolorlight="#999999" bordercolordark="#FFFFFF">
          <tr class="title_table_green">
            <td width="269">เวลา</td>
            <td width="140">ดำเนินการ</td>
          </tr>
		  <?
		  		$sql="select * from meeting_starttime";
				$dbquery=@mysql_db_query($dbname, $sql);
				
				while($result=@mysql_fetch_array($dbquery))
				{
					$time_id=$result[time_id];
					$timename=$result[time_name];
					
					if($bg == "#DFE6F1") { //ส่วนของการ สลับสี 
					$bg = "#F8F7DE";
					} else {
					$bg = "#DFE6F1";
					}
					
					echo"<tr class='text' bgcolor='$bg'>
						<td>&nbsp;$timename</td>
						<td align='center'><a href='savetime.php?edit_starttime_id=$time_id' class='textnormal'>แก้ไข</a> | <a href='delete-function.php?del_starttime_id=$time_id' class='textnormal'>ลบ</a></td>
					</tr>";
				}
		  ?>
        </table></td>
      </tr>
    </table></td>
    <td valign="top"><table width="425" border="0" cellspacing="3" cellpadding="2">
      <tr class="bg_colorCopy">
        <td><img src="../images/report.gif" width="16" height="16" align="absmiddle"> รายละเอียดเวลาสิ้นสุด</td>
      </tr>
      
      <tr>
        <td><table width="100%" height="25" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" bordercolorlight="#999999" bordercolordark="#FFFFFF">
            <tr class="title_table_green">
              <td width="269">เวลา</td>
              <td width="140">ดำเนินการ</td>
            </tr>
            <?
		  		$sql="select * from meeting_endtime";
				$dbquery=@mysql_db_query($dbname, $sql);
				
				while($result=@mysql_fetch_array($dbquery))
				{
					$time_id2=$result[time_id];
					$timename=$result[time_name];
					
					if($bg == "#DFE6F1") { //ส่วนของการ สลับสี 
					$bg = "#F8F7DE";
					} else {
					$bg = "#DFE6F1";
					}
					
					echo"<tr class='text' bgcolor='$bg'>
						<td>&nbsp;$timename</td>
						<td align='center'><a href='savetime.php?edit_endtime_id=$time_id2' class='textnormal'>แก้ไข</a> | <a href='delete-function.php?del_endtime_id=$time_id2' class='textnormal'>ลบ</a></td>
					</tr>";
				}
		  ?>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
</table>
</body>
</html>
<script language="javascript" type="text/javascript">
function chkform()
{
	if(document.form1.starttime.value == 0)
	{
		alert("กรุณาระบุเวลาครับ");
		document.form1.starttime.focus();
	}else
	document.form1.submit();
}

function check_keyboard() 
{
	e_k=event.keyCode
	if (((e_k < 48) || (e_k > 47)) && e_k != 46 && e_k != 13) 
	{
	//if (e_k != 13 && (e_k < 48) || (e_k > 57) || e_k == ) {
	event.returnValue = false;
	alert(" เลืิอกไฟล์โดยการกดปุ่ม Browse...");
	}
}
function chkform2()
{
	if(document.form2.starttime.value == 0)
	{
		alert("กรุณาระบุเวลาครับ");
		document.form2.starttime.focus();
	}else
	document.form2.submit();
}

function chkform3()
{
	if(document.form3.endtime.value == 0)
	{
		alert("กรุณาระบุเวลาครับ");
		document.form3.endtime.focus();
	}else
	document.form3.submit();
}

function chkform4()
{
	if(document.form4.endtime.value == 0)
	{
		alert("กรุณาระบุเวลาครับ");
		document.form4.endtime.focus();
	}else
	document.form4.submit();
}

</script>
<? mysql_close(); ?>