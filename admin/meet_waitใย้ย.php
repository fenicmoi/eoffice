<?php
include "header.php";
$yid=chkYearMonth(); 
$u_id=$_SESSION['ses_u_id'];
?>
    <div class="row">
        <div class="col-md-2" >
             <?php
                 $menu=  checkMenu($level_id);
				 include $menu;
			 ?>
        </div>
        <div class="col-md-10">
            <div class="panel panel-primary" style="margin: 20">
                <div class="panel-heading"><i class="fas fa-book-reader fa-2x" aria-hidden="true"></i>  <strong>รายชื่อห้องประชุม</strong>
                    <a class="btn btn-default pull-right" href="meet_index.php"><i class="fas fa-calendar"></i> ปฏิทิน</a>
                </div> 
                <br>
                <table class="table table-bordered table-hover" >
                <thead>
                    <tr>
                         <th></th>
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
                        $sql="SELECT *  FROM meeting_room WHERE room_status = 1";
                        $result = dbQuery($sql);
                        while($row=dbFetchArray($result)){
                            $room_id = $row['room_id']; ?>
                            <tr>
                                <td><i class="fas fa-smile-wink"></i></td>
                                <td><?php print $row['roomname'];?></td>                     
                                <td><?php print $row['roomplace'];?></td> 
                                <td><?php print $row['roomcount'];?></td>  
                                <td><?php print $row['money1'];?>.บาท</td>  
                                <td><?php print $row['money2'];?>.บาท</td>  
                                <td>
                                    <a class="btn btn-info btn-block" href="#" 
                                            onClick="loadData('<?php print $room_id;?>','<?php print $u_id; ?>');" 
                                            data-toggle="modal" data-target=".bs-example-modal-table">
                                            <i class="fas fa-eye"></i>  Click..
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                 </tbody>
                </table>
				<div class="panel-footer"></div>
            </div>

            <!-- Model -->
            <div id="modalAdd" class="modal fade" role="dialog">
              <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-list"></i> เพิ่มห้องประชุม</h4>
                  </div>
                  <div class="modal-body">
                      <form method="post" action="meet_room.php" enctype="multipart/form-data">
                          <label for="">วันที่ทำรายการ: <?php echo DateThai();?></label>
                        <div class="form-group">
                          <div class="input-group">
                              <span class="input-group-addon"><span class="glyphicon glyphicon-list"></span></span>
                              <input type="text" class="form-control" id="roomname" name="roomname"  placeholder="ชื่อห้องประชุม"  required="">
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="input-group">
                              <span class="input-group-addon"><span class="	glyphicon glyphicon-map-marker"></span></span>
                              <input type="text" class="form-control" id="place" name="place"  placeholder="สถานที่"  required="">
                          </div>
                        </div>
                         <div class="form-group">
                          <div class="input-group">
                              <span class="input-group-addon"><span class="	glyphicon glyphicon-user"></span></span>
                              <input type="text" class="form-control" id="capacity" name="capacity"  placeholder="ความจุผู้เข้าประชุม"  required="">
                          </div>
                        </div>
                         <div class="form-group">
                          <div class="input-group col-xs-6">
                              <span class="input-group-addon"><span class="	glyphicon glyphicon-usd"></span></span>
                              <input type="text" class="form-control" id="money1" name="money1"  placeholder="ค่าธรรมเนียมเต็มวัน"  required="">
                              <span class="input-group-addon">บาท</span></span>
                          </div>
                        </div>
                         <div class="form-group">
                          <div class="input-group col-xs-6">
                              <span class="input-group-addon"><span class="	glyphicon glyphicon-usd"></span></span>
                              <input type="text" class="form-control" id="money2" name="money2"  placeholder="ค่าธรรมเนียมครึ่งวัน"  required="">
                              <span class="input-group-addon">บาท</span></span>
                          </div>
                        </div>
                         <div class="form-group">
                          <div class="input-group col-xs-6">
                              <span class="input-group-addon"><span class="	glyphicon glyphicon-phone"></span></span>
                              <input type="text" class="form-control" id="tel" name="tel"  placeholder="เบอร์โทร"  required="">
                          </div>
                        </div>
                         <div class="form-group">
                          <div class="input-group col-xs-6">
                              <span class="input-group-addon"><span class="	glyphicon glyphicon-user"></span></span>
                              <input type="text" class="form-control" id="owner" name="owner"  placeholder="เจ้าของห้อง"  required="">
                          </div>
                        </div>
                        <div class="form-group">
                          <h5><i class="fas fa-volume-up"></i> อุปกรณ์อำนวยความสะดวก</h5>
                          <div class="checkbox">
                                <div class="checkbox"><label><input type="checkbox" id="t1" name="t1" value="1">ระบบเสียง</label></div>
                                <div class="checkbox"><label><input type="checkbox" id="t2" name="t2" value="1">ระบบแสดงผล</label></div>
                                <div class="checkbox"><label><input type="checkbox" id="t3" name="t3" value="1">ระบบประชุมวีดีทัศน์ทางไกล</label></div>
                          </div>
                        </div>
                        <div class="form-group">
                            <label>รูปห้องประชุม</label>
                            <input type="file" name="fileUpload">
                        </div>
                        <?php 
                            $sql="SELECT * FROM depart WHERE dep_id=$dep_id";
                            $result=dbQuery($sql);
                            $row=dbFetchArray($result);
                        ?>
                        <div class="form-group">
                            <div class="input-group">
                                 <span class="input-group-addon"><span class="fa fa-building"></span></span>
                                <input type="text" class="form-control" id="dep_id" name="dep_id"  value="<?php print $row['dep_name'];?>" > 
                            </div>
                        </div>
                            <center>
                                <button class="btn btn-success btn-lg" type="submit" name="save">
                                    <i class="fas fa-save fa-2x"></i> บันทึก
                                </button>
                            </center>                                                         
                      </form>
                  </div>
                  <div class="modal-footer bg-primary">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">ปิด X</button>
                  </div>
                </div>
              </div>
            </div>
            <!-- End Model -->   
        </div>
    </div>  
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

    <!--  modal แก้ไขข้อมูล-->
        <div  class="modal fade bs-edit-modal-table" tabindex="-1" aria-hidden="true" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"><i class="fa fa-info"></i> แก้ไขข้อมูล</h4>
                    </div>
                    <div class="modal-body no-padding">
                        <div id="divEditview"></div>     
                    </div> <!-- modal-body -->
                    <div class="modal-footer bg-primary">
                         <button type="button" class="btn btn-danger" data-dismiss="modal">ปิด X</button>
                    </div>
                </div>
            </div>
        </div>
<!-- จบส่วนแก้ไข  -->


<?php
//ส่วนประมวลผล
if(isset($_POST['save'])){

	$roomname=$_POST['roomname'];         //ชื่อห้องประชุม
	$roomplace=$_POST['place'];    //สถานที่
	$roomcount=$_POST['capacity'];  //ความจุ
	$money1=$_POST['money1'];      //ค่าธรรมเนียมเต็มวัน
	$money2=$_POST['money2'];    //ค่าธรรมเนียมครึ่งวัน
	$tel=$_POST['tel'];         //เบอร์โทรศัพท์
    $dept=$_POST['owner'];       //เจ้าของห้อง
    $t1=$_POST['t1'];       //เสียง
    $t2=$_POST['t2'];
    $t3=$_POST['t3'];       //ประชุมทางไกล

    if (move_uploaded_file($_FILES["fileUpload"]["tmp_name"], "doc/" . $_FILES["fileUpload"]["name"])) {
        $roomimg= $_FILES["fileUpload"]["name"];
    }
  
	
	/*
	$sql="INSERT INTO  meeting_room(roomname,roomplace,roomcount,roomimg,dept,tel,room_status,money1,money2,sound,vga,vcs)
                VALUES('$roomname','$roomplace',$roomcount,'$roomimg','$dept','$tel',1,$money1,$money2,$t1,$t2,$t3)";
	//echo $sql;
	
	$result=dbQuery($sql);
	if($result){
		dbQuery("COMMIT");
		echo "<script>
        swal({
            title:'เรียบร้อย',
            type:'success',
            showConfirmButton:true
            },
            function(isConfirm){
                if(isConfirm){
                    window.location.href='meet_room.php';
                }
            }); 
        </script>";
	}else{
		dbQuery("ROLLBACK");
		echo "<script>
        swal({
            title:'มีบางอย่างผิดพลาด! กรุณาตรวจสอบ',
            type:'error',
            showConfirmButton:true
            },
            function(isConfirm){
                if(isConfirm){
                    window.location.href='meet_room.php';
                }
            }); 
        </script>";
	}*/
}

//ลบห้องประชุม
if(isset($_GET['del'])){
    $sql = "DELETE FROM meeting_room WHERE room_id=".$_GET['del'];
    $result = dbQuery($sql);
    if(!$result){
        echo "<script>
        swal({
         title:'มีบางอย่างผิดพลาด! กรุณาตรวจสอบ',
         type:'error',
         showConfirmButton:true
         },
         function(isConfirm){
             if(isConfirm){
                 window.location.href='meet_room.php';
             }
         }); 
       </script>";
    }else{
        echo "<script>
        swal({
         title:'เรียบร้อย',
         type:'success',
         showConfirmButton:true
         },
         function(isConfirm){
             if(isConfirm){
                 window.location.href='meet_room.php';
             }
         }); 
       </script>";
    }
}
//แก้ไขข้อมูล
if(isset($_POST['edit'])){
	$roomname=$_POST['roomname'];         //ชื่อห้องประชุม
	$roomplace=$_POST['roomplace'];    //สถานที่
	$roomcount=$_POST['roomcount'];  //ความจุ
	$money1=$_POST['money1'];      //ค่าธรรมเนียมเต็มวัน
	$money2=$_POST['money2'];    //ค่าธรรมเนียมครึ่งวัน
	$tel=$_POST['tel'];         //เบอร์โทรศัพท์
    $dept=$_POST['dept'];       //เจ้าของห้อง
    $t1=$_POST['t1'];       //เสียง
    $t2=$_POST['t2'];
    $t3=$_POST['t3'];       //ประชุมทางไกล
    $room_status=$_POST['room_status'];
    if (move_uploaded_file($_FILES["fileUpload"]["tmp_name"], "doc/" . $_FILES["fileUpload"]["name"])) {
        $roomimg= $_FILES["fileUpload"]["name"];
        $sql = "UPDATE meeting_room 
                SET roomname='$roomname',roomplace='$roomplace',roomcount=$roomcount,roomimg='$roomimg',dept='$dept',tel='$tel',room_status=$room_status,
                    money1=$money1,money2=$money2,sound=$t1,vga=$t2,vcs=$t3
                WHERE room_id=$room_id";
    }else{
        $sql = "UPDATE meeting_room 
                SET roomname='$roomname',roomplace='$roomplace',roomcount=$roomcount,dept='$dept',tel='$tel',room_status=$room_status,
                    money1=$money1,money2=$money2,sound=$t1,vga=$t2,vcs=$t3
                WHERE room_id=$room_id";
    }
    print $sql;
    
	$result=dbQuery($sql);
	if($result){
		echo "<script>
        swal({
            title:'เรียบร้อย',
            type:'success',
            showConfirmButton:true
            },
            function(isConfirm){
                if(isConfirm){
                    window.location.href='meet_room.php';
                }
            }); 
        </script>";
	}else{
		echo "<script>
        swal({
            title:'มีบางอย่างผิดพลาด! กรุณาตรวจสอบ',
            type:'error',
            showConfirmButton:true
            },
            function(isConfirm){
                if(isConfirm){
                    window.location.href='meet_room.php';
                }
            }); 
        </script>";
	}
}

?>

<script type="text/javascript">
function loadData(room_id,u_id) {
    var sdata = {
        room_id : room_id,
        u_id : u_id 
    };
$('#divDataview').load('show_meeting_detail.php',sdata);
}


function editData(room_id,u_id) {
    var edata = {
        room_id : room_id,
        u_id : u_id 
    };
$('#divEditview').load('show_meeting_edit.php',edata);
}

</script>
