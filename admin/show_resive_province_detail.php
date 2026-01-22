<!-- auto complate -->
<?php
date_default_timezone_set('Asia/Bangkok');
// $u_id=$_SESSION['ses_u_id'];

include 'function.php';
include '../library/database.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['ses_u_id'])) {
    header("location:../index.php");
}
?>
<?php
// รับค่ามาจาก javascript from flow-resive-province
$u_id = $_POST['u_id'];
$rec_id = $_POST['rec_id'];
$book_id = $_POST['book_id'];
$level_id = $_SESSION['ses_level_id'];
//print $level_id;


$sql = "SELECT  bookm.book_id, bookm.u_id as owner_id, bookd.*,o.obj_name,spe.speed_name,p.pri_name,u.firstname,s.sec_name,s.sec_code,dep.dep_name,year.yname
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
//echo $sql;

$result = dbQuery($sql);
$row = dbFetchArray($result);
//$status=$row['status'];
$strDate = $row['date_in'];
$dateThai = DateThai($strDate);
$book_detail_id = $row['book_detail_id'];
$owner_id = $row['owner_id'];
$current_uid = $_SESSION['ses_u_id'];
$is_owner = ($owner_id == $current_uid);

$readonly = !$is_owner ? "readonly" : "";
$disabled = !$is_owner ? "disabled" : "";

if (isset($row['file_location'])) {
    $showFile = "<a href='$row[file_location]' target='_balnk'>Download เอกสาร</a>";
} else {
    $showFile = "ไม่มีไฟล์แนบ";
}

//$file_upload = $row['file_location'];

?>
<div class="detail-modal-container">
    <form name="edit" action="flow-resive-province.php" method="post" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="book_id" value="<?php echo $book_id; ?>">
        <input type="hidden" name="book_detail_id" value="<?php echo $book_detail_id; ?>">
        <input type="hidden" name="file_location_old" value="<?php echo $row['file_location']; ?>">

        <table class="detail-table">
            <tr>
                <td class="detail-label"><i class="fas fa-hashtag"></i> เลขหนังสือ</td>
                <td>
                    <input type="text" class="form-control" name="book_no"
                        value="<?php echo htmlspecialchars($row['book_no']); ?>" <?php echo $readonly; ?>>
                </td>
                <td class="detail-label"><i class="fas fa-barcode"></i> ทะเบียนกลาง</td>
                <td>
                    <div class="detail-value"><?php echo (int) $row['book_id']; ?></div>
                </td>
            </tr>
            <tr>
                <td class="detail-label"><i class="far fa-calendar-alt"></i> ลงวันที่เอกสาร</td>
                <td>
                    <input type="date" class="form-control" name="date_book" value="<?php echo $row['date_book']; ?>"
                        onKeyDown="return false" <?php echo $readonly; ?>>
                </td>
                <td class="detail-label"><i class="far fa-clock"></i> วันที่บันทึก</td>
                <td>
                    <input type="text" class="form-control" name="date_in" value="<?php echo $row['date_in']; ?>" <?php echo $readonly; ?>>
                </td>
            </tr>
            <tr>
                <td class="detail-label"><i class="fas fa-paper-plane"></i> ผู้ส่ง</td>
                <td colspan="3"><input type="text" class="form-control" name="sendfrom"
                        value="<?php echo htmlspecialchars($row['sendfrom']); ?>" <?php echo $readonly; ?>>
                </td>
            </tr>
            <tr>
                <td class="detail-label"><i class="fas fa-user-tag"></i> ผู้รับ</td>
                <td colspan="3"><input type="text" class="form-control" name="sendto"
                        value="<?php echo htmlspecialchars($row['sendto']); ?>" <?php echo $readonly; ?>>
                </td>
            </tr>
            <tr>
                <td class="detail-label"><i class="fas fa-align-left"></i> เรื่อง</td>
                <td colspan="3"><input type="text" class="form-control" name="title"
                        value="<?php echo htmlspecialchars($row['title']); ?>" <?php echo $readonly; ?>></td>
            </tr>
            <tr>
                <td class="detail-label"><i class="fas fa-shield-alt"></i> ชั้นความลับ</td>
                <td>
                    <select class="form-control" name="pri_id" <?php echo $disabled; ?>>
                        <?php
                        $sql_p = "SELECT * FROM priority ORDER BY pri_id";
                        $res_p = dbQuery($sql_p);
                        while ($r_p = dbFetchArray($res_p)) {
                            $selected = ($r_p['pri_id'] == $row['pri_id']) ? "selected" : "";
                            echo "<option value='" . $r_p['pri_id'] . "' $selected>" . $r_p['pri_name'] . "</option>";
                        }
                        ?>
                    </select>
                </td>
                <td class="detail-label"><i class="fas fa-bolt"></i> ชั้นความเร็ว</td>
                <td>
                    <select class="form-control" name="speed_id" <?php echo $disabled; ?>>
                        <?php
                        $sql_s = "SELECT * FROM speed ORDER BY speed_id";
                        $res_s = dbQuery($sql_s);
                        while ($r_s = dbFetchArray($res_s)) {
                            $selected = ($r_s['speed_id'] == $row['speed_id']) ? "selected" : "";
                            echo "<option value='" . $r_s['speed_id'] . "' $selected>" . $r_s['speed_name'] . "</option>";
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="detail-label"><i class="fas fa-bullseye"></i> วัตถุประสงค์</td>
                <td>
                    <select class="form-control" name="obj_id" <?php echo $disabled; ?>>
                        <?php
                        $sql_o = "SELECT * FROM object ORDER BY obj_id";
                        $res_o = dbQuery($sql_o);
                        while ($r_o = dbFetchArray($res_o)) {
                            $selected = ($r_o['obj_id'] == $row['obj_id']) ? "selected" : "";
                            echo "<option value='" . $r_o['obj_id'] . "' $selected>" . $r_o['obj_name'] . "</option>";
                        }
                        ?>
                    </select>
                </td>
                <td class="detail-label"><i class="fas fa-info-circle"></i> สถานะ</td>
                <td>
                    <div class="detail-value text-primary">กำลังดำเนินการ</div>
                </td>
            </tr>
            <tr>
                <td class="detail-label"><i class="fas fa-link"></i> อ้างถึง</td>
                <td colspan="3"><textarea class="form-control" name="reference" rows="2" <?php echo $readonly; ?>><?php print $row['reference']; ?></textarea></td>
            </tr>
            <tr>
                <td class="detail-label"><i class="fas fa-paperclip"></i> สิ่งที่ส่งมาด้วย</td>
                <td colspan="3"><textarea class="form-control" name="attachment" rows="2" <?php echo $readonly; ?>><?php print $row['attachment']; ?></textarea></td>
            </tr>
            <tr>
                <td class="detail-label"><i class="fas fa-university"></i> หน่วยดำเนินการ</td>
                <td colspan="3">
                    <select class="form-control selectpicker" data-live-search="true" name="practice"
                        style="width: 100%;" <?php echo $disabled; ?>>
                        <option value="">-- เลือกหน่วยปฏิบัติ --</option>
                        <?php
                        $sql_d = "SELECT * FROM depart ORDER BY dep_name";
                        $res_d = dbQuery($sql_d);
                        while ($r_d = dbFetchArray($res_d)) {
                            $selected = ($r_d['dep_id'] == $row['practice']) ? "selected" : "";
                            echo "<option value='" . $r_d['dep_id'] . "' $selected>" . $r_d['dep_name'] . "</option>";
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="detail-label"><i class="fas fa-user-edit"></i> ผู้บันทึก</td>
                <td colspan="3">
                    <div class="detail-value-text">
                        <?php echo htmlspecialchars($row['firstname']); ?>
                        <span class="text-muted"
                            style="font-weight: 400; font-size: 0.9rem; margin-left: 0.5rem;">(<?php echo htmlspecialchars($row['dep_name']); ?>)</span>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="detail-label"><i class="fas fa-file-download"></i> ไฟล์แนบ</td>
                <td colspan="3">
                    <div class="row">
                        <div class="col-md-8">
                            <input type="file" name="file_location" class="form-control" <?php echo $disabled; ?>>
                        </div>
                        <div class="col-md-4">
                            <div class="detail-value-text" style="color: #4e73df; font-size: 0.9rem;">
                                <?php echo $showFile; ?>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="4" style="padding-top: 2rem;">
                    <hr style="border-top: 1px solid #eaecf4; margin-bottom: 2rem;">

                    <div class="text-center">
                        <?php if ($is_owner) { ?>
                            <button class="btn btn-warning btn-lg" type="submit" name="btnUpdate"
                                style="min-width: 160px; font-weight: 700; border-radius: 30px; margin-right: 15px;">
                                <i class="fas fa-save"></i> บันทึกแก้ไข
                            </button>

                            <button class="btn btn-success btn-lg" type="submit" name="resive"
                                style="min-width: 160px; font-weight: 700; border-radius: 30px; margin-right: 5px;">
                                <i class="fas fa-check-circle"></i> ลงรับหนังสือ
                            </button>

                            <button class="btn btn-danger btn-lg" type="submit" name="reply"
                                style="min-width: 160px; font-weight: 700; border-radius: 30px;">
                                <i class="fas fa-undo"></i> ส่งคืนหนังสือ
                            </button>
                        <?php } else { ?>
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i> คุณสามารถดูข้อมูลได้เพียงอย่างเดียว
                                เนื่องจากไม่ได้เป็นผู้ลงทะเบียนหนังสือฉบับนี้
                            </div>
                        <?php } ?>
                    </div>
                </td>
            </tr>
        </table>
    </form>
</div>
<script>
    $('.selectpicker').selectpicker(); // Initialize selectpicker
</script>