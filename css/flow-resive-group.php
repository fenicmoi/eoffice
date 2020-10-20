<!-- หนังสือรับถึงจังหวัด -->
<script type="text/javascript" src="datePicket.js"></script>
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
            <div class="panel panel-default" >
                <div class="panel-heading"><i class="fa fa-university fa-2x"></i>  <strong>หนังสือรับกลุ่มงาน</strong>
                    <div class="btn-group btn-grouop-lg pull-right">
                       <a href="" class="btn btn-primary" data-toggle="modal" data-target="#modalAdd">
                            <i class="fa fa-plus"></i> ลงทะเบียนรับ
                      </a>
                        
                        <a href="" class="btn btn-primary" data-toggle="modal" data-target="#myReport">
                        <i class="fa fa-print"></i> พิมพ์รายงาน
                        </a>
                        <a href="" class="btn btn-primary" data-toggle="modal" data-target="#myReport">
                        <i class="fas fa-chart-pie"></i> สถิติ/ข้อมูล
                        </a>
                    </div>
                </div>
                    <table class="table table-bordered table-hover" id="tbRecive">
                        <thead class="bg-info">
                            <tr>
                                <th>Sys.no</th> 
                                <th>ท/บ รับ</th>
                                <th>เลขที่เอกสาร</th>
                                <th>เรื่อง</th>
                                <th>ผู้ปฏิบัติ</th>
                                <th>สถานะ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $count=1;
                                $sql="SELECT fr.*,y.yname FROM flow_recive_group as fr INNER JOIN sys_year as y ON  y.yid=fr.yid  WHERE sec_id=$sec_id ORDER BY cid DESC";
                                $result=dbQuery($sql);
                                while($row=  dbFetchArray($result)){?>
                                    <tr>
                                    <td><?php echo $row['cid']; ?></td> 
                                        <td><?php echo $row['rec_no']; ?>/<?=$row['yname']?></td> 
                                        <td><?php echo $row['book_no']; ?></td>
                                        <?php 
                                            $cid=$row['cid'];
                                        // print $hire_id;
                                        ?>
                                        <td>
                                            <a class="text-success" href="#" 
                                                onClick="load_leave_data('<?php print $cid;?>','<?php print $u_id; ?>');" 
                                                data-toggle="modal" data-target=".bs-example-modal-table">
                                                <?php echo $row['title'];?> 
                                            </a>
                                        </td>
                                        <td><?php echo $row['practice']; ?></td>
                                        <td>
                                        <?php
                                            if($row['status']==0){?>
                                                <a class="btn btn-danger btn-block" href="?close=<?php echo $row['cid']; ?>"><i class="far fa-question-circle"></i></a>
                                            <? }else{ ?>
                                                <a class="btn btn-warning btn-block" href="?open=<?php echo $row['cid']; ?>"><i class="far fa-thumbs-up"></i></a>
                                           <? } ?>
                                        </td>
                                    </tr>
                                    <?php $count++; }?>
                                    
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="well"><center><kbd>คลิกปุ่มเพื่อเปลี่ยนสถานะ</kbd> ::<i class="far fa-question-circle"></i>=อยู่ระหว่างดำเนินการ::<i class="far fa-thumbs-up"></i>=ดำเนินการเสร็จแล้ว</center></panel>
                        </div>
                    </div>
            </div> <!-- class panel -->
                        
            <!-- Model -->
            <!-- เพิ่มหนังสือ -->
            <div id="modalAdd" class="modal fade" role="dialog">
              <div class="modal-dialog modal-lg">
                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header bg-primary">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"><i class="fa fa-plus-circle"></i> ลงทะเบียนรับ</h4>
                  </div>
                  <div class="modal-body bg-success">
                        <form name="form" method="post" enctype="multipart/form-data">
                             <div class="form-group col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon">ปีเอกสาร</span>
                                     <input class="form-control"   name="yearDoc" type="text" value="<?php print $yname; ?>" disabled="">
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon">วันที่ลงรับ</span>
                                    <input class="form-control"  type="text" name="date_in" id="date_in" value="<?php print DateThai();?>">
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon">เลขที่หนังสือ</span>
                                    <input class="form-control" type="text"  name="book_no" id="book_no" placeholder="ระบุเลขหนังสือ"  required  >
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon">เลขทะเบียนรับ</span>
                                    <input type="text" class="form-control" value="ออกโดยระบบ" disabled>
                                </div>
                            </div>
                            <div class="form-group col-md-8">
                                <div class="input-group">
                                    <span class="input-group-addon">ผู้ส่ง</span>
                                    <input class="form-control"  type="text"  name="sendfrom" id="sendto" placeholder="ระบุผู้รับหนังสือ">
                                </div>
                            </div>
                            <div class="form-group col-md-8">
                                <div class="input-group">
                                    <span class="input-group-addon">ผู้รับ</span>
                                     <input class="form-control"  type="text"  name="sendto" id="sendto" placeholder="ระบุผู้รับหนังสือ" value="ผู้ว่าราชการจังหวัดพังงา">
                                </div>
                            </div>
                            <div class="form-group col-md-8">
                                <div class="input-group">
                                    <span class="input-group-addon">เรื่อง</span>
                                     <input class="form-control" type="text"  name="title" id="title" placeholder="เรื่องหนังสือ" required>
                                </div>
                            </div>
                             <div class="form-group col-md-5">
                                <div class="input-group">
                                    <span class="input-group-addon">ลงวันที่</span>
                                    <input class="form-control"  type="date" name="datepicker"  id="datepicker" required >
                                </div>
                            </div>
                            <?php
                                $sql="SELECT u_id,sec_id,dep_id,firstname FROM user WHERE sec_id=$sec_id";
                                $result=dbQuery($sql);
                            ?>
                            <div class="form-group col-md-5">
                                <div class="input-group">
                                    <span class="input-group-addon">ผู้ปฏิบัติ</span>
                                    <select class="form-control" name="practice">
                                        <?php
                                            while ($row=dbFetchArray($result)) {?>
                                                <option value="$u_id"><?php echo $row['firstname'];?></option>
                                           <? } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <center>
                                        <button class="btn btn-success" type="submit" name="save">
                                         save
                                        <input id="yid" name="yid" type="hidden" value="<?php echo $yid; ?>"> 
                                        </button>
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">X</button>
                                </center> 
                            </div>  
                        </form>
                  </div>
                  <div class="modal-footer bg-info">
                     <!-- <button type="button" class="btn btn-danger" data-dismiss="modal">X</button> -->
                  </div>
                </div>

              </div>
            </div>
            <!-- End Model --> 
        </div>  <!-- col-md-10 -->
    <!-- Modal report -->
            <div id="myReport" class="modal fade" role="dialog">
              <div class="modal-dialog">
            
                <!-- Modal content-->
                <div class="modal-content ">
                  <div class="modal-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-print"></i> รายงานทะเบียนหนังสือรับ</h4>
                  </div>
                  <div class="modal-body">
                    	 <form class="form-inline" role="form" id="form_other" name="form_other" method="POST"  action="report/rep-resive-group.php" target="_blank"> 
                                <span>เลือกวันที่</span>
                                <input class="form-control" id="dateprint" name="dateprint" type="date" value="<?=$pDate;?> ">
                                <button type="submit" class="btn btn-lg btn-primary">
                                    <span class="glyphicon glyphicon-floppy-saved"></span>&nbspตกลง
                                </button>
                                <input type="hidden" name="yid" value="<?=$yid?>">
                                <input type="hidden" name="uid" value="<?=$uid?>"></td>
                                <input type="hidden" name="username" value="<?=$username?>"></td>
                         </form>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  </div>
                </div>
            
              </div>
            </div>
    <!-- end myReport -->
    <!--  modal แสงรายละเอียดข้อมูล -->
        <div  class="modal fade bs-example-modal-table" tabindex="-1" aria-hidden="true" role="dialog">
        <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"><i class="fa fa-info fa-2x"></i> รายละเอียด</h4>
            </div>
            <div class="modal-body no-padding">
                <div id="divDataview">
                       <!-- สวนสำหรับแสดงผลรายละเอียด   อ้างอิงกับไฟล์  show_command_detail.php -->                             
                </div>     
            </div> <!-- modal-body -->
            <div class="modal-footer bg-primary">
            <button type="button" class="btn btn-danger" data-dismiss="modal">close X</button>
            </div>
        </div>
        </div>
    </div>
    </div>
<?php //include "footer.php"; ?>

<!-- Update  -->
 <?php
    if(isset($_POST['update'])){   //กดปุ่มบันทึกจากฟอร์มบันทึก
        $cid=$_POST['cid'];
        $status=$_POST['status'];

       $sql="UPDATE flow_recive_group SET status=$status WHERE cid=$cid ";
       $result=dbQuery($sql);
        
        if($result){
            echo "<script>
            swal({
                title:'Update เรียบร้อยแล้ว',
                type:'success',
                showConfirmButton:true
                },
                function(isConfirm){
                    if(isConfirm){
                        window.location.href='flow-resive-group.php';
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
                        window.location.href='flow-resive-group.php';
                    }
                }); 
            </script>";
        } 
  } 

?>

  <!-- ส่วนเพิ่มข้อมูล  -->
 <?php
    if(isset($_POST['save'])){   //กดปุ่มบันทึกจากฟอร์มบันทึก
        $yid=$_POST['yid'];                //รหัสปีปัจจุบัน
        $book_no=$_POST['book_no'];           // หมายเลขประจำหนังสือ
        $title=$_POST['title'];               // เรื่อง   
      
        $sendfrom=$_POST['sendfrom'];         // ผู้ส่ง
        $sendto=$_POST['sendto'];             // ผู้รับ
        $practice=$_POST['practice'];         // ผู้ปฏิบัติ

        $dateout=$_POST['datepicker'];       // เอกสารลงวันที่
        $datein=date('Y-m-d');

        //(1) เลือกข้อมูลเพื่อรันเลขรับ  โดยมีเงื่อนไขให้ตรงกับหน่วยงานของผู้ใช้ ###########################
        $sql="SELECT rec_no FROM flow_recive_group WHERE dep_id=$dep_id and sec_id=$sec_id  and yid=$yid  ORDER  BY cid DESC";
        //echo $sql;
        $result=dbQuery($sql);
        $row= dbFetchArray($result);
        $rec_no=$row['rec_no'];
        $rec_no++;

        $sql="INSERT INTO flow_recive_group(rec_no,book_no,title,sendfrom,sendto,practice,dateout,datein,dep_id,sec_id,u_id,yid) 
                                    VALUES ($rec_no,'$book_no','$title','$sendfrom','$sendto','$practice','$dateout','$datein',$dep_id,$sec_id,$u_id,$yid)";
        //print $sql;                            
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
                        window.location.href='flow-resive-group.php';
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
                        window.location.href='flow-resive-group.php';
                    }
                }); 
            </script>";
        } 
  } 
?>
<?php
if(isset($_GET['close'])){
    $cid=$_GET['close'];
    $sql = "UPDATE  flow_recive_group SET status=1 WHERE cid=$cid";
    $result = dbQuery($sql);
    echo "<script>
    swal({
     title:'เรียบร้อย',
     type:'success',
     showConfirmButton:true
     },
     function(isConfirm){
         if(isConfirm){
             window.location.href='flow-resive-group.php';
         }
     }); 
   </script>";
}

if(isset($_GET['open'])){
    $cid=$_GET['open'];
    $sql = "UPDATE  flow_recive_group SET status=0 WHERE cid=$cid";
    $result = dbQuery($sql);
    echo "<script>
    swal({
     title:'เรียบร้อย',
     type:'success',
     showConfirmButton:true
     },
     function(isConfirm){
         if(isConfirm){
             window.location.href='flow-resive-group.php';
         }
     }); 
   </script>";
}
?>

<!-- ส่วนนำข้อมูลไปแสดงผลบน Modal -->
<script type="text/javascript">
function load_leave_data(cid,u_id) {
                   var sdata = {
                        cid : cid,
                        u_id : u_id 
                    };
                    $('#divDataview').load('show_flow_group_detail.php',sdata);
}
</script>


<script type='text/javascript'>
       $('#tbRecive').DataTable( {
        "order": [[ 0, "desc" ]]
    } )
</script>

