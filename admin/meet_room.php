<?php
include "header.php";
$yid = chkYearMonth();
$u_id = $_SESSION['ses_u_id'];

// --- ป้องกัน SQL Injection ด้วยการ cast เป็น int ---
$level_id = isset($level_id) ? (int)$level_id : 0;
$dep_id = isset($dep_id) ? (int)$dep_id : 0;
?>
<div class="row">
    <div class="col-md-2">
        <?php
        $menu = checkMenu($level_id);
        include $menu;
        ?>
    </div>
    <div class="col-md-10">
        <div class="panel panel-primary shadow" style="margin: 20px; border-radius: 12px;">
            <div class="panel-heading" style="border-radius: 12px 12px 0 0; background: linear-gradient(90deg, #2980b9 0%, #6dd5fa 100%); color: #fff;">
                <i class="fas fa-book-reader fa-2x" aria-hidden="true"></i>
                <strong style="font-size:1.3em;">จัดการห้องประชุม</strong>
                <a href="#" class="btn btn-success pull-right" data-toggle="modal" data-target="#modalAdd" style="border-radius: 20px;">
                    <i class="fa fa-plus" aria-hidden="true"></i> เพิ่มห้องประชุม
                </a>
            </div>
            <div class="panel-body" style="background: #f7fafd;">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" style="background: #fff; border-radius: 8px;">
                        <thead class="bg-info" style="background: #2980b9; color: #fff;">
                            <tr style="font-size:1.08em;">
                                <th>ชื่อห้อง</th>
                                <th>สถานะ</th>
                                <th>ที่อยู่</th>
                                <th>ความจุ</th>
                                <th>ราคาเต็มวัน</th>
                                <th>ราคาครึ่งวัน</th>
                                <th>รายละเอียด</th>
                                <th>แก้ไข</th>
                                <th>ลบ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($level_id == 1) {
                                $sql = "SELECT * FROM meeting_room ORDER BY room_id DESC";
                            } else {
                                $sql = "SELECT * FROM meeting_room WHERE dep_id = $dep_id";
                            }
                            $result = dbQuery($sql);
                            while ($row = dbFetchArray($result)) {
                                $room_id = (int)$row['room_id'];
                                ?>
                                <tr>
                                    <td style="vertical-align:middle;"><?= htmlspecialchars($row['roomname']); ?></td>
                                    <td style="vertical-align:middle;">
                                        <?php
                                        if ($row['room_status'] == 0) {
                                            echo "<span class='label label-danger'><i class='fas fa-window-close'></i> ระงับการใช้</span>";
                                        } elseif ($row['room_status'] == 1) {
                                            echo "<span class='label label-success'><i class='fas fa-laptop'></i> จองผ่านระบบ</span>";
                                        } else {
                                            echo "<span class='label label-warning'><i class='fas fa-book-open'></i> จองผ่านสมุด</span>";
                                        }
                                        ?>
                                    </td>
                                    <td style="vertical-align:middle;"><?= htmlspecialchars($row['roomplace']); ?></td>
                                    <td style="vertical-align:middle;"><?= (int)$row['roomcount']; ?></td>
                                    <td style="vertical-align:middle;"><?= htmlspecialchars($row['money1']); ?> บาท</td>
                                    <td style="vertical-align:middle;"><?= htmlspecialchars($row['money2']); ?> บาท</td>
                                    <td style="vertical-align:middle;">
                                        <a class="btn btn-info btn-sm" href="#"
                                           onClick="loadData('<?php echo $room_id; ?>','<?php echo $u_id; ?>');"
                                           data-toggle="modal" data-target=".bs-example-modal-table" title="ดูรายละเอียด">
                                            <i class="fas fa-info-circle"></i>
                                        </a>
                                    </td>
                                    <td style="vertical-align:middle;">
                                        <a class="btn btn-warning btn-sm" href="#"
                                           onClick="editData('<?php echo $room_id; ?>','<?php echo $u_id; ?>');"
                                           data-toggle="modal" data-target=".bs-edit-modal-table" title="แก้ไข">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </td>
                                    <td style="vertical-align:middle;">
                                        <a class="btn btn-danger btn-sm" href="?del=<?php echo $room_id; ?>"
                                           onclick="return confirm('คุณกำลังจะลบห้องประชุม !');" title="ลบ">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="panel-footer" style="border-radius: 0 0 12px 12px; background: #eaf6fb;"></div>
        </div>

        <!-- Model -->
        <div id="modalAdd" class="modal fade" role="dialog">
          <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><i class="fa fa-list"></i> เพิ่มห้องประชุม</h4>
              </div>
              <div class="modal-body">
                  <form method="post" action="meet_room.php" enctype="multipart/form-data">
                      <label for="">วันที่ทำรายการ: <?php echo DateThai();?></label>
                    <div class="form-group">
                      <div class="input-group">
                          <span class="input-group-addon"><span class="glyphicon glyphicon-list"></span></span>
                          <input type="text" class="form-control" id="roomname" name="roomname"  placeholder="ชื่อห้องประชุม"  required="">
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="input-group">
                          <span class="input-group-addon"><span class="	glyphicon glyphicon-map-marker"></span></span>
                          <input type="text" class="form-control" id="place" name="place"  placeholder="สถานที่"  required="">
                      </div>
                    </div>
                     <div class="form-group">
                      <div class="input-group">
                          <span class="input-group-addon"><span class="	glyphicon glyphicon-user"></span></span>
                          <input type="text" class="form-control" id="capacity" name="capacity"  placeholder="ความจุผู้เข้าประชุม"  required="">
                      </div>
                    </div>
                     <div class="form-group">
                      <div class="input-group col-xs-6">
                          <span class="input-group-addon"><span class="	glyphicon glyphicon-usd"></span></span>
                          <input type="text" class="form-control" id="money1" name="money1"  placeholder="ค่าธรรมเนียมเต็มวัน"  required="">
                          <span class="input-group-addon">บาท</span></span>
                      </div>
                    </div>
                     <div class="form-group">
                      <div class="input-group col-xs-6">
                          <span class="input-group-addon"><span class="	glyphicon glyphicon-usd"></span></span>
                          <input type="text" class="form-control" id="money2" name="money2"  placeholder="ค่าธรรมเนียมครึ่งวัน"  required="">
                          <span class="input-group-addon">บาท</span></span>
                      </div>
                    </div>
                     <div class="form-group">
                      <div class="input-group col-xs-6">
                          <span class="input-group-addon"><span class="	glyphicon glyphicon-phone"></span></span>
                          <input type="text" class="form-control" id="tel" name="tel"  placeholder="เบอร์โทร"  required="">
                      </div>
                    </div>
                    <div class="form-group">
                      <h5><i class="fas fa-volume-up"></i> อุปกรณ์อำนวยความสะดวก</h5>
                      <div class="checkbox">
                            <div class="checkbox"><label><input type="checkbox" id="t1" name="t1" value="1">ระบบเสียง</label></div>
                            <div class="checkbox"><label><input type="checkbox" id="t2" name="t2" value="1">ระบบแสดงผล</label></div>
                            <div class="checkbox"><label><input type="checkbox" id="t3" name="t3" value="1">ระบบประชุมวีดีทัศน์ทางไกล</label></div>
                      </div>
                    </div>
                    <div class="form-group">
                        <label>รูปห้องประชุม</label>
                        <input class="form-control" type="file" name="fileUpload">
                    </div>
                    <?php 
                        $sql="SELECT * FROM depart WHERE dep_id=$dep_id";
                        $result=dbQuery($sql);
                        $row=dbFetchArray($result);
                    ?>
                        <center>
                            <button class=" btn btn-success btn-lg" type="submit" name="save">
                                <i class="fas fa-save fa-2x"></i> บันทึก
                            </button>
                        </center>                                                         
                  </form>
              </div>
              <div class="modal-footer bg-primary">
                <button type="button" class="btn btn-danger" data-dismiss="modal">ปิด X</button>
              </div>
            </div>
          </div>
        </div>
        <!-- End Model -->   
    </div>
</div>  
<!--  modal แสงรายละเอียดข้อมูล -->
        <div  class="modal fade bs-example-modal-table" tabindex="-1" aria-hidden="true" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"><i class="fa fa-info"></i> รายละเอียด</h4>
                    </div>
                    <div class="modal-body no-padding">
                        <div id="divDataview"></div>     
                    </div> <!-- modal-body -->
                    <div class="modal-footer bg-primary">
                         <button type="button" class="btn btn-danger" data-dismiss="modal">ปิด X</button>
                    </div>
                </div>
            </div>
        </div>
<!-- จบส่วนแสดงรายละเอียดข้อมูล  -->

    <!--  modal แก้ไขข้อมูล-->
        <div  class="modal fade bs-edit-modal-table" tabindex="-1" aria-hidden="true" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"><i class="fa fa-info"></i> แก้ไขข้อมูล</h4>
                    </div>
                    <div class="modal-body no-padding">
                        <div id="divEditview"></div>     
                    </div> <!-- modal-body -->
                    <div class="modal-footer bg-primary">
                         <button type="button" class="btn btn-danger" data-dismiss="modal">ปิด X</button>
                    </div>
                </div>
            </div>
        </div>
<!-- จบส่วนแก้ไข  -->


<?php
// --- ส่วนประมวลผล ---

// เพิ่มห้องประชุม
if (isset($_POST['save'])) {
    $roomname = htmlspecialchars(trim($_POST['roomname']));
    $roomplace = htmlspecialchars(trim($_POST['place']));
    $roomcount = (int)$_POST['capacity'];
    $money1 = (float)$_POST['money1'];
    $money2 = (float)$_POST['money2'];
    $tel = htmlspecialchars(trim($_POST['tel']));
    //$dep_id = $_POST['dep_id'];
    $t1 = isset($_POST['t1']) ? 1 : 0;
    $t2 = isset($_POST['t2']) ? 1 : 0;
    $t3 = isset($_POST['t3']) ? 1 : 0;
    $roomimg = "";

    // ตรวจสอบไฟล์อัปโหลด
    if (isset($_FILES["fileUpload"]["tmp_name"]) && is_uploaded_file($_FILES["fileUpload"]["tmp_name"])) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $ext = strtolower(pathinfo($_FILES["fileUpload"]["name"], PATHINFO_EXTENSION));
        if (in_array($ext, $allowed) && $_FILES["fileUpload"]["size"] <= 2*1024*1024) {
            $roomimg = basename($_FILES["fileUpload"]["name"]);
            move_uploaded_file($_FILES["fileUpload"]["tmp_name"], "doc/" . $roomimg);
        }
    }

    $sql = "INSERT INTO meeting_room(roomname,roomplace,roomcount,roomimg,tel,room_status,money1,money2,sound,vga,vcs)
            VALUES('$roomname','$roomplace',$roomcount,'$roomimg','$tel',1,$money1,$money2,$t1,$t2,$t3)";
    print $sql;
    $result = dbQuery($sql);
    if ($result) {
        dbQuery("COMMIT");
        echo "<script>
        swal({
            title:'เรียบร้อย',
            type:'success',
            showConfirmButton:true
            },
            function(isConfirm){
                if(isConfirm){
                    window.location.href='meet_room.php';
                }
            }); 
        </script>";
    } else {
        
        dbQuery("ROLLBACK");
        /*
        echo "<script>
        swal({
            title:'มีบางอย่างผิดพลาด! กรุณาตรวจสอบ',
            type:'error',
            showConfirmButton:true
            },
            function(isConfirm){
                if(isConfirm){
                    window.location.href='meet_room.php';
                }
            }); 
            
        </script>";*/
    }
}

// ลบห้องประชุม (ตรวจสอบสิทธิ์)
if (isset($_GET['del'])) {
    $del_id = (int)$_GET['del'];
    if ($level_id == 1 || dbNumRows(dbQuery("SELECT room_id FROM meeting_room WHERE room_id=$del_id AND dep_id=$dep_id")) > 0) {
        $sql = "DELETE FROM meeting_room WHERE room_id=$del_id";
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
                     window.location.href='meet_room.php';
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
                     window.location.href='meet_room.php';
                 }
             }); 
           </script>";
        }
    } else {
        echo "<script>
        swal({
         title:'คุณไม่มีสิทธิ์ลบห้องนี้',
         type:'error',
         showConfirmButton:true
         },
         function(isConfirm){
             if(isConfirm){
                 window.location.href='meet_room.php';
             }
         }); 
       </script>";
    }
}

// แก้ไขข้อมูล
if (isset($_POST['edit'])) {
    $room_id = (int)$_POST['room_id'];
    $roomname = htmlspecialchars(trim($_POST['roomname']));
    $roomplace = htmlspecialchars(trim($_POST['roomplace']));
    $roomcount = (int)$_POST['roomcount'];
    $money1 = (float)$_POST['money1'];
    $money2 = (float)$_POST['money2'];
    $tel = htmlspecialchars(trim($_POST['tel']));
    $t1 = isset($_POST['t1']) ? 1 : 0;
    $t2 = isset($_POST['t2']) ? 1 : 0;
    $t3 = isset($_POST['t3']) ? 1 : 0;
    $room_status = (int)$_POST['room_status'];
    $roomimg = "";

    if (isset($_FILES["fileUpload"]["tmp_name"]) && is_uploaded_file($_FILES["fileUpload"]["tmp_name"])) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $ext = strtolower(pathinfo($_FILES["fileUpload"]["name"], PATHINFO_EXTENSION));
        if (in_array($ext, $allowed) && $_FILES["fileUpload"]["size"] <= 2*1024*1024) {
            $roomimg = basename($_FILES["fileUpload"]["name"]);
            move_uploaded_file($_FILES["fileUpload"]["tmp_name"], "doc/" . $roomimg);
            $sql = "UPDATE meeting_room 
                    SET roomname='$roomname',roomplace='$roomplace',roomcount=$roomcount,roomimg='$roomimg',tel='$tel',room_status=$room_status,
                        money1=$money1,money2=$money2,sound=$t1,vga=$t2,vcs=$t3
                    WHERE room_id=$room_id";
        }
    } else {
        $sql = "UPDATE meeting_room 
                SET roomname='$roomname',roomplace='$roomplace',roomcount=$roomcount,tel='$tel',room_status=$room_status,
                    money1=$money1,money2=$money2,sound=$t1,vga=$t2,vcs=$t3
                WHERE room_id=$room_id";
    }
    $result = dbQuery($sql);
    if ($result) {
        echo "<script>
        swal({
            title:'เรียบร้อย',
            type:'success',
            showConfirmButton:true
            },
            function(isConfirm){
                if(isConfirm){
                    window.location.href='meet_room.php';
                }
            }); 
        </script>";
    } else {
        echo "<script>
        swal({
            title:'มีบางอย่างผิดพลาด! กรุณาตรวจสอบ',
            type:'error',
            showConfirmButton:true
            },
            function(isConfirm){
                if(isConfirm){
                    window.location.href='meet_room.php';
                }
            }); 
        </script>";
    }
}
?>

<script type="text/javascript">
function loadData(room_id, u_id) {
    var sdata = {
        room_id: room_id,
        u_id: u_id
    };
    $('#divDataview').load('show_meeting_detail.php', sdata);
}

function editData(room_id, u_id) {
    var edata = {
        room_id: room_id,
        u_id: u_id
    };
    $('#divEditview').load('show_meeting_edit.php', edata);
}
</script>

<style>
/* เพิ่มเงาและความโค้งมนให้ panel และปุ่ม */
.panel-primary.shadow {
    box-shadow: 0 4px 18px rgba(44, 62, 80, 0.13);
}
.btn-success, .btn-info, .btn-warning, .btn-danger {
    border-radius: 20px;
}
.table > thead > tr > th, .table > tbody > tr > td {
    text-align: center;
    vertical-align: middle !important;
}
@media (max-width: 767px) {
    .panel-body, .table-responsive {
        padding: 0 !important;
    }
    .table {
        font-size: 0.95em;
    }
    .btn {
        margin-bottom: 5px;
    }
}
</style>
