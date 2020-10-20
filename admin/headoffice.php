
<?php
include 'header.php';
$u_id = $_SESSION['ses_u_id'];
?>
    <div class="row">
        <div class="col-md-2" >
           <?php
                $menu = checkMenu($level_id);
                include $menu;
                echo $menu;
            ?>
        </div>
        <div class="col-md-10">
            <div class="panel panel-primary" style="margin: 20">
                <div class="panel-heading"><i class="fa fa-user-secret fa-2x" aria-hidden="true"></i>  <strong>ข้อมูลผู้บริหาร</strong>
                    <a href="#" class="btn btn-default pull-right" data-toggle="modal" data-target="#modalAdd">
                        <i class="fa fa-plus" aria-hidden="true"></i>เพิ่มผู้บริหาร/เจ้าหน้าที่
                    </a>
                </div>
                <hr/>
                <table class="table table-bordered table-hover" id="myTable">
                    <thead class="alert alert-info">
                     <tr>
                         <th>ลำดับ</th>
                         <th>ตำแหน่ง</th>
                         <th>ชื่อ</th>
                         <th>สกุล</th>
                         <th>โทรศัพท์</th>
                         <th>โทรสาร</th>
                         <th>มือถือ</th>
                         <th>อีเมลล์</th>
                         <th>สายด่วน</th>
                         <th></th>
                     </tr>
                 </thead>
                 <tbody>
                     <?php
                        $count = 1;
                        switch ($level_id) {  //ตรวจสอบสิทธิ์การใช้งาน
                            case 1:
                              $sql = 'SELECT u.u_id,u.dep_id,u.firstname,u.lastname,u.position,d.dep_name,u.u_name,u.u_pass,l.level_name,s.sec_name,d.dep_name,u.status
                              FROM  user u
                              INNER JOIN  user_level l ON  u.level_id = l.level_id
                              INNER JOIN  section s ON u.sec_id=s.sec_id
                              INNER JOIN  depart d ON  u.dep_id=d.dep_id
                              ORDER BY u.u_id DESC
                              ';
                              break;
                            case 2:
                              $sql = "SELECT u.u_id,u.dep_id,u.firstname,u.lastname,u.position,d.dep_name,u.u_name,u.u_pass,l.level_name,s.sec_name,d.dep_name,u.status
                              FROM  user u
                              INNER JOIN  user_level l ON  u.level_id = l.level_id
                              INNER JOIN  section s ON u.sec_id=s.sec_id
                              INNER JOIN  depart d ON  u.dep_id=d.dep_id
                              WHERE u.dep_id=$dep_id AND u.level_id=2
                              ORDER BY u.u_id DESC
                              ";
                              break;
                            case 3:
                              $sql = "SELECT u.u_id,u.dep_id,u.firstname,u.lastname,u.position,d.dep_name,u.u_name,u.u_pass,l.level_name,s.sec_name,d.dep_name,u.status
                              FROM  user u
                              INNER JOIN  user_level l ON  u.level_id = l.level_id
                              INNER JOIN  section s ON u.sec_id=s.sec_id
                              INNER JOIN  depart d ON  u.dep_id=d.dep_id
                              WHERE u.dep_id=$dep_id
                              ORDER BY u.u_id DESC
                              ";
                              break;
                            case 4:
                                echo 'ไม่มีสิทธิ์ใช้งานเมนูนี้';
                                break;
                        }

                        $result = dbQuery($sql);
                        while ($row = dbFetchArray($result)) {
                            ?>
                            <tr>
                            <td><?php echo $count; ?></td>
                            <td><?php echo $row['firstname']; ?></td>
                            <td><?php echo $row['lastname']; ?></td>
                            <td><?php echo $row['u_name']; ?></td>
                            <td><?php echo $row['level_name']; ?></td>
                            <td><?php echo $row['sec_name']; ?></td>
                            <td><?php echo $row['dep_name']; ?></td>
                            
                            <td><?php
                                    $status = $row['status'];
                            if ($status == 1) {
                                echo '<center><i class="fa fa-check"</i></p></center>';
                            } else {
                                echo '<center><i class="fa fa-close"></i></p></center>';
                            } ?></td>
                
                            <td>
                                <a class="btn btn-info" href="user_edit.php?edit=<?php echo $row['u_id']; ?>" onclick="return confirm('กำลังจะแก้ไขข้อมูล !'); " >
                                <i class="fas fa-edit" aria-hidden="true"></i>  แก้ไข</a>
                            </td>
                            <td>
                                <a class="btn btn-danger" href="user.php?del=<?php echo $row['u_id']; ?>" onclick="return confirm('ระบบกำลังจะลบข้อมูล !'); " >
                                    <i class="fas fa-trash" aria-hidden="true"></i>   ลบ</a>
                            </td>
                            </tr>
                            <?php ++$count;
                        }?>
                 </tbody>
             </table>
                
            </div>
            <div class="well alert-info">
                คำอธิบาย:  <i class="fa fa-check"></i> อนุญาตใช้งาน
                         <i class="fa fa-close"></i> ระงับการใช้งาน
            </div>
            
            
            
            
            
            <!-- Model -->
            <!-- เพิ่มผู้ใช้ -->
            <div id="modalAdd" class="modal fade" role="dialog" >
              <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title "><i class="fa fa-user fa-2x"></i> เพิ่มผู้ใช้งาน</h4>
                  </div>
                  <div class="modal-body">
                      <form name="form" method="post">
                      <?php if ($level_id <= 2) {
                            ?>         <!-- กรณีที่เป็น Admin หรือ สารบรรณจังหวัด -->
                          <div class="form-group form-inline"> 
                                    <label for="province">ประเภทส่วนราชการ : </label>
                                    <span id="province">
                                        <select class="form-control" required>
                                            <option value="">- เลือกประเภทส่วนราชการ -</option>
                                        </select>
                                    </span>
                          </div>
                          <div class="form-group form-inline">
                              <label for="amphur">ชื่อส่วนราชการ : </label>
                                <span id="amphur">
                                    <select class="form-control" required>
                                        <option value=''>- เลือกหน่วยงาน -</option>
                                    </select>
                                </span>
                          </div>
                      <?php
                        } ?>  
                          <div class="form-group form-inline">
                              <label for="district">หน่วยงานย่อย : </label>
                                <span id="district">
                                    <select name="sec_id" class="form-control" required>
                                    <option value=''>- เลือกกลุ่มงาน -</option>
                                    <?php
                                     //if($level_id > 2){      //กรณีที่เป็นผู้ใช้งานทั่วไป
                                         $sql = "SELECT * FROM section WHERE dep_id=$dep_id";
                                         $result = dbQuery($sql);
                                         while ($rowSec = dbFetchArray($result)) {
                                             ?>
                                             <option value='<?php echo $rowSec['sec_id']; ?>'><?php echo $rowSec['sec_name']; ?></option>
                                   <?php
                                         }?>
                               <?php //}?>
                                    </select>
                                </span>
                          </div>
                          <div class="form-group form-inline">
                              <label for="level_name">สิทธิ์การใช้งาน : </label>
                              <?php if ($level_id <= 2) {
                                             ?>
                              <input type="radio" name="level"  id="level" value="1" > ผู้ดูแลระบบ 
                              <input type="radio" name="level"  id="level" value="2" > สารบรรณกลาง
                              <?php
                                         }?>
                              <input type="radio" name="level"  id="level" value="3"> สารบรรณประจำหน่วยงาน
                              <input type="radio" name="level"  id="level" value="4"> สารบรรณประจำกลุ่ม/กอง
                              <input type="radio" name="level"  id="level" value="5" checked=""> ผู้ใช้ทั่วไป
                          </div>
                          <div class="form-group form-inline">
                               <label for="firstname">ชื่อ :</label>
                              <div class="input-group">
                                  <input class="form-control" type="text" name="firstname" id="firstname" size="25" required="">
                              </div>
                                 <label for="lastname">นามสกุล</label>
                              <div class="input-group">
                                  <input class="form-control" type="text" name="lastname" id="lastname" size="20" required>
                              </div>
                          </div>
                          <div class="form-group form-inline">
                               <label for="position">ตำแหน่ง :</label>
                              <div class="input-group">
                                 <input class="form-control" type="text" name="position" id="position" size="40">
                              </div>
                          </div>
                          <div class="form-group form-inline">
                              <label for="u_name">ชื่อผู้ใช้ :</label>
                              <div class="input-group">
                                  <input class="form-control" type="text"  name="u_name" id="u_name"  required placeholder="username">
                              </div>
                              <label for="u_pass">รหัสผ่าน :</label>
                              <div class="input-group">
                                  <input class="form-control" type="text" name="u_pass" id="u_pass"  required placeholder="username">
                              </div>
                          </div> 
                          <div class="form-group form-inline">
                              <label for="email">E-mail</label>
                              <div class="input-group">
                                  <input class="form-control" type="email" name="email" id="email" required>
                              </div>
                          </div>
                          <div class="form-group form-inline">
                              <label for="status">สถานะการใช้งาน</label>
                              <input class="form-control" type="radio" name="status" id="status" value="1" checked>อนุญาตใช้งาน
                              
                          </div>
                          <div class="form-group form-inline">
                              <label for="date_create">วันที่สร้าง</label>
                              <div class="input-group">
                                  <input class="form-control" type="text" name="date_user" id="date_user" value="<?php echo date('Y-m-d'); ?>">
                              </div>
                          </div>
                          <?php
                            if (isset($_GET['edit'])) {
                                ?>
                                    <button type="submit" name="update">update</button>
                                    <?php
                            } else {
                                ?>
                                    <center><button class="btn btn-primary btn-lg" type="submit" name="save">
                                        <i class="fa fa-database fa-2x"></i> บันทึก
                                        <input id="u_id" name="u_id" type="hidden" value="<?php echo $u_id; ?>"> 
                                        </button></center>
                                    <?php
                            }
                            ?>
                     </form>
                  </div>
                  <div class="modal-footer bg-primary">
                      <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i></button>
                  </div>
                </div>

              </div>
            </div>
            <!-- End Model --> 
            
            
            
        </div>
    </div>  

<?php 
if (isset($_POST['save'])) {
    if ($level_id <= 2) {  //กรณีเป็นผู้ดูแลระบบ เอาค่า จากส่วนนี้
        $type_id = $_POST['province'];  //ประเภทส่วนราชการ
        $dep_id = $_POST['amphur'];     //รหัสหน่วยงาน
        $sec_id = $_POST['district'];   //รหัสกลุ่มงานย่อย
    }

    $level_id = $_POST['level'];
    $u_name = $_POST['u_name'];
    $u_pass = $_POST['u_pass'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $position = $_POST['position'];
    $date_create = $_POST['date_user'];
    $status = $_POST['status'];
    $email = $_POST['email'];

    // print $sql;
    $sql = "SELECT * FROM user WHERE u_name='".$u_name.'';
    $result = dbQuery($sql);
    $numrow = dbNumRows($result);
    if ($numrow >= 1) {
        echo "<script>
               swal({
                title:'ชื่อผู้ใช้งานซ้ำ!..กรุณาเปลี่ยนใหม่',
                type:'error',
                showConfirmButton:true
                },
                function(isConfirm){
                    if(isConfirm){
                        window.location.href='user.php';
                    }
                }); 
              </script>";
    } elseif ($numrow < 1) {
        $sql = "INSERT INTO user(sec_id,dep_id,level_id,u_name,u_pass,firstname,lastname,position,date_create,status,email)
                   VALUES ($sec_id,$dep_id,$level_id,'$u_name','$u_pass','$firstname','$lastname','$position','$date_create',$status,'$email')";
        //echo $sql;
        $result = dbQuery($sql);
        $level_id = $_SESSION['level'];
        if (!$result) {
            echo "<script>
            swal({
             title:'มีบางอย่างผิดพลาด',
             type:'warning',
             showConfirmButton:true
             },
             function(isConfirm){
                 if(isConfirm){
                     window.location.href='user.php';
                 }
             }); 
           </script>";
        } else {
            echo "<script>
            swal({
             title:'เพิ่มผู้ใช้เรียบร้อยแล้ว',
             type:'success',
             showConfirmButton:true
             },
             function(isConfirm){
                 if(isConfirm){
                     window.location.href='user.php';
                 }
             }); 
           </script>";
        }
    } // user duplicate
} //send

if (isset($_GET['del'])) {
    $sql = 'DELETE FROM user WHERE u_id='.$_GET['del'];
    $result = dbQuery($sql);
    if (!$result) {
        echo "<script>
            swal({
             title:'มีบางอย่างผิดพลาด  กรุณาลองใหม่',
             type:'warning',
             showConfirmButton:true
             },
             function(isConfirm){
                 if(isConfirm){
                     window.location.href='user.php';
                 }
             }); 
           </script>";
    } else {
        echo "<script>
            swal({
             title:'ลบผู้ใช้เรียบร้อยแล้ว',
             type:'success',
             showConfirmButton:true
             },
             function(isConfirm){
                 if(isConfirm){
                     window.location.href='user.php';
                 }
             }); 
           </script>";
    }
}

if (isset($_GET['edit'])) {
    $SQL = $conn->query('SELECT * FROM  user WHERE u_id='.$_GET['edit']);
    echo $sql;
    $getROW = $SQL->fetch_array();
    //echo "<meta http-equiv='refresh' content='1;URL=object.php'>";
}

if (isset($_POST['update'])) {
    $sql = 'UPDATE depart
                         SET type_id='.$_POST['officeType'].",
                             dep_name='".$_POST['dep_name']."',
                             address='".$_POST['address']."',
                             phone='".$_POST['tel']."',
                             fax='".$_POST['fax']."',
                             social='".$_POST['website']."',
                             status=".$_POST['status'].',
                             local_num='.$_POST['local_num'].'
                        WHERE dep_id='.$_GET['edit'].'
                            ';
    echo $sql;
    $SQL = $conn->query($sql);
    echo '<script>swal("Good job!", "แก้ไขข้อมูลแล้ว!", "success")</script>';

    echo "<meta http-equiv='refresh' content='1;URL=user.php'>";
}
?>







<script language=Javascript>   //ส่วนการทำ dropdown
        function Inint_AJAX() {
           try { return new ActiveXObject("Msxml2.XMLHTTP");  } catch(e) {} //IE
           try { return new ActiveXObject("Microsoft.XMLHTTP"); } catch(e) {} //IE
           try { return new XMLHttpRequest();          } catch(e) {} //Native Javascript
           alert("XMLHttpRequest not supported");
           return null;
        };

        function dochange(src, val) {
             var req = Inint_AJAX();
             req.onreadystatechange = function () { 
                  if (req.readyState==4) {
                       if (req.status==200) {
                            document.getElementById(src).innerHTML=req.responseText; //รับค่ากลับมา
                       } 
                  }
             };
             req.open("GET", "localtion.php?data="+src+"&val="+val); //สร้าง connection
             req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;charset=utf-8"); // set Header
             req.send(null); //ส่งค่า
        }

        window.onLoad=dochange('province', -1);     

        $(document).ready( function () {
            $('#myTable').DataTable();
        } );
    </script>
    
    
