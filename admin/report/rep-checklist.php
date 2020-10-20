<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>ตรวจสอบผู้รับเอกสาร</title>
<style>
td{border:1px dashed #CCC;  }
img {
    display: block;
    margin-left: auto;
    margin-right: auto;
}
</style>
</head>

<body>
<?php

require_once('mpdf/mpdf.php'); //ที่อยู่ของไฟล์ mpdf.php ในเครื่องเรานะครับ
ob_start(); // ทำการเก็บค่า html นะครับ
session_start();
$dep_id=$_SESSION['ses_dep_id'];
$sec_id=$_SESSION['ses_sec_id'];

$pid=$_GET['pid'];
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


?>	
    <?php 
        $sql = "SELECT title,postdate  FROM paper WHERE pid=$pid ";
        $result = dbQuery($sql);
        $row = dbFetchArray($result);
    ?>
    <table cellspacing="0" cellpadding="1" border="1" style="width:1100px;"> 
		<tr> 
        	<td colspan="6"><center><img  src="logo.jpg" style="width:5%;"><h3>รายงานผลการตรวจสอบเอกสารส่ง</h3></center></td>
        </tr> 
        <tr>
            <td>หนังสือ:</td>
            <td colspan="5"><?php print $row['title'];?></td>
        </tr>
        <tr>
            <td>วันที่ส่ง:</td>
            <td colspan="5"><?php print thaiDate($row['postdate']);?></td>
        </tr>
        <tr> 
        	<td>วันที่พิมพ์</td>
            <td colspan="5"> <?php echo  DateThai(); ?></td>
        </tr> 
		<tr>
			<td><strong>ที่</strong></td>
            <td><strong>ชื่อส่วนราชการ/หน่วยงาน</strong></td>
            <td><strong>กลุ่มงาน/หน่วยงานย่อย</strong></td>
            <td><strong>สถานะ</strong></td>
            <td><strong>วันที่ยืนยัน<strong></td>]
            <td><strong>เบอร์ติดต่อ</strong></td>
		</tr>
            <?php
             $sql="SELECT p.pid,p.u_id,p.sec_id,p.confirm,p.confirmdate,p.dep_id,d.dep_name,d.phone,s.sec_name,u.title
                    FROM  paperuser p
                    INNER JOIN paper u ON u.pid = p.pid
                    INNER JOIN depart d   ON  p.dep_id=d.dep_id
                    INNER JOIN section s ON s.sec_id=p.sec_id
                    WHERE p.pid=$pid  ORDER BY confirm ASC
                    ";
                print $sql;
                $result=dbQuery($sql);
                $numrow=1;

             while ($row = dbFetchArray($result)) { ?>
                <tr>
                    <td><?php print $numrow;?></td>
                    <td><?php print $row['dep_name'];?></td>
                    <td><?php print $row['sec_name'];?></td>
                    <td>
                        <?php
                            if($row['confirm']==0){
                                echo "No";
                            }else{
                                echo "Yes";
                            }
                        ?>
                    </td>
                    <td><?php print $row['confirmdate'];?></td>
                    <td><?php print $row['phone'];?></td>
                </tr>
           <?php $numrow++; } ?>
		
	</table>
	<br>
	<h5>ออกรายงานจาก ระบบบริการเอกสารจังหวัดพังงา (E-office 2.0)</h5>
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