<script>
    // ใช้ jQuery ในการจัดการ DataTable หลังจากการโหลด DOM
    $(document).ready(function() {
        // ปรับปรุงการเลือก ID ให้ตรงและชัดเจน
        $('#tbOutside').DataTable(); 
    });
</script>
<?php
// === 1. การตั้งค่าเริ่มต้นและการตรวจสอบสิทธิ์ ===
date_default_timezone_set('Asia/Bangkok');
include "header.php";

// ตรวจสอบการเข้าสู่ระบบและเตรียมตัวแปร
if (!isset($_SESSION['ses_u_id'])) {
    header("Location: ../index.php");
    exit();
} 

// ทำความสะอาดและกำหนดตัวแปรหลัก
$u_id = htmlspecialchars($_SESSION['ses_u_id'] ?? '', ENT_QUOTES, 'UTF-8'); 
$cid = filter_input(INPUT_GET, 'cid', FILTER_VALIDATE_INT);
$doctype = filter_input(INPUT_GET, 'doctype', FILTER_SANITIZE_STRING);

// กำหนดชื่อตาราง
$tb = null;
if ($doctype === "flow-circle") {
    $tb = "flowcircle";
} elseif ($doctype === "flow-normal") {
    $tb = "flownormal";
}

$title = '';
$link_file = '';
$level_id = isset($_SESSION['ses_level_id']) ? $_SESSION['ses_level_id'] : 0;

// === 2. ดึงข้อมูลเอกสารต้นฉบับ (กรณีมีการส่งต่อ) ===
if ($cid && $tb) {
    // ใช้ Prepared Statement (จากโค้ดที่ปรับปรุงก่อนหน้า)
    $sql = "SELECT title, file_upload FROM $tb WHERE cid=?"; 
    $result = dbQuery($sql, 'i', [$cid]); 

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

// === 3. ฟังก์ชัน Helper สำหรับการแสดงรายการส่วนราชการ (ลดโค้ดซ้ำซ้อนใน HTML) ===
/**
 * ดึงและแสดงผลรายการสำหรับฟอร์มเลือกผู้รับ
 * @param string $sql คำสั่ง SQL
 * @param string $input_name ชื่อฟอร์ม (toSomeUser หรือ toSomeOneUser)
 * @param string $onclick_func ชื่อฟังก์ชัน JavaScript
 * @param string $id_col ชื่อคอลัมน์ ID
 * @param string $name_col ชื่อคอลัมน์ชื่อ
 */
function renderRecipientList($sql, $input_name, $onclick_func, $id_col, $name_col) {
    $result = dbQuery($sql);
    $numrow = dbNumRows($result);
    
    if (empty($numrow)) {
        echo '<thead><tr><td></td><td>ไม่มีข้อมูล</td></tr></thead>';
        return;
    }
    
    echo '<tbody>';
    $i = 0;
    while ($row = dbFetchAssoc($result)) {
        $i++;
        // ใช้ class สำหรับสีพื้นหลังแทนการกำหนด inline style
        $row_class = ($i % 2 === 0) ? 'even-row' : 'odd-row'; 
        
        $id_safe = htmlspecialchars($row[$id_col], ENT_QUOTES, 'UTF-8');
        $name_safe = htmlspecialchars($row[$name_col], ENT_QUOTES, 'UTF-8');
        
        // ป้องกัน XSS ใน onclick
        echo "<tr class='$row_class'>";
        echo "<td class='select_multiple_checkbox'><input type='checkbox' onclick=\"$onclick_func(this,'$id_safe')\"></td>";
        echo "<td class='select_multiple_name'>$name_safe</td>";
        echo '</tr>';
    }
    dbFreeResult($result);
    echo '</tbody>';
}
?>

<div class="col-md-2">
    <?php
    $menu = checkMenu($level_id);           //check permision menu
    include $menu;                          //include menu
    ?>
</div>
<div class="col-md-10">
    <div class="panel panel-primary">
        <div class="panel-heading"><i class="fas fa-share-square fa-2x"></i> <strong>ส่งหนังสือระหว่างส่วนราชการ</strong></div>
        <div class="panel-body">
            <ul class="nav nav-tabs">
                <li><a class="btn-danger fas fa-envelope" href="paper.php"> หนังสือเข้า</a></li>
                <li><a class="btn-danger fas fa-envelope-open" href="folder.php">สถานะ(รับ/คืน)</a></li>
                <li><a class="btn-danger fas fa-history" href="history.php"> ส่งแล้ว</a></li>
                <li class="active"><a class="btn-danger fas fa-globe" href="outside_all.php"> ส่งหนังสือ</a></li>
            </ul>
            <br>
            <form id="fileout" name="fileout" method="post" enctype="multipart/form-data" action="outside_all.php?<?php echo htmlspecialchars($_SERVER['QUERY_STRING'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                
                <div class="form-group row">
                    <label for="title" class="col-md-2 col-form-label">เรื่อง:</label>
                    
                    <div class="col-md-10">
                        <input 
                            class="form-control" 
                            type="text" 
                            name="title" 
                            placeholder="ใส่ชื่อเรื่อง" 
                            required
                            value="<?php echo htmlspecialchars($title ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                        >
                    </div>
                </div>

            <div class="form-group row">
                <label for="book_no" class="col-md-2 col-form-label">เลขหนังสือ:</label>
                
                <div class="col-md-10">
                    <input 
                        class="form-control" 
                        type="text" 
                        name="book_no" 
                        placeholder="โปรดระบุ" 
                        required
                        value="<?php echo htmlspecialchars($_POST['book_no'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                    >
                </div>
            </div>

             

                <div class="form-group">
                    <label>ส่งถึง:</label>
                    <input type="radio" name="send_mode" id="toAll" value="1" onclick="setEnabledTo2(this)"> ทุกส่วนราชการ
                    <input type="radio" name="send_mode" id="toSome" value="2" onclick="setEnabledTo2(this)"> แยกตามประเภท
                    <input type="text" name="toSomeUser" class="mytextboxLonger" style="width:373px;" readonly disabled
                        value="<?php echo htmlspecialchars($_POST['toSomeUser'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                    <input type="radio" name="send_mode" id="toSomeOne" value="3" onclick="setEnabledTo2(this)"> เลือกเอง
                    <input type="text" name="toSomeOneUser" class="mytextboxLonger" style="width:373px;" readonly disabled
                        value="<?php echo htmlspecialchars($_POST['toSomeOneUser'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                    
                    <div id="ckToType" style="display:none">
                        <table border="1" width="599px" cellspacing="0" cellpadding="0">
                            <tr><td class="alert alert-info"><center>เลือกผู้รับตามประเภท</center></td></tr>
                        </table>
                        <div id="div1" style="width:599px; height:250px; overflow:auto">
                            <table border="1" width="599px">
                                <?php 
                                // ใช้ Helper Function
                                renderRecipientList("SELECT type_id, type_name FROM office_type ORDER BY type_id", 
                                                    "toSomeUser", "listType", "type_id", "type_name");
                                ?>
                            </table>
                        </div>
                        <table>
                            <tr>
                                <td><input class="btn-success" style="width:77px;" type="button" value="ตกลง" onclick="document.getElementById('ckToType').style.display = 'none';"></td>
                                <td><input class="btn-danger" style="width:77px;" type="button" value="ยกเลิก" onclick="document.getElementById('ckToType').style.display = 'none';"></td>
                            </tr>
                        </table>
                    </div> 

                    <div id="ckToSome" style="display:none">
                        <table border="1" width="100%" cellspacing="0" cellpadding="0">
                            <tr><td class="bg-primary"><center>เลือกผู้รับรายหน่วยงาน</center></td></tr>
                        </table>
                        <div id="div1">
                            <table id="tbOutside" class="display" style="width:100%">
                                <thead>
                                    <th>เลือก</th>
                                    <th>ชื่อส่วนราชการ</th>
                                </thead>
                                <?php 
                                // ใช้ Helper Function
                                renderRecipientList("SELECT dep_id, dep_name FROM depart ORDER BY type_id", 
                                                    "toSomeOneUser", "listSome", "dep_id", "dep_name");
                                ?>
                                <tfoot>
                                    <tr>
                                        <td>เลือก</td>
                                        <td>ส่วนราชการ</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <table>
                            <tr>
                                <td><input class="btn-success" style="width:77px;" type="button" value="ตกลง" onclick="document.getElementById('ckToSome').style.display = 'none';"></td>
                                <td><input class="btn-danger" style="width:77px;" type="button" value="ยกเลิก" onclick="document.getElementById('ckToSome').style.display = 'none';"></td>
                            </tr>
                        </table>
                    </div>
                </div>
                
                <div class="form-group form-inline">
                    <label for="fileupload">แนบไฟล์</label>
                    <?php if ($cid && $link_file) { ?>
                        <a class="btn btn-warning" href="<?php echo $link_file; ?>" target="_blank"><i class="fa fa-file fa-2x"></i> ดูไฟล์เดิม</a>
                        <input type="hidden" name="existing_file" value="1">
                    <?php } else { ?>
                        <input type="file" name="fileupload" required>
                    <?php } ?>
                </div>

                <div class="form-group form-inline">
                    <label for="detail">รายละเอียด</label>
                    <textarea name="detail" rows="3" cols="60"><?php echo htmlspecialchars($_POST['detail'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></textarea>
                </div>
                
                <center>
                    <div class="form-group">
                        <input type="hidden" name="dep_id" value="<?php echo htmlspecialchars($_SESSION['ses_dep_id'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
                        <input type="hidden" name="sec_id" value="<?php echo htmlspecialchars($_SESSION['ses_sec_id'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" />
                        <input type="hidden" name="user_id" id="user_id" value="<?php echo $u_id; ?>" />
                        <input type="submit" name="sendOut" class="btn btn-primary btn-lg" value="ส่งเอกสาร" />
                    </div>
                </center>
            </form>
        </div>
        <div class="panel-footer"></div>
    </div>
</div>

<?php
// === 5. ส่วนประมวลผล (Backend Logic) ===

if (isset($_POST['sendOut'])) {
    
    // ดึงค่าและทำความสะอาด
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING); 
    $detail = filter_input(INPUT_POST, 'detail', FILTER_SANITIZE_STRING);
    $book_no = filter_input(INPUT_POST, 'book_no', FILTER_SANITIZE_STRING);
    $send_mode = filter_input(INPUT_POST, 'send_mode', FILTER_VALIDATE_INT);

    $user_id = filter_input(INPUT_POST, 'user_id', FILTER_VALIDATE_INT); 
    $dep_id = filter_input(INPUT_POST, 'dep_id', FILTER_VALIDATE_INT); 
    $sec_id = filter_input(INPUT_POST, 'sec_id', FILTER_VALIDATE_INT); 
    
    $toSomeUser = filter_input(INPUT_POST, 'toSomeUser', FILTER_SANITIZE_STRING);
    $toSomeOneUser = filter_input(INPUT_POST, 'toSomeOneUser', FILTER_SANITIZE_STRING);
    
    // ตั้งค่าตัวแปรอื่นๆ
    $date = date('YmdHis'); 
    $outsite = 1;

    // A. จัดการไฟล์อัปโหลด
    $link_file = '';
    // ใช้ไฟล์เดิมหากมีการส่งต่อและไม่ได้อัปโหลดไฟล์ใหม่
    if (isset($_POST['existing_file']) && empty($_FILES['fileupload']['name'])) {
        // ดึงชื่อไฟล์เดิมจาก $link_file ที่ได้มาจากการ Query ด้านบน
    } elseif (isset($_FILES['fileupload']) && $_FILES['fileupload']['error'] === UPLOAD_ERR_OK) {
        $upload = $_FILES['fileupload'];
        $upload_dir = "paper/";
        $ext = strtolower(pathinfo($upload['name'], PATHINFO_EXTENSION));
        $allowed_extensions = array('pdf', 'png', 'jpg', 'jpeg', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'zip', '7z', 'rar', 'zipx');

        if (!in_array($ext, $allowed_extensions)) {
            echo "<script>alert('ไม่อนุญาตให้อัปโหลดไฟล์ .$ext'); window.history.back();</script>";
            exit;
        }

        $new_filename = date("YmdHis") . "_" . mt_rand(100000, 999999) . "." . $ext;
        $link_file = $upload_dir . $new_filename;

        if (!move_uploaded_file($upload['tmp_name'], $link_file)) {
            echo "<script>alert('เกิดข้อผิดพลาดในการบันทึกไฟล์'); window.history.back();</script>";
            exit;
        }
    } else {
         // กรณีไม่มีไฟล์และไม่ใช่การส่งต่อ
        $link_file = null; 
    }
    
    // B. INSERT ข้อมูลหลักเข้าตาราง paper
    $sql_insert_paper = "INSERT INTO paper(title, detail, file, postdate, u_id, sec_id, outsite, dep_id, book_no)
                         VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $types = "sssiiiiis";
    $params = [$title, $detail, $link_file, $date, $user_id, $sec_id, $outsite, $dep_id, $book_no];
    $paper_inserted = dbQuery($sql_insert_paper, $types, $params);

    if ($paper_inserted === true) {
        $lastid = dbInsertId();
        
        // C. INSERT ผู้รับ (Paperuser) ตามโหมดที่เลือก
        if ($send_mode === 1) { // ส่งให้ทุกส่วนราชการ
            $sql_users = "SELECT u.u_id, s.sec_id, d.dep_id
                          FROM user u 
                          INNER JOIN section s ON s.sec_id=u.sec_id
                          INNER JOIN depart d ON d.dep_id=u.dep_id
                          WHERE u.Level_id = 3 AND d.dep_id <> ? AND d.status <> 0"; 
            $result_users = dbQuery($sql_users, 'i', [$dep_id]);
            
        } elseif ($send_mode === 2) { // ส่งตามประเภท
            $type_ids = array_map('intval', array_filter(explode("|", ltrim($toSomeUser, '|'))));
            $result_users = processUserSelectionByType($type_ids, $dep_id);

        } elseif ($send_mode === 3) { // เลือกเอง
            $dep_ids_select = array_map('intval', array_filter(explode("|", ltrim($toSomeOneUser, '|'))));
            $result_users = processUserSelectionByDep($dep_ids_select);
        }

        // วนลูปและบันทึกผู้รับ
        if (isset($result_users) && $result_users) {
             while ($rowUser = dbFetchArray($result_users)) {
                $u_id_to = $rowUser['u_id'];
                $sec_id_to = $rowUser['sec_id'];
                $dep_id_to = $rowUser['dep_id'];
                $sql_insert_user = "INSERT INTO paperuser (pid, u_id, sec_id, dep_id) VALUES (?, ?, ?, ?)";
                dbQuery($sql_insert_user, 'iiii', [$lastid, $u_id_to, $sec_id_to, $dep_id_to]);
            }
            dbFreeResult($result_users);
        }

        // แสดงผลสำเร็จ
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
        
    } else {
        // จัดการข้อผิดพลาดในการบันทึก Paper
        echo "<script>
        swal({
            title:'เกิดข้อผิดพลาดในการบันทึกเอกสารหลัก',
            type:'error',
            showConfirmButton:true
            }); 
        </script>";
    }
}


// === D. ฟังก์ชันช่วยเหลือสำหรับประมวลผลผู้รับ (เพื่อความสะอาดของโค้ด) ===

/**
 * ดึงรายการผู้ใช้ (สารบรรณ) ตามประเภทหน่วยงานที่เลือก
 * @param array $type_ids อาร์เรย์ของ type_id
 * @param int $exclude_dep_id dep_id ที่ต้องการยกเว้น
 * @return mixed ผลลัพธ์จาก dbQuery หรือ false
 */
function processUserSelectionByType(array $type_ids, int $exclude_dep_id) {
    if (empty($type_ids)) return false;

    // สร้าง placeholders สำหรับ IN clause
    $placeholders = implode(',', array_fill(0, count($type_ids), '?'));
    
    // สร้าง SQL Query: WHERE d.type_id IN (?, ?, ...) AND d.dep_id <> ?
    $sql = "SELECT u.u_id, s.sec_id, d.dep_id
            FROM user u 
            INNER JOIN section s ON s.sec_id=u.sec_id
            INNER JOIN depart d ON d.dep_id=u.dep_id
            WHERE d.type_id IN ($placeholders) AND d.dep_id <> ? AND u.level_id = 3";

    // สร้าง types string: 'i' สำหรับ type_ids ทุกตัว + 'i' สำหรับ $exclude_dep_id
    $types = str_repeat('i', count($type_ids)) . 'i';
    
    // สร้าง params array: type_ids ทั้งหมด + $exclude_dep_id
    $params = array_merge($type_ids, [$exclude_dep_id]);

    return dbQuery($sql, $types, $params);
}

/**
 * ดึงรายการผู้ใช้ (สารบรรณ) ตามหน่วยงานที่เลือก
 * @param array $dep_ids_select อาร์เรย์ของ dep_id
 * @return mixed ผลลัพธ์จาก dbQuery หรือ false
 */
function processUserSelectionByDep(array $dep_ids_select) {
    if (empty($dep_ids_select)) return false;
    
    $placeholders = implode(',', array_fill(0, count($dep_ids_select), '?'));
    
    // สร้าง SQL Query: WHERE u.dep_id IN (?, ?, ...)
    $sql = "SELECT u.u_id, s.sec_id, d.dep_id
            FROM user u 
            INNER JOIN section s ON s.sec_id=u.sec_id
            INNER JOIN depart d ON d.dep_id=u.dep_id
            WHERE u.dep_id IN ($placeholders) AND u.level_id = 3";
            
    // สร้าง types string: 'i' สำหรับ dep_ids_select ทุกตัว
    $types = str_repeat('i', count($dep_ids_select));
    
    return dbQuery($sql, $types, $dep_ids_select);
}

?>

<script type='text/javascript'>
    // ตั้งค่า DataTable หลังการโหลด DOM (ซ้ำซ้อนกับด้านบน, เลือกใช้แค่ที่เดียว)
    $('#tbOutside').DataTable({
        "order": [
            [0, "desc"]
        ]
    })
</script>

<script language="JavaScript">
    
    // ใช้สำหรับเปลี่ยนโหมดการเลือกผู้รับ
    function setEnabledTo2(obj) {
        // ซ่อน/แสดง div เลือกผู้รับทั้งหมด
        document.getElementById('ckToType').style.display = 'none';
        document.getElementById('ckToSome').style.display = 'none';

        // เคลียร์ค่า input text
        obj.form.toSomeUser.disabled = true;
        obj.form.toSomeOneUser.disabled = true;

        if (obj.value == "2") { // แยกตามประเภท
            document.getElementById('ckToType').style.display = 'block';
            obj.form.toSomeUser.disabled = false; 
        } else if (obj.value == "3") { // เลือกเอง
            document.getElementById('ckToSome').style.display = 'block';
            obj.form.toSomeOneUser.disabled = false;
        } 
        
        // Ensure other radio buttons are unchecked (though native HTML usually handles this)
        if (obj.id !== 'toAll') obj.form.toAll.checked = false;
        if (obj.id !== 'toSome') obj.form.toSome.checked = false;
        if (obj.id !== 'toSomeOne') obj.form.toSomeOne.checked = false;
    }

</script>

<script type="text/javascript">
    function updateRecipientInput(inputElement, id) {
        let m = inputElement.value;
        let id_with_pipe = '|' + id;

        if (event.target.checked) {
            // เพิ่ม ID หากยังไม่มี
            if (m.indexOf(id_with_pipe) < 0) {
                m += id_with_pipe;
            }
        } else {
            // ลบ ID
            m = m.replace(id_with_pipe, '');
        }

        // ลบ | ตัวแรก ถ้ามี
        if (m.startsWith('|')) {
            m = m.substring(1);
        }
        
        inputElement.value = m;
    }
    
    // ฟังค์ชั่นกรณีเลือกเป็นประเภท
    function listType(checkbox, type_id) { 
        updateRecipientInput(document.fileout.toSomeUser, type_id);
    }

    // ฟังค์ชั่นกรณีเลือกส่วนราชการเอง
    function listSome(checkbox, dep_id) { 
        updateRecipientInput(document.fileout.toSomeOneUser, dep_id);
    }
    
    // ลบ listOne ออกเนื่องจากไม่ได้ใช้ในฟอร์มนี้
    /*function listOne(a, b, c) { ... }*/ 
</script>