<?php
//require_once 'config.php';

/*$dbConn = mysql_connect ($dbHost, $dbUser, $dbPass) or die ('MySQL connect failed. ' . mysql_error());
mysql_query('SET NAMES utf8');
date_default_timezone_set('Asia/Bangkok');
mysql_select_db($dbName) or die('Cannot select database. ' . mysql_error());*/
/*
$dbConn=new mysqli($dbHost, $dbUser, $dbPass);
$dbConn->query("set names utf8");
$dbConn->select_db($dbName);
*/

$db_config=array(
        "host"=>"localhost",  // กำหนด host
        "user"=>"root", // กำหนดชื่อ user
        "pass"=>"hellojava",   // กำหนดรหัสผ่าน
        "dbname"=>"eoffice",  // กำหนดชื่อฐานข้อมูล
        "charset"=>"utf8"  // กำหนด charset
    );


$dbConn = @new mysqli($db_config["host"], $db_config["user"], $db_config["pass"], $db_config["dbname"]);
if(mysqli_connect_error()) {
    die('Connect Error (' . mysqli_connect_errno() . ') '. mysqli_connect_error());
    exit;
}

if(!$dbConn->set_charset($db_config["charset"])) { // เปลี่ยน charset เป้น utf8 พร้อมตรวจสอบการเปลี่ยน
            printf("Error loading character set utf8: %sn", $mysqli->error);  // ถ้าเปลี่ยนไม่ได้
        }else{
          //  printf("Current character set: %sn", $dbConn->character_set_name()); // ถ้าเปลี่ยนได้
        }
       // echo $dbConn->character_set_name();  // แสดง charset เอา comment ออก
       // echo 'Success... ' . $dbConn->host_info . "n";
      //  $mysqli->close();


function dbQuery($sql)
{   
        global $dbConn;
        $result = $dbConn->query($sql);
	return $result;
}

function dbAffectedRows()  //ส่งจำนวนแถวก่อนดำเนินการ
{
	//global $dbConn;
	
	//return mysql_affected_rows($dbConn);
        return mysqli_affected_rows($dbConn);
}

function dbFetchArray($result) {
          global $dbConn;
          return mysqli_fetch_array($result);
}

function dbFetchAssoc($result)
{
	//return mysql_fetch_assoc($result);
    global $dbConn;
          return mysqli_fetch_assoc($result);
}

function dbFetchRow($result) 
{
	 //return mysqli_fetch_row($result);
    global $dbConn;
         return mysqli_fetch_row($result);
}

function dbFreeResult($result)
{
	//return mysql_free_result($result);
         global $dbConn;
          return mysqli_free_result($result);
}

function dbNumRows($result)
{
	
        global $dbConn;
       // return mysql_num_rows($result);
        return mysqli_num_rows($result);
}

function dbSelect($dbName)
{
	return mysqli_select_db($dbName);
}

function dbInsertId()
{
        global $dbConn;
	return mysqli_insert_id($dbConn);
       
}

function always_run(){
        global $dbConn;
        mysqli_close($dbConn);
        //echo 'end of request. the connection is close automatically';
}
register_shutdown_function('always_run');

?>