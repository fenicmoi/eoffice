
<?php
date_default_timezone_set('Asia/Bangkok');
include 'function.php';
include '../library/database.php';

$cid=$_POST['cid'];
$u_id=$_POST['u_id'];
$sql="SELECT dep.*,d.dep_name,s.sec_name,y.yname,u.firstname
      FROM flow_recive_group as dep
      INNER JOIN depart as d ON d.dep_id = dep.dep_id
      INNER JOIN section as s ON s.sec_id = dep.sec_id
      INNER JOIN user as u ON u.u_id = dep.u_id
      INNER JOIN sys_year as y ON y.yid = dep.yid
      WHERE dep.cid=$cid";
//print $sql;
$result=dbQuery($sql);
$row=dbFetchAssoc($result);
?>  
  <form name="form_update" action="flow-resive-group.php"   method="post" >
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
        <td><?php print $row['practice'];?></td>
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
                    echo "  
                          <input type=\"radio\" name=\"status\" value=0 checked> อยู่ระหว่างดำเนินการ
                          <input type=\"radio\" name=\"status\" value=1> เสร็จแล้ว
                          ";
                          
                }else{
                    echo "<input type=\"radio\" name=\"status\" value=0 > อยู่ระหว่างดำเนินการ
                          <input type=\"radio\" name=\"status\" value=1 checked> เสร็จแล้ว
                          ";
                }
            ?>
        </td>
    </tr>
    <tr>
        <td colspan="2">
        <center>
            <input type="hidden" name="cid" value="<?=$cid?>">
             <button class="btn btn-success" type="submit" name="update">Update</button>
            <!-- <input type="submit" value="submit"> -->
           
        </center></td>

    </tr>
</table>
</form>


