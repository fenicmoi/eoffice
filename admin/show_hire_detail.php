
<?php
date_default_timezone_set('Asia/Bangkok');
include 'function.php';
include '../library/database.php';

$hire_id=$_POST['hire_id'];
$u_id=$_POST['u_id'];
$sql="SELECT h.*,d.dep_name,s.sec_name,y.yname,u.firstname
      FROM hire as h
      INNER JOIN depart as d ON d.dep_id = h.dep_id
      INNER JOIN section as s ON s.sec_id = h.sec_id
      INNER JOIN user as u ON u.u_id = h.u_id
      INNER JOIN year_money as y ON y.yid = h.yid
      WHERE h.hire_id=$hire_id";
//print $sql;
$result=dbQuery($sql);
$row=dbFetchAssoc($result);
?>  
<table border=1 width=100% >
    <tr>
         <td><label>ทะเบียนคุมสัญญา:</label></td>
         <td><?php print $row['rec_no']?>/<?php print $row['yname'];?></td>
    </tr>
    <tr>
        <td><label>วันที่ทำรายการ:</label></td>
        <td><?php print thaiDate($row['datein']);?></td>
    </tr>

    <tr>
        <td><label>รายการจ้าง:</label></td>
        <td><?php print $row['title']?></td>
    </tr>
    <tr>
        <td><label>วงเงินการจ้าง:</label></td>
        <td><?php print number_format($row['money']);?> -บาท</td>
    </tr>
    <tr>
        <td><label>หลักประกัน:</label></td>
        <td><?php print number_format($row['guarantee']);?> -บาท</td>
    </tr>
    <tr>
        <td><label>ผู้รับจ้าง:</label></td>
        <td><?php print $row['employee'];?></td>
    </tr>
    <tr>
        <td><label>วันที่ลงนามสัญญาจ้าง:</label></td>
        <td><?php print thaiDate($row['date_hire']);?></td>
    </tr>
    <tr>
        <td><label>วันที่ส่งมอบงาน:</label></td>
        <td><?php  print thaiDate(($row['date_submit']));?></td>
    </tr>
    <tr>
        <td><label>ผู้ลงนาม:</label></td>
        <td><?php print $row['signer'];?></td>
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

