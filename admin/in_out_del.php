    
<?php  
date_default_timezone_set('Asia/Bangkok');
include "header.php";
$u_id=$_SESSION['ses_u_id'];
$pid=$_GET['pid'];
    dbQuery("BEGIN");
    $sql="DELETE FROM paper WHERE pid=$pid";
    $result1 =  dbQuery($sql);

    $sql="DELETE FROM paperuser WHERE pid=$pid";
    $result2 = dbQuery($sql);

    if($result1 && $result2){
        dbQuery("COMMIT");
         echo "<script>
                    swal({
                     title:'ลบเอกสารส่งเรียบร้อยแล้ว',
                     type:'success',
                     showConfirmButton:true
                     },
                     function(isConfirm){
                         if(isConfirm){
                             window.location.href='history.php';
                         }
                     }); 
                   </script>";  
    }else{
        dbQuery("ROLLBACK");
                    echo "<script>
                    swal({
                     title:'มีบางอย่างผิดพลาด กรุณาตรวจสอบ',
                     type:'warning',
                     showConfirmButton:true
                     },
                     function(isConfirm){
                         if(isConfirm){
                             window.location.href='history.php';
                         }
                     }); 
                   </script>";
               
                   
    }  //check db 
	
	
	