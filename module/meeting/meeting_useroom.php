<?
	session_start();
	session_destroy();
	error_reporting(E_ALL^E_NOTICE);
	include'inc/connect_db.php';
?>
<? 
	$monthname=array("มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
?>
<?
	$curDay = date("j");
	$curMonth = date("n");
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

<? $today="$curDay $showmonth $curYear"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<title>โปรแกรมจองห้องประชุมออนไลน์ ราคา 1,000 บาท พร้อมโค้ด</title>
<meta name="keywords" content="โปรแกรม, จองห้องประชุมออนไลน์, จองห้องประชุม PHP">
<meta name="description" content="ขายระบบจองห้องประชุมออนไลน์ ได้โปรแกรมพร้อมโค้ด มีบริการหลังการขาย อัปเดตฟรี ซื้อเลย !">
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
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td valign="top" class="right_border" width="15%"><table width="260" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><? include 'menu.php'; ?></td>
          </tr>
        </table></td>
        <td width="85%" valign="top"><table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td><div align="center" class="title">:: ข้อมูลการจองห้องประชุมประจำเดือน <? echo $curMonth; ?>:: </div></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td><table width="100%" height="25" border="1" align="center" cellpadding="3" cellspacing="0" bordercolor="#FFFFFF" bordercolorlight="#999999" bordercolordark="#FFFFFF">
                  <tr class="title_table">
                    <td width="15%">วันที่</td>
                    <td width="28%">เรื่อง</td>
                    <td width="23%">ห้องที่ใช้</td>
                    <td width="14%">เวลาประชุม</td>
                    <td width="10%">จองโดย</td>
                    <td width="10%">สถานะ</td>
                    </tr>
                  <?
		  		$sql="select bk.startdate, bk.subject, mr.roomname, bk.starttime, bk.endtime, mu.name, bk.conf_status from meeting_booking as bk, meeting_room as mr, meeting_user as mu where bk.room_id=mr.room_id, bk.user_id=mu.user_id";
				$dbquery = mysql_db_query($dbname, $sql);
				
				while($result=mysql_fetch_array($dbquery))
				{
					$startdate=$result[0];
					$subject=$result[1];
					$room_name=$result[2];
					$starttime=$result[3];
					$endtime=$result[4];
					$name=$result[5];
					$conf_status[6];
					
					if($conf_status=1)
					{
						$conf_status="อนุมัติ";
						$
					}
					
					list($year, $month, $day) = split('[/.-]', $startdate);
					$date=  "$day-$month-$year";
					
					echo"<tr class='text'>
						<td align='center'>$date</td>
						<td>&nbsp;$subject</td>
						<td>&nbsp;$room_name</td>
						<td align='center'>$starttime - $endtime</td>
						<td align='center'>$name</td>
						<td align='center'>$conf_status</td>
					</tr>";
					
					$order++;
				}
		  ?>
                </table>
				</td>
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