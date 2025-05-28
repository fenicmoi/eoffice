<?php
include "header.php";
$yid = chkYearMonth();
$u_id = $_SESSION['ses_u_id'];
$level_id = isset($level_id) ? (int)$level_id : 0;
?>
<div class="row">
    <div class="col-md-2">
        <?php
            $menu = checkMenu($level_id);
            include $menu;
        ?>
    </div>
    <div class="col-md-10">
        <div class="panel panel-primary" style="margin: 20px; border-radius: 12px; box-shadow: 0 4px 18px rgba(44,62,80,0.13);">
            <div class="panel-heading" style="border-radius: 12px 12px 0 0; background: linear-gradient(90deg, #2980b9 0%, #6dd5fa 100%); color: #fff;">
                <i class="fas fa-book-reader fa-2x" aria-hidden="true"></i>
                <strong style="font-size:1.3em;">รายชื่อห้องประชุม</strong>
                <a class="btn btn-info pull-right" href="meet_index.php" style="border-radius: 20px;">
                    <i class="fas fa-calendar"></i> ปฏิทิน
                </a>
            </div>
            <div class="panel-body" style="background: #f7fafd;">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" style="background: #fff; border-radius: 8px;">
                        <thead class="bg-info" style="background: #2980b9; color: #fff;">
                            <tr>
                                <th>สถานะ</th>
                                <th>ชื่อห้อง</th>
                                <th>ที่อยู่</th>
                                <th>ความจุ</th>
                                <th>ราคาเต็มวัน</th>
                                <th>ราคาครึ่งวัน</th>
                                <th>รายละเอียด</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT * FROM meeting_room";
                            $result = dbQuery($sql);
                            while ($row = dbFetchArray($result)) {
                                $room_id = (int)$row['room_id'];
                                ?>
                                <tr>
                                    <td style="vertical-align:middle;">
                                        <?php
                                        if ($row['room_status'] == 0) {
                                            echo "<span class='label label-danger'><i class='fas fa-window-close'></i> ระงับการใช้</span>";
                                        } else {
                                            echo "<span class='label label-success'><i class='fas fa-check-circle'></i> ใช้ปกติ</span>";
                                        }
                                        ?>
                                    </td>
                                    <td style="vertical-align:middle;"><?= htmlspecialchars($row['roomname']); ?></td>
                                    <td style="vertical-align:middle;"><?= htmlspecialchars($row['roomplace']); ?></td>
                                    <td style="vertical-align:middle;"><?= (int)$row['roomcount']; ?></td>
                                    <td style="vertical-align:middle;"><?= htmlspecialchars($row['money1']); ?> บาท</td>
                                    <td style="vertical-align:middle;"><?= htmlspecialchars($row['money2']); ?> บาท</td>
                                    <td style="vertical-align:middle;">
                                        <a class="btn btn-info btn-block" href="#"
                                           onClick="loadData('<?= $room_id; ?>','<?= $u_id; ?>');"
                                           data-toggle="modal" data-target=".bs-example-modal-table">
                                            <i class="fas fa-eye"></i> ดูรายละเอียด
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <div class="panel-footer" style="border-radius: 0 0 12px 12px; background: #eaf6fb;"></div>
            </div>
        </div>

        <!-- Modal แสดงรายละเอียดข้อมูล -->
        <div class="modal fade bs-example-modal-table" tabindex="-1" aria-hidden="true" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"><i class="fa fa-info"></i> รายละเอียด</h4>
                    </div>
                    <div class="modal-body no-padding">
                        <div id="divDataview"></div>
                    </div>
                    <div class="modal-footer bg-primary">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">ปิด X</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Modal -->

        <!-- Modal แก้ไขข้อมูล (ถ้ามีสิทธิ์) -->
        <div class="modal fade bs-edit-modal-table" tabindex="-1" aria-hidden="true" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"><i class="fa fa-edit"></i> แก้ไขข้อมูล</h4>
                    </div>
                    <div class="modal-body no-padding">
                        <div id="divEditview"></div>
                    </div>
                    <div class="modal-footer bg-primary">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">ปิด X</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Modal -->
    </div>
</div>

<style>
.panel.panel-primary {
    border-radius: 12px;
    box-shadow: 0 4px 18px rgba(44, 62, 80, 0.13);
    border: none;
}
.panel-heading {
    background: linear-gradient(90deg, #2980b9 0%, #6dd5fa 100%) !important;
    color: #fff !important;
    border-radius: 12px 12px 0 0;
    min-height: 70px;
    padding-top: 18px;
    padding-bottom: 18px;
    box-shadow: 0 2px 8px rgba(41,128,185,0.08);
}
.panel-heading strong {
    font-size: 1.35em;
    letter-spacing: 1px;
}
.table > thead > tr > th, .table > tbody > tr > td {
    text-align: center;
    vertical-align: middle !important;
}
.label {
    font-size: 1em;
    padding: 6px 12px;
    border-radius: 12px;
}
.btn-info.btn-block {
    border-radius: 18px;
    font-weight: 500;
    font-size: 1em;
    margin-top: 2px;
    margin-bottom: 2px;
}
@media (max-width: 991px) {
    .panel-body, .table-responsive {
        padding: 0 !important;
    }
    .table {
        font-size: 0.95em;
    }
    .btn {
        margin-bottom: 5px;
    }
}
</style>

<script type="text/javascript">
function loadData(room_id, u_id) {
    var sdata = {
        room_id: room_id,
        u_id: u_id
    };
    $('#divDataview').load('show_meeting_detail.php', sdata);
}

function editData(room_id, u_id) {
    var edata = {
        room_id: room_id,
        u_id: u_id
    };
    $('#divEditview').load('show_meeting_edit.php', edata);
}
</script>
