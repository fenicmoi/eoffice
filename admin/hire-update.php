<?php
// hire-update.php
include "header.php";
//include 'function.php';

//include '../library/database.php';


if (isset($_POST['update_hire'])) {
    if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
        die("CSRF token validation failed.");
    }
    if ($level_id >= 3) {
        $sqlBase .= " AND h.dep_id = " . (int) $dep_id . " ";
    }
    $hire_id = $_POST['hire_id'];
    $title = $_POST['title'];
    $money = $_POST['money'];
    $employee = $_POST['employee'];
    $datehire = $_POST['datehire'];
    $date_submit = $_POST['date_submit'];
    $signer = $_POST['signer'];
    $guarantee = $_POST['guarantee'];

    $sql = "UPDATE hire SET 
          title = ?,
          money = ?,
          employee = ?,
          date_hire = ?,
          date_submit = ?,
          signer = ?,
          guarantee = ?
          WHERE hire_id = ?";

    $result = dbQuery($sql, "ssssssii", [$title, $money, $employee, $datehire, $date_submit, $signer, $guarantee, (int) $hire_id]);
    //print $sql;
    $result = dbQuery($sql);

    if ($result) {
        dbQuery("COMMIT");
        // ส่วนที่ 3: การดึงข้อมูลพร้อมการจัดเรียงและการจำกัดจำนวน (Ordering and Limiting)
        $orderColumn = $columns[$requestData['order'][0]['column']];
        $orderDir = strtoupper($requestData['order'][0]['dir']) === 'ASC' ? 'ASC' : 'DESC';
        $start = (int) $requestData['start'];
        $length = (int) $requestData['length'];

        $sql .= " ORDER BY $orderColumn $orderDir LIMIT $start, $length";
        $query = dbQuery($sql) or die("section 3");
        echo "<script>
        swal({
            title:'แก้ไขข้อมูลเรียบร้อย',
            type:'success',
            showConfirmButton:true
            },
            function(isConfirm){
                if(isConfirm){
                    window.location.href='hire.php';
                }
            }); 
        </script>";
    } else {
        dbQuery("ROLLBACK");
        echo "<script>
        swal({
            title:'มีบางอย่างผิดพลาด! กรุณาตรวจสอบ',
            type:'error',
            showConfirmButton:true
            },
            function(isConfirm){
                if(isConfirm){
                    window.location.href='hire.php';
                }
            }); 
        </script>";
    }
}
?>