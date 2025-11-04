<?php

session_start();
require_once(__DIR__ . '/vendor/autoload.php'); 
ob_start(); 

include "../../library/config.php";
include "../../library/database.php";
include "../function.php";


$dep_id=$_SESSION['ses_dep_id'];
$sec_id=$_SESSION['ses_sec_id'];
$dateStart=$_POST['dateStart'];
$dateEnd = $_POST['dateEnd'];
$uid=$_POST['uid'];
$yid=$_POST['yid'];
$username=$_POST['username'];


$sql="SELECT d.dep_name,s.sec_name FROM depart as d
      INNER JOIN section as s ON s.dep_id=d.dep_id
      WHERE d.dep_id = '$dep_id' AND s.sec_id = '$sec_id' ";
$result=dbQuery($sql);
$row=dbFetchAssoc($result);

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>พิมพ์รายงานหนังสือรับประจำวัน</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

    <table cellspacing="0" cellpadding="1" border="1" style="width:1100px;">
    
        <tr>
            <td colspan="11"><center><h3><?php echo $row['dep_name'];?></h3></center></td>
        </tr>
        <tr> 
        	<td colspan="11"><center><h3>รายงานทะเบียนหนังสือรับ  ระหว่างวันที่ <?php echo thaiDate($dateStart); ?> - <?php echo thaiDate($dateEnd);?> </h3></center></td>
        </tr>  
        <tr>
            <td width="50" align="center" >ที่</td>
            <td >&nbsp;เลขรับ</td>
            <td >&nbsp;เลขหนังสือ</td>
            <td >&nbsp;เรื่อง</td>
            <td >&nbsp;จาก</td>
            <td >&nbsp;ถึง</td>
            <td >&nbsp;มอบ</td>
            <td >&nbsp;เจ้าหน้าที่</td>
            <td width="100" >&nbsp;ลงวันที่</td>
            <td width="100" >&nbsp;วันที่ลงรับ</td>
            <td width="80" >&nbsp;ลงชื่อผู้รับ</td> 
        </tr>
  
		<?php
        $i=1;
        $sql ="SELECT f.*, s.sec_name FROM flow_recive_depart as f 
               INNER JOIN section as s ON s.sec_id = f.remark 
               WHERE f.datein BETWEEN DATE('$dateEnd') AND DATE('$dateEnd')
                AND f.dep_id = $dep_id
               ORDER BY f.cid DESC";
        
        $result=dbQuery($sql);
    
       	while($rs=dbFetchArray($result)){
		?>  
      <tr>
        <td align="center"><?=$i?></td>
        <td >&nbsp;<?=$rs['rec_no']?></td>
        <td >&nbsp;<?=$rs['book_no']?></td>
        <td >&nbsp;<?=$rs['title']?></td>
        <td >&nbsp;<?=$rs['sendfrom']?></td>
        <td >&nbsp;<?=$rs['sendto']?></td>
        <td >&nbsp;<?=$rs['sec_name']?></td>
        <td >&nbsp;<?=$rs['practice']?></td>
        <td >&nbsp;<?=thaiDate($rs['dateout'])?></td>
        <td >&nbsp;<?=thaiDate($rs['datein'])?></td>
        <td >&nbsp;</td>
     </tr>
<?php $i++; } ?>     
	  <tr>
      	 <td colspan="10"><center><b>รวมหนังสือรับ</b></center></td>
         <td><center><b><?=$i-1?></b></center> </td>
      </tr>
    </table>
<h4>*หมายเหตุ:สำหรับใช้ประกอบหลักฐานการรับ-ส่ง   #report  update 4-11-68</h4>
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
$mpdf->Output('รายงานหนังสือรับ_'.date('Ymd').'.pdf', \Mpdf\Output\Destination::INLINE); 
// \Mpdf\Output\Destination::INLINE จะแสดงในเบราว์เซอร์, FILE จะบันทึกเป็นไฟล์

exit; // จบการทำงานหลังจากสร้าง PDF

?>