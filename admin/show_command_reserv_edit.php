<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<?php
include 'function.php';
include '../library/database.php';
session_start();
$level_id=$_SESSION['ses_level_id'];
$u_id=$_POST['u_id'];
$cid=$_POST['cid'];

$sql="SELECT c.*,y.yname,u.firstname,d.dep_name 
      FROM flowcommand as c 
      INNER JOIN sys_year as y ON y.yid=c.yid 
      INNER JOIN user as u ON u.u_id=c.u_id 
      INNER JOIN depart as d ON d.dep_id=c.dep_id
      WHERE c.cid=$cid
      ORDER BY c.cid DESC";

$result=dbQuery($sql);
$row=dbFetchArray($result);
?>
    <form method="POST" name="frnReserv" action="flow-command.php" enctype="multipart/form-data" >
    <table class="table table-bordered table-strap">
        <tr>
            <td>ปีที่ออกคำสั่ง</td>
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
        <tr class="bg-warning">
            <td>วันที่ลงนาม</td>
            <td><input type="date" name="dateline" class="form-control" value="<?php echo $row['dateline'];?>" onKeydown="return false" ></td>
        </tr>
        <tr class="bg-warning">
            <td>ผู้ลงนาม</td>
            <td><input type="text" name="boss" class="form-control" value="<?php echo $row['boss'];?>"></td>
        </tr>
        <tr class="bg-warning">
            <td>คำสั่งเรื่อง</td>
            <td><input type="text" name="title" class="form-control" value="<?php echo $row['title'];?>"></td>
        </tr>
        <tr class="bg-warning">
            <td>Upload File</td>
            <td><input type="file" name="fileupload" id="fileupload" class="form-control"/></td>
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
            <td colspan=2>
            <center>
                <input type="submit"  name="update" class="btn btn-success btn-lg" value="บันทึก" >
                <input type="hidden" name="cid" value="<?php echo $cid;?>">
            </center>
            </td>
        </tr>
    </table>

    </form>