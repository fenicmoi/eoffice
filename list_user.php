<?php
// Display  user registry 
if (!defined('IS_SYSTEM_RUNNING')) {
    header('Location: index.php?menu=3');
    exit;
}

date_default_timezone_set('Asia/Bangkok');
include_once 'admin/function.php';

$sql = "SELECT *
        FROM  register_staf
        ORDER BY reg_id desc ";

$result = dbQuery($sql);

?>

<div class="row">

    <div class="col-md-12">
        <br><br><br>
        <table id="myTable" name="myTable" class="myTable">
            <thead class="alert alert-info">
                <tr>
                    <th>ส่วนราชการ</th>
                    <th>เลขส่วนราชการ</th>
                    <th>เจ้าหน้าที่สารบรรณ</th>
                    <th>ตำแหน่ง</th>
                    <th>โทรศัพท์</th>
                    <th>แฟกส์</th>
                    <th>อีเมลล์</th>
                    <th>เว็บไซต์</th>
                    <th>วันที่ลงทะเบียน</th>
                </tr>
            </thead>

            <tbody>
                <?php while ($row = dbFetchArray($result)) { ?>
                    <tr>
                        <td><?php echo $row['depart'] ?></td>
                        <td><?php echo $row['book_no'] ?></td>
                        <td><?php echo $row['fname'] ?>&nbsp&nbsp<?= $row['lname'] ?></td>
                        <td><?php echo $row['position'] ?></td>
                        <td><?php echo $row['office_tel'] ?></td>
                        <td><?php echo $row['office_fax'] ?></td>
                        <td><?php echo $row['email'] ?></td>
                        <td><?php echo $row['website'] ?></td>
                        <td><?php echo $row['date_add'] ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

</div>
<script type="text/javascript" language="javascript">
    $(document).ready(function () {
        $('#myTable').DataTable();
    });
</script>
<?php // Footer is included by index.php ?>