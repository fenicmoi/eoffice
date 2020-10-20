<?
	session_start();
	error_reporting(E_ALL^E_NOTICE);
	include "../inc/connect_db.php";
	
	if(!$_SESSION['admin_id'])
	{
		echo"<script language=\"javascript\">
	alert(\"กรุณา Login ก่อนใช้งานหน้านี้\");
	window.parent.location='../admin.php';
</script>";
	}	
?>
<? 
	$monthname=array("มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
?>
<?
	$curDay = date("j");
	$curMonth = date("n");
	$curYear2 = date("Y");
	$curYear = date("Y")+543;
	$year=date("Y");
	
	//$today="$curDay-$curMonth-$curYear";
?>
<? if ($curMonth== '1') { $showmonth = 'มกราคม' ;} ?>
<? if ($curMonth== '2') { $showmonth = 'กุมภาพันธ์' ;} ?>
<? if ($curMonth== '3') { $showmonth = 'มีนาคม' ;} ?>
<? if ($curMonth== '4') { $showmonth = 'เมษายน' ;} ?>
<? if ($curMonth== '5') { $showmonth = 'พฤษภาคม' ;} ?>
<? if ($curMonth== '6') { $showmonth = 'มิถุนายน' ;} ?>
<? if ($curMonth== '7') { $showmonth = 'กรกฏาคม' ;} ?>
<? if ($curMonth== '8') { $showmonth = 'สิงหาคม' ;} ?>
<? if ($curMonth== '9') { $showmonth = 'กันยายน' ;} ?>
<? if ($curMonth== '10') { $showmonth = 'ตุลาคม' ;} ?>
<? if ($curMonth== '11') { $showmonth = 'พฤศจิกายน' ;} ?>
<? if ($curMonth== '12') { $showmonth = 'ธันวาคม' ;} ?>

<? $today="$showmonth $curYear"; ?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
<link href="../mystyle.css" rel="stylesheet" type="text/css">
<script language='javascript' src='popcalendar.js' type="text/javascript"></script>
<style type="text/css">
<!--
body {
	margin-top: 20px;
	background-color: #e5e5e5;
}
-->
</style>
<script type="text/javascript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
</head>

<body>
<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td class="title_bg_text_no_center_blue"><img src="../images/application_add.gif" alt="title" width="16" height="16" align="absmiddle"> ข้อมูลการจองห้องประชุมที่<span class="redfont">ไม่อนุมัติ</span>ประจำปี <? echo $curYear; ?></td>
  </tr>
</table>
<table width="95%" border="0" align="center" cellpadding="3" cellspacing="5">
  <tr>
    <td><form name="form1" id="form1">
      <div align="center">เดือน
        <select name="menu1" onChange="MM_jumpMenu('self',this,0)">
              <option value="meeting-data-cancel.php?month=0">กรุณาเลือกเดือน</option>
              <option value="meeting-data-cancel.php?month=01">มกราคม</option>
              <option value="meeting-data-cancel.php?month=02">กุมภาพันธ์</option>
              <option value="meeting-data-cancel.php?month=03">มีนาคม</option>
              <option value="meeting-data-cancel.php?month=04">เมษายน</option>
              <option value="meeting-data-cancel.php?month=05">พฤษภาคม</option>
              <option value="meeting-data-cancel.php?month=06">มิถุนายน</option>
              <option value="meeting-data-cancel.php?month=07">กรกฎาคม</option>
              <option value="meeting-data-cancel.php?month=08">สิงหาคม</option>
              <option value="meeting-data-cancel.php?month=09">กันยายน</option>
              <option value="meeting-data-cancel.php?month=10">ตุลาคม</option>
              <option value="meeting-data-cancel.php?month=11">พฤศจิกายน</option>
              <option value="meeting-data-cancel.php?month=12">ธ้นวาคม</option>
          </select>
      </div>
    </form></td>
  </tr>
  <?php $month=$_GET['month']; ?>
  <tr>
    <td><div align="center"><span class="title">เดือน</span>
            <? if ($month== '01') { $showmonth2 = 'มกราคม' ;} ?>
            <? if ($month== '02') { $showmonth2 = 'กุมภาพันธ์' ;} ?>
            <? if ($month== '03') { $showmonth2 = 'มีนาคม' ;} ?>
            <? if ($month== '04') { $showmonth2 = 'เมษายน' ;} ?>
            <? if ($month== '05') { $showmonth2 = 'พฤษภาคม' ;} ?>
            <? if ($month== '06') { $showmonth2 = 'มิถุนายน' ;} ?>
            <? if ($month== '07') { $showmonth2 = 'กรกฏาคม' ;} ?>
            <? if ($month== '08') { $showmonth2 = 'สิงหาคม' ;} ?>
            <? if ($month== '09') { $showmonth2 = 'กันยายน' ;} ?>
            <? if ($month== '10') { $showmonth2 = 'ตุลาคม' ;} ?>
            <? if ($month== '11') { $showmonth2 = 'พฤศจิกายน' ;} ?>
            <? if ($month== '12') { $showmonth2 = 'ธันวาคม' ;} ?>
            <? 
if($month)
{
	echo "<b>$showmonth2</b>";
}else 
{
	echo "<b>$showmonth</b>";
}
?></div></td>
  </tr>
  <tr>
    <td width="100%"><table width="100%" height="25" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" bordercolorlight="#999999" bordercolordark="#FFFFFF">
      <tr class="title_table_green">
        <td width="47">ลำดับ</td>
        <td width="97">วันที่ประชุม</td>
        <td width="254">เรื่อง</td>
        <td width="201">ห้องที่จอง</td>
        <td width="152">ช่วงเวลา</td>
        <td width="143">ชื่อผู้จอง</td>
        <td width="65">แก้ไข</td>
      </tr>
      <?			
				if($month)
				{
				$sql="SELECT bk.book_id, bk.subject, rm.roomname, bk.startdate, bk.enddate, bk.bookname , bk.starttime, bk.endtime
				      FROM meeting_booking as bk, meeting_room as rm 
				      WHERE bk.room_id=rm.room_id and bk.conf_status='2' AND (bk.startdate between '$curYear2-$month-01' AND '$curYear2-$month-31') 
				      ORDER BY bk.startdate DESC";
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
					
					if($s >= 1)
					{
						$status="<a href='edit-function.php?conf_book_id=$book_id' class='text'>อนุมัติ</a>";
					}else if($s < 1)
					{
						$status="<font color='#CFCFCF'>อนุมัติ</font>";
					}
					
					list($year, $month, $day) = preg_split('[-]', $startdate);
					$date=  "$day-$month-$year";

					
					if($bg == "#DFE6F1") { //ส่วนของการ สลับสี 
					$bg = "#F8F7DE";
					} else {
					$bg = "#DFE6F1";
					}
					
					echo"<tr class='text' bgcolor='$bg'>
						<td align='center'>$order</td>
						<td align='center'>$date</td>
						<td>&nbsp;$subject</td>
						<td>&nbsp;$room_name</td>						
						<td align='center'>$starttime - $endtime</td>
						<td>&nbsp;$bookname</td>
						<td align='center'>$status</td>
					</tr>";
					
					$order++;
				}
				}else
				{
					$sql="select bk.book_id, bk.subject, rm.roomname, bk.startdate, bk.enddate, bk.bookname , bk.starttime, bk.endtime
				from meeting_booking as bk, meeting_room as rm 
				where bk.room_id=rm.room_id and bk.conf_status='2' AND (bk.startdate between '$curYear2-$curMonth-01' AND '$curYear2-$curMonth-31') 
				order by bk.startdate DESC";
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
					
					if($s >= 1)
					{
						$status="<a href='edit-function.php?conf_book_id=$book_id' class='text'>อนุมัติ</a>";
					}else if($s < 1)
					{
						$status="<font color='#CFCFCF'>อนุมัติ</font>";
					}
					
					list($year, $month, $day) = preg_split('[-]', $startdate);
					$date=  "$day-$month-$year";

					
					if($bg == "#DFE6F1") { //ส่วนของการ สลับสี 
					$bg = "#F8F7DE";
					} else {
					$bg = "#DFE6F1";
					}
					
					echo"<tr class='text' bgcolor='$bg'>
						<td align='center'>$order</td>
						<td align='center'>$date</td>
						<td>&nbsp;$subject</td>
						<td>&nbsp;$room_name</td>						
						<td align='center'>$starttime - $endtime</td>
						<td>&nbsp;$bookname</td>
						<td align='center'>$status</td>
					</tr>";
					
					$order++;
				}
				}
		  ?>
    </table>
    <div align="center"><br>
      </div></td>
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