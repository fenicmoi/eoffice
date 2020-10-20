
<?php
/*if(!isset($_SESSION['ses_u_id'])){
    header("location:../index.php");
}*/
date_default_timezone_set('Asia/Bangkok');
include "header.php"; 
$u_id=$_SESSION['ses_u_id'];
$cid=$_GET['cid'];

require_once 'crud_flownormal.php';

?>
<?php    
   //ตรวจสอบปีเอกสาร
   $sqlYear="SELECT * FROM sys_year WHERE status=1";
   $resYear=$conn->query($sqlYear);
   $data=$resYear->fetch_array();
   $yid=$data[0];
   $yname=$data[1];
 
    
    //คำนำหน้าทะเบียน
    $sqlPrefex="SELECT d.dep_id,d.dep_name,d.prefex,u.firstname 
                FROM depart d
                INNER JOIN user u
                ON u.dep_id= d.dep_id
                WHERE u.u_id=".$u_id;
    //echo $sqlPrefex;
    $resPrefex=  dbQuery($sqlPrefex);
    $rowPrefex= mysqli_fetch_array($resPrefex);
    $prefex=$rowPrefex[2];
    
   
   
    
    //เลือกขอมูลหนังสือส่งปกติ
    $sqlFlowCircle="SELECT * FROM flownormal WHERE  cid=$cid";
    //print $sqlFlowCircle;
    $resSqlFlowCircle= mysqli_query($conn, $sqlFlowCircle);
    $rowFlowCircle=  mysqli_fetch_assoc($resSqlFlowCircle);
    
    $speed=$rowFlowCircle['speed_id'];
    $sec_id=$rowFlowCircle['sec_id'];
    $obj_id=$rowFlowCircle['obj_id'];
    $sendFrom=$rowFlowCircle['sendfrom'];
    $sendTo=$rowFlowCircle['sendto'];
    $title=$rowFlowCircle['title'];
    $refer=$rowFlowCircle['refer'];
    $attachment=$rowFlowCircle['attachment'];
    $practice=$rowFlowCircle['practice'];
    $file_location=$rowFlowCircle['file_location'];
    $dateLine=$rowFlowCircle['dateline'];
    
    $fileUpload=$rowFlowCircle['file_upload'];

    
     //ชั้นความเร็ว
   $sqlSpeed="SELECT * FROM  speed WHERE speed_id=$speed";
   $resSpeed=$conn->query($sqlSpeed);
   $rowSpeed=  mysqli_fetch_assoc($resSpeed);
   $speed_name=$rowSpeed['speed_name'];
   
    //ชั้นความลับ
    $sqlSecret="SELECT * FROM secret WHERE sec_id=$sec_id";
    $resSecret=$conn->query($sqlSecret);
    $rowSecret=  mysqli_fetch_assoc($resSecret);
    $sec_name=$rowSecret['sec_name'];
    
      //วัตถุประสงค์
    $sqlobj="SELECT * FROM object WHERE obj_id=$obj_id";
    $resObj=$conn->query($sqlobj);
    $rowObj=  mysqli_fetch_assoc($resObj);
    $objName=$rowObj['obj_name'];
    
    if(!$rowFlowCircle){
        echo "ไม่สามารถเลือกข้อมูลระบบได้";
        exit();
    }
    
?>
        <div class="col-md-2" >
           <?php
                $menu=  checkMenu($level_id);
                //echo $menu;
                include $menu;
           ?>
        </div>
    
        <div  class="col-md-10">
             <div class="panel panel-default" style="margin: 20">
                 <div class="panel-heading"><i class="fa fa-envelope-open-o fa-2x" aria-hidden="true"></i>  <strong>แก้ไข/เพิ่มเติม</strong></div>
                   <i class="badge"> ข้อมูลทั่วไป </i>                   
                    <div class="well">
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
                                    <div class="form-group form-inline">
                                        <label for="yearDoc">ปีเอกสาร : </label>
                                        <input class="form-control"  name="yearDoc" type="text" value="<?php print $yname; ?>" disabled="">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                     <div class="form-group form-inline">
                                        <label for="currentDate">วันที่ทำรายการ :</label>
                                        <?php $changDate=$rowFlowCircle['dateout'];?>
                                        <input type="text" class="form-control" name="currentDate" value="<?php   echo thaiDate($changDate); ?>" disabled="">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group form-inline"> 
                                        <label for="obj_id">วัตถุประสงค์ : </label>
                                        <kbd><?php print $objName ?></kbd>  
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="form-group form-inline">
                                        <label for="prefex">เลขทะเบียนส่ง : </label>
                                        <input type="text" class="form-control" name="prefex" id="prefex" value="<?php  print $prefex; ?>/ว <?php print $rowFlowCircle['rec_no'];?>" disabled="" >
                                    </div>    
                                </td>
                                <td>
                                   <!-- <div class="form-group form-inline">
                                         <label>เลขทะเบียนส่ง : <kbd><?php //print $rowFlowCircle['rec_no'];?></kbd></label>
                                    </div>  -->
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="form-group form-inline">
                                        <label for="speed">ชั้นความเร็ว : </label>
                                        <kbd><?php print $speed_name ?></kbd>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group form-inline">
                                        <label for="sec_id">ชั้นความลับ :</label>
                                        <kbd><?php print $sec_name?></kbd>
                                    </div>
                                </td>
                            </tr>
                        </table>
                        </div>
                    
                        <i class="badge"> รายละเอียด</i>
                        <div class="well">  
                            <table width="800">
                                <tr>
                                    <td>
                                        <div class="form-group form-inline">
                                            <label for="sendfrom">จาก : </label>
                                            <input class="form-control" type="text"  name="sendfrom" id="sendfrom" value="<?php print $sendFrom ?>" disabled="">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group form-inline">
                                            <label for="sendto">ถึง : </label>
                                            <input class="form-control" type="text"  name="sendto" id="sendto"   value="<?php print $sendTo?>" disabled="">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <div class="form-group form-inline">
                                            <label for="title">เรื่อง : </label>
                                            <input class="form-control" type="text"  name="title" id="title" size="100" value="<?php print $title ?>" disabled="">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-group form-inline">
                                            <label for="refer">อ้างถึง</label>
                                            <input class="form-control" type="text"  size="50" name="refer" id="refer" value="<?php print $refer?>" disabled="" >
                                        </div>    
                                     </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-group form-inline">
                                            <label for="attachment">สิ่งที่ส่งมาด้วย</label>
                                            <input class="form-control" type="text" size="40" name="attachment" value="<?php print $attachment ?>" disabled="" >
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group form-inline">
                                            <label for="practice">ผู้เสนอ</label>
                                            <input type="text" size="30"  name="practice" value="<?php print $practice ?>" disabled="">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-group form-inline">
                                             <label for="file_location">ที่เก็บเอกสาร</label>
                                             <input class="form-control" type="text" size="30"  name="file_location" value="<?php print $file_location?>" disabled="">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group form-inline">
                                            <label for="datepicker">ลงวันที่ :</label><input type="text" name="datepicker" value="<?php print $dateLine ?>" disabled="" >
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                       <?php if($fileUpload<>""){?>
                                        <div class="form-group form-inline">
                                            <label for="fileupload">สำเนาหนังสือ</label>
                                            <a href="<?php print $fileUpload ?>" target="_blank"><i class="fa fa-file-text"></i>มีสำเนาหนังสือ</a>
                                        </div>
                                       <?php }elseif($fileUpload==""){ ?>
                                        <div class="form-group form-inline">
                                            <label for="fileupload">แนบไฟล์</label>
                                            <input type="file" name="fileupload"  class="alert-success">
                                        </div> 
                                       <?php } ?>
                                </tr>
                            </table>
                          
                          <div class="form-group form-inline">
                              <label>อื่นๆ :</label>
                              <input type="checkbox" name="follow" id="follow" value="1" checked> ติดตามผลการดำเนินงาน
                              <input type="checkbox" name="open" id="open" value="1" checked> เปิดเผยแก่บุคคลทั่วไป
                          </div>
                         </div> <!-- class well -->    
                         
                               <center>
                                   <?php if($fileUpload<>""){?>
                                   <a class="btn btn-success" href="flow-normal.php">ย้อนกลับ</a>
                                   <?php } else { ?>
                                    <button class="btn btn-primary btn-lg" type="submit" name="update">
                                    <i class="fa fa-database fa-2x"></i> บันทึก
                                    <input id="u_id" name="u_id" type="hidden" value="<?php echo $u_id; ?>"> 
                                    <input id="yid" name="yid" type="hidden" value="<?php echo $yid; ?>"> 
                                    </button>
                                   <?php } ?>
                               </center>    
                     </form>
                   
                    </div> <!-- panel -->
                 </div>  <!-- col-md-10 -->
    </div>  <!-- container -->
<?php //include "footer.php"; ?>
  
 
<script>

$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
});

 $.datepicker.regional['th'] ={
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
    $( "#datepicker" ).datepicker( $.datepicker.regional["th"] ); // Set ภาษาที่เรานิยามไว้ด้านบน
    $( "#datepicker" ).datepicker("setDate", new Date()); //Set ค่าวันปัจจุบัน
  });


    var Holidays;
 
    //On Selected Date
    //Have Check Date
    function CheckDate(date) {
        var day = date.getDate();
        var selectable = true;//ระบุว่าสามารถเลือกวันที่ได้หรือไม่ True = ได้ False = ไม่ได้
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
        Holidays = [1,4,6,11]; // Sample Data
    }
    //=====================================
 
  </script> 