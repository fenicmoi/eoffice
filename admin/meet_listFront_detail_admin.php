
<?php
include 'function.php';
include "../library/database.php";
$book_id=$_POST['book_id'];

$sql ="SELECT m.*, r.roomname, r.roomplace, r.roomcount, r.roomimg, d.dep_name, d.phone, u.firstname, u.lastname FROM meeting_booking AS m 
       INNER JOIN meeting_room AS r ON m.room_id = r.room_id
       INNER JOIN depart AS d ON m.dep_id = d.dep_id
       INNER JOIN user as u ON m.user_id = u.u_id
       WHERE book_id=$book_id";

//print $sql;
$result = dbQuery($sql);
$row = dbFetchAssoc($result);

?>
<h3>Admin Panel </h3>
<table class="table  table-bordered" width="100%">
    <tbody>
        <tr class="bg-warning">
            <td class="text-center" colspan="4"> 
                <form action="meet_wait.php" method="POST">
                     <label class="radio-inline"><input type="radio" name="optradio" value="2" <?php if($row['conf_status']==2){ echo "checked";}?>> อนุมัติ</label>
                     <label class="radio-inline"><input type="radio" name="optradio" value="1" <?php if($row['conf_status']==1){ echo "checked";}?>> รออนุมัติ</label>
                     <label class="radio-inline"><input type="radio" name="optradio" value="0" <?php if($row['conf_status']==0){ echo "checked";}?>> ยกเลิกการจอง</label> 
                     <hr>
                     <div class="form-group">
                        <div class="input-group col-xs-12">
                            <span class="input-group-addon">หมายเหตุ</span>
                            <input class="form-control" type="text" name="remark" id="remark">
                        </div>
                    </div> 
                    <button type="submit" class="btn btn-success btn-lg" name="save" id="save"><i class="fas fa-cat"></i>ตกลง</button>
                    <input type="hidden" name="book_id" value="<?php print $row['book_id'];?>">
                </form>

            </td>
        </tr>
        <tr>
            <td><b><i class="fas fa-list"></i> เรื่องประชุม</b></td>
            <td colspan='3'><?php echo $row['subject'];?></td>
        </tr>
        <tr>
            <td><b><i class="fas fa-user-tie"></i> ประธานการประชุม</b></td>
            <td colspan="3"><?php echo $row['head'];?></td>
        </tr>
        <tr>
            <td><b><i class="fas fa-list"></i> ชื่อห้องประชุม</b></td>
            <td colspan="3"><?php echo $row['roomname'];?></td>
        </tr>
        <tr>
            <td><b<i class="fas fa-map-marker-alt"></i> ที่อยู่</b></td>
            <td colspan='3'><?php echo $row['roomplace'];?></td>
        </tr>
        <tr>
            <td><b><i class="fas fa-calendar"></i> วันที่ประชุม</b></td>
            <td><?php echo thaiDate($row['startdate']);?></td>
            <td><b><i class="fas fa-clock"> เวลาประชุม</b></td>
            <td><?php echo  $row['starttime'];?> - <?php echo $row['endtime'];?></td>
        </tr>
        <tr>
            <td><b><i class="fas fa-user-tie"></i> ประธานการประชุม</b></td>
            <td colspan="3"><?php echo $row['head'];?></td>
        </tr>
        <tr>
            <td><b><i class="fas fa-users"></i> จำนวนผู้เข้าประชุม</b></td>
            <td><?php echo $row['numpeople'];?>.คน</td>
            <td><b><i class="fas fa-box-open"></i> ความจุห้องประชุม</b></td>
            <td><?php echo $row['roomcount'];?>.คน</td>
        </tr>
         <tr>
            <td><b><i class="fas fa-home "></i> เจ้าของเรื่อง</b></td>
            <td colspan="3"><?php echo $row['dep_name'];?></td>
        </tr>
        <tr>
            <td><b><i class="fas fa-user "></i> ผู้จอง</b></td>
            <td><?php echo $row['firstname'];?>&nbsp<?php echo $row['lastname'];?></td>
            <td><b><i class="fas fa-phone "></i> โทรศัพท์</b></td>
            <td><?php echo $row['phone'];?></td>
        </tr>
    </tbody>
</table>



