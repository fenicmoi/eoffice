<?php
ob_start();
session_start();
if(!isset($_SESSION['ses_u_id'])){
	header("location:../index.php");
	exit;
}



include 'header.php';
if (isset($_SESSION['login_success']) && $_SESSION['login_success'] === true) {
    
    // **ต้องมั่นใจว่าไฟล์ SweetAlert JS/CSS ถูกรวมไว้ในหน้านี้แล้ว** // หรือรวมอยู่ใน header.php ที่เรียกใช้ในหน้านี้

    echo "<script>
        // SweetAlert ที่แสดงเครื่องหมายถูก
        swal({
            title: 'Have a good Day!',
            text: 'ยินดีต้อนรับเข้าสู่ระบบ E-Office ',
            type: 'success', // **ใช้ 'success' เพื่อแสดงเครื่องหมายถูก**
            timer: 2000, // แสดง 2 วินาทีแล้วปิดเอง
            showConfirmButton: false
        });
    </script>";
    
    // ลบ Session นี้ทิ้งทันที เพื่อไม่ให้แสดงซ้ำเมื่อมีการ Refresh หน้า
    unset($_SESSION['login_success']); 
}

include 'deskboard.php';
include 'footer.php';
?>
