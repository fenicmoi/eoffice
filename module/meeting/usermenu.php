<!DOCTYPE html>
<html >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="mystyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="css/bootstrap.min.css">
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</head>

<body>
<div class="container-fluid">
	 <div class="panel panel-primary">
     	<div class="panel-heading"><span class="glyphicon glyphicon-list-alt"></span>  เมนูหลัก</div>
      	<div class="list-group">
    		<a  href="fillform.php" target="rightframe" class="list-group-item">
            	<span class="glyphicon glyphicon-plus"></span> จองห้องประชุม
            </a>
   			<a href="cancelform.php" target="rightframe" class="list-group-item">
            	<span class="glyphicon glyphicon-remove"></span> ยกเลิกการจองห้องประชุม
            </a>
    		<a href="historymeeting.php" target="rightframe" class="list-group-item">
            	<span class="glyphicon glyphicon-calendar"></span> ประวัติการจองห้องประชุม
            </a>
            <a href="index.php" target="_parent" class="list-group-item">
            	<span class="glyphicon glyphicon-log-out"></span> ออกจากระบบ
            </a>
  	   </div>
    </div>
</div>
</body>
</html>
<script language="javascript">
function chkform()
{
	if(document.form1.username.value == 0)
	{
		alert("กรุณาระบุชื่อผู้ใช้ก่อนครับ1");
		document.form1.username.focus();
	}else 
	if(document.form1.passwords.value == 0)
	{
		alert("กรุณาระบรหัสผ่านก่อนครับ2");
		document.form1.passwords.focus();
	}else
	document.form1.submit();
}
</script>