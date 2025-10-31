<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>รายงานหนังสือรับตามช่วงเวลา</title>
<style>
td{border:1px dashed #CCC;  }
</style>
</head>

<body>
<?php

//require_once('mpdf/mpdf.php'); //ที่อยู่ของไฟล์ mpdf.php ในเครื่องเรานะครับ
include ("mpdf/mpdf.php");
ob_start(); // ทำการเก็บค่า html นะครับ
session_start();
$dep_id=$_SESSION['ses_dep_id'];
$sec_id=$_SESSION['ses_sec_id'];

$dateStart=$_POST['dateStart'];  //วันที่เริ่มต้น
$dateEnd=$_POST['dateEnd'];      //วันที่สิ้นสุด

//$dateprint=$_POST['dateprint'];

$uid=$_POST['uid'];
$yid=$_POST['yid'];
$username=$_POST['username'];


header("Content-type:text/html; charset=UTF-8");                
header("Cache-Control: no-store, no-cache, must-revalidate");               
header("Cache-Control: post-check=0, pre-check=0", false);    
include "../../library/config.php";
include "../../library/database.php";
include "../function.php";

$sql="SELECT dep_name FROM depart WHERE dep_id=$dep_id";
$result=dbQuery($sql);
$row=dbFetchAssoc($result);

?>


    <table cellspacing="0" cellpadding="1" border="1" style="width:1100px;">
         <tr> 
        	<td colspan="7"><center><h3>รายงานทะเบียนหนังสือรับ  ระหว่างวันที่ <?php echo thaiDate($dateStart); ?>-<?php echo thaiDate($dateEnd);?> #<?=$row['sec_name'];?></h3></center></td>
        </tr> 
        <tr> 
        	<td colspan="7"><center><h4>วันที่ออกรายงาน <?php echo  DateThai(); ?></h4></center></td>
        </tr>  
        <tr>
            <td width="50" align="center" bgcolor="#F2F2F2">#</td>
            <td bgcolor="#F2F2F2" >&nbsp;เลขรับ</td>
            <td bgcolor="#F2F2F2" >&nbsp;เลขหนังสือ</td>
            <td bgcolor="#F2F2F2" >&nbsp;เรื่อง</td>
            <td bgcolor="#F2F2F2" width="100" >&nbsp;ลงวันที่</td>
            <td bgcolor="#F2F2F2" width="80" >&nbsp;ลงชื่อผู้รับ</td> 
        </tr>
		<?php
        $i=1;
        $sql="SELECT * FROM flow_recive_depart WHERE datein  BETWEEN  '$dateStart'  AND  '$dateEnd' AND  dep_id=$dep_id ORDER BY cid ASC";
        $result = dbQuery($sql);
    while($rs=dbFetchArray($result)){?>  
      <tr>
        <td align="center"><?=(($e_page*$chk_page)+$i)?></td>
        <td >&nbsp;<?=$rs['rec_no']?></td>
        <td >&nbsp;<?=$rs['book_no']?></td>
        <td >&nbsp;<?=$rs['title']?></td>
        <td >&nbsp;<?=$rs['date_book']?></td>
        <td >&nbsp;</td>
     </tr>
<?php $i++; } ?>     
	  <tr>
      	 <td colspan="5"><center><b>รวมหนังสือรับ</b></center></td>
         <td><center><b><?=$i-1?></b></center> </td>
      </tr>
    </table>
<h4>*หมายเหตุ:ใช้สำหรับเจ้าหน้าที่นำส่งเอกสารลงชื่อรับเอกสารตัวจริง</h4>
</body>
</html>    
<?Php
$html = ob_get_contents();
ob_end_clean();
$pdf = new mPDF('th', 'A4-L', '0', ''); //การตั้งค่ากระดาษถ้าต้องการแนวตั้ง ก็ A4 เฉยๆครับ ถ้าต้องการแนวนอนเท่ากับ A4-L
$pdf->SetAutoFont();
$pdf->SetDisplayMode('fullpage');
$pdf->WriteHTML($html, 2);
$pdf->Output();
?>