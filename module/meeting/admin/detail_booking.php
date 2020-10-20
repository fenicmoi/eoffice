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
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>รายละเอียดการใช้ห้องประชุม</title>
<link href="../mystyle.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
body {
	margin-top: 10px;
}
-->
</style></head>

<body>
<table width="500" border="1" align="center" cellpadding="5" cellspacing="0" bordercolor="#000000" bordercolorlight="#666666" bordercolordark="#FFFFFF">
  <tr>
    <td colspan="2">
	<?
		$book_id=$_GET['book_id'];
		$sql="select * from meeting_booking where book_id='$book_id'";
		$dbquery=@mysql_db_query($dbname, $sql);
		$result=@mysql_fetch_array($dbquery);
		
		$dep=$result[department];
		$subj=$result[subject];
		$head=$result[head];
		$num=$result[numpeople];
		$room_id=$result[room_id];
		$enddate=$result[enddate];
		$starttime=$result[starttime];
		$endtime=$result[endtime];
		$bookname=$result[bookname];
		$booking_date=$result[booking_date];
		$comment=$result[comment];
		$format=$result[format];
		$user_id=$result[user_id];
		$admin_id=$result[admin_id];
		$startdate=$result[startdate];
		
		
		
		
		list($year, $month, $day) = preg_split('[-]', $startdate);
		$startdate=  "$day-$month-$year";
		
		/*list($year, $month, $day) = split('[/.-]', $enddate);
		$enddate=  "$year-$month-$day";
					
		$year=$year+543;
	
		if ($month== '1') { $showmonth = 'มกราคม' ;}else
		if ($month== '2') { $showmonth = 'กุมภาพันธ์' ;}else
		if ($month== '3') { $showmonth = 'มีนาคม' ;}else
		if ($month== '4') { $showmonth = 'เมษายน' ;}else
		if ($month== '5') { $showmonth = 'พฤษภาคม' ;}else
		if ($month== '6') { $showmonth = 'มิถุนายน' ;}else
		if ($month== '7') { $showmonth = 'กรกฏาคม' ;}else
		if ($month== '8') { $showmonth = 'สิงหาคม' ;}else
		if ($month== '9') { $showmonth = 'กันยายน' ;}else
		if ($month== '10') { $showmonth = 'ตุลาคม' ;}else
		if ($month== '11') { $showmonth = 'พฤศจิกายน' ;}else
		if ($month== '12') { $showmonth = 'ธันวาคม' ;}
					
		$showstartdate="$day $showmonth $year";
		$showenddate="$day $showmonth $year";*/
	?>
    </td>
  </tr>
  <tr>
    <td colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="3%" valign="top"><?
		$sql="select * from meeting_room where room_id=$room_id";
		//echo $sql;
		$dbquery=@mysql_db_query($dbname, $sql);
		$result=@mysql_fetch_array($dbquery);
		
		$roomname=$result[roomname];
		$roomplace=$result[roomplace];
		$roomimg=$result[roomimg];
		$roomcount=$result[roomcount];
		
		if($roomimg =='')
		{
			$showimg="<img src='roomimg/noimg.jpg' border='1' width='200' height='150'>";	
		}else
		{
			$showimg="<img src='roomimg/$roomimg' border='1' width='200' height='150'>";
		}
		echo $showimg;
	?></td>
        <td width="97%" valign="top"><table width="100%" border="0" cellspacing="5" cellpadding="2">
          <tr>
            <td width="38%"><div align="right" class="title">ชื่อห้องประชุม : </div></td>
            <td width="62%"><strong><? echo $roomname; ?></strong></td>
          </tr>
          <tr>
            <td><div align="right" class="title">สถานที่ตั้ง : </div></td>
            <td><strong><? echo $roomplace; ?></strong></td>
          </tr>
          <tr>
            <td><div align="right" class="title">ความจุที่นั่ง : </div></td>
            <td><strong><? echo $roomcount; ?> คน </strong></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><div align="right" class="title">วันที่ใช้ห้อง : </div></td>
    <td><strong><? echo $startdate; ?></strong></td>
  </tr>
  <tr>
    <td width="158"><div align="right" class="title">เรืองที่ประชุม : </div></td>
    <td width="316"><strong><? echo $subj; ?></strong></td>
  </tr>
  <tr>
    <td><div align="right" class="title">ประธานในที่ประชุม : </div></td>
    <td><strong><? echo $head; ?></strong></td>
  </tr>
  <tr>
    <td><div align="right" class="title">จำนวนผู้ร่วมประชุม : </div></td>
    <td><strong><? echo $num; ?></strong></td>
  </tr>
  <tr>
    <td><div align="right" class="title">ช่วงเวลาที่ใช้ : </div></td>
    <td><strong><? echo "ตั้งแต่เวลา $starttime ถึง $endtime"; ?></strong></td>
  </tr>
  <tr>
    <td><div align="right" class="title">อุปกรณ์ที่ใ้ช้ : </div></td>
    <td><strong>
      <?
	  	$sql="select * from meeting_tools";
		$dbquery=@mysql_db_query($dbname, $sql);
		$numrows=@mysql_num_rows($dbquery);
		$num = 0;
		while($result=@mysql_fetch_array($dbquery))
		{
		$tool_id[$num]=$result[tool_id];
		$toolname[$num]=$result[toolname];
		$num++;
		}
	  	
		$sql2="select tool_id from meeting_booking where book_id='$book_id' ";
		$dbquery2=@mysql_db_query($dbname, $sql2);
		$result2=@mysql_fetch_array($dbquery2);
		$all_tool=$result2[0];
		$all_tool2=explode(",", $all_tool);
		
		// ลูป tool ที่มีทั้งหมด
		for($i=0;$i<$numrows;$i++)
		{
		// ถ้าค่า tool มีอยู่ใน tool ที่เลือกให้ทำ
		if(in_array($tool_id[$i],$all_tool2))
		{
		echo "$toolname[$i],";
		}
		}
	?>
    </strong> </td>
  </tr>
  <tr>
    <td><div align="right" class="title">เตรียมอาหาร : </div></td>
    <td><strong>
      <?
		$sql="select * from meeting_foods";
		$dbquery=@mysql_db_query($dbname, $sql);
		$numrows=@mysql_num_rows($dbquery);
		$num = 0;
		while($result=@mysql_fetch_array($dbquery))
		{
		$food_id[$num]=$result[food_id];
		$food_name[$num]=$result[food_name];
		$num++;
		}
	  	
		$sql2="select food_id from meeting_booking where book_id='$book_id' ";
		$dbquery2=@mysql_db_query($dbname, $sql2);
		$result2=@mysql_fetch_array($dbquery2);
		$all_food=$result2[0];
		$all_food2=explode(",", $all_food);
		
		// ลูป tool ที่มีทั้งหมด
		for($i=0;$i<$numrows;$i++)
		{
		// ถ้าค่า tool มีอยู่ใน tool ที่เลือกให้ทำ
		if(in_array($food_id[$i],$all_food2))
		{
		echo "$food_name[$i],";
		}
		}
	?>
    </strong></td>
  </tr>
  <tr>
    <td><div align="right" class="title">หน่วยงาน : </div></td>
    <td><strong>
      <? 
	$sql="SELECT
meeting_department.dept_name, meeting_user.phone
FROM
meeting_department
Inner Join meeting_user ON meeting_user.department = meeting_department.dept_id
Inner Join meeting_booking ON meeting_user.user_id = meeting_booking.user_id
WHERE
meeting_user.user_id =  '$user_id' AND
meeting_booking.book_id =  '$book_id'";
$dbquery=@mysql_db_query($dbname, $sql);
$result=@mysql_fetch_array($dbquery);

$department=$result[0];
$phone_u=$result[1];
echo $department;
	?>
    </strong></td>
  </tr>
  <tr>
    <td><div align="right" class="title">เบอร์ติดต่อ : </div></td>
    <td><strong><? echo $phone_u; ?></strong></td>
  </tr>
  <tr>
    <td><div align="right" class="title">หมายเหตุ : </div></td>
    <td><strong><? echo $comment; ?></strong></td>
  </tr>
  <tr>
    <td><div align="right" class="title">ชื่อผู้จอง : </div></td>
    <td><strong><? echo $bookname; ?></strong></td>
  </tr>
</table>
<p align="center">
  <input type="submit" name="Submit" value="ปิดหน้าต่าง" onClick="window.close();">
</p>
</body>
</html>
