<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js'></script>
<?php
include "header.php"; 
//$yid=chkYearMonth();  //return   ปี พ.ศ.
$u_id=$_SESSION['ses_u_id'];
$level_id=$_SESSION['ses_level_id'];
?>

    <div class="row">
        <div class="col-md-2" >
             <?php
                 $menu=  checkMenu($level_id);
                 include $menu;
             ?>
        </div>  <!-- col-md-2 -->
        <div class="col-md-10">
            <div class="panel panel-primary" style="margin: 10">
                <div class="panel-heading"><i class="fas fa-calendar fa-2x"></i>   <strong>ปฏิทินการใช้ห้องประชุม</strong>
                    <a class="btn btn-default pull-right" href="#" 
                        onClick="loadReserve('<?php echo $u_id; ?>','<?php echo $level_id;?>');" 
                        data-toggle="modal" data-target=".modal-reserv">
                        <i class="fas fa-plus"></i> จองห้องประชุม
                    </a>
                    <a class="btn btn-default pull-right" href="meet_room_user.php">
                        <i class="fas fa-info"></i> ดูห้องประชุม
                    </a>
                     <a class="btn btn-danger pull-right" href="meet_history.php">
                        <i class="fas fa-history"></i> ยกเลิกใช้ห้อง
                    </a>
                    <a  class="btn btn-default pull-right" href="doc/form_meeting.pdf" target="_blank">
                        <i class="fab fa-wpforms"></i> แบบขออนุมัติ
                    </a>

            </div> 

                <?php include "calendar.php";?>
            <div>
        </div> <!-- col-md- -->
    </div>    <!-- end row  -->

