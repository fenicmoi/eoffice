<?php
date_default_timezone_set('Asia/Bangkok');
include 'function.php';
include '../library/database.php';

// ป้องกัน SQL Injection
$room_id = isset($_POST['room_id']) ? (int)$_POST['room_id'] : 0;
$u_id = isset($_POST['u_id']) ? (int)$_POST['u_id'] : 0;

$sql = "SELECT * FROM meeting_room WHERE room_id = $room_id";
$result = dbQuery($sql);
$row = dbFetchAssoc($result);

// ตรวจสอบไฟล์รูปภาพก่อนแสดง
$roomimg = (!empty($row['roomimg']) && file_exists("doc/" . $row['roomimg'])) ? htmlspecialchars($row['roomimg']) : "no-image.png";
?>
<table class="table table-bordered table-hover" width="100%">
    <tr>
        <td colspan="2" class="text-center">
            <img src="doc/<?= $roomimg ?>" class="img-responsive img-rounded" style="max-width:300px; height:auto;" alt="รูปห้องประชุม">
        </td>
    </tr>
    <tr>
        <td width="20%"><label>ชื่อห้อง:</label></td>
        <td><?= htmlspecialchars($row['roomname']) ?></td>
    </tr>
    <tr>
        <td><label>ที่อยู่:</label></td>
        <td><?= htmlspecialchars($row['roomplace']) ?></td>
    </tr>
    <tr>
        <td><label>ความจุผู้เข้าประชุม:</label></td>
        <td><?= (int)$row['roomcount'] ?> คน</td>
    </tr>
    <tr>
        <td><label>ค่าธรรมเนียมเต็มวัน:</label></td>
        <td><?= htmlspecialchars($row['money1']) ?> บาท</td>
    </tr>
    <tr>
        <td><label>ค่าธรรมเนียมครึ่งวัน:</label></td>
        <td><?= htmlspecialchars($row['money2']) ?> บาท</td>
    </tr>
    <tr>
        <td><label>อุปกรณ์อำนวยความสะดวก:</label></td>
        <td>
            <input type="checkbox" disabled <?= $row['sound'] == 1 ? 'checked' : '' ?>> ระบบเสียง
            <input type="checkbox" disabled <?= $row['vga'] == 1 ? 'checked' : '' ?>> ระบบแสดงผล
            <input type="checkbox" disabled <?= $row['vcs'] == 1 ? 'checked' : '' ?>> ระบบประชุมทางไกล
        </td>
    </tr>
    <tr>
        <td><label>เบอร์ติดต่อ:</label></td>
        <td><?= htmlspecialchars($row['tel']) ?></td>
    </tr>
</table>

