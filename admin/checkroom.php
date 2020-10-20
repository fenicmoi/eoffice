
<?php
date_default_timezone_set('Asia/Bangkok');
include 'function.php';
include '../library/database.php';

$room=$_POST['room_id'];
$u_id=$_POST['u_id'];
$startdate=$_POST['startdate'];  //1

$sql = "SELECT * FROM meeting_room WHERE room_id='$room'";
$result = dbQuery($sql);
$row = dbFetchArray($result);
$roomname=$row['roomname'];


$sql="SELECT bk.book_id, bk.subject, rm.roomname, bk.startdate, bk.enddate ,bk.starttime, bk.endtime, bk.numpeople,bk.conf_status, d.dep_name
	  FROM meeting_booking AS bk
      INNER JOIN  meeting_room AS rm  ON bk.room_id = rm.room_id
      INNER JOIN  depart AS d ON bk.dep_id = d.dep_id
      WHERE bk.room_id=rm.room_id AND bk.conf_status <> '0' AND bk.startdate='$startdate' AND bk.room_id='$room' ORDER BY bk.book_id  DESC";
//print $sql;
$result = dbQuery($sql);
$numrow = dbNumRows($result);
if($numrow==0){
    echo "<center><i class='fas fa-cat fa-5x'></i> ไม่มีข้อมูลการประชุมสำหรับวันนี้</center>";
}else{
?>  
<table class="table table-bordered table-striped">
    <thead>
        <tr class="bg-info">
             <td colspan='5'><div align="center"><i class="fas fa-list"></i> ข้อมูลการใช้ <kbd><?php echo $roomname; ?></kbd> วันที่ <?php print thaiDate($startdate);?></td>
        </tr>
        <tr>
            <td width="60%">เรื่อง</td>
            <td width="10%">จำนวนคน</td>
            <td width="10%">เวลาประชุม</td>
            <td width="20%">เจ้าของเรื่อง</td>
            <td>สถานะ</td>
        </tr>
    </thead>
    <tbody>
        <?php
            while($row = dbFetchArray($result)){?>
              <tr>
                 <td><?php echo $row['subject'];?></td>
                 <td><?php echo $row['numpeople'];?></td>
                 <td><?php echo $row['starttime'];?></td>
                 <td><?php echo $row['dep_name'];?></td>
                 <td>
                    <?php
                    if($row['conf_status']==1){
                        echo "รออนุมัติ";
                    }elseif($row['conf_status']==2){
                        echo "อนุมัติ";
                    }
                    ?>
                 </td>
              </tr>      
           <?php } ?>
    </tbody>
</table>
<?php } ?>
