<?php
session_start();
if (!isset($_SESSION['ses_u_id'])) {
    header("location:../index.php");
    exit;
}

date_default_timezone_set('Asia/Bangkok');
include 'function.php';
include '../library/database.php';
include '../library/config.php';
include '../library/pagination.php';

$u_id = isset($_SESSION['ses_u_id']) ? $_SESSION['ses_u_id'] : '';
$sec_id = isset($_SESSION['ses_sec_id']) ? $_SESSION['ses_sec_id'] : '';
$dep_id = isset($_SESSION['ses_dep_id']) ? $_SESSION['ses_dep_id'] : '';

if ($u_id) {
    $sql = "SELECT u.u_id,u.u_name,u.u_pass,u.firstname,u.lastname,u.level_id,u.sec_id,s.sec_name,d.dep_id,d.dep_name,l.level_id,l.level_name 
            FROM user u 
            INNER JOIN section s ON s.sec_id=u.sec_id 
            INNER JOIN depart d ON d.dep_id=s.dep_id
            INNER JOIN user_level l ON l.level_id=u.level_id
            WHERE u.u_id=$u_id";
    $result = dbQuery($sql);
    $num = dbNumRows($result);
    if ($num > 0) {
        $row = dbFetchAssoc($result);
        $u_name = $row['u_name'];
        $u_pass = $row['u_pass'];
        $firstname = $row['firstname'];
        $lastname = $row['lastname'];
        $sec_id = $row['sec_id'];
        $secname = $row['sec_name'];
        $depart = $row['dep_name'];
        $level = $row['level_name'];
        $level_id = $row['level_id'];
        $dep_id = $row['dep_id'];
    }
} else {
    $level = 'ผู้ใช้งานทั่วไป';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="ระบบสารบรรณจังหวัดพัทลุง">
    <meta name="author" content="นายสมศักดิ์  แก้วเกลี้ยง">
    <link rel="icon" href="../images/favicon.ico">
    <title><?php echo isset($title) ? htmlspecialchars($title) : 'E-Office'; ?></title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link href="../css/sticky-footer-navbar.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/loader.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" crossorigin="anonymous">
    <script src="../js/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/function.js"></script>
    <link rel="stylesheet" href="../css/sweetalert.css">
    <script src="../js/sweetalert.min.js"></script>
    <script src="app.js"></script>
    <!-- DateTimePicker -->
    <script src="../js/jquery-ui-1.11.4.custom.js"></script>
    <link rel="stylesheet" href="../css/jquery-ui-1.11.4.custom.css" />
    <link rel="stylesheet" href="../css/SpecialDateSheet.css" />
    <!-- Notification -->
    <script src="../js/jquery_notification_v.1.js"></script>
    <link href="../css/jquery_notification.css" type="text/css" rel="stylesheet" />
    <link href="../css/dataTables.css" rel="stylesheet">
    <script src="../js/dataTables.js"></script>
    <link rel="stylesheet" type="text/css" href="../select/selection.css">
    <link href="https://fonts.googleapis.com/css?family=Taviraj" rel="stylesheet">
    <!-- Bootstrap select autocomplete -->
    <link rel="stylesheet" href="css/bootstrap-select.css">
    <script src="js/bootstrap-select.js"></script>
    <script>
      $(function() {
        $('.selectpicker').selectpicker();
      });
    </script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="../js/jquery.alphanumeric.js"></script>
    <script>
      $(document).ready(function () {
        $('#myTable').DataTable();
        $('.select-unit').select2();
      });
    </script>
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style type="text/css">
      body { font-family: 'Taviraj', serif; }
      .content { border:solid 1px #cccccc; padding:3px; clear:both; width:300px; margin:3px; }
      #text_center { text-align:center; }
      #text_right { text-align:right; }
      #text_left { text-align:left; }
      #under { text-decoration: underline dotted blue ; }
      /* ใช้ class Bootstrap แทน chip ถ้าไม่มี CSS chip */
      .chip { display: flex; align-items: center; gap: 8px; }
    </style>
</head>
<body>
<nav class="navbar navbar-inverse">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#"><?php echo isset($title) ? htmlspecialchars($title) : 'E-Office'; ?></a>
        <ul class="nav navbar-nav">
            <li>
                <a href="#">
                    <i class="fas fa-users"></i>
                    <?php echo htmlspecialchars($level) . " [" . htmlspecialchars($firstname) . "]"; ?>
                </a>
            </li>
        </ul>
    </div>
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <?php if (!$u_id) { ?>
            <form class="navbar-form navbar-right" name="login" method="post" action="checkUser.php" style="margin-right:10px;">
                <label for="username">เข้าสู่ระบบ</label>
                <div class="form-group">
                    <input type="text" name="username" class="form-control" placeholder="username" required>
                </div>
                <div class="form-group">
                    <input type="password" name="password" class="form-control" placeholder="password" required>
                </div>
                <button type="submit" class="btn btn-primary">LOGIN</button>
            </form>
        <?php } else { ?>
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <div class="chip">
                        <img src="../images/img_avatar.png" alt="Person" width="50" height="50">
                        <span class="badge" data-toggle="modal" title="Click" data-target="#myModal">ข้อมูลผู้ใช้</span>
                    </div>
                </li>
                <li>
                    <div class="chip">
                        <img src="../images/logout.png" alt="Person" width="50" height="50">
                        <a class="badge" href="#" id="logout-btn">ออกจากระบบ</a>
                    </div>
                </li>
            </ul>
        <?php } ?>
    </div><!-- /.navbar-collapse -->
</nav>

<div class="container-fluid">
    <!-- Modal ข้อมูลผู้ใช้ -->
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-address-card" aria-hidden="true"></i> User Profile</h4>
                </div>
                <div class="modal-body">
                    <p><i class="fa fa-tag"></i> ชื่อ  <?php echo htmlspecialchars($firstname); ?> <?php echo htmlspecialchars($lastname); ?></p>
                    <p><i class="fa fa-tag"></i> <?php echo htmlspecialchars($secname); ?></p>
                    <p><i class="fa fa-tag"></i> <?php echo htmlspecialchars($depart); ?></p>
                    <p><i class="fa fa-tag"></i> สถานะผู้ใช้งาน  <?php echo htmlspecialchars($level); ?></p>
                </div>
                <div class="modal-footer bg-primary">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i></button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal -->

<?php
// user online
$session = session_id();
$time = time();
$time_check = $time - 600;
$sql = "select * from user_online";
$result = dbQuery($sql);
$session_check = dbNumRows($result);
if ($session_check == 0) {
    $sql = "insert into user_online values ('$session',$time)";
    dbQuery($sql);
} else {
    $sql = "update user_online set time='$time' where session='$session'";
    dbQuery($sql);
}
$sql = "select count(*) from user_online";
$result = dbQuery($sql);
$user_online = dbNumRows($result);
?>
<!-- เปลี่ยน container-fluse เป็น container-fluid -->
<div class="container-fluid">
<script>
$(document).ready(function() {
    $('#logout-btn').on('click', function(e) {
        e.preventDefault();
        swal({
            title: "ยืนยันการออกจากระบบ",
            text: "คุณต้องการออกจากระบบหรือไม่?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "ออกจากระบบ",
            cancelButtonText: "ยกเลิก"
        }, function(isConfirm) {
            if (isConfirm) {
                window.location.href = "../logout.php";
            }
        });
    });
});
</script>

