<?php
// hire-update.php
include "header.php";
//include 'function.php';

//include '../library/database.php';


if(isset($_POST['update_hire'])){
    $hire_id = $_POST['hire_id'];
    $title = $_POST['title'];
    $money = $_POST['money'];
    $employee = $_POST['employee'];
    $datehire = $_POST['datehire'];
    $date_submit = $_POST['date_submit'];
    $signer = $_POST['signer'];
    $guarantee = $_POST['guarantee'];

    $sql="UPDATE hire SET 
          title ='".dbEscapeString($title)."',
          money =".dbEscapeString($money).",
          employee ='".dbEscapeString($employee)."',
          date_hire ='".dbEscapeString($datehire)."',
          date_submit ='".dbEscapeString($date_submit)."',
          signer ='".dbEscapeString($signer)."',
          guarantee =".dbEscapeString($guarantee)."
          WHERE hire_id =".dbEscapeString($hire_id);
    //print $sql;
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
                    window.location.href='hire.php';
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
                    window.location.href='hire.php';
                }
            }); 
        </script>";
    }     
}
?>