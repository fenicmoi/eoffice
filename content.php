<!-- <link rel="stylesheet" href="css/note.css"> -->
<div class="row">
    <div class="col-md-12">
        <div id="myCarousel" class="carousel slide" data-ride="carousel">
            <!-- Indicators -->
            <ol class="carousel-indicators">
                <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                <li data-target="#myCarousel" data-slide-to="1"></li>
            </ol>
            <!-- Wrapper for slides -->
            <div class="carousel-inner">
                <div class="item active">
                    <img height="400" src="images/newbanner2.png" alt="Los Angeles">
                </div>
                <!-- <div class="item">
                <img src="images/office3.jpg" alt="Chicago">
                </div> -->
            </div>
            <!-- Left and right controls -->
            <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#myCarousel" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-2">
        <div class="bg-primary text-center rounded p-3 shadow">
            <a href="#" data-toggle="modal" data-target="#modelRule" class="text-white">
                <i class="far fa-handshake fa-4x mb-2"></i>
                <h5>ข้อตกลงการใช้งาน</h5>
            </a>
        </div>
    </div>
    <div class="col-md-2">
        <div class="bg-success text-center rounded p-3 shadow">
            <a href="list_user.php" class="text-white">
                <i class="fab fa-earlybirds fa-4x mb-2"></i>
                <h5>รายชื่อหน่วยงาน</h5>
            </a>
        </div>
    </div>
    <div class="col-md-2">
        <div class="bg-warning text-center rounded p-3 shadow">
            <a data-toggle="modal" data-target="#modalAdd" class="text-white">
                <i class="fab fa-fort-awesome fa-4x mb-2"></i>
                <h5>ลงทะเบียนหน่วยงาน</h5>
            </a>
        </div>
    </div>
    <div class="col-md-2">
        <div class="bg-info text-center rounded p-3 shadow">
            <a href="https://www.phone.phatthalung.go.th/" target="_blank" class="text-white">
                <i class="fas fa-map-signs fa-4x mb-2"></i>
                <h5>สมุดโทรศัพท์จังหวัด</h5>
            </a>
        </div>
    </div>
    <div class="col-md-2">
        <div class="bg-info text-center rounded p-3 shadow">
            <a href="manual.pdf" target="_blank" class="text-white">
                <i class="fas fa-map-signs fa-4x mb-2"></i>
                <h5>คู่มือผู้ใช้</h5>
            </a>
        </div>
    </div>
    <div class="col-md-2">
        <div class="bg-info text-center rounded p-3 shadow">
            <a href="manual.pdf" target="_blank" class="text-white">
                <i class="fas fa-map-signs fa-4x mb-2"></i>
                <h5>จองห้องประชุม</h5>
            </a>
        </div>
    </div>
</div>


<!-- Model  -->
<?php
//Display office type
$sql = "SELECT * FROM office_type";
$query = dbQuery($sql);
?>

<div id="modalRegister" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title "><i class="fa fa-user fa-2x"></i> ลงทะเบียนผู้ใช้งานทั่วไป</h4>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning">
                    <i class="fas fa-bomb fa-2x"></i>
                    <h4>หลังจากลงทะเบียนแล้ว ให้ติดต่อ Admin ประจำหน่วยงานของท่าน</h4>
                </div>
                <form name="form" method="post">
                    <div class="form-group form-inline">
                        <label for="offict_type">ประเภทหน่วยงาน : </label>
                        <select name="office_type" id="office_type">
                            <option value="">เลือก</option>
                            <?php while ($result = dbFetchAssoc($query)): ?>
                                <option value="<?php echo $result['type_id'] ?>"><?php echo $result['type_name'] ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="depart">ชื่อหน่วยงาน</label>
                        <select name="depart" id="depart" class="form-control">
                            <option value="">เลือกหน่วยงาน</option>
                        </select>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="section">เลือกกลุ่มงาน</label>
                        <select name="section" id="section" class="form-control">
                            <option value="">เลือกกลุ่มงาน</option>
                        </select>
                    </div>

                    <div class="form-group col-sm-6">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fas fa-star"></i></span>
                            <input class="form-control" type="text" name="firstname" id="firstname"
                                placeholder="ชื่อ (ไม่ต้องมีคำนำหน้า)" required="">
                        </div>
                    </div>
                    <div class="form-group col-sm-6">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fas fa-star"></i></span>
                            <input class="form-control" type="text" name="lastname" id="lastname" placeholder="นามสกุล"
                                required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fab fa-black-tie"></i></span>
                            <input class="form-control" type="text" name="position" id="position" placeholder="ตำแหน่ง"
                                required>
                        </div>
                    </div>
                    <div class="form-group col-sm-6">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fas fa-user-secret"></i></span>
                            <input class="form-control" type="text" name="u_name" id="u_name" required
                                placeholder="ระบุชื่อผู้ใช้ (อังกฤษ+ตัวเลข">
                        </div>
                    </div>
                    <div class="form-group col-sm-6">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fas fa-key"></i></span>
                            <input class="form-control" type="text" name="u_pass" id="u_pass" required
                                placeholder="ระบุรหัสผ่าน (อังกฤษ+ตัวเลข)">
                        </div>
                    </div>
                    <div class="form-group col-sm-6">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fas fa-envelope-square"></i></span>
                            <input class="form-control" type="email" name="email" id="email"
                                placeholder="อีเมลล์ที่เป็นทางการของหน่วยงาน" required>
                        </div>
                    </div>
                    <div class="form-group col-sm-6">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="far fa-calendar-alt"></i></span>
                            <input class="form-control" type="text" name="date_user" id="date_user"
                                value="<?php echo date('Y-m-d'); ?>">
                        </div>
                    </div>
                    <center>
                        <button class="btn btn-success btn-lg" type="submit" name="save">
                            <i class="fa fa-database fa-2x"></i> บันทึก
                        </button>
                    </center>
                </form>
            </div>
            <div class="modal-footer bg-primary">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i></button>
            </div>
        </div>
    </div>
</div>
<!-- End Model -->
<?php
if (isset($_POST['save'])) {

    // ใช้ชื่อฟิลด์จากฟอร์มจริง (office_type, depart, section)
    $type_id = $_POST['office_type'] ?? '';
    $dep_id = $_POST['depart'] ?? '';
    $sec_id = $_POST['section'] ?? '';
    $level_id = 5;
    $u_name = $_POST['u_name'] ?? '';
    $u_pass_plain = $_POST['u_pass'] ?? '';
    // เข้ารหัสผ่าน
    $u_pass_hashed = password_hash($u_pass_plain, PASSWORD_BCRYPT);

    $firstname = $_POST['firstname'] ?? '';
    $lastname = $_POST['lastname'] ?? '';
    $position = $_POST['position'] ?? '';
    $date_create = $_POST['date_user'] ?? date('Y-m-d');
    $email = $_POST['email'] ?? '';

    // ตรวจสอบชื่อผู้ใช้ซ้ำ (ใช้ Prepared Statements)
    $sql = "SELECT u_name FROM user WHERE u_name = ?";
    $result = dbQuery($sql, "s", [$u_name]);
    $numrow = dbNumRows($result);
    if ($numrow >= 1) {
        echo "<script>
               swal({
                title:'ไม่สามารถใช้ชื่อนี้ได้!..กรุณาเปลี่ยนใหม่นะครับ',
                type:'error',
                showConfirmButton:true
                },
                function(isConfirm){
                    if(isConfirm){
                        window.location.href='index.php';
                    }
                }); 
              </script>";
    } elseif ($numrow < 1) {
        $sql = "INSERT INTO user(sec_id, dep_id, level_id, u_name, u_pass, firstname, lastname, position, date_create, status, email)
                   VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 0, ?)";

        $result = dbQuery($sql, "iiisssssss", [
            (int) $sec_id,
            (int) $dep_id,
            (int) $level_id,
            $u_name,
            $u_pass_hashed,
            $firstname,
            $lastname,
            $position,
            $date_create,
            $email
        ]);
        if (!$result) {
            echo "<script>
            swal({
             title:'มีบางอย่างผิดพลาด',
             text: 'กรุณาตรวจสอบข้อมูลก่อนส่งอีกครั้ง!',
             type:'warning',
             showConfirmButton:true
             },
             function(isConfirm){
                 if(isConfirm){
                     window.location.href='index.php';
                 }
             }); 
           </script>";
        } else {
            echo "<script>
            swal({
             title:'ลงทะเบียนเรียบร้อยแล้ว',
              text: 'กรุณาติดต่อเจ้าหน้าที่สารบรรณประจำหน่วยงานเพื่อเปิดการใช้งาน',
             type:'success',
             showConfirmButton:true
             },
             function(isConfirm){
                 if(isConfirm){
                     window.location.href='index.php';
                 }
             }); 
           </script>";
        }
    }
    // 	user duplicate
}
//send
?>

<script type='text/javascript'>
    $('#tableCheck').DataTable({
        "order": [[0, "desc"]]
    }
    )
</script>