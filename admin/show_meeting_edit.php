<!-- bootstrap select autocomplete -->
<link rel="stylesheet" href="css/bootstrap-select.css">
<script src="js/bootstrap-select.js"></script>
<script type="text/javascript">
    $('.selectpicker').selectpicker({});
</script>
<?php
session_start();
$dep_id = isset($_SESSION['ses_dep_id']) ? (int)$_SESSION['ses_dep_id'] : 0;

date_default_timezone_set('Asia/Bangkok');
include 'function.php';
include '../library/database.php';

$room_id = isset($_POST['room_id']) ? (int)$_POST['room_id'] : 0;
$u_id = isset($_POST['u_id']) ? (int)$_POST['u_id'] : 0;

$sql = "SELECT * FROM meeting_room WHERE room_id = $room_id";
$result = dbQuery($sql);
$row = dbFetchAssoc($result);

// ตรวจสอบไฟล์รูปภาพก่อนแสดง
$roomimg = (!empty($row['roomimg']) && file_exists("doc/" . $row['roomimg'])) ? htmlspecialchars($row['roomimg']) : "no-image.png";
?>
<!-- ปรับปรุงให้ responsive ด้วย Bootstrap -->
<form method="post" action="meet_room.php" enctype="multipart/form-data">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 text-center">
                <img src="doc/<?= $roomimg ?>" width="100%" style="max-width:300px; height:auto;" class="img-thumbnail" alt="รูปห้องประชุม">
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-6">
                <div class="form-group">
                    <label>ชื่อห้อง:</label>
                    <input name="roomname" type="text" class="form-control" value="<?= htmlspecialchars($row['roomname']) ?>" required>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="form-group">
                    <label>ที่อยู่:</label>
                    <input name="roomplace" type="text" class="form-control" value="<?= htmlspecialchars($row['roomplace']) ?>" required>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-4">
                <div class="form-group">
                    <label>ความจุผู้เข้าประชุม:</label>
                    <input name="roomcount" type="number" class="form-control" value="<?= (int)$row['roomcount'] ?>" min="1" required>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="form-group">
                    <label>ค่าธรรมเนียมเต็มวัน:</label>
                    <input name="money1" type="number" class="form-control" value="<?= htmlspecialchars($row['money1']) ?>" min="0" required>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="form-group">
                    <label>ค่าธรรมเนียมครึ่งวัน:</label>
                    <input name="money2" type="number" class="form-control" value="<?= htmlspecialchars($row['money2']) ?>" min="0" required>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <label>อุปกรณ์อำนวยความสะดวก:</label><br>
                    <label class="checkbox-inline">
                        <input name="t1" type="checkbox" value="1" <?= $row['sound'] == 1 ? 'checked' : '' ?>> ระบบเสียง
                    </label>
                    <label class="checkbox-inline">
                        <input name="t2" type="checkbox" value="1" <?= $row['vga'] == 1 ? 'checked' : '' ?>> ระบบแสดงผล
                    </label>
                    <label class="checkbox-inline">
                        <input name="t3" type="checkbox" value="1" <?= $row['vcs'] == 1 ? 'checked' : '' ?>> ระบบประชุมทางไกล
                    </label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-6">
                <div class="form-group">
                    <label>เบอร์ติดต่อ:</label>
                    <input name="tel" type="text" class="form-control" value="<?= htmlspecialchars($row['tel']) ?>">
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="form-group">
                    <label>สถานะการใช้งาน:</label><br>
                    <label class="radio-inline">
                        <input name="room_status" type="radio" value="1" <?= $row['room_status'] == 1 ? 'checked' : '' ?>> จองออนไลน์
                    </label>
                    <label class="radio-inline">
                        <input name="room_status" type="radio" value="2" <?= $row['room_status'] == 2 ? 'checked' : '' ?>> จองผ่านสมุด
                    </label>
                    <label class="radio-inline">
                        <input name="room_status" type="radio" value="0" <?= $row['room_status'] == 0 ? 'checked' : '' ?>> งดใช้งาน
                    </label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <label>รูปห้องประชุม:</label>
                    <input type="file" name="fileUpload" class="form-control" accept="image/*">
                </div>
            </div>
        </div>
        <input type="hidden" name="room_id" value="<?= $room_id ?>">
        <div class="row">
            <div class="col-12 text-center">
                <button class="btn btn-primary btn-lg" type="submit" name="edit" id="edit">
                    <i class="fas fa-save"></i> บันทึก
                </button>
            </div>
        </div>
    </div>
</form>
<style>
/* Responsive fix for mobile */
@media (max-width: 767px) {
    .form-group label {
        display: block;
        margin-bottom: 0.2em;
    }
    .checkbox-inline, .radio-inline {
        display: block;
        margin-bottom: 0.5em;
    }
}
</style>

