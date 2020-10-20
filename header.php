<?php 
 include 'library/config.php';
 include 'library/database.php';

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="ระบบสารบรรณจังหวัดพัทลุง">
    <meta name="author" content="นายสมศักดิ์  แก้วเกลี้ยง">
    <link rel="icon" href="images/favicon.png">
    <title><?php echo $title ?></title>

    <!-- popup -->
    <link rel="stylesheet" href="css/popup.css">

<!-- Bootstrap -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link href="css/sticky-footer-navbar.css" rel="stylesheet">
    <link rel="stylesheet" href="css/loader.css"> 
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/text-hilight.js"></script>

    <link rel="stylesheet" href="css/fontawesome5.0.8/web-fonts-with-css/css/fontawesome-all.min.css">
    <link href="https://fonts.googleapis.com/css?family=Taviraj" rel="stylesheet">
    <link rel="stylesheet" href="css/sweetalert.css">
    <script src="js/sweetalert.min.js"></script>   
 

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
<!-- Chatra {literal} -->
<script>
    (function(d, w, c) {
        w.ChatraID = '8hztemC96qH6pieSE';
        var s = d.createElement('script');
        w[c] = w[c] || function() {
            (w[c].q = w[c].q || []).push(arguments);
        };
        s.async = true;
        s.src = 'https://call.chatra.io/chatra.js';
        if (d.head) d.head.appendChild(s);
    })(document, window, 'Chatra');
</script>
<!-- /Chatra {/literal} -->
<style>
  body{
    font-family: 'Taviraj', serif;
    height:100%;
  }
</style>

<!-- popup แสดงข่าวสารหน้าแรก-->

<script type="text/javascript">
/*
	$(document).ready(function(){
		$("#popupModal").modal('show');
	});
  */
</script>
  </head>
  <body>
    <!-- Fixed navbar -->
    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="navbar-header">
           <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
           </button>
            <img src="images/logo.png" class="navbar-brand" height="80" width="80">
            <a class="navbar-brand" href="index.php"><?php echo $title;
?></a>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav ">
              <li><a class="nav-link active"  href="index.php"><i class="fas fa-home"></i> หน้าแรก</a></li>
              <!-- <li class="dropdown">
                <a class="btn disabled"  class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fas fa-users"></i> ระบบงานสารบรรณ
                <span class="caret"></span></a>
                <ul class="dropdown-menu">
                   <li><a   href="list_user.php"><i class="fas fa-check-circle"></i> ตรวจสอบส่วนราชการ/หน่วยงานที่ลงทะเบียน </a></li>
                  <li><a  data-toggle="modal" data-target="#modalAdd"><i class="fas fa-key"></i> ลงทะเบียนหน่วยงาน/เจ้าหน้าที่ </a></li>
                  <li><a   data-toggle="modal" data-target="#modalRegister"><i class="fas fa-users"></i> ลงทะเบียนผู้ใช้ทั่วไป </a></li>
                  <li><a href="admin/manual/manual-v1.pdf" target="_blank"><i class="fs fa-book"></i> คู่มือการใช้งาน</a></li>
                </ul>
              </li> -->
              <li><a class="btn-link"  href="flow-command-front.php"><i class="fas fa-retweet"></i> คำสั่งจังหวัด</a></li>
              <!-- <li><a class="btn disabled"   href="flow-command-front.php"><i class="fas fa-gavel"></i> ยุทธศาสตร์จังหวัด </a></li>
              <li class="dropdown">
                <a class="btn disabled"  class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fas fa-users"></i> ลงทะเบียน
                <span class="caret"></span></a>
                <ul class="dropdown-menu">
                   <li><a   href="list_user.php"><i class="fas fa-check-circle"></i> ตรวจสอบส่วนราชการ/หน่วยงานที่ลงทะเบียน </a></li>
                  <li><a  data-toggle="modal" data-target="#modalAdd"><i class="fas fa-key"></i> ลงทะเบียนหน่วยงาน/เจ้าหน้าที่ </a></li>
                  <li><a   data-toggle="modal" data-target="#modalRegister"><i class="fas fa-users"></i> ลงทะเบียนผู้ใช้ทั่วไป </a></li>
                  <li><a href="admin/manual/manual-v1.pdf" target="_blank"><i class="fs fa-book"></i> คู่มือการใช้งาน</a></li>
                </ul>
              </li> -->
              <li><a  class="btn disabled"  href="#" data-toggle="modal" data-target="#modelRule">ข้อตกลงการใช้งาน</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li><a class="btn btn-default"  data-toggle="modal" data-target="#myModal"><i class="fas fa-key"></i> เข้าสู่ระบบ </a></li>
            <li><i class="fas fa-key"></i></li>
          </ul>
    </nav>
        <!-- Modal -->
<div id="modelRule" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><i class="fas fa-info-circle"></i> ข้อตกลงการใช้งาน</h4>
      </div>
      <div class="modal-body">
        เรียนผู้ใช้งานระบบสำนักงานอัตโนมัติทุกท่าน  เพื่อให้ระบบสามารถทำงานได้อย่างมีประสิทธิภาพ จำเป็นต้องได้รับความร่วมมือจากเจ้าหน้าที่ผู้มีส่วนร่วมทุกท่านดังต่อไปนี้
        <ol>
          <li>ใช้โปรแกรม Web Browser <kbd>google chrome/firefox/opera/safari</kbd> เพื่อเข้าสู่ระบบเท่านั้น  </li>
          <li>เจ้าหน้าที่สารบรรณประจำหน่วยงาน <kbd>ต้องดำเนินการ</kbd> เพิ่มข้อมูลหน่อยงานย่อย (กลุ่ม/ฝ่าย/สาขา) ด้วยตนเอง ก่อนใช้งานระบบ</li>
          <li>กำหนดผู้ใช้งานเจ้าหน้าที่ระดับกลุ่มงานทุกกลุ่มงานอย่างน้อย 1 คน  ส่วนผู้ใช้ทั่วไปสามารถกำหนดได้ไม่จำกัด
          <li>เจ้าหน้าที่สารบรรณประจำหน่วยงาน <kbd>เข้าสู่ระบบวันละอย่างน้อย 2 ครั้ง   ครั้งที่ 1 เวลา 09:00 น  ครั้งที่ 2 เวลา 14:00 น </li>
        </ol>
      </div>
      <div class="modal-footer bg-primary">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal Login -->
        <div id="myModal" class="modal fade" role="dialog">
          <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><i class="fas fa-user-secret"></i>เข้าสู่ระบบ</h4>
              </div>
              <div class="modal-body">
                  <form method="post" action="checkUser.php">
                      <div class="input-group">
                          <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                          <input class="form-control" type="text" name="username" placeholder="username"  >
                      </div>
                      <br>
                      <div class="input-group">
                         <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                         <input class="form-control" type="password" name="password" placeholder="password"  >
                      </div>
                      <br>
                          <center><input type="submit" class="btn btn-success btn-lg" value="Login"/></center>
                  </form>
              </div>
              <div class="modal-footer bg-primary">
                <button type="button" class="btn btn-danger" data-dismiss="modal">X</button>
              </div>
            </div>
          </div>
        </div>
    <div class="container-fluse">
<!-- Modal Add -->
        <div id="modalAdd" class="modal fade" role="dialog">
          <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><i class="fas fa-smile text-waning"></i> แบบลงทะเบียนหน่วยงาน/เจ้าหน้าที่สารบรรณ</h4>
              </div>
              <div class="modal-body">
                  <form method="post">
                      <div class="panel-group" id="accordion">
                          <div class="panel panel-success">
                              <h4 class="panel-title">
                                  <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">ส่วนที่ 1 ข้อมูลหน่วยงาน </a>
                              </h4>
                          </div>
                          <div id="collapse1" class="panel-collapse collapse">
                              <div class="panel-body">
                                  <fieldset>
                                        <div class="form-group">
                                          <div class="input-group">
                                              <span class="input-group-addon">ชื่อส่วนราชการ/หน่วยงาน</span>
                                              <input class="form-control" type="text" name="depart" required>
                                          </div>
                                        </div>
                                        <div class="form-group">
                                          <div class="input-group">
                                              <span class="input-group-addon">เลขประจำส่วนราชการ</span>
                                              <input class="form-control" type="text" name="book_no" placeholder="ตัวอย่าง พง 0017.1" required >
                                          </div>
                                        </div>
                                        <div class="form-group">
                                          <div class="input-group">
                                              <span class="input-group-addon">ที่อยู่สำนักงาน</span>
                                              <input class="form-control" type="text" name="address" required>
                                          </div>
                                        </div>
                                        <div class="form-group">
                                          <div class="input-group">
                                              <span class="input-group-addon">เบอร์โทรศัพท์</span>
                                              <input class="form-control" type="text" name="o_tel" placeholder="ตัวอย่าง 0-7648-1421" required >
                                          </div>
                                        </div>
                                        <div class="form-group">
                                          <div class="input-group">
                                              <span class="input-group-addon">เบอร์โทรสาร</span>
                                              <input class="form-control" type="text" name="o_fax" placeholder="ตัวอย่าง 0-7648-1421" required >
                                          </div>
                                        </div>
                                        <div class="form-group">
                                          <div class="input-group">
                                              <span class="input-group-addon">Website</span>
                                              <input class="form-control" type="text" name="website" placeholder="ตัวอย่าง www.phangnga.go.th">
                                          </div>
                                        </div>
                                        <div class="form-group">
                                          <div class="input-group">
                                              <span class="input-group-addon">E-mail</span>
                                              <input class="form-control" type="email" name="email" placeholder="phangnga@moi.go.thg" required>
                                          </div>
                                        </div>
                                  </fieldset>
                              </div>
                          </div>
                           <div class="panel panel-default">
                              <h4 class="panel-title">
                                  <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">ส่วนที่ 2 ข้อมูลเจ้าหน้าที่สารบรรณประจำหน่วยงาน </a>
                              </h4>
                          </div>
                          <div id="collapse2" class="panel-collapse collapse">
                              <div class="panel-body">
                                  <fieldset>
                                        <div class="form-group">
                                          <div class="input-group">
                                              <span class="input-group-addon">ชื่อ</span>
                                              <input class="form-control" type="text" name="fname" required>
                                          </div>
                                        </div>
                                        <div class="form-group">
                                          <div class="input-group">
                                              <span class="input-group-addon">นามสกุล</span>
                                              <input class="form-control" type="text" name="lname" required >
                                          </div>
                                        </div>
                                        <div class="form-group">
                                          <div class="input-group">
                                              <span class="input-group-addon">ตำแหน่ง</span>
                                              <input class="form-control" type="text" name="position"  required >
                                          </div>
                                        </div>
                                        <div class="form-group">
                                          <div class="input-group">
                                              <span class="input-group-addon">เบอร์โทรศัพท์</span>
                                              <input class="form-control" type="text" name="tel" placeholder="ตัวอย่าง 0-7648-1421" required >
                                          </div>
                                        </div>
                                        <div class="form-group">
                                          <div class="input-group">
                                              <span class="input-group-addon">เบอร์โทรสาร</span>
                                              <input class="form-control" type="text" name="fax" placeholder="ตัวอย่าง 0-7648-1421" required >
                                          </div>
                                        </div>
                                        <div class="form-group">
                                          <div class="input-group">
                                              <span class="input-group-addon">username</span>
                                              <input class="form-control" type="text" name="username" placeholder="ประกอบด้วยตัวอักษรภาษาอังกฤษและตัวเลข 8 หลัก">
                                          </div>
                                        </div>
                                        <div class="form-group">
                                          <div class="input-group">
                                              <span class="input-group-addon">password</span>
                                              <input class="form-control" type="text" name="password" placeholder="ประกอบด้วยตัวอักษรภาษาอังกฤษและตัวเลข 8 หลัก" required>
                                          </div>
                                        </div>
                                  </fieldset>
                              </div>
                          </div>
                      </div>
                          <br>
                              <center><input type="submit"  name="add" class="btn btn-success btn-lg" value="ตกลง"/></center>
                  </form>
              </div>
              <div class="modal-footer bg-primary">
                <button type="button" class="btn btn-danger" data-dismiss="modal">X</button>
              </div>
            </div>
          </div>
        </div>
<?php
if(isset($_POST['add'])){
	$depart=$_POST['depart'];
	$book_no=$_POST['book_no'];
	$address=$_POST['address'];
	$office_tel=$_POST['o_tel'];
	$office_fax=$_POST['o_fax'];
	$website=$_POST['website'];
	$email=$_POST['email'];
	$fname=$_POST['fname'];
	$lname=$_POST['lname'];
	$position=$_POST['position'];
	$tel=$_POST['tel'];
	$fax=$_POST['fax'];
	$username=$_POST['username'];
	$password=$_POST['password'];
	$status=0;
	$sql="INSERT INTO register_staf(depart,book_no,address,office_tel,office_fax,website,fname,lname,position,tel,fax,email,username,password,status) VALUES('$depart','$book_no','$address','$office_tel','$office_fax','$website','$fname','$lname','$position','$tel','$fax','$email','$username','$password',$status)";
	// 	print $sql;
	
	$result=dbQuery($sql);
	if(!$result){
		echo "<script>
                  swal({
                    title:'ลงทะเบียนไม่สำเร็จ  กรุณาตรวจสอบ',
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
	else{
		echo "<script>
                swal({
                    title:'ลงทะเบียนเรียบร้อยแล้ว ;-)',
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
?>
    <div class="container-fluse">
