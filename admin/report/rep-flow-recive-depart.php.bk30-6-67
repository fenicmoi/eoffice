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
ini_set('display_errors', '0');  

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
$rep_time = $_POST['rep_time'];      //ตัวแปรรับค่าตามช่วงเวลา
$uid=$_POST['uid'];
$yid=$_POST['yid'];
$username=$_POST['username'];
header("Content-type:text/html; charset=UTF-8");                
header("Cache-Control: no-store, no-cache, must-revalidate");               
header("Cache-Control: post-check=0, pre-check=0", false);    
include "../../library/config.php";
include "../../library/database.php";
include "../function.php";


$sql="SELECT d.dep_name,s.sec_name FROM depart as d
      INNER JOIN section as s ON s.dep_id=d.dep_id
      WHERE d.dep_id=$dep_id AND s.sec_id=$sec_id ";
$result=dbQuery($sql);
$row=dbFetchAssoc($result);

switch ($rep_time) {
    case '1':
        $text="รอบเช้า";
        break;
    case '2':
        $text="รอบบ่าย";
        break;
    default:
        $text="ทั้งหมด";
        break;
}

?>


    <table cellspacing="0" cellpadding="1" border="1" style="width:1100px;">
        <tr hight="200"> 
        	<td colspan="10" align="center"><h3><?=$row['dep_name'];?></h3></td>
        </tr>
        <tr hight="200"> 
        	<td colspan="10" align="center"><h3>รายงานทะเบียนหนังสือรับหน่วยงาน  ประจำวันที่ <?= thaiDate($dateprint)?> #<?=$text?></h3></td>
        </tr>  
        <tr>
            <td width="50" align="center" bgcolor="#F2F2F2">ที่</td>
            <td bgcolor="#F2F2F2" >&nbsp;เลขรับ</td>
            <td bgcolor="#F2F2F2" >&nbsp;เลขหนังสือ</td>
            <td bgcolor="#F2F2F2" >&nbsp;เรื่อง</td>
            <td bgcolor="#F2F2F2" >&nbsp;จาก</td>
            <td bgcolor="#F2F2F2" >&nbsp;ถึง</td>
            <td bgcolor="#F2F2F2" >&nbsp;ผู้ปฏิบัติ</td>
            <td bgcolor="#F2F2F2" width="100" >&nbsp;ลงวันที่</td>
            <td bgcolor="#F2F2F2" width="100" >&nbsp;วันที่ลงรับ</td>
            <td bgcolor="#F2F2F2" width="80" >&nbsp;ลงชื่อผู้รับ</td> 
        </tr>
		<?php
        $i=1;
        $sql="SELECT * FROM flow_recive_depart WHERE dep_id=$dep_id AND datein='$dateprint'";
        if($rep_time == 1){  //ช่วงเช้า
            $sql.=" AND time_stamp >= '08:00:00' AND time_stamp <= '12:00:00'";
        }else if($rep_time == 2){  //ช่วงบ่าย
            $sql.=" AND time_stamp >= '13:00:00' AND time_stamp <= '16:30:00'";
        }else if($rep_time ==''){  //ไม่เลือก
            $$sql.=" ORDER BY cid DESC";
        }

        $sql.=" ORDER BY cid DESC";
        //print $sql;
        
        $result=dbQuery($sql);
    
       	   while($rs=dbFetchArray($result)){
		?>  
      <tr>
        <td align="center"><?=(($e_page*$chk_page)+$i)?></td>
        <td >&nbsp;<?=$rs['rec_no']?></td>
        <td >&nbsp;<?=$rs['book_no']?></td>
        <td >&nbsp;<?=$rs['title']?></td>
        <td >&nbsp;<?=$rs['sendfrom']?></td>
        <td >&nbsp;<?=$rs['sendto']?></td>
        <td >&nbsp;<?=$rs['practice']?></td>
        <td >&nbsp;<?=thaiDate($rs['dateout'])?></td>
        <td >&nbsp;<?=thaiDate($rs['datein'])?><br>เวลา<?=$rs['time_stamp'];?></td>
        <td >&nbsp;</td>
     </tr>
<?php $i++; } ?>     
	  <tr>
      	 <td colspan="9"><center><b>รวมหนังสือรับ</b></center></td>
         <td><center><b><?=$i-1?></b></center> </td>
      </tr>
    </table>
<h4>*หมายเหตุ:สำหรับใช้ประกอบหลักฐานการรับ-ส่ง    ##report update 20-12-61 by developer</h4>
</body>
</html>    
<?php
$html = ob_get_contents();
ob_end_clean();
$pdf = new mPDF('th', 'A4-L', '0', ''); //การตั้งค่ากระดาษถ้าต้องการแนวตั้ง ก็ A4 เฉยๆครับ ถ้าต้องการแนวนอนเท่ากับ A4-L
$pdf->SetAutoFont();
$pdf->SetDisplayMode('fullpage');
$pdf->WriteHTML($html, 2);
$pdf->Output();
?>