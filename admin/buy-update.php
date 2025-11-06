<?php
// buy-update.php
include "header.php"; 
// ต้องแน่ใจว่า header.php มีการเรียกใช้ library/database.php และ function.php อยู่แล้ว

if(isset($_POST['update_buy'])){
    // รับค่าจากฟอร์ม
    $buy_id = $_POST['buy_id'];
    $title = $_POST['title'];
    $money = $_POST['money']; // จำนวนเงิน (ในสัญญา)
    $money_project = $_POST['money_project']; // จำนวนเงินตามโครงการ
    $company = $_POST['company'];
    $date_stop = $_POST['date_stop'];
    $date_submit = $_POST['date_submit'];
    $signer = $_POST['signer'];

    // คำสั่ง SQL UPDATE
    $sql="UPDATE buy SET 
          title ='" . dbEscapeString($title) . "',
          money =" . dbEscapeString($money) . ",
          money_project =" . dbEscapeString($money_project) . ",
          company ='" . dbEscapeString($company) . "',
          date_stop ='" . dbEscapeString($date_stop) . "',
          date_submit ='" . dbEscapeString($date_submit) . "',
          signer ='" . dbEscapeString($signer) . "'
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