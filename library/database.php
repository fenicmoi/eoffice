<?php
require_once 'config.php';

/*$dbConn = mysql_connect ($dbHost, $dbUser, $dbPass) or die ('MySQL connect failed. ' . mysql_error());
mysql_query('SET NAMES utf8');
date_default_timezone_set('Asia/Bangkok');
mysql_select_db($dbName) or die('Cannot select database. ' . mysql_error());*/

$dbConn=new mysqli($dbHost, $dbUser, $dbPass);
if ($dbConn->connect_error) {
    die("Connection failed: " . $dbConn->connect_error);
}
$dbConn->query("set names utf8");
$dbConn->select_db($dbName);

/**
 * ฟังก์ชันสำหรับ Query ฐานข้อมูลโดยใช้ Prepared Statements
 * @param string $sql คำสั่ง SQL ที่มี placeholder (?)
 * @param string $types string ที่ระบุชนิดของตัวแปร (เช่น "ssi" สำหรับ string, string, integer)
 * @param array $params อาร์เรย์ของตัวแปรที่ต้องการ Bind
 * @return mixed ถ้าเป็น SELECT จะคืนค่า mysqli_result ถ้าเป็น INSERT/UPDATE/DELETE จะคืนค่า true/false
 */
function dbQuery($sql, $types = null, $params = null)
{   
    global $dbConn;
    
    // ถ้าไม่มี $params หรือ $types ให้ใช้ query แบบเดิม (ควรใช้ในกรณีที่ไม่รับค่าจากผู้ใช้)
    if (empty($params) || empty($types)) {
        $result = $dbConn->query($sql);
        return $result;
    }

    $stmt = $dbConn->prepare($sql);
    if ($stmt === false) {
        // จัดการข้อผิดพลาดในการเตรียมคำสั่ง
        error_log("MySQL Prepare Error: " . $dbConn->error . "\nSQL: " . $sql);
        return false;
    }

    // bind_param ต้องรับอาร์เรย์เป็น reference
    $bind_names[] = $types;
    for ($i=0; $i<count($params);$i++) {
        $bind_name = 'bind' . $i;
        $$bind_name = $params[$i];
        $bind_names[] = &$$bind_name;
    }

    call_user_func_array(array($stmt, 'bind_param'), $bind_names);

    if (!$stmt->execute()) {
        error_log("MySQL Execute Error: " . $stmt->error . "\nSQL: " . $sql);
        $stmt->close();
        return false;
    }
    
    // ถ้าเป็น SELECT ให้คืนค่าผลลัพธ์
    if ($stmt->field_count > 0) {
        $result = $stmt->get_result();
        $stmt->close();
        return $result;
    }

    // ถ้าเป็น INSERT, UPDATE, DELETE ให้คืนค่า true/false และ close statement
    $stmt->close();
    return true;
}

// ... ฟังก์ชันอื่นๆ (dbAffectedRows, dbFetchArray, ฯลฯ) ไม่ต้องเปลี่ยน

function dbAffectedRows()
{
	global $dbConn;
        return mysqli_affected_rows($dbConn);
}

function dbFetchArray($result) {
          global $dbConn;
          return mysqli_fetch_array($result);
}

function dbFetchAssoc($result)
{
    global $dbConn;
          return mysqli_fetch_assoc($result);
}

function dbFetchRow($result) 
{
    global $dbConn;
         return mysqli_fetch_row($result);
}

function dbFreeResult($result)
{
    global $dbConn;
          return mysqli_free_result($result);
}

function dbNumRows($result)
{
    global $dbConn;
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

function dbEscapeString($text)
{
    global $dbConn;
    // ใช้ mysqli_real_escape_string เนื่องจากมีการสร้าง $dbConn เป็นวัตถุ mysqli
    return mysqli_real_escape_string($dbConn, $text); 
}

function always_run(){
        global $dbConn;
        if ($dbConn) {
            mysqli_close($dbConn);
        }
        //echo 'end of request. the connection is close automatically';
}
register_shutdown_function('always_run');

?>