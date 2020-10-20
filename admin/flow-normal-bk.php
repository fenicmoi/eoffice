
<?php
/*if(!isset($_SESSION['ses_u_id'])){
    header("location:../index.php");
}*/
date_default_timezone_set('Asia/Bangkok');
include "header.php"; 
$u_id=$_SESSION['ses_u_id'];
//require_once 'crud_flownormal.php';

?>
<?php    
   //ตรวจสอบปีเอกสาร
   $yid=chkYear();
 
    
    //คำนำหน้าทะเบียน
    $sqlPrefex="SELECT d.dep_id,d.dep_name,d.prefex,u.firstname 
                FROM depart as d
                INNER JOIN user as u ON u.dep_id= d.dep_id
                WHERE u.u_id=".$u_id;
    //echo $sqlPrefex;
    $resPrefex= dbQuery($sqlPrefex);
    $rowPrefex= dbFetchArray($resPrefex);
    $prefex=$rowPrefex[2];
    
    //ชั้นความเร็ว
    $sqlSpeed="SELECT * FROM speed ORDER BY speed_id";
    $resSpeed=dbQuery($sqlSpeed);
    $rowSpeed=dbFetchArray($resSpeed);
  
?>
        <div class="col-md-2" >
           <?php
                $menu=  checkMenu($level_id);
                //echo $menu;
                include $menu;
           ?>
        </div>
    
        <div  class="col-md-10">
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#home">ทะเบียนรวมหนังสือปกติ</a></li>
                <li><a data-toggle="tab" href="#menu1">ออกเลขหนังสือปกติ</a></li>
            </ul>

            <div class="tab-content">
                <div id="home" class="tab-pane fade in active">
                     <table class="table table-bordered table-hover" id="myTable">
                        <thead>
                            <tr>
                                <th>สถานะ</th>
                                <th>เลขส่ง</th>
                                <th>เลขที่เอกสาร</th>
                                <th>เรื่อง</th>
                                <th>ถึง</th>
                                <th>ลงวันที่</th>
                                <th>แนบ</th>
                                <th>ส่งเอกสาร</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $count=1;
                                
                                        
                                $sql="SELECT * FROM  flownormal WHERE u_id=$u_id ORDER BY cid DESC";
                                    
                                $result = dbQuery($sql);
                            
                                while($row=dbFetchArray($result)){?>
                                    <tr>
                                    <td><?php
                                            $status= $row['status']; 
                                            switch ($status) {
                                                case 0:
                                                    echo "<img src=\"../images/close.gif\">";
                                                    break;
                                                case 1:
                                                    echo "<img src=\"../images/lease.gif\">";
                                                    break;
                                                case 2:
                                                    echo "<img src=\"../images/working.gif\">";
                                                    break;
                                                case 3:
                                                    echo "<img src=\"../images/succ.gif\">";
                                                    break;
                                            }
                                        ?></td>
                                    <?php  $cid=$row['cid']; ?>
                                    <td><?php echo $row['rec_no']; ?></td>
                                    <td><?php echo $row['prefex']; echo $row['rec_no']; ?></td>
                                    <td><a href="flow-normal-detail.php?u_id=<?=$u_id?>&cid=<?=$cid?>"> <?php echo substr($row['title'],0,300);?></a></td>
                                    <td><?php echo $row['sendto']; ?></td>
                                    <td><?php echo $row['dateline']; ?></td>
                                    <td><a class="btn btn-success" href="flow-normal-edit.php?u_id=<?=$u_id?>&cid=<?=$cid?>"><i  class="fa fa-pencil"></i> แนบสำเนา</a></td>
                                    <td><a class="btn btn-primary" href="flow-normal-send.php?u_id=<?=$u_id?>&cid=<?=$cid?>"><i  class="fa fa-pencil"></i>ส่งเอกสาร</a></td>
                                    </tr>
                                    <?php $count++; }?>
                        </tbody>
                    </table>
                    <div class="well">
                        คำอธิบาย:  <img src="../images/working.gif"> อยู่ระหว่างดำเนินการ   
                                <img src="../images/succ.gif"> ปิดงานแล้ว   
                                <img src="../images/lase.gif"> อยู่ระหว่างดำเนินการและเลยกำหนด   
                                <img src="../images/cancle.gif"> ยกเลิก/ส่งคืนหนังสือ   
                    </div>
                </div>

                <div id="menu1" class="tab-pane fade">
                    <br>
                        
                   <i class="badge"> ข้อกำหนดทั้่วไป </i>                   
                    <div class="well">
                     <form name="form" method="post" enctype="multipart/form-data">
                        <table width="800">
                            <tr>
                                <td> 
                                    <div class="form-group form-inline">
                                        <label for="typeDoc">ประเภทหนังสือ :</label>
                                        <input class="form-control" name="typeDoc" type="radio" value="0" checked=""> ปกติ
                                        <input class="form-control" name="typeDoc" type="radio" value="1" disabled=""> เวียน
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group form-inline">
                                        <label for="yearDoc">ปีเอกสาร : </label>
                                        <input class="form-control"  name="yearDoc" type="text" value="<?php print $yid[1]; ?>" disabled="">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                     <div class="form-group form-inline">
                                        <label for="currentDate">วันที่ทำรายการ :</label>
                                        <input class="form-control" type="text" name="currentDate" value="<?php print DateThai();?>" disabled="">
                                    </div>
                                </td>
                                <?php
                                  //วัตถุประสงค์
                                    $sql="SELECT * FROM object ORDER BY obj_id";
                                    $result=dbQuery($sql);
                                    $rowObj=dbFetchArray($result);
                                ?>
                                <td>
                                    <div class="form-group form-inline"> 
                                        <label for="obj_id">วัตถุประสงค์ : </label>
                                        <select name="obj_id" class="form-control" required>
                                            <?php 
                                                while ($rowObj=dbFetchArray($result)){
                                                echo "<option  value=".$rowObj['obj_id'].">".$rowObj['obj_name']."</option>";
                                            }?>
                                        </select>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="form-group form-inline">
                                        <label for="prefex">คำนำหน้าเลข ท/บ : </label>
                                        <input type="text" class="form-control" name="prefex" id="prefex" value="<?php  print $prefex; ?>/" >
                                    </div>    
                                </td>
                                <td>
                                 <div class="form-group form-inline">
                                     <label>เลขทะเบียนส่ง : <kbd>ออกโดยระบบ</kbd></label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="form-group form-inline">
                                        <label for="speed">ชั้นความเร็ว : </label>
                                        <select name="speed_id" id="speed_id" class="form-control">
                                                <?php 
                                                    while ($rowSpeed=$resSpeed->fetch_array()){
                                                        echo "<option  value=".$rowSpeed['speed_id'].">".$rowSpeed['speed_name']."</option>";
                                                    }?>
                                        </select>
                                    </div>
                                </td>
                                <?php
                                  //ชั้นความลับ
                                $sql="SELECT * FROM secret ORDER BY sec_id";
                                $result=dbQuery($sql);
                                $row=dbFetchArray($result);
                                ?>
                                <td>
                                    <div class="form-group form-inline">
                                        <label for="sec_id">ชั้นความลับ :</label>
                                        <select name="sec_id" id="sec_id" class="form-control">
                                                <?php
                                                    while($row=dbFetchArray($result)){
                                                        echo "<option value=".$row['sec_id'].">".$row['sec_name']."</option>";
                                                    }?>
                                        </select>
                                    </div>
                                </td>
                            </tr>
                        </table>
                        </div>

                        <i class="badge">รายละเอียด</i>
                        <div class="well">  
                            <table width="800">
                                <tr>
                                    <td>
                                        <div class="form-group form-inline">
                                            <label for="sendfrom">จาก : </label>
                                            <input class="form-control" type="text"  name="sendfrom" id="sendfrom" value="ผู้ว่าราชการจังหวัดพังงา">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group form-inline">
                                            <label for="sendto">ถึง : </label>
                                            <input class="form-control" type="text"  name="sendto" id="sendto"   required placeholder="ระบุผู้รับหนังสือ">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-group form-inline">
                                            <label for="title">เรื่อง : </label>
                                            <input class="form-control" type="text"  name="title" id="title" size="50" required placeholder="เรื่องหนังสือ">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group form-inline">
                                            <label for="datepicker">ลงวันที่ :</label><input class="form-control" type="text" name="datepicker"  id="datepicker" >
                                       </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-group form-inline">
                                            <label for="refer">อ้างถึง</label>
                                            <input class="form-control" type="text"  size="50" name="refer" id="refer" value="-" ><br>
                                        </div>    
                                     </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-group form-inline">
                                            <label for="attachment">สิ่งที่ส่งมาด้วย</label>
                                            <input class="form-control" type="text" size="40" name="attachment" value="-" >
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group form-inline">
                                            <label for="practice">ผู้เสนอ</label>
                                            <input class="form-control" type="text" size="30"  name="practice" placeholder="ระบุผู้รับผิดชอบ" required>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-group form-inline">
                                             <label for="file_location">ที่เก็บเอกสาร</label>
                                             <input class="form-control" type="text" size="30"  name="file_location" placeholder="ระบุที่เก็บเอกสาร" required>
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
                          
                          <div class="form-group form-inline">
                              <label>อื่นๆ :</label>
                              <input type="checkbox" name="follow" id="follow" value="1" checked> ติดตามผลการดำเนินงาน
                              <input type="checkbox" name="open" id="open" value="1" checked> เปิดเผยแก่บุคคลทั่วไป
                          </div>
                         </div> <!-- class well -->    
                         
                               <center>
                                    <button class="btn btn-primary btn-lg" type="submit" name="save">
                                    <i class="fa fa-database fa-2x"></i> บันทึก
                                    <input id="u_id" name="u_id" type="hidden" value="<?php echo $u_id; ?>"> 
                                    <input id="yid" name="yid" type="hidden" value="<?php echo $yid; ?>"> 
                                    </button>
                               </center>    
                     </form>
                   
                </div>
            </div>
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