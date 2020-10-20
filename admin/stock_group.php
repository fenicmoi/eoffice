
<!-- บริหารจัดการรถยนต์ -->
<?php
include "header.php"; 
$yid=chkYearMonth();
$u_id=$_SESSION['ses_u_id'];
?>
    <div class="row">
        <div class="col-md-2" >
             <?php
                 $menu=  checkMenu($level_id);
                 include $menu;
             ?>
        </div>  <!-- col-md-2 -->
        <div class="col-md-10">
            <div class="panel panel-primary">
                <div class="panel-heading"><i class="fas fa-feather fa-2x"></i>  <strong>Group Number (Admin Deskboard)</strong> 
                     <a href="" class="btn btn-default  pull-right" data-toggle="modal" data-target="#modalAdd">
                     <i class="fa fa-plus" aria-hidden="true"></i> เพิ่ม Group
                    </a></div>  
                <div class="panel-content">
                <table class="table table-bordered table-hover" id="tbGroup">
                        <thead>
                            <th>ลำดับที่</th>
                            <th>ชื่อกลุ่ม (GROUP)</th>
                            <th>หมายเลขกลุ่ม</th>
                            <th>แก้ไข</th>
                        </thead>
                        <tbody>
                        <?php   
                            $sql ="SELECT * FROM st_group ORDER BY gid DESC";
                            $result = dbQuery($sql);
                            while ($row = dbFetchArray($result)) {
                                echo "<tr>
                                         <td>".$row['gid']."</td>
                                         <td>".$row['gname']."</td>
                                         <td>".$row['gnumber']."</td>
                                         <td>".$row['gstatus']."</td>
                                     </tr>";
                            }
                        ?>
                        </tbody>
                   </table>

                </div>
				<div class="panel-footer"></div>
            </div> 
        </div> <!-- col-md-10 -->
    </div>    <!-- end row  -->

 <!--เพิ่มข้อมูล -->
 <div id="modalAdd" class="modal fade" role="dialog" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="exampleModalLabel"><i class="fa fa-plus"></i> เพิ่มกลุ่มพัสดุ</h4>
            </div>
            <div class="modal-body">
                <form method="post">
                          <label class="badge">วันที่บันทึก: <?php echo DateThai(); ?></label>
                          <?php 
                            $sql="SELECT *FROM depart WHERE dep_id=$dep_id";
                            $result=dbQuery($sql);
                            $row=dbFetchArray($result);
                        ?>
                          <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">ชื่อกลุ่มพัสดุ</span>
                                <input type="text" name="gname"  class="form-control">      
                                
                                
                            </div>
                         </div> 
                        
                         <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">เลขกลุ่ม</span>
                                    <input type="number" name="gnumber" class="form-control">
                                </div>
                         </div>
                        
                            <center>
                                <button class="btn btn-success" type="submit" name="save">
                                    <i class="fa fa-save fa-2x"></i> บันทึก
                                </button>
                            </center>                                                         
                      
                  </div>
                  <div class="modal-footer bg-primary">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                  </div>
                </form>
            </div> <!-- main body -->
        </div> <!-- modal content -->
    </div>   <!-- modal dialog -->
            <!-- End Model -->  
    

<!--  modal แสงรายละเอียดข้อมูล -->
        <div  class="modal fade bs-example-modal-table" tabindex="-1" aria-hidden="true" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-danger">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"><i class="fa fa-info"></i> รายละเอียด</h4>
                    </div>
                    <div class="modal-body no-padding">
                        <div id="divDataview"></div>     
                    </div> <!-- modal-body -->
                    <div class="modal-footer bg-danger">
                         <button type="button" class="btn btn-danger" data-dismiss="modal">ปิด X</button>
                    </div>
                </div>
            </div>
        </div>
<!-- จบส่วนแสดงรายละเอียดข้อมูล  -->

<?php
// ส่วนการจัดการข้อมูล
if(isset($_POST['save'])){

    $gname = $_POST['gname'];
    $gnumber = $_POST['gnumber'];
    $gstatus = 1;
    
    //check ว่าหมายเลขกลุ่มซำ้หรือม่
    $sql  = "SELECT  * FROM st_group WHERE gnumber = $gnumber";
    $result = dbQuery($sql);
    $numrow = dbNumRows($result);

    if( $numrow == 1 ){
        echo "<script>
        swal({
            title:'มีข้อมูลแล้ว! กรุณาตรวจสอบ',
            type:'error',
            showConfirmButton:true
            },
            function(isConfirm){
                if(isConfirm){
                    window.location.href='stock_group.php';
                }
            }); 
        </script>";
    }else{
     
        
        $sql="INSERT INTO st_group (gnumber,gname,gstatus)
                            VALUES($gnumber,'$gname',$gstatus)";
        $result = dbQuery($sql);
        if($result){
       
            echo "<script>
            swal({
                title:'เรียบร้อย',
                type:'success',
                showConfirmButton:true
                },
                function(isConfirm){
                    if(isConfirm){
                        window.location.href='stock_group.php';
                    }
                }); 
            </script>";
        }else{
    
            echo "<script>
            swal({
                title:'มีบางอย่างผิดพลาด! กรุณาตรวจสอบ',
                type:'error',
                showConfirmButton:true
                },
                function(isConfirm){
                    if(isConfirm){
                        window.location.href='stock_group.php';
                    }
                }); 
            </script>";
        } //insert
        
    } //numrow
}  //post
?>

<script type="text/javascript">
function loadData(hire_id,u_id) {
    var sdata = {
        hire_id : hire_id,
        u_id : u_id 
    };
$('#divDataview').load('show_hire_detail.php',sdata);
}


$(document).ready(function() {
    $('#tbGroup').DataTable( {
        "order": [[ 0, "desc" ]]
    } );
} );
</script>

