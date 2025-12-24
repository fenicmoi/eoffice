<?php
include '../library/database.php';
include_once 'function.php';

if (isset($_POST['save'])) {
    $type_id = $conn->real_escape_string($_POST['province']);
    $dep_id = $conn->real_escape_string($_POST['amphur']);
    $sec_id = $conn->real_escape_string($_POST['district']);
    $level_id = $conn->real_escape_string($_POST['level_id']);
    $u_name = $conn->real_escape_string($_POST['u_name']);
    $u_pass = $conn->real_escape_string($_POST['u_pass']);
    $firstname = $conn->real_escape_string($_POST['firstname']);
    $lastname = $conn->real_escape_string($_POST['lastname']);
    $position = $conn->real_escape_string($_POST['position']);
    $date_create = $conn->real_escape_string($_POST['date_user']);
    $status = $conn->real_escape_string($_POST['status']);
    $u_pass_hashed = password_hash($u_pass, PASSWORD_BCRYPT);

    $sqlCheck = "SELECT u_id FROM user WHERE u_name = ?";
    $result = dbQuery($sqlCheck, "s", [$u_name]);
    $numrow = dbNumRows($result);

    if ($numrow >= 1) {
        echo "<script>swal(\"ชื่อผู้ใช้ซ้ำ!\") </script>";
        echo "<meta http-equiv='refresh' content='1;URL=user.php'>";
    } else {
        $sql = "INSERT INTO user(sec_id, dep_id, level_id, u_name, u_pass, firstname, lastname, position, date_create, status, email)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $result = dbQuery($sql, "iiissssssis", [
            (int) $sec_id,
            (int) $dep_id,
            (int) $level_id,
            $u_name,
            $u_pass_hashed,
            $firstname,
            $lastname,
            $position,
            $date_create,
            (int) $status,
            $email
        ]);

        echo "<meta http-equiv='refresh' content='1;URL=user.php'>";
        echo "<script>swal(\"Good job!\", \"บันทึกข้อมูลเรียบร้อยแล้ว\", \"success\")</script>";
        if (!$result) {
            error_log("Insert error in crud_FromSendProvince.php");
        }
    }
}

if (isset($_GET['del'])) {
    $sql = "DELETE FROM depart WHERE dep_id = ?";
    dbQuery($sql, "i", [(int) $_GET['del']]);
    echo "<meta http-equiv='refresh' content='1;URL=depart.php'>";
}

if (isset($_GET['edit'])) {
    $sql = "SELECT * FROM user WHERE u_id = ?";
    $result = dbQuery($sql, "i", [(int) $_GET['edit']]);
    $getROW = dbFetchArray($result);
    //echo "<meta http-equiv='refresh' content='1;URL=object.php'>";
}

if (isset($_POST['update'])) {
    $sql = "UPDATE depart
            SET type_id = ?,
                dep_name = ?,
                address = ?,
                phone = ?,
                fax = ?,
                social = ?,
                status = ?,
                local_num = ?
            WHERE dep_id = ?";

    $result = dbQuery($sql, "isssssiii", [
        (int) $_POST['officeType'],
        $_POST['dep_name'],
        $_POST['address'],
        $_POST['tel'],
        $_POST['fax'],
        $_POST['website'],
        (int) $_POST['status'],
        (int) $_POST['local_num'],
        (int) $_GET['edit']
    ]);

    echo "<script>swal(\"Good job!\", \"แก้ไขข้อมูลแล้ว!\", \"success\")</script>";
    echo "<meta http-equiv='refresh' content='1;URL=user.php'>";
}
?>