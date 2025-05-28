<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js'></script>
<?php
include "header.php"; 
$u_id = $_SESSION['ses_u_id'];
$level_id = $_SESSION['ses_level_id'];
?>

<div class="row">
    <div class="col-md-2">
        <?php
            $menu = checkMenu($level_id);
            include $menu;
        ?>
    </div> <!-- col-md-2 -->
    <div class="col-md-10">
        <div class="panel panel-primary" style="margin: 10px;">
            <div class="panel-heading d-flex flex-wrap align-items-center justify-content-between" style="gap:10px;">
                <span>
                    <i class="fas fa-calendar fa-2x" aria-label="ปฏิทิน"></i>
                    <strong>ปฏิทินการใช้ห้องประชุม</strong>
                </span>
                <div class="btn-group meeting-btn-group" role="group" aria-label="meeting-actions">
                    <a class="btn btn-success" href="#"
                        onclick="loadReserve('<?php echo htmlspecialchars($u_id); ?>','<?php echo htmlspecialchars($level_id); ?>');"
                        data-toggle="modal" data-target=".modal-reserv">
                        <i class="fas fa-plus" aria-label="จองห้องประชุม"></i> จองห้องประชุม
                    </a>
                    <a class="btn btn-info" href="meet_room_user.php">
                        <i class="fas fa-info" aria-label="ดูห้องประชุม"></i> ดูห้องประชุม
                    </a>
                    <a class="btn btn-danger" href="meet_history.php">
                        <i class="fas fa-history" aria-label="ยกเลิกใช้ห้อง"></i> ยกเลิกใช้ห้อง
                    </a>
                    <a class="btn btn-warning" href="doc/form_meeting.pdf" target="_blank">
                        <i class="fab fa-wpforms" aria-label="แบบขออนุมัติ"></i> แบบขออนุมัติ
                    </a>
                </div>
            </div>
            <div class="panel-body">
                <div id="calendar-container" style="width: 100%; min-height: 500px;">
                    <?php include "calendar.php"; ?>
                </div>
            </div>
        </div>
    </div> <!-- col-md-10 -->
</div> <!-- end row -->
<style>
#calendar-container .fc {
    max-width: 100%;
    margin: 0 auto;
}
.meeting-btn-group .btn {
    margin-left: 8px;
    margin-bottom: 0;
}
.meeting-btn-group .btn:first-child {
    margin-left: 0;
}
@media (max-width: 991px) {
    .meeting-btn-group {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        width: 100%;
        margin-top: 10px;
        justify-content: flex-start;
    }
    .meeting-btn-group .btn {
        width: 100%;
        margin-left: 0 !important;
        margin-bottom: 6px;
        text-align: left;
    }
    .panel-heading.d-flex {
        flex-direction: column;
        align-items: flex-start !important;
    }
}
@media (max-width: 768px) {
    #calendar-container {
        min-height: 350px;
        font-size: 12px;
    }
}
</style>

