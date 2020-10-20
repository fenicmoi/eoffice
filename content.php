 <link rel="stylesheet" href="css/note.css">
<div class="row">
    <div class="col-md-12">
         <div id="myCarousel" class="carousel slide" data-ride="carousel">
            <!-- Indicators -->
            <ol class="carousel-indicators">
                <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                <li data-target="#myCarousel" data-slide-to="1"></li>
            </ol>
            <!-- Wrapper for slides -->
            <div class="carousel-inner">
                <div class="item active">
                <img height="400" src="images/office2.jpg" alt="Los Angeles">
                </div>
                <div class="item">
                <img src="images/office3.jpg" alt="Chicago">
                </div>
            </div>
            <!-- Left and right controls -->
            <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#myCarousel" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
</div>
<!--
<div class="row bg-info">
    <div class="col-md-2">
       <center>
       <a href="#" data-toggle="modal" data-target="#modelRule"><i class="far fa-handshake fa-10x"></i>
            <h4>ข้อตกลงการใช้งานเบื้องต้น</h4>
       </a>
       </center>
   </div>
   <div class="col-md-2">
       <center>
       <a href="list_user.php"><i class="fab fa-earlybirds fa-10x"></i>
            <h4>รายชื่อหน่วยงาน/admin</h4>
       </a>
       </center>
   </div>
    <div class="col-md-2">
       <center>
       <a  data-toggle="modal" data-target="#modalAdd"><i class="fab fa-fort-awesome fa-10x"></i>
            <h4>ลงทะเบียนหน่วยงาน</h4>
       </a>
       </center>
   </div>
   <div class="col-md-2">
       <center>
       <a  data-toggle="modal" data-target="#modalRegister"><i class="fas fa-user fa-10x"></i>
            <h4>ลงทะเบียนผู้ใช้งาน</h4>
       </a>
       </center>
   </div>
   <div class="col-md-2">
       <center>
       <a href="admin/manual/manual-v1.pdf" target="_blank"><i class="fas fa-map-signs fa-10x"></i>
            <h4>คู่มือผู้ใช้</h4>
       </a>
       </center>
   </div>
   <div class="col-md-2">
       <center>
       <a href="#" target="_blank"><i class="fas fa-chart-pie fa-10x"></i>
            <h4>สถิติข้อมูล</h4>
       </a>
       User online <?php include_once "module/user-online.php"; ?>
       </center>
   </div>
</div>
-->
<?php
    $sql="SELECT 
            COUNT(IF(type_id=1,1,null)) AS c1,
            COUNT(IF(type_id=2,1,null)) AS c2,
            COUNT(IF(type_id=3,1,null)) AS c3,
            COUNT(IF(type_id=4,1,null)) AS c4,
            COUNT(IF(type_id=5,1,null)) AS c5,
            COUNT(IF(type_id>4,1,null)) AS c6
        FROM depart";
        //print $sql;
        $result=dbQuery($sql);
        $row=dbFetchArray($result);
        $c1=$row['c1'];
        $c2=$row['c2'];
        $c3=$row['c3'];
        $c4=$row['c4'];
        $c5=$row['c5'];
        $c6=$row['c6'];
        $sum=$c1+$c2+$c3+$c4+$c5+$c6;
?>
<div class="row">
 <div class="col-md-4">
    <div class="quote-container">
    <i class="pin"></i>
    <blockquote class="note yellow">
        <i class="fas fa-chat"></i> <kbd>แจ้งเปิดใช้งานระบบใหม่</kbd> <br>
            <ol>
                <li>ระบบออกเลขคำสั่งจังหวัด</li>
                <li>ระบบออกเลขสัญญาซื้อขาย/สัญญาจ้างจังหวัด</li>
                <li>ระบบออกเลขทะเบียนส่งจังหวัด(ธรรมดา/เวียน)</li>
            </ol>
             
         <cite class="author">สำนักงานจังหวัดพัทลุง</cite>
    </blockquote>
    </div>
</div>
<div class="col-md-4">
    <div class="quote-container">
    <i class="pin"></i>
    <blockquote class="note yellow">
        <i class="fas fa-chat"></i> <kbd>Username & Password</kbd> <br>
            ท่านสามารถใช้งาน Username และ Password เดิมเพื่อเข้าสู่ระบบที่เปิดให้บริการ
             
         <cite class="author">Administrator</cite>
    </blockquote>
    </div>
 </div>
 <div class="col-md-4">
    <div class="quote-container">
    <i class="pin"></i>
    <blockquote class="note yellow">
        <i class="fas fa-chat"></i><kbd>Module ระบบจองห้องประชุม</kbd> <br>
           สนจ.พท  ได้ดำเนินการปรับปรุงระบบการจองห้องประชุม  โดยมีลำดับขั้นตอนดังนี้
           <ol>
                <li>ดาวน์โหลดเอกสารคำขออนุัติการใช้ห้องประชุมเพื่อกรอกรายละเอียด (ดาวน์โหลดได้หลังจาก login)</li>
                <li>เข้าสู่ระบบ ไปที่ระบบการจองห้องประชุม</li>
                <li>บันทึกข้อมูลการจอง <kbd>พร้อมแนบไฟล์ตามข้อ 1</kbd>เข้าสู่ระบบ</li>
                <li>ติดตามผลการอนุมัติ</li>
           </ol>
         <cite class="author">สำนักงานจังหวัดพัทลุง</cite>
    </blockquote>
    </div>
 </div>
</div> <!-- row  note -->

    <!-- <div class="well"><center><h3><span class="fas fa-chart-area fa-2x">สถิติข้อมูล</span></h3></center></div> -->
                    <!-- <div class="row">
                        <div class="col-md-6">
                            <div id="depart" style="width: 700px; height: 350px;"></div>
                            <script type="text/javascript" src="js/chart/loader.js"></script>
                            <script type="text/javascript">
                            // Load google charts
                            google.charts.load('current', {'packages':['corechart']});
                            google.charts.setOnLoadCallback(drawChart);

                            // Draw the chart and set the chart values
                            function drawChart() {
                            var data = google.visualization.arrayToDataTable([
                            ['Task', 'Hours per Day'],
                            ['ส่วนกลาง', <?=$c1?>],
                            ['ส่วนภูมิภาค', <?=$c2?>],
                            ['ส่วนท้องถิ่น', <?=$c3?>],
                            ['รัฐวิสาหกิจ', <?=$c4?>],
                            ['อื่น',<?=$c5?>]
                            ]);

                            // Optional; add a title and set the width and height of the chart
                            var options = {
                                title: 'ส่วนราชการ',
                                pieHole: 0.4,
                            };


                            // Display the chart inside the <div> element with id="piechart"
                            var chart = new google.visualization.PieChart(document.getElementById('depart'));
                            chart.draw(data, options);
                            }
                            </script>
                        </div>
                        <?php /*
                        $sql="SELECT 
                                COUNT(IF(level_id=1,1,null)) AS c1,
                                COUNT(IF(level_id=2,1,null)) AS c2,
                                COUNT(IF(level_id=3,1,null)) AS c3,
                                COUNT(IF(level_id=4,1,null)) AS c4,
                                COUNT(IF(level_id=5,1,null)) AS c5
                            FROM user";

                        $result=dbQuery($sql);
                        $row=dbFetchArray($result);
                        $c1=$row['c1'];
                        $c2=$row['c2'];
                        $c3=$row['c3'];
                        $c4=$row['c4'];
                        $c5=$row['c5'];
                        $sum=$c1+$c2+$c3+$c4+$c5;
                        */
                        ?>
                         <div class="row">
                        <div class="col-md-6">
                            <div id="piechart"></div>
                         
                            <script type="text/javascript">
                            // Load google charts
                            google.charts.load('current', {'packages':['corechart']});
                            google.charts.setOnLoadCallback(drawChart);

                            // Draw the chart and set the chart values
                            function drawChart() {
                            var data = google.visualization.arrayToDataTable([
                            ['Task', 'Hours per Day'],
                            ['ผู้ดูแลระบบ', <?//=$c1?>],
                            ['สารบรรณจังหวัด', <?//=$c2?>],
                            ['สารบรรณหน่วยงาน', <?//=$c3?>],
                            ['สารบรรณกลุ่ม', <?//=$c4?>],
                            ['ผู้ใช้ทั่วไป',<?//=$c5?>]
                            ]);

                            // Optional; add a title and set the width and height of the chart
                            var options = {'title':'สัดส่วนผู้ใช้งาน', 'width':550, 'height':400};

                            // Display the chart inside the <div> element with id="piechart"
                            var chart = new google.visualization.PieChart(document.getElementById('piechart'));
                            chart.draw(data, options);
                            }
                            </script>
                        </div>
                    </div> -->
<!-- <div class="row">
    <div class ="col-md-4 bg-danger ">
        <center><div id="piechart" style="width: 450px; height: 250px;"></div></center>
    </div>
</div> -->
 <!-- Model -->
            <!-- เพิ่มผู้ใช้ -->
            <div id="modalRegister" class="modal fade" role="dialog" >
              <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title "><i class="fa fa-user fa-2x"></i> ลงทะเบียนผู้ใช้งานทั่วไป</h4>
                  </div>
                  <div class="modal-body">
                      <div class="alert alert-warning">
                          <i class="fas fa-bomb fa-2x"></i><h4>หลังจากลงทะเบียนแล้ว  ให้ติดต่อ Admin ประจำหน่วยงานของท่าน</h4>
                      </div>
                      <form name="form" method="post">
                          <div class="form-group"> 
                                <div class ="input-group">
                                    <span class="input-group-addon">ประเภทส่วนราชการ : </span>
                                    <span id="province">
                                        <select class="form-control" required>
                                            <option value="">- เลือกประเภทส่วนราชการ -</option>
                                        </select>
                                    </span>
                                </div>
                          </div>
                          <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">ชื่อส่วนราชการ : </span>
                                    <span id="amphur">
                                        <select class="form-control" required>
                                            <option value=''>- เลือกหน่วยงาน -</option>
                                        </select>
                                    </span>
                                </div>
                          </div>
                          <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">ชื่อกลุ่มงาน/สาขา : </span>
                                    <span id="district">
                                         <select name="sec_id" class="form-control" required>
                                        <option value=''>- เลือกกลุ่มงาน -</option>
                                            <?php
                                                $sql="SELECT * FROM section WHERE dep_id=$dep_id";
$result= dbQuery($sql);
while ($rowSec = dbFetchArray($result)){
	?>
                                                    <option value='<?php print $rowSec['sec_id'];
?>'><?php print $rowSec['sec_name'];
?></option>
                                        <?php
}
?>
                                        </select>
                                    </span>
                                </div>
                          </div>
                            <div class="form-group col-sm-6">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fas fa-star"></i></span>
                                    <input class="form-control" type="text" name="firstname" id="firstname" placeholder="ชื่อ (ไม่ต้องมีคำนำหน้า)"  required="">
                                </div>
                            </div>
                            <div class="form-group col-sm-6">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fas fa-star"></i></span>
                                   <input class="form-control" type="text" name="lastname" id="lastname" placeholder="นามสกุล"  required>
                               </div>
                          </div>
                          <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fab fa-black-tie"></i></span>
                                    <input class="form-control" type="text" name="position" id="position" placeholder="ตำแหน่ง"  required >
                              </div>
                          </div>
                           <div class="form-group col-sm-6">
                                <div class="input-group">
                                  <span class="input-group-addon"><i class="fas fa-user-secret"></i></span>
                                  <input class="form-control" type="text"  name="u_name" id="u_name"  required placeholder="ระบุชื่อผู้ใช้ (อังกฤษ+ตัวเลข">
                              </div>
                           </div>
                           <div class="form-group col-sm-6">
                                <div class="input-group">
                                  <span class="input-group-addon"><i class="fas fa-key"></i></span>
                                  <input class="form-control" type="text" name="u_pass" id="u_pass"  required placeholder="ระบุรหัสผ่าน (อังกฤษ+ตัวเลข)">
                              </div>
                          </div> 
                          <div class="form-group col-sm-6">
                                <div class="input-group">
                                  <span class="input-group-addon"><i class="fas fa-envelope-square"></i></span>
                                  <input class="form-control" type="email" name="email" id="email" placeholder="อีเมลล์" required>
                              </div>
                          </div>
                          <div class="form-group col-sm-6">
                                <div class="input-group">
                                  <span class="input-group-addon"><i class="far fa-calendar-alt"></i></span>
                                  <input class="form-control" type="text" name="date_user" id="date_user" value="<?php echo date('Y-m-d');
?>">
                              </div>
                          </div>
                           <center>
                           <button class="btn btn-success btn-lg" type="submit" name="save">
                                <i class="fa fa-database fa-2x"></i> บันทึก
                                <input id="u_id" name="u_id" type="hidden" value="<?php echo $u_id;
?>"> 
                            </button>
                            </center>
                     </form>
                  </div>
                  <div class="modal-footer bg-primary">
                      <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i></button>
                  </div>
                </div>
              </div>
            </div>
            <!-- End Model --> 
<?php 
if(isset($_POST['save'])){
	
	
	$type_id=$_POST['province'];
	
	$dep_id=$_POST['amphur'];
	
	$sec_id=$_POST['district'];
	
	$level_id=5;
	$u_name=$_POST['u_name'];
	$u_pass=$_POST['u_pass'];
	$firstname=$_POST['firstname'];
	$lastname=$_POST['lastname'];
	$position=$_POST['position'];
	$date_create=$_POST['date_user'];
	$email=$_POST['email'];
	
	// 	print $sql;
	$sql="SELECT u_name FROM user WHERE u_name='".trim($u_name)."'";
	//p	rint $sql;
	
	$result= dbQuery($sql);
	$numrow= dbNumRows($result);
	if($numrow>=1){
		echo "<script>
               swal({
                title:'ไม่สามารถใช้ชื่อนี้ได้!..กรุณาเปลี่ยนใหม่นะครับ',
                type:'error',
                showConfirmButton:true
                },
                function(isConfirm){
                    if(isConfirm){
                        window.location.href='index.php';
                    }
                }); 
              </script>";
	}
	elseif($numrow<1){
		$sql="INSERT INTO user(sec_id,dep_id,level_id,u_name,u_pass,firstname,lastname,position,date_create,status,email)
                   VALUES ($sec_id,$dep_id,$level_id,'$u_name','$u_pass','$firstname','$lastname','$position','$date_create',0,'$email')";
		//echo $sql;
		$result=  dbQuery($sql);
		if(!$result){
			echo "<script>
            swal({
             title:'มีบางอย่างผิดพลาด',
             text: 'กรุณาตรวจสอบข้อมูลก่อนส่งอีกครั้ง!',
             type:'warning',
             showConfirmButton:true
             },
             function(isConfirm){
                 if(isConfirm){
                     window.location.href='index.php';
                 }
             }); 
           </script>";
		}
		else{
			echo "<script>
            swal({
             title:'ลงทะเบียนเรียบร้อยแล้ว',
              text: 'กรุณาติดต่อเจ้าหน้าที่สารบรรณประจำหน่วยงานเพื่อเปิดการใช้งาน',
             type:'success',
             showConfirmButton:true
             },
             function(isConfirm){
                 if(isConfirm){
                     window.location.href='index.php';
                 }
             }); 
           </script>";
		}
	}
	// 	user duplicate
}
//send
?>
<script language=Javascript>   //ส่วนการทำ dropdown
        function Inint_AJAX() {
           try { return new ActiveXObject("Msxml2.XMLHTTP");  } catch(e) {} //IE
           try { return new ActiveXObject("Microsoft.XMLHTTP"); } catch(e) {} //IE
           try { return new XMLHttpRequest();          } catch(e) {} //Native Javascript
           alert("XMLHttpRequest not supported");
           return null;
        };
        function dochange(src, val) {
             var req = Inint_AJAX();
             req.onreadystatechange = function () { 
                  if (req.readyState==4) {
                       if (req.status==200) {
                            document.getElementById(src).innerHTML=req.responseText; //รับค่ากลับมา
                       } 
                  }
             };
             req.open("GET", "admin/localtion.php?data="+src+"&val="+val); //สร้าง connection
             req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;charset=utf-8"); // set Header
             req.send(null); //ส่งค่า
        }
        window.onLoad=dochange('province', -1);     
</script>
<script type='text/javascript'>
       $('#tableCheck').DataTable( {
	"order": [[ 0, "desc" ]]
}
)
</script> 
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {
	'packages':['corechart']
}
);
google.charts.setOnLoadCallback(drawChart);
function drawChart() {
	var data = google.visualization.arrayToDataTable([
	          ['Task', 'Hours per Day'],
	          ['ส่วนกลาง',     <?php echo $dep1;
?>],
          ['ส่วนภูมิภาค',      <?php echo $dep2;
?>],
          ['ส่วนท้องถิ่น',      <?php echo $dep3;
?>],
          ['อื่นๆ',      <?php echo $dep4;
?>],
        ]);
        var options = {
          title: 'ผู้ใช้งานทั้งหมด'
        };
        var chart = new google.visualization.PieChart(document.getElementById('piechart'));
        chart.draw(data, options);
      }
</script>
