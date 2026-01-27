<?php
include "../library/database.php";
include "../library/config.php";
include "../library/security.php";

// Check if form is submitted
if (isset($_POST['update'])) {

    // CSRF Validation (optional but recommended if implemented)
    // if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
    //     die("CSRF token validation failed."); 
    // }

    $u_id = $_POST['u_id'];

    // Retrieve values
    $sec_id = $_POST['district'];
    $dep_id = $_POST['amphur'];
    // For admin level (<=2), type_id/province might be used but dep_id is critical for user table usually
    // user_edit.php logic used $_POST['province'] to help UI but updated DB with sec_id, dep_id

    $level_id = $_POST['level'];
    $u_name = $_POST['u_name'];

    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $position = $_POST['position'];
    $date_create = $_POST['date_user'];
    $status = $_POST['status'];
    $email = $_POST['email'];
    $telphone = $_POST['telphone'];
    $keyman = isset($_POST['keyman']) ? $_POST['keyman'] : 0;

    // Password Handling
    // Fetch current password hash to keep it if not changed
    $sqlCheck = "SELECT u_pass FROM user WHERE u_id = ?";
    $resCheck = dbQuery($sqlCheck, "i", [(int) $u_id]);
    $rowCheck = dbFetchAssoc($resCheck);
    $current_hash = $rowCheck['u_pass'];

    if (!empty($_POST['u_pass'])) {
        $u_pass = password_hash($_POST['u_pass'], PASSWORD_BCRYPT);
    } else {
        $u_pass = $current_hash;
    }

    // Update Query
    $sql = "UPDATE user 
            SET sec_id = ?,
                dep_id = ?,
                level_id = ?,
                u_name = ?,
                u_pass = ?,
                firstname = ?,
                lastname = ?,
                position = ?,
                date_create = ?,
                status = ?,
                email = ?,
                telphone = ?,
                keyman = ?
            WHERE u_id = ?";

    $result = dbQuery($sql, "iiissssssisssi", [
        (int) $sec_id,
        (int) $dep_id,
        (int) $level_id,
        $u_name,
        $u_pass,
        $firstname,
        $lastname,
        $position,
        $date_create,
        $status,
        $email,
        $telphone,
        $keyman,
        (int) $u_id
    ]);

    if (!$result) {
        // Error
        echo "<script>
            alert('มีบางอย่างผิดพลาด กรุณาตรวจสอบ');
            window.location.href='user.php';
        </script>";
    } else {
        // Success
        echo "<script>
            alert('แก้ไขข้อมูลเรียบร้อยแล้ว');
            window.location.href='user.php';
        </script>";
    }

} else {
    // If accessed directly without POST
    header("Location: user.php");
    exit();
}
?>