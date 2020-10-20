
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
                    <i class="fa fa-university fa-2x" aria-hidden="true"></i>  <strong>ทะเบียนหนังสือรับ</strong>
                    <a href="" class="btn btn-primary pull-right" data-toggle="modal" data-target="#myReport"><i class="fa fa-print " aria-hidden="true"></i> รายงานประจำวัน</a>
                </div>
                    <table class="table table-bordered table-hover" id="tbRecive">
                        <thead class="bg-info">
                            <tr>
                                <th>ท/บ กลาง</th>
                                <th>ท/บ รับ</th>
                                <th>เลขที่เอกสาร</th>
                                <th>เรื่อง</th>
                                <th>จาก</th>
                                <th>ลงวันที</th>
                                <th>สถานะ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $count=1;
                                $sql="SELECT fr.*,d.book_id,d.book_no,d.title,d.sendfrom,d.date_book,d.date_line,d.status
                                      FROM flowrecive as fr
                                      INNER JOIN book_detail as d ON fr.book_detail_id = d.book_detail_id
                                      WHERE dep_id = $dep_id";
                               // print $sql;
                                $result=dbQuery($sql);
                                while($row=dbFetchArray($result)){?>
                                    <?php $rec_id=$row['rec_no']; ?>    <!-- กำหนดตัวแปรเพื่อส่งไปกับลิงค์ -->
                                    <?php $book_id=$row['book_detail_id']; ?>  <!-- กำหนดตัวแปรเพื่อส่งไปกับลิงค์ -->
                                    <tr>
                                    <td> <?php echo $row['book_id']; ?></td>  
                                    <td><?php echo $row['rec_no']; ?></td>
                                    <td><?php echo $row['book_no']; ?></td>
                                    <td>
                                        <a href="#" 
                                                onclick="load_leave_data('<? print $u_id;?>','<? print $rec_id; ?>','<? print $book_id; ?>');" data-toggle="modal" data-target=".bs-example-modal-table">
                                                <?php echo $row['title'];?> 
                                        </a>
                                    </td>
                                    <td><?php echo $row['sendfrom']; ?></td>
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
                    	 <form class="form-inline" role="form" id="form_other" name="form_other" method="POST"  action="report/rep-resive-depart.php"> 
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
        $sql="SELECT rec_id FROM book_master WHERE   yid=$yid ORDER  BY book_id DESC";
        $result=dbQuery($sql);
        $rowRun= dbFetchArray($result);
        $rec_id=$rowRun['rec_id'];
        $rec_id++;
      
   
       
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

        $sql="INSERT INTO book_detail (book_id,book_no,title,sendfrom,sendto,reference,attachment,date_book,date_in,practice,follow,publice_book,status,file_upload)
        VALUES($book_id,'$book_no','$title','$sendfrom','$sendto','$refer','$attachment','$date_book','$date_in','$practice[0]','$follow','$publice_book',0,'$part_copy')";
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
 }*/


?>


<!-- ส่วนนำข้อมูลไปแสดงผลบน Modal -->
<script type="text/javascript">
function load_leave_data(u_id,rec_id,book_id) {
                    var sdata = 
                    {u_id : u_id , 
                    rec_id : rec_id,
                    book_id : book_id
                    };
                    $('#divDataview').load('show_resive_depart_detail.php',sdata);
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
