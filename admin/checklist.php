<!-- Bootstrap -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link href="../css/sticky-footer-navbar.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/loader.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.4.2/css/bulma.css">
    <link rel="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.4.2/css/bulma.css.map">
    <script src="../js/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/function.js"></script>
    
    <link rel="stylesheet" href="../css/sweetalert.css">
    <script src="../js/sweetalert.min.js"></script>
    <script src="app.js"></script>
     <!-- DateTimePicket -->
     <script src="../js/jquery-ui-1.11.4.custom.js"></script>
     <link rel="stylesheet" href="../css/jquery-ui-1.11.4.custom.css" />
     <link rel="stylesheet" href="../css/SpecialDateSheet.css" />

    <!-- หน้าต่างแจ้งเตือน -->
    <script  src="../js/jquery_notification_v.1.js"> </script>  <!-- Notification -->
    <link href="../css/jquery_notification.css" type="text/css" rel="stylesheet"/>
    
    <link href="../css/dataTables.css" rel="stylesheet">
    <script src="../js/dataTables.js"></script>
    <link rel="stylesheet" type="text/css" href="../select/selection.css">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script type='text/javascript'>
        $(document).ready(function(){
    $('#myTable').DataTable(
        {
           "oLanguage": {
                 "oPaginate": {
                        "sFirst": "หน้าแรก",
                         "sLast": "หน้าสุดท้าย",
                         "sNext": "ถัดไป",
                         "sPrevious": "กลับ"
                               }
                         }
      }
                
        );
    })
    
    </script>
<?php
include 'function.php';
include '../library/database.php';
$pid=$_GET['pid'];
//print $pid;
/* ************* ส่วนการตรวจสอบสถานะของเอกสาร */
//ยืนยันแล้ว
$sql="SELECT  pid  FROM paperuser WHERE pid=$pid and confirm=1";
$result=dbQuery($sql);
$resNumOk=  dbNumRows($result);

//ยังไม่ได้ยืนยัน
$sql="SELECT pid FROM paperuser WHERE pid=$pid and confirm=0";
// print $sqlNo;
$result=  dbQuery($sql);
$resNumNo= dbNumRows($result);


/************** ตรวจสอบว่าเป็นหนังสื่อส่งภายนอกหรือภายใน */
$sql="SELECT * FROM paperuser WHERE pid=$pid";
$result=dbQuery($sql);
$rowCheck=dbFetchArray($result);
if(!$rowCheck){
    echo "<script>
    swal({
        title:'มีบางอย่างผิดพลาด !',
        type:'error',
        showConfirmButton:true
        },
        function(isConfirm){
            if(isConfirm){
                window.location.href='paper.php';
            }
        }); 
    </script>"; 
}

$check=$rowCheck['sec_id'];
if($check==0){       // ถ้าค่าเป็น 0 หมายถึงเป็นเอกสารส่งภายนอก
    $sql="SELECT p.pid,p.sec_id,p.dep_id,p.confirm,p.confirmdate,d.dep_name,d.phone
          FROM paperuser p
          INNER JOIN depart d ON p.dep_id=d.dep_id
          WHERE p.sec_id=0 AND pid=$pid";  
}else{
    $sql="SELECT p.pid,p.u_id,p.sec_id,p.confirm,p.confirmdate,p.dep_id,d.dep_name,d.phone,s.sec_name,u.firstname
      FROM  paperuser p
      INNER JOIN depart d   ON  p.dep_id=d.dep_id
      INNER JOIN section s ON s.sec_id=p.sec_id
      INNER JOIN user u ON u.u_id=p.u_id
      WHERE pid=$pid  
      ";
    
}
//print $sql;
 $result= dbQuery($sql);
 $count=1;
 if(!$result){
     echo "ระบบมีปัญหาการเชื่อมต่อรายงาน";
 }
?>
    <div class="container-fluid">
        <div class="well" style="background-color: #006699">
            <h3 style="color: white">
                <i class="fa fa-check-square-o fa-2x"></i> ตรวจสอบผู้รับเอกสาร
            </h3>
        </div>
        <div class="nav navbar">
            <center>
                <button type="button" class="btn btn-success">ลงรับแล้ว <span class="badge"><h4><?php print $resNumOk ?></h4></span></button> 
                <button type="button" class="btn btn-danger">ยังไม่ลงรับ <span class="badge"><h4><?php print $resNumNo ?></h4></span></button>
                <a  class="btn btn-warning" href="report/rep-checklist.php?pid=<?php echo $pid;?>" target="_blank"> <i class="fa fa-print fa-3x"></i></a>
                <button type="button" class="btn btn-primary" onclick="window.close()"<i class="fa fa-print"></i><i class="fa fa-window-close fa-3x"></i> <span class="badge"></span></button> 
            </center>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered table-hover" id="myTable">
                    <thead>
                        <tr>
                            <th>ที่</th>
                            <th>หน่วยงาน</th>
                            <th>กลุ่มงาน</th>
                            <th>สถานะ</th>
                            <th>วันที่รับ</th>
                            <th>ผู้รับ</th>
                            <th>เบอร์ติดต่อ</th>
                        </tr>
                    </thead>
                    <tbody>
                            <?php
                            while ($row=dbFetchArray($result)){?>
                                <tr>
                                    <td><?=$count?></td>
                                    <td><?php echo $row['dep_name']?></td>
                                    <td>
                                        <?php   // ถ้า sec_id=0 แสดงว่าเป็นหนังสือส่งภายนอก  ไม่ต้องแสดงแผนก
                                        if($row['sec_id']==0){
                                              echo "-";
                                        }else{
                                              echo $row['sec_name'];
                                        } ?>
                                    </td>
                                    <?php 
                                     if($row['confirm']==1){?>
                                    <td class="alert-success"><center><i class="fa fa-check-square-o"></i> ลงรับแล้ว</center></td> 
                                      <td><?php echo thaiDate($row['confirmdate'])?></td>
                                <?php } else { ?>
                                      <td class="alert-danger"><center><i class="fa fa-window-close"></i> ยังไม่ลงรับ</center></td>
                                      <td>-</td>
                                <?php } ?>
                                     <td><?php echo $row['firstname'];?></td>
                                     <td><?php echo $row['phone']?></td>
                                </tr>   
                        <?php $count++; } ?>
                    </tbody>
                </table>  
            </div>
        </div>
    </div>  

    
    