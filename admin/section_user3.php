
<?php
/*if(!isset($_SESSION['ses_u_id'])){
    header("location:../index.php");
}*/

include "header.php"; 
$u_id=$_SESSION['ses_u_id'];
require_once 'crud_section.php';
//checkuser();
?>
    <div class="row">
        <div class="col-md-2" >
            <?php include 'menu3.php';?>
        </div>
        <div class="col-md-10">
            <div class="panel panel-default" style="margin: 20">
                <div class="panel-heading"><i class="fa fa-user-secret fa-2x" aria-hidden="true"></i>  <strong>จัดการกลุ่ม/ฝ่าย</strong></div>
                <p></p>
                <div class="panel-body text-center">
                    <a  class="btn btn-primary btn-lg" data-toggle="modal" data-target="#modalAdd">
                     <i class="fa fa-plus" aria-hidden="true"></i>เพิ่มกลุ่ม/ฝ่าย
                    </a>
                 </div>
                <hr/>
                <table class="table table-bordered table-hover" id="myTable">
                 <thead>
                     <tr>
                         <th>ที่</th>
                         <th>ชื่อกลุ่ม/ฝ่าย</th>
                         <th>เลขหน่วยงาน</th>
                         <th>สถานะการใช้งาน</th>
                         <th>ออกเลขภายใน</th>
                         <th></th>
                         <th></th>
                     </tr>
                 </thead>
                 <tbody>
                     <?php
                        $count=1;
                        $sql="SELECT *
                              FROM section 
                              WHERE dep_id=".$dep_id;
                        $res = $conn->query($sql);
                        while($row=$res->fetch_array()){?>
                            <tr>
                            <td><?php echo $count ?></td>
                            <td><?php echo $row['sec_name']; ?></td>
                            <td><?php echo $row['sec_code']; ?></td>
                            <td><?php
                                    $status= $row['status']; 
                                    if($status==1){
                                        echo "<center><p class=\"btn btn-warning\"><i class=\"fa fa-check-square\"</i></p></center>";
                                    }else{
                                         echo "<center><p class=\"btn btn-danger\"><i class=\"fa fa-close\"></i></p></center>";
                                    }
                                ?></td>
                            <td>
                                <?php
                                    $local_num= $row['local_num']; 
                                    if($local_num==1){
                                        echo "<center><p  class=\"btn btn-warning\"><i class=\"fa fa-check-square\"></i></p></center>";
                                    }else{
                                         echo "<center><p class=\"btn btn-danger\"><i class=\"fa fa-close\"></i></p></center>";
                                    }
                                ?>
                            </td>
                
                            <td><a class="btn btn-info" href="section_edit.php?edit=<?php echo $row['sec_id']; ?>" onclick="return confirm('กำลังจะแก้ไขข้อมูล !'); " >
                                <i class="fa fa-pencil" aria-hidden="true"></i>  แก้ไข</a></td>
                                <td><a class="btn btn-danger" href="section.php?del=<?php echo $row['sec_id']; ?>" onclick="return confirm('ระบบกำลังจะลบข้อมูล !'); " >
                                    <i class="fa fa-trash-o" aria-hidden="true"></i>   ลบ</a></td>
                            </tr>
                            <?php $count++; }?>
                 </tbody>
             </table>
                
            </div>
            <!-- Model -->
            <!-- -ข้อมูลผู้ใช้ -->
            <?php
             //ต้องทำให้เพิ่มแผนกได้
            ?>
            <div id="modalAdd" class="modal fade" role="dialog">
              <div class="modal-dialog">
              
                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header alert-info">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"> <?php print $depart ?></h4>
                  </div>
                  <div class="modal-body">
                      <form method="post">
                           <div class="input-group">
                                <label for="status"><i class="fa fa-cog"></i>สถานะการใช้งาน:</label>
                                    <input type="radio" id="status" name="status" value="1" checked> ใช้งาน 
                                    <input type="radio" id="status" name="status" value="0"> ระงับการใช้งาน <br>
                                <label for="local_num"><i class="fa fa-cog"></i>อนุญาตออกเลขหนังสือภายใน:</label>
                                    <input type="radio" id="local_num" name="local_num" value="1" checked> อนุญาต 
                                    <input type="radio" id="local_num" name="local_num" value="0"> ไม่อนุญาต
                            </div>
                          
                            
                        <div class="form-group">
                          <label for="dep_name">ชื่อกลุ่ม/ฝ่าย/สาขา:</label>
                          <div class="input-group">
                              <input type="text" class="form-control" id="sec_name" name="sec_name" placeholder="ชื่อกลุ่ม/ฝ่าย" required>
                            <span class="input-group-addon"><span class="glyphicon glyphicon-th-list"></span>
                          </div>
                          
                        </div>
                         <div class="form-group">
                          <label for="sec_code">หมายเลขประจำส่วนราชการ:</label>
                          <div class="input-group">
                              <input type="text" class="form-control" id="sec_code" name="sec_code" placeholder="หมายเลขประจำส่วนราชการ" required>
                            <span class="input-group-addon"><span class="glyphicon glyphicon-th-list"></span>
                          </div>
                          
                        </div>  
                        <div class="form-group">
                            <label for="tel">เบอร์โทรศัพท์</label>
                            <div class="input-group">
                                 <input type="text" class="form-control" id="phone" name="phone" onkeyup="autoTabTel(this,2)" /> 
                                 <span class="input-group-addon"><span class="glyphicon glyphicon-phone-alt"></span></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="fax">เบอร์โทรสาร</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="fax" name="fax" onkeyup="autoTabTel(this,2)" />
                                <span class="input-group-addon"><span class="glyphicon glyphicon-print"></span></span>
                                
                            </div>
                        </div>
                         <?php
                            if(isset($_GET['edit']))
                            {
                                    ?>
                                    <button type="submit" name="update">update</button>
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
                  <div class="modal-footer alert-info">
                    <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
                  </div>
                </div>

              </div>
            </div>
            <!-- End Model -->   
        </div>
    </div>  
<?php //include "footer.php"; ?>




