<?
	session_start();
	session_destroy();
	error_reporting(E_ALL^E_NOTICE);
	$room=$_POST['room'];
	$startdate=$_POST['startdate'];  //1
	$namefill=$_POST['namefill'];
	//echo "date is $startdate";
	//echo "room is=$room_id";
?>
<? 
	$monthname=array("มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
?>
<?
	$curDay = date("j");
	$curMonth = date("n");
	$curYear = date("Y")+543;
	//echo $curYear;
	//$year=date("Y");
	//$today="$curDay/$curMonth/$curYear";  //<!-- 13-06-2559 -->
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

<? //$today="$curDay $showmonth $curYear"; ?>
<html >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="meeting room">
<title>โปรแกรมจองห้องประชุมออนไลน์</title>
<link href="mystyle.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><? include 'header.php'; ?></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td valign="top" bgcolor="#CCCCCC" class="right_border">&nbsp;</td>
        <td valign="top" bgcolor="#E5E5E5">&nbsp;</td>
      </tr>
      <tr>
        <td width="15%" valign="top" bgcolor="#CCCCCC" class="right_border"><table width="260" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><? include 'menu.php'; ?></td>
          </tr>
        </table></td>
        <td width="85%" valign="top" bgcolor="#E5E5E5"><table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<?
				$sql="select * from meeting_room where room_id='$room'";
				$dbquery=@mysql_db_query($dbname, $sql);
				$result=@mysql_fetch_array($dbquery);
				$room_id=$result[roomid];
				$roomname=$result[roomname];
				$roomplace=$result[roomplace];
				$roomcount=$result[roomcount];
				$roomimg=$result[roomimg];
				$dept=$result[dept];
				$tel=$result[tel];
				$comment=$result[comment];
			?>
              <tr>
                <td><div align="center" class="title">:: ข้อมูลการใช้ <span class="redfont"><? echo $roomname; ?></span> ประจำวันที่ 
				<?

					list($year, $month,$day ) = preg_split('[-]', $startdate);
					//$startdate=  "$day-$month-$year";  //2
					//echo "head table $startdate";
					$year=$year+543;
					//echo "is YEAR=$year";
	
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
					
					$day="$day $showmonth $year";
					echo $day;
					//echo $startdate;
				?> :: </div></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td><table width="100%" height="25" border="1" align="center" cellpadding="3" cellspacing="0" bordercolor="#FFFFFF" bordercolorlight="#999999" bordercolordark="#FFFFFF">
                    <tr class="title_table_green">
                      <td width="37%">เรื่อง</td>
                      <td width="29%">ห้องที่ใช้</td>
                      <td width="9%">จำนวนคน</td>
                      <td width="14%">เวลาประชุม</td>
                      <td width="11%">เพิ่มเติม</td>
                    </tr>
                    <?
                    //echo "ohhh:::$startdate";
                    $startdate=$_POST['startdate'];
					list($day, $month, $year) = preg_split('[-]', $startdate);
					//$year=$year+543;

					//$date=  "$year-$month-$day";
					$date=$startdate;
		  		$sql="select bk.book_id, bk.subject, rm.roomname, bk.startdate, bk.enddate, bk.bookname ,bk.starttime, bk.endtime, bk.numpeople
				from meeting_booking as bk, meeting_room as rm 
				where bk.room_id=rm.room_id and bk.conf_status='1' and bk.startdate='$startdate' and bk.room_id='$room'";
				//echo $sql;
				
				$Per_Page =10;
				if(!$Page)
				$Page=1;
				
				$Prev_Page = $Page-1;
				$Next_Page = $Page+1;
				//echo $sql;
				$dbquery=@mysql_db_query($dbname, $sql);
				
				$Page_start = ($Per_Page*$Page)-$Per_Page;
				$Num_Rows = @mysql_num_rows($dbquery);

				if($Num_Rows<=$Per_Page)
				$Num_Pages =1;
				else if(($Num_Rows % $Per_Page)==0)
				$Num_Pages =($Num_Rows/$Per_Page) ;
				else 
				$Num_Pages =($Num_Rows/$Per_Page) +1;
				
				$Num_Pages = (int)$Num_Pages;
				
				if(($Page>$Num_Pages) || ($Page<0))
				print "<center><b>จำนวน $Page มากกว่า $Num_Pages ยังไม่มีข้อความ<b></center>";
				$sql .= " Order by bk.book_id ASC LIMIT $Page_start , $Per_Page";
				//echo $sql;
				$dbquery = @mysql_query($sql);
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
					$num=$result[8];
					
					if($bg == "#DFE6F1") { //ส่วนของการ สลับสี 
					$bg = "#F8F7DE";
					} else {
					$bg = "#DFE6F1";
					}
					
					echo"<tr class='text' bgcolor='$bg'>
						<td>&nbsp;$subject</td>
						<td>&nbsp;$room_name</td>
						<td align='center'>$num</td>
						<td align='center'>$starttime - $endtime</td>
						<td align='center'><a href='detail.php?book_id=$book_id' target='_blank' class='text'>เพิ่มเติม</a></td>
					</tr>";
					
					$order++;
				}
		  ?>
                  </table>
                    <div align="center"><br />
                        <span class="text">มีรายการจองห้องประชุมทั้งหมด
                      <?= $Num_Rows;?>
                      รายการ แบ่ง <b>
                        <?=$Num_Pages;?>
                        </b> หน้า :
                        <? /* สร้างปุ่มย้อนกลับ */
if($Prev_Page) 
echo " <a href='$PHP_SELF?Page=$Prev_Page&startdate=$startdate' class='text'><< ย้อนกลับ </a>";
for($i=1; $i<$Num_Pages; $i++){
if($i != $Page)
echo "[<a href='$PHP_SELF?Page=$i&startdate=$startdate'  class='text'>$i</a>]";
else 
echo "<b> $i </b>";
}
/*สร้างปุ่มเดินหน้า */
if($Page!=$Num_Pages)
echo "<a href ='$PHP_SELF?Page=$Next_Page&startdate=$startdate'  class='text'> หน้าถัดไป>> </a>";

?>
                    </div></td>
              </tr>
            </table>			</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td colspan="2"><? include 'footer.php'; ?></td>
        </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
<? mysql_close(); ?>