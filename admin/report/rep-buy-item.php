<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>รายละเอียดสัญญา</title>
</head>
<body>

<?php
error_reporting(0);
require_once('mpdf/mpdf.php'); //ที่อยู่ของไฟล์ mpdf.php ในเครื่องเรานะครับ
include "../../function.php";
ob_start(); // ทำการเก็บค่า html นะครับ
session_start();
$dep_id=$_SESSION['ses_dep_id'];
$sec_id=$_SESSION['ses_sec_id'];

$buy_id=$_GET['buy_id'];
$dateprint=$_POST['dateprint'];
$uid=$_POST['uid'];
$yid=$_POST['yid'];
$username=$_POST['username'];

header("Content-type:text/html; charset=UTF-8");                
header("Cache-Control: no-store, no-cache, must-revalidate");               
header("Cache-Control: post-check=0, pre-check=0", false);    

include "../../library/config.php";
include "../../library/database.php";
include "../function.php";

 $sql="SELECT h.*,y.yname,d.dep_name,s.sec_name,u.firstname,u.lastname
       FROM buy h
	   INNER JOIN sys_year y ON y.yid = h.yid
	   INNER JOIN depart d ON d.dep_id = h.dep_id
	   INNER JOIN section s ON s.sec_id = h.sec_id
	   INNER JOIN user u ON u.u_id = h.u_id
	   WHERE h.buy_id=$buy_id
       ";
//print $sql;
$result=dbQuery($sql);
$row=dbFetchAssoc($result);
?>

<h2 style="text-align:center">จังหวัดพัทลุง</h2>
<h3 style="text-align:center; margin-top: 5px">สัญญาซื้อขาย</h3>

<h4 >เลขที่ <?php echo $row['rec_no'];?>/<?php echo beYear();?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
วันที่ออกเลขสัญญา <span style="border-bottom: thin dotted;";?><?php echo thaiDate($row['date_submit']);?></span></h4>

<h4>หน่วยงานเจ้าของงบประมาณ <?php echo $row['dep_name'];?>  ระหว่าง จังหวัดพัทลุง  โดย
 <span style="border-bottom: thin dotted;";?><?php echo $row['governer'];?></span> ผู้ซื้อ <br>
 กับ   <span style="border-bottom: thin dotted;";?><?php echo $row['company'];?></span> ผู้ขาย &nbsp;&nbsp;&nbsp;&nbsp;
 ชื่อ ผู้จัดการ/หุ้นส่วนผู้จัดการ <span style="border-bottom: thin dotted;";?><?php echo $row['manager'];?></span> <br>
 ที่อยู่ 
 <span style="border-bottom: thin dotted;";?><?php echo $row['add1'];?></span> <br>
 ที่อยู่ 
 <span style="border-bottom: thin dotted;";?><?php echo $row['add2'];?></span> <br>
 หมายเลขโทรศัพท์/ผู้รับมอบอำนาจ <span style="border-bottom: thin dotted;";?><?php echo $row['telphone'];?></span>
</h4>

<hr>

<h4>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ข้อตกลงซื้อขาย <span style="border-bottom: thin dotted;";?><?php echo $row['product'];?></span>
 สถานที่ส่งมอบ ณ  <span style="border-bottom: thin dotted;";?><?php echo $row['location'];?></span> <br>
 วันครบกำหนด (งวดสุดท้าย)  <span style="border-bottom: thin dotted;";?><?php echo thaiDate($row['date_stop']);?></span>
</h4>

<hr>

<h4>
<?php    
	switch ($row['confirm_id']) {
		case 0:
			$msg = "ไม่มี";
			break;
		case 1: 
			$msg = "เงินสด";
			break;
		case 2: 
			$msg = "เช็คธนาคาร";
			break;
		case 3: 
			$msg = "หนังสือค้ำประกันธนาคาร";
			break;
		case 4: 
			$msg = "หนังสือค้ำประกันของบริษัทเงินทุน";
			break;
		case 5:   
			$msg = "พันธบัตร";
			break;
		default:
			# code...
			break;
	}
?>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ประเภทหลักประกันสัญญา <span style="border-bottom: thin dotted;"><?php echo $msg;?></span> 
จำนวนเงิน <span style="border-bottom: thin dotted;"> <?php  echo number_format($row['money']);?> ( <?php echo bathformat($row['money']);?> ) </span> <br>
กรณีเป็นหนังสือค้ำประกันของธนาคาร <br>
<ol>
	<li>ธนาคารผู้ค้ำประกัน <span style="border-bottom: thin dotted;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;สาขา&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></li>
	<li>เลขที่ <span style="border-bottom: thin dotted;"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; วันที่  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; เดือน &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  ปี  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  </span></li>
</ol>
</h4>
<hr>
<h4>
<kbd>หมายเหตุ : เอกสารฉบับนี้พิมพ์จากระบบสำนักงานอัตโนมัติจังหวัดพัทลุง</kbd> <br>
วันที่ออกรายงาน   <?php echo dateThai();?>
</h4>

</body>
</html>    
<?php
$html = ob_get_contents();
ob_end_clean();
$pdf = new mPDF('th', 'A4', '0', ''); //การตั้งค่ากระดาษถ้าต้องการแนวตั้ง ก็ A4 เฉยๆครับ ถ้าต้องการแนวนอนเท่ากับ A4-L
$pdf->SetAutoFont();
$pdf->SetDisplayMode('fullpage');
$pdf->WriteHTML($html, 2);
$pdf->Output();
?>

<?php   
function bathformat($number) {
	$numberstr = array('ศูนย์','หนึ่ง','สอง','สาม','สี่','ห้า','หก','เจ็ด','แปด','เก้า','สิบ');
	$digitstr = array('','สิบ','ร้อย','พัน','หมื่น','แสน','ล้าน');
  
	$number = str_replace(",","",$number); // ลบ comma
	$number = explode(".",$number); // แยกจุดทศนิยมออก
  
	// เลขจำนวนเต็ม
	$strlen = strlen($number[0]);
	$result = '';
	for($i=0;$i<$strlen;$i++) {
	  $n = substr($number[0], $i,1);
	  if($n!=0) {
		if($i==($strlen-1) AND $n==1){ $result .= 'เอ็ด'; }
		elseif($i==($strlen-2) AND $n==2){ $result .= 'ยี่'; }
		elseif($i==($strlen-2) AND $n==1){ $result .= ''; }
		else{ $result .= $numberstr[$n]; }
		$result .= $digitstr[$strlen-$i-1];
	  }
	}
	
	// จุดทศนิยม
	$strlen = strlen($number[1]);
	if ($strlen>2) { // ทศนิยมมากกว่า 2 ตำแหน่ง คืนค่าเป็นตัวเลข
	  $result .= 'จุด';
	  for($i=0;$i<$strlen;$i++) {
		$result .= $numberstr[(int)$number[1][$i]];
	  }
	} else { // คืนค่าเป็นจำนวนเงิน (บาท)
	  $result .= 'บาท';
	  if ($number[1]=='0' OR $number[1]=='00' OR $number[1]=='') {
		$result .= 'ถ้วน';
	  } else {
		// จุดทศนิยม (สตางค์)
		for($i=0;$i<$strlen;$i++) {
		  $n = substr($number[1], $i,1);
		  if($n!=0){
			if($i==($strlen-1) AND $n==1){$result .= 'เอ็ด';}
			elseif($i==($strlen-2) AND $n==2){$result .= 'ยี่';}
			elseif($i==($strlen-2) AND $n==1){$result .= '';}
			else{ $result .= $numberstr[$n];}
			$result .= $digitstr[$strlen-$i-1];
		  }
		}
		$result .= 'สตางค์';
	  }
	}
	return $result;
  }
?>