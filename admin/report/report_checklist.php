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
// Require composer autoload
require_once __DIR__ . '/vendor/autoload.php';
// Create an instance of the class:


$mpdf = new \Mpdf\Mpdf();

$defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
$fontDirs = $defaultConfig['fontDir'];

$defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
$fontData = $defaultFontConfig['fontdata'];

$mpdf = new \Mpdf\Mpdf([
    'fontDir' => array_merge($fontDirs, [
        __DIR__ . '/ttfonts',
    ]),
    'fontdata' => $fontData + [
        'th-sarabun' => [
            'R' => 'THSarabunNew.ttf',
            'I' => 'THSarabunNew Italic.ttf',
            'B' => 'THSarabunNew Bold.ttf',
            'BI' => 'THSarabunNew BoldItalic.ttf',
        ]
    ],
    'default_font' => 'th-sarabun',
    'default_font_size' => 16,
]);

ob_start(); // ทำการเก็บค่า html นะครับ
session_start();
$dep_id=$_SESSION['ses_dep_id'];
$sec_id=$_SESSION['ses_sec_id'];

@$pid=$_GET['pid'];
@$dateprint=$_POST['dateprint'];
@$uid=$_POST['uid'];
@$yid=$_POST['yid'];
@$username=$_POST['username'];

header("Content-type:text/html; charset=UTF-8");                
header("Cache-Control: no-store, no-cache, must-revalidate");               
header("Cache-Control: post-check=0, pre-check=0", false);    
include "../../library/config.php";
include "../../library/database.php";
include "../function.php";
?>

<?php  
$sql = "SELECT title,postdate ,book_no FROM paper WHERE pid=$pid ";
$result = dbQuery($sql);
$row = dbFetchArray($result);
?>

<table cellspacing="0" cellpadding="1" border="1" style="width:1100px;"> 
		<tr> 
        	<td colspan="7"><center><img  src="logo.png" style="width:15%;"><h3>รายงานผลการตอบรับหนังสือ</h3></center></td>
        </tr> 
        <tr>
            <td>หนังสือเรื่อง:</td>
            <td colspan="6"><?php print $row['title'];?></td>
        </tr>
        <tr>
            <td>เลขที่หนังสือ:</td>
            <td colspan="6"><?php print $row['book_no'];?></td>
        </tr>
        <tr>
            <td>วันที่ส่งหนังสือ:</td>
            <td colspan="6"><?php print thaiDate($row['postdate']);?></td>
        </tr>
        <tr> 
        	<td>วันที่ออกรายงาน</td>
            <td colspan="6"> <?php echo  DateThai(); ?></td>
        </tr> 
		<tr>
			<td><strong> ที่        </strong></td>
            <td><strong> ส่วนราชการ </strong></td>
            <td><strong> กลุ่มงาน   </strong></td>
            <td><strong> เจ้าหน้าที่   </strong></td>
            <td><strong> โทร      </strong></td>
            <td><strong> วันที่ลงรับ  </strong></td>
            <td><strong> สถานะ    </strong></td> 
          
           
		</tr>
            <?php
             $sql=" SELECT p.pid,p.u_id, p.sec_id,p.confirm,p.confirmdate,p.dep_id,d.dep_name,d.phone,s.sec_name,u.title,e.firstname,e.telphone
                    FROM  paperuser p
                    INNER JOIN paper u ON u.pid = p.pid
                    INNER JOIN depart d   ON  p.dep_id = d.dep_id
                    INNER JOIN section s ON s.sec_id = p.sec_id
                    INNER JOIN user e ON e.u_id = p.u_id
                    WHERE p.pid=$pid  ORDER BY confirm ASC
                    ";
                //print $sql;
                $result=dbQuery($sql);
                $numrow=1;

             while ($row = dbFetchArray($result)) { ?>
                <tr>
                    <td><?php print $numrow;?></td>
                    <td><?php print $row['dep_name'];?></td>
                    <td><?php print $row['sec_name'];?></td>
                    <td><?php print $row['firstname'];?></td>
                    <td><?php print $row['telphone'];?></td>
                    <td><?php print $row['confirmdate'];?></td>  
                    <td>
                        <?php
                            if($row['confirm']==0){
                                echo "<center> X </center>";
                            }else{
                                echo "<center> / </center> ";
                            }
                        ?>
                    </td>
                </tr>
           <?php $numrow++; } ?>
		
	</table>
    <h6>หมายเหตุ   สถานะ x = ยังไม่ลงรับ  / = ลงรับแล้ว </h6>
	<br>
	<h5>ออกรายงานจาก ระบบงานสารบรรณอิล็กทรอนิกส์จังหวัดพัทลุง</h5>
</body>
</html>    




<?php
$html = ob_get_contents();
ob_end_clean();

$mpdf->WriteHTML($html);

// Output a PDF file directly to the browser
$mpdf->Output();
?>