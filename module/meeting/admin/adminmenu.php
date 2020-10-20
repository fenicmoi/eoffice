<!DOCTYPE html>
<html l">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ระบบจองห้องประชุมออนไลน์</title>
<link href="../mystyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}
-->
</style></head>

<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="right_border">
  
  
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" class="borderall_blue">
      <tr>
        <td class="title_bg_text_no_center_green"><img src="../images/application.gif" width="16" height="16" align="absmiddle" /> เมนูหลัก</td>
      </tr>
      <tr>
        <td><table width="100%" border="0" align="center" cellpadding="2" cellspacing="2">
          
          <tr>
            <td class="blue_bg_color"><img src="../images/arrow_right.gif" width="16" height="16" align="absmiddle" /><a href="meetingroom.php"  class="text" target="rightframe">บันทึกรายละเอียดห้องประชุม1</a></td>
          </tr>
          <tr>
            <td class="yellow_bg_color"><img src="../images/arrow_right.gif" width="16" height="16" align="absmiddle" /><a href="toolmeeting.php"  class="text"  target="rightframe">บันทึกอุปกรณ์ใช้ในการประชุม</a></td>
          </tr>
          <tr>
            <td class="blue_bg_color"><img src="../images/arrow_right.gif" width="16" height="16" align="absmiddle" /><a href="savetime.php" class="text"  target="rightframe">บันทึกเวลาที่ใช้ในการประชุม</a></td>
          </tr>
          <tr>
            <td class="yellow_bg_color"><img src="../images/arrow_right.gif" width="16" height="16" align="absmiddle" /><a href="meeting-data.php" class="text"  target="rightframe">ข้อมูลการจองห้องประชุมใหม่</a></td>
          </tr>
          <tr>
            <td class="blue_bg_color"><img src="../images/arrow_right.gif" width="16" height="16" align="absmiddle" /><a href="meeting-data-conf.php" class="text"  target="rightframe">ข้อมูลการจองห้องประชุมอนุมัติแล้ว</a></td>
          </tr>
          <tr>
            <td class="yellow_bg_color"><img src="../images/arrow_right.gif" width="16" height="16" align="absmiddle" /><a href="meeting-data-cancel.php" class="text"  target="rightframe">ข้อมูลการจองห้องประชุมไม่อนุม้ติ</a></td>
          </tr>
          <tr>
            <td class="blue_bg_color"><img src="../images/arrow_right.gif" width="16" height="16" align="absmiddle" /><a href="config_day2.php" class="text"  target="rightframe">กำหนดวันยกเลิกการจอง</a></td>
          </tr>
          <tr>
            <td class="yellow_bg_color"><img src="../images/arrow_right.gif" width="16" height="16" align="absmiddle" /><a href="add_user.php" class="text"  target="rightframe">เพิ่มผู้ใช้งาน</a></td>
          </tr>
          <tr>
            <td class="blue_bg_color"><img src="../images/arrow_right.gif" width="16" height="16" align="absmiddle" /><a href="add_dept.php" class="text"  target="rightframe">เพิ่มหน่วยงาน</a></td>
          </tr>
        </table></td>
      </tr>
      
      
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" class="borderall_green">
      <tr>
        <td class="title_bg_text_no_center_blue"><img src="../images/application_form_magnify.gif" width="16" height="16" align="absmiddle" /> ข้อมูลส่วนตัว</td>
      </tr>
      
      <tr>
        <td><table width="100%" border="0" align="center" cellpadding="2" cellspacing="2">
          
          <tr>
            <td class="blue_bg_color"><img src="../images/arrow_right.gif" width="16" height="16" align="absmiddle" /><a href="changepass.php" class="text"  target="rightframe">เปลี่ยนรหัสผ่าน</a></td>
          </tr>
          <tr>
            <td class="yellow_bg_color"><img src="../images/arrow_right.gif" width="16" height="16" align="absmiddle" /><a href="../index.php" target="_parent" class="text">ออกจากระบบ</a></td>
          </tr>
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
	if(document.form1.username.value == 0)
	{
		alert("กรุณาระบุชื่อผู้ใช้ก่อนครับ");
		document.form1.username.focus();
	}else 
	if(document.form1.passwords.value == 0)
	{
		alert("กรุณาระบรหัสผ่านก่อนครับ");
		document.form1.passwords.focus();
	}else
	document.form1.submit();
}
</script>