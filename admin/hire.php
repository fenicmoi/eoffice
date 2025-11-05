
<!--  ทะเบียนคุมสัญญาจ้าง -->
<?php
include "header.php"; 
$yid=chkYearMonth();
$u_id=$_SESSION['ses_u_id'];
?>
<script type="text/javascript" language="javascript" >
			$(document).ready(function() {
				var dataTable = $('#myTable').DataTable( {
          order: [[ 0, 'desc' ], [ 0, 'asc' ]],
					"processing": true,
					"serverSide": true,
          "resonsive": true,
        
          "language": {
                "sLengthMenu": "แสดง _MENU_ เร็คคอร์ด ต่อหน้า",
                "sZeroRecords": "ไม่พบข้อมูลที่ค้นหา",
                "sInfo": "แสดง _START_ ถึง _END_ ของ _TOTAL_ เร็คคอร์ด",
                "sInfoEmpty": "แสดง 0 ถึง 0 ของ 0 เร็คคอร์ด",
                "sInfoFiltered": "(จากเร็คคอร์ดทั้งหมด _MAX_ เร็คคอร์ด)",
                "sSearch": "ค้นหา: ",
                "oPaginate": {
                    "sFirst":    "หน้าแรก",
                    "sPrevious": "ก่อนหน้า",
                    "sNext":     "ถัดไป",
                    "sLast":     "หน้าสุดท้าย"
                }
            },
					"ajax":{
						url :"hire-serverside.php", // json datasource
						type: "post",  // method  , by default get
                        data:{
                            level_id: '<?php echo $level_id; ?>',
                            dep_id: '<?php echo $dep_id; ?>'
                        },
						error: function(){  // error handling
							$(".myTable-error").html("");
							$("#myTable").append('<tbody class="myTable-error"><tr><th colspan="3">ไม่มีข้อมูล</th></tr></tbody>');
							$("#myTable").css("display","none");
							
						}
					}
				} );
			} );
</script>

    <div class="row">
        <div class="col-md-2" >
             <?php
                 $menu=  checkMenu($level_id);
                 include $menu;
             ?>
        </div>  <!-- col-md-2 -->
        <div class="col-md-10">
            <div class="panel panel-primary">
                <div class="panel-heading"><i class="fas fa-shopping-cart fa-2x"></i>  <strong>ทะเบียนคุมสัญญาจ้าง </strong>
                		<a href="" class="btn btn-default  pull-right" data-toggle="modal" data-target="#modalAdd">
                     		<i class="fas fa-plus"></i> ออกเลขสัญญา
                    	</a>
						<!-- <button id="hideSearch" class="btn btn-default pull-right"><i class="fas fa-search"> ค้นหา</i></button> -->
						<a href="buy.php" class="btn btn-default pull-right"><i class="fas fa-home"></i> หน้าหลัก</a>
                </div>  
                <br>

                  <table id="myTable" cellpadding="0" cellspacing="0"  class="display" width="100%">
                        <thead class="bg-info">
                            <tr>
                                
                                <th class="dt-nowrap">เลขที่สัญญา</th>
                                <th class="dt-nowrap">วันที่บันทึก</th>
                                <th>เรื่อง</th>
                                <th class="dt-nowrap">จำนวนเงิน</th>
                                <th>หน่วยงาน</th>
                                <th>พิมพ์</th>
                                <th>แก้ไข</th>
                            </tr>
                        </thead>
                        <!-- <tfoot>
                                
                                <th>เลขที่สัญญา</th>
                                <th>วันที่บันทึก</th>
                                <th>เรื่อง</th>
                                <th>จำนวนเงิน</th>
                                <th>หน่วยงาน</th>
                        </tfoot> -->
                </table>
            </div> 
        </div> <!-- col-md-10 -->
    </div>    <!-- end row  -->

 <!--เพิ่มข้อมูล -->
 <div id="modalAdd" class="modal fade" role="dialog" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="exampleModalLabel"><i class="fa fa-list"></i> ออกเลขสัญญาจ้าง</h4>
                  </div>
                  <div class="modal-body">
                      <form method="post">
                          <label class="badge">วันที่ทำรายการ: <?php echo DateThai(); ?></label>
                          <?php 
                            $sql="SELECT *FROM depart WHERE dep_id=$dep_id";
                            $result=dbQuery($sql);
                            $row=dbFetchArray($result);
                        ?>
                          <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">หน่วยงานเจ้าของงบประมาณ</span>
                                <input type="text" class="form-control" id="dep_id" name="dep_id"  value="<?php print $row['dep_name'];?>" > 
                            </div>
                        </div>
                        <div class="form-group">
                          <div class="input-group"> 
                              <span class="input-group-addon">รายการจ้าง</span>
                              <input type="text" class="form-control" id="title" name="title"  required="">
                          </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group"> 
                                <span class="input-group-addon">วงเงินการจ้าง</span>
                                <input type="number" class="form-control" id="money" name="money" required="">  
                            </div>
                        </div>
                       
                        <div class="form-group">
                            <div class="input-group"> 
                                <span class="input-group-addon">ผู้รับจ้าง</span>
                                <input type="text" class="form-control" id="employee" name="employee"  required="" > 
                            </div>
                        </div>     
                        <div class="form-group form-inline">
                            <div class="input-group">
                             <span class="input-group-addon"><label for="datehire">วันทำสัญญา :</label></span>
                            <input class="form-control" type="date" name="datehire"  id="datehire" onKeyDown="return false" required > 
                            </div>
                        </div>
                        <div class="form-group form-inline">
                            <div class="input-group">
                             <span class="input-group-addon"><label for="datehire">วันส่งงาน :</label></span>
                            <input class="form-control" type="date" name="date_submit"  id="date_submit" onKeyDown="return false" required > 
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group"> 
                                <span class="input-group-addon">ผู้ลงนาม</span>
                                <input type="text" class="form-control" id="signer" name="signer"  placeholder="ผู้ลงนาม" value="ผู้ว่าราชการจังหวัด" required="" > 
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">หลักประกันสัญญา</i></span>
                                <input type="number" class="form-control" id="guarantee" name="guarantee"  value="0"  required="" ;> 
                            </div>
                        </div>
                            <center>
                                <button class="btn btn-success" type="submit" name="save">
                                    <i class="fa fa-save fa-2x"></i> บันทึก
                                </button>
                            </center>                                                         
                      </form>
                  </div>
                  <div class="modal-footer bg-primary">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                  </div>
                </div>
              </div>
            </div>
<!-- End Model -->  

<!--เพิ่มข้อมูล -->
 <div id="modalEdit" class="modal fade" role="dialog" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="exampleModalLabel"><i class="fa fa-list"></i> ออกเลขสัญญาจ้าง</h4>
                  </div>
                  <div class="modal-body">
                     <div id="divEditForm"></div>
                  </div>
                  <div class="modal-footer bg-primary">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                  </div>
                </div>
              </div>
            </div>
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

    $datein=date('Y-m-d');
    $title=$_POST['title'];
    $money=$_POST['money'];
    $employee=$_POST['employee'];
    $datehire=$_POST['datehire'];
    $signer=$_POST['signer'];
    $guarantee=$_POST['guarantee'];
    $date_submit=$_POST['date_submit'];
    
  
    //echo $yid[0];
    //echo "this is datein=".$datein;
    //ตัวเลขรันอัตโนมัติ
    $sql="SELECT hire_id,rec_no
          FROM hire
          WHERE yid=$yid[0]
          ORDER BY hire_id DESC
          LIMIT 1";
    //print $sql;
    //print $yid[0];
    $result=dbQuery($sql);
    $row = dbFetchAssoc($result);
    $rec_no=$row['rec_no'];

    if($rec_no==0){
       $rec_no=1;
    }else{
       $rec_no++; 
    } 
   

    $sql="INSERT INTO hire (rec_no,datein,title,money,employee,date_hire,signer,guarantee,date_submit,dep_id,sec_id,u_id,yid)
                VALUES($rec_no,'$datein','$title',$money,'$employee','$datehire','$signer',$guarantee,'$date_submit',$dep_id,$sec_id,$u_id,$yid[0])";
    
    
    $result=dbQuery($sql);
    if($result){
        dbQuery("COMMIT");
        echo "<script>
        swal({
            title:'เรียบร้อย',
            type:'success',
            showConfirmButton:true
            },
            function(isConfirm){
                if(isConfirm){
                    window.location.href='hire.php';
                }
            }); 
        </script>";
    }else{
        dbQuery("ROLLBACK");
        echo "<script>
        swal({
            title:'มีบางอย่างผิดพลาด! กรุณาตรวจสอบ',
            type:'error',
            showConfirmButton:true
            },
            function(isConfirm){
                if(isConfirm){
                    window.location.href='hire.php';
                }
            }); 
        </script>";
    }     
}
?>

<script type="text/javascript">
function loadData(hire_id,u_id) {
    var sdata = {
        hire_id : hire_id,
        u_id : u_id 
    };
$('#divDataview').load('show_hire_detail.php',sdata);
}

function loadEditForm(hire_id) {
    var sdata = {
        hire_id : hire_id
    };
 
    $('#divDataview').load('load_hire_edit_form.php', sdata, function() {
        $('.bs-example-modal-table').modal('show'); 
    });
}
</script>

