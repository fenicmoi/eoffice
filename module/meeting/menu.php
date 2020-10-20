<?
	error_reporting(E_ALL^E_NOTICE);
	include "inc/connect_db.php";
?>
<html>
<head>
<title>โปรแกรมจองห้องประชุมออนไลน์ จังหวัดพังงา</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="meeting room">
<link href="mystyle.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  
<style type="text/css">

body {
	margin-left: 0px;
}
</style>
<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});
</script>
</head>
<body>
<div class="container-fluid">
<div class="alert alert-info">
   		 <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    	<strong>Info!</strong> ใช้ google chrome เพื่อการแสดงผลที่ถูกต้อง.<br>
        <strong>Info!</strong> Username/Password  เดี่ยวกับระบบสารบรรณ
  	 </div>  
 <div class="panel panel-primary">
      <div class="panel-heading"><label class="glyphicon glyphicon-user">เข้าสู่ระบบ</label></div>
      <div class="panel-body">
      	 <form role="form" action="chkuser.php" method="post" name="form1" >
  			<div class="form-group">
            	
                 <i class="icon-user"></i>
   				     <input type="text" name="username" id="username" class="form-control" placeholder="ชื่อผู้ใช้">
  			</div>
  			<div class="form-group">
   			 <input type="password" name="passwords" class="form-control" id="passwords" placeholder="รหัสผ่าน">
 			 </div>
 			 <button type="submit" class="btn btn-info btn-block" onclick="chkform();">ตกลง</button>
		</form>
      </div>
    </div>
    
    <div class="panel panel-primary">
    <div class="panel-heading"><label class="glyphicon glyphicon-search">ตรวจสอบการใช้ห้องประชุม</label></div>
      <div class="panel-body">
      	 <form role="form" action="chkroom.php" method="post" name="form2" >
  			<div class="form-group">
   				 <label for="email">เลือกห้อง:</label>
   				 <select name="room" id="room" data-toggle="tooltip" title="คลิกเลือกห้องประชุม!">
                    <option value="0" selected="selected">--ห้องประชุม--</option>
               		 <?
						$sql="select * from  meeting_room";
						$dbquery = @mysql_db_query($dbname, $sql);
						$num_rows = @mysql_num_rows($dbquery);
						$i=0;
						while ($i < $num_rows){
							$result = @mysql_fetch_array($dbquery);
							$room_id=$result[room_id];
							$roomname=$result[roomname];
							echo"<option value='$room_id'>$roomname</option>";
							$i++;
						}
					?>
           		 </select>
  		    </div>
  			<div class="form-group">
   				 <label for="pwd">วันที่:</label>
   			 <input type="date" name="startdate" class="form-control" id="startdate" size="10" onkeypress="check_number()" data-toggle="tooltip" title="คลิกเลือกวันที่!">
 			 </div>
 			 <button type="submit" class="btn btn-info btn-block"  onclick="chkform2();">ตกลง</button>
		</form>
      </div>
    </div>
    </div>
    <span class="glyphicon-glass">    <!--user online script-->
   	<script language="JavaScript">var fhs = document.createElement('script');var fhs_id = "5342965";
		var ref = (''+document.referrer+'');var pn =  window.location;var w_h = window.screen.width + " x " + window.screen.height;
		fhs.src = "//s1.freehostedscripts.net/ocounter.php?site="+fhs_id+"&e1=Online User&e2=Online Users&r="+ref+"&wh="+w_h+"&a=1&pn="+pn+"";
		document.head.appendChild(fhs);document.write("<span id='o_"+fhs_id+"'></span>");
 	 </script>
	</span>
</div>
</body>
</html>
<script language="javascript">

 function chkform()
{
	if(document.form1.username.value == 0)
	{
		jAlert('error', 'This is the error dialog box with some extra text.', 'Error Dialog');
		//alert("กรุณาระบุชื่อผู้ใช้ก่อนครับ");
		//document.form1.username.focus();
	}else 
	if(document.form1.passwords.value == 0)
	{
		alert("กรุณาระบุรหัสผ่านก่อนครับ");
		document.form1.passwords.focus();
	}else
	document.form1.submit();
}

function chkform2()
{
	if(document.form2.room.value == 0)
	{
		alert("กรุณาเลือกห้องครับ");
		document.form2.room.focus();
	}else
	if(document.form2.startdate.value == "")
	{
		alert("กรุณาระบุวันที่ครับ");
		document.form2.startdate.focus();
	}else
		document.form2.submit();
}

function check_number() 
{
	e_k=event.keyCode
	if (((e_k < 48) || (e_k > 47)) && e_k != 46 && e_k != 13) 
	{
	//if (e_k != 13 && (e_k < 48) || (e_k > 57) || e_k == ) {
	event.returnValue = false;
	alert(" กรุณาใส่วันที่ โดยการกดปุ่ม DATE");
	}
}
</script>