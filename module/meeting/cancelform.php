<?
	session_start();
	error_reporting(E_ALL^E_NOTICE);
	include "inc/connect_db.php";
	$userid=$_SESSION['userid'];
	if(!$userid)
	{
		echo"<script language=\"javascript\">
	alert(\"กรุณา Login ก่อนใช้งานหน้านี้\");
	window.parent.location='index.php';
</script>";
	}	
?>
<? 
	$monthname=array("มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
?>
<?
	$curDay = date("j");
	$curMonth = date("n");
	$curYear = date("Y");
	
	$today2="$curYear-$curMonth-$curDay";
?>
<?
	$sql="select day from meeting_cancelday";
	$dbquery=@mysql_db_query($dbname, $sql);
	$result=@mysql_fetch_array($dbquery);
	
	$config_day=$result[0];
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>ยกเลิกห้องประชุม</title>
<link href="mystyle.css" rel="stylesheet" type="text/css">
<script language='javascript' src='popcalendar.js' type="text/javascript"></script>
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
    <td class="title_bg_text_no_center_blue"><img src="images/application_form_edit.gif" width="16" height="16" align="absmiddle"> แก้ไข / ลบ การจองห้องประชุม</td>
  </tr>
</table>
<form action="edit-form.php" name="form1" method="post">
  <table width="95%" height="25" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" bordercolorlight="#999999" bordercolordark="#FFFFFF">
    <tr class="title_table_green">
      <td width="57">ลำดับ</td>
      <td width="349">เรื่อง</td>
      <td width="227">ห้องที่จอง</td>
      <td width="168">วันที่ประชุม</td>
      <td width="193">ช่วงเวลา</td>
      <td width="193">ชื่อผู้จอง</td>
      <td width="109">ดำเนินการ</td>
    </tr>
    <?
		  		$sql="select bk.book_id, bk.subject, rm.roomname, bk.startdate, bk.enddate, bk.bookname, bk.starttime, bk.endtime
				from meeting_booking as bk, meeting_room as rm 
				where bk.room_id=rm.room_id and bk.user_id='$userid' and bk.startdate > '$today2'  order by bk.startdate";
				//echo $sql;
				$dbquery=@mysql_db_query($dbname, $sql);
				
				$order=1;
				
				while($result=@mysql_fetch_array($dbquery))
				{
					$book_id=$result[0];
					$subject=$result[1];
					$room_name=$result[2];
					$startdate=$result[3];
					$enddate=$result[4];
					$bookname=$result[5];
					$starttime=$result[6];
					$endtime=$result[7];
					
					$today_date=date("Y-m-d");
	
					$expire_explode = explode("-", $startdate);
					$expire_year = $expire_explode[0];
					$expire_month = $expire_explode[1];
					$expire_day = $expire_explode[2];
					
					$today_explode = explode("-", $today_date);
					$today_year = $today_explode[0];
					$today_month = $today_explode[1];
					$today_day = $today_explode[2];
					
					$expire = gregoriantojd($expire_month,$expire_day,$expire_year);
					$today = gregoriantojd($today_month,$today_day,$today_year);
					
					$s=$expire - $today;
					//echo $s;
					//echo $config_day;
					
					if($s > $config_day)
					{
						$status="<a href='delete-function.php?del_book_id=$book_id' class='textnormal' onclick=\"return confirm('ยืนยันลบข้อมูลการจองห้องประชุม')\">ยกเลิก</a>";
					}else if($s <= $config_day)
					{
						$status="<font color='#CFCFCF'>ยกเลิก</font>";
					}
										
					if($bg == "#DFE6F1") { //ส่วนของการ สลับสี 
					$bg = "#F8F7DE";
					} else {
					$bg = "#DFE6F1";
					}
					
					echo"<tr class='text' bgcolor='$bg'>
						<td align='center'>$order</td>
						<td>&nbsp;$subject</td>
						<td>&nbsp;$room_name</td>
						<td align='center'>$startdate</td>
						<td align='center'>$starttime - $endtime</td>
						<td>&nbsp;$bookname</td>
						<!-- <td align='center'><a href='fillform.php?edit_book_id=$book_id' class='textnormal'>*แก้ไข</a> | $status</td>  -->
						<td align='center'>$status</td>
					</tr>";
					
					$order++;
				}
		  ?>
  </table>
  <table width="95%" border="0" align="center" cellpadding="3" cellspacing="5">
  <tr>
    <td width="100%"><span class="redfont">*หมายเหตุ*</span>      <strong>การยกเลิก สามารถทำได้กับรายการจองที่ยังไม่ถึงวันประชุมล่วงหน้า <? echo $config_day; ?> วัน</strong> </td>
  </tr>
</table>
</form>
</body>
</html>
<script language="javascript" type="text/javascript">
function chkform()
{
	if(document.form1.dept.value == 0)
	{
		alert("กรุณาระบุหน่วยงาน / กลุ่มงาน");
		document.form1.dept.focus();
	}else
	if(document.form1.subject.value == 0)
	{
		alert("กรุณาระบุเรื่องที่ประชุม");
		document.form1.subject.focus();
	}else
	if(document.form1.header.value == 0)
	{
		alert("กรุณาระบุประธานในที่ประชุม");
		document.form1.header.focus();
	}else
	if(document.form1.nummeeting.value == 0)
	{
		alert("กรุณาระบุจำนวนผู้เข้าประชุม");
		document.form1.nummeeting.focus();
	}else
	if(document.form1.room_meeting.value == 0)
	{
		alert("กรุณาเลือกห้องประชุม");
		document.form1.room_meeting.focus();
	}else
	if(document.form1.startdate.value == 0)
	{
		alert("กรุณาเลือกวันเริ่มใช้ห้อง");
		document.form1.startdate.focus();
	}else
	if(document.form1.enddate.value == 0)
	{
		alert("กรุณาเลือกวันสุดท้าย");
		document.form1.enddate.focus();
	}else
	if(document.form1.starttime.value == 0)
	{
		alert("กรุณาเลือกเวลาเริ่ม");
		document.form1.starttime.focus();
	}else
	if(document.form1.endtime.value == 0)
	{
		alert("กรุณาเลือกเวลาสิ้นสุด");
		document.form1.endtime.focus();
	}else
	if(document.form1.namefill.value == 0)
	{
		alert("กรุณาระบุผู้จองห้องประชุม");
		document.form1.namefill.focus();
	}else
		document.form1.submit();
}

function check_number() {
e_k=event.keyCode
if (((e_k > 57) || (e_k < 47)) && e_k != 46 && e_k != 13) {
event.returnValue = false;
alert(" กรุณาระบุเป็นตัวเลขเท่านั้น");
}
} 
</script>