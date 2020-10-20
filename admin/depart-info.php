
<?php
/*if(!isset($_SESSION['ses_u_id'])){
    header("location:../index.php");
}*/

include 'header.php';

$u_id = $_SESSION['ses_u_id'];
?>
    <div class="row">
        <div class="col-md-2" >
             <?php
                 $menu = checkMenu($level_id);
                include $menu;
            ?>
        </div>
        <div class="col-md-10">
            <div class="panel panel-default" style="margin: 20">
                <div class="panel-heading"><i class="fa fa-university fa-2x" aria-hidden="true"></i>  <strong>ข้อมูลหน่วยงาน</strong>
                <a href="add_object.php" class="btn btn-primary  pull-right" data-toggle="modal" data-target="#modalAdd">
                     <i class="fa fa-plus" aria-hidden="true"></i> เพิ่มส่วนราชการ
                    </a>
                </div> 
                <table class="table table-bordered table-hover" id="myTable">
                 <thead class="bg-info">
                     <tr>
                         <th>ที่</th>
                         <th>ชื่อส่วนราชการ</th>
                         <th>โทรศัพท์</th>
                         <th>แฟกซ์</th>
                         <th>ประเภทหน่วยงาน</th>
                         <th>สถานะ</th>
                         <th>กระทรวง</th>
                         <th>แก้ไข</th>
                         <th>ลบ</th>
                     </tr>
                 </thead>
                 <tbody>
                     <?php
                        $count = 1;
                        $sql = 'SELECT d.*,o.type_name
                                FROM depart d
                                INNER JOIN office_type o ON d.type_id= o.type_id
                                ORDER BY d.dep_id DESC
                              ';
                        $result = dbQuery($sql);
                        while ($row = dbFetchArray($result)) {
                            ?>
                            <tr>
                            <td><?php echo $count; ?></td>
                            <td><?php echo $row['dep_name']; ?></td>
                            <td><?php echo $row['phone']; ?></td>
                            <td><?php echo $row['fax']; ?></td>
                            <td><?php echo $row['type_name']; ?></td>
                            <td><?php  ?> </td>
                            <td>
                                <?php
                                    $local_num = $row['local_num'];
                            if ($local_num == 1) {
                                echo '<center><i class="fa fa-check-square"></i></center>';
                            } else {
                                echo '<center><i class="fa fa-close"></p></center>';
                            } ?>
                            </td>
                
                            <td><a class="btn btn-success" href="depart_edit.php?edit=<?php echo $row['dep_id']; ?>" onclick="return confirm('กำลังจะแก้ไขข้อมูล !'); " >
                                <i class="fas fa-edit" aria-hidden="true"></i>  แก้ไข</a></td>
                                <td><a class="btn btn-danger" href="depart.php?del=<?php echo $row['dep_id']; ?>" onclick="return confirm('ระบบกำลังจะลบข้อมูล !'); " >
                                    <i class="fas fa-trash" aria-hidden="true"></i>   ลบ</a></td>
                            </tr>
                            <?php ++$count;
                        }?>
                 </tbody>
                </table>
                
            </div>
            <!-- Model -->
            <!-- -ข้อมูลผู้ใช้ -->
            <div id="modalAdd" class="modal fade" role="dialog">
              <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">เพิ่มส่วนราชการ</h4>
                  </div>
                  <div class="modal-body">
                      <form method="post">
                        <div class="form-group">
                            <div class="input-group">
                                <label for="status"><i class="fa fa-cog"></i>สถานะการใช้งาน:</label>
                                    <input type="radio" id="status" name="status" value="1" checked> ใช้งาน 
                                    <input type="radio" id="status" name="status" value="0"> ระงับการใช้งาน <br>
                                <label for="local_num"><i class="fa fa-cog"></i>อนุญาตออกเลขหนังสือภายใน:</label>
                                    <input type="radio" id="local_num" name="local_num" value="1" checked> อนุญาต 
                                    <input type="radio" id="local_num" name="local_num" value="0"> ไม่อนุญาต
                            </div>
                            <div class="input-group">
                                <span class="input-group-addon">ประเภทส่วนราชการ</span>
                                <select class="form-control" id="officeType" name="officeType" required="">
                                    <option value="" disabled selected>จำเป็นต้องระบุ</option>
                                    <?php
                                        $sql = 'SELECT * FROM office_type ORDER BY type_id';
                                        $result = dbQuery($sql);
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo '<option value='.$row['type_id'].'>'.$row['type_name'].'</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">กระทรวง</span>
                                 <select class="form-control" id="ministry" name="ministry" required="">
                                    <option value="" disabled selected>จำเป็นต้องระบุ</option>
                                    <?php
                                        $sql = 'SELECT * FROM ministry ORDER BY m_impo';
                                        $result = dbQuery($sql);
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo '<option value='.$row['m_id'].'>'.$row['m_name'].'</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                          <div class="input-group">
                              <span class="input-group-addon">ชื่อส่วนราชการ</span>
                              <input type="text"" class="form-control" id="dep_name" name="dep_name" required="">
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="input-group">
                              <span class="input-group-addon">เลขหนังสือหน่วยงาน</span>         
                              <input type="text" class="form-control" id="prefex" name="prefex" required="">
                             
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="address">ที่อยู่สำนักงาน:</label>
                          <textarea class="form-control" name="address" rows="3" cols="60" required="">
                          </textarea>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                 <span class="input-group-addon">เบอร์โทรศัพท์</span>
                                <input type="text" class="form-control" id="phone" name="phone" onkeyup="autoTabTel(this,2)" required="" > 
                                                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">เบอร์โทรสาร</span>
                                <input type="text" class="form-control" id="fax" name="fax" onkeyup="autoTabTel(this,2)" >
                            </div>
                        </div>
                        <div class="form-group">
                          <div class="input-group">
                             <span class="input-group-addon">เว็บไซต์</span>
                             <input type="facebook" class="form-control" id="facebook" name="facebook">
                          </div>
                        </div>
                          <?php
                            if (isset($_GET['edit'])) {
                                ?>
                                    <button type="submit" name="update">update</button>
                                    <?php
                            } else {
                                ?>
                                    <center>
                                        <button class="btn btn-primary btn-lg" type="submit" name="save">
                                        <i class="fa fa-database fa-2x"></i> บันทึก
                                        </button>
                                    </center>
                                    <?php
                            }
                            ?>
                                                     
                      </form>
                  </div>
                  <div class="modal-footer bg-primary">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  </div>
                </div>

              </div>
            </div>
            <!-- End Model -->   
        </div>
    </div>  
<?php
// ส่วนการจัดการข้อมูล
if (isset($_POST['save'])) {
    $officeType = $_POST['officeType'];
    $dep_name = $_POST['dep_name'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $fax = $_POST['fax'];
    $social = $_POST['facebook'];
    $status = $_POST['status'];
    $local_num = 1;
    $prefex = $_POST['prefex'];

    $sql = "SELECT * FROM depart WHERE dep_name='$dep_name'";
    //echo $sql;
    $result = dbQuery($sql);
    $row = dbFetchRow($result);
    if ($row > 0) {
        echo "<script>
       swal({
        title:'มีชื่อส่วนราชการนี้แล้ว !  กรุณาตรวจสอบ',
        type:'error',
        showConfirmButton:true
        },
        function(isConfirm){
            if(isConfirm){
                window.location.href='depart.php';
            }
        }); 
      </script>";
    } else {
        $sql = "INSERT INTO depart(type_id,dep_name,address,phone,fax,social,status,local_num,prefex)
        VALUES ('$officeType','$dep_name','$address','$phone','$fax','$social',$status,$local_num,'$prefex')";

        $result = dbQuery($sql);
        if (!$result) {
            echo "<script>
           swal({
            title:'มีบางอย่างผิดพลาด! กรุณาตรวจสอบ',
            type:'error',
            showConfirmButton:true
            },
            function(isConfirm){
                if(isConfirm){
                    window.location.href='depart.php';
                }
            }); 
          </script>";
        } else {
            echo "<script>
           swal({
            title:'เรียบร้อย',
            type:'success',
            showConfirmButton:true
            },
            function(isConfirm){
                if(isConfirm){
                    window.location.href='depart.php';
                }
            }); 
          </script>";
        }//check error
    } //check duplicate
}

if (isset($_GET['del'])) {
    $sql = 'DELETE FROM depart WHERE dep_id='.$_GET['del'];
    $result = dbQuery($sql);
    if (!$result) {
        echo "<script>
        swal({
         title:'มีบางอย่างผิดพลาด! กรุณาตรวจสอบ',
         type:'error',
         showConfirmButton:true
         },
         function(isConfirm){
             if(isConfirm){
                 window.location.href='depart.php';
             }
         }); 
       </script>";
    } else {
        echo "<script>
        swal({
         title:'เรียบร้อย',
         type:'success',
         showConfirmButton:true
         },
         function(isConfirm){
             if(isConfirm){
                 window.location.href='depart.php';
             }
         }); 
       </script>";
    }
}
?>
<?php //include "footer.php";?>


