
<?php
/*if(!isset($_SESSION['ses_u_id'])){
    header("location:../index.php");
}*/

include "header.php"; 

$u_id=$_SESSION['ses_u_id'];

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
                <div class="panel-heading"><i class="fa fa-clock-o fa-2x" aria-hidden="true"></i>  <strong>จัดการปีปฏิทิน-ทะเบียนคุมสัญญา</strong>
                <a href="add_object.php" class="btn btn-primary pull-right" data-toggle="modal" data-target="#modalAdd">
                     <i class="fa fa-plus" aria-hidden="true"></i> เพิ่มปีปฏิทิน
                    </a>
                </div>
                <table class="table table-bordered table-hover" id="tbYear">
                 <thead class="bg-info">
                     <tr>
                         <th>ที่</th>
                         <th>ปีปฏิทิน</th>
                         <th>สถานะ</th>
                         <th>แก้ไข</th>
                         <th>ลบ</th>
                     </tr>
                 </thead>
                 <tbody>
                     <?php
                        $count=1;
                        $sql="SELECT *
                              FROM year_money
                              ORDER BY yid DESC
                              ";
                        $result = dbQuery($sql);
                        while($row=dbFetchArray($result)){?>
                            <tr>
                            <td><?php echo $row['yid']; ?></td>
                            <td><?php echo $row['yname']; ?></td>
                            <td><?php
                                    $status= $row['status']; 
                                    if($status==1){
                                        echo "<center><i class=\"fa fa-check-square fa-2x alert-success\"</i></center>";
                                    }else{
                                         echo "<center><i class=\"fa fa-close fa-2x alert-danger\"></i></center>";
                                    }
                                ?></td>
                           
                
                            <td>
                                <?php 
                                    if($status==1){?>
                                        <a class="btn btn-danger" href="?close=<?php echo $row['yid']; ?>" onclick="return confirm('กำลังจะปิดปีปฏิทิน !'); " >ปิดปีปฏิทิน</a>
                                <?php }else {?>
                                         <a class="btn btn-success" href="?open=<?php echo $row['yid']; ?>" onclick="return confirm('กำลังเปิดปีปฏิทิน !'); " >เปิดปีปฏิทิน</a>
                                <?php } ?>
                            </td>
                            <td><a class="btn btn-danger" href="?del=<?php echo $row['yid']; ?>" onclick="return confirm('กำลังจะลบข้อมูล !'); " >
                                <i class="far fa-trash-alt"></i>  ลบ</a>
                            </td>
                            </tr>
                            <?php $count++; }?>
                 </tbody>
                </table>
                
            </div>
            <!-- Model -->
            <!-- -ข้อมูลผู้ใช้ -->
            <div id="modalAdd" class="modal fade" role="dialog">
              <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header bg-info">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">เพิ่มปีปฏิทิน</h4>
                  </div>
                  <div class="modal-body">
                      <form method="post">
                        <div class="form-group">
                            <div class="input-group">
                                <label for="status"><i class="fa fa-cog"></i>สถานะการใช้งาน:</label>
                                    <input type="radio" id="status" name="status" value="1" checked> ใช้งาน 
                                    <input type="radio" id="status" name="status" value="0"> ปิดปีปฏิทิน <br>
                            </div>
                            
                        </div>
                        <div class="form-group">
                          <label for="dep_name">ปีปฏิทิน:</label>
                          <div class="input-group">
                              <input type="text" class="form-control" id="yname" name="yname" required="">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-th-list"></span>
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
                                    <center>
                                        <button class="btn btn-primary btn-lg" type="submit" name="save">
                                        <i class="fa fa-database fa-2x"></i> บันทึก
                                        </button>
                                    </center>
                                    <?php
                            }
                            ?>
                                                     
                      </form>
                  </div>
                  <div class="modal-footer bg-info">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  </div>
                </div>

              </div>
            </div>
            <!-- End Model -->   
        </div>
    </div>  
<?php
// ส่วนการจัดการข้อมูล
if(isset($_POST['save'])){
    $yname=$_POST['yname'];
    
    
    
    $sql="SELECT * FROM  year_money WHERE dep_name='$yname'";
    //echo $sql;
    $result=dbQuery($sql);
    $row=dbFetchRow($result);
    if($row>0){
       echo "<script>
       swal({
        title:'ปีปฏิทินซ้ำกันไม่ได้ !  กรุณาตรวจสอบ',
        type:'warning',
        showConfirmButton:true
        },
        function(isConfirm){
            if(isConfirm){
                window.location.href='year-buy.php';
            }
        }); 
      </script>";
    }else{
        $sql="INSERT INTO year_money(yname,status)
        VALUES ('$yname',1)";
        
       $result=dbQuery($sql);
       if(!$result){
           echo "<script>
           swal({
            title:'มีบางอย่างผิดพลาด! กรุณาตรวจสอบ',
            type:'error',
            showConfirmButton:true
            },
            function(isConfirm){
                if(isConfirm){
                    window.location.href='year-buy.php';
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
                    window.location.href='year-buy.php';
                }
            }); 
          </script>";
       }//check error  
    } //check duplicate    
}

if(isset($_GET['del'])){
    $sql = "DELETE FROM year_money WHERE yid=".$_GET['del'];
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
                 window.location.href='year-buy.php';
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
                 window.location.href='year-buy.php';
             }
         }); 
       </script>";
    }
}




if(isset($_GET['close'])){
    $sql = "UPDATE  sys_year SET status=0 WHERE yid=".$_GET['close'];
    $result = dbQuery($sql);
    echo "<script>
    swal({
     title:'เรียบร้อย',
     type:'success',
     showConfirmButton:true
     },
     function(isConfirm){
         if(isConfirm){
             window.location.href='year-buy.php';
         }
     }); 
   </script>";
}

if(isset($_GET['open'])){
    $sql = "UPDATE  sys_year SET status=1 WHERE yid=".$_GET['open'];
    $result = dbQuery($sql);
    echo "<script>
    swal({
     title:'เรียบร้อย',
     type:'success',
     showConfirmButton:true
     },
     function(isConfirm){
         if(isConfirm){
             window.location.href='year-buy.php';
         }
     }); 
   </script>";
}

?>
<?php //include "footer.php"; ?>


<script type='text/javascript'>
       $('#tbYear').DataTable( {
        "order": [[ 0, "desc" ]]
    } )
</script>   
