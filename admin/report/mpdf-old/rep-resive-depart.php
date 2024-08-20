<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>พิมพ์รายงานหนังสือรับประจำวัน</title>
<style>
td{border:1px dashed #CCC;  }
</style>
</head>

<body>
<?php

require_once('mpdf/mpdf.php'); //ที่อยู่ของไฟล์ mpdf.php ในเครื่องเรานะครับ
ob_start(); // ทำการเก็บค่า html นะครับ
session_start();
$dep_id=$_SESSION['ses_dep_id'];
/*$user="$_SESSION[sess]";
    if(empty($user)){
        header('location:../index.php');
        exit();
    }  */
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

$sql="SELECT dep_name FROM depart WHERE dep_id=$dep_id";
$result=dbQuery($sql);
$row=dbFetchAssoc($result);

?>


    <table cellspacing="0" cellpadding="1" border="1" style="width:1100px;">
        <tr> 
        	<td colspan="10"><h3>รายงานทะเบียนหนังสือรับ  ประจำวันที่ <?= dateThai($dateprint)?> #<?=$row['dep_name'];?></h3></td>
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
        $sql="SELECT fr.*,d.book_no,d.title,d.sendfrom,d.date_book,d.date_line,d.status
              FROM flowrecive as fr
              INNER JOIN book_detail as d ON fr.book_detail_id = d.book_detail_id
              WHERE dep_id = $dep_id AND d.date_line='$dateprint'";
              $result=dbQuery($sql);
    
       	   while($rs=dbFetchArray($result)){
		?>  
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