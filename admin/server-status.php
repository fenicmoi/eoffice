
<?php   
include "header.php";
$u_id=$_SESSION['ses_u_id'];
?>
<?php    
//ตรวจสอบปีเอกสาร
list($yid,$yname,$ystatus)=chkYear();
$yid=$yid;
$yname=$yname;
$ystatus=$ystatus;
?>
<!-- ส่วนการทำ auto complate -->

<div class="col-md-2" >
<?php
$menu=  checkMenu($level_id);
include $menu;
?>
 </div>
        <div  class="col-md-10">
            <div class="panel panel-danger" >
                <div class="panel-heading">
                    <i class="fas fa-chart-pie  fa-2x" aria-hidden="true"></i>  <strong>Admin Panal</strong>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <?php echo phpinfo();?>
                        </div>
                    </row>
                </div>
                <div class="panel-footer">
                </div>
 <?php

echo "กำลังใช้งานอยู่ : $user_online คน";

//ทดสอบการแสดงผล ถ้านำไปใช้ให้ปิด หรือลบบรรทัดนี้ออกไป
dbQuery("delete from user_online where time<$time_check");



?>


                  
            </div> <!-- class panel -->
        </div>  <!-- col-md-10 -->
<?php

$sql1="SELECT u_id,level_id,status FROM USER WHERE level_id=1";
$sql2="SELECT u_id,level_id,status FROM USER WHERE level_id=2";
$sql3="SELECT u_id,level_id,status FROM USER WHERE level_id=3";
$sql4="SELECT u_id,level_id,status FROM USER WHERE level_id=4";
$sql5="SELECT u_id,level_id,status FROM USER WHERE level_id=5";

$result1=dbQuery($sql1);
$level1=dbNumRows($result1);

$result2=dbQuery($sql2);
$level2=dbNumRows($result2);

$result3=dbQuery($sql3);
$level3=dbNumRows($result3);

$result4=dbQuery($sql4);
$level4=dbNumRows($result4);

$result5=dbQuery($sql5);
$level5=dbNumRows($result5);
?>
   

  