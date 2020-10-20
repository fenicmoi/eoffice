
<?php
date_default_timezone_set('Asia/Bangkok');
include "header.php"; 
$u_id=$_SESSION['ses_u_id'];
?>
<?php    
   //ตรวจสอบปีเอกสารว่าเป็นปีปัจจุบันหรือไม่
    list($yid,$yname,$ystatus)=chkYear();  
    $yid=$yid;
    $yname=$yname;
    $ystatus=$ystatus;
?>
        <div class="col-md-2" >
           <?php
                $menu =  checkMenu($level_id);
                include $menu;
           ?>
        </div>
    
        <div  class="col-md-10">
            <div class="panel panel-default" >
                <div class="panel-heading">
                    <i class="fa fa-envelope fa-2x" aria-hidden="true"></i>  <strong>หนังสือส่ง [เวียน]</strong>
                    <a href="" class="btn btn-danger btn-md pull-right" data-toggle="modal" data-target="#modalAdd"><i class="fa fa-plus " aria-hidden="true"></i> ลงทะเบียนส่ง</a>
                </div>
                 <table class="table table-bordered table-hover" id="dataTable">
                        <thead class="bg-info">
                            <tr>
                                <th>Sys</th>
                                <th>เลขหนังสือ</th>
                                <th>เรื่อง</th>
                                <th>ลงวันที่</th>
                                <th>แนบไฟล์</th>
                                <th>ส่งเอกสาร</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $count=1;
                                //$sql="SELECT * FROM  flowcircle WHERE u_id=$u_id ORDER BY cid DESC";
                                if($level_id==1){   //กรณีเป็น Admin  สามารถดูได้ทั้งหมด
                                     $sql="SELECT * FROM  flowcircle   ORDER BY cid DESC";    
                                }else{
                                    $sql="SELECT * FROM  flowcircle WHERE dep_id=$dep_id AND sec_id=$sec_id  ORDER BY cid DESC LIMIT 200";
                                }
                                 
                                $result = dbQuery($sql);
                                while($row = dbFetchArray($result)){?>
                                    <tr>
                                  
                                    
                                    <td><?php echo $row['cid']; ?></td>
                                    <td><?php echo $row['prefex']; echo $row['rec_no']; ?></td>
                                    <td>
                                        <?php 
                                         $cid=$row['cid']; 
                                         $doctype='flow-circle';  //ใช้แยกประเภทตารางเพื่อส่งไปให้ file paper
                                         ?>
                                        <a href="#" 
                                            onClick="loadData('<?php print $cid;?>','<?php print $u_id; ?>');" 
                                            data-toggle="modal" data-target=".bs-example-modal-table">
                                             <?php echo $row['title'];?> 
                                    </a>
                                    </td>
                                    <td><?php echo thaiDate($row['dateline']); ?></td>
                                    <td><a class="btn btn-success btn-block" href="flow-circle-edit.php?u_id=<?=$u_id?>&cid=<?=$cid?>"><i  class="fas fa-paperclip"></i></a></td>
                                    <td>  <a class="btn btn-primary btn-block" href="paper.php?cid=<?=$cid?>&doctype=<?=$doctype?>"> <i class="fas fa-paper-plane"></i></a></td>
                                    </tr>
                                    <?php $count++; }?>
                        </tbody>
                    </table>
            </div> <!-- panel -->
           
             <!-- Model -->
            <!-- เพิ่มหนังสือ -->
            <div id="modalAdd" class="modal fade" role="dialog">
              <div class="modal-dialog modal-lg">
                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-plus-circle"></i> ลงทะเบียนหนังสือเวียน</h4>
                  </div>
                  <div class="modal-body bg-success"> 
                     <form name="form" method="post" enctype="multipart/form-data">
                        <table width="800">
                            <tr>
                                <td> 
                                    <div class="form-group form-inline">
                                        <label for="typeDoc">ประเภทหนังสือ :</label>
                                        <input class="form-control" name="typeDoc" type="radio" value="0" disabled> ปกติ
                                        <input class="form-control" name="typeDoc" type="radio" value="1" checked=""> เวียน
                                    </div>
                                </td>
                                <td>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon">ปีเอกสาร:</span>
                                                 <input class="form-control"  name="yearDoc" type="text" value="<?php print $yname; ?>" disabled="">
                                            </div>
                                        </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                     <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon">วันที่ทำรายการ:</span>
                                                 <input class="form-control" type="text" name="currentDate" value="<?php print DateThai();?>" disabled="">
                                             </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon">วัตถุประสงค์:</span>
                                                <select name="obj_id" class="form-control" required>
                                                    <?php 
                                                        //วัตถุประสงค์
                                                        $sql="SELECT * FROM object ORDER BY obj_id";
                                                        $result = dbQuery($sql);
                                                        while ($row=dbFetchArray($result)){
                                                        echo "<option  value=".$row['obj_id'].">".$row['obj_name']."</option>";
                                                    }?>
                                                </select>
                                            </div>
                                    </div>
                                </td>
                            </tr>
                            <?php 
                                 //หมายเลขส่วนราชการ
                                   /* $sql="SELECT d.dep_id,d.dep_name,d.prefex,u.firstname,
                                    FROM depart d
                                    INNER JOIN user u ON u.dep_id= d.dep_id
                                    WHERE u.u_id=".$u_id;*/
                                $sql = "SELECT section.sec_code,user.firstname,user.sec_id  FROM section,user  WHERE user.u_id = $u_id AND user.sec_id = section.sec_id " ;
                                //print $sql;
                                $result =  dbQuery($sql);
                                $rowPrefex= dbFetchArray($result);
                                $prefex=$rowPrefex['sec_code'];
                                $firstname=$rowPrefex['firstname'];
                            ?>
                            <tr>
                                <td>
                                    <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon">เลขประจำส่วนราชการ:</span>
                                                 <input type="text" class="form-control" name="prefex" id="prefex" value="<?php  print $prefex; ?>/ว" >
                                            </div>    
                                    </div>
                                </td>
                                <td>
                                 <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon">เลขทะเบียนส่ง:</span>
                                                <kbd>ออกโดยระบบ</kbd>
                                 </div>
                                </td>
                            </tr>
                            <?php
                                //ชั้นความเร็ว
                                $sql="SELECT * FROM speed ORDER BY speed_id";
                                $result= dbQuery($sql);
                            ?>
                            <tr>
                                <td>
                                    <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon">ชั้นความเร็ว:</span>
                                                <select name="speed_id" id="speed_id" class="form-control">
                                                        <?php 
                                                            while ($rowSpeed=dbFetchArray($result)){
                                                                echo "<option  value=".$rowSpeed['speed_id'].">".$rowSpeed['speed_name']."</option>";
                                                            }?>
                                                </select>
                                            </div>
                                    </div>
                                </td>
                                <?php
                                      //ชั้นความลับ
                                    $sql="SELECT * FROM secret ORDER BY sec_id";
                                    $result = dbQuery($sql);
                                ?>
                                <td>
                                    <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon">ชั้นความลับ:</span>
                                                <select name="sec_id" id="sec_id" class="form-control">
                                                        <?php
                                                            while($rowSecret=dbFetchArray($result)){
                                                                echo "<option value=".$rowSecret['sec_id'].">".$rowSecret['sec_name']."</option>";
                                                            }?>
                                                </select>
                                            </div>
                                    </div>
                                </td>
                                
                            </tr>
                            <tr>
                                <td>
                                    <div class="form-group form-inline">
                                        <input type="radio"  name="open" value="1" checked><label>เปิดเผยแก่บุคคลทั่วไป</label>
                                        <input type="radio"  name="open" value="0" ><label>ไม่เปิดเผย</label>
                                    </div>
                                </td>
                            </tr>
                        </table>
                        </div>

                        <i class="badge">รายละเอียด</i>
                        <div class="well">  
                            <table width=100%>
                                <tr>
                                    <td colspan=2>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon">เรื่อง:</span>
                                                <input class="form-control" type="text" size=100  name="title" id="title" size="50" required placeholder="เรื่องหนังสือ">
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan=2>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon">ผู้ส่ง:</span>
                                                <input class="form-control" type="text" size=100  name="sendfrom" id="sendfrom" placeholder="ระบุผู้ส่ง" required>
                                            </div>
                                        </div>
                                    </td>
                                   
                                </tr>
                                <tr>
                                    <td colspan=2>
                                         <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon">ผู้รับ:</span>
                                                <input class="form-control" type="text" size=100   name="sendto" id="sendto"   required placeholder="ระบุผู้รับหนังสือ">
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                   
                                    <td>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon">ลงวันที่:</span>
                                                 <input class="form-control" type="date" name="datepicker"  id="datepicker" onKeydown="return false" required >
                                            </div>
                                       </div>
                                      
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon">อ้างถึง:</span>
                                                 <input class="form-control" type="text"  size="50" name="refer" id="refer" value="-" ><br>
                                             </div>    
                                        </div>
                                     </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon">สิ่งที่ส่งมาด้วย:</span>
                                                 <input class="form-control" type="text" size="40" name="attachment" value="-" >
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon">ผู้เสนอ:</span>
                                                 <input class="form-control" type="text" size="30"  name="practice" value="<?=$firstname?>">
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan=2>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon">ที่เก็บเอกสาร:</span>
                                             <input class="form-control" type="text" size="30"  name="file_location" placeholder="ระบุที่เก็บเอกสาร" required>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                       <!-- <div class="form-group form-inline">
                                            <label for="datepicker">ลงวันที่ :</label><input type="text" name="datepicker"  id="datepicker" >
                                       </div> -->
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                       <!-- <div class="form-group form-inline">
                                            <label for="fileupload">แนบไฟล์</label>
                                            <input type="file" name="fileupload"  class="alert-success">
                                        </div> -->
                                </tr>
                            </table>
                         </div> <!-- class well -->    
                         
                               <center>
                                    <button class="btn btn-primary btn-lg" type="submit" name="save">
                                    <i class="fas fa-save fa-2x"></i> บันทึก
                                    <input id="u_id" name="u_id" type="hidden" value="<?php echo $u_id; ?>"> 
                                    <input id="yid" name="yid" type="hidden" value="<?php echo $yid; ?>"> 
                                    </button>
                               </center>    
                     </form>
                  </div>
                  <div class="modal-footer bg-info">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">X</button>
                  </div>
                </div>  <!-- model content -->
              </div>
            </div>
            <!-- End Model -->     
            </div>

        </div>  <!-- col-md-10 -->
    </div>  <!-- container -->
    <!--  modal แสงรายละเอียดข้อมูล -->
        <div  class="modal fade bs-example-modal-table" tabindex="-1" aria-hidden="true" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"><i class="fa fa-info"></i> รายละเอียด</h4>
                    </div>
                    <div class="modal-body no-padding">
                        <div id="divDataview">
                            <!-- สวนสำหรับแสดงผลรายละเอียด   อ้างอิงกับไฟล์  show_command_detail.php -->                             
                        </div>     
                    </div> <!-- modal-body -->
                    <div class="modal-footer bg-info">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">X</button>
                    </div>
                </div>
            </div>
        </div>
    </div>                                                 
<?php

include_once 'function.php';
error_reporting( error_reporting() & ~E_NOTICE );//ปิดการแจ้งเตือน
date_default_timezone_set('Asia/Bangkok'); //วันที่


if(isset($_POST['save'])){   //กดปุ่มบันทึกจากฟอร์มบันทึก
    //$yid=$_POST['yid'];
    $uid=$_POST['u_id'];
    $obj_id=$_POST['obj_id'];
    $typeDoc=$_POST['typeDoc'];
    $prefex=$_POST['prefex'];
    $title=$_POST['title'];
    $speed_id=$_POST['speed_id'];
   // $sec_id=$_POST['sec_id'];
    $sendfrom=$_POST['sendfrom'];
    $sendto=$_POST['sendto'];
    $refer=$_POST['refer'];
    $attachment=$_POST['attachment'];
    $practice=$_POST['practice'];
    $file_location=$_POST['file_location'];
    $dateline=$_POST['datepicker'];
    $datelout=date('Y-m-d h:i:s');
    $follow=$_POST['follow'];
    $open=$_POST['open'];
  
  
    if($ystatus==0){
        echo "<script>swal(\"ระบบจัดการปีปฏิทินมีปัญหา  ติดต่อ Admin!\") </script>";
        echo "<meta http-equiv='refresh' content='1;URL=flow-circle.php'>";
    }else{
           //ตัวเลขรันอัตโนมัติ
            // $sqlRun="SELECT cid,rec_no FROM flowcircle WHERE  AND yid=$yid  ORDER  BY cid DESC";
             $sqlRun="SELECT cid,rec_no FROM flowcircle WHERE  yid=$yid  ORDER  BY cid DESC";
            $resRun=  dbQuery($sqlRun);
            $rowRun= dbFetchArray($resRun);
            $rec_no=$rowRun['rec_no'];
            $rec_no++;

        dbQuery('BEGIN');    
        $sqlInsert="INSERT INTO flowcircle
                         (rec_no,u_id,obj_id,yid,typeDoc,prefex,title,speed_id,sec_id,sendfrom,sendto,refer,attachment,practice,file_location,dateline,dateout,open,dep_id)    
                    VALUE($rec_no,$u_id,$obj_id,$yid,'$typeDoc','$prefex','$title',$speed_id,$sec_id,'$sendfrom','$sendto','$refer','$attachment','$practice','$file_location','$dateline','$datelout',$open,$dep_id)";
       // echo $sqlInsert;
        $result=dbQuery($sqlInsert);
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
                        window.location.href='flow-circle.php';
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
                        window.location.href='flow-circle.php';
                    }
                }); 
            </script>";
        } 
  } 
}


if(isset($_POST['update'])){
            $fileupload=$_REQUEST['fileupload'];  //การจัดการ fileupload
            $date=date('Y-m-d');
            $numrand=(mt_rand()); //สุ่มตัวเลข
            $upload=$_FILES['fileupload']; //เพิ่มไฟล์
        if($upload<>''){
            $part="doc/";   //โฟลเดอร์เก็บเอกสาร
            $type=  strrchr($_FILES['fileupload']['name'],".");   //เอาชื่อเก่าออกให้เหลือแต่นามสกุล
            $newname=$date.$numrand.$type;   //ตั้งชื่อไฟล์ใหม่โดยใช้เวลา
            $part_copy=$part.$newname;
            $part_link="doc/".$newname;
            move_uploaded_file($_FILES['fileupload']['tmp_name'],$part_copy);  //คัดลอกไฟล์ไป Server
            
            $sqlUpdate="UPDATE flowcircle SET file_upload='$part_copy' WHERE cid=$cid";
            print $sqlUpdate;
            $resUpdate=  mysqli_query($conn, $sqlUpdate);
            if(!$resUpdate){
                echo "ระบบมีปัญหา";
                exit;
            }else{
              echo "<script>swal(\"Good job!\", \"แก้ไขข้อมูลแล้ว!\", \"success\")</script>";                 
              echo "<meta http-equiv='refresh' content='1;URL=flow-circle.php'>";  
            }
        }else{
            echo "<meta http-equiv='refresh' content='1;URL=flow-circle.php'>";
        }
}    
?>

<script type='text/javascript'>
    $('#dataTable').DataTable( {
        "order": [[ 0, "desc" ]],
        "oLanguage": {
                    "sLengthMenu": "แสดง _MENU_ เร็คคอร์ด ต่อหน้า",  
                    "sZeroRecords": "ไม่เจอข้อมูลที่ค้นหา",
                    "sInfo": "แสดง _START_ ถึง _END_ ของ _TOTAL_ เร็คคอร์ด",
                    "sInfoEmpty": "แสดง 0 ถึง 0 ของ 0 เร็คคอร์ด",
                    "sInfoFiltered": "(จากเร็คคอร์ดทั้งหมด _MAX_ เร็คคอร์ด)",
                    "sSearch": "ค้นหา :"
                  }
    })

</script>

<script type="text/javascript">
function loadData(cid,u_id) {
    var sdata = {
        cid : cid,
        u_id : u_id 
    };
$('#divDataview').load('show-flow-circle.php',sdata);
}
</script>
  
