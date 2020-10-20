<?php

//include_once 'function.php';
include '../library/database.php';
error_reporting( error_reporting() & ~E_NOTICE );//ปิดการแจ้งเตือน
date_default_timezone_set('Asia/Bangkok'); //วันที่

   
if(isset($_POST['save'])){               //กดปุ่มบันทึกจากฟอร์มบันทึก
    $yearDoc=$_POST['yearDoc'];          //ปีเอกสาร
    $currentDate=$_POST['currentDate'];  // วันที่ทำรายการ
    $boss=$_POST['boss'];
    $title=$_POST['title'];              //เรื่อง
    $dateline=$_POST['datepicker'];      //วันที่มีผลบังคับใช้
    $dateout=date('Y-m-d H:i:s');


  
    //check year ว่าเป็นปีปัจจุบันหรือไม่
    $sql="select * from sys_year where status=1";
    $result=  dbQuery($sql);
    $numrow=dbNumRows($result);
     if(!$numrow){
        echo "<script> alert('Admin ยังไม่ได้กำหนดสถานะปีปฏิทิน  ติดต่อผู้ดูแลระบบ')</script> ";
        echo "<meta http-equiv='refresh' content='1;URL=flow-command.php'>";

    }
    $rowData=  dbFetchArray($result);
    $yid=$rowData['yid'];
    //$yname=$rowdata['yname'];
            //กำหนดเลขรันอัตโนมัติ
            
            $sql="SELECT cid,rec_id FROM flowcommand  WHERE yid=$yid  ORDER  BY cid DESC";
            $result=  dbQuery($sql);
            $rowRun= dbNumRows($result);
            if($rowRun=0){
                $rowRun=1;
            }else{
                $rowRun++;
            }
            
        $sql="INSERT INTO flowcommand
                         (rec_id,yid,title,boss,dateline,dateout,u_id,sec_id,dep_id)    
                    VALUE($rec_id,$yid,'$title','$boss','$dateline','$dateout',$u_id,$sec_id,$dep_id)";
       
        $result($sql);
        if(!$result){
             echo "<script> alert('มีบางอย่างผิดพลาด  ติดต่อผู้ดูแลระบบ')</script> ";
             echo "<meta http-equiv='refresh' content='1;URL=error.php'>";
        }else{ 
            echo "<script> alert('บันทึกข้อมูลเรียบร้อยแล้ว'); </script>";
            echo "<meta http-equiv='refresh' content='1;URL=flow-command.php'>"; 
            /* echo "<script>swal(\"Good job!\", \"บันทึกข้อมูลเรียบร้อยแล้ว\", \"success\")</script>"; */
            //$conn->close();*/
        }

}


if(isset($_POST['update'])){
            $cid=$_POST['cid'];
            //echo "cid=".
            $fileupload=$_REQUEST['fileupload'];  //การจัดการ fileupload
            $date=date('Y-m-d');
            $numrand=(mt_rand()); //สุ่มตัวเลข
            $upload=$_FILES['fileupload']; //เพิ่มไฟล์
        if($upload<>''){
            $part="doc/";   //โฟลเดอร์เก็บเอกสาร
            $type=  strrchr($_FILES['fileupload']['name'],".");   //เอาชื่อเก่าออกให้เหลือแต่นามสกุล
            $newname=$date.$numrand.$type;   //ตั้งชื่อไฟล์ใหม่โดยใช้เวลา
            $part_copy=$part.$newname;
            $part_link="doc/".$newname;
            move_uploaded_file($_FILES['fileupload']['tmp_name'],$part_copy);  //คัดลอกไฟล์ไป Server
            
            $sqlUpdate="UPDATE flowcommand SET file_upload='$part_copy' WHERE cid=$cid";
           // print $sqlUpdate;
            $resUpdate=  mysqli_query($conn, $sqlUpdate);
            if(!$resUpdate){
                echo "ระบบมีปัญหา";
                exit;
            }else{
                echo "<script> alert('บันทึกข้อมูลเรียบร้อยแล้ว'); </script>";                
                echo "<meta http-equiv='refresh' content='1;URL=flow-command.php'>";  
            }
        }else{
            echo "<meta http-equiv='refresh' content='1;URL=flow-command.php'>";
        }
        
}    
?>