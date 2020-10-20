
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
</table>
<br>
 <form method="post" action="follow-check.php">
    <table wid=100%>
        <tr>
            <td colspan=2>
                <div class="form-group">
                <label>ข้อเสนอแนะ</label>
                <input class="form-control" type="text" name="remark" id="remark" size="100">
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="form-group from-inline">
                <label>ผลการตรวจแฟ้ม</label>
                <select class="form-control" name="result" id="result">
                    <option value="1">ลงรับ</option>
                    <option value="2">ลงนามแล้ว</option>
                    <option value="3">ผ่านชั้นถัดไป</option>
                    <option value="4">แก้ไข/ส่งคืน</option>
                    <option value="5">ขอพบเจ้าของเรื่อง</option>
                </div>
            </td>
            
            <td>
              <input type="submit" class="btn btn-primary" name="update" id="update" value="บันทึกการเปลี่ยนแปลง">
              <input name="f_id" type="hidden" value="<?=$f_id?>">
            </td>
        </tr>
    </table>
 </form>

