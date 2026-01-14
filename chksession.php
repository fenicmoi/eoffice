<?php
ob_start();
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}

// ตรวจสอบว่ามีการล็อกอินหรือไม่
if (empty($_SESSION['ses_u_id'])) {
	// ถ้าไม่ได้ล็อกอิน ให้ส่งกลับไปหน้า index.php
	// จัดการเรื่อง Path สำหรับ Windows (backslashes)
	$current_path = str_replace('\\', '/', $_SERVER['PHP_SELF']);
	$redirect_path = (strpos($current_path, '/admin/') !== false) ? '../index.php' : 'index.php';
	header("Location: $redirect_path");
	exit();
}
?>