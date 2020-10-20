<?php
	session_start();
	error_reporting(E_ALL^E_NOTICE);
	include 'inc/connect_db.php';
	
	$userid=$_SESSION['userid'];
	
	$room_id=$_POST['room_id'];
	$edit_book_id=$_POST['edit'];
	$subject=$_POST['subject'];
	$header=$_POST['header'];
	$nummeeting=$_POST['nummeeting'];
	$namefill=$_POST['namefill'];
	$comment=$_POST['comment'];
	$startdate=$_POST['startdate'];  //recive date from  fillform.php
	$starttime=$_POST['starttime'];
	$endtime=$_POST['endtime'];
	

	
	if(!$userid){
		        echo"<script language=\"javascript\">
	                 alert(\"กรุณาเข้าสู่ระบบ\");
	                 window.parent.location='index.php';
                     </script>";
	}	
	

	list($day,$month,$year) = preg_split('[/]', $startdate);
	     $date="$year-$month-$day";
 
	list($day, $month, $year) = preg_split('[/]', $startdate);
	$startdate="$year-$month-$day";

	$curDay = date("j");
	$curMonth = date("n");
	$curYear = date("Y");

	$bookingdate="$curYear-$curMonth-$curDay";
	

	$today_date=date("Y-m-d");

	
	$expire_explode = explode("-", $bookingdate);
	$expire_year = $expire_explode[0];
	$expire_month = $expire_explode[1];
	$expire_day = $expire_explode[2];
	
	$today_explode = explode("-", $today_date);
	$today_year = $today_explode[0];
	$today_month = $today_explode[1];
	$today_day = $today_explode[2];
	
	$expire = gregoriantojd($expire_month,$expire_day,$expire_year);
	$today = gregoriantojd($today_month,$today_day,$today_year);

	$sql10="select roomcount from meeting_room where room_id='$room_id'";
	$dbquery10=@mysql_db_query($dbname, $sql10);
	$result10=@mysql_fetch_array($dbquery10);

	$roomcount=$result10[0];

	if($nummeeting > $roomcount){    //peple over load
		echo"<script language=\"javascript\">
			alert(\"จำนวนผู้เข้าประชุมเกินความจุห้องประชุม\");
			window.location='fillform.php?edit_book_id=$edit';
			</script>";	
	}else if($nummeeting <= $roomcount){	//peple not overload
	if($expire < $today){    //meeting day not return
			echo"<script language=\"javascript\">
				 alert(\"วันที่ผิด กรุณาตรวจสอบ\");
				 window.location='fillform.php?edit_book_id=$edit';
			    </script>";	
		}else if($expire >= $today){    //meeting day is true
			
			list($hour, $minute, $second) = preg_split('[:]', $starttime);
			$starttime="$hour:$minute:$second";
			//echo "starttime=$starttime";
			list($hour2, $minute2, $second2) = preg_split('[:]', $endtime);
			$endtime="$hour2:$minute2:$second2";

			if($starttime > $endtime){     //start time > end time
					echo"<script language=\"javascript\">
					alert(\"ผิดพลาด กรุณาตรวจสอบ\");
					window.location='fillform.php?edit_book_id=$edit';
					</script>";
				}else if($starttime < $endtime){	 
						$sql1="select min(starttime), max(endtime) from meeting_booking where startdate='$startdate'  and room_id='$room_id' ";   
						//echo "sql1=$sql1<br>";
						$dbquery1=@mysql_db_query($dbname, $sql1);
						$numrows1=@mysql_num_rows($dbquery1);
						if($numrows1 == 0){
							$sql5=" UPDATE meeting_booking 
							        SET   subject='$subject', 
										  head='$header', 
									      numpeople='$nummeeting', 
									      room_id='$room_id', 
									      startdate='$date',  
									      starttime='$starttime', 
									      endtime='$endtime', 
									      bookname='$namefill', 
									      bookingdate='$bookingdate',
									      comment='$comment', 
									      update_status='1' 
							      WHERE book_id='$edit_book_id' 
								        and user_id='$userid' ";
							//echo "sql5=$sql5<br>";
							//echo "numrows=$numrows1<br>";
							$dbquery5=@mysql_db_query($dbname, $sql5);
							
						}else if($numrows1 <> 0){
									$sql_checktime="SELECT  starttime,endtime 
									                FROM meeting_booking
									                WHERE startdate='$date' AND room_id='$room_id' AND book_id='$edit_book_id'";
									echo  $sql_checktime;
									$db_checktime=@mysql_db_query($dbname, $sqlchecktime);
									$result=@mysql_fetch_array($db_checktime);
									$st1=$result[0];
									$et2=$result[1];
									echo "starttime=$starttime<br>";
									echo "st1=$st1<br>";
									if(($starttime<>$st1) AND ($endtime<>$et2)){
										echo"<script language=\"javascript\">
											  alert(\"คุณไม่สามารถแก้ไขเวลาเริ่ม/เลิก การประชุมได้  ให้คุณยกเลิกห้องประชุมและจองใหม่ครับ\");
											  window.location='fillform.php?edit_book_id=$edit';
											  </script>";
									}else{
										    $sql4="UPDATE meeting_booking 
												   SET  subject='$subject', 
														head='$header', 
														numpeople='$nummeeting', 
														room_id='$room_id', 
														startdate='$date', 
														bookname='$namefill', 
														bookingdate='$bookingdate', 
														comment='$comment', 
														update_status='1' 
												   WHERE book_id='$edit_book_id' and user_id='$userid' ";
													$dbquery4=@mysql_db_query($dbname, $sql4);
													echo"<script language='javascript'>
														alert('แก้ไขข้อมูลเรียบร้อยแล้วครับ');
														window.location='cancelform.php';
													</script>";
									}
									/*while($result=@mysql_fetch_array($dbquery1)){
										$st1=$result[0];
										$et2=$result[1];
						
										$sql2="SELECT * 
											   FROM meeting_booking 
											   WHERE startdate='$date' 
											   AND room_id='$room_id' 
											   AND user_id = '$userid' 
											   AND book_id=$edit_book_id ";
										$dbquery2=@mysql_db_query($dbname, $sql2);
										$numrows=@mysql_num_rows($dbquery2);
										
										//echo "is a numrow=$numrows<br>";  
										if($numrows == 1){
											$sql4="UPDATE meeting_booking 
												   SET  subject='$subject', 
														head='$header', 
														numpeople='$nummeeting', 
														room_id='$room_id', 
														startdate='$date', 
														bookname='$namefill', 
														bookingdate='$bookingdate', 
														comment='$comment', 
														update_status='1' 
												   WHERE book_id='$edit_book_id' and user_id='$userid' ";
													$dbquery4=@mysql_db_query($dbname, $sql4);
													echo"<script language='javascript'>
														alert('แก้ไขข้อมูลเรียบร้อยแล้วครับ');
														window.location='cancelform.php';
													</script>";
										}
									  }  //end while		 */
						} //if numrows<>0
					} //starttime<endtime
			}
	}  //$nummeeting > $roomcount
	
	if($checktool)
	{
		$all_tool = implode($checktool, ",");
		$sql = "update meeting_booking set tool_id='$all_tool' where book_id='$edit'";
		//echo $sql;
		$dbquery=mysql_db_query($dbname, $sql);
	}
	
	
	
	if($checkfood)
	{	
	$all_food = implode($checkfood, ",");
	$sql = "update meeting_booking set food_id='$all_food' where book_id='$edit'";
	$dbquery=mysql_db_query($dbname, $sql);
	}	
	/*
	echo"<script language='javascript'>
	alert('á¡éä¢¢éÍÁÙÅàÃÕÂºÃéÍÂ¤ÃÑº ok');
	window.location='cancelform.php';
	</script>";   */
?>