

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>ตรวจสอบการล็อกอิน</title>
    
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<body>

<?php
	include('inc/connect_db.php');
	session_start();
	error_reporting(E_ALL ^ E_NOTICE);

	$username=$_POST['username'];
	$passwords=$_POST['passwords'];
	$sql="select * from  user where user='$username' and pass='$passwords'";
	//echo $sql;
	$dbname="phangnga_office";
	$dbquery = @mysql_db_query($dbname, $sql);
	$num_rows = @mysql_num_rows($dbquery);
	$result = @mysql_fetch_array($dbquery);
	$name=$result[name];
	$user_id=$result[uid];

	if(!$num_rows){
    ?>
	<script language="javascript">
	alert("ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง");
	location.href("index.php");  
	</script>
   
    
    <?php echo"<meta http-equiv='refresh' content='0;URL=index.php'>"; ?>
<?	 }else{
	    $_SESSION['name']=$name;
		$_SESSION['userid']=$user_id; 	
		echo"<meta http-equiv='refresh' content='0;URL=main.php'>";
	 }	 	
		
mysql_close();
?>

</body>
</html>

