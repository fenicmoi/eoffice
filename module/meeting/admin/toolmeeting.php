<?
	session_start();
	error_reporting(E_ALL^E_NOTICE);
	include '../inc/connect_db.php';
	
	if(!$_SESSION['admin_id'])
	{
		echo"<script language=\"javascript\">
	alert(\"please login\");
	window.parent.location='../index.php';
</script>";
	}else
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

<body onLoad="document.form1.toolname.focus();">
<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td class="title_bg_text_no_center_blue"><img src="../images/application_add.gif" alt="title" width="16" height="16" align="absmiddle"> บันทึกอุปกรณ์ใช้ในห้องประชุม</td>
  </tr>
</table>
<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0" class="borderall_green">
  
  <tr>
    <td>
	<?
	$edit_tool_id=$_GET['edit_tool_id'];
	
	if(!$edit_tool_id)
	{
	?>
	<form action="add-function.php" name="form1" method="post">
	<table width="100%" border="0" cellspacing="3" cellpadding="2">
      <tr class="bg_colorCopy">
        <td colspan="2"><img src="../images/add.gif" width="16" height="16" align="absmiddle"> เพิ่มอุปกรณ์ </td>
        </tr>
      
      <tr>
        <td width="14%" class="bg_color"><div align="right">ชื่ออุปกรณ์ : </div></td>
        <td width="86%" class="yellow_bg_color">
          <input name="toolname" type="text" id="toolname" size="40">
          <input name="add_tools" type="hidden" id="add_tools" value="add_tools"></td>
      </tr>
      <tr>
        <td class="bg_color">&nbsp;</td>
        <td class="yellow_bg_color"><input type="button" name="Button" value="บันทึก"  onclick="chkform();"> <input type="reset" name="Submit2" value="ยกเลิก"></td>
      </tr>
    </table>
	</form>
	<?
	}else if($edit_tool_id)
	{
		$sql="select * from meeting_tools where tool_id='$edit_tool_id' ";
		$dbquery=@mysql_db_query($dbname, $sql);
		$result=@mysql_fetch_array($dbquery);
		$tool_id=$result[tool_id];
		$toolname=$result[toolname];
		

	?>
	<form action="edit-function.php" name="form2" method="post">
	<table width="100%" border="0" cellspacing="3" cellpadding="2">
      <tr class="bg_colorCopy">
        <td colspan="2"><img src="../images/drive_edit.gif" width="16" height="16" align="absmiddle"> แก้ไขอุปกรณ์ </td>
        </tr>
      
      <tr>
        <td width="14%" class="bg_color"><div align="right">ชื่ออุปกรณ์ : </div></td>
        <td width="86%" class="yellow_bg_color"><input name="edit_toolname" type="text" id="edit_toolname" value="<? echo $toolname; ?>" size="40">
          <input name="tool_id" type="hidden" id="tool_id" value="<? echo $tool_id; ?>"></td>
      </tr>
      <tr>
        <td class="bg_color">&nbsp;</td>
        <td class="yellow_bg_color"><input type="button" name="Button2" value="แก้ไข"  onclick="chkform2();">
           <input type="reset" name="Submit2" value="ยกเลิก"></td>
      </tr>
    </table>
	</form>
	<?
	}
	?>	</td>
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
    <td><table width="100%" border="0" cellspacing="3" cellpadding="2">
      <tr class="bg_colorCopy">
        <td><img src="../images/report.gif" width="16" height="16" align="absmiddle"> อุปกร์ที่ใช้ในห้องประชุม </td>
      </tr>
      
      <tr>
        <td><table width="363" height="25" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" bordercolorlight="#999999" bordercolordark="#FFFFFF">
          <tr class="title_table_green">
            <td width="233">ชื่ออุปกรณ์</td>
            <td width="124">ดำเนินการ</td>
            </tr>
		  <?
		  		$sql="select * from meeting_tools";
				$dbquery=@mysql_db_query($dbname, $sql);
				
				while($result=@mysql_fetch_array($dbquery))
				{
					$tool_id=$result[tool_id];
					$toolname=$result[toolname];
					
					
					if($bg == "#DFE6F1") { //ส่วนของการ สลับสี 
					$bg = "#F8F7DE";
					} else {
					$bg = "#DFE6F1";
					}
					
					echo"<tr class='text' bgcolor='$bg'>
						<td>&nbsp;$toolname</td>
						<td align='center'><a href='toolmeeting.php?edit_tool_id=$tool_id' class='textnormal'>แก้ไข</a> | <a href='delete-function.php?del_tool_id=$tool_id' class='textnormal'>ลบ</a></td>
					</tr>";
				}
		  ?>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
<script language="javascript" type="text/javascript">
function chkform()
{
	if(document.form1.toolname.value == 0)
	{
		alert("กรุณาระบุชื่ออุปกรณ์ครับ");
		document.form1.toolname.focus();
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
	if(document.form2.edit_toolname.value == 0)
	{
		alert("กรุณาระบุชื่ออุปกรณ์ครับ");
		document.form2.edit_toolname.focus();
	}else
	document.form2.submit();
}
</script>
<? mysql_close(); ?>