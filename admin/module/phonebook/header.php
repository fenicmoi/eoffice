   <?php
session_start();
if(!isset($_SESSION['ses_u_id'])){
	header("location:../index.php");
}


date_default_timezone_set('Asia/Bangkok');
include 'function.php';
include '../library/database.php';
include '../library/config.php';
include '../library/pagination.php';


$u_id=(isset($_SESSION['ses_u_id']))?$_SESSION['ses_u_id']:'';
$sec_id=(isset($_SESSION['ses_sec_id']))?$_SESSION['ses_sec_id']:'';
$dep_id=(isset($_SESSION['ses_dep_id']))?$_SESSION['ses_dep_id']:'';


if($u_id){
	$sql="SELECT u.u_id,u.u_name,u.u_pass,u.firstname,u.lastname,u.level_id,u.sec_id,s.sec_name,d.dep_id,d.dep_name,l.level_id,l.level_name 
                 FROM user u 
                 INNER JOIN section s ON s.sec_id=u.sec_id 
                 INNER JOIN depart d ON d.dep_id=s.dep_id
                 INNER JOIN user_level l ON l.level_id=u.level_id
                 WHERE u.u_id=$u_id";
	$result=  dbQuery($sql);
	$num= dbNumRows($result);
	if($num>0){
		$row= dbFetchAssoc($result);
		$u_name=$row['u_name'];
		$u_pass=$row['u_pass'];
		$firstname=$row['firstname'];
		$lastname=$row['lastname'];
		$sec_id=$row['sec_id'];
		$secname=$row['sec_name'];
		$depart=$row['dep_name'];
		$level=$row['level_name'];
		$level_id=$row['level_id'];
		$dep_id=$row['dep_id'];
	}	
}else{
	$level='ผู้ใช้งานทั่วไป';
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
     <meta name="description" content="ระบบสารบรรณจังหวัดพังงา">
    <meta name="author" content="นายสมศักดิ์  แก้วเกลี้ยง">
    <link rel="icon" href="../images/favicon.ico">
    <title><?php echo $title;
?></title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link href="../css/sticky-footer-navbar.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/loader.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">

    <script src="../js/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/function.js"></script>
    
    <link rel="stylesheet" href="../css/sweetalert.css">
    <script src="../js/sweetalert.min.js"></script>
    <script src="app.js"></script>
    
     <!-- DateTimePicket -->
     <script src="../js/jquery-ui-1.11.4.custom.js"></script>
     <link rel="stylesheet" href="../css/jquery-ui-1.11.4.custom.css" />
     <link rel="stylesheet" href="../css/SpecialDateSheet.css" />
   
    <!-- หน้าต่างแจ้งเตือน -->
    <script  src="../js/jquery_notification_v.1.js"> </script>  <!-- Notification -->
    <link href="../css/jquery_notification.css" type="text/css" rel="stylesheet"/>
    
    <link href="../css/dataTables.css" rel="stylesheet">
    <script src="../js/dataTables.js"></script>

    <link rel="stylesheet" type="text/css" href="../select/selection.css">
    <link href="https://fonts.googleapis.com/css?family=Taviraj" rel="stylesheet">
    
    <!-- auto complate -->
    <script type="text/javascript" src="autocomplete.js"></script>
    <link rel="stylesheet" href="autocomplete.css"  type="text/css"/>
    <script type="text/javascript" src="../js/jquery.alphanumeric.js"></script>
    <script>
    $(document).ready( function () {
        $('#myTable').DataTable();
    } );
</script>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

<style type="text/css">
body{
     font-family: 'Taviraj', serif;
}
.content {
    border:solid 1px #cccccc;
    padding:3px;
    clear:both;
    width:300px;
    margin:3px;
}
#text_center { text-align:center; }
#text_right { text-align:right; }
#text_left { text-align:left; }
#under { text-decoration: underline dotted blue ;}

</style>


  </head>
  
  <body>
      <nav class="navbar navbar navbar-inverse ">
          <!-- Brand and toggle get grouped for better mobile display -->
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
              <a class="navbar-brand" href="#"><?php echo $title;

?></a>
              <ul class="nav navbar-nav">
                  <li><a href="#"><i class="fas fa-users"></i> <?php echo $level ;
echo "[".$firstname."]";
?></a></li>
              </ul>
          </div>

            <?php if(!$u_id){
	
	?>
             <ul class="nav navbar-nav navbar-right">
             <form class="navbar-form navbar-left" name="login" method="post" action="checkUser.php">
                    <label for="username">เข้าสู่ระบบ</label>
                  <div class="form-group">
                      <input type="text" name="username" class="form-control" placeholder="username" required="">
                  </div>
                  <div class="form-group">
                      <input type="password" name="password" class="form-control" placeholder="password" required="">
                  </div>
                  <button type="submit" class="btn btn-primary">LOGIN</button>
            </form>
             </ul>
         
            <?php
}

else{

?>
             
            <ul class="nav navbar-nav navbar-right">
              <li>
                      <div class="chip">
                          <img src="../images/img_avatar.png" alt="Person" width="50" height="50">
                          <span class="badge" data-toggle="modal" title="Click"  data-target="#myModal"> ข้อมูลผู้ใช้ </span>
                     </div>
              </li>
              <li>
                  <div class="chip">
                          <img src="../images/logout.png" alt="Person" width="50" height="50">
                          <a class="badge" href="../logout.php" onclick(return alert("hellojava"));> ออกจากระบบ</a>
                         
                  <!--<a href="../logout.php">LOGOUT</a> -->
              </li>
            </ul>
          </div><!-- /.navbar-collapse -->
            <?php
}

?>
    </nav>
      
   <div class="container-fluid">
       <!-- Model -->
    <!-- -ข้อมูลผู้ใช้ -->
    <div id="myModal" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header bg-primary">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"><i class="fa fa-address-card" aria-hidden="true"></i>User Profile</h4>
          </div>
          <div class="modal-body">
              <p><i class="fa fa-tag"></i> ชื่อ  <?php print $firstname ?>    <?php print $lastname ?></p>
              <p><i class="fa fa-tag"></i><?php print $secname?></p>
              <p><i class="fa fa-tag"></i><?php print $depart?></p>
              <p><i class="fa fa-tag"></i>สถานะผู้ใช้งาน  <?php print $level ?></p>
          </div>
          <div class="modal-footer bg-primary">
              <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i></button>
          </div>
        </div>

      </div>
    </div>
    <!-- End Model -->
<?php  //useronline
//user online
$session=session_id();
$time=time();
$time_check=$time-600;
//print $time_check;
//กำหนดเวลาในที่นี้ผมกำหนด 10 นาที
$sql="select * from user_online";
//print $sql;
$result = dbQuery($sql);
$session_check = dbNumRows($result);
//echo "session_check".$session_check;
if ($session_check == 0) {
    $sql="insert into user_online values ('$session',$time)";
    //print $sql;
    dbQuery($sql);
}
else {
    $sql="update user_online set time='$time' where session='$session'";
    //print $sql;
	dbQuery($sql);
}
$sql="select count(*) from user_online";
$result= dbQuery($sql);
$user_online = dbNumRows($result);

?>
    <div class="container-fluse">    

