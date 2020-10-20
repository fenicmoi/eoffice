
<table class="table table-bordered table-hover">
    <thead>
        <tr style="background-color:#000000;">
			<td colspan="6">
                <center>
				<form class="form-inline"  method="post" name="chkroom" id="chkroom">
                    <div class="form-group">
                            <label for="namefill" style="color:#80ffff">ตรวจสอบห้องประชุมว่าง >>> </label>
                            <div class="input-group">
                                <span class="input-group-addon">เลือกห้อง <i class="fas fa-hand-point-right"></i></span>
                                <select class="form-control" id="namefill" name="namefill">
                                    <?php
                                    $sql ="SELECT * FROM meeting_room WHERE room_status<>0 ";
                                    $result = dbQuery($sql);
                                    while ($row = dbFetchArray($result)) {
                                        $room_id=$row['room_id'];?>
                                        <option value="<?php print $room_id;?>">
                                           <b><?php print $row['roomname'];?></b>
                                            <?php 
                                                switch ($row['room_status']) {
                                                    case 0:
                                                        echo ":งดใช้";
                                                        break;
                                                    case 1;
                                                        echo ":จองผ่านระบบ";
                                                        break;
                                                    case 2:
                                                        echo ":จองผ่านสมุด";
                                                        break;
                                                }
                                             ?>
                                        </option>
                                <?php } ?>
						        </select>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">เลือกวันที่<i class="fas fa-hand-point-right"></i></span>
                            <input id="startdate" name="startdate" class="form-control" type="date" onKeyDown="return false" required="">
                        </div>
                    </div>
					<div class="form-group">
						<div class="input-group">
							<div class="input-group-btn">
                                  <a class="btn btn-info" href="#" 
                                            onClick="checkRoom(chkroom.namefill.value,chkroom.startdate.value,'<?=$u_id?>');" 
                                            data-toggle="modal" data-target=".bs-example-modal-table">
                                            <i class="fas fa-search"></i> Click
                                  </a>
							</div>
						</div>
					</div>
				</form>
                </center>
			</td>
		</tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <?php
                    $GoToDay = @$_GET['txtDay']; 
                    if (!empty($GoToDay)) { 
                    $StartDate=date("m/d/y",strtotime ("$GoToDay")); 
                    } else if (empty($StartDate)) $StartDate=date("m/d/y"); 
                    echo WriteMonth($StartDate); 
                ?>
            </td>
        </tr>
    </tbody>
</table>

<!--  modal แสงรายละเอียดข้อมูล -->
        <div  class="modal fade bs-example-modal-table" tabindex="-1" aria-hidden="true" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"><i class="fa fa-info"></i> รายละเอียด</h4>
                    </div>
                    <div class="modal-body no-padding">
                        <div id="divDataview"></div>     
                    </div> <!-- modal-body -->
                    <div class="modal-footer bg-primary">
                         <button type="button" class="btn btn-danger" data-dismiss="modal">ปิด X</button>
                    </div>
                </div>
            </div>
        </div>
<!-- จบส่วนแสดงรายละเอียดข้อมูล  -->

<script type="text/javascript">
function checkRoom(room_id,startdate,u_id) {
    var sdata = {
        room_id : room_id,
        startdate : startdate,
        u_id : u_id
    };
$('#divDataview').load('checkroom.php',sdata);
}
</script>