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
    <title><?php echo $title ?>-version 2024</title>

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
    <script src="js/script_dropdown.js"></script>
 

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

<!-- /Chatra {/literal} -->
<style>
  body{
    font-family: 'Taviraj', serif;
    height:100%;
  }
</style>

<link href="css/dataTables.css" rel="stylesheet">
<script src="js/dataTables.js"></script>
<!-- <script type="text/javascript" language="javascript" >
			$(document).ready( function () {
                 $('#myTable').DataTable();
            } );
</script> -->

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
            <a class="navbar-brand" href="index.php"><?php echo $title;?></a>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav ">
              <li><a class="nav-link active"  href="index.php?menu=1"><i class="fas fa-home"></i> หน้าแรก</a></li>
              <li><a class="btn-link"  href="index.php?menu=2"><i class="fas fa-retweet"></i> คำสั่งจังหวัด</a></li>
              <li class="dropdown">
                <a class="btn-link"  class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fas fa-users"></i> ลงทะเบียน
                <span class="caret"></span></a>
                <ul class="dropdown-menu">
                   <li><a   href="index.php?menu=3"><i class="fas fa-check-circle"></i> ตรวจสอบส่วนราชการ/หน่วยงานที่ลงทะเบียน </a></li>
                  <li><a  data-toggle="modal" data-target="#modalAdd"><i class="fas fa-key"></i> ลงทะเบียนหน่วยงาน/เจ้าหน้าที่ </a></li>
                </ul>
              </li>
              <li><a  class="btn-link"  href="#" data-toggle="modal" data-target="#modelRule">ข้อตกลงการใช้งาน</a></li>
              <li><a class="btn-link"  data-toggle="modal" data-target="#myModal"><i class="fas fa-key"></i> เข้าสู่ระบบ </a></li>
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

    <div class="container-fluid">
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
                                              <input class="form-control" type="text" name="book_no" placeholder="ตัวอย่าง พท 0017" required >
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
                                              <input class="form-control" type="text" name="o_tel" placeholder="ตัวอย่าง 074-613409" required >
                                          </div>
                                        </div>
                                        <div class="form-group">
                                          <div class="input-group">
                                              <span class="input-group-addon">เบอร์โทรสาร</span>
                                              <input class="form-control" type="text" name="o_fax" placeholder="ตัวอย่าง 074-613409" required >
                                          </div>
                                        </div>
                                        <div class="form-group">
                                          <div class="input-group">
                                              <span class="input-group-addon">Website</span>
                                              <input class="form-control" type="text" name="website" placeholder="ตัวอย่าง www.phatthalung.go.th">
                                          </div>
                                        </div>
                                        <div class="form-group">
                                          <div class="input-group">
                                              <span class="input-group-addon">E-mail ทางการ</span>
                                              <input class="form-control" type="email" name="email" placeholder="อีเมลล์ทางการของหน่วยงาน"  required>
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
                                              <span class="input-group-addon">เบอร์สำนักงาน</span>
                                              <input class="form-control" type="text" name="tel" placeholder="ตัวอย่าง 0-7648-1421" required >
                                          </div>
                                        </div>
                                        <div class="form-group">
                                          <div class="input-group">
                                              <span class="input-group-addon">เบอร์มือถือ</span>
                                              <input class="form-control" type="text" name="fax" placeholder="ตัวอย่าง 0-7648-1421" required >
                                          </div>
                                        </div>
                                        <!-- <div class="form-group">
                                          <div class="input-group">
                                              <span class="input-group-addon">username</span>
                                              <input class="form-control" type="text" name="username" placeholder="ประกอบด้วยตัวอักษรภาษาอังกฤษและตัวเลข 8 หลัก">
                                          </div>
                                        </div> -->
                                        <!-- <div class="form-group">
                                          <div class="input-group">
                                              <span class="input-group-addon">password</span>
                                              <input class="form-control" type="text" name="password" placeholder="ประกอบด้วยตัวอักษรภาษาอังกฤษและตัวเลข 8 หลัก" required>
                                          </div>
                                        </div> -->
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
if(isset($_POST['add'])){       // check button  
    $depart = trim(strip_tags($_POST['depart'] ?? ''));
    $book_no = trim(strip_tags($_POST['book_no'] ?? ''));
    $address = trim(strip_tags($_POST['address'] ?? ''));
    $office_tel = trim(strip_tags($_POST['o_tel'] ?? ''));
    $office_fax = trim(strip_tags($_POST['o_fax'] ?? ''));
    $website = trim($_POST['website'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $fname = trim(strip_tags($_POST['fname'] ?? ''));
    $lname = trim(strip_tags($_POST['lname'] ?? ''));
    $position = trim(strip_tags($_POST['position'] ?? ''));
    $tel = trim(strip_tags($_POST['tel'] ?? ''));
    $fax = trim(strip_tags($_POST['fax'] ?? ''));
    $status = 0;

    $inserted = false;

    // พยายามใช้ mysqli prepared statement (ต้องมีค่าคอนสแตนท์ใน config.php)
    if (defined('DB_HOST') && defined('DB_USER') && defined('DB_PASS') && defined('DB_NAME')) {
        $mysqli = @new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($mysqli && $mysqli->connect_errno === 0) {
            $stmt = $mysqli->prepare("INSERT INTO register_staf (depart,book_no,address,office_tel,office_fax,website,fname,lname,position,tel,fax,email,status) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)");
            if ($stmt) {
                // 12 strings + 1 int => 'ssssssssssssi'
                $stmt->bind_param('ssssssssssssi', $depart, $book_no, $address, $office_tel, $office_fax, $website, $fname, $lname, $position, $tel, $fax, $email, $status);
                $inserted = $stmt->execute();
                if (!$inserted) {
                    error_log('Register insert error (stmt): ' . $stmt->error);
                }
                $stmt->close();
            } else {
                error_log('Prepare failed (mysqli): ' . $mysqli->error);
            }
            $mysqli->close();
        } else {
            error_log('MySQL connect failed in header.php');
        }
    }

    // Fallback: ถ้าไม่สำเร็จด้วย mysqli ให้ escape อย่างน้อยแล้วใช้ dbQuery เดิม
    if (!$inserted) {
        $depart_e = addslashes($depart);
        $book_no_e = addslashes($book_no);
        $address_e = addslashes($address);
        $office_tel_e = addslashes($office_tel);
        $office_fax_e = addslashes($office_fax);
        $website_e = addslashes($website);
        $fname_e = addslashes($fname);
        $lname_e = addslashes($lname);
        $position_e = addslashes($position);
        $tel_e = addslashes($tel);
        $fax_e = addslashes($fax);
        $email_e = addslashes($email);

        $sql = "INSERT INTO register_staf(depart,book_no,address,office_tel,office_fax,website,fname,lname,position,tel,fax,email,status) VALUES('$depart_e','$book_no_e','$address_e','$office_tel_e','$office_fax_e','$website_e','$fname_e','$lname_e','$position_e','$tel_e','$fax_e','$email_e',$status)";
        $result = dbQuery($sql);
        if ($result) $inserted = true;
        else error_log('Fallback dbQuery failed in header.php: ' . $sql);
    }

    if(!$inserted){
        echo "<script>
                  swal({
                    title:'ลงทะเบียนไม่สำเร็จ  กรุณาตรวจสอบ',
                    text: 'อาจมีบางอย่างผิดพลาด โปรดลองอีกครั้ง',
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
                    text: 'จังหวัดพัทลุงจะชี้แจงแนวทางการใช้งานอีกครั้ง',
                    type:'success',
                    showConfirmButton:true
                    },
                    function(isConfirm){
                        if(isConfirm){
                            window.location.href='index.php?menu=3';
                        }
                    }); 
                </script>";
    }
                
}
?>
<div class="container-fluse">
