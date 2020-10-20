<?
	session_start();
	error_reporting(E_ALL^E_NOTICE);
	include '../inc/connect_db.php';
	
	if(!$_SESSION['admin_id'])
	{
		echo"<script language=\"javascript\">
	alert(\"please login \");
	window.location=../index.php';
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
	background-color: #E5E5E5;
}
-->
</style></head>

<body onload="document.form1.fullname.focus();">
<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td class="title_bg_text_no_center_blue"><img src="../images/application_add.gif" alt="title" width="16" height="16" align="absmiddle" /> บันทึกผู้ใช้งาน</td>
  </tr>
</table>
<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0" class="borderall_green">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>
	<?
		$edit_user_id=$_POST['edit_user_id'];
		if(!$edit_user_id)
		{
	?>
	<form action="add-function.php" method="post"  name="form1">
	<table width="100%" border="0" cellspacing="3" cellpadding="2">
      <tr>
        <td colspan="2" class="bg_colorCopy"><img src="../images/add.gif" width="16" height="16" align="absmiddle" /> เพิ่มผู้ใช้งาน</td>
        </tr>
      
      <tr>
        <td width="133" class="bg_color"><div align="right">ชื่อ - นามสกุล: </div></td>
        <td width="977" class="yellow_bg_color"><input name="fullname" type="text" id="fullname" size="30" /></td>
      </tr>
      <tr>
        <td class="bg_color"><div align="right">หน่วยงาน : </div></td>
        <td class="yellow_bg_color"><select name="dept" id="dept">
          <option value="0" selected="selected">--เลือกหน่วยงาน--</option>
          <?
			$sql="select * from  meeting_department";
			$dbquery = @mysql_db_query($dbname, $sql);
			$num_rows = @mysql_num_rows($dbquery);
			$i=0;
			while ($i < $num_rows)
			{
			$result = @mysql_fetch_array($dbquery);
			$dept_id=$result[dept_id];
			$dept_name=$result[dept_name];
			echo"<option value='$dept_id'>$dept_name</option>";
			$i++;
			}
			?>
        </select></td>
      </tr>
      <tr>
        <td class="bg_color"><div align="right">ชื่อผู้ใชุ้ : </div></td>
        <td class="yellow_bg_color"><input name="account" type="text" id="account" size="30" /></td>
      </tr>
      <tr>
        <td class="bg_color"><div align="right">รหัสผ่าน : </div></td>
        <td class="yellow_bg_color"><input name="pass" type="text" id="pass" size="30" /></td>
      </tr>
      
      <tr>
        <td class="bg_color">&nbsp;</td>
        <td class="yellow_bg_color"><input type="button" name="Button" value="บันทึก"  onclick="chkform();"/> <input type="reset" name="Reset" value="ยกเลิก" /></td>
      </tr>
    </table>
	</form>
	
	<?
		}else if($edit_user_id)
		{
			$sql="select * from meeting_user where user_id='$edit_user_id' ";
			$dbquery=@mysql_db_query($dbname, $sql);
			$result=@mysql_fetch_array($dbquery);
			
			$fullname=$result[name];
			$account=$result[username];
			$pass=$result[passwords];
			$ref_dept=$result[department];
	?>
	<form action="edit-function.php" method="post" name="form2">
	  <table width="100%" border="0" cellspacing="3" cellpadding="2">
        <tr>
          <td colspan="2" class="bg_colorCopy"><img src="../images/drive_edit.gif" width="16" height="16" align="absmiddle" /> แก้ไขผู้ใช้งาน </td>
        </tr>
        
        <tr>
          <td width="133" class="bg_color"><div align="right">ชื่อ - นามสกุล: </div></td>
          <td width="977" class="yellow_bg_color"><input name="edit_fullname" type="text" id="edit_fullname" value="<? echo $fullname; ?>" size="30" /></td>
        </tr>
        <tr>
          <td class="bg_color"><div align="right">หน่วยงาน : </div></td>
          <td class="yellow_bg_color"><select name="edit_dept" id="edit_dept">
            <? 
			$sql="select * from meeting_department";
			$dbquery=@mysql_db_query($dbname, $sql);
			while($result=@mysql_fetch_array($dbquery))
			{
				$dept_id=$result[dept_id];
				$dept_name=$result[dept_name];
				
				if($ref_dept==$dept_id)
				{
					echo "<option value='$dept_id' selected>$dept_name</option>";
				}else
				{
					echo "<option value='$dept_id'>$dept_name</option>";
				}
			}
		?>
                    </select></td>
        </tr>
        <tr>
          <td class="bg_color"><div align="right">ชื่อผู้ใชุ้ : </div></td>
          <td class="yellow_bg_color"><input name="edit_account" type="text" id="edit_account" value="<? echo $account; ?>" size="30" /></td>
        </tr>
        <tr>
          <td class="bg_color"><div align="right">รหัสผ่าน : </div></td>
          <td class="yellow_bg_color"><input name="edit_pass" type="text" id="edit_pass" value="<? echo $pass; ?>" size="30" />
            <input name="edit_user_id" type="hidden" id="edit_user_id" value="<? echo $edit_user_id; ?>" /></td>
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
        <td class="bg_colorCopy"><img src="../images/report.gif" width="16" height="16" align="absmiddle" /> ผู้ใช้งานทั้งหมด </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><table width="827" height="25" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" bordercolorlight="#999999" bordercolordark="#FFFFFF">
          <tr class="title_table_green">
            <td width="294">ชื่อ - สกุล </td>
            <td width="383">หน่วยงาน</td>
            <td width="142">ดำเนินการ</td>
          </tr>
		  <?
		  		$sql="select mu.user_id, mu.name, md.dept_name from meeting_user as mu, meeting_department as md where mu.department=md.dept_id order by mu.user_id ";
				//echo $sql;
				$dbquery=@mysql_db_query($dbname, $sql);
				
				while($result=@mysql_fetch_array($dbquery))
				{
					$user_id=$result[0];
					$name=$result[1];
					$dept=$result[2];
					
					
					if($bg == "#DFE6F1") { //ส่วนของการ สลับสี 
					$bg = "#F8F7DE";
					} else {
					$bg = "#DFE6F1";
					}
					
					echo"<tr class='text' bgcolor='$bg'>
						<td>&nbsp;$name</td>
						<td>&nbsp;$dept</td>
						<td align='center'><a href='add_user.php?edit_user_id=$user_id' class='textnormal'>แก้ไข</a> | <a href='delete-function.php?del_user_id=$user_id' class='textnormal'>ลบ</a></td>
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
	if(document.form1.fullname.value == 0)
	{
		alert("กรุณาระบุชื่อ สกุลครับ");
		document.form1.fullname.focus();
	}else
	if(document.form1.dept.value == 0)
	{
		alert("กรุณาเลือกหน่วยงานครับ");
		document.form1.dept.focus();
	}else
	if(document.form1.account.value == 0)
	{
		alert("กรุณาระบุชื่่อผู้ใช้ครับ");
		document.form1.account.focus();
	}else
	if(document.form1.pass.value == 0)
	{
		alert("กรุณาระบุรหัสผ่านครับ");
		document.form1.pass.focus();	
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
	if(document.form2.edit_fullname.value == 0)
	{
		alert("กรุณาระบุชื่อ สกุลครับ");
		document.form2.edit_fullname.focus();
	}else
	if(document.form2.edit_dept.value == 0)
	{
		alert("กรุณาเลือกหน่วยงานครับ");
		document.form2.edit_dept.focus();
	}else
	if(document.form2.edit_account.value == 0)
	{
		alert("กรุณาระบุชื่่อผู้ใช้ครับ");
		document.form2.edit_account.focus();
	}else
	if(document.form2.edit_pass.value == 0)
	{
		alert("กรุณาระบุรหัสผ่านครับ");
		document.form2.edit_pass.focus();	
	}else
	document.form2.submit();
}

</script>
<? mysql_close(); ?>