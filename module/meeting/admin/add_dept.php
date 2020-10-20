<?
	session_start();
	error_reporting(E_ALL^E_NOTICE);
	include '../inc/connect_db.php';
	
	if(!$_SESSION['admin_id'])
	{
		echo"<script language=\"javascript\">
	alert(\"กรุณา Login ก่อนใช้งานหน้านี้\");
	window.location='../index.php';
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
	background-color: #e5e5e5;
}
-->
</style></head>

<body onload="document.form1.dept_code.focus();">
<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td class="title_bg_text_no_center_blue"><img src="../images/application_add.gif" alt="title" width="16" height="16" align="absmiddle" /> บันทึกหน่วยงาน</td>
  </tr>
</table>
<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0" class="borderall_green">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>
	<?
    $edit_dept_id=$_GET['edit_dept_id'];
		if(!$edit_dept_id)
		{
	?>
	<form action="add-function.php" method="post"  name="form1">
	<table width="100%" border="0" cellspacing="3" cellpadding="2">
      <tr>
        <td colspan="2" class="bg_colorCopy"><img src="../images/add.gif" width="16" height="16" align="absmiddle" /> เพิ่มหน่วยงาน</td>
        </tr>
      
      <tr>
        <td width="133" class="bg_color"><div align="right">รหัสหน่วยงาน : </div></td>
        <td width="977" class="yellow_bg_color"><input name="dept_code" type="text" id="dept_code" /></td>
      </tr>
      <tr>
        <td class="bg_color"><div align="right">ชื่อหน่วยงาน : </div></td>
        <td class="yellow_bg_color"><input name="dept_name" type="text" id="dept_name" size="30" /></td>
      </tr>
      
      <tr>
        <td class="bg_color">&nbsp;</td>
        <td class="yellow_bg_color"><input type="button" name="Button" value="บันทึก"  onclick="chkform();"/> <input type="reset" name="Reset" value="ยกเลิก" /></td>
      </tr>
    </table>
	</form>
	
	<?
		}else if($edit_dept_id)
		{
			$sql="select * from meeting_department where dept_id='$edit_dept_id' ";
			$dbquery=@mysql_db_query($dbname, $sql);
			$result=@mysql_fetch_array($dbquery);
			
			$edit_dept_name=$result[dept_name];
			$edit_dept_code=$result[dept_code];
	?>
	<form action="edit-function.php" method="post" name="form2">
	  <table width="100%" border="0" cellspacing="3" cellpadding="2">
        <tr>
          <td colspan="2" class="bg_colorCopy"><img src="../images/drive_edit.gif" width="16" height="16" align="absmiddle" /> แก้ไขหน่วยงาน</td>
        </tr>
        
        <tr>
          <td width="133" class="bg_color"><div align="right">รหัสหน่วยงาน : </div></td>
          <td width="977" class="yellow_bg_color"><input name="edit_dept_code" type="text" id="edit_dept_code" value="<? echo $edit_dept_code; ?>" /></td>
        </tr>
        <tr>
          <td class="bg_color"><div align="right">ชื่อหน่วยงาน : </div></td>
          <td class="yellow_bg_color"><input name="edit_dept_name" type="text" id="edit_dept_name" value="<? echo $edit_dept_name; ?>" size="30" />
            <input name="edit_dept_id" type="hidden" id="edit_dept_id" value="<? echo $edit_dept_id; ?>" /></td>
        </tr>

        <tr>
          <td class="bg_color">&nbsp;</td>
          <td class="yellow_bg_color"><input type="button" name="Button2" value="บันทึก"  onclick="chkform2();"/>
              <input type="reset" name="Reset2" value="ยกเลิก" /></td>
        </tr>
      </table>
	  </form>
	<? } ?>
	</td>
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
      <tr>
        <td class="bg_colorCopy"><img src="../images/report.gif" width="16" height="16" align="absmiddle" /> หน่วยงานทั้งหมด </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><table width="61%" height="25" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" bordercolorlight="#999999" bordercolordark="#FFFFFF">
          <tr class="title_table_green">
            <td width="190">รหัสหน่วยงาน</td>
            <td width="346">ชื่อหน่วยงาน</td>
            <td width="160">ดำเนินการ</td>
          </tr>
		  <?
		  		$sql="select * from meeting_department order by dept_code";
				$dbquery=@mysql_db_query($dbname, $sql);
				
				while($result=@mysql_fetch_array($dbquery))
				{
					$dept_id=$result[dept_id];
					$dept_code=$result[dept_code];
					$dept_name=$result[dept_name];
					
					
					if($bg == "#DFE6F1") { //ส่วนของการ สลับสี 
					$bg = "#F8F7DE";
					} else {
					$bg = "#DFE6F1";
					}
					
					echo"<tr class='text' bgcolor='$bg'>
						<td align='center'>$dept_code</td>
						<td>&nbsp;$dept_name</td>
						<td align='center'><a href='add_dept.php?edit_dept_id=$dept_id' class='textnormal'>แก้ไข</a> | <a href='delete-function.php?del_dept_id=$dept_id' class='textnormal'>ลบ</a></td>
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
	if(document.form1.dept_code.value == 0)
	{
		alert("กรุณาระบุรหัสหน่วยงาน");
		document.form1.dept_code.focus();
	}else
	if(document.form1.dept_name.value == 0)
	{
		alert("กรุณาระบชื่อหน่วยงาน");
		document.form1.dept_name.focus();
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
	if(document.form2.edit_dept_code.value == 0)
	{
		alert("กรุณาระบุรหัสหน่วยงาน");
		document.form2.edit_dept_code.focus();
	}else
	if(document.form2.edit_dept_name.value == 0)
	{
		alert("กรุณาระบชื่อหน่วยงาน");
		document.form2.edit_dept_name.focus();
	}else
	document.form2.submit();
}

</script>
<? mysql_close(); ?>