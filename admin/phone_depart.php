
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
                <div class="panel-heading"><i class="fa fa-university fa-2x" aria-hidden="true"></i>  <strong>หน่วยงานในสังกัดกระทรวง</strong>
                <a href="add_object.php" class="btn btn-primary  pull-right" data-toggle="modal" data-target="#modalAdd">
                     <i class="fa fa-plus" aria-hidden="true"></i> เพิ่มหน่วยงาน
                    </a>
                </div> 
                <table class="table table-bordered table-hover" id="myTable">
                 <thead class="bg-info">
                     <tr>
                         <th>ที่</th>
                         <th>หน่วยงาน</th>
                         <th>สังกัด</th>
                         <th>แก้ไข</th>
                     </tr>
                 </thead>
                 <tbody>
                     <?php
                        $count = 1;
                        $sql = '
                                SELECT d.*,m.m_name FROM phone_depart as d
                                INNER JOIN ministry as m ON d.dep_minis = m.m_id  
                                ORDER BY dep_id
                              ';
                        $result = dbQuery($sql);
                        while ($row = dbFetchArray($result)) {
                            ?>
                            <tr>
                            <td><?php echo $count; ?></td>
                            <td><?php echo $row['dep_name']; ?></td>
                            <td><?php echo $row['m_name']; ?></td>
                            <td><a class="btn btn-success" href="depart_edit.php?edit=<?php echo $row['dep_id']; ?>" onclick="return confirm('กำลังจะแก้ไขข้อมูล !'); " >
                                <i class="fas fa-edit" aria-hidden="true"></i>  แก้ไข</a>
                            </td>
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
                    <h4 class="modal-title">เพิ่มหน่วยงาน</h4>
                  </div>
                  <div class="modal-body">
                      <form method="post">
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
    $dep_name = $_POST['dep_name'];
    $dep_minis = $_POST['ministry'];

    $sql = "SELECT * FROM phone_depart WHERE dep_name =$dep_name";
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
                window.location.href='phone_depart.php';
            }
        });
      </script>";
    } else {
        $sql = "INSERT INTO phone_depart(dep_minis,dep_impo,dep_name)
                 VALUES ($dep_minis,'','$dep_name')";
        //echo $sql;

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
                            window.location.href='phone_depart.php';
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
                            window.location.href='phone_depart.php';
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


