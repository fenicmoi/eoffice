
<?php
/*if(!isset($_SESSION['ses_u_id'])){
    header("location:../index.php");
}*/
date_default_timezone_set('Asia/Bangkok');
include "header.php"; 
$u_id=$_SESSION['ses_u_id'];
$cid=$_GET['cid'];

//include 'function.php';
//include '../library/database.php';  
// 'crud_flownormal.php';
?>
<?php    
   //ตรวจสอบปีเอกสาร
   $sqlYear="SELECT * FROM sys_year WHERE status=1";
   $resYear=dbQuery($sqlYear);
   $data=dbFetchArray($resYear);
   $yid=$data[0];
   $yname=$data[1];
 
    
    //คำนำหน้าทะเบียน
    // $sqlPrefex="SELECT d.dep_id,d.dep_name,d.prefex,u.firstname 
    //             FROM depart d
    //             INNER JOIN user u
    //             ON u.dep_id= d.dep_id
    //             WHERE u.u_id=".$u_id;
    // //echo $sqlPrefex;
    // $resPrefex=  dbQuery($sqlPrefex);
    // $rowPrefex= dbFetchArray($resPrefex);
    // $prefex=$rowPrefex[2];
    
   
   
    
    //เลือกขอมูลหนังสือเวียน
    $sqlFlowCircle="SELECT * FROM flownormal WHERE  cid=$cid";
    //print $sqlFlowCircle;
    $resSqlFlowCircle= dbQuery($sqlFlowCircle);
    $rowFlowCircle=  dbFetchAssoc($resSqlFlowCircle);
    
    $speed=$rowFlowCircle['speed_id'];
    $sec_id=$rowFlowCircle['sec_id'];
    $obj_id=$rowFlowCircle['obj_id'];
    $sendFrom=$rowFlowCircle['sendfrom'];
    $sendTo=$rowFlowCircle['sendto'];
    $title=$rowFlowCircle['title'];
    $refer=$rowFlowCircle['refer'];
    $attachment=$rowFlowCircle['attachment'];
    $practice=$rowFlowCircle['practice'];
    $file_location=$rowFlowCircle['file_location'];
    $dateLine=$rowFlowCircle['dateline'];
    $dateout=$rowFlowCircle['dateout'];
    $prefex = $rowFlowCircle['prefex'];

    
    
    $fileUpload=$rowFlowCircle['file_upload'];

    

   

   
    
    if(!$rowFlowCircle){
        echo "ไม่สามารถเลือกข้อมูลระบบได้";
        exit();
    }
    
?>
        <div class="col-md-2" >
           <?php
                $menu=  checkMenu($level_id);
                //echo $menu;
                include $menu;
           ?>
        </div>
    
        <div  class="col-md-10">
             <div class="panel panel-default" style="margin: 20">
                 <div class="panel-heading"><i class="fa fa-envelope-open-o fa-2x" aria-hidden="true"></i>  <strong>แก้ไข/เพิ่มเติม</strong></div>
                   <i class="badge"> ข้อมูลทั่วไป </i>                   
                    <div class="well">
                     <form name="form" method="post" action="flow-normal.php" enctype="multipart/form-data">
                        <table width="800">
                            <tr>
                                <td> 
                                    <div class="form-group form-inline">
                                        <span for="typeDoc">ประเภทหนังสือ :</span>
                                        <input class="form-control" name="typeDoc" type="radio" value="0" disabled> ปกติ
                                        <input class="form-control" name="typeDoc" type="radio" value="1" checked=""> เวียน
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon" for="yearDoc">ปีเอกสาร : </span>
                                            <input class="form-control"  name="yearDoc" type="text" value="<?php print $yname; ?>" disabled=""> 
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                     <div class="form-group">
                                        <div class="input-group col-sm-10">
                                            <span class="input-group-addon">วันที่ทำรายการ :</span>
                                            <?php $changDate=$rowFlowCircle['dateline'];?>
                                            <input type="text" class="form-control" name="currentDate" value="<?php   echo thaiDate($changDate); ?>" disabled="">
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group"> 
                                        <div class="input-group col-sm-10">
                                        <span class="input-group-addon">วัตถุประสงค์ : </span>
                                        <select name="obj" class="form-control">
                                        <?php
                                           //วัตถุประสงค์
                                            $sqlobj="SELECT * FROM object ";
                                            $resObj=dbQuery($sqlobj);
                                            while ($row = dbFetchArray($resObj)) {?>
                                               <option value="<?php echo $row['obj_id'];?>"><?php echo $row['obj_name'];?></option>
                                         <?php }?>
                                        </select>
                                        </div>
                                        
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <div class="input-group col-sm-10">
                                            <span class="input-group-addon">เลขทะเบียนส่ง : </span>
                                            <input type="text" class="form-control" name="prefex" id="prefex" value="<?php  print $prefex; ?>/ว <?php print $rowFlowCircle['rec_no'];?>" disabled="" >
                                        </div>
                                    </div>    
                                </td>
                                <td>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon">ลงวันที่ :</span>
                                            <input class="form-control" type="date" name="dateout" value="<?php echo   $dateout; ?>" >
                                        </div>
                                    </div>             
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <div class="input-group col-sm-10">
                                            <span class="input-group-addon">ชั้นความเร็ว : </span>
                                            <select class="form-control" name="speed">
                                            <?php
                                                $sqlSpeed="SELECT * FROM  speed ";
                                                $resSpeed=dbQuery($sqlSpeed);
                                                while ($row = dbFetchArray($resSpeed)) {?>
                                                    <option  value="<?php echo $row['speed_id'];?>"><?php echo $row['speed_name'];?></option>
                                                <?php }?>
                                            </select>
                                        </div>
                                       
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <div class="input-group col-sm-10">
                                            <span class="input-group-addon">ชั้นความลับ</span>
                                            <select name="secret" class="form-control">
                                            <?php 
                                            $sqlSecret="SELECT * FROM secret";
                                            $resSecret=dbQuery($sqlSecret);
                                             
                                            while ($row = dbFetchArray($resSecret)) {?>
                                                <option value="<?php echo $row['sec_id'];?>"><?php echo $row['sec_name'];?></option>
                                           <?php }?>
                                            </select>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                        </div>
                    
                        <i class="badge">รายละเอียด</i>
                        <div class="well">  
                            <table width="800">
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <div class="input-group col-sm-10">
                                                <span class="input-group-addon">ผู้ส่ง : </span>
                                                <input class="form-control" type="text"  name="sendfrom" id="sendfrom" value="<?php print $sendFrom ?>" >    
                                            </div>
                                           
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <div class="input-group col-sm-10">
                                                <span class="input-group-addon">ถึง : </span>
                                                <input class="form-control" type="text"  name="sendto" id="sendto"   value="<?php print $sendTo?>">
                                             </div> 
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon">เรื่อง : </span>
                                                <input class="form-control" type="text"  name="title" id="title" size="100" value="<?php print $title ?>" >
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon">อ้างถึง</span>
                                                <input class="form-control" type="text"  size="50" name="refer" id="refer" value="<?php print $refer?>" >
                                            </div>
                                            
                                        </div>    
                                     </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon">สิ่งที่ส่งมาด้วย</span>
                                                 <input class="form-control" type="text" size="40" name="attachment" value="<?php print $attachment ?>" >
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <div class="input-group">
                                                 <span class="input-group-addon">ผู้เสนอ</span>
                                                 <input class="form-control" type="text" size="30"  name="practice" value="<?php print $practice ?>" disabled="" >
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <div class="input-group">
                                                 <span class="input-group-addon">ที่เก็บเอกสาร</span>
                                                 <input class="form-control" type="text" size="30"  name="file_location" value="<?php print $file_location?>" >
                                            </div>
                                            
                                        </div>
                                    </td>
                                    <td>
    
                                    </td>
                                </tr>
                            </table>
                         
                         </div> <!-- class well -->    
                         
                               <center>
                     
                                    <button class="btn btn-primary btn-lg" type="submit" name="update">
                                    <i class="fa fa-database fa-2x"></i> บันทึก
                                    <input id="cid" name="cid" type="hidden" value="<?php echo $cid; ?>"> 
                               </center>    
                     </form>
                   
                    </div> <!-- panel -->
                 </div>  <!-- col-md-10 -->
    </div>  <!-- container -->
<?php //include "footer.php"; ?>
  
 
