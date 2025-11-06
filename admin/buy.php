
<?php
include "header.php";

// เพิ่มโค้ดนี้เพื่อตรวจสอบการเข้าสู่ระบบ
if (!isset($_SESSION['ses_u_id']) || empty($_SESSION['ses_u_id'])) {
    // หากไม่มีเซสชันหรือค่าว่าง ให้เปลี่ยนเส้นทางไปยังหน้า Login หรือแสดงข้อความปฏิเสธ
    header("Location: login.php"); // เปลี่ยน 'login.php' เป็นชื่อไฟล์หน้าล็อกอินของคุณ
    exit();
}


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
          "columnDefs": [
                {
                    "targets": [ 0 ], // ตำแหน่งคอลัมน์ที่ 0 (hire_id)
                    "visible": false, // ซ่อนคอลัมน์
                    "searchable": false // ไม่ให้ค้นหาในคอลัมน์นี้ด้วย
                }
            ],
        
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
						url :"buy-serverside.php", // json datasource
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
        </div>
        <div class="col-md-10">
            <div class="panel panel-primary" >
                <div class="panel-heading"><i class="fas fa-shopping-cart fa-2x"></i>  <strong>ทะเบียนคุมสัญญาซื้อ/ขาย </strong>
                		<a href="" class="btn btn-default  pull-right" data-toggle="modal" data-target="#modalAdd">
                     		<i class="fas fa-plus"></i> ออกเลขสัญญาซื้อ/ขาย
                    	</a>
						<!-- <button id="hideSearch" class="btn btn-default pull-right"><i class="fas fa-search"> ค้นหา</i></button> -->
						<a href="buy.php" class="btn btn-default pull-right"><i class="fas fa-home"></i> หน้าหลัก</a>
                </div> 
               
                <table id="myTable" cellpadding="0" cellspacing="0"  class="display" width="100%">
                        <thead class="bg-info">
                            <tr>
                                <th>ที่</th>
                                <th class="dt-nowrap">เลขที่สัญญา</th>
                                <th>รายการซื้อขาย</th>
								<th class="dt-nowrap">วันที่บันทึก</th>
                                <th class="dt-nowrap">จำนวนเงิน</th>
                                <th>หน่วยงาน</th>
                                <th>พิมพ์</th>
                                <th>แก้ไข</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                </table>
			</div>
			</div> <!-- col-md-10 -->



            <!-- Model -->
            <!-- -เพิ่มข้อมูล -->
            <div id="modalAdd" class="modal fade " role="dialog">
              <div class="modal-dialog modal-lg">
                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-list"></i> ออกเลขสัญญาซื้อ/ขาย</h4>
                  </div>
                  <div class="modal-body  bg-warning">
                      <form method="post" id="frmMain" name="frmMain" acton="">
                          <label>วันที่ทำรายการ: <?php echo DateThai();?></label>
						  <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">เรื่อง</span>
                                <input type="text" class="form-control" id="title" name="title" placeholder="ระบุเรื่อง" required="" > 
                            </div>
                        </div>  

						<div class="form-group">
							<div class="input-group">
								<span id="spnMoney" name="spnMoney"  class="input-group-addon">งบประมาณ</span>
								<input type="number" class="form-control" id="money_project" name="money_project"   required="" value="0">
							</div>
						</div>
					
						<div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">เจ้าของงบประมาณ</span>
                                <input type="text" class="form-control" id="dep_name" name="dep_name"  value="<?php print $row['dep_name'];?>" > 
								<span class="input-group-addon">ระหว่าง จังหวัดพัทลุง</span>
                            </div>
                        </div>  
						 <div class="form-group">
                            <div class="input-group">  
                                <span class="input-group-addon">โดย</span>
                                <input type="text" class="form-control" id="governer" name="governer"  value="ผู้ว่าราชการจังหวัดพัทลุง"> 
								<span class="input-group-addon">ผู้ซื้อ</span>
                            </div>
                        </div>  
						 <div class="form-group">
                            <div class="input-group">  
                                <span class="input-group-addon">กับ</span>
                                <input type="text" class="form-control" id="company" name="company"  placeholder="ชื่อร้าน/บริษัท" required="" > 
								 <span class="input-group-addon">ผู้ขาย</span>
                            </div>
                        </div>  
						<div class="form-group">
                            <div class="input-group">  
                                <span class="input-group-addon">ชื่อ ผู้จัดการ/หุ้นส่วนผู้จัดการ</span>
                                <input type="text" class="form-control" id="manager" name="manager"  placeholder="" required="" > 
                            </div>
                        </div>  
						<div class="form-group">
                            <div class="input-group">  
                                <span class="input-group-addon">ที่อยู่</span>
                                <input type="text" class="form-control" id="add1" name="add1"   required="" > 
                            </div>
                        </div> 
						<div class="form-group">
                            <div class="input-group">  
                                <span class="input-group-addon">ชื่อผู้ลงนามในสัญญา</span>
                                <input type="text" class="form-control" id="signer" name="signer"   required="" > 
                            </div>
                        </div>  
						<div class="form-group">
                            <div class="input-group">  
                                <span class="input-group-addon">ที่อยู่</span>
                                <input type="text" class="form-control" id="add2" name="add2"   required="" > 
                            </div>
                        </div> 
						<div class="form-group">
                            <div class="input-group col-xs-6">  
                                <span class="input-group-addon">โทรศัพท์/ผู้รับมอบอำนาจ</span>
                                <input type="text" class="form-control" id="telphone" name="telphone"   required="" > 
                            </div>
                        </div> 

						<hr style="height: 2px; background-color: red"/>

                        <div class="form-group">
                          <div class="input-group">
                              <span class="input-group-addon">ข้อตกลงซื่้อขาย(โดยสังเขป</span>
                              <input type="text" class="form-control" id="product" name="product"   required="">
                          </div>
                        </div>
						<div class="form-group">
                          <div class="input-group">
                              <span class="input-group-addon">สถานที่ส่งมอบ ณ</span>
                              <input type="text" class="form-control" id="location" name="location"   required="">
                          </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group col-xs-6">
                                <span class="input-group-addon"><label for="date_stop">วันที่ครบกำหนด(งวดสุดท้าย) :</label></span>
                                <input class="form-control" type="date" name="date_stop"  id="date_stop" onKeyDown="return false" required >
                                
                            </div>
                        </div>

						<hr style="height: 2px; background-color: red"/>

						<div class="form-group">
                          <div class="input-group">
                              <span class="input-group-addon"><label for="selConFirm">ประเภทหลักประกันสัญญา</label></span>
							  <select class="form-control" id="selConFirm" name="selConFirm">
									<option value="1">เงินสด</option>
									<option value="2">เช็คธนาคาร</option>
									<option value="3">หนังสือค้ำประกันธนาคาร</option>
									<option value="4">หนังสือค้ำประกันของบริษัทเงินทุน</option>
									<option value="5">พันธบัตร</option>
									<option value="0" selected>ไม่มี</option>
								</select>
								<span id="spnMoney" name="spnMoney"  class="input-group-addon">จำนวนเงิน</span>
								<input type="text" class="form-control" id="txtMoney" name="txtMoney"   required="" value="0">
                          </div>
                        </div>
						<div id="bank">
						<label>กรณีเป็นหนังสือค้ำประกันของธนาคาร  ให้ระบุรายละเอียดเพิ่มเติม ดังนี้</label>
                        <div class="form-group">
                            <div class="input-group"> 
                                <span class="input-group-addon"><label>ธนาคารผู้ค้ำประกัน</label></span>
                                <input type="text" class="form-control" id="bank" name="bank"> 
								<span class="input-group-addon"><label>สาขา</label></span>
								<input type="text" class="form-control" id="brance" name="brance"> 
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group"> 
                                <span class="input-group-addon">เลขที่หนังสือ</span>
                                <input type="text" class="form-control" id="doc_num" name="doc_num"> 
								<span class="input-group-addon"><label for="">ลงวันที่ :</label></span>
                            <input class="form-control" type="date" name="date_num"  id="date_num" onKeyDown="return false"  >
                            </div>
                        </div>
						</div>
                        <?php 
							$sql="SELECT *FROM depart WHERE dep_id=$dep_id";
							$result=dbQuery($sql);
							$row=dbFetchArray($result);
						?>
                        
                            <center>
								<input type="hidden" id="dep_id" name="dep_id" value="<?php echo $dep_id;?>">
								<input type="hidden" id="sec_id " name="sec_id" value="<?php echo $sec_id;?>">
								<input type="hidden" id="u_id" name="u_id" value="<?php echo $u_id;?>">

                                <button class="btn btn-success btn-lg" type="submit" name="btnsave" id="btnsave">
                                    <i class="fa fa-save fa-2x"></i> SAVE
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
        </div>
    </div>  


<?php

// ส่วนการจัดการข้อมูล
if(isset($_POST['btnsave'])){
	$title = $_POST["title"];
	$money_project = $_POST["money_project"];
	$dep_id = $_POST["dep_id"];
	$governer = $_POST["governer"];
	$company = $_POST["company"];
	$manager = $_POST["manager"];
	$add1 = $_POST["add1"];
	$signer = $_POST["signer"];
	$add2 = $_POST["add2"];
	$telphone = $_POST["telphone"];
	$product = $_POST["product"];
	$location = $_POST["location"];
	$date_stop = $_POST["date_stop"];
	$confirm_id = $_POST["selConFirm"];
	$money = $_POST["txtMoney"];
	$bank = $_POST["bank"];
	$brance = $_POST["brance"];
	$doc_num = $_POST["doc_num"];
	$date_num = $_POST["date_num"];
	$date_submit = date("Y-m-d");
	$sec_id = $_POST["sec_id"];
	$u_id = $_POST["u_id"];

	if($date_num = '' ){
		$date_num = date('Y-m-d');
	}
	
	//running number
	$sql="SELECT buy_id, rec_no
          FROM buy
          WHERE yid=$yid[0]
          ORDER BY buy_id DESC
		  LIMIT 1";
		  

	
	$result=dbQuery($sql);
	$row=dbFetchAssoc($result);
	$rec_no=$row['rec_no'];
	if($rec_no==0){
		$rec_no=1;
	}else{
		$rec_no++;
	}
	
	dbQuery('BEGIN');
	
	$sql = "INSERT INTO buy(rec_no, dep_id, governer,title, money_project, company, manager, add1, signer, add2, telphone, product, location, 
                        date_stop, confirm_id, money, bank, brance, doc_num, date_num, date_submit, sec_id, u_id, yid)
            VALUE($rec_no, $dep_id, '$governer', '$title',$money_project, '$company', '$manager', '$add1', '$signer', '$add2', '$telphone', '$product', '$location', '$date_stop', $confirm_id, 
						$money, '$bank', '$brance', '$doc_num', '$date_num', '$date_submit', $sec_id, $u_id, $yid[0])";
	//print $sql;
	
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
                    window.location.href='buy.php';
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
                    window.location.href='buy.php';
                }
            }); 
        </script>";
	}
	
	
}

?>

<script type="text/javascript">
function loadData(buy_id,u_id) {
    var sdata = {
        buy_id : buy_id,
        u_id : u_id 
    };
$('#divDataview').load('show_buy_detail.php',sdata);
}


// *** เพิ่มฟังก์ชันสำหรับการแก้ไขข้อมูล ***
function loadEditForm(buy_id) {
    var sdata = {
        buy_id : buy_id
    };
 
    // โหลดฟอร์มแก้ไขเข้ามาใน modal 'divDataview' และแสดง modal
    $('#divDataview').load('load_buy_edit_form.php', sdata, function() {
        $('.bs-example-modal-table').modal('show'); 
    });
}
// *** สิ้นสุดการเพิ่มฟังก์ชัน ***
</script>

