

<?php
include "header.php"; 
$yid=chkYear();

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
            <div class="panel panel-default" style="margin: 20">
                <div class="panel-heading"><i class="fas fa-shopping-cart"></i>  <strong>ทะเบียนคุมสัญญาซื้อ/ขาย</strong>
                <a href="" class="btn btn-primary  pull-right" data-toggle="modal" data-target="#modalAdd">
                     <i class="fas fa-plus"></i> ออกเลขสัญญา
                    </a>
                </div> 
                <br>
                <table class="table table-bordered table-hover" id="tbHire">
                 <thead class="bg-info">
                     <tr>
                         <th>Ref_sys</th>
                         <th>เลขสัญญา</th>
                         <th>วันที่ทำรายการ</th>
                         <th>รายการซื้อ/ขาย</th>
                         <th>วงเงิน</th>
                         <th>ผู้ซื้อ/ขาย</th>
                         <th>วันที่ซื้อ/ขาย</th>
                         <th>ผู้ลงนาม</th>
                         <th>หลักประกัน</th>
                         <th>วันที่ส่งงาน</th>
                         <th>หน่วยงาน</th>
                     </tr>
                 </thead>
                 <tbody>
                 <?php
                        $sql = "SELECT MAX(hire_id) AS maxid FROM buy"; // query อ่านค่า id สูงสุด
                        $result = dbQuery($sql);
                        $row=dbFetchAssoc($result);
                        $last_id = $row['maxid']; // คืนค่า id ที่ insert สูงสุด
                        //echo "this is last_id:".$last_id;
                ?>
                     <?php
                        // $sql="SELECT h.*,d.dep_name,y.yname
                        //       FROM buy h
                        //       INNER JOIN depart d ON d.dep_id=h.dep_id
                        //       INNER JOIN sys_year y ON h.yid=y.yid
                        //       WHERE  h.dep_id=$dep_id
                        //       ";
                        $sql="SELECT b.*,d.dep_name,y.yname
                              FROM buy as b
                              INNER JOIN depart as d ON d.dep_id=b.dep_id
                              INNER JOIN sys_year as y ON b.yid=y.yid
                              ORDER BY  b.hire_id DESC
                              ";
                        print $sql;
                        $result = dbQuery($sql);
                        while($row=dbFetchArray($result)){?>
                            <tr>
                                <td><?=$row['hire_id']?></td>
                                <td>
                                <?php
                                    if($row['hire_id']==$last_id){
                                        echo "<i class='fas fa-play '></i>". $row['rec_no']; ?>/<?php echo $row['yname'];  
                                    }else{
                                        echo $row['rec_no']; ?>/<?php echo $row['yname'];
                                    }
                                                                     ?>
                                 </td>
                                <td><?php echo thaiDate($row['datein']); ?></td>
                                <td><?php echo $row['title']; ?></td>
                                <td><?php echo number_format($row['money']); ?></td>
                                <td><?php echo $row['employee']; ?></td>
                                <td><?php echo thaiDate($row['date_hire']); ?></td>
                                <td><?php echo $row['signer']; ?></td>
                                <td><?php echo number_format($row['guarantee']); ?></td>
                                <td><?php echo thaiDate($row['date_submit']); ?></td>
                                <td><?php echo $row['dep_name']; ?></td>  
                            </tr>
                        <?php } ?>
                 </tbody>
                </table>
                
            </div>
            <!-- Model -->
            <!-- -เพิ่มข้อมูล -->
            <div id="modalAdd" class="modal fade" role="dialog">
              <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-list"></i> ออกเลขสัญญาซื้อ/ขาย</h4>
                  </div>
                  <div class="modal-body">
                       <label class="alert alert-danger"><i class="fas fa-exclamation-triangle"></i>ช่องวันที่ ให้กดเลือกห้ามพิมพ์โดยเด็ดขาด แนะนำให้ใช้ google chrome </label>
                      <form method="post">
                          <label for="">วันที่ทำรายการ: <?php echo DateThai(); ?></label>
                        <div class="form-group">
                          <div class="input-group">
                              <span class="input-group-addon"><span class="glyphicon glyphicon-list"></span></span>
                              <input type="text" class="form-control" id="title" name="title"  placeholder="รายการซื้อ/ขาย"  required="">
                          </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fas fa-money-bill-alt"></i></span>
                                <input type="text" class="form-control" id="money" name="money"  placeholder="วงเงินซื้อ/ขาย" required=""  onKeyUp="if(this.value*1!=this.value) this.value='' ;"> 
                            </div>
                        </div>
                       
                        <div class="form-group">
                            <div class="input-group">  
                                <span class="input-group-addon"><span class="fa fa-user"></span></span>
                                <input type="text" class="form-control" id="employee" name="employee"  placeholder="ผู้รับซื้อ/ขาย" required="" > 
                            </div>
                        </div>     
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><label for="datehire">วันที่ทำสัญญา :</label></span>
                                <input class="form-control" type="date" name="datehire"  id="datehire" required >
                                
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group"> 
                                <span class="input-group-addon"><span class="fa fa-user-secret"></span></span>
                                <input type="text" class="form-control" id="signer" name="signer" value="ผู้ว่าราชการจังหวัดพังงา" placeholder="ผู้ลงนาม" required="" > 
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group"> 
                                <span class="input-group-addon"><i class="fas fa-money-bill-alt"></i></span>
                                <input type="text" class="form-control" id="guarantee" name="guarantee"  placeholder="หลักประกัน *ไม่มีใส่ 0" require=""  onKeyUp="if(this.value*1!=this.value) this.value=''" ;> 
                            </div>
                        </div>
                        <div class="form-group form-inline">
                            <div class="input-group">
                            <span class="input-group-addon"><label for="">วันที่ส่งงาน :</label></span>
                            <input class="form-control" type="date" name="date_submit"  id="date_submit" required >
                          
                            </div>
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
                                <button class="btn btn-success btn-lg" type="submit" name="save">
                                    <i class="fa fa-save fa-2x"></i> บันทึก
                                </button>
                            </center>                                                         
                      </form>
                  </div>
                  <div class="modal-footer bg-primary">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                  </div>
                </div>
              </div>
            </div>
            <!-- End Model -->   
        </div>
    </div>  

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
          FROM buy
          WHERE yid=$yid[0]
          ORDER BY hire_id DESC
          LIMIT 1";
    //print $sql;
    
    $result=dbQuery($sql);
    $row=dbFetchAssoc($result);
    $rec_no=$row['rec_no'];

    if($rec_no==0){
       $rec_no=1;
    }else{
       $rec_no++; 
    } 
    //echo "This is $rec_no=".$rec_no;
    dbQuery('BEGIN');
    $sql="INSERT INTO buy (rec_no,datein,title,money,employee,date_hire,signer,guarantee,date_submit,dep_id,sec_id,u_id,yid)
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
                    window.location.href='buy.php';
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
                    window.location.href='buy.php';
                }
            }); 
        </script>";
    }     
    
}
?>

<script type='text/javascript'>
       $('#tbHire').DataTable( {
        "order": [[ 0, "desc" ]]
    } )
</script>
