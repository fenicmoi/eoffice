<?
	session_start();
	error_reporting(E_ALL^E_NOTICE);
	include 'inc/connect_db.php';
	$userid=$_SESSION['userid'];
	if(!$userid) 
	{
		echo"<script language=\"javascript\">
	            alert(\"กรุณาเข้าสู่ระบบ\");
	            window.parent.location='index.php';
             </script>";
	}	
	$startdate=$_POST['startdate'];     //รับค่าวันประชุม
	list($year, $month, $day) = preg_split('[-]', $startdate);    //นำมาแยก ปี-เดือน-วัน

	$date="$day-$month-$year";            //เปลี่ยนเป็น วัน-เดือน-ปี
	$resive_date="$year-$month-$day";     //แปลงวันที่จองให้ให้อยู่ในรูปแบบ xxxx-xx-xx 
	$enddate=  "$year-$month-$day";
	$bookingdate=date("Y-m-d");
	$date=date("Y-m-d");

	
	$expire_explode = explode("/", $startdate);
	$expire_year = $expire_explode[0];
	$expire_month = $expire_explode[1];
	$expire_day = $expire_explode[2];


	$today_explode = explode("/", $date);
	$today_year = $today_explode[0];
	$today_month = $today_explode[1];
	$today_day = $today_explode[2];   // [2]

	
	
	$expire = gregoriantojd($expire_month,$expire_day,$expire_year);
	$today = gregoriantojd($today_month,$today_day,$today_year);


	$sum=$expire - $today;
	$room_id=$_POST['room_id'];

	$sql10="select roomcount from meeting_room where room_id='$room_id'";
	$dbquery10=@mysql_db_query($dbname, $sql10);
	$result10=@mysql_fetch_array($dbquery10);
	$roomcount=$result10[0];  //เก็บความจุห้องประชุม
	
	//รับค่าจากฟอร์ม
	$subject=$_POST['subject'];
	$header=$_POST['header'];
	$nummeeting=$_POST['nummeeting'];
	$namefill=$_POST['namefill'];
	$comment=$_POST['comment'];

	$config_day=0;   //สำหรับกำหนดวันจองล่วงหน้า
	//echo "configday=$config_day";
	
	if($sum = $config_day){    //ถ้า ระยะห่างระหว่างการจอง = config_day (เงื่อนไขไม่มีทางเป็นจริง)
    
		echo"<script language=\"javascript\">
		       alert(\"กรุณาจองห้องประชุมล่วงหน้าอย่างน้อย $config_day วัน\");
		       window.location='fillform.php';
		     </script>";
	}
	
	if($nummeeting > $roomcount){  //เช็คจำนวนคนในห้อง
	
		echo"<script language=\"javascript\">
		alert(\"จำนวนผู้เข้าประชุมเกินความจุ กรุณาเลือกห้องประชุมที่ความจุเหมาะสม\");
		window.location='fillform.php';
		</script>";	
	}
	
	
	if($nummeeting <= $roomcount){	
		if($expire < $today){     //ป้องกันการจองห้องย้อนหลัง
			echo"<script language=\"javascript\">
			alert(\"คุณระบุวันใช้ห้องย้อนหลังไม่ได้  กรุณาตรวจสอบวันที่ใช้ห้อง\");
			window.location='fillform.php';
			</script>";	
		}
		
	if($expire >= $today){    //ถ้าวันจองมากกว่าวันที่ปัจจุบันจริง

			 $starttime=$_POST['starttime'];    //เวลาเริ่มต้นประชุม
			 $endtime=$_POST['endtime'];        //เวลาสิ้นสุดการประชุม

			 list($hour, $minute, $second) = preg_split('[:]', $starttime);    //แยกข้อมูลเวลาเริ่มประชุมเก็บใน Array
			 $starttime="$hour:$minute:$second";
			
			 list($hour2, $minute2, $second2) = preg_split('[:]', $endtime);    //แยกข้อมูลเวลาสิ้นสุดการประชุมเก็บใน Array
			 $endtime="$hour2:$minute2:$second2";
	  }
			
			
	 if($starttime > $endtime){    //ตรวจสอบว่าเวลาเริ่มประชุมมากกว่าเวลาเลิกประชุมหรือไม่ *เวลาเริ่มต้องน้อยกว่า
			echo"<script language=\"javascript\">
				 alert(\"ระบุช่วงเวลาประชุมผิด กรุณาตรวจสอบ\");   
				 window.location='fillform.php';
				 </script>";
	 }else if($starttime < $endtime){	//ถ้าเวลาเริ่มประชุมน้อยกว่าเวลาเลิกจริง
		     $sql1="SELECT MIN(starttime), MAX(endtime) 
			        FROM meeting_booking 
			        WHERE  startdate='$resive_date' 
					AND room_id='$room_id'
				   ";  //คิวรี่ข้อมูลหาค่าที่น้อยที่สุด กับค่าที่มากที่สุดในวันนั้น
			 //echo "sql1=$sql1<br>";   
			 $dbquery1=@mysql_db_query($dbname, $sql1);
			 $numrows1=@mysql_num_rows($dbquery1);
			 //echo "numrows1=$numrows1<br>";
			 
			 if($numrows1 == 0){
							$sql5="insert into meeting_booking(book_id, subject, head, numpeople, room_id, startdate, starttime, endtime, bookname, bookingdate, user_id, comment, conf_status)
							values('', '$subject', '$header', '$nummeeting', '$room_id', '$startdate', '$starttime', '$endtime', '$namefill', '$bookingdate', '$userid', '$comment', '1' )";
							$dbquery5=@mysql_db_query($dbname, $sql5);
			 }else if($numrows1 <> 0){
				           // echo "loop while<br>";
							while($result=@mysql_fetch_array($dbquery1))
							{
								$st1=$result[0];  //เวลาต่ำสุด 
								$et1=$result[1];  //เวลาสูงสุด
			
								$sql2="SELECT * 
								       FROM meeting_booking 
								       WHERE startdate='$resive_date' 
								       AND room_id='$room_id' 
								       AND ('$starttime' between '$st1' and '$et1') 
								       OR ('$endtime' between '$st1' and '$et1')";
								//echo $sql2;
								$dbquery2=@mysql_db_query($dbname, $sql2);
								$numrows=@mysql_num_rows($dbquery2);
								//echo $numrows;

								if($numrows <> 0){
										echo"<script language=\"javascript\">
										alert(\"ห้องประชุมไม่ว่างในช่วงเวลาดังกล่าว กรุณาตรวจสอบ\");
										window.location='fillform.php';
										</script>";
								}
							 }  //end while   
							 
							if($numrows == 0){
									$sql4="insert into meeting_booking(book_id, subject, head, numpeople, room_id, startdate, starttime, endtime, bookname, bookingdate, user_id, comment, conf_status)
									values('', '$subject', '$header', '$nummeeting', '$room_id', '$startdate', '$starttime', '$endtime', '$namefill', '$bookingdate', '$userid', '$comment', '1' )";
									$dbquery4=@mysql_db_query($dbname, $sql4);   
							}  //end $numrows==0
						}  //numrows1 <>0
				}  //starttime>endtime
			} //$expire >= $toda
	//}  //$nummeeting <= $roomcount
	
    
	$checktool=$_POST["checktool"];
	if($checktool)
	{
	$sql3="select max(book_id) from meeting_booking";
	//echo "THIS IS SQL3:$sql3</BR>";
	$dbquery3=@mysql_db_query($dbname, $sql3);
	$result=@mysql_fetch_array($dbquery3);
	
	$book_id=$result[0];
	
	$all_tool = implode($checktool, ",");
	//$all_tool=implode(",",$checktool);
	$sql = "update meeting_booking set tool_id='$all_tool' where book_id='$book_id' and book_id<>''";
	//echo $sql;
	$dbquery=@mysql_db_query($dbname, $sql);
	//$result=@mysql_fetch_array($dbquerry);
     
	}
	
	 $sql_tool="INSERT INTO meeting_usetool(book_id,tool_id) VALUES('$book_id','$all_tool')";  
	 //echo $sql_tool;
	 $dbquery=@mysql_db_query($dbname, $sql_tool);
	
	echo"<script language='javascript'>
	alert('จองห้องประชุมเรียบร้อยแล้วครับ');
	window.location='fillform.php';
	</script>";
?>