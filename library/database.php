<?php
require_once 'config.php';
require_once 'security.php';

// **การเชื่อมต่อฐานข้อมูลแบบ Object Oriented (mysqli)**
$dbConn = new mysqli($dbHost, $dbUser, $dbPass);
if ($dbConn->connect_error) {
    die("Connection failed: " . $dbConn->connect_error);
}
$dbConn->query("set names utf8");
$dbConn->select_db($dbName);

/**
 * ฟังก์ชันสำหรับ Query ฐานข้อมูลโดยใช้ Prepared Statements (แบบที่นิยม/ปลอดภัย)
 * @param string $sql คำสั่ง SQL ที่มี placeholder (?)
 * @param string $types string ที่ระบุชนิดของตัวแปร (เช่น "ssi" สำหรับ string, string, integer)
 * @param array $params อาร์เรย์ของตัวแปรที่ต้องการ Bind
 * @return mixed ถ้าเป็น SELECT จะคืนค่า mysqli_result ถ้าเป็น INSERT/UPDATE/DELETE จะคืนค่า true/false
 */
function dbQuery($sql, $types = null, $params = null)
{
    global $dbConn;

    // **รูปแบบการเรียกใช้ทั่วไป (ไม่รับค่าจากผู้ใช้)**
    if (empty($params) || empty($types)) {
        $result = $dbConn->query($sql);
        if ($result === false) {
            error_log("MySQL Query Error: " . $dbConn->error . "\nSQL: " . $sql);
        }
        return $result;
    }

    // **รูปแบบ Prepared Statements (แบบที่นิยม/ปลอดภัย)**
    $stmt = $dbConn->prepare($sql);
    if ($stmt === false) {
        error_log("MySQL Prepare Error: " . $dbConn->error . "\nSQL: " . $sql);
        return false;
    }

    // Bind parameters
    $bind_names[] = $types;
    for ($i = 0; $i < count($params); $i++) {
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

    // ถ้าเป็น INSERT, UPDATE, DELETE 
    $stmt->close();
    return true; // สำเร็จ
}

// **ฟังก์ชันมาตรฐานสำหรับการจัดการผลลัพธ์**
function dbAffectedRows()
{
    global $dbConn;
    return mysqli_affected_rows($dbConn);
}

function dbFetchArray($result)
{
    global $dbConn;
    if ($result instanceof mysqli_result) {
        return mysqli_fetch_array($result);
    }
    return false;
}

function dbFetchAssoc($result)
{
    global $dbConn;
    if ($result instanceof mysqli_result) {
        return mysqli_fetch_assoc($result);
    }
    return false;
}

function dbFetchRow($result)
{
    global $dbConn;
    if ($result instanceof mysqli_result) {
        return mysqli_fetch_row($result);
    }
    return false;
}

function dbFreeResult($result)
{
    global $dbConn;
    if ($result instanceof mysqli_result) {
        return mysqli_free_result($result);
    }
    return false;
}

function dbNumRows($result)
{
    // ตรวจสอบว่าเป็น Object ของ mysqli_result ก่อน
    if ($result instanceof mysqli_result) {
        return $result->num_rows;
    }
    return 0; // คืนค่า 0 หากไม่ใช่ผลลัพธ์ที่ถูกต้อง
}

/**
 * ฟังก์ชันสำหรับตั้งค่าตัวชี้ผลลัพธ์กลับไปที่แถวเริ่มต้น (จำเป็นสำหรับวนลูปซ้ำ)
 */
function dbdataSeek($result, $row_number)
{
    global $dbConn;
    if ($result instanceof mysqli_result) {
        return $result->data_seek($row_number);
    }
    return false;
}

function dbInsertId()
{
    global $dbConn;
    return mysqli_insert_id($dbConn);
}

function dbEscapeString($text)
{
    global $dbConn;
    return mysqli_real_escape_string($dbConn, $text);
}

function always_run()
{
    global $dbConn;
    if ($dbConn instanceof mysqli && !$dbConn->connect_error) {
        $dbConn->close();
    }
}
register_shutdown_function('always_run');
?>