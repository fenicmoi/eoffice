
1<?php
include('mpdf/mpdf.php'); 
include ('connect_db.php');
ob_start(); // ทำการเก็บค่า html นะครับ

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>การออกรายงานด้วย mPDF</title>
<style type="text/css">
<!--
@page rotated { size: landscape; }
.style1 {
	font-family: "TH SarabunPSK";
	font-size: 18pt;
	font-weight: bold;
}
.style2 {
	font-family: "TH SarabunPSK";
	font-size: 16pt;
	font-weight: bold;
}
.style3 {
	font-family: "TH SarabunPSK";
	font-size: 16pt;
	
}
.style5 {cursor: hand; font-weight: normal; color: #000000;}
.style9 {font-family: Tahoma; font-size: 12px; }
.style11 {font-size: 12px}
.style13 {font-size: 9}
.style16 {font-size: 9; font-weight: bold; }
.style17 {font-size: 12px; font-weight: bold; }
-->
</style>
</head>

<body>
<div class=Section2>
<table bordercolor="#424242" width="1141" height="78" border="1"  align="center" cellpadding="0" cellspacing="0" class="style3">
  <tr align="center">
    <td width="123" align="center" bgcolor="#D5D5D5"><strong>recNo</strong></td>
    <td width="155" align="center" bgcolor="#D5D5D5"><strong>title</strong></td>
    <td width="139" align="center" bgcolor="#D5D5D5"><strong>from</strong></td>
  </tr>
  <?php
$sql="SELECT flowother.* FROM flowother WHERE flowother.uid='2' AND yid='8' ORDER BY oid DESC";
$result=mysql_query($sql);
$numrows = mysql_numrows($result);
$i=0;
while ($row=mysql_fetch_array($result)) 
{	
	/*$recno = $row[recno];    //เก็บรหัสสินค้า
	$sendfrom = $row[sendfrom];         //เก็บราคาสินค้า
	$title = $row[title];   //เก็บชื่อสินค้า  */
	?>
   <tr>
    <td align="right" class="style3"><?php echo $row['recno']; ?></td>
    <td align="right" class="style3"><?php echo $row['title']; ?></td>
    <td align="right" class="style3"><?php echo $row['sendfrom']; ?></td>
   </tr>
  <?php $i++;}?>
   
<?php
$html = ob_get_contents();
ob_end_clean();
$pdf = new mPDF('th', 'A4-L', '0', 'THSaraban');
$pdf->SetAutoFont();
$pdf->SetDisplayMode('fullpage');
$pdf->WriteHTML($html, 2);
$pdf->Output();

//$pdf->Output("MyPDF/MyPDF.pdf","F");


?>     
</div>
ดาวโหลดรายงานในรูปแบบ PDF <a href="MyPDF/MyPDF.pdf">คลิกที่นี้</a>
</body>
</html>
