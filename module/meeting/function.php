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
  
    return [$yid,$yname,$ystatus];
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
  
    return [$yid,$yname,$ystatus];
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

?>  





