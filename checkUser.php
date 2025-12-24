<?php
session_start();
date_default_timezone_set('Asia/Bangkok');

include 'library/database.php';

$u_name = $_POST['username'] ?? '';
$u_pass = $_POST['password'] ?? '';

$error_message = '';
$success = false;

// 3. ตรวจสอบ Input ก่อน Query
if (empty($u_name)) {
    $error_message = 'โปรดระบุชื่อผู้ใช้';
} elseif (empty($u_pass)) {
    $error_message = 'โปรดระบุรหัสผ่าน';
} else {
    // 4. Query ฐานข้อมูล (ใช้ Prepared Statements)
    $sql = "SELECT u_id, sec_id, dep_id, level_id, u_name, u_pass, status FROM user WHERE u_name = ? AND status <> 0";
    $result = dbQuery($sql, "s", [$u_name]);
    $num = dbNumRows($result);

    if ($num > 0) {
        $row = dbFetchAssoc($result);

        // ตรวจสอบรหัสผ่านด้วย password_verify()
        if (password_verify($u_pass, $row['u_pass'])) {
            $success = true;
        }
        // --- ส่วนเสริม: Auto-Migration (สำหรับย้ายจาก Plaintext เป็น Hash) ---
        elseif ($u_pass === $row['u_pass']) {
            // ถ้ารหัสผ่านตรงกับ Plaintext ในฐานข้อมูล ให้ทำการ Hash และ Update ทันที
            $new_hash = password_hash($u_pass, PASSWORD_BCRYPT);
            $sql_update = "UPDATE user SET u_pass = ? WHERE u_id = ?";
            dbQuery($sql_update, "si", [$new_hash, $row['u_id']]);

            $success = true;
        }

        if ($success) {
            // --- ส่วนที่ Login สำเร็จ ---
            // อัพเดต Last Login Time (ใช้ Prepared Statements)
            $now = date("Y-m-d H:i:s");
            $sqlu = "UPDATE user SET user_last_login = ? WHERE u_id = ?";
            dbQuery($sqlu, "si", [$now, $row['u_id']]);

            // ตั้งค่า Session
            $_SESSION['ses_u_id'] = $row['u_id'];
            $_SESSION['ses_level_id'] = $row['level_id'];
            $_SESSION['ses_dep_id'] = $row['dep_id'];
            $_SESSION['ses_sec_id'] = $row['sec_id'];
            $_SESSION['login_success'] = true;

            header("Location: admin/index_admin.php");
            exit;
        } else {
            $error_message = 'ขออภัย ! รหัสผ่านไม่ถูกต้อง';
        }
    } else {
        $error_message = 'ขออภัย ! เราไม่พบผู้ใช้งานในระบบ';
    }
}

// 6. การจัดการข้อผิดพลาด (โค้ดนี้จะทำงานเฉพาะเมื่อ Login ไม่สำเร็จเท่านั้น)
if (!$success) {
    // ต้อง include header.php เพื่อสร้างโครงสร้าง HTML ก่อนแสดง SweetAlert
    include 'header.php';

    // ต้องรวมไฟล์ SweetAlert JS/CSS ที่จำเป็น (เพราะถูกลบออกจากด้านบนสุดของไฟล์ไปแล้ว)
    // หากไฟล์เหล่านี้ถูกรวมอยู่ใน header.php อยู่แล้ว ให้ลบ 2 บรรทัดนี้
    echo '<link rel="stylesheet" href="css/sweetalert.css">';
    echo '<script src="js/sweetalert.min.js"></script>';

    // แสดง SweetAlert
    echo "<script>
        swal({
            title: '{$error_message}',
            type: 'error',
            showConfirmButton: true
        }, function(isConfirm) {
            if (isConfirm) {
                window.location.href = 'index.php?menu=1';
            }
        });
    </script>";

    // ต้อง include footer.php เพื่อปิดโครงสร้าง HTML
    include 'footer.php';
}


// ไม่ต้องมีโค้ดต่อจากนี้แล้ว เพราะทุกเส้นทางมีการ exit หรือมีการ include footer.php ไปแล้ว
?>