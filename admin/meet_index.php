<?php
include "header.php"; 
//$yid=chkYearMonth();  //return   ปี พ.ศ.
$u_id=$_SESSION['ses_u_id'];
$level_id=$_SESSION['ses_level_id'];
?>
<?php
$monthname=array("มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
$curDay = date("j");   //day  01,02,03
$curMonth = date("n");   //month 01-12
$curYear = date("Y")+543;  //year chang to pudda  2559
$year=date("Y");  // year cris
	
$today="$curDay-$curMonth-$curYear";
@$startdate=$_GET['startdate'];
        
?>

<? if ($curMonth== '1') { $showmonth = 'มกราคม' ;} ?>
<? if ($curMonth== '2') { $showmonth = 'กุมภาพันธ์' ;} ?>
<? if ($curMonth== '3') { $showmonth = 'มีนาคม' ;} ?>
<? if ($curMonth== '4') { $showmonth = 'เมษายน' ;} ?>
<? if ($curMonth== '5') { $showmonth = 'พฤษภาคม' ;} ?>
<? if ($curMonth== '6') { $showmonth = 'มิถุนายน' ;} ?>
<? if ($curMonth== '7') { $showmonth = 'กรกฏาคม' ;} ?>
<? if ($curMonth== '8') { $showmonth = 'สิงหาคม' ;} ?>
<? if ($curMonth== '9') { $showmonth = 'กันยายน' ;} ?>
<? if ($curMonth== '10') { $showmonth = 'ตุลาคม' ;} ?>
<? if ($curMonth== '11') { $showmonth = 'พฤศจิกายน' ;} ?>
<? if ($curMonth== '12') { $showmonth = 'ธันวาคม' ;} ?>

<? $today="$curDay $showmonth $curYear"; ?>
    <div class="row">
        <div class="col-md-2" >
             <?php
                 $menu=  checkMenu($level_id);
                 include $menu;
             ?>
        </div>  <!-- col-md-2 -->
        <div class="col-md-10">
            <div class="panel panel-primary" style="margin: 10">
                <div class="panel-heading"><i class="fas fa-calendar fa-2x"></i>   <strong>ปฏิทินการใช้ห้องประชุม</strong>
                    <a class="btn btn-default pull-right" href="#" 
                        onClick="loadReserve('<?php echo $u_id; ?>','<?php echo $level_id;?>');" 
                        data-toggle="modal" data-target=".modal-reserv">
                        <i class="fas fa-plus"></i> จองห้องประชุม
                    </a>
                    <a class="btn btn-default pull-right" href="meet_room_user.php">
                        <i class="fas fa-info"></i> ดูห้องประชุม
                    </a>
                     <a class="btn btn-danger pull-right" href="meet_history.php">
                        <i class="fas fa-history"></i> ยกเลิกใช้ห้อง
                    </a>
                    <a  class="btn btn-default pull-right" href="doc/form_meeting.pdf" target="_blank">
                        <i class="fab fa-wpforms"></i> แบบขออนุมัติ
                    </a>

                </div> 
                <?php include "calendar.php";?>
                <?php include "meet_listFront.php";?>
            <div>
        </div> <!-- col-md- -->
    </div>    <!-- end row  -->

    <!--  modal แสงรายละเอียดข้อมูล -->
        <div  class="modal fade modal-reserv" tabindex="-1" aria-hidden="true" role="dialog">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"><i class="fa fa-info"></i> รายละเอียด</h4>
                    </div>
                    <div class="modal-body no-padding">
                        <div id="divReserv"></div>     
                    </div> <!-- modal-body -->
                    <div class="modal-footer bg-primary">
                         <button type="button" class="btn btn-danger" data-dismiss="modal">ปิด X</button>
                    </div>
                </div>
            </div>
        </div>
<!-- จบส่วนแสดงรายละเอียดข้อมูล  -->

<?php 
// ส่วนตรวจสอบและบันทึกข้อมูล
if(isset($_POST['save_reserv'])){

	$subject=$_POST['subject'];      
	$head=$_POST['head'];     
	$numpeople=$_POST['numpeople'];  
	$room_id=$_POST['room_id'];      
	$startdate=$_POST['startdate'];    
	$starttime=$_POST['starttime'];        
    $endtime=$_POST['endtime'];       
    $bookingdate= date("Y-m-d");
    $conf_status=1;
    $catgory=$_POST['catgory'];

    //่ส่วนสลับวันที่วันประชุม
    list($year, $month, $day) = preg_split('[-]', $startdate);    //นำมาแยก ปี-เดือน-วัน
    $date = "$day-$month-$year";

    //ส่วนแปลงวันที่ประชุม
    $expire_explode = explode("-", $startdate);
	$expire_year = $expire_explode[0];
	$expire_month = $expire_explode[1];
	$expire_day = $expire_explode[2];

    //ส่วนแปลงวันที่ปัจจุบัน
	$today_explode = explode("-", date("Y-m-d"));
	$today_year = $today_explode[0];
	$today_month = $today_explode[1];
	$today_day = $today_explode[2];   // [2]

    //ส่วนใช้เปรียบเทียบค่าของวันที่มากกว่าน้อยกว่า
    $expire = gregoriantojd($expire_month,$expire_day,$expire_year);
    $today = gregoriantojd($today_month,$today_day,$today_year);

    $sql = "SELECT * FROM meeting_room WHERE room_id = $room_id";
    $result = dbQuery($sql);
    $row = dbFetchArray($result);

    
    $sql1 = "";
  
    //ความจุห้องประชุม
    if($numpeople > $row['roomcount']){         //เช็คจำนวนผู้เข้าประชุม
         over_limit();
    }else{  //ถ้าจำนวนผู้ประชุมถูกต้อง
        if ($expire < $today) {   //ป้องกันเลือกวันที่ย้อนหลัง
            day_history();
        }else{  //กรณีวันถูกต้องแล้ว
            list($hour, $minute) = preg_split('[:]',$starttime);    //แยกเวลาเริ่มประชุม ชั่วโมง นาที
            $starttime = "$hour:$minute";

            list($hour, $minute) = preg_split('[:]',$endtime);      //แยกเวลาสิ้นสุดประชุม  ชั่วโมง:นาที
            $endtime = "$hour:$minute";

            if($starttime > $endtime){
                 time_rang();
            }else{  //ตรวจสอบห้องประชุมที่เลือก
                $sql = "SELECT * FROM meeting_booking WHERE startdate ='$startdate' AND room_id='$room_id'";
                $result = dbQuery($sql);
                $numrow = dbNumRows($result);

                if($numrow == 0){  //ถ้าไม่มีการจองห้องประชุมเลย
                    if(!empty($_FILES)){            //ตรวจสอบไฟล์ upload
                        $name = $_FILES['fileUpload']['name'];
                        $tmp = $_FILES['fileUpload']['tmp_name'];
                            if(strlen($name)){
                                list($txt, $ext) = explode(".", $name);
                                $filename  = date("Ymdhis");
                                $filename = $filename."-".rand(1,1000);
                                $fileupload = $filename.".".$ext;       //ชื่อไฟล์ใหม่ที่ได้
      
                                if(move_uploaded_file($tmp,"form-meeting/".$fileupload)){
                                    
                                    $sql = "INSERT INTO meeting_booking(subject,head,numpeople,room_id,startdate,starttime,endtime,bookingdate,user_id,conf_status,dep_id,catgory,fileupload)
                                            VALUES('$subject','$head',$numpeople,$room_id,'$startdate','$starttime','$endtime','$bookingdate',$u_id,$conf_status,$dep_id,$catgory,'$fileupload') ";
                                  
                                
                                   $result=dbQuery($sql);
                                    if($result){
                                        success();
                                    }else{
                                        nosuccess();
                                    }
                                }  //upload file
                             }//strlen
                    } // file  
               }else if($numrow <> 0){    //ถ้ามีนี้มีการใช้  ให้เชคต่อไปว่าเวลาตรงกันหรือไม่
                    $sql = "SELECT MIN(starttime) as st,MAX(endtime) as et FROM meeting_booking WHERE startdate ='$startdate'AND room_id='$room_id'";
                    $result = dbQuery($sql);
                    while ($row = dbFetchArray($result)) {
                        $st = $row['st'];  //เวลาเริ่มประชุม
                        $et = $row['et'];  //เวลาสิ้นสุดการประชุม

                        $sql2 = "SELECT * FROM meeting_booking           
								 WHERE startdate='$startdate'           
								 AND room_id='$room_id'                
								 AND ('$starttime' BETWEEN '$st' and '$et')
                                 AND ('$endtime' BETWEEN '$st' and '$et')
                                 AND (conf_status >=1)";

                        $dbquery2 = dbQuery($sql2);
                        $numrows = dbNumRows($dbquery2);
                        //print $numrows;

                        if ($numrows <> 0) {
                            reserve();
                        }elseif($numrows == 0){
                            if(!empty($_FILES)){            //ตรวจสอบไฟล์ upload
                                $name = $_FILES['fileUpload']['name'];
                                $tmp = $_FILES['fileUpload']['tmp_name'];
                                    if(strlen($name)){
                                        list($txt, $ext) = explode(".", $name);
                                        $filename  = date("Ymdhis");
                                        $filename = $filename."-".rand(1,1000);
                                        $fileupload = $filename.".".$ext;       //ชื่อไฟล์ใหม่ที่ได้
                            
                                        if(move_uploaded_file($tmp,"form-meeting/".$fileupload)){
                                            $sql = "INSERT INTO meeting_booking(subject,head,numpeople,room_id,startdate,starttime,endtime,bookingdate,user_id,conf_status,dep_id,catgory,fileupload)
                                                    VALUES('$subject','$head',$numpeople,$room_id,'$startdate','$starttime','$endtime','$bookingdate',$u_id,$conf_status,$dep_id,$catgory,'$fileupload')";
                                           
                                           $result=dbQuery($sql);
                                            if($result){
                                                success();
                                            }else{
                                                 nosuccess();
                                            }
                                        }  //upload file
                                    }//strlen
                            } // file
                        }
                    }  //end while    
               } //ตรวจสอบว่าห้องประชุมว่างตามช่วงเวลาดังกล่าวหรือไม่
            } //ป้องกันเลือกเวลาผิด  
        } //ป้องกันเลือกวันย้อนหลัง
    } // ผู้เข้าประชุม
}//check button
?>

<script>
function loadReserve(u_id,level_id) {
    var sdata = {
        u_id : u_id,
        level_id : level_id
    };
$('#divReserv').load('meet_reserv.php',sdata);
}

</script>

<?php  
    function success(){
        echo "<script>
                swal({
                    title:'จองห้องเรียบร้อยแล้ว',
                    text:'ติดตามผลการอนุมัติต่อไป',
                    type:'success',
                    showConfirmButton:true
                },
                function(isConfirm){
                    if(isConfirm){
                        window.location.href='meet_index.php';
                    }
                }); 
            </script>";
    }

    function over_limit(){
          echo "<script>
        swal({
            title:'เกินความจุห้องประชุม',
            text:'กรุณาเลือกห้องประชุมที่เหมาะสม หากยืนยันจะใช้ ให้ระบุตัวเลขผู้เข้าร่วมไม่เกินความจุห้องประชุม',
            type:'warning',
            showConfirmButton:true
            },
            function(isConfirm){
                if(isConfirm){
                    window.location.href='meet_index.php';
                }
            }); 
        </script>";
    }

    function day_history(){
         echo"<script>
            swal({
                title:'คุณเลือกวันย้อนหลัง',
                text:'กรุณาตรวจสอบ',
                type:'warning',
                showConfirmButton:true
                },
                function(isConfirm){
                    if(isConfirm){
                        window.location.href='meet_index.php';
                    }
                }); 
            </script>";
    }

    function time_rang(){
        echo"<script>
                    swal({
                        title:'ระบุเวลาช่วงประชุมผิด',
                        text:'กรุณาตรวจสอบเวลาเริ่ม-เลิก ประชุม ',
                        type:'warning',
                        showConfirmButton:true
                        },
                        function(isConfirm){
                            if(isConfirm){
                                window.location.href='meet_index.php';
                            }
                        }); 
                    </script>";
    }

    function no_success(){
         echo "<script>
                                            swal({
                                                title:'ไม่สำเร็จ',
                                                text:'มีบางอย่างผิดพลาด กรุณาลองใหม่อีกครั้ง',
                                                type:'warning',
                                                showConfirmButton:true
                                                },
                                                function(isConfirm){
                                                    if(isConfirm){
                                                        window.location.href='meet_index.php';
                                                    }
                                                }); 
                                            </script>";
    }

    function reserve(){
        echo"<script>
                                swal({
                                    title:'ห้องประชุมไม่ว่างในช่วงเวลาดังกล่าว',
                                    text:'อาจอยู่ระหว่างติดจอง/รออนุมัติ  กรุณาตรวจสอบ',
                                    type:'warning',
                                    showConfirmButton:true
                                    },
                                    function(isConfirm){
                                        if(isConfirm){
                                            window.location.href='meet_index.php';
                                        }
                                    }); 
                                </script>";
    }

?>