<?php
// 1. จัดการ PHP Logic และ Output Buffering ทันทีตั้งแต่เริ่มต้นไฟล์
// ปิดการรายงาน Error/Warning เพื่อป้องกันการรั่วไหลที่ทำให้ PDF เสียหาย
error_reporting(0); 
session_start();

// 2. Core Includes และ Autoload
// ต้องแน่ใจว่า Path ถูกต้อง
require_once(__DIR__ . '/vendor/autoload.php'); 
include "../../library/config.php";
include "../../library/database.php";
include "../function.php"; // ต้องมี Convert() และ thaiDate() อยู่ในไฟล์นี้

// 3. เริ่ม Output Buffering ก่อนที่ HTML ใดๆ จะถูกสร้าง
ob_start();

// 4. การจัดการตัวแปร (ใช้ buy_id เป็นหลัก)
$buy_id = isset($_GET['buy_id']) ? $_GET['buy_id'] : 0;
// หากยังมีการส่ง hire_id มาจาก buy-serverside.php ให้ใช้ค่านี้เป็น fallback
if ($buy_id == 0) {
    $buy_id = isset($_GET['buy_id']) ? $_GET['buy_id'] : 0;
}

$dep_id = $_SESSION['ses_dep_id'];
$sec_id = $_SESSION['ses_sec_id'];

// 5. ดึงข้อมูล
$sql="SELECT b.*,y.yname,d.dep_name,s.sec_name,u.firstname,u.lastname
      FROM buy b
	  INNER JOIN year_money y ON y.yid = b.yid
	  INNER JOIN depart d ON d.dep_id = b.dep_id
	  INNER JOIN section s ON s.sec_id = b.sec_id
	  INNER JOIN user u ON u.u_id = b.u_id
      WHERE b.buy_id = " . dbEscapeString($buy_id);
//print $sql;
$result=dbQuery($sql);
$row=dbFetchArray($result);

// 6. เริ่ม HTML (เนื้อหา HTML นี้จะถูกเก็บใน Buffer)
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>รายละเอียดสัญญาซื้อ/ขาย</title>
<style>
/* Style สำหรับ PDF */
body {
	/* ใช้ Sarabun เป็นหลัก (ถ้ามีการติดตั้งใน mPDF), Fallback เป็น Garuda/sans-serif */
	font-family: 'Sarabun', 'Garuda', sans-serif; 
	font-size: 16pt; /* ขนาด Font หลัก 16pt (เหมาะสมกับเอกสารราชการ) */
	color: #333; /* สีตัวอักษรเข้มขึ้น */
}

/* หัวข้อหลัก */
h3 {
    font-size: 24pt; /* ขยายให้ใหญ่ขึ้น */
    margin-top: 15px;
    margin-bottom: 5px;
    font-weight: bold;
    color: #000;
}

/* หัวข้อรอง (เลขที่) */
h4 {
    font-size: 18pt;
    margin-top: 0px;
    margin-bottom: 15px;
    font-weight: normal;
}

/* ส่วนท้ายรายงาน */
h5 {
    font-size: 12pt;
    margin-top: 30px;
    margin-bottom: 0px;
    color: #666; /* สีเทาอ่อน */
    text-align: right;
}

center {
    text-align: center;
}

/* ตารางข้อมูล */
table {
    font-size: 14pt; /* ขนาด Font ในตารางเล็กกว่า Body เล็กน้อย */
    border-collapse: collapse; 
    width: 100%;
    border: 1px solid #000; /* กำหนดขอบตารางภายนอก */
}

/* เซลล์ข้อมูล */
td {
    border: 1px solid #000; /* ขอบเซลล์เป็นสีดำ */
    padding: 8px 15px; /* เพิ่ม Padding ให้มีช่องว่าง */
    vertical-align: top;
}

/* แถวสลับสี (เพิ่ม Class 'alt' ใน HTML) */
tr:nth-child(even) {
    background-color: #F8F8F8; /* สีพื้นหลังแถวคู่ (เทาอ่อนมาก) */
}

/* คอลัมน์รายการ/หัวข้อ (ซ้ายมือ) */
.header-col {
    width: 30%;
    font-weight: bold; /* เน้นคอลัมน์รายการ */
    background-color: #EDEDED; /* สีพื้นหลังคอลัมน์หัวข้อ */
    color: #000;
}

</style>
</head>

<body>
<center><h3>รายละเอียดสัญญาซื้อ/ขาย</h3></center>
<center><h4>เลขที่: <?php echo $row['rec_no'];?>/<?php echo $row['yname'];?></h4></center>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td class="header-col" width="30%">รายการซื้อ/ขาย</td>
        <td width="70%"><?php echo $row['title'];?></td>
    </tr>
    <tr>
        <td class="header-col">จำนวนเงิน (บาท)</td>
        <td><?php echo number_format($row['money'], 2);?></td>
    </tr>
    <tr>
        <td class="header-col">เงินโครงการ (บาท)</td>
        <td><?php echo number_format($row['money_project'], 2);?></td>
    </tr>
    <tr>
        <td class="header-col">คู่สัญญา/บริษัท</td>
        <td><?php echo $row['company'];?></td>
    </tr>
    <tr>
        <td class="header-col">ที่อยู่บริษัท</td>
        <td><?php echo $row['add1'];?></td>
    </tr>
    <tr>
        <td class="header-col">รายละเอียดสินค้า/บริการ</td>
        <td><?php echo $row['product'];?></td>
    </tr>
    <tr>
        <td class="header-col">สถานที่จัดส่ง/ปฏิบัติงาน</td>
        <td><?php echo $row['location'];?></td>
    </tr>
    <tr>
        <td class="header-col">วันที่ทำสัญญา</td>
        <td><?php echo thaiDate($row['date_submit']);?></td>
    </tr>
    <tr>
        <td class="header-col">วันสิ้นสุดสัญญา</td>
        <td><?php echo thaiDate($row['date_stop']);?></td>
    </tr>
    <tr>
        <td class="header-col">ผู้ลงนาม</td>
        <td><?php echo $row['signer'];?></td>
    </tr>
    <tr>
        <td class="header-col">สำนักงาน</td>
        <td><?php echo $row['dep_name'];?></td>
    </tr>
    <tr>
        <td class="header-col">กลุ่ม/ฝ่าย</td>
        <td><?php echo $row['sec_name'];?></td>
    </tr>
    <tr>
        <td class="header-col">เจ้าหน้าที่</td>
        <td><?php echo $row['firstname'];?>&nbsp;<?php echo $row['lastname'];?></td>
    </tr>
</table>
<br>
<h5>รายงานจากระบบ e-office จังหวัดพัทลุง วันที่ <?php echo Date('d-m-Y');?></h5>
</body>
</html>    
<?Php
// 7. การประมวลผล mPDF
$html = ob_get_clean(); // ดึงเนื้อหา HTML จาก Buffer 
$mpdf = new \Mpdf\Mpdf([
    'mode' => 'utf-8', 
    'format' => 'A4-P', 
    'tempDir' => __DIR__ . '/temp', 
    'autoScriptToLang' => true,
    'autoLangToFont' => true,
    'margin_left' => 15,
    'margin_right' => 15,
    'margin_top' => 15,
    'margin_bottom' => 15,
]);

$mpdf->WriteHTML($html);
$mpdf->Output('rep-buy-item-'.$buy_id.'.pdf', 'I'); 

// 8. สำคัญมาก: สั่งหยุดการทำงานของสคริปต์ทันที
exit; 
?>