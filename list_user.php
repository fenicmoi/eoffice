<?php
// Display  user registry 
date_default_timezone_set('Asia/Bangkok');
include "header.php"; 
include_once 'admin/function.php';

$sql = "SELECT *
        FROM  register_staf
        ORDER BY reg_id ASC ";

$result = dbQuery($sql);

?>

<div class="row">
   
    <div class ="col-md-12">
    <br><br><br>
        <table class="table table-bordered table-hover" id="myTable">
                        <thead class="alert alert-info">
                            <tr>
                                <th>ส่วนราชการ</th>
                                <th>เลขส่วนราชการ</th>
                                <th>เจ้าหน้าที่สารบรรณ</th>
                                <th>ตำแหน่ง</th>
                                <th>โทรศัพท์</th>
                                 <th>แฟกส์</th>
                                <th>อีเมลล์</th>
                                <th>เว็บไซต์</th>
                                <th>วันที่ลงทะเบียน</th>
                            </tr>
                        </thead>
        
                <tbody>
                        <?php while($row=dbFetchArray($result)){?>
                        <tr>
                            <td><?php echo $row['depart']?></td>
                            <td><?php echo $row['book_no']?></td>
                            <td><?php echo $row['fname']?>&nbsp&nbsp<?=$row['lname']?></td>
                            <td><?php echo $row['position']?></td>
                            <td><?php echo $row['office_tel']?></td>
                            <td><?php echo $row['office_fax']?></td>
                            <td><?php echo $row['email']?></td>
                            <td><?php echo $row['website']?></td>
                            <td><?php echo $row['date_add']?></td>
                        </tr>
                    <?php } ?>
                </tbody>
        </table>
    </div>
 
</div>
<?php include "footer.php";