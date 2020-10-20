
<?php
date_default_timezone_set('Asia/Bangkok');
include 'admin/function.php';
include 'library/database.php';  

//$u_id=$_GET['u_id'];
$cid=$_POST['cid'];
$table="flowcircle";
hit($table,$cid);


//echo "uid:".$u_id;
$sql="SELECT f.*,d.dep_name,s.sec_name,y.yname,u.firstname,o.obj_name,sp.speed_name
      FROM flowcircle as f
      INNER JOIN section as s ON s.sec_id = f.sec_id
      INNER JOIN depart as d ON d.dep_id = f.dep_id
      INNER JOIN user as u ON u.u_id = f.u_id
      INNER JOIN sys_year as y ON y.yid = f.yid
      INNER JOIN object as o ON o.obj_id = f.obj_id
      INNER JOIN speed as sp ON sp.speed_id = f.speed_id
      WHERE cid=$cid";
//echo $sql;
$result=dbQuery($sql);
$row=dbFetchAssoc($result);
$uid=$row['u_id'];
?>  

<table border=1 width=100% class="table table-hover" >
    <tr>
         <td><label>เลขหนังสือ:</label></td>
         <td><?php print $row['prefex']?><? print $row['rec_no']?></td>
    </tr>
    <tr>
        <td><label>วันที่ทำรายการ:</label></td>
        <td><?php print thaiDate($row['dateout']);?></td>
        
    </tr>
    <tr>
        <td><label>เรื่อง:</label></td>
        <td><?php print $row['title']?></td>
    </tr>
    <tr>
        <td><label>วัตถุประสงค์:</label></td>
        <td><?php print $row['obj_name'];?></td>
    </tr>
     <tr>
        <td><label>ผู้ส่ง:</label></td>
        <td><?php print $row['sendfrom'];?></td>
    </tr>
    <tr>
        <td><label>ผู้รับ:</label></td>
        <td><?php print $row['sendto'];?></td>
    </tr>
    <tr>
        <td><label>อ้างถึง:</label></td>
        <td><?php print $row['refer'];?></td>
    </tr>
    <tr>
        <td><label>สิ่งที่ส่งมาด้วย:</label></td>
        <td><?php print $row['attachment'];?></td>
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
        <td><label>เจ้าหน้าที่:</label></td>
        <td><?php print $row['firstname']?></td>
    </tr>
     <tr>
        <td><label>ไฟล์เอกสาร:</label></td>
        <?php 
         $fileupload=$row['file_upload'];
         if($fileupload==''){
            echo "<td>-</td" ;
         }else{?>
             <td><a class="btn btn-warning"  href="admin/<?php print $fileupload ?>" target="_blank"><i class="fa fa-download"></i> ดาวน์โหลด</a></td>
         <?php } ?>
    </tr>
    
</table>
