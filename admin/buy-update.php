<?php
// buy-update.php (ฉบับปรับปรุง)
include "header.php"; 
// ต้องแน่ใจว่า header.php มีการเรียกใช้ library/database.php และ function.php อยู่แล้ว

if(isset($_POST['update_buy'])){
    // รับค่าจากฟอร์มทั้งหมด
    $buy_id = $_POST['buy_id'];
    $governer = $_POST['governer'];
    $title = $_POST['title'];
    $money_project = $_POST['money_project']; // จำนวนเงินตามโครงการ
    $company = $_POST['company'];
    $manager = $_POST['manager'];
    $add1 = $_POST['add1'];
    $signer = $_POST['signer'];
    $add2 = $_POST['add2'];
    $telphone = $_POST['telphone'];
    $product = $_POST['product'];
    $location = $_POST['location'];
    $date_stop = $_POST['date_stop'];
    $money = $_POST['money']; // จำนวนเงิน (ในสัญญา)
    $bank = $_POST['bank'];
    $brance = $_POST['brance'];
    $doc_num = $_POST['doc_num'];
    $date_num = $_POST['date_num'];
    $date_submit = $_POST['date_submit'];
    
    // คำสั่ง SQL UPDATE
    $sql="UPDATE buy SET 
          governer ='" . dbEscapeString($governer) . "',
          title ='" . dbEscapeString($title) . "',
          money_project =" . dbEscapeString($money_project) . ",
          company ='" . dbEscapeString($company) . "',
          manager ='" . dbEscapeString($manager) . "',
          add1 ='" . dbEscapeString($add1) . "',
          signer ='" . dbEscapeString($signer) . "',
          add2 ='" . dbEscapeString($add2) . "',
          telphone ='" . dbEscapeString($telphone) . "',
          product ='" . dbEscapeString($product) . "',
          location ='" . dbEscapeString($location) . "',
          date_stop ='" . dbEscapeString($date_stop) . "',
          money =" . dbEscapeString($money) . ",
          bank ='" . dbEscapeString($bank) . "',
          brance ='" . dbEscapeString($brance) . "',
          doc_num ='" . dbEscapeString($doc_num) . "',
          date_num ='" . dbEscapeString($date_num) . "',
          date_submit ='" . dbEscapeString($date_submit) . "'
          WHERE buy_id =" . dbEscapeString($buy_id);
    
    $result=dbQuery($sql);
    
    if($result){
        dbQuery("COMMIT");
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
    }else{
        dbQuery("ROLLBACK");
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