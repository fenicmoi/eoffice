
<?php
include 'inc/connect_db.php';
echo "<html>"; 
echo "<head>"; 
echo "<meta  http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">";
echo "<link href=\"mystyle.css\" rel=\"stylesheet\" type=\"text/css\" />";

echo "<link rel=\"stylesheet\" href=\"css/bootstrap.min.css\"/>";
echo "<script src=\"js/jquery.min.js\"></script>";
echo "<script src=\"js/bootstrap.min.js\"></script>";

echo "</head>"; 
echo "<body>"; 
echo "<table class=\"table table-bordered table-hover\" width=\"100%\"  cellpadding=\"0\" cellspacing=\"0\" bordercolor=\"#FFFFFF\" bordercolorlight=\"#999999\" bordercolordark=\"#FFFFFF\" bgcolor=\"#E0E0E0\">"; 
echo "<TR><TD>"; 
$GoToDay = $_GET['txtDay']; 
//echo $GoToDay;

if (!empty($GoToDay)) { 
  $StartDate=date("m/d/y",strtotime ("$GoToDay")); 
} else if (empty($StartDate)) $StartDate=date("m/d/y"); 
echo WriteMonth($StartDate); 

function WriteMonth($StartDate) 
{ 
  $thaimonth=array("มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฏาคม","สิงหาคม","กันยายน","ตุลาคม", "พฤศจิกายน","ธันวาคม");
  
  $WriteMonth="";
  $CurrentDate=date("m/1/y", strtotime ("$StartDate"));
  //echo $CurrentDate;
  $setMonth=date("m",strtotime ($CurrentDate));
  $todaysDate=date("j",strtotime(date("m/d/y")));
  $mmon=date("m",strtotime ($CurrentDate));
  $myear=date("Y",strtotime ($CurrentDate));
  $noOfDays=date("t",strtotime ($CurrentDate)); 
  //echo $noOfDays;

  $WriteMonth.=""; 
  $WriteMonth.="<table width=\"100%\" border=\"1\" cellpadding=\"0\" cellspacing=\"0\" bordercolor=\"#FFFFFF\" bordercolorlight=\"#999999\" bordercolordark=\"#FFFFFF\" >
  <tr>
 
  <td colspan=\"2\" align=\"left\" class=\"title_bg_text_no_center_blue\">"; 
  $WriteMonth.="<a href=\"?txtDay=".date("m/1/y", strtotime ("$CurrentDate -1 months"))." \" class='textwhite'><span class=\"glyphicon glyphicon-backward\"><span> เดือนก่อนหน้า</a></td>
  
  <td colspan=\"3\" align=\"center\"  class=\"title_bg_text_no_center_blue\" ><strong>".$thaimonth[date("m", strtotime ($StartDate)) - 1]." ".(date("Y",strtotime ($StartDate)) + 543); 
  $WriteMonth.="</strong></td>
  
  <td colspan=\"2\" align=\"right\"  class=\"title_bg_text_no_center_blue\" >"; 
  $WriteMonth.="<a href=\"?txtDay=".date("m/1/y", strtotime ("$StartDate +1 months"))."\" class='textwhite'>เดือนถัดไป <span class=\"glyphicon glyphicon-forward\"><span></a>"; 

  $WriteMonth.="</td></tr>
  
  <tr>"; 
  $WriteMonth.="<td align=\"center\" valign=\"top\"  background=\"dayBg.gif\" height=\"25\" width=\"14%\"><B><font color=\"#000066\">อ.</font></B></td>"; 
  $WriteMonth.="<td align=\"center\" valign=\"top\"  background=\"dayBg.gif\" height=\"25\" width=\"14%\"><B><font color=\"#000066\">จ.</font></B></td>"; 
  $WriteMonth.="<td align=\"center\" valign=\"top\"  background=\"dayBg.gif\" height=\"25\" width=\"14%\"><B><font color=\"#000066\">ค.</font></B></td>"; 
  $WriteMonth.="<td align=\"center\" valign=\"top\"  background=\"dayBg.gif\" height=\"25\" width=\"14%\"><B><font color=\"#000066\">พ.</font></B></td>"; 
  $WriteMonth.="<td align=\"center\" valign=\"top\"  background=\"dayBg.gif\" height=\"25\" width=\"14%\"><B><font color=\"#000066\">พฤ.</font></B></td>"; 
  $WriteMonth.="<td align=\"center\" valign=\"top\"  background=\"dayBg.gif\" height=\"25\" width=\"14%\"><B><font color=\"#000066\">ศ.</font></B></td>"; 
  $WriteMonth.="<td align=\"center\" valign=\"top\"  background=\"dayBg.gif\" height=\"25\" width=\"14%\"><B><font color=\"#000066\">ส.</font></B></td>"; 
  $WriteMonth.="</tr>"; 

  $startMonth=date("$myear/$setMonth/01"); 
  //echo $startMonth;
  $endMonth=date("$myear/$setMonth/$noOfDays"); 
 //echo $endMonth;

  $WriteMonth .= "<tr>"; 
  for($i=1;$i<=$noOfDays;$i++)
   { 
    $coolmonth=date("$setMonth/$i/$myear"); //à´×Í¹·Ñé§ËÁ´¢Í§»ÕÃÙ»áºº 01/1/10 à´×Í¹/»Õ/ÇÑ¹
    $TBD=date("j",strtotime ($coolmonth)); //ÇÑ¹·Õè¢Í§ÇÑ¹¹Õé
    $BD=date("j",strtotime ($coolmonth)); //ÇÑ¹·Õè
    $BDay=date("D",strtotime ($coolmonth)); //ÇÑ¹
    if ($todaysDate==$TBD)
	{ 
	  $bgcolor="#6699FF";	 //#004080
      $BD= "<B><font color=\"#B3EC80\">$TBD</font></B>"; 
    } 
	$sql="select * from meeting_booking where conf_status=1 and startdate='$myear-$mmon-$BD' ";
	//echo $sql;
	$dbname="phangnga_office";
	$query=@mysql_db_query($dbname, $sql);
	$result=@mysql_fetch_array($query);
	if($result)
	{
		$bgcolor="#FFCC00";  //#B3EC80
		$BD="<a href='?startdate=$result[startdate]&txtDay=$StartDate' class='text'>$BD</a>";
	}
	
    $BD = "<td align=\"center\" bgcolor = \"$bgcolor\" height=\"50\">$BD</td>"; 
	/*$show=$TBD;
	
	if($result)
	{
		$BD="?startdate=$result[startdate]";
	}*/
	
		switch($BDay)
		{ 
		case 'Sun': 
		$bgcolor="#E8EEF5";	
		  $WriteMonth .= "$BD"; 
		  break; 
		  
		case 'Mon': 
		$bgcolor="#E8EEF5";
		  if ($TBD==1) $WriteMonth .= "<td> </td>"; 
		  $WriteMonth .= "$BD"; 
		  break; 
		  
		case 'Tue': 
		$bgcolor="#E8EEF5";
		  if($TBD==1) $WriteMonth .= "<td> </td><td> </td>"; 
		  $WriteMonth .= "$BD"; 
		  break; 
		  
		case 'Wed': 
		$bgcolor="#E8EEF5";
		  if($TBD==1) $WriteMonth .= "<td> </td><td> </td><td> </td>"; 
		  $WriteMonth .= "$BD"; 
		  break; 
		  
		case 'Thu': 
		$bgcolor="#E8EEF5";
		  if($TBD==1) $WriteMonth .= "<td> </td><td> </td><td> </td><td> </td>"; 
		  $WriteMonth .= "$BD"; 
		  break; 
		  
		case 'Fri': 
		$bgcolor="#E8EEF5";
		  if($TBD==1) $WriteMonth .= "<td> </td><td> </td><td> </td><td> </td><td> </td>"; 
		  $WriteMonth .= "$BD"; 
		  break; 
		  
		case 'Sat': 
		$bgcolor="#FF0033";  // #BCCDE2
		  if($TBD==1) $WriteMonth .= "<td> </td><td> </td><td> </td><td> </td><td> </td><td>;</td>"; 
		  $WriteMonth .= "$BD"; 
		  $WriteMonth .="</tr><tr>"; 
		  break; 
		} 
  } 
  $WriteMonth .="</table>"; 
  return $WriteMonth; 
} 
echo "</TD></TR>"; 
echo "</TABLE>"; 
echo "<BR>"; 
echo "</body>"; 
echo "</html>"; 
?>