
<?php
date_default_timezone_set('Asia/Bangkok');
include 'function.php';
include '../library/database.php';

$hire_id=$_POST['hire_id'];
$u_id=$_POST['u_id'];
$sql="SELECT a.*,d.dep_name,s.sec_name,y.yname,u.firstname
      FROM announce as a
      INNER JOIN depart as d ON d.dep_id = a.dep_id
      INNER JOIN section as s ON s.sec_id = a.sec_id
      INNER JOIN user as u ON u.u_id = a.u_id
      INNER JOIN year_money as y ON y.yid = a.yid
      WHERE a.hire_id=$hire_id";
//print $sql;
$result=dbQuery($sql);
$row=dbFetchAssoc($result);
?>  
<table border=1 width=100% >
    <tr>
         <td><label>ทะเบียนคุมประกาศ:</label></td>
         <td><?php print $row['rec_no']?>/<?php print $row['yname'];?></td>
    </tr>
    <tr>
        <td><label>วันที่ทำรายการ:</label></td>
        <td><?php print thaiDate($row['datein']);?></td>
    </tr>
    <tr>
        <td><label>เรื่อง:</label></td>
        <td><?php print $row['title']?></td>
    </tr>
    <tr>
        <td><label>สถานที่ขายแบบ:</label></td>
        <td><?php print $row['place_buy'];?></td>
    </tr>
    <tr>
        <td><label>วันที่ขาย/ให้แบบ:</label></td>
        <td><?php print thaiDate($row['date_start']);?></td>
    </tr>
    <tr>
        <td><label>วันที่สิ้นสุดขาย/ให้แบบ:</label></td>
        <td><?php print thaiDate($row['date_end']);?></td>
    </tr>
    <tr>
        <td><label>สถานที่ยื่นซอง:</label></td>
        <td><?php print $row['place_pre'];?></td>
    </tr>
    <tr>
        <td><label>วันที่เริ่มยื่นซอง:</label></td>
        <td><?php print thaiDate($row['date_pre_start']);?></td>
    </tr>
    <tr>
        <td><label>วันที่สิ้นสุดยื่นซอง:</label></td>
        <td><?php print thaiDate($row['date_pre_end']);?></td>
    </tr>
    <tr>
        <td><label>สำนักงาน:</label></td>
        <td><?php print $row['dep_name']?></td>
       
    </tr>
    <tr>
        <td><label>กลุ่ม/หน่วยย่อย:</label></td>
        <td><?php print $row['sec_name']?></td>
    </tr>
    <tr>
        <td><label>เจ้าหน้าที่</label></td>
        <td><?php print $row['firstname']?></td>
    </tr>


</table>

