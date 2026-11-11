<?php

define('IS_SYSTEM_RUNNING', true);
require_once 'library/database.php';
require_once 'library/security.php';
$menu = isset($_GET['menu']) ? (int) $_GET['menu'] : 1;
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <meta name="description" content="">
  <meta name="author" content="นายสมศักดิ์  แก้วเกลี้ยง">
  <link rel="icon" href="images/favicon.png">
  <title>ศูนย์รวมข้อมูลการขับเคลื่อน e-office จังหวัดพัทลุง</title>

  <!-- popup -->
  <link rel="stylesheet" href="css/popup.css">

  <!-- Bootstrap -->
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <!-- <link href="css/sticky-footer-navbar.css" rel="stylesheet"> -->
  <link rel="stylesheet" href="css/loader.css">
  <script src="js/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/text-hilight.js"></script>

  <link rel="stylesheet" href="css/fontawesome5.0.8/web-fonts-with-css/css/fontawesome-all.min.css">
  <link
    href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;600;700&family=Taviraj:wght@300;400;600;700&display=swap"
    rel="stylesheet">
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
  <!-- /Chatra {/literal} -->
  <link href="css/modern_dashboard.css?v=<?php echo time(); ?>" rel="stylesheet">

  <link href="css/dataTables.css" rel="stylesheet">
  <script src="js/dataTables.js"></script>
  
  <!-- Tailwind CSS (No Preflight) -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      corePlugins: {
        preflight: false,
      }
    }
  </script>
  <style>
    /* Phatthalung Identity Theme */
    :root {
      --phatthalung-purple-dark: #2e0854;
      --phatthalung-purple: #4c1d95;
      --phatthalung-purple-light: #6b21a8;
      --phatthalung-gold: #f59e0b;
      --phatthalung-gold-light: #fbbf24;
      --phatthalung-lake: #0284c7;
    }

    body {
      padding-top: 70px;
      background-color: #f8fafc;
      font-family: 'Sarabun', 'Taviraj', 'TH Sarabun New', sans-serif;
    }

    /* Fix Tailwind CSS conflict with Bootstrap 3 collapse */
    .collapse {
      visibility: visible;
    }
    @media (max-width: 767px) {
      .navbar-collapse.collapse:not(.in) {
        display: none !important;
      }
      .navbar-collapse.collapse.in {
        display: block !important;
        visibility: visible !important;
      }
    }
    @media (min-width: 768px) {
      .navbar-collapse.collapse {
        display: block !important;
        visibility: visible !important;
      }
    }

    /* Navbar with Phatthalung Identity */
    .phatthalung-navbar {
      background: linear-gradient(90deg, #2e0854 0%, #4c1d95 45%, #3b0764 100%) !important;
      border: none !important;
      border-bottom: 3.5px solid #f59e0b !important;
      box-shadow: 0 4px 20px rgba(46, 8, 84, 0.35) !important;
      min-height: 60px;
    }

    .phatthalung-navbar .navbar-brand {
      padding: 6px 15px;
      height: 60px;
      display: flex;
      align-items: center;
    }

    .phatthalung-navbar .navbar-nav > li > a {
      color: #f1f5f9 !important;
      font-size: 1.35rem;
      font-weight: 600;
      padding: 19px 10px;
      transition: all 0.2s ease;
      font-family: 'Sarabun', sans-serif;
    }

    @media (min-width: 768px) and (max-width: 1200px) {
      .phatthalung-navbar .navbar-nav > li > a {
        font-size: 1.25rem;
        padding: 19px 7px;
      }
      .phatthalung-navbar .navbar-brand {
        padding: 6px 8px;
      }
    }

    .phatthalung-navbar .navbar-nav > li > a:hover,
    .phatthalung-navbar .navbar-nav > li > a:focus,
    .phatthalung-navbar .navbar-nav > li.open > a {
      color: #fbbf24 !important;
      background: rgba(255, 255, 255, 0.08) !important;
    }

    .phatthalung-navbar .navbar-nav > li.active > a {
      color: #fbbf24 !important;
      background: rgba(245, 158, 11, 0.15) !important;
      border-bottom: 3px solid #fbbf24;
    }

    /* Dropdown Menus */
    .phatthalung-navbar .dropdown-menu {
      border-radius: 12px;
      border: 1px solid #e2e8f0;
      box-shadow: 0 12px 30px rgba(15, 23, 42, 0.15);
      padding: 8px 0;
      min-width: 290px;
      font-family: 'Sarabun', sans-serif;
    }

    .phatthalung-navbar .dropdown-menu > li > a {
      padding: 10px 18px;
      font-size: 1.45rem;
      color: #1e293b;
      font-weight: 500;
      display: flex;
      align-items: center;
      transition: all 0.15s ease;
    }

    .phatthalung-navbar .dropdown-menu > li > a:hover {
      background-color: #f3e8ff;
      color: #6b21a8;
      padding-left: 22px;
    }

    .phatthalung-navbar .dropdown-header {
      font-size: 1.25rem;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      color: #7e22ce;
      font-weight: 700;
      padding: 6px 18px;
      background: #faf5ff;
    }

    @media (min-width: 768px) {
      .phatthalung-navbar .navbar-nav > li.dropdown:hover > .dropdown-menu {
        display: block;
        margin-top: 0;
      }
    }

    /* Golden Login Button */
    .btn-phatthalung-login {
      background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%) !important;
      color: #ffffff !important;
      font-weight: 700 !important;
      border-radius: 20px !important;
      padding: 7px 15px !important;
      margin-top: 13px !important;
      margin-left: 6px !important;
      margin-right: 10px !important;
      border: 1px solid #fbbf24 !important;
      box-shadow: 0 4px 12px rgba(217, 119, 6, 0.35) !important;
      transition: all 0.25s ease !important;
      font-size: 1.35rem !important;
      display: inline-flex !important;
      align-items: center !important;
    }

    .btn-phatthalung-login:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 16px rgba(217, 119, 6, 0.5) !important;
      color: #ffffff !important;
      background: linear-gradient(135deg, #fbbf24 0%, #d97706 100%) !important;
    }
  </style>
</head>
<body>
  <!-- Fixed Navbar with Phatthalung Identity -->
  <nav class="navbar navbar-inverse navbar-fixed-top phatthalung-navbar">
    <div class="container-fluid" style="padding-left: 15px; padding-right: 15px;">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
          data-target="#bs-example-navbar-collapse-1" aria-expanded="false" style="margin-top: 14px; border-color: #fbbf24;">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar" style="background-color: #fbbf24;"></span>
          <span class="icon-bar" style="background-color: #fbbf24;"></span>
          <span class="icon-bar" style="background-color: #fbbf24;"></span>
        </button>
        <a class="navbar-brand" href="index.php">
          <img src="images/logo.png" alt="ตราประจำจังหวัดพัทลุง" style="height: 40px; width: 40px; margin-right: 10px; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.3));">
          <div style="line-height: 1.2;">
            <div style="font-weight: 800; font-size: 1.6rem; color: #ffffff; font-family: 'Sarabun', sans-serif;">
              e-Office <span style="color: #fbbf24;">จังหวัดพัทลุง</span>
            </div>
            <div style="font-size: 1.1rem; color: #e9d5ff; font-weight: 400; font-family: 'Sarabun', sans-serif;">
              เมืองลุง ก้าวสู่ระบบราชการดิจิทัล 2570
            </div>
          </div>
        </a>
      </div>

      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav">
          <li class="<?php echo ($menu == 1) ? 'active' : ''; ?>">
            <a href="index.php?menu=1"><i class="fas fa-home text-warning mr-1"></i> หน้าแรก</a>
          </li>
          
          <!-- ระบบงานหลัก (Dropdown) -->
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
              <i class="fas fa-th-large text-warning mr-1"></i> ระบบงานหลัก <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
              <li class="dropdown-header"><i class="fas fa-star text-warning"></i> ระบบงานหลักประจำจังหวัด</li>
              <li>
                <a href="http://phatthalung.eoffice.go.th" target="_blank">
                  <i class="fas fa-cloud text-primary mr-2" style="font-size: 1.5rem; width: 22px;"></i>
                  <div>
                    <span class="font-weight-bold">ระบบ e-Office (GDCC)</span>
                    <span class="badge badge-primary ml-1" style="background: #2563eb; font-size: 1.1rem;">ระบบใหม่</span>
                  </div>
                </a>
              </li>
              <li>
                <a href="#" data-toggle="modal" data-target="#myModal">
                  <i class="fas fa-building text-warning mr-2" style="font-size: 1.5rem; width: 22px;"></i>
                  <div>
                    <span class="font-weight-bold">ระบบรับ-ส่ง เอกสารเดิม (พัทลุง)</span>
                    <span class="badge badge-warning ml-1" style="background: #d97706; font-size: 1.1rem;">ระบบเดิม</span>
                  </div>
                </a>
              </li>
              <li role="separator" class="divider"></li>
              <li>
                <a href="http://www.phone.phatthalung.go.th" target="_blank">
                  <i class="fas fa-address-book text-success mr-2" style="font-size: 1.5rem; width: 22px;"></i>
                  <span>ติดต่อเรา</span>
                </a>
              </li>
            </ul>
          </li>

          <!-- เมนูคู่มือและสื่อการเรียนรู้ (Dropdown รวมคู่มือทั้งหมดตามที่ผู้ใช้ขอ: ส่วนคู่มืออื่นๆ เอาไปทำเป็น top menu) -->
          <li class="dropdown <?php echo ($menu == 5) ? 'active' : ''; ?>">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
              <i class="fas fa-book-reader text-warning mr-1"></i> คู่มือและสื่อการเรียนรู้ <span class="caret"></span>
            </a>
            <ul class="dropdown-menu" style="min-width: 320px;">
              <li class="dropdown-header"><i class="fas fa-file-pdf text-danger"></i> เอกสารคู่มือการใช้งาน (PDF)</li>
              <li>
                <a href="https://documents.eoffice.go.th/docs/ManualeSaraban" target="_blank">
                  <i class="fas fa-file-pdf text-danger mr-2" style="font-size: 1.5rem; width: 22px;"></i>
                  <div>
                    <div class="font-weight-bold">คู่มือการใช้งานระบบ e-Office</div>
                    <small class="text-muted">ครอบคลุมทุกฟังก์ชันสำหรับผู้ใช้ทั่วไป</small>
                  </div>
                </a>
              </li>
              <li>
                <a href="https://documents.eoffice.go.th/docs/ManualAdminTool" target="_blank">
                  <i class="fas fa-cogs mr-2" style="font-size: 1.5rem; width: 22px; color: #9333ea;"></i>
                  <div>
                    <div class="font-weight-bold">คู่มือสำหรับผู้ดูแลระบบ</div>
                    <small class="text-muted">สำหรับ Administrator ประจำหน่วยงาน</small>
                  </div>
                </a>
              </li>
              <li>
                <a href="https://documents.eoffice.go.th/new-features/28-04-2569/update-1/" target="_blank">
                  <i class="fas fa-user-plus text-info mr-2" style="font-size: 1.5rem; width: 22px;"></i>
                  <div>
                    <div class="font-weight-bold">ขั้นตอนการลงทะเบียนระบบ</div>
                    <small class="text-muted">คู่มือการสมัครและตั้งค่าบัญชีผู้ใช้</small>
                  </div>
                </a>
              </li>
              
              <li role="separator" class="divider"></li>
              <li class="dropdown-header"><i class="fab fa-youtube text-danger"></i> วิดีโอแนะนำและอบรม</li>
              <li>
                <a href="https://documents.eoffice.go.th/docs/VideoTutorial" target="_blank">
                  <i class="fab fa-youtube text-danger mr-2" style="font-size: 1.5rem; width: 22px;"></i>
                  <span>วิดีโอแนะนำการใช้งาน (ผู้ใช้ทั่วไป)</span>
                </a>
              </li>
              <li>
                <a href="https://documents.eoffice.go.th/docs/VideoTutorialAdmin" target="_blank">
                  <i class="fas fa-video text-warning mr-2" style="font-size: 1.5rem; width: 22px;"></i>
                  <span>วิดีโอแนะนำระบบ (สำหรับ Admin)</span>
                </a>
              </li>
              <li>
                <a href="https://documents.eoffice.go.th/docs/VideoTraining" target="_blank">
                  <i class="fas fa-chalkboard-teacher text-success mr-2" style="font-size: 1.5rem; width: 22px;"></i>
                  <span>วิดีโอบันทึกการอบรมอย่างละเอียด</span>
                </a>
              </li>

              <li role="separator" class="divider"></li>
              <li>
                <a href="index.php?menu=5" style="background-color: #faf5ff; font-weight: bold; color: #4c1d95;">
                  <i class="fas fa-th-list text-primary mr-2" style="font-size: 1.4rem; width: 22px;"></i>
                  <span>เปิดหน้ารวมคู่มือและวิดีโอทั้งหมด &rarr;</span>
                </a>
              </li>
            </ul>
          </li>

          <!-- <li class="<?php echo ($menu == 2) ? 'active' : ''; ?>">
            <a href="index.php?menu=2"><i class="fas fa-retweet text-warning mr-1"></i> คำสั่งจังหวัด</a>
          </li> -->

          <li class="<?php echo ($menu == 4) ? 'active' : ''; ?>">
            <a href="index.php?menu=4"><i class="fas fa-address-book text-warning mr-1"></i>ติดต่อเจ้าหน้าที่</a>
          </li>

          <!-- ลงทะเบียน (Dropdown) -->
          <li class="dropdown <?php echo ($menu == 3) ? 'active' : ''; ?>">
            <a href="http://phatthalung.eoffice.go.th/api/auth/thaid/forward?source=register"  role="button" aria-haspopup="true" aria-expanded="false">
              <i class="fas fa-users text-warning mr-1"></i> ลงทะเบียน <span class="caret"></span>
            </a>
          </li>

          <!-- <li>
            <a href="#" data-toggle="modal" data-target="#modelRule">
              <i class="fas fa-info-circle text-warning mr-1"></i> ข้อตกลง
            </a>
          </li> -->
        </ul>

        <!-- ปุ่มเข้าสู่ระบบ เด่นสง่า สีทอง -->
        <ul class="nav navbar-nav navbar-right">
          <li>
            <a href="#" class="btn-phatthalung-login" data-toggle="modal" data-target="#myModal">
              <i class="fas fa-key mr-2"></i> เข้าสู่ระบบ (ระบบเดิม)
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- Modal -->
  <div class="container-fluse">

    <!-- Modal Login -->
    <div id="myModal" class="modal fade" role="dialog">
      <div class="modal-dialog modal-sm">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header bg-primary text-center">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"><i class="fas fa-lock mr-2"></i> เข้าสู่ระบบ</h4>
          </div>
          <div class="modal-body">
            <div class="text-center mb-4">
              <i class="fas fa-user-circle fa-5x text-primary shadow-sm rounded-circle"></i>
            </div>
            <form method="post" action="checkUser.php">
              <div class="form-group">
                <div class="input-group shadow-sm">
                  <span class="input-group-addon bg-light"><i class="fas fa-user text-primary"></i></span>
                  <input class="form-control" type="text" name="username" placeholder="ชื่อผู้ใช้งาน" required>
                </div>
              </div>
              <div class="form-group">
                <div class="input-group shadow-sm">
                  <span class="input-group-addon bg-light"><i class="fas fa-key text-primary"></i></span>
                  <input class="form-control" type="password" name="password" placeholder="รหัสผ่าน" required>
                </div>
              </div>
              <button type="submit" class="btn btn-primary btn-block btn-lg mt-4 shadow">
                <i class="fas fa-sign-in-alt mr-2"></i> เข้าสู่ระบบ
              </button>
            </form>
          </div>
          <div class="modal-footer text-center">
            <small class="text-muted">ระบบสารบรรณพัทลุง Version 2024</small>
          </div>
        </div>
      </div>
    </div>

      <?php
      if (isset($_POST['add'])) {       // check button  
        $depart = dbEscapeString($_POST['depart']);
        $book_no = dbEscapeString($_POST['book_no']);
        $address = dbEscapeString($_POST['address']);
        $office_tel = dbEscapeString($_POST['o_tel']);
        $office_fax = dbEscapeString($_POST['o_fax']);
        $website = dbEscapeString($_POST['website']);
        $email = dbEscapeString($_POST['email']);
        $fname = dbEscapeString($_POST['fname']);
        $lname = dbEscapeString($_POST['lname']);
        $position = dbEscapeString($_POST['position']);
        $tel = dbEscapeString($_POST['tel']);
        $fax = dbEscapeString($_POST['fax']);

        $status = 0;
        $sql = "INSERT INTO register_staf (depart, book_no, address, office_tel, office_fax, website, fname, lname, position, tel, fax, email, status) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $result = dbQuery($sql, "ssssssssssssi", [
          $depart,
          $book_no,
          $address,
          $office_tel,
          $office_fax,
          $website,
          $fname,
          $lname,
          $position,
          $tel,
          $fax,
          $email,
          (int) $status
        ]);

        //echo $sql;
      

        $result = dbQuery($sql);
        if (!$result) {
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
        } else {
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