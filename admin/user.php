<?php
include '../chksession.php';
include 'header.php';
$u_id = $_SESSION['ses_u_id'];
?>
</script>
<div class="row">
    <div class="col-md-2">
        <?php
        $menu = checkMenu($level_id);
        include $menu;
        echo $menu;
        ?>
    </div>
    <div class="col-md-10">
        <div class="panel panel-danger">
            <div class="panel-heading"><i class="fa fa-user-secret fa-2x" aria-hidden="true"></i>
                <strong>จัดการผู้ใช้งาน</strong>
                <a href="#" class="btn btn-default pull-right" data-toggle="modal" data-target="#modalAdd">
                    <i class="fa fa-plus" aria-hidden="true"></i>เพิ่มผู้ใช้งาน
                </a>
            </div>



            <hr />
            <table class="table table-bordered table-hover" id="myTable">
                <thead class="bg-primary">
                    <tr>
                        <th>ที่</th>
                        <th>ชื่อ</th>
                        <th>สกุล</th>
                        <th>ชื่อผู้ใช้</th>
                        <th>สิทธิ์การใช้งาน</th>
                        <th>กลุ่ม/ฝ่าย</th>
                        <th>ต้นสังกัด</th>
                        <th>สถานะ</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $count = 1;
                    $result = null;
                    switch ($level_id) {  //ตรวจสอบสิทธิ์การใช้งาน
                        case 1:
                            $sql = 'SELECT u.u_id,u.dep_id,u.firstname,u.lastname,u.position,d.dep_name,u.u_name,u.u_pass,l.level_name,s.sec_name,d.dep_name,u.status
                              FROM  user u
                              INNER JOIN  user_level l ON  u.level_id = l.level_id
                              INNER JOIN  section s ON u.sec_id=s.sec_id
                              INNER JOIN  depart d ON  u.dep_id=d.dep_id
                              ORDER BY u.u_id DESC
                              ';
                            $result = dbQuery($sql);
                            break;
                        case 2:
                            $sql = "SELECT u.u_id,u.dep_id,u.firstname,u.lastname,u.position,d.dep_name,u.u_name,u.u_pass,l.level_name,s.sec_name,d.dep_name,u.status
                              FROM  user u
                              INNER JOIN  user_level l ON  u.level_id = l.level_id
                              INNER JOIN  section s ON u.sec_id=s.sec_id
                              INNER JOIN  depart d ON  u.dep_id=d.dep_id
                              WHERE u.dep_id = ? AND u.level_id = 2
                              ORDER BY u.u_id DESC
                              ";
                            $result = dbQuery($sql, "i", [(int) $dep_id]);
                            break;
                        case 3:
                            $sql = "SELECT u.u_id,u.dep_id,u.firstname,u.lastname,u.position,d.dep_name,u.u_name,u.u_pass,l.level_name,s.sec_name,d.dep_name,u.status
                              FROM  user u
                              INNER JOIN  user_level l ON  u.level_id = l.level_id
                              INNER JOIN  section s ON u.sec_id=s.sec_id
                              INNER JOIN  depart d ON  u.dep_id=d.dep_id
                              WHERE u.dep_id = ?
                              ORDER BY u.u_id DESC
                              ";
                            $result = dbQuery($sql, "i", [(int) $dep_id]);
                            break;
                        case 4:
                            echo 'ไม่มีสิทธิ์ใช้งานเมนูนี้';
                            break;
                    }

                    if ($result) {
                        while ($row = dbFetchArray($result)) {
                            ?>
                            <tr>
                                <td><?php echo $count; ?></td>
                                <td><?php echo htmlspecialchars($row['firstname']); ?></td>
                                <td><?php echo htmlspecialchars($row['lastname']); ?></td>
                                <td><?php echo htmlspecialchars($row['u_name']); ?></td>
                                <td><?php echo htmlspecialchars($row['level_name']); ?></td>
                                <td><?php echo htmlspecialchars($row['sec_name']); ?></td>
                                <td><?php echo htmlspecialchars($row['dep_name']); ?></td>

                                <td><?php
                                $status = $row['status'];
                                if ($status == 1) {
                                    echo '<center><i class="fa fa-check"</i></p></center>';
                                } else {
                                    echo '<center><i class="fa fa-close"></i></p></center>';
                                } ?></td>

                                <td>
                                    <a class="btn btn-warning" href="#" 
                                       onclick="loadEditModal(<?php echo $row['u_id']; ?>); return false;">
                                       <i class="fas fa-edit" aria-hidden="true"></i> แก้ไข
                                    </a>
                                </td>
                            </tr>
                            <?php ++$count;
                        }
                    } ?>
                </tbody>
            </table>

        </div>
        <div class="well alert-info">
            คำอธิบาย: <i class="fa fa-check"></i> อนุญาตใช้งาน
            <i class="fa fa-close"></i> ระงับการใช้งาน
        </div>





        <!-- Model -->
        <!-- เพิ่มผู้ใช้ -->
        <div id="modalAdd" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title "><i class="fa fa-user-plus"></i> เพิ่มผู้ใช้งาน</h4>
                    </div>
                    <div class="modal-body modal-body-soft">
                        <form name="form" method="post">
                            <?php echo csrf_field(); ?>
                            
                            <h5 class="text-primary"><i class="fa fa-building"></i> ข้อมูลหน่วยงาน</h5>
                            <hr class="mt-0 mb-3">
                            <div class="row">
                                <?php if ($level_id <= 2) { ?>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="province">ประเภทส่วนราชการ</label>
                                        <select name="province" class="form-control" onchange="dochange('amphur', this.value)" required>
                                            <option value="">- เลือกประเภท -</option>
                                            <?php 
                                            $sql_type = "SELECT * FROM office_type";
                                            $result_type = dbQuery($sql_type);
                                            while ($row_type = dbFetchArray($result_type)) {
                                                echo "<option value='{$row_type['type_id']}'>{$row_type['type_name']}</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="amphur">ชื่อส่วนราชการ</label>
                                        <span id="amphur">
                                            <select class="form-control" disabled><option>- รอการเลือก -</option></select>
                                        </span>
                                    </div>
                                </div>
                                <?php } ?>
                                
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="district">หน่วยงานย่อย</label>
                                        <span id="district">
                                            <select name="sec_id" class="form-control" required>
                                                <option value=''>- เลือกกลุ่มงาน -</option>
                                                <?php
                                                if ($level_id > 2) {
                                                    $sql = "SELECT * FROM section WHERE dep_id = ?";
                                                    $result = dbQuery($sql, "i", [(int) $dep_id]);
                                                    while ($rowSec = dbFetchArray($result)) {
                                                        echo "<option value='{$rowSec['sec_id']}'>{$rowSec['sec_name']}</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                     <h5 class="text-primary mt-3"><i class="fa fa-id-card"></i> ข้อมูลส่วนตัว</h5>
                                     <hr class="mt-0 mb-3">
                                     <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>ชื่อ</label>
                                                <input class="form-control" type="text" name="firstname" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                             <div class="form-group">
                                                <label>นามสกุล</label>
                                                <input class="form-control" type="text" name="lastname" required>
                                            </div>
                                        </div>
                                     </div>
                                     <div class="form-group">
                                        <label>ตำแหน่ง</label>
                                        <input class="form-control" type="text" name="position">
                                    </div>
                                    <div class="form-group">
                                        <label>อีเมล</label>
                                        <input class="form-control" type="email" name="email" required>
                                    </div>
                                    <div class="form-group">
                                        <label>เบอร์โทรศัพท์</label>
                                        <input class="form-control" type="text" name="telphone" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h5 class="text-primary mt-3"><i class="fa fa-lock"></i> ข้อมูลบัญชี</h5>
                                     <hr class="mt-0 mb-3">
                                     <div class="form-group">
                                        <label>ชื่อผู้ใช้</label>
                                        <input class="form-control" type="text" name="u_name" required>
                                    </div>
                                     <div class="form-group">
                                        <label>รหัสผ่าน</label>
                                        <input class="form-control" type="password" name="u_pass" required>
                                    </div>
                                    <div class="form-group">
                                        <label>สิทธิ์การใช้งาน</label>
                                        <select name="level" class="form-control"> 
                                            <?php if ($level_id <= 2) { ?>
                                            <option value="1">ผู้ดูแลระบบ</option>
                                            <option value="2">สารบรรณกลาง</option>
                                            <?php } ?>
                                            <option value="3">สารบรรณประจำหน่วยงาน</option>
                                            <option value="4">สารบรรณประจำกลุ่ม/กอง</option>
                                            <option value="5" selected>ผู้ใช้ทั่วไป</option>
                                        </select>
                                    </div>
                                     <div class="form-group">
                                        <label>สถานะ</label>
                                        <div class="radio">
                                            <label class="radio-inline"><input type="radio" name="status" value="1" checked> อนุญาต</label>
                                            <label class="radio-inline"><input type="radio" name="status" value="0"> ระงับ</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <input type="hidden" name="date_user" value="<?php echo date('Y-m-d'); ?>">

                            <center>
                                <button class="btn btn-success btn-lg mt-3" type="submit" name="save">
                                    <i class="fa fa-save"></i> บันทึกข้อมูล
                                    <input id="u_id" name="u_id" type="hidden" value="<?php echo $u_id; ?>">
                                </button>
                            </center>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Model -->

        <!-- Modal Edit -->
        <div id="modalEdit" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header bg-warning">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"><i class="fa fa-user-edit"></i> แก้ไขผู้ใช้งาน</h4>
                    </div>
                    <div class="modal-body" id="modalEditBody">
                        <div class="text-center">
                            <i class="fa fa-spinner fa-spin fa-3x"></i><br>กำลังโหลดข้อมูล...
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Modal Edit -->



    </div>
</div>

<?php
if (isset($_POST['save'])) {
    if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
        die("CSRF token validation failed.");
    }
    if ($level_id <= 2) {  //กรณีเป็นผู้ดูแลระบบ เอาค่า จากส่วนนี้
        $type_id = $_POST['province'];  //ประเภทส่วนราชการ
        $dep_id = $_POST['amphur'];     //รหัสหน่วยงาน
        $sec_id = $_POST['district'];   //รหัสกลุ่มงานย่อย
    }

    $level_id = $_POST['level'];
    $u_name = $_POST['u_name'];
    $u_pass_plain = $_POST['u_pass'];
    // เข้ารหัสผ่านด้วย password_hash() โดยใช้ BCRYPT
    $u_pass_hashed = password_hash($u_pass_plain, PASSWORD_BCRYPT);
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $position = $_POST['position'];
    $date_create = $_POST['date_user'];
    $status = $_POST['status'];
    $email = $_POST['email'];
    $telphone = $_POST['telphone'];

    // print $sql;
    // เช็คชื่อผู้ใช้ซ้ำ (ใช้ Prepared Statements)
    $sql = "SELECT * FROM user WHERE u_name = ?";
    $result = dbQuery($sql, "s", [$u_name]);
    $numrow = dbNumRows($result);
    if ($numrow == 1) {
        echo "<script>
               swal({
                title:'Username ซ้ำ!..กรุณาเปลี่ยนชื่อใหม่',
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
        $sql = "INSERT INTO user(sec_id, dep_id, level_id, u_name, u_pass, firstname, lastname, position, date_create, status, email, telphone)
                   VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $result = dbQuery($sql, "iiisssssisss", [
            (int) $sec_id,
            (int) $dep_id,
            (int) $level_id,
            $u_name,
            $u_pass_hashed,
            $firstname,
            $lastname,
            $position,
            $date_create,
            (int) $status,
            $email,
            $telphone
        ]);
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
    $sql = 'DELETE FROM user WHERE u_id = ?';
    $result = dbQuery($sql, "i", [(int) $_GET['del']]);
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
    $sql = 'SELECT * FROM user WHERE u_id = ?';
    $result = dbQuery($sql, "i", [(int) $_GET['edit']]);
    $getROW = dbFetchArray($result);
    //echo "<meta http-equiv='refresh' content='1;URL=object.php'>";
}

if (isset($_POST['update'])) {
    $sql = "UPDATE depart 
            SET type_id = ?, 
                dep_name = ?, 
                address = ?, 
                phone = ?, 
                fax = ?, 
                social = ?, 
                status = ?, 
                local_num = ? 
            WHERE dep_id = ?";
    $result = dbQuery($sql, "isssssiii", [
        (int) $_POST['officeType'],
        $_POST['dep_name'],
        $_POST['address'],
        $_POST['tel'],
        $_POST['fax'],
        $_POST['website'],
        (int) $_POST['status'],
        (int) $_POST['local_num'],
        (int) $_GET['edit']
    ]);
    if ($result) {
        echo '<script>swal("Good job!", "แก้ไขข้อมูลแล้ว!", "success")</script>';
        echo "<meta http-equiv='refresh' content='1;URL=user.php'>";
    }
}
?>
<script>
    $(document).ready(function () {
        // เรียกใช้ DataTables บนตารางที่มี id="myTable"
        $('#myTable').DataTable();
    });

    function loadEditModal(u_id) {
        // Open Modal
        $('#modalEdit').modal('show');
        
        // Load Content
        $.ajax({
            url: "user_model_edit.php",
            type: "GET",
            data: { edit: u_id },
            success: function (data) {
                $('#modalEditBody').html(data);
                // Initialize stuff if needed inside the modal (e.g. selectpicker)
                // user_model_edit.php should handle its own inline scripts or we do it here
            },
            error: function () {
                $('#modalEditBody').html('<div class="alert alert-danger">Error loading data</div>');
            }
        });
    }
</script>
<script language=Javascript>   //ส่วนการทำ dropdown
    function Inint_AJAX() {
        try { return new ActiveXObject("Msxml2.XMLHTTP"); } catch (e) { } //IE
        try { return new ActiveXObject("Microsoft.XMLHTTP"); } catch (e) { } //IE
        try { return new XMLHttpRequest(); } catch (e) { } //Native Javascript
        alert("XMLHttpRequest not supported");
        return null;
    };

    function dochange(src, val) {
        var req = Inint_AJAX();
        req.onreadystatechange = function () {
            if (req.readyState == 4) {
                if (req.status == 200) {
                    document.getElementById(src).innerHTML = req.responseText; //รับค่ากลับมา
                    $('.selectpicker').selectpicker('refresh');
                }
            }
        };
        req.open("GET", "localtion.php?data=" + src + "&val=" + val); //สร้าง connection
        req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;charset=utf-8"); // set Header
        req.send(null); //ส่งค่า
    }



    // In your Javascript (external .js resource or <script> tag)

</script>