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
       WHERE bookd.book_detail_id =$book_id ";
//echo $sql;

$result = dbQuery($sql);
$row = dbFetchArray($result);
//$status=$row['status'];
$strDate = $row['date_in'];
$dateThai = DateThai($strDate);
$book_detail_id = $row['book_detail_id'];

$file_upload = $row['file_upload'];
?>
<div class="detail-modal-container">
    <center>
        <form name="edit" action="flow-resive-province.php" method="post" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <table class="detail-table" border="0">
                <tr>
                    <td width="160" class="detail-label"><i class="fas fa-hashtag"></i> เลขหนังสือ</td>
                    <td>
                        <div class="detail-value"><?php print $row['book_no'] ?></div>
                    </td>
                    <td width="160" class="detail-label"><i class="fas fa-barcode"></i> ทะเบียนกลาง</td>
                    <td>
                        <div class="detail-value"><?php print $row['book_id'] ?></div>
                    </td>
                </tr>
                <tr>
                    <td class="detail-label"><i class="far fa-calendar-alt"></i> ลงวันที่เอกสาร</td>
                    <td>
                        <div class="detail-value"><?php print thaiDate($row['date_book']); ?></div>
                    </td>
                    <td class="detail-label"><i class="far fa-clock"></i> วันที่บันทึก</td>
                    <td>
                        <div class="detail-value"><?php print thaiDate($row['date_in']); ?></div>
                    </td>
                </tr>
                <tr>
                    <td class="detail-label"><i class="fas fa-paper-plane"></i> ผู้ส่ง</td>
                    <td colspan="3"><input disabled type="text" value="<?php print $row['sendfrom']; ?>"></td>
                </tr>
                <tr>
                    <td class="detail-label"><i class="fas fa-user-tag"></i> ผู้รับ</td>
                    <td colspan="3"><input disabled type="text" value="<?php print $row['sendto']; ?>"></td>
                </tr>
                <tr>
                    <td class="detail-label"><i class="fas fa-align-left"></i> เรื่อง</td>
                    <td colspan="3"><input disabled type="text" value="<?php print $row['title']; ?>"></td>
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
                    <?php
                    $status = $row['status'];
                    switch ($status) {
                        case 0:
                            $txtStatus = "รอลงรับ";
                            break;
                        case 1:
                            $txtStatus = "ลงรับ";
                            break;
                        default:
                            $txtStatus = "แสดงผลรายละเอียด";
                            break;
                    }
                    ?>
                    <td class="detail-label"><i class="fas fa-info-circle"></i> สถานะ</td>
                    <td><input disabled type="text" value="<?= $txtStatus ?>"></td>
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
                    $practice = $row['practice'];
                    $practice_row = ['dep_name' => ''];
                    if ($practice) {
                        $sql_practice = "SELECT dep_name FROM depart WHERE dep_id=?";
                        $result_practice = dbQuery($sql_practice, "i", [(int) $practice]);
                        $practice_row = dbFetchArray($result_practice);
                    }
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
                <?php if ($file_upload != '') { ?>
                    <tr>
                        <td class="detail-label"><i class="fas fa-file-download"></i> ไฟล์แนบ</td>
                        <td colspan="3">
                            <div class="detail-value-text">
                                <a class="btn btn-primary" href="<?php print $row['file_upload']; ?>" target="_blank">
                                    <i class="fa fa-file"></i> คลิกเพื่อดาวน์โหลด
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </form>
    </center>
</div>

<!-- form send  -->