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
                <div class="panel-heading"><i class="fas fa-book-reader fa-2x" aria-hidden="true"></i>  <strong>คำขอใช้ห้องประชุมรออนุมัติ</strong>
                    <a href="meet_index.php" class="btn btn-default pull-right"><i class="fas fa-calendar"></i> หน้าหลักปฏฺิทิน</a>
                </div> 
                <br>
                <table class="table table-bordered" width="100%">
                <thead>
                    <tr>
                         <th width="6%">สถานะ</th>
                         <th width="60%">เรื่อง</th>
                         <th width="8%">วันที่ใช้</th>
                         <th>ช่วงเวลา</th>
                         <th>ชื่อห้อง</th>
                         <th>admin</th>

                     </tr>
                 </thead>
                 <tbody>
                     <?php
                        $sql="SELECT mb.*, mr.roomname, dp.dep_name, dp.phone  FROM meeting_booking as mb
                              INNER JOIN  meeting_room as mr ON mb.room_id = mr.room_id  
                              INNER JOIN  depart as dp ON mb.dep_id = dp.dep_id
                              ORDER BY book_id DESC ";
                        $result = page_query( $dbConn, $sql, 10 );
                        while($row=dbFetchArray($result)){
                            $room_id = $row['room_id'];
                            $book_id =$row['book_id']; ?>
                            <tr>
                                <td>
                                    <?php
                                        switch ($row['conf_status']) {
                                             case 0:
                                                 echo "ยกเลิก";
                                                 break;
                                             case 1:
                                                 echo "<font color='red'><b>รออนุมัติ</b></font>";
                                                 break;
                                             case 2:
                                                 echo "<font color='green'><b>อนุมัติ</b></font>";
                                                 break;    
                                         }
                                        
                                    ?>
                                </td>
                                <td>
                                    <a  href="#" 
                                        onClick="loadData('<?php echo $book_id; ?>');" 
                                        data-toggle="modal" data-target=".modal-wait">
                                        <?php echo $row['subject'];?>
                                    </a>
                                    [<?php  echo $row['remark'];?>]
                                <td><?php print thaiDate($row['startdate']);?></td>                                                    
                                <td><?php print substr($row['starttime'],0,5);?>-<?php print substr($row['endtime'],0,5);?>&nbspน.</td>  
                                <td><?php print $row['roomname'];?></td>  
                                <td>
                                    <a class="btn btn-warning"  href="#" 
                                        onClick="loadData('<?php echo $book_id; ?>');" 
                                        data-toggle="modal" data-target=".modal-wait">
                                        <i class="fab fa-nintendo-switch"></i> จัดการ
                                    </a>     
                                </td>
                            </tr>
                        <?php } ?>
                 </tbody>
                </table>
				<div class="panel-footer">
					<center>
					<a href="meet_wait.php" class="btn btn-primary">
						<i class="fas fa-home"></i> หน้าหลัก</a>
					<?php 
						page_link_border("solid","1px","gray");
						page_link_bg_color("lightblue","pink");
						page_link_font("14px");
						page_link_color("blue","red");
						page_echo_pagenums(10,true); 
				    ?>
					</center>
				</div>
            </div>
        </div>
    </div>  
    <!--  modal แสงรายละเอียดข้อมูล -->
        <div  class="modal fade modal-wait" tabindex="-1" aria-hidden="true" role="dialog">
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

<?php
if(isset($_POST['save'])){
    $conf_status = $_POST['optradio'];
    $book_id = $_POST['book_id'];
    $remark = $_POST['remark'];
    
    $sql  = "UPDATE meeting_booking SET conf_status=$conf_status,remark='$remark' WHERE book_id=$book_id";
    $result = dbQuery($sql);
     if($result){
        echo "<script>
            swal({
                title:'เรียบร้อย',
                type:'success',
                showConfirmButton:true
                },
                function(isConfirm){
                    if(isConfirm){
                        window.location.href='meet_wait.php';
                    }
                }); 
            </script>";
    }else{
    echo "<script>
            swal({
                title:'มีบางอย่างผิดพลาด',
                type:'success',
                showConfirmButton:true
                },
                function(isConfirm){
                    if(isConfirm){
                        window.location.href='meet_wait.php';
                    }
                }); 
            </script>";
    }
    
}
//ส่วนประมวลผล
if(isset($_GET['status'])){
  $status = $_GET['status'];
  $book_id = $_GET['book_id'];
  if($status == 0){
     $sql = "UPDATE meeting_booking SET conf_status=$status WHERE book_id=$book_id";
  }else{
     $sql = "UPDATE meeting_booking SET conf_status=$status WHERE book_id=$book_id";
  }

  $result = dbQuery($sql);
    if($result){
        echo "<script>
            swal({
                title:'เรียบร้อย',
                type:'success',
                showConfirmButton:true
                },
                function(isConfirm){
                    if(isConfirm){
                        window.location.href='meet_wait.php';
                    }
                }); 
            </script>";
    }else{
    echo "<script>
            swal({
                title:'มีบางอย่างผิดพลาด',
                type:'success',
                showConfirmButton:true
                },
                function(isConfirm){
                    if(isConfirm){
                        window.location.href='meet_wait.php';
                    }
                }); 
            </script>";
    }
}
?>

<script type="text/javascript">
function loadData(book_id) {
    var sdata = {
        book_id : book_id
    };
$('#divDataview').load('meet_listFront_detail_admin.php',sdata);
}

</script>
