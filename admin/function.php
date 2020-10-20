<?php
//****************  function อื่นๆ ******************/
function DateThai()  //ส่งแค่ วัน/เดือน/ปี  ณ เวลาปัจจุบัน
{
    $strDate=date('Y-m-d');
		$strYear = date("Y",strtotime($strDate))+543;
		$strMonth= date("n",strtotime($strDate));
		$strDay= date("j",strtotime($strDate));
                $strHour=date("h",  strtotime($strDate));
                $strMinute=date("i",  strtotime($strDate));
		$strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
		$strMonthThai=$strMonthCut[$strMonth];
        return "$strDay $strMonthThai $strYear";
}

function timeDate($d){   //ฟังค์ชั่นดึงเฉพาะเวลาจากฐานข้อมูล
        $strHour=substr($d,12,16);
        return "$strHour";
}

function thaiDate($changDate){  //แปลงวันเดือนปีจากฐานข้อมูลกลับมาเป็นภาษาไทย นำออกมาจากฐานข้อูล   2018-10-01
    $tDate=  explode('-', $changDate);  //แยก ปี เดือน วัน ด้วยเครื่องหมาย - 
    $y=$tDate[0]+543;      //2018+543  =  2561
    $m=$tDate[1];          //10
    $d=$tDate[2];          //01  
    
    $d=  substr($d,0,2);
    $strMonthCut =array("01"=>"ม.ค.","02"=>"ก.พ","03"=>"มี.ค.","04"=>"เม.ย.","05"=>"พ.ค.","06"=>"มิ.ย.","07"=>"ก.ค.","08"=>"ส.ค.","09"=>"ก.ย.","10"=>"ต.ค.","11"=>"พ.ย.","12"=>"ธ.ค.");
    $strMonthThai=$strMonthCut[$m];
    return "$d $strMonthThai $y";
}
        
function beYear(){  //ส่งเฉพาะปี พ.ศ. เป็นปีไทย
    $adDate=date('Y-m-d');
    $beDate=$adDate+543;                   
    return $beDate;
}

function runNum(){
    global $conn;
    $sqlYear="SELECT * FROM sys_year WHERE status=1";
    $result=  mysqli_query($conn, $sqlYear);
    $row=  mysqli_fetch_array($result);
    $data[0]=$row['yid'];
    $data[1]=$row['yname'];
    echo $data[0].":".$data[1];
   // echo $data[1];
    
}

function checkMenu($level_id){
      switch ($level_id){
                case 1:
                     $menu="menu1.php";
                    $_SESSION['level']=1;
                    break;
                case 2:
                     $menu="menu2.php";
                    $_SESSION['level']=2;
                    break;
                case 3:
                    $menu="menu3.php";
                    $_SESSION['level']=3;
                    break;
                case 4:
                    $menu="menu4.php";
                    $_SESSION['level']=4;
                    break;
                case 5:
                $menu="menu4.php";
                $_SESSION['level']=5;
            }
            return $menu;
}

function chkYear(){   //ตรวจสอบปีปัจจุบัน โดยสถานะต้องเป็น 1  เท่านั้น
    $curDate=date('Y-m-d');
    $curYear=substr($curDate,0,4)+543;

    $sql="select * from sys_year where status=1";
    $result=  dbQuery($sql);
    $row= dbFetchArray($result);
    $yid=$row['yid'];
    $yname=$row['yname'];
    $ystatus=$row['status'];
  
    return array($yid,$yname,$ystatus);

    
    //return "ปีพ.ศ.ปัจจุบัน=".$curYear."ปี พ.ศ.ฐานข้อมูลคือ=".$dbYear;
    //return  "$curYear";
}

function chkYearMonth(){   //ใช้สำหรับทะเบียนคุมเอกสารที่เกี่ยวกับปีงบประมาณด้านการเงิน
    $curDate=date('Y-m-d');
    $curYear=substr($curDate,0,4)+543;

    $sql="select * from year_money where status=1";
    $result=  dbQuery($sql);
    $row= dbFetchArray($result);
    $yid=$row['yid'];
    $yname=$row['yname'];
    $ystatus=$row['status'];
  
    return array($yid,$yname,$ystatus);
    //return "ปีพ.ศ.ปัจจุบัน=".$curYear."ปี พ.ศ.ฐานข้อมูลคือ=".$dbYear;
    //return  "$curYear";
}


function hit($table,$cid){
    global $conn;
    $sql="SELECT hit FROM $table WHERE cid=$cid";
    $result=dbQuery($sql);
    $row=dbFetchAssoc($result);
    $hit=$row['hit'];
    $hit++;
    $sql="UPDATE $table SET hit=$hit WHERE cid=$cid";
    dbQuery($sql);
    
}

//  คืนจำนวนวัน
function getNumDay($d1,$d2){
$dArr1    = preg_split("/-/", $d1);
list($year1, $month1, $day1) = $dArr1;
@$Day1 =  mktime(0,0,0,$month1,$day1,$year1);
 
$dArr2    = preg_split("/-/", $d2);
list($year2, $month2, $day2) = $dArr2;
$Day2 =  mktime(0,0,0,$month2,$day2,$year2);
 
return round(abs( $Day2 - $Day1 ) / 86400 )+1;
}  

//เปรียบเทียบวันที่กับฐานข้อมูล
function DateDiff($strDate1,$strDate2){
	return (strtotime($strDate2) - strtotime($strDate1))/  ( 60 * 60 * 24 );  // 1 day = 60*60*24
}


//แสดงเดือนบนปฏิทินการจองห้องประชุม
function WriteMonth($StartDate) { 
  $bgcolor="FFFFFF";
  $thaimonth=array("มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฏาคม","สิงหาคม","กันยายน","ตุลาคม", "พฤศจิกายน","ธันวาคม");
  
  $WriteMonth="";
  $CurrentDate=date("m/1/y", strtotime ("$StartDate"));    //เดือน-1-ปี
  //print $CurrentDate;  
  //$CurrentDate = date("Y-m-d",strtotime("$StartDate"));
  //print $CurrentDate;
  $setMonth=date("m",strtotime ($CurrentDate));   //return  01-12
  $todaysDate=date("j",strtotime(date("m/d/y"))); //teturn  01-31
  $mmon=date("m",strtotime ($CurrentDate));       //return 01-12 
  $myear=date("Y",strtotime ($CurrentDate));      //return  cirstsakkrat
  $noOfDays=date("t",strtotime ($CurrentDate));   //return  

  $WriteMonth.=""; 
  $WriteMonth.="
  <table class=\"table table-bordered\">
  <tr>
  <td colspan=\"2\"  align=\"left\" height=\"25\">"; 
  $WriteMonth.="<a href=\"?txtDay=".date("m/1/y", strtotime ("$CurrentDate -1 months"))." \" ><span class=\"glyphicon glyphicon-backward\"><span>เดือนก่อนหน้า</a>
  </td>
  
  <td colspan=\"3\" align=\"center\">
    <strong><h4>".$thaimonth[date("m", strtotime ($StartDate)) - 1]." ".(date("Y",strtotime ($StartDate)) + 543); 
    $WriteMonth.="</strong></h4>
  </td>
  
  <td colspan=\"2\" align=\"right\">"; 
  $WriteMonth.="<a href=\"?txtDay=".date("m/1/y", strtotime ("$StartDate +1 months"))."\" class='textwhite'>เดือนถัดไป <span class=\"glyphicon glyphicon-forward\"><span></a>"; 

  $WriteMonth.="</td></tr>
  
  <tr>"; 
  $WriteMonth.="<td align=\"center\"   height=\"25\" width=\"14%\"><B><font color=\"#000066\">อาทิตย์</font></B></td>"; 
  $WriteMonth.="<td align=\"center\"   height=\"25\" width=\"14%\"><B><font color=\"#000066\">จันทร์</font></B></td>"; 
  $WriteMonth.="<td align=\"center\"   height=\"25\" width=\"14%\"><B><font color=\"#000066\">อังคาร</font></B></td>"; 
  $WriteMonth.="<td align=\"center\"   height=\"25\" width=\"14%\"><B><font color=\"#000066\">พุธ</font></B></td>"; 
  $WriteMonth.="<td align=\"center\"   height=\"25\" width=\"14%\"><B><font color=\"#000066\">พฤหัสบดี</font></B></td>"; 
  $WriteMonth.="<td align=\"center\"   height=\"25\" width=\"14%\"><B><font color=\"#000066\">ศุกร์</font></B></td>"; 
  $WriteMonth.="<td align=\"center\"   height=\"25\" width=\"14%\"><B><font color=\"#000066\">เสาว์</font></B></td>"; 
  $WriteMonth.="</tr>"; 

  $startMonth=date("$myear/$setMonth/01"); 
  $endMonth=date("$myear/$setMonth/$noOfDays"); 

  $WriteMonth .= "<tr>"; 
  for($i=1;$i<=$noOfDays;$i++){ 
    $coolmonth=date("$setMonth/$i/$myear"); //à´×Í¹·Ñé§ËÁ´¢Í§»ÕÃÙ»áºº 01/1/10 à´×Í¹/»Õ/ÇÑ¹
    $TBD=date("j",strtotime ($coolmonth)); //ÇÑ¹·Õè¢Í§ÇÑ¹¹Õé
    $BD=date("j",strtotime ($coolmonth)); //ÇÑ¹·Õè
    $BDay=date("D",strtotime ($coolmonth)); //ÇÑ¹
    if ($todaysDate==$TBD){ 
	  $bgcolor="#6699FF";	 //#004080
      $BD= "<B><font color=\"#B3EC80\">$TBD</font></B>"; 
    } 
    $sql="select * from meeting_booking where conf_status<>0 and startdate='$myear-$mmon-$BD' ";
    $query = dbQuery($sql);
    $result = dbFetchArray($query);
	if($result){
		$bgcolor="#FFCC00";  //#B3EC80
		$BD="<a href='?startdate=$result[startdate]&txtDay=$StartDate'>$BD</a>";
	}
	
    $BD = "<td align='center' bgcolor='$bgcolor' height='50'>$BD</td>";
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

?>  





