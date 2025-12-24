<?php
date_default_timezone_set('Asia/Bangkok');
include 'function.php';
include '../library/database.php';
include '../library/security.php';

$hire_id = (int) ($_POST['buy_id'] ?? 0);
$u_id = (int) ($_POST['u_id'] ?? 0);

$sql = "SELECT h.*, d.dep_name, s.sec_name, y.yname, u.firstname
      FROM buy as h
      INNER JOIN depart as d ON d.dep_id = h.dep_id
      INNER JOIN section as s ON s.sec_id = h.sec_id
      INNER JOIN user as u ON u.u_id = h.u_id
      INNER JOIN year_money as y ON y.yid = h.yid
      WHERE h.buy_id = ?";

$result = dbQuery($sql, "i", [$hire_id]);
$row = dbFetchAssoc($result);
?>
<table border=1 width=100%>
    <tr>
        <td><label>ทะเบียนคุมสัญญา:</label></td>
        <td><?php echo htmlspecialchars($row['rec_no'] ?? '') ?>/<?php echo htmlspecialchars($row['yname'] ?? ''); ?></td>
    </tr>
    <tr>
        <td><label>วันที่ทำรายการ:</label></td>
        <td><?php echo thaiDate($row['date_submit'] ?? ''); ?></td>
    </tr>
    <tr>
        <td><label>รายการซื้อ/ขาย:</label></td>
        <td><?php echo htmlspecialchars($row['title'] ?? '') ?></td>
    </tr>
    <tr>
        <td><label>วงเงินโครงการ</label></td>
        <td><?php echo number_format($row['money_project'] ?? 0); ?> -บาท</td>
    </tr>
    <tr>
        <td><label>หลักประกัน:</label></td>
        <td><?php echo number_format($row['money'] ?? 0); ?> -บาท</td>
    </tr>
    <tr>
        <td><label>บริษัท/ร้าน:</label></td>
        <td><?php echo htmlspecialchars($row['company'] ?? ''); ?></td>
    </tr>
    <tr>
        <td><label>ผู้จัดการร้าน/เจ้าของ:</label></td>
        <td><?php echo htmlspecialchars($row['manager'] ?? ''); ?></td>
    </tr>
    <tr>
        <td><label>วันที่ส่งงาน:</label></td>
        <td><?php echo thaiDate($row['date_stop'] ?? ''); ?></td>
    </tr>
    <tr>
        <td><label>ที่อยู่ร้าน:</label></td>
        <td><?php echo htmlspecialchars($row['add1'] ?? ''); ?></td>
    </tr>
    <tr>
        <td><label>ผู้ลงนาม:</label></td>
        <td><?php echo htmlspecialchars($row['signer'] ?? ''); ?></td>
    </tr>
    <tr>
        <td><label>ที่อยู่:</label></td>
        <td><?php echo htmlspecialchars($row['add2'] ?? ''); ?></td>
    </tr>
    <tr>
        <td><label>วันครบกำหนดงวดสุดท้าย:</label></td>
        <td><?php echo thaiDate($row['date_stop'] ?? ''); ?></td>
    </tr>
    <tr>
        <td><label>หลักประกันสัญญา:</label></td>
        <?php
        $confirm = $row['confirm_id'] ?? 0;
        if ($confirm == 1) {
            $type = "เงินสด";
        } elseif ($confirm == 2) {
            $type = "เช็คธนาคาร";
        } elseif ($confirm == 3) {
            $type = "หนังสือค้ำประกันธนาคาร";
        } elseif ($confirm == 4) {
            $type = "หนังสือค้ำประกันของบริษัทเงินทุน";
        } elseif ($confirm == 5) {
            $type = "พันธบัตร";
        } elseif ($confirm == 0) {
            $type = "ไม่มี";
        } else {
            $type = "ไม่ระบุ";
        }
        ?>
        <td><?php echo $type; ?></td>
    </tr>

    <tr>
        <td><label>เจ้าของงบประมาณ:</label></td>
        <td><?php echo htmlspecialchars($row['dep_name'] ?? '') ?></td>

    </tr>
    <tr>
        <td><label>กลุ่ม/หน่วยย่อย:</label></td>
        <td><?php echo htmlspecialchars($row['sec_name'] ?? '') ?></td>
    </tr>
    <tr>
        <td><label>เจ้าหน้าที่</label></td>
        <td><?php echo htmlspecialchars($row['firstname'] ?? '') ?></td>
    </tr>
</table>