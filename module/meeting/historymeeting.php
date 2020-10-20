<?php
	session_start();
	error_reporting(E_ALL^E_NOTICE);
	include "inc/connect_db.php";
	$userid=$_SESSION['userid'];
	if(!$_SESSION["userid"])
	{
		echo"<script language=\"javascript\">
	 alert(\"กรุณา Login ก่อนใช้งานหน้านี้\");
	window.location.parent='index.php';
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
<title>ประวัติการจองห้องประชุม</title>
<link href="mystyle.css" rel="stylesheet" type="text/css">
<script language='javascript' src='popcalendar.js' type="text/javascript"></script>
<style type="text/css">
<!--
body {
	margin-top: 20px;
	background-color: #E5E5E5;
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
    <td class="title_bg_text_no_center_blue"><img src="images/application_add.gif" alt="title" width="16" height="16" align="absmiddle"> ประวัติการจองห้องประชุมประจำปี
     <?
	 $sel_year=$_GET['sel_year'];
	  if($sel_year)   //   display year in table
	{
		echo $sel_year;
	}else{
		echo $curYear; 
	}
	?></td>
  </tr>
</table>
<table width="95%" border="0" align="center" cellpadding="3" cellspacing="5">
  <tr>
    <td width="49%">
        <div align="center">เลือกปี 
          <?
		echo "<a href='historymeeting.php?sel_year=$curYear' class='text'>$curYear</a>";
		$next_year=$curYear+1;
		echo "&nbsp;<a href='historymeeting.php?sel_year=$next_year' class='text'>$next_year</a>";
	?>
        </div></td>
  </tr>
  <?
  	if($sel_year)
	{
  ?>
  <tr>
    <td><form name="form1" id="form1">
      <div align="center">เดือน
        <select name="menu1" onChange="MM_jumpMenu('self',this,0)">
              <? echo "<option value=\"historymeeting.php?month=0\">กรุณาเลือกเดือน</option>
              <option value=\"historymeeting.php?month=01&sel_year=$sel_year\">มกราคม</option>
              <option value=\"historymeeting.php?month=02&sel_year=$sel_year\">กุมภาพันธ์</option>
              <option value=\"historymeeting.php?month=03&sel_year=$sel_year\">มีนาคม</option>
              <option value=\"historymeeting.php?month=04&sel_year=$sel_year\">เมษายน</option>
              <option value=\"historymeeting.php?month=05&sel_year=$sel_year\">พฤษภาคม</option>
              <option value=\"historymeeting.php?month=06&sel_year=$sel_year\">มิถุนายน</option>
              <option value=\"historymeeting.php?month=07&sel_year=$sel_year\">กรกฎาคม</option>
              <option value=\"historymeeting.php?month=08&sel_year=$sel_year\">สิงหาคม</option>
              <option value=\"historymeeting.php?month=09&sel_year=$sel_year\">กันยายน</option>
              <option value=\"historymeeting.php?month=10&sel_year=$sel_year\">ตุลาคม</option>
              <option value=\"historymeeting.php?month=11&sel_year=$sel_year\">พฤศจิกายน</option>
              <option value=\"historymeeting.php?month=12&sel_year=$sel_year\">ธ้นวาคม</option>"; ?>
          </select>
      </div>
	</form></td>
  </tr>
  <?
		}else if(!$sel_year)
		{
			//echo "check error";
			//echo $sel_year;
	?>
  <tr>
    <td><form name="form1" id="form1">
      <div align="center">เดือน
        <select name="menu1" onChange="MM_jumpMenu('self',this,0)">
              <option value="historymeeting.php?month=0">กรุณาเลือกเดือน</option>
              <option value="historymeeting.php?month=01">มกราคม</option>
              <option value="historymeeting.php?month=02">กุมภาพันธ์</option>
              <option value="historymeeting.php?month=03">มีนาคม</option>
              <option value="historymeeting.php?month=04">เมษายน</option>
              <option value="historymeeting.php?month=05">พฤษภาคม</option>
              <option value="historymeeting.php?month=06">มิถุนายน</option>
              <option value="historymeeting.php?month=07">กรกฎาคม</option>
              <option value="historymeeting.php?month=08">สิงหาคม</option>
              <option value="historymeeting.php?month=09">กันยายน</option>
              <option value="historymeeting.php?month=10">ตุลาคม</option>
              <option value="historymeeting.php?month=11">พฤศจิกายน</option>
              <option value="historymeeting.php?month=12">ธ้นวาคม</option>
          </select>
      </div>
    </form></td>
	<?
		}
	?>
  </tr>
  <tr>
    <td><div align="center"><span class="title">เดือน</span>
    	     <? $month=$_GET['month']; ?>
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
}else if($sel_year)
{
	echo "<b>___________</b>";
}else if($sel_year & $month)
{
	echo "<b>$showmonth2</b>";
}else
	echo "<b>$showmonth</b>";
?>
    </div></td>
  </tr>
</table>
<?
			if(!$sel_year)
			{
		?>
<table width="95%" height="25" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" bordercolorlight="#999999" bordercolordark="#FFFFFF">
  <tr class="title_table_green">
    <td width="55">ลำดับ</td>
    <td width="122">วันที่ประชุม</td>
    <td width="334">เรื่อง</td>
    <td width="277">ห้องที่จอง</td>
    <td width="165">ช่วงเวลา</td>
    <td width="76">สถานะ</td>
    <td width="82">รายละเอียด</td>
  </tr>
  <?			
  			  $userid=$_SESSION['userid'];
			// echo "This user_id : $user_id";
				if($month)
				{
				$sql="SELECT bk.book_id, bk.subject, rm.roomname, bk.startdate, bk.enddate, bk.bookname , bk.starttime, bk.endtime, bk.conf_status,rm.room_id
				FROM meeting_booking as bk, meeting_room as rm 
				WHERE bk.room_id=rm.room_id and bk.user_id='$userid' AND (bk.startdate between '$curYear2-$month-01' AND '$curYear2-$month-31') Order by bk.book_id ASC";
				//echo "this month:$month <br>";
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
					$conf_status=$result[8];
					$room_id=$result[9];
					
					if($conf_status == "0")
					{
						$conf_status="รออนุมัติ";
					}else if($conf_status == "1")
					{
						$conf_status="อนุมัติ";
					}else if($conf_status == "2")
					{
						$conf_status="ไม่อนุมัติ";
					}
					
					if($bg == "#DFE6F1") { //ส่วนของการ สลับสี 
					$bg = "#F8F7DE";
					} else {
					$bg = "#DFE6F1";
					}
					
					echo"<tr class='text' bgcolor='$bg'>
						<td align='center'>$order</td>
						<td align='center'>$startdate</td>
						<td>&nbsp;$subject</td>
						<td>&nbsp;$room_name</td>
						<td align='center'>$starttime - $endtime</td>
						<td align='center'>$conf_status</td>
						<td align='center'><a href='detail_booking.php?room_id=$room_id&book_id=$book_id' class='text' target='_blank'>รายละเอียด</a></td>
					</tr>";
					
					$order++;
				}
				}else
				{
				$sql="select bk.book_id, bk.subject, rm.roomname, bk.startdate, bk.enddate, bk.bookname , bk.starttime, bk.endtime,bk.conf_status,rm.room_id,bk.tool_id
				from meeting_booking as bk, meeting_room as rm 
				where bk.room_id=rm.room_id and bk.user_id='$userid' AND (bk.startdate between '$curYear2-$curMonth-01' AND '$curYear2-$curMonth-31') Order by bk.book_id ASC";
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
					$conf_status=$result[8];
					$room_id=$result[9];
					$tool_id=$result[10];
					
					if($conf_status == "0")
					{
						$conf_status="รออนุมัติ";
					}else if($conf_status == "1")
					{
						$conf_status="อนุมัติ";
					}else if($conf_status == "2")
					{
						$conf_status="ไม่อนุมัติ";
					}
					
					if($bg == "#DFE6F1") { //ส่วนของการ สลับสี 
					$bg = "#F8F7DE";
					} else {
					$bg = "#DFE6F1";
					}
					
					echo"<tr class='text' bgcolor='$bg'>
						<td align='center'>$order</td>
						<td align='center'>$startdate</td>
						<td>&nbsp;$subject</td>
						<td>&nbsp;$room_name</td>
						<td align='center'>$starttime - $endtime</td>
						<td align='center'>$conf_status</td>
						<td align='center'><a href='detail_booking.php?room_id=$room_id&book_id=$book_id&tool_id=$tool_id' class='text' target='_blank'>รายละเอียด</a></td>
					</tr>";
					
					$order++;
				}
				}
		  ?>
</table>
<?
			}else if($sel_year)
			{
		?>
<table width="95%" height="25" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" bordercolorlight="#999999" bordercolordark="#FFFFFF">
  <tr class="title_table_green">
    <td width="55">ลำดับ</td>
    <td width="122">วันที่ประชุม</td>
    <td width="334">เรื่อง</td>
    <td width="277">ห้องที่จอง</td>
    <td width="165">ช่วงเวลา</td>
    <td width="76">สถานะ</td>
    <td width="82">รายละเอียด</td>
  </tr>
  <?
		  		$year_eng=$sel_year-543;	
				$sql="select bk.book_id, bk.subject, rm.roomname, bk.startdate, bk.enddate, bk.bookname , bk.starttime, bk.endtime, bk.conf_status,rm.room_id,bk.tool_id,bk.tool_id
				from meeting_booking as bk, meeting_room as rm 
				where bk.room_id=rm.room_id and bk.user_id='$userid' AND (bk.startdate between '$year_eng-$month-01' AND '$year_eng-$month-31') Order by bk.book_id ASC";
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
					$conf_status=$result[8];
					$room_id=$result[9];
					$tool_id=$result[10];
					
					if($conf_status == "0")
					{
						$conf_status="รออนุมัติ";
					}else if($conf_status == "1")
					{
						$conf_status="อนุมัติ";
					}else if($conf_status == "2")
					{
						$conf_status="ไม่อนุมัติ";
					}
					
					if($bg == "#DFE6F1") { //ส่วนของการ สลับสี 
					$bg = "#F8F7DE";
					} else {
					$bg = "#DFE6F1";
					}
					
					echo"<tr class='text' bgcolor='$bg'>
						<td align='center'>$order</td>
						<td align='center'>$startdate</td>
						<td>&nbsp;$subject</td>
						<td>&nbsp;$room_name</td>
						<td align='center'>$starttime - $endtime</td>
						<td align='center'>$conf_status</td>
						<td align='center'><a href='detail_booking.php?book_id=$book_id&room_id=$room_id&tool_id=$tool_id' class='text' target='_blank'>รายละเอียด</a></td>
					</tr>";
					
					$order++;
				}
		  ?>
</table>
<?
			}
		?>
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