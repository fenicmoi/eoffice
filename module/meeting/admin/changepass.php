<?
	session_start();
	error_reporting(E_ALL^E_NOTICE);
	include '../inc/connect_db.php';
	
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

<body onload="document.form1.old_pass.focus();">
<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td class="title_bg_text_no_center_blue"><img src="../images/application_form_edit.gif" alt="title" width="16" height="16" align="absmiddle" /> ������ʼ�ҹ</td>
  </tr>
</table>
<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0" class="borderall_green">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><form action="edit-function.php" name="form1" method="post">
	<table width="504" border="0" cellspacing="3" cellpadding="2">
      
      <tr>
        <td width="106" class="bg_color"><div align="right">���ʼ�ҹ��� : </div></td>
        <td width="381" class="yellow_bg_color"><input name="old_pass" type="password" id="old_pass" /></td>
      </tr>
      <tr>
        <td class="bg_color"><div align="right">���ʼ�ҹ���� : </div></td>
        <td class="yellow_bg_color"><input name="new_pass1" type="password" id="new_pass1" /></td>
      </tr>
      <tr>
        <td class="bg_color"><div align="right">���ʼ�ҹ�����ա���� : </div></td>
        <td class="yellow_bg_color"><input name="new_pass2" type="password" id="new_pass2" /></td>
      </tr>
      <tr>
        <td class="bg_color">&nbsp;</td>
        <td class="yellow_bg_color"><input type="button" name="Button" value="�ѹ�֡"  onclick="chkform();"/> <input type="reset" name="Submit2" value="¡��ԡ" /></td>
      </tr>
    </table>
	</form>	</td>
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
	if(document.form1.old_pass.value == 0)
	{
		alert("��س��к����ʼ�ҹ���");
		document.form1.old_pass.focus();
	}else
	if(document.form1.new_pass1.value == 0)
	{
		alert("��س��к����ʼ�ҹ����");
		document.form1.new_pass1.focus();
	}else
	if(document.form1.new_pass2.value == 0)
	{
		alert("��س��к����ʼ�ҹ�����ա����");
		document.form1.new_pass2.focus();
	}else
	document.form1.submit();
}
</script>
<? mysql_close(); ?>