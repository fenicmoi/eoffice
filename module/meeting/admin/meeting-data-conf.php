<?
	session_start();
	error_reporting(E_ALL^E_NOTICE);
	include "../inc/connect_db.php";
	
	if(!$_SESSION['admin_id'])
	{
		echo"<script language=\"javascript\">
	alert(\"กรุณาเข้าสู่ระบบ\");
	window.parent.location=../admin.php';
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
 <?php $month=$_GET['month']; ?>
<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td class="title_bg_text_no_center_blue"><img src="../images/application_add.gif" alt="title" width="16" height="16" align="absmiddle"> ข้อมูลการจองห้องประชุมที่<span class="redfont">อนุมัติแล้ว</span>ประจำปี <? echo $curYear; ?></td>
  </tr>
</table>

  <table width="95%" border="0" align="center" cellpadding="3" cellspacing="5">
  <tr>
    <td><form name="form1" id="form1"><div align="center">เดือน 	
      <select name="menu1" onChange="MM_jumpMenu('self',this,0)">
        <option value="meeting-data-conf.php?month=0">กรุณาเลือกเดือน</option>
	  	<option value="meeting-data-conf.php?month=01">มกราคม</option>
	  	<option value="meeting-data-conf.php?month=02">กุมภาพันธ์</option>
	  	<option value="meeting-data-conf.php?month=03">มีนาคม</option>
	  	<option value="meeting-data-conf.php?month=04">เมษายน</option>
	  	<option value="meeting-data-conf.php?month=05">พฤษภาคม</option>
	  	<option value="meeting-data-conf.php?month=06">มิถุนายน</option>
	  	<option value="meeting-data-conf.php?month=07">กรกฎาคม</option>
	  	<option value="meeting-data-conf.php?month=08">สิงหาคม</option>
	  	<option value="meeting-data-conf.php?month=09">กันยายน</option>
	  	<option value="meeting-data-conf.php?month=10">ตุลาคม</option>
	  	<option value="meeting-data-conf.php?month=11">พฤศจิกายน</option>
	  	<option value="meeting-data-conf.php?month=12">ธ้นวาคม</option>
        </select>      
      </div></form></td>
  </tr>
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
	echo "$month2<br>";
}else 
{
	echo "<b>$showmonth</b>";
	echo "$month<br>";
}
?></div></td>
  </tr>
  <tr>
    <td width="100%">
	<table width="100%" height="25" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" bordercolorlight="#999999" bordercolordark="#FFFFFF">
      <tr class="title_table_green">
        <td width="40">ลำดับ</td>
        <td width="81">วันที่ประชุม</td>
        <td width="214">เรื่อง</td>
        <td width="184">ห้องที่จอง</td>
        <td width="124">ช่วงเวลา</td>
        <td width="121">ชื่อผู้จอง</td>
        <td width="73">โทร</td>
        <td width="69">แก้ไข</td>
        <td width="49">ยกเลิก</td>
        <td width="49">update</td>
      </tr>
      <?		
	  //echo "month=$month<br>";	
				if($month)
				{
				$sql="SELECT
							 bk.book_id, bk.subject, rm.roomname, bk.startdate, bk.enddate, bk.bookname , bk.starttime, bk.endtime,bk.update_status, bk.user_id
				      FROM 
					         meeting_booking as bk, meeting_room as rm, user as mu
				      WHERE  bk.user_id=mu.uid AND bk.room_id=rm.room_id and bk.conf_status='1' AND (bk.startdate between '$curYear2-$month-01' AND '$curYear2-$month-31') 
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
					$phone=$result[8];
					$update=$result[9];
					$user_id=$result[10];
					//echo "update=$update<br>";
					if($update  == 0)
					{
						$update="";
					}else if($update == 1)
					{
						$update="<a href='edit-function.php?book_id=$book_id'><img src='../images/update.gif' border='0'></a>";
					}
					
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
						$status="<a href='delete-function.php?conf_book_id=$book_id' class='text'>ไม่อนุมัติ</a>";
					}else if($s < 1)
					{
						$status="<font color='#CFCFCF'>ไม่อนุมัติ</font>";
					}
					
					list($year, $month, $day) =preg_split('[-]', $startdate);
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
						<td align='center'>$phone</td>
						<td align='center'>$status</td>
						<td align='center'><a href='delete-function.php?del_book_id=$book_id' class='text'>ยกเลิก</a></td>
						<td align='center'>$update</td>
					</tr>";
					
					$order++;
				}
				}else
				{
					$sql="select bk.book_id, bk.subject, rm.roomname, bk.startdate, bk.enddate, bk.bookname , bk.starttime, bk.endtime, mu.phone, bk.update_status, bk.user_id
				from meeting_booking as bk, meeting_room as rm, meeting_user as mu
				where bk.user_id=mu.user_id AND bk.room_id=rm.room_id and bk.conf_status='1' AND (bk.startdate between '$curYear2-$curMonth-01' AND '$curYear2-$curMonth-31') 
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
					$phone=$result[8];
					$update=$result[9];
					$user_id=$result[10];
					
					if($update  == 0)
					{
						$update="";
					}else if($update == 1)
					{
						$update="<a href='edit-function.php?book_id=$book_id'><img src='../images/update.gif' border='0'></a>";
					}
					
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
						$status="<a href='delete-function.php?conf_book_id=$book_id' class='text'>ไม่อนุมัติ</a>";
					}else if($s < 1)
					{
						$status="<font color='#CFCFCF'>ไม่อนุมัติ</font>";
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
						<td align='center'>$phone</td>
						<td align='center'>$status</td>
						<td align='center'><a href='delete-function.php?del_book_id=$book_id' class='text'>ยกเลิก</a></td>
						<td align='center'>$update</td>
					</tr>";
					
					$order++;
				}
				}
		  ?>
    </table>
	<div align="center"><br></div></td>
    </tr>
  <tr>
    <td><table width="800" border="0" cellspacing="2" cellpadding="2">
      <tr>
        <td width="74"><span class="redfont">*หมายเหตุ*</span></td>
        <td width="712"><strong>: คลิกที่ <img src="../images/update.gif" width="47" height="10"> เพื่อรับทราบการแำ้ก้ไข </strong></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
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