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
<style>
.meeting-detail-table {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    margin: 0 auto;
    max-width: 600px;
    font-size: 1.05em;
}
.meeting-detail-table th, .meeting-detail-table td {
    vertical-align: middle !important;
    border-top: none !important;
}
.meeting-detail-label {
    font-weight: bold;
    color: #2c3e50;
    width: 30%;
    background: #f7f7f7;
}
.meeting-detail-value {
    color: #333;
}
.meeting-detail-img {
    border-radius: 10px;
    border: 1px solid #e0e0e0;
    margin: 18px 0 12px 0;
    box-shadow: 0 1px 6px rgba(0,0,0,0.07);
}
@media (max-width: 767px) {
    .meeting-detail-table {
        font-size: 0.98em;
        max-width: 100%;
    }
}
</style>
<table class="table table-bordered table-hover meeting-detail-table">
    <tr>
        <td colspan="2" class="text-center" style="background: #f9f9f9;">
            <img src="doc/<?= $roomimg ?>" class="img-responsive img-rounded meeting-detail-img" style="max-width:300px; height:auto; display:inline-block;" alt="รูปห้องประชุม">
            <div style="font-size:1.2em; color:#2980b9; margin-top:8px;">
                <i class="fas fa-door-open"></i> <?= htmlspecialchars($row['roomname']) ?>
            </div>
        </td>
    </tr>
    <tr>
        <td class="meeting-detail-label"><i class="fas fa-map-marker-alt"></i> ที่อยู่:</td>
        <td class="meeting-detail-value"><?= htmlspecialchars($row['roomplace']) ?></td>
    </tr>
    <tr>
        <td class="meeting-detail-label"><i class="fas fa-users"></i> ความจุ:</td>
        <td class="meeting-detail-value"><?= (int)$row['roomcount'] ?> คน</td>
    </tr>
    <tr>
        <td class="meeting-detail-label"><i class="fas fa-coins"></i> ค่าธรรมเนียมเต็มวัน:</td>
        <td class="meeting-detail-value"><?= htmlspecialchars($row['money1']) ?> บาท</td>
    </tr>
    <tr>
        <td class="meeting-detail-label"><i class="fas fa-coins"></i> ค่าธรรมเนียมครึ่งวัน:</td>
        <td class="meeting-detail-value"><?= htmlspecialchars($row['money2']) ?> บาท</td>
    </tr>
    <tr>
        <td class="meeting-detail-label"><i class="fas fa-tools"></i> อุปกรณ์:</td>
        <td class="meeting-detail-value">
            <span>
                <input type="checkbox" disabled <?= $row['sound'] == 1 ? 'checked' : '' ?>> ระบบเสียง
            </span>
            <span style="margin-left:10px;">
                <input type="checkbox" disabled <?= $row['vga'] == 1 ? 'checked' : '' ?>> ระบบแสดงผล
            </span>
            <span style="margin-left:10px;">
                <input type="checkbox" disabled <?= $row['vcs'] == 1 ? 'checked' : '' ?>> ระบบประชุมทางไกล
            </span>
        </td>
    </tr>
    <tr>
        <td class="meeting-detail-label"><i class="fas fa-phone"></i> เบอร์ติดต่อ:</td>
        <td class="meeting-detail-value"><?= htmlspecialchars($row['tel']) ?></td>
    </tr>
</table>

