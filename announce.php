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
                <div class="panel-heading"><i class="fa fa-volume-up fa-2x" aria-hidden="true"></i>  <strong>เลขเอกสารประกวดราคา</strong>
                <a href="" class="btn btn-primary  pull-right" data-toggle="modal" data-target="#modalAdd">
                     <i class="fa fa-plus" aria-hidden="true"></i> ออกเลขเอกสาร
                    </a>
                </div> 
                <br>
                <table class="table table-bordered table-hover" id="tbHire">
                 <thead class="bg-info">
                     <tr>
                         <th>เลขระบบ</th>
                         <th>เลขประกาศ</th>
                         <th>ชื่องาน</th>
                         <th>สถานที่ติดต่อ</th>
                         <th>สิ้นสุดยื่นซอง</th>
                         <th>หน่วยงาน</th>
                     </tr>
                 </thead>
                 <tbody>
                 <?php
                    $sql = "SELECT MAX(hire_id) AS maxid FROM announce";// query อ่านค่า id สูงสุด
                    $result = dbQuery($sql);
                    $row=dbFetchAssoc($result);
                    $last_id = $row['maxid'];// คืนค่า id ที่ insert สูงสุด
                ?>
                     <?php
                        $sql="SELECT a.*,d.dep_name,y.yname
                              FROM announce a
                              INNER JOIN depart d ON d.dep_id=a.dep_id
                              INNER JOIN sys_year y ON a.yid=y.yid
                              WHERE a.dep_id = $dep_id
                              ORDER BY hire_id DESC
                              ";
                        //echo $sql;
                        $result = dbQuery($sql);
                        while($row=dbFetchArray($result)){?>
                            <tr>
                                <td><?=$row['hire_id']?></td>
                                <td>
                                <?php
                                    if($row['hire_id']==$last_id){//เลชประกาศ
                                        echo "<i class='fa fa-arrow-circle-right bg-danger '></i>". $row['rec_no'];?>/<?php echo $row['yname'];
                                    }else{
                                        echo $row['rec_no'];?>/<?php echo $row['yname'];
                                    }
                                ?>
                                 </td>
                                <td>
                                    <?php $hire_id=$row['hire_id'];?>
                                    <a href="#" 
                                            onClick="loadData('<?php print $hire_id;?>','<?php print $u_id; ?>');" 
                                            data-toggle="modal" data-target=".bs-example-modal-table">
                                             <?php echo $row['title'];?> 
                                    </a>
                                </td>                  <!-- ชื่องาน -->        
                                <td><?php echo $row['place_buy'];?></td>              <!-- สถานที่ขายแบบ -->
                                <td><?php echo thaiDate($row['date_pre_end']);?></td> 
                                <td><?php echo $row['dep_name'];?></td>  
                            </tr>
                        <?php
}
?>
                 </tbody>
                </table>
            </div>
            <!-- Model -->
            <!-- -ข้อมูลผู้ใช้ -->
            <div id="modalAdd" class="modal fade" role="dialog">
              <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-list"></i> ออกเลขประกาศ</h4>
                  </div>
                  <div class="modal-body">
                      <form method="post">
                          <label for="">วันที่ทำรายการ: <?php echo DateThai();?></label>
                        <div class="form-group">
                          <div class="input-group">
                              <span class="input-group-addon"><span class="glyphicon glyphicon-list"></span></span>
                              <input type="text" class="form-control" id="title" name="title"  placeholder="เรื่อง"  required="">
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="input-group">
                              <span class="input-group-addon"><span class="	glyphicon glyphicon-map-marker"></span></span>
                              <input type="text" class="form-control" id="place_buy" name="place_buy"  placeholder="สถานที่ขายแบบ"  required="">
                          </div>
                        </div>
                         <div class="form-group">
                           <div class="form-group form-inline">
                            <label for="date_start">วันที่ขายแบบ :</label><input class="form-control" type="date" name="date_start"  id="date_start" required>
                           </div>
                        </div>
                        <div class="form-group">
                           <div class="form-group form-inline">
                            <label for="date_end">วันที่สิ้นสุดให้แบบ :</label><input class="form-control" type="date" name="date_end"  id="date_end" required >
                           </div>
                        </div>
                         <div class="form-group">
                          <div class="input-group">
                              <span class="input-group-addon"><span class="	glyphicon glyphicon-map-marker"></span></span>
                              <input type="text" class="form-control" id="place_pre" name="place_pre"  placeholder="สถานที่ยื่นซอง"  required="">
                          </div>
                        </div>
                        <div class="form-group">
                           <div class="form-group form-inline">
                            <label for="date_pre_start">วันที่เริ่มยื่นซอง:</label><input class="form-control" type="date" name="date_pre_start"  id="date_pre_start" required >
                           </div>
                        </div>
                        <div class="form-group">
                           <div class="form-group form-inline">
                            <label for="date_pre_end">วันที่สิ้นสุดยื่นซอง:</label><input class="form-control" type="date" name="date_pre_end"  id="date_pre_end" required >
                           </div>
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
                                <button class="btn btn-primary btn-lg" type="submit" name="save">
                                    <i class="fa fa-database fa-2x"></i> บันทึก
                                </button>
                            </center>                                                         
                      </form>
                  </div>
                  <div class="modal-footer bg-info">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close X</button>
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
                    <div class="modal-header bg-success">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"><i class="fa fa-info"></i> รายละเอียด</h4>
                    </div>
                    <div class="modal-body no-padding">
                        <div id="divDataview"></div>     
                    </div> <!-- modal-body -->
                    <div class="modal-footer bg-success">
                         <button type="button" class="btn btn-danger" data-dismiss="modal">close X</button>
                    </div>
                </div>
            </div>
        </div>
<!-- จบส่วนแสดงรายละเอียดข้อมูล  -->
<?php
// ส่วน[ันทึกข้อมูล
if(isset($_POST['save'])){

    
	$datein=date('Y-m-d');   
	$title=$_POST['title'];            //เรื่อง
	$place_buy=$_POST['place_buy'];    //สถานที่ขายแบบ
	$date_start=$_POST['date_start'];  //วันที่เริ่มขายแบบ
	$date_end=$_POST['date_end'];      //วันที่หยุดขายแบบ
	$place_pre=$_POST['place_pre'];    //สถานที่ยื่นซอง
	$date_pre_start=$_POST['date_pre_start'];   //วันที่เริ่มยื่นซอง
	$date_pre_end=$_POST['date_pre_end'];       //วันที่หยุดรับซอง
	
	
	   $sql="SELECT hire_id,rec_no
          FROM announce      
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
       
	
	dbQuery('BEGIN');
	$sql="INSERT INTO  announce(rec_no,datein,title,place_buy,date_start,date_end,place_pre,date_pre_start,date_pre_end,dep_id,sec_id,u_id,yid)
                VALUES($rec_no,'$datein','$title','$place_buy','$date_start','$date_end','$place_pre','$date_pre_start','$date_pre_end',$dep_id,$sec_id,$u_id,$yid[0])";
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
                    window.location.href='announce.php';
                }
            }); 
        </script>";
	}
	else{
		dbQuery("ROLLBACK");
		echo "<script>
        swal({
            title:'มีบางอย่างผิดพลาด! กรุณาตรวจสอบ',
            type:'error',
            showConfirmButton:true
            },
            function(isConfirm){
                if(isConfirm){
                    window.location.href='announce.php';
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

<script type="text/javascript">
function loadData(hire_id,u_id) {
    var sdata = {
        hire_id : hire_id,
        u_id : u_id 
    };
$('#divDataview').load('show_announce_detail.php',sdata);
}
</script>
