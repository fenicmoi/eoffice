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
/* ปรับปุ่มให้ดูทันสมัยและโดดเด่น */
.meeting-btn-group .btn {
    margin-left: 8px;
    margin-bottom: 0;
    border-radius: 22px;
    font-size: 1.07em;
    font-weight: 500;
    box-shadow: 0 2px 8px rgba(41,128,185,0.08);
    transition: background 0.2s, color 0.2s, box-shadow 0.2s;
}
.meeting-btn-group .btn:first-child {
    margin-left: 0;
}
.meeting-btn-group .btn-success {
    background: linear-gradient(90deg, #43cea2 0%, #185a9d 100%);
    border: none;
    color: #fff;
}
.meeting-btn-group .btn-success:hover {
    background: linear-gradient(90deg, #185a9d 0%, #43cea2 100%);
    color: #fff;
}
.meeting-btn-group .btn-info {
    background: linear-gradient(90deg, #36d1c4 0%, #5b86e5 100%);
    border: none;
    color: #fff;
}
.meeting-btn-group .btn-info:hover {
    background: linear-gradient(90deg, #5b86e5 0%, #36d1c4 100%);
    color: #fff;
}
.meeting-btn-group .btn-danger {
    background: linear-gradient(90deg, #ff5858 0%, #f09819 100%);
    border: none;
    color: #fff;
}
.meeting-btn-group .btn-danger:hover {
    background: linear-gradient(90deg, #f09819 0%, #ff5858 100%);
    color: #fff;
}
.meeting-btn-group .btn-warning {
    background: linear-gradient(90deg, #f7971e 0%, #ffd200 100%);
    border: none;
    color: #fff;
}
.meeting-btn-group .btn-warning:hover {
    background: linear-gradient(90deg, #ffd200 0%, #f7971e 100%);
    color: #fff;
}
.meeting-btn-group .btn i {
    margin-right: 6px;
    font-size: 1.1em;
    vertical-align: middle;
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
#calendar-container {
    width: 100%;
    min-height: 420px;
    max-width: 100%;
    margin: 0 auto;
    padding: 0;
    overflow-x: auto;
}
#calendar-container .fc {
    width: 100% !important;
    max-width: 100% !important;
    margin: 0 auto;
    font-size: 1.1em;
}
@media (max-width: 991px) {
    #calendar-container {
        min-height: 340px;
        font-size: 1em;
    }
    .fc-toolbar-title {
        font-size: 1.1em !important;
    }
}
@media (max-width: 768px) {
    #calendar-container {
        min-height: 220px;
        font-size: 0.95em;
    }
    .fc .fc-toolbar {
        flex-direction: column;
        align-items: flex-start;
    }
    .fc .fc-toolbar-chunk {
        margin-bottom: 6px;
    }
    .fc .fc-daygrid-day-number {
        font-size: 1em;
    }
}
.panel.panel-primary {
    border-radius: 12px;
    box-shadow: 0 4px 18px rgba(44, 62, 80, 0.13);
    border: none;
}
.panel-body {
    background: #f7fafd;
    border-radius: 0 0 12px 12px;
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
        margin-bottom: 8px;
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
    .panel-heading strong {
        font-size: 1.1em;
    }
    .panel-heading {
        padding-top: 12px;
        padding-bottom: 12px;
    }
}
</style>

