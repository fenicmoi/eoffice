
<!--  ทะเบียนคุมสัญญาจ้าง -->
<?php
include "header.php"; 
$yid=chkYear();
//print $yid[0];
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
            <div class="panel panel-default" style="margin: 20">
                <div class="panel-heading"><i class="fas fa-cart-plus"></i>   <strong>ทะเบียนคุมสัญญาจ้าง</strong>
                    <a href="add_object.php" class="btn btn-primary  pull-right" data-toggle="modal" data-target="#modalAdd"><i class="fa fa-plus" aria-hidden="true"></i> ออกเลขที่สัญญา</a>
                </div> 
                <br>
                <table class="table table-bordered table-hover" id="tbHire">
                 <thead class="bg-info">
                     <tr>
                         <th>เลขระบบ</th>   
                         <th>เลขสัญญา</th>
                         <th>วันที่ทำรายการ</th>
                         <th>รายการจ้าง</th>
                         <th>วงเงิน</th>
                         <th>ผู้รับจ้าง</th>
                     </tr>
                 </thead>
                 <tbody>
                 <?php
                        //คนหา ID ล่าสุด
                        $sql = "SELECT MAX(hire_id) AS maxid FROM hire"; // query อ่านค่า id สูงสุด
                        $result = dbQuery($sql);
                        $row=dbFetchAssoc($result);
                        $last_id = $row['maxid']; // คืนค่า id ที่ insert สูงสุด
   
                        //แสดงข้อมูล
                        // $sql="SELECT h.*,d.dep_name,y.yname
                        //       FROM hire h
                        //       INNER JOIN depart d ON d.dep_id=h.dep_id
                        //       INNER JOIN sys_year y ON h.yid=y.yid
                        //       WHERE h.yid=$yid[0]
                        //       ORDER BY hire_id DESC
                        //       ";
                        $sql="SELECT h.*,d.dep_name,y.yname
                              FROM hire h
                              INNER JOIN depart d ON d.dep_id=h.dep_id
                              INNER JOIN sys_year y ON h.yid=y.yid
                              WHERE h.dep_id=$dep_id
                              ORDER BY hire_id DESC
                              ";
                        //print $sql;
                        $result = dbQuery($sql);
                        while($row=dbFetchArray($result)){?>
                            <tr>
                                <td><?=$row['hire_id']?></td>
                                <td>
                                <?php
                                    if($row['hire_id']==$last_id){
                                        echo "<i class='fa fa-play'></i>". $row['rec_no']; ?>/<?php echo $row['yname'];  
                                    }else{
                                        echo $row['rec_no']; ?>/<?php echo $row['yname'];
                                    }
                                ?>
                                 </td>
                                <td><?php echo thaiDate($row['datein']); ?></td>
                                <?php 
                                    $hire_id=$row['hire_id'];
                                   // print $hire_id;
                                ?>
                                <td><a href="#" 
                                            onClick="loadData('<?php print $hire_id;?>','<?php print $u_id; ?>');" 
                                            data-toggle="modal" data-target=".bs-example-modal-table">
                                             <?php echo $row['title'];?> 
                                    </a>
                                    
                                </td>                                <td><?php echo number_format($row['money']); ?></td>
                                <td><?php echo $row['employee']; ?></td>
                            </tr>
                        <?php } ?>
                 </tbody>
                </table>
            </div>
            <!--เพิ่มข้อมูล -->
            <div id="modalAdd" class="modal fade" role="dialog">
              <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-list"></i> ออกเลขสัญญาจ้าง</h4>
                  </div>
                  <div class="modal-body">
                      <form method="post">
                          <label class="badge">วันที่ทำรายการ: <?php echo DateThai(); ?></label>
                        <div class="form-group">
                          <div class="input-group"> 
                              <span class="input-group-addon"><span class="glyphicon glyphicon-list"></span></span>
                              <input type="text" class="form-control" id="title" name="title"  placeholder="รายการจ้าง"  required="">
                          </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group"> 
                                <span class="input-group-addon"><i class="far fa-money-bill-alt"></i></span>
                                <input type="text" class="form-control" id="money" name="money"  placeholder="วงเงินการจ้าง" required="" onKeyUp="if(this.value*1!=this.value) this.value='' ;"> 
                            </div>
                        </div>
                       
                        <div class="form-group">
                            <div class="input-group"> 
                                <span class="input-group-addon"><span class="fa fa-user"></span></span>
                                <input type="text" class="form-control" id="employee" name="employee"  placeholder="ผู้รับจ้าง" required="" > 
                            </div>
                        </div>     
                        <div class="form-group form-inline">
                            <label for="datehire">ลงวันที่ :</label><input class="form-control" type="date" name="datehire"  id="datehire" required >
                        </div>
                        <div class="form-group">
                            <div class="input-group"> 
                                <span class="input-group-addon"><span class="fa fa-user-secret"></span></span>
                                <input type="text" class="form-control" id="signer" name="signer"  placeholder="ผู้ลงนาม" required="" > 
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="far fa-money-bill-alt"></i></span>
                                <input type="text" class="form-control" id="guarantee" name="guarantee"  placeholder="หลักประกัน" required="" onKeyUp="if(this.value*1!=this.value) this.value=''" ;> 
                            </div>
                        </div>
                        <div class="form-group form-inline">
                            <label for="">วันที่ส่งงาน :</label><input class="form-control" type="date" name="date_submit"  id="date_submit" required >
                        </div>
                        <?php 
                            $sql="SELECT *FROM depart WHERE dep_id=$dep_id";
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
                                <button class="btn btn-primary btn-lg" type="submit" name="save">
                                    <i class="fa fa-database fa-2x"></i> บันทึก
                                </button>
                            </center>                                                         
                      </form>
                  </div>
                  <div class="modal-footer bg-info">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                  </div>
                </div>
              </div>
            </div>
            <!-- End Model -->   
        </div> <!-- col-md-10 -->
    </div>    <!-- end row  -->
<!--  modal แสงรายละเอียดข้อมูล -->
        <div  class="modal fade bs-example-modal-table" tabindex="-1" aria-hidden="true" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-info">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"><i class="fa fa-info"></i> รายละเอียด</h4>
                    </div>
                    <div class="modal-body no-padding">
                        <div id="divDataview"></div>     
                    </div> <!-- modal-body -->
                    <div class="modal-footer bg-info">
                         <button type="button" class="btn btn-danger" data-dismiss="modal">close X</button>
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
    dbQuery('BEGIN');
    $sql="INSERT INTO hire (rec_no,datein,title,money,employee,date_hire,signer,guarantee,date_submit,dep_id,sec_id,u_id,yid)
                VALUES($rec_no,'$datein','$title',$money,'$employee','$datehire','$signer',$guarantee,'$date_submit',$dep_id,$sec_id,$u_id,$yid[0])";
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

<script type='text/javascript'>
       $('#tbHire').DataTable( {
        "order": [[ 0, "desc" ]]
    } )
</script>
