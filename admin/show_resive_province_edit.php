

<!-- แก้ไขหนังสือรับถึงจังหวัด -->
<?php   
include "header.php"; 
$u_id=$_SESSION['ses_u_id'];
$level_id = $_SESSION['ses_level_id'];

// รับค่ามาจาก javascript from flow-resive-province
 $book_id = $_GET['book_id'];

 $sql="SELECT  bookm.book_id,bookm.rec_id,bookm.typeDoc,bookd.*,o.obj_id,o.obj_name,spe.speed_id,spe.speed_name,p.pri_id,p.pri_name,u.firstname,s.sec_id,s.sec_name,dep.dep_name,year.yname,dep.prefex
       FROM  book_master  bookm
       INNER JOIN book_detail bookd ON bookd.book_id = bookm.book_id
       INNER JOIN user u ON  u.u_id = bookm.u_id
       INNER JOIN section s ON s.sec_id = bookm.sec_id
       INNER JOIN object o ON o.obj_id = bookm.obj_id
       INNER JOIN speed spe ON spe.speed_id=bookm.speed_id
       INNER JOIN depart dep ON dep.dep_id = bookm.dep_id
       INNER JOIN sys_year year ON year.yid = bookm.yid
       INNER JOIN priority p ON p.pri_id = bookm.pri_id
       WHERE bookm.book_id =$book_id ";

$result = dbQuery($sql);
$row=dbFetchArray($result);
$strDate = $row['date_in'];
$dateThai =  DateThai($strDate);
$rec_id = $row['rec_id'];
$yname = $row['yname'];
$book_detail_id = $row['book_detail_id'];
$file_upload = $row['file_upload'];
?>

<div class="col-md-2" >
<?php
    $menu = checkMenu($level_id);
    include $menu;
?>
</div>
<div  class="col-md-10">
    <div class="panel panel-primary" >
        <div class="panel-heading">
            <i class="fa fa-edit fa-2x"></i>  <strong>แก้ไขหนังสือรับ [ถึงจังหวัด]</strong>
            <a href="flow-resive-province.php" class="btn btn-success pull-right"><i class="fas fa-home "></i> กลับหน้าหลัก</a>
        </div>
        <div class="panel-body bg-success">
             <form name="edit" action="#" method="post" enctype="multipart/form-data">
                <div class="form-group form-inline">
                    <div class="input-group col-xs-3">
                        <span class="input-group-addon">เลขทะเบียนรับ</span>
                        <input type="text" class="form-control" value="<?php print $rec_id;?>/<?php print $yname;?>"  disabled>
                    </div>
                     <div class="input-group col-xs-3">
                        <span class="input-group-addon"><i class="fas fa-calendar-alt"></i> วันที่ลงรับ</span>
                        <input  name="date_in" type="text" class="form-control" value="<?php print $row['date_in'];?>">
                    </div>
                </div>

                <div class="form-group form-inline">
                    <div class="input-group col-xs-4">
                        <span class="input-group-addon">เลขที่เอกสาร</span>
                        <input  name="book_no" type="text" class="form-control" value="<?php print $row['book_no']; ?>">
                    </div>
                    <div class="input-group col-xs-3">
                        <span class="input-group-addon"><i class="fas fa-folder"></i> ประเภทหนังสือ</span>
                        <input  name="typeDoc" type="radio" value="1" <?php if($row['typeDoc']==1){ echo "checked";}?>> ปกติ
                        <input  name="typeDoc" type="radio" value="2" <?php if($row['typeDoc']==2){ echo "checked";}?>> เวียน
                    </div>
                </div>

                 <div class="form-group form-inline">
                     <div class="input-group col-xs-2">
                        <span class="input-group-addon"><i class="fas fa-low-vision"></i> ชั้นความลับ</span>
                        <select class="form-control" name="pri_id" id="pri_id">
                            <?php
                            $sql="SELECT * FROM priority ORDER BY pri_id";  //เลือกชั้นความลับ
                            $r =  dbQuery($sql);
                            $pri_cure=$row['pri_id'];
                            while($pri= dbFetchArray($r)){
                                $pri_sel=$pri['pri_id']; ?>
                                <option <?php if($pri_cure==$pri_sel){ echo "selected";}?> value="<?php print $pri['pri_id'];?>"><?php print $pri['pri_name'];?></option>
                           <?php } ?>
                        </select>
                    </div>
                    <div class="input-group col-xs-2">
                        <span class="input-group-addon"><i class="fas fa-space-shuttle"></i> ชั้นความเร็ว</span>
                        <select class="form-control" name="speed_id" id="speed_id">
                            <?php
                            $sql="SELECT * FROM speed ORDER BY speed_id";  //เลือกชั้นความเร็ว
                            $r=  dbQuery($sql);
                            $pri_cure=$row['speed_id'];
                            while($pri= dbFetchArray($r)){
                                $pri_sel=$pri['speed_id']; ?>
                                <option <?php if($pri_cure==$pri_sel){ echo "selected";}?> value="<?php print $pri['speed_id'];?>"><?php print $pri['speed_name'];?></option>
                           <?php }?>
                        </select>
                    </div>
                     <div class="input-group col-xs-3">
                        <span class="input-group-addon"><i class="fas fa-crosshairs"></i> วัตถุประสงค์</span>
                        <select class="form-control" name="obj_id" id="obj_id">
                            <?php
                            $sql="SELECT * FROM object ORDER BY obj_id";  //เลือกชั้นความเร็ว
                            $r = dbQuery($sql);
                            $pri_cure=$row['obj_id'];
                            while($pri= dbFetchArray($r)){
                                $pri_sel=$pri['obj_id']; ?>
                                <option <?php if($pri_cure==$pri_sel){ echo "selected";}?> value="<?php print $pri['obj_id'];?>"><?php print $pri['obj_name'];?></option>
                           <?php }?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-group col-xs-8">
                        <span class="input-group-addon"><i class="fas fa-calendar-alt"></i> เอกสารลงวันที่</span>
                        <input type="date" class="form-control col-xs-2" name="date_book" value="<?php print $row['date_book']; ?>" onKeyDown="return false" >
                    </div>
                </div>

                 <div class="form-group">
                    <div class="input-group col-xs-5">
                        <span class="input-group-addon"><i class="fas fa-user"></i> ผู้ส่ง</span>
                        <input name="sendfrom" type="text" class="form-control" value="<?php print $row['sendfrom']; ?>">
                    </div>
                   
                </div>

                <div class="form-group">
                     <div class="input-group col-xs-5">
                        <span class="input-group-addon"><i class="fas fa-user"></i> ผู้รับ</span>
                        <input name="sendto" type="text" class="form-control" value="<?php print $row['sendto']; ?>">
                    </div>
                </div>

                 <div class="form-group">
                     <div class="input-group col-xs-10">
                        <span class="input-group-addon"><i class="fas fa-list"></i> เรื่อง</span>
                        <input name="title" type="text" class="form-control" value="<?php print $row['title']; ?>">
                    </div>
                </div>

                <div class="form-group form-inline">
                     <div class="input-group col-xs-5">
                        <span class="input-group-addon"><i class="fas fa-share-alt"></i> อ้างถึง</span>
                        <input name="reference" type="text" class="form-control" value="<?php print $row['reference'];?>">
                    </div>
                    <div class="input-group col-xs-5">
                        <span class="input-group-addon"><i class="fab fa-wpforms"></i> สิ่งที่ส่งมาด้วย</span>
                        <input name="attachment" type="text" class="form-control" value="<?php print $row['attachment'];?>">
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-group col-xs-10">
                        <span class="input-group-addon"><i class="fab fa-jenkins"></i>หน่วยปฏิบัติ</span>
                        <?php
                        $practice=$row['practice'];
                            if($practice!='') {
                                $sql="SELECT dep_name FROM depart WHERE dep_id=$practice";
                                $result=dbQuery($sql);
                                $r=dbFetchArray($result);?>
                                <input class="form-control" type="text" value="<?php print $r['dep_name'];?>" disabled>
                      <?php }else{ ?>
                                <input class="form-control" type="text" value="ยังไม่มีหน่วยปฏิบัติ" disabled>
                      <?php } ?>
                    </div>
                </div>
                <div class="well bg-warning">
                
                 <div class="form-group form-inline">
                    <div class="input-group col-xs-5">
                         <span class="input-group-addon"><i class="fas fa-hand-point-right"></i> พิมพ์เลือกหน่วยปฏิบัติ</span>
                        <input class="form-control"  name="show_province1" type="text" id="show_province1"/>
                        <input name="h_province_id1" type="hidden" id="h_province_id1" value="" / >
                    </div>
                    <div class="input-group col-xs-2">
                        <span class="input-group-addon"><i class="fab fa-wpforms"></i> รหัสหน่วยงาน</span>
                        <input class="form-control" type="text" name="province_id" id="province_id">
                    </div>
                </div>
                
                <div class="form-group form-inline">
                     <div class="input-group col-xs-5">
                       <span class="input-group-addon"><i class="fas fa-upload fa-2x"></i> เลือกไฟล์เพื่อแนบเอกสาร</span>
                       <input name="file_location" class="form-control"  type="file">
                    </div>
                    <?php
                        if($row['file_location']!=''){?>
                             มีไฟล์เอกสารอยู่แล้ว= <a class="btn btn-info" href="<?php echo $row['file_location'];?>" target="_blank"><i class="fas fa-download"></i>Click Download</a>
                       <?php }else{?>
                             <span class="alert alert-danger"><i class="fas fa-exclamation-circle fa-2x"></i>คลิกที่ช่อง เพื่อเลือกไฟล์</span>
                     <?php  } ?>
                   
                </div>
                
                </div>
                 <div class="form-group form-inline">
                    <div class="input-group col-xs-5">
                        <span class="input-group-addon"><i class="fas fa-building"></i> ส่วนราชการผู้บันทึก</span>
                        <input name="dep_name" type="text" class="form-control" value="<?php print $row['dep_name'];?>" disabled>
                    </div>
                    <div class="input-group col-xs-5">
                        <span class="input-group-addon"><i class="fas fa-user"></i> เจ้าหน้าที่</span>
                        <input name="firstname" type="text" class="form-control" value="<?php print $row['firstname'];?>" disabled>
                    </div>
                </div>
                <!-- ตัวแปรส่งไปเพื่่อตรวจสอบกับฐานข้อมูล -->
                <input name="book_id" type="hidden" name="book_id" value="<?php echo $row['book_id'];?>">    
                <input name="book_detail_id" type="hidden"  value="<?php echo $row['book_detail_id'];?>">
                <input name="practice" type="hidden" value="<?php echo $row['practice'];?>">
                <center>
                        <input class="btn btn-warning btn-lg" type="submit" name="update" value="ตกลง">&nbsp&nbsp
                        <a class="btn btn-danger btn-lg" href="flow-resive-province.php">ยกเลิก</a>
                </center>    
            </form>
        </div> <!-- panel-body -->
        <div class="panel-footer">
        </div>
    </div><!-- panel -->
</div> 
<?php
//Update
 if(isset($_POST['update'])){       //if button update
    //book_master
    $book_id=$_POST['book_id'];
    $typeDoc=$_POST['typeDoc'];     //book master
    $obj_id=$_POST['obj_id'];
    $pri_id=$_POST['pri_id'];
    $speed_id=$_POST['speed_id'];

    //Book_detail
    $book_detail_id=$_POST['book_detail_id'];       //key of book_detail
    $book_no=$_POST['book_no'];     
    $reference=$_POST['reference'];
    $attachment=$_POST['attachment'];
    $title=$_POST['title'];
    $sendfrom=$_POST['sendfrom'];
    $sendto=$_POST['sendto'];
    $date_book=$_POST['date_book'];       //date of ducument
    $date_in=$_POST['date_in'];
    $practice=$_POST['h_province_id1'];
    $practiceCheck=$_POST['practice'];    //ใช้ตรวจสอบกรณีไม่มีการเลือกปฏิบัตหรือว่าผู้ปกิบัติมีอยู่แล้ว

    $upload=$_FILES['file_location']['name']; //ตัวแปรสำหรับอ่านค่าไฟล์ต่าง ๆ  $_FILES
        if($upload!=''){  
            $date=date('Y-m-d');  //กำหนดรูปแบบวันที่
            $numrand=(mt_rand()); //สุ่มตัวเลข
            $part="recive-to-province/";   //โฟลเดอร์เก็บเอกสาร
            $type=  strrchr($upload,'.');   //เอาชื่อเก่าออกให้เหลือแต่นามสกุล
            $newname=$date.$numrand.$type;   //ตั้งชื่อไฟล์ใหม่โดยใช้เวลา
            $part_copy=$part.$newname;
            $part_link="recive-to-province/".$newname;
            move_uploaded_file($_FILES['file_location']['tmp_name'],$part_copy);  //คัดลอกไฟล์ไป Server
        }else{
            $part_copy='';
        }

        if($practice == ''){  //กรณีที่ไม่ต้องการเปลี่ยนแปลงผู้ปฏิบัติ  ให้ใช้ค่าเดิม
          $practice=$practiceCheck;
        }

        //start transection
        dbQuery("BEGIN");
        $sql="UPDATE book_master SET typeDoc=$typeDoc,obj_id=$obj_id,pri_id=$pri_id,speed_id=$speed_id WHERE book_id=$book_id";
        $result1=dbQuery($sql);

        
        $sql="UPDATE book_detail SET
                                 book_no='$book_no',
                                 title='$title',
                                 sendfrom='$sendfrom',
                                 sendto='$sendto',
                                 reference='$reference',
                                 attachment='$attachment',
                                 date_book='$date_book',
                                 date_in='$date_in',
                                 practice=$practice,
                                 file_location='$part_copy' WHERE book_detail_id=$book_detail_id";
        $result2=dbQuery($sql);

         if($result1 && $result2){
            dbQuery("COMMIT");
            echo "<script>
            swal({
                title:'แก้ไขข้อมูลเรียบร้อยแล้ว',
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

?>

<script type="text/javascript">
function make_autocom(autoObj,showObj){
    var mkAutoObj=autoObj;
    var mkSerValObj=showObj;
    new Autocomplete(mkAutoObj, function() {
        this.setValue = function(id) {
            document.getElementById(mkSerValObj).value = id;
            // ถ้ามี id ที่ได้จากการเลือกใน autocomplete
            if(id!=""){
                // ส่งค่าไปคิวรี่เพื่อเรียกข้อมูลเพิ่มเติมที่ต้องการ โดยใช้ ajax
                $.post("g_fulldata.php",{id:id},function(data){
                    if(data!=null && data.length>0){ // ถ้ามีข้อมูล
                            // นำข้อมูลไปแสดงใน textbox ที่่เตรียมไว้
                            $("#province_id").val(data[0].id);
                            $("#province_name_th").val(data[0].name_th);
                    }
                });
            }else{
                // ล้างค่ากรณีไม่มีการส่งค่า id ไปหรือไม่มีการเลือกจาก autocomplete
                $("#province_id").val("");
                $("#province_name_th").val("");
            }
        }
        if ( this.isModified )
            this.setValue("");
        if ( this.value.length < 1 && this.isNotClick )
            return ;
        return "gdata.php?q=" +encodeURIComponent(this.value);
    });
}

// การใช้งาน
// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
make_autocom("show_province1","h_province_id1");
</script>  