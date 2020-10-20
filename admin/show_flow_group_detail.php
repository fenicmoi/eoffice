
<?php
date_default_timezone_set('Asia/Bangkok');
include 'function.php';
include '../library/database.php';

$cid=$_POST['cid'];
$u_id=$_POST['u_id'];
$sql="SELECT g.*,d.dep_name,s.sec_name,y.yname,u.firstname
      FROM flow_recive_group as g
      INNER JOIN depart as d ON d.dep_id = g.dep_id
      INNER JOIN section as s ON s.sec_id = g.sec_id
      INNER JOIN user as u ON u.u_id = g.u_id 
      INNER JOIN sys_year as y ON y.yid = g.yid
      WHERE g.cid=$cid";
$result=dbQuery($sql);
$row=dbFetchAssoc($result);

//ตรวจสอบจำนวนวัน
$d1 = $row[ 'datein' ];
$d2 = date( 'Y-m-d' );
$numday = getNumDay( $d1, $d2 );
?>  
  <form name="form_update" action="flow-resive-group.php"   method="post" >
<?php 
if($numday > 3){?>   
<table border=1 width=100% >
    <tr>
         <td><label>เลขทะเบียนรับ:</label></td>
         <td><?php print $row['rec_no']?>/<?php print $row['yname'];?></td>
    </tr>
    <tr>
         <td><label>เลขหนังสือ:</label></td>
         <td><?php print $row['book_no']?></td>
    </tr>
    <tr>
         <td><label>เรื่อง:</label></td>
         <td><?php print $row['title']?></td>
    </tr>
    <tr>
         <td><label>ผู้ส่ง:</label></td>
         <td><?php print $row['sendfrom']?></td>
    </tr>
    <tr>
         <td><label>ผู้รับ:</label></td>
         <td><?php print $row['sendto']?></td>
    </tr>
    <tr>
        <td><label>ลงวันที่:</label></td>
        <td><?php print thaiDate($row['dateout']);?></td>
    </tr>
     <tr>
        <td><label>วันที่ลงรับ:</label></td>
        <td><?php print thaiDate($row['datein']);?></td>
    </tr>
    <tr>
        <td><label>ผู้ปฏิบัติ:</label></td>
        <td><?php
            $practice = $row['practice'];
            $sql = "SELECT u_id,firstname FROM user WHERE u_id = $practice";
            $query = dbQuery($sql);
            $result = dbFetchArray($query);
            echo $result['firstname'];
        ?></td>
    </tr>
    <tr>
        <td><label>เจ้าหน้าที่ผู้ลงรับ</label></td>
        <td><?php print $row['firstname']?></td>
    </tr>
    
    <tr>
        <td><label>การปฏิบัติ</label></td>
        <td>
            <?php 
                if($row['status']==0){
                    echo "อยู่ระหว่างดำเนินการ";
                          
                }else{
                    echo "ดำเนินการแล้ว";
                }
            ?>
        </td>
    </tr>
    <tr>
        <td colspan="2">
        <center>
             <button class="btn btn-primary" type="submit" name="ok">ตกลง</button>
            <!-- <input type="submit" value="submit"> -->
           
        </center></td>

    </tr>
</table>

<?php }else{ ?>
<table class="table table-bordered" width=100% >
    <tr>
         <td><label>เลขทะเบียนรับ:</label></td>
         <td><?php print $row['rec_no']?>/<?php print $row['yname'];?></td>
    </tr>
    <tr>
         <td><label>เลขหนังสือ:</label></td>
         <td><input type="text" name="book_no" id="book_no" class="form-control" value="<?php echo $row['book_no'];?>"></td>
    </tr>
    <tr>
         <td><label>เรื่อง:</label></td>
         <td><input type="text" name="title" id="title" class="form-control" value="<?php echo $row['title'];?>"></td>
    </tr>
    <tr>
         <td><label>ผู้ส่ง:</label></td>
         <td><input type="text" name="sendfrom" id="sendfrom" class="form-control" value="<?php echo $row['sendfrom'];?>"></td>
    </tr>
    <tr>
         <td><label>ผู้รับ:</label></td>
         <td><input type="text" name="sendto" id="sendto" class="form-control" value="<?php echo $row['sendto'];?>"></td>
    </tr>
    <tr>
        <td><label>ลงวันที่:</label></td>
        <td><input type="date" name="dateout" id="dateout" class="form-control" value="<?php echo $row['dateout'];?>"></td>
    </tr>
     <tr>
        <td><label>วันที่ลงรับ:</label></td>
        <td><input type="date" name="datein" id="datein" class="form-control" value="<?php echo $row['datein'];?>"></td>
    </tr>
    <tr>
        <td><label>ผู้ปฏิบัติ:</label></td>
        <td><?php
            $sec_id= $row['sec_id'];
            $p1 = $row['practice'];
            $sql = "SELECT u_id,sec_id,dep_id,firstname FROM user WHERE sec_id=$sec_id";
            $query = dbQuery($sql);
        ?>
            <?php $p1= $row['practice'];?>
            <select class="form-control" name="practice">
					<?php
						while ( $r= dbFetchArray( $query ) ) {?>
						<option  <?php if ($p1 == $r['u_id']) {
                             echo 'selected';
                            } ?> value="<?=$r['u_id']?>"><?php echo $r['firstname'];?>
						</option>
					<?php } ?>
			</select>
        </td>
    </tr>
    <tr>
        <td><label>เจ้าหน้าที่ผู้ลงรับ</label></td>
        <td><?php print $row['firstname']?></td>
    </tr>
    
    <tr>
        <td><label>การปฏิบัติ</label></td>
        <td>
            <?php 
                if($row['status']==0){
                    echo "อยู่ระหว่างดำเนินการ";
                          
                }else{
                    echo "ดำเนินการแล้ว";
                }
            ?>
        </td>
    </tr>
    <tr>
        <td colspan="2">
        <center>
            <input type="hidden" name="cid" value="<?=$cid?>">
             <button class="btn btn-warning" type="submit" name="update">ตกลง</button>
            <!-- <input type="submit" value="submit"> -->
           
        </center></td>

    </tr>
</table>
<?php }
?>
</form>


