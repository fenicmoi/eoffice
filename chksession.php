<?php
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}

// ตรวจสอบว่ามีการล็อกอินหรือไม่
if (!isset($_SESSION['ses_u_id']) || $_SESSION['login_success'] !== true) {
	// ถ้าไม่ได้ล็อกอิน ให้ส่งกลับไปหน้า index.php (หน้าหลักที่มีฟอร์มล็อกอิน)
	// ใช้ path ที่ถูกต้องสำหรับไฟล์ในโฟลเดอร์ admin
	$redirect_path = (strpos($_SERVER['PHP_SELF'], '/admin/') !== false) ? '../index.php' : 'index.php';
	header("Location: $redirect_path");
	exit();
}
?>