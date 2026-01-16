<!-- แก้ไขหนังสือรับถึงจังหวัด -->
<?php
include "header.php";
$u_id = $_SESSION['ses_u_id'];
$level_id = $_SESSION['ses_level_id'];

// รับค่ามาจาก javascript from flow-resive-province
$book_id = $_GET['book_id'];

$sql = "SELECT  bookm.book_id,bookm.rec_id,bookm.typeDoc,bookd.*,
               o.obj_id,o.obj_name,
               spe.speed_id,spe.speed_name,
               p.pri_id,p.pri_name,
               u.firstname, u.lastname, 
               s.sec_id,s.sec_name,
               dep.dep_name,
               year.yname,
               dep.prefex
       FROM  book_master  bookm
       INNER JOIN book_detail bookd ON bookd.book_id = bookm.book_id
       INNER JOIN user u ON  u.u_id = bookm.u_id
       INNER JOIN section s ON s.sec_id = bookm.sec_id
       INNER JOIN object o ON o.obj_id = bookm.obj_id
       INNER JOIN speed spe ON spe.speed_id=bookm.speed_id
       INNER JOIN depart dep ON dep.dep_id = bookm.dep_id
       INNER JOIN sys_year year ON year.yid = bookm.yid
       INNER JOIN priority p ON p.pri_id = bookm.pri_id
       WHERE bookm.book_id =$book_id ";
//print $sql;
$result = dbQuery($sql);
$row = dbFetchArray($result);
$strDate = $row['date_in'];
$dateThai = DateThai($strDate);
$rec_id = $row['rec_id'];
$yname = $row['yname'];
$book_detail_id = $row['book_detail_id'];
$file_upload = $row['file_upload'];
?>

<style>
    /* Custom soft styling for the edit page */
    .edit-body-soft {
        background-color: #f0f4f8 !important; /* Soft steel blue/gray */
        padding: 30px !important;
        border-radius: 0 0 10px 10px;
    }

    .panel-primary-modern {
        border: none;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        border-radius: 10px;
    }

    .panel-primary-modern > .panel-heading {
        background-color: #4e73df !important;
        border-color: #4e73df !important;
        color: white;
        border-radius: 10px 10px 0 0;
        padding: 15px 20px;
    }

    .input-group-addon {
        background-color: #eaecf4;
        border: 1px solid #d1d3e2;
        color: #4e73df;
        font-weight: 600;
        min-width: 120px;
        text-align: left;
    }

    .form-control {
        border: 1px solid #d1d3e2;
        border-radius: 4px;
        transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
    }

    .form-control:focus {
        border-color: #bac8f3;
        box-shadow: 0 0 0 0.2rem rgba(78,115,223,.25);
    }

    .form-group label {
        font-weight: 600;
        color: #4e73df;
        margin-bottom: 8px;
    }

    .well.bg-warning-soft {
        background-color: #fff9e6;
        border: 1px border-style: dashed; border-color: #ffeeba;
        border-radius: 8px;
    }
    
    .btn-lg-modern {
        padding: 10px 30px;
        font-weight: 600;
        border-radius: 30px;
        transition: all 0.3s;
    }
    
    .btn-warning-modern {
        background-color: #f6c23e;
        border-color: #f6c23e;
        color: #fff;
    }
    
    .btn-warning-modern:hover {
        background-color: #f4b619;
        transform: translateY(-2px);
    }

    .btn-danger-modern {
        background-color: #e74a3b;
        border-color: #e74a3b;
        color: #fff;
    }
    
    .btn-danger-modern:hover {
        background-color: #be2617;
        transform: translateY(-2px);
    }
</style>

<div class="col-md-2">
    <?php
    $menu = checkMenu($level_id);
    include $menu;
    ?>
</div>
<div class="col-md-10">
    <div class="panel panel-primary-modern">
        <div class="panel-heading">
            <i class="fa fa-edit fa-2x"></i> <strong>แก้ไขหนังสือรับ [ถึงจังหวัด]</strong>
            <a href="flow-resive-province.php" class="btn btn-info pull-right"><i class="fas fa-arrow-left"></i>
                กลับหน้าหลัก</a>
        </div>
        <div class="panel-body edit-body-soft">
            <form name="edit" action="#" method="post" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><i class="fas fa-fingerprint"></i> เลขทะเบียนรับ</label>
                            <div class="input-group">
                                <span class="input-group-addon">เลขทะเบียนรับ</span>
                                <input type="text" class="form-control" value="<?php print $rec_id; ?>/<?php print $yname; ?>" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><i class="fas fa-calendar-check"></i> วันที่ลงรับ</label>
                            <div class="input-group">
                                <span class="input-group-addon">วันที่ลงรับ</span>
                                <input name="date_in" type="text" class="form-control" value="<?php print $row['date_in']; ?>">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><i class="fas fa-hashtag"></i> เลขที่หนังสือ</label>
                            <div class="input-group">
                                <span class="input-group-addon">เลขที่หนังสือ</span>
                                <input name="book_no" type="text" class="form-control" value="<?php print $row['book_no']; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><i class="fas fa-folder"></i> ประเภทหนังสือ</label>
                            <div class="input-group" style="padding: 6px 12px; background: white; border: 1px solid #d1d3e2; border-radius: 4px; width: 100%;">
                                <label class="radio-inline"><input name="typeDoc" type="radio" value="1" <?php if ($row['typeDoc'] == 1)
                                    echo "checked"; ?>> ปกติ</label>
                                <label class="radio-inline"><input name="typeDoc" type="radio" value="2" <?php if ($row['typeDoc'] == 2)
                                    echo "checked"; ?>> เวียน</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label><i class="fas fa-user-secret"></i> ชั้นความลับ</label>
                            <div class="input-group">
                                <span class="input-group-addon">ชั้นความลับ</span>
                                <select class="form-control" name="pri_id" id="pri_id">
                                    <?php
                                    $sql = "SELECT * FROM priority ORDER BY pri_id";
                                    $r = dbQuery($sql);
                                    $pri_cure = $row['pri_id'];
                                    while ($pri = dbFetchArray($r)) { ?>
                                            <option <?php if ($pri_cure == $pri['pri_id'])
                                                echo "selected"; ?> value="<?php print $pri['pri_id']; ?>"><?php print $pri['pri_name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label><i class="fas fa-running"></i> ชั้นความเร็ว</label>
                            <div class="input-group">
                                <span class="input-group-addon">ชั้นความเร็ว</span>
                                <select class="form-control" name="speed_id" id="speed_id">
                                    <?php
                                    $sql = "SELECT * FROM speed ORDER BY speed_id";
                                    $r = dbQuery($sql);
                                    $speed_cure = $row['speed_id'];
                                    while ($speed = dbFetchArray($r)) { ?>
                                            <option <?php if ($speed_cure == $speed['speed_id'])
                                                echo "selected"; ?> value="<?php print $speed['speed_id']; ?>"><?php print $speed['speed_name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label><i class="fas fa-bullseye"></i> วัตถุประสงค์</label>
                            <div class="input-group">
                                <span class="input-group-addon">วัตถุประสงค์</span>
                                <select class="form-control" name="obj_id" id="obj_id">
                                    <?php
                                    $sql = "SELECT * FROM object ORDER BY obj_id";
                                    $r = dbQuery($sql);
                                    $obj_cure = $row['obj_id'];
                                    while ($obj = dbFetchArray($r)) { ?>
                                            <option <?php if ($obj_cure == $obj['obj_id'])
                                                echo "selected"; ?> value="<?php print $obj['obj_id']; ?>"><?php print $obj['obj_name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><i class="far fa-calendar-alt"></i> ลงวันที่</label>
                            <div class="input-group">
                                <span class="input-group-addon">ลงวันที่</span>
                                <input type="date" class="form-control" name="date_book" value="<?php print $row['date_book']; ?>" onKeyDown="return false">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><i class="fas fa-user-edit"></i> ผู้ส่ง</label>
                            <div class="input-group">
                                <span class="input-group-addon">ผู้ส่ง</span>
                                <input name="sendfrom" type="text" class="form-control" value="<?php print $row['sendfrom']; ?>">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label><i class="fas fa-user-tie"></i> ผู้รับ</label>
                    <div class="input-group">
                        <span class="input-group-addon">ผู้รับ</span>
                        <input name="sendto" type="text" class="form-control" value="<?php print $row['sendto']; ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label><i class="fas fa-bookmark"></i> เรื่อง</label>
                    <div class="input-group">
                        <span class="input-group-addon">เรื่อง</span>
                        <input name="title" type="text" class="form-control" value="<?php print $row['title']; ?>">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><i class="fas fa-link"></i> อ้างถึง</label>
                            <div class="input-group">
                                <span class="input-group-addon">อ้างถึง</span>
                                <input name="reference" type="text" class="form-control" value="<?php print $row['reference']; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><i class="fas fa-paperclip"></i> สิ่งที่ส่งมาด้วย</label>
                            <div class="input-group">
                                <span class="input-group-addon">สิ่งที่ส่งมาด้วย</span>
                                <input name="attachment" type="text" class="form-control" value="<?php print $row['attachment']; ?>">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label><i class="fas fa-university"></i> หน่วยปฏิบัติ</label>
                    <div class="input-group">
                        <span class="input-group-addon">หน่วยปฏิบัติ</span>
                        <select class="form-control selectpicker" data-live-search="true" id="practice" name="practice" required="">
                            <?php
                            $sql = 'SELECT * FROM depart ORDER BY dep_id';
                            $result_dep = dbQuery($sql);
                            while ($dep_row = dbFetchAssoc($result_dep)) { ?>
                                    <option value="<?php echo $dep_row['dep_id']; ?>" <?php if ($dep_row['dep_id'] == $row['practice'])
                                           echo 'selected'; ?>>
                                        <?php echo $dep_row['dep_name']; ?>
                                    </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="well bg-warning-soft">
                    <div class="form-group">
                        <label><i class="fas fa-file-upload"></i> จัดการไฟล์เอกสาร</label>
                        <div class="row">
                            <div class="col-md-6">
                                <input name="file_location" class="form-control" type="file">
                            </div>
                            <div class="col-md-6">
                                <?php if ($row['file_location'] != '') { ?>
                                        <div class="alert alert-info" style="margin-bottom: 0; padding: 10px;">
                                            <i class="fas fa-check-circle"></i> มีไฟล์เดิมอยู่แล้ว: 
                                            <a class="btn btn-xs btn-primary" href="<?php echo $row['file_location']; ?>" target="_blank">
                                                <i class="fas fa-download"></i> ดาวน์โหลดไฟล์
                                            </a>
                                        </div>
                                <?php } else { ?>
                                        <div class="alert alert-danger" style="margin-bottom: 0; padding: 10px;">
                                            <i class="fas fa-exclamation-triangle"></i> ยังไม่มีการอัปโหลดไฟล์
                                        </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><i class="fas fa-building"></i> ส่วนราชการผู้บันทึก</label>
                            <div class="input-group">
                                <span class="input-group-addon">หน่วยงาน</span>
                                <input name="dep_name" type="text" class="form-control" value="<?php print $row['dep_name']; ?>" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><i class="fas fa-user-shield"></i> เจ้าหน้าที่ผู้บันทึก</label>
                            <div class="input-group">
                                <span class="input-group-addon">เจ้าหน้าที่</span>
                                <input name="firstname" type="text" class="form-control" value="<?php print $row['firstname'] . " " . $row['lastname']; ?>" disabled>
                            </div>
                        </div>
                    </div>
                </div>

                <input type="hidden" name="book_id" value="<?php echo $row['book_id']; ?>">
                <input type="hidden" name="book_detail_id" value="<?php echo $row['book_detail_id']; ?>">
                
                <hr style="border-top: 2px solid #eaecf4;">
                <div class="text-center" style="margin-top: 20px;">
                    <button class="btn btn-warning-modern btn-lg-modern" type="submit" name="update">
                        <i class="fas fa-save"></i> บันทึกการแก้ไข
                    </button>
                    <a class="btn btn-danger-modern btn-lg-modern" href="flow-resive-province.php">
                        <i class="fas fa-times"></i> ยกเลิก
                    </a>
                </div>
            </form>
        </div> <!-- panel-body -->
        <div class="panel-footer" style="background-color: transparent; border-top: none;">
        </div>
    </div><!-- panel -->
</div>
<?php
//Update
if (isset($_POST['update'])) {       //if button update
    if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
        die("CSRF token validation failed.");
    }
    //book_master
    $book_id = $_POST['book_id'];
    $typeDoc = $_POST['typeDoc'];     //book master
    $obj_id = $_POST['obj_id'];
    $pri_id = $_POST['pri_id'];
    $speed_id = $_POST['speed_id'];

    //Book_detail
    $book_detail_id = $_POST['book_detail_id'];       //key of book_detail
    $book_no = $_POST['book_no'];
    $reference = $_POST['reference'];
    $attachment = $_POST['attachment'];
    $title = $_POST['title'];
    $sendfrom = $_POST['sendfrom'];
    $sendto = $_POST['sendto'];
    $date_book = $_POST['date_book'];       //date of ducument
    $date_in = $_POST['date_in'];
    $practice = $_POST['practice'];
    $practiceCheck = $_POST['practice'];    //ใช้ตรวจสอบกรณีไม่มีการเลือกปฏิบัตหรือว่าผู้ปกิบัติมีอยู่แล้ว

    $upload = $_FILES['file_location']['name']; //ตัวแปรสำหรับอ่านค่าไฟล์ต่าง ๆ  $_FILES
    if ($upload != '') {
        $date = date('Y-m-d');  //กำหนดรูปแบบวันที่
        $numrand = (mt_rand()); //สุ่มตัวเลข
        $part = "recive-to-province/";   //โฟลเดอร์เก็บเอกสาร
        $type = strrchr($upload, '.');   //เอาชื่อเก่าออกให้เหลือแต่นามสกุล
        $newname = $date . $numrand . $type;   //ตั้งชื่อไฟล์ใหม่โดยใช้เวลา
        $part_copy = $part . $newname;
        $part_link = "recive-to-province/" . $newname;
        move_uploaded_file($_FILES['file_location']['tmp_name'], $part_copy);  //คัดลอกไฟล์ไป Server
    } else {
        $part_copy = '';
    }

    if ($practice == '') {  //กรณีที่ไม่ต้องการเปลี่ยนแปลงผู้ปฏิบัติ  ให้ใช้ค่าเดิม
        $practice = $practiceCheck;
    }

    //start transection
    dbQuery("BEGIN");
    $sql = "UPDATE book_master SET typeDoc=?,obj_id=?,pri_id=?,speed_id=? WHERE book_id=?";
    $result1 = dbQuery($sql, "iiiii", [$typeDoc, $obj_id, $pri_id, $speed_id, $book_id]);


    $sql = "UPDATE book_detail SET
                                 book_no=?,
                                 title=?,
                                 sendfrom=?,
                                 sendto=?,
                                 reference=?,
                                 attachment=?,
                                 date_book=?,
                                 date_in=?,
                                 practice=?,
                                 file_location=? 
                                 WHERE book_detail_id=?";
    // echo $sql;
    $result2 = dbQuery($sql, "ssssssssssi", [
        $book_no,
        $title,
        $sendfrom,
        $sendto,
        $reference,
        $attachment,
        $date_book,
        $date_in,
        $practice,
        $part_copy,
        $book_detail_id
    ]);

    if ($result1 && $result2) {
        dbQuery("COMMIT");
        echo "<script>
            swal({
                title:'แก้ไขข้อมูลเรียบร้อยแล้ว',
                type:'success',
                showConfirmButton:true
                },
                function(isConfirm){
                    if(isConfirm){
                        window.location.href='flow-resive-province.php';
                    }
                }); 
            </script>";
    } else {
        dbQuery("ROLLBACK");
        echo "<script>
            swal({
                title:'มีบางอย่างผิดพลาด! กรุณาตรวจสอบ',
                type:'error',
                showConfirmButton:true
                },
                function(isConfirm){
                    if(isConfirm){
                        window.location.href='flow-resive-province.php';
                    }
                }); 
            </script>";
    }
}

?>

<script type="text/javascript">
    function make_autocom(autoObj, showObj) {
        var mkAutoObj = autoObj;
        var mkSerValObj = showObj;
        new Autocomplete(mkAutoObj, function () {
            this.setValue = function (id) {
                document.getElementById(mkSerValObj).value = id;
                // ถ้ามี id ที่ได้จากการเลือกใน autocomplete
                if (id != "") {
                    // ส่งค่าไปคิวรี่เพื่อเรียกข้อมูลเพิ่มเติมที่ต้องการ โดยใช้ ajax
                    $.post("g_fulldata.php", { id: id }, function (data) {
                        if (data != null && data.length > 0) { // ถ้ามีข้อมูล
                            // นำข้อมูลไปแสดงใน textbox ที่่เตรียมไว้
                            $("#province_id").val(data[0].id);
                            $("#province_name_th").val(data[0].name_th);
                        }
                    });
                } else {
                    // ล้างค่ากรณีไม่มีการส่งค่า id ไปหรือไม่มีการเลือกจาก autocomplete
                    $("#province_id").val("");
                    $("#province_name_th").val("");
                }
            }
            if (this.isModified)
                this.setValue("");
            if (this.value.length < 1 && this.isNotClick)
                return;
            return "gdata.php?q=" + encodeURIComponent(this.value);
        });
    }

    // การใช้งาน
    // make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
    make_autocom("show_province1", "h_province_id1");
</script>