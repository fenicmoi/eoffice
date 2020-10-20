
<script type="text/javascript" src="datePicket.js"></script>
<?php
include "header.php"; 
$u_id=$_SESSION['ses_u_id'];

?>
<?php    
//ตรวจสอบปีเอกสาร
    list($yid,$yname)=chkYear();  
    $yid=$yid;
    $yname=$yname;

//วัตถุประสงค์
    $sqlobj="SELECT * FROM object ORDER BY obj_id";
    $resObj=$conn->query($sqlobj);
    
//ชั้นความเร็ว
    $sqlSpeed="SELECT * FROM speed ORDER BY speed_id";
    $resSpeed=$conn->query($sqlSpeed);

//ชั้นความลับ
    $sqlSecret="SELECT * FROM secret ORDER BY sec_id";
    $resSecret=$conn->query($sqlSecret);
?>




        <div class="col-md-2" >
           <?php
                $menu=  checkMenu($level_id);
                include $menu;
           ?>
        </div>
        
        <div  class="col-md-10">
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#home"><h4>ทะเบียนรวมหนังสือรับ</h4></a></li>
                <li><a data-toggle="tab" href="#menu1"><h4>ลงทะเบียนหนังสือรับ</h4></a></li>
            </ul>

            <div class="tab-content">
                <div id="home" class="tab-pane fade in active">
                     <table class="table table-bordered table-hover" id="tbRecive">
                        <thead>
                            <tr>
                                <th>ท/บ กลาง</th>
                                <th>ท/บ รับ</th>
                                <th>เลขที่เอกสาร</th>
                                <th>เรื่อง</th>
                                <th>จาก</th>
                                <th>วันที่รับ</th>
                                <th>ส่งเอกสาร</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $count=1;
                                $sql="SELECT * FROM  flowrecive WHERE u_id=$u_id ORDER BY cid DESC";
                                    
                                $res = $conn->query($sql);
                                while($row=$res->fetch_array()){?>
                                    <?php $cid=$row['cid']; ?>
                                    <tr>
                                    <td><?php echo $row['cid']; ?></td>
                                    <td><?php echo $row['rec_no']; ?></td>
                                    <td><?php echo $row['prefex']; echo $row['rec_no']; ?></td>
                                    <td> <a href="#" onclick="load_leave_data('<?php print $u_id;?>','<?php print $cid; ?>');" data-toggle="modal" data-target=".bs-example-modal-table"> <?php echo $row['title'];?> </a></td>
                                    <td><?php echo $row['sendto']; ?></td>
                                    <td><?php echo $row['dateline']; ?></td>
                                    <td><a class="btn btn-primary" href="paper.php"><i  class="fa fa-paper-plane"></i> ส่งเอกสาร</a></td>
                                    </tr>
                                    <?php $count++; }?>
                                    
                        </tbody>
                    </table>
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
                                        <input class="form-control" name="typeDoc" type="radio" value="1" > เวียน
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
                                        <input class="form-control" type="text" name="currentDate" value="<?php print DateThai();?>" disabled="">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group form-inline"> 
                                        <label for="obj_id">วัตถุประสงค์ : </label>
                                        <select name="obj_id" class="form-control" required>
                                            <?php 
                                                while ($row=$resObj->fetch_array()){
                                                echo "<option  value=".$row['obj_id'].">".$row['obj_name']."</option>";
                                            }?>
                                        </select>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="form-group form-inline">
                                        <label for="prefex">เลขที่เอกสาร : </label>
                                        <input type="text" class="form-control" name="prefex" id="prefex"  >
                                    </div>    
                                </td>
                                <td>
                                 <div class="form-group form-inline">
                                     <label>เลขทะเบียนรับ : <kbd>ออกโดยระบบ</kbd></label>
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
                                <td>
                                    <div class="form-group form-inline">
                                        <label for="sec_id">ชั้นความลับ :</label>
                                        <select name="sec_id" id="sec_id" class="form-control">
                                                <?php
                                                    while($rowSecret=$resSecret->fetch_array()){
                                                        echo "<option value=".$rowSecret['sec_id'].">".$rowSecret['sec_name']."</option>";
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
                                            <input class="form-control" type="text"  name="sendfrom" id="sendfrom" size="50" require placeholder="ระบุผู้ส่ง" >
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group form-inline">
                                            <label for="sendto">ถึง : </label>
                                            <input class="form-control" type="text"  name="sendto" id="sendto"  size="50"  required placeholder="ระบุผู้รับหนังสือ">
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
                                            <label for="datepicker">เอกสารลงวันที่ :</label><input class="form-control" type="text" name="datepicker"  id="datepicker" >
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
                                            <label for="practice">ผู้ปฏิบัติ</label>
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
    <!-- Modal -->
        <div  class="modal fade bs-example-modal-table" tabindex="-1" aria-hidden="true" role="dialog">
        <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header alert-info">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"><i class="fa fa-info"></i> รายละเอียด</h4>
            </div>
            <div class="modal-body no-padding">
                <div id="divDataview"></div>     <!-- สวนสำหรับแสดงผลรายละเอียด   อ้างอิงกับไฟล์  show_command_detail.php -->
            </div> <!-- modal-body -->
            <div class="modal-footer alert-info">
            <button type="button" class="btn btn-danger" data-dismiss="modal">X</button>
            </div>
        </div>
        </div>
    </div>
    </div>
<?php //include "footer.php"; ?>

    <?php
    if(isset($_POST['save'])){   //กดปุ่มบันทึกจากฟอร์มบันทึก
    //$yid=$_POST['yid'];
    $uid=$_POST['u_id'];
    $obj_id=$_POST['obj_id'];
    $typeDoc=$_POST['typeDoc'];
    $prefex=$_POST['prefex'];
    $title=$_POST['title'];
    $speed_id=$_POST['speed_id'];
    $sec_id=$_POST['sec_id'];
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
  
    //check year
    $sqlYear="select * from sys_year where status=1";
    $resYear=  mysqli_query($conn, $sqlYear);
    $rowYear= mysqli_num_rows($resYear);
    $rowData=  mysqli_fetch_array($resYear);
    $yid=$rowData[0];
    if($rowYear==0){
        echo "<script>swal(\"ระบบจัดการปีปฏิทินมีปัญหา  ติดต่อ Admin!\") </script>";
        echo "<meta http-equiv='refresh' content='1;URL=flow-normal.php'>";
    }else{
           //ตัวเลขรันอัตโนมัติ
            $sqlRun="SELECT cid,rec_no FROM flowrecive  ORDER  BY cid DESC";
            $resRun=  mysqli_query($conn, $sqlRun);
            $rowRun= mysqli_fetch_array($resRun);
            $rec_no=$rowRun['rec_no'];
            $rec_no++;
            
        $sqlInsert="INSERT INTO flowrecive
                         (rec_no,u_id,obj_id,yid,typeDoc,prefex,title,speed_id,sec_id,sendfrom,sendto,refer,attachment,practice,file_location,dateline,dateout,follow,open,file_upload)    
                    VALUE($rec_no,$u_id,$obj_id,$yid,'$typeDoc','$prefex','$title',$speed_id,$sec_id,'$sendfrom','$sendto','$refer','$attachment','$practice','$file_location','$dateline','$datelout',$follow,$open,'$newname')";
        //echo $sqlInsert;
        $SQL=mysqli_query($conn, $sqlInsert);
   
    
    echo "<meta http-equiv='refresh' content='1;URL=flow-resive.php'>";
    
    echo "<script>swal(\"Good job!\", \"บันทึกข้อมูลเรียบร้อยแล้ว\", \"success\")</script>";
    if(!$SQL){
        echo $conn->error;
    }
  } 
}

if(isset($_POST['update'])){
            $cid=$_POST['cid'];
            $fileupload=$_REQUEST['fileupload'];  //การจัดการ fileupload
            $date=date('Y-m-d');
            $numrand=(mt_rand()); //สุ่มตัวเลข
            $upload=$_FILES['fileupload']; //เพิ่มไฟล์
        if($upload<>''){
            $part="recive/";   //โฟลเดอร์เก็บเอกสาร
            $type=  strrchr($_FILES['fileupload']['name'],".");   //เอาชื่อเก่าออกให้เหลือแต่นามสกุล
            $newname=$date.$numrand.$type;   //ตั้งชื่อไฟล์ใหม่โดยใช้เวลา
            $part_copy=$part.$newname;
            $part_link="recive/".$newname;
            move_uploaded_file($_FILES['fileupload']['tmp_name'],$part_copy);  //คัดลอกไฟล์ไป Server
            
            $sqlUpdate="UPDATE flowrecive SET file_upload='$part_copy' WHERE cid=$cid";
            //print $sqlUpdate;
            $resUpdate=  mysqli_query($conn, $sqlUpdate);
            if(!$resUpdate){
                echo "ระบบมีปัญหา";
                exit;
            }else{
              echo "<script>window.alert(\"ระบบบันทึกข้อมูลเรียบร้อยแล้ว ;)\");</script>";             
              echo "<meta http-equiv='refresh' content='1;URL=flow-resive.php'>";  
            }
        }
}  
?>



<script type="text/javascript">
function load_leave_data( u_id, cid) {
                    var sdata = {
                      u_id: u_id,
                      cid: cid
                    };
                    $('#divDataview').load('show_resive_detail.php', sdata);
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