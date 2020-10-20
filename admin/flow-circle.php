
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
                    <!-- <a href="" class="btn btn-default btn-md pull-right" data-toggle="modal" data-target="#modalReserv"><i class="fas fa-hand-point-up "></i> จองทะเบียนส่ง</a> -->
                </div>
                 <table class="table table-bordered table-hover" id="dataTable">
                        <thead class="bg-info">
                            <tr>
                                <th>เลขหนังสือ</th>
                                <th>เรื่อง</th>
                                <th>ลงวันที่</th>
                                <th>แก้ไข</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $count=1;
                                if($level_id==1){   //กรณีเป็น Admin  สามารถดูได้ทั้งหมด
                                     $sql="SELECT * FROM  flowcircle   ORDER BY cid DESC";    
                                }elseif($level_id==2){   //สารบรรณกลาง  แสดงทั้งหมด
                                     $sql="SELECT * FROM  flowcircle   ORDER BY cid DESC";    
                                }elseif($level_id==3){             //สารบรรณหน่วยงาน   แสดงแค่หน่วยของตนเอง
                                    $sql="SELECT * FROM  flowcircle WHERE dep_id=$dep_id  ORDER BY cid DESC ";
                                }elseif($level_id==4){             //สารบรรณกลุ่มงาน  แสดงแค่กลุ่มของตนเอง
                                     $sql="SELECT * FROM  flowcircle WHERE dep_id=$dep_id AND sec_id=$sec_id  ORDER BY cid DESC ";
                                }elseif($level_id==5){            // ผู้ใช้ทั่วไปแสดงแค่หนังสือที่ตนออก
                                     $sql="SELECT * FROM  flowcircle WHERE dep_id=$dep_id AND sec_id=$sec_id  AND u_id=$u_id  ORDER BY cid DESC ";
                                }
                                
                                //print $sql;
                                $result = page_query( $dbConn, $sql, 10 );

                                while($row = dbFetchArray($result)){?>
                                    <tr>
                                        <td><?php echo $row['prefex'];?>/ว<?php echo $row['rec_no']; ?></td>
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
                                        <td>
                                            <?php 
                                                $curDate = date('Y-m-d');
                                                $dateLine = $row['dateline'];
                                                //$date_diff= DateDiff($curDate,$dateLine);
                                                $date_diff = getNumDay($dateLine,$curDate);

                                                if($date_diff <= 3){?>
                                                    <a class="btn btn-success btn-block" href="flow-circle-edit.php?u_id=<?=$u_id?>&cid=<?=$cid?>"><i  class="fas fa-edit"></i></a>
                                                <?php }else if($date_diff > 3){ ?>
                                                    <center><i  class="fas fa-lock fa-2x"></i></center>
                                                <?php } ?>   
                                        </td>
                                    </tr>
                                    <?php }?>
                                <tr>
                                    <td colspan="8">
                                        <center>
                                            <a href="flow-circle.php" class="btn btn-primary"><i class="fas fa-home"></i></a>
                                            <?php 
                                            page_link_border("solid","1px","gray");
                                            page_link_bg_color("lightblue","pink");
                                            page_link_font("14px");
                                            page_link_color("blue","red");
                                            page_echo_pagenums(6,true); 
                                            ?>
                                        </center>
                                    </td>
                                </tr>    
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
                               // $prefex=$rowPrefex['sec_code'];
                                $firstname=$rowPrefex['firstname'];
                            ?>
                            <tr>
                                <td>
                                    <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon">เลขประจำส่วนราชการ:</span>
                                                 <input type="text" class="form-control" name="prefex" id="prefex"  placeholder="ตัวอย่าง:พท 0017.1" required>
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

if(isset($_POST['save'])){   //กดปุ่มบันทึกจากฟอร์มบันทึก
    $uid=$_POST['u_id'];
    $obj_id=$_POST['obj_id'];
    $typeDoc=$_POST['typeDoc'];
    $prefex=$_POST['prefex'];
    $title=$_POST['title'];
    $speed_id=$_POST['speed_id'];
    $sendfrom=$_POST['sendfrom'];
    $sendto=$_POST['sendto'];
    $refer=$_POST['refer'];
    $attachment=$_POST['attachment'];
    $practice=$_POST['practice'];
    $file_location=$_POST['file_location'];
    $dateline=$_POST['datepicker'];
    $datelout=date('Y-m-d h:i:s');
    @$follow=$_POST['follow'];
    $open=$_POST['open'];
  
  
    if($ystatus==0){
        echo "<script>swal(\"ระบบจัดการปีปฏิทินมีปัญหา  ติดต่อ Admin!\") </script>";
        echo "<meta http-equiv='refresh' content='1;URL=flow-circle.php'>";
    }else{
           //ตัวเลขรันอัตโนมัติ
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

        $sendfrom = $_POST['sendfrom'];
        $sendto = $_POST['sendto'];
        $title = $_POST['title'];
        $refer = $_POST['refer'];
        $attachment = $_POST['attachment'];
        $cid = $_POST['cid'];
    
        $sql = "UPDATE flowcircle SET sendfrom = '$sendfrom', sendto = '$sendto', title = '$title', refer = '$refer', attachment = '$attachment' WHERE cid = $cid ";
     
        $result = dbQuery($sql);
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
?>

<!-- Modal จองเลขหนังสือ -->
<div id="modalReserv" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
       <h4 class="modal-title"> <i class="fas fa-plus"></i> จองเลขหนังสือส่ง</h4>
      </div>
      <div class="modal-body">
         <div class="alert alert-danger"><i class="fas fa-comments" fa-2x></i>ระบุจำนวนเอกสารที่ต้องการจอง</div>
         <form name="form" method="post" enctype="multipart/form-data">
          <div class="form-group col-sm-6">
            <div class="input-group">
                <span class="input-group-addon">จำนวน:</span>
                <input type="number" class="form-control" name="num" max=10  placeholder="ไม่เกิน 10 ฉบับ" required>
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
<?php   
if(isset($_POST['btnReserv'])){

        $sql = "SELECT section.sec_code,user.firstname,user.sec_id  FROM section,user  WHERE user.u_id = $u_id AND user.sec_id = section.sec_id " ;
        $result =  dbQuery($sql);
        $rowPrefex= dbFetchArray($result);
        $obj_id = 1;
        $typeDoc = 1;
        $prefex = ''.'/';
        $title = "จองเลขหนังสือ";
        $speed_id = 4;
        $sendfrom = "ผู้ว่าราชการจังหวัด";
        $sendto = "Mr.x";
        $refer = "-";
        $attachment = "-";
        $practice = $rowPrefex['firstname']; ;
        $file_location = "-";
        $dateline =  date("Y-m-d");
        $datelout = date('Y-m-d');
        $follow = 0;
        $open = 0;

        $num = $_POST['num'];   //จำนวนหนังสือที่ต้องจอง
        $a=0;
        while ($a < $num) {
            $sql = "SELECT max(rec_no) as rec_no FROM flowcircle where yid=$yid";
            $result = dbQuery($sql);
            $row = dbFetchArray($result);
            $rec_no =$row['rec_no'];
            $rec_no = $rec_no + 1;

            $sqlInsert="INSERT INTO flowcircle
                         (rec_no,u_id,obj_id,yid,typeDoc,prefex,title,speed_id,sec_id,sendfrom,sendto,refer,attachment,practice,file_location,dateline,dateout,dep_id)    
                    VALUE($rec_no,$u_id,$obj_id,$yid,'$typeDoc','$prefex','$title',$speed_id,$sec_id,'$sendfrom','$sendto','$refer','$attachment','$practice','$file_location','$dateline','$datelout',$dep_id)";
            $result = dbQuery($sqlInsert);
        
            $a++;
        }//while
            if($a == $num){
                 echo "<script>
                    swal({
                        title:'เรียบร้อย',
                        text:'!มีเวลา 3 วัน หลังวันจอง  เพื่อแก้ไขเอกสารให้ถูกต้อง',
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
                 echo "<script>
                    swal({
                        title:'มีบางอย่างผิดพลาด',
                        text:'ระบบไม่สามารถจองได้  กรุณาลองใหม่',
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
}//if
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
  
