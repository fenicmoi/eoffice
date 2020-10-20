<?php
	session_start();
	session_destroy();
	error_reporting(E_ALL^E_NOTICE);
	include'inc/connect_db.php';
?>

<!doctype html>
<html>
<head>
<title>รายละเอียดการประชุม</title>
<link href="mystyle.css" rel="stylesheet" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="meeting room">
<link href="mystyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script language='javascript' src='popcalendar.js'></script>
<style type="text/css">
<!--

body {
	margin-left: 0px;
}
-->
</style>
</head>
<?php
	    $book_id=$_GET["book_id"];
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
		
	?>  
    <?php
	   $book_id=$_GET["book_id"];
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
    <?php  
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
			$showimg="<img src='admin/roomimg/noimg.jpg' border='1' width='200' height='150'>";	
		}else
		{
			$showimg="<img src='admin/roomimg/$roomimg' border='1' width='200' height='150'>";
		}
		?> 
<body>
     <div class="container">
     <div class="row">
     	<div class="col-md-3"> col1 </div>
        <div class="col-md-6"> 
        	<div class="well">
            		<table width="" border="1" align="center" cellpadding="5" cellspacing="0" bordercolor="#000000" bordercolorlight="#666666" bordercolordark="#FFFFFF">
 					 <tr>
   						 <td colspan="2"><center>รายละเอียดการใช้ห้องประชุม</center></td>
  					 </tr>
 					 <tr>
    					 <td colspan="2">
                         	<table width="100%" border="0" cellspacing="0" cellpadding="0">
     				 	    <tr>
        						<td width="3%" valign="top"><?echo $showimg; ?></td>
        						<td width="97%" valign="top">
                                	<table width="100%" border="0" cellspacing="5" cellpadding="2">
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
        							</table>
                                </td>
      						</tr>
    						</table>
                         </td>
  					</tr>
  					<tr>
   						 <td><div align="right" class="title">วันที่ใช้ห้อง : </div></td>
    					 <td><strong><? echo $startdate; ?></strong></td>
  					</tr>
  					<tr>
    					 <td width="158"><div align="right" class="title">เรื่องประชุม : </div></td>
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
   						<td><div align="right" class="title">อุปกรณ์ที่ใช้ : </div></td>
    					<td><strong>
      					<?php
	  						$sql="select * from meeting_tools";
							$dbquery=@mysql_db_query($dbname, $sql);
							$numrows=@mysql_num_rows($dbquery);
							$num = 0;
							while($result=@mysql_fetch_array($dbquery)){
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
							for($i=0;$i<$numrows;$i++){
							// ถ้าค่า tool มีอยู่ใน tool ที่เลือกให้ทำ
							if(in_array($tool_id[$i],$all_tool2)){
							echo "$toolname[$i],";
							}
							}
						?>
    						</strong> </td>
 					 </tr>
  					  
  <tr>
    <td><div align="right" class="title">หน่วยงาน : </div></td>
    <td><strong>
      <? 
	$sql="SELECT
			depart.name,user.name,user.phone
		  FROM  depart
		    Inner Join user ON user.did = depart.did
		    Inner Join meeting_booking ON user.uid = meeting_booking.uid
		  WHERE
          user.uid =  '$user_id' AND
          meeting_booking.book_id =  '$book_id'";
$dbquery=@mysql_db_query($dbname, $sql);
$result=@mysql_fetch_array($dbquery);

$department=$result[0];
$user=$result[1];
$phone_u=$result[2];
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

            </div>  <!-- col-md-6 -->
        <div class="col-md-3"> col3 </div>
     </div>
     </div>

</body>
</html>
