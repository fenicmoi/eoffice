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
                <div class="panel-heading">
                    <i class="fa fa-university fa-2x" aria-hidden="true"></i>  <strong>หนังสือรับ [ถึงหน่วยงาน]</strong>
                    <a href="" class="btn btn-primary btn-sm pull-right" data-toggle="modal" data-target="#modalAdd">
                        <i class="fa fa-plus" aria-hidden="true"></i> ลงทะเบียนรับ
                        </a>
                </div>
                    <div class="well">
                            <ul class="nav nav-tabs">
                                <li class="active"  ><a class="fa fa-yelp" data-toggle="tab" href="#home"> หนังสือรอลงรับ</a></li>
                                <li><a class="fa fa-folder" data-toggle="tab" href="#menu1"> หนังสือรับแล้ว</a></li>
                            </ul>

                            <div class="tab-content">
                                <div id="home" class="tab-pane fade in active">
                                   <?php include 'flow-resive-internal-new.php'; ?>
                                </div>
                                <div id="menu1" class="tab-pane fade">
                                   <?php include 'flow-resive-internal-folder.php'; ?>
                                </div>
                            </div>
                    </div>
            </div> <!-- class panel -->


            <!-- Model -->
            <!-- เพิ่มหนังสือ -->
            <div id="modalAdd" class="modal fade" role="dialog">
              <div class="modal-dialog modal-lg">
                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header bg-info">
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
                                        <input  type="text"  name="sendto" id="sendto"  size="50"  placeholder="ระบุผู้รับหนังสือ" required
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
                                         <input  type="text" size="50"  name="practice" placeholder="ระบุหน่วยงานรับผิดชอบ" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                       <label for="fileupload">เอกสารแนบ</label>
                                       <div class="well">
                                       <input type="file" name="fileupload" required >
                                       </div>
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
                                    <button class="btn btn-primary btn-lg" type="submit" name="save">
                                        <i class="fa fa-database fa-2x"></i> บันทึก
                                        <input id="u_id" name="u_id" type="hidden" value="<?php echo $u_id; ?>"> 
                                        <input id="sec_id" name="u_id" type="hidden" value="<?php echo $sec_id; ?>"> 
                                        <input id="dep_id" name="u_id" type="hidden" value="<?php echo $dep_id; ?>"> 
                                        <input id="yid" name="yid" type="hidden" value="<?php echo $yid; ?>"> 
                                    </button>
                                    
                            </center>   
                        </form>
                  </div>
                  <div class="modal-footer bg-info">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">X</button>
                  </div>
                </div>

              </div>
            </div>
            <!-- End Model --> 
        </div>  <!-- col-md-10 -->
    
    <!--  modal แสงรายละเอียดข้อมูล -->
        <div  class="modal fade bs-example-modal-table" tabindex="-1" aria-hidden="true" role="dialog">
        <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"><i class="fa fa-info"></i> รายละเอียดหนังสือเข้า</h4>
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
        $type_id=2;                    //ชนิดของหนังสือ  1  หนังสือรับ-ถึงจังหวัด
        /*$dep_id=$_SESSION['dep_id'];     //รหัสหน่วยงาน   รับค่ามาจาก session จาก header แล้ว
        $sec_id=$_SESSION['sec_id'];       //รหัสกลุ่มงาน  */
        $uid=$_POST['u_id'];               //รหัสผู้ใช้
        $obj_id=$_POST['obj_id'];          //รหัสวัตถุประสงค์
        $pri_id=$_POST['pri_id'];          //รหัสชั้นความลับ
        $yid=$_POST['yid'];                //รหัสปีปัจจุบัน
        $typeDoc=$_POST['typeDoc'];        //รหัสประเภทหนังสือ   1ปกติ 2 เวียน
        $speed_id=$_POST['speed_id'];


        //(1) เลือกข้อมูลเพื่อรันเลขรับ  โดยมีเงื่อนไขให้ตรงกับหน่วยงานของผู้ใช้ ###########################
        $sql="SELECT rec_id FROM book_master WHERE dep_id=$dep_id and type_id=2 AND yid=$yid ORDER  BY book_id DESC";
        //echo $sql;
        $result=dbQuery($sql);
        $rowRun= dbFetchArray($result);
        $rec_id=$rowRun['rec_id'];
        $rec_id++;
       
        // ##### ตาราง book_master
  
        /*$sql="SHOW TABLE STATUS LIKE 'book_master'";     //ส่วนหา ID ล่าสุด
        $result=dbQuery($sql);
        $row=dbFetchAssoc($result);
        $book_id=(int)$row['Auto_increment'];*/
        

        //#######  ข้อมูลสำหรับตาราง book_detail  #########################################
       // $book_id=dbInsertId($dbConn);  //เลือก ID ล่าสุดจากตาราง book_master
        $book_no=$_POST['book_no'];           // หมายเลขประจำหนังสือ
        $title=$_POST['title'];               // เรื่อง   
        $date_in=$_POST['date_in'];             // วันที่ลงรับ
        $date_book=$_POST['datepicker'];       // เอกสารลงวันที่
        $sendfrom=$_POST['sendfrom'];         // ผู้ส่ง
        $sendto=$_POST['sendto'];             // ผู้รับ
        $refer=$_POST['refer'];               // อ้างถึง
        $practice=$_POST['practice'];         // ผู้ปฏิบัติ
        $follow=$_POST['follow'];             // ติดตามหนังสือ
        $publice_book=$_POST['open'];         // เปิดเผยหนังสือ
        $attachment=$_POST['attachment'];     //เอกสารแนบ

        //file upload
        // $fileupload=$_REQUEST['fileupload'];  //การจัดการ fileupload
        @$fileupload=$_POST['fileupload'];
        $date=date('Y-m-d');
        $numrand=(mt_rand()); //สุ่มตัวเลข
        $upload=$_FILES['fileupload']; //เพิ่มไฟล์
        if($upload<>''){
            $part="resive-to-internal/";   //โฟลเดอร์เก็บเอกสาร
            $type=  strrchr($_FILES['fileupload']['name'],".");   //เอาชื่อเก่าออกให้เหลือแต่นามสกุล
            $newname=$date.$numrand.$type;   //ตั้งชื่อไฟล์ใหม่โดยใช้เวลา
            $part_copy=$part.$newname;
            $part_link="resive-to-internal/".$newname;
            move_uploaded_file($_FILES['fileupload']['tmp_name'],$part_copy);  //คัดลอกไฟล์ไป Server
        }
       //$file_location=$_POST['file_location'];
        
        $datelout=date('Y-m-d h:i:s');
        

        //transection
        dbQuery('BEGIN');

        $sql="INSERT INTO book_master (rec_id,type_id,dep_id,sec_id,u_id,obj_id,pri_id,yid,typeDoc,speed_id) 
                      VALUES ($rec_id,$type_id,$dep_id,$sec_id,$u_id,$obj_id,$pri_id,$yid,$typeDoc,$speed_id)";
        $result1=dbQuery($sql);
        $book_id=dbInsertId();

        $sql="INSERT INTO book_detail (book_id,book_no,title,sendfrom,sendto,reference,attachment,date_book,date_in,practice,follow,publice_book,status,file_upload)
        VALUES($book_id,'$book_no','$title','$sendfrom','$sendto','$refer','$attachment','$date_book','$date_in','$practice','$follow','$publice_book',1,'$part_copy')";
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
                        window.location.href='flow-resive-internal.php';
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
                        window.location.href='flow-resive-internal.php';
                    }
                }); 
            </script>";
        } 
  } 

if(isset($_POST['recive'])){   //ถ้ามีการกดปุ่มรับหนังสือ
    $book_id=$_POST['book_id'];


     //transection
    dbQuery('BEGIN');
    //update book_detail
    $sql="UPDATE book_detail SET status=1 WHERE book_id=$book_id ";   //book_detail
    $result1=dbQuery($sql);

    //ค้นหาระเบียนที่จะลงรับ
    $sql="SELECT m.book_id , d.book_detail_id , d.practice  FROM book_master m   
          INNER JOIN book_detail d ON d.book_id=m.book_id
          WHERE d.book_id=$book_id AND d.status=1";  
    $result=dbQuery($sql);
    $row=dbFetchAssoc($result);
    $book_detail_id=$row['book_detail_id'];

    //หา recno ล่าสุด
    $sql="SELECT rec_no FROM flowrecive WHERE yid=$yid AND  dep_id=$dep_id";
    $result=dbQuery($sql);
    $rec_no=dbNumRows($result);

    if($rec_no==0){
        $rec_no=1;
    }else{
        $rec_no++;
    }
    
    //วันที่ลงรับ
    $date_recive=DateThai();

    $sql="INSERT INTO flowrecive (book_detail_id,rec_no,date_recive,dep_id,yid)  VALUES($book_detail_id,$rec_no,'$date_recive',$dep_id,$yid)";
    $result2=dbQuery($sql);

    if(!$result1 && !$result2){
         dbQuery("ROLLBACK");
        echo "<script>
        swal({
            title:'มีบางอย่างผิดพลาด! กรุณาตรวจสอบ',
            type:'error',
            showConfirmButton:true
            },
            function(isConfirm){
                if(isConfirm){
                    window.location.href='flow-resive-internal.php';
                }
            }); 
        </script>";
    } else{
        dbQuery('commit');
        echo "<script>
        swal({
            title:'ลงทะเบียนรับเรียบร้อยแล้ว',
            type:'success',
            showConfirmButton:true
            },
            function(isConfirm){
                if(isConfirm){
                    window.location.href='flow-resive-internal.php';
                }
            }); 
        </script>";
    }
}

if(isset($_POST['resend'])){   //ถ้ามีการกดปุ่มส่งคืน
    $book_id=$_POST['book_id'];
    $sql="UPDATE book_detail SET status=3 WHERE book_id=$book_id ";   //book_detail
    $result1=dbQuery($sql);
    if($result1){
        echo "<script>
        swal({
            title:'ส่งคืนหนังสือเรียบร้อยแล้ว',
            type:'success',
            showConfirmButton:true
            },
            function(isConfirm){
                if(isConfirm){
                    window.location.href='flow-resive-internal.php';
                }
            }); 
        </script>";
    }else{
        echo "<script>
        swal({
            title:'มีบางอย่างผิดพลาด !',
            type:'error',
            showConfirmButton:true
            },
            function(isConfirm){
                if(isConfirm){
                    window.location.href='flow-resive-internal.php';
                }
            }); 
        </script>";
    }
}
?>



<!-- ส่วนนำข้อมูลไปแสดงผลบน Modal -->
<script type="text/javascript">
function load_leave_data(u_id,rec_id,book_id) {
                    var sdata = 
                    {u_id : u_id , 
                    rec_id : rec_id,
                    book_id : book_id
                    };
                    $('#divDataview').load('show_resive_internal_detail.php',sdata);
}
</script>


<script type='text/javascript'>
       $('#tbRecive').DataTable( {
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