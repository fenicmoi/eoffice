<?php
/*if(!isset($_SESSION['ses_u_id'])){
    header("location:../index.php");
}*/
include "header.php"; 

$u_id=$_SESSION['ses_u_id'];

/* code for data update */
if(isset($_GET['edit']))
{
    $sql = "SELECT * FROM office_type WHERE type_id=".$_GET['edit'];
    $result = dbQuery($sql);
    $getROW = dbFetchArray($result);
}

//checkuser();
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
                <div class="panel-heading"><i class="fa fa-university fa-2x" aria-hidden="true"></i>  <strong>จัดการประเภทหน่วยงาน</strong></div>
                <p></p>
                <form method="post" class="form-group">
                    <input class="form-control" type="text" name="officeType" required placeholder="ใส่ประเภทหน่วยงานที่ต้องการเพิ่ม"
                                   value="<?php if(isset($_GET['edit'])) echo $getROW['type_name'];  ?>"/>
  
                     <p></p>
                    <?php
                    if(isset($_GET['edit'])){?>
                      <button class="btn btn-success" type="submit" name="update">ปรับปรุงข้อมูล</button>
                     <?php }else{  ?>     
                     <button class="btn btn-primary" type="submit" name="save">บันทึก</button>
                      <?php } ?>
                </form>
                <hr/>
                <table class="table table-bordered table-hover" id="myTable">
                 <thead class="bg-info">
                     <tr>
                         <th>ที่</th>
                         <th>ชื่อประเภทหน่วยงาน</th>
                         <th></th>
                         <th></th>
                     </tr>
                 </thead>
                 <tbody>
                     <?php
                        $count=1;
                        $sql = "SELECT * FROM office_type";
                        $result = dbQuery($sql);
                        while($row=dbFetchArray($result)){?>
                            <tr>
                            <td><?php echo $count ?></td>
                            <td><?php echo $row['type_name']; ?></td>
                            <td><a class="btn btn-success" href="officeType.php?edit=<?php echo $row['type_id']; ?>" 
                                onclick="return confirm('ระบบกำลังจะแก้ไขรายการ !'); " >
                                <i class="fas fa-edit" aria-hidden="true"></i>  แก้ไข</a></td>
                                <td><a class="btn btn-danger" href="officeType.php?del=<?php echo $row['type_id']; ?>" onclick="return confirm('ระบบกำลังจะลบข้อมูล !'); " >
                                    <i class="fas fa-trash" aria-hidden="true"></i>   ลบ</a></td>
                            </tr>
                            <?php $count++; }?>
                 </tbody>
             </table>
            </div>
        </div>
    </div>  
    <?php

include_once 'function.php';

/* code for data insert */
    if(isset($_POST['save'])){

        $type_name = $_POST['officeType'];

        $sql="SELECT * FROM office_type WHERE type_name='$type_name'";
        $result = dbQuery($sql);
        $row = dbFetchAssoc($result);
        if($row>0){
            echo "<script>
            swal({
             title:'มีชื่อประเภทนี้แล้ว !  กรุณาตรวจสอบ',
             type:'error',
             showConfirmButton:true
             },
             function(isConfirm){
                 if(isConfirm){
                     window.location.href='officeType.php';
                 }
             }); 
           </script>";
        }else{
            $sql= "INSERT INTO office_type(type_name) VALUES('$type_name')";
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
                        window.location.href='officeType.php';
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
                        window.location.href='officeType.php';
                    }
                }); 
              </script>";
            }
        }             
    }

/* code for data delete */
if(isset($_GET['del']))
{
    $sql = "DELETE FROM office_type WHERE type_id=".$_GET['del'];
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
                 window.location.href='officeType.php';
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
                 window.location.href='officeType.php';
             }
         }); 
       </script>";
    }
}
/* code for data delete */





if(isset($_POST['update']))
{
    $sql = "UPDATE office_type SET type_name='".$_POST['officeType']."' WHERE type_id=".$_GET['edit'];
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
                 window.location.href='officeType.php';
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
                 window.location.href='officeType.php';
             }
         }); 
       </script>";
    }
    
	
}
/* code for data update */

?>
<?php //include "footer.php"; ?>


