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
<title>Untitled Document</title>
<link href="../mystyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
body {
	margin-top: 20px;
}
-->
</style></head>

<body onload="document.form1.toolname.focus();">
<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td class="title_bg_text"><img src="../images/application_add.gif" alt="title" width="16" height="16" align="absmiddle" /> กำหนดวันจองล่วงหน้า </td>
  </tr>
</table>
<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>
	<?
		$sql="select * from meeting_day";
		$dbquery=mysql_db_query($dbname, $sql);
		$result=mysql_fetch_array($dbquery);
		
		$day_id=$result[day_id];
		$day=$result[day];
	?>
	<form id="form1" name="form1" method="post" action="add_day.php">
      <input name="day" type="text" id="day" value="<? echo $day; ?>" />
      <input type="button" name="Button" value="Save" onclick="chkform();" />
      <input name="day_id" type="hidden" id="day_id" value="<? echo $day_id; ?>" />
	</form>
    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><span class="redfont">*หมายเหตุ*</span> <strong>กำหนดจำนวนวันล่วงหน้าที่สามารถจองห้องประชุมได้ ตั้งแต่ 1-30 วัน </strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
<script language="javascript">
function chkform()
{
	if(document.form1.day.value == 0)
	{
		alert("กรุณาระบุจำนวนวันครับ");
		document.form1.day.focus();
	}else
	document.form1.submit();
}
</script>
<? mysql_close(); ?>