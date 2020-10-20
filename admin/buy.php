
<?php
include "header.php";
$yid=chkYearMonth();
$u_id=$_SESSION['ses_u_id'];
?>
<script>

	$(document).ready(function(){
		
		$("#txtMoney").hide();
		$("#bank").hide();
		//hide and show status
		$("#selConFirm").change( function(){
			
			var selConFirm = $("#selConFirm").val();
			if (selConFirm == 0) {
				$("#txtMoney").hide();
				$("#bank").hide();
			} else if(selConFirm == 3) {
				$("#txtMoney").show();
				$("#bank").show();
			} else {
				$("#txtMoney").show();
				$("#bank").hide();
			}
		
		});

/*
		$("#btnsave").click(function(){
			
			$.ajax({
				type: "POST",
				dataType: 'json',
				url: "saveBuy.php",
				data: $("#frmMain").serialize(),
				success: function(result){
					if(result.status==1) {
						swal("Good job!", "บันทึกข้อมูลเรียบร้อยแล้ว!", "success")

					}else{
						swal("Error!", "มีบางอย่างผิดพลาด!", "error")
					}
				}
			});
		});
*/
		
	});

	
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
                     		<i class="fas fa-plus"></i> ออกเลขสัญญา
                    	</a>
						<!-- <button id="hideSearch" class="btn btn-default pull-right"><i class="fas fa-search"> ค้นหา</i></button> -->
						<a href="buy.php" class="btn btn-default pull-right"><i class="fas fa-home"></i> หน้าหลัก</a>
                </div> 
                <br>
                <table class="table table-bordered table-hover" id="tbHire">
                <thead class="bg-info">
				<tr bgcolor="black">
					<td colspan="6">
						<form class="form-inline" method="post" name="frmSearch" id="frmSearch">
							<div class="form-group">
								<select class="form-control" id="typeSearch" name="typeSearch">
									<option value="1"><i class="fas fa-star"></i> เลขที่สัญญา</option>
									<option value="2" selected>เรื่องสัญญา</option>
								</select>
								<div class="input-group">
									<input class="form-control" id="search" name="search" type="text" size="80" placeholder="Keyword สั้นๆ">
									<div class="input-group-btn">
										<button class="btn btn-primary" type="submit" name="btnSearch" id="btnSearch">
										<i class="fas fa-search "></i>
										</button>
									</div>
								</div>
							</div>
						</form>
					</td>
				</tr>
                <tr>
                    <th>เลขสัญญา</th>
					<th>รายการซื้อ/ขาย</th>
                    <th>วันที่บันทึก</th>
                    <th>วงเงิน</th>
                    <th>หน่วยงาน</th>
					<th>พิมพ์</th>
                </tr>
                </thead>
                <tbody>
                     <?php
						$sql="SELECT h.*,d.dep_name,y.yname
                              FROM buy as h
                              INNER JOIN depart as d ON d.dep_id=h.dep_id
                              INNER JOIN year_money as y ON y.yid=h.yid
                              ";

						//ส่วนการค้นหา
						if ( isset( $_POST[ 'btnSearch' ] ) ) {      //ถ้ามีการกดปุ่มค้นหา
							@$typeSearch = $_POST[ 'typeSearch' ];   //ประเภทการค้นหา
							@$txt_search = $_POST[ 'search' ];       //กล่องรับข้อความ
	
							if ( @$typeSearch == 1 ) {               //ทะเบียนรับ
								$sql .= " WHERE h.rec_no LIKE '%$txt_search%'   ORDER BY h.buy_id  DESC";
	                        }elseif( @$typeSearch == 2 ) {           //เลขหนังสือ
								$sql .= " WHERE h.title LIKE '%$txt_search%'     ORDER BY h.buy_id DESC ";
							}

							$result = page_query( $dbConn, $sql, 10 );
							$numrow = dbNumRows( $result );

							if ( $numrow == 0 ) {
								echo "<script>
										swal({
											title:'ไม่พบข้อมูล!',
											type:'warning',
											text:'กรุณาตรวจสอบคำค้น...หรือเลือกเงื่อนไขการค้นหาใหม่อีกครั้งนะครับ',
											showConfirmButton:true
											},
											function(isConfirm){
												if(isConfirm){
													window.location.href='buy.php';
												}
											}); 
									</script>";
							}
						}else{ //กรณีโหลดเพจ หรือไม่มีการกดปุ่มใดๆ
							switch ( $level_id ) {
								case 1: //admin
								$sql .= " ORDER BY h.buy_id  DESC ";
								break;
								case 2: //สารบรรณจังหวัด    ดูได้ทั้งจังหวัด
								$sql .= " ORDER BY h.buy_id  DESC ";
								break;
								case 3: //สารบรรณหน่วยงาน  ดูได้ทั้งหน่วยงาน
								$sql .= " WHERE h.dep_id=$dep_id ORDER BY h.buy_id  DESC  ";
								break;
								case 4: //สารบรรณกลุ่มงาน  ดูได้ทั้งหน่วย  แต่แก้ไม่ได้
								$sql .= " WHERE  h.dep_id=$dep_id ORDER BY h.buy_id  DESC  ";
								break;
								case 5: //สารบรรณกลุ่มงาน  ดูได้เฉพาะของตนเอง
								$sql .= " WHERE  h.dep_id=$dep_id AND h.u_id=$u_id ORDER BY h.buy_id  DESC  ";
								break;						
	                     	}
							$result = page_query( $dbConn, $sql, 10 );	
						}

						$result = page_query( $dbConn, $sql, 10 );
						while($row=dbFetchArray($result)){?>
                            <tr>
                                <td><?php echo $row['rec_no'];?>/<?php echo $row['yname'];?></td>
								<?php $buy_id=$row['buy_id'];?>
                                <td>
									<a href="#" onClick="loadData('<?php print $buy_id;?>','<?php print $u_id;?>');" 
                                       data-toggle="modal" data-target=".bs-example-modal-table">
                                             <?php echo iconv_substr($row['title'],0,150,"UTF-8")."...";?> 
                                    </a>
								</td>
								<td><?php echo thaiDate($row['date_submit']);?></td>
                                <td><?php echo number_format($row['money_project']);?></td>
                                <td><?php echo $row['dep_name'];?></td>  
								<td><a href="report/rep-buy-item.php?buy_id=<?php print $buy_id?>" class="btn btn-warning" target="_blank"><i class="fas fa-print"></i></a></td>
                            </tr>
                        <?php }?>
                 </tbody>
                </table>
                <div class="panel-footer">
					<center>
					<a href="buy.php" class="btn btn-primary">
						<i class="fas fa-home"></i> หน้าหลัก
					</a>
					<?php 
						page_link_border("solid","1px","gray");
						page_link_bg_color("lightblue","pink");
						page_link_font("14px");
						page_link_color("blue","red");
						page_echo_pagenums(10,true);
					?>
					</center>
				</div>
            </div>

			<?php   
				$sql = "SELECT dep_name FROM depart WHERE dep_id = $dep_id ";
				$result = dbQuery($sql);
				$row = dbFetchArray($result);
			?>
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
		$date_num = date(Y-m-d);
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
</script>
