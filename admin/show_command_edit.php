<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<?php
include 'function.php';
include '../library/database.php';
session_start();
$level_id=$_SESSION['ses_level_id'];
$u_id=$_POST['u_id'];
$cid=$_POST['cid'];
$edit=$_POST['edit'];

$sql="SELECT c.*,y.yname,u.firstname,d.dep_name 
      FROM flowcommand as c 
      INNER JOIN sys_year as y ON y.yid=c.yid 
      INNER JOIN user as u ON u.u_id=c.u_id 
      INNER JOIN depart as d ON d.dep_id=c.dep_id
      WHERE c.cid=$cid
      ORDER BY c.cid DESC";
//print $sql;
$result=dbQuery($sql);
$row=dbFetchArray($result);
?>
    <form method="POST" name="upload" action="flow-command.php" enctype="multipart/form-data" >
    <table class="table table-borderedr"  border=1>
        <tr>
            <td>ปีที่ออกคำสั่งแก้ไข</td>
            <td><?php print $row['yname'];?></td>
        </tr>
         <tr>
            <td>เลขที่คำสั่ง</td>
            <td><?php print $row['rec_id'];?>/<?php print $row['yname'];?></td>
        </tr>
        <tr>
            <td>วันที่ทำรายการ</td>
            <td><?php print thaiDate($row['dateout']);?></td>
        </tr>
        <tr>
            <td>วันที่ลงนาม</td>
            <td><?php print thaiDate($row['dateline']);?></td>
        </tr>
        <tr>
            <td>ผู้ลงนาม</td>
            <td><?php print $row['boss'];?></td>
        </tr>
        <tr>
            <td>คำสั่งเรื่อง</td>
            <td><?php print $row['title'];?></td>
        </tr>
        <tr>
            <td>ผู้บันทึก</td>
            <td><?php print $row['firstname'];?></td>
        </tr>
         <tr>
            <td>เจ้าของเรื่อง</td>
            <td><?php print $row['dep_name'];?></td>
        </tr>
        <tr>
            <?php 
if($row['file_upload']==null){?>
                <td> <input class="form-control" type="file"  name="fileupload"></td>
                     <input type="hidden" name="cid" value="<?php print $row['cid'];?>">
                 <td colspan=2><center> <button class="btn btn-success" type="submit" name="update"><i class="fas fa-save fa-2x"></i> บันทึกการเปลี่ยนแปลง</button></center></td>
               <?php } else { ?>
                 <td>ไฟล์เอกสาร</td>
                 <td> <a href="<?php print $row['file_upload'];?>" class="btn btn-warning" target="_blank"><i class="fas fa-download"></i>ดาวน์โหลด</a>
              <?php } ?>
           
        </tr>
    </table>
    </form>