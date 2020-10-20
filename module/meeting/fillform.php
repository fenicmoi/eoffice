<?php
	session_start();
	error_reporting(E_ALL^E_NOTICE);
	include "inc/connect_db.php";
	$userid=$_SESSION['userid'];
	
	if(!$userid){
		echo"<script language=\"javascript\">
	         alert(\"กรุณา Login ก่อนใช้งานหน้านี้fileform\");
	         window.parent.location='index.php';
             </script>";
	}	
	
	$monthname=array("มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
	$curDay = date("j");
	$curMonth = date("n");
	$curYear = date("Y")+543;
	$startdate="$curDay-$curMonth-$curYear";
?>

<!DOCTYPE html >
<html >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>บันทึกการจองห้องประชุม</title>
 <link href="mystyle.css" rel="stylesheet" type="text/css" /> 
<link rel="stylesheet" href="css/bootstrap.min.css">
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script language='javascript' src='popcalendar.js'></script>
<style type="text/css">
<!--
body {
	margin-top: 20px;
	background-color: #E5E5E5;
}
-->
</style>
</head>

<body>
<div class="container-fluid">
	<div class="panel panel-success">
      <div class="panel-heading"><h4>บันทึกการจองห้องประชุม</h4></div>
      <div class="panel-body">
      <?php
		$edit_book_id=$_GET['edit_book_id'];
		if(!$edit_book_id){  //ถ้ามีการส่งค้าแก้ไขรายการมา
	  ?>
		<form action="add-form.php" name="form1" method="post">
			<table class="table-condensed"  width="95%" border="0" align="center" cellpadding="3" cellspacing="5" class="borderall_green">
  			<tr>
    			<td width="14%" class="blue_bg_color"><div align="right"><strong>วันที่จอง: </strong></div></td>
    			<td width="86%" class="yellow_bg_color"><span class="badge"><? echo "$curDay-$curMonth-$curYear"; ?></span></td>
  			</tr>
  
  			<tr>
    			<td class="blue_bg_color"><div align="right"><strong>ประชุมเรื่อง : </strong></div></td>
    			<td class="yellow_bg_color"><input name="subject" type="text" id="subject" size="40" placeholder="ต้องระบุ" /> 
      			<span class="redfont">*</span> </td>
  			</tr>
  			<tr>
    			<td class="blue_bg_color"><div align="right"><strong>ประธานในที่ประชุม : </strong></div></td>
    			<td class="yellow_bg_color"><input name="header" type="text" id="header" size="40" placeholder="ต้องระบุ" /> <span class="redfont">*</span> </td>
  			</tr>
  			<tr>
    			<td class="blue_bg_color"><div align="right"><strong>จำนวนผู้เข้าประชุม : </strong></div></td>
    			<td class="yellow_bg_color"><input name="nummeeting" type="text" id="nummeeting" size="40" placeholder="ต้องระบุ" onKeyPress="check_number()" /> <span class="redfont">*</span> </td>
  			</tr>
  			<tr>
    			<td class="blue_bg_color"><div align="right"><strong>ห้องที่ใช้ประชุม : </strong></div></td>
    			<td class="yellow_bg_color"><select name="room_id" id="room_id">
      			<option value="0" selected="selected">--เลือกห้องประชุม--</option>
      			<?php
					$sql="select * from  meeting_room";
					$dbquery = @mysql_db_query($dbname, $sql);
					$num_rows = @mysql_num_rows($dbquery);
					$i=0;
					while ($i < $num_rows){
						$result = mysql_fetch_array($dbquery);
						$room_id=$result[room_id];
						$roomname=$result[roomname];
						echo"<option value='$room_id'>$roomname</option>";
						$i++;
					}
				?>
   				</select> <span class="redfont">*</span> </td>
  			</tr>
  			<tr>
    			<td class="blue_bg_color"><div align="right"><strong>วันที่ใช้ห้อง : </strong></div></td>
    			<td class="yellow_bg_color"><input name="startdate" type="date" id="startdate" size="12"><span class="redfont">* หมายเหตุ... ต้องจองล่วงหน้าอย่างน้อย 1 วัน </span> </td>
 			 </tr>
  			 <tr>
    			<td class="blue_bg_color"><div align="right"><strong>ช่วงเวลาที่ใช้ : </strong></div></td>
    			<td class="yellow_bg_color"><select name="starttime" id="starttime">
      			<option value="0" selected="selected">เวลา</option>
      			<?php
					$sql="select * from  meeting_starttime";
					$dbquery = @mysql_db_query($dbname, $sql);
					$num_rows = @mysql_num_rows($dbquery);
					$i=0;
					while ($i < $num_rows){
						$result = @mysql_fetch_array($dbquery);
						$time_id=$result[time_id];
						$time_name=$result[time_name];
						echo"<option value='$time_name'>$time_name</option>";
						$i++;
					}
				 ?>
      			 </select>
      			 ถึง
      			<select name="endtime" id="endtime">
        		<option value="0" selected="selected">เวลา</option>
       			<?php
					$sql="select * from  meeting_endtime";
					$dbquery = @mysql_db_query($dbname, $sql);
					$num_rows = @mysql_num_rows($dbquery);
					$i=0;
					while ($i < $num_rows){
						$result = @mysql_fetch_array($dbquery);
						$time_id=$result[time_id];
						$time_name=$result[time_name];
						echo"<option value='$time_name'>$time_name</option>";
						$i++;
					}
				?>
      			</select> <span class="redfont">*</span> </td>
  			</tr>
  			<tr>
    			<td class="blue_bg_color"><div align="right"><strong>อุปกรณ์ที่ใช้ : </strong></div></td>
    			<td valign="top" class="yellow_bg_color">
			<?php
				$sql="select * from meeting_tools";
				$dbquery=@mysql_db_query($dbname, $sql);
				$num_rows=@mysql_num_rows($dbquery);
				$a=0;
				while($a<$num_rows){
					$result = @mysql_fetch_array($dbquery);
					$tool_id=$result[tool_id];
					$tool_name=$result[toolname];
					echo "<input type=\"checkbox\" name=\"checktool[]\" value=\"$tool_id\" />$tool_name<br>";
					$a++;
				}
			?></td>
    	 	</tr>
  			<tr>
    			<td valign="top" class="blue_bg_color"><div align="right"><strong>หมายเหตุ : </strong></div></td>
    			<td class="yellow_bg_color"><textarea name="comment" cols="30" rows="5" id="comment"></textarea></td>
  			</tr>
  			<tr>
    			<td class="blue_bg_color"><div align="right"><strong>ชื่อผู้จอง : </strong></div></td>
    			<td class="yellow_bg_color"><input name="namefill" type="text" id="namefill" value="
				<?php 
					$sql="select name from user where uid=$userid";
					$dbquery=@mysql_db_query($dbname, $sql);
					$result=@mysql_fetch_array($dbquery);
					$name=$result[0];
					echo $name;
				?>" size="40" readonly/>
  			</tr>
 			<tr>
    			<td class="blue_bg_color">&nbsp; <input name="startdate1" type="hidden" id="startdate1" value="<? $startdate;?>"/> </td>
    			<td class="yellow_bg_color"><input type="button" class="btn-primary" name="Button" value="จองห้องประชุม" onclick="chkform();"/>
     			<input type="reset" class="btn-danger" name="Submit2" value="ล้างข้อมูล" />
    			<!-- <input name="room_id" type="hidden" id="room_id" value="<?$room_id;?>"/> -->
    			</td>
  			</tr>
		</table>
	</form>
<? }else if($edit_book_id){         //กรณีที่มีการแก้ไขฟอร์ม 
	$sql="select * from meeting_booking where book_id='$edit_book_id' ";
	$dbquery=@mysql_db_query($dbname, $sql);
	while($result=@mysql_fetch_array($dbquery)){
		$dept=$result[department];
		$subject=$result[subject];
		$head=$result[head];
		$num=$result[numpeople];
		$startdate=$result[startdate];
		$enddate=$result[enddate];
		$starttime=$result[starttime];
		$endtime=$result[endtime];
		$bookname=$result[bookname];
		$ref_room_id=$result[room_id];
		$comment=$result[comment];
	}
       
		list($year, $month, $day) = preg_split('[-]', $startdate);
		$startdate=  "$day/$month/$year";

		list($year, $month, $day) = preg_split('[/.-]', $enddate);
		$enddate=  "$day/$month/$year";
?>
		<form action="edit-function.php" name="form2" method="post">
			<table class="table-condensed" width="95%" border="0" align="center" cellpadding="3" cellspacing="5">
  				<tr>
    				<td width="145" class="blue_bg_color"><div align="right">วันที่จอง : </div></td>
    				<td class="yellow_bg_color"><? echo "<span class=\"badge\"> $curDay-$curMonth-$curYear</span>"; ?></td>
  				</tr>
                <tr>
                    <td class="blue_bg_color"><div align="right">ประชุมเรื่อง : </div></td>
                    <td class="yellow_bg_color"><input name="subject" type="text" id="subject" value="<? echo $subject; ?>" size="40" /> <span class="redfont">*</span> </td>
                </tr>
                <tr>
                    <td class="blue_bg_color"><div align="right">ประธานในที่ประชุม : </div></td>
                    <td class="yellow_bg_color"><input name="header" type="text" id="header" value="<? echo $head; ?>" size="40" /> <span class="redfont">*</span> </td>
                </tr>
                <tr>
                    <td class="blue_bg_color"><div align="right">จำนวนผู้เข้าประชุม : </div></td>
    				<td class="yellow_bg_color"><input name="nummeeting" type="text" id="nummeeting" onKeyPress="check_number()" value="<? echo $num; ?>" size="40" /> <span class="redfont">*</span> </td>
  				</tr>
  				<tr>
    				<td class="blue_bg_color"><div align="right">ห้องที่ใช้ประชุม : </div></td>
    				<td class="yellow_bg_color">
                    	<select name="room_id" id="room_id">
						<?php 
                            $sql="select * from meeting_room";
                            $dbquery=@mysql_db_query($dbname, $sql);
                            while($result=mysql_fetch_array($dbquery)){
                                $room_id=$result[room_id];
                                $roomname=$result[roomname];
                    
                                if($ref_room_id==$room_id){
                                    echo "<option value='$room_id' selected>$roomname</option>";
                                    }else{
                                    echo "<option value='$room_id'>$roomname</option>";
                                    }
                            }
                        ?>
       			 		</select> <span class="redfont">*</span> </td>
  				</tr>
 				<tr>
    				<td class="blue_bg_color"><div align="right">วันที่ใช้ห้อง : </div></td>
    				<td class="yellow_bg_color"><input name="startdate" type="text" id="startdate" value="<? echo $startdate; ?>" size="12">
					<span class="redfont">*</span> </td>
  				</tr>
  				<tr>
    				<td class="blue_bg_color"><div align="right">ช่วงเวลาที่ใช้ : </div></td>
    				<td class="yellow_bg_color">
                        <select name="starttime" id="starttime">
                        <?php
                            $sql="select * from meeting_starttime";
                            $dbquery=@mysql_db_query($dbname, $sql);
                            while($result=@mysql_fetch_array($dbquery)){
                                $time_id=$result[time_id];
                                $time_name=$result[time_name];
                                
                                if($starttime==$time_name)
                                {
                                    echo "<option value='$time_name' selected>$time_name</option>";
                                }else
                                {
                                    echo "<option value='$time_name'>$time_name</option>";
                                }
                            }
                        ?>
                        </select>
                      	ถึง
                      <select name="endtime" id="endtime">
                        <?php 
                            $sql="select * from meeting_endtime";
                            $dbquery=@mysql_db_query($dbname, $sql);
                            while($result=@mysql_fetch_array($dbquery))
                            {
                                $time_id=$result[time_id];
                                $time_name=$result[time_name];
                                
                                if($endtime==$time_name)
                                {
                                    echo "<option value='$time_name' selected>$time_name</option>";
                                }else
                                {
                                    echo "<option value='$time_name'>$time_name</option>";
                                }
                            }
                        ?>
                      </select> <span class="redfont">*</span> </td>
  					</tr>
                  	<tr>
                    	<td class="blue_bg_color"><div align="right">อุปกรณ์ที่ใช้ : </div></td>
                        <td valign="top" class="yellow_bg_color"><?
                            $sql="select * from meeting_tools";
                            $dbquery=@mysql_db_query($dbname, $sql);
                            $numrows=@mysql_num_rows($dbquery);
                            $num = 0;
                            while($result=@mysql_fetch_array($dbquery)){
								$tool_id[$num]=$result[tool_id];
								$toolname[$num]=$result[toolname];
								$num++;
                            }
                            
                            $sql2="select tool_id from meeting_booking where book_id='$edit_book_id' ";
                            $dbquery2=@mysql_db_query($dbname, $sql2);
                            $result2=@mysql_fetch_array($dbquery2);
                            $all_tool=$result2[0];
                            $all_tool2=preg_split("[,]", $all_tool);

                            for($i=0;$i<$numrows;$i++){
								if(in_array($tool_id[$i],$all_tool2)){
									$res[$i] = 'checked="checked"';
								}
                            	echo '<div><input type="checkbox" name="checktool['.$i.']" value="'.$tool_id[$i].'" '.$res[$i].' />'.$toolname[$i].'</div>';
                            }
                            ?></td>
                    </tr>
                  	<tr>
                    	<td valign="top" class="blue_bg_color"><div align="right">หมายเหตุ : </div></td>
                    	<td class="yellow_bg_color"><textarea name="comment" cols="30" rows="5" id="comment"><? echo $comment; ?></textarea></td>
                  	</tr>
  					<tr>
                        <td class="blue_bg_color"><div align="right">ลงชื่อผู้จอง : </div></td>
                        <td class="yellow_bg_color"><input  name="namefill" type="text" id="namefill" value="
                        <?php 
                        $sql="select name from user where uid=$userid";
                        $dbquery=@mysql_db_query($dbname, $sql);
                        $result=@mysql_fetch_array($dbquery);
                        
                        $name=$result[0];
                        echo $name; 
                        ?>" size="40" readonly /></td>
 					</tr>
                  <tr>
                    <td class="blue_bg_color">
                    	<div align="right">
                      		<input name="edit" type="hidden" id="edit" value="<? echo $edit_book_id; ?>" />
                    	</div></td>
                    <td class="yellow_bg_color"><input type="button" name="Button" value="แก้ไขการจอง" onclick="chkform2();"/> <input type="reset" name="Submit2" value="ยกเลิก" /></td>
                  </tr>
			</table>
		</form>

      </div> <!--panel-body -->
    </div>
    
</div> <!-- container -->

<? }?>
</body>
</html>
<script language="javascript">
function chkform()
{
	if(document.form1.subject.value == 0)
	{
		alert("กรุณาระบุเรื่องที่ประชุม");
		document.form1.subject.focus();
	}else
	if(document.form1.header.value == 0)
	{
		alert("กรุณาระบุประธานในที่ประชุม");
		document.form1.header.focus();
	}else
	if(document.form1.nummeeting.value == 0)
	{
		alert("กรุณาระบุจำนวนผู้เข้าประชุม1");
		document.form1.nummeeting.focus();
	}else
	if(document.form1.room_id.value == 0)
	{
		alert("กรุณาเลือกห้องประชุม please select room");
		document.form1.room_id.focus();
	}else
	if(document.form1.startdate.value == 0)
	{
		alert("กรุณาเลือกวันใช้ห้อง");
		document.form1.startdate.focus();
	}else
	if(document.form1.starttime.value == 0)
	{
		alert("กรุณาเลือกเวลาเริ่ม");
		document.form1.starttime.focus();
	}else
	if(document.form1.endtime.value == 0)
	{
		alert("กรุณาเลือกเวลาสิ้นสุด");
		document.form1.endtime.focus();
	}else
		document.form1.submit();
}

function check_number() {
e_k=event.keyCode
if (((e_k > 57) || (e_k < 47)) && e_k != 46 && e_k != 13) {
event.returnValue = false;
alert(" กรุณาระบุเป็นตัวเลขเท่านั้น");
}
} 

function chkform2()
{
	if(document.form2.subject.value == 0)
	{
		alert("กรุณาระบุเรื่องที่ประชุม");
		document.form2.subject.focus();
	}else
	if(document.form2.header.value == 0)
	{
		alert("กรุณาระบุประธานในที่ประชุม");
		document.form2.header.focus();
	}else
	if(document.form2.nummeeting.value == 0)
	{
		alert("กรุณาระบุจำนวนผู้เข้าประชุม");
		document.form2.nummeeting.focus();
	}else if(document.form2.namefill.value == 0)
	{
		alert("กรุณาระบุผู้จองห้องประชุม");
		document.form2.namefill.focus();
	}else
		document.form2.submit();
}
</script>