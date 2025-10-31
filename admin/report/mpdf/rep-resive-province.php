<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>พิมพ์รายงานหนังสือรับประจำวัน[สารบรรณกลาง]</title>
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
$sec_id=$_SESSION['ses_sec_id'];

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


 $sql="SELECT d.dep_name,s.sec_id,s.sec_name FROM depart as d
       INNER JOIN section as s ON s.sec_id=$sec_id
       WHERE d.dep_id=$dep_id";
//print $sql;

 $result=dbQuery($sql);
 $row=dbFetchArray($result);

?>


    <table cellspacing="0" cellpadding="1" border="1" style="width:1100px;">
        <tr> 
        	<td  bgcolor="#C0C0C0" colspan="7"><center><h3>รายงานทะเบียนหนังสือรับ  วันที่ <?= thaiDate($dateprint)?></center></td>
        </tr> 
        <tr>
            <td bgcolor="#C0C0C0" colspan="7"><center><h4>หน่วยรับ::<?php echo $row['dep_name'];?></h4></center></td>
        </tr>
        <tr>
            <td  bgcolor="#C0C0C0" colspan="7"><center><h4>กลุ่มงาน/หน่วยงานย่อย:<?php echo $row['sec_name'];?>:วันที่ออกรายงาน:<?php echo DateThai();?></center></td>
        </tr>
        <tr>
            <td width="50" align="center" bgcolor="#C0C0C0">#</td>
            <td bgcolor="#C0C0C0" ><center>เลขรับ</center></td>
            <td bgcolor="#C0C0C0" ><center>เลขหนังสือ</center></td>
            <td bgcolor="#C0C0C0" ><center>เรื่อง</center></td>
            <td bgcolor="#C0C0C0" width="100" >ลงวันที่</td>
            <td bgcolor="#C0C0C0" width="100" >หน่วยปฏิบัติ</td>
            <td bgcolor="#C0C0C0" width="80" >ลงชื่อผู้รับ</td> 
        </tr>
		<?php
        $i=1;
        $sql="SELECT m.book_id,m.rec_id,m.dep_id,d.book_no,d.title,d.sendfrom,d.sendto,d.date_book,d.date_in,d.date_line,d.practice,d.status,s.sec_code,dep.dep_name
              FROM book_master m
              INNER JOIN book_detail d ON d.book_id = m.book_id
              INNER JOIN section s ON s.sec_id = m.sec_id 
              INNER JOIN depart dep ON dep.dep_id= d.practice
              WHERE m.type_id=1 AND d.date_line='$dateprint' AND m.dep_id=$dep_id
              ORDER BY m.rec_id DESC";
        //print $sql;
          $i=dbNumRows($sql);
          $result=dbQuery($sql);
          $i=1;
       	   while($rs=dbFetchArray($result)){
		?>  
      <tr>
        <td align="center"><?=(($e_page*$chk_page)+$i)?></td>
        <td >&nbsp;<?=$rs['rec_id']?></td>
        <td >&nbsp;<?=$rs['book_no']?></td>
        <td >&nbsp;<?=$rs['title']?></td>
        <td >&nbsp;<?=thaiDate($rs['date_book'])?></td>
         <td >&nbsp;<?=$rs['dep_name']?></td>
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