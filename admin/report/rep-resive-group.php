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
$sec_id=$_SESSION['ses_sec_id'];
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


/*
$sql = "SELECT  f.*, d.dep_name, s.sec_name, u.firstname 
        FROM flow_recive_group  f 
        INNER JOIN depart  d ON  d.dep_id = f.dep_id
        INNER JOIN section  s ON s.sec_id = s.sec_id
        INNER JOIN user  u ON  u.u_id = f.practice
        WHERE datein='$dateprint'  AND s.sec_id = $sec_id" ;
*/

$sql = "SELECT f.rec_no, f.book_no, f.title, f.dateout, f.datein, f.sendfrom, f.sec_id, f.practice, u.firstname
        FROM  flow_recive_group as f  
        INNER JOIN  user as u ON u.u_id = f.practice
        WHERE f.datein LIKE '$dateprint' AND f.sec_id = $sec_id ORDER BY f.cid DESC"
//print $sql;
?>


    <table cellspacing="0" cellpadding="1" border="1" style="width:1100px;">
        <tr> 
        	<td colspan="8"><center><h3>รายงานทะเบียนหนังสือรับ  วันที่ <?= dateThai($dateprint)?> #<?=$row['sec_name'];?></h3></center></td>
        </tr> 
        <tr> 
        	<td colspan="8"><center><h4>วันที่ออกรายงาน <?php echo  DateThai(); ?></h4></center></td>
        </tr>  
        <tr>
            <td width="50" align="center" bgcolor="#F2F2F2">#</td>
            <td bgcolor="#F2F2F2" >&nbsp;เลขรับ</td>
            <td bgcolor="#F2F2F2" >&nbsp;เลขหนังสือ</td>
            <td bgcolor="#F2F2F2" >&nbsp;เรื่อง</td>
            <td bgcolor="#F2F2F2" width="100" >&nbsp;วันรับ</td>
            <td bgcolor="#F2F2F2" >&nbsp;ต้นเรื่อง</td>
            <td bgcolor="#F2F2F2" >&nbsp;ผู้ปฏิบัติ</td>
            <td bgcolor="#F2F2F2" width="80" >&nbsp;ลงชื่อผู้รับ</td> 
        </tr>
		<?php
        $i=1;


      //  $sql="SELECT * FROM flow_recive_group WHERE datein='$dateprint' AND  sec_id=$sec_id ORDER BY cid DESC";
        $result=dbQuery($sql);
    
       	   while($rs=dbFetchArray($result)){
		?>  
      <tr>
        <td align="center"><?=(($e_page*$chk_page)+$i)?></td>
        <td >&nbsp;<?=$rs['rec_no']?></td>
        <td >&nbsp;<?=$rs['book_no']?></td>
        <td >&nbsp;<?=$rs['title']?></td>
        <td >&nbsp;<?=thaiDate($rs['datein'])?></td>
        <td >&nbsp;<?=$rs['sendfrom']?></td>
        <td >&nbsp;<?=$rs['firstname']?></td>
        <td >&nbsp;</td>
     </tr>
<?php $i++; } ?>     
	  <tr>
      	 <td colspan="6"><center><b>รวมหนังสือรับ</b></center></td>
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