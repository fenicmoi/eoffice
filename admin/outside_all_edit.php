<?php
date_default_timezone_set('Asia/Bangkok');
include "header.php";
?>
<style>
    .file-upload-row {
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .btn-remove-file {
        color: #e74a3b;
        cursor: pointer;
        font-size: 1.2em;
    }

    .btn-remove-file:hover {
        color: #be2617;
    }
</style>
<script>
    $(document).ready(function () {
        // Function to add new file row
        $("#add-file-btn").click(function () {
            const newRow = `
                <div class="file-upload-row">
                    <input type="file" name="fileupload[]" class="form-control">
                    <i class="fas fa-minus-circle btn-remove-file" title="ลบไฟล์นี้"></i>
                </div>
            `;
            $("#file-upload-container").append(newRow);
        });

        // Function to remove file row
        $(document).on('click', '.btn-remove-file', function () {
            $(this).closest('.file-upload-row').remove();
        });

        // Confirm delete existing file
        $(".btn-delete-existing").click(function (e) {
            if (!confirm('ยืนยันลาลบไฟล์นี้?')) {
                e.preventDefault();
            }
        });
    });
</script>
<?php



//checkuser login
if (!isset($_SESSION['ses_u_id'])) {
    header("Location: ../index.php");
    exit();
} else {
    $u_id = $_SESSION['ses_u_id'];
    $pid = $_GET['pid'];
}

// --- HANDLE FILE DELETION ---
if (isset($_GET['action']) && $_GET['action'] == 'del_file' && isset($_GET['fid'])) {
    $fid = (int) $_GET['fid'];
    // Get file path
    $sql_f = "SELECT file_path FROM paper_file WHERE fid = $fid";
    $res_f = dbQuery($sql_f);
    if ($row_f = dbFetchAssoc($res_f)) {
        $file_path = $row_f['file_path'];
        // Delete physical file
        if (file_exists($file_path)) {
            unlink($file_path);
        }
        // Delete DB record
        $sql_del = "DELETE FROM paper_file WHERE fid = $fid";
        dbQuery($sql_del);

        // Sync Legacy Main File Column
        $sql_main = "SELECT file FROM paper WHERE pid = $pid";
        $res_main = dbQuery($sql_main);
        if ($row_main = dbFetchAssoc($res_main)) {
            if ($row_main['file'] == $file_path) {
                dbQuery("UPDATE paper SET file='' WHERE pid = $pid");
            }
        }

    }
    // Redirect to avoid re-submit
    echo "<script>window.location.href='outside_all_edit.php?pid=$pid';</script>";
    exit;
}
// ----------------------------

$sql = "SELECT pid,title,book_no,file FROM paper  WHERE pid=$pid";

$result = dbQuery($sql);
$row = dbFetchAssoc($result);

$link_file = $row['file'];
?>
<div class="col-md-2">
    <?php
    $menu = checkMenu($level_id);
    include $menu;
    ?>
</div>
<div class="col-md-10">
    <div class="panel panel-primary">
        <div class="panel-heading"><i class="fas fa-share-square fa-2x"></i> <strong>ส่งเอกสารภายในจังหวัด</strong>
        </div>
        <div class="panel-body">
            <ul class="nav nav-tabs">
                <li><a class="btn-danger fas fa-envelope" href="paper.php"> จดหมายเข้า</a></li>
                <li><a class="btn-danger fas fa-envelope-open" href="folder.php"> รับแล้ว</a></li>
                <li><a class="btn-danger fas fa-history" href="history.php"> ส่งแล้ว</a></li>
                <li><a class="btn-danger fas fa-paper-plane" href="inside_all.php"> ส่งภายใน</a></li>
                <li class="active"><a class="btn-danger fas fa-globe" href="outside_all.php"> ส่งภายนอก [แก้ไข]</a></li>
            </ul>
            <br>
            <form id="fileout" name="fileout" method="post" enctype="multipart/form-data">
                <div class="form-group form-inline">
                    <label for="title">ชื่อเอกสาร:</label>
                    <input class="form-control" type="text" name="title" size="100%"
                        value="<?php print $row['title']; ?>">
                </div>
                <div class="form-group form-inline">
                    <label for="book_no">เลขหนังสือ:</label>
                    <input class="form-control" type="text" name="book_no" size="100%"
                        value="<?php print $row['book_no']; ?>">
                </div>

                <div class="form-group">
                    <label>ไฟล์แนบเดิม:</label>
                    <ul>
                        <?php
                        // 1. Show Main File (Legacy)
                        if (!empty($row['file'])) {
                            echo "<li><a href='{$row['file']}' target='_blank'>{$row['file']}</a> (ไฟล์หลัก)</li>";
                        }
                        // 2. Show Additional Files (paper_file)
                        $sql_pf = "SELECT * FROM paper_file WHERE pid = $pid";
                        $res_pf = dbQuery($sql_pf);
                        while ($row_pf = dbFetchAssoc($res_pf)) {
                            echo "<li>
                                        <a href='{$row_pf['file_path']}' target='_blank'>{$row_pf['file_name']}</a> 
                                        <a href='outside_all_edit.php?pid=$pid&action=del_file&fid={$row_pf['fid']}' class='text-danger btn-delete-existing'>[ลบ]</a>
                                      </li>";
                        }
                        ?>
                    </ul>
                </div>

                <div class="form-group">
                    <label for="fileupload">แนบไฟล์เพิ่ม:</label>
                    <div id="file-upload-container">
                        <div class="file-upload-row">
                            <input type="file" name="fileupload[]" class="form-control">
                        </div>
                    </div>
                    <button type="button" id="add-file-btn" class="btn btn-sm btn-success" style="margin-top: 5px;">
                        <i class="fas fa-plus"></i> เพิ่มไฟล์
                    </button>
                    <small class="text-muted" style="display: block; margin-top: 5px;">
                        * สามารถแนบได้หลายไฟล์พร้อมกัน
                    </small>
                </div>

                <div class="form-group form-inline">
                    <label for="detail">รายละเอียด</label>
                    <textarea name="detail" rows="3" cols="60">-</textarea>
                </div>
                <center>
                    <div class="form-group">

                        <input type="hidden" name="pid" id="pid" value="<?php print $row['pid']; ?>" />
                        <input type="submit" name="sendOut" class="btn btn-primary btn-lg" value="บันทึก" />
                        <a href="history.php" class="btn btn-danger btn-lg">ยกเลิก</a>
                    </div>
                </center>
            </form>
        </div>
        <div class="panel-footer"></div>
    </div>
</div>

<?php
/*++++++++++++++++++++++++++++PROCESS+++++++++++++++++++++++++++*/

if (isset($_POST['sendOut'])) {                   //ตรวจสอบปุ่ม sendOut
    $pid = $_POST['pid'];                         //รหัสเอกสารส่งที่ต้องการแก้ไข
    $title = $_POST['title'];                     //ช	ื่อเอกสาร
    $date = date('YmdHis');                       //วันเวลาปัจจุบัน
    $detail = $_POST['detail'];                   //รายละเอียด
    $book_no = $_POST['book_no'];                 //เลขที่หนังสือ
    $upload_dir = "paper/";

    // 1. Update Key Details
    $sql = "UPDATE paper SET title ='$title', detail='$detail', book_no='$book_no', edit='$date' WHERE pid=$pid ";


    // 2. Handle File Uploads (Multiple)
    $uploaded_files = [];
    $allowed_extensions = array('pdf', 'png', 'jpg', 'jpeg', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'zip', '7z', 'rar', 'zipx');

    if (isset($_FILES['fileupload']) && is_array($_FILES['fileupload']['name'])) {
        foreach ($_FILES['fileupload']['name'] as $key => $filename) {
            if ($_FILES['fileupload']['error'][$key] === UPLOAD_ERR_NO_FILE)
                continue;

            $tmp_name = $_FILES['fileupload']['tmp_name'][$key];
            $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

            if (in_array($ext, $allowed_extensions)) {
                $date_prefix = date("YmdHis");
                $random_num = mt_rand(100000, 999999);
                $new_filename = $date_prefix . "_" . $random_num . "_" . $key . "." . $ext;
                $target_path = $upload_dir . $new_filename;

                if (move_uploaded_file($tmp_name, $target_path)) {
                    // Insert into paper_file
                    $sql_file = "INSERT INTO paper_file (pid, file_path, file_name, upload_date) VALUES ('$pid', '$target_path', '$filename', NOW())";
                    dbQuery($sql_file);

                    // Sync Legacy Main File Column (if empty)
                    $sql_chk = "SELECT file FROM paper WHERE pid = $pid";
                    $res_chk = dbQuery($sql_chk);
                    if ($row_chk = dbFetchAssoc($res_chk)) {
                        if (empty($row_chk['file'])) {
                            dbQuery("UPDATE paper SET file='$target_path' WHERE pid = $pid");
                        }
                    }

                }
            }
        }
    }




    $result = dbQuery($sql);
    if (!$result) {
        echo "<script>
                    swal({
                     title:'มีบางอย่างผิดพลาด กรุณาตรวจสอบ',
                     type:'warning',
                     showConfirmButton:true
                     },
                     function(isConfirm){
                         if(isConfirm){
                             window.location.href='history.php';
                         }
                     }); 
                   </script>";
    } else {
        echo "<script>
                    swal({
                     title:'แก้ไขข้อมูลเรียบร้อยแล้ว',
                     type:'success',
                     showConfirmButton:true
                     },
                     function(isConfirm){
                         if(isConfirm){
                             window.location.href='history.php';
                         }
                     }); 
                   </script>";
    }  //check db 
}  //send out
