<?php
include "header.php";
$u_id=$_SESSION['ses_u_id'];
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
        <div class="panel panel-primary" style="margin: 20">
            <div class="panel-heading">
                <i class="fas fa-clipboard-list  fa-2x" aria-hidden="true"></i>  <strong>ทะเบียนคำสั่งจังหวัด</strong>

                <a href="" class="btn btn-default pull-right" data-toggle="modal" data-target="#modalReserv">
                    <i class="fas fa-hand-point-up"></i> จองเลขคำสั่ง
                </a>
                <a href="" class="btn btn-default pull-right" data-toggle="modal" data-target="#modalAdd">
                    <i class="fa fa-plus" aria-hidden="true"></i> ออกเลขคำสั่ง
                </a>
            </div> <!-- panel -heading-->
            <div class="panel-body">
                <table class="table table-bordered table-hover" id="tbCommand">
                    <thead class="bg-info">
                        <tr style="backgroundcolor:red">
                            <th width="10%">เลขที่</th>
                            <th width="60%">เรื่อง</th>
                            <th width="10%">วันที่บันทึก</th>
                            <th width="10%">ไฟล์</th>
                            <th width="10%" style="text-align: center;"><i class="fas fa-cog" style=""></i></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
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
                    $result = page_query( $dbConn, $sql, 10 );

                  

                    while($row=dbFetchArray($result)){
                        $cid= $row['cid'];
                        $d1 = $row['dateout'];
                        $d2 = date( 'Y-m-d' );
                        $numday = getNumDay( $d1, $d2 );

                        $file_upload = $row['file_upload'];
                        ?>
                        <tr>
                            <td > 
                                <?php
                                    if($file_upload == ""){
                                        echo "<i class='fas fa-ticket-alt'></i>ขาด file แนบ";
                                    }else{
                                        echo $row['rec_id'];?>/<?php echo $row['yname'];
                                    }
                                ?>
                            </td> 
                            <td >
                                <a class="text-success" href="#" onclick="load_leave_data('<?php print $u_id;?>','<?php print $cid;?>','<?php print $edit=0;?>');" data-toggle="modal" data-target=".bs-example-modal-table"> <?php echo $row['title'];?> </a> 
                            </td>
                            <td><?php echo thaiDate($row['dateout']);?></td>
                        <?php 
                            $file_upload=$row['file_upload'];
                            if($file_upload ==''){ ?>
                                <td><i class="fas fa-sad-tear"></i> No file</td>
                            <?php }else{ ?>
                                <td ><a class="btn btn-success btn-sm" href="<?php print $row['file_upload'];?>" target='_blank'><i class='fas fa-file-pdf'></i>  ไฟล์คำสั่ง</a></td>
                            <?php } ?>
                            <td>
                            <form name="frmDel" action="#" method="post" >
                                <div class="btn-group" role="group" aria-label="Basic example">
                                        <?php 
                                        if($numday > $dayEdit){?>
                                            <a class="btn btn-default btn-sm disabled" href="#" onclick="load_leave_data('<?php print $u_id;?>','<?php print $cid;?>','<?php print $edit=0;?>');" data-toggle="modal" data-target=".bs-example-modal-table"><i class="fas fa-edit"></i> แก้ไข</a> 
                                            <!-- <input type="submit" class="btn btn-danger btn-sm disabled" name="btnDel" id="btnDel" onclick="return confirm('คุณกำลังจะลบข้อมูล!');" value="ลบ"> -->
                                    <?php }else{ ?>
                                            <a class="btn btn-warning btn-sm" 
                                                href="#" 
                                                onclick="load_edit('<?php print $u_id;?>','<?php print $cid;?>','<?php print $edit=0;?>');" 
                                                data-toggle="modal" 
                                                data-target=".bs-example-modal-table"> 
                                                <i class="fas fa-edit"></i> แก้ไข
                                            </a> 
                                            <input type="hidden" id="cid" name ="cid" value="<?php echo $cid;?>">
                                            <!-- <input type="submit" class="btn btn-danger btn-sm" name="btnDel" id="btnDel" onclick="return confirm('คุณกำลังจะลบข้อมูล!');" value="ลบ"> -->
                                    <?php } ?>
                        
                                </div>
                            </form>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                    <tfoot>
                          <tr><td colspan="5"><div  style="text-align:center;">กำหนดแก้ไขได้ภายใน 3 วัน</div></td></tr>
                    </tfoot>
                </table>
            </div> <!-- panel-body -->
        <div class="panel-footer">
            <center>
			<a href="flow-command.php" class="btn btn-primary"><i class="fas fa-home"></i> หน้าหลัก</a>
			<?php 
				page_link_border("solid","1px","gray");
				page_link_bg_color("lightblue","pink");
				page_link_font("14px");
				page_link_color("blue","red");
				page_echo_pagenums(10,true); 
			?>
			</center>
        </div>
    </div> <!-- panel-->
    </div>
</div>  <!-- col-md-10 -->
</div>  <!-- container -->

 <!-- Modal แสดงรายละเอียด -->
  <div  class="modal fade bs-example-modal-table" tabindex="-1" aria-hidden="true" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header bg-primary">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><i class="fa fa-info"></i> รายละเอียดคำสั่งจังหวัด</h4>
        </div>
        <div class="modal-body no-padding">
            <div id="divDataview"></div>     <!-- สวนสำหรับแสดงผลรายละเอียด   อ้างอิงกับไฟล์  show_command_detail.php -->
        </div> <!-- modal-body -->
        <div class="modal-footer bg-primary">
          <button type="button" class="btn btn-danger" data-dismiss="modal">ปิด X</button>
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
              <input type="text" class="form-control" name="yearDoc" value="<?php print $yname ;?>" disabled>
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
                <input type="text" class="form-control" name="boss" value="ผู้ว่าราชการจังหวัดพัทลุง">
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
                <input class="form-control" type="date" name="datepicker"  id="datepicker" onKeyDown="return false" required >
            </div>
         </div>
         <div class="form-group">
            <div class="input-group">
                <span class="input-group-addon">วันที่บันทึก:</span>
                <input type="text" name="currentDate"  id="currentDate" value="<?php  echo DateThai();?>" >
            </div>
         </div>
         <!-- <div class="form-group">
            <div class="input-group">
                <input class="form-control" type="file" name="fileupload" id="fileupload" disabled><label><i class="fas fa-exclamation-circle"></i>ต้องแนบไฟล์ เพื่อแสดงเลขที่คำสั่ง</label>
            </div>
         </div> -->
         <div class="form-group">
            <div class="input-group">
                <label class="radio-inline"><input type="radio" name="doc_status" value="1" checked>เปิดเผย (แสดงหน้าเว็บไซต์)</label>
                <label class="radio-inline"><input type="radio" name="doc_status" value="2">ไม่เปิดเผย</label> 
            </div>
         </div>
             <center> <button class="btn btn-success" type="submit" name="save" id="save"><i class="fas fa-save fa-2x"></i> บันทึก</button></center>
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
	    @$yearDoc=$_POST['yearDoc'];
	    $currentDate=$_POST['currentDate'];
	    $boss=$_POST['boss'];
	    $title=$_POST['title'];
	    $dateline=$_POST['datepicker'];
        $dateout=date('Y-m-d');
        $doc_status = $_POST['doc_status'];
        
	$sqlRun="SELECT cid,rec_id FROM flowcommand WHERE  yid=$yid  ORDER  BY cid DESC";
	$resRun=  dbQuery($sqlRun);
	$rowRun= dbFetchArray($resRun);
	$rec_id=$rowRun['rec_id'];
	$rec_id++;
	
	$sql="INSERT INTO flowcommand
                         (rec_id,yid,title,boss,dateline,dateout,u_id,sec_id,dep_id,doc_status)    
                    VALUE($rec_id,$yid,'$title','$boss','$dateline','$dateout',$u_id,$sec_id,$dep_id,$doc_status)";
    
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
	}else{
        //หาหมายเลขหนังสือล่าสุด 
        $sql = "SELECT  *  FROM  flowcommand WHERE u_id = $u_id  ORDER BY cid DESC LIMIT 1";
        $result = dbQuery($sql);
        $row = dbFetchArray($result);
        $rec_id = $row['rec_id'];
		echo "<script>
            swal({
                title:'เลขที่คำสั่ง".$rec_id."/".$yname."',
                text:'!แนบไฟล์คำสั่งด้วย',
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
?>

<!-- Modal Reserv -->
<div id="modalReserv" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
       <h4 class="modal-title"> <i class="fas fa-plus"></i> จองเลขคำสั่ง</h4>
      </div>
      <div class="modal-body">
         <div class="alert alert-danger"><i class="fas fa-comments" fa-2x></i>ระบุจำนวนเอกสารที่ต้องการจอง</div>
         <form name="form" method="post" enctype="multipart/form-data">
          <div class="form-group col-sm-6">
            <div class="input-group">
                <span class="input-group-addon">จำนวน:</span>
                <input type="number" class="form-control" name="num" max=10  placeholder="ไม่เกิน 10 ฉบับ">
            </div>
          </div>
             <center> <button class="btn btn-success" type="submit" name="btnReserv" id="btnReserv"><i class="fas fa-save fa-2x"></i> บันทึก</button></center>
         </form>
      </div>
      <div class="modal-footer bg-primary">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!--  process  Reserv -->
<?php
if(isset($_POST['btnReserv'])){

        $title = "จองเลขคำสั่ง...";
        $boss = "ผู้ว่าราชการจังหวัด";
        $dateline = date("Y-m-d");
        $dateout = date("Y-m-d");
        $num = $_POST['num'];
        $a=0;
     
        while ($a < $num) {
            $sql = "SELECT max(rec_id) as rec_id FROM flowcommand where yid=$yid";
            $result = dbQuery($sql);
            $row = dbFetchArray($result);
            $rec_id = $row['rec_id'];
            $rec_id = $rec_id + 1;

            $sql="INSERT INTO flowcommand
                         (rec_id,yid,title,boss,dateline,dateout,u_id,sec_id,dep_id)    
                    VALUE($rec_id,$yid,'$title','$boss','$dateline','$dateout',$u_id,$sec_id,$dep_id)";
            $result = dbQuery($sql);
            $a++;

        }
        
        if($a == $num){
            echo "<script>
            swal({
                title:'เรียบร้อย',
                text:'!มีเวลา 3 วัน หลังวันจอง  เพื่อแก้ไขชื่อคำสั่งให้ถูกต้อง',
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

<?php
if(isset($_POST['update'])){

    $cid=$_POST['cid'];
    $title = $_POST['title'];
    $boss = $_POST['boss'];
    $dateline = $_POST['dateline'];
	$date=date('Y-m-d');
	$numrand=(mt_rand());
    $part="command/";
    
	    if($_FILES['fileupload']['size'] <> 0 ){
		    $type =  strrchr($_FILES['fileupload']['name'],".");
		    $newname = $date.$numrand.$type;
		    $part_copy = $part.$newname;
		    move_uploaded_file($_FILES['fileupload']['tmp_name'],$part_copy);
            $sql="UPDATE flowcommand SET title='$title', boss='$boss', dateline='$dateline', file_upload='$part_copy' WHERE cid=$cid";
		    $result=  dbQuery($sql);
		
            if($result){
                echo "<script>
                swal({
                    title:'เรียบร้อย',
                    text: 'แนบไฟล์เรียบร้อยแล้ว',
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
            }else{  
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
            
	}else{  //case nofile
            $sql="UPDATE flowcommand SET title='$title', boss='$boss', dateline='$dateline' WHERE cid=$cid";
            $result = dbQuery($sql);
            if($result){
                echo "<script>
                swal({
                    title:'เรียบร้อย',
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
            }else{  
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
    }  //check upload
}  //check button


if(isset($_POST['btnDel'])){
    $cid = $_POST["cid"];
    $sql = "DELETE  FROM flowcommand WHERE cid = $cid";
    $result = dbQuery($sql);
    if($result){
        echo "<script>
        swal({
            title:'เรียบร้อย',
            text:'ลบไฟล์เรียบร้อยแล้ว',
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
?>



<script type="text/javascript">

function load_leave_data( u_id, cid,edit) {
    var sdata = {
        u_id: u_id,
        cid: cid,
        edit:edit
    };
    $('#divDataview').load('show_command_detail.php', sdata);
}

function load_edit( u_id, cid) {
    var sdata = {
        u_id: u_id,
        cid: cid
    };
    $('#divDataview').load('show_command_reserv_edit.php', sdata);
}
</script>
