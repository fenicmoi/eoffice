<?php

/*if(!isset($_SESSION['ses_u_id'])){
header("location:../index.php");
}
*/
//date_default_timezoe_set('Asia/Bangkok');
include "header.php";
$u_id=$_SESSION['ses_u_id'];
//include '../library/database.php';
//include "crud_flowcommand.php";
?>
<?php    
  //ตรวจสอบปีเอกสาร
  list($yid,$yname,$ystatus)=chkYear();
$yid=$yid;
$yname=$yname;
$ystatus=$ystatus;


?>
        <div class="col-md-2" >
           <?php
                $menu=  checkMenu($level_id);
include $menu;
?>
        </div>
        <div  class="col-md-10">
            <div class="alert alert-danger">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <i class="fas fa-volume-up fa-2x"></i><strong> ขอความร่วมมือ!</strong> แนบไฟล์ทุกครั้งที่ออกคำสั่ง เพื่อให้ค้นหาได้ง่ายในภายหลังนะครับ1
            </div>
            <div class="panel panel-default" style="margin: 20">
                <div class="panel-heading">
                        <i class="fas fa-clipboard-list  fa-2x" aria-hidden="true"></i>  <strong>หนังสือคำสั่ง</strong>
                        <a href="" class="btn btn-primary pull-right" data-toggle="modal" data-target="#modalAdd">
                            <i class="fa fa-plus" aria-hidden="true"></i> ออกเลขคำสั่ง
                        </a>
                </div> <!-- panel -heading-->
                     <table class="table table-bordered table-hover" id="tbCommand">
                        <thead>
                            <tr>
                                <th>Ref_sys</th>
                                <th>เลขที่</th>
                                <th>เรื่อง</th>
                                <th>ลงวันที่</th>
                                <th>ไฟล์</th>
                                <th>แก้ไข</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                               $count=1;
                               $sql="SELECT c.*,y.yname FROM  flowcommand as c INNER JOIN sys_year as y ON y.yid=c.yid";
                               switch ($level_id) {
                                   case 1:      //programmer
                                       $sql=$sql;
                                       break;
                                   case 2:      //admin
                                        $sql=$sql;
                                        break;
                                    case 3:     //sub_admin
                                       $sql.=" WHERE c.dep_id=$dep_id";
                                       break;
                                    case 4:     //group_admin
                                       $sql.=" WHERE c.sec_id=$sec_id";
                                       break;
                                    case 5:     //user
                                       $sql.=" WHERE c.u_id=$u_id";
                                       break;
                               }
                          $sql.=" ORDER BY c.cid DESC";
                          //echo "level=".$level_id;
                          //print $sql;
                          // $edit=1;
                               $result = dbQuery($sql);

                               $strDate1= date('Y-m-d');            //current date                           
                              while($row=dbFetchArray($result)){?>
                                    <?php 
                                    $cid=$row['cid'];
                                    $strDate2=$row['dateout'];
                                    $file_upload=$row['file_upload'];

                                    ?>
                                    <tr>
                                        <td><?php echo $row['cid'];?> </td>
                                        <td> <?php echo $row['rec_id'];?>/<?php echo $row['yname'];?></td> 
                                        <td> <a href="#" onclick="load_leave_data('<?php print $u_id;?>','<?php print $cid;?>','<?php print $edit=0;?>');" data-toggle="modal" data-target=".bs-example-modal-table"> <?php echo $row['title'];?> </a></td>
                                        <td><?php echo thaiDate($row['dateout']);?></td>
                                        <?php 
                                          $file_upload=$row['file_upload'];
                                          if($file_upload==''){ ?>
                                              <td> <a class="btn btn-danger" href="#" onclick="load_leave_data('<?php print $u_id;?>','<?php print $cid;?>','<?php print $edit=0;?>');" data-toggle="modal" data-target=".bs-example-modal-table">คลิกแนบไฟล์ </a></td>
                                          <? }else{ ?>
                                              <td class='bg-success'><a class="btn btn-success" href="<?=$row['file_upload']?>" target='_blank'><i class='fas fa-file-pdf'></i>  ไฟล์คำสั่ง</a></td>
                                         <? } ?>
                                         <?php
                                          $diff=DateDiff($strDate2,$strDate1);
                                          if($diff>7){ ?>    
                                             <td><center><i class="fas fa-hand-paper fa-2x"></i></center></td>
                                         <? }else{ ?>
                                         <td><a class="btn btn-warning" href="#" onclick="load_leave_data('<?php print $u_id;?>','<?php print $cid;?>','<?php print $edit=0;?>');" data-toggle="modal" data-target="#modalEdit"><i class="fas fa-edit"></i> แก้ไข </a></td>
                                         <? } ?>
                                    </tr>
                                    <?php $count++; } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>  <!-- col-md-10 -->
    </div>  <!-- container -->

 <!-- Modal แสดงรายละเอียด -->
  <div  class="modal fade bs-example-modal-table" tabindex="-1" aria-hidden="true" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header bg-primary">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><i class="fa fa-info"></i> รายละเอียดคำสั่ง</h4>
        </div>
        <div class="modal-body no-padding">
            <div id="divDataview"></div>     <!-- สวนสำหรับแสดงผลรายละเอียด   อ้างอิงกับไฟล์  show_command_detail.php -->
        </div> <!-- modal-body -->
        <div class="modal-footer bg-primary">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</div>
<!--end Modal  -->

<!-- Modal -->
<div id="modalAdd" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
       <h4 class="modal-title"> <i class="fas fa-plus"></i> ออกเลขคำสั่ง</h4>
      </div>
      <div class="modal-body">
         <form name="form" method="post" enctype="multipart/form-data">
         <div class="form-group">
          <div class="input-group">
              <span class="input-group-addon">ปีคำสั่ง:</span>
              <input type="text" class="form-control" name="yearDoc" value="<?php print $yname ;?>">
            </div>  
          </div>       
           <div class="form-group">
            <div class="input-group">
                <span class="input-group-addon">เลขที่คำสั่ง:</span>
                <kbd>ออกโดยระบบ</kbd>
            </div>
          </div>
          <div class="form-group">
            <div class="input-group">
                <span class="input-group-addon">ผู้ลงนาม:</span>
                <input type="text" class="form-control" name="boss" value="ผู้ว่าราชการจังหวัดพังงา">
            </div>
          </div>
          <div class="form-group">
            <div class="input-group">
                <span class="input-group-addon">เรื่อง:</span>
                <input class="form-control" type="text" class="form-control" name="title" required>
            </div>
          </div>
          <div class="form-group">
            <div class="input-group">
                <span class="input-group-addon">วันที่ลงนาม:</span>
                <input class="form-control" type="date" name="datepicker"  id="datepicker" required >
            </div>
         </div>
         <div class="form-group">
            <div class="input-group">
                <span class="input-group-addon">วันที่บันทึก:</span>
                <input type="text" name="currentDate"  id="currentDate" value="<?php  echo DateThai();?>" >
            </div>
         </div>
         <div class="form-group">
            <div class="input-group">
                <input class="form-control" type="file" name="fileupload" id="fileupload" disabled><label><i class="fas fa-exclamation-circle"></i>ออกเลขให้เสร็จก่อนดำเนินการแนบไฟล์</label>
            </div>
         </div>
             <center> <button class="btn btn-primary" type="submit" name="save" id="save"><i class="fas fa-save fa-2x"></i> บันทึก</button></center>
         </form>
      </div>
      <div class="modal-footer bg-primary">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<?php    //precess add
if(isset($_POST['save'])){
	//ก	ดปุ่มบันทึกจากฟอร์มบันทึก
	    $yearDoc=$_POST['yearDoc'];
	//ป	ีเอกสาร
	    $currentDate=$_POST['currentDate'];
	// 	วันที่ทำรายการ
	    $boss=$_POST['boss'];
	$title=$_POST['title'];
	//เ	รื่อง
	    $dateline=$_POST['datepicker'];
	//ว	ันที่มีผลบังคับใช้
        $dateout=date('Y-m-d');
        
	$sqlRun="SELECT cid,rec_id FROM flowcommand WHERE  yid=$yid  ORDER  BY cid DESC";
	$resRun=  dbQuery($sqlRun);
	$rowRun= dbFetchArray($resRun);
	$rec_id=$rowRun['rec_id'];
	$rec_id++;
	
	$sql="INSERT INTO flowcommand
                         (rec_id,yid,title,boss,dateline,dateout,u_id,sec_id,dep_id)    
                    VALUE($rec_id,$yid,'$title','$boss','$dateline','$dateout',$u_id,$sec_id,$dep_id)";
	//p	rint $sql;
	
	$result=dbQuery($sql);
	if(!$result){
		echo "<script>
            swal({
                title:'มีบางอย่างผิดพลาด! กรุณาตรวจสอบ',
                type:'error',
                showConfirmButton:true
                },
                function(isConfirm){
                    if(isConfirm){
                        window.location.href='flow-command.php';
                    }
                }); 
            </script>";
	}
	else{
		echo "<script>
            swal({
                title:'เรียบร้อย',
                text:'!..เพื่อความสมบูรณ์กรุณาแนบไฟล์คำสั่งด้วย',
                type:'success',
                showConfirmButton:true
                },
                function(isConfirm){
                    if(isConfirm){
                        window.location.href='flow-command.php';
                    }
                }); 
            </script>";
	}
	
}



if(isset($_POST['update'])){
	$cid=$_POST['cid'];
	// 	echo "cid=".$cid;
	@$fileupload=$_REQUEST['fileupload'];
	//ก	ารจัดการ fileupload
	    $date=date('Y-m-d');
	$numrand=(mt_rand());
	//ส	ุ่มตัวเลข
	    $upload=$_FILES['fileupload'];
	//เ	พิ่มไฟล์
	    if($upload<>''){
		$part="command/";
		//โ		ฟลเดอร์เก็บเอกสาร
		        $type=  strrchr($_FILES['fileupload']['name'],".");
		//เ		อาชื่อเก่าออกให้เหลือแต่นามสกุล
		        $newname=$date.$numrand.$type;
		//ต		ั้งชื่อไฟล์ใหม่โดยใช้เวลา
		        $part_copy=$part.$newname;
		$part_link="command/".$newname;
		move_uploaded_file($_FILES['fileupload']['tmp_name'],$part_copy);
		//ค		ัดลอกไฟล์ไป Server
		
		$sql="UPDATE flowcommand SET file_upload='$part_copy' WHERE cid=$cid";
		$result=  dbQuery($sql);
		
		if($result){
			echo "<script>
            swal({
                title:'เรียบร้อย',
                text:'ขอบคุณสำหรับการแนบไฟล์',
                icon:'success',
                type:'success',
                showConfirmButton:true
                },
                function(isConfirm){
                    if(isConfirm){
                        window.location.href='flow-command.php';
                    }
                }); 
            </script>";
		}
		else{
			echo "<script>
            swal({
                title:'มีบางอย่างผิดพลาด! กรุณาตรวจสอบ',
                type:'error',
                showConfirmButton:true
                },
                function(isConfirm){
                    if(isConfirm){
                        window.location.href='flow-command.php';
                    }
                }); 
            </script>";
		}
		
	}
	else{
		echo "<meta http-equiv='refresh' content='1;URL=flow-command.php'>";
	}
}
?>



<!-- modal Edit -->
<div id="modalEdit" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
       <h4 class="modal-title"> <i class="fas fa-edit"></i> แก้ไข</h4>
      </div>
      <div class="modal-body">
         <form name="form" method="post" enctype="multipart/form-data">
         <div class="form-group">
          <div class="input-group">
              <span class="input-group-addon">ปีคำสั่ง:</span>
              <input type="text" class="form-control" name="yearDoc" value="<?php print $yname ;?>">
            </div>  
          </div>       
           <div class="form-group">
            <div class="input-group">
                <span class="input-group-addon">เลขที่คำสั่ง:</span>
                <kbd>ออกโดยระบบ</kbd>
            </div>
          </div>
          <div class="form-group">
            <div class="input-group">
                <span class="input-group-addon">ผู้ลงนาม:</span>
                <input type="text" class="form-control" name="boss" value="ผู้ว่าราชการจังหวัดพังงา">
            </div>
          </div>
          <div class="form-group">
            <div class="input-group">
                <span class="input-group-addon">เรื่อง:</span>
                <input class="form-control" type="text" class="form-control" name="title" required>
            </div>
          </div>
          <div class="form-group">
            <div class="input-group">
                <span class="input-group-addon">วันที่ลงนาม:</span>
                <input class="form-control" type="date" name="datepicker"  id="datepicker" required >
            </div>
         </div>
         <div class="form-group">
            <div class="input-group">
                <span class="input-group-addon">วันที่บันทึก:</span>
                <input type="text" name="currentDate"  id="currentDate" value="<?php  echo DateThai();?>" >
            </div>
         </div>
         <div class="form-group">
            <div class="input-group">
                <input class="form-control" type="file" name="fileupload" id="fileupload" disabled><label><i class="fas fa-exclamation-circle"></i>ออกเลขให้เสร็จก่อนดำเนินการแนบไฟล์</label>
            </div>
         </div>
             <center> <button class="btn btn-primary" type="submit" name="save" id="save"><i class="fas fa-save fa-2x"></i> บันทึก</button></center>
         </form>
      </div>
      <div class="modal-footer bg-primary">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
function load_leave_data( u_id, cid,edit) {
                    var sdata = {
                      u_id: u_id,
                      cid: cid,
                      edit:edit
                    };
                    $('#divDataview').load('show_command_detail.php', sdata);
                  }
</script>
<script type='text/javascript'>
       $('#tbCommand1').DataTable( {
        "order": [[ 0, "desc" ]]
    } )
</script> 