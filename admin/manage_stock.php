
<!-- บริหารจัดการรถยนต์ -->
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
        </div>  <!-- col-md-2 -->
        <div class="col-md-10">
            <div class="panel panel-primary">
                <div class="panel-heading"><i class="fas fa-feather fa-2x"></i>  <strong>ทะเบียนทรัพย์สิน (Admin Deskboard)</strong></div>  
                <div class="panel-content">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">จัดการหมายเลขพัสดุ</h4>
                            <p class="card-text">ส่วนสำหรับจัดการ Federal Stock Number</p>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><a class="btn btn-danger btn-block" href="stock_group.php"> จัดการ Group </a> </li>
                            <li class="list-group-item"><a class="btn btn-danger btn-block" href="#"> จัดการ Class </a></li>
                            <li class="list-group-item"><a class="btn btn-danger btn-block" href="#"> จัดการ Type </a></li>
                            <li class="list-group-item"><a class="btn btn-danger btn-block" href="#"> จัดการ รายการพัสดุ </a></li>
                        </ul>
                    </div>
                </div>
				<div class="panel-footer"></div>
            </div> 
        </div> <!-- col-md-10 -->
    </div>    <!-- end row  -->

 <!--เพิ่มข้อมูล -->
 <div id="modalAdd" class="modal fade" role="dialog" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="exampleModalLabel"><i class="fa fa-plus"></i> เพิ่มรถราชการ</h4>
            </div>
            <div class="modal-body">
                <form method="post">
                          <label class="badge">วันที่บันทึก: <?php echo DateThai(); ?></label>
                          <?php 
                            $sql="SELECT *FROM depart WHERE dep_id=$dep_id";
                            $result=dbQuery($sql);
                            $row=dbFetchArray($result);
                        ?>
                          <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">ประเภทรถ</span>
                                  <select class="form-control" name="car_type" id="car_type">
                                    <option>---โปรดเลือก---</option>
                                    <option>รถยนต์ 7 ที่นั่ง</option>
                                    <option>รถกระบะ 4 ประตู</option>
                                    <option>รถกระบะ 2 ประตู</option>
                                    <option>รถตู้</option>
                                    <option>รถมอเตอร์ไซต์</option>
                                    <option>รถหกล้อ</option>
                                  </select>
                                </div>
                            </div>
                         </div> 
                        
                         <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">ยี่ห้อ</span>
                                    <input type="text" name="brand" id="brand" class="form-control">
                                </div>
                         </div>
                        
                        <div class="form-group">
                            <div class="input-group"> 
                                <span class="input-group-addon">วงเงินการจ้าง</span>
                                <input type="number" class="form-control" id="money" name="money" required="">  
                            </div>
                        </div>
                       
                        <div class="form-group">
                            <div class="input-group"> 
                                <span class="input-group-addon">ผู้รับจ้าง</span>
                                <input type="text" class="form-control" id="employee" name="employee"  required="" > 
                            </div>
                        </div>     
                        <div class="form-group form-inline">
                            <div class="input-group">
                             <span class="input-group-addon"><label for="datehire">วันทำสัญญา :</label></span>
                            <input class="form-control" type="date" name="datehire"  id="datehire" onKeyDown="return false" required > 
                            </div>
                        </div>
                        <div class="form-group form-inline">
                            <div class="input-group">
                             <span class="input-group-addon"><label for="datehire">วันส่งงาน :</label></span>
                            <input class="form-control" type="date" name="date_submit"  id="date_submit" onKeyDown="return false" required > 
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group"> 
                                <span class="input-group-addon">ผู้ลงนาม</span>
                                <input type="text" class="form-control" id="signer" name="signer"  placeholder="ผู้ลงนาม" value="ผู้ว่าราชการจังหวัด" required="" > 
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">หลักประกันสัญญา</i></span>
                                <input type="number" class="form-control" id="guarantee" name="guarantee"  value="0"  required="" ;> 
                            </div>
                        </div>
                       
                       
                        
                            <center>
                                <button class="btn btn-success" type="submit" name="save">
                                    <i class="fa fa-save fa-2x"></i> บันทึก
                                </button>
                            </center>                                                         
                      
                  </div>
                  <div class="modal-footer bg-primary">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                  </div>
                </form>
            </div> <!-- main body -->
        </div> <!-- modal content -->
    </div>   <!-- modal dialog -->
            <!-- End Model -->  
    

<!--  modal แสงรายละเอียดข้อมูล -->
        <div  class="modal fade bs-example-modal-table" tabindex="-1" aria-hidden="true" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-danger">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"><i class="fa fa-info"></i> รายละเอียด</h4>
                    </div>
                    <div class="modal-body no-padding">
                        <div id="divDataview"></div>     
                    </div> <!-- modal-body -->
                    <div class="modal-footer bg-danger">
                         <button type="button" class="btn btn-danger" data-dismiss="modal">ปิด X</button>
                    </div>
                </div>
            </div>
        </div>
<!-- จบส่วนแสดงรายละเอียดข้อมูล  -->

<?php
// ส่วนการจัดการข้อมูล
if(isset($_POST['save'])){

    $datein=date('Y-m-d');
    $title=$_POST['title'];
    $money=$_POST['money'];
    $employee=$_POST['employee'];
    $datehire=$_POST['datehire'];
    $signer=$_POST['signer'];
    $guarantee=$_POST['guarantee'];
    $date_submit=$_POST['date_submit'];
    
  
    //echo $yid[0];
    //echo "this is datein=".$datein;
    //ตัวเลขรันอัตโนมัติ
    $sql="SELECT hire_id,rec_no
          FROM hire
          WHERE yid=$yid[0]
          ORDER BY hire_id DESC
          LIMIT 1";
    //print $sql;
    //print $yid[0];
    $result=dbQuery($sql);
    $row = dbFetchAssoc($result);
    $rec_no=$row['rec_no'];

    if($rec_no==0){
       $rec_no=1;
    }else{
       $rec_no++; 
    } 
    //echo "rec_no=".$rec_no;

    
    //echo "This is $rec_no=".$rec_no;
    //dbQuery('BEGIN');
    $sql="INSERT INTO hire (rec_no,datein,title,money,employee,date_hire,signer,guarantee,date_submit,dep_id,sec_id,u_id,yid)
                VALUES($rec_no,'$datein','$title',$money,'$employee','$datehire','$signer',$guarantee,'$date_submit',$dep_id,$sec_id,$u_id,$yid[0])";
    
    
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
                    window.location.href='hire.php';
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
                    window.location.href='hire.php';
                }
            }); 
        </script>";
    }     
}
?>

<script type="text/javascript">
function loadData(hire_id,u_id) {
    var sdata = {
        hire_id : hire_id,
        u_id : u_id 
    };
$('#divDataview').load('show_hire_detail.php',sdata);
}
</script>

