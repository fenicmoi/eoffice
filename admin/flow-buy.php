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
    <div class="panel panel-default" style="margin: 20">
        <div class="panel-heading">
            <i class="fas fa-clipboard-list  fa-2x" aria-hidden="true"></i>  <strong>ประกาศ</strong>
            <a href="" class="btn btn-primary pull-right" data-toggle="modal" data-target="#modalAdd">
                <i class="fa fa-plus" aria-hidden="true"></i> ลงประกาศ
            </a>
        </div> <!-- panel -heading-->
        <div class="panel-body">
            <table class="table table-bordered table-hover" id="tbCommand">
                <thead>
                    <tr>
                        <th>เลขที่อ้างอิง</th>
                        <th>เรื่อง</th>
                        <th>วันที่เผยแพร่</th>
                        <th>แก้ไข</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $count=1;
                    $sql="SELECT c.*,y.yname FROM  flowbuy as c INNER JOIN sys_year as y ON y.yid=c.yid";
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
                    $strDate1= date('Y-m-d');            //current date                           
                    while($row=dbFetchArray($result)){?>
                        <?php 
                            $cid=$row['cid'];
                            $strDate2=$row['dateout'];
                            $file_upload=$row['file_upload'];

                            //ตรวจสอบสิทธิ์การแก้ไข
                            $d1 = $row[ 'dateout' ];
                            $d2 = date( 'Y-m-d' );
                            $numday = getNumDay( $d1, $d2 );
                        ?>
                        <tr>
                            <td> <?php echo $row['rec_id'];?>/<?php echo $row['yname'];?></td> 
                            <td> <a href="#" onclick="load_leave_data_show('<?php print $u_id;?>','<?php print $cid;?>','<?php print $edit=0;?>');" data-toggle="modal" data-target=".bs-example-modal-table"> <?php echo $row['title'];?> </a></td>
                            <td><?php echo thaiDate($row['dateout']);?></td>
                            <?php if($numday >= $dayEdit){?>
                            <td><i class="fab fa-expeditedssl fa-2x"></i></td>
                            <?php }else{?>
                            <td> <a class="btn btn-warning" href="#" onclick="load_leave_data_edit('<?php print $u_id;?>','<?php print $cid;?>','<?php print $edit=0;?>');" data-toggle="modal" data-target=".bs-example-modal-table1"><i class="fas fa-edit"></i> แก้ไข </a></td>
                            <?php } ?>
                        </tr>
                    <?php $count++; } ?>
                </tbody>
            </table>
        </div> <!-- panel-body -->
        <div class="panel-footer">
            <center>
			<a href="flow-buy.php" class="btn btn-primary"><i class="fas fa-home"></i> หน้าหลัก</a>
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
</div>  <!-- col-md-10 -->


 <!-- Modal แสดงรายละเอียด -->
  <div  class="modal fade bs-example-modal-table" tabindex="-1" aria-hidden="true" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header bg-primary">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><i class="fa fa-info"></i> รายละเอียดประกาศ</h4>
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


 <!-- Modal แก้ไขเอกสาร -->
  <div  class="modal fade bs-example-modal-table1" tabindex="-1" aria-hidden="true" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header bg-primary">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><i class="fa fa-info"></i> แก้ไขประกาศ</h4>
        </div>
        <div class="modal-body no-padding">
            <div id="divDataviewEdit"></div>     <!-- สวนสำหรับแสดงผลรายละเอียด   อ้างอิงกับไฟล์  show_command_detail.php -->
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
       <h4 class="modal-title"> <i class="fas fa-plus"></i> ลงประกาศ</h4>
      </div>
      <div class="modal-body">
         <form name="form" method="post" enctype="multipart/form-data">
         <div class="form-group">
          <div class="input-group">
              <span class="input-group-addon">ปีที่ออกประกาศ:</span>
              <input type="text" class="form-control" name="yearDoc" value="<?php print $yname ;?>">
            </div>  
          </div>       
           <div class="form-group">
            <div class="input-group">
                <span class="input-group-addon">เลขที่ประกาศ:</span>
                <kbd>ออกโดยระบบ</kbd>
            </div>
          </div>
          <div class="form-group">
            <div class="input-group">
                <span class="input-group-addon">ผู้ลงนาม:</span>
                <input type="text" class="form-control" name="boss" required>
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
         <div class="form-group">
            <div class="input-group">
                <input class="form-control" type="file" name="fileupload" id="fileupload" required>
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

	$yearDoc=$_POST['yearDoc'];
	$currentDate=$_POST['currentDate'];
	$boss=$_POST['boss'];
	$title=$_POST['title'];
	$dateline=$_POST['datepicker'];
    $dateout=date('Y-m-d');

    @$fileupload=$_REQUEST['fileupload'];
	$date=date('Y-m-d');
	$numrand=(mt_rand());
	$upload=$_FILES['fileupload'];
	    if($upload<>''){
		    $part="buy/";
		    $type=  strrchr($_FILES['fileupload']['name'],".");
		    $newname=$date.$numrand.$type;
		    $part_copy=$part.$newname;
		    $part_link="buy/".$newname;
            move_uploaded_file($_FILES['fileupload']['tmp_name'],$part_copy);
            
            $sqlRun="SELECT cid,rec_id FROM flowbuy WHERE  yid=$yid  ORDER  BY cid DESC";
            $resRun=  dbQuery($sqlRun);
            $rowRun= dbFetchArray($resRun);
            $rec_id=$rowRun['rec_id'];
            $rec_id++;
	
	        $sql="INSERT INTO flowbuy (rec_id,yid,title,boss,dateline,dateout,file_upload,u_id,sec_id,dep_id)    
                  VALUE($rec_id,$yid,'$title','$boss','$dateline','$dateout','$part_link',$u_id,$sec_id,$dep_id)";
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
                                window.location.href='flow-buy.php';
                            }
                        }); 
                    </script>";
            }
            else{
                echo "<script>
                    swal({
                        title:'เรียบร้อย',
                        text:'ได้ประกาศหน้าเว็บไซต์เรียบร้อยแล้ว',
                        type:'success',
                        showConfirmButton:true
                        },
                        function(isConfirm){
                            if(isConfirm){
                                window.location.href='flow-buy.php';
                            }
                        }); 
                    </script>";
            } //if result
        } //if upload
} //if save



if(isset($_POST['update'])){
    $cid=$_POST['cid'];
    $boss=$_POST['boss'];
	$title=$_POST['title'];
    $dateline=$_POST['datepicker'];
    


	@$fileupload=$_REQUEST['fileupload'];
	$date=date('Y-m-d');
	$numrand=(mt_rand());
    $upload=$_FILES['fileupload'];
    
	    if($_FILES['fileupload']['name'] != null){
            $part="buy/";
            $type=  strrchr($_FILES['fileupload']['name'],".");
            $newname=$date.$numrand.$type;
            $part_copy=$part.$newname;
            $part_link="buy/".$newname;
            move_uploaded_file($_FILES['fileupload']['tmp_name'],$part_copy);
            $sql="UPDATE flowbuy SET title='$title',boss='$boss',dateline='$dateline',file_upload='$part_copy',date_edit='$date' WHERE cid=$cid";
        }else{
            $sql="UPDATE flowbuy SET title='$title',boss='$boss',dateline='$dateline',date_edit='$date' WHERE cid=$cid";
        }
		$result=  dbQuery($sql);
		
		if($result){
			echo "<script>
            swal({
                title:'เรียบร้อย',
                text:'แก้ไขเรียบร้อยแล้ว',
                icon:'success',
                type:'success',
                showConfirmButton:true
                },
                function(isConfirm){
                    if(isConfirm){
                        window.location.href='flow-buy.php';
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
                        window.location.href='flow-buy.php';
                    }
                }); 
            </script>";
        } //result
}  //update button
?>

<script type="text/javascript">
function load_leave_data_show( u_id, cid,edit) {
                    var sdata = {
                      u_id: u_id,
                      cid: cid,
                      edit:edit
                    };
                    $('#divDataview').load('show-buy-edit.php', sdata);
                  }
</script>


<script type="text/javascript">
function load_leave_data_edit( u_id, cid,edit) {
                    var sdata = {
                      u_id: u_id,
                      cid: cid,
                      edit:edit
                    };
                    $('#divDataviewEdit').load('show-buy.php', sdata);
                  }
</script>
