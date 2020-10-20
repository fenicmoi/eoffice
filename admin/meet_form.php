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
               
				<div class="panel-footer"></div>
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
