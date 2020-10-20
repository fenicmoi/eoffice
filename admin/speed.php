<?php
/*if(!isset($_SESSION['ses_u_id'])){
    header("location:../index.php");
}*/
include "header.php"; 

$u_id=$_SESSION['ses_u_id'];
/* code for data update */
if(isset($_GET['edit']))
{
    $sql = "SELECT * FROM speed WHERE speed_id=".$_GET['edit'];
    $result = dbQuery($sql);
	$getROW = dbFetchArray($result);
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
                <div class="panel-heading"><i class="fa fa-fighter-jet fa-2x" aria-hidden="true"></i>  <strong>จัดการชั้นความเร็ว</strong></div>
                <p></p>
                <form method="post" class="form-group">
                    <input class="form-control" type="text" name="speed" required placeholder="ใส่ข้อมูล"
                                   value="<?php if(isset($_GET['edit'])) echo $getROW['speed_name'];  ?>"/>
  
                     <p></p>
                    <?php
                    if(isset($_GET['edit'])){?>
                      <button class="btn btn-success" type="submit" name="update">ปรับปรุงข้อมูล</button>
                     <?php }else{  ?>     
                     <button class="btn btn-primary" type="submit" name="save">บันทึก</button>
                      <?php } ?>
                </form>
                <hr/>
                <table class="table table-bordered table-hover">
                 <thead class="bg-info">
                     <tr>
                         <th>ที่</th>
                         <th>ชั้นความเร็ว</th>
                         <th></th>
                         <th></th>
                     </tr>
                 </thead>
                 <tbody>
                     <?php
                        $count=1;
                        $sql = "SELECT * FROM speed ";
                        $result = dbQuery($sql);
                        while($row = dbFetchArray($result) ){?>
                            <tr>
                            <td><?php echo $count ?></td>
                            <td><?php echo $row['speed_name']; ?></td>
                            <td><a class="btn btn-success" href="speed.php?edit=<?php echo $row['speed_id']; ?>" 
                                onclick="return confirm('sure to edit !'); " >
                                <i class="fas fa-edit" aria-hidden="true"></i>  แก้ไข</a></td>
                                <td><a class="btn btn-danger" href="speed.php?del=<?php echo $row['speed_id']; ?>" onclick="return confirm('sure to delete !'); " >
                                    <i class="fas fa-trash" aria-hidden="true"></i>   ลบ</a></td>
                            </tr>
                            <?php $count++; }?>
                 </tbody>
             </table>
            </div>
        </div>
    </div>  

<?php

//include_once 'function.php';

/* code for data insert */
    if(isset($_POST['save']))
    {
         $speed_name = $_POST['speed'];
             $sql = "INSERT INTO speed(speed_name) VALUES('$speed_name')";
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
                         window.location.href='speed.php';
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
                         window.location.href='speed.php';
                     }
                 }); 
               </script>";
             }

    }

/* code for data delete */
if(isset($_GET['del']))
{
    $sql = "DELETE FROM speed WHERE speed_id=".$_GET['del'];
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
                window.location.href='speed.php';
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
                window.location.href='speed.php';
            }
        }); 
      </script>";
    }
}


if(isset($_POST['update']))
{
    $sql = "UPDATE speed SET speed_name='".$_POST['speed']."' WHERE speed_id=".$_GET['edit'];
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
                window.location.href='speed.php';
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
                window.location.href='speed.php';
            }
        }); 
      </script>";
    }
}
?>
<?php include "footer.php"; ?>


