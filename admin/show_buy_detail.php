
<?php
date_default_timezone_set('Asia/Bangkok');
include 'function.php';
include '../library/database.php';

$hire_id=$_POST['buy_id'];
$u_id=$_POST['u_id'];
$sql="SELECT h.*,d.dep_name,s.sec_name,y.yname,u.firstname
      FROM buy as h
      INNER JOIN depart as d ON d.dep_id = h.dep_id
      INNER JOIN section as s ON s.sec_id = h.sec_id
      INNER JOIN user as u ON u.u_id = h.u_id
      INNER JOIN year_money as y ON y.yid = h.yid
      WHERE h.buy_id=$hire_id";
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
        <td><?php print thaiDate($row['date_submit']);?></td>
    </tr>
    <tr>
        <td><label>รายการซื้อ/ขาย:</label></td>
        <td><?php print $row['title']?></td>
    </tr>
    <tr>
        <td><label>วงเงินโครงการ</label></td>
        <td><?php print number_format($row['money_project']);?> -บาท</td>
    </tr>
    <tr>
        <td><label>หลักประกัน:</label></td>
        <td><?php print number_format($row['money']);?> -บาท</td>
    </tr>
    <tr>
        <td><label>บริษัท/ร้าน:</label></td>
        <td><?php print $row['company'];?></td>
    </tr>
    <tr>
        <td><label>ผู้จัดการร้าน/เจ้าของ:</label></td>
        <td><?php print $row['manager'];?></td>
    </tr>
    <tr>
        <td><label>วันที่ส่งงาน:</label></td>
        <td><?php print thaiDate($row['date_stop']);?></td>
    </tr>
    <tr>
        <td><label>ที่อยู่ร้าน:</label></td>
        <td><?php print $row['add1'];?></td>
    </tr>
    <tr>
        <td><label>ผู้ลงนาม:</label></td>
        <td><?php print $row['signer'];?></td>
    </tr>
    <tr>
        <td><label>ที่อยู่:</label></td>
        <td><?php print $row['add2'];?></td>
    </tr>
    <tr>
        <td><label>วันครบกำหนดงวดสุดท้าย:</label></td>
        <td><?php print thaiDate($row['date_stop']);?></td>
    </tr>
    <tr>
        <td><label>หลักประกันสัญญา:</label></td>
        <?php    
            $confirm = $row['confirm_id'];
            if($confirm == 1){
                $type= "เงินสด";
            }elseif($confirm == 2){
                $type = "เช็คธนาคาร";
            }elseif($confirm == 3){
                $type = "หนังสือค้ำประกันธนาคาร";
            }elseif($confirm == 4){
                $type = "หนังสือค้ำประกันของบริษัทเงินทุน";
            }elseif($confirm == 5){
                $type = "พันธบัตร";
            }elseif($confirm == 0){
                $type = "ไม่มี";
            }
        ?>
        <td><?php print $type;?></td>
    </tr>
   
    <tr>
        <td><label>เจ้าของงบประมาณ:</label></td>
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

