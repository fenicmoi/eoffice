
<!--  ทะเบียนคุมสัญญาจ้าง -->
<?php
include "header.php"; 
$yid=chkYearMonth();
$u_id=$_SESSION['ses_u_id'];
?>
<?php
$monthname=array("มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
	$curDay = date("j");   //day  01,02,03
	$curMonth = date("n");   //month 01-12
	$curYear = date("Y")+543;  //year chang to pudda  2559
	$year=date("Y");
	
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
        <div class="col-md-12">
            <div class="panel panel-primary" style="margin: 10">
                <div class="panel-heading"><i class="fas fa-calendar fa-2x"></i>   <strong>ปฏิทินการใช้ห้องประชุม</strong>
                    <a class="btn btn-default pull-right" href="#" 
                        onClick="loadReserve('<?php echo $u_id; ?>');" 
                        data-toggle="modal" data-target=".modal-reserv">
                        <i class="fas fa-plus"></i> จองห้องประชุม
                    </a>
                    <a class="btn btn-default pull-right" href="meet_room_user.php">
                        <i class="fas fa-info"></i> ดูห้องประชุม
                    </a>
                     <a  class="btn btn-default pull-right" href="meet_history.php"> 
                        <i class="fas fa-history"></i> ประวัติการจอง
                    </a>
                    <a class="btn btn-default pull-right" href="doc/form.pdf" target="_blank">
                        <i class="fab fa-wpforms"></i> แบบขออนุมัติ
                    </a>
                    <a class="btn btn-default pull-right" href="doc/info.pdf" target="_blank">
                        <i class="fas fa-hand-holding-usd"></i> อัตราค่าตอบแทน
                    </a>
                </div> 
                <?php include "admin/calendar.php";?>
                <?php include "admin/meet_listFront.php";?>
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

    //ความจุห้องประชุม
    if($numpeople > $row['roomcount']){         //เช็คจำนวนผู้เข้าประชุม
        echo "<script>
        swal({
            title:'เกินความจุห้องประชุม',
            text:'จำนวนผู้เข้าประชุมเกินความจุ',
            type:'warning',
            showConfirmButton:true
            },
            function(isConfirm){
                if(isConfirm){
                    window.location.href='meet_index.php';
                }
            }); 
        </script>";
    }else{  //ถ้าจำนวนผู้ประชุมถูกต้อง
        if ($expire < $today) {   //ป้องกันเลือกวันที่ย้อนหลัง
        echo"<script>
            swal({
                title:'คุณเลือกวันย้อนหลัง',
                text:'มันต้องผิดแน่ๆ ',
                type:'warning',
                showConfirmButton:true
                },
                function(isConfirm){
                    if(isConfirm){
                        window.location.href='meet_index.php';
                    }
                }); 
            </script>";
        }else{  //กรณีวันถูกต้องแล้ว
            list($hour, $minute, $second) = preg_split('[:]',$starttime);
            $starttime = "$hour:$minute:$second";

            list($hour, $minute, $second) = preg_split('[:]',$endtime);
            $endtime = "$hour:$minute:$second";

            if($starttime > $endtime){
                 echo"<script>
                    swal({
                        title:'ระบุเวลาช่วงประชุมผิด',
                        text:'มันต้องผิดแน่ๆ ',
                        type:'warning',
                        showConfirmButton:true
                        },
                        function(isConfirm){
                            if(isConfirm){
                                window.location.href='meet_index.php';
                            }
                        }); 
                    </script>";
            }else{  //ตรวจสอบห้องประชุมที่เลือก
                $sql = "SELECT *
                        FROM meeting_booking
                        WHERE startdate ='$startdate'
                        AND room_id='$room_id'";
                $result = dbQuery($sql);
                $numrow = dbNumRows($result);
               // print $sql;
                //echo  "<br>";
               // print $numrow;
                
                if($numrow == 0){  //ถ้าไม่มีการจองห้องประชุมเลย
                    $sql="INSERT INTO  meeting_booking(subject,head,numpeople,room_id,startdate,starttime,endtime,bookingdate,user_id,conf_status,dep_id,catgory)
                          VALUES('$subject','$head',$numpeople,$room_id,'$startdate','$starttime','$endtime','$bookingdate',$u_id,$conf_status,$dep_id,$catgory)";
                    $result=dbQuery($sql);
                      echo"<script>
                                swal({
                                    title:'จองห้องเรียบร้อยแล้ว',
                                    text:'ติดตามผลการอนุมัติต่อไป',
                                    type:'warning',
                                    showConfirmButton:true
                                    },
                                    function(isConfirm){
                                        if(isConfirm){
                                            window.location.href='meet_index.php';
                                        }
                                    }); 
                                </script>";
               }elseif($numrow <> 0){
                  // MIN(starttime) as st,MAX(endtime) as et
                    $sql = "SELECT MIN(starttime) as st,MAX(endtime) as et FROM meeting_booking
                            WHERE startdate ='$startdate'
                            AND room_id='$room_id'";
                    $result = dbQuery($sql);
                    while ($row = dbFetchArray($result)) {
                        $st = $row['st'];  //เวลาต่ำสุด 
                        $et = $row['et'];  //เวลาสูงสุด

                        $sql2 = "SELECT * FROM meeting_booking 
								 WHERE startdate='$startdate' 
								 AND room_id='$room_id' 
								 AND ('$starttime' BETWEEN '$st' and '$et') 
                                 OR ('$endtime' BETWEEN '$st' and '$et')";
                        //print $sql2;
                        $dbquery2 = dbQuery($sql2);
                        $numrows = dbNumRows($dbquery2);

                        if ($numrows <> 0) {
                            echo"<script>
                                swal({
                                    title:'ห้องประชุมไม่ว่าง',
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
                        }elseif($numrows == 0){
                             $sql="INSERT INTO  meeting_booking(subject,head,numpeople,room_id,startdate,starttime,endtime,bookingdate,user_id,conf_status,dep_id,catgory)
                                   VALUES('$subject','$head',$numpeople,$room_id,'$startdate','$starttime','$endtime','$bookingdate',$u_id,$conf_status,$dep_id,$catgory)";
                             $result=dbQuery($sql);
                            echo"<script>
                                swal({
                                    title:'จองห้องเรียบร้อยแล้ว',
                                    text:'ติดตามผลการอนุมัติต่อไป',
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
                    }  //end while 
               } //ตรวจสอบว่าห้องประชุมว่างตามช่วงเวลาดังกล่าวหรือไม่
            } //ป้องกันเลือกเวลาผิด
        } //ป้องกันเลือกวันย้อนหลัง
    } // ผู้เข้าประชุม
}//check button
?>

<script>
function loadReserve(u_id) {
    var sdata = {
        u_id : u_id
    };
$('#divReserv').load('meet_reserv.php',sdata);
}



</script>