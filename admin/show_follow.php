
<?php
date_default_timezone_set('Asia/Bangkok');

include 'function.php';

include '../library/database.php';


$f_id=$_POST['f_id'];

$u_id=$_POST['u_id'];

$sql="SELECT f.*,u.u_id,b.name,b.position,b.sec_id,s.speed_name ,d.dep_name,u.firstname,sec.sec_name
                      FROM fllow as f
                      INNER JOIN boss as b ON b.rec_id = f.rec_id
                      INNER JOIN user as u ON u.u_id = f.u_id
                      INNER JOIN speed as s ON s.speed_id = f.speed_id
                      INNER JOIN depart as d ON d.dep_id = f.dep_id
                      INNER JOIN section as sec ON sec.sec_id = f.sec_id
                      WHERE f.f_id = $f_id
                      ORDER BY f.f_id
                ";
//print $sql;
$result=dbQuery($sql);

$row=dbFetchAssoc($result);

?>  
<table border=1 width=100% >
    <tr>
         <td><label>เลขระบบ:</label></td>
         <td><?php print $row['f_id']?></td>
    <tr>
    <tr>
         <td><label>วันที่เสนอแฟ้ม:</label></td>
         <td><?php print thaiDate($row['date_current'])?></td>
    <tr>
    <tr>
         <td><label>โปรดลงนามก่อน:</label></td>
         <td><?php print thaiDate($row['dateline'])?></td>
    <tr>
    <tr>
         <td><label>เรื่อง:</label></td>
         <td><?php print $row['title']?></td>
    <tr>
    <tr>
         <td><label>เสนอผ่าน:</label></td>
         <td><?php print $row['name']?> ตำแหน่ง <?php print $row['position']?> </td>
    <tr>
    <tr>
         <td><label>ความเร่งด่วน:</label></td>
         <td><?php print $row['speed_name']?></td>
    <tr>
    <tr>
         <td><label>หน่วยงาน:</label></td>
         <td><?php print $row['dep_name']?></td>
    <tr>
    <tr>
         <td><label>กลุ่ม/ฝ่าย:</label></td>
         <td><?php print $row['sec_name']?></td>
    <tr>
    <tr>
         <td><label>เจ้าของเรื่อง:</label></td>
         <td><?php print $row['firstname']?></td>
    <tr>
    <tr>
         <td><label>ข้อเสนอแนะ:</label></td>
         <td><kbd><?php print $row['remark']?></kbd></td>
    <tr>
</table>


