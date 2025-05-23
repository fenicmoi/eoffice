<link rel="stylesheet" href="../css/sweetalert.css">
<script src="../js/sweetalert.min.js"></script>
<?php
// ตั้งค่า timezone
date_default_timezone_set('Asia/Bangkok');
include 'function.php';
include '../library/database.php';

$cid = $_POST['cid'];
$u_id = $_POST['u_id'];
// echo "uid:" . $u_id;
$sql = "SELECT f.*, d.dep_name, s.sec_name, y.yname, u.firstname, o.obj_name, sp.speed_name
        FROM flowdepart AS f
        INNER JOIN section AS s ON s.sec_id = f.sec_id
        INNER JOIN depart AS d ON d.dep_id = s.dep_id
        INNER JOIN user AS u ON u.u_id = f.u_id
        INNER JOIN sys_year AS y ON y.yid = f.yid
        INNER JOIN object AS o ON o.obj_id = f.obj_id
        INNER JOIN speed AS sp ON sp.speed_id = f.speed_id
        WHERE cid = $cid";
// print $sql;
$result = dbQuery($sql);
$row = dbFetchAssoc($result);
$uid = $row['u_id'];
?>
<table border="1" width="100%" class="table table-hover">
    <tr>
        <td><label>เลขหนังสือ:</label></td>
        <td><?php echo $row['prefex']; ?><?php echo $row['rec_no']; ?></td>
    </tr>
    <tr>
        <td><label>วันที่ทำรายการ:</label></td>
        <td><?php echo thaiDate($row['dateout']); ?></td>
    </tr>
    <tr>
        <td><label>เรื่อง:</label></td>
        <td><?php echo $row['title']; ?></td>
    </tr>
    <tr>
        <td><label>วัตถุประสงค์:</label></td>
        <td><?php echo $row['obj_name']; ?></td>
    </tr>
    <tr>
        <td><label>ผู้ส่ง:</label></td>
        <td><?php echo $row['sendfrom']; ?></td>
    </tr>
    <tr>
        <td><label>ผู้รับ:</label></td>
        <td><?php echo $row['sendto']; ?></td>
    </tr>
    <tr>
        <td><label>อ้างถึง:</label></td>
        <td><?php echo $row['refer']; ?></td>
    </tr>
    <tr>
        <td><label>สิ่งที่ส่งมาด้วย:</label></td>
        <td><?php echo $row['attachment']; ?></td>
    </tr>
    <tr>
        <td><label>สำนักงาน:</label></td>
        <td><?php echo $row['dep_name']; ?></td>
    </tr>
    <tr>
        <td><label>กลุ่ม/หน่วยย่อย:</label></td>
        <td><?php echo $row['sec_name']; ?></td>
    </tr>
    <tr>
        <td><label>เจ้าหน้าที่:</label></td>
        <td><?php echo $row['firstname']; ?></td>
    </tr>
    <tr>
        <td><label>ไฟล์เอกสาร:</label></td>
        <?php 
        $fileupload = $row['file_upload'];
        if ($fileupload == '') {
            echo '<td>-</td>';
        } else { ?>
            <td><a class="btn btn-warning" href="<?php echo $fileupload; ?>" target="_blank"><i class="fa fa-download"></i> ดาวน์โหลด</a></td>
        <?php } ?>
    </tr>
</table>
