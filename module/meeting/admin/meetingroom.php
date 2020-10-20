<?
	session_start();
	error_reporting(E_ALL^E_NOTICE);
	include '../inc/connect_db.php';
	if(!$_SESSION['admin_id'])
	{
		echo"<script language=\"javascript\">
	  alert(\"please login\");
	window.parent.location='../index.php';
</script>";
	}else
?>
<!DOCTYPE html>
<html >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../mystyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
body {
	margin-top: 20px;
	background-color: #E5E5E5;
}
-->
</style></head>

<body onload="document.form1.roomname.focus();">
<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td class="title_bg_text_no_center_blue"><img src="../images/application_add.gif" width="16" height="16" align="absmiddle" />ห้องประชุม</td>
  </tr>
</table>
<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0" class="borderall_green">
  
  <tr>
    <td>
	<?php
		$edit_room_id=$_GET['edit_room_id'];

		echo "$edit_room_id";
		if(!$edit_room_id)

		{
	?>
	<form action="add-function.php" method="post" enctype="multipart/form-data" name="form1">
	<table width="100%" border="0" cellspacing="3" cellpadding="2">
      <tr class="bg_colorCopy">
        <td colspan="2"><img src="../images/add.gif" width="16" height="16" border="0" align="absmiddle" />รายละเอียดห้องประชุม</td>
        </tr>
      
      <tr>
        <td width="145" class="bg_color"><div align="right">ชื่อห้องประชุม : </div></td>
        <td width="963" class="yellow_bg_color"><input name="roomname" type="text" id="roomname" size="30" /> <span class="redfont">*</span></td>
      </tr>
      <tr>
        <td class="bg_color"><div align="right">สถานที่ : </div></td>
        <td class="yellow_bg_color"><input name="roomplace" type="text" id="roomplace" size="30" /> <span class="redfont">*</span></td>
      </tr>
      <tr>
        <td class="bg_color"><div align="right">ความจุผู้เข้าประชุม : </div></td>
        <td class="yellow_bg_color"><input name="roomcount" type="text" id="roomcount" size="30" /> <span class="redfont">*</span></td>
      </tr>
      <tr>
        <td class="bg_color"><div align="right">เจ้าของ : </div></td>
        <td class="yellow_bg_color"><input name="dept" type="text" id="dept" size="30" />
          <span class="redfont">*</span></td>
      </tr>
      <tr>
        <td class="bg_color"><div align="right">โทรศัพท์ : </div></td>
        <td class="yellow_bg_color"><input name="tel" type="text" id="tel" size="30" />
          <span class="redfont">*</span></td>
      </tr>
      
      <tr>
        <td valign="top" class="bg_color"><div align="right">หมายเหตุ : </div></td>
        <td class="yellow_bg_color"><textarea name="comment" cols="30" rows="5" id="comment"></textarea></td>
      </tr>
      
      <tr>
        <td class="bg_color"><div align="right">ภาพตัวอย่าง : </div></td>
        <td class="yellow_bg_color"><input name="roomimg" type="file" id="roomimg" size="30"  onKeyPress="check_keyboard();"/>
          <span class="redfont">*</span>
          <input name="add_room" type="hidden" id="add_room" value="add_room" /></td>
      </tr>
      <tr>
        <td class="bg_color">&nbsp;</td>
        <td class="yellow_bg_color"><input type="button" name="Button" value="ok"  onclick="chkform();"/> <input type="reset" name="Reset" value="reset" /></td>
      </tr>
    </table>
	</form>
	
	<?
		}else if($edit_room_id)
		{
			$sql="select * from meeting_room where room_id='$edit_room_id' ";
			$dbquery=@mysql_db_query($dbname, $sql);
			$result=@mysql_fetch_array($dbquery);
			
			$roomname=$result[roomname];
			$roomplace=$result[roomplace];
			$roomcount=$result[roomcount];
			$roomimg=$result[roomimg];
			$dept=$result[dept];
			$tel=$result[tel];
			$comment=$result[comment];
	?>
	<form action="edit-function.php" method="post" enctype="multipart/form-data" name="form2">
	<table width="100%" border="0" cellspacing="3" cellpadding="2">
      <tr class="bg_colorCopy">
        <td colspan="2"><img src="../images/drive_edit.gif" width="16" height="16" align="absmiddle" /> ห้องประชุม </td>
        </tr>
      
      <tr>
        <td width="145" class="bg_color"><div align="right">ชื่อห้องประชุม: </div></td>
        <td width="963" class="yellow_bg_color"><input name="roomname" type="text" id="roomname" value="<? echo $roomname; ?>" size="30" />
          <span class="redfont">*</span></td>
      </tr>
      <tr>
        <td class="bg_color"><div align="right">สถานที่: </div></td>
        <td class="yellow_bg_color"><input name="roomplace" type="text" id="roomplace" value="<? echo $roomplace; ?>" size="30" />
          <span class="redfont">*</span></td>
      </tr>
      <tr>
        <td class="bg_color"><div align="right">ความจุผู้เข้าประชุม: </div></td>
        <td class="yellow_bg_color"><input name="roomcount" type="text" id="roomcount" value="<? echo $roomcount; ?>" size="30" />
          <span class="redfont">*</span></td>
      </tr>
      <tr>
        <td class="bg_color"><div align="right">เจ้าของt: </div></td>
        <td class="yellow_bg_color"><input name="dept" type="text" id="dept" value="<? echo $dept; ?>" size="30" />
          <span class="redfont">*</span></td>
      </tr>
      <tr>
        <td class="bg_color"><div align="right">โทรศัพท์: </div></td>
        <td class="yellow_bg_color"><input name="tel" type="text" id="tel" value="<? echo $tel; ?>" size="30" />
          <span class="redfont">*</span></td>
      </tr>
      
      <tr>
        <td valign="top" class="bg_color"><div align="right">หมายเหตุ: </div></td>
        <td class="yellow_bg_color"><textarea name="comment" cols="30" rows="5" id="comment"><? echo $comment; ?></textarea></td>
      </tr>
      

      <tr>
        <td class="bg_color"><div align="right">ภาพห้องประชุม : </div></td>
        <td class="yellow_bg_color"><?
			if($roomimg<>" ")
			{
				echo "<img src='roomimg/$roomimg' border='0' width='150' height='100'>&nbsp;&nbsp;<input type='checkbox' value='1' name='chkdel'>ร…ยบรรยปร€ร’ยพ";
			}else
			{
				echo "<input name=\"roomimg\" type=\"file\" id=\"roomimg\" size=\"30\"  onKeyPress=\"check_keyboard();\"/>";
			}
		?>
          <input name="room_id" type="hidden" id="room_id" value="<? echo $edit_room_id; ?>" />
          <input name="del_roomimg" type="hidden" id="del_roomimg" value="<? echo $roomimg; ?>" /></td>
      </tr>
      <tr>
        <td class="bg_color">&nbsp;</td>
        <td class="yellow_bg_color"><input type="button" name="Button" value="OK"  onclick="chkform2();"/> 
        <input type="reset" name="Reset" value="reset" /></td>
      </tr>
    </table>
	</form>
	<? } ?>	</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="3" cellpadding="2">
      <tr class="bg_colorCopy">
        <td><img src="../images/report.gif" width="16" height="16" align="absmiddle" /> ห้องประชุมอาคารศาลากลางจังหวัดพังงา</td>
      </tr>
      
      <tr>
        <td><table width="78%" height="25" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" bordercolorlight="#999999" bordercolordark="#FFFFFF">
          <tr class="title_table_green">
            <td width="301">ชื่อห้องประชุม</td>
            <td width="349">สถานที่ตั้ง</td>
            <td width="87">รายละเอียด</td>
            <td width="124">แก้ไข/ลบ</td>
          </tr>
		  <?
		  		$sql="select * from meeting_room";
				$dbquery=@mysql_db_query($dbname, $sql);
				
				while($result=@mysql_fetch_array($dbquery))
				{
					$room_id=$result[room_id];
					$roomname=$result[roomname];
					$roomplace=$result[roomplace];
					$roomcount=$result[roomcount];
					$roomimg=$result[roomimg];		
					$dept=$result[dept];
					$tel=$result[tel];
					$comment=$result[comment];		
							
					if($bg == "#DFE6F1") { //รรจรยนยขรยงยกร’ร รร…ร‘ยบรร• 
					$bg = "#F8F7DE";
					} else {
					$bg = "#DFE6F1";
					}
					
					echo"<tr class='text' bgcolor='$bg'>
						<td>&nbsp;$roomname</td>
						<td>&nbsp;$roomplace</td>
						<td align='center'><a href='detail_room.php?room_id=$room_id' class='textnormal' target='_blank'>detail</a></td>
						<td align='center'><a href='meetingroom.php?edit_room_id=$room_id' class='textnormal'>edit</a> | <a href='delete-function.php?del_room_id=$room_id&del_roomimg=$roomimg' class='textnormal'>del</a></td>
					</tr>";
				}
		  ?>
        </table></td>
      </tr>
    </table></td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
<script language="javascript">
function chkform()
{
	if(document.form1.roomname.value == 0)
	{
		alert("ยกรรยณร’รรยบรยชร—รจรรรฉรยงยปรรยชรรยครร‘ยบ");
		document.form1.roomname.focus();
	}else
	if(document.form1.roomplace.value == 0)
	{
		alert("ยกรรยณร’รรยบรรยถร’ยนยทร•รจยตร‘รฉยงยครร‘ยบ");
		document.form1.roomplace.focus();
	}else
	if(document.form1.roomcount.value == 0)
	{
		alert("ยกรรยณร’รรยบรยจร“ยนรยนยครร’รยจรยขรยงยคยนยดรฉรรยครร‘ยบ");
		document.form1.roomcount.focus();
	}else
	if(document.form1.dept.value == "")
	{
		alert("");
		document.form1.dept.focus();
	}else
	if(document.form1.tel.value == "")
	{
		alert("");
		document.form1.tel.focus();
	}else
	if(document.form1.roomimg.value == 0)
	{
		alert("ยกรรยณร’ร ร…ร—รยกรรยปรรฉรยงยปรรยชรรยครร‘ยบ");
		document.form1.roomimg.focus();
	}else
	document.form1.submit();
}

function check_keyboard() 
{
	e_k=event.keyCode
	if (((e_k < 48) || (e_k > 47)) && e_k != 46 && e_k != 13) 
	{
	//if (e_k != 13 && (e_k < 48) || (e_k > 57) || e_k == ) {
	event.returnValue = false;
	alert(" ร ร…ร—ร”รยกรคยฟร…รฌรขยดรยกร’รยกยดยปรรจร Browse...");
	}
}
function chkform2()
{
	if(document.form2.roomname.value == 0)
	{
		alert("ยกรรยณร’รรยบรยชร—รจรรรฉรยงยปรรยชรรยครร‘ยบ");
		document.form2.roomname.focus();
	}else
	if(document.form2.roomplace.value == 0)
	{
		alert("ยกรรยณร’รรยบรรยถร’ยนยทร•รจยตร‘รฉยงยครร‘ยบ");
		document.form2.roomplace.focus();
	}else
	if(document.form2.roomcount.value == 0)
	{
		alert("ยกรรยณร’รรยบรยจร“ยนรยนยครร’รยจรยขรยงยคยนยดรฉรรยครร‘ยบ");
		document.form2.roomcount.focus();
	}else
	document.form2.submit();
}

</script>
<? mysql_close(); ?>