
<!-- หนังสือรับถึงจังหวัด -->
<?php   
include "header.php"; 
$u_id=$_SESSION['ses_u_id'];
?>

<script type="text/javascript" src="datePicket.js"></script>

<?php    
//ตรวจสอบปีเอกสาร
    list($yid,$yname,$ystatus)=chkYear();  
    $yid=$yid;
    $yname=$yname;
    $ystatus=$ystatus;
?>
<!-- ส่วนการทำ auto complate -->

        <div class="col-md-2" >
           <?php
                $menu=  checkMenu($level_id);
                include $menu;
           ?>
        </div>
        <div  class="col-md-10">
            <div class="panel panel-default" >
                <div class="panel-heading">
                    <i class="fa fa-university fa-2x" aria-hidden="true"></i>  <strong>หนังสือรับ [ถึงจังหวัด]</strong>
                    <a href="" class="btn btn-primary pull-right" data-toggle="modal" data-target="#modalAdd"><i class="fa fa-plus "></i> ลงทะเบียนรับ</a>
                     <a href="" class="btn btn-success pull-right" data-toggle="modal" data-target="#myReport"><i class="fa fa-print "></i> รายงานประจำวัน</a>
                </div>
                
                    <table class="table table-bordered table-hover" id="tbRecive">
                        <thead class="bg-info">
                            <tr>
                                <th>ท/บ กลาง</th>
                                <th>ท/บ รับ</th>
                                <th>เลขที่เอกสาร</th>
                                <th>เรื่อง</th>
                                <th>จาก</th>
                                <th>ลงวันที่</th>
                                <th>สถานะ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $count=1;
                                if($level_id > 2){    //ผู้ใช้ทั่วไป  เลือกข้อมูลที่ลงรับแล้วเท่านั้นมาแสดงผล  remark เพราะว่าจะเปิดอนุญาติให้คนอื่นมาลงได้
                                    //   $sql="SELECT m.book_id,m.rec_id,m.dep_id,d.book_no,d.title,d.sendfrom,d.sendto,d.date_book,d.date_in,d.date_line,d.practice,d.status,s.sec_code
                                    //   FROM book_master m
                                    //   INNER JOIN book_detail d ON d.book_id = m.book_id
                                    //   INNER JOIN section s ON s.sec_id = m.sec_id
                                    //   WHERE m.type_id=1  AND d.status = 1 AND d.practice = $dep_id
                                    //   ORDER BY m.rec_id DESC";
                                     $sql="SELECT m.book_id,m.rec_id,d.book_no,d.title,d.sendfrom,d.sendto,d.date_book,d.date_in,d.date_line,d.practice,d.status,s.sec_code,y.yname
                                      FROM book_master m
                                      INNER JOIN book_detail d ON d.book_id = m.book_id
                                      INNER JOIN section s ON s.sec_id = m.sec_id  AND m.dep_id=$dep_id
                                      INNER JOIN sys_year y ON y.yid = m.yid
                                      WHERE m.type_id=1 
                                      ORDER BY m.book_id DESC";
  
                                }else{  // ผู้ใช้ระดับ admin  เลือกข้อมูลทั้งหมดขึ้นมาแสดง เพื่อให้สามารถเช็ได้ว่า หนังสือลงรับแล้วหรือไม่
                                    $sql="SELECT m.book_id,m.rec_id,d.book_no,d.title,d.sendfrom,d.sendto,d.date_book,d.date_in,d.date_line,d.practice,d.status,s.sec_code,y.yname
                                      FROM book_master m
                                      INNER JOIN book_detail d ON d.book_id = m.book_id
                                      INNER JOIN section s ON s.sec_id = m.sec_id 
                                      INNER JOIN sys_year y ON y.yid = m.yid
                                      WHERE m.type_id=1 
                                      ORDER BY m.book_id DESC";
                                   //print $sql;
                                }
                                  $result=dbQuery($sql);
                                while($row=  dbFetchArray($result)){?>
                                    <?php $rec_id=$row['rec_id']; ?>    <!-- กำหนดตัวแปรเพื่อส่งไปกับลิงค์ -->
                                    <?php $book_id=$row['book_id']; ?>  <!-- กำหนดตัวแปรเพื่อส่งไปกับลิงค์ -->
                                    <tr>
                                    <td> <?php echo $row['book_id']; ?></td>
                                    <td><?php echo $row['rec_id']; ?>/<?=$row['yname']?></td>
                                    <td><?php echo $row['book_no']; ?></td>
                                    <td>
                                        <a href="#" 
                                                onclick="load_leave_data('<? print $u_id;?>','<? print $rec_id; ?>','<? print $book_id; ?>');" data-toggle="modal" data-target=".bs-example-modal-table">
                                                <?php echo $row['title'];?> 
                                        </a>
                                    </td>
                                    <td><?php echo $row['sendfrom']; ?></td>
                                    <?php 
                                    // if($row['date_line']==null){
                                    //     $date_line= "รอยืนยัน";
                                    // }else{
                                    //     $date_line= thaiDate($row['date_line']);
                                    // }
                                    ?>
                                    <td><?php echo $row['date_book']; ?></td>
                                    <!-- <td><a class="btn btn-info" href="paper.php?book_id=<?php //echo $book_id ?>"><i  class="fa fa-paper-plane"></i> ส่งเอกสาร</a></td> -->
                                    <td>
                                        <?php 
                                             if($row['status']==0){
                                                 echo "<i class='alert-success fa fa-envelope'></i>";
                                            }else if($row['status']==1){
                                                echo "<i class='alert-info fa fa-envelope-open'></i>";
                                            }else{
                                                echo "<i class='alert-danger fa fa-reply'></i>";
                                            }
                                        ?>
                                    </td>
                                    </tr>
                                    <?php $count++; }?>
                                    
                        </tbody>
                    </table>
                   
                        <div class="col">
                       <kbd>หมายเหตุ >>></kbd>  <i class='alert-success fa fa-envelope'></i >รอรับ  
                       <i class='alert-info fa fa-envelope-open'></i>รับแล้ว  
                       <i class='alert-danger fa fa-reply'></i>ส่งคืน
                    
                    <hr/>
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
                            <table width="100%" >
                                <tr>
                                    <td> <label for="yearDoc">ปีเอกสาร : </label> <input   name="yearDoc" type="text" value="<?php print $yname; ?>" disabled=""></td>
                                    <td></td>
                                    <td><label for="date_in">วันที่ลงรับ:</label><input  type="text" name="date_in" id="date_in" value="<?php print DateThai();?>"></td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <label for="typeDoc">ประเภทหนังสือ :</label>
                                        <input  name="typeDoc" type="radio" value="1" checked=""> ปกติ
                                        <input  name="typeDoc" type="radio" value="2" > เวียน
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="book_no">เลขที่เอกสาร : </label><input type="text"  name="book_no" id="book_no"  required  ></td>
                                    <td></td>
                                    <td><label>เลขทะเบียนรับ : <kbd>ออกโดยระบบ</kbd></label></td>
                                </tr>
                                <?php
                                //ชั้นความเร็ว
                                $sql="SELECT * FROM speed ORDER BY speed_id";
                                $result=  dbQuery($sql);
                                 ?>
                                    <td>
                                        <label for="speed_id">ชั้นความเร็ว : </label>
                                            <select name="speed_id" id="speed_id">
                                                <?php 
                                                    while ($rowSpeed= dbFetchArray($result)){
                                                        echo "<option  value=".$rowSpeed['speed_id'].">".$rowSpeed['speed_name']."</option>";
                                                }?>
                                            </select>
                                    </td>
                                    <?php
                                //ชั้นความลับ
                                $sql="SELECT * FROM priority ORDER BY pri_id";
                                $result=  dbQuery($sql);
                                ?>
                                    <td>
                                        <label for="sec_id">ชั้นความลับ :</label>
                                            <select name="pri_id" id="pri_id">
                                                    <?php
                                                        while($rowSecret= dbFetchArray($result)){
                                                            echo "<option value=".$rowSecret['pri_id'].">".$rowSecret['pri_name']."</option>";
                                                        }?>
                                            </select>
                                    </td>
                                    <td>
                                    <?php
                                //วัตถุประสงค์
                                $sql="SELECT * FROM object ORDER BY obj_id";
                                $result = dbQuery($sql)
                                ?>
                                        <label for="obj_id">วัตถุประสงค์ : </label>
                                            <select name="obj_id" required>
                                            <?php 
                                                while ($row= dbFetchArray($result)){
                                                    echo "<option  value=".$row['obj_id'].">".$row['obj_name']."</option>";
                                            }?>
                                            </select>
                                    </td>
                                <tr>
                                    <td colspan="3">
                                        <label for="sendfrom">ผู้ส่ง : </label>
                                        <input  type="text"  name="sendfrom" id="sendfrom" size="50" require placeholder="ระบุผู้ส่ง" required >
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        <label for="sendto">ผู้รับ : </label>
                                        <input  type="text"  name="sendto" id="sendto"  size="50"  placeholder="ระบุผู้รับหนังสือ" value="ผู้ว่าราชการจังหวัดพังงา">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        <label for="title">เรื่อง : </label>
                                        <input type="text"  name="title" id="title" size="80" placeholder="เรื่องหนังสือ" required>
                                    </td>
                                    
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        <label for="datepicker">ลงวันที่ :</label><input  type="text" name="datepicker"  id="datepicker" required >
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        <label for="refer">อ้างถึง</label>
                                        <input type="text"  size="50" name="refer" id="refer" value="-" ><br>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                         <label for="attachment">สิ่งที่ส่งมาด้วย</label>
                                         <input  type="text" size="50" name="attachment" value="-" >
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        <label for="practice">หน่วยดำเนินการ</label>
                                         <input type="radio" name="toSomeOne" id="toSomeOne" value="3" 
                                                onclick="setEnabledTo2(this);
                                                        document.getElementById('ckToSome').style.display = 'block';
                                               "> เลือกเอง
                                        <input type="text" name="toSomeOneUser" class="mytextboxLonger" style="width:373px;" readonly disabled>
                                        <div id="ckToSome" style="display:none">
                                             <table  border="1" width="600px" cellspacing="0" cellpadding="0">
                                                        <tr>
                                                            <td  class="bg-primary"><center>เลือกผู้รับ</center></td>
                                                        </tr>
                                                    </table>
                                                <div id="div1" style="width:600px; height:200px; overflow:auto">
                                                    <table id="tbNew" border="1" width="600px" >
                                                        <thead>
                                                            <th></th>
                                                            <th>ชื่อส่วนราชการ</th>
                                                        </thead>
                                                        <tbody>
                                                        <?php  
                                                        $sql="SELECT dep_id,dep_name FROM depart ORDER BY dep_name";
                                                        $result=dbQuery($sql);
                                                        $numrowOut=dbNumRows($result);
                                                        if(empty($numrowOut)){?>
                                                        <tr>
                                                            <td></td>
                                                            <td>ไม่มีข้อมูลประเภทส่วนราชการ</td>
                                                        </tr>
                                                        <?php } else { 
                                                            $i=0;
                                                            while($rowOut=dbFetchAssoc($result)){ 
                                                            $i++;
                                                            $a=$i%2;
                                                            if($a==0){?>
                                                        <tr bgcolor="#A9F5D0">
                                                            <?php }else{ ?>
                                                        <tr bgcolor="#F5F6CE">
                                                            <?php } ?>
                                                            <td   class="select_multiple_checkbox"><input type="checkbox" onclick="listSome(this,'<?php echo $rowOut['dep_id'];?>')"></td>
                                                            <td   class="select_multiple_name"><?php print $rowOut['dep_name']; ?></td>
                                                        </tr>
                                                        
                                                        <?php }}?>
                                                        </tbody>
                                                    </table>
                                                    
                                                </div>  <!-- div1 -->
                                                <table>
                                                        <tr>
                                                            <td><input class="btn-success"  style="width:77px;" type="button" value="ตกลง" onclick="document.getElementById('ckToSome').style.display = 'none';"></td>
                                                            <td><input class="btn-danger" style="width:77px;" type="button" value="ยกเลิก" onclick="document.getElementById('ckToSome').style.display = 'none';"></td>
                                                        </tr>
                                                    </table>
                                        </div> <!-- ckToSome -->
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                       <label for="fileupload">เอกสารแนบ</label>
                                       <div class="well">
                                       <input type="file" name="fileupload" disabled>
                                       </div>
                                    </td>
                                    <td>
                                    <h5><i class="fa fa-exclamation-circle fa-2x"></i>ดำเนินการลงทะเบียนรับให้เสร็จสิ้นก่อนแนบเอกสาร</h5>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        <label>อื่นๆ :</label>
                                        <input type="checkbox" name="follow" id="follow" value="1" checked> ติดตามผลการดำเนินงาน
                                        <input type="checkbox" name="open" id="open" value="1" checked> เปิดเผยแก่บุคคลทั่วไป
                                    </td>
                                </tr>
                            </table><br>
                            <center>
                                    <button class="btn btn-success" type="submit" name="save">
                                    <i class="fa fa-database"></i> ตกลง
                                    <input id="u_id" name="u_id" type="hidden" value="<?php echo $u_id; ?>"> 
                                    <input id="sec_id" name="u_id" type="hidden" value="<?php echo $sec_id; ?>"> 
                                    <input id="dep_id" name="u_id" type="hidden" value="<?php echo $dep_id; ?>"> 
                                    <input id="yid" name="yid" type="hidden" value="<?php echo $yid; ?>"> 
                                    </button>
                            </center>   
                        </form>
                  </div>
                  <div class="modal-footer bg-primary">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">X</button>
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
                    	 <form class="form-inline" role="form" id="form_other" name="form_other" method="POST"  action="report/rep-resive-province.php"> 
                                <span>เลือกวันที่</span>
                                <input class="form-control" id="dateprint" name="dateprint" type="date">
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
                        <h4 class="modal-title"><i class="fa fa-info"></i> รายละเอียด</h4>
                    </div>
                    <div class="modal-body no-padding">
                        <div id="divDataview">
                            <!-- สวนสำหรับแสดงผลรายละเอียด   อ้างอิงกับไฟล์  show_command_detail.php -->                             
                        </div>     
                    </div> <!-- modal-body -->
                    <div class="modal-footer bg-primary">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">X</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php //include "footer.php"; ?>


  <!-- ส่วนเพิ่มข้อมูล  -->
 <?php
    if(isset($_POST['save'])){   //กดปุ่มบันทึกจากฟอร์มบันทึก

        //#######  ข้อมูลสำหรับตาราง book_master ########################################
        $type_id=1;                    //ชนิดของหนังสือ  1  หนังสือรับ-ถึงจังหวัด
        /*$dep_id=$_SESSION['dep_id'];     //รหัสหน่วยงาน   รับค่ามาจาก session จาก header แล้ว
        $sec_id=$_SESSION['sec_id'];       //รหัสกลุ่มงาน  */
        $uid=$_POST['u_id'];               //รหัสผู้ใช้
        $obj_id=$_POST['obj_id'];          //รหัสวัตถุประสงค์
        $pri_id=$_POST['pri_id'];          //รหัสชั้นความลับ
        $yid=$_POST['yid'];                //รหัสปีปัจจุบัน
        $typeDoc=$_POST['typeDoc'];        //รหัสประเภทหนังสือ   1ปกติ 2 เวียน
        $speed_id=$_POST['speed_id'];

        //(1) เลือกข้อมูลเพื่อรันเลขรับ  โดยมีเงื่อนไขให้ตรงกับหน่วยงานของผู้ใช้ ###########################
        $sql="SELECT rec_id FROM book_master WHERE   yid=$yid  ORDER BY book_id DESC LIMIT 1";
        //print $sql;
        $result=dbQuery($sql);
        $rowRun= dbFetchArray($result);
        $rec_id=$rowRun['rec_id'];
         if($rec_id==0){
            $rec_id=1;
            }else{
            $rec_id++; 
            } 
      
   
       
        // ##### ตาราง book_master
  
        $sql="SHOW TABLE STATUS LIKE 'book_master'";     //ส่วนหา ID ล่าสุด
        $result=dbQuery($sql);
        $row=dbFetchAssoc($result);
        $book_id=(int)$row['Auto_increment'];

        //#######  ข้อมูลสำหรับตาราง book_detail  #########################################
       // $book_id=dbInsertId($dbConn);  //เลือก ID ล่าสุดจากตาราง book_master
        $book_no=$_POST['book_no'];           // หมายเลขประจำหนังสือ
        $title=$_POST['title'];               // เรื่อง   
        $date_in=$_POST['date_in'];             // วันที่ลงรับ
        $date_book=$_POST['datepicker'];       // เอกสารลงวันที่
        $sendfrom=$_POST['sendfrom'];         // ผู้ส่ง
        $sendto=$_POST['sendto'];             // ผู้รับ
        $refer=$_POST['refer'];               // อ้างถึง
        
        $follow=$_POST['follow'];             // ติดตามหนังสือ
        $publice_book=$_POST['open'];         // เปิดเผยหนังสือ
        $attachment=$_POST['attachment'];     //เอกสารแนบ

        $practice=$_POST['toSomeOneUser'];         // ผู้ปฏิบัติ
        $practice=substr($practice, 1);
        $practice=explode("|", $practice);

        // $fileupload=$_REQUEST['fileupload'];  //การจัดการ fileupload
        @$fileupload=$_POST['fileupload'];
        @$upload=$_FILES['fileupload']; //เพิ่มไฟล์


        if($upload!=''){
            
            $date=date('Y-m-d');  //กำหนดรูปแบบวันที่
            $numrand=(mt_rand()); //สุ่มตัวเลข
            $part="recive-to-province/";   //โฟลเดอร์เก็บเอกสาร
            $type=  strrchr($_FILES['fileupload']['name'],".");   //เอาชื่อเก่าออกให้เหลือแต่นามสกุล
            $newname=$date.$numrand.$type;   //ตั้งชื่อไฟล์ใหม่โดยใช้เวลา
            $part_copy=$part.$newname;
            $part_link="recive-to-province/".$newname;
            move_uploaded_file($_FILES['fileupload']['tmp_name'],$part_copy);  //คัดลอกไฟล์ไป Server
        }else{
            $part_copy='';
        }
        
        $datelout=date('Y-m-d h:i:s');
        

        //transection
        dbQuery('BEGIN');

        $sql="INSERT INTO book_master (rec_id,type_id,dep_id,sec_id,u_id,obj_id,pri_id,yid,typeDoc,speed_id) 
                      VALUES ($rec_id,$type_id,$dep_id,$sec_id,$u_id,$obj_id,$pri_id,$yid,$typeDoc,$speed_id)";
        $result1=dbQuery($sql);

        $date_line=date('Y-m-d');
        $sql="INSERT INTO book_detail (book_id,book_no,title,sendfrom,sendto,reference,attachment,date_book,date_in,practice,follow,publice_book,status,date_line,file_upload)
        VALUES($book_id,'$book_no','$title','$sendfrom','$sendto','$refer','$attachment','$date_book','$date_in','$practice[0]','$follow','$publice_book',0,'$date_line','$part_copy')";
        // echo $sql;
        $result2=dbQuery($sql);

        if($result1 && $result2){
            dbQuery("COMMIT");
            echo "<script>
            swal({
                title:'เรียบร้อย',
                type:'success',
                showConfirmButton:true
                },
                function(isConfirm){
                    if(isConfirm){
                        window.location.href='flow-resive-province.php';
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
                        window.location.href='flow-resive-province.php';
                    }
                }); 
            </script>";
        } 
  } 

//กรณีเพิ่มเอกสารแนบ
 if(isset($_POST['update'])){
     @$fileupload = $_POST['fileupload'];
     $book_detail_id = $_POST['book_detail_id'];
     @$resive = $_POST['resive'];
     $upload=$_FILES['fileupload']; //เพิ่มไฟล์

        if($upload!=''){
            $date=date('Y-m-d');  //กำหนดรูปแบบวันที่
            $numrand=(mt_rand()); //สุ่มตัวเลข
            $part="recive-to-province/";   //โฟลเดอร์เก็บเอกสาร
            $type=  strrchr($_FILES['fileupload']['name'],".");   //เอาชื่อเก่าออกให้เหลือแต่นามสกุล
            $newname=$date.$numrand.$type;   //ตั้งชื่อไฟล์ใหม่โดยใช้เวลา
            $part_copy=$part.$newname;
            $part_link="recive-to-province/".$newname;
            move_uploaded_file($_FILES['fileupload']['tmp_name'],$part_copy);  //คัดลอกไฟล์ไป Server
        }else{
            $part_copy='';
        }

        $sql="UPDATE book_detail SET file_upload='$part_copy' WHERE book_detail_id=$book_detail_id";
        //echo $sql;
        $result=dbQuery($sql);
         if($result){
            echo "<script>
            swal({
                title:'แนบเอกสารเรียบร้อยแล้ว',
                type:'success',
                showConfirmButton:true
                },
                function(isConfirm){
                    if(isConfirm){
                        window.location.href='flow-resive-province.php';
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
                        window.location.href='flow-resive-province.php';
                    }
                }); 
            </script>";
        } 
 }

 //กรณีลงรับหนังสือ
 /*if(isset($_POST['resive'])){
    $book_detail_id = $_POST['book_detail_id'];
     $date=date('Y-m-d');
    $sql="UPDATE book_detail SET date_line='$date',status=1 WHERE book_detail_id=$book_detail_id";  //1 ยอมรับหนังสือ
    //echo $sql;
        $result=dbQuery($sql);
         if($result){
            echo "<script>
            swal({
                title:'ลงทะเบียนรับเรียบร้อยแล้ว',
                type:'success',
                showConfirmButton:true
                },
                function(isConfirm){
                    if(isConfirm){
                        window.location.href='flow-resive-province.php';
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
                        window.location.href='flow-resive-province.php';
                    }
                }); 
            </script>";
        } 
 }*/


//กรณีส่งคืนหนังสือ
 /*if(isset($_POST['reply'])){
    $book_detail_id = $_POST['book_detail_id'];
    $date=date('Y-m-d');
    $sql="UPDATE book_detail SET date_line='$date', status=2 WHERE book_detail_id=$book_detail_id";  //1 ยอมรับหนังสือ
    //echo $sql;
        $result=dbQuery($sql);
         if($result){
            echo "<script>
            swal({
                title:'ส่งคืนหนังสือแล้ว',
                type:'success',
                showConfirmButton:true
                },
                function(isConfirm){
                    if(isConfirm){
                        window.location.href='flow-resive-province.php';
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
                        window.location.href='flow-resive-province.php';
                    }
                }); 
            </script>";
        }    
 }
*/

?>


<!-- ส่วนนำข้อมูลไปแสดงผลบน Modal -->
<script type="text/javascript">
function load_leave_data(u_id,rec_id,book_id) {
                    var sdata = 
                    {u_id : u_id , 
                    rec_id : rec_id,
                    book_id : book_id
                    };
                    $('#divDataview').load('show_resive_province_detail.php',sdata);
}
</script>

<!-- ตารางแสดงข้อมูลหลัก -->
<script type='text/javascript'>
       $('#tbRecive').DataTable( {
        "order": [[ 0, "desc" ]]
    } )
</script>
<!-- ตารางแสดงหน่วยงาน -->
<script type='text/javascript'>
       $('#tbNew').DataTable( {
        "order": [[ 0, "desc" ]]
    } )
</script>


<script>
$.datepicker.regional['th'] = {
    changeMonth: true,
    changeYear: true,
    //defaultDate: GetFxupdateDate(FxRateDateAndUpdate.d[0].Day),
    yearOffSet: 543,
    showOn: "button",
    buttonImage: '../images/calendar.gif',
    buttonImageOnly: true,
    dateFormat: 'dd M yy',
    dayNames: ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'],
    dayNamesMin: ['อา', 'จ', 'อ', 'พ', 'พฤ', 'ศ', 'ส'],
    monthNames: ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'],
    monthNamesShort: ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'],
    constrainInput: true,

    prevText: 'ก่อนหน้า',
    nextText: 'ถัดไป',
    yearRange: '-20:+0',
    buttonText: 'เลือก',

};
$.datepicker.setDefaults($.datepicker.regional['th']);

$(function() {
    $("#datepicker").datepicker($.datepicker.regional["th"]); // Set ภาษาที่เรานิยามไว้ด้านบน
    $("#datepicker").datepicker("setDate", new Date()); //Set ค่าวันปัจจุบัน
});


var Holidays;

//On Selected Date
//Have Check Date
function CheckDate(date) {
    var day = date.getDate();
    var selectable = true; //ระบุว่าสามารถเลือกวันที่ได้หรือไม่ True = ได้ False = ไม่ได้
    var CssClass = '';

    if (Holidays != null) {

        for (var i = 0; i < Holidays.length; i++) {
            var value = Holidays[i];
            if (value == day) {

                selectable = false;
                CssClass = 'specialDate';
                break;
            }
        }
    }
    return [selectable, CssClass, ''];
}


//=====================================================================================================
//On Selected Date
function SelectedDate(dateText, inst) {
    //inst.selectedMonth = Index of mounth
    //(inst.selectedMonth+1)  = Current Mounth
    var DateText = inst.selectedDay + '/' + (inst.selectedMonth + 1) + '/' + inst.selectedYear;
    //CallGetUpdateInMonth(ReFxupdateDate(dateText));
    //CallGetUpdateInMonth(DateText);
    return [dateText, inst]
}
//=====================================================================================================
//Call Date in month on click image
function OnBeforShow(input, inst) {
    var month = inst.currentMonth + 1;
    var year = inst.currentYear;
    //currentDay: 10
    //currentMonth: 6
    //currentYear: 2012
    GetDaysShows(month, year);

}
//=====================================================================================================
//On Selected Date
//On Change Drop Down
function ChangMonthAndYear(year, month, inst) {

    GetDaysShows(month, year);
}

//=====================================
function GetDaysShows(month, year) {
    //CallGetDayInMonth(month, year); <<เป็น Function ที่ผมใช้เรียก ajax เพื่อหาวันใน DataBase  แต่นี้เป็นเพียงตัวอย่างจึงใช้ Array ด้านล่างแทนการ Return Json
    //อาจใช้ Ajax Call Data โดยเลือกจากเดือนและปี แล้วจะได้วันที่ต้องการ Set ค่าวันไว้คล้ายด้านล่าง
    Holidays = [1, 4, 6, 11]; // Sample Data
}
//=====================================
</script>
<script>
function setEnabledTo2(obj) {
	 if(obj.value=="3") {             //กรณีเลือกเอง
        obj.form.toSomeOneUser.disabled=false;
	} 
}
</script>
 <script type="text/javascript">     
    function listSome(a,b,c) {     //ฟังค์ชั่นกรณีเลือกส่วนราชการเอง
        m=document.form.toSomeOneUser.value;
        
        if (a.checked) {
            if (m.indexOf(b)<0) m+='|'+b;
        
        } else {
        m=document.form.toSomeOneUser.value.replace('|'+b,'');
        }
        z="|";
        if (m.substring(2) == c) m=m.substring(2);
        document.form.toSomeOneUser.value=m;
    }
</script>
