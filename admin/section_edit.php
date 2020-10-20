<?php
/*if(!isset($_SESSION['ses_u_id'])){
    header("location:../index.php");
}*/

include "header.php"; 

$u_id=$_SESSION['ses_u_id'];

    /* code for data update */
    if(isset($_GET['edit']))
    {
        $sql = "SELECT * FROM section WHERE sec_id=".$_GET['edit'];
        $result = dbQuery($sql);
        $getROW = dbFetchArray($result);
            //echo "<meta http-equiv='refresh' content='1;URL=object.php'>";
    }
?>
    <div class="row">
        <div class="col-md-2" >
            <?php
            $menu=  checkMenu($level_id);
            include $menu;
            ?>
        </div>
        <div class="col-md-10">
            <div class="panel panel-default" style="margin: 20">
                <div class="panel-heading"><i class="fa fa-user-secret fa-2x" aria-hidden="true"></i>  <strong>จัดการชื่อส่วนราชการ</strong></div>
                <p></p>
                <div class="panel-body">
                    <form class="alert-info" method="post" style="width:600px;margin: auto;">
                            <div class="input-group">
                                <label for="status"><i class="fa fa-cog"></i>สถานะการใช้งาน</label>
                                <?php
                                 $status=$getROW['status'];
                                    if($status==1){
                                          echo "<input type=\"radio\" id=\"status\" name=\"status\" value=\"1\" checked>ใช้งาน ";
                                          echo "<input type=\"radio\" id=\"status\" name=\"status\" value=\"0\" >ระงับการใช้งาน";
                                    }else{
                                          echo "<input type=\"radio\" id=\"status\" name=\"status\" value=\"1\">ใช้งาน ";
                                          echo "<input type=\"radio\" id=\"status\" name=\"status\" value=\"0\" checked>ระงับการใช้งาน";
                                    }
                                    
                                ?>
                                <br>
                                <label for="local_num"><i class="fa fa-cog"></i>การออกเลขหนังสือภายใน</label>
                                <?php
                                   
                                    $local_num=$getROW['local_num'];
                                    if($local_num==1){
                                         echo "<input type=\"radio\" id=\"local_num\" name=\"local_num\" value=\"1\" checked>ใช้งาน ";
                                         echo "<input type=\"radio\" id=\"local_num\" name=\"local_num\" value=\"0\" >ระงับการใช้งาน";
                                    }else{
                                         echo "<input type=\"radio\" id=\"local_num\" name=\"local_num\" value=\"1\" >ใช้งาน ";
                                         echo "<input type=\"radio\" id=\"local_num\" name=\"local_num\" value=\"0\" checked>ระงับการใช้งาน";
                                    }
                                ?>
                            </div>
                     
                        <div class="form-group">
                          <label for="dep_name">ชื่อกลุ่ม/ฝ่าย/สาขา:</label>
                          <div class="input-group">
                              <input type="text" class="form-control" id="sec_name" name="sec_name" value="<?php print $getROW['sec_name'] ?>">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-th-list"></span>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="sec_code">หมายเลขประจำหน่วยงาน:</label>
                          <div class="input-group">
                              <input type="text" class="form-control" id="sec_code" name="sec_code" value="<?php print $getROW['sec_code'] ?>">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-th-list"></span>
                          </div>
                        </div>
                        <div class="form-group">
                            <label for="tel">เบอร์โทรศัพท์</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="phone" 
                                       name="phone" onkeyup="autoTabTel(this,2)" value="<?php print $getROW['phone']; ?>" /> 
                                 <span class="input-group-addon"><span class="glyphicon glyphicon-phone-alt"></span></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="fax">เบอร์โทรสาร</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="fax" 
                                       name="fax" onkeyup="autoTabTel(this,2)" value="<?php print $getROW['fax']; ?>"/>
                                <span class="input-group-addon"><span class="glyphicon glyphicon-print"></span></span>
                            </div>
                        </div>
                          <?php
                            if(isset($_GET['edit']))
                            {
                                    ?>
                                    <center>
                                        <button class="btn btn-primary btn-lg" type="submit" name="update">
                                            <i class="fa fa-database fa-2x"></i>update
                                            <input type="hidden" id="dep_id"  name="dep_id" value="<?php echo $dep_id; ?>">
                                        </button>
                                    </center>
                                    <?php
                            }
                            else
                            {
                                    ?>
                                    <center><button class="btn btn-primary btn-lg" type="submit" name="save">
                                        <i class="fa fa-database fa-2x"></i> บันทึก
                                        <input id="dep_id" name="dep_id" type="hidden" value="<?php echo $dep_id; ?>"> 
                                        </button></center>
                                    <?php
                            }
                            ?>                        
                      </form>
                </div>

              </div>
            </div>
            <!-- End Model --> 
        </div>
    </div>  
<?php
if(isset($_POST['update']))
{
	$sql = "UPDATE section SET
                 sec_name='".$_POST['sec_name']."', 
                 sec_code='".$_POST['sec_code']."',
                 dep_id='".$_POST['dep_id']."',
                 phone='".$_POST['phone']."',
                 fax='".$_POST['fax']."',
                 status='".$_POST['status']."',
                 local_num='".$_POST['local_num']."'
                 WHERE sec_id=".$_GET['edit'];
        
     $result = dbQuery($sql);
     if(!$result){
        echo "<script>
        swal({
         title:'มีบางอย่างผิดพลาด! กรุณาตรวจสอบ',
         type:'error',
         showConfirmButton:true
         },
         function(isConfirm){
             if(isConfirm){
                 window.location.href='section.php';
             }
         }); 
       </script>";
    }else{
        echo "<script>
        swal({
         title:'เรียบร้อย',
         type:'success',
         showConfirmButton:true
         },
         function(isConfirm){
             if(isConfirm){
                 window.location.href='section.php';
             }
         }); 
       </script>";
    }//check error
}

?>
<?php include "footer.php"; ?>


