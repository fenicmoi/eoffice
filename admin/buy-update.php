<?php
// buy-update.php (ฉบับปรับปรุง)
include "header.php";
include "../library/security.php";

if (isset($_POST['update_buy'])) {
    if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
        die("CSRF token validation failed.");
    }

    // รับค่าจากฟอร์มทั้งหมด
    $buy_id = (int) $_POST['buy_id'];
    $governer = $_POST['governer'];
    $title = $_POST['title'];
    $money_project = (float) $_POST['money_project'];
    $company = $_POST['company'];
    $manager = $_POST['manager'];
    $add1 = $_POST['add1'];
    $signer = $_POST['signer'];
    $add2 = $_POST['add2'];
    $telphone = $_POST['telphone'];
    $product = $_POST['product'];
    $location = $_POST['location'];
    $date_stop = $_POST['date_stop'];
    $money = (float) $_POST['money'];
    $bank = $_POST['bank'];
    $brance = $_POST['brance'];
    $doc_num = $_POST['doc_num'];
    $date_num = $_POST['date_num'];
    $date_submit = $_POST['date_submit'];

    // คำสั่ง SQL UPDATE ใช้ Prepared Statements
    $sql = "UPDATE buy SET 
          governer = ?,
          title = ?,
          money_project = ?,
          company = ?,
          manager = ?,
          add1 = ?,
          signer = ?,
          add2 = ?,
          telphone = ?,
          product = ?,
          location = ?,
          date_stop = ?,
          money = ?,
          bank = ?,
          brance = ?,
          doc_num = ?,
          date_num = ?,
          date_submit = ?
          WHERE buy_id = ?";

    $params = [
        $governer,
        $title,
        $money_project,
        $company,
        $manager,
        $add1,
        $signer,
        $add2,
        $telphone,
        $product,
        $location,
        $date_stop,
        $money,
        $bank,
        $brance,
        $doc_num,
        $date_num,
        $date_submit,
        $buy_id
    ];
    $types = "ssissssssssssdssssi"; // d for double/float if supported, s if not. dbQuery usually handles s/i. Let's use d for money.

    // Check types: money_project (d), money (d), buy_id (i)
    $types = "ssissssssssssdssssi"; // Wait, money_project is float, money is float.
    // Let's use "ssdssssssssssddsssi"
    // 0: s (governer)
    // 1: s (title)
    // 2: d (money_project)
    // 3: s (company)
    // 4: s (manager)
    // 5: s (add1)
    // 6: s (signer)
    // 7: s (add2)
    // 8: s (telphone)
    // 9: s (product)
    // 10: s (location)
    // 11: s (date_stop)
    // 12: d (money)
    // 13: s (bank)
    // 14: s (brance)
    // 15: s (doc_num)
    // 16: s (date_num)
    // 17: s (date_submit)
    // 18: i (buy_id)
    $types = "ssdssssssssssddsssi";

    $result = dbQuery($sql, $types, $params);

    if ($result) {
        echo "<script>
        swal({
            title:'แก้ไขข้อมูลเรียบร้อย',
            type:'success',
            showConfirmButton:true
            },
            function(isConfirm){
                if(isConfirm){
                    window.location.href='buy.php';
                }
            }); 
        </script>";
    } else {
        echo "<script>
        swal({
            title:'มีบางอย่างผิดพลาด! กรุณาตรวจสอบ',
            type:'error',
            showConfirmButton:true
            },
            function(isConfirm){
                if(isConfirm){
                    window.location.href='buy.php';
                }
            }); 
        </script>";
    }
}
?>