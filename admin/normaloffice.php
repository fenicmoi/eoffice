<?php
date_default_timezone_set('Asia/Bangkok');
include "header.php";
$u_id = $_SESSION['ses_u_id'];
?>
<?php
//ตรวจสอบปีเอกสารว่าเป็นปีปัจจุบันหรือไม่
list($yid, $yname, $ystatus) = chkYear();
$yid = $yid;
$yname = $yname;
$ystatus = $ystatus;
?>
<div class="col-md-2">
    <?php
    $menu = checkMenu($level_id);
    include $menu;
    ?>
</div>

<div class="col-md-10">
    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="fa fa-envelope fa-2x" aria-hidden="true"></i>
            <strong>ทะเบียนหนังสือส่งสำนักงานจังหวัด[ปกติ]</strong>
            <a href="" class="btn btn-primary btn-md pull-right" data-toggle="modal" data-target="#modalAdd"><i
                    class="fa fa-plus " aria-hidden="true"></i> ลงทะเบียนส่ง</a>
        </div>
        <table class="table table-bordered table-hover" id="dataTable">
            <thead class="bg-primary">
                <tr>
                    <th>เลขหนังสือ</th>
                    <th>เรื่อง</th>
                    <th>ลงวันที่</th>
                    <th>แก้ไข</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $count = 1;
                $sql = "SELECT * FROM  flownormal_depart   ORDER BY cid DESC";
                $result = page_query($dbConn, $sql, 10);

                while ($row = dbFetchArray($result)) { ?>
                    <tr>
                        <td>
                            <?php echo $row['prefex']; ?>/
                            <?php echo $row['rec_no']; ?>
                        </td>
                        <td>
                            <?php
                            $cid = $row['cid'];
                            ?>
                            <a href="#" onClick="loadData('<?php print $cid; ?>','<?php print $u_id; ?>');"
                                data-toggle="modal" data-target=".bs-example-modal-table">
                                <?php echo $row['title']; ?>
                            </a>
                        </td>
                        <td>
                            <?php echo thaiDate($row['dateline']); ?>
                        </td>
                        <td>
                            <?php
                            $curDate = date('Y-m-d');
                            $dateLine = $row['dateline'];
                            $date_diff = getNumDay($dateLine, $curDate);

                            if ($date_diff <= 7) { ?>
                                <a class="btn btn-success btn-block"
                                    href="flow-normal-edit.php?u_id=<?= $u_id ?>&cid=<?= $cid ?>&type=depart"><i
                                        class="fas fa-edit"></i></a>
                            <?php } else if ($date_diff > 7) { ?>
                                    <center><i class="fas fa-lock fa-2x"></i></center>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
                <tr>
                    <td colspan="8">
                        <center>
                            <a href="index_admin.php" class="btn btn-primary"><i class="fas fa-home"></i></a>
                            <?php
                            page_link_border("solid", "1px", "gray");
                            page_link_bg_color("lightblue", "pink");
                            page_link_font("14px");
                            page_link_color("blue", "red");
                            page_echo_pagenums(6, true);
                            ?>
                        </center>
                    </td>
                </tr>
            </tbody>
        </table>
    </div> <!-- panel -->

    <!-- Model -->
    <!-- เพิ่มหนังสือ -->
    <div id="modalAdd" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-plus-circle"></i> ออกเลขหนังสือส่งปกติ</h4>
                </div>
                <div class="modal-body bg-success">
                    <form name="form" method="post" enctype="multipart/form-data">
                        <table width="800">
                            <tr>
                                <td>
                                    <div class="form-group form-inline">
                                        <label for="typeDoc">ประเภทหนังสือ :</label>
                                        <input class="form-control" name="typeDoc" type="radio" value="0" checked="">
                                        ปกติ
                                        <input class="form-control" name="typeDoc" type="radio" value="1" disabled>
                                        เวียน
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon">ปีเอกสาร:</span>
                                            <input class="form-control" name="yearDoc" type="text"
                                                value="<?php print $yname; ?>" disabled="">
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon">วันที่ทำรายการ:</span>
                                            <input class="form-control" type="text" name="currentDate"
                                                value="<?php print DateThai(); ?>" disabled="">
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon">วัตถุประสงค์:</span>
                                            <select name="obj_id" class="form-control" required>
                                                <?php
                                                $sql = "SELECT * FROM object ORDER BY obj_id";
                                                $result = dbQuery($sql);
                                                while ($row = dbFetchArray($result)) {
                                                    echo "<option  value=" . $row['obj_id'] . ">" . $row['obj_name'] . "</option>";
                                                } ?>
                                            </select>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?php
                            $sql = "SELECT section.sec_code,user.firstname,user.sec_id  FROM section,user  WHERE user.u_id = $u_id AND user.sec_id = section.sec_id ";
                            $result = dbQuery($sql);
                            $rowPrefex = dbFetchArray($result);
                            $prefex = $rowPrefex['sec_code'];
                            $firstname = $rowPrefex['firstname'];
                            ?>
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon">เลขประจำส่วนราชการ:</span>
                                            <input type="text" class="form-control" name="prefex" id="prefex"
                                                value="<?php echo $prefex; ?>">
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon">เลขทะเบียนส่ง:</span>
                                            <kbd>ออกโดยระบบ</kbd>
                                        </div>
                                </td>
                            </tr>
                            <?php
                            //ชั้นความเร็ว
                            $sql = "SELECT * FROM speed ORDER BY speed_id";
                            $result = dbQuery($sql);
                            ?>
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon">ชั้นความเร็ว:</span>
                                            <select name="speed_id" id="speed_id" class="form-control">
                                                <?php
                                                while ($rowSpeed = dbFetchArray($result)) {
                                                    echo "<option  value=" . $rowSpeed['speed_id'] . ">" . $rowSpeed['speed_name'] . "</option>";
                                                } ?>
                                            </select>
                                        </div>
                                    </div>
                                </td>
                                <?php
                                //ชั้นความลับ
                                $sql = "SELECT * FROM secret ORDER BY sec_id";
                                $result = dbQuery($sql);
                                ?>
                                <td>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon">ชั้นความลับ:</span>
                                            <select name="sec_id" id="sec_id" class="form-control">
                                                <?php
                                                while ($rowSecret = dbFetchArray($result)) {
                                                    echo "<option value=" . $rowSecret['sec_id'] . ">" . $rowSecret['sec_name'] . "</option>";
                                                } ?>
                                            </select>
                                        </div>
                                    </div>
                                </td>

                            </tr>
                            <tr>
                                <td>
                                    <div class="form-group form-inline">
                                        <input type="radio" name="open" value="1"
                                            checked><label>แสดงผลหน้าเว็บไซต์</label>
                                        <input type="radio" name="open" value="0"><label>ไม่แสดงผลหน้าเว็บไซต์ </label>
                                    </div>
                                </td>
                            </tr>
                        </table>
                </div>

                <i class="badge">รายละเอียด</i>
                <div class="well">
                    <table width=100%>
                        <tr>
                            <td colspan=2>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">เรื่อง:</span>
                                        <input class="form-control" type="text" size=100 name="title" id="title"
                                            size="50" required placeholder="เรื่องหนังสือ">
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan=2>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">ผู้ส่ง:</span>
                                        <input class="form-control" type="text" size=100 name="sendfrom" id="sendfrom"
                                            placeholder="ระบุผู้ส่ง" required>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan=2>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">ผู้รับ:</span>
                                        <input class="form-control" type="text" size=100 name="sendto" id="sendto"
                                            required placeholder="ระบุผู้รับหนังสือ">
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">ลงวันที่:</span>
                                        <input class="form-control" type="date" name="datepicker" id="datepicker"
                                            onKeydown="return false" required value="<?php echo date('Y-m-d'); ?>">
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">อ้างถึง:</span>
                                        <input class="form-control" type="text" size="50" name="refer" id="refer"
                                            value="-"><br>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">สิ่งที่ส่งมาด้วย:</span>
                                        <input class="form-control" type="text" size="40" name="attachment" value="-">
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">ผู้เสนอ:</span>
                                        <input class="form-control" type="text" size="30" name="practice"
                                            value="<?= $firstname ?>">
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan=2>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">ที่เก็บเอกสาร:</span>
                                        <input class="form-control" type="text" size="30" name="file_location"
                                            placeholder="ระบุที่เก็บเอกสาร" required>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div> <!-- class well -->

                <center>
                    <button class="btn btn-primary btn-lg" type="submit" name="save">
                        <i class="fas fa-save fa-2x"></i> บันทึก
                        <input id="u_id" name="u_id" type="hidden" value="<?php echo $u_id; ?>">
                        <input id="yid" name="yid" type="hidden" value="<?php echo $yid; ?>">
                    </button>
                </center>
                </form>
            </div>
            <div class="modal-footer bg-info">
                <button type="button" class="btn btn-danger" data-dismiss="modal">X</button>
            </div>
        </div> <!-- model content -->
    </div>
</div>
<!-- End Model -->
</div>

<!--  modal แสงรายละเอียดข้อมูล -->
<div class="modal fade bs-example-modal-table" tabindex="-1" aria-hidden="true" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><i class="fa fa-info"></i> รายละเอียด</h4>
            </div>
            <div class="modal-body no-padding">
                <div id="divDataview">
                    <!-- สวนสำหรับแสดงผลรายละเอียด   อ้างอิงกับไฟล์  show-flow-normal.php -->
                </div>
            </div> <!-- modal-body -->
            <div class="modal-footer bg-info">
                <button type="button" class="btn btn-danger" data-dismiss="modal">X</button>
            </div>
        </div>
    </div>
</div>

<?php
if (isset($_POST['save'])) {
    $uid = $_POST['u_id'];
    $obj_id = $_POST['obj_id'];
    $typeDoc = $_POST['typeDoc'];
    $prefex = $_POST['prefex'];
    $title = $_POST['title'];
    $speed_id = $_POST['speed_id'];
    $sendfrom = $_POST['sendfrom'];
    $sendto = $_POST['sendto'];
    $refer = $_POST['refer'];
    $attachment = $_POST['attachment'];
    $practice = $_POST['practice'];
    $file_location = $_POST['file_location'];
    $dateline = $_POST['datepicker'];
    $datelout = date('Y-m-d h:i:s');
    $open = $_POST['open'];

    if ($ystatus == 0) {
        echo "<script>swal(\"ระบบจัดการปีปฏิทินมีปัญหา  ติดต่อ Admin!\") </script>";
    } else {
        $sqlRun = "SELECT cid,rec_no FROM flownormal_depart WHERE yid=$yid ORDER BY cid DESC LIMIT 1";
        $resRun = dbQuery($sqlRun);
        $rowRun = dbFetchArray($resRun);
        $rec_no = ($rowRun) ? $rowRun['rec_no'] : 0;
        $rec_no++;

        dbQuery('BEGIN');
        $sqlInsert = "INSERT INTO flownormal_depart
                         (rec_no,u_id,obj_id,yid,typeDoc,prefex,title,speed_id,sec_id,sendfrom,sendto,refer,attachment,practice,file_location,dateline,dateout,open,dep_id)    
                    VALUES ($rec_no, $uid, $obj_id, $yid, '$typeDoc', '$prefex', '$title', $speed_id, $sec_id, '$sendfrom', '$sendto', '$refer', '$attachment', '$practice', '$file_location', '$dateline', '$datelout', $open, $dep_id)";

        $result = dbQuery($sqlInsert);
        if ($result) {
            dbQuery("COMMIT");
            echo "<script>
            swal({
                title:'เรียบร้อย',
                type:'success',
                showConfirmButton:true
                },
                function(isConfirm){
                    if(isConfirm){
                        window.location.href='normaloffice.php';
                    }
                }); 
            </script>";
        } else {
            dbQuery("ROLLBACK");
            echo "<script>swal(\"มีบางอย่างผิดพลาด!\") </script>";
        }
    }
}
?>

<script type='text/javascript'>
    $('#dataTable').DataTable({
        "order": [[0, "desc"]],
        "oLanguage": {
            "sLengthMenu": "แสดง _MENU_ เร็คคอร์ด ต่อหน้า",
            "sZeroRecords": "ไม่เจอข้อมูลที่ค้นหา",
            "sInfo": "แสดง _START_ ถึง _END_ ของ _TOTAL_ เร็คคอร์ด",
            "sInfoEmpty": "แสดง 0 ถึง 0 ของ 0 เร็คคอร์ด",
            "sInfoFiltered": "(จากเร็คคอร์ดทั้งหมด _MAX_ เร็คคอร์ด)",
            "sSearch": "ค้นหา :"
        }
    })

    function loadData(cid, u_id) {
        var sdata = {
            cid: cid,
            u_id: u_id
        };
        $('#divDataview').load('show-flow-normal.php', sdata);
    }
</script>
<?php include "footer.php"; ?>