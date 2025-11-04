<?php
// 1. การตั้งค่าเริ่มต้น: Session, Autoload, และ Buffering
session_start();

// ** 📌 จุดที่ 1: แก้ไขพาธ Autoload ของ Composer (สำคัญมาก) **
// ต้องแน่ใจว่าพาธนี้ถูกต้องตามโครงสร้างไฟล์ของคุณ
// ในกรณีนี้ สมมติว่าไฟล์ vendor อยู่เหนือไฟล์รายงาน 3 ระดับ
require_once(__DIR__ . '/vendor/autoload.php'); 

// เริ่มเก็บ Output Buffer
ob_start(); 

// 2. ดึงค่าจาก POST และ Session
$dep_id    = $_SESSION['ses_dep_id'];
$sec_id    = $_SESSION['ses_sec_id'];
$dateStart = $_POST['dateStart'];   // วันที่เริ่มต้น
$dateEnd   = $_POST['dateEnd'];     // วันที่สิ้นสุด
$uid       = $_POST['uid'];
$yid       = $_POST['yid'];
$username  = $_POST['username'];

// 3. Includes และการจัดการ Header
// ** 📌 จุดที่ 2: ลบคำสั่ง header() ที่ไม่จำเป็นออก ** (เพราะ mPDF จะจัดการ Header เอง)
// header("Content-type:text/html; charset=UTF-8");               
// ...

include "../../library/config.php";
include "../../library/database.php";
include "../function.php";

// 4. Query สำหรับข้อมูลส่วนหัวหน่วยงาน
// ** 📌 จุดที่ 3: เพิ่มเครื่องหมาย ' ' รอบตัวแปรใน SQL และลบ print $sql; **
$sql_header = "SELECT d.dep_name,s.sec_id,s.sec_name 
               FROM depart as d
               INNER JOIN section as s ON s.sec_id='$sec_id'
               WHERE d.dep_id='$dep_id'";
// print $sql; // ลบออก

$result_header = dbQuery($sql_header);
$row_header = dbFetchArray($result_header);
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>พิมพ์รายงานหนังสือรับประจำวัน[สารบรรณกลาง]</title>
<style>
/* CSS ปรับปรุงเพื่อแสดงผลใน mPDF ได้ดีขึ้น */
body {
    font-family: 'Garuda', sans-serif; /* แนะนำให้ใช้ฟอนต์ที่รองรับภาษาไทย */
}
table {
    width: 100%; /* ใช้ความกว้างเต็มที่ */
    border-collapse: collapse; /* ทำให้เส้นตารางเชื่อมต่อกัน */
    font-size: 10pt; /* ปรับขนาดตัวอักษรให้เหมาะสมกับ A4-L */
}
td, th {
    border: 1px solid #000; /* ใช้เส้นทึบแทนเส้นประ */
    padding: 5px;
    line-height: 1.2;
}
.header-bg {
    background-color: #C0C0C0;
    text-align: center;
    padding: 5px;
}
</style>
</head>

<body>
    <table cellspacing="0" cellpadding="1" border="0">
        <tr> 
            <td colspan="7" class="header-bg">
                <center><h3>รายงานทะเบียนหนังสือรับ ระหว่างวันที่ <?php echo thaiDate($dateStart); ?> - <?php echo thaiDate($dateEnd);?> #<?=$row_header['sec_name'];?></h3></center>
            </td>
        </tr> 
        <tr>
            <td class="header-bg" colspan="7"><center><h4>หน่วยรับ: <?php echo $row_header['dep_name'];?></h4></center></td>
        </tr>
        <tr>
            <td class="header-bg" colspan="7"><center><h4>กลุ่มงาน/หน่วยงานย่อย: <?php echo $row_header['sec_name'];?> &nbsp;|&nbsp; วันที่ออกรายงาน: <?php echo DateThai();?></center></td>
        </tr>
        <tr>
            <th width="5%">#</th>
            <th width="10%">เลขรับ</th>
            <th width="15%">เลขหนังสือ</th>
            <th>เรื่อง</th>
            <th width="10%">ลงวันที่</th>
            <th width="15%">เจ้าของเรื่อง</th>
            <th width="10%">ลงชื่อผู้รับ</th> 
        </tr>
        <?php
        $sql_data = "SELECT m.book_id,m.rec_id,d.book_no,d.title,d.date_book,dep.dep_name
                     FROM book_master m
                     INNER JOIN book_detail d ON d.book_id = m.book_id
                     INNER JOIN section s ON s.sec_id = m.sec_id 
                     INNER JOIN depart dep ON d.practice = dep.dep_id
                     WHERE m.type_id=1 
                     AND d.date_line BETWEEN '$dateStart' AND '$dateEnd' 
                     AND m.dep_id='$dep_id'
                     ORDER BY m.rec_id DESC";
         print $sql; 
        
        $result_data = dbQuery($sql_data);
        $total_rows = dbNumRows($result_data);
        $i = 1;
        
        while($rs = dbFetchArray($result_data)){
        ?>  
        <tr>
            <td align="center"><?= $i ?></td> 
            <td>&nbsp;<?= $rs['rec_id'] ?></td>
            <td>&nbsp;<?= $rs['book_no'] ?></td>
            <td>&nbsp;<?= $rs['title'] ?></td>
            <td>&nbsp;<?= thaiDate($rs['date_book']) ?></td>
            <td><?= $rs['dep_name'] ?></td>
            <td>&nbsp;</td>
        </tr>
        <?php $i++; } ?>     
        <tr>
            <td class="header-bg" colspan="5" align="right"><b>รวมหนังสือรับ</b></td>
            <td class="header-bg" colspan="2" align="center"><b><?= $total_rows ?> ฉบับ</b></td>
        </tr>
    </table>
<h4>*หมายเหตุ: ใช้สำหรับเจ้าหน้าที่นำส่งเอกสารลงชื่อรับเอกสารตัวจริง</h4>
</body>
</html>    
<?Php
// 5. การสร้าง PDF ด้วย mPDF (เวอร์ชันใหม่)

$html = ob_get_clean(); // ดึงค่า HTML และปิดบัฟเฟอร์

// กำหนดค่า Config Array สำหรับ mPDF (มาตรฐานใหม่)
$mpdf_config = [
    'mode' => 'utf-8', 
    'format' => 'A4-L', 
    'tempDir' => __DIR__ . '/temp', // ต้องสร้างโฟลเดอร์ 'temp' และกำหนดสิทธิ์การเขียน
    'autoScriptToLang' => true,
    'autoLangToFont' => true
];

// สร้าง Instance โดยใช้ \Mpdf\Mpdf (แก้ไขปัญหา Class 'mPDF' not found)
$pdf = new \Mpdf\Mpdf($mpdf_config); 

$pdf->SetDisplayMode('fullpage');

// การเขียน HTML โดยใช้ค่าคงที่พร้อม Namespace
$pdf->WriteHTML($html, \Mpdf\HTMLParserMode::DEFAULT_MODE); 

// สั่ง Output โดยใช้ค่าคงที่พร้อม Namespace
$filename = 'รายงานหนังสือรับ_'.date('Ymd').'.pdf';
$pdf->Output($filename, \Mpdf\Output\Destination::INLINE); 

exit; 
?>