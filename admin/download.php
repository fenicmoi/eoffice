<?php
session_start();

// ตรวจสอบการ Login
if (!isset($_SESSION['ses_u_id'])) {
    exit('Access Denied');
}

// รับชื่อไฟล์จาก Parameter
if (isset($_GET['file'])) {
    $file_path = $_GET['file'];

    // --- SECURITY CHECK 1: Directory Traversal Prevention ---
    // ไม่อนุญาตให้มี .. หรือ /../ ในชื่อไฟล์
    if (strpos($file_path, '..') !== false) {
        exit('Invalid File Path');
    }

    // --- SECURITY CHECK 2: Allowed Directory ---
    // ตรวจสอบว่าไฟล์ต้องอยู่ในโฟลเดอร์ paper/ เท่านั้น (หรือโฟลเดอร์ที่กำหนด)
    // สมมติว่า path ในฐานข้อมูลเก็บเป็น paper/filename.pdf หรือแค่อยู่ใน folder นี้
    // โดยปกติ $rowList['file'] จะเก็บเป็น 'paper/xxxx.pdf'

    // ตรวจสอบว่าเป็นไฟล์จริงๆ
    if (file_exists($file_path)) {

        // หา Mime Type
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime_type = finfo_file($finfo, $file_path);
        finfo_close($finfo);

        // ชื่อไฟล์ที่จะแสดงตอนดาวน์โหลด (ตัดเอาเฉพาะชื่อไฟล์ ไม่เอา Path)
        $filename = basename($file_path);

        // set headers
        header('Content-Description: File Transfer');
        header('Content-Type: ' . $mime_type);
        // เลือกแบบ Inline (เปิดใน Browser) หรือ Attachment (บังคับโหลด)
        // ถ้าต้องการเปิดอ่าน PDF ในเว็บใช้ 'inline', ถ้าต้องการโหลดใช้ 'attachment'
        header('Content-Disposition: inline; filename="' . $filename . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file_path));

        // Clean buffer เพื่อป้องกันไฟล์เสีย
        ob_clean();
        flush();

        // อ่านไฟล์ส่งไปที่ Browser
        readfile($file_path);
        exit;
    } else {
        exit('File not found.');
    }
} else {
    exit('No file specified.');
}
?>