<?php
error_reporting( error_reporting() & ~E_NOTICE );  //ปิดการแจ้งเตือน
include_once 'function.php';
date_default_timezone_set('Asia/Bangkok');
$date=date('Y-m-d');

if(isset($_POST['send'])){        //ตรวจสอบการกดปุ่ม send  จากส่งเอกสารภายใน
    $title=$_POST['title'];
    $detail=$_POST['detail'];
    $fileupload=$_POST['file'];
    $date=date('YmdHis');
    $sec_id=$_POST['sec_id'];
    $insite=1;                    //เอกสารภายใน
    $user_id=$_POST['user_id'];
  
    $dep_id=$_POST['dep_id'];
    $toAll=$_POST['toAll'];
    $toSome=$_POST['toSome'];
    $toSomeUser=$_POST['toSomeUser'];
    
    $fileupload=$_REQUEST['fileupload'];   //การจัดการ fileupload
    $numrand=(mt_rand());  //สุ่มตัวเลข
    $upload=$_FILES['fileupload'];  //เพิ่มไฟล์
    if($upload<>''){
        $part="paper/";
        $type=  strrchr($_FILES['fileupload']['name'],".");    //เอาชื่อเก่าออกให้เหลือแต่นามสกุล
        $newname=$date.$numrand.$type;   //ตั้งชื่อไฟล์ใหม่โดยใช้เวลา
        $part_copy=$part.$newname;
        $part_link="paper/".$newname;
        move_uploaded_file($_FILES['fileupload']['tmp_name'],$part_copy);  //คัดลอกไฟล์ไป Server
    }
    
    // ส่วนตรวจสอบว่าเป็นปีปัจจุบันหรือไม่
    $sqlYear="select * from sys_year where status=1";
    $resYear=  mysqli_query($conn, $sqlYear);
    $rowYear= mysqli_num_rows($resYear);
    $rowData=  mysqli_fetch_array($resYear);
    $yid=$rowData[0];
    if($rowYear==0){
        echo "<script>swal(\"ระบบจัดการปีปฏิทินมีปัญหา  ติดต่อ Admin!\") </script>";
        echo "<meta http-equiv='refresh' content='1;URL=flow-circle.php'>";
    }else{
           //ตัวเลขรันอัตโนมัติ
            $sqlRun="SELECT cid,rec_no FROM flowcircle  ORDER  BY cid DESC";
            $resRun=  mysqli_query($conn, $sqlRun);
            $rowRun= mysqli_fetch_array($resRun);
            $rec_no=$rowRun['rec_no'];
            $rec_no++;
    }
    
    if($toAll!=''){    //กรณีส่งเอกสารถึงทุกคน
        $sqlSend="INSERT INTO paper(title,detail,file,postdate,u_id,sec_id,insite)
                            VALUE('$title','$detail','$part_link','$date',$user_id,$sec_id,$insite)";
        $chk1=mysqli_query($conn, $sqlSend) ;  
        $lastid=  mysqli_insert_id($conn);
        $sqlUser="SELECT sec_id,sec_name FROM section WHERE dep_id=$dep_id";
        $resUser=  mysqli_query($conn, $sqlUser);
        
        while($rowUser=  mysqli_fetch_array($resUser)){
            $userId=$rowUser[0];
            $tb="paperuser";
            $sqlPaper="insert into $tb (pid,sec_id) values ($lastid,'$userId')";
            $dbquery=  mysqli_query($conn, $sqlPaper);
	    }
        echo "<script>window.alert(\"ส่งเอกสารเรียบร้อยแล้ว\");</script>";
        //echo "<script>swal(\"Good job!\", \"ส่งหนังสือแล้ว\", \"success\");</script>"; 
	echo "<meta http-equiv='refresh' content='1;URL=paper.php'>"; 
    }elseif($toSomeUser!=''){  //ส่งเอกสารให้บางคน
        $sqlSend="INSERT INTO paper(title,detail,file,postdate,u_id,sec_id,insite)
                  VALUE('$title','$detail','$part_link','$date',$user_id,$sec_id,$insite)";
       // print $sqlSend;
        
        $chk1=mysqli_query($conn, $sqlSend) ;  
        $lastid=  mysqli_insert_id($conn);     //ค้นหาเลขระเบียนล่าสุด
        //table ตรวจสอบผู้รับในสำนักงาน
        $sqlUser="SELECT sec_id,sec_name FROM section WHERE dep_id=$dep_id ";
        $resUser=  mysqli_query($conn, $sqlUser);
        if(!resUser){
            echo 'SQL Error';
        }else{
            $sendto=$_POST['toSomeUser'];
            $sendto=substr($sendto, 1);
            $c=explode("|", $sendto);
                for ($i=0;$i<count($c);$i++){
                    $sendto=$c[$i];
                    $tb="paperuser";
                    $sqlSome="insert into $tb (pid,sec_id) values ('$lastid','$sendto')";
                    //echo $sqlSome;
                    $dbquery=mysqli_query($conn,$sqlSome);
                }

            echo "<script>window.alert(\"ส่งเอกสารเรียบร้อยแล้ว\");</script>";
            //echo "<script>swal(\"Good job!\", \"ส่งหนังสือแล้ว\", \"success\");</script>"; 
            echo "<meta http-equiv='refresh' content='1;URL=paper.php'>";  
        } 
    }
}

// ส่วนการส่งหนังสือภายนอก
if(isset($_POST['sendOut'])){
    $title=$_POST['title'];              //ชื่อเอกสาร
    $detail=$_POST['detail'];            //รายละเอียด
    $date=date('YmdHis');           //วันเวลาปัจจุบัน
    $sec_id=$_POST['sec_id'];            //รหัสแผนกที่ส่ง
    $outsite=1;                          //กำหนดค่าเอกสาร insite=ภายใน   outsite = ภายนอก
    $user_id=$_POST['user_id'];          //รหัสผู้ใช้
    $dep_id=$_POST['dep_id'];            //รหัสหน่วยงาน

    $toAll=$_POST['toAll'];              //ส่งเอกสารถึงทุกคน
    $toSome=$_POST['toSome'];            //ส่งตามประเภท
    $toSomeUser=$_POST['toSomeUser'];      //ส่งแบบเลือกเอง
    $toSomeOneUser=$_POST['toSomeOneUser'];  //ช่องรับรหัส
    
    $fileupload=$_POST['file'];          //ไฟล์เอกสาร
    $numrand=(mt_rand());  //สุ่มตัวเลข
    $upload=$_FILES['fileupload'];  //เพิ่มไฟล์
    if($upload<>''){
        $part="paper/";
        $type=  strrchr($_FILES['fileupload']['name'],".");    //เอาชื่อเก่าออกให้เหลือแต่นามสกุล
        $newname=$date.$numrand.$type;   //ตั้งชื่อไฟล์ใหม่โดยใช้เวลา 
        $part_copy=$part.$newname;
        $part_link="paper/".$newname;
        move_uploaded_file($_FILES['fileupload']['tmp_name'],$part_copy);  //คัดลอกไฟล์ไป Server
    }
  
    if($toAll!=''){    //ส่งเอกสารถึงทุกส่วนราชการ
        $sqlSend="INSERT INTO paper(title,detail,file,postdate,u_id,outsite,sec_id,dep_id)
                              VALUE('$title','$detail','$part_link','$date',$user_id,$outsite,$sec_id,$dep_id)";
        $chk1=mysqli_query($conn, $sqlSend) ;  
        if(!chk1){
            echo mysqli_report;
            echo "<meta http-equiv='refresh' content='1;URL=paper.php'>";  
        }

        $lastid=  mysqli_insert_id($conn);    //เลข ID จากตาราง paper ล่าสุด
        
        $sqlDepart="SELECT dep_id,dep_name FROM depart WHERE dep_id<>$dep_id";
        $resDepart=  mysqli_query($conn, $sqlDepart);
        if(!$resDepart){
            echo mysqli_report;
            echo "<meta http-equiv='refresh' content='1;URL=paper.php'>";  
        }
        
        while($rowDepart=  mysqli_fetch_array($resDepart)){
            $dep_id=$rowDepart[0];
            $tb="paperuser";
            $sqlPaper="insert into $tb (pid,dep_id) values ($lastid,$dep_id)";
            $dbquery=  mysqli_query($conn, $sqlPaper);
	    }
        echo "<script>window.alert(\"ส่งเอกสารเรียบร้อยแล้ว\");</script>";
       // echo "<script>swal(\"Good job!\", \"ส่งหนังสือแล้ว\", \"success\");</script>"; 
	    echo "<meta http-equiv='refresh' content='1;URL=paper.php'>";  
    }elseif($toSomeUser!=''){  //ส่งเอกสารให้บางคน
        $sqlSend="INSERT INTO paper(title,detail,file,postdate,u_id,sec_id,insite)
                  VALUE('$title','$detail','$part_link','$date',$user_id,$sec_id,$insite)";
       // print $sqlSend;
        
        $chk1=mysqli_query($conn, $sqlSend) ;  
        $lastid=  mysqli_insert_id($conn);     //ค้นหาเลขระเบียนล่าสุด
        //table ตรวจสอบผู้รับในสำนักงาน
        $sqlUser="SELECT sec_id,sec_name FROM section WHERE dep_id=$dep_id ";
        $resUser=  mysqli_query($conn, $sqlUser);
        if(!resUser){
            echo 'SQL Error';
        }else{
            $sendto=$_POST['toSomeUser'];
            $sendto=substr($sendto, 1);
            $c=explode("|", $sendto);
                for ($i=0;$i<count($c);$i++){
                    $sendto=$c[$i];
                    $tb="paperuser";
                    $sqlSome="insert into $tb (pid,sec_id) values ('$lastid','$sendto')";
                    //echo $sqlSome;
                    $dbquery=mysqli_query($conn,$sqlSome);
                }

            echo "<script>window.alert(\"ส่งเอกสารเรียบร้อยแล้ว\");</script>";
            //echo "<script>swal(\"Good job!\", \"ส่งหนังสือแล้ว\", \"success\");</script>"; 
            echo "<meta http-equiv='refresh' content='1;URL=paper.php'>";  
        } 
    }
}
       
?>