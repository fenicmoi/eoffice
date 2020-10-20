<?php
/*if(!isset($_SESSION['ses_u_id'])){
    header("location:../index.php");
}*/
include "header.php"; 

$u_id=$_SESSION['ses_u_id'];

/* code for data edit */
if(isset($_GET['edit']))
{
    $sql ="SELECT * FROM user_level WHERE level_id=".$_GET['edit'];
    $result = dbQuery($sql);
    $getRow=dbFetchArray($result);

}
?>
    <div class="row">
        <div class="col-md-2" >
            <?php  //ตรวจสอบสิทธิ์การใช้งานเมนู
                $menu=  checkMenu($level_id);
                include $menu;
            ?>
        </div>
        <?php  //ดึงข้อมูลมาแสดงกรณีแก้ไข
           /* if (isset($_GET['edit'])){
               $sql = "SELECT level_name FROM user_leve WHERE level_id=".$_GET['edit'];
               $retuls = dbQuery($sql);
               $row = dbFetchArray($result);
            }*/
        ?>
        <div class="col-md-10">
            <div class="panel panel-default" style="margin: 20">
                <div class="panel-heading"><i class="fa fa-group fa-2x" aria-hidden="true">
                    </i>...<strong>จัดการกลุ่มผู้ใช้งาน</strong>
                </div>
                <p></p>
                <form method="post" class="form-group">
                    <input class="form-control" type="text" name="level_name" required placeholder="ใส่กลุ่มผู้ใช้ที่ต้องการสร้าง"
                                   value="<?php if(isset($_GET['edit'])) echo $getRow['level_name'];  ?>"/>
                    <label for="status"><i class="fa fa-cog"></i>สถานะการใช้งาน:</label>
                                    <input type="radio" id="status" name="status" value="1" checked> ใช้งาน 
                                    <input type="radio" id="status" name="status" value="0"> ระงับการใช้งาน <br>
                     <p></p>
                    <?php
                    if(isset($_GET['edit'])){?>
                     <center><button class="btn btn-success btn-lg" type="submit" name="update"><i class="fa fa-database"></i> update</button></center>
                     <?php }else{  ?>     
                     <center><button class="btn btn-primary btn-lg" type="submit" name="save"><i class="fa fa-database"></i> save</button></center>
                      <?php } ?>
                </form>
               
                <hr/>
                <table id='myTable' class="table table-bordered table-hover">
                 <thead class="bg-info">
                     <tr>
                         <th>ที่</th>
                         <th>กลุ่มผู้ใช้งาน</th>
                         <th>สถานะ</th>
                         <th></th>
                         <th></th>
                     </tr>
                 </thead>
                 <tbody>
                     <?php
                        $count=1;
                        $sql="SELECT * FROM user_level";
                        $result=dbQuery($sql);
                        while($row = dbFetchArray($result)){?>
                         <tr>
                            <td><?php echo $count ?></td>
                            <td><?php echo $row['level_name']; ?></td>
                            <td><?php
                                    $status=$row['status'];
                                    if($status==1){
                                        echo "<a class=\"btn btn-warning \"><i class=\"fa fa-user\"></i></a>";
                                    }  else {
                                        echo "<a class=\"btn btn-danger \"><i class=\"fa fa-user-times\"></i></a>";
                                    }
                                 ?>
                            </td>
                            <td><a class="btn btn-success" href="user_group.php?edit=<?php echo $row['level_id']; ?>" 
                                onclick="return confirm('คุณต้องการแก้ไขข้อมูลใช่หรือไม่ !'); " >
                                <i class="fas fa-edit" aria-hidden="true"></i>  แก้ไข</a></td>
                                <td><a class="btn btn-danger" href="user_group.php?del=<?php echo $row['level_id']; ?>" onclick="return confirm('ระบบกำลังจะลบกลุ่มผู้ใช้อย่างถาวร !'); " >
                                    <i class="fas fa-trash" aria-hidden="true"></i>   ลบ</a></td>
                         </tr>
                            <?php $count++; }?>
                 </tbody>
             </table>
            </div>
            <div class="well">
                คำอธิบาย: <i class="fa fa-user btn btn-warning"></i> อนุญาตใช้งาน
                         <i class="fa fa-user-times btn btn-danger"></i> ระงับการใช้งาน
            </div>
        </div>
    </div>  

<?php
/* code for data insert */
if(isset($_POST['save']))
{
     $level_name = $_POST['level_name'];
     $status=$_POST['status'];
        // $SQL = $conn->query("INSERT INTO user_level(level_name,status) VALUES('$level_name','$status')");
         //

         $sql="SELECT level_name FROM user_level WHERE level_name='$level_name'";
         //echo $sql;
         $result=dbQuery($sql);
         $row=dbFetchRow($result);
         if($row>0){
            echo "<script>
            swal({
             title:'กลุ่มผู้ใช้งานซ้ำ!..กรุณาเปลี่ยนใหม่',
             type:'error',
             showConfirmButton:true
             },
             function(isConfirm){
                 if(isConfirm){
                     window.location.href='user_group.php';
                 }
             }); 
           </script>";
         }else{
            $sql="INSERT INTO user_level(level_name,status) VALUES ('$level_name','$status')";
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
                         window.location.href='user_group.php';
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
                         window.location.href='user_group.php';
                     }
                 }); 
               </script>";
            }//check error
         } //check duplicate*/
}

/* code for data delete */
if(isset($_GET['del']))
{
    $del=$_GET['del'];
    $sql="DELETE FROM user_level WHERE level_id=$del";
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
                 window.location.href='user_group.php';
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
                 window.location.href='user_group.php';
             }
         }); 
       </script>";
    }
}


/* code for data edit */
if(isset($_GET['edit']))
{
    $sql ="SELECT * FROM user_level WHERE level_id=".$_GET['edit'];
    $result = dbQuery($sql);
    $getRow=dbFetchArray($result);

}

if(isset($_POST['update']))
{
	$sql= "UPDATE user_level SET level_name='".$_POST['level_name']."',status='".$_POST['status']."'
                             WHERE level_id=".$_GET['edit'];
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
                 window.location.href='user_group.php';
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
                 window.location.href='user_group.php';
             }
         }); 
       </script>";
    }
    
    
    
}
/* code for data update */
?>
<?php include "footer.php"; ?>


