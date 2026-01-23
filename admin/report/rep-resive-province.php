<?php

session_start();
require_once(__DIR__ . '/vendor/autoload.php');
ob_start();

include "../../library/config.php";
include "../../library/database.php";
include "../function.php"; // ต้องแน่ใจว่าฟังก์ชัน thaiDate() และ DateThai() อยู่ในไฟล์นี้


// 3. ดึงค่าจาก Session และ POST
$dep_id = $_SESSION['ses_dep_id'];
$sec_id = $_SESSION['ses_sec_id'];
$dateprint = $_POST['dateprint'];  // วันที่พิมพ์รายงาน
$uid = $_POST['uid'];
$yid = $_POST['yid'];
$username = $_POST['username'];
$scope = $_POST['scope'] ?? 'all';


$sql = "SELECT d.dep_name,s.sec_id,s.sec_name 
      FROM depart as d
      INNER JOIN section as s ON s.sec_id='$sec_id'
      WHERE d.dep_id = '$dep_id'";

$result = dbQuery($sql);
$row = dbFetchArray($result);

?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>พิมพ์รายงานหนังสือรับประจำวัน[สารบรรณกลาง]</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <table cellspacing="0" cellpadding="1" border="0" style="width:100%;">
        <tr>
            <td class="header-bg" colspan="8">
                <center>
                    <h4>รายงานทะเบียนรับหนังสือจังหวัดพัทลุง ประจำวันที่ <?= thaiDate($dateprint) ?></h4>
                </center>
            </td>
        </tr>
        <tr>
            <td class="header-bg" colspan="8">
                <center>
                    <h4>หน่วยรับ: <?php echo $row['dep_name']; ?></h4>
                </center>
            </td>
        </tr>
        <tr>
            <td class="header-bg" colspan="8">
                <center>
                    <h4>กลุ่มงาน: <?php echo $row['sec_name']; ?> &nbsp;|&nbsp; วันที่ออกรายงาน:
                        <?php echo DateThai(); ?>
                    </h4>
                    <?php if ($scope == 'owner') { ?>
                        <h5>(เฉพาะที่เป็นเจ้าของ)</h5>
                    <?php } ?>
                </center>
            </td>
        </tr>
        <tr>
            <th width="5%">#</th>
            <th width="5%">เลขรับ</th>
            <th width="10%">วันที่รับ</th>
            <th width="10%">เลขหนังสือ</th>
            <th width="10%">ลงวันที่</th>
            <th width="40">เรื่อง</th>
            <th width="15%">หน่วยปฏิบัติ</th>
            <th width="10%">ลงชื่อผู้รับ</th>
        </tr>
        <?php
        $i = 1;  // ตัวนับลำดับแถว
        $sql = "SELECT m.book_id,m.rec_id,m.dep_id,d.book_no,d.title,d.sendfrom,d.sendto,d.date_book,d.date_in,d.date_line,d.practice,d.status,s.sec_code,dep.dep_name
              FROM book_master m
              INNER JOIN book_detail d ON d.book_id = m.book_id
              INNER JOIN section s ON s.sec_id = m.sec_id 
              INNER JOIN depart dep ON dep.dep_id= d.practice
              LEFT JOIN user u ON m.u_id = u.u_id
              WHERE m.type_id=1 
              AND d.date_line BETWEEN '$dateprint 00:00:00' AND '$dateprint 23:59:59' ";

        if ($scope == 'owner') {
            $sql .= " AND m.u_id = '$uid' ";
        } else {
            $sql .= " AND (m.dep_id='$dep_id' OR u.dep_id='$dep_id') ";
        }

        $sql .= " ORDER BY m.rec_id DESC";

        // **การนับแถวด้วย dbNumRows(sql) ก่อนรัน dbQuery ซ้ำ อาจทำให้โค้ดทำงานซ้ำซ้อน**
        // ควรใช้ $i=1; และนับไปเรื่อยๆ ในลูป หรือใช้ dbNumRows(result) หลังการ Query
        
        $result = dbQuery($sql);
        $i = 1; // เริ่มนับที่ 1 ใหม่
        
        while ($rs = dbFetchArray($result)) {
            ?>
            <tr>
                <td align="center"><?= $i ?></td>
                <td>&nbsp;<?= $rs['rec_id'] ?></td>
                <td>&nbsp;<?= thaiDate($rs['date_in']) ?></td>
                <td>&nbsp;<?= $rs['book_no'] ?></td>
                <td>&nbsp;<?= thaiDate($rs['date_book']) ?></td>
                <td>&nbsp;<?= $rs['title'] ?></td>
                <td>&nbsp;<?= $rs['dep_name'] ?></td>
                <td>&nbsp;</td>
            </tr>
            <?php $i++;
        } ?>
        <tr>
            <td class="header-bg" colspan="7" align="right"><b>รวมหนังสือรับ</b></td>
            <td class="header-bg" colspan="1" align="center"><b><?= $i - 1 ?> ฉบับ</b></td>
        </tr>
    </table>
    <h4>*หมายเหตุ: ใช้สำหรับเจ้าหน้าที่นำส่งเอกสารลงชื่อรับเอกสารตัวจริง</h4>
</body>

</html>

<?Php
// 7. สิ้นสุดการเก็บ Output และสร้าง PDF

$html = ob_get_clean(); // ใช้ ob_get_clean() แทน ob_end_clean() เพื่อดึงค่าและปิดบัฟเฟอร์

// **การตั้งค่า mPDF สำหรับเวอร์ชันใหม่ (ใช้ Namespace)**
$mpdf = new \Mpdf\Mpdf([
    'mode' => 'utf-8',
    'format' => 'A4-L', // A4-L คือแนวนอน
    'tempDir' => __DIR__ . '/temp', // แนะนำให้กำหนด Temp Directory ที่เขียนได้
    'autoScriptToLang' => true,
    'autoLangToFont' => true,
    // 💡 เพิ่มการตั้งค่าระยะขอบกระดาษตรงนี้ (หน่วยเป็นมิลลิเมตร)
    'margin_left' => 10,  // ขอบซ้าย 10 มม.
    'margin_right' => 10, // ขอบขวา 10 มม.
    'margin_top' => 10,   // ขอบบน 15 มม. (เผื่อพื้นที่ส่วนหัว)
    'margin_bottom' => 10, // ขอบล่าง 15 มม. (เผื่อพื้นที่ส่วนท้าย)
]);
// **หมายเหตุ:** mPDF เวอร์ชันใหม่จะไม่รับพารามิเตอร์แบบเดิมแล้ว

// **ตั้งค่าฟอนต์สำหรับภาษาไทย** (สำคัญมาก)
// หากคุณไม่ได้ติดตั้งฟอนต์ "Garuda" ใน mPDF ให้ใช้ 'sarabun' หรือฟอนต์อื่นที่คุณได้กำหนดไว้
// $mpdf->SetFont('Garuda'); // อาจต้องมีการตั้งค่าฟอนต์เพิ่มเติมใน config ของ mPDF

$mpdf->SetDisplayMode('fullpage');
$mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::DEFAULT_MODE); // ใช้ค่าคงที่สำหรับ WriteHTML

// สั่งให้ดาวน์โหลดไฟล์โดยใช้ชื่อไฟล์
$mpdf->Output('รายงานหนังสือรับ_' . date('Ymd') . '.pdf', \Mpdf\Output\Destination::INLINE);
// \Mpdf\Output\Destination::INLINE จะแสดงในเบราว์เซอร์, FILE จะบันทึกเป็นไฟล์

exit; // จบการทำงานหลังจากสร้าง PDF
?>