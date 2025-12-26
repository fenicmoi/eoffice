<script>
    $(document).ready(function () {
        $('#tbOutside   ').DataTable();
    });
</script>
<?php
date_default_timezone_set('Asia/Bangkok');
include "header.php";

// checkuser login
if (!isset($_SESSION['ses_u_id'])) {
    header("Location: ../index.php");
    exit();
} else {
    // ป้องกัน XSS ในค่า $u_id ที่มาจาก session
    $u_id = htmlspecialchars($_SESSION['ses_u_id'], ENT_QUOTES, 'UTF-8');

    // ใช้ FILTER_VALIDATE_INT เพื่อตรวจสอบและทำความสะอาดค่าที่รับมา
    @$cid = filter_input(INPUT_GET, 'cid', FILTER_VALIDATE_INT);
    @$doctype = filter_input(INPUT_GET, 'doctype', FILTER_SANITIZE_STRING);

    // ตรวจสอบความถูกต้องของ $cid 
    if ($cid === false) {
        $cid = null;
    }
}

if ($doctype == "flow-circle") {
    $tb = "flowcircle";
} elseif ($doctype == "flow-normal") {
    $tb = "flownormal";
} else {
    // กำหนดค่าเริ่มต้นหรือจัดการกรณีที่ไม่ถูกต้อง
    $tb = null;
}

// ส่วนที่ 1: การใช้ Prepared Statements ในส่วนดึงข้อมูล
if ($cid && $tb) {
    // ใช้ Prepared Statement เพื่อป้องกัน SQL Injection
    $sql = "SELECT title,file_upload FROM $tb  WHERE cid=?";
    $result = dbQuery($sql, 'i', [$cid]); // 'i' คือ integer สำหรับ $cid

    if ($result) {
        $row = dbFetchAssoc($result);
        if ($row) {
            // ป้องกัน XSS เมื่อแสดงผล
            $title = htmlspecialchars($row['title'], ENT_QUOTES, 'UTF-8');
            $link_file = htmlspecialchars($row['file_upload'], ENT_QUOTES, 'UTF-8');
        }
        dbFreeResult($result);
    }
}
?>
<div class="col-md-2">
    <?php
    $level_id = isset($_SESSION['ses_level_id']) ? $_SESSION['ses_level_id'] : 0; // ควรดึง level_id จาก session
    $menu = checkMenu($level_id);           //check permision menu
    include $menu;                          //include menu
    ?>
</div>
<div class="col-md-10">
    <div class="panel panel-primary">
        <div class="panel-heading"><i class="fas fa-share-square fa-2x"></i>
            <strong>ส่งหนังสือระหว่างส่วนราชการ</strong>
        </div>
        <div class="panel-body">
            <ul class="nav nav-tabs">
                <li><a class="btn-danger fas fa-envelope" href="paper.php"> หนังสือเข้า</a></li>
                <li><a class="btn-danger fas fa-envelope-open" href="folder.php">สถานะ(รับ/คืน)</a></li>
                <li><a class="btn-danger fas fa-history" href="history.php"> ส่งแล้ว</a></li>
                <li class="active"><a class="btn-danger fas fa-globe" href="outside_all.php"> ส่งหนังสือ</a></li>
            </ul>
            <br>
            <form id="fileout" name="fileout" method="post" enctype="multipart/form-data"
                action="outside_all.php?<?php echo isset($_SERVER['QUERY_STRING']) ? htmlspecialchars($_SERVER['QUERY_STRING']) : ''; ?>">
                <div class="form-group form-inline">
                    <label for="title">เรื่อง:</label>
                    <input class="form-control" type="text" name="title" size="100%" placeholder="ใส่ชื่อเรื่อง"
                        required="">
                </div>
                <div class="form-group form-inline">
                    <label for="book_no">เลขหนังสือ:</label>
                    <input class="form-control" type="text" name="book_no" size="100%" placeholder="โปรดระบุ"
                        required=""
                        value="<?php echo isset($_POST['book_no']) ? htmlspecialchars($_POST['book_no'], ENT_QUOTES, 'UTF-8') : ''; ?>">
                </div>
                <div class="form-group form-inline">
                    <label>ส่งถึง:</label>
                    <input type="radio" name="toAll" id="toAll" value="1" onclick="setEnabledTo2(this);
                                        document.getElementById('ckToType').style.display = 'none';
                                        document.getElementById('ckToSome').style.display = 'none';
                            "> ทุกส่วนราชการ
                    <input type="radio" name="toSome" id="toSome" value="2" onclick="setEnabledTo2(this);
                                        document.getElementById('ckToType').style.display = 'block';
                                        document.getElementById('ckToSome').style.display = 'none';
                            "> แยกตามประเภท
                    <input type="text" name="toSomeUser" class="mytextboxLonger" style="width:373px;" readonly disabled
                        value="<?php echo isset($_POST['toSomeUser']) ? htmlspecialchars($_POST['toSomeUser'], ENT_QUOTES, 'UTF-8') : ''; ?>">
                    <input type="radio" name="toSomeOne" id="toSomeOne" value="3" onclick="setEnabledTo2(this);
                                        document.getElementById('ckToType').style.display = 'none';
                                        document.getElementById('ckToSome').style.display = 'block';
                            "> เลือกเอง
                    <input type="text" name="toSomeOneUser" class="mytextboxLonger" style="width:373px;" readonly
                        disabled
                        value="<?php echo isset($_POST['toSomeOneUser']) ? htmlspecialchars($_POST['toSomeOneUser'], ENT_QUOTES, 'UTF-8') : ''; ?>">
                    <div id="ckToType" style="display:none">
                        <table border="1" width="599px" cellspacing="0" cellpadding="0">
                            <tr>
                                <td class="alere alert-info">
                                    <center>เลือกผู้รับ</center>
                                </td>
                            </tr>
                        </table>
                        <div id="div1" style="width:599px; height:250px; overflow:auto">
                            <table border="1" width="599px">
                                <?php
                                // ปลอดภัย: ไม่ได้รับค่าจากผู้ใช้
                                $sql = "SELECT type_id,type_name FROM office_type ORDER BY type_id";
                                $result = dbQuery($sql);
                                $numrowOut = dbNumRows($result);
                                if (empty($numrowOut)) {
                                    ?>
                                    <thead>
                                        <tr>
                                            <td></td>
                                            <td>ไม่มีข้อมูลประเภทส่วนราชการ</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                } else {
                                    $i = 0;
                                    while ($rowOut = dbFetchAssoc($result)) {
                                        $i++;
                                        $a = $i % 2;
                                        if ($a == 0) { ?>
                                                <tr bgcolor="#A9F5D0">
                                                <?php } else { ?>
                                                <tr bgcolor="#F5F6CE">
                                                <?php } ?>
                                                <td class="select_multiple_checkbox"><input type="checkbox"
                                                        onclick="listType(this,'<?php echo htmlspecialchars($rowOut['type_id'], ENT_QUOTES, 'UTF-8'); ?>')">
                                                </td>
                                                <td class="select_multiple_name">
                                                    <?php print htmlspecialchars($rowOut['type_name'], ENT_QUOTES, 'UTF-8'); ?>
                                                </td>
                                            </tr>
                                            <?php
                                    }
                                    dbFreeResult($result); // คืนค่าหน่วยความจำ
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                        <table>
                            <tr>
                                <td><input class="btn-success" style="width:77px;" type="button" value="ตกลง"
                                        onclick="document.getElementById('ckToType').style.display = 'none';"></td>
                                <td><input class="btn-danger" style="width:77px;" type="button" value="ยกเลิก"
                                        onclick="document.getElementById('ckToType').style.display = 'none';"></td>
                            </tr>
                        </table>
                    </div>
                    <div id="ckToSome" style="display:none">
                        <table border="1" width="100%" cellspacing="0" cellpadding="0">
                            <tr>
                                <td class="bg-primary">
                                    <center>เลือกผู้รับ</center>
                                </td>
                            </tr>
                        </table>
                        <div id="div1">
                            <table id="tbOutside" class="display" style="width:100%">
                                <thead>
                                    <th>No.</th>
                                    <th>ชื่อส่วนราชการ</th>
                                </thead>
                                <tbody>
                                    <?php
                                    // ปลอดภัย: ไม่ได้รับค่าจากผู้ใช้
                                    $sql = "SELECT dep_id,dep_name,type_id FROM depart ORDER BY type_id";
                                    $result = dbQuery($sql);
                                    $numrowOut = dbNumRows($result);
                                    if (empty($numrowOut)) { ?>
                                        <tr>
                                            <td></td>
                                            <td>ไม่มีข้อมูลประเภทส่วนราชการ</td>
                                        </tr>
                                        <?php
                                    } else {
                                        $i = 0;
                                        while ($rowOut = dbFetchAssoc($result)) { ?>
                                            <tr>
                                                <td class="select_multiple_checkbox"><input type="checkbox"
                                                        onclick="listSome(this,'<?php echo htmlspecialchars($rowOut['dep_id'], ENT_QUOTES, 'UTF-8'); ?>')">
                                                </td>
                                                <td class="select_multiple_name">
                                                    <?php print htmlspecialchars($rowOut['dep_name'], ENT_QUOTES, 'UTF-8'); ?>
                                                </td>
                                            </tr>
                                            <?php
                                        } //while
                                        dbFreeResult($result); // คืนค่าหน่วยความจำ
                                    } //if
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td>No.</td>
                                        <td>ส่วนราชการ</td>
                                    </tr>
                                    </thead>
                            </table>
                        </div>
                        <table>
                            <tr>
                                <td><input class="btn-success" style="width:77px;" type="button" value="ตกลง"
                                        onclick="document.getElementById('ckToSome').style.display = 'none';"></td>
                                <td><input class="btn-danger" style="width:77px;" type="button" value="ยกเลิก"
                                        onclick="document.getElementById('ckToSome').style.display = 'none';"></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <?php
                if ($cid && isset($link_file) && $link_file <> null) { ?>
                    <div class="form-group form-inline">
                        <label for="fileupload">ไฟล์แนบ</label><a class="btn btn-warning"
                            href="<?php print htmlspecialchars($link_file, ENT_QUOTES, 'UTF-8'); ?>" target="_blank"><i
                                class="fa fa-file fa-2x"></i></a>
                    </div>
                <?php } else { ?>
                    <div class="form-group form-inline">
                        <label for="fileupload">แนบไฟล์</label>
                        <input type="file" name="fileupload" required>
                    </div>
                <?php } ?>
                <div class="form-group form-inline">
                    <label for="detail">รายละเอียด</label>
                    <textarea name="detail" rows="3"
                        cols="60"><?php echo isset($_POST['detail']) ? htmlspecialchars($_POST['detail'], ENT_QUOTES, 'UTF-8') : '-'; ?></textarea>
                </div>
                <center>
                    <div class="form-group">
                        <input type="hidden" name="file"
                            value="<?php echo isset($fileupload) ? htmlspecialchars($fileupload, ENT_QUOTES, 'UTF-8') : ''; ?>" />
                        <input type="hidden" name="dep_id"
                            value="<?php echo isset($dep_id) ? htmlspecialchars($dep_id, ENT_QUOTES, 'UTF-8') : ''; ?>" />
                        <input type="hidden" name="sec_id"
                            value="<?php echo isset($sec_id) ? htmlspecialchars($sec_id, ENT_QUOTES, 'UTF-8') : ''; ?>" />
                        <input type="hidden" name="user_id" id="user_id"
                            value="<?php echo htmlspecialchars($u_id, ENT_QUOTES, 'UTF-8'); ?>" />
                        <input type="submit" name="sendOut" class="btn btn-primary btn-lg" value="ส่งเอกสาร" />
                    </div>
                </center>
            </form>
        </div>
        <div class="panel-footer"></div>
    </div>
</div>

<?php
/*++++++++++++++++++++++++++++ส่งภายนอก+++++++++++++++++++++++++++*/

if (isset($_POST['sendOut'])) {           //ตรวจสอบปุ่ม sendOut

    // **ส่วนที่ 2: ทำความสะอาดค่าที่รับจาก POST ก่อนใช้งาน**
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING); // ชื่ออเอกสาร
    $detail = filter_input(INPUT_POST, 'detail', FILTER_SANITIZE_STRING); // รายละเอียด
    $date = date('YmdHis');               // วันเวลาปัจจุบันที่จะเอาไปใส่ในระบบว่าส่งมาเมื่อไหร่
    $sec_id = filter_input(INPUT_POST, 'sec_id', FILTER_VALIDATE_INT); // รหัสแผนกที่ส่ง (ต้องเป็นตัวเลข)
    $outsite = 1;                         // กำหนดค่าเอกสาร insite=ภายใน outsite = ภายนอก
    $user_id = filter_input(INPUT_POST, 'user_id', FILTER_VALIDATE_INT); // ไอดีผู้ใช้ (ต้องเป็นตัวเลข)
    $dep_id = filter_input(INPUT_POST, 'dep_id', FILTER_VALIDATE_INT); // ไอดีหน่วยงาน (ต้องเป็นตัวเลข)
    $book_no = filter_input(INPUT_POST, 'book_no', FILTER_SANITIZE_STRING); // เลขหนังสือ

    @$toAll = filter_input(INPUT_POST, 'toAll', FILTER_VALIDATE_INT);            // ส่งถึงทุกส่วน
    @$toSome = filter_input(INPUT_POST, 'toSome', FILTER_VALIDATE_INT);          // ส่งตามประเภท
    @$toSomeOne = filter_input(INPUT_POST, 'toSomeOne', FILTER_VALIDATE_INT);    // ส่งแบบเจาะจง

    // สตริงที่เก็บรายการ ID
    @$toSomeUser = filter_input(INPUT_POST, 'toSomeUser', FILTER_SANITIZE_STRING);          // INPUT ส่งแยกประเภทตามหน่วยงาน
    @$toSomeOneUser = filter_input(INPUT_POST, 'toSomeOneUser', FILTER_SANITIZE_STRING);    // INPUT รับรหัสแบบเลือกเอง

    @$fileupload = filter_input(INPUT_POST, 'file', FILTER_SANITIZE_STRING);                // ไฟล์เอกสาร (ชื่อไฟล์เดิม)
    $dateSend = date('Y-m-d');                    // วันที่ส่งเอกสาร

    $link_file = ''; // กำหนดค่าเริ่มต้น
    // **ส่วนที่ 3: ปรับปรุงการจัดการไฟล์อัปโหลด**
    if (isset($_FILES['fileupload'])) {
        $err = $_FILES['fileupload']['error'];

        if ($err === UPLOAD_ERR_OK) {
            $upload = $_FILES['fileupload'];
            $upload_dir = "paper/";

            $filename = $upload['name'];
            // --- ดึงนามสกุล (ตัวพิมพ์เล็ก) ---
            $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            // --- รายการนามสกุลที่อนุญาต (เพิ่มการตรวจสอบให้เข้มงวดขึ้น) ---
            //$allowed_extensions = array('pdf', 'png', 'jpg', 'jpeg', 'zip', '7z', 'rar'); 
            // อนุญาตประเภทเอกสาร: doc, docx, xls, xlsx, ppt, pptx, zip, 7z, rar, pdf, jpg, jpeg, png
            $allowed_extensions = array('pdf', 'png', 'jpg', 'jpeg', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'zip', '7z', 'rar', 'zipx');


            // --- ตรวจสอบว่าไฟล์อยู่ในรายการอนุญาตไหม ---
            if (!in_array($ext, $allowed_extensions)) {
                echo "<script>alert('ไม่อนุญาตให้อัปโหลดไฟล์ .$ext'); window.history.back();</script>";
                exit;
            }

            // ตั้งชื่อไฟล์ใหม่ไม่ให้ซ้ำ (มีความปลอดภัยสูง)
            $date_prefix = date("YmdHis"); // รูปแบบปีเดือนวันชั่วโมงนาทีวินาที
            $random_num = mt_rand(100000, 999999); // สุ่มตัวเลข 6 หลัก
            $new_filename = $date_prefix . "_" . $random_num . "." . $ext;

            // พาธเต็มรูปแบบสำหรับบันทึกไฟล์
            $link_file = $upload_dir . $new_filename;

            // ย้ายไฟล์ไปยังพาธปลายทาง
            if (!move_uploaded_file($upload['tmp_name'], $link_file)) {
                echo "<script>alert('เกิดข้อผิดพลาดในการบันทึกไฟล์'); window.history.back();</script>";
                exit;
            }
        } elseif ($err === UPLOAD_ERR_NO_FILE) {
            // กรณีไม่มีการอัพโหลดใหม่ ให้ตรวจสอบว่ามีไฟล์เดิมหรือไม่
            if (!empty($fileupload)) {
                $link_file = $fileupload; // ใช้ไฟล์เดิม
            }
        } elseif ($err === UPLOAD_ERR_INI_SIZE || $err === UPLOAD_ERR_FORM_SIZE) {
            echo "<script>alert('ไฟล์มีขนาดใหญ่เกินกว่าที่ระบบกำหนด (Upload Max Size)'); window.history.back();</script>";
            exit;
        } else {
            echo "<script>alert('เกิดข้อผิดพลาดในการอัปโหลดไฟล์ (Error Code: $err)'); window.history.back();</script>";
            exit;
        }
    }


    // **ส่วนที่ 4: การใช้ Prepared Statements ในการ INSERT**

    // กรณีส่งให้ทุกส่วนราชการ
    if ($toAll == 1) { // ใช้การเปรียบเทียบที่รัดกุมกว่า
        // เตรียม SQL Query
        $sql_insert = "INSERT INTO paper(title, detail, file, postdate, u_id, sec_id, outsite, dep_id, book_no)
                       VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)";

        // กำหนดชนิดของตัวแปร: s: string, i: integer
        $types = "sssiiiiis";
        // กำหนดค่าตัวแปร
        $params = [$title, $detail, $link_file, $date, $user_id, $sec_id, $outsite, $dep_id, $book_no];

        $result = dbQuery($sql_insert, $types, $params);

        if ($result === true) { // ตรวจสอบว่า query สำเร็จ
            $lastid = dbInsertId();    // เลข ID จากตาราง paper ล่าสุด

            // เลือก User ทั้งหมด (ไม่จำเป็นต้องใช้ Prepared Statements เพราะไม่มีการรับค่าจากผู้ใช้มาใส่ใน WHERE)
            $sql_users = "SELECT  u.u_id, u.firstname, s.sec_id, d.dep_id
                          FROM user u 
                          INNER JOIN section s ON s.sec_id=u.sec_id
                          INNER JOIN depart d  ON d.dep_id=u.dep_id
                          WHERE u.Level_id = 3 AND d.dep_id <> ? AND d.status <> 0"; // ใช้ placeholder ใน WHERE

            $result_users = dbQuery($sql_users, 'i', [$dep_id]); // 'i' คือ integer สำหรับ $dep_id

            if ($result_users) {
                while ($rowUser = dbFetchArray($result_users)) {
                    // **ใช้ Prepared Statements ในการ INSERT ลง paperuser**
                    $u_id_to = $rowUser['u_id'];
                    $sec_id_to = $rowUser['sec_id'];
                    $dep_id_to = $rowUser['dep_id'];
                    $tb = "paperuser";
                    $sql_insert_user = "INSERT INTO $tb (pid, u_id, sec_id, dep_id) VALUES (?, ?, ?, ?)";
                    dbQuery($sql_insert_user, 'iiii', [$lastid, $u_id_to, $sec_id_to, $dep_id_to]);
                }
                dbFreeResult($result_users);
            }
        }

        echo "<script>
        swal({
            title:'ส่งเอกสารเรียบร้อยแล้ว',
            type:'success',
            showConfirmButton:true
            },
            function(isConfirm){
                if(isConfirm){
                    window.location.href='history.php';
                }
            }); 
        </script>";
    }


    // ***เลือกเองตามประเภท 
    if ($toSome == 2) { // ใช้การเปรียบเทียบที่รัดกุมกว่า
        // **ใช้ Prepared Statements ในการ INSERT ลง paper**
        $sql_insert = "INSERT INTO paper(title, detail, file, postdate, u_id, outsite, sec_id, dep_id, book_no)
                       VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $types = "sssiiiiis";
        $params = [$title, $detail, $link_file, $date, $user_id, $outsite, $sec_id, $dep_id, $book_no];
        $result = dbQuery($sql_insert, $types, $params);

        if ($result === true) {
            $lastid = dbInsertId(); // ค้นหาเลขระเบียนล่าสุด
            $sendto_safe = $toSomeUser; // ค่าจาก textbox ที่ถูกทำความสะอาดแล้ว

            // ประมวลผลและทำความสะอาดค่าที่มาจาก textbox
            $sendto_safe = ltrim($sendto_safe, '|'); // ลบ | ตัวแรก
            $c = explode("|", $sendto_safe);

            foreach ($c as $type_id) { // ใช้ foreach แทน for
                $type_id = (int) $type_id; // ตรวจสอบให้แน่ใจว่าเป็นตัวเลข

                if ($type_id > 0) { // ตรวจสอบว่าเป็น ID ที่ถูกต้อง
                    // **ใช้ Prepared Statements ในการ SELECT**
                    $sql_users = "SELECT u.u_id,u.firstname,s.sec_id,d.dep_id,d.type_id
                                  FROM user u 
                                  INNER JOIN section s ON s.sec_id=u.sec_id
                                  INNER JOIN depart d  ON d.dep_id=u.dep_id
                                  INNER JOIN office_type t ON t.type_id=d.type_id
                                  WHERE d.type_id=? AND d.dep_id<>? AND u.level_id = 3";

                    $result_users = dbQuery($sql_users, 'ii', [$type_id, $dep_id]);

                    if ($result_users) {
                        while ($row = dbFetchArray($result_users)) {
                            // **ใช้ Prepared Statements ในการ INSERT ลง paperuser**
                            $u_id_to = $row['u_id'];
                            $sec_id_to = $row['sec_id'];
                            $dep_id_to = $row['dep_id'];
                            $tb = "paperuser";
                            $sql_insert_user = "INSERT INTO $tb (pid, u_id, sec_id, dep_id) VALUES (?, ?, ?, ?)";
                            dbQuery($sql_insert_user, 'iiii', [$lastid, $u_id_to, $sec_id_to, $dep_id_to]);
                        }
                        dbFreeResult($result_users);
                    }
                }
            }
        }

        echo "<script>
                swal({
                    title:'เรียบร้อย',
                    type:'success',
                    showConfirmButton:true
                    },
                    function(isConfirm){
                        if(isConfirm){
                            window.location.href='history.php';
                        }
                    }); 
                </script>";
    }

    // ***** เลือกเองทีละหน่วยงาน*********	
    if ($toSomeOne == 3) { // ใช้การเปรียบเทียบที่รัดกุมกว่า
        // **ใช้ Prepared Statements ในการ INSERT ลง paper**
        $sql_insert = "INSERT INTO paper(title, detail, file, postdate, u_id, outsite, sec_id, dep_id, book_no)
                       VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $types = "sssiiiiis";
        $params = [$title, $detail, $link_file, $date, $user_id, $outsite, $sec_id, $dep_id, $book_no];
        $result = dbQuery($sql_insert, $types, $params);

        if ($result === true) {
            $lastid = dbInsertId();
            $sendto_safe = $toSomeOneUser;

            // ประมวลผลและทำความสะอาดค่าที่มาจาก textbox
            $sendto_safe = ltrim($sendto_safe, '|');
            $c = explode("|", $sendto_safe);

            foreach ($c as $dep_id_select) {
                $dep_id_select = (int) $dep_id_select; // ตรวจสอบให้แน่ใจว่าเป็นตัวเลข

                if ($dep_id_select > 0) {
                    // **ใช้ Prepared Statements ในการ SELECT**
                    $sql_users = "SELECT u.u_id,u.firstname,s.sec_id,d.dep_id,d.dep_name  
                                  FROM user u 
                                  INNER JOIN section s ON s.sec_id=u.sec_id
                                  INNER JOIN depart d  ON d.dep_id=u.dep_id
                                  WHERE u.dep_id=? AND u.level_id = 3"; // ค้นหาสารบรรณประจำหน่วยงานเท่านั้น

                    $result_users = dbQuery($sql_users, 'i', [$dep_id_select]);

                    if ($result_users) {
                        while ($row = dbFetchArray($result_users)) {
                            // **ใช้ Prepared Statements ในการ INSERT ลง paperuser**
                            $u_id_to = $row['u_id'];
                            $sec_id_to = $row['sec_id'];
                            $dep_id_to = $row['dep_id'];
                            $sql_insert_user = "INSERT INTO paperuser (pid, u_id, sec_id, dep_id) VALUES (?, ?, ?, ?)";
                            dbQuery($sql_insert_user, 'iiii', [$lastid, $u_id_to, $sec_id_to, $dep_id_to]);
                        }
                        dbFreeResult($result_users);
                    }
                }
            }
        }

        echo "<script>
                swal({
                    title:'เรียบร้อย',
                    type:'success',
                    showConfirmButton:true
                    },
                    function(isConfirm){
                        if(isConfirm){
                            window.location.href='history.php';
                        }
                    }); 
                </script>";
    }
}


?>
<script type='text/javascript'>
    $('#tbOutside').DataTable({
        "order": [
            [0, "desc"]
        ]
    })
</script>

<script language="JavaScript">
</script>

<script type="text/javascript">
    function listOne(a, b, c) {
        m = document.fileIn.toSomeUser.value;

        if (a.checked) {
            if (m.indexOf(b) < 0) m += '|' + b;

        } else {
            m = document.fileIn.toSomeUser.value.replace('|' + b, '');
        }
        z = "|";
        if (m.substring(2) == c) m = m.substring(2);
        document.fileIn.toSomeUser.value = m;
    }
</script>
<script type="text/javascript">
    function listType(a, b, c) { //ฟังค์ชั่นกรณีเลือกเป็นประเภท
        m = document.fileout.toSomeUser.value;

        if (a.checked) {
            if (m.indexOf(b) < 0) m += '|' + b;

        } else {
            m = document.fileout.toSomeUser.value.replace('|' + b, '');
        }
        z = "|";
        if (m.substring(2) == c) m = m.substring(2);
        document.fileout.toSomeUser.value = m;
    }
</script>
<script type="text/javascript">
    function listSome(a, b, c) { //ฟังค์ชั่นกรณีเลือกส่วนราชการเอง
        m = document.fileout.toSomeOneUser.value;

        if (a.checked) {
            if (m.indexOf(b) < 0) m += '|' + b;

        } else {
            m = document.fileout.toSomeOneUser.value.replace('|' + b, '');
        }
        z = "|";
        if (m.substring(2) == c) m = m.substring(2);
        document.fileout.toSomeOneUser.value = m;
    }
</script>