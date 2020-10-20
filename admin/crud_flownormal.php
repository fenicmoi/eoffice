<?php

include_once 'function.php';
error_reporting( error_reporting() & ~E_NOTICE );//ปิดการแจ้งเตือน
date_default_timezone_set('Asia/Bangkok'); //วันที่

   


if(isset($_POST['update'])){
            $fileupload=$_REQUEST['fileupload'];  //การจัดการ fileupload
            $date=date('Y-m-d');
            $numrand=(mt_rand()); //สุ่มตัวเลข
            $upload=$_FILES['fileupload']; //เพิ่มไฟล์
        if($upload<>''){
            $part="flow-normal/";   //โฟลเดอร์เก็บเอกสาร
            $type=  strrchr($_FILES['fileupload']['name'],".");   //เอาชื่อเก่าออกให้เหลือแต่นามสกุล
            $newname=$date.$numrand.$type;   //ตั้งชื่อไฟล์ใหม่โดยใช้เวลา
            $part_copy=$part.$newname;
            $part_link="flow-normal/".$newname;
            move_uploaded_file($_FILES['fileupload']['tmp_name'],$part_copy);  //คัดลอกไฟล์ไป Server
            
            $sqlUpdate="UPDATE flownormal SET file_upload='$part_copy' WHERE cid=$cid";
            //print $sqlUpdate;
            $resUpdate=  dbQuery($sqlUpdate);
             if($resUpdate){
                echo "<script>
                swal({
                    title:'เรียบร้อย',
                    type:'success',
                    showConfirmButton:true
                    },
                    function(isConfirm){
                        if(isConfirm){
                            window.location.href='flow-normal.php';
                        }
                    }); 
                </script>";
            }else{
                echo "<script>
                swal({
                    title:'มีบางอย่างผิดพลาด! กรุณาตรวจสอบ',
                    type:'error',
                    showConfirmButton:true
                    },
                    function(isConfirm){
                        if(isConfirm){
                            window.location.href='flow-normal.php';
                        }
                    }); 
                </script>";
            } 
        }else{
            echo "<meta http-equiv='refresh' content='1;URL=flow-normal.php'>";
        }
        
}    
?>