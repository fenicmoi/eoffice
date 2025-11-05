<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>รายละเอียดสัญญา</title>
<style>
ิbody{
	font-family:thaisanslite;
	font-size:16px;
}

table {
    font-size: 16pt;
    border-collapse: collapse; /* ทำให้เส้นขอบติดกัน */
}

td {
    border: 1px solid #000; /* เปลี่ยนจาก dashed เป็น solid และใช้สีดำ */
    padding: 5px 10px; /* เพิ่มระยะห่างภายในเซลล์ */
}

h3 {
    font-size: 22pt; /* ปรับขนาดให้ใหญ่ขึ้นสำหรับหัวข้อหลัก */
    margin-top: 5px;
    margin-bottom: 5px;
}

h4 {
    font-size: 18pt;
    margin-top: 5px;
    margin-bottom: 5px;
}

center {
    text-align: center;
}
	
td{border:1px dashed #CCC;  }

</style>
</head>

<body>
<?php
session_start();
require_once(__DIR__ . '/vendor/autoload.php'); 
ob_start();

include "../../library/config.php";
include "../../library/database.php";
include "../function.php"; // ต้องแน่ใจว่าฟังก์ชัน thaiDate() และ DateThai() อยู่ในไฟล์นี้


$dep_id=$_SESSION['ses_dep_id'];
$sec_id=$_SESSION['ses_sec_id'];

$hire_id=$_GET['hire_id'];



 $sql="SELECT h.*,y.yname,d.dep_name,s.sec_name,u.firstname,u.lastname
       FROM hire h
			 INNER JOIN year_money y ON y.yid = h.yid
			 INNER JOIN depart d ON d.dep_id = h.dep_id
			 INNER JOIN section s ON s.sec_id = h.sec_id
			 INNER JOIN user u ON u.u_id = h.u_id
			 WHERE h.hire_id=$hire_id
       ";

$result=dbQuery($sql);
$row=dbFetchAssoc($result);

?>


    <table cellspacing="0" cellpadding="1" border="1" style="width:1100px;"> 
		<tr> 
        	<td colspan="2" style="border:none"><center><img  src="logo.jpg" style="width:10%;"><h3>รายงานทะเบียนคุมสัญญาจ้างจังหวัดพัทลุง</h3></center></td>
        </tr> 
        <tr> 
        	<td colspan="2" style="border: none;"><center><h4>วันที่ออกรายงาน <?php echo  DateThai(); ?></h4></center></td>
        </tr> 
				<tr>
					<td>ทะเบียนคุมสัญญา</td>
					<td><?php echo $row['rec_no']?>/<?php echo $row['yname']?></td>
				</tr>
				<!-- <tr>
					<td>วันที่ทำรายการ</td>
					<td><?php //echo  thaiDate($row['h.datein'])?></td>
				</tr> -->
				<tr> 
					<td>รายการจ้าง</td>
					<td><?php echo $row['title'];?></td>
				</tr>
				<tr>
					<td>วงเงินการจ้าง</td>
					<td><?php echo number_format($row['money']);?>-บ.</td>
				</tr>
				<tr>
					<td>หลักประกัน</td>
					<td><?php echo $row['guarantee'];?>-บ.</td>
				</tr>
			  <tr>
					<td>ผู้รับจ้าง</td>
					<td><?php echo $row['employee'];?></td>
				</tr>
				<tr>
					<td>วันที่ลงนามสัญญาจ้าง</td>
					<td><?php echo thaiDate($row['date_hire']);?></td>
				</tr>
				<tr>
					<td>วันที่ส่งมอบงาน</td>
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
	<h5>eoffice จังหวัพัทลุง version_report 5-11-68</h5>
</body>
</html>    
<?Php
$html = ob_get_clean(); 
$mpdf = new \Mpdf\Mpdf([
    'mode' => 'utf-8', 
    'format' => 'A4-L', // A4-L คือแนวนอน
    'tempDir' => __DIR__ . '/temp', // แนะนำให้กำหนด Temp Directory ที่เขียนได้
    'autoScriptToLang' => true,
    'autoLangToFont' => true,
    // 💡 เพิ่มการตั้งค่าระยะขอบกระดาษตรงนี้ (หน่วยเป็นมิลลิเมตร)
    'margin_left' => 10,  // ขอบซ้าย 10 มม.
    'margin_right' => 10, // ขอบขวา 10 มม.
    'margin_top' => 25,   // ขอบบน 15 มม. (เผื่อพื้นที่ส่วนหัว)
    'margin_bottom' => 10, // ขอบล่าง 15 มม. (เผื่อพื้นที่ส่วนท้าย)
]); 

$mpdf->SetDisplayMode('fullpage');
$mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::DEFAULT_MODE); // ใช้ค่าคงที่สำหรับ WriteHTML
$mpdf->Output('รายงานหนังสือรับ_'.date('Ymd').'.pdf', \Mpdf\Output\Destination::INLINE); 
exit; 
?>