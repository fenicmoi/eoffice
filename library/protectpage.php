<?php  
if (!defined('IS_SYSTEM_RUNNING')) {
    // กำหนด URL ของหน้าหลัก
    $homepage_url = 'index.php'; 

    // ตั้งค่าหัว (Header) เพื่อเปลี่ยนเส้นทางไปยังหน้าหลัก
    header('Location: ' . $homepage_url);
    
    // ตั้งสถานะ HTTP เป็น 302 Found (หรือ 301/303)
    http_response_code(302); 
    
    // หยุดการทำงานของสคริปต์หลังจากส่ง Header แล้ว
    exit('กำลังเปลี่ยนเส้นทาง...'); 
}
?>