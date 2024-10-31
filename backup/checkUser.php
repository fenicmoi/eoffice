<link rel="stylesheet" href="css/sweetalert.css">
<script src="js/sweetalert.min.js"></script>   
<?php
session_start();
date_default_timezone_set('Asia/Bangkok');

include 'header.php';
$u_name=$_POST['username'];
$u_pass=$_POST['password'];

if($u_name==""){
	//e	cho"<div class=\"alert alert-danger\">ไม่ได้กรอกชื่อผู้ใช้</div>";
	//s	wal("ไม่ได้ระบุชื่อผู้ใช้!", "ไประบุชื่อผู้ใช้?");
	echo "<script>
               swal({
                title:'โปรดระบุชื่อผู้ใช้',
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
elseif($u_pass==""){
	echo "<script>
               swal({
                title:'โปรดระบุรหัสผ่าน',
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
	$sql="SELECT * FROM user WHERE u_name='".$u_name."' AND u_pass='".$u_pass."' AND status<>0";
	$result=  dbQuery($sql);
	//p	rint $result;
	$num= dbNumRows($result);
	if($num>0){
		$row=  dbFetchAssoc($result);
		$sqlu="UPDATE user SET user_last_login='".date("Y-m-d H:i:s")."' WHERE u_id=".$row['u_id'];
		dbQuery($sqlu);
		echo "<br><br><br><br>";
		echo "<center><div class=\"loader\"></div></center>";
		echo "<center><div class='col-md-12 alert alert-success'><h3>กรุณารอสักครู่</h3</div></center>";
		$_SESSION['ses_u_id']=$row['u_id'];
		$_SESSION['ses_level_id']=$row['level_id'];
		$_SESSION['ses_dep_id']=$row['dep_id'];
		$_SESSION['ses_sec_id']=$row['sec_id'];
		$level_id=$row['level_id'];
		echo "<meta http-equiv='refresh' content='2;URL=admin/index_admin.php'>";
	}
	else{
		//ก		รณีไม่พบผู้ใช้
				            echo "<script>
               swal({
                title:'ขออภัย !  เราไม่พบผู้ใช้งาน กรุณาตรวจสอบ ชื่อและรหัสผ่านใหม่',
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
}
echo "</div>";


include 'footer.php';
?>
