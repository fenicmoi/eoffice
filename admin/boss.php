<?php

/*if(!isset($_SESSION['ses_u_id'])){
ader("location:../index.php");
}
*/

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
            <div class="panel-heading"><i class="fa fa-address-book fa-2x" aria-hidden="true"></i>  <strong>ผู้บริหาร</strong>
                <a href="add_object.php" class="btn btn-primary pull-right" data-toggle="modal" data-target="#modalAdd">
                <i class="fa fa-plus" aria-hidden="true"></i> เพิ่มผู้บริหาร
                </a>
            </div>
            <table class="table table-bordered table-hover" id="tbYear">
                <thead class="bg-info">
                    <tr>
                        <th>ที่</th>
                        <th>ชื่อ-สกุล</th>
                        <th>ตำแหน่ง</th>
                        <th>สถานะ</th>
                        <th>ลบ</th>
                    </tr>
                </thead>
                 <tbody>
                    <?php
                    $count=1;
                    $sql="SELECT * FROM boss ORDER BY rec_id DESC";
                    $result = dbQuery($sql);
                    while($row=dbFetchArray($result)){?>
                    <tr>
                        <td><?php echo $count;?></td>
                        <td><?php echo $row['name'];?></td>
                        <td><?php echo $row['position'];?></td>
                        <td>
                        <?php 
                            if($row['status']==1){?>
                                <a class="btn btn-success" href="?open=<?php echo $row['rec_id'];?>" onclick="return confirm('คุณกำลังจะปิดวาระ !'); " >อยู่ในวาระ</a>
                        <?php }else {?>
                                <a class="btn btn-danger" href="?close=<?php echo $row['rec_id'];?>" onclick="return confirm('คุณกำลังจะเปิดวาระ !'); " >หมดวาระ</a>
                        <?php } ?>
                        </td>
                        <td>
                            <a class="btn btn-danger" href="?del=<?php echo $row['rec_id'];?>" onclick="return confirm('กำลังจะลบข้อมูล !'); " ><i class="fa fa-trash" aria-hidden="true"></i>  ลบ</a>
                        </td>
                    </tr>
                    <?php $count++;}?>
                 </tbody>
            </table>
        </div>


            <!-- Model -->
            <!-- เพิ่มผู้บริหาร -->
            <div id="modalAdd" class="modal fade" role="dialog">
              <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header bg-info">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">เพิ่มผู้บริหาร</h4>
                  </div>
                  <div class="modal-body">
                      <form method="post">
                        <div class="form-group">
                        </div>
                        <div class="form-group">
                          <label for="position">ตำแหน่ง:</label>
                          <div class="input-group">
                               <select class="form-control" id="position" name="position" required="">
                                <option value="" disabled selected>จำเป็นต้องระบุ</option>
                                 <option value="ผู้ว่าราชการจังหวัด">ผู้ว่าราชการจังหวัด</option>
                                 <option value="รองผู้ว่าราชการจังหวัด">รองผู้ว่าราชการจังหวัด</option>
                            </select>
                            <span class="input-group-addon"><span class="glyphicon glyphicon-th-list"></span>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="name">ชื่อ-นามสกุล:</label>
                          <div class="input-group">
                              <input type="text" class="form-control" id="name" name="name" placeholder="ไม่ต้องมีคำนำหน้า" required="">
                              <span class="input-group-addon"><span class="glyphicon glyphicon-th-list"></span>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="dep_name">ลำดับอาวุโส:</label>
                          <div class="input-group">
                               <select class="form-control" id="keyman" name="keyman"  required="">
                                <option value="" disabled selected>จำเป็นต้องระบุ</option>
                                 <option value="1">ลำดับ 1</option>
                                 <option value="2">ลำดับ 2</option>
                                 <option value="3">ลำดับ 3</option>
                            </select>
                            <span class="input-group-addon"><span class="glyphicon glyphicon-th-list"></span>
                          </div>
                        </div>

                        <?php
                        $sql="SELECT u.u_id,u.sec_id,u.dep_id,u.firstname,d.dep_id,d.dep_name,s.sec_id,s.sec_name
                              FROM user as u
                              INNER JOIN  section as s ON u.sec_id = s.sec_id
                              INNER JOIN  depart as d  ON u.dep_id = d.dep_id
                              WHERE s.sec_name='งานเลขานุการ' AND d.dep_name='สำนักงานจังหวัดพังงา'
                            ";
                        //print $sql;
                        $result=dbQuery($sql);
                        ?>  
                        <div class="form-group">
                          <label for="dep_name">เลือกเลขานุการ:</label>
                          <div class="input-group">
                               <select class="form-control" id="sec_id" name="sec_id"  required="">
                                <option value="" disabled selected>จำเป็นต้องระบุ</option>
                                <?php
                                    while ($row=dbFetchArray($result)) {?>
                                        <option value="<?=$row['u_id']?>"><?=$row['firstname']?></option>
                                    <?}?>
                                ?>
                            </select>
                            <span class="input-group-addon"><span class="glyphicon glyphicon-th-list"></span>
                          </div>
                        </div>
            
                                <center>
                                <button class="btn btn-primary btn-lg" type="submit" name="save">
                                  <i class="fas fa-save fa-2x"></i> บันทึก
                                </button>
                                </center>
    
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
    $position=$_POST['position'];
    $name=$_POST['name'];
    $keyman=$_POST['keyman'];
    $status=1;  //0 หมดวระ  1  อยู่ในวาระ
    $sec_id=$_POST['sec_id'];
    //check governer
    $sql ="SELECT * FROM boss WHERE keyman=1 AND status=1";
    $result = dbQuery($sql);
    $row = dbNumRows($result);
    
    if($row > 1){
		echo "<script>
        swal({
        title:'ผู้ว่าราชการจังหวัดมีได้เพียงคนเดียว  กรุณาตรวจสอบ',
        type:'error',
        showConfirmButton:true
        },
        function(isConfirm){
            if(isConfirm){
                 window.location.href='boss.php';
            }
        }); 
        </script>";
    }else{

        $sql="INSERT INTO boss(name,position,keyman,status,sec_id) VALUES ('$name','$position',$keyman,$status,$sec_id)";
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
                    window.location.href='boss.php';
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
                    window.location.href='boss.php';
                }
            }); 
            </script>";
        }     
    }   
}



if(isset($_GET['del'])){
	$sql = "DELETE FROM boss WHERE rec_id=".$_GET['del'];
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
                 window.location.href='boss.php';
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
                 window.location.href='boss.php';
             }
         }); 
       </script>";
	}
}




if(isset($_GET['close'])){
	$sql = "UPDATE  boss SET status=1 WHERE rec_id=".$_GET['close'];
	$result = dbQuery($sql);
	echo "<script>
    swal({
     title:'เรียบร้อย',
     type:'success',
     showConfirmButton:true
     },
     function(isConfirm){
         if(isConfirm){
             window.location.href='boss.php';
         }
     }); 
   </script>";
}

if(isset($_GET['open'])){
	$sql = "UPDATE  boss SET status=0 WHERE rec_id=".$_GET['open'];
	$result = dbQuery($sql);
	echo "<script>
    swal({
     title:'เรียบร้อย',
     type:'success',
     showConfirmButton:true
     },
     function(isConfirm){
         if(isConfirm){
             window.location.href='boss.php';
         }
     }); 
   </script>";
}

?>

<script type='text/javascript'>
       $('#tbYear').DataTable( {
        "order": [[ 0, "desc" ]]
    } )
</script>   
