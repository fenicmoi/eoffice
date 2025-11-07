<?php
ob_start(); 

/**
 * outside_all.php - หน้าบันทึกหนังสือราชการภายนอก (V21: Final Syntax Correction)
 * - แก้ไข Parse Error ด้วยการใช้ Alternative Syntax (:, endif;, endwhile;) เพื่อความเสถียรสูงสุด
 */

date_default_timezone_set('Asia/Bangkok');
$title = "ระบบสารบรรณอิเล็กทรอนิกส์ (ส่งหนังสือภายนอก)";
include "header.php"; 

global $dbConn; 

// ====================================================
// 1. Initial Setup and Data Loading
// ====================================================
if (!isset($_SESSION['ses_u_id'])) {
    header("Location: ../index.php");
    exit();
}

// ตรวจสอบและกำหนดค่าตัวแปร Session
$u_id = (int)($_SESSION['ses_u_id'] ?? 0);
$sec_id = (int)($_SESSION['ses_sec_id'] ?? 0);
$dep_id = (int)($_SESSION['ses_dep_id'] ?? 0);
$level_id = (int)($_SESSION['ses_level_id'] ?? 0);

// Default Form State
$title_post = '';
$book_no = '';
$detail = '';
$errors = []; 
$success_save = false; 

// ดึงค่าจาก POST สำหรับ Sticky Form (ใช้ค่าว่างถ้าไม่มี)
$send_mode = htmlspecialchars($_POST['send_mode'] ?? 'all', ENT_QUOTES, 'UTF-8'); 
$toSomeOneUser = htmlspecialchars($_POST['toSomeOneUser'] ?? '', ENT_QUOTES, 'UTF-8'); 

// Recipient data derived from toSomeOneUser
$selected_types = []; 
$selected_dep_ids = []; 
$recipients_dep_ids = [];


// Constants and Data Fetching
define('UPLOAD_DIR', 'paper/'); 
define('MAX_FILE_SIZE', 10 * 1024 * 1024); // 10MB
$allowed_extensions = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'jpg', 'jpeg', 'png', 'zip', 'rar'];


// Function: โหลดข้อมูลประเภทหน่วยงาน
function fetch_depart_types() {
    return dbQuery("SELECT t.type_id, t.type_name, 
                            (SELECT COUNT(d.dep_id) FROM depart d WHERE d.type_id = t.type_id AND d.status = 1) as count 
                            FROM office_type t ORDER BY t.type_name ASC");
}

// Function: โหลดข้อมูลหน่วยงานทั้งหมด
function fetch_all_departs() {
    return dbQuery("SELECT d.dep_id, d.dep_name, t.type_name 
                        FROM depart d 
                        INNER JOIN office_type t ON t.type_id = d.type_id 
                        WHERE d.status = 1 
                        ORDER BY d.dep_name ASC");
}

$depart_types = fetch_depart_types();
$all_departs = fetch_all_departs();


// ====================================================
// 2. Form Submission Handler (เมื่อมีการ POST ข้อมูล)
// ====================================================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // 2.1 Sanitize and Extract Input
    $title_post = trim(htmlspecialchars($_POST['title'] ?? '', ENT_QUOTES, 'UTF-8'));
    $book_no = trim(htmlspecialchars($_POST['book_no'] ?? '', ENT_QUOTES, 'UTF-8'));
    $detail = trim(htmlspecialchars($_POST['detail'] ?? '', ENT_QUOTES, 'UTF-8'));
    
    // Parse the single recipient input (V17/V18 FIX)
    if ($send_mode === 'type' && !empty($toSomeOneUser)) {
        $selected_types = array_filter(array_map('intval', explode('|', trim($toSomeOneUser, '|'))));
    } elseif ($send_mode === 'manual' && !empty($toSomeOneUser)) {
        $selected_dep_ids = array_filter(array_map('intval', explode('|', trim($toSomeOneUser, '|'))));
    }

    // 2.2 Validation Logic - Centralized error collection
    
    // Check main inputs
    if (empty($title_post)) $errors[] = "กรุณาระบุ 'เรื่อง'";
    if (empty($book_no)) $errors[] = "กรุณาระบุ 'เลขที่หนังสือ'";
    if (empty($detail)) $errors[] = "กรุณาระบุ 'รายละเอียด'";
    
    
    // Determine Recipients based on send_mode and validate selection
    if (empty($send_mode)) {
        $errors[] = "กรุณาเลือก 'วิธีการส่ง'";
        
    } elseif ($send_mode === 'all') {
        // Mode: All
        $res_all = dbQuery("SELECT dep_id FROM depart WHERE status = 1");
        if ($res_all) {
            while ($row = dbFetchArray($res_all)) {
                $recipients_dep_ids[] = (int)$row['dep_id'];
            }
        }
    } elseif ($send_mode === 'type') {
        // Mode: By Type
        if (empty($selected_types)) {
             $errors[] = "กรุณาเลือกอย่างน้อยหนึ่งประเภทหน่วยงาน";
        } else {
            // Prepared Statement to get recipients from selected types
            $placeholders = implode(',', array_fill(0, count($selected_types), '?'));
            $types_type = str_repeat('i', count($selected_types)); 
            $sql_type = "SELECT dep_id FROM depart WHERE type_id IN ($placeholders) AND status = 1";
            $res_type = dbQuery($sql_type, $types_type, $selected_types); 
            
            if ($res_type) {
                while ($row = dbFetchArray($res_type)) {
                    $recipients_dep_ids[] = (int)$row['dep_id'];
                }
            }
        }
    } elseif ($send_mode === 'manual') {
        // Mode: Manual
        $recipients_dep_ids = $selected_dep_ids; 
        
        if (empty($selected_dep_ids)) {
             $errors[] = "กรุณาเลือกอย่างน้อยหนึ่งหน่วยงาน";
        }
    }

    // Final check: Must have recipients if no other errors occurred
    if (empty($recipients_dep_ids) && empty($errors)) {
        $errors[] = "ไม่พบหน่วยงานผู้รับตามตัวเลือกที่กำหนด";
    }


    // 2.3 File Upload Handling
    $file_name = '';
    $file_path = '';
    $upload_error = $_FILES['file_upload']['error'] ?? UPLOAD_ERR_NO_FILE;

    if ($upload_error === UPLOAD_ERR_OK) {
        $file = $_FILES['file_upload'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        // Validation: Size and Extension
        if ($file['size'] > MAX_FILE_SIZE) {
            $errors[] = "ขนาดไฟล์ต้องไม่เกิน " . (MAX_FILE_SIZE / 1024 / 1024) . " MB";
        }
        if (!in_array($ext, $allowed_extensions)) {
            $errors[] = "ประเภทไฟล์ไม่ถูกต้อง อนุญาตเฉพาะ: " . implode(', ', $allowed_extensions);
        }

        if (empty($errors)) {
            // Generate unique file name
            $file_name = time() . '-' . uniqid() . '.' . $ext;
            $file_path = UPLOAD_DIR . $file_name; 

            // Move file
            if (!move_uploaded_file($file['tmp_name'], $file_path)) {
                $errors[] = "เกิดข้อผิดพลาดในการอัปโหลดไฟล์ (ตรวจสอบสิทธิ์การเขียนของโฟลเดอร์: " . UPLOAD_DIR . ")";
            }
        }
    } else if ($upload_error !== UPLOAD_ERR_NO_FILE) {
         $errors[] = "เกิดข้อผิดพลาดในการอัปโหลดไฟล์ (Code: " . $upload_error . ") - **โปรดตรวจสอบขนาดไฟล์แนบ**";
    } else {
         if(empty($errors)) $errors[] = "กรุณาเลือกไฟล์เอกสาร";
    }


    // 2.4 Database Transaction and Save
    if (empty($errors)) {
        
        // Start Transaction for Atomicity
        if ($dbConn instanceof mysqli) {
            $dbConn->begin_transaction();
        } 
        
        $postdate = date("Y-m-d H:i:s");
        $edit_date = date("Y-m-d");

        // Insert into paper (Table: paper)
        $sql_paper = "INSERT INTO paper (title, detail, file, postdate, u_id, insite, outsite, sec_id, dep_id, book_no, edit) 
                      VALUES (?, ?, ?, ?, ?, 0, 1, ?, ?, ?, ?)";
        
        $params_paper = [$title_post, $detail, $file_path, $postdate, $u_id, $sec_id, $dep_id, $book_no, $edit_date];
        $types_paper = 'ssssiiiss'; 
        
        $insert_paper_ok = dbQuery($sql_paper, $types_paper, $params_paper);
        $pid = $insert_paper_ok ? dbInsertId() : false; 

        if ($pid !== false) {
            $all_ok = true;
            $confirmdate = '0000-00-00 00:00:00'; 
            
            // Insert into paperuser for all recipients (Table: paperuser)
            $sql_paperuser = "INSERT INTO paperuser (pid, u_id, sec_id, dep_id, confirm, confirmdate) 
                              VALUES (?, 0, 0, ?, 0, ?)";
            $types_user = 'iis'; 

            foreach ($recipients_dep_ids as $dep_id_rec) {
                $params_user = [$pid, (int)$dep_id_rec, $confirmdate];
                
                if (!dbQuery($sql_paperuser, $types_user, $params_user)) {
                    $all_ok = false;
                    break; 
                }
            }

            if ($all_ok) {
                // Success: Commit and Flag
                $dbConn->commit();
                $success_save = true; 
            } else {
                // Error on Recipient Insert: Rollback and cleanup file
                $dbConn->rollback();
                if (file_exists($file_path)) { unlink($file_path); }
                $errors[] = "การบันทึกข้อมูลผู้รับไม่สำเร็จ โปรดลองใหม่อีกครั้ง";
            }
            
        } else {
            // Error on Paper Insert: Rollback and cleanup file
            $dbConn->rollback();
            if (file_exists($file_path)) { unlink($file_path); }
            $errors[] = "เกิดข้อผิดพลาดในการบันทึกข้อมูลหลัก (paper)";
        }
    }
}


// ====================================================
// 3. Presentation Logic / Sticky Form Display
// ====================================================
$displayDepartSelection = 'ยังไม่ได้เลือกหน่วยงาน'; 

if ($send_mode === 'all') {
    $displayDepartSelection = 'เลือกทุกส่วนราชการ';
} elseif ($send_mode === 'type' && !empty($selected_types)) {
    // Re-calculate the display text for sticky form/errors
    $types_count_map = [];
    if ($depart_types) { 
        // ต้อง dbdataSeek(..., 0) เนื่องจากใช้ $depart_types ซ้ำ
        dbdataSeek($depart_types, 0); 
        while ($row = dbFetchArray($depart_types)) {
            $types_count_map[$row['type_id']] = (int)$row['count'];
        }
    }
    
    $totalCount = 0;
    foreach ($selected_types as $type_id) {
        $totalCount += $types_count_map[$type_id] ?? 0;
    }
    $count_type = count($selected_types);
    $displayDepartSelection = "เลือก {$count_type} ประเภท ({$totalCount} หน่วยงาน)";
    
} elseif ($send_mode === 'manual' && !empty($selected_dep_ids)) {
    $count = count($selected_dep_ids);
    $displayDepartSelection = "เลือกแล้ว {$count} หน่วยงาน";
}


// ====================================================
// 4. HTML/JS Output (ใช้ Alternative Syntax)
// ====================================================
?>

<link rel="stylesheet" type="text/css" href="../bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<style>
.modal-body-scroll {
    max-height: 70vh;
    overflow-y: auto;
}
</style>

<div class="row">
    
    <div class="col-md-2">
        <?php
        $menu = checkMenu($level_id);
        include $menu;
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

                <div class="box box-primary" style="border-top: none;">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-envelope-o"></i> ส่งหนังสือราชการภายนอก</h3>
                    </div>
                    <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                        <div class="box-body">
                            
                            <?php if (!empty($errors)): // ใช้ Alternative Syntax ?>
                                <div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <h4><i class="icon fa fa-ban"></i> ข้อผิดพลาด!</h4>
                                    <ul>
                                        <?php foreach ($errors as $error): ?>
                                            <li><?= $error ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php endif; // สิ้นสุด Alternative Syntax ?>

                            <div class="form-group">
                                <label for="book_no" class="col-sm-2 control-label">เลขที่หนังสือ <span class="text-danger">*</span></label>
                                <div class="col-sm-4">
                                    <input type="text" name="book_no" id="book_no" class="form-control" value="<?= htmlspecialchars($book_no, ENT_QUOTES, 'UTF-8') ?>" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="title" class="col-sm-2 control-label">เรื่อง <span class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    <input type="text" name="title" id="title" class="form-control" value="<?= htmlspecialchars($title_post, ENT_QUOTES, 'UTF-8') ?>" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="detail" class="col-sm-2 control-label">รายละเอียด <span class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    <textarea name="detail" id="detail" class="form-control" rows="3" required><?= htmlspecialchars($detail, ENT_QUOTES, 'UTF-8') ?></textarea>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="file_upload" class="col-sm-2 control-label">ไฟล์เอกสาร <span class="text-danger">*</span></label>
                                <div class="col-sm-6">
                                    <input type="file" name="file_upload" id="file_upload" required>
                                    <p class="help-block">อนุญาต: <?= implode(', ', $allowed_extensions) ?> (ไม่เกิน <?= MAX_FILE_SIZE / 1024 / 1024 ?> MB)</p>
                                </div>
                            </div>

                            <hr>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">วิธีการส่ง <span class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    <label class="radio-inline">
                                        <input type="radio" name="send_mode" id="send_mode_all" value="all" <?= $send_mode == 'all' ? 'checked' : '' ?>> 
                                        **ทุกส่วนราชการ**
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="send_mode" id="send_mode_type" value="type" <?= $send_mode == 'type' ? 'checked' : '' ?>> 
                                        แยกตามประเภท
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="send_mode" id="send_mode_manual" value="manual" <?= $send_mode == 'manual' ? 'checked' : '' ?>> 
                                        เลือกเอง
                                    </label>
                                </div>
                            </div>

                            <div class="form-group" id="recipient_buttons_group">
                                <label class="col-sm-2 control-label"></label>
                                <div class="col-sm-10">
                                    <button type="button" class="btn btn-info btn-flat" id="btnSelectType" data-toggle="modal" data-target="#modalSelectType">
                                        <i class="fa fa-th-large"></i> เลือกประเภทหน่วยงาน
                                    </button>
                                    <button type="button" class="btn btn-info btn-flat" id="btnSelectDepart" data-toggle="modal" data-target="#modalSelectDepart">
                                        <i class="fa fa-bank"></i> เลือกหน่วยงาน
                                    </button>
                                    <input type="text" class="form-control" id="displayDepartSelection" value="<?= htmlspecialchars($displayDepartSelection, ENT_QUOTES, 'UTF-8') ?>" readonly>
                                    <input type="hidden" name="toSomeOneUser" id="toSomeOneUser" value="<?= htmlspecialchars($toSomeOneUser, ENT_QUOTES, 'UTF-8') ?>">
                                </div>
                            </div>

                        </div>
                        <div class="box-footer">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-send"></i> บันทึกและส่งหนังสือ</button>
                                <a href="index.php" class="btn btn-default btn-flat">ยกเลิก</a>
                            </div>
                        </div>
                    </form>
                    </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalSelectType" tabindex="-1" role="dialog" aria-labelledby="modalSelectTypeLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modalSelectTypeLabel"><i class="fa fa-th-large"></i> เลือกประเภทหน่วยงาน</h4>
            </div>
            <div class="modal-body modal-body-scroll">
                <p>เลือกประเภทหน่วยงานที่ต้องการส่งหนังสือ</p>
                <div class="checkbox">
                    <label><input type="checkbox" id="selectAllType"> **เลือกทุกประเภท**</label>
                </div>
                <hr>
                <div class="row">
                    <?php if ($depart_types): // ใช้ Alternative Syntax ?>
                        <?php 
                        // ใช้ dbdataSeek() เพื่อนำ Cursor กลับไปเริ่มต้นใหม่
                        dbdataSeek($depart_types, 0); 
                        $pre_selected_types = $send_mode == 'type' ? $selected_types : [];
                        ?>

                        <?php while ($row = dbFetchArray($depart_types)): // ใช้ Alternative Syntax ?>
                            <?php
                            $type_id = $row['type_id'];
                            $type_name = htmlspecialchars($row['type_name'], ENT_QUOTES, 'UTF-8');
                            $count = number_format($row['count']);
                            $is_checked = in_array($type_id, $pre_selected_types) ? 'checked' : '';
                            ?>
                            <div class="col-sm-6">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" class="type-checkbox" value="<?= $type_id ?>" data-count="<?= $row['count'] ?>" <?= $is_checked ?>> 
                                        <?= $type_name ?> 
                                        <span class="badge" title="จำนวนหน่วยงานในประเภท"><?= $count ?></span>
                                    </label>
                                </div>
                            </div>
                        <?php endwhile; // สิ้นสุด Alternative Syntax ?>
                        
                        <?php if (dbNumRows($depart_types) == 0): // ใช้ Alternative Syntax ?>
                            <div class="col-xs-12"><p class="text-danger">ไม่พบข้อมูลประเภทหน่วยงานในฐานข้อมูล</p></div>
                        <?php endif; // สิ้นสุด Alternative Syntax ?>
                        
                    <?php else: // ใช้ Alternative Syntax ?>
                        <div class="col-xs-12"><p class="text-danger">เกิดข้อผิดพลาดในการโหลดข้อมูลประเภทหน่วยงาน (SQL Query Failed)</p></div>
                    <?php endif; // สิ้นสุด Alternative Syntax ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-flat" data-dismiss="modal"><i class="fa fa-times"></i> ยกเลิก</button>
                <button type="button" class="btn btn-success btn-flat" onclick="confirmTypeSelection()"><i class="fa fa-check"></i> ยืนยันการเลือก</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalSelectDepart" tabindex="-1" role="dialog" aria-labelledby="modalSelectDepartLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modalSelectDepartLabel"><i class="fa fa-bank"></i> เลือกหน่วยงานที่ต้องการส่ง</h4>
            </div>
            <div class="modal-body modal-body-scroll">
                <p>เลือกหน่วยงานจากรายการด้านล่าง (สามารถค้นหาได้)</p>
                <div class="checkbox">
                    <label><input type="checkbox" id="selectAllDepart"> **เลือกทุกหน่วยงานที่แสดง**</label>
                </div>
                <hr>
                <table id="departTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th style="width: 5%;"><i class="fa fa-check-square-o"></i></th>
                            <th style="width: 25%;">ประเภทหน่วยงาน</th>
                            <th style="width: 70%;">ชื่อหน่วยงาน</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $pre_selected_dep_ids = $send_mode == 'manual' ? $selected_dep_ids : [];

                        if ($all_departs): // ใช้ Alternative Syntax
                            dbdataSeek($all_departs, 0);
                            
                            while ($row = dbFetchArray($all_departs)): // ใช้ Alternative Syntax
                                $is_checked = in_array($row['dep_id'], $pre_selected_dep_ids) ? 'checked' : '';
                            ?>
                                <tr>
                                    <td>
                                        <input type="checkbox" class="depart-checkbox" value="<?= $row['dep_id'] ?>" data-name="<?= htmlspecialchars($row['dep_name'], ENT_QUOTES, 'UTF-8') ?>" <?= $is_checked ?>>
                                    </td>
                                    <td><?= htmlspecialchars($row['type_name'], ENT_QUOTES, 'UTF-8') ?></td>
                                    <td><?= htmlspecialchars($row['dep_name'], ENT_QUOTES, 'UTF-8') ?></td>
                                </tr>
                            <?php endwhile; // สิ้นสุด Alternative Syntax ?>
                            
                            <?php if (dbNumRows($all_departs) == 0): // ใช้ Alternative Syntax ?>
                                <tr><td colspan="3" class="text-danger">ไม่พบข้อมูลหน่วยงานในฐานข้อมูล</td></tr>
                            <?php endif; // สิ้นสุด Alternative Syntax ?>
                            
                        <?php else: // ใช้ Alternative Syntax ?>
                            <tr><td colspan="3" class="text-danger">เกิดข้อผิดพลาดในการโหลดข้อมูลหน่วยงานทั้งหมด (SQL Query Failed)</td></tr>
                        <?php endif; // สิ้นสุด Alternative Syntax ?>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-flat" data-dismiss="modal"><i class="fa fa-times"></i> ยกเลิก</button>
                <button type="button" class="btn btn-success btn-flat" onclick="confirmDepartSelection()"><i class="fa fa-check"></i> ยืนยันการเลือก</button>
            </div>
        </div>
    </div>
</div>

<?php if (isset($success_save) && $success_save === true): ?>
<script>
$(document).ready(function() {
    swal({
        title: "ส่งหนังสือสำเร็จ!",
        text: "หนังสือถูกบันทึกและส่งไปยังหน่วยงานผู้รับเรียบร้อยแล้ว",
        type: "success",
        showCancelButton: false,
        confirmButtonColor: "#5cb85c",
        confirmButtonText: "ตกลง (ไปที่ประวัติ)",
        closeOnConfirm: true
    },
    function(){
        window.location.href = 'history.php';
    });
});
</script>
<?php endif; ?>

<script src="../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

<script>
let departTableInstance = null;

$(document).ready(function() {
    
    var initialMode = $('input[name="send_mode"]:checked').val() || 'all';
    toggleRecipientControls(initialMode);
    
    // 1. การเปลี่ยนโหมด
    $('input[name="send_mode"]').on('change', function() {
        var mode = $(this).val();
        toggleRecipientControls(mode);
    });
    
    function toggleRecipientControls(mode) {
        $('#btnSelectType').hide();
        $('#btnSelectDepart').hide();
        
        var currentValue = $('#toSomeOneUser').val();

        if (mode === 'all') {
            // Nothing to show/hide
        } else if (mode === 'type') {
            $('#btnSelectType').show();
            if (currentValue === 'all' || currentValue === '') { 
                 $('#displayDepartSelection').val('ยังไม่ได้เลือกประเภทหน่วยงาน');
            }
        } else if (mode === 'manual') {
            $('#btnSelectDepart').show();
            if (currentValue === 'all' || currentValue === '') {
                $('#displayDepartSelection').val('ยังไม่ได้เลือกหน่วยงาน');
            }
        }
    }
    
    // 2. Modal 1: เลือกทุกประเภท
    $('#selectAllType').on('change', function() {
        $('.type-checkbox').prop('checked', this.checked);
    });

    // 3. Modal 2: การจัดการ DataTable 
    
    $('#modalSelectDepart').on('shown.bs.modal', function () {
        if (!$.fn.DataTable.isDataTable('#departTable')) {
            departTableInstance = $('#departTable').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Thai.json"
                },
                "pageLength": 10,
                "columnDefs": [
                    { "orderable": false, "targets": 0 }
                ]
            });
        }
        
        if (departTableInstance) {
            departTableInstance.columns.adjust().draw();
        }
    });

    // 3.2: เลือกทุกหน่วยงานใน DataTable ที่แสดงอยู่
    $('#selectAllDepart').on('change', function() {
        if (departTableInstance) {
            departTableInstance.rows({ filter: 'applied', page: 'current' }).nodes().to$().find('.depart-checkbox').prop('checked', this.checked);
        } else {
             $('.depart-checkbox').prop('checked', this.checked);
        }
    });
});

// ฟังก์ชันยืนยันการเลือกประเภท (Modal 1)
function confirmTypeSelection() {
    let selected = [];
    let totalCount = 0;
    
    $('.type-checkbox:checked').each(function() {
        selected.push(this.value);
        totalCount += parseInt($(this).data('count'));
    });
    
    document.getElementById('toSomeOneUser').value = '|' + selected.join('|');
    
    let displayText = '';
    if (selected.length > 0) {
        displayText = `เลือก ${selected.length} ประเภท (${totalCount} หน่วยงาน)`;
    } else {
        displayText = 'กรุณาเลือกประเภทหน่วยงาน';
        document.getElementById('toSomeOneUser').value = ''; 
    }
    document.getElementById('displayDepartSelection').value = displayText;
    
    $('#modalSelectType').modal('hide');
}

// ฟังก์ชันยืนยันการเลือกหน่วยงาน (Modal 2)
function confirmDepartSelection() {
    let selected = [];
    let names = [];
    
    document.querySelectorAll('#modalSelectDepart .depart-checkbox:checked').forEach(function(cb) {
        selected.push(cb.value);
        names.push(cb.dataset.name);
    });
    
    document.getElementById('toSomeOneUser').value = '|' + selected.join('|');
    
    let displayText = '';
    if (selected.length > 0) {
        displayText = `เลือกแล้ว ${selected.length} หน่วยงาน`;
        if (names.length <= 3) {
            displayText += ': ' + names.join(', ');
        } else {
            displayText += ': ' + names.slice(0, 3).join(', ') + ` และอีก ${names.length - 3} หน่วยงาน`;
        }
    } else {
        displayText = 'กรุณาเลือกหน่วยงาน';
        document.getElementById('toSomeOneUser').value = ''; 
    }
    document.getElementById('displayDepartSelection').value = displayText;
    
    $('#modalSelectDepart').modal('hide');
}
</script>