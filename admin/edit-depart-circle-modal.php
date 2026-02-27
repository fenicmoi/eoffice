<?php
date_default_timezone_set('Asia/Bangkok');
include 'function.php';
include '../library/database.php';

$cid = $_POST['cid'];
$u_id = $_POST['u_id'];

$sqlFlowCircle = "SELECT * FROM flowcircle_depart WHERE cid=?";
$resSqlFlowCircle = dbQuery($sqlFlowCircle, "i", [(int) $cid]);
$rowFlowCircle = dbFetchAssoc($resSqlFlowCircle);

if (!$rowFlowCircle) {
    echo "ไม่สามารถเลือกข้อมูลระบบได้";
    exit();
}

$speed = $rowFlowCircle['speed_id'];
$sec_id = $rowFlowCircle['sec_id'];
$obj_id = $rowFlowCircle['obj_id'];
$sendFrom = $rowFlowCircle['sendfrom'];
$sendTo = $rowFlowCircle['sendto'];
$title = $rowFlowCircle['title'];
$refer = $rowFlowCircle['refer'];
$attachment = $rowFlowCircle['attachment'];
$prefex = $rowFlowCircle['prefex'];
$rec_no = $rowFlowCircle['rec_no'];
$practice = $rowFlowCircle['practice'];
$file_location = $rowFlowCircle['file_location'];
$dateout = $rowFlowCircle['dateout'];

// Get year
$sqlYear = "SELECT * FROM sys_year WHERE status=1";
$resYear = dbQuery($sqlYear);
$data = dbFetchArray($resYear);
$yname = $data[1];
?>
<form name="formEdit" method="post" action="circleoffice.php" enctype="multipart/form-data">
    <input type="hidden" name="cid" value="<?php echo $cid; ?>">
    <table width="100%" class="table table-bordered">
        <tr>
            <td>
                <label>ประเภทหนังสือ :</label>
                <div>
                    <input name="typeDoc" type="radio" value="0" disabled> ปกติ
                    <input name="typeDoc" type="radio" value="1" checked=""> เวียน
                </div>
            </td>
            <td>
                <label>ปีเอกสาร:</label>
                <input class="form-control" name="yearDoc" type="text" value="<?php print $yname; ?>" disabled>
            </td>
        </tr>
        <tr>
            <td>
                <label>วันที่ทำรายการ :</label>
                <input type="text" class="form-control" name="currentDate" value="<?php echo thaiDate($dateout); ?>"
                    disabled>
            </td>
            <td>
                <label>วัตถุประสงค์:</label>
                <select name="obj_id" class="form-control" required>
                    <?php
                    $sql = "SELECT * FROM object ORDER BY obj_id";
                    $result = dbQuery($sql);
                    while ($row = dbFetchArray($result)) {
                        $selected = ($row['obj_id'] == $obj_id) ? "selected" : "";
                        echo "<option value='" . $row['obj_id'] . "' $selected>" . $row['obj_name'] . "</option>";
                    }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>
                <label>เลขทะเบียนส่ง:</label>
                <input type="text" class="form-control" name="prefex" id="prefex"
                    value="<?php print $prefex; ?>/ว <?php print $rec_no; ?>" disabled>
            </td>
            <td>
                <label>ลงวันที่ :</label>
                <input class="form-control" type="date" name="dateout" value="<?php echo $dateout; ?>" required>
            </td>
        </tr>
        <tr>
            <td>
                <label>ชั้นความเร็ว:</label>
                <select name="speed_id" id="speed_id" class="form-control">
                    <?php
                    $sql = "SELECT * FROM speed ORDER BY speed_id";
                    $result = dbQuery($sql);
                    while ($rowSpeed = dbFetchArray($result)) {
                        $selected = ($rowSpeed['speed_id'] == $speed) ? "selected" : "";
                        echo "<option value='" . $rowSpeed['speed_id'] . "' $selected>" . $rowSpeed['speed_name'] . "</option>";
                    }
                    ?>
                </select>
            </td>
            <td>
                <label>ชั้นความลับ:</label>
                <select name="sec_id" id="sec_id" class="form-control">
                    <?php
                    $sql = "SELECT * FROM secret ORDER BY sec_id";
                    $result = dbQuery($sql);
                    while ($rowSecret = dbFetchArray($result)) {
                        $selected = ($rowSecret['sec_id'] == $sec_id) ? "selected" : "";
                        echo "<option value='" . $rowSecret['sec_id'] . "' $selected>" . $rowSecret['sec_name'] . "</option>";
                    }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>
                <label>แสดงผลหน้าเว็บไซต์</label>
                <div>
                    <input type="radio" name="open" value="1" checked><label>แสดง</label>
                    <input type="radio" name="open" value="0"><label>ไม่แสดง</label>
                </div>
            </td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2">
                <label>เรื่อง:</label>
                <input class="form-control" type="text" name="title" value="<?php print htmlspecialchars($title); ?>"
                    required>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <label>ผู้ส่ง:</label>
                <input class="form-control" type="text" name="sendfrom"
                    value="<?php print htmlspecialchars($sendFrom); ?>" required>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <label>ผู้รับ:</label>
                <input class="form-control" type="text" name="sendto" value="<?php print htmlspecialchars($sendTo); ?>"
                    required>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <label>อ้างถึง:</label>
                <input class="form-control" type="text" name="refer" value="<?php print htmlspecialchars($refer); ?>">
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <label>สิ่งที่ส่งมาด้วย:</label>
                <input class="form-control" type="text" name="attachment"
                    value="<?php print htmlspecialchars($attachment); ?>">
            </td>
        </tr>
        <tr>
            <td>
                <label>ผู้เสนอ:</label>
                <input class="form-control" type="text" name="practice"
                    value="<?php print htmlspecialchars($practice); ?>">
            </td>
            <td>
                <label>ที่เก็บเอกสาร:</label>
                <input class="form-control" type="text" name="file_location"
                    value="<?php print htmlspecialchars($file_location); ?>">
            </td>
        </tr>
    </table>
    <center>
        <button class="btn btn-primary" type="submit" name="update">
            <i class="fas fa-save"></i> บันทึกการแก้ไข
        </button>
    </center>
</form>