<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['ses_u_id'])) {
    header("location:../index.php");
}
$level_id = $_SESSION['ses_level_id'];
date_default_timezone_set('Asia/Bangkok');
// $u_id=$_SESSION['ses_u_id'];
include 'function.php';
include '../library/database.php';
include '../library/security.php';

?>
<?php
// รับค่ามาจาก javascript from flow-resive-province
$u_id = $_POST['u_id'];
$rec_id = $_POST['rec_id'];
$book_id = $_POST['book_id'];


$sql = "SELECT  bookm.book_id,bookd.*,o.obj_name,spe.speed_name,p.pri_name,u.firstname,s.sec_name,s.sec_code,dep.dep_name,year.yname
       FROM  book_master  bookm
       INNER JOIN book_detail bookd ON bookd.book_id = bookm.book_id
       INNER JOIN user u ON  u.u_id = bookm.u_id 
       INNER JOIN section s ON s.sec_id = bookm.sec_id 
       INNER JOIN object o ON o.obj_id = bookm.obj_id
       INNER JOIN speed spe ON spe.speed_id=bookm.speed_id
       INNER JOIN depart dep ON dep.dep_id = bookm.dep_id 
       INNER JOIN sys_year year ON year.yid = bookm.yid 
       INNER JOIN priority p ON p.pri_id = bookm.pri_id
       WHERE bookm.book_id = ? ";

$result = dbQuery($sql, "i", [(int) $book_id]);
$row = dbFetchArray($result);
//$status=$row['status'];
$strDate = $row['date_in'];
$dateThai = DateThai($strDate);
$book_detail_id = $row['book_detail_id'];

$file_upload = $row['file_location'];
?>
<!-- <div class="well"> -->

<div class="detail-modal-container">
    <center>
        <form name="edit" action="FlowResiveProvince.php" method="post" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <table class="detail-table" border="0">
                <tr>
                    <td width="160" class="detail-label"><i class="fas fa-hashtag"></i> เลขหนังสือ</td>
                    <td>
                        <div class="detail-value"><?php echo htmlspecialchars($row['book_no']); ?></div>
                    </td>
                    <td width="160" class="detail-label"><i class="fas fa-barcode"></i> ทะเบียนกลาง</td>
                    <td>
                        <div class="detail-value"><?php echo (int) $row['book_id']; ?></div>
                    </td>
                </tr>
                <tr>
                    <td class="detail-label"><i class="far fa-calendar-alt"></i> ลงวันที่เอกสาร</td>
                    <td>
                        <div class="detail-value"><?php echo thaiDate($row['date_book']); ?></div>
                    </td>
                    <td class="detail-label"><i class="far fa-clock"></i> วันที่บันทึก</td>
                    <td>
                        <div class="detail-value"><?php echo thaiDate($row['date_in']); ?></div>
                    </td>
                </tr>
                <tr>
                    <td class="detail-label"><i class="fas fa-paper-plane"></i> ผู้ส่ง</td>
                    <td colspan="3"><input disabled type="text"
                            value="<?php echo htmlspecialchars($row['sendfrom']); ?>"></td>
                </tr>
                <tr>
                    <td class="detail-label"><i class="fas fa-user-tag"></i> ผู้รับ</td>
                    <td colspan="3"><input disabled type="text" value="<?php echo htmlspecialchars($row['sendto']); ?>">
                    </td>
                </tr>
                <tr>
                    <td class="detail-label"><i class="fas fa-align-left"></i> เรื่อง</td>
                    <td colspan="3"><input disabled type="text" value="<?php echo htmlspecialchars($row['title']); ?>">
                    </td>
                </tr>
                <tr>
                    <td class="detail-label"><i class="fas fa-shield-alt"></i> ชั้นความลับ</td>
                    <td><input disabled type="text" value="<?php print $row['pri_name']; ?>"></td>
                    <td class="detail-label"><i class="fas fa-bolt"></i> ชั้นความเร็ว</td>
                    <td><input disabled type="text" value="<?php print $row['speed_name']; ?>"></td>
                </tr>
                <tr>
                    <td class="detail-label"><i class="fas fa-bullseye"></i> วัตถุประสงค์</td>
                    <td><input disabled type="text" value="<?php print $row['obj_name']; ?>"></td>
                    <td class="detail-label"><i class="fas fa-info-circle"></i> สถานะ</td>
                    <td><input disabled type="text" value="แสดงผลรายละเอียด"></td>
                </tr>
                <tr>
                    <td class="detail-label"><i class="fas fa-link"></i> อ้างถึง</td>
                    <td colspan="3"><textarea disabled rows="2"><?php print $row['reference']; ?></textarea></td>
                </tr>
                <tr>
                    <td class="detail-label"><i class="fas fa-paperclip"></i> สิ่งที่ส่งมาด้วย</td>
                    <td colspan="3"><textarea disabled rows="2"><?php print $row['attachment']; ?></textarea></td>
                </tr>
                <tr>
                    <?php
                    $practice_id = $row['practice'];
                    $sql_practice = "SELECT dep_name FROM depart WHERE dep_id = ?";
                    $result_practice = dbQuery($sql_practice, "i", [(int) $practice_id]);
                    $practice_row = dbFetchArray($result_practice);
                    ?>
                    <td class="detail-label"><i class="fas fa-university"></i> หน่วยดำเนินการ</td>
                    <td colspan="3">
                        <div class="detail-value-text"><label
                                id="under"><?php echo htmlspecialchars($practice_row['dep_name'] ?? ''); ?></label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="detail-label"><i class="fas fa-user-edit"></i> ผู้บันทึก</td>
                    <td colspan="3">
                        <div class="detail-value-text">
                            <?php echo htmlspecialchars($row['firstname']); ?>
                            <span class="text-muted"
                                style="font-weight: 400; font-size: 1.4rem;">(<?php echo htmlspecialchars($row['dep_name']); ?>)</span>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" style="padding-top: 2rem;">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="book_detail_id" value="<?php echo (int) $book_detail_id; ?>">
                        <div class="text-center">
                            <button class="btn btn-success btn-lg" type="submit" name="resive"
                                style="padding: 1rem 3rem; font-weight: 600;">
                                <i class="fas fa-check-circle"></i> ลงรับหนังสือ
                            </button>
                            &nbsp;&nbsp;
                            <button class="btn btn-danger btn-lg" type="submit" name="reply"
                                style="padding: 1rem 3rem; font-weight: 600;">
                                <i class="fas fa-undo"></i> ส่งคืนหนังสือ
                            </button>
                        </div>
                    </td>
                </tr>
            </table>
        </form>
    </center>
</div>
<!-- </div> -->

<!-- form send  -->