<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>รายละเอียดสัญญา</title>
<style>
td{border:1px dashed #CCC;  }
img {
    display: block;
    margin-left: auto;
    margin-right: auto;
}
</style>
</head>

<body>
<?php


//require_once __DIR__ . '/vendor/autoload.php';
require_once ('vendor/autoload.php');
// Create an instance of the class:
$mpdf = new \Mpdf\Mpdf();
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
			 WHERE h.buy_id=$buyid
       ";
//print $sql;
$result=dbQuery($sql);
$row=dbFetchAssoc($result);

?>

		
		
    <table cellspacing="0" cellpadding="1" border="1" style="width:1100px;"> 
				 <tr> 
        	<td colspan="2"><center><img  src="logo.jpg" style="width:10%;"><h3>รายงานทะเบียนคุมสัญญาจ้าง</h3></center></td>
        </tr> 
        <tr> 
        	<td colspan="2"><center><h4>วันที่ออกรายงาน <?php echo  DateThai(); ?></h4></center></td>
        </tr> 
				<tr>
					<td>ทะเบียนคุมสัญญา</td>
					<td><?php echo $row['rec_no']?>/<?php echo $row['yname']?></td>
				</tr>
				<tr>
					<td>วันที่ทำรายการ</td>
					<td><?php echo  thaiDate($row['date_hire']);?></td>
				<tr>
					<td>รายการซื้อ/ขาย</td>
					<td><?php echo $row['title'];?></td>
				</tr>
				<tr>
					<td>วงเงินซื้อ/ขาย</td>
					<td><?php echo number_format($row['money']);?>-บ.</td>
				</tr>
				<tr>
					<td>หลักประกัน</td>
					<td><?php echo $row['guarantee'];?>-บ.</td>
				</tr>
			  <tr>
					<td>ผู้รับซื้อ/ขาย</td>
					<td><?php echo $row['employee'];?></td>
				</tr>
				<tr>
					<td>วันที่ลงนาม</td>
					<td><?php echo thaiDate($row['date_submit']);?></td>
				</tr>
				<tr>
					<td>ผู้ลงนาม</td>
					<td><?php echo $row['signer'];?></td>
				</tr>
				<tr>
					<td>สำนักงาน</td>
					<td><?php echo $row['dep_name'];?></td>
				</tr>
				<tr>
					<td>กลุ่ม/ฝ่าย</td>
					<td><?php echo $row['sec_name'];?></td>
				</tr>
				<tr>
					<td>เจ้าหน้าที่</td>
					<td><?php echo $row['firstname'];?>&nbsp;<?php echo $row['lastname'];?></td>
				</tr>
	</table>
	<br>
	<h5>ออกรายงานจาก ระบบบริการเอกสารจังหวัดพังงา (E-office 2.0)</h5>
	<h5>ศาลากลางจังหวัดพังงา  อาคารศูนย์ราชการจังหวัดพังงา  ถ.พังงา-ทับปุด ต.ถ้ำน้ำผุด อ.เมืองพังงา จ.พังงา  82000 <br>
		โทรศัพท์ 0 7648 1423 <br>
		โทรสาร  0 7648 1424  <br>
		อีเมลล์  phangnga@moi.go.th
	</h5>
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